<?php

namespace App\Db;

function getQuestions()
{
    global $conn;

    $sql = "SELECT * FROM question";

    $stmt = $conn->prepare($sql);
    $stmt->execute();

    return $stmt->fetchAll(\PDO::FETCH_ASSOC);
}

function insertQuestion($question, $possible_answers)
{
    global $conn;

    $sql = "INSERT INTO question (question, possible_answers) VALUES ('$question', '$possible_answers')";

    $conn->exec($sql);
}

function deleteQuestion($id)
{
    global $conn;

    $sql = "DELETE FROM question WHERE id = $id";

    $conn->exec($sql);
}
