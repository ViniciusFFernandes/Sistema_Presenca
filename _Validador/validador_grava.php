<?php
    include_once("../_BD/conecta_login.php");
    include_once("../funcoes/funcoes.php");
    //
    //
    $sql = "SELECT *
                FROM eventos
                JOIN presencas_eventos ON (prev_ev_id = ev_id)
                JOIN alunos ON (prev_alu_id = alu_id)
                WHERE prev_cod_certificado = " . sgr($_POST['codigo']);
    //
    $res = $db->consultar($sql);
    //
    if(!$res){ ?>
      <div class="row">
        <div class="col-12">
            <b class="text-dange">Código de certificado inválido!</b> <br>
            Nenhum certificado foi encontrado com este código!
        </div>
      </div>
<?php  exit;
    }
    //
    foreach($res as $reg){ ?>

        <div class="row justify-content-md-center">
            <div class="col-12 text-center">
                <b class="text-success">Código valido!</b>
            </div>
            <div class="col-12 col-md-4 card m-1 ">
                <div class="row card-header bg-primary text-light">
                    <div class="col-12 mt-2 text-center">
                        <b>Dados do Aluno</b>
                    </div>
                </div>
                <div class="row card-body">    
                    <div class="col-12 mb-2">
                        Aluno: <?= $reg['alu_nome'] ?>
                    </div>
                    <div class="col-12">
                        Curso: <?= $reg['alu_curso'] ?>
                    </div>
                </div>
            </div>    
            <div class="col-12 col-md-7 card m-1">
                <div class="row card-header bg-primary text-light">
                    <div class="col-12 mt-2 text-center">
                        <b>Dados do Evento</b>
                    </div>
                </div>
                <div class="row card-body">    
                    <div class="col-12 col-md-4 mb-2">
                        Evento: <?= $reg['ev_nome'] ?>
                    </div>
                    <div class="col-12 col-md-4 mb-2">
                        Responsável: <?= $reg['ev_responsavel'] ?>
                    </div>
                    <div class="col-12 col-md-4 mb-2">
                        Carga Horário: <?= $reg['ev_horas'] ?>
                    </div>
                    <div class="col-12 col-md-4 mb-2">
                        Data: <?= converteData($reg['ev_data']) ?>
                    </div>
                    <div class="col-12 col-md-4 mb-2">
                        Inicio: <?= $reg['ev_hora_inicio'] ?>
                    </div>
                    <div class="col-12 col-md-4 mb-2">
                        Fim: <?= $reg['ev_hora_fim'] ?>
                    </div>
                </div>
            </div>
      </div>
<?php  } ?>
                       