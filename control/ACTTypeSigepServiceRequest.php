<?php
/**
*@package pXP
*@file gen-ACTTypeSigepServiceRequest.php
*@author  (admin)
*@date 30-11-2018 15:13:43
*@description Clase que recibe los parametros enviados por la vista para mandar a la capa de Modelo
*/

class ACTTypeSigepServiceRequest extends ACTbase{    
			
	function listarTypeSigepServiceRequest(){
		$this->objParam->defecto('ordenacion','id_type_sigep_service_request');
		if ($this->objParam->getParametro('id_type_service_request') != '') {
			$this->objParam->addFiltro("tssr.id_type_service_request = ". $this->objParam->getParametro('id_type_service_request'));
		}
		$this->objParam->defecto('dir_ordenacion','asc');
		if($this->objParam->getParametro('tipoReporte')=='excel_grid' || $this->objParam->getParametro('tipoReporte')=='pdf_grid'){
			$this->objReporte = new Reporte($this->objParam,$this);
			$this->res = $this->objReporte->generarReporteListado('MODTypeSigepServiceRequest','listarTypeSigepServiceRequest');
		} else{
			$this->objFunc=$this->create('MODTypeSigepServiceRequest');
			
			$this->res=$this->objFunc->listarTypeSigepServiceRequest($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
				
	function insertarTypeSigepServiceRequest(){
		$this->objFunc=$this->create('MODTypeSigepServiceRequest');	
		if($this->objParam->insertar('id_type_sigep_service_request')){
			$this->res=$this->objFunc->insertarTypeSigepServiceRequest($this->objParam);			
		} else{			
			$this->res=$this->objFunc->modificarTypeSigepServiceRequest($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
						
	function eliminarTypeSigepServiceRequest(){
			$this->objFunc=$this->create('MODTypeSigepServiceRequest');	
		$this->res=$this->objFunc->eliminarTypeSigepServiceRequest($this->objParam);
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
			
}

?>