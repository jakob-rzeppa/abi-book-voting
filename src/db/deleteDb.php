<?php

include 'db.php';

function deleteDatabaseTables()
{
    global $conn;

    $sql = "DROP TABLE IF EXISTS voted, vote, question, student, user, teacher";

    $conn->exec($sql);
}
