<?php

namespace App\Db;

use PDO;

use App\Db\DbConnection;

require_once('db/dbConnection.php');

function getQuestions()
{
    $conn = DbConnection::getInstance()->getConnection();

    $sql = "SELECT * FROM question";

    $stmt = $conn->prepare($sql);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function insertQuestion($question, $possible_answers)
{
    $conn = DbConnection::getInstance()->getConnection();

    $sql = "INSERT INTO question (question, possible_answers) VALUES ('$question', '$possible_answers')";

    $conn->exec($sql);
}

function deleteQuestion($id)
{
    $conn = DbConnection::getInstance()->getConnection();

    $sql = "DELETE FROM question WHERE id = $id";

    $conn->exec($sql);
}
