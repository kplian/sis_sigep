<?php
/**
*@package pXP
*@file gen-MODSigepServiceRequest.php
*@author  (admin)
*@date 27-12-2018 12:23:23
*@description Clase que envia los parametros requeridos a la Base de datos para la ejecucion de las funciones, y que recibe la respuesta del resultado de la ejecucion de las mismas
*/

require_once __DIR__ . '/../vendor/autoload.php';


use Jose\Component\Core\AlgorithmManager;
use Jose\Component\Core\Converter\StandardConverter;
use Jose\Component\Core\JWK;
use Jose\Component\Signature\Algorithm\HS256;
use Jose\Component\Signature\Algorithm\RS256;
use Jose\Component\Signature\Algorithm\RS512;
use Jose\Component\Signature\JWSBuilder;
use Jose\Component\Signature\JWSVerifier;
use Jose\Component\KeyManagement\JWKFactory;
use Jose\Component\Signature\Serializer\JWSSerializerManager;
use Jose\Component\Signature\Serializer\JSONFlattenedSerializer;	

class MODSigepServiceRequest extends MODbase{
	private $canceledServices = array();
	function __construct(CTParametro $pParam){
		parent::__construct($pParam);
	}
			
	function listarSigepServiceRequest(){
		//Definicion de variables para ejecucion del procedimientp
		$this->procedimiento='sigep.ft_sigep_service_request_sel';
		$this->transaccion='SIG_SSR_SEL';
		$this->tipo_procedimiento='SEL';//tipo de transaccion
				
		//Definicion de la lista del resultado del query
		$this->captura('id_sigep_service_request','int4');
		$this->captura('id_service_request','int4');
		$this->captura('id_type_sigep_service_request','int4');
		$this->captura('estado_reg','varchar');
		$this->captura('status','varchar');
		$this->captura('date_queue_sent','timestamp');
		$this->captura('date_request_sent','timestamp');
		$this->captura('last_message','text');
		$this->captura('id_usuario_reg','int4');
		$this->captura('usuario_ai','varchar');
		$this->captura('fecha_reg','timestamp');
		$this->captura('id_usuario_ai','int4');
		$this->captura('id_usuario_mod','int4');
		$this->captura('fecha_mod','timestamp');
		$this->captura('usr_reg','varchar');
		$this->captura('usr_mod','varchar');
		
		$this->captura('sigep_service_name','varchar');
		$this->captura('last_message_revert','text');
		$this->captura('user_name','varchar');
		$this->captura('queue_id','varchar');
		$this->captura('queue_revert_id','varchar');
		
		
		
		//Ejecuta la instruccion
		$this->armarConsulta();
		$this->ejecutarConsulta();
		
		//Devuelve la respuesta
		return $this->respuesta;
	}
			
	function procesarServices() {
		$cone = new conexion();
        $link = $cone->conectarpdo();
		$procesando = $this->verificarProcesamiento($link);
		
		if ($procesando == 'no') {
			$sql = "SELECT ssr.id_sigep_service_request,ssr.id_service_request,ssr.status,ssr.user_name,ssr.queue_id, ssr.queue_revert_id,tsr.sigep_url,tsr.method_type,
					tsr.queue_url,tsr.queue_method,tsr.revert_url,tsr.revert_method,tsr.sigep_main_container 
					FROM sigep.tsigep_service_request ssr 
					JOIN sigep.ttype_sigep_service_request tsr ON tsr.id_type_sigep_service_request = ssr.id_type_sigep_service_request
					WHERE ssr.estado_reg = 'activo' AND ssr.status IN ('next_to_execute','pending_queue','next_to_revert','pending_queue_revert')
					ORDER BY ssr.id_service_request ASC, ssr.exec_order ASC";
		    try {
			    foreach ($link->query($sql) as $row) {
			    	$this->procesarService($link,$row);			    	
				}
				$this->modificaProcesamiento($link,'no');
				$this->respuesta=new Mensaje();			
            	$this->respuesta->setMensaje('EXITO',$this->nombre_archivo,'Procesamiento exitoso ','Procesamiento exitoso ','modelo',$this->nombre_archivo,'procesarServices','IME','');
			} catch (Exception $e) {
                $this->modificaProcesamiento($link,'no');	 
                $this->respuesta=new Mensaje();
				$this->respuesta->setMensaje('ERROR',$this->nombre_archivo,$e->getMessage(),$e->getMessage(),'modelo','','','','');
                                
        	}
			return $this->respuesta;    
		} else {
			$this->respuesta=new Mensaje();
			$mensaje = "Existe un proceso activo, no es posible procesar en este momento";
			$this->respuesta->setMensaje('ERROR',$this->nombre_archivo,$mensaje,$mensaje,'modelo','','','','');
			return $this->respuesta; 
		}
	}
	
	function verificarProcesamiento($link) {
		$sql = "SELECT  valor
				FROM pxp.variable_global 
				WHERE variable = 'sigep_processing'";
		
		foreach ($link->query($sql) as $row) {
			$valor = $row['valor'];
		}
		
		if ($valor == 'si') {
			return $valor;
		} else {
			$this->modificaProcesamiento($link,'si');	
			return 'no';
		}
	}
	
	function modificaProcesamiento($link, $valor) {
		$sql = "UPDATE  pxp.variable_global 
				SET valor = '" . $valor . "'
				WHERE variable = 'sigep_processing'";		
		
		$stmt = $link->prepare($sql);          
        $stmt->execute();
	}
	function procesarService($link,$servicio){
		if (!in_array($servicio['id_service_request'], $this->canceledServices)) { //El servicio no fue cancelado
			$accessToken = $this->getToken($link,$servicio['user_name']);						
			if ($accessToken == "0") { //ocurrio un error al generar el acces token
				$this->serviceError($link,$servicio['id_sigep_service_request'],$servicio['id_service_request'],"Error al generar access token para el usuario: ".$servicio['user_name'],'si');
			} else {
				if ($servicio['status'] == 'next_to_execute') {					
					$this->procesarSigep($link,$accessToken,$servicio['status'],$servicio['sigep_url'],$servicio['method_type'],
										$servicio['id_sigep_service_request'],$servicio['id_service_request']);
				} else if ($servicio['status'] == 'pending_queue') {
					$this->procesarSigep($link,$accessToken,$servicio['status'],$servicio['queue_url'],$servicio['queue_method'],
										$servicio['id_sigep_service_request'],$servicio['id_service_request'],$servicio['sigep_main_container']);
				} else if ($servicio['status'] == 'next_to_revert') {
					$this->procesarSigep($link,$accessToken,$servicio['status'],$servicio['revert_url'],$servicio['revert_method'],
										$servicio['id_sigep_service_request'],$servicio['id_service_request']);
					
				} else if ($servicio['status'] == 'pending_queue_revert') {
					$this->procesarSigep($link,$accessToken,$servicio['status'],$servicio['queue_url'],$servicio['queue_method'],
										$servicio['id_sigep_service_request'],$servicio['id_service_request'],$servicio['sigep_main_container']);
				}
			}	    
		}
	}

	function serviceError($link,$id_sigep_service_request,$id_service_request, $error,$fatal) {
			
		$this->resetParametros();	
		
		$this->transaccion = 'SIG_SISERROR_UPD';	
		$this->procedimiento = 'sigep.ft_sigep_service_request_ime';            
        $this->tipo_procedimiento = 'IME';	
		$this->arreglo['id_sigep_service_request'] = $id_sigep_service_request;
		$this->arreglo['error'] = $error;
		$this->arreglo['fatal'] = $fatal;
		
		$this->setParametro('id_sigep_service_request','id_sigep_service_request','integer');
		$this->setParametro('error','error','text');
		$this->setParametro('fatal','fatal','varchar');		
		
		$this->armarConsulta();
		
        $stmt = $link->prepare($this->consulta);          
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC); 
		
		//recupera parametros devuelto depues de insertar ... (id_formula)
        $resp_procedimiento = $this->divRespuesta($result['f_intermediario_ime']);        
        
        $respuesta = $resp_procedimiento['datos'];        
        if ($respuesta['cancelar_servicio'] == 'si') {
        	array_push($this->canceledServices,$id_service_request);	
        }
	}
	
	function procesarSigep ($link, $accessToken, $status, $url, $method, $id_sigep_service_request, $id_service_request, $sigep_container = '') {
		
		$algorithmManager = AlgorithmManager::create([
		    new RS512(),
		]);		
		
		$jwk = JWKFactory::createFromKeyFile(
		    __DIR__ . '/../boa.key', // The filename
		    null,                   // Secret if the key is encrypted
		    [
		        'use' => 'sig',         // Additional parameters
		        'kid' => 'boaws'
		    ]
		);
		 
		$jsonConverter = new StandardConverter();
		
		// We instantiate our JWS Builder.
		$jwsBuilder = new JWSBuilder(
		    $jsonConverter,
		    $algorithmManager
		);
		//obtener parametros
		$params = $this->getInputParams($link, $id_sigep_service_request,$status);
		
		$curl = curl_init();
		
		$curl_array = array(
	        CURLOPT_URL => $url,
	        CURLOPT_RETURNTRANSFER => true,
	        CURLOPT_ENCODING => "",
	        CURLOPT_MAXREDIRS => 10,
	        CURLOPT_TIMEOUT => 30,
	        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	        CURLOPT_CUSTOMREQUEST => $method,
	        CURLOPT_HTTPHEADER => array(
	            "authorization: bearer " . $accessToken,
	            "cache-control: no-cache"
	        )
	    );
		// The payload we want to sign. The payload MUST be a string hence we use our JSON Converter.
		if ($method != 'GET') {			
			$payload = $jsonConverter->encode($params);
			$jws = $jwsBuilder
			    ->create()                               // We want to create a new JWS
			    ->withPayload($payload)                  // We set the payload
			    ->addSignature($jwk, ['alg' => 'RS512'],['kid' => 'boaws']) // We add a signature with a simple protected header
			    ->build();
				
			$serializer = new JSONFlattenedSerializer($jsonConverter); // The serializer
			$token = $serializer->serialize($jws, 0); // We serialize the signature at index 0 (we only have one signature).
			$curl_array[CURLOPT_POSTFIELDS] =  $token;
			array_push($curl_array[CURLOPT_HTTPHEADER],"content-type: application/json");
			
		} else {
			if ($status == "pending_queue" || $status == 'pending_queue_revert') {
				$curl_array[CURLOPT_URL] =  $url . "/" . $params;
				
			} else {
				$curl_array[CURLOPT_URL] =  $url . "?" . http_build_query($params);
			}
			
		}
		
		curl_setopt_array($curl,$curl_array);
	    $response = curl_exec($curl);
		
	    $err = curl_error($curl);
	
	    curl_close($curl);
		
	    if ($err) {	    	
	        $this->serviceError($link,$id_sigep_service_request,$id_service_request,"Error al ejecutar curl en sigep para status : $status ,archivo:MODSigepServiceRequest,  funcion: procesarSigep ",'si');
	    } else {
	        //DESSERIALIZAR MENSAJE
	        
	        // The algorithm manager with the HS256 algorithm.
	        $algorithmManager = AlgorithmManager::create([
	            new RS512()
	        ]);
	
	        // We instantiate our JWS Verifier.
	        $jwsVerifier = new JWSVerifier(
	            $algorithmManager
	        );
	        $jwk = JWKFactory::createFromKeyFile(
	            __DIR__ . '/../boa.key', // The filename
	            null
	        );
	
	        // The JSON Converter.
	        $jsonConverter = new StandardConverter();	        
	        $token = $response;
			
	        $serializer = new JSONFlattenedSerializer($jsonConverter);	
					
	        // We try to load the token.
	        try {
	        	$jws = $serializer->unserialize($token);
				$resObj = json_decode($jws->getPayload(), true);
				
				if (isset($resObj['data']['errores'])) {
					$this->serviceError($link,$id_sigep_service_request,$id_service_request,"CODIGO:".$resObj['data']['errores']['codigo'].", ACCION: ".$resObj['data']['errores']['accion'].",CAUSA:".$resObj['data']['errores']['causa'].",MENSAJE:".$resObj['data']['errores']['mensaje'],'no');
				} else {					
					$this->registrarProcesoExitoso($link,$id_sigep_service_request,($sigep_container == '' ? $resObj['data']:$resObj['data'][$sigep_container]),$id_service_request);	
				}		
				
	        } catch (Exception $e) {
	        	$this->serviceError($link,$id_sigep_service_request,$id_service_request,"Error al desserializar respuesta : ". $token,'si');
	        }
		}
	}

	function registrarProcesoExitoso($link,$id_sigep_service_request,$resObj,$id_service_request) {
		$names = "";
		$values = "";	
		foreach($resObj as $key => $value)
		{
			$names .= $key."||";
			$values .= $value . "||";
		}
		$names = substr($names, 0, -2);
		$values = substr($values, 0, -2);
		$this->resetParametros();	
		$this->transaccion = 'SIG_SISSUCC_UPD';	
		$this->procedimiento = 'sigep.ft_sigep_service_request_ime';            
        $this->tipo_procedimiento = 'IME';	
		$this->arreglo['id_sigep_service_request'] = $id_sigep_service_request;
		$this->arreglo['names_output'] = $names;
		$this->arreglo['values_output'] = $values;		
		$this->setParametro('id_sigep_service_request','id_sigep_service_request','integer');
		$this->setParametro('names_output','names_output','text');
		$this->setParametro('values_output','values_output','text');
				
		$this->armarConsulta();
        $stmt = $link->prepare($this->consulta);
        
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC); 
		
		$resp_procedimiento = $this->divRespuesta($result['f_intermediario_ime']);
        if ($resp_procedimiento['tipo_respuesta']=='ERROR') {        	
            $this->serviceError($link,$id_sigep_service_request,$id_service_request,"Error al llamar a la transaccion : SIG_SISSUCC_UPD ,en archivo:MODSigepServiceRequest,  funcion: registrarProcesoExitoso ",'si');
        }
		
	} 

	function getInputParams($link, $id_sigep_service_request,$status) {
			
		if ($status == "next_to_execute" || $status == 'next_to_revert') {
			$res = array();
			$input_output =($status == 'next_to_execute') ? "input" : "revert";	
			$sql = "SELECT  name, value,ctype
					FROM sigep.trequest_param
					WHERE input_output = '$input_output' and id_sigep_service_request = $id_sigep_service_request";
			
			foreach ($link->query($sql) as $row) {
				if ($row['value'] == 'NULL') {
					$res[$row['name']] = NULL;
				} else if ($row['ctype'] == 'NUMERIC') {
					$res[$row['name']] = (float)$row['value'];
				} else if ($row['ctype'] == 'INTEGER') {
					$res[$row['name']] = (int)$row['value'];
				} else {
					$res[$row['name']] = $row['value'];
				}
			}
			return $res;
			
		} else if ($status == "pending_queue" || $status == 'pending_queue_revert') {
			$queue_field = ($status == 'pending_queue') ? "queue_id" : "queue_revert_id";
			$sql = "SELECT   $queue_field as value
					FROM sigep.tsigep_service_request
					WHERE id_sigep_service_request = $id_sigep_service_request";
				
			foreach ($link->query($sql) as $row) {
				$res = $row['value'];
			}
			return $res;
		}	
		
	}
	
	function getToken($link,$username) {
		$sql = "SELECT  um.refresh_token,um.access_token,
				(um.date_issued_at + (um.expires_in - 100) * interval '1 second') < now() as expired
				FROM sigep.tuser_mapping um 
				WHERE estado_reg = 'activo' AND lower(pxp_user) = lower('" . $username . "')";
				
		
		foreach ($link->query($sql) as $row) {
			if ($row['expired']) {
				/*************************************************
				 *
				 *
				 * OBTENER ACCESS TOKEN
				 *
				 **************************************************/
				
				
				$curl = curl_init();
				
				curl_setopt_array($curl, array(
				    CURLOPT_URL => "http://sigeppre-wl12.sigma.gob.bo/rsseguridad/apiseg/token?grant_type=refresh_token&client_id=0&redirect_uri=%2Fmodulo%2Fapiseg%2Fredirect&client_secret=0&refresh_token=". $row['refresh_token'],
				    CURLOPT_RETURNTRANSFER => true,
				    CURLOPT_ENCODING => "",				    
				    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				    CURLOPT_CUSTOMREQUEST => "POST",
				    CURLOPT_HTTPHEADER => array(
				        "cache-control: no-cache",
				        "content-type: application/x-www-form-urlencoded"
				    ),
				));
				
				$response = curl_exec($curl);
				$err = curl_error($curl);
				
				curl_close($curl);
	
				if ($err) {
				    return "0";
				} else {					
					if ($this->isJson($response)) {
						$token_response = json_decode($response);
						
						$sql = "UPDATE  sigep.tuser_mapping
								SET access_token = '" . $token_response->{'access_token'} . "',
								date_issued_at = now(),
								expires_in = " . $token_response->{'expires_in'} . "
								WHERE estado_reg = 'activo' AND lower(pxp_user) = lower('" . $username . "')";	
						
						$stmt = $link->prepare($sql);          
				        $stmt->execute();
						
				    	return $token_response->{'access_token'};
					} else {
						return "0";
					}			    
				}
			} else {				
				return $row['access_token'];
			}   
		}
		return "0";
	}

	function isJson($string) {
	 	json_decode($string);
	 	return (json_last_error() == JSON_ERROR_NONE);
	}
			
}
?>