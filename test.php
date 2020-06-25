<div class="col-md-6 row border text-center d-flex justify-content-center">
    <h1 class="text-center">Cursus toevoegen</h1>

    <form method="post">

        <div class="col-md-6">
            <input class="mb-2 border rounded" type="text" name="title" placeholder="Naam">
        </div>

        <div class="col-md-6">
            <input class="mb-2 border rounded" type="text" name="location" placeholder="Location">
        </div>

        <div class="col-md-6">
            <select class="border rounded mb-2" name="employee">
                <option value="">Instructeur</option>
                <?php getEmployee(); ?>
            </select>
        </div>

        <div class="col-md-6">
            <input class="mb-2 border rounded" type="number" placeholder="Prijs per les" step="0.01" min="0.00" name="price">
        </div>

        <div class="col-md-6">
            <input class="mb-2 border rounded" type="number" placeholder="Plekken vrij" step="1" min="0" name="totalspots">
        </div>

        <div class="col-md-12">
            <input class="col-md-12 mb-2 border rounded" type="submit" name="AddCourse" value="Toevoegen">
        </div>

    </form>
</div>