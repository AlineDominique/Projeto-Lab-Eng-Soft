<?php
function mensagens($codigo){
	$mensagens = array(
					array(
						"Codigo"=>1
						,"Mensagem"=>"Caminho especificado nao encontrado"
					)
					,array(
						"Codigo"=>2
						,"Mensagem"=>"Nenhum dado recebido"
					)
					,array(
						"Codigo"=>3
						,"Mensagem"=>"Estrutura de dados diferente do esperado"
					)
					,array(
						"Codigo"=>4	
						,"Mensagem"=>"Inserido com sucesso!"
					)
					,array(
						"Codigo"=>5	
						,"Mensagem"=>"Código inválido"
					)
					
					,array(
						"Codigo"=>6	
						,"Mensagem"=>"Atualizado com sucesso"
					)
					,array(
						"Codigo"=>7	
						,"Mensagem"=>"Excluído com sucesso"
					)
					,array(
						"Codigo"=>8	
						,"Mensagem"=>"Usuário excluído com sucesso"
					)
					,array(
						"Codigo"=>9	
						,"Mensagem"=>"Usuário encontrado"
					)
					,array(
						"Codigo"=>10
						,"Mensagem"=>"Email já cadastrado!"
					)
					,array(
						"Codigo"=>11
						,"Mensagem"=>"Codigo invalido!"
					)
				 );
	$retorno = array();
	//Busca pelo erro com o codigo informado de parâmetro
	foreach($mensagens as $item){
		if($item["Codigo"] == $codigo){
			$retorno = $item;
			break;
		}
	}
	return $retorno;
}
?>