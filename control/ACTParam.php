<?php
/**
*@package pXP
*@file gen-ACTParam.php
*@author  (admin)
*@date 29-11-2018 04:35:55
*@description Clase que recibe los parametros enviados por la vista para mandar a la capa de Modelo
*/

class ACTParam extends ACTbase{    
			 
	function listarParam(){
		$this->objParam->defecto('ordenacion','id_param');
		if ($this->objParam->getParametro('id_type_sigep_service_request') != '') {
			$this->objParam->addFiltro("para.id_type_sigep_service_request = ". $this->objParam->getParametro('id_type_sigep_service_request'));
		}
		$this->objParam->defecto('dir_ordenacion','asc');
		if($this->objParam->getParametro('tipoReporte')=='excel_grid' || $this->objParam->getParametro('tipoReporte')=='pdf_grid'){
			$this->objReporte = new Reporte($this->objParam,$this);
			$this->res = $this->objReporte->generarReporteListado('MODParam','listarParam');
		} else{
			$this->objFunc=$this->create('MODParam');
			
			$this->res=$this->objFunc->listarParam($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
				
	function insertarParam(){
		$this->objFunc=$this->create('MODParam');	
		if($this->objParam->insertar('id_param')){
			$this->res=$this->objFunc->insertarParam($this->objParam);			
		} else{			
			$this->res=$this->objFunc->modificarParam($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
						
	function eliminarParam(){
			$this->objFunc=$this->create('MODParam');	
		$this->res=$this->objFunc->eliminarParam($this->objParam);
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
			
}

?>