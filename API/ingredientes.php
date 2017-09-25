<?php

function InserirIngrediente(){
	
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
		if(!isset($dados["NomeIngrediente"]) || !isset($dados["Observacao"]) || !isset($dados["UnidMedida"]) || !isset($dados["Quantidade"]) ||
			!isset($dados["idReceita"]))
		{
			$resposta = mensagens(3);
		}
		else{
			include("conectar.php");
			
			//Evita SQL injection
			$NomeIngrediente = mysqli_real_escape_string($conexao,$dados["NomeIngrediente"]);
			$Observacao = mysqli_real_escape_string($conexao,$dados["Observacao"]);
			$UnidMedida = mysqli_real_escape_string($conexao,$dados["UnidMedida"]);
			$Quantidade = mysqli_real_escape_string($conexao,$dados["Quantidade"]);
			$idReceita = mysqli_real_escape_string($conexao,$dados["idReceita"]);
					
			//Recupera idIngrediente para incrementar 1
			$idIngrediente = 0;
			$query = mysqli_query($conexao, "SELECT idIngrediente FROM Ingredientes ORDER BY idIngrediente DESC LIMIT 1") or die(mysqli_error($conexao));
			while($dados = mysqli_fetch_array($query)){
				$idIngrediente = $dados["idIngrediente"];
			}
			$idIngrediente++;
			
			//Insere Ingrediente
			$query = mysqli_query($conexao,"INSERT INTO Ingredientes VALUES(" .$idIngrediente .",'" .$NomeIngrediente."','" .$Observacao ."','" .$UnidMedida ."','" .$Quantidade ."'," .$idReceita .")") or die(mysqli_error($conexao));
			$resposta = mensagens(4);
		}
	}
	return $resposta;
}
function AtualizarIngrediente($id){
	
	//Recupera conteudo recebido na request
	$conteudo = file_get_contents("php://input");
	$resposta = array();
	//Verifica se o id foi recebido
	if($id == 0){
		$resposta = mensagens(5);
	}
	else{
		//Verifica se o conteudo foi recebido
		if(empty($conteudo)){
			$resposta = mensagens(2);
		}
		else{
			//Converte o json recebido pra array
			$dados = json_decode($conteudo,true);
			
			//Verifica se as infromações esperadas foram recebidas
			if(!isset($dados["NomeIngrediente"]) || !isset($dados["Observacao"]) || !isset($dados["UnidMedida"]) || !isset($dados["Quantidade"]) ||
			!isset($dados["idReceita"]))
			{
				$resposta = mensagens(3);
			}
			else
			{
				include("conectar.php");
				
				//Evita SQL injection
				$NomeIngrediente = mysqli_real_escape_string($conexao,$dados["NomeIngrediente"]);
				$Observacao = mysqli_real_escape_string($conexao,$dados["Observacao"]);
				$UnidMedida = mysqli_real_escape_string($conexao,$dados["UnidMedida"]);
				$Quantidade = mysqli_real_escape_string($conexao,$dados["Quantidade"]);
				$idReceita = mysqli_real_escape_string($conexao,$dados["idReceita"]);
					
				$update = "UPDATE Ingredientes SET NomeIngrediente = '" .$NomeIngrediente ."', Observacao = '" .$Observacao ."', Quantidade = '" .$Quantidade ."', idReceita = " .$idReceita ." WHERE idIngrediente = ".$id;		
				
				//Atualiza Ingredientes no banco
				$query = mysqli_query($conexao, $update) or die(mysqli_error($conexao));
				$resposta = mensagens(6);
			}
		}
	}
	return $resposta;
}
function ExcluirIngrediente($id){
	
	//Recupera conteudo recebido na request
	$resposta = array();
	//Verifica se o id foi recebido
	if($id == 0){
		$resposta = mensagens(5);
	}
	else{
		include("conectar.php");
		
		//Evita SQL injection		
		$idIngrediente = mysqli_real_escape_string($conexao,$id);
		
		//Exclui Ingrediente
		$query = mysqli_query($conexao, "DELETE FROM Ingredientes WHERE idIngrediente=" .$idIngrediente) or die(mysqli_error($conexao));
		
		$resposta = mensagens(7);
	}
	return $resposta;
}
?>