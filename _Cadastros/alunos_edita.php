<?php
  include_once("../_BD/conecta_login.php");
  $menuActive = 'Cadastro';
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
      function excluirPessoa(){
        //
        //função usada para alterar o valor do campo operacao e executar o submit do form
        $("#operacao").val('Excluir');
        $("#form_edita").submit();
      }

      function emitirCertificados(alu_id, ev_id, prev_id){
        $("#div_certificado_" + prev_id).html('Emitindo Certificado...');
        //
        $.post("../_Relatorios/emitir_certificado.php", {ev_id: ev_id, alu_id: alu_id}, 
        function(data){
          if(data == 'Enviado'){
            $("#div_certificado_" + prev_id).html(data);
          }else{
            alert("Erro ao emitir certificado!\n" + data);
            $("#div_certificado_" + prev_id).html("Certificado");
          }
        }, 'html')
      }
    </script>  
    <body>
        <?php
            include_once("../menu.php")
        ?>
        <div class="container">
          <?php if($_REQUEST['msg'] != ''){ 
            if($_REQUEST['msgTipo'] == 'erro'){
              $tipo = 'danger';
            }elseif($_REQUEST['msgTipo'] == 'sucesso'){
              $tipo = 'success';
            }else{
              $tipo = 'info';
            }
            ?>
            <div class="alert alert-<?= $tipo ?> alert-dismissible">
              <button type="button" class="close" data-dismiss="alert">&times;</button>
              <?= $_REQUEST['msg'] ?>
            </div>
          <?php } 
            if($_REQUEST['alu_id'] > 0){
              $sql = "SELECT * FROM alunos WHERE alu_id = " . $_REQUEST['alu_id'];
              $reg = $db->retornaUmReg($sql);
            }
          ?>
          <div class="card">
            <div class="card-header bg-primary text-light">
              <b>Cadastro de Aluno</b>
              <span class="float-right light"><a href="../_Cadastros/alunos_lista.php"><img src="../icones/lupaPrimary.png" width="28px"></a></span>
            </div>
            <div class="card-body">
              <form action="alunos_grava.php" method="post" id="form_edita">
                <input type="hidden" id="alu_id" name="alu_id" value="<?= $reg['alu_id'] ?>">
                <input type="hidden" id="operacao" name="operacao" value="Gravar">
                <div class="row" >
                    <div class="col-12 col-sm-6">
                      <div class="form-group">
                        <label for="alu_nome">Nome</label>
                        <input type="text" class="form-control" id="alu_nome" name="alu_nome" placeholder="Digite o Nome" value="<?= $reg['alu_nome'] ?>">
                      </div>
                    </div>
                    <div class="col-12 col-sm-6">
                      <div class="form-group">
                        <label for="alu_email">E-mail</label>
                        <input type="text" class="form-control" id="alu_email" name="alu_email" placeholder="Digite o e-mail do aluno" value="<?= $reg['alu_email'] ?>">
                      </div>
                    </div>
                    <div class="col-12 col-sm-6">
                      <div class="form-group">
                        <label for="alu_curso">Curso</label>
                        <input type="text" class="form-control" id="alu_curso" name="alu_curso" placeholder="Digite o nome do Curso" value="<?= $reg['alu_curso'] ?>">
                      </div>
                    </div>
                    <div class="col-12 col-sm-12" align="center">
                      <button type="submit" class="btn btn-success">Gravar</button>
                      <?php
                        if($reg['alu_id'] > 0){ ?>
                          <button type="button" class="btn btn-danger" onclick="excluirPessoa()">Excluir</button>
                          <a href="../_Cadastros/alunos_edita.php">
                            <button type="button" class="btn btn-primary">Novo</button>
                          </a>
                      <?php  
                        }
                      ?>
                    </div>
                </div>
              </form>
            </div>
          </div>
          <?php
          if($_REQUEST['alu_id'] > 0) { 
            $sql = "SELECT * FROM eventos 
                      JOIN presencas_eventos ON (prev_ev_id = ev_id)
                      WHERE prev_alu_id = " . $_REQUEST['alu_id'] . "
                      ORDER BY prev_data_hora";
            
            $res = $db->consultar($sql);

            if($res){
            ?>
            <div class="card mt-3">
              <div class="card-body">
                <div class="row">
                  <div class="col-12 col-sm-12">
                    <table class="table table-striped">
                      <thead class="thead-light">
                        <tr>
                          <th>Evento</th>
                          <th>C.H.</th>
                          <th>&nbsp;</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php foreach($res as $reg){ ?>
                          <tr>
                            <td><?= $reg['ev_nome'] ?></td>
                            <td><?= $reg['ev_horas'] ?></td>
                            <td align="right">
                              <?php
                              if(!empty($reg['prev_data_hora'])){
                                echo "<kbd id='div_certificado_" . $reg["prev_id"] . "'><span onclick='emitirCertificados(" . $reg['prev_alu_id'] . "," . $reg['prev_ev_id'] . "," . $reg['prev_id'] . ")'>Certificado</span></kbd>";
                              }
                              ?>
                            </td>
                          </tr>
                        <?php } ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          <?php
            }
          } ?>
        </div>
    </body>
</html>
