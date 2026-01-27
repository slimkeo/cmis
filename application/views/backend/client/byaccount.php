<div class="row">
	<div class="col-md-12">	    
		<div class="col-lg-12">
			<section class="panel">
				<header class="panel-heading">
					<h2 class="panel-title">Search by Account</h2>
				</header>
				<div class="panel-body">
					<div class="form-horizontal form-bordered validate">

						<div class="form-group">
							<label class="col-md-3 control-label">Enter Account</label>
							<div class="col-md-6">
								<input type="number" id="account_id" class="form-control" name="account_id" placeholder="Enter Account Number">
							</div>
						</div>

						<div class="form-group">
							<div class="col-sm-offset-3 col-sm-5">
								<button type="button" id="search_client" class="btn btn-default btn-sm">
									<i class="fa fa-search"></i> Confirm User
								</button>
							</div>
						</div>

						<!-- AJAX Result Area -->
						<div id="client_result" style="display: none;">
							<div class="form-group">
								<label class="col-md-3 control-label">Client Name</label>
								<div class="col-md-6">
									<input type="text" class="form-control" id="client_name" readonly>
								</div>
							</div>

							<div class="form-group">
								<label class="col-md-3 control-label">Your Limit</label>
								<div class="col-md-6">
									<input type="text" class="form-control" id="account_balance" readonly>
								</div>
							</div>

							<div class="form-group">
								<label class="col-md-3 control-label">Enter Amount</label>
								<div class="col-md-6">
									<input type="number" class="form-control" name="amount" id="amount_field" required>
								</div>
							</div>

							<div class="form-group">
								<div class="col-sm-offset-3 col-sm-5">
									<button type="button" id="send_money_btn" class="btn btn-success">
										<i class="fa fa-money"></i> Send Money
									</button>
								</div>
							</div>

							<div id="money_success" class="alert alert-success" style="display:none; margin-left: 25%;">
								Money sent successfully!
							</div>

							<div id="money_error" class="alert alert-danger" style="display:none; margin-left: 25%;">
								Error sending money.<p id="error_messgae"></p>
							</div>
						</div>

						<div id="not_found" class="alert alert-danger" style="display:none; margin-left: 25%;">
							Client not found.
						</div>

					</div>
				</div>
			</section>
		</div>
	</div>
</div>

<script>
	let account_id = null;

	$('#search_client').on('click', function() {
		account_id = $('#account_id').val();

		if (account_id.trim() === '') {
			alert("Please enter a account number.");
			return;
		}

		$.ajax({
			url: '<?php echo base_url(); ?>index.php?client/search_client_by_account',
			type: 'POST',
			data: { account_id: account_id },
			dataType: 'json',
			success: function(response) {
				if (response.status === 'success') {
					$('#client_name').val(response.fullname + ' ' + response.lastname);
					$('#account_balance').val(response.account_balance);
					$('#client_result').show();
					$('#not_found').hide();
				} else {
					$('#client_result').hide();
					$('#not_found').show();
				}
			},
			error: function() {
				alert("An error occurred. Try again.");
			}
		});
	});

	$('#send_money_btn').on('click', function() {
		var amount = $('#amount_field').val();

		if (!account_id || amount <= 0) {
			alert("Enter a valid amount and confirm client.");
			return;
		}

		alert(account_id); 

		$.ajax({
			url: '<?php echo base_url(); ?>index.php?client/send_byAccount_to_primary_account',
			type: 'POST',
			data: {
				account_id: account_id, // Receiver
				amount: amount
			},
			dataType: 'json',
			success: function(response) {
				if (response.status === 'success') {
					$('#money_success').show();
					$('#money_error').hide();
					$('#account_balance').val(response.new_balance);
				} else {
					$('#money_success').hide();
					$('#error_message').text(response.message); // set message in <p>
					$('#money_error').show();
				}
			}
		});
	});
</script>