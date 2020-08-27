<?php
  include_once("../_BD/conecta_login.php");
  $menuActive = 'Validador';
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
        <link href="../js/jquery-ui-1.12.1/jquery-ui.css" rel="stylesheet">
        <script src="../js/jquery-ui-1.12.1/jquery-ui.js"></script>
    </head>
    <script>
        function validaCertificado(){
            $("#cardCertificado").show();
            $("#dadosCertificado").html('<center><img src="../icones/carregando_engrenagens.gif" width="25px"> Emitindo Certificados...</center>');
            //
            $.post("validador_grava.php", {codigo: $("#codigo").val()}, 
                function(data){
                    $("#dadosCertificado").html(data);
                }, 'html')
        }
    </script>  
    <body>
        <nav class="navbar navbar-expand-lg navbar-light bg-light mb-1 border border-secondary border-top-0 border-left-0 border-right-0 shadow-lg">
            <a class="navbar-brand" href="#">Controle de Presença</a>
        </nav>
        <div class="container">
            <div class="card">
                <div class="card-header bg-primary text-light">
                <b>Validador de Certificados</b>
                </div>
                <div class="card-body">
                <form action="validador_grava.php" method="post" id="form_rel">
                    <div class="row" >
                        <div class="col-12 col-sm-12">
                        <div class="form-group">
                            <label for="ev_nome">Código do certificado</label>
                            <input type="text" class="form-control" id="codigo" name="codigo" placeholder="Código">
                        </div>
                        </div>
                    </div>
                    <div class="row" >
                        <div class="col-12 col-sm-12">
                        <div class="form-group d-flex justify-content-center">
                            <input type="button" class="btn btn-primary" name="btnLista" value="Consultar" onclick="validaCertificado()">
                        </div>
                        </div>
                    </div>
                </form>
                </div>
            </div>
            <div class="card mt-2" id="cardCertificado" style="display: none;">
                <div class="card-header bg-primary text-light">
                    <b>Dados do Certificado</b>
                </div>
                <div class="card-body" id="dadosCertificado">
                </div>
            </div>
        </div>
    </body>
</html>
