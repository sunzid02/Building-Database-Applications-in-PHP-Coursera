<?php
    session_start();
    if ( !isset($_SESSION['name']) ) 
    {
        die("ACCESS DENIED");
        
    }
    
    require_once('db.php');
    

    // If the user requested logout go back to index.php
    if ( isset($_POST['cancel']) ) 
    {

        header('Location: index.php');
        return;
    }

    // after form submit
    if ( isset($_POST['make']) &&  isset($_POST['model']) &&  isset($_POST['year']) &&  isset($_POST['mileage']) )
    {
        if ( strlen($_POST['make']) < 1 || strlen($_POST['model']) < 1 || strlen($_POST['year']) < 1 || strlen($_POST['mileage']) < 1 ) 
        {
            $_SESSION['error'] = "All fields are required";

            header("Location: add.php");
            return;            

        }
        elseif (  !is_numeric($_POST['year']) ) 
        {
            $_SESSION['error'] = 'Year must be an integer';

            header("Location: add.php");
            return;            
        }
        elseif (  !is_numeric($_POST['mileage']) ) 
        {
            $_SESSION['error'] = 'Year must be an integer';

            header("Location: add.php");
            return;            
        }
        else 
        {
            // echo "<pre>";
            // print_r($_POST);
            // die();

            $stmt = $pdo->prepare('INSERT INTO autos (make, model,year, mileage) VALUES ( :mk, :mdl, :yr, :mi)');

            $stmt->execute(
                        array(
                            ':mk' => $_POST['make'],
                            ':mdl' => $_POST['model'],
                            ':yr' => $_POST['year'],
                            ':mi' =>  $_POST['mileage']
                        )
            );


            $_SESSION['success'] = "Record added";
            header("Location: index.php");
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
                <h1>Tracking Autos for <?= $_SESSION['name'] ?> </h1>
                <br>
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
                    <label>Make:
                        <input type="text" name="make" size="60" class="form-control"/>
                    </label><br>

                    <label>Model:
                        <input type="text" name="model" size="60"  class="form-control"/>
                    </label><br>

                    <label>Year:
                        <input type="text" name="year" class="form-control"/>
                    </label><br>

                    <label>Mileage:
                        <input type="text" name="mileage" class="form-control"/>
                    </label><br>
                    <br><br>

                    <input type="submit" value="Add" class="btn btn-success"> 
                    <input type="submit" name="cancel" value="Cancel" class="btn btn-warning">
                </form>


                    

            </div>
        </body>
</html>
