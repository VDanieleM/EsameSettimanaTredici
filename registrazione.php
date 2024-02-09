<?php

require_once('config.php');

$error = false;
$registrazione_riuscita = false;
$campi_vuoti = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($mysqli, $_POST['username']);
    $email = mysqli_real_escape_string($mysqli, $_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    if (empty($username) || empty($email) || empty($_POST['password'])) {
        $campi_vuoti = true;
    } else {
        $sql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("sss", $username, $email, $password);

        try {
            if ($stmt->execute()) {
                $registrazione_riuscita = true;
            }
        } catch (mysqli_sql_exception $e) {
            $error = true;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <style>
        .fade-in {
            animation: fadeIn ease 3s;
            -webkit-animation: fadeIn ease 3s;
            -moz-animation: fadeIn ease 3s;
            -o-animation: fadeIn ease 3s;
            -ms-animation: fadeIn ease 3s;
        }

        @keyframes fadeIn {
            0% {
                opacity: 0;
            }

            100% {
                opacity: 1;
            }
        }

        @-moz-keyframes fadeIn {
            0% {
                opacity: 0;
            }

            100% {
                opacity: 1;
            }
        }

        @-webkit-keyframes fadeIn {
            0% {
                opacity: 0;
            }

            100% {
                opacity: 1;
            }
        }

        @-o-keyframes fadeIn {
            0% {
                opacity: 0;
            }

            100% {
                opacity: 1;
            }
        }

        @-ms-keyframes fadeIn {
            0% {
                opacity: 0;
            }

            100% {
                opacity: 1;
            }
        }

        .border-light {
            border: 1px solid gray !important;
        }
    </style>
</head>

<body class="bg-dark text-white">
    <?php include('navbar.php'); ?>
    <div class="d-flex justify-content-center align-items-center vh-100">
        <div class="card text-white bg-dark fade-in border-light">
            <div class="card-body">
                <h5 class="card-title text-center">Registrazione</h5>
                <?php if ($registrazione_riuscita): ?>
                    <div class="alert alert-success" role="alert">
                        Registrazione avvenuta con successo, fai login per accedere
                    </div>
                <?php endif; ?>
                <?php if ($error): ?>
                    <div class="alert alert-danger" role="alert">
                        Username o Email già utilizzate
                    </div>
                <?php endif; ?>
                <?php if ($campi_vuoti): ?>
                    <div class="alert alert-warning" role="alert">
                        Tutti i campi sono obbligatori
                    </div>
                <?php endif; ?>
                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" name="username">
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email">
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password">
                    </div>
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <button type="submit" class="btn btn-light">Registrati</button>
                        <a href="index.php" class="btn btn-secondary">Accedi</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
</body>

</html>