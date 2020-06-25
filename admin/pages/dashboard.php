<?php include '../admin/phpscripts/dashboard.php'; ?>


<div class="container">
    <div class="row mb-5 col-md-12 d-flex align-content-center">
        <div class="col text-center">
            <h1>Welkom <?php echo $_SESSION['name'] ?></h1>
            <p>Je bevind je momenteel in het Slingeraapje Admin paneel, hier kan je in het ondestaande formulier een
                les
                inplannen of een cursus toevoegen. Als er iets mis is met het formulier laat het weten aan een
                administrator! En maak geen misbruik van dit paneel</p>
        </div>
    </div>

    <div class="row ">
        <div class="col-6 row text-center d-flex align-items-center justify-content-center">
            <h1 class="text-center col-md-12">Les toevoegen</h1>

            <form method="post">
                <div class="col-md-6">
                    <select class="mb-2 border rounded" name="course">
                        <option value="<?php echo(isset($_POST['course']) ? $_POST['course'] : ''); ?>">Cursus</option>
                        <?php getCourses(); ?>
                    </select>
                </div>

                <div class=" col-md-6">
                    <input class="mb-2 border rounded" type="date" name="date" placeholder="Datum" id="date"
                           value="<?php echo date("Y-m-d") ?>" onchange="CheckDate()">
                </div>

                <div class="col-md-6">
                    <select class="mb-2 border rounded" name="timestamp">
                        <option value="">Tijdstip</option>
                        <?php GetAllTimeStamps(); ?>
                    </select>
                </div>

                <div class="col-md-12">
                    <input class="col-md-12 mb-2 border rounded" type="submit" name="AddLesson" value="Toevoegen">
                </div>

            </form>
        </div>
        <div class="col-6 row text-center d-flex align-items-center justify-content-center">
            <h1 class="text-center col-md-12">Cursus toevoegen</h1>

            <form method="post" enctype="multipart/form-data" name="addCourse">

                <div class="col-md-6">
                    <input class="mb-2 border rounded" type="text" name="title" placeholder="Naam"
                           value="<?php echo(isset($_POST['title']) ? $_POST['title'] : ''); ?>">
                </div>

                <div class="col-md-6">
                    <input class="mb-2 border rounded" type="text" name="location" placeholder="Location"
                           value="<?php echo(isset($_POST['location']) ? $_POST['location'] : ''); ?>">
                </div>

                <div class="col-md-6">
                    <select class="border rounded mb-2" name="employee">
                        <option value="<?php echo(isset($_POST['employee']) ? $_POST['employee'] : ''); ?>">
                            Instructeur
                        </option>
                        <?php getEmployee(); ?>
                    </select>
                </div>

                <div class="col-md-6">
                    <input class="mb-2 border rounded" type="number" placeholder="Prijs per les" step="0.01"
                           min="0.00" name="price"
                           value="<?php echo(isset($_POST['price']) ? $_POST['price'] : ''); ?>">
                </div>

                <div class="col-md-6">
                    <input class="mb-2 border rounded" type="number" placeholder="Plekken vrij" step="1" min="0"
                           name="totalspots"
                           value="<?php echo(isset($_POST['totalspots']) ? $_POST['totalspots'] : ''); ?>">
                </div>

                <div class="col-md-12">
                    <input class="col-md-12 mb-2 border rounded" type="button" id="imagebtn" value="Afbeelding kiezen">
                    <input type="file" name="image" id="image" style="display:none"
                           value="<?php echo(isset($_POST['image']) ? $_POST['image'] : ''); ?>">
                </div>

                <div class="col-md-12">
                    <input class="col-md-12 mb-2 border rounded" type="submit" name="AddCourse" value="Toevoegen">
                </div>

            </form>
        </div>
    </div>
</div>