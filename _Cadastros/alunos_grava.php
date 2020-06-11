<?php
  include_once("../_BD/conecta_login.php");

  if($_POST['operacao'] == 'Gravar'){
      if($_POST['alu_id'] > 0){
        $sql = "UPDATE alunos SET ";
        $sql .= " alu_nome = '" . $_POST['alu_nome'] . "', ";
        $sql .= " alu_email = '" . $_POST['alu_email'] . "', ";
        $sql .= " alu_curso = '" . $_POST['alu_curso'] . "'";
        $sql .= " WHERE alu_id = " . $_POST['alu_id'];
        //
        $db->executaSQL($sql);
        //
        if($db->erro()){
            header("Location: ../_Cadastros/alunos_edita.php?msg=Erro%20ao%20editar%20aluno&msgTipo=erro");
            exit;
        }else{
            header("Location: ../_Cadastros/alunos_edita.php?msg=Aluno%20alterado%20com%20sucesso&msgTipo=sucesso");
            exit;
        }
      }else{
        $sql = "INSERT INTO alunos (alu_nome, alu_email, alu_curso) VALUES( ";
        $sql .= "'" . $_POST['alu_nome'] . "', ";
        $sql .= "'" . $_POST['alu_email'] . "', ";
        $sql .= "'" . $_POST['alu_curso'] . "')";
                //
        $db->executaSQL($sql);
        //
        if($db->erro()){
            header("Location: ../_Cadastros/alunos_edita.php?msg=Erro%20ao%20cadastrar%20aluno&msgTipo=erro");
            exit;
        }else{
            $sql = "SELECT alu_id FROM alunos ORDER BY alu_id DESC LIMIT 1";
            $reg = $db->retornaUmReg($sql);
            $alu_id = $reg['alu_id'];
            //
            header("Location: ../_Cadastros/alunos_edita.php?alu_id=" . $alu_id . "&msg=Aluno%20cadastrado%20com%20sucesso&msgTipo=sucesso");
            exit;
        }
      }
    }

    if($_POST['operacao'] == 'Excluir'){
        $sql = "DELETE FROM alunos WHERE alu_id = " . $_POST['alu_id'];
        //
        $db->executaSQL($sql);
        //
        if($db->erro()){
            header("Location: ../_Cadastros/alunos_edita.php?alu_id=" . $_POST['alu_id'] . "&msg=Erro%20ao%20excluir%20aluno&msgTipo=erro");
            exit;
        }else{
            header("Location: ../_Cadastros/alunos_edita.php?msg=Aluno%20excluido%20com%20sucesso");
            exit;
        }
    }
?>