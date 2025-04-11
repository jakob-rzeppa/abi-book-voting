<?php

namespace App\Db;

function getUserByToken($token)
{
    global $conn;

    $sql = "SELECT * FROM user WHERE unique_token='$token'";

    $stmt = $conn->prepare($sql);
    $stmt->execute();

    return $stmt->fetch();
}

function getTokenByEmail($email)
{
    global $conn;

    $sql = "SELECT unique_token FROM user WHERE email='$email'";

    $stmt = $conn->prepare($sql);
    $stmt->execute();

    return $stmt->fetchColumn();
}

function insertUser($email)
{
    global $conn;

    do {
        $token = bin2hex(random_bytes(25));
    } while (getUserByToken($token));

    $sql = "INSERT INTO user (email, unique_token) VALUES ('$email', '$token')";

    $conn->exec($sql);
}
