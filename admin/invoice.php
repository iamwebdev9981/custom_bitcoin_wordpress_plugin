<?php
/*
Payment page

This code is designed to be easily understandable at the expense of speed, 
for large productions this can be done with one sql request, instead of several

*/
include_once "header.php";
include_once "config.php";
include_once "functions.php";
// Check code
if(!isset($_GET['code'])){
    exit();
}
$code = sanitize_text_field( $_GET['code']);
// Get invoice information
$address = getAddress($code);

$product = getInvoiceProduct($code);

$status = getStatus($code);

$price = getInvoicePrice($code);

// Status translation

$statusval = $status;
$info = "";
if($status == 0){
    $status = "<span style='color: orangered' id='status'>PENDING</span>";
    $info = "<p>You payment has been received. Invoice will be marked paid on two blockchain confirmations.</p>";
}else if($status == 1){
    $status = "<span style='color: orangered' id='status'>PENDING</span>";
    $info = "<p>You payment has been received. Invoice will be marked paid on two blockchain confirmations.</p>";
}else if($status == 2){
    $status = "<span style='color: green' id='status'>PAID</span>";
}else if($status == -1){
    $status = "<span style='color: red' id='status'>UNPAID</span>";
}else if($status == -2){
    $status = "<span style='color: red' id='status'>Too little paid, please pay the rest.</span>";
}else {
    $status = "<span style='color: red' id='status'>Error, expired</span>";
}


?>


<div class="container p-5  m-5">
    <!-- Invoice -->
    
<main class="">
    <div class="row">
        <div class="col-sm-12 col-lg-8 col-md-8">
            <div class="pay-box-main border rounded shadow-sm">
            <h3 style="width:100%;">Truamore Pay</h3>
            <p style="display:block;width:100%;">Please pay <?php echo round(USDtoBTC($price), 8); ?> BTC to address: <span id="address"><?php echo $address; ?></span></p>
            <div class="row">
                <div class="col-sm-12 col-lg-6 col-md-6 col-left">
                    <?php
                    // QR code generation using google apis
                    $cht = "qr";
                    $chs = "300x300";
                    $chl = $address;
                    $choe = "UTF-8";
                    $qrcode = 'https://chart.googleapis.com/chart?cht=' . $cht . '&chs=' . $chs . '&chl=' . $chl . '&choe=' . $choe;
                    ?>
                    <div class="qr-hold">
                        <img src="<?php echo $qrcode ?>" alt="My QR code" style="width:250px;">
                    </div>
                    <p style="display:block;width:100%;">Status: <?php echo $status; ?></p>
                </div>
                <div class="col-sm-12 col-lg-6 col-md-6 col-right">
                    <?php echo $info; ?>
                    <div id="info"></div>
                    <div class="invoice-logo-box">
                        <img src="<?php echo C_BITCOIN_URL . 'media/truamore_logo.png'; ?>" alt="">
                    </div>
                    <h6 >Truamore Membership</h6>
                    <p style="width:100%;margin-top: 20px;"><?php echo getProduct($product); ?></p>
                    <p><?php echo getDescription($product); ?></p>
                </div>
            </div>
            </div>
        </div>

        <div class="col-sm-12 col-lg-4 col-md-4">
            
        </div>
        
        
    </div>
</main>
    <script>
        var status = <?php echo $statusval; ?>
        
        // Create socket variables
        if(status < 2 && status != -2){
        var addr =  document.getElementById("address").innerHTML;
        var wsuri2 = "wss://www.blockonomics.co/payment/"+ addr;
        // Create socket and monitor
        var socket = new WebSocket(wsuri2, "protocolOne")
            socket.onmessage = function(event){
                console.log(event.data);
                response = JSON.parse(event.data);
                //Refresh page if payment moved up one status
                if (response.status > status)
                  setTimeout(function(){ window.location=window.location }, 1000);
            }
        }
        
    </script>
</div>



<?php include_once "footer.php";  ?>