<?php get_header();

include_once('header.php');

global $wpdb,$table_prefix;
$wp_c_bit_api = $table_prefix.'c_bit_api';
$wp_products  = $table_prefix.'c_bit_products';
$result = $wpdb->get_results("SELECT * FROM $wp_c_bit_api");

 ?>


 <div class="container m-5 ">
 	<div class="row">
 		<div class="col-sm-12 col-lg-8 col-md-8 offset-lg-2 offset-md-2">
 			<div class="container-fluid p-0 mt-5 test-payment-container  border rounded p-5 bg-white shadow-sm"> 
				<h5 class="mb-4">Test Payment</h5>
				<div class="table-responsive">
					<table class="table table-bordered ">
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
								<td class="text-primary font-weight-bold">$<?php echo $value->price ?></td>
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
 	</div>
 </div>



<?php get_footer(); ?>