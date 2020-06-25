<div class="container">
    <div class="col-md-12">
        <?php include 'src/phpscripts/contact.php'; ?>
    </div>


    <div class="row col-md-12 d-flex align-content-center">
        <div class="col-md-4">
            <h6>E-mail adres en telefoonnummer</h6>
            <p>
                info@outdoorcentrum-hardenberg.nl <br>
                +0523 12 34 56 78
            </p>

            <h6>Bezoekadres</h6>
            <p>
                Parkweg 1A1 <br> 7772 XP Hardenberg
            </p>

            <h5>Contact opnemen</h5>
            <form method="post">
                <div class="form-group row">
                    <input type="text" class="form-control col mr-2" name="firstname" placeholder="Naam">
                    <input type="text" class="form-control col ml-2" name="lastname" placeholder="Achternaam">
                </div>
                <div class="form-group row">
                    <input type="text" class="form-control col mr-2" name="email" placeholder="E-mail adres">
                    <input type="text" class="form-control col ml-2" name="subject" placeholder="Onderwerp">
                </div>
                <div class="form-group row">
                    <textarea class="form-control col" name="message" placeholder="Typ hier uw bericht" rows="6"
                              cols="50"></textarea>
                </div>
                <div class="form-group row float-right">
                    <input type="submit" name="contactForm" class="btn btn-success" value="Verzenden">
                </div>
            </form>
        </div>
        <div class="col-md-8 text-center">
            <h1>Instructeurs</h1>
            <div class="row">
                <?php getEmployees($db); ?>
            </div>
        </div>
    </div>
</div>