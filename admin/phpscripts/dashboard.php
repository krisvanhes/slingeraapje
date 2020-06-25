<?php

function removeSuccesMessage()
{
    //remove the message after 5 seconds
    header('Refresh:0');
    sleep(5);
    unset($goodMsg, $_SESSION['goodMsg']);
    header('Refresh:0');
}

function getCourses()
{
    // get all timestamps
    $db = $GLOBALS["db"];
    try {
        $courses = $db->query('SELECT * FROM course')->fetchAll();

        foreach ($courses as $course) {
            echo "<option value='{$course['Course_ID']}'>{$course['Title']}</option>";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

function GetAllTimeStamps()
{

    // get the timestamps where id = 2 AND 3
    $db = $GLOBALS["db"];
    try {
        $timestamps = $db->query('SELECT * FROM timestamp')->fetchAll(); // query

        foreach ($timestamps as $timestamp) {
            $beginTime = substr($timestamp['BeginTime'], 0, -3); // remove :00 at the end of the string
            $endTime = substr($timestamp['EndTime'], 0, -3); // remove :00 at the end of the string

            if (substr($beginTime, 0, -3) == 20) {
                echo "<option value='{$timestamp['Timestamp_ID']}'>Doordeweeks: {$beginTime} - {$endTime}</option>";
            } else {
                echo "<option value='{$timestamp['Timestamp_ID']}'>Weekend: {$beginTime} - {$endTime}</option>";
            }
        }

    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

function getEmployee()
{
    // get all employees where role > 1
    $db = $GLOBALS["db"];
    try {
        $employees = $db->query('SELECT * FROM user WHERE Role > 1')->fetchAll();

        foreach ($employees as $employee) {
            echo "<option value='{$employee['User_ID']}'>{$employee['FirstName']} {$employee['LastName']} {$employee['PrefixLastName']}</option>";
        }

    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}


function AddLesson($course_ID, $timestamp_ID, $date, $maxSpots, $spotsFree)
{
    // add course with all the details if everything is correct in the checkCourseForm function
    $db = $GLOBALS["db"];
    try {
        $stmt = $db->prepare("INSERT INTO lesson (Course_ID, Timestamp_ID, Date, MaxSpots, SpotsFree) VALUES (?,?,?,?,?)");
        $stmt->execute(array($course_ID, $timestamp_ID, $date, $maxSpots[0], $spotsFree[0]));

        $_SESSION["goodMsg"][] = "De les is aangemaakt";
        echo '<script>window.location = window.location.href</script>';
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

function checkLessonForm()
{
    // function to check if everything is not empty in the form
    $course = htmlspecialchars($_POST['course']);
    $date = htmlspecialchars($_POST['date']);
    $timestamp = htmlspecialchars($_POST['timestamp']);
    $db = $GLOBALS["db"];
    try {
        $stmt = $db->prepare("SELECT MaxSpots FROM Course WHERE Course_ID = ?");
        $stmt->execute([$course]);
        $spotsFree = $stmt->fetch();

        if (empty($course)) {
            $_SESSION['errorMsg'][] = 'De cursus is niet ingevuld';
        } elseif (empty($date)) {
            $_SESSION['errorMsg'][] = 'Datum is niet ingevuld';
        } elseif (empty($timestamp)) {
            $_SESSION['errorMsg'][] = 'Tijdstip is niet ingevuld';
        } else {
            unset($_SESSION['errorMsg']); // remove error messages
            AddLesson($course, $timestamp, $date, $spotsFree, $spotsFree);
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}


function AddCourse($title, $location, $employee, $price, $places, $image)
{
    // add course with all the details if everything is correct in the checkCourseForm function
    try {
        $db = $GLOBALS["db"];
        $stmt = $db->prepare("INSERT INTO course (title, Location, Employee_ID, Price, maxSpots, Image) VALUES (?,?,?,?,?,?)");
        $stmt->execute([$title, $location, $employee, $price, $places, $image]);

        $_SESSION["goodMsg"][] = "De cursus is toegevoegd en er kan nu een les van worden gemaakt";
        echo '<script>window.location = window.location.href</script>';

    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

function checkCourseForm()
{
    // function to check if everything is not empty in the form
    $title = htmlspecialchars($_POST['title']);
    $location = htmlspecialchars($_POST['location']);
    $employee = htmlspecialchars($_POST['employee']);
    $price = htmlspecialchars($_POST['price']);
    $places = htmlspecialchars($_POST['totalspots']);

    $target_dir = "../src/image/course/"; // directory for images
    $target_file = $target_dir . basename($_FILES['image']['name']); // image from HTML form

    if (empty($title)) {
        $_SESSION['errorMsg'][] = "Naam van de cursus is niet ingevuld";
    } elseif (empty($location)) {
        $_SESSION['errorMsg'][] = "Locatie is niet ingevuld";
    } elseif (empty($employee)) {
        $_SESSION['errorMsg'][] = "Medewerker is niet ingevuld";
    } elseif (empty($price)) {
        $_SESSION['errorMsg'][] = "Prijs per les is niet ingevuld";
    } elseif (empty($places)) {
        $_SESSION['errorMsg'][] = "Aantal beschikbare plekken is niet ingevuld";
    } elseif (!move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
        $_SESSION['errorMsg'][] = "Er is iets misgegaan met de afbeelding";
    } elseif (!empty($title) && !empty($location) && !empty($employee) && !empty($price) && !empty($places) && !empty($target_file)) {
        unset($_SESSION['errorMsg']); // remove error messages
        AddCourse($title, $location, $employee, $price, $places, $target_file);
    }
}

if (isset($_POST["AddCourse"])) {
    unset($_SESSION['goodMsg'], $_SESSION['errorMsg']);
    checkCourseForm();
} elseif (isset($_POST["AddLesson"])) {
    unset($_SESSION['goodMsg'], $_SESSION['errorMsg']);
    checkLessonForm();
}
