<?php

namespace App\Util;

use Exception;

use function App\Db\{
    getStudentByName,
    getTeacherByName,
    insertVote,
    insertVoted
};

require_once('./db/userDb.php');
require_once('./db/questionDb.php');
require_once('./db/studentDb.php');
require_once('./db/teacherDb.php');
require_once('./db/votedDb.php');
require_once('./db/voteDb.php');

use function App\Util\sanitize;

require_once('./util/sanitize.php');

function handleStudentVote($user, $question, $studentName)
{
    try {
        $studentName = sanitize($studentName, 'string');
    } catch (Exception $e) {
        echo $e->getMessage();
        exit;
    }

    $student = getStudentByName($studentName);
    if (!$student) {
        echo "<script>alert('Der Schülername ist nicht korrekt.');</script>";
        echo "<meta http-equiv='refresh' content='0'>";
        exit();
    }

    insertVote($question['id'], 'student', $student['id']);
    insertVoted($user['id'], $question['id']);
}

function handleTeacherVote($user, $question, $teacherName)
{
    try {
        $teacherName = sanitize($teacherName, 'string');
    } catch (Exception $e) {
        echo $e->getMessage();
        exit;
    }

    $teacher = getTeacherByName($teacherName);
    if (!$teacher) {
        echo "<script>alert('Der Lehrername ist nicht korrekt.');</script>";
        echo "<meta http-equiv='refresh' content='0'>";
        exit();
    }

    insertVote($question['id'], 'teacher', $teacher['id']);
    insertVoted($user['id'], $question['id']);
}

function handleStudentAndTeacherVote($user, $question, $answer)
{
    try {
        $answer = sanitize($answer, 'string');
    } catch (Exception $e) {
        echo $e->getMessage();
        exit;
    }

    $student = getStudentByName($answer);
    if ($student) {
        insertVote($question['id'], 'student', $student['id']);
    } else {
        $teacher = getTeacherByName($answer);
        if ($teacher) {
            insertVote($question['id'], 'teacher', $teacher['id']);
        } else {
            echo "<script>alert('Der Name ist nicht korrekt.');</script>";
            echo "<meta http-equiv='refresh' content='0'>";
            exit();
        }
    }

    insertVoted($user['id'], $question['id']);
}

function handleTwoStudentsVote($user, $question)
{
    $studentOneName = $_POST['student_one'];
    $studentTwoName = $_POST['student_two'];

    try {
        $studentOneName = sanitize($studentOneName, 'string');
        $studentTwoName = sanitize($studentTwoName, 'string');
    } catch (Exception $e) {
        echo $e->getMessage();
        exit;
    }

    $studentOne = getStudentByName($studentOneName);
    $studentTwo = getStudentByName($studentTwoName);

    if (!$studentOne || !$studentTwo) {
        echo "<script>alert('Einer der Schülernamen ist nicht korrekt.');</script>";
        echo "<meta http-equiv='refresh' content='0'>";
        exit();
    }
    if ($studentOne['id'] == $studentTwo['id']) {
        echo "<script>alert('Die Schülernamen sind identisch.');</script>";
        echo "<meta http-equiv='refresh' content='0'>";
        exit();
    }

    insertVote($question['id'], 'two_students', $studentOne['id'], $studentTwo['id']);
    insertVoted($user['id'], $question['id']);
}
