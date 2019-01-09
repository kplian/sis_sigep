<?php
/**
*@package pXP
*@file gen-MODServiceRequest.php
*@author  (admin)
*@date 27-12-2018 13:10:13
*@description Clase que envia los parametros requeridos a la Base de datos para la ejecucion de las funciones, y que recibe la respuesta del resultado de la ejecucion de las mismas
*/

class MODServiceRequest extends MODbase{
	
	function __construct(CTParametro $pParam){
		parent::__construct($pParam);
	}
			
	function listarServiceRequest(){
		//Definicion de variables para ejecucion del procedimientp
		$this->procedimiento='sigep.ft_service_request_sel';
		$this->transaccion='SIG_SERE_SEL';
		$this->tipo_procedimiento='SEL';//tipo de transaccion
				
		//Definicion de la lista del resultado del query
		$this->captura('id_service_request','int4');
		$this->captura('id_type_service_request','int4');
		$this->captura('estado_reg','varchar');
		$this->captura('date_finished','timestamp');
		$this->captura('status','varchar');
		$this->captura('sys_origin','varchar');
		$this->captura('ip_origin','varchar');
		$this->captura('last_message','text');
		$this->captura('usuario_ai','varchar');
		$this->captura('fecha_reg','timestamp');
		$this->captura('id_usuario_reg','int4');
		$this->captura('id_usuario_ai','int4');
		$this->captura('id_usuario_mod','int4');
		$this->captura('fecha_mod','timestamp');
		$this->captura('usr_reg','varchar');
		$this->captura('usr_mod','varchar');
		$this->captura('service_code','varchar');
		$this->captura('description','text');
		$this->captura('last_message_revert','text');
		
		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();
		
		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function insertarServiceRequest(){
		$cone = new conexion();
        $link = $cone->conectarpdo();
                   
        try {
            $link->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);     
            $jsonOb = $this->aParam->_json_decode($this->aParam->getParametro('json'));
			
            $link->beginTransaction();	
			$this->transaccion = 'SIG_SERE_INS';	
			$this->procedimiento = 'sigep.ft_service_request_ime';            
            $this->tipo_procedimiento = 'IME';	
			$this->arreglo['ip_origin'] = $_SERVER['REMOTE_ADDR'];
			$this->setParametro('service_code','service_code','varchar');
			$this->setParametro('ip_origin','ip_origin','varchar');
			$this->setParametro('sys_origin','sys_origin','varchar');
			
			$this->armarConsulta();
            $stmt = $link->prepare($this->consulta);          
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);               
            
            //recupera parametros devuelto depues de insertar ... (id_formula)
            $resp_procedimiento = $this->divRespuesta($result['f_intermediario_ime']);
            if ($resp_procedimiento['tipo_respuesta']=='ERROR') {
                throw new Exception("Error al ejecutar en la bd", 3);
            }
            
            $respuesta = $resp_procedimiento['datos'];
            
            $id_service_request = $respuesta['id_service_request'];
			
			$this->insertaSigepServices($link,$id_service_request,$this->aParam->getParametro('service_code'),$jsonOb);
			$link->commit();
            $this->respuesta=new Mensaje();			
            $this->respuesta->setMensaje('EXITO',$this->nombre_archivo,'Insercion ',$resp_procedimiento['mensaje_tec'],'modelo',$this->nombre_archivo,'insertarServiceRequest','IME',$this->consulta);
            $this->respuesta->setDatos($respuesta);
		} catch (Exception $e) {          
                $link->rollBack();
                $this->respuesta=new Mensaje();
                if ($e->getCode() == 2) {//es un error en bd de una consulta
                    $this->respuesta->setMensaje('ERROR',$this->nombre_archivo,$e->getMessage(),$e->getMessage(),'modelo','','','','');
                } else if ($e->getCode() == 2) {//es un error en bd de una consulta
                    $this->respuesta->setMensaje('ERROR',$this->nombre_archivo,$e->getMessage(),$e->getMessage(),'modelo','','','','');
                } else {//es un error lanzado con throw exception
                    throw new Exception($e->getMessage(), 2);
                }
                
        }    
        
        return $this->respuesta;
	}
	
	function insertaSigepServices($link,$id_service_request,$service_code,$json_obj) {
		$sql = "SELECT id_type_sigep_service_request, exec_order, json_main_container, user_param 
				FROM sigep.ttype_sigep_service_request ssr 
				JOIN sigep.ttype_service_request sr ON sr.id_type_service_request = ssr.id_type_service_request 
				WHERE ssr.estado_reg = 'activo' AND sr.service_code ='" . $service_code ."'
				ORDER BY exec_order";
	    
	    foreach ($link->query($sql) as $row) {
	    	if ($row['json_main_container']) { 
	        	foreach ($json_obj[$row['json_main_container']] as $detail) {
	        		$id_sigep_service_request = $this->insertaSigepServiceRequest($link,$id_service_request,$row['id_type_sigep_service_request'],$json_obj[$row['user_param']],$row['exec_order']);
					$this->insertaParams($link,$id_sigep_service_request,$row['id_type_sigep_service_request'],$json_obj,$detail);
	        	}	
			} else {
				$id_sigep_service_request = $this->insertaSigepServiceRequest($link,$id_service_request,$row['id_type_sigep_service_request'],$json_obj[$row['user_param']],$row['exec_order']);
				$this->insertaParams($link,$id_sigep_service_request,$row['id_type_sigep_service_request'],$json_obj);
			}
		}
		
		
	}
	
	function insertaSigepServiceRequest($link,$id_service_request,$id_type_sigep_service_request,$user,$exec_order) {
		$this->resetParametros();	
		$this->transaccion = 'SIG_SISERE_INS';	
		$this->procedimiento = 'sigep.ft_sigep_service_request_ime';            
        $this->tipo_procedimiento = 'IME';	
		$this->arreglo['id_service_request'] = $id_service_request;
		$this->arreglo['id_type_sigep_service_request'] = $id_type_sigep_service_request;
		$this->arreglo['user_name'] = $user;
		
		$this->arreglo['exec_order'] = $exec_order;
		if ($exec_order == 1 ) {
			$this->arreglo['status'] = "next_to_execute";
		} else {
			$this->arreglo['status'] = "pending";
		}
		$this->setParametro('id_service_request','id_service_request','integer');
		$this->setParametro('id_type_sigep_service_request','id_type_sigep_service_request','integer');
		$this->setParametro('user_name','user_name','varchar');
		$this->setParametro('exec_order','exec_order','integer');
		$this->setParametro('status','status','varchar');
		
		
		$this->armarConsulta();
        $stmt = $link->prepare($this->consulta);          
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);               
        
        //recupera parametros devuelto depues de insertar ... (id_formula)
        $resp_procedimiento = $this->divRespuesta($result['f_intermediario_ime']);
        if ($resp_procedimiento['tipo_respuesta']=='ERROR') {
            throw new Exception("Error al ejecutar en la bd", 3);
        }
        
        $respuesta = $resp_procedimiento['datos'];        
        return $respuesta['id_sigep_service_request'];	
	}

	function insertaParams($link,$id_sigep_service_request,$id_type_sigep_service_request,$json_obj,$detail="") {
		$sql = "SELECT id_type_sigep_service_request, sigep_name, erp_name, erp_json_container,ctype, input_output, def_value 
				FROM sigep.tparam par
				WHERE estado_reg = 'activo' AND par.input_output IN ('input','revert') 
				AND par.id_type_sigep_service_request = " . $id_type_sigep_service_request ."
				AND (erp_name IS NOT NULL OR def_value IS NOT NULL)
				ORDER BY id_param";
		
		$this->transaccion = 'SIG_REQPAR_INS';	
		$this->procedimiento = 'sigep.ft_request_param_ime';            
        $this->tipo_procedimiento = 'IME';		
		foreach ($link->query($sql) as $row) {
			
			$this->resetParametros();
			$this->arreglo['id_sigep_service_request'] = $id_sigep_service_request;
			$this->arreglo['name'] = $row['sigep_name'];
			
			if ($row['def_value'] != '' && $row['erp_name'] == '') {
				$this->arreglo['value'] = $row['def_value'];
			} else if ($row['erp_json_container'] != '') {
				$this->arreglo['value'] = $detail[$row['erp_name']];
			} else {
				$this->arreglo['value'] = $json_obj[$row['erp_name']];
			}
			
			$this->arreglo['ctype'] = $row['ctype'];
			$this->arreglo['input_output'] = $row['input_output'];
			
			$this->setParametro('id_sigep_service_request','id_sigep_service_request','integer');
			$this->setParametro('name','name','varchar');
			$this->setParametro('value','value','text');
			$this->setParametro('ctype','ctype','varchar');
			$this->setParametro('input_output','input_output','varchar');
			
			$this->armarConsulta();
	        $stmt = $link->prepare($this->consulta);          
	        $stmt->execute();	        	    	
		}
	} 
			
	function modificarServiceRequest(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='sigep.ft_service_request_ime';
		$this->transaccion='SIG_SERE_MOD';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_service_request','id_service_request','int4');
		$this->setParametro('id_type_service_request','id_type_service_request','int4');
		$this->setParametro('estado_reg','estado_reg','varchar');
		$this->setParametro('date_finished','date_finished','timestamp');
		$this->setParametro('status','status','varchar');
		$this->setParametro('sys_origin','sys_origin','varchar');
		$this->setParametro('ip_origin','ip_origin','varchar');
		$this->setParametro('last_message','last_message','text');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function eliminarServiceRequest(){
		//Definicion de variables para ejecucion del procedimiento
		$this->procedimiento='sigep.ft_service_request_ime';
		$this->transaccion='SIG_SERE_ELI';
		$this->tipo_procedimiento='IME';
				
		//Define los parametros para la funcion
		$this->setParametro('id_service_request','id_service_request','int4');

		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();

		//Devuelve la respuesta
		return $this->respuesta;
	}

	function getServiceStatus(){
		$cone = new conexion();
        $link = $cone->conectarpdo();
		$objRes = array();
		
		$sql = "SELECT id_service_request, status, last_message, last_message_revert 
				FROM sigep.tservice_request sr 
				WHERE sr.id_service_request = " . $this->arreglo['id_service_request'] ;
		
		foreach ($link->query($sql) as $row) {
			$objRes['status'] = $row['status'];
			if ($row['status'] == 'success'){
				$objRes['output'] = $this->getOutParams($link,$this->arreglo['id_service_request']);
			} else {
				$objRes['last_message'] = $row['last_message'];
				$objRes['last_message_revert'] = $row['last_message_revert'];
			}
		}
		//Devuelve la respuesta
		$this->respuesta=new Mensaje();			
        $this->respuesta->setMensaje('EXITO',$this->nombre_archivo,'getServiceStatus ','getServiceStatus','modelo',$this->nombre_archivo,'getServiceStatus','IME','');
        $this->respuesta->setDatos($objRes);
		return $this->respuesta;
	}
	
	function getInputParams($link, $id_service_request) {
		$res = array();
		$sql = "SELECT  rp.name, rp.value, rp.ctype, ssr.id_sigep_service_request,tssr.id_type_sigep_service_request, tssr.json_main_container
				FROM sigep.tsigep_service_request ssr
				JOIN sigep.ttype_sigep_service_request tssr ON tssr.id_type_sigep_service_request = ssr.id_type_sigep_service_request
				JOIN sitep.trequest_param rp ON rp.id_sigep_service_request
				WHERE input_output = 'output' and id_service_request = $id_service_request
				ORDER BY tssr.json_main_container,ssr.id_sigep_service_request";
		$id_sigep_service_request = "";
		$json_main_container = "";
		foreach ($link->query($sql) as $row) {
			if (!empty($row['json_main_container']) && $row['json_main_container'] != $json_main_container) {
				$res[$row['json_main_container']] = array();
				$json_main_container = 	$row['json_main_container'];			
			}
			if ($id_sigep_service_request != $row['id_sigep_service_request']) {
				if (!empty($row['json_main_container'])) {
					array_push($res[$row['json_main_container']],array());
				}
				$id_sigep_service_request = $row['id_sigep_service_request'];
			}
			
			if (!empty($row['json_main_container'])) {
				$res[$row['json_main_container']][count($res[$row['json_main_container']])-1][$row['name']] = $row['value'];
			} else {
				$res[$row['name']] = $row['value'];
			}
		}
		return $res;
		
	}
			
}
?>