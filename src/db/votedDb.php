<?php

include 'db.php';

function insertVoted($user_id, $question_id)
{
    global $conn;

    $sql = "INSERT INTO voted (user_id, question_id) VALUES ($user_id, $question_id)";

    $conn->exec($sql);
}

function getAlreadyVotedQuestions($user_id)
{
    global $conn;

    $sql = "SELECT question_id FROM voted WHERE user_id = $user_id";

    $stmt = $conn->prepare($sql);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
