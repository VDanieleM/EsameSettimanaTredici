<?php
require_once('config.php');

// Gestione dell'inserimento di un nuovo libro
if (isset($_POST['add'])) {
    $titolo = $_POST['titolo'];
    $autore = $_POST['autore'];
    $anno_pubblicazione = $_POST['anno_pubblicazione'];
    $genere = $_POST['genere'];
    $prezzo = $_POST['prezzo'];

    $stmt = $mysqli->prepare("INSERT INTO `libri` (`titolo`, `autore`, `anno_pubblicazione`, `genere`, `prezzo`) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssiss", $titolo, $autore, $anno_pubblicazione, $genere, $prezzo);

    if (!$stmt->execute()) {
        echo 'Errore nell\'inserimento del libro: ' . $stmt->error;
    }
    $stmt->close();
}

// Gestione della modifica di un libro
if (isset($_POST['edit_id'])) {
    $edit_id = $_POST['edit_id'];
    $titolo = $_POST['titolo'];
    $autore = $_POST['autore'];
    $anno_pubblicazione = $_POST['anno_pubblicazione'];
    $genere = $_POST['genere'];
    $prezzo = $_POST['prezzo'];

    $stmt = $mysqli->prepare("UPDATE `libri` SET `titolo` = ?, `autore` = ?, `anno_pubblicazione` = ?, `genere` = ?, `prezzo` = ? WHERE `id` = ?");
    $stmt->bind_param("ssissi", $titolo, $autore, $anno_pubblicazione, $genere, $prezzo, $edit_id);

    if (!$stmt->execute()) {
        echo 'Errore nella modifica del libro: ' . $stmt->error;
    }
    $stmt->close();
}

// Gestione della cancellazione di un libro
if (isset($_POST['delete_id'])) {
    $delete_id = $_POST['delete_id'];

    $stmt = $mysqli->prepare("DELETE FROM `libri` WHERE `id` = ?");
    $stmt->bind_param("i", $delete_id);

    if (!$stmt->execute()) {
        echo 'Errore nella cancellazione del libro: ' . $stmt->error;
    }
    $stmt->close();
}

// Reindirizza l'utente a index.php
header('Location: index.php');
?>