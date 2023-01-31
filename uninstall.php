<?php 

if (!defined('WP_UNINSTALL_PLUGIN')) {
    die;
}

global $wpdb,$table_prefix;
    $wp_invoices = $table_prefix.'c_bit_invoices';
    $wp_orders   = $table_prefix.'c_bit_orders';
    $wp_payments = $table_prefix.'c_bit_payments';
    $wp_products = $table_prefix.'c_bit_products';
    $wp_c_bit_api = $table_prefix.'c_bit_api';

$qry1 = "DROP TABLE $wp_invoices";
$wpdb->query($qry1);

$qry2 = "DROP TABLE $wp_orders";
$wpdb->query($qry2);

$qry3 = "DROP TABLE $wp_payments";
$wpdb->query($qry3);

$qry4 = "DROP TABLE $wp_products";
$wpdb->query($qry4);

$qry5 = "DROP TABLE $wp_c_bit_api";
$wpdb->query($qry5);

 ?>