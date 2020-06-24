<?php
    include_once("../_BD/conecta_login.php");
    include_once("../funcoes/funcoes.php");
    //
    //Rotina usada para alterar e inserir novos registros
    if($_POST['operacao'] == 'Gravar'){
        //
        //Validações antes de executar a rotina
        if(empty($_POST['tiev_descricao'])){
            mostraErro("A descrição do tipo de evento não pode ser informado em branco!", "Gravar");
        }
        //
        //inicio da rotina para inserir ou alterar os registros
        $db->setTabela("tipos_eventos", "tiev_id");
        //
        $dados['id']                = $_POST['tiev_id'];
        $dados['tiev_descricao'] 	= sgr($_POST['tiev_descricao']);
        $db->gravarInserir($dados);
        //
        if($db->erro()){
            //
            //Caso a rotina der error retorna com uma mensagem de erro
            header("Location: ../_Cadastros/tipo_evento_edita.php?msg=Erro%20ao%20gravar%20Tipo%20de%20Evento&msgTipo=erro");
            exit;
        }else{
            //
            //Caso a rotorina der certo define qual o id que deve retornar e reotrna com uma mensagem de sucesso
            if ($_POST['tiev_id'] > 0) {
                $id = $_POST['tiev_id'];
            }else{
                $id = $db->getUltimoID();
            }
            header("Location: ../_Cadastros/tipo_evento_edita.php?tiev_id={$id}&msg=Tipo%20de%20Evento%20gravado%20com%20sucesso&msgTipo=sucesso");
            exit;
        }
    }
    //
    //Rotina usada para exclusão de registros
    if($_POST['operacao'] == 'Excluir'){
        //
        //Inicio da rotina
        $db->setTabela("tipos_eventos", "tiev_id");
        $db->excluir($_POST['tiev_id']);
        //
        if($db->erro()){
            //
            //Caso a rotina der error retorna com o id e uma mensagem de erro
            header("Location: ../_Cadastros/tipo_evento_edita.php?tiev_id=" . $_POST['tiev_id'] . "&msg=Erro%20ao%20excluir%20Tipo%20de%20Evento&msgTipo=erro");
            exit;
        }else{
            //
            //Caso a rotorina der certo retorna com uma mensagem de sucesso
            header("Location: ../_Cadastros/tipo_evento_edita.php?msg=Tipo%20de%20Evento%20excluido%20com%20sucesso");
            exit;
        }
    }
?>