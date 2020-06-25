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

            $sql = "SELECT *
                        FROM eventos
                        JOIN tipos_eventos ON (ev_tiev_id = tiev_id)
                        JOIN alunos ON (ev_alu_id = alu_id)
                      WHERE ev_id = {$_POST['ev_id']}
                  ORDER BY alu_nome";
            
            $res = $db->consultar($sql);
        ?>
        <div class="container">
          <div class="card">
            <div class="card-header bg-primary text-light">
              <b>Relatório de Presenças</b>
              <span class="float-right light"><a href="./rel_presencas_sel.php"><img src="../icones/voltar.png" width="28px"></a></span>
            </div>
            <div class="card-body">
                <div class="row" >
                    <div class="col-12 col-sm-12">
                      <table class="table">
                        <tr>
                          <th colspan="3"><?= $_POST['ev_nome'] ?></th>
                        </tr>
                        <tr>
                          <th>Nome</th>
                          <th>Curso</th>
                          <th>&nbsp;</th>
                        </tr>
                        <?php
                        if(!$res){ ?>
                          <tr><td colspan="3">Não existem registros de presenças para o Evento selecionado!</td></tr>
                        <?php
                        }
                        foreach($res as $reg){
                        ?>
                        <tr>
                          <td><?= $reg["alu_nome"] ?></td>
                          <td><?= $reg["alu_curso"] ?></td>
                          <td>
                            <?php
                              //
                              //Verifica se a data da presença está vazia, caso esteja, significa que o aluno faltou.
                              if(!empty($reg['prev_data_hora'])){
                                echo "<span class='text-success'><b>P</b></span>";
                              }else{
                                echo "<span class='text-danger'><b>F</b></span>";
                              }
                            ?>
                          </td>
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
