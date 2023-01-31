<?php
    // Blockonmics API stuff
    $apikey = " ".API." ";
    $url = " ".API_URL." ";
    
    $options = array( 
        'http' => array(
            'header'  => 'Authorization: Bearer '.$apikey,
            'method'  => 'POST',
            'content' => '',
            'ignore_errors' => true
        )   
    );

?>