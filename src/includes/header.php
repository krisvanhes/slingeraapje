<?php
include('db.php');
session_start()
?>

<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta http-equiv="refresh" content="300"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="src/css/style.css">
    <link rel="stylesheet" href="src/css/animate.css">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="src/css/bootstrap4.4.1.css">
    <!-- Custom javaScript -->
    <script src="src/js/script.js"></script>

    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>

    <title>Het slingeraapje - Hardenberg</title>
</head>
<body>

<?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin']) { ?>
    <nav class="navbar navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="#"><h1>Het slingeraapje</h1> <h5>Outdoorcentrum hardenberg</h5></a>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown">
                    <!-- logout  -->
                    <div class="row">
                        <div class="col-md-12 pr-md-1 mt-1">
                            <a class="text-dark form-control btn btn-light" href="index.php?page=logout">
                                Uitloggen
                            </a>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
<?php } else { ?>
    <nav class="navbar navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="#"><h1>Het slingeraapje</h1> <h5>Outdoorcentrum hardenberg</h5></a>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown">
                    <!-- login  & register -->
                    <form method="post">
                        <div class="row no-gutters">

                            <div class="col-md-4 pr-md-1">
                                <input type="text" class="form-control mr-10" name="email" placeholder="Gebruikersnaam">
                            </div>
                            <div class="col-md-4 pr-md-1">
                                <input type="password" class="form-control ml-10 mr-10" name="password"
                                       placeholder="Wachtwoord">
                            </div>
                            <div class="col-md-4 pr-md-1">
                                <input type="submit" name="loginForm" class="form-control btn btn-light"
                                       placeholder="Inloggen">
                            </div>

                        </div>
                    </form>
                    <div class="row no-gutters">
                        <div class="col-md-8 pr-md-1"></div>
                        <div class="col-md-4 pr-md-1 mt-1">
                            <a class="text-dark form-control btn btn-light" href="index.php?page=register">
                                Registreren
                            </a>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
<?php } ?>

<div class="mt-1 mb-4 mt-1" id="wrapper-content">
    <div class="container" id="menu">
        <div class="row row-cols-3">
            <div class="col">
                <a class="form-control btn btn-light border" href="index.php?page=home">Home</a>
            </div>
            <div class="col">
                <a class="form-control btn btn-light border" href="index.php?page=cursussen">Cursussen</a>
            </div>
            <div class="col">
                <a class="form-control btn btn-light border" href="index.php?page=contact">Contact</a>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <div class="col-md-12">
        <?php
        include 'src/phpscripts/login.php';

        if (isset($_SESSION['errorMsg'])) {
            foreach ($_SESSION['errorMsg'] as $key => $value) { ?>
                <form method="post">
                    <div class="alert alert-danger text-center">
                        <button type="submit" name="disableErrorMsg<?php echo $key ?>" class="close btn btn-link">
                            &times;
                        </button>
                        <?php echo $value; ?>
                    </div>
                </form>
                <?php
                if (isset($_POST["disableErrorMsg" . $key])) {
                    unset($_SESSION['errorMsg'][$key]);
                    echo '<script>$(location).attr("href", window.location)</script>';
                }
            }
        } else if (isset($_SESSION['goodMsg'])) {
            foreach ($_SESSION['goodMsg'] as $key => $value) { ?>
                <form method="post">
                    <div class="alert alert-danger text-center">
                        <input type="submit" name="disableGoodMsg<?php echo $key ?>" class="close" aria-label="close"
                               value="&times;">
                        <?php echo $value; ?>
                    </div>
                </form>
                <?php
                if (isset($_POST["disableGoodMsg" . $key])) {
                    unset($_SESSION['goodMsg'][$key]);
                    echo '<script>$(location).attr("href", window.location)</script>';
                }
            }
        } ?>
    </div>
</div>
