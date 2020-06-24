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

            $sql = "SELECT ev_nome, DATE_FORMAT(ev_data, '%d/%m/%Y') as ev_data FROM presencas_eventos
                        JOIN alunos ON (alu_id = prev_alu_id)
                        JOIN eventos ON (ev_id = prev_ev_id)
                      WHERE alu_id = " . $_POST['alu_id'];
            if(isset($_POST["cb_presente"])){
              $sql .= " AND ISNULL(prev_data_hora, '') <> ''";
            }
            $sql .= " ORDER BY ev_data";
            
            $res = $db->consultar($sql);
        ?>
        <div class="container">
          <div class="card">
            <div class="card-header bg-primary text-light">
              <b>Inscrições de Eventos</b>
              <span class="float-right light"><a href="./rel_alunos_sel.php"><img src="../icones/voltar.png" width="28px"></a></span>
            </div>
            <div class="card-body">
                <div class="row" >
                    <div class="col-12 col-sm-12">
                      <table class="table">
                        <tr>
                          <th colspan="2"><?= $_POST["alu_nome"] ?></th>
                        </tr>
                        <?php
                        if(!$res){ ?>
                          <tr><td colspan="2">Não existem registros de eventos para o Aluno selecionado!</td></tr>
                        <?php
                        }
                          foreach($res as $reg){
                            ?>
                            <tr>
                              <td><?= $reg['ev_nome'] ?></td>
                              <td width="20%"><?= $reg['ev_data'] ?></td>
                            </tr>
                            <?php
                          }
                        ?>
                      </table>
                    </div>
                </div>
            </div>
          </div>
        </div>
    </body>
</html>
