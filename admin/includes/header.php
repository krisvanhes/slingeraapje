<?php
include('db.php');
session_start()
?>

<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="../src/css/style.css">
    <link rel="stylesheet" href="../src/css/animate.css">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../src/css/bootstrap4.4.1.css">
    <!-- Custom javaScript -->
    <script src="../src/js/script.js"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

    <title>Het slingeraapje - Admin</title>
</head>
<body>

<?php
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] && $_SESSION['role'] > 1) { ?>
    <nav class="navbar navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="/index.php"><h1>Het slingeraapje</h1> <h5>Outdoorcentrum hardenberg</h5></a>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown">
                    <!-- logout  -->
                    <div class="row">
                        <div class="col-md-12 pr-md-1 mt-1">
                            <a class="text-dark form-control btn btn-light" href="/index.php?page=logout">
                                Uitloggen
                            </a>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
<?php } else { ?>
    <script>redirectWithDelay(1)</script>
<?php } ?>

<div class="mt-1 mb-4 mt-1" id="wrapper-content">
    <div class="container" id="menu">
        <div class="row row-cols-2">
            <div class="col">
                <a class="form-control btn btn-light border" href="index.php?page=dashboard">Home</a>
            </div>
            <div class="col">
                <a class="form-control btn btn-light border" href="index.php?page=inschrijvingen">Inschrijvingen</a>
            </div>
        </div>
    </div>
</div>


<div class="container">
    <div class="col-md-12 text-center">
        <?php
        if (isset($_SESSION["adminErrorMsg"])) {
            foreach ($_SESSION["adminErrorMsg"] as $error) { ?>
                <div class="alert alert-danger alert-dismissible" role="alert">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <?php echo $error; ?>
                </div>
            <?php }
        }
        if (isset($_SESSION["adminGoodMsg"])) {
            foreach ($_SESSION["adminGoodMsg"] as $message) { ?>
                <div class="alert alert-success alert-dismissible" role="alert">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close"
                       id="disableGoodMessage">&times;</a>
                    <?php echo $message; ?>
                </div>
            <?php }
        } ?>
        </form>
    </div>
</div>