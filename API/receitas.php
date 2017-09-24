<?php

//Adiciona uma receita
function InserirReceitas(){
	
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
		if(!isset($dados["NomeReceita"]) || !isset($dados["TempodePreparo"]) || !isset($dados["Porcoes"]) || !isset($dados["Categoria"]) ||
			!isset($dados["Usuario_idUsuario"]) || !isset($dados["MododePreparo"]) || !isset($dados["Dicas"]) ||  !isset($dados["Foto"]))
		{
			$resposta = mensagens(3);
		}
		else{
			include("conectar.php");
			
			//Evita SQL injection
			$NomeReceita = mysqli_real_escape_string($conexao,$dados["NomeReceita"]);
			$TempodePreparo = mysqli_real_escape_string($conexao,$dados["TempodePreparo"]);
			$Porcoes = mysqli_real_escape_string($conexao,$dados["Porcoes"]);
			$Categoria = mysqli_real_escape_string($conexao,$dados["Categoria"]);
			$idUsuario = mysqli_real_escape_string($conexao,$dados["Usuario_idUsuario"]);
			$MododePreparo = mysqli_real_escape_string($conexao,$dados["MododePreparo"]);
			$Dicas = mysqli_real_escape_string($conexao,$dados["Dicas"]);
			$Foto = mysqli_real_escape_string($conexao,$dados["Foto"]);
			
			//Recupera idIngrediente para incrementar 1
			$idReceita = 0;
			$query = mysqli_query($conexao, "SELECT idReceita FROM Receita ORDER BY idReceita DESC LIMIT 1") or die(mysqli_error($conexao));
			while($dados = mysqli_fetch_array($query)){
				$idReceita = $dados["idReceita"];
			}
			$idReceita++;
			
			//Insere Ingrediente
			$query = mysqli_query($conexao,"INSERT INTO Receita VALUES(" .$idReceita .",'" .$NomeReceita."','" .$TempodePreparo ."','" .$Porcoes ."','" .$Categoria ."'," .$idUsuario .",'" .$MododePreparo ."','" .$Dicas ."','" .$Foto ."')") or die(mysqli_error($conexao));
			$resposta = mensagens(4);
		}
	}
	return $resposta;
}
function AtualizarReceita($id){
	
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
			if(!isset($dados["NomeReceita"]) || !isset($dados["TempodePreparo"]) || !isset($dados["Porcoes"]) || !isset($dados["Categoria"]) ||
			!isset($dados["Usuario_idUsuario"]) || !isset($dados["MododePreparo"]) || !isset($dados["Dicas"]) ||  !isset($dados["Foto"]))
		{
			$resposta = mensagens(3);
		}
			else{
				include("conectar.php");
			
				//Evita SQL injection
				$NomeReceita = mysqli_real_escape_string($conexao,$dados["NomeReceita"]);
				$TempodePreparo = mysqli_real_escape_string($conexao,$dados["TempodePreparo"]);
				$Porcoes = mysqli_real_escape_string($conexao,$dados["Porcoes"]);
				$Categoria = mysqli_real_escape_string($conexao,$dados["Categoria"]);
				$idUsuario = mysqli_real_escape_string($conexao,$dados["Usuario_idUsuario"]);
				$MododePreparo = mysqli_real_escape_string($conexao,$dados["MododePreparo"]);
				$Dicas = mysqli_real_escape_string($conexao,$dados["Dicas"]);
				$Foto = mysqli_real_escape_string($conexao,$dados["Foto"]);
						
				$update = "UPDATE Receita SET NomeReceita = '" .$NomeReceita ."', TempodePreparo = '" .$TempodePreparo."', Porcoes = '" .$Porcoes ."', Categoria = '" .$Categoria ."', idUsuario = " .$idUsuario .", MododePreparo = '" .$MododePreparo ."', Dicas = '" .$Dicas ."', Foto = '" .$Foto ."' WHERE idReceita = ".$idReceita;
								
				//Atualiza Receita no banco
				$query = mysqli_query($conexao, $update) or die(mysqli_error($conexao));
				$resposta = mensagens(6);
			}
		}
	}
	return $resposta;
}
function ExcluirReceita($id){
	
	//Recupera conteudo recebido na request
	$resposta = array();
	//Verifica se o id foi recebido
	if($id == 0){
		$resposta = mensagens(5);
	}
	else{
		include("conectar.php");
		
		//Evita SQL injection		
		$id = mysqli_real_escape_string($conexao,$id);
		
		//Exclui Receita
		$query = mysqli_query($conexao, "DELETE FROM Receita WHERE idReceita=" .$id) or die(mysqli_error($conexao));
		
		$resposta = mensagens(7);
	}
	return $resposta;
}

//Menu de Receitas por Categoria
function ListaPorCategoria($categoriaID){
	include("conectar.php");
	
	//Recebe a resposta das mensagens
	$resposta = array();
	$categoriaID = mysqli_real_escape_string($conexao,$categoriaID);
	
	//Consulta Tabela Receita no BD
	if($categoriaID == 0){
		$query = mysqli_query($conexao,"SELECT idReceita, NomeReceita, TempodePreparo, Porcoes, Categoria, MododePreparo, Dicas, Foto FROM Receita ORDER BY NomeReceita") or die(mysqli_error($conexao));
	}else{
		$query = mysqli_query($conexao,"SELECT idReceita, NomeReceita, TempodePreparo, Porcoes, Categoria, MododePreparo, Dicas, Foto FROM Receita WHERE Categoria = '". $categoriaID ."' ORDER BY NomeReceita") or die(mysqli_error($conexao));
	
	//faz um looping e cria um array com os campos da consulta
	while($dados = mysqli_fetch_array($query))
	{
		$resposta[] = array('idReceita' => $dados['idReceita'],
							'NomeReceita' => $dados['NomeReceita'],
							'MododePreparo' => $dados['MododePreparo'],
							'TempodePreparo' => $dados['TempodePreparo'],
							'Porcoes' => $dados['Porcoes'],
							'idUsuario' => $dados['idUsuario'],
							'NomeUsuario' => $dados['NomeUsuario'],
							'Categoria' => $dados['Categoria'],
							'Dicas' => $dados['Dicas'],
							'Foto' => $dados['idFoto']); 
	}
	return $resposta;
}

//Seleção de Receitas na lista de Menu 
function SelecionarReceita($receitaID){
	include("conectar.php");
	
	//Recebe a resposta das mensagens
	$resposta = array();
	$receitaID = mysqli_real_escape_string($conexao,$receitaID);
	
	//Consulta Tabela Receita no BD
	if($receitaID == 0){
		$query = mysqli_query($conexao,"SELECT idReceita, NomeReceita, TempodePreparo, Porcoes, Categoria, MododePreparo, Dicas, Foto FROM Receita") or die(mysqli_error($conexao));
	}else{
		$query = mysqli_query($conexao,"SELECT idReceita, NomeReceita, TempodePreparo, Porcoes, Categoria, MododePreparo, Dicas, Foto FROM Receita WHERE idReceita = '". $receitaID ."'") or die(mysqli_error($conexao));
	
	//faz um looping e cria um array com os campos da consulta
	while($dados = mysqli_fetch_array($query))
	{
		$resposta[] = array('idReceita' => $dados['idReceita'],
							'NomeReceita' => $dados['NomeReceita'],
							'MododePreparo' => $dados['MododePreparo'],
							'TempodePreparo' => $dados['TempodePreparo'],
							'Porcoes' => $dados['Porcoes'],
							'idUsuario' => $dados['idUsuario'],
							'NomeUsuario' => $dados['NomeUsuario'],
							'Categoria' => $dados['Categoria'],
							'Dicas' => $dados['Dicas'],
							'Foto' => $dados['idFoto']); 
	}
	return $resposta;
}

//Pesquisa de Receitas por Nome ou Ingrediente
function Pesquisar($pesquisa){
	include("conectar.php");
	
	//Recebe a resposta das mensagens
	$resposta = array();
	$pesquisa = mysqli_real_escape_string($conexao,$pesquisa);
	
	//Consulta Tabela Receita no BD
	if($pesquisa == null){
		$resposta = mensagem(2);
	}else{
		$query = mysqli_query($conexao,"SELECT R.idReceita, R.NomeReceita, R.TempodePreparo, R.Porcoes, R.Categoria, R.MododePreparo, R.Dicas, R.Foto FROM Receita as R INNER JOIN Ingrediente as I on R.idReceita = I.idReceita WHERE R.NomeReceita LIKE '". $pesquisa ."' OR I.NomeIngrediente LIKE '". $pesquisa ."' ORDER BY R.NomeReceita ") or die(mysqli_error($conexao));
	
	//faz um looping e cria um array com os campos da consulta
	while($dados = mysqli_fetch_array($query))
	{
		$resposta[] = array('idReceita' => $dados['R.idReceita'],
							'NomeReceita' => $dados['R.NomeReceita'],
							'MododePreparo' => $dados['R.MododePreparo'],
							'TempodePreparo' => $dados['R.TempodePreparo'],
							'Porcoes' => $dados['R.Porcoes'],
							'idUsuario' => $dados['R.idUsuario'],
							'NomeUsuario' => $dados['R.NomeUsuario'],
							'Categoria' => $dados['R.Categoria'],
							'Dicas' => $dados['R.Dicas'],
							'Foto' => $dados['R.idFoto']); 
	}
	return $resposta;
}
?>