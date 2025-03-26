<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Auswertung Abi Buch Abstimmungen</title>
</head>

<body>
    <h1>Auswertung</h1>
    <a href="admin.php">Zurück zum Admin Panel</a>
    <?php
    include 'db/voteDb.php';
    include 'db/questionDb.php';
    include 'db/votedDb.php';
    include 'db/studentDb.php';

    createVotedTable();
    createVoteTable();

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
            foreach ($votes as $vote) {
                $student = getStudent($vote['student_id']);
                echo '<li>' . htmlspecialchars($student['name']) . '</li>';
            }
            echo '</ul>';
        }
    }
    ?>

</body>

</html>