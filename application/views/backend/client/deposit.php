<?php
   $query = $this->db->get( 'town' );
   $towns = $query->result_array();
    $rates = $this->db->get_where( 'plan')->result_array();
    $clients = $this->db->get_where( 'client')->result_array();
  ?>

<div class="row" data-appear-animation="fadeInRight" data-appear-animation-delay="100">
    <?php echo form_open(base_url() . 'index.php?admin/deposit/create' , 
      array('class' => 'form-horizontal form-bordered validate'));?>
        <div class="col-md-8">
            
            <div class="panel" >
            
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <?php echo get_phrase('deposit');?>
                    </h4>
                </div>
                
                <div class="panel-body">
                    
        <div class="form-group">
                <label class="col-sm-3 control-label"><?php echo get_phrase('client');?></label>
                <div class="col-sm-7">
                <select data-plugin-selectTwo class="form-control populate" id="client_id" name="client_id"  style="width: 100%">
                                <option value="" ></option> 
                  <?php foreach ($clients as $rowz): ?>
                  <option value="<?php echo $rowz['id']; ?>" ><?php echo $rowz['id']." ".$rowz['fullname']." ".$rowz['lastname']; ?></option>
                  <?php endforeach; ?>
                </select>
                </div>
              </div>
                    

                    
                  <div class="form-group">
                <label class="col-sm-3 control-label"><?php echo get_phrase('account');?></label>
                <div class="col-sm-7">
                <select  id="account_id" class="form-control populate" name="account_id"  style="width: 100%">
                   <option value="" ></option>  
                </select>
                </div>
              </div>
                    
                            <div class="form-group">
                      <label  class="col-sm-3 control-label"><?php echo get_phrase('amount');?></label>
                      <div class="col-sm-9">
                          <input type="number" id="amount" class="form-control" name="amount" >
                      </div>
                  </div>
                    



                    

                </div>
                
        <footer class="panel-footer">
          <div class="row">
            <div class="col-sm-9 col-sm-offset-3">
             <button type="submit" class="btn btn-primary"><?php echo get_phrase('deposit');?></button>
            </div>
          </div>  
        </footer>
                <?php echo form_close();?>
            </div>
        </div>
        

   <div class="col-md-4">
            
     <section class="panel">

      <div class="panel-heading">
         <h4 class="panel-title">
        <?php echo get_phrase('risk_profile');?>
        </h4>
      </div>

       <div class="panel-body">

             <div class="form-group">
                      <label  class="col-sm-3 control-label">Credit Score</label>
                      <div class="col-sm-9">
                          <input type="text" id="credit_score" class="form-control" name="unearned_interest" 
                              value="" readonly>
                      </div>
                  </div>

                  <div class="form-group">
                      <label  class="col-sm-3 control-label">Low or High Risk</label>
                      <div class="col-sm-9">
                          <input type="text" class="form-control" id="client_risk" name="total_balance" 
                              value="" readonly>
                      </div>
                  </div>

    
      </div>

        </footer>
     </section>

        <!-- </div> -->
    </div>
    <script>
    $('#client').on('change', function() {
        const client_id = $(this).val();
        if (client_id) {
            loadAccounts(client_id);
        }
    });
</script>
    <!--DARK MODE ON HIDDEN-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
     <script type="text/javascript">
    $(document).ready(function() {

$('#client_id').change(function() {
    var client_id = $(this).val();
    console.log('Selected value:', client_id);

            $.ajax({
                url: "<?php echo base_url()?>index.php?account/get_accounts",
                method: 'POST',
            dataType: 'json',
            data: {
                    client_id: client_id
                },
                  success: function(response) {
                      console.log(response);

                      // Clear existing options in the dropdown
                      $('#account_id').empty();

                      // Add default placeholder option
                      $('#account_id').append('<option value="" disabled selected>Select a Account</option>');

                      // Populate dropdown with account_list data
                      if (response.account_list.length > 0) {
                          response.account_list.forEach(function(account) {
                              $('#account_id').append(
                                  `<option value="${account.id}">
                                      ${account.id} Available Balance ${account.balance}
                                  </option>`
                              );
                          });                        
                      } else {
                          $('#account_id').append('<option value="" disabled>No accounts available</option>');
                      }
                  },
                  error: function(xhr, status, error) {
                      console.error("Error: " + error);
                  }
            });
        });
    });
</script>
<script type="text/javascript">
$(document).ready(function() {
          //var client_id = 1012;
          //fetchRiskData(client_id);
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

                // Event listener for select change
                $("#client_id").change(function() {
                    var client_id = $(this).val();
                    console.log('Selecteddddd value:', client_id);
                    fetchRiskData(client_id); // Fetch risk data
                });
    });
</script>
