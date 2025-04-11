<?php

namespace App;

use function App\Db\{
    deleteDatabaseTables,
    initDatabase,
    initStudentInformation,
    initTeacherInformation
};

include('./db/connection.php');
require_once('./db/initDb.php');
require_once('./db/deleteDb.php');
require_once('./db/studentDb.php');
require_once('./db/teacherDb.php');

?>

<!DOCTYPE html>
<html lang="de">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dev</title>
</head>

<body>
    <div>
        <?php if ($_COOKIE['admin_password'] === $_ENV['ADMIN_PASSWORD']) { ?>
            <h2>Init</h2>
            <form method="post">
                <input type="submit" name="init" value="Init Database">
            </form>
            <?php
            if (isset($_POST['init'])) {
                initDatabase();
                echo "database tables initialized";
            }
            ?>
            <h2>Delete</h2>
            <form method="post">
                <input type="submit" name="delete" value="Delete Database">
            </form>
            <?php
            if (isset($_POST['delete'])) {
                deleteDatabaseTables();
                echo "database tables deleted";
            }
            ?>
            <h2>Init Students</h2>
            <form method="post">
                <input type="submit" name="init_students" value="Init Students">
            </form>
            <?php
            if (isset($_POST['init_students'])) {
                if (initStudentInformation()) {
                    echo "students initialized";
                } else {
                    echo "students already initialized";
                }
            } ?>
            <h2>Init Teachers</h2>
            <form method="post">
                <input type="submit" name="init_teachers" value="Init Teachers">
            </form>
            <?php
            if (isset($_POST['init_teachers'])) {
                if (initTeacherInformation()) {
                    echo "teachers initialized";
                } else {
                    echo "teachers already initialized";
                }
            } ?>
        <?php } ?>
    </div>
</body>

</html>