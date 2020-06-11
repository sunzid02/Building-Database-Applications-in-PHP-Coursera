<?php

    $pdo = new PDO('mysql:host=localhost;port=3306;dbname=music',
                    'root','');

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);                
    
    
    try 
    {
        $stmt = $pdo->query('select * from userss');                    
        echo "<pre>";
        while( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) 
        {
            print_r($row);        
        }
        echo "</pre>";
    } 
    catch (Exception $e) {
        echo "<pre>";
        echo 'Please contact admin';
        error_log('db.php, SQL error='.$e->getMessage() );
    }

