<?php
/**
*@package pXP
*@file gen-MODTypeSigepServiceRequest.php
*@author  (admin)
*@date 30-11-2018 15:13:43
*@description Clase que envia los parametros requeridos a la Base de datos para la ejecucion de las funciones, y que recibe la respuesta del resultado de la ejecucion de las mismas
*/

class MODTypeSigepServiceRequest extends MODbase{
	
	function __construct(CTParametro $pParam){
		parent::__construct($pParam);
	}
			
	function listarTypeSigepServiceRequest(){
		//Definicion de variables para ejecucion del procedimientp
		$this->procedimiento='sigep.ft_type_sigep_service_request_sel';
		$this->transaccion='SIG_TSSR_SEL';
		$this->tipo_procedimiento='SEL';//tipo de transaccion
				
		//Definicion de la lista del resultado del query
		$this->captura('id_type_sigep_service_request','int4');
		$this->captura('id_type_service_request','int4');
		$this->captura('exec_order','int4');
		$this->captura('queue_method','varchar');
		$this->captura('estado_reg','varchar');
		$this->captura('time_to_refresh','int4');
		$this->captura('queue_url','varchar');
		$this->captura('method_type','varchar');
		$this->captura('sigep_service_name','varchar');
		$this->captura('sigep_url','varchar');
		$this->captura('usuario_ai','varchar');
		$this->captura('fecha_reg','timestamp');
		$this->captura('id_usuario_reg','int4');
		$this->captura('id_usuario_ai','int4');
		$this->captura('fecha_mod','timestamp');
		$this->captura('id_usuario_mod','int4');
		$this->captura('usr_reg','varchar');
		$this->captura('usr_mod','varchar');
		$this->captura('revert_url','varchar');
		$this->captura('revert_method','varchar');
		$this->captura('user_param','varchar');
		$this->captura('json_main_container','varchar');
		
		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();
		
		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function insertarTypeSigepServiceRequest(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='sigep.ft_type_sigep_service_request_ime';
		$this->transaccion='SIG_TSSR_INS';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_type_service_request','id_type_service_request','int4');
		$this->setParametro('exec_order','exec_order','int4');
		$this->setParametro('queue_method','queue_method','varchar');
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('time_to_refresh','time_to_refresh','int4');
		$this->setParametro('queue_url','queue_url','varchar');
		$this->setParametro('method_type','method_type','varchar');
		$this->setParametro('sigep_service_name','sigep_service_name','varchar');
		$this->setParametro('sigep_url','sigep_url','varchar');
		$this->setParametro('revert_url','revert_url','varchar');		
		$this->setParametro('revert_method','revert_method','varchar');
		$this->setParametro('user_param','user_param','varchar');		
		$this->setParametro('json_main_container','json_main_container','varchar');
		

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function modificarTypeSigepServiceRequest(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='sigep.ft_type_sigep_service_request_ime';
		$this->transaccion='SIG_TSSR_MOD';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_type_sigep_service_request','id_type_sigep_service_request','int4');
		$this->setParametro('id_type_service_request','id_type_service_request','int4');
		$this->setParametro('exec_order','exec_order','int4');
		$this->setParametro('queue_method','queue_method','varchar');
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('time_to_refresh','time_to_refresh','int4');
		$this->setParametro('queue_url','queue_url','varchar');
		$this->setParametro('method_type','method_type','varchar');
		$this->setParametro('sigep_service_name','sigep_service_name','varchar');
		$this->setParametro('sigep_url','sigep_url','varchar');
		$this->setParametro('revert_url','revert_url','varchar');		
		$this->setParametro('revert_method','revert_method','varchar');
		$this->setParametro('user_param','user_param','varchar');		
		$this->setParametro('json_main_container','json_main_container','varchar');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function eliminarTypeSigepServiceRequest(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='sigep.ft_type_sigep_service_request_ime';
		$this->transaccion='SIG_TSSR_ELI';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_type_sigep_service_request','id_type_sigep_service_request','int4');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
}
?>