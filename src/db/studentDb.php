<?php

include 'db.php';

function createStudentTable()
{
    global $conn;

    $sql = "CREATE TABLE IF NOT EXISTS student (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255) NOT NULL
    )";

    $conn->exec($sql);
}

function getStudents()
{
    global $conn;

    $sql = "SELECT * FROM student";

    $stmt = $conn->prepare($sql);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
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
