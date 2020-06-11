<?php
  include_once("../_BD/conecta_login.php");

  if($_POST['operacao'] == 'Gravar'){
      if($_POST['idalunos'] > 0){
        $sql = "UPDATE alunos SET ";
        $sql .= " nome_alu = '" . $_POST['nome_alu'] . "', ";
        $sql .= " email_alu = '" . $_POST['email_alu'] . "', ";
        $sql .= " curso_alu = '" . $_POST['curso_alu'] . "'";
        $sql .= " WHERE alunos_id = " . $_POST['alunos_id'];
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
        $sql = "INSERT INTO alunos (nome_alu, email_alu, curso_alu) VALUES( ";
        $sql .= "'" . $_POST['nome_alu'] . "', ";
        $sql .= "'" . $_POST['email_alu'] . "', ";
        $sql .= "'" . $_POST['curso_alu'] . "')";
                //
        $db->executaSQL($sql);
        //
        if($db->erro()){
            header("Location: ../_Cadastros/alunos_edita.php?msg=Erro%20ao%20cadastrar%20aluno&msgTipo=erro");
            exit;
        }else{
            $sql = "SELECT alunos_id FROM alunos ORDER BY alunos_id DESC LIMIT 1";
            $reg = $db->retornaUmReg($sql);
            $alunos_id = $reg['alunos_id'];
            //
            header("Location: ../_Cadastros/alunos_edita.php?alunos_id=" . $alunos_id . "&msg=Aluno%20cadastrado%20com%20sucesso&msgTipo=sucesso");
            exit;
        }
      }
    }

    if($_POST['operacao'] == 'Excluir'){
        $sql = "DELETE FROM alunos WHERE alunos_id = " . $_POST['alunos_id'];
        //
        $db->executaSQL($sql);
        //
        if($db->erro()){
            header("Location: ../_Cadastros/alunos_edita.php?alunos_id=" . $_POST['alunos_id'] . "&msg=Erro%20ao%20excluir%20aluno&msgTipo=erro");
            exit;
        }else{
            header("Location: ../_Cadastros/alunos_edita.php?msg=Aluno%20excluido%20com%20sucesso");
            exit;
        }
    }
?>