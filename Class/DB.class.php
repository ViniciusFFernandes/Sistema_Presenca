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
		private $transactionAtivo;
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
		//Metodo usado para criar uma transação
		public function beginTransaction(){
			$this->conexao->beginTransaction();
		}
		//
		//Metodo usado para finalizar uma transação
		public function commit(){
			$this->conexao->commit();
		}
		//
		//Metodo usado para reverter uma transação
		public function rollBack(){
			$this->conexao->rollBack();
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
		//Metodo usado para setar tabela para execuções
		public function setTabela($tabela, $idtabela){
			$this->tabela = $tabela;
			$this->idtabela = $idtabela;
		}
		//
		//Metodo usado retornar o id da ultima execução
		public function getUltimoID(){
			$nomeID = 'id'. $this->tabela;
			$sql = "SELECT " . $nomeID . " FROM " . $this->tabela . " ORDER BY " . $nomeID . " DESC LIMIT 1";
			$query = $this->conexao->query($sql);
			$query->execute();
			$resultado = $query->fetch(PDO::FETCH_ASSOC);  // fetch = recuperação do resultado
			$query->closeCursor();
			return $resultado[$nomeID];
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
				file_put_contents("../erro.log", "\n\nData: " . date("d/m/Y H:i") . "\nErro: " . $mensagem, FILE_APPEND);
				
			}
			//
			//print_r($dados);
		  return $dados;
		}
		//
		//Metodo usado para executar um select de uma linha
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
				file_put_contents("../erro.log", "\n\nData: " . date("d/m/Y H:i") . "\nErro: " . $mensagem, FILE_APPEND);
			}
		 	return $resultado;
		}
		//
		//Metodo usado para executar um select de um unico campo
		public function retornaUmCampoSql($sql, $campo){
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
				file_put_contents("../erro.log", "\n\nData: " . date("d/m/Y H:i") . "\nErro: " . $mensagem, FILE_APPEND);
			}

			return $resultado[$campo];
		}
		//
		//Metodo usado para executar um select de um unico campo pelo id da tabela
		public function retornaUmCampoID($campo, $tabela, $id){
			$this->erro = '';
			$this->msgErro = '';
			$sql = "SELECT {$campo} AS campo FROM {$tabela} WHERE id{$tabela} = {$id}";
			$sql = trim($sql);
			try{
				// $resultado=$this->conexao->query($sql);
				// $this->erro = false;
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
				file_put_contents("../erro.log", "\n\nData: " . date("d/m/Y H:i") . "\nErro: " . $mensagem, FILE_APPEND);
			}

			return $resultado["campo"];
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
				file_put_contents("../erro.log", "\n\nData: " . date("d/m/Y H:i") . "\nErro: " . $mensagem, FILE_APPEND);
				
			}
	  	}
		//
		//Metodo usado para definir se deve inserir ou atualizar dados
	  	public function gravarInserir($dados){
	  		if(!empty($dados['id'])){
	  			return $this->alterar($dados);
	  		}else{
	  			unset($dados['id']);
	  			return $this->gravar($dados);
	  		}
	  	}
		//
		//Metodo usado para atualizar dados
		public function gravar($dados = null){
			$campos   = implode(",",array_keys($dados));
			$valores  = implode(",",array_values($dados));
			$query = "INSERT INTO " . $this->tabela . " (" .
					  $campos." ) VALUES ( " . $valores . " ) ";
			return $this->executaSQL($query);
		}
		//
		//Metodo usado para inserir dados
		public function alterar($dados = null){
			if(!is_null($dados)){
				$valores = array();
				foreach($dados as $key=>$value){
					if($key != 'id') $valores[] = $key . " = " . $value;
				}
				$valores = implode(',',$valores);
				$query = "UPDATE " . $this->tabela . " SET " . $valores . " WHERE " . $this->idtabela . " = " . $dados['id'];
			    //echo "$query<br>";
			    
			return $this->executaSQL($query);
		  }else{
			return false;
			}
		}
		//
		//Metodo usado para excluir dados
		public function excluir($id = null){
				if(!is_null($id)){
					$query = "DELETE FROM " . $this->tabela . " WHERE " . $this->idtabela . " = " . $id;
					return $this->executaSQL($query);
				}
				else{
					return false;
				}
			}

		private function criaBanco($nomeBD, $host, $user){
			$sql = "CREATE DATABASE IF NOT EXISTS `{$nomeBD}`
			DEFAULT character SET UTF8
			DEFAULT collate utf8_general_ci;
			GRANT ALL ON `{$nomeBD}`.* TO '{$user}'@'{$host}';
    		FLUSH PRIVILEGES;";
    		if(!$this->conexao->exec($sql)){
    			echo 'Falha ao criar banco de dados!';
    		}
		} 

		private function criaTabelas($nomeBD){
			//
			//Crias as tabelas do banco de dados
			$sql = file_get_contents("../_BD/tabelas_sistema.sql");
			$sql = utf8_decode($sql);
			if($this->conexao->exec($sql)){
    			echo 'Falha ao criar as tabelas!';
    			exit;
    		}
		}

		private function criarBase(){
			//Conecta ao servidor e cria a base
			$dados = "mysql:host=" . $this->host;
			$dados = $dados . ";port=" . $this->porta;
			$this->conexao = new PDO($dados, $this->usudb, $this->senhadb);   // pdo php data objectve, classe generica pra banco de dados
			$this->criaBanco($this->nomedb, $this->host, $this->usudb);
			//
			//conecta ao banco e cria as tabelas
			$dados = $dados . ";dbname=" . $this->nomedb;
			$this->conexao = new PDO($dados, $this->usudb, $this->senhadb);   // pdo php data objectve, classe generica pra banco de dados
			$this->criaTabelas($this->nomedb);
			//
			//
			header('Location: ../index.php');
			exit;
		}
	}


?>
