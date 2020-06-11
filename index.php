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
    </head>
        <title>Sistema de Presença</title>
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
            <?php
                include_once('rodape.php');
            ?>
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
        Em Desenvolvimento...
      </div>

      <!-- footer -->
      <div class="modal-footer d-none">
        <button type="button" class="btn btn-danger">Close</button>
        <button type="button" class="btn btn-success">Confirmar</button>
      </div>

    </div>
  </div>
</div>
    
    



