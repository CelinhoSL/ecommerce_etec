<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use App\Models\AdminAuthCodeService;
require_once("../vendor/autoload.php");

class UserMailer extends Controller
{

    public  function sendCode(string $email, string $code): void {
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
            $mail->Subject = 'Seu código de verificação';
            $mail->Body = "Seu código é: <strong>{$code}</strong><br>Válido por 10 minutos. <a href='https://localhost:8000/confirm-code'>Confirmar código</a>";

            $mail->send();
        } catch (Exception $e) {
            throw new \Exception("Erro ao enviar e-mail: " . $mail->ErrorInfo);
        }
    }


    public  function newDeviceDeteced(string $email): void {
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
            $mail->setFrom('seu email', 'Novo Logi');
            $mail->addAddress($email); // Email que foi passado por parâmetro

            // Assunto e corpo do e-mail
            $mail->isHTML(true);
            $mail->Subject = 'Seu código de verificação';
            $mail->Body    = "Um novo dispositivo foi conectado à sua conta. Se não foi você click aqui: <a href='http://localhost:8000/redefine-pasword'><a>";

            $mail->send();
        } catch (Exception $e) {
            throw new \Exception("Erro ao enviar e-mail: " . $mail->ErrorInfo);
        }
    }
}

