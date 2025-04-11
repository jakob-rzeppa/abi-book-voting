<?php

namespace App\Db;

function getTeacher($id)
{
    global $conn;

    $sql = "SELECT * FROM teacher WHERE id = $id";

    $stmt = $conn->prepare($sql);
    $stmt->execute();

    return $stmt->fetchAll(\PDO::FETCH_ASSOC)[0];
}

function getTeacherByName($name)
{
    global $conn;

    $sql = "SELECT * FROM teacher WHERE name = '$name'";

    $stmt = $conn->prepare($sql);
    $stmt->execute();

    return $stmt->fetchAll(\PDO::FETCH_ASSOC)[0];
}

function getTeachers()
{
    global $conn;

    $sql = "SELECT * FROM teacher";

    $stmt = $conn->prepare($sql);
    $stmt->execute();

    return $stmt->fetchAll(\PDO::FETCH_ASSOC);
}

function insertTeacher($name)
{
    global $conn;

    $sql = "INSERT INTO teacher (name) VALUES ('$name')";

    $conn->exec($sql);
}

function deleteTeacher($id)
{
    global $conn;

    $sql = "DELETE FROM teacher WHERE id = $id";

    $conn->exec($sql);
}
