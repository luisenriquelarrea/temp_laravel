<?php

namespace App\Http\Controllers;

use App\Models\SueldosSalarios;
use App\Models\Ejercicio;
use App\Http\Traits\MethodResponseTrait;
use App\Http\Traits\NominaTrait;
use Illuminate\Http\Request;

class SueldosSalariosController extends Controller
{
    use MethodResponseTrait {
        set_error as protected error_response;
        set_success as protected success_response;
    }

    use NominaTrait {
        get_salario_minimo as protected obten_salario_minimo;
        get_bonos_estrategia_premios as protected obten_bonos;
        calcula_sdi as protected obten_sdi;
        calcula_sueldos_salarios as protected obten_sueldos_salarios;
        calcula_isr as protected obten_isr;
        calcula_subsidio_empleo as protected obten_subsidio_empleo;
        calcula_subsidio_empleo_entregar as protected obten_subsidio_entregar;
        calcula_isr_pagar as protected obten_isr_pagar;
        calcula_imss as protected obten_imss;
    }

    /**
     * Constructor.
     *
     */
    public function __construct(){
        $modelo = new SueldosSalarios;
        $tabla = 'sueldos_salarios';
        parent::__construct($modelo, $tabla);
    }

    /**
     * Update values sueldos salarios.
     *
     * @param  int   $sueldos_salarios_id
     * @return array $response
     */
    public function actualiza_valores_sueldos_salarios(int $sueldos_salarios_id, float $total_sueldos_salarios, 
        float $isr_determinado, float $isr_pagar, float $subsidio_empleo_causado, float $subsidio_empleo_entregar, 
        float $imss, float $neto):array{
        $sueldos_salarios = SueldosSalarios::find($sueldos_salarios_id);
        if($sueldos_salarios){
            $sueldos_salarios->sueldos_salarios = $total_sueldos_salarios;
            $sueldos_salarios->isr_determinado = $isr_determinado;
            $sueldos_salarios->isr_pagar = $isr_pagar;
            $sueldos_salarios->subsidio_empleo_causado = $subsidio_empleo_causado;
            $sueldos_salarios->subsidio_empleo_entregado = $subsidio_empleo_entregar;
            $sueldos_salarios->imss = $imss;
            $sueldos_salarios->neto = $neto;
            $sueldos_salarios->save();
            return $this->success_response();
        }
        return $this->error_response("Error no existe registro sueldos_salarios", __CLASS__, __FUNCTION__, __LINE__);
    }

    /**
     * Calculate sueldos salarios
     *
     * @return JSON Response
     */
    public function calcula_valores_sueldos_salarios(Request $request)
    {
        $sueldos_salarios = SueldosSalarios::select('sueldos_salarios.*', 'ejercicio.descripcion AS ejercicio_descripcion')
            ->where('sueldos_salarios.sueldos_salarios', '=', 0)
            ->join('ejercicio', 'sueldos_salarios.ejercicio_id', 
                '=', 'ejercicio.id')
            ->get()
            ->toArray();
        if(count($sueldos_salarios) === 0){
            $error = $this->error_response("Error no hay informacion sueldos_salarios BD", __CLASS__, __FUNCTION__, __LINE__);
            return response()->json($error, 500);
        }
        foreach($sueldos_salarios as $key => $valor){
            $fecha_pago = $valor['ejercicio_descripcion']."-02-01";
            $n_dias_reducir = 0;
            $n_dias_pagados = (int)$valor['n_dias_pagados'];
            $bono_septimo_dia = (float)$valor['bono_septimo_dia'];
            if($bono_septimo_dia > 0.0){
                $n_dias_reducir++;
                if($n_dias_pagados === 14 || $n_dias_pagados === 15)
                    $n_dias_reducir++;
            }
            $salario_diario = (float)$valor['sd'];
            $total_sueldos_salarios = $this->obten_sueldos_salarios($salario_diario, $n_dias_pagados - $n_dias_reducir);
            $bono_puntualidad = (float)$valor['bono_puntualidad'];
            $bono_asistencia = (float)$valor['bono_asistencia'];
            $total_gravado = $total_sueldos_salarios + $bono_septimo_dia + $bono_puntualidad + $bono_asistencia;
            $response = $this->obten_isr($total_gravado, $n_dias_pagados, $fecha_pago);
            if(isset($response['error'])){
                $error = $this->error_response("Error al calcular ISR", __CLASS__, __FUNCTION__, __LINE__, $response);
                return response()->json($error, 500);
            }
            $isr_determinado = (float)$response['isr_determinado'];
            $response = $this->obten_subsidio_empleo($total_gravado, $n_dias_pagados, $fecha_pago);
            if(isset($response['error'])){
                $error = $this->error_response("Error al calcular subsidio empleo causado", __CLASS__, __FUNCTION__, 
                    __LINE__, $response);
                return response()->json($error, 500);
            }
            $subsidio_empleo_causado = (float)$response['subsidio_empleo_causado'];
            $subsidio_empleo_entregar = $this->obten_subsidio_entregar($subsidio_empleo_causado, $isr_determinado);
            $isr_pagar = $this->obten_isr_pagar($isr_determinado, $subsidio_empleo_causado, $subsidio_empleo_entregar);
            $n_dias_vacaciones = (int)$valor['n_dias_vacaciones'];
            $response = $this->obten_imss($salario_diario, $n_dias_pagados, $fecha_pago, $n_dias_vacaciones);
            if(isset($response['error'])){
                $error = $this->error_response("Error al calcular IMSS", __CLASS__, __FUNCTION__, __LINE__, $response);
                return response()->json($error, 500);
            }
            $imss = (float)$response['imss'];
            $neto = $total_gravado + $subsidio_empleo_entregar - $isr_pagar - $imss;
            $sueldos_salarios_id = $valor['id'];
            $response = $this->actualiza_valores_sueldos_salarios($sueldos_salarios_id, $total_sueldos_salarios, $isr_determinado, 
                $isr_pagar, $subsidio_empleo_causado, $subsidio_empleo_entregar, $imss, $neto);
            if(isset($response['error'])){
                $error = $this->error_response("Error al actualizar valores sueldos_salarios", __CLASS__, __FUNCTION__, __LINE__, $response);
                return response()->json($error, 500);
            }
        }
        $success = $this->success_response();
        return response()->json($success, 200);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return SueldosSalarios::select('sueldos_salarios.*')->orderBy('id', 'ASC')->get();
    }

    /**
     * Display a listing of approaching neto values.
     *
     * @return \Illuminate\Http\Response
     */
    public function obten_aproximacion_neto(Request $request){
        if(!isset($request->data['neto']) || (string)$request->data['neto'] === ''){
            $error = $this->error_response('Error $request->data[neto] debe estar asignado', __CLASS__, __FUNCTION__, __LINE__);
            return response()->json($error, 500);
        }
        $neto = $request->data['neto'];
        $sueldos_salarios = SueldosSalarios::select('sueldos_salarios.*')
            ->orderBy(SueldosSalarios::raw("ABS(sueldos_salarios.neto - $neto)", 'ASC'))
            ->limit(2)
            ->get();
        if($sueldos_salarios->isEmpty()){
            $error = $this->error_response('Error no hay informacion sueldos_salarios BD', __CLASS__, __FUNCTION__, __LINE__);
            return response()->json($error, 500);
        }
        return $sueldos_salarios;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $override = false)
    {
        $ejercicio_id = $request->data['ejercicio_id'];
        $n_dias_pagados = $request->data['n_dias_pagados'];
        $n_dias_vacaciones = $request->data['n_dias_vacaciones'];
        $sd_inicio = (int)$request->data['sd_inicio'];
        $sd_final = (int)$request->data['sd_final'];
        $calcula_bonos = false;
        if(isset($request->data['calcula_bonos']) && $request->data['calcula_bonos'] === 'activo'){
            $calcula_bonos = true;
        }
        $ejercicio = Ejercicio::select('ejercicio.*')
            ->where('ejercicio.id', '=', $ejercicio_id)
            ->sole();
        $ejercicio = $ejercicio->toArray();
        if(count($ejercicio) === 0){
            $response = [
                'success' => false,
                'message' => 'Error no hay informacion en ejercicio BD',
            ];
            return response()->json($response, 500);
        }
        $ejercicio_descripcion = $ejercicio['descripcion'];
        $fecha_pago = $ejercicio_descripcion."-02-01";
        $salario_minimo = $this->obten_salario_minimo($fecha_pago);
        $salario_minimo = $salario_minimo->toArray();
        if(count($salario_minimo) === 0){
            $response = [
                'success' => false,
                'message' => 'Error no hay informacion en salario_minimo BD',
            ];
            return response()->json($response, 500);
        }
        $salario_minimo_centro = $salario_minimo['centro'];
        if((float)$sd_inicio < (float)$salario_minimo_centro){
            $response = [
                'success' => false,
                'message' => 'Error el salario diario no puede ser menor al minimo :'.$salario_minimo_centro,
            ];
            return response()->json($response, 500);
        }
        $step = 0.25;
        foreach(range($sd_inicio, $sd_final, $step) as $salario_diario){
            $bono_septimo_dia = 0;
            $bono_puntualidad = 0;
            $bono_asistencia = 0;
            if($calcula_bonos === true){
                $bonos = $this->obten_bonos($salario_diario, $n_dias_pagados);
                $bono_septimo_dia = $bonos['bono_septimo_dia'];
                $bono_puntualidad = $bonos['bono_puntualidad'];
                $bono_asistencia = $bonos['bono_asistencia'];
            }
            $salario_diario_integrado = $this->obten_sdi($salario_diario, $n_dias_vacaciones);
            $sueldos_salarios_model = new SueldosSalarios;
            $sueldos_salarios_model->ejercicio_id = $ejercicio_id;
            $sueldos_salarios_model->sd = $salario_diario;
            $sueldos_salarios_model->sdi = $salario_diario_integrado;
            $sueldos_salarios_model->n_dias_pagados = $n_dias_pagados;
            $sueldos_salarios_model->n_dias_vacaciones = $n_dias_vacaciones;
            $sueldos_salarios_model->bono_septimo_dia = $bono_septimo_dia;
            $sueldos_salarios_model->bono_puntualidad = $bono_puntualidad;
            $sueldos_salarios_model->bono_asistencia = $bono_asistencia;
            try{
                $sueldos_salarios_model->save();
            }catch(\Exception $e){
                $response = [
                    'success' => false,
                    'message' => $e->getMessage(),
                ];
                return response()->json($response, 500);
            }
        }
        $response = [
            'success' => true,
            'message' => 'exito',
        ];
        return response()->json($response, 200);
    }
}
