<?php
/*
Payment page

This code is designed to be easily understandable at the expense of speed, 
for large productions this can be done with one sql request, instead of several

*/
include("header.php");
include_once "config.php";
include_once "functions.php";

?>


    <!-- Invoice -->
    
    <main>
        <div class="row">
            <h1 >Previous purchases</h1>
            <?php
            $ip = getIp2();

            global $wpdb,$table_prefix;
            $wp_orders   = $table_prefix.'c_bit_orders';?>


            <div class="container-fluid p-0 mt-5 test-payment-container">
                <h5>Test Payment</h5>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <td>ID</td>
                                <td>Product</td>
                                <td>Invoice</td>
                                <td>Action</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
        $result = $wpdb->get_results('SELECT * FROM $wp_orders WHERE ip="'.$ip.'" ORDER BY id DESC');
                          foreach ($result as $value) { ?>
                            <tr>
                                <td><?php // echo $value->id ?></td>
                                <td><?php echo getProduct2(getInvoiceProduct2($value->invoice)); ?></td>
                                <td><a href="invoice.php?code=<?php echo $row['invoice']; ?>"><?php echo $value->invoice; ?></a></td>
                            </tr>
                            <?php  } ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </main>
    

    <?php include("footer.php"); ?>