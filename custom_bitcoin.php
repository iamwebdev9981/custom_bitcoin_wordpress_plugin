<?php 
/*
 *
 * Plugin Name: Truamore Payment Gateway
 * Plugin URI: http://localhost/
 * Description: Accept Cryptocurrency Payments.
 * Version: 1.0.0
 * Author: GMS
 * Author URI: http://localhost/
 * © 2023 All rights reserved.
 *
 */

   define('BITCOIN_WP', true);
   define('PLUGINS_DIR_PATH',plugin_dir_path(__FILE__));
   define('HOME_URL',home_url());
   define('ADMIN_URL',get_admin_url());
   define('plugins_url', plugins_url());
   define('C_BITCOIN_URL', plugins_url.'/custom-bitcoin/');


    global $wpdb,$table_prefix;  
    $wp_c_bit_api = $table_prefix.'c_bit_api';
    @$result = $wpdb->get_results("SELECT * FROM $wp_c_bit_api");
    @$fetch_apikey  = $result[0]->api;
    define('API',@$fetch_apikey);
    define('API_URL','https://www.blockonomics.co/api/');
 
   


/*
 * ----------------------------------------------------------
 * # FOR SECURITY
 * ----------------------------------------------------------
 */

   if(!defined('ABSPATH')){
      header("Location:".HOME_URL."/");
   }

   
   function c_bitcoin_plugin_activate(){
   global $wpdb,$table_prefix;
    $wp_invoices  = $table_prefix.'c_bit_invoices';
    $wp_orders    = $table_prefix.'c_bit_orders';
    $wp_payments  = $table_prefix.'c_bit_payments';
    $wp_products  = $table_prefix.'c_bit_products';
    $wp_c_bit_api = $table_prefix.'c_bit_api';


  // Table structure for table `invoices`
  
  $qry1 = "CREATE TABLE IF NOT EXISTS $wp_invoices(`id` INT NOT NULL AUTO_INCREMENT , `code` VARCHAR(255) NOT NULL , `address` VARCHAR(255) NOT NULL , `price` DOUBLE NOT NULL , `status` INT NOT NULL , `product` INT NOT NULL , `ip` VARCHAR(255) NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB DEFAULT CHARSET=latin1;";
  $wpdb->query($qry1);


  /*Table structure for table `orders`*/

  $qry2 = "CREATE TABLE IF NOT EXISTS $wp_orders(`id` INT NOT NULL AUTO_INCREMENT , `invoice` VARCHAR(255) NOT NULL , `ip` VARCHAR(255) NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB DEFAULT CHARSET=latin1;";
  $wpdb->query($qry2);


  /*Table structure for table `payments`*/

  $qry3 = "CREATE TABLE IF NOT EXISTS $wp_payments(`id` INT NOT NULL AUTO_INCREMENT , `txid` VARCHAR(255) NOT NULL , `addr` VARCHAR(255) NOT NULL , `value` INT NOT NULL , `status` INT NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB DEFAULT CHARSET=latin1;";
  $wpdb->query($qry3);


  // Table structure for table `products`

  $qry4 = "CREATE TABLE IF NOT EXISTS $wp_products(`id` INT NOT NULL AUTO_INCREMENT , `name` VARCHAR(255) NOT NULL , `description` LONGTEXT NOT NULL , `price` FLOAT(10,2) NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB DEFAULT CHARSET=latin1;";
  $wpdb->query($qry4);

    // Table structure for table `products`

  $qry5 = "CREATE TABLE IF NOT EXISTS $wp_c_bit_api(`id` INT NOT NULL AUTO_INCREMENT , `api` VARCHAR(255) NOT NULL , `add_on` TIMESTAMP NOT NULL , `status` INT NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB DEFAULT CHARSET=latin1;";
  $wpdb->query($qry5);

   $data1 = array(
   'name' => 'Premium',
   'description' => 'Premium membership for the site',
   'price' => 40.00
   );
   $wpdb->insert($wp_products, $data1);


   $data2 = array(
   'name' => 'Premium',
   'description' => 'Premium+ membership for the site',
   'price' => 50.00
   );
   $wpdb->insert($wp_products, $data2);

}
register_activation_hook(__FILE__, 'c_bitcoin_plugin_activate');


function c_bitcoin_plugin_deactivation(){
   global $wpdb,$table_prefix;
    $wp_invoices = $table_prefix.'c_bit_invoices';
    $wp_orders   = $table_prefix.'c_bit_orders';
    $wp_payments = $table_prefix.'c_bit_payments';
    $wp_products = $table_prefix.'c_bit_products';
    $wp_c_bit_api = $table_prefix.'c_bit_api';

    $qry1 = "TRUNCATE $wp_invoices";
    $wpdb->query($qry1);

    $qry2 = "TRUNCATE $wp_orders";
    $wpdb->query($qry2);

    $qry3 = "TRUNCATE $wp_payments";
    $wpdb->query($qry3);

    $qry4 = "TRUNCATE $wp_products";
    $wpdb->query($qry4);

    $qry5 = "TRUNCATE $wp_c_bit_api";
    $wpdb->query($qry5);
}
register_deactivation_hook(__FILE__, 'c_bitcoin_plugin_deactivation'); 


/*
 * ----------------------------------------------------------
 * # ADMIN AREA
 * ----------------------------------------------------------
 *
 * Display the administration area and the nav menu
 *
 */





function custom_bitcoin_admin_menu() {

   add_menu_page( 'Bitcoin', 'Truamore Pay', 'read', 'Bitcoin',  'custom_bitcoin_admin_action',C_BITCOIN_URL . 'media/bitcoin_icon.svg');
   add_submenu_page('Bitcoin', 'Settings', 'Buy', 'manage_options', 'buy', 'custom_bitcoin_admin_buy_action');
   add_submenu_page('Bitcoin', 'Settings', 'invoice', 'manage_options', 'invoice', 'custom_bitcoin_admin_invoice_action');
}

function custom_bitcoin_admin_action(){
   include('admin/dashboard.php');
}

function custom_bitcoin_admin_buy_action(){
   include('admin/buy.php');
}

function custom_bitcoin_admin_invoice_action(){
   include('admin/invoice.php');
}


add_action('admin_menu', 'custom_bitcoin_admin_menu');


 ?>