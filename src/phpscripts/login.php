<?php

if (isset($_POST['loginForm'])) {
    $username = htmlspecialchars($_POST['email']);
    $password = htmlspecialchars($_POST['password']);

    if (empty($username) || empty($password)) {
        $errorMsg[] = "Vul beide velden in"; // if username or password is empty errormsg
    } else {
        try {
            $stmt = $db->prepare("SELECT * FROM user WHERE email = ?");
            $stmt->execute([$username]);
            $result = $stmt->fetch();

            if ($result) {
                if ($result['PrefixLastName'] == "" || $result['PrefixLastName'] == NULL) {
                    $name = "{$result['FirstName']} {$result['LastName']}";
                } else {
                    $name = "{$result['FirstName']} {$result['PrefixLastName']} {$result['LastName']}";
                }

                $password_db = $result['Password'];

                if (password_verify($_POST['password'], $password_db)) { // if password is correct with stored db
                    $_SESSION['loggedin'] = TRUE;
                    $_SESSION['name'] = $name;
                    $_SESSION['User_ID'] = $result['User_ID'];
                    if ($result['Role']) {
                        $_SESSION['role'] = $result['Role'];
                        $role = $_SESSION['role'];
                    } else {
                        $role = 1;
                    }
                    $_SESSION['email'] = $result['Email'];

                    $goodMsg[] = "Succesvol ingelogd u word binnen 5 seconden doorgestuurd naar de homepagina";

                    if ($role > 1) {
                        echo '<script>redirectAdmin()</script>';
                    } else {
                        echo '<script>redirectWithDelay(5000)</script>';
                    }
                }
            } else {
                $errorMsg[] = "Gebruikersnaam en/of wachtwoord zijn niet correct";
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}