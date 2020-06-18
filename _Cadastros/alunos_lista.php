<?php
  include_once("../_BD/conecta_login.php");
?>
<!doctype html>
<html lang="pt-br">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>Sistema de Presença</title>
        <?php
        include_once('../includes.php');
        ?>
    </head>
    <script>
    </script>  
    <body>
        <?php
            include_once("../menu.php")
        ?>
        <div class="container">
          <div class="card">
            <div class="card-header bg-primary text-light">
              <b>Lista de Alunos</b>
              <span class="float-right light"><a href="../_Cadastros/alunos_edita.php"><img src="../icones/adiciona.png" width="28px"></a></span>
            </div>
            <div class="card-body">
              <form action="alunos_lista.php" method="post" id="form_lista">
                <div class="row">
                	<div class="col-12 col-sm-12 p-0">
                		<div class="input-group mb-2">
							<input type="text" class="form-control" placeholder="Pesquisar Aluno..." id="pesquisaAluno" name="pesquisaAluno" value="<?= $_REQUEST['pesquisaAluno']?>">
							<div class="input-group-append">
								<button type="submit" class="btn"><img src="../icones/lupa.png" width="24px"></button>
							</div>
					</div>
                	</div>
                </div>
              </form>
            	<?php
					$sql = "SELECT * FROM alunos";
					if(!empty($_REQUEST['pesquisaAluno'])){
						$sql .= " WHERE UPPER(alu_nome) LIKE '%" . strtoupper($_REQUEST['pesquisaAluno']) . "%' OR UPPER(alu_curso) LIKE '%" . strtoupper($_REQUEST['pesquisaAluno']) . "%'";
					}
					$res = $db->consultar($sql);
				?>
				<div class="row">
					<div class="col-12 col-sm-12 p-0">
						<table id="tableAlunos" class="table table-striped m-0 p-0" style="font-size: 14px;">
							<thead class="table-light">
								<tr>
									<th>Aluno</th>
									<th>Curso</th>
								</tr>
							</thead>
							<tbody>
							<?php
							if(empty($res)){
							?>
								<tr><td colspan="2" align="center">Não existem alunos cadastrados!</td></tr>
							<?php
							}
							foreach($res as $reg){
							?>
								<tr onclick="location.href = '../_Cadastros/alunos_edita.php?alu_id=<?= $reg['alu_id']?>';" style="cursor: pointer;">
									<td><?= $reg['alu_nome'] ?></td>
									<td><?= $reg['alu_curso'] ?></td>
								</tr>
							<?php
							}
							?>
							</tbody>
						</table>
					</div>
				</div>
            </div>
          </div>
        </div>
    </body>
</html>
