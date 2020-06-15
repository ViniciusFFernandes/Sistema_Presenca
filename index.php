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
          function abreCamera(){
            $("#carregandoCamera").show();
            $("#scanQRCode").hide();
            $("#prev_id").val('');
            //
            let scanner = new Instascan.Scanner({
              video: document.getElementById('scanQRCode'),
              mirror: false
            });
            scanner.addListener('scan', function(content){
                // alert(content);
                scanner.stop();
                //
                $("#linhaCamera").hide();
                $("#modalTitulo").html("Confira os dados do aluno");
                $("#linhaDados").show();
                $("#prev_id").val(content);
                $.post("presenca_grava.php", {operacao: 'buscarDados', prev_id: content},
                function(data){
                  $("#divDados").html(data);
                  $("#modalFooter").show();
                }, 'html');
            });
            Instascan.Camera.getCameras().then(cameras => {
              if(cameras.length > 0 ){
                scanner.start(cameras[1]);
                $("#carregandoCamera").hide();
                $("#scanQRCode").show();
              }else{
                $("#divCamera").html("Nenhuma camera encontrada!<br>Verifique se está conectada e atualize a pagina!")
              }
            });
          }

          function confirmaPresenca(){
            $.post("presenca_grava.php", {operacao: 'gravarPresenca', prev_id: $("#prev_id").val(content)},
                function(data){
                  if(data == 'Ok'){
                    alert("Presença registrada!");
                    abreCamera(); 
                  }else{
                    alert("Erro ao gerar presença");
                  }
                }, 'html');
          }

          function cancelaPresenca(){
            abreCamera();
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
          <input type="hidden" id="prev_id">
        <div class="row" id="linhaCamera">
          <div class="col-12">
            <span class="spinner-border spinner-border-sm text-primary" id="carregandoCamera"></span>Buscando camera...
            <video id="scanQRCode" width="100%" class="d-none"></video>
          </div>
        </div>
        <div class="row d-none" id="linhaDados">
          <div class="col-12" id="divDados">
            <span class="spinner-border spinner-border-sm text-primary"></span>Buscando dados...
          </div>
        </div>
      </div>

      <!-- footer -->
      <div class="modal-footer d-none" id="modalFooter">
        <button type="button" class="btn btn-danger">Cancelar</button>
        <button type="button" class="btn btn-success">Confirmar</button>
      </div>

    </div>
  </div>
</div>
    
    



