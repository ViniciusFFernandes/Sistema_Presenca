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
              <b>Lista de Evento</b>
              <span class="float-right light"><a href="../_Cadastros/evento_edita.php"><img src="../icones/adiciona.png" width="28px"></a></span>
            </div>
            <div class="card-body">
              <form action="evento_lista.php" method="post" id="form_lista">
                <div class="row">
                	<div class="col-12 col-sm-12 p-0">
                		<div class="input-group mb-2">
							<input type="text" class="form-control" placeholder="Pesquisar Evento..." id="pesquisaEvento" name="pesquisaEvento" value="<?= $_REQUEST['pesquisaEvento']?>">
							<div class="input-group-append">
								<button type="submit" class="btn"><img src="../icones/lupa.png" width="24px"></button>
							</div>
					</div>
                	</div>
                </div>
              </form>
            	<?php
					$sql = "SELECT * FROM eventos";
					if(!empty($_REQUEST['pesquisaEvento'])){
						$sql .= " WHERE UPPER(ev_nome) LIKE '%" . strtoupper($_REQUEST['pesquisaEvento']) . "%'";
					}
					$res = $db->consultar($sql);
				?>
				<div class="row">
					<div class="col-12 col-sm-12 p-0">
						<table id="tableEvento" class="table table-striped m-0 p-0" style="font-size: 14px;">
							<thead class="table-light">
								<tr>
									<th>Evento</th>
								</tr>
							</thead>
							<tbody>
							<?php
							if(empty($res)){
							?>
								<tr><td colspan="2" align="center">Não existem eventos cadastrados!</td></tr>
							<?php
							}
							foreach($res as $reg){
							?>
								<tr onclick="location.href = '../_Cadastros/evento_edita.php?ev_id=<?= $reg['ev_id']?>';" style="cursor: pointer;">
									<td><?= $reg['ev_nome'] ?></td>
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
