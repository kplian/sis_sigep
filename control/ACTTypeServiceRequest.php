<?php
/**
*@package pXP
*@file gen-ACTTypeServiceRequest.php
*@author  (admin)
*@date 29-11-2018 04:31:24
*@description Clase que recibe los parametros enviados por la vista para mandar a la capa de Modelo
*/

class ACTTypeServiceRequest extends ACTbase{    
			
	function listarTypeServiceRequest(){
		$this->objParam->defecto('ordenacion','id_type_service_request');

		$this->objParam->defecto('dir_ordenacion','asc');
		if($this->objParam->getParametro('tipoReporte')=='excel_grid' || $this->objParam->getParametro('tipoReporte')=='pdf_grid'){
			$this->objReporte = new Reporte($this->objParam,$this);
			$this->res = $this->objReporte->generarReporteListado('MODTypeServiceRequest','listarTypeServiceRequest');
		} else{
			$this->objFunc=$this->create('MODTypeServiceRequest');
			
			$this->res=$this->objFunc->listarTypeServiceRequest($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
				
	function insertarTypeServiceRequest(){
		$this->objFunc=$this->create('MODTypeServiceRequest');	
		if($this->objParam->insertar('id_type_service_request')){
			$this->res=$this->objFunc->insertarTypeServiceRequest($this->objParam);			
		} else{			
			$this->res=$this->objFunc->modificarTypeServiceRequest($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
						
	function eliminarTypeServiceRequest(){
			$this->objFunc=$this->create('MODTypeServiceRequest');	
		$this->res=$this->objFunc->eliminarTypeServiceRequest($this->objParam);
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
			
}

?>