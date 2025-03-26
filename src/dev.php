<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dev</title>
</head>

<body>
    <div>
        <h2>Tables</h2>
        <form method="post">
            <input type="submit" name="init" value="Init Database">
        </form>
        <?php
        if (isset($_POST['init'])) {
            initDatabase();
            echo "database tables initialized";
        }
        ?>
    </div>
</body>

</html>