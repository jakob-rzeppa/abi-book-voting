<?php

namespace App\Db;

use App\Db\DbConnection;

require_once('db/dbConnection.php');

function getUserByToken($token)
{
    $conn = DbConnection::getInstance()->getConnection();

    $stmt = $conn->prepare('SELECT * FROM user WHERE unique_token = :token');
    $stmt->bindParam(':token', $token);

    $stmt->execute();

    return $stmt->fetch();
}

function getTokenByEmail($email)
{
    $conn = DbConnection::getInstance()->getConnection();

    $stmt = $conn->prepare('SELECT unique_token FROM user WHERE email = :email');
    $stmt->bindParam(':email', $email);

    $stmt->execute();

    return $stmt->fetchColumn();
}

function insertUser($email)
{
    $conn = DbConnection::getInstance()->getConnection();

    do {
        $token = bin2hex(random_bytes(25));
    } while (getUserByToken($token));

    $stmt = $conn->prepare('INSERT INTO user (email, unique_token) VALUES (:email, :unique_token)');
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':unique_token', $token);

    $stmt->execute();
}
