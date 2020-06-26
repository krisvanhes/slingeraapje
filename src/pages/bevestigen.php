<?php include 'src/phpscripts/confirm.php' ?>

<div class="container">
    <div class="row">
        <div class="col-md-12 row border">
            <h2 class="text-center col-md-12">Ingeschreven voor de volgende les(sen):</h2>
            <table class='table'>
                <thead>
                <tr>
                    <th scope='col'>Cursus</th>
                    <th scope='col'>Datum en tijdstip</th>
                    <th scope='col'>Prijs</th>
                    <th scope='col'>Locatie</th>
                    <th scope='col'>Instructeur</th>
                </tr>
                </thead>
                <tbody class=''>
                <?php getBookedToday(); ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
