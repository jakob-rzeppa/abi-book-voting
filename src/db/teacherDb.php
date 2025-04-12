<?php

namespace App\Db;

use PDO;

use App\Db\DbConnection;

require_once('db/dbConnection.php');

function getTeacher($id)
{
    $conn = DbConnection::getInstance()->getConnection();

    $sql = "SELECT * FROM teacher WHERE id = $id";

    $stmt = $conn->prepare($sql);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC)[0];
}

function getTeacherByName($name)
{
    $conn = DbConnection::getInstance()->getConnection();

    $sql = "SELECT * FROM teacher WHERE name = '$name'";

    $stmt = $conn->prepare($sql);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC)[0];
}

function getTeachers()
{
    $conn = DbConnection::getInstance()->getConnection();

    $sql = "SELECT * FROM teacher";

    $stmt = $conn->prepare($sql);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function insertTeacher($name)
{
    $conn = DbConnection::getInstance()->getConnection();

    $sql = "INSERT INTO teacher (name) VALUES ('$name')";

    $conn->exec($sql);
}

function deleteTeacher($id)
{
    $conn = DbConnection::getInstance()->getConnection();

    $sql = "DELETE FROM teacher WHERE id = $id";

    $conn->exec($sql);
}
