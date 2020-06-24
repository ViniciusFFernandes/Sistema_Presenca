<?php
//
//Configurações para corrigir data, exibir erros fatais e inclusão de paginas nescessarias
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);
date_default_timezone_set('America/Sao_Paulo');
require_once("../Class/DB.class.php");
require_once("../privado/constantes.php");
//
//Inicia a classe de conecção com o banco
$db = new Db($SERVIDOR, $PORTA, $USUARIO, $SENHA, $DB_NAME);
//
//Conecta com o banco de dados
$db->conectar();
?>
