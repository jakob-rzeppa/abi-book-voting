<?php

include 'db.php';

function createVoteTable()
{
    global $conn;

    $sql = "CREATE TABLE IF NOT EXISTS vote (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        student_id INT(6) UNSIGNED,
        question_id INT(6) UNSIGNED,
        FOREIGN KEY (student_id) REFERENCES student(id),
        FOREIGN KEY (question_id) REFERENCES question(id)
    )";

    $conn->exec($sql);
}

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
