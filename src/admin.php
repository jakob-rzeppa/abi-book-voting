<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 80%;
            margin: 0 auto;
            background: #fff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
        }

        h1,
        h2,
        h3 {
            color: #333;
        }

        a {
            color: #007BFF;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        ul {
            list-style-type: disc;
            padding-left: 20px;
        }

        li {
            background: #f9f9f9;
            margin: 5px 0;
            padding: 10px;
            border: 1px solid #ddd;
        }

        form {
            margin-top: 20px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        input[type="text"],
        input[type="password"],
        select {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        input[type="submit"] {
            background: #007BFF;
            color: #fff;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            border-radius: 4px;
        }

        input[type="submit"]:hover {
            background: #0056b3;
        }
    </style>
</head>

<body>
    <div class="container">
        <?php if ($_SESSION['admin_password'] === 'admin') {
            include 'db/questionDb.php';
            include 'db/studentDb.php';
            include 'db/teacherDb.php';
            include 'db/initDb.php';
        ?>
            <h1>Admin Panel</h1>
            <a href="index.php">Zurück</a><br>
            <a href="evaluation.php">Auswertung der Abstimmungen</a>
            <div>
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
                    <label for="possible_answers">Mögliche Antworten</label>
                    <select name="possible_answers" id="possible_answers">
                        <option value="students">Schüler</option>
                        <option value="teachers">Lehrer</option>
                        <option value="everyone">Jeder</option>
                    </select>
                    <input type="submit" value="Füge Frage hinzu">
                </form>
                <?php
                if (isset($_POST['question'])) {
                    insertQuestion($_POST['question'], $_POST['possible_answers']);
                    unset($_POST['question']);
                    echo "<meta http-equiv='refresh' content='0'>";
                }

                if (isset($_POST['delete_question'])) {
                    deleteQuestion($_POST['delete_question']);
                    unset($_POST['delete_question']);
                    echo "<meta http-equiv='refresh' content='0'>";
                }
                ?>
            </div>
            <div>
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
                    insertStudent($_POST['student']);
                    unset($_POST['student']);
                    echo "<meta http-equiv='refresh' content='0'>";
                }

                if (isset($_POST['delete_student'])) {
                    deleteStudent($_POST['delete_student']);
                    unset($_POST['delete_student']);
                    echo "<meta http-equiv='refresh' content='0'>";
                }
                ?>
            </div>
            <div>
                <h2>Lehrer</h2>
                <ul>
                    <?php
                    $teachers = getTeachers();
                    if (empty($teachers)) {
                        echo "Keine Lehrer vorhanden";
                    } else {
                        foreach ($teachers as $teacher) {
                            echo "<li>{$teacher['name']}</li>";
                        }
                    }
                    ?>
                </ul>

                <h3>Lösche Lehrer</h3>
                <form method="post">
                    <label for="delete_teacher">Wähle einen Lehrer zum löschen</label>
                    <select name="delete_teacher" id="delete_teacher">
                        <?php
                        foreach ($teachers as $teacher) {
                            echo "<option value='{$teacher['id']}'>{$teacher['name']}</option>";
                        }
                        ?>
                    </select>
                    <input type="submit" value="Lösche Lehrer">
                </form>
                <form method="post">
                    <label for="teacher">Lehrer</label>
                    <input type="text" name="teacher" id="teacher" placeholder="Lehrer">
                    <input type="submit" value="Füge Lehrer hinzu">
                </form>
                <?php
                if (isset($_POST['teacher'])) {
                    insertTeacher($_POST['teacher']);
                    unset($_POST['teacher']);
                    echo "<meta http-equiv='refresh' content='0'>";
                }

                if (isset($_POST['delete_teacher'])) {
                    deleteTeacher($_POST['delete_teacher']);
                    unset($_POST['delete_teacher']);
                    echo "<meta http-equiv='refresh' content='0'>";
                }
                ?>
            </div>
            <div>
                <h2>Tables</h2>
                <form method="post">
                    <input type="submit" name="init" value="Init Database">
                </form>
                <?php
                if (isset($_POST['init'])) {
                    initDatabase();
                    echo "database tables initialized";
                }
                ?>
            </div>
        <?php } else { ?>
            <form action="admin.php" method="post">
                <input type="password" name="password" id="password" placeholder="Password">
                <input type="submit" value="Login">
            </form>
        <?php } ?>

        <?php
        if ($_POST['password'] === $_ENV['ADMIN_PASSWORD']) {
            $_SESSION['admin_password'] = $_POST['password'];
            unset($_POST['password']);
            echo "<meta http-equiv='refresh' content='0'>";
        }
        ?>
    </div>
</body>

</html>