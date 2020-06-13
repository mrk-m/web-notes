<?php 

    session_start();

    // POST data
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Connect to db
    require_once ('private/connect.php');

    // SQL
    $sql = 'SELECT ID, Password, Active FROM Users WHERE EmailAddress = ?';

    $stmt = $db->prepare($sql);
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $stmt->bind_result($userid, $passwordhash, $active);

    // Check
    if ($stmt->fetch()) {
        if (!$active) {
            // Account is not active
            header("Location: signin?error=inactive");
        } elseif (password_verify($password, $passwordhash)) {
            // Correct password
            $_SESSION['user_id'] = $userid;
            header("Location: notes");
        } else {
            // Incorrect password
            header("Location: signin?error=incorrect");
        }
    } else {
        // Incorrect email
        header("Location: signin?error=incorrect");
    }

    // Close statement
    $stmt->close();
?>