<?php
  $menuActive = 'Home';
?>
<!doctype html>
<html lang="pt-br">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
        <title>Sistema de Presença</title>
        <?php
          include_once('rodape.php');
        ?>
        <script src="js/instascan.min.js"></script>
        <script>
          $( document ).ready(function() {
            let scanner = new Instascan.Scanner({
              video: document.getElementById('scanQRCode')
            })
            scanner.addListener('scan', content => {
              alert(content)
            })
            Instascan.Camera.getCameras().then(cameras => {
              if(cameras.length >0 ){
                scanner.start(cameras[0])
              }else{
                $("#divCamera").html("Nenhuma camera encontrada!<br>Verifique se está conectada e atualize a pagina!")
              }
            })
          });
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
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalQRCode">Escanear QR Code</button>
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
        <div class="row">
          <div class="col-12" id="divCamera">
            <video id="scanQRCode"></video>
          </div>
        </div>
      </div>

      <!-- footer -->
      <div class="modal-footer d-none">
        <button type="button" class="btn btn-danger">Close</button>
        <button type="button" class="btn btn-success">Confirmar</button>
      </div>

    </div>
  </div>
</div>
    
    



