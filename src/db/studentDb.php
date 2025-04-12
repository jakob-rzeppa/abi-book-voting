<?php

namespace App\Db;

use PDO;

use App\Db\DbConnection;

require_once('db/dbConnection.php');

function getStudent($id)
{
    $conn = DbConnection::getInstance()->getConnection();

    $sql = "SELECT * FROM student WHERE id = $id";

    $stmt = $conn->prepare($sql);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC)[0];
}

function getStudentByName($name)
{
    $conn = DbConnection::getInstance()->getConnection();

    $sql = "SELECT * FROM student WHERE name = '$name'";

    $stmt = $conn->prepare($sql);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC)[0];
}

function getStudents()
{
    $conn = DbConnection::getInstance()->getConnection();

    $sql = "SELECT * FROM student";

    $stmt = $conn->prepare($sql);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function insertStudent($name)
{
    $conn = DbConnection::getInstance()->getConnection();

    $sql = "INSERT INTO student (name) VALUES ('$name')";

    $conn->exec($sql);
}

function deleteStudent($id)
{
    $conn = DbConnection::getInstance()->getConnection();

    $sql = "DELETE FROM student WHERE id = $id";

    $conn->exec($sql);
}
