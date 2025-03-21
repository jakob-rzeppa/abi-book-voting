<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Abi-Buch Abstimmung</title>
</head>

<body>
    <title>Abi-Buch Abstimmungen</title>
    <form action="auth.php" method="post">
        <label>Bitte gebe deine Schul-Email ein:</label><br>
        <input type="email" name="email" required><br>
        <input type="submit" value="Einloggen">
    </form>
    <?php
    // if (isset($_POST['email'])) {
    //     $email = $_POST['email'];
    //     if (strpos($email, '@igsff-bs.de') !== false) {
    //         echo "Dir wird eine Bestätigungs-Email an {$email} zugesendet! <br> Bitte checke deinen Posteingang und Spam-Ordner und klicke auf den Bestätigungslink!";
    //         $msg = "Hallo, bitte klicke auf den folgenden Link um dich einzuloggen: http://localhost:8080/abi-buch-abstimmung/login.php?email={$email}";

    //         require("class.phpmailer.php");
    //         $mailer = new PHPMailer();
    //         $mailer->IsSMTP();
    //         $mailer->Host = 'ssl://smtp.gmail.com:465';
    //         $mailer->SMTPAuth = TRUE;
    //         $mailer->Username = 'fake[ @ ] googlemail.com';  // Change this to your gmail adress
    //         $mailer->Password = 'fakepassword';  // Change this to your gmail password
    //         $mailer->From = 'fake[ @ ] googlemail.com';  // This HAVE TO be your gmail adress
    //         $mailer->FromName = 'fake'; // This is the from name in the email, you can put anything you like here
    //         $mailer->Body = 'This is the main body of the email';
    //         $mailer->Subject = 'This is the subject of the email';
    //         $mailer->AddAddress('fake2[ @ ] gmail.com');  // This is where you put the email adress of the person you want to mail
    //         if (!$mailer->Send()) {
    //             echo "Message was not sent<br/ >";
    //             echo "Mailer Error: " . $mailer->ErrorInfo;
    //         } else {
    //             echo "Message has been sent";
    //         }
    //     } else {
    //         echo 'Bitte gebe eine gültige IGSFF-Email ein!';
    //     }
    // }
    ?>
</body>

</html>