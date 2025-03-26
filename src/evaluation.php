<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Auswertung Abi Buch Abstimmungen</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        h1,
        h2 {
            color: #333;
        }

        h1 {
            background-color: #4CAF50;
            color: white;
            padding: 20px;
            text-align: center;
            margin: 0;
        }

        h2 {
            margin-top: 20px;
        }

        a {
            display: inline-block;
            margin: 20px;
            text-decoration: none;
            color: #4CAF50;
            font-weight: bold;
        }

        a:hover {
            text-decoration: underline;
        }

        .container {
            width: 80%;
            margin: 0 auto;
            background-color: white;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        ul {
            list-style-type: none;
            padding: 0;
        }

        li {
            background-color: #f9f9f9;
            margin: 5px 0;
            padding: 10px;
            border: 1px solid #ddd;
        }
    </style>
</head>

<body>
    <h1>Auswertung</h1>
    <div class="container">
        <a href="admin.php">Zurück zum Admin Panel</a>
        <?php
        include 'db/voteDb.php';
        include 'db/questionDb.php';
        include 'db/votedDb.php';
        include 'db/studentDb.php';
        include 'db/teacherDb.php';

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
                    } elseif (isset($vote['teacher_id'])) {
                        $teacher = getTeacher($vote['teacher_id']);
                        $name = $teacher['name'];
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