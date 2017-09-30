<?php
//OK
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
		if(!isset($dados["idUsuario"]) || !isset($dados["idReceita"]))
		{
			$resposta = mensagens(3);
		}
		else{
			include("conectar.php");
			
			//Evita SQL injection
			$idUsuario = mysqli_real_escape_string($conexao,$dados["idUsuario"]);
			$idReceita = mysqli_real_escape_string($conexao,$dados["idReceita"]);
			
			//Recupera idIngrediente para incrementar 1
			$idFavorito = 0;
			$query = mysqli_query($conexao, "SELECT idFavorito FROM ReceitasFav ORDER BY idFavorito DESC LIMIT 1") or die(mysqli_error($conexao));
			while($dados = mysqli_fetch_array($query)){
				$idFavorito = $dados["idFavorito"];
			}
			$idFavorito++;
			
			//Insere uma Receita aos favoritos dos Usuario
			$query = mysqli_query($conexao,"INSERT INTO ReceitasFav VALUES(" .$idUsuario ."," .$idReceita ."," .$idFavorito .")") or die(mysqli_error($conexao));
			$resposta = mensagens(4);
		}
	}
	return $resposta;
}
//OK
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
		$idFavorito = mysqli_real_escape_string($conexao,$id);
		//$idUsuario = mysqli_real_escape_string($conexao,$id);
		//$idReceita = mysqli_real_escape_string($conexao,$id);
		
				
		//Exclui Favoritos
		$query = mysqli_query($conexao, "DELETE FROM ReceitasFav WHERE idFavorito = ".$idFavorito) or die(mysqli_error($conexao));
		
		$resposta = mensagens(7);
	}
	return $resposta;
}

//OK
//Usuario poder ver sua lista de receitas Favoritas
function SelecionarPorUsuario($idUsuario){
	include("conectar.php");
	
	//Recebe a resposta das mensagens
	$resposta = array();
	$receitaID = mysqli_real_escape_string($conexao,$idUsuario);
	
	//Consulta Tabela ReceitasFav no BD
	if($idUsuario == 0){
		$query = mysqli_query($conexao,"SELECT r.idReceita, r.NomeReceita, r.TempodePreparo, r.Porcoes, r.idCategoria, r.MododePreparo, r.Dicas, r.Foto, r.idUsuario, u.NomeUsuario FROM Receita as r INNER JOIN Usuario as u on r.idUsuario = u.idUsuario ORDER BY NomeReceita") or die(mysqli_error($conexao));
	}else{ 
		$query = mysqli_query($conexao,"SELECT r.idReceita, r.NomeReceita, r.TempodePreparo, r.Porcoes, r.idCategoria, r.MododePreparo, r.Dicas, r.Foto, r.idUsuario, u.NomeUsuario FROM Receita as r INNER JOIN Usuario as u on r.idUsuario = u.idUsuario WHERE r.idReceita = '". $idUsuario ."'") or die(mysqli_error($conexao));
	
	//faz um looping e cria um array com os campos da consulta
	while($dados = mysqli_fetch_array($query))
	{
		$resposta[] = array('idReceita' => $dados['idReceita'],
							'NomeReceita' => $dados['NomeReceita'],
							'Porcoes' => $dados['Porcoes'],
							'idUsuario' => $dados['idUsuario'],
							'NomeUsuario' => $dados['NomeUsuario'],
							'Foto' => $dados['Foto']); 
	}
	return $resposta;
	}
}
?>