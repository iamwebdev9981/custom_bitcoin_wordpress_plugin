<?php 
include('header.php');
include_once "config.php";
include_once "functions.php";


global $wpdb,$table_prefix;  
    $wp_c_bit_api = $table_prefix.'c_bit_api';
    $wp_products  = $table_prefix.'c_bit_products';
    @$result = $wpdb->get_results("SELECT * FROM $wp_c_bit_api");
    @$f_api  = $result[0]->api;
    @$f_id  = $result[0]->id;

if (isset($_POST['submit'])) {
	 $api_key = $_POST['api_key'];
     
     if($api_key == ''){
     	$err_msg = "Pleas Enter Your Api Key.";
     }else{
        $res = $wpdb->get_row("SELECT * FROM $wp_c_bit_api WHERE api='".$api_key."' ");
        @$f_api_key  = $res->api;
        
        if($f_api_key == $api_key){
        	$err_msg = "Api key already Exist.";
        }else{
        	$data = array('api'=>$api_key);
	     	if($wpdb->insert($wp_c_bit_api, $data)){
	           $success_msg = "API Key Added Successfully.";
               echo'<meta http-equiv="refresh" content="3">';
	     	}else{
	     		$err_msg = "insert Query Failed.";
	     	}
        }	
    }
}

// Code for remove api kay
 if(isset($_POST['del_api'])){
 	$query = $wpdb->delete( $wp_c_bit_api, array( 'id' => $f_id ));

 	if($query){
 		$err_msg = "Api Key Removing...";
 		echo'<meta http-equiv="refresh" content="3">';
      }else{
      	$err_msg = "Delete Query Failed.";
      }
 }

 
 ?>



<div class="container p-4">
<div class="container-fluid p-0">
	<div class="logo-box">
		<h3><span class="logo_text">T</span><span class="trua-text">RUAMORE </span><span class="pay-text">PAYMENT</span></h3>
	</div>
	<hr>
</div>

<span class="text-success font-weight-bold"><?php if(isset($success_msg)){echo $success_msg;}; ?></span>
<span class="text-danger font-weight-bold"><?php if(isset($err_msg)){echo $err_msg;}; ?></span>
<div class="row ">
	<div class="col-sm-12 col-lg-6 col-md-6">
		<form action="" method="post" class="mt-4">
			
		<div class="input-group ">
		  <input type="text" class="form-control <?php if(isset($f_api)){echo 'text-success border border-success';} ?> <?php if(isset($err_msg)){echo "border border-danger";} ?>" placeholder="Enter your blockonomics API key" aria-label="Recipient's username" aria-describedby="button-addon2" name="api_key" value="<?php if(isset($f_api)){echo $f_api;} ?>" <?php if(isset($f_api)){echo 'disabled';} ?>>
		  <input type="submit" class="<?php if(isset($f_api)){echo 'btn-outline-success border border-success';}else{echo 'btn-outline-secondary';} ?> btn  shadow-none" name="submit"  id="button-addon2" <?php if(isset($f_api)){echo 'disabled';} ?> value="<?php if(isset($f_api)){echo 'Activated';}else{echo 'Activate';} ?>">
		</div>
		<div id="emailHelp" class="form-text mb-3"><i>If you do not have the key. please <a href="https://www.blockonomics.co/merchants#/" target="_blank">click</a> here to generate the key.</i></div>
		</form>
		<form action="" method="post">
			<input type="submit" style="<?php if(isset($f_api)){echo 'display:block';}else{echo 'display:none';} ?>" class="btn-danger border border-danger btn  shadow-none" name="del_api"  id="" value="Remove Api Key">
		</form>


		<div class="container-fluid p-0 mt-5 test-payment-container">
			<h5>Test Payment</h5>
			<div class="table-responsive">

			<table class="table">
				<thead>
					<tr>
						<td>ID</td>
						<td>NAME</td>
						<td>DESCRIPTION</td>
						<td>PRICE</td>
						<td>ACTION</td>
					</tr>
				</thead>
				<tbody>
				<?php 
                 $result = $wpdb->get_results("SELECT * FROM $wp_products");
                 foreach ($result as $value) { ?>
					<tr>
						<td><?php echo $value->id ?></td>
						<td><?php echo $value->name ?></td>
						<td><?php echo $value->description ?></td>
						<td class="text-primary font-weight-bold"><?php echo $value->price ?></td>
						<td>
						  <a href="admin.php?page=buy&id=<?php echo $value->id; ?>" style="text-decoration: none;" class="btn-sm border border-success btn-outline-success">Test now</a>
						</td>
					</tr>
				<?php } ?>
				</tbody>
			</table>

	</div>
		</div>
		
	</div>
	<div class="col-sm-12 col-lg-6 col-md-6">
		
	</div>
</div>



	
</div>


<?php include('footer.php') ?>