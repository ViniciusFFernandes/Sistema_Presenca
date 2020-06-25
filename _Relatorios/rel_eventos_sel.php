<?php
  include_once("../_BD/conecta_login.php");
  $menuActive = 'Relatorios';
?>
<!DOCTYPE html>
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
      $(document).ready(function(){
                    // Atribui evento e função para limpeza dos campos
                    $('#ev_nome').on('input', limpaCampos);
                    // Dispara o Autocomplete a partir do segundo caracter
                    $( '#ev_nome' ).autocomplete({
                      minLength: 2,
                      source: function( request, response ) {
                          $.ajax({
                              url: '../_Autocomplementar/autocomplementar.php',
                              dataType: 'json',
                              method: 'POST', 
                              data: {
                                campoMostra: 'ev_nome',
                                campoId: 'ev_id',
                                tabela: 'eventos',
                                where: ' WHERE ev_nome LIKE \'%' + $('#ev_nome').val() + '%\'',
                                qteLimit : 10,
                                consulta:  $('#ev_nome').val()
                              },
                              success: function(data) {
                                 response(data);
                              }
                          });
                      },
                      select: function(event, ui) {
                          $('#ev_nome').val(ui.item.mostra);
                          $('#ev_id').val(ui.item.id);
                          return false;
                      }
                    })
                    .autocomplete('instance')._renderItem = function( ul, item ) {
                      return $( '<li>' )
                        .append( '<div>' + item.mostra + '</div>' )
                        .appendTo( ul );
                    };
                    // Função para limpar os campos caso a busca esteja vazia
                    function limpaCampos(){
                       var busca = $('#ev_nome').val();
                       if(busca == ''){
                          $('#ev_nome').val(''); 
                       }
                    }
            })
    </script>  
    <body>
        <?php
            include_once("../menu.php")
        ?>
        <div class="container">
          <div class="card">
            <div class="card-header bg-primary text-light">
              <b>Relatório de Eventos</b>
            </div>
            <div class="card-body">
              <form action="rel_eventos.php" method="post" id="form_rel">
                <div class="row" >
                    <div class="col-12 col-sm-12">
                      <div class="form-group">
                        <label for="alu_nome">Evento</label>
                        <input type="text" class="form-control" id="ev_nome" name="ev_nome">
                        <input type="hidden" name="ev_id" id="ev_id">
                      </div>
                    </div>
                </div>
                <div class="row">
                  <div class="col-12 col-sm-6">
                    <div class="form-group">
                      <label for="ev_tiev_id">Tipo do Evento</label>
                      <select class="form-control" id="ev_tiev_id" name="ev_tiev_id">
                        <option value="">Selecione o Tipo</option>
                        <?php 
                          $sqlTipos = "SELECT * FROM tipos_eventos";
                          $resTipos = $db->consultar($sqlTipos);
                          foreach($resTipos AS $regTipos){
                            echo '<option value="' . $regTipos['tiev_id'] . '">' . $regTipos['tiev_descricao'] . '</option>';
                          }
                        ?>
                      </select>
                    </div>
                  </div>
                  <div class="col-12 col-sm-6">
                    <div class="form-group">
                      <label for="ev_data">Data</label>
                      <input type="date" class="form-control" id="ev_data" name="ev_data" value="">
                    </div>
                  </div>
                </div>
                <div class="row" >
                    <div class="col-12 col-sm-12">
                      <div class="form-group d-flex justify-content-center">
                        <input type="submit" class="btn btn-primary" name="btnLista" value="Listar">
                      </div>
                    </div>
                </div>
              </form>
            </div>
          </div>
        </div>
    </body>
</html>
