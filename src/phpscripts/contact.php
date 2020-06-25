<?php

use PHPMailer\PHPMailer\PHPMailer;

function getEmployees($db)
{
    try {
        $stmt = $db->prepare('SELECT * FROM user WHERE Role = 2');
        $stmt->execute();
        $user = $stmt->fetchAll();

        foreach ($user as $item) {
            if ($item['PrefixLastName'] == "" || $item['PrefixLastName'] == NULL) {
                $name = "{$item['FirstName']} {$item['LastName']}";
            } else {
                $name = "{$item['FirstName']} {$item['PrefixLastName']} {$item['LastName']}";
            }
            $age = countAge($item['Birthday']); // calls function countAge with birthday
            $picture = $item['Picture'];

            $id = $item['User_ID'];
            $stmt = $db->prepare('SELECT title FROM course WHERE Employee_ID = ?');
            $stmt->execute([$id]);
            $resultC = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($resultC) {
                $course = implode("", $resultC);
            } else {
                $course = "";
            }

            echo "
            <div class='col-md-6 mb-5'><div class='card'>
                <img class='card-img-top' src='{$picture}' alt='Afbeelding {$name}'>
                <div class='card-body'><p class='card-title'>{$name} - {$age} <br> Instructeur {$course}</div>
            </div></div>";
        }

    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

function countAge($birthday)
{
    $currentDate = new DateTime('today');

    return date_diff(date_create($birthday), date_create('today'))->y;
}

function sendMail($name, $email, $subject, $message)
{
    require_once 'vendor/autoload.php';

    $mail = new PHPMailer();

    $mail->isSMTP();
    $mail->Host = 'smtp.mailtrap.io';
    $mail->SMTPAuth = true;
    $mail->Username = 'c983bf31652a41';
    $mail->Password = '126d1a59487be4';
    $mail->SMTPSecure = 'tls';
    $mail->Port = 2525;

    $mail->setFrom($email, $name);
    $mail->addAddress('info@slingeraapje.nl', 'Slingeraapje');
    $mail->Subject = $subject;
    $mail->isHTML(true);

    $mailContent = $message;
    $mail->Body = $mailContent;

    if ($mail->send()) {
        $goodMsg[] = "Uw mail0 is verzonden en ";
    } else {
        $errorMsg[] = $mail->ErrorInfo;
    }
}

function checkContactForm()
{
    $firstName = htmlspecialchars($_POST['firstname']);
    $lastName = htmlspecialchars($_POST['lastname']);
    $email = htmlspecialchars($_POST['email']);
    $subject = htmlspecialchars($_POST['subject']);
    $message = htmlspecialchars($_POST['message']);

    if (empty($firstName)) {
        $errorMsg[] = "Voornaam is niet ingevuld";
    } elseif (empty($lastName)) {
        $errorMsg[] = "Achternaam is niet ingevuld";
    } elseif (empty($email)) {
        $errorMsg[] = "Email is niet ingevuld";
    } elseif (empty($subject)) {
        $errorMsg[] = "Onderwerp is niet ingevuld";
    } elseif (empty($message)) {
        $errorMsg[] = "Bericht kan niet leeg zijn";
    } else {
        $name = "{$firstName} {$lastName}";
        sendMail($name, $email, $subject, $message); // send mail with the mail function defined above
    }
}

if (isset($_POST["contactForm"])) {
    checkContactForm();
}