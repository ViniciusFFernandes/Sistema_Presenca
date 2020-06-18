<?php
  include_once("../_BD/conecta_login.php");
  $menuActive = 'Relatorios';
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
      $(document).ready(function(){
                    // Atribui evento e função para limpeza dos campos
                    $('#alu_nome').on('input', limpaCampos);
                    // Dispara o Autocomplete a partir do segundo caracter
                    $( '#alu_nome' ).autocomplete({
                      minLength: 2,
                      source: function( request, response ) {
                          $.ajax({
                              url: '../_Autocomplementar/autocomplementar.php',
                              dataType: 'json',
                              method: 'POST', 
                              data: {
                                campoMostra: 'alu_nome',
                                campoId: 'alu_id',
                                tabela: 'alunos',
                                where: ' WHERE alu_nome LIKE \'%' + $('#alu_nome').val() + '%\'',
                                qteLimit : 10,
                                consulta:  $('#alu_nome').val()
                              },
                              success: function(data) {
                                 response(data);
                              }
                          });
                      },
                      select: function(event, ui) {
                          $('#alu_nome').val(ui.item.mostra);
                          $('#alu_id').val(ui.item.id);
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
                       var busca = $('#alu_nome').val();
                       if(busca == ''){
                          $('#alu_nome').val(''); 
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
              <b>Relatório de Alunos</b>
            </div>
            <div class="card-body">
              <form action="" method="post" id="form_edita">
                <input type="hidden" id="tiev_id" name="tiev_id" value="<?= $reg['tiev_id'] ?>">
                <input type="hidden" id="operacao" name="operacao" value="Gravar">
                <div class="row" >
                    <div class="col-12 col-sm-6">
                      <div class="form-group">
                        <label for="tiev_descricao">Aluno</label>
                        <input type="text" class="form-control" id="alu_nome" name="alu_nome">
                        <input type="hidden" name="alu_id" id="alu_id">
                      </div>
                    </div>
                </div>
              </form>
            </div>
          </div>
        </div>
    </body>
</html>
