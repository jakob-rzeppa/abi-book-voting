<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Abi Buch Abstimmung</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            max-width: 100%;
            margin: auto;
            padding: 10px;
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


        <?php if ($questionsToVote[0] == null) { ?>
            <p>Es gibt keine Fragen mehr zum Abstimmen. Vielen Dank für die Teilnahme!</p>
        <?php } else { ?>
            <form action="vote.php" method="post">
                <p>Hallo <?php echo str_replace('.', ' ', strstr($user['email'], '@', true)) ?>, hier kannst du für das Abi Buch Abstimmen. Abstimmungen werden nicht in Verbindung mit deiner Person gespeichert. Bei Fragen gerne an Jakob (jakob.rzeppa@igsff-bs.de) wenden. Vielen Dank für die Teilnahme.</p>
                <h2><?php echo $questionsToVote[0]['question'] ?></h2>
                <?php
                include 'db/studentDb.php';
                include 'db/teacherDb.php';
                $students = getStudents();
                $teachers = getTeachers();
                ?>
                <input type="text" id="searchBar" onkeyup="filterOptions()" placeholder="Search for names..">
                <?php if ($questionsToVote[0]['possible_answers'] == 'teachers') { ?>
                    <select name="teacher" id="teacherSelect">
                        <?php foreach ($teachers as $teacher) { ?>
                            <option value="<?php echo $teacher['id']; ?>"><?php echo $teacher['name']; ?></option>
                        <?php } ?>
                    </select>
                <?php } else if ($questionsToVote[0]['possible_answers'] === 'students') { ?>
                    <select name="student" id="studentSelect">
                        <?php foreach ($students as $student) { ?>
                            <option value="<?php echo $student['id']; ?>"><?php echo $student['name']; ?></option>
                        <?php } ?>
                    </select>
                <?php } else if ($questionsToVote[0]['possible_answers'] === 'everyone') { ?>
                    <select name="answer" id="answerSelect">
                        <?php foreach ($students as $student) { ?>
                            <option value="student:<?php echo $student['id']; ?>"><?php echo $student['name']; ?></option>
                        <?php } ?>
                        <?php foreach ($teachers as $teacher) { ?>
                            <option value="teacher:<?php echo $teacher['id']; ?>"><?php echo $teacher['name']; ?></option>
                        <?php } ?>
                    </select>
                <?php } else if ($questionsToVote[0]['possible_answers'] === 'two_students') { ?>
                    <select name="student_one" id="studentOneSelect">
                        <?php foreach ($students as $student) { ?>
                            <option value="student_one:<?php echo $student['id']; ?>"><?php echo $student['name']; ?></option>
                        <?php } ?>
                    </select>
                    <select name="student_two" id="studentTwoSelect">
                        <?php foreach ($students as $student) { ?>
                            <option value="student_two:<?php echo $student['id']; ?>"><?php echo $student['name']; ?></option>
                        <?php } ?>
                    </select>

                    <script>
                        document.querySelector('form').addEventListener('submit', function(event) {
                            var studentOneSelect = document.getElementById('studentOneSelect');
                            var studentTwoSelect = document.getElementById('studentTwoSelect');

                            if (studentOneSelect.value.split(':')[1] === studentTwoSelect.value.split(':')[1]) {
                                event.preventDefault();
                                alert("Die beiden Schüler müssen unterschiedlich sein.");
                            }
                        });
                    </script>
                <?php } ?>

                <script>
                    function filterOptions() {
                        var input, filter, select, options, i;
                        input = document.getElementById('searchBar');
                        filter = input.value.toLowerCase();
                        select = document.querySelectorAll('select');
                        select.forEach(function(sel) {
                            options = sel.getElementsByTagName('option');
                            for (i = 0; i < options.length; i++) {
                                txtValue = options[i].textContent || options[i].innerText;
                                if (txtValue.toLowerCase().indexOf(filter) > -1) {
                                    options[i].style.display = "";
                                } else {
                                    options[i].style.display = "none";
                                }
                            }
                        });
                    }
                </script>
                <input type="submit" value="Abstimmen">
            </form>
        <?php } ?>

        <?php

        if (isset($_POST['student'])) {
            $student = $_POST['student'];

            insertVote($questionsToVote[0]['id'], 'student', $student);
            insertVoted($user['id'], $questionsToVote[0]['id']);

            unset($_POST['submit']);
            unset($_POST['student']);

            echo "<meta http-equiv='refresh' content='0'>";
        } else if (isset($_POST['teacher'])) {
            $teacher = $_POST['teacher'];

            insertVote($questionsToVote[0]['id'], 'teacher', $teacher);
            insertVoted($user['id'], $questionsToVote[0]['id']);

            unset($_POST['submit']);
            unset($_POST['teacher']);

            echo "<meta http-equiv='refresh' content='0'>";
        } else if (isset($_POST['answer'])) {
            $answer = explode(':', $_POST['answer']);

            insertVote($questionsToVote[0]['id'], $answer[0], $answer[1]);
            insertVoted($user['id'], $questionsToVote[0]['id']);

            unset($_POST['submit']);
            unset($_POST['answer']);

            echo "<meta http-equiv='refresh' content='0'>";
        } else if (isset($_POST['student_one']) && isset($_POST['student_two'])) {
            $answer = explode(':', $_POST['student_one']);
            $answer2 = explode(':', $_POST['student_two']);
            if ($answer[1] === $answer2[1]) {
                echo "<script>alert('Die beiden Schüler müssen unterschiedlich sein.');</script>";
                echo "<meta http-equiv='refresh' content='0'>";
                exit;
            }

            insertVote($questionsToVote[0]['id'], 'two_students', $answer[1], $answer2[1]);
            insertVoted($user['id'], $questionsToVote[0]['id']);

            unset($_POST['submit']);
            unset($_POST['student_one']);
            unset($_POST['student_two']);

            echo "<meta http-equiv='refresh' content='0'>";
        }
        ?>
    <?php } else { ?>
        <p>Du musst diese Seite über deinen Persönlichen Link aufrufen</p>
        <a href="index.php">Zurück</a>
    <?php } ?>
</body>

</html>