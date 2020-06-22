<?php
    include_once("../_BD/conecta_login.php");
    include_once("../funcoes/funcoes.php");
    include_once('../PHPMailer/PHPMailer.php');
    include_once('../PHPMailer/SMTP.php');
    include_once('../PHPMailer/Exception.php');
    include_once('../phpqrcode/qrlib.php');

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    if($_POST['operacao'] == 'Gravar'){
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
                header("Location: ../_Cadastros/evento_edita.php?ev_id=" . $_POST['ev_id'] . "msg=Evento%20alterado%20com%20sucesso&msgTipo=sucesso");
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
            $sql = "SELECT * FROM eventos WHERE ev_id = " . $_POST['ev_id'];
            $reg = $db->retornaUmReg($sql);
            if(strtotime($reg['ev_data'] . " " . $reg['ev_hora_fim']) <= strtotime(date("Y-m-d H:i"))){
                mostraErro("Não é permitido inserir alunos com o evento já finalizado!", "Inserir");
            }
            //
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

        if($_POST['operacao'] == 'gerarQR'){
        
                $sql = "SELECT * FROM presencas_eventos 
                            JOIN alunos ON (prev_alu_id = alu_id) 
                            JOIN eventos ON (prev_ev_id = ev_id)
                        WHERE prev_ev_id = " . $_POST['ev_id'];
                if($_POST['prev_id'] != ''){
                    $sql .= " AND prev_id = " . $_POST['prev_id'];
                }
                // echo $sql;
                $res = $db->consultar($sql);
                foreach($res AS $reg){
                    //                   
                    QRcode::png($reg['prev_id'], "qrcode_tmp.png", QR_ECLEVEL_H, 10);
                    //
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

                    $mail = new PHPMailer();

                    try {
                        $mail->isSMTP();
                        $mail->Host = $SMTP_HOST;
                        $mail->SMTPAuth = true;
                        $mail->Username = $SMTP_LOGIN;
                        $mail->Password = $SMTP_SENHA;
                        $mail->Port = $SMTP_PORTA;

                        $mail->setFrom($SMTP_EMAIL);
                        $mail->addAddress($reg['alu_email']);
                        
                        $mail->AddEmbeddedImage("qrcode_tmp.png",$cid,$cid);
                        $mail->isHTML(true);
                        $mail->Subject = "QR Code do Evento " . $reg['ev_nome'];
                        $mail->Body = $texto;

                        if(!$mail->send()) {
                            echo 'Erro';
                            unlink("qrcode_tmp.png");
                            exit;
                        }
                    } catch (Exception $e) {
                        echo "Erro ao enviar mensagem: {$mail->ErrorInfo}";
                        unlink("qrcode_tmp.png");
                        exit;
                    }
                    unlink("qrcode_tmp.png");
                }
            echo 'Ok';
            exit;
        }
    ?>