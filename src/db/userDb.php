<?php

namespace App\Db;

use App\Db\DbConnection;

require_once('db/dbConnection.php');

function getUserByToken($token)
{
    $conn = DbConnection::getInstance()->getConnection();

    $sql = "SELECT * FROM user WHERE unique_token='$token'";

    $stmt = $conn->prepare($sql);
    $stmt->execute();

    return $stmt->fetch();
}

function getTokenByEmail($email)
{
    $conn = DbConnection::getInstance()->getConnection();

    $sql = "SELECT unique_token FROM user WHERE email='$email'";

    $stmt = $conn->prepare($sql);
    $stmt->execute();

    return $stmt->fetchColumn();
}

function insertUser($email)
{
    $conn = DbConnection::getInstance()->getConnection();

    do {
        $token = bin2hex(random_bytes(25));
    } while (getUserByToken($token));

    $sql = "INSERT INTO user (email, unique_token) VALUES ('$email', '$token')";

    $conn->exec($sql);
}
