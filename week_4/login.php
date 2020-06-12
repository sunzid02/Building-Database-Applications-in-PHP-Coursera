<?php // Do not put any HTML above this line

    session_start();

    // echo phpinfo();
    if ( isset($_POST['cancel'] ) ) 
    {
        // Redirect the browser to game.php
        header("Location: index.php");
        return;
    }

    $salt = 'XyZzy12*_';

    $stored_hash = '1a52e17fa899cf40fb04cfc42e6352f1';  // Pw is php123 // // echo "<br>";$md5 = hash('md5', 'XyZzy12*_php123');




    // Check to see if we have some POST data, if we do process it
    if ( isset($_POST['email']) && isset($_POST['pass']) ) 
    {
        if ( strlen($_POST['email']) < 1 || strlen($_POST['pass']) < 1 ) 
        {
            $failure = "User name and password are required";
            $_SESSION['error'] = $failure;

            header("Location: login.php");
            return;
            
        }
        elseif ( !filter_var( $_POST['email'], FILTER_VALIDATE_EMAIL ) )  
        {
            $failure = "Email must have an at-sign (@)";
            $_SESSION['error'] = $failure;

            header("Location: login.php");
            return;
        } 
        else 
        {
            // $md5 = hash('md5', 'XyZzy12*_php123');

            $check = hash('md5', $salt.$_POST['pass']);

            $stored_hash = '1a52e17fa899cf40fb04cfc42e6352f1';  // Pw is php123

            // echo "<br>";
            // echo $md5 = hash('md5', 'XyZzy12*_php123');

            // die();

            unset( $_SESSION['name'] );
            if ( $check == $stored_hash ) 
            {
                error_log("Login success ".$_POST['email']);

                $_SESSION['name'] = $_POST['email'];

                header("Location: view.php");
                return;
            } 
            else 
            {
                error_log("Login fail ".$_POST['email']." $check");
                
                $failure = "Incorrect password";
                $_SESSION['error'] = $failure;

                header("Location: login.php");
                return;


            }
        }
    }

// Fall through into the View
?>
<!DOCTYPE html>
    <html>
    <head>
        <title> Sarker Sunzid Mahmud </title>
        <?php require_once "bootstrap.php"; ?>
    </head>

    <body>
        <div class="container">
            <h1>Please Log In</h1>
            <?php

                if ( isset( $_SESSION['error'] ) ) 
                {

                    // Look closely at the use of single and double quotes
                    echo('<p style="color: red;">'.htmlentities( $_SESSION['error'] )."</p>\n");
                    unset( $_SESSION['error'] );
                }
            ?>
            <form method="POST">

                <label for="nam">Email</label>
                <input type="text" name="email" id="nam"><br/>

                <label for="id_1723">Password</label>
                <input type="text" name="pass" id="id_1723"><br/>

                <input type="submit" value="Log In">
                <input type="submit" name="cancel" value="Cancel">

            </form>
            <p>
                <!-- For a password hint, view source and find an account and password hint in the HTML comments. -->
                <!-- Hint:
                The account is csev@umich.edu
                The password is the three character name of the
                programming language used in this class (all lower case)
                followed by 123. -->
            </p>
        </div>
    </body>