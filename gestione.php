<?php
require_once('config.php');

// Gestione dell'inserimento di un nuovo libro
if (isset($_POST['add'])) {
    $titolo = $_POST['titolo'];
    $autore_id = $_POST['autore'];
    $anno_pubblicazione = $_POST['anno_pubblicazione'];
    $genere = $_POST['genere'];
    $prezzo = $_POST['prezzo'];
    $copertina = $_POST['copertina'];

    $stmt = $mysqli->prepare("INSERT INTO libri (titolo, autore_id, anno_pubblicazione, genere, prezzo, copertina) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("siisss", $titolo, $autore_id, $anno_pubblicazione, $genere, $prezzo, $copertina);

    if (!$stmt->execute()) {
        echo 'Errore nell\'inserimento del libro: ' . $stmt->error;
    }
    $stmt->close();
}

// Gestione della modifica di un libro
if (isset($_POST['edit_id'])) {
    $edit_id = $_POST['edit_id'];
    $titolo = $_POST['titolo'];
    $autore_id = $_POST['autore'];
    $anno_pubblicazione = $_POST['anno_pubblicazione'];
    $genere = $_POST['genere'];
    $prezzo = $_POST['prezzo'];
    $copertina = $_POST['copertina'];

    // Aggiorna il libro
    $stmt = $mysqli->prepare("UPDATE libri SET titolo = ?, autore_id = ?, anno_pubblicazione = ?, genere = ?, prezzo = ?, copertina = ? WHERE id = ?");
    $stmt->bind_param("siissss", $titolo, $autore_id, $anno_pubblicazione, $genere, $prezzo, $copertina, $edit_id);

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

// Gestione dell'inserimento di un nuovo autore
if (isset($_POST['add_author'])) {
    $nome = $_POST['nome'];
    $data_di_nascita = $_POST['data_di_nascita'];
    $ritratto = $_POST['ritratto'];

    $stmt = $mysqli->prepare("INSERT INTO autori (nome, data_di_nascita, ritratto) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $nome, $data_di_nascita, $ritratto);

    if (!$stmt->execute()) {
        echo 'Errore nell\'inserimento dell\'autore: ' . $stmt->error;
    }
    $stmt->close();
}

// Gestione della modifica di un autore
if (isset($_POST['edit_author_id'])) {
    $edit_id = $_POST['edit_author_id'];
    $authorName = $_POST['authorName'];
    $birthDate = $_POST['birthDate'];
    $ritratto = $_POST['ritratto'];

    $stmt = $mysqli->prepare("UPDATE `autori` SET `nome` = ?, `data_di_nascita` = ? , `ritratto` = ? WHERE `id` = ?");
    $stmt->bind_param("sssi", $authorName, $birthDate, $ritratto, $edit_id);

    if (!$stmt->execute()) {
        echo 'Errore nella modifica dell\'autore: ' . $stmt->error;
    }
    $stmt->close();
}

// Gestione dell'eliminazione di un autore
if (isset($_GET['delete_author'])) {
    $author_id = $_GET['delete_author'];

    $stmt = $mysqli->prepare("DELETE FROM autori WHERE id = ?");
    $stmt->bind_param("i", $author_id);

    if (!$stmt->execute()) {
        echo 'Errore nell\'eliminazione dell\'autore: ' . $stmt->error;
    }
    $stmt->close();
}

header('Location: backoffice.php');
?>