<?php

namespace App\Http\Controllers;
use App\Models\AdminToken;
use App\Models\AdminAuthCodeService;
use Illuminate\Http\Request;
require ("../vendor/autoload.php");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class AdminEmailService extends Controller
{

    public function sendTokenEmail($email, $url) {
        // Instancia o PHPMailer
        $mail = new PHPMailer(true);

        try {
            // Configurações SMTP
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'seu email';
            $mail->Password = 'sua senha';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            // Configuração do remetente e destinatário
            $mail->setFrom('seu email', 'Seu Sistema');
            $mail->addAddress($email); // Email que foi passado por parâmetro

            // Assunto e corpo do e-mail
            $mail->isHTML(true);
            $mail->Subject = 'Cadastro de Administrador';
            $mail->Body    = "Clique no link abaixo para concluir seu cadastro:<br><a href='$url'>$url</a>";

            // Enviar o e-mail
            $mail->send();

            echo "Link enviado para: $email<br>";

        } catch (Exception $e) {
            echo "Erro ao enviar e-mail: {$mail->ErrorInfo}";
        }
    }
}


