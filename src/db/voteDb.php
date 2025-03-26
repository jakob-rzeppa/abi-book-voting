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

function insertVote($student_id, $teacher_id, $question_id)
{
    global $conn;

    if ($student_id && $teacher_id) {
        return;
    }

    if ($student_id) {
        $sql = "INSERT INTO vote (student_id, question_id) VALUES ($student_id, $question_id)";
    } else if ($teacher_id) {
        $sql = "INSERT INTO vote (teacher_id, question_id) VALUES ($teacher_id, $question_id)";
    } else {
        return;
    }

    $conn->exec($sql);
}
