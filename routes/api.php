<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SeccionMenuController;
use App\Http\Controllers\SeccionMenuInputController;
use App\Http\Controllers\PaisController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\GrupoController;
use App\Http\Controllers\AccionController;
use App\Http\Controllers\AccionGrupoController;
use App\Http\Controllers\AccionBasicaController;
use App\Http\Controllers\EjercicioController;
use App\Http\Controllers\SueldosSalariosController;
use App\Http\Controllers\SalarioMinimoController;
use App\Http\Controllers\IsrSemanalController;
use App\Http\Controllers\IsrQuincenalController;
use App\Http\Controllers\IsrMensualController;
use App\Http\Controllers\SubsidioEmpleoSemanalController;
use App\Http\Controllers\SubsidioEmpleoQuincenalController;
use App\Http\Controllers\SubsidioEmpleoMensualController;
use App\Http\Controllers\UmaController;
use App\Http\Controllers\DepartamentoController;
use App\Http\Controllers\PeriodicidadPagoController;
use App\Http\Controllers\PuestoController;
use App\Http\Controllers\PlazaController;
use App\Http\Controllers\EstadoController;
use App\Http\Controllers\MunicipioController;
use App\Http\Controllers\CodigoPostalController;
use App\Http\Controllers\RegimenFiscalController;
use App\Http\Controllers\EmpleadoController;
use App\Http\Controllers\EmpresaController;
use App\Http\Controllers\EmpresaPlazaController;
use App\Http\Controllers\EmpresaCuentaBancariaController;
use App\Http\Controllers\RegistroPatronalController;
use App\Http\Controllers\EmpleadoEmpresaController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AltasBajasImssController;
use App\Http\Controllers\BancoController;
use App\Http\Controllers\TipoContratoController;
use App\Http\Controllers\TipoDeduccionController;
use App\Http\Controllers\TipoJornadaController;
use App\Http\Controllers\TipoNominaController;
use App\Http\Controllers\TipoOtroPagoController;
use App\Http\Controllers\TipoPercepcionController;
use App\Http\Controllers\TipoRegimenController;
use App\Http\Controllers\RiesgoPuestoController;
use App\Http\Controllers\TipoReciboController;
use App\Http\Controllers\EmpleadoCuentaBancariaController;
use App\Http\Controllers\MesController;
use App\Http\Controllers\PeriodoPagoController;
use App\Http\Controllers\PercepcionController;
use App\Http\Controllers\DeduccionController;
use App\Http\Controllers\BonoController;
use App\Http\Controllers\DescuentoController;
use App\Http\Controllers\PrenominaController;
use App\Http\Controllers\PrenominaDetalleController;
use App\Http\Controllers\MonedaController;
use App\Http\Controllers\TipoCambioController;
use App\Http\Controllers\NominaController;
use App\Http\Controllers\ReciboController;
use App\Http\Controllers\ReciboPercepcionController;
use App\Http\Controllers\ReciboDeduccionController;
use App\Http\Controllers\ReciboTipoOtroPagoController;
use App\Http\Controllers\PagoBonoController;
use App\Http\Controllers\PagoDescuentoController;
use App\Http\Controllers\CalculoNominaController;
use App\Http\Controllers\TipoIncapacidadController;
use App\Http\Controllers\IncapacidadController;
use App\Http\Controllers\TipoProductoController;
use App\Http\Controllers\DivisionProductoController;
use App\Http\Controllers\GrupoProductoController;
use App\Http\Controllers\ClaseProductoController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\UnidadController;
use App\Http\Controllers\ConceptoController;
use App\Http\Controllers\FormaPagoController;
use App\Http\Controllers\TipoComprobanteController;
use App\Http\Controllers\ExportacionController;
use App\Http\Controllers\MetodoPagoController;
use App\Http\Controllers\TipoRelacionController;
use App\Http\Controllers\UsoCfdiController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\FacturaController;
use App\Http\Controllers\FacturaConceptoController;
use App\Http\Controllers\MotivoCancelacionController;
use App\Http\Controllers\FacturaCanceladaController;
use App\Http\Controllers\FacturaRelacionadaController;
use App\Http\Controllers\SerieCfdiController;
use App\Http\Controllers\ComplementoPagoController;
use App\Http\Controllers\ComplementoPagoDocumentoController;
use App\Http\Controllers\ComplementoPagoCanceladoController;
use App\Http\Controllers\NotaCreditoController;
use App\Http\Controllers\NotaCreditoDocumentoController;
use App\Http\Controllers\NotaCreditoCanceladaController;
use App\Http\Controllers\FabricaController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/

Route::get('/accion', [AccionController::class, 'index']);
Route::get('/accion/{id}', [AccionController::class, 'show']);
Route::prefix('/accion')->group(function(){
    Route::post('/store', [AccionController::class, 'store']);
    Route::put('/{id}', [AccionController::class, 'update']);
    Route::delete('/{id}', [AccionController::class, 'destroy']);
});

Route::get('/accion_basica', [AccionBasicaController::class, 'index']);
Route::get('/accion_basica/{id}', [AccionBasicaController::class, 'show']);
Route::prefix('/accion_basica')->group(function(){
    Route::post('/store', [AccionBasicaController::class, 'store']);
    Route::put('/{id}', [AccionBasicaController::class, 'update']);
    Route::delete('/{id}', [AccionBasicaController::class, 'destroy']);
    Route::post('/defaults_navbar', [AccionBasicaController::class, 'get_accion_navbar']);
});

Route::get('/accion_grupo', [AccionGrupoController::class, 'index']);
Route::get('/accion_grupo/{id}', [AccionGrupoController::class, 'show']);
Route::prefix('/accion_grupo')->group(function(){
    Route::post('/store', [AccionGrupoController::class, 'store']);
    Route::put('/{id}', [AccionGrupoController::class, 'update']);
    Route::delete('/{id}', [AccionGrupoController::class, 'destroy']);
    Route::post('/allowed_menus', [AccionGrupoController::class, 'get_allowed_menus']);
    Route::post('/allowed_table_actions', [AccionGrupoController::class, 'get_allowed_table_actions']);
    Route::post('/allowed_navbar', [AccionGrupoController::class, 'get_allowed_navbar']);
    Route::post('/has_xls_button', [AccionGrupoController::class, 'get_xls_button']);
});

Route::get('/altas_bajas_imss', [AltasBajasImssController::class, 'index']);
Route::get('/altas_bajas_imss/{id}', [AltasBajasImssController::class, 'show']);
Route::prefix('/altas_bajas_imss')->group(function(){
    Route::post('/store', [AltasBajasImssController::class, 'store']);
    Route::put('/{id}', [AltasBajasImssController::class, 'update']);
    Route::delete('/{id}', [AltasBajasImssController::class, 'destroy']);
});

Route::get('/banco', [BancoController::class, 'index']);
Route::get('/banco/{id}', [BancoController::class, 'show']);
Route::prefix('/banco')->group(function(){
    Route::post('/store', [BancoController::class, 'store']);
    Route::put('/{id}', [BancoController::class, 'update']);
    Route::delete('/{id}', [BancoController::class, 'destroy']);
});

Route::get('/bono', [BonoController::class, 'index']);
Route::get('/bono/{id}', [BonoController::class, 'show']);
Route::prefix('/bono')->group(function(){
    Route::post('/store', [BonoController::class, 'store']);
    Route::put('/{id}', [BonoController::class, 'update']);
    Route::delete('/{id}', [BonoController::class, 'destroy']);
});

Route::get('/calculo_nomina', [CalculoNominaController::class, 'index']);
Route::get('/calculo_nomina/{id}', [CalculoNominaController::class, 'show']);
Route::prefix('/calculo_nomina')->group(function(){
    Route::post('/store', [CalculoNominaController::class, 'store']);
    Route::put('/{id}', [CalculoNominaController::class, 'update']);
    Route::delete('/{id}', [CalculoNominaController::class, 'destroy']);
});

Route::get('/clase_producto', [ClaseProductoController::class, 'index']);
Route::get('/clase_producto/{id}', [ClaseProductoController::class, 'show']);
Route::prefix('/clase_producto')->group(function(){
    Route::post('/store', [ClaseProductoController::class, 'store']);
    Route::put('/{id}', [ClaseProductoController::class, 'update']);
    Route::delete('/{id}', [ClaseProductoController::class, 'destroy']);
});

Route::get('/cliente', [ClienteController::class, 'index']);
Route::get('/cliente/{id}', [ClienteController::class, 'show']);
Route::prefix('/cliente')->group(function(){
    Route::post('/store', [ClienteController::class, 'store']);
    Route::put('/{id}', [ClienteController::class, 'update']);
    Route::delete('/{id}', [ClienteController::class, 'destroy']);
});

Route::get('/codigo_postal', [CodigoPostalController::class, 'index']);
Route::get('/codigo_postal/{id}', [CodigoPostalController::class, 'show']);
Route::prefix('/codigo_postal')->group(function(){
    Route::post('/store', [CodigoPostalController::class, 'store']);
    Route::put('/{id}', [CodigoPostalController::class, 'update']);
    Route::delete('/{id}', [CodigoPostalController::class, 'destroy']);
});

Route::get('/complemento_pago', [ComplementoPagoController::class, 'index']);
Route::get('/complemento_pago/{id}', [ComplementoPagoController::class, 'show']);
Route::prefix('/complemento_pago')->group(function(){
    Route::post('/store', [ComplementoPagoController::class, 'store']);
    Route::put('/{id}', [ComplementoPagoController::class, 'update']);
    Route::delete('/{id}', [ComplementoPagoController::class, 'destroy']);
});

Route::get('/complemento_pago_cancelado', [ComplementoPagoCanceladoController::class, 'index']);
Route::get('/complemento_pago_cancelado/{id}', [ComplementoPagoCanceladoController::class, 'show']);
Route::prefix('/complemento_pago_cancelado')->group(function(){
    Route::post('/store', [ComplementoPagoCanceladoController::class, 'store']);
    Route::put('/{id}', [ComplementoPagoCanceladoController::class, 'update']);
    Route::delete('/{id}', [ComplementoPagoCanceladoController::class, 'destroy']);
});

Route::get('/complemento_pago_documento', [ComplementoPagoDocumentoController::class, 'index']);
Route::get('/complemento_pago_documento/{id}', [ComplementoPagoDocumentoController::class, 'show']);
Route::prefix('/complemento_pago_documento')->group(function(){
    Route::post('/store', [ComplementoPagoDocumentoController::class, 'store']);
    Route::put('/{id}', [ComplementoPagoDocumentoController::class, 'update']);
    Route::delete('/{id}', [ComplementoPagoDocumentoController::class, 'destroy']);
});

Route::get('/concepto', [ConceptoController::class, 'index']);
Route::get('/concepto/{id}', [ConceptoController::class, 'show']);
Route::prefix('/concepto')->group(function(){
    Route::post('/store', [ConceptoController::class, 'store']);
    Route::put('/{id}', [ConceptoController::class, 'update']);
    Route::delete('/{id}', [ConceptoController::class, 'destroy']);
});

Route::get('/deduccion', [DeduccionController::class, 'index']);
Route::get('/deduccion/{id}', [DeduccionController::class, 'show']);
Route::prefix('/deduccion')->group(function(){
    Route::post('/store', [DeduccionController::class, 'store']);
    Route::put('/{id}', [DeduccionController::class, 'update']);
    Route::delete('/{id}', [DeduccionController::class, 'destroy']);
});

Route::get('/departamento', [DepartamentoController::class, 'index']);
Route::get('/departamento/{id}', [DepartamentoController::class, 'show']);
Route::prefix('/departamento')->group(function(){
    Route::post('/store', [DepartamentoController::class, 'store']);
    Route::put('/{id}', [DepartamentoController::class, 'update']);
    Route::delete('/{id}', [DepartamentoController::class, 'destroy']);
});

Route::get('/descuento', [DescuentoController::class, 'index']);
Route::get('/descuento/{id}', [DescuentoController::class, 'show']);
Route::prefix('/descuento')->group(function(){
    Route::post('/store', [DescuentoController::class, 'store']);
    Route::put('/{id}', [DescuentoController::class, 'update']);
    Route::delete('/{id}', [DescuentoController::class, 'destroy']);
});

Route::get('/division_producto', [DivisionProductoController::class, 'index']);
Route::get('/division_producto/{id}', [DivisionProductoController::class, 'show']);
Route::prefix('/division_producto')->group(function(){
    Route::post('/store', [DivisionProductoController::class, 'store']);
    Route::put('/{id}', [DivisionProductoController::class, 'update']);
    Route::delete('/{id}', [DivisionProductoController::class, 'destroy']);
});

Route::get('/ejercicio', [EjercicioController::class, 'index']);
Route::get('/ejercicio/{id}', [EjercicioController::class, 'show']);
Route::prefix('/ejercicio')->group(function(){
    Route::post('/store', [EjercicioController::class, 'store']);
    Route::put('/{id}', [EjercicioController::class, 'update']);
    Route::delete('/{id}', [EjercicioController::class, 'destroy']);
});

Route::get('/empleado', [EmpleadoController::class, 'index']);
Route::get('/empleado/{id}', [EmpleadoController::class, 'show']);
Route::prefix('/empleado')->group(function(){
    Route::post('/store', [EmpleadoController::class, 'store']);
    Route::post('/data_filtered', [EmpleadoController::class, 'data_filtered']);
    Route::put('/{id}', [EmpleadoController::class, 'update']);
    Route::delete('/{id}', [EmpleadoController::class, 'destroy']);
});

Route::get('/empleado_cuenta_bancaria', [EmpleadoCuentaBancariaController::class, 'index']);
Route::get('/empleado_cuenta_bancaria/{id}', [EmpleadoCuentaBancariaController::class, 'show']);
Route::prefix('/empleado_cuenta_bancaria')->group(function(){
    Route::post('/store', [EmpleadoCuentaBancariaController::class, 'store']);
    Route::put('/{id}', [EmpleadoCuentaBancariaController::class, 'update']);
    Route::delete('/{id}', [EmpleadoCuentaBancariaController::class, 'destroy']);
});

Route::get('/empleado_empresa', [EmpleadoEmpresaController::class, 'index']);
Route::get('/empleado_empresa/{id}', [EmpleadoEmpresaController::class, 'show']);
Route::prefix('/empleado_empresa')->group(function(){
    Route::post('/store', [EmpleadoEmpresaController::class, 'store']);
    Route::put('/{id}', [EmpleadoEmpresaController::class, 'update']);
    Route::delete('/{id}', [EmpleadoEmpresaController::class, 'destroy']);
});

Route::get('/empresa', [EmpresaController::class, 'index']);
Route::get('/empresa/{id}', [EmpresaController::class, 'show']);
Route::prefix('/empresa')->group(function(){
    Route::post('/store', [EmpresaController::class, 'store']);
    Route::put('/{id}', [EmpresaController::class, 'update']);
    Route::delete('/{id}', [EmpresaController::class, 'destroy']);
});

Route::get('/empresa_cuenta_bancaria', [EmpresaCuentaBancariaController::class, 'index']);
Route::get('/empresa_cuenta_bancaria/{id}', [EmpresaCuentaBancariaController::class, 'show']);
Route::prefix('/empresa_cuenta_bancaria')->group(function(){
    Route::post('/store', [EmpresaCuentaBancariaController::class, 'store']);
    Route::put('/{id}', [EmpresaCuentaBancariaController::class, 'update']);
    Route::delete('/{id}', [EmpresaCuentaBancariaController::class, 'destroy']);
});

Route::get('/empresa_plaza', [EmpresaPlazaController::class, 'index']);
Route::get('/empresa_plaza/{id}', [EmpresaPlazaController::class, 'show']);
Route::prefix('/empresa_plaza')->group(function(){
    Route::post('/store', [EmpresaPlazaController::class, 'store']);
    Route::put('/{id}', [EmpresaPlazaController::class, 'update']);
    Route::delete('/{id}', [EmpresaPlazaController::class, 'destroy']);
});

Route::get('/estado', [EstadoController::class, 'index']);
Route::get('/estado/{id}', [EstadoController::class, 'show']);
Route::prefix('/estado')->group(function(){
    Route::post('/store', [EstadoController::class, 'store']);
    Route::put('/{id}', [EstadoController::class, 'update']);
    Route::delete('/{id}', [EstadoController::class, 'destroy']);
});

Route::get('/exportacion', [ExportacionController::class, 'index']);
Route::get('/exportacion/{id}', [ExportacionController::class, 'show']);
Route::prefix('/exportacion')->group(function(){
    Route::post('/store', [ExportacionController::class, 'store']);
    Route::put('/{id}', [ExportacionController::class, 'update']);
    Route::delete('/{id}', [ExportacionController::class, 'destroy']);
});

Route::get('/fabrica', [FabricaController::class, 'index']);
Route::get('/fabrica/{id}', [FabricaController::class, 'show']);
Route::prefix('/fabrica')->group(function(){
    Route::post('/store', [FabricaController::class, 'store']);
    Route::put('/{id}', [FabricaController::class, 'update']);
    Route::delete('/{id}', [FabricaController::class, 'destroy']);
});

Route::get('/factura_concepto', [FacturaConceptoController::class, 'index']);
Route::get('/factura_concepto/{id}', [FacturaConceptoController::class, 'show']);
Route::prefix('/factura_concepto')->group(function(){
    Route::post('/store', [FacturaConceptoController::class, 'store']);
    Route::put('/{id}', [FacturaConceptoController::class, 'update']);
    Route::delete('/{id}', [FacturaConceptoController::class, 'destroy']);
});

Route::get('/factura', [FacturaController::class, 'index']);
Route::get('/factura/{id}', [FacturaController::class, 'show']);
Route::prefix('/factura')->group(function(){
    Route::post('/store', [FacturaController::class, 'store']);
    Route::put('/{id}', [FacturaController::class, 'update']);
    Route::delete('/{id}', [FacturaController::class, 'destroy']);
});

Route::get('/factura_cancelada', [FacturaCanceladaController::class, 'index']);
Route::get('/factura_cancelada/{id}', [FacturaCanceladaController::class, 'show']);
Route::prefix('/factura_cancelada')->group(function(){
    Route::post('/store', [FacturaCanceladaController::class, 'store']);
    Route::put('/{id}', [FacturaCanceladaController::class, 'update']);
    Route::delete('/{id}', [FacturaCanceladaController::class, 'destroy']);
});

Route::get('/factura_relacionada', [FacturaRelacionadaController::class, 'index']);
Route::get('/factura_relacionada/{id}', [FacturaRelacionadaController::class, 'show']);
Route::prefix('/factura_relacionada')->group(function(){
    Route::post('/store', [FacturaRelacionadaController::class, 'store']);
    Route::put('/{id}', [FacturaRelacionadaController::class, 'update']);
    Route::delete('/{id}', [FacturaRelacionadaController::class, 'destroy']);
});

Route::get('/forma_pago', [FormaPagoController::class, 'index']);
Route::get('/forma_pago/{id}', [FormaPagoController::class, 'show']);
Route::prefix('/forma_pago')->group(function(){
    Route::post('/store', [FormaPagoController::class, 'store']);
    Route::put('/{id}', [FormaPagoController::class, 'update']);
    Route::delete('/{id}', [FormaPagoController::class, 'destroy']);
});

Route::get('/grupo', [GrupoController::class, 'index']);
Route::get('/grupo/{id}', [GrupoController::class, 'show']);
Route::prefix('/grupo')->group(function(){
    Route::post('/store', [GrupoController::class, 'store']);
    Route::put('/{id}', [GrupoController::class, 'update']);
    Route::delete('/{id}', [GrupoController::class, 'destroy']);
});

Route::get('/grupo_producto', [GrupoProductoController::class, 'index']);
Route::get('/grupo_producto/{id}', [GrupoProductoController::class, 'show']);
Route::prefix('/grupo_producto')->group(function(){
    Route::post('/store', [GrupoProductoController::class, 'store']);
    Route::put('/{id}', [GrupoProductoController::class, 'update']);
    Route::delete('/{id}', [GrupoProductoController::class, 'destroy']);
});

Route::get('/incapacidad', [IncapacidadController::class, 'index']);
Route::get('/incapacidad/{id}', [IncapacidadController::class, 'show']);
Route::prefix('/incapacidad')->group(function(){
    Route::post('/store', [IncapacidadController::class, 'store']);
    Route::put('/{id}', [IncapacidadController::class, 'update']);
    Route::delete('/{id}', [IncapacidadController::class, 'destroy']);
});

Route::get('/isr_mensual', [IsrMensualController::class, 'index']);
Route::get('/isr_mensual/{id}', [IsrMensualController::class, 'show']);
Route::prefix('/isr_mensual')->group(function(){
    Route::post('/store', [IsrMensualController::class, 'store']);
    Route::put('/{id}', [IsrMensualController::class, 'update']);
    Route::delete('/{id}', [IsrMensualController::class, 'destroy']);
});

Route::get('/isr_quincenal', [IsrQuincenalController::class, 'index']);
Route::get('/isr_quincenal/{id}', [IsrQuincenalController::class, 'show']);
Route::prefix('/isr_quincenal')->group(function(){
    Route::post('/store', [IsrQuincenalController::class, 'store']);
    Route::put('/{id}', [IsrQuincenalController::class, 'update']);
    Route::delete('/{id}', [IsrQuincenalController::class, 'destroy']);
});

Route::get('/isr_semanal', [IsrSemanalController::class, 'index']);
Route::get('/isr_semanal/{id}', [IsrSemanalController::class, 'show']);
Route::prefix('/isr_semanal')->group(function(){
    Route::post('/store', [IsrSemanalController::class, 'store']);
    Route::put('/{id}', [IsrSemanalController::class, 'update']);
    Route::delete('/{id}', [IsrSemanalController::class, 'destroy']);
});

Route::get('/menu', [MenuController::class, 'index']);
Route::get('/menu/{id}', [MenuController::class, 'show']);
Route::prefix('/menu')->group(function(){
    Route::post('/store', [MenuController::class, 'store']);
    Route::put('/{id}', [MenuController::class, 'update']);
    Route::delete('/{id}', [MenuController::class, 'destroy']);
});

Route::get('/mes', [MesController::class, 'index']);
Route::get('/mes/{id}', [MesController::class, 'show']);
Route::prefix('/mes')->group(function(){
    Route::post('/store', [MesController::class, 'store']);
    Route::put('/{id}', [MesController::class, 'update']);
    Route::delete('/{id}', [MesController::class, 'destroy']);
});

Route::get('/metodo_pago', [MetodoPagoController::class, 'index']);
Route::get('/metodo_pago/{id}', [MetodoPagoController::class, 'show']);
Route::prefix('/metodo_pago')->group(function(){
    Route::post('/store', [MetodoPagoController::class, 'store']);
    Route::put('/{id}', [MetodoPagoController::class, 'update']);
    Route::delete('/{id}', [MetodoPagoController::class, 'destroy']);
});

Route::get('/municipio', [MunicipioController::class, 'index']);
Route::get('/municipio/{id}', [MunicipioController::class, 'show']);
Route::prefix('/municipio')->group(function(){
    Route::post('/store', [MunicipioController::class, 'store']);
    Route::put('/{id}', [MunicipioController::class, 'update']);
    Route::delete('/{id}', [MunicipioController::class, 'destroy']);
});

Route::get('/moneda', [MonedaController::class, 'index']);
Route::get('/moneda/{id}', [MonedaController::class, 'show']);
Route::prefix('/moneda')->group(function(){
    Route::post('/store', [MonedaController::class, 'store']);
    Route::put('/{id}', [MonedaController::class, 'update']);
    Route::delete('/{id}', [MonedaController::class, 'destroy']);
});

Route::get('/motivo_cancelacion', [MotivoCancelacionController::class, 'index']);
Route::get('/motivo_cancelacion/{id}', [MotivoCancelacionController::class, 'show']);
Route::prefix('/motivo_cancelacion')->group(function(){
    Route::post('/store', [MotivoCancelacionController::class, 'store']);
    Route::put('/{id}', [MotivoCancelacionController::class, 'update']);
    Route::delete('/{id}', [MotivoCancelacionController::class, 'destroy']);
});

Route::get('/nomina', [NominaController::class, 'index']);
Route::get('/nomina/{id}', [NominaController::class, 'show']);
Route::prefix('/nomina')->group(function(){
    Route::post('/store', [NominaController::class, 'store']);
    Route::put('/{id}', [NominaController::class, 'update']);
    Route::delete('/{id}', [NominaController::class, 'destroy']);
});

Route::get('/nota_credito', [NotaCreditoController::class, 'index']);
Route::get('/nota_credito/{id}', [NotaCreditoController::class, 'show']);
Route::prefix('/nota_credito')->group(function(){
    Route::post('/store', [NotaCreditoController::class, 'store']);
    Route::put('/{id}', [NotaCreditoController::class, 'update']);
    Route::delete('/{id}', [NotaCreditoController::class, 'destroy']);
});

Route::get('/nota_credito_cancelada', [NotaCreditoCanceladaController::class, 'index']);
Route::get('/nota_credito_cancelada/{id}', [NotaCreditoCanceladaController::class, 'show']);
Route::prefix('/nota_credito_cancelada')->group(function(){
    Route::post('/store', [NotaCreditoCanceladaController::class, 'store']);
    Route::put('/{id}', [NotaCreditoCanceladaController::class, 'update']);
    Route::delete('/{id}', [NotaCreditoCanceladaController::class, 'destroy']);
});

Route::get('/nota_credito_documento', [NotaCreditoDocumentoController::class, 'index']);
Route::get('/nota_credito_documento/{id}', [NotaCreditoDocumentoController::class, 'show']);
Route::prefix('/nota_credito_documento')->group(function(){
    Route::post('/store', [NotaCreditoDocumentoController::class, 'store']);
    Route::put('/{id}', [NotaCreditoDocumentoController::class, 'update']);
    Route::delete('/{id}', [NotaCreditoDocumentoController::class, 'destroy']);
});

Route::get('/pais', [PaisController::class, 'index']);
Route::get('/pais/{id}', [PaisController::class, 'show']);
Route::prefix('/pais')->group(function(){
    Route::post('/store', [PaisController::class, 'store']);
    Route::put('/{id}', [PaisController::class, 'update']);
    Route::delete('/{id}', [PaisController::class, 'destroy']);
});

Route::get('/pago_bono', [PagoBonoController::class, 'index']);
Route::get('/pago_bono/{id}', [PagoBonoController::class, 'show']);
Route::prefix('/pago_bono')->group(function(){
    Route::post('/store', [PagoBonoController::class, 'store']);
    Route::put('/{id}', [PagoBonoController::class, 'update']);
    Route::delete('/{id}', [PagoBonoController::class, 'destroy']);
});

Route::get('/pago_descuento', [PagoDescuentoController::class, 'index']);
Route::get('/pago_descuento/{id}', [PagoDescuentoController::class, 'show']);
Route::prefix('/pago_descuento')->group(function(){
    Route::post('/store', [PagoDescuentoController::class, 'store']);
    Route::put('/{id}', [PagoDescuentoController::class, 'update']);
    Route::delete('/{id}', [PagoDescuentoController::class, 'destroy']);
});

Route::get('/periodicidad_pago', [PeriodicidadPagoController::class, 'index']);
Route::get('/periodicidad_pago/{id}', [PeriodicidadPagoController::class, 'show']);
Route::prefix('/periodicidad_pago')->group(function(){
    Route::post('/store', [PeriodicidadPagoController::class, 'store']);
    Route::put('/{id}', [PeriodicidadPagoController::class, 'update']);
    Route::delete('/{id}', [PeriodicidadPagoController::class, 'destroy']);
});

Route::get('/periodo_pago', [PeriodoPagoController::class, 'index']);
Route::get('/periodo_pago/{id}', [PeriodoPagoController::class, 'show']);
Route::prefix('/periodo_pago')->group(function(){
    Route::post('/store', [PeriodoPagoController::class, 'store']);
    Route::put('/{id}', [PeriodoPagoController::class, 'update']);
    Route::delete('/{id}', [PeriodoPagoController::class, 'destroy']);
});

Route::get('/percepcion', [PercepcionController::class, 'index']);
Route::get('/percepcion/{id}', [PercepcionController::class, 'show']);
Route::prefix('/percepcion')->group(function(){
    Route::post('/store', [PercepcionController::class, 'store']);
    Route::put('/{id}', [PercepcionController::class, 'update']);
    Route::delete('/{id}', [PercepcionController::class, 'destroy']);
});

Route::get('/plaza', [PlazaController::class, 'index']);
Route::get('/plaza/{id}', [PlazaController::class, 'show']);
Route::prefix('/plaza')->group(function(){
    Route::post('/store', [PlazaController::class, 'store']);
    Route::put('/{id}', [PlazaController::class, 'update']);
    Route::delete('/{id}', [PlazaController::class, 'destroy']);
});

Route::get('/prenomina', [PrenominaController::class, 'index']);
Route::get('/prenomina/{id}', [PrenominaController::class, 'show']);
Route::prefix('/prenomina')->group(function(){
    Route::post('/store', [PrenominaController::class, 'store']);
    Route::put('/{id}', [PrenominaController::class, 'update']);
    Route::delete('/{id}', [PrenominaController::class, 'destroy']);
});

Route::get('/prenomina_detalle', [PrenominaDetalleController::class, 'index']);
Route::get('/prenomina_detalle/{id}', [PrenominaDetalleController::class, 'show']);
Route::prefix('/prenomina_detalle')->group(function(){
    Route::post('/store', [PrenominaDetalleController::class, 'store']);
    Route::put('/{id}', [PrenominaDetalleController::class, 'update']);
    Route::delete('/{id}', [PrenominaDetalleController::class, 'destroy']);
});

Route::get('/producto', [ProductoController::class, 'index']);
Route::get('/producto/{id}', [ProductoController::class, 'show']);
Route::prefix('/producto')->group(function(){
    Route::post('/store', [ProductoController::class, 'store']);
    Route::put('/{id}', [ProductoController::class, 'update']);
    Route::delete('/{id}', [ProductoController::class, 'destroy']);
});

Route::get('/puesto', [PuestoController::class, 'index']);
Route::get('/puesto/{id}', [PuestoController::class, 'show']);
Route::prefix('/puesto')->group(function(){
    Route::post('/store', [PuestoController::class, 'store']);
    Route::put('/{id}', [PuestoController::class, 'update']);
    Route::delete('/{id}', [PuestoController::class, 'destroy']);
});

Route::get('/recibo', [ReciboController::class, 'index']);
Route::get('/recibo/{id}', [ReciboController::class, 'show']);
Route::prefix('/recibo')->group(function(){
    Route::post('/store', [ReciboController::class, 'store']);
    Route::put('/{id}', [ReciboController::class, 'update']);
    Route::delete('/{id}', [ReciboController::class, 'destroy']);
});

Route::get('/recibo_deduccion', [ReciboDeduccionController::class, 'index']);
Route::get('/recibo_deduccion/{id}', [ReciboDeduccionController::class, 'show']);
Route::prefix('/recibo_deduccion')->group(function(){
    Route::post('/store', [ReciboDeduccionController::class, 'store']);
    Route::put('/{id}', [ReciboDeduccionController::class, 'update']);
    Route::delete('/{id}', [ReciboDeduccionController::class, 'destroy']);
});

Route::get('/recibo_tipo_otro_pago', [ReciboTipoOtroPagoController::class, 'index']);
Route::get('/recibo_tipo_otro_pago/{id}', [ReciboTipoOtroPagoController::class, 'show']);
Route::prefix('/recibo_tipo_otro_pago')->group(function(){
    Route::post('/store', [ReciboTipoOtroPagoController::class, 'store']);
    Route::put('/{id}', [ReciboTipoOtroPagoController::class, 'update']);
    Route::delete('/{id}', [ReciboTipoOtroPagoController::class, 'destroy']);
});

Route::get('/recibo_percepcion', [ReciboPercepcionController::class, 'index']);
Route::get('/recibo_percepcion/{id}', [ReciboPercepcionController::class, 'show']);
Route::prefix('/recibo_percepcion')->group(function(){
    Route::post('/store', [ReciboPercepcionController::class, 'store']);
    Route::put('/{id}', [ReciboPercepcionController::class, 'update']);
    Route::delete('/{id}', [ReciboPercepcionController::class, 'destroy']);
});

Route::get('/regimen_fiscal', [RegimenFiscalController::class, 'index']);
Route::get('/regimen_fiscal/{id}', [RegimenFiscalController::class, 'show']);
Route::prefix('/regimen_fiscal')->group(function(){
    Route::post('/store', [RegimenFiscalController::class, 'store']);
    Route::put('/{id}', [RegimenFiscalController::class, 'update']);
    Route::delete('/{id}', [RegimenFiscalController::class, 'destroy']);
});

Route::get('/registro_patronal', [RegistroPatronalController::class, 'index']);
Route::get('/registro_patronal/{id}', [RegistroPatronalController::class, 'show']);
Route::prefix('/registro_patronal')->group(function(){
    Route::post('/store', [RegistroPatronalController::class, 'store']);
    Route::put('/{id}', [RegistroPatronalController::class, 'update']);
    Route::delete('/{id}', [RegistroPatronalController::class, 'destroy']);
});

Route::get('/riesgo_puesto', [RiesgoPuestoController::class, 'index']);
Route::get('/riesgo_puesto/{id}', [RiesgoPuestoController::class, 'show']);
Route::prefix('/riesgo_puesto')->group(function(){
    Route::post('/store', [RiesgoPuestoController::class, 'store']);
    Route::put('/{id}', [RiesgoPuestoController::class, 'update']);
    Route::delete('/{id}', [RiesgoPuestoController::class, 'destroy']);
});

Route::get('/salario_minimo', [SalarioMinimoController::class, 'index']);
Route::get('/salario_minimo/{id}', [SalarioMinimoController::class, 'show']);
Route::prefix('/salario_minimo')->group(function(){
    Route::post('/store', [SalarioMinimoController::class, 'store']);
    Route::put('/{id}', [SalarioMinimoController::class, 'update']);
    Route::delete('/{id}', [SalarioMinimoController::class, 'destroy']);
});

Route::get('/seccion_menu', [SeccionMenuController::class, 'index']);
Route::get('/seccion_menu/{id}', [SeccionMenuController::class, 'show']);
Route::prefix('/seccion_menu')->group(function(){
    Route::post('/store', [SeccionMenuController::class, 'store']);
    Route::put('/{id}', [SeccionMenuController::class, 'update']);
    Route::delete('/{id}', [SeccionMenuController::class, 'destroy']);
    Route::post('/desc', [SeccionMenuController::class, 'get_seccion_menu']);
});

Route::get('/seccion_menu_input', [SeccionMenuInputController::class, 'index']);
Route::get('/seccion_menu_input/{id}', [SeccionMenuInputController::class, 'show']);
Route::prefix('/seccion_menu_input')->group(function(){
    Route::post('/store', [SeccionMenuInputController::class, 'store']);
    Route::put('/{id}', [SeccionMenuInputController::class, 'update']);
    Route::delete('/{id}', [SeccionMenuInputController::class, 'destroy']);
    Route::post('/inputs', [SeccionMenuInputController::class, 'get_inputs_alta']);
    Route::post('/inputs_modifica', [SeccionMenuInputController::class, 'get_inputs_modifica']);
    Route::post('/table_columns', [SeccionMenuInputController::class, 'get_table_columns']);
    Route::post('/inputs_filtro', [SeccionMenuInputController::class, 'get_inputs_filtro']);
});

Route::get('/serie_cfdi', [SerieCfdiController::class, 'index']);
Route::get('/serie_cfdi/{id}', [SerieCfdiController::class, 'show']);
Route::prefix('/serie_cfdi')->group(function(){
    Route::post('/store', [SerieCfdiController::class, 'store']);
    Route::put('/{id}', [SerieCfdiController::class, 'update']);
    Route::delete('/{id}', [SerieCfdiController::class, 'destroy']);
});

Route::get('/sueldos_salarios', [SueldosSalariosController::class, 'index']);
Route::get('/sueldos_salarios/{id}', [SueldosSalariosController::class, 'show']);
Route::prefix('/sueldos_salarios')->group(function(){
    Route::post('/store', [SueldosSalariosController::class, 'store']);
    Route::put('/{id}', [SueldosSalariosController::class, 'update']);
    Route::delete('/{id}', [SueldosSalariosController::class, 'destroy']);
    Route::post('/calcula_sueldos_salarios', [SueldosSalariosController::class, 'calcula_valores_sueldos_salarios']);
    Route::post('/neto_aprox', [SueldosSalariosController::class, 'obten_aproximacion_neto']);
});

Route::get('/subsidio_empleo_mensual', [SubsidioEmpleoMensualController::class, 'index']);
Route::get('/subsidio_empleo_mensual/{id}', [SubsidioEmpleoMensualController::class, 'show']);
Route::prefix('/subsidio_empleo_mensual')->group(function(){
    Route::post('/store', [SubsidioEmpleoMensualController::class, 'store']);
    Route::put('/{id}', [SubsidioEmpleoMensualController::class, 'update']);
    Route::delete('/{id}', [SubsidioEmpleoMensualController::class, 'destroy']);
});

Route::get('/subsidio_empleo_quincenal', [SubsidioEmpleoQuincenalController::class, 'index']);
Route::get('/subsidio_empleo_quincenal/{id}', [SubsidioEmpleoQuincenalController::class, 'show']);
Route::prefix('/subsidio_empleo_quincenal')->group(function(){
    Route::post('/store', [SubsidioEmpleoQuincenalController::class, 'store']);
    Route::put('/{id}', [SubsidioEmpleoQuincenalController::class, 'update']);
    Route::delete('/{id}', [SubsidioEmpleoQuincenalController::class, 'destroy']);
});

Route::get('/subsidio_empleo_semanal', [SubsidioEmpleoSemanalController::class, 'index']);
Route::get('/subsidio_empleo_semanal/{id}', [SubsidioEmpleoSemanalController::class, 'show']);
Route::prefix('/subsidio_empleo_semanal')->group(function(){
    Route::post('/store', [SubsidioEmpleoSemanalController::class, 'store']);
    Route::put('/{id}', [SubsidioEmpleoSemanalController::class, 'update']);
    Route::delete('/{id}', [SubsidioEmpleoSemanalController::class, 'destroy']);
});

Route::get('/tipo_cambio', [TipoCambioController::class, 'index']);
Route::get('/tipo_cambio/{id}', [TipoCambioController::class, 'show']);
Route::prefix('/tipo_cambio')->group(function(){
    Route::post('/store', [TipoCambioController::class, 'store']);
    Route::put('/{id}', [TipoCambioController::class, 'update']);
    Route::delete('/{id}', [TipoCambioController::class, 'destroy']);
});

Route::get('/tipo_deduccion', [TipoDeduccionController::class, 'index']);
Route::get('/tipo_deduccion/{id}', [TipoDeduccionController::class, 'show']);
Route::prefix('/tipo_deduccion')->group(function(){
    Route::post('/store', [TipoDeduccionController::class, 'store']);
    Route::put('/{id}', [TipoDeduccionController::class, 'update']);
    Route::delete('/{id}', [TipoDeduccionController::class, 'destroy']);
});

Route::get('/tipo_comprobante', [TipoComprobanteController::class, 'index']);
Route::get('/tipo_comprobante/{id}', [TipoComprobanteController::class, 'show']);
Route::prefix('/tipo_comprobante')->group(function(){
    Route::post('/store', [TipoComprobanteController::class, 'store']);
    Route::put('/{id}', [TipoComprobanteController::class, 'update']);
    Route::delete('/{id}', [TipoComprobanteController::class, 'destroy']);
});

Route::get('/tipo_contrato', [TipoContratoController::class, 'index']);
Route::get('/tipo_contrato/{id}', [TipoContratoController::class, 'show']);
Route::prefix('/tipo_contrato')->group(function(){
    Route::post('/store', [TipoContratoController::class, 'store']);
    Route::put('/{id}', [TipoContratoController::class, 'update']);
    Route::delete('/{id}', [TipoContratoController::class, 'destroy']);
});

Route::get('/tipo_incapacidad', [TipoIncapacidadController::class, 'index']);
Route::get('/tipo_incapacidad/{id}', [TipoIncapacidadController::class, 'show']);
Route::prefix('/tipo_incapacidad')->group(function(){
    Route::post('/store', [TipoIncapacidadController::class, 'store']);
    Route::put('/{id}', [TipoIncapacidadController::class, 'update']);
    Route::delete('/{id}', [TipoIncapacidadController::class, 'destroy']);
});

Route::get('/tipo_jornada', [TipoJornadaController::class, 'index']);
Route::get('/tipo_jornada/{id}', [TipoJornadaController::class, 'show']);
Route::prefix('/tipo_jornada')->group(function(){
    Route::post('/store', [TipoJornadaController::class, 'store']);
    Route::put('/{id}', [TipoJornadaController::class, 'update']);
    Route::delete('/{id}', [TipoJornadaController::class, 'destroy']);
});

Route::get('/tipo_nomina', [TipoNominaController::class, 'index']);
Route::get('/tipo_nomina/{id}', [TipoNominaController::class, 'show']);
Route::prefix('/tipo_nomina')->group(function(){
    Route::post('/store', [TipoNominaController::class, 'store']);
    Route::put('/{id}', [TipoNominaController::class, 'update']);
    Route::delete('/{id}', [TipoNominaController::class, 'destroy']);
});

Route::get('/tipo_otro_pago', [TipoOtroPagoController::class, 'index']);
Route::get('/tipo_otro_pago/{id}', [TipoOtroPagoController::class, 'show']);
Route::prefix('/tipo_otro_pago')->group(function(){
    Route::post('/store', [TipoOtroPagoController::class, 'store']);
    Route::put('/{id}', [TipoOtroPagoController::class, 'update']);
    Route::delete('/{id}', [TipoOtroPagoController::class, 'destroy']);
});

Route::get('/tipo_percepcion', [TipoPercepcionController::class, 'index']);
Route::get('/tipo_percepcion/{id}', [TipoPercepcionController::class, 'show']);
Route::prefix('/tipo_percepcion')->group(function(){
    Route::post('/store', [TipoPercepcionController::class, 'store']);
    Route::put('/{id}', [TipoPercepcionController::class, 'update']);
    Route::delete('/{id}', [TipoPercepcionController::class, 'destroy']);
});

Route::get('/tipo_producto', [TipoProductoController::class, 'index']);
Route::get('/tipo_producto/{id}', [TipoProductoController::class, 'show']);
Route::prefix('/tipo_producto')->group(function(){
    Route::post('/store', [TipoProductoController::class, 'store']);
    Route::put('/{id}', [TipoProductoController::class, 'update']);
    Route::delete('/{id}', [TipoProductoController::class, 'destroy']);
});

Route::get('/tipo_recibo', [TipoReciboController::class, 'index']);
Route::get('/tipo_recibo/{id}', [TipoReciboController::class, 'show']);
Route::prefix('/tipo_recibo')->group(function(){
    Route::post('/store', [TipoReciboController::class, 'store']);
    Route::put('/{id}', [TipoReciboController::class, 'update']);
    Route::delete('/{id}', [TipoReciboController::class, 'destroy']);
});

Route::get('/tipo_regimen', [TipoRegimenController::class, 'index']);
Route::get('/tipo_regimen/{id}', [TipoRegimenController::class, 'show']);
Route::prefix('/tipo_regimen')->group(function(){
    Route::post('/store', [TipoRegimenController::class, 'store']);
    Route::put('/{id}', [TipoRegimenController::class, 'update']);
    Route::delete('/{id}', [TipoRegimenController::class, 'destroy']);
});

Route::get('/tipo_relacion', [TipoRelacionController::class, 'index']);
Route::get('/tipo_relacion/{id}', [TipoRelacionController::class, 'show']);
Route::prefix('/tipo_relacion')->group(function(){
    Route::post('/store', [TipoRelacionController::class, 'store']);
    Route::put('/{id}', [TipoRelacionController::class, 'update']);
    Route::delete('/{id}', [TipoRelacionController::class, 'destroy']);
});

Route::get('/uma', [UmaController::class, 'index']);
Route::get('/uma/{id}', [UmaController::class, 'show']);
Route::prefix('/uma')->group(function(){
    Route::post('/store', [UmaController::class, 'store']);
    Route::put('/{id}', [UmaController::class, 'update']);
    Route::delete('/{id}', [UmaController::class, 'destroy']);
});

Route::get('/unidad', [UnidadController::class, 'index']);
Route::get('/unidad/{id}', [UnidadController::class, 'show']);
Route::prefix('/unidad')->group(function(){
    Route::post('/store', [UnidadController::class, 'store']);
    Route::put('/{id}', [UnidadController::class, 'update']);
    Route::delete('/{id}', [UnidadController::class, 'destroy']);
});

Route::get('/user', [UserController::class, 'index']);
Route::prefix('/user')->group(function(){
    Route::post('/authen', [UserController::class, 'authenticate']);
    Route::get('/auth_error', [UserController::class, 'auth_error'])->name('auth_error');
});

Route::get('/uso_cfdi', [UsoCfdiController::class, 'index']);
Route::get('/uso_cfdi/{id}', [UsoCfdiController::class, 'show']);
Route::prefix('/uso_cfdi')->group(function(){
    Route::post('/store', [UsoCfdiController::class, 'store']);
    Route::put('/{id}', [UsoCfdiController::class, 'update']);
    Route::delete('/{id}', [UsoCfdiController::class, 'destroy']);
});