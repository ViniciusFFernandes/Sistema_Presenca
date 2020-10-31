<?php
  $menuActive = 'Home';
?>
<!doctype html>
<html lang="pt-br">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <title>Sistema de Presença</title>
        <?php
          include_once('includes.php');
        ?>
        <script src="js/instascan.min.js"></script>
        <script>
          tipo = '';
          function confirmaPorCodigo(){
            $("#linhaCodigo").show();
            $("#carregandoCamera").hide();
            $("#linhaCamera").hide();
            $("#scanQRCode").hide();
            $("#linhaDados").hide();
            $("#modalFooter").hide();
            $("#prev_id").val('');
            $("#modalTitulo").html("Informe o código");
          }

          function confereCodigo(){
            if($("#prev_id").val() <= 0){
              alert("Código não informado!");
              return;
            }
            $("#linhaCodigo").hide();
            $("#modalTitulo").html("Confira os dados do aluno");
            $("#linhaDados").show();
            tipo = 'codigo';
            buscaPresencaEvento($("#prev_id").val());
          }

          function abreCamera(){
            $("#carregandoCamera").show();
            $("#linhaCodigo").hide();
            $("#linhaCamera").show();
            $("#scanQRCode").hide();
            $("#linhaDados").hide();
            $("#modalFooter").hide();
            $("#prev_id").val('');
            $("#modalTitulo").html("Aponte a camera para o QR Code");
            //
            let scanner = new Instascan.Scanner({
              video: document.getElementById('scanQRCode'),
              mirror: false,
              backgroundScan: false,
              refractoryPeriod: 2000
            });
            scanner.addListener('scan', function(content){
                // alert(content);
                this.stop();
                //
                $("#linhaCamera").hide();
                $("#modalTitulo").html("Confira os dados do aluno");
                $("#linhaDados").show();
                $("#prev_id").val(content);
                tipo = 'camera';
                buscaPresencaEvento(content);
            });
            Instascan.Camera.getCameras().then(cameras => {
              if(cameras.length > 0 ){
                  if(cameras[1] == undefined){
                      scanner.start(cameras[0]);
                  }else{
                      scanner.start(cameras[1]);
                  }
                
                $("#carregandoCamera").hide();
                $("#scanQRCode").show();
              }else{
                  $("#carregandoCamera").html("Nenhuma camera disponivel!<br>Verifique se está conectada e atualize a pagina!");
                }
            }).catch(function (e) {
                $("#carregandoCamera").html("Nenhuma camera encontrada!<br>Verifique se está conectada e atualize a pagina!");
              });
          }

          function confirmaPresenca(tipo){
            $.post("_Cadastros/presenca_grava.php", {operacao: 'gravarPresenca', prev_id: $("#prev_id").val()},
                function(data){
                  if(data == 'Ok'){
                    alert("Presença registrada!");
                    recarrega()
                  }else{
                    alert("Erro ao gerar presença");
                    return;
                  }
                }, 'html');
          }

          function recarrega(){
            if(tipo == 'camera'){
              abreCamera(); 
            }
            if(tipo == 'codigo'){
              confirmaPorCodigo();
            }
          }

          function buscaPresencaEvento(id_prev){
            $.post("_Cadastros/presenca_grava.php", {operacao: 'buscarDados', prev_id: id_prev},
                function(data){
                  if(data == "Evento Finalizado"){
                    alert("Este evento já foi finalizado!\nNão é possivel gerar presença!");
                    if(tipo == 'camera'){
                      abreCamera(); 
                    }
                    if(tipo == 'codigo'){
                      confirmaPorCodigo();
                    }
                  }else{
                    $("#divDados").html(data);
                    $("#modalFooter").show();
                  }
                }, 'html');
          }
        </script>
    </head>
    <body>
        <?php
            include_once("menu.php")
        ?>
        <div class="container">
            <?php
                include_once('cabecalho.php');
            ?>
            <div class="row" align="center">
                <div class="col-12">
                    <button type="button" onclick="abreCamera()" class="btn btn-primary" data-toggle="modal" data-target="#modalQRCode">Escanear QR Code</button>
                </div>
            </div>
            <div class="row pt-2" align="center">
                <div class="col-12">
                    <button type="button" onclick="confirmaPorCodigo()" class="btn btn-primary" data-toggle="modal" data-target="#modalQRCode">Confirmação por Código</button>
                </div>
            </div>
        </div>
    </body>
</html>

<!-- Modal -->
<div class="modal" id="modalQRCode">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Header -->
      <div class="modal-header">
        <h5 class="modal-title" id="modalTitulo">Aponte a camera para o QR Code</h5>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- body -->
      <div class="modal-body">
        <div class="row" id="linhaCodigo" style="display:none;">
          <div class="col-12 input-group">
            <input type="text" id="prev_id" class="form-control" placeholder="Código">
            <div class="input-group-append">
              <button class="btn btn-primary light" type="button" onclick="confereCodigo()"><img src="icones/lupaPrimary.png" width="24px"></button>  
            </div>
          </div>
        </div>
        <div class="row" id="linhaCamera">
          <div class="col-12">
            <span id="carregandoCamera"><span class="spinner-border spinner-border-sm text-primary"></span> Buscando camera...</span>
            <video id="scanQRCode" width="100%" style="display:none;"></video>
          </div>
        </div>
        <div class="row" style="display:none;" id="linhaDados">
          <div class="col-12" id="divDados">
            <span class="spinner-border spinner-border-sm text-primary"></span> Buscando dados...
          </div>
        </div>
      </div>

      <!-- footer -->
      <div class="modal-footer" style="display:none;" id="modalFooter">
        <button type="button" class="btn btn-danger" onclick="recarrega()">Cancelar</button>
        <button type="button" class="btn btn-success" onclick="confirmaPresenca()">Confirmar</button>
      </div>

    </div>
  </div>
</div>
    
    



