<?php
if (isset($_POST['register'])) {
    $firstName = htmlspecialchars($_POST['firstName']);
    if (empty($_POST['prefixLastName']) || $_POST['prefixLastName'] == "") {
        $prefixLastName = "";
    } else {
        $prefixLastName = htmlspecialchars($_POST['prefixLastName']);
    }
    $lastName = htmlspecialchars($_POST['lastName']);
    $email = htmlspecialchars($_POST['email']);
    $password = htmlspecialchars($_POST['password']);
    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

    if (empty($firstName)) {
        $errorMsg[] = "Voornaam"; // checks if firstname is empty
    } elseif (empty($lastName)) {
        $errorMsg[] = "Achternaam"; // checks if lastname is empty
    } elseif (empty($email)) {
        $errorMsg[] = "E-mail"; // checks if email is empty
    } elseif (empty($password)) {
        $errorMsg[] = "Wachtwoord"; // checks if password is empty
    } else {
        try {
            $selectEmail = $db->prepare('SELECT * FROM student WHERE Student_ID = 1');
            $selectEmail->execute();
            $row = $selectEmail->fetch();

            if ($row["username"] == $email) {
                $errorMsg[] = "E-mail is al in gebruik"; // if user exist in the database
            } elseif (!isset($errorMsg)) {
                $sql = $db->prepare("INSERT INTO user (Firstname, PrefixLastName, LastName, Email, Password) VALUES (?, ?, ?, ?, ?)");
                $sql->execute(array($firstName, $prefixLastName, $lastName, $email, $passwordHash));

                if (empty($prefixLastName) || $prefixLastName == "") {
                    $name = "{$firstName} {$lastName}";
                } else {
                    $name = "{$firstName} {$prefixLastName} {$lastName}";
                }

                $_SESSION['loggedin'] = TRUE;
                $_SESSION['name'] = $name;
                $_SESSION['email'] = $email;
                $_SESSION['role'] = 1;

                $goodMsg[] = "Succesvol geregistreerd u word binnen 5 seconden doorgestuurd naar de homepagina";

                echo '<script>redirectWithDelay(5000) </script>'; // functions that redirects the logged in user to homepage
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
}
