<?php
    include_once("../_BD/conecta_login.php");
    include_once("../funcoes/funcoes.php");
    include_once('../PHPMailer/PHPMailer.php');
    include_once('../PHPMailer/SMTP.php');
    include_once('../PHPMailer/Exception.php');
    include_once('../phpqrcode/qrlib.php');
    //
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;
    //
    //Rotina usada para alterar e inserir novos registros
    if($_POST['operacao'] == 'Gravar'){
        //
        //Validações antes de executar a rotina
        if(empty($_POST['ev_nome'])){
            mostraErro("O nome do evento não pode ser informado em branco!", "Gravar");
        }
        if(empty($_POST['ev_tiev_id'])){
            mostraErro("O tipo do evento não pode ser informado em branco!", "Gravar");
        }
        if(empty($_POST['ev_horas'])){
            mostraErro("A carga horaria do evento não pode ser informado em branco!", "Gravar");
        }
        if(empty($_POST['ev_data'])){
            mostraErro("A data do evento não pode ser informado em branco!", "Gravar");
        }
        if(empty($_POST['ev_hora_inicio'])){
            mostraErro("O horario de inicio do evento não pode ser informado em branco!", "Gravar");
        }
        if(empty($_POST['ev_hora_fim'])){
            mostraErro("O horario de fim do evento não pode ser informado em branco!", "Gravar");
        }
        //
        //inicio da rotina para inserir ou alterar os registros
        $db->setTabela("eventos", "ev_id");
        //
        $dados['id']                = $_POST['ev_id'];
        $dados['ev_nome']       	= sgr($_POST['ev_nome']);
        $dados['ev_tiev_id'] 	    = igr($_POST['ev_tiev_id']);
        $dados['ev_responsavel'] 	= sgr($_POST['ev_responsavel']);
        $dados['ev_horas']      	= sgr($_POST['ev_horas']);
        $dados['ev_data']   	    = sgr($_POST['ev_data']);
        $dados['ev_hora_inicio'] 	= sgr($_POST['ev_hora_inicio']);
        $dados['ev_hora_fim']   	= sgr($_POST['ev_hora_fim']);
        $db->gravarInserir($dados);
        //
        if($db->erro()){
            //
            //Caso a rotina der error retorna com uma mensagem de erro
            header("Location: ../_Cadastros/evento_edita.php?msg=Erro%20ao%20gravar%20evento&msgTipo=erro");
            exit;
        }else{
            //
            //Caso a rotorina der certo define qual o id que deve retornar e reotrna com uma mensagem de sucesso
            if ($_POST['ev_id'] > 0) {
                $id = $_POST['ev_id'];
            }else{
                $id = $db->getUltimoID();
            }
            header("Location: ../_Cadastros/evento_edita.php?ev_id={$id}&msg=Evento%20gravado%20com%20sucesso&msgTipo=sucesso");
            exit;
        }
    }
    //
    //Rotina usada para exclusão de registros
    if($_POST['operacao'] == 'Excluir'){
        //
        //Inicio da rotina
        $db->setTabela("eventos", "ev_id");
        $db->excluir($_POST['ev_id']);
        //
        if($db->erro()){
            //
            //Caso a rotina der error retorna uma mensagem de erro
            header("Location: ../_Cadastros/eve'nto_edita.php?ev_id=" . $_POST['ev_id'] . "&msg=Erro%20ao%20excluir%20evento&msgTipo=erro");
            exit;
        }else{
            //
            //Caso a rotorina der certo retorna com uma mensagem de sucesso
            header("Location: ../_Cadastros/evento_edita.php?msg=Evento%20excluido%20com%20sucesso");
            exit;
        }
    }
    //
    //Rotina usada para incluir alunos nos eventos
    if($_POST['operacao'] == 'incluir_alunos'){
        //
        //Validações antes de executar a rotina
        $sql = "SELECT * FROM eventos WHERE ev_id = " . $_POST['ev_id'];
        $reg = $db->retornaUmReg($sql);
        if(strtotime($reg['ev_data'] . " " . $reg['ev_hora_fim']) <= strtotime(date("Y-m-d H:i"))){
            mostraErro("Não é permitido inserir alunos com o evento já finalizado!", "Inserir");
        }
        //
        //Inicio da rotina
        $db->setTabela("presencas_eventos", "prev_id");
        foreach($_POST['checkbox_alu_id'] AS $alu_id){
            unset($dados);
            //
            $dados['id']                = 0;
            $dados['prev_alu_id']       = igr($alu_id);
            $dados['prev_ev_id'] 	    = igr($_POST['ev_id']);
            $db->gravarInserir($dados);
            //
            if($db->erro()){
                //
                //Caso a rotina der error retorna uma mensagem de erro
                header("Location: ../_Cadastros/evento_edita.php?ev_id=" . $_POST['ev_id'] . "msg=Erro%20ao%incluir%20alunos%20no%20evento&msgTipo=erro");
                exit;
            }
        }
        //
        //Caso a rotorina der certo retorna com uma mensagem de sucesso
        header("Location: ../_Cadastros/evento_edita.php?ev_id=" . $_POST['ev_id'] . "&msg=Alunos%20incluidos%20no%20evento");
        exit;
    }
    //
    //Rotina usada para exclusão de registros
    if($_POST['operacao'] == 'excluirMatricula'){
        //
        //Inicio da rotina
        $db->setTabela("presencas_eventos", "prev_id");
        $db->excluir($_POST['prev_id']);
        //
        if($db->erro()){
            //
            //Caso a rotina der error retorna "Erro" para o javaScript exibir que não foi possivel excluir
            echo "Erro";
        }else{
            //
            //Caso a rotina der certo retorna "Ok" para o javaScript exibir que a foi excluido e remover da tela
            echo "Ok";
        }
        exit;
    }
    //
    //Rotina usada para gerar e enviar o QR Code de cada aluno por e-mail
    if($_POST['operacao'] == 'gerarQR'){
        //
        //Inicio da rotina
        $sql = "SELECT * FROM presencas_eventos 
                    JOIN alunos ON (prev_alu_id = alu_id) 
                    JOIN eventos ON (prev_ev_id = ev_id)
                WHERE prev_ev_id = " . $_POST['ev_id'];
        if($_POST['prev_id'] != ''){
            $sql .= " AND prev_id = " . $_POST['prev_id'];
        }
        //
        //Efetua a leitura de todos ou do aluno que deve ser gerado e enviado o QR Code
        $res = $db->consultar($sql);
        foreach($res AS $reg){
            //     
            //Biblioteca usada para gerar o QR Code e salvar a imagem              
            QRcode::png($reg['prev_id'], "qrcode_tmp.png", QR_ECLEVEL_H, 10);
            //
            //Neste ponto define-se o nome da imagem no e-mail e o corpo do mesmo 
            $cid = date('YmdHms').'.'.time();
            //
            $texto="
            <html>
            <body>
            <div>
            <font size=3>
            Ola {$reg['alu_nome']},
            </font>
            </div>
            <div>
            <font size=3>
            Segue a baixo seu QR Code de autetificação para o evento {$reg['ev_nome']} 
            </font>
            </div>
            </ br>
            </ br>
            <div align='center'>
            <img src=\"cid:$cid\">
            </div>
            <div>
            <font size=2>
            Não esqueça de comparecer ao evento com este e-mail em mãos!
            </font>
            </div>
            </body>
            </html>
            ";
            //
            //Inicia a classe para envio de e-mail
            $mail = new PHPMailer();
            //
            //Validação do envio
            try {
                //
                //Inicia a configuracões do servidor smtp (configuração feitas pelo constante.php)
                $mail->isSMTP();
                $mail->Host = $SMTP_HOST;
                $mail->SMTPAuth = true;
                $mail->Username = $SMTP_LOGIN;
                $mail->Password = $SMTP_SENHA;
                $mail->Port = $SMTP_PORTA;
                //
                //Define o e-mail de envio e para qual sera enviado
                $mail->setFrom($SMTP_EMAIL);
                $mail->addAddress($reg['alu_email']);
                //
                if($db->erro()){
                    header("Location: ../_Cadastros/evento_edita.php?ev_id=" . $_POST['ev_id'] . "&msg=Erro%20ao%incluir%20alunos%20no%20evento&msgTipo=erro");
                //Adicona a imagem como anexo para ser exibida no corpo
                $mail->AddEmbeddedImage("qrcode_tmp.png",$cid,$cid);
                $mail->isHTML(true);
                $mail->Subject = "QR Code do Evento " . $reg['ev_nome'];
                $mail->Body = $texto;
                //
                //Verifica se o email foi enviado
                if(!$mail->send()) {
                    echo 'Erro';
                    unlink("qrcode_tmp.png");
                    exit;
                }
            } catch (Exception $e) {
                //
                //Executado caso ocorra algum erro na classe de envio
                echo "Erro ao enviar mensagem: {$mail->ErrorInfo}";
                unlink("qrcode_tmp.png");
                exit;
            }
            //
            //Apaga a imagem gerada pois o sistema não armazena os QR Codes
            unlink("qrcode_tmp.png");
        }
        echo 'Ok';
        exit;
    }
    ?>