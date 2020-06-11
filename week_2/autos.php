<?php
    // Demand a GET parameter
    if ( ! isset($_GET['name']) || strlen($_GET['name']) < 1  ) {
        die('Name parameter missing');
    }

    require_once('db.php');

    $failure = false;  // If we have no POST data
    $record = false;  // If we have no POST data
    

    // If the user requested logout go back to index.php
    if ( isset($_POST['logout']) ) 
    {

        header('Location: index.php');
        return;
    }

    // after form submit
    if ( isset($_POST['make']) &&  isset($_POST['year']) &&  isset($_POST['mileage']) )
    {
        if ( strlen($_POST['make']) < 1  ) 
        {
            $failure = "Make is required";
            
        }
        elseif ( !is_numeric($_POST['year']) || !is_numeric($_POST['mileage']) ) 
        {
            $failure = 'Mileage and year must be numeric';
        }
        else 
        {
            // echo "<pre>";
            // print_r($_POST);
            // die();

            $stmt = $pdo->prepare('INSERT INTO autos (make, year, mileage) VALUES ( :mk, :yr, :mi)');

            $stmt->execute(array(
                ':mk' => $_POST['make'],
                ':yr' => $_POST['year'],
                ':mi' => $_POST['mileage'])
            );

            $record = 'Record inserted';
            
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
                    if ( $failure !== false ) 
                    {
                        // Look closely at the use of single and double quotes
                        echo('<p style="color: red;">'.htmlentities($failure)."</p>\n");
                    }
                    if ( $record !== false ) 
                    {
                        // Look closely at the use of single and double quotes
                        echo('<p style="color: green;">'.htmlentities($record)."</p>\n");
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
                    <input type="submit" name="logout" value="Logout">
                </form>

                    <h2>Automobiles</h2>
                    <?php 

                        $stmt = $pdo->query('select * from autos');                    

                        echo "<ul>"; 
                        $i=0;
                        while( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) 
                        {
                            ++$i;
                            if ($i==1) 
                            {
                                echo "<li>".$row["year"]." "."&lt;b&gt;".$row["make"]." / ".$row["mileage"]."</li>";
                            }
                            else 
                            {
                                echo "<li>".$row["year"]." ".$row["make"]." / ".$row["mileage"]."</li>";
                                # code...
                            }
                        }
                        echo "</ul>"; 
                    
                    ?>

                    

            </div>
        </body>
</html>
