CREATE OR REPLACE FUNCTION "sigep"."ft_param_sel"(	
				p_administrador integer, p_id_usuario integer, p_tabla character varying, p_transaccion character varying)
RETURNS character varying AS
$BODY$
/**************************************************************************
 SISTEMA:		Sigep
 FUNCION: 		sigep.ft_param_sel
 DESCRIPCION:   Funcion que devuelve conjuntos de registros de las consultas relacionadas con la tabla 'sigep.tparam'
 AUTOR: 		 (admin)
 FECHA:	        29-11-2018 04:35:55
 COMENTARIOS:	
***************************************************************************
 HISTORIAL DE MODIFICACIONES:
#ISSUE				FECHA				AUTOR				DESCRIPCION
 #0				29-11-2018 04:35:55								Funcion que devuelve conjuntos de registros de las consultas relacionadas con la tabla 'sigep.tparam'	
 #
 ***************************************************************************/

DECLARE

	v_consulta    		varchar;
	v_parametros  		record;
	v_nombre_funcion   	text;
	v_resp				varchar;
			    
BEGIN

	v_nombre_funcion = 'sigep.ft_param_sel';
    v_parametros = pxp.f_get_record(p_tabla);

	/*********************************    
 	#TRANSACCION:  'SIG_PARA_SEL'
 	#DESCRIPCION:	Consulta de datos
 	#AUTOR:		admin	
 	#FECHA:		29-11-2018 04:35:55
	***********************************/

	if(p_transaccion='SIG_PARA_SEL')then
     				
    	begin
    		--Sentencia de la consulta
			v_consulta:='select
						para.id_param,
						para.id_type_sigep_service_request,
						para.ctype,
						para.estado_reg,
						para.erp_json_container,
						para.sigep_name,
						para.erp_name,
						para.id_usuario_reg,
						para.fecha_reg,
						para.usuario_ai,
						para.id_usuario_ai,
						para.fecha_mod,
						para.id_usuario_mod,
						usu1.cuenta as usr_reg,
						usu2.cuenta as usr_mod,
						para.input_output,
						para.def_value
						from sigep.tparam para
						inner join segu.tusuario usu1 on usu1.id_usuario = para.id_usuario_reg
						left join segu.tusuario usu2 on usu2.id_usuario = para.id_usuario_mod
				        where  ';
			
			--Definicion de la respuesta
			v_consulta:=v_consulta||v_parametros.filtro;
			v_consulta:=v_consulta||' order by ' ||v_parametros.ordenacion|| ' ' || v_parametros.dir_ordenacion || ' limit ' || v_parametros.cantidad || ' offset ' || v_parametros.puntero;

			--Devuelve la respuesta
			return v_consulta;
						
		end;

	/*********************************    
 	#TRANSACCION:  'SIG_PARA_CONT'
 	#DESCRIPCION:	Conteo de registros
 	#AUTOR:		admin	
 	#FECHA:		29-11-2018 04:35:55
	***********************************/

	elsif(p_transaccion='SIG_PARA_CONT')then

		begin
			--Sentencia de la consulta de conteo de registros
			v_consulta:='select count(id_param)
					    from sigep.tparam para
					    inner join segu.tusuario usu1 on usu1.id_usuario = para.id_usuario_reg
						left join segu.tusuario usu2 on usu2.id_usuario = para.id_usuario_mod
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
ALTER FUNCTION "sigep"."ft_param_sel"(integer, integer, character varying, character varying) OWNER TO postgres;
