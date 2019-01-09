CREATE OR REPLACE FUNCTION "sigep"."ft_param_ime" (	
				p_administrador integer, p_id_usuario integer, p_tabla character varying, p_transaccion character varying)
RETURNS character varying AS
$BODY$

/**************************************************************************
 SISTEMA:		Sigep
 FUNCION: 		sigep.ft_param_ime
 DESCRIPCION:   Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla 'sigep.tparam'
 AUTOR: 		 (admin)
 FECHA:	        29-11-2018 04:35:55
 COMENTARIOS:	
***************************************************************************
 HISTORIAL DE MODIFICACIONES:
#ISSUE				FECHA				AUTOR				DESCRIPCION
 #0				29-11-2018 04:35:55								Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla 'sigep.tparam'	
 #
 ***************************************************************************/

DECLARE

	v_nro_requerimiento    	integer;
	v_parametros           	record;
	v_id_requerimiento     	integer;
	v_resp		            varchar;
	v_nombre_funcion        text;
	v_mensaje_error         text;
	v_id_param	integer;
			    
BEGIN

    v_nombre_funcion = 'sigep.ft_param_ime';
    v_parametros = pxp.f_get_record(p_tabla);

	/*********************************    
 	#TRANSACCION:  'SIG_PARA_INS'
 	#DESCRIPCION:	Insercion de registros
 	#AUTOR:		admin	
 	#FECHA:		29-11-2018 04:35:55
	***********************************/

	if(p_transaccion='SIG_PARA_INS')then
					
        begin
        	--Sentencia de la insercion
        	insert into sigep.tparam(
			id_type_sigep_service_request,
			ctype,
			estado_reg,
			erp_json_container,
			sigep_name,
			erp_name,
			id_usuario_reg,
			fecha_reg,
			usuario_ai,
			id_usuario_ai,
			fecha_mod,
			id_usuario_mod,
			input_output,
			def_value
          	) values(
			v_parametros.id_type_sigep_service_request,
			v_parametros.ctype,
			'activo',
			v_parametros.erp_json_container,
			v_parametros.sigep_name,
			v_parametros.erp_name,
			p_id_usuario,
			now(),
			v_parametros._nombre_usuario_ai,
			v_parametros._id_usuario_ai,
			null,
			null,
			v_parametros.input_output,
			v_parametros.def_value				
			
			
			)RETURNING id_param into v_id_param;
			
			--Definicion de la respuesta
			v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Param almacenado(a) con exito (id_param'||v_id_param||')'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_param',v_id_param::varchar);

            --Devuelve la respuesta
            return v_resp;

		end;

	/*********************************    
 	#TRANSACCION:  'SIG_PARA_MOD'
 	#DESCRIPCION:	Modificacion de registros
 	#AUTOR:		admin	
 	#FECHA:		29-11-2018 04:35:55
	***********************************/

	elsif(p_transaccion='SIG_PARA_MOD')then

		begin
			--Sentencia de la modificacion
			update sigep.tparam set
			id_type_sigep_service_request = v_parametros.id_type_sigep_service_request,
			ctype = v_parametros.ctype,
			erp_json_container = v_parametros.erp_json_container,
			sigep_name = v_parametros.sigep_name,
			erp_name = v_parametros.erp_name,
			fecha_mod = now(),
			id_usuario_mod = p_id_usuario,
			id_usuario_ai = v_parametros._id_usuario_ai,
			usuario_ai = v_parametros._nombre_usuario_ai,
			input_output = v_parametros.input_output,
			def_value = v_parametros.def_value
			where id_param=v_parametros.id_param;
               
			--Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Param modificado(a)'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_param',v_parametros.id_param::varchar);
               
            --Devuelve la respuesta
            return v_resp;
            
		end;

	/*********************************    
 	#TRANSACCION:  'SIG_PARA_ELI'
 	#DESCRIPCION:	Eliminacion de registros
 	#AUTOR:		admin	
 	#FECHA:		29-11-2018 04:35:55
	***********************************/

	elsif(p_transaccion='SIG_PARA_ELI')then

		begin
			--Sentencia de la eliminacion
			delete from sigep.tparam
            where id_param=v_parametros.id_param;
               
            --Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Param eliminado(a)'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_param',v_parametros.id_param::varchar);
              
            --Devuelve la respuesta
            return v_resp;

		end;
         
	else
     
    	raise exception 'Transaccion inexistente: %',p_transaccion;

	end if;

EXCEPTION
				
	WHEN OTHERS THEN
		v_resp='';
		v_resp = pxp.f_agrega_clave(v_resp,'mensaje',SQLERRM);
		v_resp = pxp.f_agrega_clave(v_resp,'codigo_error',SQLSTATE);
		v_resp = pxp.f_agrega_clave(v_resp,'procedimientos',v_nombre_funcion);
		raise exception '%',v_resp;
				        
END;
$BODY$
LANGUAGE 'plpgsql' VOLATILE
COST 100;
ALTER FUNCTION "sigep"."ft_param_ime"(integer, integer, character varying, character varying) OWNER TO postgres;
