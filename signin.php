<?php
    $pageTitle = 'Sign In | Notes App';
    require ('private/incHeader.php');

?>

<div class="sign-box">
    <form action="authenticate" method="post" class="grid">

        <h1 class="col-1">Sign In</h1>

        <?php
        if (isset($_GET['error'])) {
            if ($_GET['error'] == "incorrect") {
                print '
                
                <div class="col-1">
                <div class="ui-state-error ui-corner-all" style="padding: .5em;">
                    <p style="margin: 0">
                        <span class="ui-icon ui-icon-alert" style="input: left; margin-right: .3em;"></span>
                        Incorrect email or password.
                    </p>
                </div>
                </div>
                ';
            } elseif ($_GET['error'] == "inactive") {

            }
        }
        if (isset($_GET['success'])) {
            print '
            <div class="col-1">
            <div class="ui-state-success ui-icon-white ui-corner-all" style="padding: .5em;">
                <p style="margin: 0">
                    <span class="ui-icon ui-icon-check" style="input: left; margin-right: .3em;"></span>
                    Account created successfully.
                </p>
            </div>
            </div>
            ';
        }
        ?>

        <div class="col-1 input-container-container">
            <div class="input-container" id="input-container">
                <label for="email">Email Address</label>
                <input type="email" name="email" id="email"  data-placeholder="" autocomplete="email" oninvalid="this.setCustomValidity('Please enter your valid email address')" oninput="this.setCustomValidity('')" required>
            </div>
        </div>

        <div class="col-1 input-container-container">
            <div class="input-container" id="input-container">
                <label for="password">Password</label>
                <input type="password" name="password" id="password"  data-placeholder="" autocomplete="current-password" oninvalid="this.setCustomValidity('Please enter your password')" oninput="this.setCustomValidity('')" required>
            </div>
        </div>

        <div class="col-1-2 no-pad-bottom">
            <a href="signup.php">
                <input type=button class="createaccount" value="Create Account">
            </a>
        </div>
        
        <div class="col-1-2">
            <input type="submit" value="Sign In">
        </div>   
    </form>
</div>
<script src="js/input-float.js"></script>



<?php
    require ('private/incFooter.php');
?>