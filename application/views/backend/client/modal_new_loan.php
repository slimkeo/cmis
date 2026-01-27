<?php
   $query = $this->db->get( 'town' );
   $towns = $query->result_array();
    $rates = $this->db->get_where( 'plan')->result_array();
    $clients = $this->db->get_where( 'client')->result_array();
	?>

<div class="row" data-appear-animation="fadeInRight" data-appear-animation-delay="100">
    <?php echo form_open(base_url() . 'index.php?admin/loans/create' , 
      array('class' => 'form-horizontal form-bordered validate'));?>
        <div class="col-md-8">
            
            <div class="panel" >
            
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <?php echo get_phrase('new_loan');?>
                    </h4>
                </div>
                
                <div class="panel-body">
                    
				<div class="form-group">
								<label class="col-sm-3 control-label"><?php echo get_phrase('client');?></label>
								<div class="col-sm-7">
								<select data-plugin-selectTwo class="form-control populate" id="selected_client" name="client"  style="width: 100%">
                                <option value="" ></option>	
									<?php foreach ($clients as $rowz): ?>
									<option value="<?php echo $rowz['id']; ?>" ><?php echo $rowz['id']." ".$rowz['fullname']." ".$rowz['lastname']; ?></option>
									<?php endforeach; ?>
								</select>
								</div>
							</div>
                    

                    
                  <div class="form-group">
								<label class="col-sm-3 control-label"><?php echo get_phrase('loan_plan');?></label>
								<div class="col-sm-7">
								<select data-plugin-selectTwo id="plan" class="form-control populate" name="plan"  style="width: 100%">
								<option value="" ></option>	
                                <?php foreach ($rates as $rowz): ?>
									<option value="<?php echo $rowz['id']; ?>" ><?php echo $rowz['months']." Months at ".$rowz['rate']."% interest"; ?></option>
									<?php endforeach; ?>
								</select>
								</div>
							</div>
                    
                            <div class="form-group">
                      <label  class="col-sm-3 control-label"><?php echo get_phrase('loan_amount');?></label>
                      <div class="col-sm-9">
                          <input type="number" id="principal_amount" class="form-control" name="principal_amount" >
                      </div>
                  </div>
                    

             <div class="form-group">
                      <label  class="col-sm-3 control-label">Credit Score</label>
                      <div class="col-sm-9">
                          <input type="text" name="credit_score"  class="form-control" id="credit_score" 
                              value="" readonly>
                      </div>
                  </div>

                  <div class="form-group">
                      <label  class="col-sm-3 control-label">Low or High Risk</label>
                      <div class="col-sm-9">
                          <input type="text" name="client_risk" class="form-control" id="client_risk" 
                              value="" readonly>
                      </div>
                  </div>


                    

                </div>
                
				<footer class="panel-footer">
					<div class="row">
						<div class="col-sm-9 col-sm-offset-3">
						 <button type="submit" class="btn btn-primary"><?php echo get_phrase('creat_loan');?></button>
						</div>
					</div>	
				</footer>
                <?php echo form_close();?>
            </div>>
        </div>
        

   <div class="col-md-4">
            
	   <section class="panel">

			<div class="panel-heading">
			   <h4 class="panel-title">
				<?php echo get_phrase('loan_details');?>
				</h4>
			</div>

			 <div class="panel-body">

             <div class="form-group">
                      <label  class="col-sm-3 control-label"><?php echo get_phrase('unearned_interest');?></label>
                      <div class="col-sm-9">
                          <input type="text" id="unearned_interest" class="form-control" name="unearned_interest" 
                              value="" readonly>
                      </div>
                  </div>

                  <div class="form-group">
                      <label  class="col-sm-3 control-label"><?php echo get_phrase('total_balance');?></label>
                      <div class="col-sm-9">
                          <input type="text" class="form-control" id="total_balance" name="total_balance" 
                              value="" readonly>
                      </div>
                  </div>

				<div id="hidden-on-dark">

                <div class="form-group mb-md">
                      <label  class="col-sm-3 control-label"><?php echo get_phrase('monthly_pay');?></label>
                      <div class="col-sm-9">
                          <input type="text" id="monthly_pay" class="form-control" name="monthly_pay" 
                              value="" readonly>
                      </div>
                  </div>

                  <div class="form-group mb-md">
                      <label  class="col-sm-3 control-label"><?php echo get_phrase('effective_date');?></label>
                      <div class="col-sm-9">
                          <input type="text" class="form-control" name="effective_date"   id="effective_date"
                              value="" readonly>
                      </div>
                  </div> 
				</div> 

    
			</div>
	   </section>

        <!-- </div> -->
    </div>
    
    <!--DARK MODE ON HIDDEN-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script type="text/javascript">
  $(document).ready(function() {
      $("#principal_amount").on("keyup", function() {
             var amount = $(this).val();
            calculateCompoundInterest(amount)
        });
      $("#selected_client").change(function() {
        var client_id = $(this).val(); // Get selected client ID
        fetchRiskData(client_id); // Fetch risk data
       });
        function calculateCompoundInterest(amount){
                    $.ajax({
                        url: "<?php echo base_url()?>index.php?calculator/calculateCompoundInterest",
                        method: 'POST',
                    dataType: 'json',
                    data: {
                            amount: amount,
                            plan: $( '#plan' ).val()
                        },
                        success: function(response) {
                                    // Clear the existing results
                                    $("#unearned_interest").empty();
                                    $("#total_balance").empty();
                                    $("#monthly_pay").empty();
                                    $("#effective_date").empty();
                                    // Loop through the results array and append each result to the text field

                                        $("#unearned_interest").val(response.unearned_interest);
                                        $("#total_balance").val(response.total_balance);
                                        $("#monthly_pay").val(response.monthly_pay);
                                        $("#effective_date").val(response.effective_date);
                        }
                    });
        }
        function fetchRiskData(client_id) {
                          $.ajax({
                              url: "<?php echo base_url()?>apis/preditctRisk.php",
                              method: 'POST',
                              dataType: 'json',
                              data: { client_id: client_id },
                              success: function(response) {
                                console.log('response:', response);
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
