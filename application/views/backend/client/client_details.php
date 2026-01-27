
<?php
   $query = $this->db->get( 'town' );
   $towns = $query->result_array();

   $client_id=$this->session->userdata('client_id');

$edit_data = $this->db->get_where( 'client', array( 'id' => $client_id ) )->result_array();
foreach ( $edit_data as $row ):
	?>
<div class="row" data-appear-animation="fadeInRight" data-appear-animation-delay="100">
    <?php echo form_open(base_url() . 'index.php?admin/client/do_update/'.$client_id , 
      array('class' => 'form-horizontal form-bordered validate'));?>
        <div class="col-md-6">
            
            <div class="panel" >
            
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <?php echo get_phrase('my_details');?>
                    </h4>
                </div>
                
                <div class="panel-body">
				<div class="form-group">
						<label class="col-md-3 control-label">
							<?php echo get_phrase('national_id');?>
						</label>
						<div class="col-md-7">
							<input type="text" class="form-control" required name="national_id" value="<?php echo $row['national_id'];?>"/>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label">
							<?php echo get_phrase('fullname');?>
						</label>
						<div class="col-md-7">
							<input type="text" class="form-control" required name="fullname" value="<?php echo $row['fullname'];?>"/>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label">
							<?php echo get_phrase('lastname');?>
						</label>
						<div class="col-md-7">
							<input type="text" class="form-control" required name="lastname" value="<?php echo $row['lastname'];?>"/>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label">
							<?php echo get_phrase('contact');?>
						</label>
						<div class="col-md-7">
							<input type="text" class="form-control" required name="contact" value="<?php echo $row['contact'];?>"/>
						</div>
					</div>	
					<div class="form-group">
						<label class="col-md-3 control-label">
							<?php echo get_phrase('organization');?>
						</label>
						<div class="col-md-7">
							<input type="text" class="form-control" required name="organization" value="<?php echo $row['organization'];?>"/>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label">
							<?php echo get_phrase('org_contact');?>
						</label>
						<div class="col-md-7">
							<input type="text" class="form-control" required name="org_contact" value="<?php echo $row['org_contact'];?>"/>
						</div>
					</div>	
					<div class="form-group">
						<label class="col-md-3 control-label">
							<?php echo get_phrase('salary');?>
						</label>
						<div class="col-md-7">
							<input type="text" class="form-control" required name="salary" value="<?php echo $row['salary'];?>"/>
						</div>
					</div>			
					<div class="form-group">
						<label class="col-md-3 control-label">
							<?php echo get_phrase('address');?>
						</label>
						<div class="col-md-7">
							<input type="text" class="form-control" required name="address" value="<?php echo $row['address'];?>"/>
						</div>
					</div>					
					
					<div class="form-group">
								<label class="col-sm-3 control-label"><?php echo get_phrase('town');?></label>
								<div class="col-sm-7">
								<select data-plugin-selectTwo class="form-control populate" name="town" onchange="class_section(this.value)" style="width: 100%">
					<?php foreach ($towns as $rowz): ?>
					<option value="<?php echo $rowz['id']; ?>" <?php if ($row['town'] == $rowz[ 'id']) echo 'selected'; ?>><?php echo $rowz['name']; ?></option>
					<?php endforeach; ?>
				</select>
								</div>
							</div>
					
					<div class="form-group">
						<label class="col-md-3 control-label">
							<?php echo get_phrase('email');?>
						</label>
						<div class="col-md-7">
							<input type="email" class="form-control" name="email" value="<?php echo $row['email'];?>"/>
						</div>
					</div>
                </div>
                
				<footer class="panel-footer">
					<div class="row">
						<div class="col-sm-9 col-sm-offset-3">
						 <button type="submit" class="btn btn-primary"><?php echo get_phrase('save');?></button>
						</div>
					</div>	
				</footer>
                <?php echo form_close();?>
            </div>
        </div>
        

      <?php 
        $skin = $this->db->get_where('settings' , array(
          'type' => 'skin_colour'
        ))->row()->description;
	
        $borders = $this->db->get_where('settings' , array(
          'type' => 'borders_style'
        ))->row()->description;
	
        $header = $this->db->get_where('settings' , array(
          'type' => 'header_colour'
        ))->row()->description;

        $sidebar_colour = $this->db->get_where('settings' , array(
          'type' => 'sidebar_colour'
        ))->row()->description;	
	
        $sidebar_size = $this->db->get_where('settings' , array(
          'type' => 'sidebar_size'
        ))->row()->description;
      ?>
    
   <div class="col-md-6">
            
	   <section class="panel">
		   <?php echo form_open(base_url() . 'index.php?admin/system_settings/change_skin');?>

			<div class="panel-heading">
			   <h4 class="panel-title">
				<?php echo get_phrase('account_details');?>
				</h4>
			</div>

			 <div class="panel-body">

				  <table class="table">
				    <thead>
				      <tr>
				        <th>Account Number</th>
				        <th>Type</th>
				        <th>Balance</th>
				        <th>option</th>
				      </tr>
				    </thead>
				    <tbody>
						<?php
						$account_data = $this->db->get_where( 'account', array( 'client_id' => $client_id ) )->result_array();
						foreach ( $account_data as $data ):
							?>
				      <tr class="success">
				         <th><?php echo $data['id']; ?></th>
				         <td><?php echo $this->db->get_where('account_type' , array('id' =>$data['type']))->row()->name; ?></td>
				        <td><?php echo $this->db->get_where('settings' , array('type' =>'currency'))->row()->description.$data['balance']; ?></td>
				        <td><a href="<?php echo base_url(); ?>index.php?admin/client_qr/<?php echo $data['id'];?>" class="btn btn-info" 
												data-original-title="<?php echo get_phrase('print_code');?>" target="_blank">
                        <i class="fa fa-print"></i> QR Code
                        </a></td>
				      </tr>
				     <?php endforeach; ?> 
				    </tbody>
				  </table>    
			</div>
			<?php echo form_close();?>   
	   </section>
	   <section class="panel">
		   <?php echo form_open(base_url() . 'index.php?admin/system_settings/change_skin');?>

			<div class="panel-heading">
			   <h4 class="panel-title">
				<?php echo get_phrase('loan_details');?>
				</h4>
			</div>

			 <div class="panel-body">

				  <table class="table">
				    <thead>
				      <tr>
				        <th>Loan ID</th>
				        <th>Balance</th>
				      </tr>
				    </thead>
				    <tbody>
						<?php
						$loan_data = $this->db->get_where( 'loan', array( 'client_id' => $client_id ) )->result_array();
						foreach ( $loan_data as $data1 ):
							?>
				      <tr class="success">
				          <th><?php echo $data1['id'] ?></th>
				        <td><?php echo $this->db->get_where('settings' , array('type' =>'currency'))->row()->description.$data1['total_balance'] ?></td>
				      </tr>
				     <?php endforeach; ?> 
				    </tbody>
				  </table>    
			</div>
			<?php echo form_close();?>   
	   </section>
		  <div class="panel" >
			 <div class="panel-body">

             <div class="form-group">
                      <label  class="col-sm-3 control-label">Credit Score</label>
                      <div class="col-sm-9">
                          <input type="text"  class="form-control" id="credit_score" 
                              value="" readonly>
                      </div>
                  </div>

                  <div class="form-group">
                      <label  class="col-sm-3 control-label">Low or High Risk</label>
                      <div class="col-sm-9">
                          <input type="text" class="form-control"  id="client_risk" 
                              value="" readonly>
                      </div>
                  </div>

    
			</div>

			  <div class="panel-body">
			<?php echo form_open(base_url() . 'index.php?admin/client_statement/'.$client_id , array(
			'class' => 'form-horizontal form-bordered','target'=>'_top' , 'enctype' => 'multipart/form-data'));?>
				  <div class="form-group">
					  <div class="col-sm-12">

				<div class="form-group">
								<label class="col-sm-3 control-label"><?php echo get_phrase('account');?></label>
								<div class="col-sm-7">
								<select data-plugin-selectTwo class="form-control populate" name="account" onchange="class_section(this.value)" style="width: 100%">
									<?php 
							$account_data = $this->db->get_where( 'account', array( 'client_id' => $client_id ) )->result_array();
							foreach ( $account_data as $data ):  ?>
									<option value="<?php echo $data['id']; ?>"><?php echo $data['id']; ?></option>
									<?php endforeach; ?>
								</select>
								</div>
							</div>					  	
							<div class="form-group">
												<label class="col-md-3 control-label">Date Range</label>
												<div class="col-md-12">
													<div class="input-daterange input-group" data-plugin-datepicker>
														<span class="input-group-addon">
															<i class="fa fa-calendar"></i>
														</span>
														<input type="text" class="form-control" name="startdate">
														<span class="input-group-addon">To</span>
														<input type="text" class="form-control" name="enddate">
													</div>
												</div>
							</div>
						<div class="form-group">
							  <div class="col-sm-offset-3 col-sm-5">
								  <button type="submit" class="btn btn-primary"><?php echo get_phrase('view_statement');?></button>
							  </div>
							</div>
					  </div>
				  </div>
				   <?php echo form_close();?>
			  </div>
		  
		  </div>

        </div>
    </div>
 <?php
endforeach;
?>
    
    <!--DARK MODE ON HIDDEN-->
	<script type="text/javascript">
		var div = document.getElementById('hidden-on-dark');
		
		if( '<?php echo $skin ?>' == 'dark'){
			div.style.display = 'none';
		} else {
			div.style.display = 'block';
		}
		
		function get_hidden_on_dark( mode_id ) {
		if(mode_id == 'dark'){
				div.style.display = 'none';
			} else {
				div.style.display = 'block';
			}
		}
	</script>
<script type="text/javascript">
$(document).ready(function() {
					var client_id = <?php echo $client_id; ?>;
          //var client_id = 1012;
 					fetchRiskData(client_id);
				   function fetchRiskData(client_id) {
				          $.ajax({
				              url: "<?php echo base_url()?>apis/preditctRisk.php",
				              method: 'POST',
				              dataType: 'json',
				              data: { client_id: client_id },
				              success: function(response) {
				                // Clear the existing results
				                $("#client_risk").empty();
				                $("#credit_score").empty();
				                  if (response.error) {
				                      alert(response.error);
				                  } else {
				                      $("#client_risk").val(response.risk);
				                      $("#credit_score").val(response.score);
				                  }
				              },
				              error: function(xhr, status, error) {
				                  console.log("AJAX Error:", error);
				              }
				          });
				  	}
    });
</script>
