<?php

$config = [
    "host" => "localhost",
    "user" => "root",
    "password" => "",
];

$mysqli = new mysqli($config["host"], $config["user"], $config["password"]);

if ($mysqli->connect_errno) {
    die("Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error);
}

$sql = "CREATE DATABASE IF NOT EXISTS gestione_liberia";
$mysqli->query($sql);

$mysqli->select_db("gestione_liberia");

$sql = "CREATE TABLE IF NOT EXISTS `libri` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `titolo` VARCHAR(255) NOT NULL,
    `autore` VARCHAR(255) NOT NULL,
    `anno_pubblicazione` INT NOT NULL,
    `genere` VARCHAR(255) NOT NULL,
    `prezzo` DECIMAL(10, 2) NOT NULL,

    PRIMARY KEY (`id`))";
$mysqli->query($sql);

/* $libri = [
    ['titolo' => 'HTML & CSS: Design and Build Websites', 'autore' => 'Jon Duckett', 'anno_pubblicazione' => 2011, 'genere' => 'Web Development', 'prezzo' => 19.99],
    ['titolo' => 'JavaScript: The Good Parts', 'autore' => 'Douglas Crockford', 'anno_pubblicazione' => 2008, 'genere' => 'Dev', 'prezzo' => 25.99],
    ['titolo' => 'Eloquent JavaScript', 'autore' => 'Marijn Haverbeke', 'anno_pubblicazione' => 2018, 'genere' => 'Web', 'prezzo' => 31.99],
    ['titolo' => 'Learning Web Design', 'autore' => 'Jennifer Robbins', 'anno_pubblicazione' => 2018, 'genere' => 'Development', 'prezzo' => 39.99],
    ['titolo' => 'CSS: The Definitive Guide', 'autore' => 'Eric Meyer & Estelle Weyl', 'anno_pubblicazione' => 2017, 'genere' => 'Dev', 'prezzo' => 43.99],
    ['titolo' => 'You Dont Know JS', 'autore' => 'Kyle Simpson', 'anno_pubblicazione' => 2015, 'genere' => 'Web Development', 'prezzo' => 28.99],
    ['titolo' => 'Responsive Web Design with HTML5 and CSS', 'autore' => 'Ben Frain', 'anno_pubblicazione' => 2020, 'genere' => 'Web', 'prezzo' => 35.99],
    ['titolo' => 'Web Design with HTML, CSS, JavaScript and jQuery Set', 'autore' => 'Jon Duckett', 'anno_pubblicazione' => 2014, 'genere' => 'Web Dev', 'prezzo' => 41.99],
    ['titolo' => 'Learning PHP, MySQL & JavaScript', 'autore' => 'Robin Nixon', 'anno_pubblicazione' => 2018, 'genere' => 'Development', 'prezzo' => 49.99],
    ['titolo' => 'Front-End Web Development: The Big Nerd Ranch Guide', 'autore' => 'Chris Aquino & Todd Gandee', 'anno_pubblicazione' => 2016, 'genere' => 'Web', 'prezzo' => 29.99]
];

foreach ($libri as $libro) {
    $stmt = $mysqli->prepare("SELECT COUNT(*) AS count FROM `libri` WHERE `titolo` = ? AND `autore` = ?");
    $stmt->bind_param("ss", $libro['titolo'], $libro['autore']);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if ($row['count'] == 0) {
        $stmt = $mysqli->prepare("INSERT INTO `libri` (`titolo`, `autore`, `anno_pubblicazione`, `genere`, `prezzo`) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("ssiss", $libro['titolo'], $libro['autore'], $libro['anno_pubblicazione'], $libro['genere'], $libro['prezzo']);
        $stmt->execute();
    }
    $stmt->close();
} */

?>