<?php
    include_once("../_BD/conecta_login.php");
    include_once("../funcoes/funcoes.php");

    if($_POST['operacao'] == 'Gravar'){
        if(empty($_POST['alu_nome'])){
            mostraErro("O nome do aluno não pode ser informado em branco!", "Gravar");
        }
        if(empty($_POST['alu_email'])){
            mostraErro("O e-mail do aluno não pode ser informado em branco!", "Gravar");
        }
        //
        //
        $db->setTabela("alunos", "alu_id");
        //
        $dados['id']            = $_POST['alu_id'];
        $dados['alu_nome'] 	    = sgr($_POST['alu_nome']);
        $dados['alu_email'] 	= sgr($_POST['alu_email']);
        $dados['alu_curso'] 	= sgr($_POST['alu_curso']);
        $db->gravarInserir($dados);
        //
        if($db->erro()){
            header("Location: ../_Cadastros/alunos_edita.php?msg=Erro%20ao%20gravar%20aluno&msgTipo=erro");
            exit;
        }else{
            if ($_POST['alu_id'] > 0) {
                $id = $_POST['alu_id'];
            }else{
                $id = $db->getUltimoID();
            }
            header("Location: ../_Cadastros/alunos_edita.php?alu_id={$id}&msg=Aluno%20gravado%20com%20sucesso&msgTipo=sucesso");
            exit;
        }
    }   

    if($_POST['operacao'] == 'Excluir'){
        $db->setTabela("alunos", "alu_id");
        $db->excluir($_POST['alu_id']);
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