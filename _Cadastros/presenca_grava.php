<?php
    include_once("../_BD/conecta_login.php");
    include_once("../funcoes/funcoes.php");

    if($_POST['operacao'] == 'buscarDados'){
        $sql = "SELECT * 
                FROM presencas_eventos
                    JOIN eventos ON (prev_ev_id = ev_id)
                    JOIN alunos ON (prev_alu_id = alu_id)
                WHERE prev_id = " . $_POST['prev_id'];
        $reg = $db->retornaUmReg($sql);
        if(strtotime($reg['ev_data'] . " " . $reg['ev_hora_fim']) <= strtotime(date("Y-m-d H:i"))){
            echo "Evento Finalizado";
            exit;
        }
        ?>
        <div class="row">
            <div class="col-12 col-sm-6">Nome: <?= $reg['alu_nome'] ?></div>
            <div class="col-12 col-sm-6">Curso: <?= $reg['alu_curso'] ?></div>
            <div class="col-12">Evento: <?= $reg['ev_nome'] ?></div>
            <?php
                if(!empty($reg['prev_data_hora'])){ ?>
                    <div class="col-12 mt-1" style="font-size: .8rem;"><i>Presença já confirmada - <?= converteData($reg['prev_data_hora']) ?></i></div>
            <?php }
            ?>
        </div>
<?php      exit;
    }

    if($_POST['operacao'] == 'gravarPresenca'){
        $sql = "UPDATE presencas_eventos SET prev_data_hora = '" . date("Y-m-d H:i") . "' WHERE prev_id = " . $_POST['prev_id'];
        //
        $db->executaSQL($sql);
        //
        if($db->erro()){
            echo "Erro";
            exit;
        }else{
            echo "Ok";
            exit;
        }
    }
?>