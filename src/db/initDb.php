<?php

namespace App\Db;

use PDO;

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
        unique_token VARCHAR(50) NOT NULL,
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

function initStudentInformation()
{
    global $conn;

    $sql = "SELECT * FROM student";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $students = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (empty($students)) {
        $students = [
            ['Anton Pietrek'],
            ['Anton Stormanns'],
            ['Benjamin Morbitzer'],
            ['Caspar Beate'],
            ['David Elias Niklasch'],
            ['Emma Keck'],
            ['Fred Braband'],
            ['Jakob Rzeppa'],
            ['Jule Carlotta Requardt'],
            ['Klara Van der Veen'],
            ['Konstantin Rechner'],
            ['Leon Schmitz'],
            ['Levi Waldmann'],
            ['Linus Matti Rekel'],
            ['Matti Campbell-Smith'],
            ['Mia Rose Maaß'],
            ['Nail Can Knipping'],
            ['Paula Flor Stuelpe'],
            ['Quinn Anderson'],
            ['Richard Grießhammer'],
            ['Tobey Taeubner'],
            ['Tom Koehnecke'],
            ['Christopher Thies'],
            ['Lennard Hoeppner'],
            ['Armaan-Aziz Yilmaz'],
            ['Arthur Béla Jankowski'],
            ['Artsiom Hryhoryev'],
            ['Finja-Marie Dobrat'],
            ['Finn Klages'],
            ['Henrike Laukien'],
            ['Marlene Bansemer'],
            ['Nina Traut'],
            ['Paul Roessler'],
            ['Roven Abratis'],
            ['Schadia Della Ventura'],
            ['Semi Zor'],
            ['Veikko Poppinga'],
            ['Alina Redzepi'],
            ['Aurelia-Joelle Holtegel'],
            ['Fatma Guel oengel'],
            ['Frida Aimee Nickel'],
            ['Jenny Kuhn'],
            ['Lara Niagara Vojinovic'],
            ['Laura-Marie Lichtenberg'],
            ['Lia Lotte Lorenz'],
            ['Lian Lueddeke'],
            ['Lisa Joehring'],
            ['Liseli Maiwald'],
            ['Maria Feisthauer'],
            ['Marie Ehrhoff'],
            ['Paul Simon Moebius'],
            ['Sophie Jaeger'],
            ['Till Lennart Kuester'],
            ['Zoe Shadi Hoffmann'],
            ['Jamie Onyenom'],
            ['Roj Ali'],
            ['Noel Bou Khalil'],
            ['Alex Pretzsch'],
            ['Lena Sophy Schoppe'],
            ['Helen Marie Westphal'],
            ['Jule Mathilde Reinhardt'],
            ['Lara-Sophie Maetzing'],
            ['Larissa Borris'],
            ['Rosalie Friedrich'],
            ['Sophie Kodoll'],
            ['Lara Maetzing']
        ];

        $stmt = $conn->prepare("INSERT INTO student (name) VALUES (?)");
        foreach ($students as $student) {
            $stmt->execute($student);
        }

        return true;
    }

    return false;
}

function initTeacherInformation()
{
    global $conn;

    $sql = "SELECT * FROM teacher";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $teachers = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (empty($teachers)) {
        $sql = "INSERT INTO teacher (name) VALUES ('Benjamin Bank'), ('Thomas Baptist'), ('Angelika Bethke'), ('André Blank'), ('Kerstin Boettger'), ('Kaja Brandenburger'), ('Sandra-Christin Draheim'), ('Tilman Eckelt'), ('Heike Exeler'), ('Gerrit Feige'), ('Lorena Feige'), ('Milena Feige'), ('Katharina Fricke-Dietrich'), ('Patrick Galke-Janßen'), ('Alexander Geiger'), ('Linda Giffhorn'), ('Felix Goltermann'), ('Dennis Graef'), ('Denise Graf'), ('Silke Graß'), ('Thorben Grote'), ('Natali Haak'), ('Robert Hain'), ('Dana Hegmann'), ('Sarah Hentschel'), ('Marc Heydecke'), ('Isabell Hildner'), ('Karoline Hill'), ('Konstantin Hilpert'), ('Eva Holste'), ('Stefanie Huhn'), ('Henner Kaatz'), ('Lisa Karstaedt'), ('Lisa Kassautzki'), ('Tina Marita Keinz'), ('Eva Kemper'), ('Gudrun Klasmeyer'), ('Isabell Kling'), ('Bettina Koeppen-Stahl'), ('Tessa Eponine Koethe'), ('Lisanne Kraeva'), ('Edith Laukien'), ('Lisa Lohrmann'), ('Tobias Lutterbeck'), ('Ute Meißner'), ('Kora Neupert'), ('Alexandra Otto-Bethe'), ('Seval Ozdogan'), ('Joerg Pinke'), ('Vivien Poppek'), ('Lena Rolfes'), ('Benjamin Sauerland'), ('Skrollan Fides Schmidt'), ('Frauke Johanna Schubert'), ('Christian Schwarz'), ('Sven Sekula'), ('Jens Siebert'), ('Louisa Singfield'), ('Julia Sittler'), ('Berret Stegemann'), ('Antje Stolpe'), ('Lina-Sophie Szczes'), ('Isabelle Theuerzeit'), ('Heide Toklu'), ('Claudia Weber'), ('Olga Weigum-Merkel'), ('Anna Zoellner'), ('Jan-Bodo Schwehm-Ketelsen'), ('Hans Bock')";

        $conn->exec($sql);

        return true;
    }

    return false;
}
