<?php

namespace App;

use function App\Db\{
    getHashedIdByEmail,
    insertUser
};
use function App\Util\sendEmail;

include('./db/connection.php');
require_once('./db/userDb.php');
require_once('./util/sendEmail.php');

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Abi Buch Abstimmungen</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
            text-align: center;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            margin-bottom: 10px;
            font-weight: bold;
        }

        input[type="email"] {
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        input[type="submit"] {
            padding: 10px;
            background-color: #28a745;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #218838;
        }

        a {
            display: block;
            margin-top: 20px;
            color: #007bff;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        .message {
            margin-top: 20px;
            color: red;
        }
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

                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    echo 'Invalide Email Adresse';
                    exit;
                }

                if (!preg_match('/@igsff-bs\.de$/', $email)) {
                    echo 'Du musst eine IGSFF Email Adresse verwenden';
                    exit;
                }

                $hashedId = getHashedIdByEmail($email);

                if (!$hashedId) {
                    insertUser($email);
                    $hashedId = getHashedIdByEmail($email);
                }

                $url = $_ENV['EMAIL_URL'];

                $message = "Bitte clicke auf den folgenden Link um für dein Abi Buch abzustimmen: $url/vote.php?id=$hashedId";

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