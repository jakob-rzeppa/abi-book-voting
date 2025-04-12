<?php

namespace App\Db;

use PDO;

use App\Db\DbConnection;

require_once('db/dbConnection.php');

function getStudent($id)
{
    $conn = DbConnection::getInstance()->getConnection();

    $stmt = $conn->prepare('SELECT * FROM student WHERE id = :id');
    $stmt->bindParam(':id', $id);

    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC)[0];
}

function getStudentByName($name)
{
    $conn = DbConnection::getInstance()->getConnection();

    $stmt = $conn->prepare('SELECT * FROM student WHERE name = :name');
    $stmt->bindParam(':name', $name);

    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC)[0];
}

function getStudents()
{
    $conn = DbConnection::getInstance()->getConnection();

    $stmt = $conn->prepare('SELECT * FROM student');

    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function insertStudent($name)
{
    $conn = DbConnection::getInstance()->getConnection();

    $stmt = $conn->prepare('INSERT INTO student (name) VALUES (:name)');
    $stmt->bindParam(':name', $name);

    $stmt->execute();
}

function deleteStudent($id)
{
    $conn = DbConnection::getInstance()->getConnection();

    $stmt = $conn->prepare('DELETE FROM vote WHERE student_id = :id');
    $stmt->bindParam(':id', $id);

    $stmt->execute();
}
