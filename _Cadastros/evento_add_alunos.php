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
        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
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
              <span class="float-right light"><a href="../_Cadastros/evento_edita.php?ev_id=<?= $_REQUEST['ev_id'] ?>"><img src="../icones/voltar.png" width="28px"></a></span>
            </div>
            <div class="card-body">
                <form action="evento_add_alunos.php" method="post" id="form_lista">
                    <input type="hidden" name="ev_id" id="ev_id" value="<?= $_REQUEST['ev_id'] ?>">
                    <div class="row">
                        <div class="col-12 col-sm-12 p-0">
                            <div class="input-group mb-2">
                                <input type="text" class="form-control" placeholder="Pesquisar Aluno..." id="pesquisaAluno" name="pesquisaAluno" value="<?= $_REQUEST['pesquisaAluno'] ?>">
                                <div class="input-group-append">
                                    <span class="input-group-button">
                                        <button type="submit" class="btn btn-light"><img src="../icones/lupa.png" width="24px"></button>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            	<?php
					$sql = "SELECT * 
                            FROM alunos 
                            WHERE (SELECT IFNULL(COUNT(1), 0) 
                                    FROM presencas_eventos 
                                    WHERE prev_alu_id = alunos.alu_id 
                                        AND prev_ev_id = " . $_REQUEST['ev_id'] . ") <= 0";
					if(!empty($_REQUEST['pesquisaAluno'])){
						$sql .= " AND (alu_nome LIKE '%" . $_REQUEST['pesquisaAluno'] . "%' OR alu_curso LIKE '%" . $_REQUEST['pesquisaAluno'] . "%')";
					}
					$res = $db->consultar($sql);
				?>
				<div class="row">
					<div class="col-12 col-sm-12 p-0">
                        <form action="../_Cadastros/evento_grava.php" method="post" id="form_inclui" name="form_inclui">
                            <input type="hidden" name="operacao" id="operacao" value="incluir_alunos">
                            <input type="hidden" name="ev_id" id="ev_id" value="<?= $_REQUEST['ev_id'] ?>">
                            <table id="tableAlunos" class="table table-striped m-0" style="font-size: 14px;">
                                <thead class="table-primary">
                                    <tr>
                                        <th width="5%">&nbsp;</th>
                                        <th>Aluno</th>
                                        <th>Curso</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                foreach($res as $reg){
                                ?>
                                    <tr>
                                        <td><input type="checkbox" name="checkbox_alu_id[]" value="<?= $reg['alu_id'] ?>"></td>
                                        <td><?= $reg['alu_nome'] ?></td>
                                        <td><?= $reg['alu_curso'] ?></td>
                                    </tr>
                                <?php
                                }
                                ?>
                                    <tr>
                                        <td colspan="3" align="center">
                                            <button type="submit" class="btn btn-primary">Incluir Alunos</button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </form>
					</div>
				</div>
            </div>
          </div>
            <?php
                include_once('../rodape.php');
            ?>
        </div>
    </body>
</html>
