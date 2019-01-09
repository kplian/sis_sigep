<?php
/**
*@package pXP
*@file gen-MODUserMapping.php
*@author  (admin)
*@date 08-04-2018 11:04:46
*@description Clase que envia los parametros requeridos a la Base de datos para la ejecucion de las funciones, y que recibe la respuesta del resultado de la ejecucion de las mismas
*/

class MODUserMapping extends MODbase{
	
	function __construct(CTParametro $pParam){
		parent::__construct($pParam);
	}
			
	function listarUserMapping(){
		//Definicion de variables para ejecucion del procedimientp
		$this->procedimiento='sigep.ft_user_mapping_sel';
		$this->transaccion='SIG_USM_SEL';
		$this->tipo_procedimiento='SEL';//tipo de transaccion
				
		//Definicion de la lista del resultado del query
		$this->captura('id_user_mapping','int4');
		$this->captura('refresh_token','varchar');
		$this->captura('sigep_user','varchar');
		$this->captura('access_token','varchar');
		$this->captura('date_issued_at','timestamp');
		$this->captura('expires_in','int4');
		$this->captura('estado_reg','varchar');
		$this->captura('date_issued_rt','timestamp');
		$this->captura('pxp_user','varchar');
		$this->captura('id_usuario_ai','int4');
		$this->captura('id_usuario_reg','int4');
		$this->captura('fecha_reg','timestamp');
		$this->captura('usuario_ai','varchar');
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
			
	function insertarUserMapping(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='sigep.ft_user_mapping_ime';
		$this->transaccion='SIG_USM_INS';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		
		$this->setParametro('sigep_user','sigep_user','varchar');		
		$this->setParametro('pxp_user','pxp_user','varchar');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function modificarUserMapping(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='sigep.ft_user_mapping_ime';
		$this->transaccion='SIG_USM_MOD';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_user_mapping','id_user_mapping','int4');		
		$this->setParametro('sigep_user','sigep_user','varchar');		
		$this->setParametro('pxp_user','pxp_user','varchar');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function eliminarUserMapping(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='sigep.ft_user_mapping_ime';
		$this->transaccion='SIG_USM_ELI';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_user_mapping','id_user_mapping','int4');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
	
	function initRefreshToken(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='sigep.ft_user_mapping_ime';
		$this->transaccion='SIG_INITOK_MOD';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('access_token','access_token','varchar');
		$this->setParametro('refresh_token','refresh_token','varchar');
		$this->setParametro('expires_in','expires_in','int4');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
}
?>