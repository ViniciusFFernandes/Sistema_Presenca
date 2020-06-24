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
      function excluirEvento(){
        //
        //função usada para alterar o valor do campo operacao e executar o submit do form
        $("#operacao").val('Excluir');
        $("#form_edita").submit();
      }

      function excluirMatricula(prev_id){
        //
        //função usada para execluir uma matriculo atravez de uma solicitação assincrona do jquery ($.post)
        //
        //Define o botão de exclusão com um carregando ate finalizar a operação
        $("#tdExcluiPresenca").html('<span class="spinner-border spinner-border-sm text-primary"></span>');
        //
        //Executa a solicitação
        $.post("evento_grava.php", {operacao: 'excluirMatricula', prev_id: prev_id},
          function(data){
            if(data == 'Ok'){
              //
              //Caso de certo avisa com um alert e remove a matrcula da tela
              alert("Matricula excluida com sucesso!");
              $("#matricula_" + prev_id).remove();
            }else{
              //
              //Caso de erro avisa com um alert e restaura o botão de exclusão na tela
              alert("Erro ao excluir matricula!");
              $("#tdExcluiPresenca").html('<img src="../icones/excluir.png" style="cursor: pointer;" onclick="excluirMatricula(<?= $regMatriculas['prev_id'] ?>)">');
            }
          }, "html");
      }

      function gerarQR(prev_id){
        //
        //função usada para gerar e enviar os QR Codes atravez de uma solicitação assincrona do jquery ($.post)
        //
        //Desabilita e coloca um carregando nos botões de QR Code até que a operação seja finalizada
        $("input[name=tdQrCode]").html('<span class="spinner-border spinner-border-sm text-primary"></span>');
        $("#btnGeraQr").html('<span class="spinner-border spinner-border-sm text-primary">Gerando...</span>');
        $("#btnGeraQr").attr("disabled", true);
        //
        //Executa a solicitação
        var ev_id = $("#ev_id").val();
        $.post("evento_grava.php", 
          {operacao: "gerarQR", prev_id: prev_id, ev_id: ev_id},
          function(data){
            if(data == 'Ok'){
              //
              //Se der certo avisa na tela diferenciando se foi solicitado para a turma toda ou exclusico para um aluno
              if(prev_id == ''){
                alert("QR codes do evento enviados com sucesso!");
              }else{
                alert("QR code do aluno enviados com sucesso!");
              }
            }else{
              //
              //Se der erro avisa na tela
              alert("Erro ao gerar QR code!")
            }
            //
            //Restaura os botões de QR Code na tela
            $("input[name=tdQrCode]").html('<img src="../icones/qrcode.png" style="cursor: pointer;" onclick="gerarQR(' + prev_id + ')">');
            $("#btnGeraQr").html('Gerar QR Codes <img src="../icones/qrcode.png">');
            $("#btnGeraQr").attr("disabled", false);
          }, "html")
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
          <div class="card pb-1 mb-3">
            <div class="card-header bg-primary text-light">
              <b>Cadastro de Eventos</b>
              <span class="float-right light"><a href="../_Cadastros/evento_lista.php"><img src="../icones/lupaPrimary.png" width="28px"></a></span>
            </div>
            <div class="card-body mb-1">
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
                        <label for="ev_responsavel">Responsável</label>
                        <input type="text" class="form-control" id="ev_responsavel" name="ev_responsavel" placeholder="Digite o Nome do Responsavel" value="<?= $reg['ev_responsavel'] ?>">
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
                        <label for="ev_horas">Carga Horária</label>
                        <input type="number" class="form-control" id="ev_horas" name="ev_horas" placeholder="Digite a Carga Horaria" value="<?= $reg['ev_horas'] ?>">
                      </div>
                    </div>
                    <div class="col-12 col-sm-4">
                      <div class="form-group">
                        <label for="ev_data">Data</label>
                        <input type="date" class="form-control" id="ev_data" name="ev_data" value="<?= $reg['ev_data'] ?>">
                      </div>
                    </div>
                    <div class="col-12 col-sm-4">
                      <div class="form-group">
                        <label for="ev_hora_inicio">Horário de Inicio</label>
                        <input type="time" class="form-control" id="ev_hora_inicio" name="ev_hora_inicio" value="<?= $reg['ev_hora_inicio'] ?>">
                      </div>
                    </div>
                    <div class="col-12 col-sm-4">
                      <div class="form-group">
                        <label for="ev_hora_fim">Horário de Fim</label>
                        <input type="time" class="form-control" id="ev_hora_fim" name="ev_hora_fim" value="<?= $reg['ev_hora_fim'] ?>">
                      </div>
                    </div>
                    <div class="col-12" align="center">
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
            </div>
          </div>
          
          <?php  
          if($_REQUEST['ev_id'] > 0){
            //
            //Caso esteja com algum evento em tela ira exibir os alunos matriculados para poder gerar os QR Codes 
            $sqlMatriculas = "SELECT * 
                    FROM presencas_eventos 
                      JOIN alunos ON (prev_alu_id = alu_id)
                    WHERE prev_ev_id = " . $reg['ev_id'];
            $resMatriculas = $db->consultar($sqlMatriculas);
          ?>

              <div class="card pb-1 mb-5">
                <?php
                if($reg['ev_id'] > 0){ ?>
                  <div class="row">
                    <div class="col-6 m-0 p-0 mt-2 mb-2" align="center">
                      <a href="../_Cadastros/evento_add_alunos.php?ev_id=<?= $reg['ev_id'] ?>">
                        <button type="button" class="btn btn-secondary" style="font-size: 0.75rem;">Adicionar Alunos <img src="../icones/adiciona.png"></button>
                      </a>
                    </div>
                    <div class="col-6 m-0 p-0 mt-2 mb-2" align="center">
                      <button type="button" class="btn btn-info" id="btnGeraQr" style="font-size: 0.75rem;" onclick="gerarQR('')">Gerar QR Codes <img src="../icones/qrcode.png"></button>
                    </div>
                  </div>
                <?php  
                  }
                ?>
                <div class="card-header bg-primary text-light">
                  <b>Alunos Inscritos</b>
                </div>
                <div class="card-body m-0 p-0">
                  <table class="table table-striped p-0 m-0" cellpadding="0" cellspacing="0">
                    <thead>
                      <tr class="table-active">
                        <th>Nome</th>
                        <th>Curso</th>
                        <th colspan="2" width="5%">&nbsp;</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      foreach($resMatriculas AS $regMatriculas){ ?>
                        <tr id="matricula_<?= $regMatriculas['prev_id'] ?>">
                          <td><?= $regMatriculas['alu_nome'] ?></td>
                          <td><?= $regMatriculas['alu_curso'] ?></td>
                          <td style="white-space: nowrap;" id="tdExcluiPresenca">
                            <img src="../icones/excluir.png" style="cursor: pointer;" onclick="excluirMatricula(<?= $regMatriculas['prev_id'] ?>)">
                          </td>
                          <td style="white-space: nowrap;" name="tdQrCode">
                            <img src="../icones/qrcode.png" style="cursor: pointer;" onclick="gerarQR(<?= $regMatriculas['prev_id'] ?>)">
                          </td>
                        </tr>
                      <?php  
                      }
                      ?>
                    </tbody>
                  </table>
                </div>
                  
                </div>
              </div>
          <?php 
            }
          ?>
        </div>
    </body>
</html>
