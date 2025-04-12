<?php

namespace App\Db;

use PDO;

use App\Db\DbConnection;

require_once('db/dbConnection.php');

function getQuestions()
{
    $conn = DbConnection::getInstance()->getConnection();

    $sql = 'SELECT * FROM question';

    $stmt = $conn->prepare($sql);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function insertQuestion($question, $possible_answers)
{
    $conn = DbConnection::getInstance()->getConnection();

    $stmt = $conn->prepare('INSERT INTO question (question, possible_answers) VALUES (:question, :possible_answers)');
    $stmt->bindParam(':question', $question);
    $stmt->bindParam(':possible_answers', $possible_answers);

    $stmt->execute();
}

function deleteQuestion($id)
{
    $conn = DbConnection::getInstance()->getConnection();

    $stmt = $conn->prepare('DELETE FROM vote WHERE question_id = :id');
    $stmt->bindParam(':id', $id);

    $stmt->execute();
}
