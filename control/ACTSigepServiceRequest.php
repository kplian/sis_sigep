<?php
/**
*@package pXP
*@file gen-ACTSigepServiceRequest.php
*@author  (admin)
*@date 27-12-2018 12:23:23
*@description Clase que recibe los parametros enviados por la vista para mandar a la capa de Modelo
*/

class ACTSigepServiceRequest extends ACTbase{    
			
	function listarSigepServiceRequest(){
		$this->objParam->defecto('ordenacion','id_sigep_service_request');
		if ($this->objParam->getParametro('id_service_request') != '') {
			$this->objParam->addFiltro("ssr.id_service_request = ". $this->objParam->getParametro('id_service_request'));
		}
		$this->objParam->defecto('dir_ordenacion','asc');
		if($this->objParam->getParametro('tipoReporte')=='excel_grid' || $this->objParam->getParametro('tipoReporte')=='pdf_grid'){
			$this->objReporte = new Reporte($this->objParam,$this);
			$this->res = $this->objReporte->generarReporteListado('MODSigepServiceRequest','listarSigepServiceRequest');
		} else{
			$this->objFunc=$this->create('MODSigepServiceRequest');
			
			$this->res=$this->objFunc->listarSigepServiceRequest($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}				
	function procesarServices(){
		$this->objFunc=$this->create('MODSigepServiceRequest');	
		$this->res=$this->objFunc->procesarServices($this->objParam);
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
			
}

?>