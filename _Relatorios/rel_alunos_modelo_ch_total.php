<?php
  include_once("../_BD/conecta_login.php");
  $menuActive = 'Relatorios';
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
        <link href="../js/jquery-ui-1.12.1/jquery-ui.css" rel="stylesheet">
        <script src="../js/jquery-ui-1.12.1/jquery-ui.js"></script>
    </head>
    <script>
    </script>  
    <body>
        <?php
            include_once("../menu.php");

            $sql = "SELECT SUM(ev_horas) as total FROM presencas_eventos
                        JOIN alunos ON (alu_id = prev_alu_id)
                        JOIN eventos ON (ev_id = prev_ev_id)
                      WHERE alu_id = {$_POST['alu_id']}
                      AND prev_data_hora IS NOT NULL
                      GROUP BY alu_id";
            $reg = $db->retornaUmReg($sql);
        ?>
        <div class="container">
          <div class="card">
            <div class="card-header bg-primary text-light">
              <b>Relatório de Carga Horária</b>
              <span class="float-right light"><a href="./rel_alunos_sel.php"><img src="../icones/voltar.png" width="28px"></a></span>
            </div>
            <div class="card-body">
                <div class="row" >
                    <div class="col-12 col-sm-12">
                      <table class="table">
                        <tr>
                          <th colspan="2">Carga Horária Total</th>
                        </tr>
                        <tr>
                          <td><?= $_POST["alu_nome"] ?></td>
                          <td width="30%"><b><?= empty($reg['total']) ? "0" : $reg['total'] ?> H</b></td>
                        </tr>
                      </table>
                    </div>
                </div>
            </div>
          </div>
        </div>
    </body>
</html>
