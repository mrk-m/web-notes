<?php

    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        $data = htmlentities($data);
        return $data;
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        session_start();

        // POST data
        $first_name = test_input($_POST["firstname"]);
        $last_name = test_input($_POST["lastname"]);
        $email = test_input($_POST["email"]);
        $password = test_input($_POST["password"]);

        echo '<br>First Name ' . $first_name;
        echo '<br>Last Name ' . $last_name;
        echo '<br>Email ' . $email;
        echo '<br>Password ' . $password;

        // Connect to db
        require_once ('private/connect.php');

        // SQL
        $sql = 'SELECT EmailAddress FROM Users WHERE EmailAddress = ?';

        $stmt = $db->prepare($sql);
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $stmt->bind_result($tempvar);

        $success = false;

        // Check
        if (!$stmt->fetch()) {
            // Create an account
            // SQL
            $sqlc = 'INSERT INTO Users (`FirstName`, `LastName`, `EmailAddress`, `Password`) VALUES (?, ?, ?, ?);';

            $stmtc = $db->prepare($sqlc);
            $stmtc->bind_param('ssss', $first_name, $last_name, $email, password_hash($password, PASSWORD_BCRYPT));
            $stmtc->execute();
            $stmtc->close();

            $success = true;
        } else {
            // Account already exists with this email
            header("Location: signup?error=email");
        }

        // Close statement
        $stmt->close();

        if ($success) {
            header("Location: signin?success");
        }
    }

    $pageTitle = 'Sign Up | Notes App';
    require ('private/incHeader.php');
?>


<div class="sign-box">
    <form action="signup" method="post" class="grid">

        <h1 class="col-1">Sign Up</h1>

        <?php
    if (isset($_GET['error'])) {
        if ($_GET['error'] == "email") {
            print '
            
            <div class="col-1">
            <div class="ui-state-error ui-corner-all" style="padding: .5em;">
                <p style="margin: 0">
                    <span class="ui-icon ui-icon-alert" style="input: left; margin-right: .3em;"></span>
                    An account already exists with this email.
                </p>
            </div>
            </div>
            ';
        } elseif ($_GET['error'] == "inactive") {

        }
    }
    ?>
        
        <div class="col-1-2 input-container-container">
            <div class="input-container" id="input-container">
                <label for="firstname">First Name</label>
                <input type="text" name="firstname" id="firstname"  data-placeholder="" autocomplete="given-name" oninvalid="this.setCustomValidity('Please enter your first name')" oninput="this.setCustomValidity('')" required>
            </div>
        </div>

        <div class="col-1-2 input-container-container">
            <div class="input-container" id="input-container">
                <label for="lastname">Last Name</label>
                <input type="text" name="lastname" id="lastname"  data-placeholder="" autocomplete="family-name" oninvalid="this.setCustomValidity('Please enter your last name')" oninput="this.setCustomValidity('')" required>
            </div>
        </div>


        
        <div class="col-1 input-container-container">
            <div class="input-container" id="input-container">
                <label for="email">Email Address</label>
                <input type="email" name="email" id="email"  data-placeholder="" autocomplete="email" oninvalid="this.setCustomValidity('Please enter your valid email address')" oninput="this.setCustomValidity('')" required>
            </div>
        </div>

        <div class="col-1 input-container-container">
            <div class="input-container" id="input-container">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" data-placeholder="" autocomplete="new-password" oninvalid="this.setCustomValidity('Please enter a password')" oninput="this.setCustomValidity('')" required>
            </div>
        </div>

        <div class="col-1 input-container-container">
            <div id="input-container">
                <input type="checkbox" name="agreeterms" id="agreeterms"  data-placeholder="" oninvalid="this.setCustomValidity('Please accept the terms and conditions')" oninput="this.setCustomValidity('')" required>
                <label for="agreeterms">I agree to the <a href="#">Terms and Conditions</a></label>
            </div>
        </div>

        <div class="col-1-2 no-pad-bottom">
            <a href="signin">
                <input type=button class="createaccount" value="Back to Sign In">
            </a>
        </div>

        <div class="col-1-2">
            <input type="submit" value="Create Account">
        </div>
        
    </form>
    
</div>

<script src="js/input-float.js"></script>
<?php
    require ('private/incFooter.php');
?>