<?php

function getBookedToday()
{
    $db = $GLOBALS["db"];
    $user_ID = $_SESSION['User_ID'];
    // select from enrolment where user_id = session['user_id'] and date = today
    try {
//        $stmt = $db->prepare("SELECT e.Lesson_ID, l.Course_ID, l.Timestamp_ID, l.Date,
//        FROM enrolment AS e WHERE user_ID = ? AND Date = CURRENT_DATE()
//        JOIN lesson AS l ON e.Lesson_ID = e.Lesson_ID
//        JOIN course AS c ON l.Course_ID = c.Course_ID");
        $stmt = $db->prepare("SELECT * FROM enrolment AS e WHERE user_ID = ? AND Date = CURRENT_DATE()");
        $stmt->execute(array($user_ID));
        $enrolments = $stmt->fetchAll();

        var_dump($enrolments);

//        if ($enrolments) { // if the database has found any records from today
        foreach ($enrolments as $enrolment) {
            $lesson_ID = $enrolment['Lesson_ID'];
            echo "
                    <tr>
                        <td></td>
                        <td>{$enrolment['l.Date']}</td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>";
        }

//        } else {
//            echo '<script>$(location).attr("href", "index.php")</script>'; // else go back to the homepage
//        }
    } catch (Exception $e) {
        echo 'Caught exception: ', $e->getMessage(), "\n";
    }
}