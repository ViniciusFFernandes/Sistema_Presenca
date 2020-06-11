<?php
	//
	//Classe usada para se conectar com o banco de dados e executar ações no banco 
	//
	class Db {
		private $host;
		private $porta;
		private $usudb;
		private $nomedb;
		private $senhadb;
		private $conexao;
		private $tabela;
		private $idtabela;
		private $msgErro;
		private $erro;
		//
		//Metodo construtor da class
		function __construct($host, $porta, $usudb, $senhadb, $nomedb){
			$this->host = $host;
			$this->porta = $porta;
			$this->nomedb = $nomedb;
			$this->usudb = $usudb;
			$this->senhadb = $senhadb;
		}
		//
		//Metodo para criar uma conexão com o banco de dados
		public function conectar(){
			try{	
				if(!isset($this->conexao)){
					$dados = "mysql:host=" . $this->host;
					$dados = $dados . ";port=" . $this->porta;
					$dados = $dados . ";dbname=" . $this->nomedb;
					$this->conexao = new PDO($dados, $this->usudb, $this->senhadb, array(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => true, PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));   // pdo php data objectve, classe generica pra banco de dados
					$this->conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
					$this->conexao->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
				}
			}catch(PDOException $e){
				if(preg_match('/Unknown database/', $e->getMessage())){
					//Cria o banco e suas tabelas
					$this->criarBase();
				}else{
					echo 'ERROR: ' . $e->getMessage();
				}
			}
		}
		//
		//Metodo usado para retornar se a execução deu erro ou não
		public function erro(){
			return $this->erro;
		}
		//
		//Metodo usado para retornar mensagem de erros da execução
		public function getErro(){
			return $this->msgErro;
		}
		//
		//Metodo usado para executar select
		public function consultar($sql){
		  	$sql = trim($sql);
		  	$this->erro = '';
		  	$this->msgErro = '';
			try{
				$query = $this->conexao->query($sql);
				$query->execute();
				$dados = $query->fetchAll(PDO::FETCH_ASSOC);
				$query->closeCursor();
				$this->erro = false;
			}catch(PDOException $e) {
				$resultado = NULL;
				$this->erro = true;
				$this->msgErro = $e->getMessage();
				$mensagem  = $e->getMessage();				
			}
			//
			//print_r($dados);
		  return $dados;
		}
		//
		//Metodo usado quando a cunsulta retorna somente um registro
		public function retornaUmReg($sql){
			$this->erro = '';
			$this->msgErro = '';
			$sql = trim($sql);
			try{
				$query = $this->conexao->query($sql);
				$query->execute();
				$resultado = $query->fetch(PDO::FETCH_ASSOC);  // fetch = recuperação do resultado
				$query->closeCursor();
			}
			catch(PDOException $e) {
				$resultado = NULL;
				$this->erro = true;
				$this->msgErro = $e->getMessage();
				$mensagem  = $e->getMessage();
			}
		 	return $resultado;
		}
		//
		//Metodo usado para executar um select de um unico campo
		public function executaSQL($sql){
			$sql = trim($sql);
			$this->erro = '';
			$this->msgErro = '';
			try{
				$this->conexao->exec($sql);
				$this->erro = false;
			}catch(PDOException $e) {
				$this->erro = true;
				$this->msgErro = $e->getMessage();
				$mensagem  = $e->getMessage();				
			}
	  	}
	}


?>
