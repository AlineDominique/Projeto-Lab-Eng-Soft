<?php
//Adiciona Favoritos 
function InserirFavoritos(){
	
	//Recupera conteudo recebido na request
	$conteudo = file_get_contents("php://input");
	//Variavel que recebe as mensagens
	$resposta = array();
	
	//Verifica se o conteudo foi recebido
	if(empty($conteudo)){
		$resposta = mensagens(2);
	}
	else{
		//Converte o json recebido pra array
		$dados = json_decode($conteudo,true);
		
		//Verifica se as infromações esperadas foram recebidas
		if(!isset($dados["Receita_idReceita"]) || !isset($dados["Usuario_idUsuario"]))
		{
			$resposta = mensagens(3);
		}
		else{
			include("conectar.php");
			
			//Evita SQL injection
			$idReceita = mysqli_real_escape_string($conexao,$dados["Receita_idReceita"]);
			$idUsuario = mysqli_real_escape_string($conexao,$dados["Usuario_idUsuario"]);
								
			//Insere uma Receita aos favoritos dos Usuario
			$query = mysqli_query($conexao,"INSERT INTO ReceitasFav VALUES(" .$idReceita ."," .$idUsuario .")") or die(mysqli_error($conexao));
			$resposta = mensagens(4);
		}
	}
	return $resposta;
}

//Deleta Favoritos
function ExcluirFavoritos($id){
	
	//Recupera conteudo recebido na request
	$resposta = array();
	
	//Verifica se o id foi recebido
	if($id == 0){
		$resposta = mensagens(5);
	}
	else{
		include("conectar.php");
		
		//Evita SQL injection		
		$idReceita = mysqli_real_escape_string($conexao,$id);
		$idUsuario = mysqli_real_escape_string($conexao,$id);
				
		//Exclui Ingrediente
		$query = mysqli_query($conexao, "DELETE FROM ReceitasFav WHERE idReceita= " .$idReceita. "AND idUsuario= " .$idUsuario) or die(mysqli_error($conexao));
		
		$resposta = mensagens(7);
	}
	return $resposta;
}?>