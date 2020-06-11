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
        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    </head>
    <script>
      function excluirEvento(){
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
            if($_REQUEST['tiev_id'] > 0){
              $sql = "SELECT * FROM tipos_eventos WHERE tiev_id = " . $_REQUEST['tiev_id'];
              $reg = $db->retornaUmReg($sql);
            }
          ?>
          <div class="card">
            <div class="card-header bg-primary text-light">
              <b>Cadastro de Tipo de Evento</b>
              <span class="float-right light"><a href="../_Cadastros/tipo_evento_lista.php"><img src="../icones/lupaPrimary.png" width="28px"></a></span>
            </div>
            <div class="card-body">
              <form action="tipo_evento_grava.php" method="post" id="form_edita">
                <input type="hidden" id="tiev_id" name="tiev_id" value="<?= $reg['tiev_id'] ?>">
                <input type="hidden" id="operacao" name="operacao" value="Gravar">
                <div class="row" >
                    <div class="col-12 col-sm-6">
                      <div class="form-group">
                        <label for="tiev_descricao">Nome</label>
                        <input type="text" class="form-control" id="tiev_descricao" name="tiev_descricao" placeholder="Digite o Tipo de Evento" value="<?= $reg['tiev_descricao'] ?>">
                      </div>
                    </div>
                    <div class="col-12 col-sm-12" align="center">
                      <button type="submit" class="btn btn-success">Gravar</button>
                      <?php
                        if($reg['tiev_id'] > 0){ ?>
                          <button type="button" class="btn btn-danger" onclick="excluirEvento()">Excluir</button>
                          <a href="../_Cadastros/tipo_evento_edita.php">
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
