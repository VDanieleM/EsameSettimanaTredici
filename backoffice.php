<?php
session_start();

// Controllo se l'utente è loggato
if (!isset($_SESSION['username'])) {
    ?>
    <!DOCTYPE html>
    <html>

    <head>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
        <style>
            #overlay {
                display: flex;
                position: fixed;
                width: 100%;
                height: 100%;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background-color: rgba(0, 0, 0, 0.9);
                z-index: 2;
                cursor: pointer;
                align-items: center;
                justify-content: center;
                flex-direction: column;
                color: white;
                font-size: 2em;
            }
        </style>
    </head>

    <body>
        <div id="overlay" class="d-flex">
            <div>Logga per accedere alla pagina, sarai reindirizzato tra 3 secondi</div>
        </div>

        <script>
            setTimeout(function () {
                window.location.href = 'index.php';
            }, 3000);
        </script>
    </body>

    </html>
    <?php
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>La mia bellissima libreria</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
</head>

<body class="bg-dark text-white">
    <?php include('navbar.php'); ?>
    <div class="container d-flex align-items-center justify-content-center mt-5">

        <!-- Button Aggiunta Autore -->
        <button type="button" class="btn btn-light me-3" data-bs-toggle="modal" data-bs-target="#addAuthorModal"
            style="max-height: 100px">
            Aggiungi autore
        </button>

        <!-- Modale Aggiungi Autore -->
        <div class="modal fade" id="addAuthorModal" tabindex="-1" aria-labelledby="addAuthorModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content bg-dark text-white">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addAuthorModalLabel">Aggiungi un nuovo autore</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="addAuthorForm" method="post" action="gestione.php">
                            <input type="hidden" name="add_author" value="1">
                            <div class="mb-3">
                                <label for="nome" class="form-label">Nome</label>
                                <input type="text" class="form-control" id="nome" name="nome" required>
                            </div>
                            <div class="mb-3">
                                <label for="data_di_nascita" class="form-label">Data di nascita</label>
                                <input type="date" class="form-control" id="data_di_nascita" name="data_di_nascita"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label for="ritratto" class="form-label">Ritratto</label>
                                <input type="text" class="form-control" id="ritratto" name="ritratto" required>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Chiudi</button>
                        <button type="submit" form="addAuthorForm" class="btn btn-light">Salva</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Button Mostra Autori -->
        <button type="button" class="btn btn-light me-3" data-bs-toggle="modal" data-bs-target="#authorsModal"
            style="max-height: 100px">
            Mostra autori
        </button>

        <!-- Modale Mostra Autori -->
        <div class="modal fade" id="authorsModal" tabindex="-1" aria-labelledby="authorsModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content bg-dark text-white">
                    <div class="modal-header text-center align-middle">
                        <h5 class="modal-title" id="authorsModalLabel">Mostra autori</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <table class="table table-dark table-striped text-center">
                            <thead>
                                <tr class="align-middle">
                                    <th>ID</th>
                                    <th>Ritratto</th>
                                    <th>Nome</th>
                                    <th>Nascita</th>
                                    <th>Pubblicazioni</th>
                                    <th>Azione</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                require_once('config.php');
                                $result = $mysqli->query("SELECT autori.id, autori.nome, autori.data_di_nascita, autori.ritratto, COUNT(libri.id) AS num_libri FROM autori LEFT JOIN libri ON autori.id = libri.autore_id GROUP BY autori.id, autori.nome, autori.data_di_nascita, autori.ritratto");
                                while ($row = $result->fetch_assoc()) {
                                    echo "<tr class='align-middle'>";
                                    echo "<td>" . $row['id'] . "</td>";
                                    echo "<td><img src='" . $row['ritratto'] . "' alt='Ritratto' width='80' height='80' class='rounded-2'></td>";
                                    echo "<td>" . $row['nome'] . "</td>";
                                    echo "<td>" . $row['data_di_nascita'] . "</td>";
                                    echo "<td>" . $row['num_libri'] . "</td>";
                                    echo "<td><a href='gestione.php?delete_author=" . $row['id'] . "' class='btn btn-danger'><i class='bi bi-trash'></i></a></td>";
                                    echo "</tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer text-center align-middle">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Chiudi</button>
                    </div>
                </div>
            </div>
        </div>


        <!-- Button Aggiunta Libro -->
        <button type="button" class="btn btn-light me-3" data-bs-toggle="modal" data-bs-target="#addBookModal"
            style="max-height: 100px">
            Aggiungi libro
        </button>

        <!-- Modale Aggiunta Libro -->
        <div class="modal fade" id="addBookModal" tabindex="-1" aria-labelledby="addBookModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content bg-dark text-white">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addBookModalLabel">Aggiungi un nuovo libro</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="addBookForm" method="post" action="gestione.php">
                            <input type="hidden" name="add" value="1">
                            <div class="mb-3">
                                <label for="titolo" class="form-label">Titolo</label>
                                <input type="text" class="form-control" id="titolo" name="titolo" required>
                            </div>
                            <?php
                            $sql = "SELECT id, nome FROM autori";
                            $result = $mysqli->query($sql);
                            ?>

                            <div class="mb-3">
                                <label for="autore" class="form-label">Autore</label>
                                <select class="form-control" id="autore" name="autore" required>
                                    <?php
                                    while ($row = $result->fetch_assoc()) {
                                        echo '<option value="' . $row['id'] . '">' . $row['nome'] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="anno_pubblicazione" class="form-label">Anno Pubblicazione</label>
                                <input type="number" class="form-control" id="anno_pubblicazione"
                                    name="anno_pubblicazione" required>
                            </div>
                            <div class="mb-3">
                                <label for="genere" class="form-label">Genere</label>
                                <input type="text" class="form-control" id="genere" name="genere" required>
                            </div>
                            <div class="mb-3">
                                <label for="prezzo" class="form-label">Prezzo</label>
                                <input type="number" step="0.01" class="form-control" id="prezzo" name="prezzo"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label for="copertina" class="form-label">URL Copertina</label>
                                <input type="text" class="form-control" id="copertina" name="copertina" required>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Chiudi</button>
                        <button type="submit" form="addBookForm" class="btn btn-light">Salva</button>
                    </div>
                </div>
            </div>
        </div>

        <table class="table table-dark table-striped mt-3 text-center" style="border: 1px solid gray;">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Copertina</th>
                    <th scope="col">Titolo</th>
                    <th scope="col">Autore</th>
                    <th scope="col">Pubblicazione</th>
                    <th scope="col">Genere</th>
                    <th scope="col">Prezzo</th>
                    <th scope="col">Azioni</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT libri.id, libri.titolo, autori.nome as autore, libri.anno_pubblicazione, libri.genere, libri.prezzo, libri.copertina FROM `libri` JOIN `autori` ON libri.autore_id = autori.id";
                if ($result = $mysqli->query($sql)) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td class='align-middle'>" . $row['id'] . "</td>";
                        echo "<td class='align-middle'><div style='background-image: url(\"" . $row['copertina'] . "\"); width: 100px; height: 150px; background-size: cover; background-position: center;' class='rounded-2'></div></td>";
                        echo "<td class='align-middle'>" . $row['titolo'] . "</td>";

                        // Modale per visualizzare i dettagli dell'autore
                        if (isset($row['autore'])) {
                            $sql_autore = "SELECT * FROM `autori` WHERE `nome` = '" . $mysqli->real_escape_string($row['autore']) . "'";
                            if ($result_autore = $mysqli->query($sql_autore)) {
                                $row_autore = $result_autore->fetch_assoc();
                                echo "<td class='align-middle'><div class='d-flex align-items-center justify-content-center'><button class='btn btn-light me-2' data-bs-toggle='modal' data-bs-target='#authorModal" . $row_autore['id'] . "'>" . $row['autore'] . "</button>";
                                echo "<button class='btn btn-warning' data-bs-toggle='modal' data-bs-target='#editAuthorModal" . $row_autore['id'] . "'><i class='bi bi-pencil-fill'></i></button></div></td>";
                                echo "<div class='modal fade' id='authorModal" . $row_autore['id'] . "' tabindex='-1' aria-labelledby='authorModalLabel" . $row_autore['id'] . "' aria-hidden='true'>";
                                echo "<div class='modal-dialog'>";
                                echo "<div class='modal-content bg-dark text-white'>";
                                echo "<div class='modal-header'>";
                                echo "<h5 class='modal-title text-center' id='authorModalLabel" . $row_autore['id'] . "'>Dettagli Autore</h5>";
                                echo "<button type='button' class='btn-close btn-close-white' data-bs-dismiss='modal' aria-label='Close'></button>";
                                echo "</div>";
                                echo "<div class='modal-body text-center'>";
                                echo "<p><img src='" . $row_autore['ritratto'] . "' alt='Ritratto' width='100' height='100' class='rounded-2'></p>";
                                echo "<p><span class='fw-bold'>Nome:</span> " . $row_autore['nome'] . "</p>";
                                echo "<p><span class='fw-bold'>Data di nascita:</span> " . $row_autore['data_di_nascita'] . "</p>";
                                $sql_libri = "SELECT titolo FROM `libri` WHERE `autore_id` = " . $row_autore['id'];
                                if ($result_libri = $mysqli->query($sql_libri)) {
                                    echo "<p class='fw-bold'>Libri:</p>";
                                    echo "<ul style='list-style-type: none; padding-left: 0;'>";
                                    while ($row_libro = $result_libri->fetch_assoc()) {
                                        echo "<li>" . $row_libro['titolo'] . "</li>";
                                    }
                                    echo "</ul>";
                                }
                                echo "</div>";
                                echo "<div class='modal-footer justify-content-center'>";
                                echo "<button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Chiudi</button>";
                                echo "</div>";
                                echo "</div>";
                                echo "</div>";
                                echo "</div>";
                            }
                        }

                        // Modale per modificare i dettagli dell'autore
                        if (isset($row['autore'])) {
                            $sql_autore = "SELECT * FROM `autori` WHERE `nome` = '" . $mysqli->real_escape_string($row['autore']) . "'";
                            if ($result_autore = $mysqli->query($sql_autore)) {
                                $row_autore = $result_autore->fetch_assoc();
                                echo "<div class='modal fade' id='editAuthorModal" . $row_autore['id'] . "' tabindex='-1' aria-labelledby='editAuthorModalLabel" . $row_autore['id'] . "' aria-hidden='true'>";
                                echo "<div class='modal-dialog'>";
                                echo "<div class='modal-content bg-dark text-white'>";
                                echo "<div class='modal-header'>";
                                echo "<h5 class='modal-title' id='editAuthorModalLabel" . $row_autore['id'] . "'>Modifica Autore</h5>";
                                echo "<button type='button' class='btn-close btn-close-white' data-bs-dismiss='modal' aria-label='Close'></button>";
                                echo "</div>";
                                echo "<div class='modal-body'>";
                                echo "<form id='editAuthorForm" . $row_autore['id'] . "' method='post' action='gestione.php'>";
                                echo "<input type='hidden' name='edit_author_id' value='" . $row_autore['id'] . "'>";
                                echo "<div class='mb-3'>";
                                echo "<label for='authorName' class='form-label'>Nome</label>";
                                echo "<input type='text' class='form-control' id='authorName' name='authorName' value='" . $row_autore['nome'] . "' required>";
                                echo "</div>";
                                echo "<div class='mb-3'>";
                                echo "<label for='birthDate' class='form-label'>Data di nascita</label>";
                                echo "<input type='date' class='form-control' id='birthDate' name='birthDate' value='" . $row_autore['data_di_nascita'] . "' required>";
                                echo "</div>";
                                echo "<div class='mb-3'>";
                                echo "<label for='ritratto' class='form-label'>Ritratto</label>";
                                if (isset($row_autore['ritratto'])) {
                                    echo "<input type='text' class='form-control' id='ritratto' name='ritratto' value='" . $row_autore['ritratto'] . "' required>";
                                } else {
                                    echo "<input type='text' class='form-control' id='ritratto' name='ritratto' required>";
                                }
                                echo "</div>";
                                echo "<div class='modal-footer'>";
                                echo "<button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Chiudi</button>";
                                echo "<button type='submit' form='editAuthorForm" . $row_autore['id'] . "' class='btn btn-light'>Salva</button>";
                                echo "</div>";
                                echo "</form>";
                                echo "</div>";
                                echo "</div>";
                                echo "</div>";
                                echo "</div>";
                            }
                        }

                        echo "<td class='align-middle'>" . $row['anno_pubblicazione'] . "</td>";
                        echo "<td class='align-middle'>" . $row['genere'] . "</td>";
                        echo "<td class='align-middle'>" . $row['prezzo'] . "</td>";
                        echo "<td class='align-middle'>";
                        echo "<form method='post' action='gestione.php' style='display: inline;'>";
                        echo "<input type='hidden' name='delete_id' value='" . $row['id'] . "'>";
                        echo "<button type='submit' class='btn btn-danger mb-2 d-block'><i class='bi bi-trash-fill'></i></button>";
                        echo "</form>";
                        echo "<button class='btn btn-warning d-block' data-bs-toggle='modal' data-bs-target='#editBookModal" . $row['id'] . "'><i class='bi bi-pencil-fill'></i></button>";
                        echo "</td>";
                        echo "</tr>";
                    }

                    // Modale per la modifica del libro
                    if ($result = $mysqli->query($sql)) {
                        while ($row = $result->fetch_assoc()) {
                            if ($row !== null && isset($row['id'])) {
                                echo "<div class='modal fade' id='editBookModal" . $row['id'] . "' tabindex='-1' aria-labelledby='editBookModalLabel" . $row['id'] . "' aria-hidden='true'>";
                                echo "<div class='modal-dialog'>";
                                echo "<div class='modal-content bg-dark text-white'>";
                                echo "<div class='modal-header'>";
                                echo "<h5 class='modal-title' id='editBookModalLabel" . $row['id'] . "'>Modifica libro</h5>";
                                echo "<button type='button' class='btn-close btn-close-white' data-bs-dismiss='modal' aria-label='Close'></button>";
                                echo "</div>";
                                echo "<div class='modal-body'>";
                                echo "<form id='editBookForm" . $row['id'] . "' method='post' action='gestione.php'>";
                                echo "<input type='hidden' name='edit_id' value='" . $row['id'] . "'>";
                                echo "<div class='mb-3'>";
                                echo "<label for='titolo' class='form-label'>Titolo</label>";
                                echo "<input type='text' class='form-control' id='titolo' name='titolo' value='" . $row['titolo'] . "' required>";
                                echo "</div>";
                                $sql_autori = "SELECT id, nome FROM autori";
                                $result_autori = $mysqli->query($sql_autori);

                                echo "<div class='mb-3'>";
                                echo "<label for='autore' class='form-label'>Autore</label>";
                                echo "<select class='form-control' id='autore' name='autore' required>";
                                while ($row_autore = $result_autori->fetch_assoc()) {
                                    $selected = $row_autore['id'] == $row['autore_id'] ? 'selected' : '';
                                    echo '<option value="' . $row_autore['id'] . '" ' . $selected . '>' . $row_autore['nome'] . '</option>';
                                }
                                echo "</select>";
                                echo "</div>";
                                echo "<div class='mb-3'>";
                                echo "<label for='anno_pubblicazione' class='form-label'>Anno Pubblicazione</label>";
                                echo "<input type='number' class='form-control' id='anno_pubblicazione' name='anno_pubblicazione' value='" . $row['anno_pubblicazione'] . "' required>";
                                echo "</div>";
                                echo "<div class='mb-3'>";
                                echo "<label for='genere' class='form-label'>Genere</label>";
                                echo "<input type='text' class='form-control' id='genere' name='genere' value='" . $row['genere'] . "' required>";
                                echo "</div>";
                                echo "<div class='mb-3'>";
                                echo "<label for='prezzo' class='form-label'>Prezzo</label>";
                                echo "<input type='number' step='0.01' class='form-control' id='prezzo' name='prezzo' value='" . $row['prezzo'] . "' required>";
                                echo "</div>";
                                echo "<div class='mb-3'>";
                                echo "<label for='copertina' class='form-label'>URL Copertina</label>";
                                echo "<input type='text' class='form-control' id='copertina' name='copertina' value='" . $row['copertina'] . "' required>";
                                echo "</div>";
                                echo "</form>";
                                echo "</div>";
                                echo "<div class='modal-footer'>";
                                echo "<button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Chiudi</button>";
                                echo "<button type='submit' form='editBookForm" . $row['id'] . "' class='btn btn-light'>Salva</button>";
                                echo "</div>";
                                echo "</div>";
                                echo "</div>";
                                echo "</div>";
                            }
                        }
                    }
                } else {
                    echo "Errore: " . $mysqli->error;
                }
                ?>
            </tbody>
        </table>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
</body>

</html>