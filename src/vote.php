<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        h1 {
            color: #333;
            text-align: center;
            margin-top: 20px;
        }

        p {
            color: #666;
            text-align: center;
            margin: 20px;
        }

        form {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            color: #333;
            margin-bottom: 20px;
        }

        input[type="text"] {
            width: calc(100% - 22px);
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        select {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 2px solid #007bff;
            border-radius: 4px;
            background-color: #e9ecef;
            font-weight: bold;
        }

        input[type="submit"] {
            width: 100%;
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
            text-align: center;
            margin-top: 20px;
            color: #007bff;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <?php if (isset($_GET['id']) || isset($_SESSION['id'])) {
        if (isset($_GET['id']) && !isset($_SESSION['id'])) {
            $_SESSION['id'] = $_GET['id'];
        }

        include 'db/voteDb.php';
        include 'db/userDb.php';
        include 'db/questionDb.php';
        include 'db/votedDb.php';

        $user = getUserByHashedId($_SESSION['id']);

        if (!$user) {
            die('User not found');
        }

        $questions = getQuestions();
        $alreadyVotedQuestions = getAlreadyVotedQuestions($user['id']);

        $questionsToVote = array_values(array_filter($questions, function ($question) use ($alreadyVotedQuestions) {
            foreach ($alreadyVotedQuestions as $alreadyVotedQuestion) {
                if ($question['id'] == $alreadyVotedQuestion['question_id']) {
                    return false;
                }
            }

            return true;
        }));
    ?>

        <h1> Abstimmung </h1>
        <p>Hallo <?php echo str_replace('.', ' ', strstr($user['email'], '@', true)) ?>, hier kannst du für das Abi Buch Abstimmen. Deine Abstimmung ist final und kann nicht geändert werden. Das liegt daran, dass die Daten anonym gespeichert werden und so nicht wieder zurück genommen werden können. Nach dem Abschicken einer Frage wirst du direkt zur nächsten geleitet. Du kannst jederzeit pausieren und mit dem gleichen Link weitermachen. Bei Fragen gerne an Jakob (jakob.rzeppa@igsff-bs.de) wenden. Vielen Dank für die Teilnahme.</p>

        <?php if ($questionsToVote[0] == null) { ?>
            <p>Es gibt keine Fragen mehr zum Abstimmen. Vielen Dank für die Teilnahme!</p>
        <?php } else { ?>
            <form action="vote.php" method="post">
                <h2><?php echo $questionsToVote[0]['question'] ?></h2>
                <?php
                include 'db/studentDb.php';
                $students = getStudents();
                ?>
                <input type="text" id="studentSearch" placeholder="Search for a student...">
                <select name="student" id="studentSelect">
                    <?php foreach ($students as $student) { ?>
                        <option value="<?php echo $student['id']; ?>"><?php echo $student['name']; ?></option>
                    <?php } ?>
                </select>

                <script>
                    document.getElementById('studentSearch').addEventListener('input', function() {
                        var searchValue = this.value.toLowerCase();
                        var options = document.getElementById('studentSelect').options;
                        for (var i = 0; i < options.length; i++) {
                            var optionText = options[i].text.toLowerCase();
                            options[i].style.display = optionText.includes(searchValue) ? '' : 'none';
                        }
                    });
                </script>
                <input type="submit" value="Final Abstimmen">
            </form>
        <?php } ?>

        <?php

        if (isset($_POST['student'])) {
            insertVote($_POST['student'], $questionsToVote[0]['id']);
            insertVoted($user['id'], $questionsToVote[0]['id']);

            unset($_POST['submit']);
            unset($_POST['student']);

            echo "<meta http-equiv='refresh' content='0'>";
        }

        ?>

    <?php } else { ?>
        <p>Du musst diese Seite über deinen Persönlichen Link aufrufen</p>
        <a href="index.php">Zurück</a>
    <?php } ?>
</body>

</html>