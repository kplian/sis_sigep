<?php
/**
*@package pXP
*@file gen-ACTUserMapping.php
*@author  (admin)
*@date 08-04-2018 11:04:46
*@description Clase que recibe los parametros enviados por la vista para mandar a la capa de Modelo
*/

class ACTUserMapping extends ACTbase{    
			
	function listarUserMapping(){
		$this->objParam->defecto('ordenacion','id_user_mapping');

		$this->objParam->defecto('dir_ordenacion','asc');
		if($this->objParam->getParametro('tipoReporte')=='excel_grid' || $this->objParam->getParametro('tipoReporte')=='pdf_grid'){
			$this->objReporte = new Reporte($this->objParam,$this);
			$this->res = $this->objReporte->generarReporteListado('MODUserMapping','listarUserMapping');
		} else{
			$this->objFunc=$this->create('MODUserMapping');
			
			$this->res=$this->objFunc->listarUserMapping($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
				
	function insertarUserMapping(){
		$this->objFunc=$this->create('MODUserMapping');	
		if($this->objParam->insertar('id_user_mapping')){
			$this->res=$this->objFunc->insertarUserMapping($this->objParam);			
		} else{			
			$this->res=$this->objFunc->modificarUserMapping($this->objParam);
		}
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
						
	function eliminarUserMapping(){
			$this->objFunc=$this->create('MODUserMapping');	
		$this->res=$this->objFunc->eliminarUserMapping($this->objParam);
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
	function initRefreshToken(){
		$this->objFunc=$this->create('MODUserMapping');	
		$this->res=$this->objFunc->initRefreshToken($this->objParam);
		$this->res->imprimirRespuesta($this->res->generarJson());
	}
			
}

?>