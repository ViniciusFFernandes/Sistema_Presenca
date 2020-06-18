<?php 
	include_once '../_BD/conecta_login.php';
	//
	$_POST['campoMostra'] = $_POST['campoMostra'];
	//
	$sql = "SELECT {$_POST['campoMostra']} AS mostra, {$_POST['campoId']} AS id FROM {$_POST['tabela']} ";
	//
	if($_POST['where'] <> '' ){
		$_POST['where'] = $_POST['where'];
		// $_POST['where'] = str_replace("##valor##", $_POST['consulta'], $_POST['where']);
		$sql .= $_POST['where'];
	}
	//
	$sql .= " LIMIT {$_POST['qteLimit']}";
	// echo $sql;
	//
	$dados = $db->consultar($sql);
	$json = json_encode($dados);
	echo $json;
	exit;
 ?>