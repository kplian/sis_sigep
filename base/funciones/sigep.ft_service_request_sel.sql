CREATE OR REPLACE FUNCTION "sigep"."ft_service_request_sel"(	
				p_administrador integer, p_id_usuario integer, p_tabla character varying, p_transaccion character varying)
RETURNS character varying AS
$BODY$
/**************************************************************************
 SISTEMA:		Sigep
 FUNCION: 		sigep.ft_service_request_sel
 DESCRIPCION:   Funcion que devuelve conjuntos de registros de las consultas relacionadas con la tabla 'sigep.tservice_request'
 AUTOR: 		 (admin)
 FECHA:	        27-12-2018 13:10:13
 COMENTARIOS:	
***************************************************************************
 HISTORIAL DE MODIFICACIONES:
#ISSUE				FECHA				AUTOR				DESCRIPCION
 #0				27-12-2018 13:10:13								Funcion que devuelve conjuntos de registros de las consultas relacionadas con la tabla 'sigep.tservice_request'	
 #
 ***************************************************************************/

DECLARE

	v_consulta    		varchar;
	v_parametros  		record;
	v_nombre_funcion   	text;
	v_resp				varchar;
			    
BEGIN

	v_nombre_funcion = 'sigep.ft_service_request_sel';
    v_parametros = pxp.f_get_record(p_tabla);

	/*********************************    
 	#TRANSACCION:  'SIG_SERE_SEL'
 	#DESCRIPCION:	Consulta de datos
 	#AUTOR:		admin	
 	#FECHA:		27-12-2018 13:10:13
	***********************************/

	if(p_transaccion='SIG_SERE_SEL')then
     				
    	begin
    		--Sentencia de la consulta
			v_consulta:='select
						sere.id_service_request,
						sere.id_type_service_request,
						sere.estado_reg,
						sere.date_finished,
						sere.status,
						sere.sys_origin,
						sere.ip_origin,
						sere.last_message,
						sere.usuario_ai,
						sere.fecha_reg,
						sere.id_usuario_reg,
						sere.id_usuario_ai,
						sere.id_usuario_mod,
						sere.fecha_mod,
						usu1.cuenta as usr_reg,
						usu2.cuenta as usr_mod,
						tsr.service_code,
						tsr.description,
						sere.last_message_revert	
						from sigep.tservice_request sere
						inner join segu.tusuario usu1 on usu1.id_usuario = sere.id_usuario_reg
						inner join sigep.ttype_service_request tsr on tsr.id_type_service_request = sere.id_type_service_request
						left join segu.tusuario usu2 on usu2.id_usuario = sere.id_usuario_mod
				        where  ';
			
			--Definicion de la respuesta
			v_consulta:=v_consulta||v_parametros.filtro;
			v_consulta:=v_consulta||' order by ' ||v_parametros.ordenacion|| ' ' || v_parametros.dir_ordenacion || ' limit ' || v_parametros.cantidad || ' offset ' || v_parametros.puntero;

			--Devuelve la respuesta
			return v_consulta;
						
		end;

	/*********************************    
 	#TRANSACCION:  'SIG_SERE_CONT'
 	#DESCRIPCION:	Conteo de registros
 	#AUTOR:		admin	
 	#FECHA:		27-12-2018 13:10:13
	***********************************/

	elsif(p_transaccion='SIG_SERE_CONT')then

		begin
			--Sentencia de la consulta de conteo de registros
			v_consulta:='select count(id_service_request)
					    from sigep.tservice_request sere
					    inner join segu.tusuario usu1 on usu1.id_usuario = sere.id_usuario_reg
					    inner join sigep.ttype_service_request tsr on tsr.id_type_service_request = sere.id_type_service_request
						left join segu.tusuario usu2 on usu2.id_usuario = sere.id_usuario_mod
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
ALTER FUNCTION "sigep"."ft_service_request_sel"(integer, integer, character varying, character varying) OWNER TO postgres;
