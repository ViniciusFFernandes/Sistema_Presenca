<?php
    include_once("../_BD/conecta_login.php");
    include_once("../funcoes/funcoes.php");
    include_once('../PHPMailer/PHPMailer.php');
    include_once('../PHPMailer/SMTP.php');
    include_once('../PHPMailer/Exception.php');
    include_once('../dompdf/lib/html5lib/Parser.php');
    include_once('../dompdf/lib/php-font-lib-master/src/FontLib/Autoloader.php');
    include_once('../dompdf/lib/php-svg-lib-master/src/autoload.php');
    include_once('../dompdf/src/Autoloader.php');
    //
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;
    Dompdf\Autoloader::register();
    use Dompdf\Dompdf;
    //
    $relatorioEnvio = '';
    //
    $sql = "SELECT *
                FROM eventos
                JOIN presencas_eventos ON (prev_ev_id = ev_id)
                JOIN alunos ON (prev_alu_id = alu_id)
                WHERE ev_id = {$_POST['ev_id']}
                AND prev_data_hora IS NOT NULL";
    //
    if($_POST['alu_id'] > 0){
        $sql .= " AND alu_id = {$_POST['alu_id']}";
    }
    // 
    $sql .= " ORDER BY alu_nome";

    $res = $db->consultar($sql);

    if(!$res){ 
        $relatorioEnvio .= "Nenhum certificado encontrado para emissão!";
        exit;
    }
    $relatorioEnvio .= "Certificados Emetidos:";
    foreach($res as $reg){
        //
        //Escreve de quem é o certificado para exibir no final
        $relatorioEnvio .= "<br>&nbsp;&nbsp;&nbsp;{$reg['alu_nome']} ";
        //
        //Testa se o email esta informado
        if($reg['alu_email'] == ''){
            $relatorioEnvio .= "<font color='red'><b>Erro</b></font>";
            continue;
        }
        //
        //Define o codigo do certificado caso não exista
        if(empty($reg['prev_cod_certificado'])){
            $cod = geraCodigoCertificado($reg);
            //
            //Grava o codigo no banco de dados
            $db->setTabela("presencas_eventos", "prev_id");
            //
            $dados['id']                    = $reg['prev_id'];
            $dados['prev_cod_certificado'] 	= sgr($cod);
            //
            $db->gravarInserir($dados);
            //
            $reg['prev_cod_certificado'] = $cod;
        }
        //
        //Inicia a classe para gerar o pdf
        $dompdf = new DOMPDF();
        //
        //Opções da classe
        $dompdf->set_paper('A4', 'landscape');  
        //
        //Carrega o html
        $dompdf->load_html('
        <!doctype html>
        <html lang="pt-br">
            <head>
                <meta charset="utf-8">
                <title>Sistema de Presença</title>
                <style>
                    @page{ 
                        margin: 0px;
                    }

                    #watermark {
                        position: fixed;
                        bottom:   0px;
                        left:     0px;
                        width:    30cm;
                        height:   21cm;
                        z-index:  -1000;
                    }
                </style>
            </head>
            <body>
                <div id="watermark">
                    <img src="../imagens/fundo_certificado.jpg" height="100%" width="100%" />
                </div>
                <main> 
                    <div style="min-width: 297mm; min-height: 210mm;">
                        <div style="font-size: 60px; padding-top:40mm;"><center>Certificado</center></div>
                        <div style="font-size: 28px; text-align: justify; width: 70%; margin: auto; padding-top:30mm;">
                            Certificamos que ' . $reg['alu_nome'] . ' participou do evento ' . $reg['ev_nome'] . ', 
                            realizada no dia ' . converteData($reg['ev_data']) . ', com carga horaria de ' . $reg['ev_horas'] . ' horas, 
                            no ' . $reg['ev_local'] . '.
                        </div>
                    </div>
                </main> 
            </body>
        </html>
        ');
        //
        //Renderizar o html e baixa o certificado para anexar no email
        $dompdf->render();
        $output = $dompdf->output();
        file_put_contents("certificado.pdf", $output);
        //
        //Texto do email
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
                            Segue em anexo o certificado do evento {$reg['ev_nome']} 
                        </font>
                    </div>
                    <div>
                        <font size=3>
                            Agradecemos sua presença!
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
            //Adicona certificado como anexo
            $mail->isHTML(true);
            $mail->AddAttachment("certificado.pdf");
            $mail->Subject = "Certificado do Evento " . $reg['ev_nome'];
            $mail->Body = $texto;
            //
            //Verifica se o email foi enviado
            if(!$mail->send()) {
                $relatorioEnvio .= "<font color='red'><b>Erro</b></font>";
                unlink("certificado.pdf");
                exit;
            }
            $relatorioEnvio .= "<font color='green'><b>Ok</b></font>";
        } catch (Exception $e) {
            //
            //Executado caso ocorra algum erro na classe de envio
            // $relatorioEnvio .= "Erro ao enviar mensagem: {$mail->ErrorInfo}";
            $relatorioEnvio .= "<font color='red'><b>Erro</b></font>";
            unlink("certificado.pdf");
        }
        //
        //Apaga o certificado gerada pois o sistema não armazena os mesmos
        unlink("certificado.pdf");
    }
    //
    //Limpa qualquer saida e imprime o relatorio de envio
    ob_clean();
    echo $relatorioEnvio;


    function geraCodigoCertificado($reg){
        $cod = 'R';
        $cod .= str_pad($reg['alu_id'], 5, "0", STR_PAD_LEFT);
        $cod .= date('Ymd');
        $cod .= $reg['ev_id'];
        $cod .= 'F';
        //
        //retorna o codigo para continuar o programa
        return $cod;
    }
    ?>
                       