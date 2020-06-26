<?php
  include_once("../_BD/conecta_login.php");
  include_once("../funcoes/funcoes.php");
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

            $sql = "SELECT ev_nome, tiev_descricao, ev_data, ev_horas
                        FROM eventos
                        JOIN  tipos_eventos ON (ev_tiev_id = tiev_id)
                      WHERE 1 = 1 ";

            if(!empty($_POST["ev_id"])){
              $sql .= " AND ev_id = {$_POST['ev_id']}";
            }

            if(!empty($_POST["ev_tiev_id"])){
              $sql .= " AND ev_tiev_id = {$_POST['ev_tiev_id']}";
            }

            if(!empty($_POST["ev_data"])){
              $sql .= " AND ev_data = '" . $_POST['ev_data'] . "'";
            }
            $sql .= " ORDER BY ev_data";
            
            $res = $db->consultar($sql);
        ?>
        <div class="container">
          <div class="card">
            <div class="card-header bg-primary text-light">
              <b>Relatório de Eventos</b>
              <span class="float-right light"><a href="./rel_eventos_sel.php"><img src="../icones/voltar.png" width="28px"></a></span>
            </div>
            <div class="card-body">
                <div class="row" >
                    <div class="col-12 col-sm-12">
                      <table class="table-sm" style="font-size: 0.9rem">
                        <tr>
                          <th class="p-0 m-0">Nome</th>
                          <th class=" m-0">Tipo</th>
                          <th class=" m-0">Data</th>
                          <th class=" m-0">C.H.</th>
                        </tr>
                        <?php
                        if(!$res){
                          echo "<tr><td colspan='4'>Não existem registros!</td></tr>";
                        }
                        foreach($res as $reg){
                        ?>
                        <tr>
                          <td class="p-0 m-0"><?= $reg["ev_nome"] ?></td>
                          <td class=" m-0"><?= $reg["tiev_descricao"] ?></td>
                          <td class=" m-0" width="25%"><?= converteData($reg["ev_data"]) ?></td>
                          <td class=" m-0" width="15%"><?= $reg['ev_horas'] ?> H</td>
                        </tr>
                        <?php
                        } ?>
                      </table>
                    </div>
                </div>
            </div>
          </div>
        </div>
    </body>
</html>
