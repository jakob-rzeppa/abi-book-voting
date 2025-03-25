<?php

include 'db.php';

function createStudentQuestionsTable()
{
    global $conn;

    $sql = "CREATE TABLE IF NOT EXISTS studentQuestions (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        question TEXT NOT NULL
    )";

    $conn->exec($sql);
}

function getQuestions()
{
    global $conn;

    $sql = "SELECT * FROM studentQuestions";

    $stmt = $conn->prepare($sql);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function insertQuestion($question)
{
    global $conn;

    $sql = "INSERT INTO studentQuestions (question) VALUES ('$question')";

    $conn->exec($sql);
}
