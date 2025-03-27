<?php

include 'db.php';

function initDatabase()
{
    createQuestionTable();
    createStudentTable();
    createTeacherTable();
    createUserTable();
    createVoteTable();
    createVotedTable();
}

function createQuestionTable()
{
    global $conn;

    $sql = "CREATE TABLE IF NOT EXISTS question (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        question TEXT NOT NULL,
        possible_answers ENUM('students', 'teachers', 'everyone', 'two_students') NOT NULL
    )";

    $conn->exec($sql);
}

function createStudentTable()
{
    global $conn;

    $sql = "CREATE TABLE IF NOT EXISTS student (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255) NOT NULL
    )";

    $conn->exec($sql);
}
function createTeacherTable()
{
    global $conn;

    $sql = "CREATE TABLE IF NOT EXISTS teacher (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255) NOT NULL
    )";

    $conn->exec($sql);
}

function createUserTable()
{
    global $conn;

    $sql = "CREATE TABLE IF NOT EXISTS user (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        email VARCHAR(50) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )";

    $conn->exec($sql);
}

function createVoteTable()
{
    global $conn;

    $sql = "CREATE TABLE IF NOT EXISTS vote (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        student_id INT(6) UNSIGNED,
        teacher_id INT(6) UNSIGNED,
        first_student_id INT(6) UNSIGNED,
        second_student_id INT(6) UNSIGNED,
        question_id INT(6) UNSIGNED NOT NULL,
        FOREIGN KEY (student_id) REFERENCES student(id),
        FOREIGN KEY (question_id) REFERENCES question(id),
        FOREIGN KEY (teacher_id) REFERENCES teacher(id),
        FOREIGN KEY (first_student_id) REFERENCES student(id),
        FOREIGN KEY (second_student_id) REFERENCES student(id)
    )";

    $conn->exec($sql);
}

function createVotedTable()
{
    global $conn;

    $sql = "CREATE TABLE IF NOT EXISTS voted (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        user_id INT(6) UNSIGNED NOT NULL,
        question_id INT(6) UNSIGNED NOT NULL,
        FOREIGN KEY (user_id) REFERENCES user(id),
        FOREIGN KEY (question_id) REFERENCES question(id)
    )";

    $conn->exec($sql);
}
