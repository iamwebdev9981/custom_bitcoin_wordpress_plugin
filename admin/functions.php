<?php 

include_once "config.php";


function getIp2(){
    if(!empty($_SERVER['HTTP_CLIENT_IP'])){
        //ip from share internet
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    }elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
        //ip pass from proxy
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    }else{
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}

function getProduct2($id){
    global $wpdb,$table_prefix;
    $wp_products  = $table_prefix.'c_bit_products';

    $result = $wpdb->get_row("SELECT * FROM $wp_products WHERE id='".$id."' ");
    $name =  $result->name;

    return $name;
}



 ?>