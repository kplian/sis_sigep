<?php
/**
*@package pXP
*@file gen-MODTypeServiceRequest.php
*@author  (admin)
*@date 29-11-2018 04:31:24
*@description Clase que envia los parametros requeridos a la Base de datos para la ejecucion de las funciones, y que recibe la respuesta del resultado de la ejecucion de las mismas
*/

class MODTypeServiceRequest extends MODbase{
	
	function __construct(CTParametro $pParam){
		parent::__construct($pParam);
	}
			
	function listarTypeServiceRequest(){
		//Definicion de variables para ejecucion del procedimientp
		$this->procedimiento='sigep.ft_type_service_request_sel';
		$this->transaccion='SIG_TSR_SEL';
		$this->tipo_procedimiento='SEL';//tipo de transaccion
				
		//Definicion de la lista del resultado del query
		$this->captura('id_type_service_request','int4');
		$this->captura('estado_reg','varchar');
		$this->captura('description','text');
		$this->captura('service_code','varchar');
		$this->captura('id_usuario_reg','int4');
		$this->captura('fecha_reg','timestamp');
		$this->captura('usuario_ai','varchar');
		$this->captura('id_usuario_ai','int4');
		$this->captura('id_usuario_mod','int4');
		$this->captura('fecha_mod','timestamp');
		$this->captura('usr_reg','varchar');
		$this->captura('usr_mod','varchar');
		
		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();
		
		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function insertarTypeServiceRequest(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='sigep.ft_type_service_request_ime';
		$this->transaccion='SIG_TSR_INS';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('description','description','text');
		$this->setParametro('service_code','service_code','varchar');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function modificarTypeServiceRequest(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='sigep.ft_type_service_request_ime';
		$this->transaccion='SIG_TSR_MOD';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_type_service_request','id_type_service_request','int4');
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('description','description','text');
		$this->setParametro('service_code','service_code','varchar');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function eliminarTypeServiceRequest(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='sigep.ft_type_service_request_ime';
		$this->transaccion='SIG_TSR_ELI';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_type_service_request','id_type_service_request','int4');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
}
?>