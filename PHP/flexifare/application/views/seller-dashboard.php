
<?php 
if(isset($get_seller_data)){ ?>  
		<div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2>Your Plans</h2>
                </div>
                <div class="col-lg-2">
				</div>
         </div>
       
		<div class="wrapper wrapper-content animated fadeInRight">
           		<div class="row">
                <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Basic Data Tables example with responsive plugin</h5>
                    </div>
                    <div class="ibox-content">

                    <table class="table table-striped table-bordered table-hover dataTables-example" >
                    <thead>
                    <tr>
                        <th>Plan Name</th>
                        <th>Plan Summary</th>
                        <th>Account Details</th>
                        <th>Date</th>
                        <th>Edit/Delete</th>
                    </tr>
                    </thead>
                    <tbody>
						
					<?php foreach( $get_seller_data as $get_sell_data ){ ?>
                    <tr class="gradeX">
                        <td><?php echo $get_sell_data->plan_name; ?></td>
                        <td>
							<?php 
								if (strlen($get_sell_data->plan_summary) > 50){
									echo substr($get_sell_data->plan_summary, 0, 50)."....";
								}else{
									echo $get_sell_data->plan_summary;
								}																		
							?>
						</td>
                        <!--td><!--?php 
							if(isset($get_sell_data->plan_details)){
								$unserial_data = unserialize(base64_decode($get_sell_data->plan_details));
								foreach( $unserial_data as $unserial_val ){
									echo $unserial_val.'<br/>';
								}
							}
							?>
						</td-->
                        <td class="center">
							<?php 
								if(!empty($get_sell_data->paypal_address) && empty($get_sell_data->card_detail)){
									echo '<span style="display:block;font-weight:bold;">Paypal Address</span>';
									echo $get_sell_data->paypal_address;
								}elseif(!empty($get_sell_data->card_detail) && empty($get_sell_data->paypal_address)){
									$explde_data = explode(", ",$get_sell_data->card_detail);
									echo '<span style="display:block;font-weight:bold;">Card Details</span>';
									echo substr_replace($explde_data[0],"xxxx-xxxx-xxxx-",0,12).'<br/>';
									echo $explde_data[1].'<br/>';
									echo $explde_data[2].'<br/>';
									echo $explde_data[3].'<br/>';
									echo $explde_data[4];
								}elseif( (!empty($get_sell_data->paypal_address)) && (!empty($get_sell_data->card_detail)) ){
									echo '<span style="display:block;font-weight:bold;">Paypal Address</span>';
									echo $get_sell_data->paypal_address.'<br/>';
									$explde_data = explode(", ",$get_sell_data->card_detail);
									echo '<span style="display:block;font-weight:bold;">Card Details</span>';
									echo substr_replace($explde_data[0],"xxxx-xxxx-xxxx-",0,12).'<br/>';
									echo $explde_data[1].'<br/>';
									echo $explde_data[2].'<br/>';
									echo $explde_data[3].'<br/>';
									echo $explde_data[4];
								} 
							?>
						</td>
                        <td class="center"><?php echo $get_sell_data->date; ?></td>
						<td class="center">
							<a href="<?php echo base_url(); ?>SellerDashboard/AddSellerPlan?seller_plan_id=<?php echo $get_sell_data->seller_plan_id; ?>">Edit</a> --
							<a href="<?php echo base_url(); ?>SellerDashboard/DeleteSellerPlan?seller_plan_id=<?php echo $get_sell_data->seller_plan_id; ?>">Delete</a>
						</td>
                    </tr>
					<?php }  ?>
					
                    </tbody>
                    <tfoot>
                    <tr>
                        <th>Plan Name</th>
                        <th>Plan Summary</th>
                        <th>Account Details</th>
                        <th>Date</th>
                        <th>Edit/Delete</th>
                    </tr>
                    </tfoot>
                    </table>

                    </div>
                </div>
            </div>
            </div>
         </div>
<?php }else{ ?>
		<div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2>No Plan Added</h2>
                </div>
                <div class="col-lg-2">
				</div>
         </div>
<?php } ?>
    
