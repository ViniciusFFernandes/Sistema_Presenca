<?php
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);
date_default_timezone_set('America/Sao_Paulo');
require_once("../Class/DB.class.php");
require_once("../privado/constantes.php");
//
$db = new Db($SERVIDOR, $PORTA, $USUARIO, $SENHA, $DB_NAME);
//
//Conecta com o banco de dados
$db->conectar();
?>
