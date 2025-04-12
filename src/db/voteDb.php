<?php

namespace App\Db;

use PDO;

use App\Db\DbConnection;

require_once('db/dbConnection.php');

function getVotes($question_id)
{
    $conn = DbConnection::getInstance()->getConnection();

    $stmt = $conn->prepare('SELECT * FROM vote WHERE question_id = :question_id');
    $stmt->bindParam(':question_id', $question_id);

    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function insertVote($question_id, $type, $id, $id2 = null)
{
    $conn = DbConnection::getInstance()->getConnection();

    switch ($type) {
        case 'student':
            $stmt = $conn->prepare('INSERT INTO vote (question_id, student_id) VALUES (:question_id, :student_id)');
            $stmt->bindParam(':question_id', $question_id);
            $stmt->bindParam(':student_id', $id);
            break;
        case 'teacher':
            $stmt = $conn->prepare('INSERT INTO vote (question_id, teacher_id) VALUES (:question_id, :teacher_id)');
            $stmt->bindParam(':question_id', $question_id);
            $stmt->bindParam(':teacher_id', $id);
            break;
        case 'two_students':
            $stmt = $conn->prepare('INSERT INTO vote (question_id, first_student_id, second_student_id) VALUES (:question_id, :first_student_id, :second_student_id)');
            $stmt->bindParam(':question_id', $question_id);
            $stmt->bindParam(':first_student_id', $id);
            $stmt->bindParam(':second_student_id', $id2);
            break;
        default:
            return;
    }

    $stmt->execute();
}
