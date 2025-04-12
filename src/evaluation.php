<?php

namespace App;

use function App\Db\{
    getQuestions,
    getVotes,
    getStudent,
    getTeacher
};

require_once('./db/questionDb.php');
require_once('./db/voteDb.php');
require_once('./db/studentDb.php');
require_once('./db/teacherDb.php');

if ($_COOKIE['admin_password'] !== $_ENV['ADMIN_PASSWORD']) {
    header('Location: admin.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Auswertung Abi Buch Abstimmungen</title>
    <style>
        <?php include "./css/evaluation.css" ?>
    </style>
</head>

<body>
    <h1>Auswertung</h1>
    <div class="container">
        <a href="admin.php">Zurück zum Admin Panel</a>
        <?php

        $questions = getQuestions();

        if ($questions[0] == null) {
            die('Keine Fragen gefunden');
        }

        foreach ($questions as $question) {
            echo '<h2>' . htmlspecialchars($question['question']) . '</h2>';
            $votes = getVotes($question['id']);
            if (empty($votes)) {
                echo '<p>No votes for this question.</p>';
            } else {
                echo '<ul>';
                $voteCounts = [];
                foreach ($votes as $vote) {
                    if (isset($vote['student_id'])) {
                        $student = getStudent($vote['student_id']);
                        $name = $student['name'];
                    } else if (isset($vote['teacher_id'])) {
                        $teacher = getTeacher($vote['teacher_id']);
                        $name = $teacher['name'];
                    } else if (isset($vote['first_student_id']) && isset($vote['second_student_id'])) {
                        $firstStudent = getStudent($vote['first_student_id']);
                        $secondStudent = getStudent($vote['second_student_id']);
                        $names = [$firstStudent['name'], $secondStudent['name']];
                        sort($names, SORT_STRING);
                        $name = implode(' and ', $names);
                    } else {
                        continue;
                    }

                    if (isset($voteCounts[$name])) {
                        $voteCounts[$name]++;
                    } else {
                        $voteCounts[$name] = 1;
                    }
                }

                arsort($voteCounts);
                foreach ($voteCounts as $studentName => $count) {
                    echo '<li>' . htmlspecialchars($studentName) . ': ' . $count . '</li>';
                }
                echo '</ul>';
            }
        }
        ?>
    </div>
</body>

</html>