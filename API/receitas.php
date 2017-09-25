<?php

//Adiciona uma receita OK
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
		if(!isset($dados["NomeReceita"]) || !isset($dados["TempodePreparo"]) || !isset($dados["Porcoes"]) || !isset($dados["idUsuario"]) 
			|| !isset($dados["MododePreparo"]) || !isset($dados["Dicas"]) ||  !isset($dados["Foto"]) || !isset($dados["idCategoria"]) )
		{
			$resposta = mensagens(3);
		}
		else{
			include("conectar.php");
			
			//Evita SQL injection
			$NomeReceita = mysqli_real_escape_string($conexao,$dados["NomeReceita"]);
			$TempodePreparo = mysqli_real_escape_string($conexao,$dados["TempodePreparo"]);
			$Porcoes = mysqli_real_escape_string($conexao,$dados["Porcoes"]);
			$idUsuario = mysqli_real_escape_string($conexao,$dados["idUsuario"]);
			$MododePreparo = mysqli_real_escape_string($conexao,$dados["MododePreparo"]);
			$Dicas = mysqli_real_escape_string($conexao,$dados["Dicas"]);
			$Foto = mysqli_real_escape_string($conexao,$dados["Foto"]);
			$idCategoria = mysqli_real_escape_string($conexao,$dados["idCategoria"]);
			
			//Recupera idIngrediente para incrementar 1
			$idReceita = 0;
			$query = mysqli_query($conexao, "SELECT idReceita FROM Receita ORDER BY idReceita DESC LIMIT 1") or die(mysqli_error($conexao));
			while($dados = mysqli_fetch_array($query)){
				$idReceita = $dados["idReceita"];
			}
			$idReceita++;
			
			//Insere Ingrediente
			$query = mysqli_query($conexao,"INSERT INTO Receita VALUES(" .$idReceita .",'" .$NomeReceita."','" .$TempodePreparo ."','" .$Porcoes ."'," .$idUsuario .",'" .$MododePreparo ."','" .$Dicas ."','" .$Foto ."'," .$idCategoria .")") or die(mysqli_error($conexao));
			$resposta = mensagens(4);
		}
	}
	return $resposta;
}

// Com Erro
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
			if(!isset($dados["NomeReceita"]) || !isset($dados["TempodePreparo"]) || !isset($dados["Porcoes"]) || !isset($dados["idUsuario"])
				|| !isset($dados["MododePreparo"]) || !isset($dados["Dicas"]) ||  !isset($dados["Foto"]) || !isset($dados["idCategoria"]))
		{
			$resposta = mensagens(3);
		}
			else{
				include("conectar.php");
			
				//Evita SQL injection
				$NomeReceita = mysqli_real_escape_string($conexao,$dados["NomeReceita"]);
				$TempodePreparo = mysqli_real_escape_string($conexao,$dados["TempodePreparo"]);
				$Porcoes = mysqli_real_escape_string($conexao,$dados["Porcoes"]);
				$idUsuario = mysqli_real_escape_string($conexao,$dados["idUsuario"]);
				$MododePreparo = mysqli_real_escape_string($conexao,$dados["MododePreparo"]);
				$Dicas = mysqli_real_escape_string($conexao,$dados["Dicas"]);
				$Foto = mysqli_real_escape_string($conexao,$dados["Foto"]);
				$idCategoria = mysqli_real_escape_string($conexao,$dados["idCategoria"]);
						
				$update = "UPDATE Receita SET NomeReceita = '" .$NomeReceita ."', TempodePreparo = '" .$TempodePreparo."', Porcoes = '" .$Porcoes ."', idUsuario = " .$idUsuario .", MododePreparo = '" .$MododePreparo ."', Dicas = '" .$Dicas ."', Foto = '" .$Foto ."', idCategoria = " .$idCategoria ." WHERE idReceita = ". $idReceita;
								
				//Atualiza Receita no banco
				$query = mysqli_query($conexao, $update) or die(mysqli_error($conexao));
				$resposta = mensagens(6);
			}
		}
	}
	return $resposta;
}
// OK
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

//Menu de Receitas por Categoria OK
function ListaPorCategoria($categoriaID){
	include("conectar.php");
	
	//Recebe a resposta das mensagens
	$resposta = array();
	$categoriaID = mysqli_real_escape_string($conexao,$categoriaID);
	
	//Consulta Tabela Receita no BD
	if($categoriaID == 0){
		$query = mysqli_query($conexao,"SELECT r.idReceita, r.NomeReceita, r.TempodePreparo, r.Porcoes, r.idCategoria, r.MododePreparo, r.Dicas, r.Foto, r.idUsuario, u.NomeUsuario FROM Receita as r INNER JOIN Usuario as u on r.idUsuario = u.idUsuario ORDER BY NomeReceita") or die(mysqli_error($conexao));
	}else{
		$query = mysqli_query($conexao,"SELECT r.idReceita, r.NomeReceita, r.TempodePreparo, r.Porcoes, r.idCategoria, r.MododePreparo, r.Dicas, r.Foto , r.idUsuario, u.NomeUsuario FROM Receita as r INNER JOIN Usuario as u on r.idUsuario = u.idUsuario WHERE idCategoria = '". $categoriaID ."' ORDER BY NomeReceita") or die(mysqli_error($conexao));
	
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
							'idCategoria' => $dados['idCategoria'],
							'Dicas' => $dados['Dicas'],
							'Foto' => $dados['idFoto']); 
	}
	return $resposta;
	}
}

//Seleção de Receitas na lista de Menu OK
function SelecionarReceita($receitaID){
	include("conectar.php");
	
	//Recebe a resposta das mensagens
	$resposta = array();
	$receitaID = mysqli_real_escape_string($conexao,$receitaID);
	
	//Consulta Tabela Receita no BD
	if($receitaID == 0){
		$query = mysqli_query($conexao,"SELECT r.idReceita, r.NomeReceita, r.TempodePreparo, r.Porcoes, r.idCategoria, r.MododePreparo, r.Dicas, r.Foto, r.idUsuario, u.NomeUsuario FROM Receita as r INNER JOIN Usuario as u on r.idUsuario = u.idUsuario ORDER BY NomeReceita") or die(mysqli_error($conexao));
	}else{ 
		$query = mysqli_query($conexao,"SELECT r.idReceita, r.NomeReceita, r.TempodePreparo, r.Porcoes, r.idCategoria, r.MododePreparo, r.Dicas, r.Foto, r.idUsuario, u.NomeUsuario FROM Receita as r INNER JOIN Usuario as u on r.idUsuario = u.idUsuario WHERE r.idReceita = '". $receitaID ."'") or die(mysqli_error($conexao));
	
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
							'idCategoria' => $dados['idCategoria'],
							'Dicas' => $dados['Dicas'],
							'Foto' => $dados['Foto']); 
	}
	return $resposta;
	}
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
		$query = mysqli_query($conexao,"SELECT r.idReceita, r.NomeReceita, r.TempodePreparo, r.Porcoes, r.idCategoria, r.MododePreparo, r.Dicas,
		r.Foto, u.idUsuario, u.NomeUsuario FROM Receita as r INNER JOIN Ingredientes as i 
		INNER JOIN Usuario as u on r.idReceita = i.idReceita 
		WHERE r.NomeReceita LIKE '%". $pesquisa ."%' OR i.NomeIngrediente LIKE '%". $pesquisa ."%' ORDER BY r.NomeReceita ") or die(mysqli_error($conexao));
	
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
							'idCategoria' => $dados['idCategoria'],
							'Dicas' => $dados['Dicas'],
							'Foto' => $dados['Foto']); 
	}
	return $resposta;
	}
}
?>