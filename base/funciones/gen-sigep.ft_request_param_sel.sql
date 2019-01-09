CREATE OR REPLACE FUNCTION "sigep"."ft_request_param_sel"(	
				p_administrador integer, p_id_usuario integer, p_tabla character varying, p_transaccion character varying)
RETURNS character varying AS
$BODY$
/**************************************************************************
 SISTEMA:		Sigep
 FUNCION: 		sigep.ft_request_param_sel
 DESCRIPCION:   Funcion que devuelve conjuntos de registros de las consultas relacionadas con la tabla 'sigep.trequest_param'
 AUTOR: 		 (admin)
 FECHA:	        29-12-2018 13:30:52
 COMENTARIOS:	
***************************************************************************
 HISTORIAL DE MODIFICACIONES:
#ISSUE				FECHA				AUTOR				DESCRIPCION
 #0				29-12-2018 13:30:52								Funcion que devuelve conjuntos de registros de las consultas relacionadas con la tabla 'sigep.trequest_param'	
 #
 ***************************************************************************/

DECLARE

	v_consulta    		varchar;
	v_parametros  		record;
	v_nombre_funcion   	text;
	v_resp				varchar;
			    
BEGIN

	v_nombre_funcion = 'sigep.ft_request_param_sel';
    v_parametros = pxp.f_get_record(p_tabla);

	/*********************************    
 	#TRANSACCION:  'SIG_REQPAR_SEL'
 	#DESCRIPCION:	Consulta de datos
 	#AUTOR:		admin	
 	#FECHA:		29-12-2018 13:30:52
	***********************************/

	if(p_transaccion='SIG_REQPAR_SEL')then
     				
    	begin
    		--Sentencia de la consulta
			v_consulta:='select
						reqpar.id_request_param,
						reqpar.id_sigep_service_request,
						reqpar.value,
						reqpar.ctype,
						reqpar.name,
						reqpar.estado_reg,
						reqpar.id_usuario_ai,
						reqpar.fecha_reg,
						reqpar.usuario_ai,
						reqpar.id_usuario_reg,
						reqpar.id_usuario_mod,
						reqpar.fecha_mod,
						usu1.cuenta as usr_reg,
						usu2.cuenta as usr_mod	
						from sigep.trequest_param reqpar
						inner join segu.tusuario usu1 on usu1.id_usuario = reqpar.id_usuario_reg
						left join segu.tusuario usu2 on usu2.id_usuario = reqpar.id_usuario_mod
				        where  ';
			
			--Definicion de la respuesta
			v_consulta:=v_consulta||v_parametros.filtro;
			v_consulta:=v_consulta||' order by ' ||v_parametros.ordenacion|| ' ' || v_parametros.dir_ordenacion || ' limit ' || v_parametros.cantidad || ' offset ' || v_parametros.puntero;

			--Devuelve la respuesta
			return v_consulta;
						
		end;

	/*********************************    
 	#TRANSACCION:  'SIG_REQPAR_CONT'
 	#DESCRIPCION:	Conteo de registros
 	#AUTOR:		admin	
 	#FECHA:		29-12-2018 13:30:52
	***********************************/

	elsif(p_transaccion='SIG_REQPAR_CONT')then

		begin
			--Sentencia de la consulta de conteo de registros
			v_consulta:='select count(id_request_param)
					    from sigep.trequest_param reqpar
					    inner join segu.tusuario usu1 on usu1.id_usuario = reqpar.id_usuario_reg
						left join segu.tusuario usu2 on usu2.id_usuario = reqpar.id_usuario_mod
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
ALTER FUNCTION "sigep"."ft_request_param_sel"(integer, integer, character varying, character varying) OWNER TO postgres;
