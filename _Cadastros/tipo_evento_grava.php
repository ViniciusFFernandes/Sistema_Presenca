<?php
    include_once("../_BD/conecta_login.php");
    include_once("../funcoes/funcoes.php");

     if($_POST['operacao'] == 'Gravar'){
        if(empty($_POST['tiev_descricao'])){
            mostraErro("A descrição do tipo de evento não pode ser informado em branco!", "Gravar");
        }
        //
        $db->setTabela("tipos_eventos", "tiev_id");
        //
        $dados['id']                = $_POST['tiev_id'];
        $dados['tiev_descricao'] 	= sgr($_POST['tiev_descricao']);
        $db->gravarInserir($dados);
        //
        if($db->erro()){
            header("Location: ../_Cadastros/tipo_evento_edita.php?msg=Erro%20ao%20gravar%20Tipo%20de%20Evento&msgTipo=erro");
            exit;
        }else{
            if ($_POST['tiev_id'] > 0) {
                $id = $_POST['tiev_id'];
            }else{
                $id = $db->getUltimoID();
            }
            header("Location: ../_Cadastros/tipo_evento_edita.php?tiev_id={$id}msg=Tipo%20de%20Evento%20gravado%20com%20sucesso&msgTipo=sucesso");
            exit;
        }
    }

    if($_POST['operacao'] == 'Excluir'){
        $db->setTabela("tipos_eventos", "tiev_id");
        $db->excluir($_POST['tiev_id']);
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