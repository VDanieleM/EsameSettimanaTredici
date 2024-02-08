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

// Creazione della tabella users
$sql = "CREATE TABLE IF NOT EXISTS `users` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `username` VARCHAR(50) UNIQUE NOT NULL,
    `password` VARCHAR(255) NOT NULL,
    `email` VARCHAR(255) UNIQUE NOT NULL,

    PRIMARY KEY (`id`))";
$mysqli->query($sql);

// Creazione della tabella autori
$sql = "CREATE TABLE IF NOT EXISTS `autori` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `nome` VARCHAR(255) NOT NULL,
    `data_di_nascita` DATE NOT NULL,

    PRIMARY KEY (`id`))";
$mysqli->query($sql);

// Creazione della tabella libri
$sql = "CREATE TABLE IF NOT EXISTS `libri` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `titolo` VARCHAR(255) NOT NULL,
    `autore_id` INT NOT NULL,
    `anno_pubblicazione` INT NOT NULL,
    `genere` VARCHAR(255) NOT NULL,
    `prezzo` DECIMAL(10, 2) NOT NULL,
    `copertina` VARCHAR(255),

    PRIMARY KEY (`id`),
    FOREIGN KEY (`autore_id`) REFERENCES `autori`(`id`) ON DELETE CASCADE)";
$mysqli->query($sql);

?>