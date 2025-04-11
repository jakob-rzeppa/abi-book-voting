<?php

namespace App\Db;

function getStudent($id)
{
    global $conn;

    $sql = "SELECT * FROM student WHERE id = $id";

    $stmt = $conn->prepare($sql);
    $stmt->execute();

    return $stmt->fetchAll(\PDO::FETCH_ASSOC)[0];
}

function getStudentByName($name)
{
    global $conn;

    $sql = "SELECT * FROM student WHERE name = '$name'";

    $stmt = $conn->prepare($sql);
    $stmt->execute();

    return $stmt->fetchAll(\PDO::FETCH_ASSOC)[0];
}

function getStudents()
{
    global $conn;

    $sql = "SELECT * FROM student";

    $stmt = $conn->prepare($sql);
    $stmt->execute();

    return $stmt->fetchAll(\PDO::FETCH_ASSOC);
}

function insertStudent($name)
{
    global $conn;

    $sql = "INSERT INTO student (name) VALUES ('$name')";

    $conn->exec($sql);
}

function deleteStudent($id)
{
    global $conn;

    $sql = "DELETE FROM student WHERE id = $id";

    $conn->exec($sql);
}
