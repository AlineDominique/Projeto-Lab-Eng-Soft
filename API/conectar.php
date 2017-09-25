<?php
//$ServerBD = $_SERVER['SERVER_NAME'];
if(!isset($PortaBD)){
    $conexao = mysqli_connect("mysql.hostinger.com.br","u487200405_vegs", "r3c31t45v3g");
}
//$conect = mysqli_connect('localhost', "root", "");
// Caso a conexão seja reprovada, exibe na tela uma mensagem de erro
if (!$conexao) die ('<div id="erro2">Falha na coneco com o Banco de Dados!</div>');
// Caso a conexão seja aprovada, então conecta o Banco de Dados.	
$db = mysqli_select_db($conexao,"u487200405_bdveg");
?>