CREATE OR REPLACE FUNCTION "sigep"."ft_user_mapping_sel"(	
				p_administrador integer, p_id_usuario integer, p_tabla character varying, p_transaccion character varying)
RETURNS character varying AS
$BODY$
/**************************************************************************
 SISTEMA:		Sigep
 FUNCION: 		sigep.ft_user_mapping_sel
 DESCRIPCION:   Funcion que devuelve conjuntos de registros de las consultas relacionadas con la tabla 'sigep.tuser_mapping'
 AUTOR: 		 (admin)
 FECHA:	        08-04-2018 11:04:46
 COMENTARIOS:	
***************************************************************************
 HISTORIAL DE MODIFICACIONES:
#ISSUE				FECHA				AUTOR				DESCRIPCION
 #0				08-04-2018 11:04:46								Funcion que devuelve conjuntos de registros de las consultas relacionadas con la tabla 'sigep.tuser_mapping'	
 #
 ***************************************************************************/

DECLARE

	v_consulta    		varchar;
	v_parametros  		record;
	v_nombre_funcion   	text;
	v_resp				varchar;
			    
BEGIN

	v_nombre_funcion = 'sigep.ft_user_mapping_sel';
    v_parametros = pxp.f_get_record(p_tabla);

	/*********************************    
 	#TRANSACCION:  'SIG_USM_SEL'
 	#DESCRIPCION:	Consulta de datos
 	#AUTOR:		admin	
 	#FECHA:		08-04-2018 11:04:46
	***********************************/

	if(p_transaccion='SIG_USM_SEL')then
     				
    	begin
    		--Sentencia de la consulta
			v_consulta:='select
						usm.id_user_mapping,
						usm.refresh_token,
						usm.sigep_user,
						usm.access_token,
						usm.date_issued_at,
						usm.expires_in,
						usm.estado_reg,
						usm.date_issued_rt,
						usm.pxp_user,
						usm.id_usuario_ai,
						usm.id_usuario_reg,
						usm.fecha_reg,
						usm.usuario_ai,
						usm.id_usuario_mod,
						usm.fecha_mod,
						usu1.cuenta as usr_reg,
						usu2.cuenta as usr_mod	
						from sigep.tuser_mapping usm
						inner join segu.tusuario usu1 on usu1.id_usuario = usm.id_usuario_reg
						left join segu.tusuario usu2 on usu2.id_usuario = usm.id_usuario_mod
				        where  ';
			
			--Definicion de la respuesta
			v_consulta:=v_consulta||v_parametros.filtro;
			v_consulta:=v_consulta||' order by ' ||v_parametros.ordenacion|| ' ' || v_parametros.dir_ordenacion || ' limit ' || v_parametros.cantidad || ' offset ' || v_parametros.puntero;

			--Devuelve la respuesta
			return v_consulta;
						
		end;

	/*********************************    
 	#TRANSACCION:  'SIG_USM_CONT'
 	#DESCRIPCION:	Conteo de registros
 	#AUTOR:		admin	
 	#FECHA:		08-04-2018 11:04:46
	***********************************/

	elsif(p_transaccion='SIG_USM_CONT')then

		begin
			--Sentencia de la consulta de conteo de registros
			v_consulta:='select count(id_user_mapping)
					    from sigep.tuser_mapping usm
					    inner join segu.tusuario usu1 on usu1.id_usuario = usm.id_usuario_reg
						left join segu.tusuario usu2 on usu2.id_usuario = usm.id_usuario_mod
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
ALTER FUNCTION "sigep"."ft_user_mapping_sel"(integer, integer, character varying, character varying) OWNER TO postgres;
