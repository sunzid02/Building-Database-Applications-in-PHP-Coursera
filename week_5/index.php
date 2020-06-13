<?php
    require_once('db.php');
    session_start();
?>

<!DOCTYPE html>
<html>
<head>
<title>Sarker Sunzid Mahmud</title>

<?php require_once "bootstrap.php"; ?>

</head>
    <body>

        <div class="container">
            <h1 style="text-align:center; margin-bottom: 50px" >Welcome to the Automobiles Database</h1>
            <?php
                ////flash messages
                if (isset($_SESSION['error'] ) ) 
                {
                    echo '<p style="color:red">'.$_SESSION['error']."</p>\n";
                    unset($_SESSION['error']);
                }
                if (isset($_SESSION['success'] ) ) 
                {
                    echo '<p style="color:green">'.$_SESSION['success']."</p>\n";
                    unset($_SESSION['success']);

                }
                        
            ?>

            <?php 
                if (!isset($_SESSION['name'])) 
                {                 
            ?>    
                    <p>
                        <a href="login.php">Please log in</a>
                    </p>


                    <p>
                        Attempt to go to 
                        <a href="add.php">add data</a> without logging in - it should fail with an error message.
                    </p>

            <?php
               }
               else
               {

                   
                   $stmt = $pdo->query('select * from autos');  
                //    echo "<pre>";
                //    print_r( $stmt->rowCount() );  

                   if ( $stmt->rowCount() == 0)  
                   {
                       echo " No rows found <br><br>";
                   } 
                    else 
                    {
                       echo('<table class="table">'."\n");
                       
                       echo('<thead class="thead-dark">'."\n");

                        echo('<tr>'."\n");
                            echo('<th scope="col"> Make </th>'."\n");
                            echo('<th scope="col"> Model </th>'."\n");
                            echo('<th scope="col"> Year </th>'."\n");
                            echo('<th scope="col"> Mileage </th>'."\n");
                            echo('<th scope="col"> Action </th>'."\n");
                        echo('</tr>'."\n");
                       echo('</thead>'."\n");

                       echo('<tbody>'."\n");
                           while( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) 
                           {
                               echo '<tr scope="row">';
                               
                                   echo '<td>';
                                       echo htmlentities( $row['make'] );
                                   echo '</td>';

                                   echo '<td>';
                                       echo htmlentities( $row['model'] );
                                   echo '</td>';
        
                                   echo '<td>';
                                       echo htmlentities( $row['year'] );
                                   echo '</td>';
        
                                   echo '<td>';
                                       echo htmlentities( $row['mileage'] );
                                   echo '</td>';
        
                                   echo '<td>';
                                       echo '<a class="btn btn-warning" href="edit.php?autos_id='.$row['auto_id'].'"> Edit </a> / ';
        
                                       echo '<a class="btn btn-danger" href="delete.php?autos_id='.$row['auto_id'].'"> Delete </a>  ';
                                   echo '</td>';
        
                               echo '<tr>';
                           }  
                        echo('</tbody>'."\n");

                       echo '</table>';
                       echo '<br>';
                   }

            ?>        
                <a href="add.php" class="btn btn-success">Add New Entry</a> 
                <br>
                <br>

                <a href="logout.php" class="btn btn-success">logout</a>       
            <?php 
               }
            ?>          



        </div>        

   
            