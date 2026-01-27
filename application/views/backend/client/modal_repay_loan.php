<?php
    $edit_data = $this->db->get_where( 'loan', array( 'id' => $param2 ) )->result_array();
foreach ( $edit_data as $row ):
?>
<div class="row" data-appear-animation="fadeInRight" data-appear-animation-delay="100">
    <?php echo form_open(base_url() . 'index.php?admin/loans/repay/'.$row['id'] , 
      array('class' => 'form-horizontal form-bordered validate'));?>
        <div class="col-md-12">
            
            <div class="panel" >
            
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <?php echo get_phrase('repay_loan');?>
                    </h4>
                </div>
                <div class="panel-body">
				<div class="form-group">
								<label class="col-sm-3 control-label"><?php echo get_phrase('loan_id');?></label>
								<div class="col-sm-7">
								<input type="number" id="principal_amount" value="<?php echo $row['id']; ?>" class="form-control" name="principal_amount" readonly>
								</div>
							</div>
                
				<div class="form-group">
								<label class="col-sm-3 control-label"><?php echo get_phrase('client');?></label>
								<div class="col-sm-7">
								<input readonly type="text" id="principal_amount" value="<?php echo $this->db->get_where('client', array( 'id' => $row['client_id'] ) )->row()->fullname.' '.$this->db->get_where('client', array( 'id' => $row['client_id'] ) )->row()->lastname; ?>" class="form-control" name="client_id" >
								</div>
							</div>
                    

                    
                  <div class="form-group">
								<label class="col-sm-3 control-label"><?php echo get_phrase('loan_amount');?></label>
								<div class="col-sm-7">
								<input type="number" id="loan_amount" class="form-control" name="principal_amoloan_amountunt" value="<?php echo $row['amount']; ?>" readonly>
								</div>
							</div>
                    
                            <div class="form-group">
                      <label  class="col-sm-3 control-label"><?php echo get_phrase('total_balance');?></label>
                      <div class="col-sm-9">
                          <input type="number" id="principaloan_amountl_amount" class="form-control" name="loan_amount" value="<?php echo $row['total_balance']; ?>" readonly>
                      </div>
                  </div>
                  <div class="form-group">
								<label class="col-sm-3 control-label"><?php echo get_phrase('monthly_pay');?></label>
								<div class="col-sm-7">
								<input type="number" id="paid_amount" class="form-control" name="paid_amount" value="<?php echo $row['monthly_pay']; ?>">
								</div>
							</div>                   



                    

                </div>
                
				<footer class="panel-footer">
					<div class="row">
						<div class="col-sm-9 col-sm-offset-3">
						 <button type="submit" class="btn btn-primary"><?php echo get_phrase('repay_loan');?></button>
						</div>
					</div>	
				</footer>
                <?php echo form_close();?>
            </div>
        </div>
        
        <?php
endforeach;
?>  
    <!--DARK MODE ON HIDDEN-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
     <script type="text/javascript">
    $(document).ready(function() {
        $("#principal_amount").on("keyup", function() {
             var amount = $(this).val();

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
        });
    });
</script>
