<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Abi Buch Abstimmungen</title>
</head>

<body>
    <form action="index.php" method="POST">
        <label>Email:</label>
        <input type="email" id="email" name="email">
        <input type="submit" value="Send Email">
    </form>
    <?php
    // include 'send_email.php';
    include 'db.php';

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

        if ($email !== 'rzeppa.jakob@gmail.com') { // TODO change email address to igsff-bs.de
            echo 'Du musst eine IGSFF Email Adresse verwenden';
            exit;
        }

        createUserTable();

        $hashedId = getHashedIdByEmail($email);

        if (!$hashedId) {
            insertUser($email);
            $hashedId = getHashedIdByEmail($email);
        }

        // $send = sendEmail($email);

        if ($send) {
            echo 'Email wurde versendet. Bitte überprüfe dein Postfach und Spam-Ordner';
        } else {
            echo 'Email konnte nicht versendet werden';
        }
    }
    ?>
</body>

</html>