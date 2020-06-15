<?php
    include_once("../_BD/conecta_login.php");

    if($_POST['operacao'] == 'buscarDados'){
        $sql = "SELECT * 
                FROM presencas_eventos
                    JOIN eventos ON (prev_ev_id = ev_id)
                    JOIN alunos ON (prev_alu_id = alu_id)
                WHERE prev_id = " . $_POST['prev_id'];
        $reg = $db->retornaUmReg($sql);
        ?>
        <div class="row">
            <div class="col-6">Nome: <?= $reg['alu_nome'] ?></div>
            <div class="col-6">Curso: <?= $reg['alu_curso'] ?></div>
            <div class="col-12">Evento: <?= $reg['ev_nome'] ?></div>
        </div>
<?      exit;
    }

    if($_POST['operacao'] == 'gravarPresenca'){
        $sql = "UPDATE presencas_eventos SET previ_data_hora = " . time() . " WHERE prev_id = " . $_POST['prev_id'];
        //
        $db->executaSQL($sql);
        //
        if($db->erro()){
            echo "Ok";
            exit;
        }else{
            echo "Erro";
            exit;
        }
    }
?>