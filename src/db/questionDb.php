<?php

include 'db.php';

function createQuestionTable()
{
    global $conn;

    $sql = "CREATE TABLE IF NOT EXISTS question (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        question TEXT NOT NULL
    )";

    $conn->exec($sql);
}

function getQuestions()
{
    global $conn;

    $sql = "SELECT * FROM question";

    $stmt = $conn->prepare($sql);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function insertQuestion($question)
{
    global $conn;

    $sql = "INSERT INTO question (question) VALUES ('$question')";

    $conn->exec($sql);
}

function deleteQuestion($id)
{
    global $conn;

    $sql = "DELETE FROM question WHERE id = $id";

    $conn->exec($sql);
}
