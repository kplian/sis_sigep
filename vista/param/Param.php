<?php
/**
*@package pXP
*@file gen-Param.php
*@author  (admin)
*@date 29-11-2018 04:35:55
*@description Archivo con la interfaz de usuario que permite la ejecucion de todas las funcionalidades del sistema
*/

header("content-type: text/javascript; charset=UTF-8");
?>
<script>
Phx.vista.Param=Ext.extend(Phx.gridInterfaz,{

	constructor:function(config){
		this.maestro=config.maestro;
    	//llama al constructor de la clase padre
		Phx.vista.Param.superclass.constructor.call(this,config);
		this.init();		
	},
			
	Atributos:[
		{
			//configuracion del componente
			config:{
					labelSeparator:'',
					inputType:'hidden',
					name: 'id_param'
			},
			type:'Field',
			form:true 
		},
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
			config:{
				name: 'sigep_name',
				fieldLabel: 'Sigep Name',
				allowBlank: true,
				anchor: '80%',
				gwidth: 120,
				maxLength:200,
				qtip:'Nombre del parametro en sigep'
			},
				type:'TextField',
				filters:{pfiltro:'para.sigep_name',type:'string'},
				id_grupo:1,
				grid:true,
				form:true
		},
		
		{
			config:{
				name: 'erp_name',
				fieldLabel: 'ERP Name',
				allowBlank: true,
				anchor: '80%',
				gwidth: 120,
				maxLength:200,
				qtip:'Nombre del parametro enviado desde el erp. Si este valor esta vacio se sacara el valor de def value o desde un output de un servicio anterior'
			},
				type:'TextField',
				filters:{pfiltro:'para.erp_name',type:'string'},
				id_grupo:1,
				grid:true,
				form:true
		},
		
		{
			config:{
				name: 'erp_json_container',
				fieldLabel: 'ERP Container',
				allowBlank: true,
				anchor: '80%',
				gwidth: 120,
				maxLength:200,
				qtip:'En caso de de que el parametro no se encuentre en el primer nivel del json aca ponemos el nombre del contenedor dentro del que esta el parametro'
			},
				type:'TextField',
				filters:{pfiltro:'para.erp_json_container',type:'string'},
				id_grupo:1,
				grid:true,
				form:true
		},
		
		
		{
       		config:{
       			name:'ctype',
       			fieldLabel:'Type',
       			allowBlank:false,
       			emptyText:'Type...',
       			
       			typeAhead: false,
       		    triggerAction: 'all',
       		    lazyRender:true,
       		    mode: 'local',
       		    //readOnly:true,
       		    valueField: 'autentificacion',
       		   // displayField: 'descestilo',
       		    store:['NUMERIC','INTEGER','VARCHAR','DATE']
       		    
       		},
       		type:'ComboBox',
       		id_grupo:0,
       		filters:{	
       		         type: 'list',
       				 options: ['NUMERIC','INTEGER','VARCHAR','DATE'],	
       		 	},
       		grid:true,
       		form:true
       	},	
		{
       		config:{
       			name:'input_output',
       			fieldLabel:'Inp/Out',
       			allowBlank:false,
       			emptyText:'inp...',
       			
       			typeAhead: false,
       		    triggerAction: 'all',
       		    lazyRender:true,
       		    mode: 'local',
       		    //readOnly:true,
       		    valueField: 'autentificacion',
       		   // displayField: 'descestilo',
       		    store:['input','output','revert'],
       		    qtip:'input si es un parametro para enviar al servicio, output en caso de que es una respuesta del servicio y revert en caso de q es un parametro para enviar para la reversion'
       		    
       		},
       		type:'ComboBox',
       		id_grupo:0,
       		filters:{	
       		         type: 'list',
       				 options: ['input','output','revert'],	
       		 	},
       		grid:true,
       		form:true
       	},
       	{
			config:{
				name: 'def_value',
				fieldLabel: 'Def Value',
				allowBlank: true,
				anchor: '80%',
				gwidth: 120,
				maxLength:500,
       		    qtip:'valor por defecto en caso de que siempre se debe enviar el mismo valor'
			},
				type:'TextField',
				filters:{pfiltro:'para.def_value',type:'string'},
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
				filters:{pfiltro:'para.estado_reg',type:'string'},
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
				name: 'fecha_reg',
				fieldLabel: 'Fecha creación',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
							format: 'd/m/Y', 
							renderer:function (value,p,record){return value?value.dateFormat('d/m/Y H:i:s'):''}
			},
				type:'DateField',
				filters:{pfiltro:'para.fecha_reg',type:'date'},
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
				filters:{pfiltro:'para.usuario_ai',type:'string'},
				id_grupo:1,
				grid:true,
				form:false
		},
		{
			config:{
				name: 'id_usuario_ai',
				fieldLabel: 'Funcionaro AI',
				allowBlank: true,
				anchor: '80%',
				gwidth: 100,
				maxLength:4
			},
				type:'Field',
				filters:{pfiltro:'para.id_usuario_ai',type:'numeric'},
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
				filters:{pfiltro:'para.fecha_mod',type:'date'},
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
	title:'Param',
	ActSave:'../../sis_sigep/control/Param/insertarParam',
	ActDel:'../../sis_sigep/control/Param/eliminarParam',
	ActList:'../../sis_sigep/control/Param/listarParam',
	id_store:'id_param',
	fields: [
		{name:'id_param', type: 'numeric'},
		{name:'id_type_sigep_service_request', type: 'numeric'},
		{name:'ctype', type: 'string'},
		{name:'estado_reg', type: 'string'},
		{name:'erp_json_container', type: 'string'},
		{name:'sigep_name', type: 'string'},
		{name:'input_output', type: 'string'},
		{name:'erp_name', type: 'string'},
		{name:'def_value', type: 'string'},
		{name:'id_usuario_reg', type: 'numeric'},
		{name:'fecha_reg', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
		{name:'usuario_ai', type: 'string'},
		{name:'id_usuario_ai', type: 'numeric'},
		{name:'fecha_mod', type: 'date',dateFormat:'Y-m-d H:i:s.u'},
		{name:'id_usuario_mod', type: 'numeric'},
		{name:'usr_reg', type: 'string'},
		{name:'usr_mod', type: 'string'},
		
	],
	sortInfo:{
		field: 'id_param',
		direction: 'ASC'
	},
	onReloadPage:function(m){
			this.maestro=m;			
			this.load({params:{start:0, limit:this.tam_pag,id_type_sigep_service_request:this.maestro.id_type_sigep_service_request}});			
	},
	loadValoresIniciales:function()
    {
        this.Cmp.id_type_sigep_service_request.setValue(this.maestro.id_type_sigep_service_request);       
        Phx.vista.Param.superclass.loadValoresIniciales.call(this);
    },
	bdel:true,
	bsave:true
	}
)
</script>
		
		