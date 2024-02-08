<?php
require_once('config.php');

// Gestione dell'inserimento di un nuovo libro
if (isset($_POST['add'])) {
    $titolo = $_POST['titolo'];
    $autore = $_POST['autore'];
    $anno_pubblicazione = $_POST['anno_pubblicazione'];
    $genere = $_POST['genere'];
    $prezzo = $_POST['prezzo'];
    $copertina = $_POST['copertina'];

    // Cerca l'ID dell'autore dato il nome
    $stmt = $mysqli->prepare("SELECT id FROM autori WHERE nome = ?");
    $stmt->bind_param("s", $autore);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $stmt->close();

    // Se l'autore non esiste, creane uno nuovo
    if (!$row) {
        $stmt = $mysqli->prepare("INSERT INTO autori (nome) VALUES (?)");
        $stmt->bind_param("s", $autore);
        $stmt->execute();
        $autore_id = $stmt->insert_id;
        $stmt->close();
    } else {
        $autore_id = $row['id'];
    }

    // Inserisci il nuovo libro
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
    $autore = $_POST['autore'];
    $anno_pubblicazione = $_POST['anno_pubblicazione'];
    $genere = $_POST['genere'];
    $prezzo = $_POST['prezzo'];
    $copertina = $_POST['copertina'];

    // Cerca l'ID dell'autore dato il nome
    $stmt = $mysqli->prepare("SELECT id FROM autori WHERE nome = ?");
    $stmt->bind_param("s", $autore);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $stmt->close();

    // Se l'autore non esiste, creane uno nuovo
    if (!$row) {
        $stmt = $mysqli->prepare("INSERT INTO autori (nome) VALUES (?)");
        $stmt->bind_param("s", $autore);
        $stmt->execute();
        $autore_id = $stmt->insert_id;
        $stmt->close();
    } else {
        $autore_id = $row['id'];
    }

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

// Gestione della modifica di un autore
if (isset($_POST['edit_author_id'])) {
    $edit_id = $_POST['edit_author_id'];
    $authorName = $_POST['authorName'];
    $birthDate = $_POST['birthDate'];

    $stmt = $mysqli->prepare("UPDATE `autori` SET `nome` = ?, `data_di_nascita` = ? WHERE `id` = ?");
    $stmt->bind_param("ssi", $authorName, $birthDate, $edit_id);

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

// Reindirizza l'utente a index.php
header('Location: backoffice.php');
?>