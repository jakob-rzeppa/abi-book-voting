<!DOCTYPE html>
<html lang="en">

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
                include 'db/initDb.php';
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
                include 'db/deleteDb.php';
                deleteDatabaseTables();
                echo "database tables deleted";
            }
            ?>
            <h2>Init Teachers</h2>
            <form method="post">
                <input type="submit" name="init_teachers" value="Init Teachers">
            </form>
            <?php
            if (isset($_POST['init_teachers'])) {
                include 'db/initDb.php';
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