<?php

namespace App\Db;

use PDO;

use App\Db\DbConnection;

require_once('db/dbConnection.php');

function getTeacher($id)
{
    $conn = DbConnection::getInstance()->getConnection();

    $stmt = $conn->prepare('SELECT * FROM teacher WHERE id = :id');
    $stmt->bindParam(':id', $id);

    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC)[0];
}

function getTeacherByName($name)
{
    $conn = DbConnection::getInstance()->getConnection();

    $stmt = $conn->prepare('SELECT * FROM teacher WHERE name = :name');
    $stmt->bindParam(':name', $name);

    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC)[0];
}

function getTeachers()
{
    $conn = DbConnection::getInstance()->getConnection();

    $stmt = $conn->prepare('SELECT * FROM teacher');

    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function insertTeacher($name)
{
    $conn = DbConnection::getInstance()->getConnection();
    $stmt = $conn->prepare('INSERT INTO teacher (name) VALUES (:name)');
    $stmt->bindParam(':name', $name);

    $stmt->execute();
}

function deleteTeacher($id)
{
    $conn = DbConnection::getInstance()->getConnection();

    $stmt = $conn->prepare('DELETE FROM vote WHERE teacher_id = :id');
    $stmt->bindParam(':id', $id);

    $stmt->execute();
}
