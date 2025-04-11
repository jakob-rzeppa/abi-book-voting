<?php

namespace App\Db;

function getUserByHashedId($hashedId)
{
    global $conn;

    $sql = "SELECT * FROM user WHERE MD5(id)='$hashedId'";

    $stmt = $conn->prepare($sql);
    $stmt->execute();

    return $stmt->fetch();
}

function getHashedIdByEmail($email)
{
    global $conn;

    $sql = "SELECT MD5(id) FROM user WHERE email='$email'";

    $stmt = $conn->prepare($sql);
    $stmt->execute();

    return $stmt->fetchColumn();
}

function insertUser($email)
{
    global $conn;

    $sql = "INSERT INTO user (email) VALUES ('$email')";

    $conn->exec($sql);
}
