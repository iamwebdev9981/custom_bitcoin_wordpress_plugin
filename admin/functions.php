<?php
/*
This page defines a number of functions to make the code on other pages more readable
*/

include_once "config.php";


function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function generateAddress(){
     $apikey = API;
     $url = API_URL;
    $options = array( 
        'http' => array(
            'header'  => 'Authorization: Bearer '.$apikey,
            'method'  => 'POST',
            'content' => '',
            'ignore_errors' => true
        )   
    );  
    
    $context = stream_context_create($options);
    $contents = file_get_contents($url."new_address", false, $context);
    $object = json_decode($contents);
    
    // Check if address was generated successfully
    if (isset($object->address)) {
      $address = $object->address;
    } else {
      // Show any possible errors
      $address = $http_response_header[0]."\n".$contents;
    }
    return $address;
}

function createInvoice($product, $price){
    global $wpdb,$table_prefix;
    $wp_invoices  = $table_prefix.'c_bit_invoices';

    $code = generateRandomString(25);
    $address = generateAddress();
    $status = -1;
    $ip = getIp();

    $sql = $wpdb->prepare(
    "INSERT INTO $wp_invoices(`code`, `address`, `price`, `status`, `product`,`ip`)
    VALUES ('$code', '$address', '$price', '$status', '$product', '$ip')");
    $wpdb->query($sql);
    return $code;
}

function getProduct($id){
    global $wpdb,$table_prefix;
    $wp_products  = $table_prefix.'c_bit_products';

    $result = $wpdb->get_row("SELECT * FROM $wp_products WHERE id='".$id."' ");
    $name =  $result->name;

    return $name;
}

function getPrice($id){
    global $wpdb,$table_prefix;
    $wp_products  = $table_prefix.'c_bit_products';
    
    echo $id;
    $result = $wpdb->get_row("SELECT * FROM $wp_products WHERE id='".$id."' ");
    $price =  $result->price;

    return $price;
}

function getAddress($code){
    global $wpdb,$table_prefix;
    $wp_invoices  = $table_prefix.'c_bit_invoices';

    $result = $wpdb->get_row("SELECT * FROM $wp_invoices WHERE code='".$code."' ");
    $address =  $result->address;

    return $address;
}

function getStatus($code){
    global $wpdb,$table_prefix;
    $wp_invoices  = $table_prefix.'c_bit_invoices';

    $result = $wpdb->get_row("SELECT * FROM $wp_invoices WHERE code='".$code."' ");
    $status = "Error, try again";
    $status =  $result->status;

    return $status;
}

function getInvoiceProduct($code){
    global $wpdb,$table_prefix;
    $wp_invoices  = $table_prefix.'c_bit_invoices';

    $result = $wpdb->get_row("SELECT * FROM $wp_invoices WHERE code='".$code."' ");
    $product = "Error, try again";
    $product =  $result->product;

    return $product;
}

function getInvoicePrice($code){
    global $wpdb,$table_prefix;
    $wp_invoices  = $table_prefix.'c_bit_invoices';

    $result = $wpdb->get_row("SELECT * FROM $wp_invoices WHERE code='".$code."' ");
    $price = "Error, try again";
    $price =  $result->price;

    return $price;
}

function GetCode($address){
    global $wpdb,$table_prefix;
    $wp_invoices  = $table_prefix.'c_bit_invoices';

    $result = $wpdb->get_row("SELECT * FROM $wp_invoices WHERE address='".$address."' ");
    $code = "Error, try again";
    $code =  $result->code;
   
    return $code;
}

function getDescription($product){
    global $wpdb,$table_prefix;
    $wp_products  = $table_prefix.'c_bit_products';
    
    $result = $wpdb->get_row("SELECT * FROM $wp_products WHERE id='".$product."' ");
    $description = "Error, try again";
    $description =  $result->description;

    return $description;
}

function updateInvoiceStatus($code, $status){
    global $wpdb,$table_prefix;
    $wp_invoices  = $table_prefix.'c_bit_invoices';

    $sql =  $wpdb->update($wp_invoices, array('status'=>$status) ,array('code'=>$code));

}

function getBTCPrice($currency){
    $content = file_get_contents("https://www.blockonomics.co/api/price?currency=".$currency);
    $content = json_decode($content);
    $price = $content->price;
    return $price;
}

function BTCtoUSD($amount){
    $price = getBTCPrice("USD");
    return $amount * $price;
}

function USDtoBTC($amount){
    $price = getBTCPrice("USD");
    return $amount/$price;
}

function getInvoice($addr){
    global $wpdb,$table_prefix;
    $wp_invoices  = $table_prefix.'c_bit_invoices';

    $result = $wpdb->get_row("SELECT * FROM $wp_invoices WHERE address='".$addr."' ");
    $invoice = "Error, try again";
    $invoice =  $result->code;

    return $invoice;
}

function getIp(){
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

function createOrder($invoice, $ip){
    global $wpdb,$table_prefix;
    $wp_orders    = $table_prefix.'c_bit_orders';


    $sql = $wpdb->prepare(
    "INSERT INTO $wp_orders(`invoice`,`ip`)VALUES ('$invoice', '$ip')");
    $wpdb->query($sql);
}

function getInvoiceIp($addr){
    global $wpdb,$table_prefix;
    $wp_invoices  = $table_prefix.'c_bit_invoices';

    $result = $wpdb->get_row("SELECT * FROM $wp_invoices WHERE address='".$addr."' ");
    $ip = "Error, try again";

    foreach ($result as $row){
      $ip =  $row->ip;
    }

    return $ip;
}
?>