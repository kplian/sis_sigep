<?php
/**
*@package pXP
*@file gen-MODParam.php
*@author  (admin)
*@date 29-11-2018 04:35:55
*@description Clase que envia los parametros requeridos a la Base de datos para la ejecucion de las funciones, y que recibe la respuesta del resultado de la ejecucion de las mismas
*/

class MODParam extends MODbase{
	
	function __construct(CTParametro $pParam){
		parent::__construct($pParam);
	}
			
	function listarParam(){
		//Definicion de variables para ejecucion del procedimientp
		$this->procedimiento='sigep.ft_param_sel';
		$this->transaccion='SIG_PARA_SEL';
		$this->tipo_procedimiento='SEL';//tipo de transaccion
				
		//Definicion de la lista del resultado del query
		$this->captura('id_param','int4');
		$this->captura('id_type_sigep_service_request','int4');
		$this->captura('ctype','varchar');
		$this->captura('estado_reg','varchar');
		$this->captura('erp_json_container','varchar');
		$this->captura('sigep_name','varchar');
		$this->captura('erp_name','varchar');
		$this->captura('id_usuario_reg','int4');
		$this->captura('fecha_reg','timestamp');
		$this->captura('usuario_ai','varchar');
		$this->captura('id_usuario_ai','int4');
		$this->captura('fecha_mod','timestamp');
		$this->captura('id_usuario_mod','int4');
		$this->captura('usr_reg','varchar');
		$this->captura('usr_mod','varchar');
		$this->captura('input_output','varchar');
		$this->captura('def_value','varchar');
		
		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();
		
		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function insertarParam(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='sigep.ft_param_ime';
		$this->transaccion='SIG_PARA_INS';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_type_sigep_service_request','id_type_sigep_service_request','int4');
		$this->setParametro('ctype','ctype','varchar');
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('erp_json_container','erp_json_container','varchar');
		$this->setParametro('sigep_name','sigep_name','varchar');
		$this->setParametro('erp_name','erp_name','varchar');
		$this->setParametro('input_output','input_output','varchar');
		$this->setParametro('def_value','def_value','varchar');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function modificarParam(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='sigep.ft_param_ime';
		$this->transaccion='SIG_PARA_MOD';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_param','id_param','int4');
		$this->setParametro('id_type_sigep_service_request','id_type_sigep_service_request','int4');
		$this->setParametro('ctype','ctype','varchar');
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('erp_json_container','erp_json_container','varchar');
		$this->setParametro('sigep_name','sigep_name','varchar');
		$this->setParametro('erp_name','erp_name','varchar');
		$this->setParametro('input_output','input_output','varchar');
		$this->setParametro('def_value','def_value','varchar');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function eliminarParam(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='sigep.ft_param_ime';
		$this->transaccion='SIG_PARA_ELI';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_param','id_param','int4');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
}
?>