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
      function excluirPessoa(){
        var operacao = document.getElementById("operacao");
        var form = document.getElementById("form_edita");
        operacao.value = 'Excluir';
        form.submit();
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
                include_once('../rodape.php');
            ?>
        </div>
    </body>
</html>
