<?php

function changeDateFormat($oldDate)
{
    setlocale(LC_TIME, 'NL_nl');
    $time = strtotime($oldDate);
    return strftime('%A %e-%m-%Y', $time);
}

function getAllLesson()
{
    $db = $GLOBALS["db"];
    $lessons = $db->query("SELECT * FROM lesson WHERE Date >= CURRENT_DATE()")->fetchAll(); // select all lessons

    foreach ($lessons as $lesson) {
        $course = $db->query("SELECT * FROM course WHERE Course_ID = {$lesson['Course_ID']}")->fetchAll(); // select the course things

        foreach ($course as $course) {
            $employee = $db->query("SELECT FirstName, PrefixLastName, LastName FROM user WHERE User_ID = {$course['Employee_ID']}")->fetch(); // select the employee
            $timestamp = $db->query("SELECT BeginTime, EndTime FROM timestamp WHERE Timestamp_ID = {$lesson['Timestamp_ID']}")->fetch();
            $date = changeDateFormat($lesson['Date']);

            $beginTime = substr($timestamp['BeginTime'], 0, -3);
            $endTime = substr($timestamp['EndTime'], 0, -3);
            echo "

            <form method='POST' name='courseSign'>
            <div class='row mb-5'>
                <div class='col-md-6'><img class='img-fluid shadow' src='{$course["Image"]}' alt='{$course["Title"]}'></div> 
                <div class='col-md-6'>
                   <h1>{$course["Title"]}</h1>
                   
                   <!-- hidden input for the form to submit -->
                   <input type='hidden' name='Course_ID' value='{$course['Course_ID']}'>
                   <input type='hidden' name='Course_Title' value='{$course['Title']}'>
                   <input type='hidden' name='Lesson_ID' value='{$lesson['Lesson_ID']}'>
                   <input type='hidden' name='Location' value='{$course['Location']}'>
                   <input type='hidden' name='Price' value='{$course['Price']}'>
                   <input type='hidden' name='Date' value='{$lesson['Date']}'>
                   
                   <div class='row form-group'>
                     <div class='col-md-5'>Datum</div>
                     <div class='col-md-5 text-right'>{$date}</div>
                     
                     <div class='col-md-5'>Tijdstip</div>
                     <div class='col-md-5 text-right'>{$beginTime} - {$endTime}</div>
                     
                     <div class='col-md-5'>Beschikbare plekken</div>
                     <div class='col-md-5 text-right'>{$lesson['SpotsFree']} / {$lesson['MaxSpots']}</div>
                     
                     <div class='col-md-5'>Prijs</div>
                     <div class='col-md-5 text-right'>€ {$course['Price']}</div>
                     
                     <div class='col-md-5'>Locatie</div>
                     <div class='col-md-5 text-right'>{$course['Location']}</div>
                     
                     <div class='col-md-5'>Instructeur</div>
                     <div class='col-md-5 text-right'>{$employee['FirstName']} {$employee['PrefixLastName']} {$employee['LastName']}</div>
                     
                     <div class='col-md-10 text-center'>";
            if ($lesson['SpotsFree'] <= 0) {
                echo "<p class='text-danger'>Deze cursus is helaas volgeboekt</p>";
            } else {
                echo "<button class='btn btn-default' type='submit' name='courseSign'>Schrijf mij in voor deze cursus</button>";
            }
            echo "
                     </div>
                   </div>
                </div>
                </div>
            </form> ";
        }
    }
}

function moneyDisplay($price)
{
    $price = $price / 100;
    $price = str_replace('.', ',', number_format($price, 2));
    return $price;
}

function makeReservation()
{
    $db = $GLOBALS['db'];
    foreach ($_SESSION['bookedLesson'] as $key => $item) {
        $lesson_ID = $_SESSION['bookedLesson'][$key]['Lesson_ID'];
        $user_ID = $_SESSION['User_ID'];
        $today = date("Y-m-d");

        try {
            $sql = "UPDATE lesson SET SpotsFree = (SpotsFree - 1) WHERE Lesson_ID = ?";
            $stmt = $db->prepare($sql);
            $stmt->execute(array($lesson_ID));

            $sql2 = "INSERT INTO enrolment (Lesson_ID, User_ID, Date) VALUES(?,?,?)";
            $stmt2 = $db->prepare($sql2);
            $stmt2->execute(array($lesson_ID, $user_ID, $today));
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    unset($_SESSION['bookedLesson']);
    echo '<script>$(location).attr("href", "index.php?page=confirm")</script>'; // reload page
}

function checkReservation()
{
    if (isset($_SESSION['bookedLesson']) && !empty($_SESSION['bookedLesson'])) {
        $totalprice = 0; // empty variable for all prices
        foreach ($_SESSION['bookedLesson'] as $key => $item) {
            $course = $item['Course_Title'];
            $location = $item['Location'];
            $date = $item['Date'];
            $price = str_replace('.', ',', number_format(substr($item['Price'], 0, -2), '2')); // price for counting

            echo
            "<div class='row'>

                    <div class='col-md-12 text-right'>
                        <form action='' method='POST'>
                            <button type='submit' class='text-danger btn btn-link' name='delete$key'>&times;</button>
                        </form>
                    </div>
                    
                    <div class='col-md-6'> Cursus</div>
                    <div class='col-md-6 text-right'>$course</div>
                    
                    <div class='col-md-6'> Locatie</div>
                    <div class='col-md-6 text-right'>$location</div>
                    
                    <div class='col-md-6'> Datum</div>
                    <div class='col-md-6 text-right'>$date</div>
                    
                    <div class='col-md-6'> Prijs</div>
                    <div class='col-md-6 text-right'>€$price</div>
                    
                </div>
            </form>
            <hr>";

            $price = str_replace(',', '.', number_format(substr($item['Price'], 0, -2), '2')); // price for counting
            $totalprice = ($totalprice + $price); // totalprice increases

            if (isset($_POST['delete' . $key])) {// if the delete button is pressed in a form (above)
                unset($_SESSION['bookedLesson'][$key]);
                echo '<script>$(location).attr("href", window.location)</script>'; // reload page
            }
        }
        echo "<div class='row'>
                <div class='col-md-6'>Totaalprijs</div>
                <div class='col-md-6 text-right'>€{$totalprice}</div>
              </div>";

        echo "<form action='' method='POST'>
                <button type='submit' name='signLesson' class='btn text-dark btn-link text-center col-md-12'>Inschrijven en verder gaan</button>
              </form> ";

    } else {
        echo "<p class='text-danger text-center'>Nog geen reserveringen aangemaakt </p> ";
    }

    if (isset($_POST['courseSign'])) { // if form is submitted
        if (isset($_SESSION['bookedLesson']) & !empty($_SESSION['bookedLesson'])) {
            $courses = [];
            foreach ($_SESSION['bookedLesson'] as $key => $item) {
                $title = $item['Course'];

                if ($title == $_POST['Course_Title']) {
                    $_SESSION['errorMsg'][] = "Je kunt je niet aanmelden voor dezelfde cursus";
                } else {
                    $_SESSION['bookedLesson'][] = array('Course_ID' => $_POST['Course_ID'], 'Course_Title' => $_POST['Course_Title'], 'Lesson_ID' => $_POST['Lesson_ID'], 'Location' => $_POST['Location'], 'Date' => $_POST['Date'], 'Price' => $_POST['Price']);
                }
            }
            echo '<script>$(location).attr("href", window.location)</script>';
        } else {
            $_SESSION['bookedLesson'][] = array('Course_ID' => $_POST['Course_ID'], 'Course_Title' => $_POST['Course_Title'], 'Lesson_ID' => $_POST['Lesson_ID'], 'Location' => $_POST['Location'], 'Date' => $_POST['Date'], 'Price' => $_POST['Price']);
            echo '<script>$(location).attr("href", window.location)</script>';
        }

        foreach ($courses as $course) {
            var_dump($course);
        }
    }

    if (isset($_POST['signLesson'])) {
        makeReservation();
    }
}