CREATE OR REPLACE FUNCTION "sigep"."ft_type_sigep_service_request_sel"(	
				p_administrador integer, p_id_usuario integer, p_tabla character varying, p_transaccion character varying)
RETURNS character varying AS
$BODY$
/**************************************************************************
 SISTEMA:		Sigep
 FUNCION: 		sigep.ft_type_sigep_service_request_sel
 DESCRIPCION:   Funcion que devuelve conjuntos de registros de las consultas relacionadas con la tabla 'sigep.ttype_sigep_service_request'
 AUTOR: 		 (admin)
 FECHA:	        30-11-2018 15:13:43
 COMENTARIOS:	
***************************************************************************
 HISTORIAL DE MODIFICACIONES:
#ISSUE				FECHA				AUTOR				DESCRIPCION
 #0				30-11-2018 15:13:43								Funcion que devuelve conjuntos de registros de las consultas relacionadas con la tabla 'sigep.ttype_sigep_service_request'	
 #
 ***************************************************************************/

DECLARE

	v_consulta    		varchar;
	v_parametros  		record;
	v_nombre_funcion   	text;
	v_resp				varchar;
			    
BEGIN

	v_nombre_funcion = 'sigep.ft_type_sigep_service_request_sel';
    v_parametros = pxp.f_get_record(p_tabla);

	/*********************************    
 	#TRANSACCION:  'SIG_TSSR_SEL'
 	#DESCRIPCION:	Consulta de datos
 	#AUTOR:		admin	
 	#FECHA:		30-11-2018 15:13:43
	***********************************/

	if(p_transaccion='SIG_TSSR_SEL')then
     				
    	begin
    		--Sentencia de la consulta
			v_consulta:='select
						tssr.id_type_sigep_service_request,
						tssr.id_type_service_request,
						tssr.exec_order,
						tssr.queue_method,
						tssr.estado_reg,
						tssr.time_to_refresh,
						tssr.queue_url,
						tssr.method_type,
						tssr.sigep_service_name,
						tssr.sigep_url,
						tssr.usuario_ai,
						tssr.fecha_reg,
						tssr.id_usuario_reg,
						tssr.id_usuario_ai,
						tssr.fecha_mod,
						tssr.id_usuario_mod,
						usu1.cuenta as usr_reg,
						usu2.cuenta as usr_mod,
						tssr.revert_url,
						tssr.revert_method,
						tssr.user_param,
						tssr.json_main_container
						from sigep.ttype_sigep_service_request tssr
						inner join segu.tusuario usu1 on usu1.id_usuario = tssr.id_usuario_reg
						left join segu.tusuario usu2 on usu2.id_usuario = tssr.id_usuario_mod
				        where  ';
			
			--Definicion de la respuesta
			v_consulta:=v_consulta||v_parametros.filtro;
			v_consulta:=v_consulta||' order by ' ||v_parametros.ordenacion|| ' ' || v_parametros.dir_ordenacion || ' limit ' || v_parametros.cantidad || ' offset ' || v_parametros.puntero;

			--Devuelve la respuesta
			return v_consulta;
						
		end;

	/*********************************    
 	#TRANSACCION:  'SIG_TSSR_CONT'
 	#DESCRIPCION:	Conteo de registros
 	#AUTOR:		admin	
 	#FECHA:		30-11-2018 15:13:43
	***********************************/

	elsif(p_transaccion='SIG_TSSR_CONT')then

		begin
			--Sentencia de la consulta de conteo de registros
			v_consulta:='select count(id_type_sigep_service_request)
					    from sigep.ttype_sigep_service_request tssr
					    inner join segu.tusuario usu1 on usu1.id_usuario = tssr.id_usuario_reg
						left join segu.tusuario usu2 on usu2.id_usuario = tssr.id_usuario_mod
					    where ';
			
			--Definicion de la respuesta		    
			v_consulta:=v_consulta||v_parametros.filtro;

			--Devuelve la respuesta
			return v_consulta;

		end;
					
	else
					     
		raise exception 'Transaccion inexistente';
					         
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
ALTER FUNCTION "sigep"."ft_type_sigep_service_request_sel"(integer, integer, character varying, character varying) OWNER TO postgres;
