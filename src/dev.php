<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dev</title>
</head>

<body>
    <div>
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
    </div>
</body>

</html>