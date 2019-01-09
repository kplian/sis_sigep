<?php
/**
*@package pXP
*@file gen-MODRequestParam.php
*@author  (admin)
*@date 29-12-2018 13:30:52
*@description Clase que envia los parametros requeridos a la Base de datos para la ejecucion de las funciones, y que recibe la respuesta del resultado de la ejecucion de las mismas
*/

class MODRequestParam extends MODbase{
	
	function __construct(CTParametro $pParam){
		parent::__construct($pParam);
	}
			
	function listarRequestParam(){
		//Definicion de variables para ejecucion del procedimientp
		$this->procedimiento='sigep.ft_request_param_sel';
		$this->transaccion='SIG_REQPAR_SEL';
		$this->tipo_procedimiento='SEL';//tipo de transaccion
				
		//Definicion de la lista del resultado del query
		$this->captura('id_request_param','int4');
		$this->captura('id_sigep_service_request','int4');
		$this->captura('value','text');
		$this->captura('ctype','varchar');
		$this->captura('name','varchar');
		$this->captura('estado_reg','varchar');
		$this->captura('id_usuario_ai','int4');
		$this->captura('fecha_reg','timestamp');
		$this->captura('usuario_ai','varchar');
		$this->captura('id_usuario_reg','int4');
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
			
	function insertarRequestParam(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='sigep.ft_request_param_ime';
		$this->transaccion='SIG_REQPAR_INS';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_sigep_service_request','id_sigep_service_request','int4');
		$this->setParametro('value','value','text');
		$this->setParametro('ctype','ctype','varchar');
		$this->setParametro('name','name','varchar');
		$this->setParametro('estado_reg','estado_reg','varchar');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function modificarRequestParam(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='sigep.ft_request_param_ime';
		$this->transaccion='SIG_REQPAR_MOD';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_request_param','id_request_param','int4');
		$this->setParametro('id_sigep_service_request','id_sigep_service_request','int4');
		$this->setParametro('value','value','text');
		$this->setParametro('ctype','ctype','varchar');
		$this->setParametro('name','name','varchar');
		$this->setParametro('estado_reg','estado_reg','varchar');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function eliminarRequestParam(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='sigep.ft_request_param_ime';
		$this->transaccion='SIG_REQPAR_ELI';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_request_param','id_request_param','int4');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
}
?>