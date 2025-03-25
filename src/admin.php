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

        createStudentQuestionsTable();
    ?>
        <h2>Questions</h2>
        <ul>
            <?php
            $questions = getQuestions();
            if (empty($questions)) {
                echo "No questions";
                exit;
            }

            foreach ($questions as $question) {
                echo "<li>{$question['question']}</li>";
            }
            ?>
        </ul>

        <form method="post">
            <label for="question">Question</label>
            <input type="text" name="question" id="question" placeholder="Question">
            <input type="submit" value="Add Question">
        </form>
        <?php
        if (isset($_POST['question'])) {
            insertQuestion($_POST['question']);
            unset($_POST['question']);
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