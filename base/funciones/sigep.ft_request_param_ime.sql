CREATE OR REPLACE FUNCTION "sigep"."ft_request_param_ime" (	
				p_administrador integer, p_id_usuario integer, p_tabla character varying, p_transaccion character varying)
RETURNS character varying AS
$BODY$

/**************************************************************************
 SISTEMA:		Sigep
 FUNCION: 		sigep.ft_request_param_ime
 DESCRIPCION:   Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla 'sigep.trequest_param'
 AUTOR: 		 (admin)
 FECHA:	        29-12-2018 13:30:52
 COMENTARIOS:	
***************************************************************************
 HISTORIAL DE MODIFICACIONES:
#ISSUE				FECHA				AUTOR				DESCRIPCION
 #0				29-12-2018 13:30:52								Funcion que gestiona las operaciones basicas (inserciones, modificaciones, eliminaciones de la tabla 'sigep.trequest_param'	
 #
 ***************************************************************************/

DECLARE

	v_nro_requerimiento    	integer;
	v_parametros           	record;
	v_id_requerimiento     	integer;
	v_resp		            varchar;
	v_nombre_funcion        text;
	v_mensaje_error         text;
	v_id_request_param	integer;
			    
BEGIN

    v_nombre_funcion = 'sigep.ft_request_param_ime';
    v_parametros = pxp.f_get_record(p_tabla);

	/*********************************    
 	#TRANSACCION:  'SIG_REQPAR_INS'
 	#DESCRIPCION:	Insercion de registros
 	#AUTOR:		admin	
 	#FECHA:		29-12-2018 13:30:52
	***********************************/

	if(p_transaccion='SIG_REQPAR_INS')then
					
        begin
        	--Sentencia de la insercion
        	insert into sigep.trequest_param(
			id_sigep_service_request,
			value,
			ctype,
			name,
			estado_reg,
			id_usuario_reg,
			input_output
          	) values(
			v_parametros.id_sigep_service_request,
			v_parametros.value,
			v_parametros.ctype,
			v_parametros.name,
			'activo',			
			p_id_usuario,
			v_parametros.input_output
			
			)RETURNING id_request_param into v_id_request_param;
			
			--Definicion de la respuesta
			v_resp = pxp.f_agrega_clave(v_resp,'mensaje','REQUEST PARAM almacenado(a) con exito (id_request_param'||v_id_request_param||')'); 
            v_resp = pxp.f_agrega_clave(v_resp,'id_request_param',v_id_request_param::varchar);

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
ALTER FUNCTION "sigep"."ft_request_param_ime"(integer, integer, character varying, character varying) OWNER TO postgres;
