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
            <div class="alert alert-<?= $tipo ?>">
              <?= $_REQUEST['msg'] ?>
            </div>
          <?php } 
            if($_REQUEST['alunos_id'] > 0){
              $sql = "SELECT * FROM alunos WHERE alunos_id = " . $_REQUEST['alunos_id'];
              $reg = $db->retornaUmReg($sql);
            }
          ?>
          <form action="alunos_grava.php" method="post" id="form_edita">
            <input type="hidden" id="alunos_id" name="alunos_id" value="<?= $reg['alunos_id'] ?>">
            <input type="hidden" id="operacao" name="operacao" value="Gravar">
            <div class="row" >
                <div class="col-12">
                  <div class="form-group">
                    <label for="nome_alu">Nome</label>
                    <input type="aluno" class="form-control" id="nome_alu" name="nome_alu" placeholder="Digite o Nome" value="<?= $reg['nome_alu'] ?>">
                  </div>
                </div>
                <div class="col-12">
                  <div class="form-group">
                    <label for="email_alu">E-mail</label>
                    <input type="curso" class="form-control" id="email_alu" name="email_alu" placeholder="Digite o e-mail do aluno" value="<?= $reg['email_alu'] ?>">
                  </div>
                </div>
                <div class="col-12">
                  <div class="form-group">
                    <label for="curso_alu">Curso</label>
                    <input type="curso" class="form-control" id="curso_alu" name="curso_alu" placeholder="Digite o nome do Curso" value="<?= $reg['curso_alu'] ?>">
                  </div>
                </div>
                <div class="col-12">
                  <button type="submit" class="btn btn-primary">Gravar</button>
                  <?php
                    if($reg['alunos_id'] > 0){ ?>
                      <button type="button" class="btn btn-danger" onclick="excluirPessoa()">Excluir</button>
                  <?php  
                    }
                  ?>
                </div>
            </div>
          </form>
            <?php
                include_once('../rodape.php');
            ?>
        </div>
    </body>
</html>
