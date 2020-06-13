<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php print $pageTitle ?></title>

    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/jquery-ui-1.12.1.css">
    <link rel="stylesheet" href="css/style.css">
    

    <script src="js/jquery-3.4.1.js"></script>
    <script src="js/jquery-ui-1.12.1.js"></script>
</head>
<body>

<header>
    
            <?php

            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }

            if (isset($_SESSION['user_id'])) {
                // logged in
                print '
                <a href="notes.php"><strong>Web Notes</strong></a>
                <nav>
                <ul>
                <li>
                    <a href="signout.php"><strong>Sign Out</strong></a>
                </li>
                </ul>
                </nav>
                ';
            } else {
                // not logged in
                print '
                <a href="index.php"><strong>Web Notes</strong></a>
                <nav>
                <ul>
                <li>
                    <a href="signin.php"><strong>Sign In</strong></a>
                    </li>
                    </ul>
                    </nav>
                ';
            }
            ?>
        
</header>

