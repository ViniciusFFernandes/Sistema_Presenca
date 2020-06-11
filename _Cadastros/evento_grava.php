<?php
  include_once("../_BD/conecta_login.php");

  if($_POST['operacao'] == 'Gravar'){
      if($_POST['ev_id'] > 0){
        $sql = "UPDATE eventos SET ";
        $sql .= " ev_nome = '" . $_POST['ev_nome'] . "', ";
        $sql .= " ev_tiev_id = " . $_POST['ev_tiev_id'] . ", ";
        $sql .= " ev_responsavel = '" . $_POST['ev_responsavel'] . "', ";
        $sql .= " ev_horas = " . $_POST['ev_horas'] . ", ";
        $sql .= " ev_data = '" . $_POST['ev_data'] . "', ";
        $sql .= " ev_hora_inicio = '" . $_POST['ev_hora_inicio'] . "', ";
        $sql .= " ev_hora_fim = '" . $_POST['ev_hora_fim'] . "'";
        $sql .= " WHERE ev_id = " . $_POST['ev_id'];
        //
        $db->executaSQL($sql);
        //
        if($db->erro()){
            header("Location: ../_Cadastros/evento_edita.php?msg=Erro%20ao%20editar%20evento&msgTipo=erro");
            exit;
        }else{
            header("Location: ../_Cadastros/evento_edita.php?msg=Evento%20alterado%20com%20sucesso&msgTipo=sucesso");
            exit;
        }
      }else{
        $sql = "INSERT INTO eventos (ev_nome, ev_tiev_id, ev_responsavel, ev_horas, ev_data, ev_hora_inicio, ev_hora_fim) VALUES( ";
        $sql .= "'" . $_POST['ev_nome'] . "', ";
        $sql .=  $_POST['ev_tiev_id'] . ", ";
        $sql .= "'" . $_POST['ev_responsavel'] . "', ";
        $sql .=  $_POST['ev_horas'] . ", ";
        $sql .= "'" . $_POST['ev_data'] . "', ";
        $sql .= "'" . $_POST['ev_hora_inicio'] . "', ";
        $sql .= "'" . $_POST['ev_hora_fim'] . "')";
                //
        $db->executaSQL($sql);
        //
        if($db->erro()){
            header("Location: ../_Cadastros/evento_edita.php?msg=Erro%20ao%20cadastrar%20evento&msgTipo=erro");
            exit;
        }else{
            $sql = "SELECT ev_id FROM eventos ORDER BY ev_id DESC LIMIT 1";
            $reg = $db->retornaUmReg($sql);
            $ev_id = $reg['ev_id'];
            //
            header("Location: ../_Cadastros/evento_edita.php?ev_id=" . $ev_id . "&msg=Evento%20cadastrado%20com%20sucesso&msgTipo=sucesso");
            exit;
        }
      }
    }

    if($_POST['operacao'] == 'Excluir'){
        $sql = "DELETE FROM eventos WHERE ev_id = " . $_POST['ev_id'];
        //
        $db->executaSQL($sql);
        //
        if($db->erro()){
            header("Location: ../_Cadastros/evento_edita.php?ev_id=" . $_POST['ev_id'] . "&msg=Erro%20ao%20excluir%20evento&msgTipo=erro");
            exit;
        }else{
            header("Location: ../_Cadastros/evento_edita.php?msg=Evento%20excluido%20com%20sucesso");
            exit;
        }
    }

    if($_POST['operacao'] == 'incluir_alunos'){
        //print_r($_POST);
        foreach($_POST['checkbox_alu_id'] AS $alu_id){
            $sql = "INSERT INTO presencas_eventos (prev_alu_id, prev_ev_id) VALUES( ";
            $sql .=  $alu_id . ", ";
            $sql .=  $_POST['ev_id'] . ") ";
            //
            $db->executaSQL($sql);
            //
            if($db->erro()){
                header("Location: ../_Cadastros/evento_edita.php?ev_id=" . $_POST['ev_id'] . "msg=Erro%20ao%incluir%20alunos%20no%20evento&msgTipo=erro");
                exit;
            }
        }
        //
        header("Location: ../_Cadastros/evento_edita.php?ev_id=" . $_POST['ev_id'] . "&msg=Alunos%20incluidos%20no%20evento");
        exit;
    }

    if($_POST['operacao'] == 'excluirMatricula'){
        $sql = "DELETE FROM presencas_eventos WHERE prev_id = " . $_POST['prev_id'];
        //
        $db->executaSQL($sql);
        //
        if($db->erro()){
            echo "Erro";
        }else{
            echo "Ok";
        }
        exit;
    }
?>