<?php
    // Demand a GET parameter
    if ( ! isset($_GET['name']) || strlen($_GET['name']) < 1  ) {
        die('Name parameter missing');
    }

    $pdo = new PDO('mysql:host=localhost;port=3306;dbname=misc',
                    'root','');

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);                
    