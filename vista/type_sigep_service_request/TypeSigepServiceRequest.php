<?php
/**
*@package pXP
*@file gen-TypeSigepServiceRequest.php
*@author  (admin)
*@date 30-11-2018 15:13:43
*@description Archivo con la interfaz de usuario que permite la ejecucion de todas las funcionalidades del sistema
*/

header("content-type: text/javascript; charset=UTF-8");
?>
<script>
Phx.vista.TypeSigepServiceRequest=Ext.extend(Phx.gridInterfaz,{

	constructor:function(config){
		this.maestro=config.maestro;
    	//llama al constructor de la clase padre
		Phx.vista.TypeSigepServiceRequest.superclass.constructor.call(this,config);
		this.init();
		
	},
			
	Atributos:[
		{
			//configuracion del componente
			config:{
					labelSeparator:'',
					inputType:'hidden',
					name: 'id_type_sigep_service_request'
			},
			type:'Field',
			form:true 
		},
		{
			//configuracion del componente
			config:{
					labelSeparator:'',
					inputType:'hidden',
					name: 'id_type_service_request'
			},
			type:'Field',
			form:true 
		},
		
		{
			config:{
				name: 'sigep_service_name',
				fieldLabel: 'SIGEP Service Name',
				allowBlank: true,
				anchor: '80%',
				gwidth: 150,
				maxLength:200
			},
				type:'TextField',
				filters:{pfiltro:'tssr.sigep_service_name',type:'string'},
				id_grupo:1,
				grid:true,
				form:true
		},
		
		{
			config:{
				name: 'sigep_url',
				fieldLabel: 'URL',
				allowBlank: false,
				anchor: '80%',
				gwidth: 150,
				maxLength:200
			},
				type:'TextField',
				filters:{pfiltro:'tssr.sigep_url',type:'string'},
				id_grupo:1,
				grid:true,
				form:true
		},
		
		{
			config:{
				name: 'queue_url',
				fieldLabel: 'Queue URL',
				allowBlank: true,
				anchor: '80%',
				gwidth: 150,
				maxLength:200
			},
				type:'TextField',
				filters:{pfiltro:'tssr.queue_url',type:'string'},
				id_grupo:1,
				grid:true,
				form:true
		},
		
		{
			config:{
				name: 'revert_url',
				fieldLabel: 'Revert URL',
				allowBlank: true,
				anchor: '80%',
				gwidth: 150,
				maxLength:200
			},
				type:'TextField',
				filters:{pfiltro:'tssr.revert_url',type:'string'},
				id_grupo:1,
				grid:true,
				form:true
		},
		
		{
       		config:{
       			name:'method_type',
       			fieldLabel:'Method',
       			allowBlank:false,
       			emptyText:'Meth...',
       			
       			typeAhead: false,
       		    triggerAction: 'all',
       		    lazyRender:true,
       		    mode: 'local',
       		    //readOnly:true,
       		    valueField: 'autentificacion',
       		   // displayField: 'descestilo',
       		    store:['POST','GET','PUT','DELETE']
       		    
       		},
       		type:'ComboBox',
       		id_grupo:0,
       		filters:{	
       		         type: 'list',
       		         pfiltro:'tssr.method_type',
       				 options: ['POST','GET','PUT','DELETE'],	
       		 	},
       		grid:true,
       		form:true
       	},	
		{
       		config:{
       			name:'queue_method',
       			fieldLabel:'Queue Method',
       			allowBlank:false,
       			emptyText:'Meth...',
       			
       			typeAhead: false,
       		    triggerAction: 'all',
       		    lazyRender:true,
       		    mode: 'local',
       		    //readOnly:true,
       		    valueField: 'autentificacion',
       		   // displayField: 'descestilo',
       		    store:['POST','GET','PUT','DELETE']
       		    
       		},
       		type:'ComboBox',
       		id_grupo:0,
       		filters:{	
       		         type: 'list',
       		         pfiltro:'tssr.queue_method',
       				 options: ['POST','GET','PUT','DELETE'],	
       		 	},
       		grid:true,
       		form:true
       	},
       	{
       		config:{
       			name:'revert_method',
       			fieldLabel:'Revert Method',
       			allowBlank:false,
       			emptyText:'Meth...',
       			
       			typeAhead: false,
       		    triggerAction: 'all',
       		    lazyRender:true,
       		    mode: 'local',       		    
       		    store:['POST','GET','PUT','DELETE']       		    
       		},
       		type:'ComboBox',
       		id_grupo:0,
       		filters:{	
       		         type: 'list',
       		         pfiltro:'tssr.revert_method',
       				 options: ['POST','GET','PUT','DELETE'],	
       		 	},
       		grid:true,
       		form:true
       	},
       	
       	{
			config:{
				name: 'json_main_container',
				fieldLabel: 'Json main container',
				allowBlank: true,
				anchor: '80%',
				gwidth: 150,
				maxLength:200
			},
				type:'TextField',
				filters:{pfiltro:'tssr.json_main_container',type:'string'},
				id_grupo:1,
				grid:true,
				form:true
		},
		
		{
			config:{
				name: 'user_param',
				fieldLabel: 'User Param',
				allowBlank: true,
				anchor: '80%',
				gwidth: 150,
				maxLength:200
			},
				type:'TextField',
				filters:{pfiltro:'tssr.user_param',type:'string'},
				id_grupo:1,
				grid:true,
				form:true
		},
		{
			config:{
				name: 'time_to_refresh',
				fieldLabel: 'Time to Refresh',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:4
			},
				type:'NumberField',
				filters:{pfiltro:'tssr.time_to_refresh',type:'numeric'},
				id_grupo:1,
				grid:true,
				form:true
		},
		
		
		
		
		
		{
			config:{
				name: 'exec_order',
				fieldLabel: 'Order',
				allowBlank: false,
				anchor: '80%',
				gwidth: 100,
				maxLength:4
			},
				type:'NumberField',
				filters:{pfiltro:'tssr.exec_order',type:'numeric'},
				id_grupo:1,
				grid:true,
				form:true
		},
		{
			config:{
				name: 'estado_reg',
				fieldLabel: 'Estado Reg.',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:10
			},
				type:'TextField',
				filters:{pfiltro:'tssr.estado_reg',type:'string'},
				id_grupo:1,
				grid:true,
				form:false
		},
		
		{
			config:{
				name: 'usuario_ai',
				fieldLabel: 'Funcionaro AI',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:300
			},
				type:'TextField',
				filters:{pfiltro:'tssr.usuario_ai',type:'string'},
				id_grupo:1,
				grid:true,
				form:false
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
				filters:{pfiltro:'tssr.fecha_reg',type:'date'},
				id_grupo:1,
				grid:true,
				form:false
		},
		{
			config:{
				name: 'usr_reg',
				fieldLabel: 'Creado por',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:4
			},
				type:'Field',
				filters:{pfiltro:'usu1.cuenta',type:'string'},
				id_grupo:1,
				grid:true,
				form:false
		},
		{
			config:{
				name: 'id_usuario_ai',
				fieldLabel: 'Creado por',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:4
			},
				type:'Field',
				filters:{pfiltro:'tssr.id_usuario_ai',type:'numeric'},
				id_grupo:1,
				grid:false,
				form:false
		},
		{
			config:{
				name: 'fecha_mod',
				fieldLabel: 'Fecha Modif.',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
							format: 'd/m/Y', 
							renderer:function (value,p,record){return value?value.dateFormat('d/m/Y H:i:s'):''}
			},
				type:'DateField',
				filters:{pfiltro:'tssr.fecha_mod',type:'date'},
				id_grupo:1,
				grid:true,
				form:false
		},
		{
			config:{
				name: 'usr_mod',
				fieldLabel: 'Modificado por',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:4
			},
				type:'Field',
				filters:{pfiltro:'usu2.cuenta',type:'string'},
				id_grupo:1,
				grid:true,
				form:false
		}
	],
	tam_pag:50,	
	title:'Sigep service request',
	ActSave:'../../sis_sigep/control/TypeSigepServiceRequest/insertarTypeSigepServiceRequest',
	ActDel:'../../sis_sigep/control/TypeSigepServiceRequest/eliminarTypeSigepServiceRequest',
	ActList:'../../sis_sigep/control/TypeSigepServiceRequest/listarTypeSigepServiceRequest',
	id_store:'id_type_sigep_service_request',
	fields: [
		{name:'id_type_sigep_service_request', type: 'numeric'},
		{name:'id_type_service_request', type: 'numeric'},
		{name:'exec_order', type: 'numeric'},
		{name:'queue_method', type: 'string'},
		{name:'estado_reg', type: 'string'},
		{name:'time_to_refresh', type: 'numeric'},
		{name:'queue_url', type: 'string'},
		{name:'method_type', type: 'string'},
		{name:'sigep_service_name', type: 'string'},
		{name:'sigep_url', type: 'string'},
		{name:'revert_url', type: 'string'},
		{name:'revert_method', type: 'string'},
		{name:'user_param', type: 'string'},
		{name:'json_main_container', type: 'string'},
		{name:'usuario_ai', type: 'string'},
		{name:'fecha_reg', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
		{name:'id_usuario_reg', type: 'numeric'},
		{name:'id_usuario_ai', type: 'numeric'},
		{name:'fecha_mod', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
		{name:'id_usuario_mod', type: 'numeric'},
		{name:'usr_reg', type: 'string'},
		{name:'usr_mod', type: 'string'},
		
	],
	sortInfo:{
		field: 'id_type_sigep_service_request',
		direction: 'ASC'
	},
	east:{
		  url:'../../../sis_sigep/vista/param/Param.php',
		  title:'PArams', 
		  width:'50%',
		  cls:'Param'
	},
	onReloadPage:function(m){
			this.maestro=m;			
			this.load({params:{start:0, limit:this.tam_pag,id_type_service_request:this.maestro.id_type_service_request}});			
	},
	loadValoresIniciales:function()
    {
        this.Cmp.id_type_service_request.setValue(this.maestro.id_type_service_request);       
        Phx.vista.TypeSigepServiceRequest.superclass.loadValoresIniciales.call(this);
    },
	bdel:true,
	bsave:true
	}
)
</script>
		
		