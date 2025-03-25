<?php

include 'db.php';

function createVotedTable()
{
    global $conn;

    $sql = "CREATE TABLE IF NOT EXISTS voted (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        user_id INT(6) UNSIGNED,
        question_id INT(6) UNSIGNED,
        FOREIGN KEY (user_id) REFERENCES users(id),
        FOREIGN KEY (question_id) REFERENCES question(id)
    )";

    $conn->exec($sql);
}

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
