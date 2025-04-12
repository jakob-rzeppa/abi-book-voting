<?php

namespace App\Db;

use PDO;

use App\Db\DbConnection;

require_once('src/db/dbConnection.php');

function insertVoted($user_id, $question_id)
{
    $conn = DbConnection::getInstance()->getConnection();

    $stmt = $conn->prepare('INSERT INTO voted (user_id, question_id) VALUES (:user_id, :question_id)');
    $stmt->bindParam(':user_id', $user_id);
    $stmt->bindParam(':question_id', $question_id);

    $stmt->execute();
}

function getAlreadyVotedQuestions($user_id)
{
    $conn = DbConnection::getInstance()->getConnection();

    $stmt = $conn->prepare('SELECT question_id FROM voted WHERE user_id = :user_id');
    $stmt->bindParam(':user_id', $user_id);

    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
