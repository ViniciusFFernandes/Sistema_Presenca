<?php 
	//
	//Função usada para converter a data vinda do banco de dados para formato com barra
    function converteData($string){
        if ($string != "") {
					$string = explode(" ", $string);
					$data = explode("-", $string[0]);
					$dataFormatada = $data[2] . "/" . $data[1] . "/" . $data[0];
					if (!empty($string[1])) {
						$dataFormatada .= " " . $string[1];
					}
				}else {
					return "";
				}
				return $dataFormatada;
	}
	//
	//Função usada para converter valor pra inteiro ou NULL caso não seja
	function igr($num){
		if ($num != "") {
         	return intval($num);
        }else{
          	return "NULL";
        }
	}
	//
	//Função usada para inserir aspas simples nas strings para gravação no banco de dados
	function sgr($string, $retornaNull = false){
		if ($string != "") {
			$string = str_replace("'", "''", $string);
          	return "'" . $string . "'";
        }else{
			if($retornaNull){
				return "NULL";
			}
          	return "''";
        }
	}
	//
	//Função usada para criar uma estrutra html com uma msg de erro, usada pra exibir erros do sistema
	function mostraErro($textoerro, $operacao) { ?>
		<!doctype html>
		<html lang="pt-br" style="height: 100% !important;">
			<head>
				<!-- Required meta tags -->
				<meta charset="utf-8">
				<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
				<title>Sistema de Presença</title>
				<?php
				include_once('../includes.php');
				?>
			</head>
			<body style="height: 100% !important;">
				<div class="container" style="height: 95% !important; display: flex; align-items: center; justify-content: center;">
					<div class="card">
						<div class="card-header bg-primary text-light">
							<b>Erro ao <?= $operacao ?></b>
						</div>
						<div class="card-body" align="center">
							<div class="row">
								<div class="col-12">
									<?= $textoerro ?>
								</div>
							</div>
							<div class="row mt-1">
								<div class="col-12">
									<button type="button" class="btn btn-primary" onclick="Javascript:window.history.back()">Voltar <img src="../icones/voltar.png" width="17px"></button>
								</div>
							</div>
						</div>	
					</div>
				</div>
			</body>
		</html>
<?php 
		exit;
	}
?>