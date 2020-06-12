<?php
    session_start();
    if ( !isset($_SESSION['name']) ) 
    {
        die('Not logged in');
        
    }
    require_once('db.php');
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
                    if ( isset($_SESSION['success'] ) ) 
                    {
                        echo('<p style="color: green;">'.htmlentities($_SESSION['success'])."</p>\n");
                        unset( $_SESSION['success'] );
                    }
                ?>

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

                    <p>
                        <a href="add.php">Add New</a> |
                        <a href="logout.php">Logout</a>
                    </p>
                
            </div>
        </body>
</html>
