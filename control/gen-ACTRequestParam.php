<?php
/**
*@package pXP
*@file gen-ACTRequestParam.php
*@author  (admin)
*@date 29-12-2018 13:30:52
*@description Clase que recibe los parametros enviados por la vista para mandar a la capa de Modelo
*/

class ACTRequestParam extends ACTbase{    
			
	function listarRequestParam(){
		$this->objParam->defecto('ordenacion','id_request_param');

		$this->objParam->defecto('dir_ordenacion','asc');
		if($this->objParam->getParametro('tipoReporte')=='excel_grid' || $this->objParam->getParametro('tipoReporte')=='pdf_grid'){
			$this->objReporte = new Reporte($this->objParam,$this);
			$this->res = $this->objReporte->generarReporteListado('MODRequestParam','listarRequestParam');
		} else{
			$this->objFunc=$this->create('MODRequestParam');
			
			$this->res=$this->objFunc->listarRequestParam($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
				
	function insertarRequestParam(){
		$this->objFunc=$this->create('MODRequestParam');	
		if($this->objParam->insertar('id_request_param')){
			$this->res=$this->objFunc->insertarRequestParam($this->objParam);			
		} else{			
			$this->res=$this->objFunc->modificarRequestParam($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
						
	function eliminarRequestParam(){
			$this->objFunc=$this->create('MODRequestParam');	
		$this->res=$this->objFunc->eliminarRequestParam($this->objParam);
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
			
}

?>