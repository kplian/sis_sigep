<?php
/**
*@package pXP
*@file gen-SigepServiceRequest.php
*@author  (admin)
*@date 27-12-2018 12:23:23
*@description Archivo con la interfaz de usuario que permite la ejecucion de todas las funcionalidades del sistema
*/

header("content-type: text/javascript; charset=UTF-8");
?>
<script>
Phx.vista.SigepServiceRequest=Ext.extend(Phx.gridInterfaz,{

	constructor:function(config){
		this.maestro=config.maestro;
    	//llama al constructor de la clase padre
		Phx.vista.SigepServiceRequest.superclass.constructor.call(this,config);
		this.init();
	},
			
	Atributos:[
		{
			//configuracion del componente
			config:{
					labelSeparator:'',
					inputType:'hidden',
					name: 'id_sigep_service_request'
			},
			type:'Field',
			form:true 
		},
		
		{
			config:{
				name: 'sigep_service_name',
				fieldLabel: 'Service Name',
				allowBlank: false,
				anchor: '80%',
				gwidth: 120,
				maxLength:100
			},
				type:'TextField',
				filters:{pfiltro:'tssr.sigep_service_name',type:'string'},
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
				maxLength:100
			},
				type:'TextField',
				filters:{pfiltro:'ssr.status',type:'string'},
				id_grupo:1,
				grid:true,
				form:true
		},
		{
			config:{
				name: 'date_request_sent',
				fieldLabel: 'Date Req. Sent',
				allowBlank: true,
				anchor: '80%',
				gwidth: 110,
							format: 'd/m/Y', 
							renderer:function (value,p,record){return value?value.dateFormat('d/m/Y H:i:s'):''}
			},
				type:'DateField',
				filters:{pfiltro:'ssr.date_request_sent',type:'date'},
				id_grupo:1,
				grid:true,
				form:true
		},
		{
			config:{
				name: 'date_queue_sent',
				fieldLabel: 'Date Queue Sent',
				allowBlank: true,
				anchor: '80%',
				gwidth: 120,
							format: 'd/m/Y', 
							renderer:function (value,p,record){return value?value.dateFormat('d/m/Y H:i:s'):''}
			},
				type:'DateField',
				filters:{pfiltro:'ssr.date_queue_sent',type:'date'},
				id_grupo:1,
				grid:true,
				form:true
		},
		
		{
			config:{
				name: 'last_message',
				fieldLabel: 'Last Message',
				allowBlank: true,
				anchor: '80%',
				gwidth: 130,
				maxLength:-5
			},
				type:'TextField',
				filters:{pfiltro:'ssr.last_message',type:'string'},
				id_grupo:1,
				grid:true,
				form:true
		},
		
		{
			config:{
				name: 'last_message_revert',
				fieldLabel: 'Last Message Revert',
				allowBlank: true,
				anchor: '80%',
				gwidth: 130,
				maxLength:-5
			},
				type:'TextField',
				filters:{pfiltro:'ssr.last_message_revert',type:'string'},
				id_grupo:1,
				grid:true,
				form:true
		},
		
		{
			config:{
				name: 'user_name',
				fieldLabel: 'User Name',
				allowBlank: true,
				anchor: '80%',
				gwidth: 120,
				maxLength:-5
			},
				type:'TextField',
				filters:{pfiltro:'ssr.user_name',type:'string'},
				id_grupo:1,
				grid:true,
				form:true
		},
		{
			config:{
				name: 'queue_id',
				fieldLabel: 'Queue Id',
				allowBlank: true,
				anchor: '80%',
				gwidth: 110,
				maxLength:-5
			},
				type:'TextField',
				filters:{pfiltro:'ssr.queue_id',type:'string'},
				id_grupo:1,
				grid:true,
				form:true
		},
		
		{
			config:{
				name: 'queue_revert_id',
				fieldLabel: 'Queue Rev.Id',
				allowBlank: true,
				anchor: '80%',
				gwidth: 110,
				maxLength:-5
			},
				type:'TextField',
				filters:{pfiltro:'ssr.queue_revert_id',type:'string'},
				id_grupo:1,
				grid:true,
				form:true
		},
		
		{
			config:{
				name: 'fecha_reg',
				fieldLabel: 'Fecha creación',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
							format: 'd/m/Y', 
							renderer:function (value,p,record){return value?value.dateFormat('d/m/Y H:i:s'):''}
			},
				type:'DateField',
				filters:{pfiltro:'ssr.fecha_reg',type:'date'},
				id_grupo:1,
				grid:true,
				form:false
		}
		
	],
	tam_pag:50,	
	title:'Sigep Service Request',
	ActSave:'../../sis_sigep/control/SigepServiceRequest/insertarSigepServiceRequest',
	ActDel:'../../sis_sigep/control/SigepServiceRequest/eliminarSigepServiceRequest',
	ActList:'../../sis_sigep/control/SigepServiceRequest/listarSigepServiceRequest',
	id_store:'id_sigep_service_request',
	fields: [
		{name:'id_sigep_service_request', type: 'numeric'},
		{name:'id_service_request', type: 'numeric'},
		{name:'id_type_sigep_service_request', type: 'numeric'},
		{name:'estado_reg', type: 'string'},
		{name:'sigep_service_name', type: 'string'},
		{name:'status', type: 'string'},
		{name:'queue_id', type: 'string'},
		{name:'user_name', type: 'string'},
		{name:'queue_revert_id', type: 'string'},
		{name:'date_queue_sent', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
		{name:'date_request_sent', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
		{name:'last_message', type: 'string'},
		{name:'last_message_revert', type: 'string'},
		{name:'id_usuario_reg', type: 'numeric'},
		{name:'usuario_ai', type: 'string'},
		{name:'fecha_reg', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
		{name:'id_usuario_ai', type: 'numeric'},
		{name:'id_usuario_mod', type: 'numeric'},
		{name:'fecha_mod', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
		{name:'usr_reg', type: 'string'},
		{name:'usr_mod', type: 'string'},
		
	],
	sortInfo:{
		field: 'ssr.exec_order',
		direction: 'ASC'
	},
	onReloadPage:function(m){
		this.maestro=m;			
		this.load({params:{start:0, limit:this.tam_pag,id_service_request:this.maestro.id_service_request}});			
	},
	bdel:false,
	bsave:false,
	bnew:false,
	bedit:false
	}
)
</script>
		
		