CREATE OR REPLACE FUNCTION "sigep"."ft_service_request_ime" (	
				p_administrador integer, p_id_usuario integer, p_tabla character varying, p_transaccion character varying)
RETURNS character varying AS
$BODY$

/**************************************************************************
 SISTEMA:		Sigep
 FUNCION: 		sigep.ft_service_request_ime
 DESCRIPCION:   Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla 'sigep.tservice_request'
 AUTOR: 		 (admin)
 FECHA:	        27-12-2018 13:10:13
 COMENTARIOS:	
***************************************************************************
 HISTORIAL DE MODIFICACIONES:
#ISSUE				FECHA				AUTOR				DESCRIPCION
 #0				27-12-2018 13:10:13								Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla 'sigep.tservice_request'	
 #
 ***************************************************************************/

DECLARE

	v_nro_requerimiento    	integer;
	v_parametros           	record;
	v_id_requerimiento     	integer;
	v_resp		            varchar;
	v_nombre_funcion        text;
	v_mensaje_error         text;
	v_id_service_request	integer;
    v_id_type_service_request	integer;
			    
BEGIN

    v_nombre_funcion = 'sigep.ft_service_request_ime';
    v_parametros = pxp.f_get_record(p_tabla);

	/*********************************    
 	#TRANSACCION:  'SIG_SERE_INS'
 	#DESCRIPCION:	Insercion de registros
 	#AUTOR:		admin	
 	#FECHA:		27-12-2018 13:10:13
	***********************************/

	if(p_transaccion='SIG_SERE_INS')then
					
        begin
        	--Sentencia de la insercion
            select id_type_service_request into v_id_type_service_request
            from  sigep.ttype_service_request
            where service_code = v_parametros.service_code;


        	insert into sigep.tservice_request(
			id_type_service_request,
			estado_reg,						
			status,
			sys_origin,
			ip_origin,				
			fecha_reg,
			id_usuario_reg          	) values(
			v_id_type_service_request,
			'activo',
			'pending',
			v_parametros.sys_origin,
			v_parametros.ip_origin,
			now(),
			p_id_usuario						
			
			
			)RETURNING id_service_request into v_id_service_request;
			
			--Definicion de la respuesta
			v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Service Request almacenado(a) con exito (id_service_request'||v_id_service_request||')'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_service_request',v_id_service_request::varchar);

            --Devuelve la respuesta
            return v_resp;

		end;

	/*********************************    
 	#TRANSACCION:  'SIG_SERE_MOD'
 	#DESCRIPCION:	Modificacion de registros
 	#AUTOR:		admin	
 	#FECHA:		27-12-2018 13:10:13
	***********************************/

	elsif(p_transaccion='SIG_SERE_MOD')then

		begin
			--Sentencia de la modificacion
			update sigep.tservice_request set
			id_type_service_request = v_parametros.id_type_service_request,
			date_finished = v_parametros.date_finished,
			status = v_parametros.status,
			sys_origin = v_parametros.sys_origin,
			ip_origin = v_parametros.ip_origin,
			last_message = v_parametros.last_message,
			id_usuario_mod = p_id_usuario,
			fecha_mod = now(),
			id_usuario_ai = v_parametros._id_usuario_ai,
			usuario_ai = v_parametros._nombre_usuario_ai
			where id_service_request=v_parametros.id_service_request;
               
			--Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Service Request modificado(a)'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_service_request',v_parametros.id_service_request::varchar);
               
            --Devuelve la respuesta
            return v_resp;
            
		end;

	/*********************************    
 	#TRANSACCION:  'SIG_SERE_ELI'
 	#DESCRIPCION:	Eliminacion de registros
 	#AUTOR:		admin	
 	#FECHA:		27-12-2018 13:10:13
	***********************************/

	elsif(p_transaccion='SIG_SERE_ELI')then

		begin
			--Sentencia de la eliminacion
			delete from sigep.tservice_request
            where id_service_request=v_parametros.id_service_request;
               
            --Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Service Request eliminado(a)'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_service_request',v_parametros.id_service_request::varchar);
              
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
ALTER FUNCTION "sigep"."ft_service_request_ime"(integer, integer, character varying, character varying) OWNER TO postgres;

