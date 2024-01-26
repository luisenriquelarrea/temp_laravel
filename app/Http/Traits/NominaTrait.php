<?php

namespace App\Http\Traits;

use App\Models\SalarioMinimo;
use App\Models\IsrSemanal;
use App\Models\SubsidioEmpleoSemanal;
use App\Models\Uma;
use App\Http\Traits\MethodResponseTrait;

trait NominaTrait{
    use MethodResponseTrait {
        set_error as protected error_response;
        set_success as protected success_response;
    }

    /**  
     * Calculate bonos estrategia de premios.
     *
     * @param  float $salario_diario
     * @param  int $n_dias_pagados
     * @return array
     */
    public function get_bonos_estrategia_premios(float $salario_diario, int $n_dias_pagados):array{
        $bono_septimo_dia = $this->calcula_bono_septimo_dia($salario_diario, $n_dias_pagados);
        $bono_puntualidad = $this->calcula_bono_puntualidad($salario_diario, $n_dias_pagados);
        $bono_asistencia = $this->calcula_bono_asistencia($salario_diario, $n_dias_pagados);
        return [
            'bono_septimo_dia'=>$bono_septimo_dia, 
            'bono_puntualidad'=>$bono_puntualidad, 
            'bono_asistencia'=>$bono_asistencia
        ];
    }

    /**  
     * Calculate bono asistencia.
     *
     * @param  float $salario_diario
     * @param  int $n_dias_pagados
     * @return float $bono_asistencia
     */
    public function calcula_bono_asistencia(float $salario_diario, int $n_dias_pagados):float{
        $bono_asistencia = $salario_diario * $n_dias_pagados * 0.1;
        return $bono_asistencia;
    }

    /**  
     * Calculate bono puntualidad.
     *
     * @param  float $salario_diario
     * @param  int $n_dias_pagados
     * @return float $bono_puntualidad
     */
    public function calcula_bono_puntualidad(float $salario_diario, int $n_dias_pagados):float{
        $bono_puntualidad = $salario_diario * $n_dias_pagados * 0.1;
        return $bono_puntualidad;
    }

    /**  
     * Calculate bono septimo dia.
     *
     * @param  float $salario_diario
     * @param  int $n_dias_pagados
     * @return float $bono_septimo_dia
     */
    public function calcula_bono_septimo_dia(float $salario_diario, int $n_dias_pagados):float{
        $n_septimo_dias = 1;
        if($n_dias_pagados == 14 || $n_dias_pagados == 15)
            $n_septimo_dias = 2;
        $bono_septimo_dia = $salario_diario * $n_septimo_dias;
        return $bono_septimo_dia;
    }

    /**  
     * Calculate IMSS.
     *
     * @param  float  $salario_diario
     * @param  int    $n_dias_pagados
     * @param  string $fecha_pago
     * @param  int    $n_dias_vacaciones
     * @param  int    $n_dias_aguinaldo
     * @return array  $response
     */
    public function calcula_imss(float $salario_diario, int $n_dias_pagados, string $fecha_pago, int $n_dias_vacaciones, 
        int $n_dias_aguinaldo = 15):array{
        $sbc = $this->calcula_sbc($salario_diario, $n_dias_vacaciones, $n_dias_aguinaldo);
        $registro_uma = $this->obten_registro_uma($fecha_pago);
        if(isset($registro_uma['error'])){
            return $this->error_response("Error al obtener UMA", __CLASS__, __FUNCTION__, __LINE__, $registro_uma);
        }
        $uma = (float)$registro_uma['monto'];
        $imss = 0;
        $diferencia_3uma_sbc = $sbc - ($uma * 3);
        if($diferencia_3uma_sbc > 0)
            $imss = (0.40 / 100) * $diferencia_3uma_sbc * $n_dias_pagados;

        //2.2 Gastos médicos para pensionados y beneficiarios
        $imss = $imss + (0.375 / 100) * $sbc * $n_dias_pagados;

        //2.3 En dinero
        $imss = $imss + (0.25 / 100) * $sbc * $n_dias_pagados;

        //3 Invalidez y Vida

        //3.1 En especie y dinero
        $imss = $imss + (0.625 / 100) * $sbc * $n_dias_pagados;

        //4 Retiro, Cesantía en Edad Avanzada y Vejez (CEAV)
        $imss = $imss + (1.125 / 100) * $sbc * $n_dias_pagados;
        $response = $this->success_response();
        $response['imss'] = $imss;
        return $response;
    }

    /**  
     * Calculate ISR.
     *
     * @param  float  $total_gravado
     * @param  int    $n_dias_pagados
     * @param  string $fecha_pago
     * @return array  $response
     */
    public function calcula_isr(float $total_gravado, int $n_dias_pagados, string $fecha_pago):array{
        $registro_isr = $this->obten_registro_isr($total_gravado, $n_dias_pagados, $fecha_pago);
        if(isset($registro_isr['error'])){
            return $this->error_response("Error al obtener registro ISR", __CLASS__, __FUNCTION__, 
                __LINE__, $registro_isr);
        }
        $excedente = $total_gravado - (float)$registro_isr["limite_inferior"];
        $isr_excedente = $excedente * (float)$registro_isr["porcentaje_excedente"] / 100;
        $isr_determinado = $isr_excedente + (float)$registro_isr["cuota_fija"];
        $response = $this->success_response();
        $response['isr_determinado'] = $isr_determinado;
        return $response;
    }

    /**
     * Calculate ISR a pagar.
     *
     * @param  float $isr_determinado
     * @param  float $subsidio_empleo_causado
     * @param  float $subsidio_empleo_entregar
     * @return float $isr_pagar
     */
    public function calcula_isr_pagar(float $isr_determinado, float $subsidio_empleo_causado, float $subsidio_empleo_entregar):float{
        $isr_pagar = $isr_determinado - ($subsidio_empleo_causado - $subsidio_empleo_entregar);
        return $isr_pagar;
    }

    /**
     * Calculate salario base cotizacion
     *
     * @param  float $salario_diario
     * @param  int   $n_dias_vacaciones
     * @param  int   $n_dias_aguinaldo
     * @param  float $prima_vacacional
     * @return float $sbc
     */
    public function calcula_sbc(float $salario_diario, int $n_dias_vacaciones, int $n_dias_aguinaldo, float $prima_vacacional = 0.25):float{
        $dias_anio = 365;
        $sbc = (($n_dias_aguinaldo * $salario_diario) / $dias_anio) 
            + (($n_dias_vacaciones * $salario_diario * $prima_vacacional) / $dias_anio) + $salario_diario;
        return $sbc;
    }

    /**
     * Calculate salario diario integrado
     *
     * @param float salario_diario
     * @param int dias_vacaciones
     * @param int dias_aguinaldo
     * @param float prima_vacacional
     * @return float salario_diario_integrado
     */
    public function calcula_sdi(float $salario_diario, int $dias_vacaciones, int $dias_aguinaldo = 15, float $prima_vacacional = 0.25):float{
        $monto_aguinaldo = $salario_diario * $dias_aguinaldo;
        $monto_vacaciones = $salario_diario * $dias_vacaciones;
        $monto_prima_vacacional = $prima_vacacional * $monto_vacaciones;
        $monto_extra = $monto_aguinaldo + $monto_prima_vacacional;
        $monto_anual = ($salario_diario * 365) + $monto_extra;
        $salario_diario_integrado = $monto_anual / 365;
        return $salario_diario_integrado;
    }

    /**  
     * Calculate subsidio empleo causado.
     *
     * @param  float  $total_gravado
     * @param  int    $n_dias_pagados
     * @param  string $fecha_pago
     * @return array  $response
     */
    public function calcula_subsidio_empleo(float $total_gravado, int $n_dias_pagados, string $fecha_pago):array{
        $registro_subsidio = $this->obten_registro_subsidio($total_gravado, $n_dias_pagados, $fecha_pago);
        if(isset($registro_subsidio['error'])){
            return $this->error_response("Error al obtener registro subsidio empleo", __CLASS__, __FUNCTION__, 
                __LINE__, $registro_subsidio);
        }
        $response = $this->success_response();
        $response['subsidio_empleo_causado'] = (float)$registro_subsidio['cuota_fija'];
        return $response;
    }

    /**
     * Calculate subsidio empleo a entregar.
     *
     * @param  float $subsidio_empleo_causado
     * @param  float $isr_determinado
     * @return float $subsidio_empleo_entregar
     */
    public function calcula_subsidio_empleo_entregar(float $subsidio_empleo_causado, float $isr_determinado):float{
        if($isr_determinado >= $subsidio_empleo_causado)
            return $subsidio_empleo_causado;
        $subsidio_empleo_entregar = $subsidio_empleo_causado - $isr_determinado;
        return $subsidio_empleo_entregar;
    }

    /**  
     * Calculate sueldos salarios.
     *
     * @param  float $salario_diario
     * @param  int $n_dias_pagados
     * @return float $sueldos_salarios
     */
    public function calcula_sueldos_salarios(float $salario_diario, int $n_dias_pagados):float{
        $sueldos_salarios = $salario_diario * $n_dias_pagados;
        return $sueldos_salarios;
    }

    /**
     * Retrieve salario minimo from current fecha pago.
     *
     * @param  string $fecha_pago
     * @return \Illuminate\Http\Response
     */
    public function get_salario_minimo(string $fecha_pago){
        return SalarioMinimo::select('salario_minimo.*')
            ->whereRaw("'$fecha_pago' >= salario_minimo.fecha_inicio")
            ->whereRaw("'$fecha_pago' <= salario_minimo.fecha_final")
            ->sole();
    }

    /**  
     * Get info ISR according to period.
     *
     * @param  float  $total_gravado
     * @param  int    $n_dias_pagados
     * @param  string $fecha_pago
     * @return array  $response
     */
    public function obten_registro_isr(float $total_gravado, int $n_dias_pagados, string $fecha_pago):array{
        if($n_dias_pagados === 7){
            $response = $this->obten_registro_isr_semanal($total_gravado, $fecha_pago);
            if(isset($response['error'])){
                return $this->error_response("Error al obtener registro ISR semanal", __CLASS__, __FUNCTION__, 
                    __LINE__, $response);
            }
            return $response;
        }
        return $this->error_response("Error no existe configuracion de ISR para los dias pagados", 
            __CLASS__, __FUNCTION__, __LINE__);
    }

    /**  
     * Get info ISR semanal.
     *
     * @param  float  $total_gravado
     * @param  string $fecha_pago
     * @return array  $response
     */
    public function obten_registro_isr_semanal(float $total_gravado, string $fecha_pago):array{
        $isr_semanal = IsrSemanal::select('isr_semanal.*')
            ->whereRaw("'$fecha_pago' >= isr_semanal.fecha_inicio")
            ->whereRaw("'$fecha_pago' <= isr_semanal.fecha_final")
            ->whereRaw("$total_gravado >= isr_semanal.limite_inferior")
            ->whereRaw("$total_gravado <= isr_semanal.limite_superior")
            ->sole()
            ->toArray();
        if(count($isr_semanal) === 0){
            return $this->error_response("Error no hay informacion isr_semanal BD", __CLASS__, 
                __FUNCTION__, __LINE__);
        }
        return $isr_semanal;
    }

    /**  
     * Get info subsidio empleo according to period.
     *
     * @param  float  $total_gravado
     * @param  int    $n_dias_pagados
     * @param  string $fecha_pago
     * @return array  $response
     */
    public function obten_registro_subsidio(float $total_gravado, int $n_dias_pagados, string $fecha_pago):array{
        if($n_dias_pagados === 7){
            $response = $this->obten_registro_subsidio_semanal($total_gravado, $fecha_pago);
            if(isset($response['error'])){
                return $this->error_response("Error al obtener registro subsidio empleo semanal", __CLASS__, __FUNCTION__, 
                    __LINE__, $response);
            }
            return $response;
        }
        return $this->error_response("Error no existe configuracion de subsidio empleo para los dias pagados", 
            __CLASS__, __FUNCTION__, __LINE__);
    }

    /**  
     * Get info subsidio empleo semanal.
     *
     * @param  float  $total_gravado
     * @param  string $fecha_pago
     * @return array  $response
     */
    public function obten_registro_subsidio_semanal(float $total_gravado, string $fecha_pago):array{
        $subsidio_empleo_semanal = SubsidioEmpleoSemanal::select('subsidio_empleo_semanal.*')
            ->whereRaw("'$fecha_pago' >= subsidio_empleo_semanal.fecha_inicio")
            ->whereRaw("'$fecha_pago' <= subsidio_empleo_semanal.fecha_final")
            ->whereRaw("$total_gravado >= subsidio_empleo_semanal.limite_inferior")
            ->whereRaw("$total_gravado <= subsidio_empleo_semanal.limite_superior")
            ->sole()
            ->toArray();
        if(count($subsidio_empleo_semanal) === 0){
            return $this->error_response("Error no hay informacion subsidio_empleo_semanal BD", __CLASS__, 
                __FUNCTION__, __LINE__);
        }
        return $subsidio_empleo_semanal;
    }

    /**  
     * Get info current pay date UMA.
     *
     * @param  string $fecha_pago
     * @return array  $uma
     */
    public function obten_registro_uma(string $fecha_pago):array{
        $uma = Uma::select('uma.*')
            ->whereRaw("'$fecha_pago' >= uma.fecha_inicio")
            ->whereRaw("'$fecha_pago' <= uma.fecha_final")
            ->sole()
            ->toArray();
        if(count($uma) === 0){
            return $this->error_response("Error no hay informacion UMA BD");
        }
        return $uma;
    }

    /**  
     * Validate if calculated SDI is greater than allowed
     *
     * @param  float  $salario_diario_integrado
     * @param  string $fecha
     * @return array  $uma
     */
    public function valida_sdi_maximo(float $salario_diario_integrado, string $fecha){
        $registro_uma = $this->obten_registro_uma($fecha);
        if(isset($registro_uma['error'])){
            return $this->error_response("Error no hay informacion UMA BD", __CLASS__, __FUNCTION__, 
                __LINE__, $registro_uma);
        }
        $uma = (float)$registro_uma['monto'];
    }
}