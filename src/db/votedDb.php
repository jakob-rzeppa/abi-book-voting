<?php

namespace App\Db;

use PDO;

use App\Db\DbConnection;

require_once('src/db/dbConnection.php');

function insertVoted($user_id, $question_id)
{
    $conn = DbConnection::getInstance()->getConnection();

    $sql = "INSERT INTO voted (user_id, question_id) VALUES ($user_id, $question_id)";

    $conn->exec($sql);
}

function getAlreadyVotedQuestions($user_id)
{
    $conn = DbConnection::getInstance()->getConnection();

    $sql = "SELECT question_id FROM voted WHERE user_id = $user_id";

    $stmt = $conn->prepare($sql);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
