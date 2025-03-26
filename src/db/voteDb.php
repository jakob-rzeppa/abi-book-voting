<?php

include 'db.php';

function getVotes($question_id)
{
    global $conn;

    $sql = "SELECT * FROM vote WHERE question_id = $question_id";

    $stmt = $conn->prepare($sql);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function insertVote($question_id, $type, $id)
{
    global $conn;

    switch ($type) {
        case 'student':
            $sql = "INSERT INTO vote (question_id, student_id) VALUES ($question_id, $id)";
            break;
        case 'teacher':
            $sql = "INSERT INTO vote (question_id, teacher_id) VALUES ($question_id, $id)";
            break;
        default:
            return;
    }

    $conn->exec($sql);
}
