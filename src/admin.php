<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>

    <?php if ($_SESSION['admin_password'] === 'admin') {
        include 'adminDb.php';

        createQuestionTable();
        createStudentTable();
    ?>
        <h1>Admin Panel</h1>
        <a href="index.php">Zurück</a><br>
        <a href="evaluation.php">Auswertung der Abstimmungen</a>
        <h2>Fragen</h2>
        <ul>
            <?php
            $questions = getQuestions();
            if (empty($questions)) {
                echo "Keine Fragen";
            } else {
                foreach ($questions as $question) {
                    echo "<li>{$question['question']}</li>";
                }
            }
            ?>
        </ul>

        <h3>Lösche Fragen</h3>
        <form method="post">
            <label for="delete_question">Fähle Fragen zum Löschen</label>
            <select name="delete_question" id="delete_question">
                <?php
                foreach ($questions as $question) {
                    echo "<option value='{$question['id']}'>{$question['question']}</option>";
                }
                ?>
            </select>
            <input type="submit" value="Lösche Frage">
        </form>
        <form method="post">
            <label for="question">Frage</label>
            <input type="text" name="question" id="question" placeholder="Frage">
            <input type="submit" value="Füge Frage hinzu">
        </form>
        <?php
        if (isset($_POST['question'])) {
            insertQuestion($_POST['question']);
            unset($_POST['question']);
            echo "<meta http-equiv='refresh' content='0'>";
        }

        if (isset($_POST['delete_question'])) {
            deleteQuestion($_POST['delete_question']);
            unset($_POST['delete_question']);
            echo "<meta http-equiv='refresh' content='0'>";
        }
        ?>

        <h2>Schüler</h2>
        <ul>
            <?php
            $students = getStudents();
            if (empty($students)) {
                echo "Keine Schüler vorhanden";
            } else {
                foreach ($students as $student) {
                    echo "<li>{$student['name']}</li>";
                }
            }
            ?>
        </ul>


        <h3>Lösche Schüler</h3>
        <form method="post">
            <label for="delete_student">Wähle einen Schüler zum löschen</label>
            <select name="delete_student" id="delete_student">
                <?php
                foreach ($students as $student) {
                    echo "<option value='{$student['id']}'>{$student['name']}</option>";
                }
                ?>
            </select>
            <input type="submit" value="Lösche Schüler">
        </form>
        <form method="post">
            <label for="student">Schüler</label>
            <input type="text" name="student" id="student" placeholder="Schüler">
            <input type="submit" value="Füge Schüler hinzu">
        </form>
        <?php
        if (isset($_POST['student'])) {
            insertstudent($_POST['student']);
            unset($_POST['student']);
            echo "<meta http-equiv='refresh' content='0'>";
        }

        if (isset($_POST['delete_student'])) {
            deletestudent($_POST['delete_student']);
            unset($_POST['delete_student']);
            echo "<meta http-equiv='refresh' content='0'>";
        }
        ?>


    <?php } else { ?>
        <form action="admin.php" method="post">
            <input type="password" name="password" id="password" placeholder="Password">
            <input type="submit" value="Login">
        </form>
    <?php } ?>

    <?php
    if ($_POST['password'] === 'admin') {
        $_SESSION['admin_password'] = $_POST['password'];
        echo $_SESSION['admin_password'];
        unset($_POST['password']);
    }
    ?>
</body>

</html>