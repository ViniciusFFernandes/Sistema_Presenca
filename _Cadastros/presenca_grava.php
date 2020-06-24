<?php
    include_once("../_BD/conecta_login.php");
    include_once("../funcoes/funcoes.php");
    //
    //Rotina usada para buscar dados do usuario correspondente do QR Code lido
    if($_POST['operacao'] == 'buscarDados'){
        $sql = "SELECT * 
                FROM presencas_eventos
                    JOIN eventos ON (prev_ev_id = ev_id)
                    JOIN alunos ON (prev_alu_id = alu_id)
                WHERE prev_id = " . $_POST['prev_id'];
        $reg = $db->retornaUmReg($sql);
        //
        //Neste ponto já possui os dados do aluno e do evento e verifica se o evento ja está finalizado, pois não pdoera mais marcar presença
        if(strtotime($reg['ev_data'] . " " . $reg['ev_hora_fim']) <= strtotime(date("Y-m-d H:i"))){
            echo "Evento Finalizado";
            exit;
        }
        //
        //Caso o evento não tenha sido finalizado irá exibir os dados do aluno e do evento e permitir que seja gravado/atualizado a presença?>
        <div class="row">
            <div class="col-12 col-sm-6">Nome: <?= $reg['alu_nome'] ?></div>
            <div class="col-12 col-sm-6">Curso: <?= $reg['alu_curso'] ?></div>
            <div class="col-12">Evento: <?= $reg['ev_nome'] ?></div>
            <?php
                if(!empty($reg['prev_data_hora'])){ 
                    //
                    //Caso já possua sua presença registra exibi uma mensagem avisando o operador?>
                    <div class="col-12 mt-1" style="font-size: .8rem;"><i>Presença já confirmada - <?= converteData($reg['prev_data_hora']) ?></i></div>
            <?php }
            ?>
        </div>
<?php      exit;
    }
    //
    //Rotina usada para registrar/atualizar presença do aluno no evento
    if($_POST['operacao'] == 'gravarPresenca'){
        //
        //inicio da rotina
        $db->setTabela("presencas_eventos", "prev_id");
        //
        $dados['id']                = $_POST['prev_id'];
        $dados['prev_data_hora'] 	= sgr(date("Y-m-d H:i"));
        $db->gravarInserir($dados);
        //
        if($db->erro()){
            //
            //Caso a rotina der error retorna "Erro" para o javaScript exibir que não foi possivel registrar
            echo "Erro";
            exit;
        }else{
            //
            //Caso a rotina der certo retorna "Ok" para o javaScript exibir que a presença foi registrar
            echo "Ok";
            exit;
        }
    }
?>