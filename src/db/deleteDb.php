<?php

namespace App\Db;

use App\Db\DbConnection;

require_once('db/dbConnection.php');

function deleteDatabaseTables()
{
    $conn = DbConnection::getInstance()->getConnection();

    $sql = 'DROP TABLE IF EXISTS voted, vote, question, student, user, teacher';

    $conn->exec($sql);
}
