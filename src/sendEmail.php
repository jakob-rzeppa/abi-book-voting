<?php

use PHPMailer\PHPMailer\PHPMailer;

require_once 'vendor/autoload.php';

function sendEmail($address, $message)
{
    $send = false;

    $mail = new PHPMailer(true);

    $mail->SMTPAuth = true;
    $mail->SMTPSecure = 'tls';
    $mail->Host = "smtp.gmail.com";
    $mail->Mailer = "smtp";
    $mail->Port = 587;
    $mail->Username = "abiigsff2025@gmail.com";
    // $mail->Password = "";

    //sender information
    $mail->setFrom('abiigsff2025@gmail.com', 'abi-2025-igsff');

    //receiver email address and name
    $mail->addAddress($address, $address);

    $mail->isHTML(false);

    $mail->Subject = 'Abi Buch Abstimmungen';
    $mail->Body    = $message;

    // Attempt to send the email
    if (!$mail->send()) {
        $send = false;
    } else {
        $send = true;
    }

    $mail->smtpClose();

    return $send;
}
