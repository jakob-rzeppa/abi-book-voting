<?php

namespace App;

use Exception;

use function App\Db\{
    getHashedIdByEmail,
    getTokenByEmail,
    insertUser
};
use function App\Util\sendEmail;

include('./db/connection.php');
require_once('./db/userDb.php');
require_once('./util/sendEmail.php');

use function App\Util\sanitize;

require_once('./util/sanitize.php');

?>

<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Abi Buch Abstimmungen</title>
    <style>
        <?php include "./css/index.css" ?>
    </style>
</head>

<body>
    <div class="container">
        <form action="index.php" method="POST">
            <label>Email:</label>
            <input type="email" id="email" name="email">
            <input type="submit" value="Schicke Bestätigungsemail">
        </form>
        <a href="admin.php">Admin Panel</a>
        <div class="message">
            <?php
            $email = $_POST['email'];

            if (isset($email)) {

                if (empty($email)) {
                    echo 'Bitte gib eine Email Adresse ein';
                    exit;
                }

                try {
                    $email = sanitize($email, 'email');
                } catch (Exception $e) {
                    echo $e->getMessage();
                    exit;
                }

                if (!preg_match('/@igsff-bs\.de$/', $email)) {
                    echo 'Du musst eine IGSFF Email Adresse verwenden';
                    exit;
                }

                $token = getTokenByEmail($email);

                if (!$token) {
                    insertUser($email);
                    $token = getTokenByEmail($email);
                }

                $url = $_ENV['EMAIL_URL'];

                $message = "Bitte clicke auf den folgenden Link um für dein Abi Buch abzustimmen: $url/vote.php?token=$token";

                $send = sendEmail($email, $message);

                if ($send) {
                    echo 'Email wurde versendet. Bitte überprüfe dein Postfach und Spam-Ordner';
                } else {
                    echo 'Email konnte nicht versendet werden';
                }
            }
            ?>
        </div>
    </div>
</body>

</html>