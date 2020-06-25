<div class="container">
    <div class="col-md-12">
        <?php include 'src/phpscripts/register.php'; ?>
    </div>


    <div class="col-md-4 border m-1 pt-3 mx-auto shadow">
        <h3 class="text-center mb-2">Registreren</h3>
        <form method="post" name="registerForm" class="col-md-10 align-content-center">
            <div class="form-group">
                <input type="text" class="form-control" name="firstName" placeholder="Voornaam">
            </div>
            <div class="form-group">
                <input type="text" class="form-control" name="prefixLastName" placeholder="Tussenvoegsel">
            </div>
            <div class="form-group">
                <input type="text" class="form-control" name="lastName" placeholder="Achternaam">
            </div>
            <div class="form-group">
                <input type="email" class="form-control" name="email" placeholder="E-mail">
            </div>
            <div class="form-group">
                <input type="password" class="form-control" name="password" placeholder="Wachtwoord">
            </div>
            <div class="form-group">
                <input type="submit" class="form-control" name="register" placeholder="Registreren">
            </div>
        </form>
    </div>
</div>
