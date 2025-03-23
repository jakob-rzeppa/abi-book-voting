<?php
$servername = "db";
$username = "user";
$password = "kejaffkjekjsas";
$dbname = "db";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected successfully";
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

function createUserTable()
{
    global $conn;

    $sql = "CREATE TABLE IF NOT EXISTS users (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        email VARCHAR(50) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        voted BOOLEAN DEFAULT FALSE,
        voted_at TIMESTAMP DEFAULT NULL
    )";

    $conn->exec($sql);
}

function getUserByHashedId($hashedId)
{
    global $conn;

    $sql = "SELECT * FROM users WHERE MD5(id)='$hashedId'";

    $stmt = $conn->prepare($sql);
    $stmt->execute();

    return $stmt->fetch();
}

function getHashedIdByEmail($email)
{
    global $conn;

    $sql = "SELECT MD5(id) FROM users WHERE email='$email'";

    $stmt = $conn->prepare($sql);
    $stmt->execute();

    return $stmt->fetchColumn();
}

function insertUser($email)
{
    global $conn;

    $sql = "INSERT INTO users (email) VALUES ('$email')";

    $conn->exec($sql);
}
