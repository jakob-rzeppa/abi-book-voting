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

function insertVote($student_id, $question_id)
{
    global $conn;

    $sql = "INSERT INTO vote (student_id, question_id) VALUES ($student_id, $question_id)";

    $conn->exec($sql);
}
