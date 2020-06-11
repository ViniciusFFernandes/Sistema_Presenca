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
            if($_REQUEST['ev_id'] > 0){
              $sql = "SELECT * FROM eventos WHERE ev_id = " . $_REQUEST['ev_id'];
              $reg = $db->retornaUmReg($sql);
            }
          ?>
          <form action="evento_grava.php" method="post" id="form_edita">
            <input type="hidden" id="ev_id" name="ev_id" value="<?= $reg['ev_id'] ?>">
            <input type="hidden" id="operacao" name="operacao" value="Gravar">
            <div class="row" >
                <div class="col-12 col-sm-6">
                  <div class="form-group">
                    <label for="ev_nome">Nome</label>
                    <input type="text" class="form-control" id="ev_nome" name="ev_nome" placeholder="Digite o Nome do Evento" value="<?= $reg['ev_nome'] ?>">
                  </div>
                </div>
                <div class="col-12 col-sm-6">
                  <div class="form-group">
                    <label for="ev_tiev_id">Tipo do Evento</label>
                    <select class="form-control" id="ev_tiev_id" name="ev_tiev_id">
                      <option value="">Selecione o Tipo</option>
                      <?php 
                        $sqlTipos = "SELECT * FROM tipos_eventos";
                        $resTipos = $db->consultar($sqlTipos);
                        foreach($resTipos AS $regTipos){
                          $selected = '';
                          if($regTipos['tiev_id'] == $reg['ev_tiev_id']){
                            $selected = 'selected';
                          }
                          //
                          echo '<option value="' . $regTipos['tiev_id'] . '" ' . $selected . '>' . $regTipos['tiev_descricao'] . '</option>';
                        }
                      ?>
                    </select>
                  </div>
                </div>
                <div class="col-12 col-sm-6">
                  <div class="form-group">
                    <label for="ev_responsavel">Responsalvel</label>
                    <input type="text" class="form-control" id="ev_responsavel" name="ev_responsavel" placeholder="Digite o Nome do Responsavel" value="<?= $reg['ev_responsavel'] ?>">
                  </div>
                </div>
                <div class="col-12 col-sm-6">
                  <div class="form-group">
                    <label for="ev_horas">Carga Horaria</label>
                    <input type="number" class="form-control" id="ev_horas" name="ev_horas" placeholder="Digite a Carga Horaria" value="<?= $reg['ev_horas'] ?>">
                  </div>
                </div>
                <div class="col-12 col-sm-6">
                  <div class="form-group">
                    <label for="ev_data">Data</label>
                    <input type="date" class="form-control" id="ev_data" name="ev_data" value="<?= $reg['ev_data'] ?>">
                  </div>
                </div>
                <div class="col-12 col-sm-6">
                  <div class="form-group">
                    <label for="ev_hora_inicio">Horaio de Inicio</label>
                    <input type="time" class="form-control" id="ev_hora_inicio" name="ev_hora_inicio" value="<?= $reg['ev_hora_inicio'] ?>">
                  </div>
                </div>
                <div class="col-12 col-sm-6">
                  <div class="form-group">
                    <label for="ev_hora_fim">Horario de Fim</label>
                    <input type="time" class="form-control" id="ev_hora_fim" name="ev_hora_fim" value="<?= $reg['ev_hora_fim'] ?>">
                  </div>
                </div>
                <div class="col-12 col-sm-12" align="center">
                  <button type="submit" class="btn btn-success">Gravar</button>
                  <?php
                    if($reg['ev_id'] > 0){ ?>
                      <button type="button" class="btn btn-danger" onclick="excluirEvento()">Excluir</button>
                      <a href="../_Cadastros/evento_edita.php">
                        <button type="button" class="btn btn-primary">Novo</button>
                      </a>
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
