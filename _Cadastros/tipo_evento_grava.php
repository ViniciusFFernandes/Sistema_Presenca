<?php
  include_once("../_BD/conecta_login.php");

  if($_POST['operacao'] == 'Gravar'){
      if($_POST['tiev_id'] > 0){
        $sql = "UPDATE tipos_eventos SET ";
        $sql .= " tiev_descricao = '" . $_POST['tiev_descricao'] . "', ";
        $sql .= " WHERE tiev_id = " . $_POST['tiev_id'];
        //
        $db->executaSQL($sql);
        //
        if($db->erro()){
            header("Location: ../_Cadastros/tipo_evento_edita.php?msg=Erro%20ao%20editar%20Tipo%20de%20Evento&msgTipo=erro");
            exit;
        }else{
            header("Location: ../_Cadastros/tipo_evento_edita.php?tiev_id=" . $_POST['tiev_id'] . "msg=Tipo%20de%20Evento%20alterado%20com%20sucesso&msgTipo=sucesso");
            exit;
        }
      }else{
        $sql = "INSERT INTO tipos_eventos (tiev_descricao) VALUES( ";
        $sql .= "'" . $_POST['tiev_descricao'] . "') ";
                //
        $db->executaSQL($sql);
        //
        if($db->erro()){
            header("Location: ../_Cadastros/tipo_evento_edita.php?msg=Erro%20ao%20cadastrar%20Tipo%20de%20Evento&msgTipo=erro");
            exit;
        }else{
            $sql = "SELECT tiev_id FROM tipos_eventos ORDER BY tiev_id DESC LIMIT 1";
            $reg = $db->retornaUmReg($sql);
            $tiev_id = $reg['tiev_id'];
            //
            header("Location: ../_Cadastros/tipo_evento_edita.php?tiev_id=" . $tiev_id . "&msg=Tipo%20de%20Evento%20cadastrado%20com%20sucesso&msgTipo=sucesso");
            exit;
        }
      }
    }

    if($_POST['operacao'] == 'Excluir'){
        $sql = "DELETE FROM tipos_eventos WHERE tiev_id = " . $_POST['tiev_id'];
        //
        $db->executaSQL($sql);
        //
        if($db->erro()){
            header("Location: ../_Cadastros/tipo_evento_edita.php?tiev_id=" . $_POST['tiev_id'] . "&msg=Erro%20ao%20excluir%20Tipo%20de%20Evento&msgTipo=erro");
            exit;
        }else{
            header("Location: ../_Cadastros/tipo_evento_edita.php?msg=Tipo%20de%20Evento%20excluido%20com%20sucesso");
            exit;
        }
    }
?>