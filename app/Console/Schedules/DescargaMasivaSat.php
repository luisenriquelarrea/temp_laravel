<?php
    namespace App\Console\Schedules;

    use PhpCfdi\SatWsDescargaMasiva\RequestBuilder\FielRequestBuilder\Fiel;
    use PhpCfdi\SatWsDescargaMasiva\RequestBuilder\FielRequestBuilder\FielRequestBuilder;
    use PhpCfdi\SatWsDescargaMasiva\Service;
    use PhpCfdi\SatWsDescargaMasiva\Services\Query\QueryParameters;
    use PhpCfdi\SatWsDescargaMasiva\Shared\DateTimePeriod;
    use PhpCfdi\SatWsDescargaMasiva\Shared\ComplementoCfdi;
    use PhpCfdi\SatWsDescargaMasiva\Shared\DocumentStatus;
    use PhpCfdi\SatWsDescargaMasiva\Shared\DocumentType;
    use PhpCfdi\SatWsDescargaMasiva\Shared\DownloadType;
    use PhpCfdi\SatWsDescargaMasiva\Shared\RequestType;
    use PhpCfdi\SatWsDescargaMasiva\WebClient\GuzzleWebClient;

    /**
     * Parámetros de la consulta
     * Periodo (DateTimePeriod)
     * Fecha y hora de inicio y fin de la consulta. Si no se especifica crea un periodo del segundo exacto de la creación del objeto.


     * Tipo de descarga (DownloadType)
     * Establece si la solicitud es de documentos emitidos DownloadType::issued() o recibidos DownloadType::received(). 
     * Si no se especifica utiliza el valor de emitidos.


     * Tipo de solicitud (RequestType)
     * Establece si la solicitud es de Metadatos RequestType::metadata() o archivos XML RequestType::xml(). 
     * Si no se especifica utiliza el valor de Metadatos.

     * Tipo de comprobante (DocumentType)
     * Filtra la solicitud por tipo de comprobante. Si no se especifica utiliza no utiliza el filtro.
     * Cualquiera: DocumentType::undefined() (predeterminado).
     * Ingreso: DocumentType::ingreso().
     * Egreso: DocumentType::egreso().
     * Traslado: DocumentType::traslado().
     * Nómina: DocumentType::nomina().
     * Pago: DocumentType::pago().
    
     * Tipo de complemento (ComplementoCfdi o ComplementoRetenciones)
     * Filtra la solicitud por la existencia de un tipo de complemento dentro del comprobante. 
     * Si no se especifica utiliza ComplementoUndefined::undefined() que excluye el filtro.
     * Hay dos tipos de objetos que satisfacen este parámetro, depende del tipo de comprobante que se está solicitando. 
     * Si se trata de comprobantes de CFDI Regulares entonces se usa la clase ComplementoCfdi. 
     * Si se trata de CFDI de retenciones e información de pagos entonces se usa la clase ComplementoRetenciones.
     * Estos objetos se pueden crear nombrados (ComplementoCfdi::leyendasFiscales10()), por constructor (new ComplementoCfdi('leyendasfisc')), 
     * o bien, por el método estático create (ComplementoCfdi::create('leyendasfisc')).
     * Además, se puede acceder al nombre del complemento utilizando el método label(), 
     * por ejemplo, echo ComplementoCfdi::leyendasFiscales10()->label(); // Leyendas Fiscales 1.0.
     * A su vez, este objeto ofrece un método estático getLabels(): array para obtener un arreglo con los datos, 
     * en donde la llave es el identificador del complemento y el valor es el nombre del complemento.

     * Estado del comprobante (DocumentStatus)
     * Filtra la solicitud por el estado de comprobante: Vigente (DocumentStatus::active()) y Cancelado (DocumentStatus::cancelled()). 
     * Si no se especifica utiliza DocumentStatus::undefined() que excluye el filtro.

     * UUID (Uuid)
     * Filtra la solicitud por UUID. Para crear el objeto del filtro hay que usar Uuid::create('96623061-61fe-49de-b298-c7156476aa8b'). 
     * Si no se especifica utiliza Uuid::empty() que excluye el filtro.

     * Filtrado a cuenta de terceros (RfcOnBehalf)
     * Filtra la solicitud por el RFC utilizado a cuenta de terceros. 
     * Para crear el objeto del filtro hay que usar RfcOnBehalf::create('XXX01010199A'). 
     * Si no se especifica utiliza RfcOnBehalf::empty() que excluye el filtro.

     * Filtrado por RFC contraparte (RfcMatch/RfcMatches)
     * Filtra la solicitud por el RFC en contraparte, es decir, que si la consulta es de emitidos entonces filtrará donde el RFC especificado sea el receptor, si la consulta es de recibidos entonces filtrará donde el RFC especificado sea el emisor.
     * Para crear el objeto del filtro hay que usar RfcMatch::create('XXX01010199A'). 
     * Si no se especifica utiliza una lista vacía RfcMatches::create() que excluye el filtro.

     * Acerca de RfcMatches
     * Este objeto mantiene una lista de RfcMatches, pero con características especiales:

     * Los objetos RfcMatch vacíos o repetidos son ignorados, solo se mantienen valores no vacíos únicos.
     * El método RfcMatch::getFirst() devuelve siempre el primer elemento, si no existe entonces devuelve uno vacío.
     * La clase RfcMatch es iterable, se puede hacer foreach() sobre los elementos.
     * La clase RfcMatch es contable, se puede hacer count() sobre los elementos.

     * Tipo de servicio (ServiceType)
     * Esta es una propiedad que bien se podría considerar interna y no necesitas especificarla en la consulta. 
     * Por defecto está no definida y con el valor null. 
     * Se puede conocer si la propiedad ha sido definida con la propiedad hasServiceType(): bool y cambiar con withServiceType(ServiceType): self.

     * No se recomienda definir esta propiedad y dejar que el servicio establezca el valor correcto según a donde esté apuntando el servicio.

     * Cuando se ejecuta una consulta, el servicio (Service) automáticamente define esta propiedad si es que no está definida estableciéndole el mismo valor que está definido en el objeto ServiceEndpoints. Si esta propiedad ya estaba definida, y su valor no es el mismo que el definido en el objeto ServiceEndpoints entonces se genera una LogicException.

     */

    class DescargaMasivaSat
    {
        private $cert;
        private $key;
        private $passw;

        public function __construct() {
            $this->cert = storage_path('app/ssl/certificado.cer');
            $this->key = storage_path('app/ssl/claveprivada.key');
            $this->passw = config('wssat.passw');
        }
        
        public function __invoke()
        {
            echo "...::: Service DescargaMasivaSat is running....", PHP_EOL;
            // Creación de la FIEL, puede leer archivos DER (como los envía el SAT) o PEM (convertidos con openssl)
            $fiel = Fiel::create(
                file_get_contents($this->cert),
                file_get_contents($this->key),
                $this->passw
            );

            // verificar que la FIEL sea válida (no sea CSD y sea vigente acorde a la fecha del sistema)
            if (!$fiel->isValid()){
                echo "Fallo en la validación de la FIEL.", PHP_EOL;
                return;
            }

            // creación del web client basado en Guzzle que implementa WebClientInterface
            // para usarlo necesitas instalar guzzlehttp/guzzle, pues no es una dependencia directa
            $webClient = new GuzzleWebClient();

            // creación del objeto encargado de crear las solicitudes firmadas usando una FIEL
            $requestBuilder = new FielRequestBuilder($fiel);

            // Creación del servicio
            $service = new Service($requestBuilder, $webClient);

            // Crear la consulta
            $request = QueryParameters::create()
                ->withPeriod(DateTimePeriod::createFromValues('2025-08-26 00:00:00', '2025-08-26 23:59:59'))
                ->withDownloadType(DownloadType::received())
                ->withRequestType(RequestType::xml())
                ->withDocumentType(DocumentType::ingreso())
                ->withComplement(ComplementoCfdi::leyendasFiscales10())
                ->withDocumentStatus(DocumentStatus::active());

            // presentar la consulta
            $query = $service->query($request);

            // verificar que el proceso de consulta fue correcto
            if (! $query->getStatus()->isAccepted()) {
                echo "Fallo al presentar la consulta: {$query->getStatus()->getMessage()}";
                return;
            }

            // el identificador de la consulta está en $query->getRequestId()
            $requestId = $query->getRequestId();
            echo "Se generó la solicitud {$requestId}", PHP_EOL;

            /**
             * @var Service $service Objeto de ayuda de consumo de servicio, previamente fabricado
             * @var string $requestId Identificador generado al presentar la consulta, previamente fabricado
             */

            // consultar el servicio de verificación
            $verify = $service->verify($requestId);

            // revisar que el proceso de verificación fue correcto
            if (! $verify->getStatus()->isAccepted()) {
                echo "Fallo al verificar la consulta {$requestId}: {$verify->getStatus()->getMessage()}";
                return;
            }

            // revisar que la consulta no haya sido rechazada
            if (! $verify->getCodeRequest()->isAccepted()) {
                echo "La solicitud {$requestId} fue rechazada: {$verify->getCodeRequest()->getMessage()}", PHP_EOL;
                return;
            }

            // revisar el progreso de la generación de los paquetes
            $statusRequest = $verify->getStatusRequest();
            if ($statusRequest->isExpired() || $statusRequest->isFailure() || $statusRequest->isRejected()) {
                echo "La solicitud {$requestId} no se puede completar", PHP_EOL;
                return;
            }
            if ($statusRequest->isInProgress() || $statusRequest->isAccepted()) {
                echo "La solicitud {$requestId} se está procesando", PHP_EOL;
                return;
            }
            if ($statusRequest->isFinished())
                echo "La solicitud {$requestId} está lista", PHP_EOL;

            /**
             * @var Service $service Objeto de ayuda de consumo de servicio, previamente fabricado
             * @var string[] $packagesIds Listado de identificadores de paquetes generado en la verificación, previamente fabricado
             */
            echo "Se encontraron {$verify->countPackages()} paquetes", PHP_EOL;
            $packagesIds = $verify->getPackagesIds();
            foreach ($packagesIds as $packageId)
                echo " > {$packageId}", PHP_EOL;

            // consultar el servicio de verificación
            foreach($packagesIds as $packageId) {
                $download = $service->download($packageId);
                if (! $download->getStatus()->isAccepted()) {
                    echo "El paquete {$packageId} no se ha podido descargar: {$download->getStatus()->getMessage()}", PHP_EOL;
                    continue;
                }
                $zipfile = "$packageId.zip";
                file_put_contents($zipfile, $download->getPackageContent());
                echo "El paquete {$packageId} se ha almacenado", PHP_EOL;
            }
        }
    }

    $obj = new DescargaMasivaSat;
    print_r(is_callable($obj()));