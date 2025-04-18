<?php

namespace App;

use Exception;

use function App\Util\sanitize;
use function App\Util\{
    getJWToken,
    validateJWToken
};

require_once('./util/sanitize.php');
require_once('./util/auth.php');

use function App\Db\{
    getQuestions,
    getStudents,
    getTeachers,
    insertQuestion,
    insertStudent,
    insertTeacher,
    deleteQuestion,
    deleteStudent,
    deleteTeacher
};

require_once('./db/questionDb.php');
require_once('./db/studentDb.php');
require_once('./db/teacherDb.php');



if (isset($_POST['admin_password'])) {

    $password = $_POST['admin_password'];

    try {
        $password = sanitize($password, 'string');
    } catch (Exception $e) {
        echo $e->getMessage();
        exit;
    }

    // Sleep for 1 second to prevent brute force attacks
    sleep(1);

    if ($password === $_ENV['ADMIN_PASSWORD']) {
        $adminToken = getJWToken();

        setcookie('admin_token', $adminToken, time() + 3600, '/');
        echo "<meta http-equiv='refresh' content='0'>";
    }
}

?>
<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <style>
        <?php include "./css/admin.css" ?>
    </style>
</head>

<body>
    <div class="container">
        <?php
        if (isset($_COOKIE['admin_token'])) {
            try {
                $adminToken = sanitize($_COOKIE['admin_token'], 'string');
            } catch (Exception $e) {
                echo $e->getMessage();
                exit;
            }

            if (validateJWToken($_COOKIE['admin_token'])) { ?>
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
                                echo "<li><strong>{$question['question']}</strong> - {$question['possible_answers']}</li>";
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
                            <option value="two_students">Zwei Schüler</option>
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
            <?php }
        } else { ?>
            <form action="admin.php" method="post">
                <input type="password" name="admin_password" placeholder="Password">
                <input type="submit" value="Login">
            </form>
        <?php } ?>
    </div>
</body>

</html>