<?php
/**
*@package pXP
*@file gen-ACTServiceRequest.php
*@author  (admin)
*@date 27-12-2018 13:10:13
*@description Clase que recibe los parametros enviados por la vista para mandar a la capa de Modelo
*/

class ACTServiceRequest extends ACTbase{    
			
	function listarServiceRequest(){
		$this->objParam->defecto('ordenacion','id_service_request');
		
		$this->objParam->defecto('dir_ordenacion','asc');
		if($this->objParam->getParametro('tipoReporte')=='excel_grid' || $this->objParam->getParametro('tipoReporte')=='pdf_grid'){
			$this->objReporte = new Reporte($this->objParam,$this);
			$this->res = $this->objReporte->generarReporteListado('MODServiceRequest','listarServiceRequest');
		} else{
			$this->objFunc=$this->create('MODServiceRequest');
			
			$this->res=$this->objFunc->listarServiceRequest($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
				
	function insertarServiceRequest(){
		$this->objFunc=$this->create('MODServiceRequest');	
		$this->res=$this->objFunc->insertarServiceRequest($this->objParam);	
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
	
	function getServiceStatus(){
		$this->objFunc=$this->create('MODServiceRequest');	
		$this->res=$this->objFunc->getServiceStatus($this->objParam);	
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
						
	function eliminarServiceRequest(){
		$this->objFunc=$this->create('MODServiceRequest');	
		$this->res=$this->objFunc->eliminarServiceRequest($this->objParam);
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
			
}

?>