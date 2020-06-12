<?php 

    if ( !isset( $_COOKIE['zap'] ) ) 
    {
        setcookie('zap', 42, time()+3600 );
    }
    
    echo "<pre>";
    print_r($_COOKIE);

?>