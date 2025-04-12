<?php

namespace App;

use Exception;

use function App\Db\{
    getUserByToken,
    getQuestions,
    getAlreadyVotedQuestions,
    getStudents,
    getTeachers
};

require_once('./db/userDb.php');
require_once('./db/questionDb.php');
require_once('./db/studentDb.php');
require_once('./db/teacherDb.php');
require_once('./db/votedDb.php');

use function App\Util\sanitize;

require_once('./util/sanitize.php');

use function App\Util\{
    handleStudentVote,
    handleTeacherVote,
    handleStudentAndTeacherVote,
    handleTwoStudentsVote
};

require_once('./util/handleVote.php');

if (isset($_GET['token'])) {
    setcookie('user_token', $_GET['token'], time() + (86400 * 30), "/");
    header("Location: vote.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Abi Buch Abstimmung</title>
    <style>
        <?php include "./css/vote.css" ?>
    </style>
</head>

<body>
    <?php

    $userToken = $_COOKIE['user_token'];

    if (isset($userToken)) {

        try {
            $userToken = sanitize($userToken, 'string');
        } catch (Exception $e) {
            echo $e->getMessage();
            exit;
        }

        $user = getUserByToken($userToken);

        if (!$user) {
            echo "<p>Nutzer nicht gefunden. Dein Link ist nicht valide! Probiere es nochmal. Falls es immer noch nicht geht nutze einen anderen Browser oder lösche deine Browserdaten (cookies).</p>";
            echo "<a href='index.php'>Neue Email bekommen</a>";
            echo "<a href='https://www.ionos.de/digitalguide/websites/webseiten-erstellen/cookies-loeschen/' target='_blank'>Tutorial zum Cookies löschen</a>";
            exit();
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
                $students = getStudents();
                $teachers = getTeachers();
                ?>
                <?php if ($questionsToVote[0]['possible_answers'] == 'teachers') { ?>
                    <input type="text" name="teacher" list="teachers" placeholder="Lehrername" autocomplete="off">
                    <datalist id="teachers">
                        <?php foreach ($teachers as $teacher) { ?>
                            <option value="<?php echo $teacher['name']; ?>"><?php echo $teacher['name']; ?></option>
                        <?php } ?>
                    </datalist>
                <?php } else if ($questionsToVote[0]['possible_answers'] === 'students') { ?>
                    <input type="text" name="student" list="students" placeholder="Schülername" autocomplete="off">
                    <datalist id="students">
                        <?php foreach ($students as $student) { ?>
                            <option value="<?php echo $student['name']; ?>"><?php echo $student['name']; ?></option>
                        <?php } ?>
                    </datalist>
                <?php } else if ($questionsToVote[0]['possible_answers'] === 'everyone') { ?>
                    <input type="text" name="answer" list="answers" placeholder="Schüler- oder Lehrername" autocomplete="off">
                    <datalist id="answers">
                        <?php foreach ($students as $student) { ?>
                            <option value="<?php echo $student['name']; ?>"><?php echo $student['name']; ?></option>
                        <?php } ?>
                        <?php foreach ($teachers as $teacher) { ?>
                            <option value="<?php echo $teacher['name']; ?>"><?php echo $teacher['name']; ?></option>
                        <?php } ?>
                    </datalist>
                <?php } else if ($questionsToVote[0]['possible_answers'] === 'two_students') { ?>
                    <input type="text" name="student_one" list="students" placeholder="Schülername" autocomplete="off">
                    <input type="text" name="student_two" list="students" placeholder="Schülername" autocomplete="off">
                    <datalist id="students">
                        <?php foreach ($students as $student) { ?>
                            <option value="<?php echo $student['name']; ?>"><?php echo $student['name']; ?></option>
                        <?php } ?>
                    </datalist>
                <?php } ?>
                <input type="submit" value="Abstimmen">
            </form>
        <?php } ?>

        <?php

        if (isset($_POST['student'])) {
            handleStudentVote($user, $questionsToVote[0], $_POST['student']);

            unset($_POST['submit']);
            unset($_POST['student']);

            echo "<meta http-equiv='refresh' content='0'>";
        } else if (isset($_POST['teacher'])) {
            handleTeacherVote($user, $questionsToVote[0], $_POST['teacher']);

            unset($_POST['submit']);
            unset($_POST['teacher']);

            echo "<meta http-equiv='refresh' content='0'>";
        } else if (isset($_POST['answer'])) {
            handleStudentAndTeacherVote($user, $questionsToVote[0], $_POST['answer']);

            unset($_POST['submit']);
            unset($_POST['answer']);

            echo "<meta http-equiv='refresh' content='0'>";
        } else if (isset($_POST['student_one']) && isset($_POST['student_two'])) {
            handleTwoStudentsVote($user, $questionsToVote[0]);

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