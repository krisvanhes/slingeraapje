<?php include 'src/phpscripts/course.php' ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 mr-3 ml-5 row">
            <?php
            getAllLesson(); ?>
        </div>

        <?php
        if (isset($_SESSION['loggedin'])) { ?>
            <div class="col-md-3 border border-dark shadow-sm h-100">
                <h3 class="text-center">Inschrijvingen</h3>
                <?php checkReservation(); ?>
            </div>
        <?php } else {
            ?>
            <div class="col-md-3 border border-dark shadow-sm h-100">
                <h3 class="text-center">Inschrijvingen</h3>
                <p class="text-danger">Momenteel bent u niet ingelogd en kunt u zich niet inschrijven voor een
                    cursus</p>
            </div>
        <?php } ?>
    </div>
</div>


