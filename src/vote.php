<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php if (isset($_GET['id'])) {

        include 'db/voteDb.php';
        include 'db/userDb.php';

        $user = getUserByHashedId($_GET['id']);
    ?>

        <h1> Abstimmung </h1>
        <p>Hallo <?php echo str_replace('.', ' ', strstr($user['email'], '@', true)) ?>, hier kannst du für das Abi Buch Abstimmen. Deine Abstimmung ist final und kann nicht geändert werden. Das liegt daran, dass die Daten anonym gespeichert werden und so nicht wieder zurück genommen werden können. Nach dem Abschicken einer Frage wirst du direkt zur nächsten geleitet. Du kannst jederzeit pausieren und mit dem gleichen Link weitermachen. Vielen Dank für die Teilnahme.</p>

    <?php } else { ?>
        <p>Du musst diese Seite über deinen Persönlichen Link aufrufen</p>
        <a href="index.php">Zurück</a>
    <?php } ?>
</body>

</html>