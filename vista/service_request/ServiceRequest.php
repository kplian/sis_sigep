<?php
/**
*@package pXP
*@file gen-ServiceRequest.php
*@author  (admin)
*@date 27-12-2018 13:10:13
*@description Archivo con la interfaz de usuario que permite la ejecucion de todas las funcionalidades del sistema
*/

header("content-type: text/javascript; charset=UTF-8");
?>
<script>
Phx.vista.ServiceRequest=Ext.extend(Phx.gridInterfaz,{

	constructor:function(config){
		this.maestro=config.maestro;
    	//llama al constructor de la clase padre
		Phx.vista.ServiceRequest.superclass.constructor.call(this,config);
		this.init();
		this.load({params:{start:0, limit:this.tam_pag}})
	},
			
	Atributos:[
		{
			//configuracion del componente
			config:{
					labelSeparator:'',
					inputType:'hidden',
					name: 'id_service_request'
			},
			type:'Field',
			form:true 
		},
		{
			config:{
				name: 'service_code',
				fieldLabel: 'Service Code',
				allowBlank: false,
				anchor: '80%',
				gwidth: 120,
				maxLength:100
			},
				type:'TextField',
				filters:{pfiltro:'tsr.service_code',type:'string'},
				id_grupo:1,
				grid:true,
				form:true
		},
		
		{
			config:{
				name: 'description',
				fieldLabel: 'Service Desc',
				allowBlank: false,
				anchor: '80%',
				gwidth: 150,
				maxLength:100
			},
				type:'TextField',
				filters:{pfiltro:'tsr.description',type:'string'},
				id_grupo:1,
				grid:true,
				form:true
		},
		
		{
			config:{
				name: 'sys_origin',
				fieldLabel: 'Origin',
				allowBlank: false,
				anchor: '80%',
				gwidth: 100,
				maxLength:100
			},
				type:'TextField',
				filters:{pfiltro:'sere.sys_origin',type:'string'},
				id_grupo:1,
				grid:true,
				form:true
		},
		{
			config:{
				name: 'ip_origin',
				fieldLabel: 'IP Origin',
				allowBlank: false,
				anchor: '80%',
				gwidth: 100,
				maxLength:50
			},
				type:'TextField',
				filters:{pfiltro:'sere.ip_origin',type:'string'},
				id_grupo:1,
				grid:true,
				form:true
		},
		{
			config:{
				name: 'status',
				fieldLabel: 'Status',
				allowBlank: false,
				anchor: '80%',
				gwidth: 100,
				maxLength:50
			},
				type:'TextField',
				filters:{pfiltro:'sere.status',type:'string'},
				id_grupo:1,
				grid:true,
				form:true
		},
		{
			config:{
				name: 'fecha_reg',
				fieldLabel: 'Fecha Creación',
				allowBlank: true,
				anchor: '80%',
				gwidth: 110,
							format: 'd/m/Y', 
							renderer:function (value,p,record){return value?value.dateFormat('d/m/Y H:i:s'):''}
			},
				type:'DateField',
				filters:{pfiltro:'sere.fecha_reg',type:'date'},
				id_grupo:1,
				grid:true,
				form:false
		},
		
		{
			config:{
				name: 'date_finished',
				fieldLabel: 'Fecha Finalizacion',
				allowBlank: true,
				anchor: '80%',
				gwidth: 120,
							format: 'd/m/Y', 
							renderer:function (value,p,record){return value?value.dateFormat('d/m/Y H:i:s'):''}
			},
				type:'DateField',
				filters:{pfiltro:'sere.date_finished',type:'date'},
				id_grupo:1,
				grid:true,
				form:true
		},
		
		
		{
			config:{
				name: 'last_message',
				fieldLabel: 'Ult. Mensaje',
				allowBlank: true,
				anchor: '80%',
				gwidth: 130,
				maxLength:-5
			},
				type:'TextField',
				filters:{pfiltro:'sere.last_message',type:'string'},
				id_grupo:1,
				grid:true,
				form:true
		},
		{
			config:{
				name: 'last_message_revert',
				fieldLabel: 'Ult. Mensaje Rev',
				allowBlank: true,
				anchor: '80%',
				gwidth: 130,
				maxLength:-5
			},
				type:'TextField',
				filters:{pfiltro:'sere.last_message_revert',type:'string'},
				id_grupo:1,
				grid:true,
				form:true
		}
		
		
		
	],
	tam_pag:50,	
	title:'Service Request',
	ActSave:'../../sis_sigep/control/ServiceRequest/insertarServiceRequest',
	ActDel:'../../sis_sigep/control/ServiceRequest/eliminarServiceRequest',
	ActList:'../../sis_sigep/control/ServiceRequest/listarServiceRequest',
	id_store:'id_service_request',
	fields: [
		{name:'id_service_request', type: 'numeric'},
		{name:'id_type_service_request', type: 'numeric'},
		{name:'estado_reg', type: 'string'},
		{name:'date_finished', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
		{name:'status', type: 'string'},
		{name:'sys_origin', type: 'string'},
		{name:'description', type: 'string'},
		{name:'service_code', type: 'string'},
		{name:'ip_origin', type: 'string'},
		{name:'last_message', type: 'string'},
		{name:'last_message_revert', type: 'string'},
		{name:'usuario_ai', type: 'string'},
		{name:'fecha_reg', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
		{name:'id_usuario_reg', type: 'numeric'},
		{name:'id_usuario_ai', type: 'numeric'},
		{name:'id_usuario_mod', type: 'numeric'},
		{name:'fecha_mod', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
		{name:'usr_reg', type: 'string'},
		{name:'usr_mod', type: 'string'},
		
	],
	sortInfo:{
		field: 'id_service_request',
		direction: 'DESC'
	},
	south:{
		  url:'../../../sis_sigep/vista/sigep_service_request/SigepServiceRequest.php',
		  title:'Sigep Service Request', 
		  height:'50%',
		  cls:'SigepServiceRequest'
	},
	bdel:false,
	bsave:false,
	bnew:false,
	bedit:false
	}
)
</script>
		
		