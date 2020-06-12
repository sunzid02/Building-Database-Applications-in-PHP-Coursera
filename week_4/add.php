<?php
    session_start();
    if ( !isset($_SESSION['name']) ) 
    {
        die('Not logged in');
        
    }
    
    require_once('db.php');

    

    // If the user requested logout go back to index.php
    if ( isset($_POST['cancel']) ) 
    {

        header('Location: view.php');
        return;
    }

    // after form submit
    if ( isset($_POST['make']) &&  isset($_POST['year']) &&  isset($_POST['mileage']) )
    {
        if ( strlen($_POST['make']) < 1  ) 
        {
            $_SESSION['error'] = "Make is required";

            header("Location: add.php");
            return;            

        }
        elseif ( !is_numeric($_POST['year']) || !is_numeric($_POST['mileage']) ) 
        {
            $_SESSION['error'] = 'Mileage and year must be numeric';

            header("Location: add.php");
            return;            
        }
        else 
        {
            // echo "<pre>";
            // print_r($_POST);
            // die();

            $stmt = $pdo->prepare('INSERT INTO autos (make, year, mileage) VALUES ( :mk, :yr, :mi)');

            $stmt->execute(
                        array(
                            ':mk' => htmlentities($_POST['make']),
                            ':yr' => htmlentities($_POST['year']),
                            ':mi' => htmlentities( $_POST['mileage']) 
                        )
            );


            $_SESSION['success'] = "Record inserted";
            header("Location: view.php");
            return;
            
        }

    } 
    
        
    


?>


<!DOCTYPE html>
    <html>
        <head>
            <title>Sarker Sunzid Mahmud</title>
            <?php require_once "bootstrap.php"; ?>
        </head>

        <body>
            <div class="container">
                <h1>Tracking Autos for </h1>
                
                <?php
                    // Note triple not equals and think how badly double
                    // not equals would work here...
                    if ( isset($_SESSION['error'] ) ) 
                    {
                        // Look closely at the use of single and double quotes
                        echo('<p style="color: red;">'.htmlentities($_SESSION['error'])."</p>\n");
                        unset( $_SESSION['error'] );
                    }
                ?>

                <!-- <p style="color: green;">Record inserted</p> -->
                <form method="post">
                    <p>Make:
                        <input type="text" name="make" size="60"/>
                    </p>
                    <p>Year:
                        <input type="text" name="year"/>
                    </p>
                    <p>Mileage:
                        <input type="text" name="mileage"/>
                    </p>
                    <input type="submit" value="Add">
                    <input type="submit" name="cancel" value="cancel">
                </form>


                    

            </div>
        </body>
</html>
