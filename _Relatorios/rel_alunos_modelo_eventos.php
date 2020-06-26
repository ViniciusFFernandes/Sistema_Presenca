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

            $sql = "SELECT ev_nome, ev_data, prev_data_hora, ev_horas FROM presencas_eventos
                        JOIN alunos ON (alu_id = prev_alu_id)
                        JOIN eventos ON (ev_id = prev_ev_id)
                      WHERE alu_id = " . $_POST['alu_id'];
            if(isset($_POST["cb_presente"])){
              $sql .= " AND prev_data_hora IS NOT NULL";
            }
            $sql .= " ORDER BY ev_data";
            
            $res = $db->consultar($sql);
        ?>
        <div class="container">
          <div class="card">
            <div class="card-header bg-primary text-light">
              <b>Relatório de Inscrições</b>
              <span class="float-right light"><a href="./rel_alunos_sel.php"><img src="../icones/voltar.png" width="28px"></a></span>
            </div>
            <div class="card-body">
                <div class="row" >
                    <div class="col-12 col-sm-12">
                      <table class="table">
                        <tr>
                          <th colspan="3"><?= $_POST["alu_nome"] ?></th>
                        </tr>
                        <?php
                        if($res){
                          $total = 0;
                          foreach($res as $reg){
                            ?>
                            <tr>
                              <td><?= $reg['ev_nome'] ?></td>
                              <td width="20%"><?= converteData($reg['ev_data']) ?></td>
                              <td width="10%" align="right">
                                <?php
                                //
                                //Verifica se a data da presença está vazia, caso esteja, significa que o aluno faltou.
                                if(!empty($reg['prev_data_hora'])){
                                  //
                                  //totaliza a quantidade de horas dos eventos com presença.
                                  $total += $reg['ev_horas'];

                                  echo "<span class='text-success'><b>P</b></span>";
                                }else{
                                  echo "<span class='text-danger'><b>F</b></span>";
                                }
                                ?>
                              </td>
                            </tr>
                            <?php
                          }
                        ?>
                        <tr>
                          <td colspan="3" align="right">C.H. Contabilizada: <b><?= $total; ?> H</b></td>
                        </tr>
                        <tr>
                          <td colspan="3" style="font-size: 10px;" align="right">
                            <b><span class="text-success">P</span> - Presente &emsp;&emsp; <span class="text-danger">F</span> - Falta</b>
                          </td>
                        </tr>
                      <?php }else{ ?>
                      <tr><td colspan="3">Não existem registros de eventos para o Aluno selecionado!</td></tr>
                      <?php } ?>
                      </table>
                    </div>
                </div>
            </div>
          </div>
        </div>
    </body>
</html>
