CREATE OR REPLACE FUNCTION "sigep"."ft_type_service_request_ime" (	
				p_administrador integer, p_id_usuario integer, p_tabla character varying, p_transaccion character varying)
RETURNS character varying AS
$BODY$

/**************************************************************************
 SISTEMA:		Sigep
 FUNCION: 		sigep.ft_type_service_request_ime
 DESCRIPCION:   Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla 'sigep.ttype_service_request'
 AUTOR: 		 (admin)
 FECHA:	        29-11-2018 04:31:24
 COMENTARIOS:	
***************************************************************************
 HISTORIAL DE MODIFICACIONES:
#ISSUE				FECHA				AUTOR				DESCRIPCION
 #0				29-11-2018 04:31:24								Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla 'sigep.ttype_service_request'	
 #
 ***************************************************************************/

DECLARE

	v_nro_requerimiento    	integer;
	v_parametros           	record;
	v_id_requerimiento     	integer;
	v_resp		            varchar;
	v_nombre_funcion        text;
	v_mensaje_error         text;
	v_id_type_service_request	integer;
			    
BEGIN

    v_nombre_funcion = 'sigep.ft_type_service_request_ime';
    v_parametros = pxp.f_get_record(p_tabla);

	/*********************************    
 	#TRANSACCION:  'SIG_TSR_INS'
 	#DESCRIPCION:	Insercion de registros
 	#AUTOR:		admin	
 	#FECHA:		29-11-2018 04:31:24
	***********************************/

	if(p_transaccion='SIG_TSR_INS')then
					
        begin
        	--Sentencia de la insercion
        	insert into sigep.ttype_service_request(
			estado_reg,
			description,
			service_code,
			id_usuario_reg,
			fecha_reg,
			usuario_ai,
			id_usuario_ai,
			id_usuario_mod,
			fecha_mod
          	) values(
			'activo',
			v_parametros.description,
			v_parametros.service_code,
			p_id_usuario,
			now(),
			v_parametros._nombre_usuario_ai,
			v_parametros._id_usuario_ai,
			null,
			null
							
			
			
			)RETURNING id_type_service_request into v_id_type_service_request;
			
			--Definicion de la respuesta
			v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Type Service Request almacenado(a) con exito (id_type_service_request'||v_id_type_service_request||')'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_type_service_request',v_id_type_service_request::varchar);

            --Devuelve la respuesta
            return v_resp;

		end;

	/*********************************    
 	#TRANSACCION:  'SIG_TSR_MOD'
 	#DESCRIPCION:	Modificacion de registros
 	#AUTOR:		admin	
 	#FECHA:		29-11-2018 04:31:24
	***********************************/

	elsif(p_transaccion='SIG_TSR_MOD')then

		begin
			--Sentencia de la modificacion
			update sigep.ttype_service_request set
			description = v_parametros.description,
			service_code = v_parametros.service_code,
			id_usuario_mod = p_id_usuario,
			fecha_mod = now(),
			id_usuario_ai = v_parametros._id_usuario_ai,
			usuario_ai = v_parametros._nombre_usuario_ai
			where id_type_service_request=v_parametros.id_type_service_request;
               
			--Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Type Service Request modificado(a)'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_type_service_request',v_parametros.id_type_service_request::varchar);
               
            --Devuelve la respuesta
            return v_resp;
            
		end;

	/*********************************    
 	#TRANSACCION:  'SIG_TSR_ELI'
 	#DESCRIPCION:	Eliminacion de registros
 	#AUTOR:		admin	
 	#FECHA:		29-11-2018 04:31:24
	***********************************/

	elsif(p_transaccion='SIG_TSR_ELI')then

		begin
			--Sentencia de la eliminacion
			delete from sigep.ttype_service_request
            where id_type_service_request=v_parametros.id_type_service_request;
               
            --Definicion de la respuesta
            v_resp = pxp.f_agrega_clave(v_resp,'mensaje','Type Service Request eliminado(a)'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_type_service_request',v_parametros.id_type_service_request::varchar);
              
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
ALTER FUNCTION "sigep"."ft_type_service_request_ime"(integer, integer, character varying, character varying) OWNER TO postgres;
