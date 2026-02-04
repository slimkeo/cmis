<div class="row">
	<div class="col-md-12">

		<!---CONTROL TABS START-->
		<div class="tabs">
		<ul class="nav nav-tabs">
			<li class="active">
				<a href="#add_subscription" data-toggle="tab"><i class="fa fa-plus-circle"></i>
					<?php echo 'Add Subscription Payment'; ?>
				</a>
			</li>
		</ul>
		<!---CONTROL TABS END-->

		<div class="tab-content">
		<br>

			<!-- ADD SUBSCRIPTION FORM STARTS -->
			<div class="tab-pane box active" id="add_subscription" style="padding: 15px">
				<div class="box-content">

					<?php echo form_open(base_url() . 'index.php?burial/add_subscription',
					array('class' => 'form-horizontal form-bordered validate')); ?>

					<!-- SEARCH MEMBER -->
					<div class="form-group">
						<label class="col-md-3 control-label">Search Member <span style="color: red;">*</span></label>
						<div class="col-md-7">
							<div style="position: relative;">
								<input type="text" class="form-control" id="member_search" 
									   placeholder="Search by ID Number, Name, Passbook No, or Employee No" required>
								<small class="form-text text-muted">Start typing to search for member</small>
								
								<!-- Search Results Dropdown -->
								<div id="member_search_results" style="position: absolute; top: 100%; left: 0; right: 0; background: white; border: 1px solid #ddd; border-top: none; border-radius: 0 0 4px 4px; max-height: 300px; overflow-y: auto; z-index: 1000; display: none; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
									<!-- Results will be populated here -->
								</div>
							</div>
						</div>
					</div>

					<!-- SELECTED MEMBER INFO -->
					<div class="form-group">
						<label class="col-md-3 control-label">Selected Member</label>
						<div class="col-md-7">
							<div class="alert alert-info" id="member_info" style="display: none;">
								<strong>ID Number:</strong> <span id="member_idnumber"></span> <br>
								<strong>Name:</strong> <span id="member_name"></span> <br>
								<strong>Passbook No:</strong> <span id="member_passbook"></span> <br>
								<strong>Cell Number:</strong> <span id="member_cell"></span>
							</div>
							<input type="hidden" id="selected_member_id" name="selected_member_id" value="">
						</div>
					</div>

					<!-- SELECT MONTHS -->
					<div class="form-group" id="months_group" style="display: none;">
						<label class="col-md-3 control-label">Select Months <span style="color: red;">*</span></label>
						<div class="col-md-7">
							<!-- Month Search -->
							<div style="margin-bottom: 10px;">
								<input type="text" id="month_search" class="form-control" 
									   placeholder="Search months (e.g., 'January 2025' or '2025-01')" 
									   style="display: none;">
								<small class="form-text text-muted" id="month_search_hint" style="display: none;">Type to search available months</small>
							</div>

							<!-- Month Selection Container -->
							<div id="months_container" style="border: 1px solid #ddd; padding: 10px; border-radius: 4px; max-height: 300px; overflow-y: auto;">
								<p style="text-align: center; color: #999; margin: 20px 0;">Loading available months...</p>
							</div>
							<small class="form-text text-muted">Select one or more months that member has not subscribed for</small>
						</div>
					</div>

					<!-- AMOUNT PER MONTH -->
					<div class="form-group" id="amount_group" style="display: none;">
						<label class="col-md-3 control-label">Amount Per Month <span style="color: red;">*</span></label>
						<div class="col-md-7">
							<input type="number" class="form-control" id="amount_per_month" name="amount_per_month" 
								   step="0.01" min="0" placeholder="0.00" readonly>
							<small class="form-text text-muted">Automatically calculated based on member's beneficiaries</small>
						</div>
					</div>

					<!-- TOTAL AMOUNT -->
					<div class="form-group" id="total_group" style="display: none;">
						<label class="col-md-3 control-label">Total Amount</label>
						<div class="col-md-7">
							<input type="text" class="form-control" id="total_amount" readonly 
								   placeholder="E 0.00">
						</div>
					</div>

					<!-- DESCRIPTION -->
					<div class="form-group" id="description_group" style="display: none;">
						<label class="col-md-3 control-label">Description</label>
						<div class="col-md-7">
							<input type="text" class="form-control" name="description" value="Subscription" readonly>
						</div>
					</div>

					<!-- SOURCE -->
					<div class="form-group" id="source_group" style="display: none;">
						<label class="col-md-3 control-label">Source <span style="color: red;">*</span></label>
						<div class="col-md-7">
							<select name="source" id="source_select" class="form-control" required>
								<option value="">-- Select Source --</option>
								<?php foreach ($source_enum as $value): ?>
									<option value="<?= $value ?>">
										<?= ucfirst($value) ?>
									</option>
								<?php endforeach; ?>
							</select>
						</div>
					</div>

					<!-- STATUS 
					<div class="form-group" id="status_group" style="display: none;">
						<label class="col-md-3 control-label">Status <span style="color: red;">*</span></label>
						<div class="col-md-7">
							<select name="status" class="form-control">
								<option value="">-- Select Status --</option>

								<?php foreach ($status_enum as $value): ?>
									<option value="<?= $value ?>">
										<?= ucfirst($value) ?>
									</option>
								<?php endforeach; ?>
							</select>
						</div>
					</div> -->

					<!-- SUBMIT BUTTON -->
					<div class="form-group">
						<div class="col-sm-offset-3 col-sm-5">
							<button type="submit" class="btn btn-primary" id="submit_btn" disabled>
								<i class="fa fa-check"></i> Add Subscription
							</button>
							<button type="reset" class="btn btn-secondary">
								<i class="fa fa-times"></i> Clear
							</button>
						</div>
					</div>

					</form>
				</div>
			</div>
			<!-- ADD SUBSCRIPTION FORM ENDS -->

		</div>
	</div>
   </div>
</div>

<script>
$(document).ready(function() {

	// Member search with dropdown results
	$('#member_search').keyup(function() {
		var search = $(this).val();
		
		if (search.length < 2) {
			$('#member_search_results').hide();
			$('#member_info').hide();
			$('#months_group, #amount_group, #total_group, #description_group, #status_group').hide();
			$('#selected_member_id').val('');
			$('#submit_btn').prop('disabled', true);
			return;
		}

		$.ajax({
			url: "<?php echo base_url('index.php?burial/search_members');?>",
			method: 'POST',
			data: {search: search},
			dataType: 'json',
			success: function(response) {
				if (response.success && response.members.length > 0) {
					display_search_results(response.members);
				} else {
					$('#member_search_results').html('<div style="padding: 10px; text-align: center; color: #999;">No members found</div>').show();
					$('#member_info').hide();
					$('#months_group, #amount_group, #total_group, #description_group, #status_group').hide();
					$('#selected_member_id').val('');
					$('#submit_btn').prop('disabled', true);
				}
			},
			error: function() {
				$('#member_search_results').html('<div style="padding: 10px; text-align: center; color: #d32f2f;">Error loading members</div>').show();
			}
		});
	});

	// Display search results in dropdown
	function display_search_results(members) {
		var resultsHtml = '';
		
		$.each(members, function(index, member) {
			var displayName = member.surname + ' ' + member.name;
			var displayId = member.idnumber;
			var displayPassbook = member.passbook_no || 'N/A';
			var displayEmployee = member.employeeno || 'N/A';
			
			resultsHtml += '<div class="member-search-result" style="padding: 10px 15px; border-bottom: 1px solid #f0f0f0; cursor: pointer; transition: background 0.2s; display: flex; justify-content: space-between; align-items: center;" ' +
				'data-member-id="' + member.id + '" ' +
				'data-member-idnumber="' + member.idnumber + '" ' +
				'data-member-surname="' + member.surname + '" ' +
				'data-member-name="' + member.name + '" ' +
				'data-member-passbook="' + member.passbook_no + '" ' +
				'data-member-cell="' + member.cellnumber + '">' +
				'<div style="flex-grow: 1;">' +
				'<strong style="display: block; margin-bottom: 3px;">' + displayName + '</strong>' +
				'<small style="color: #666; display: block;">ID: ' + displayId + ' | Passbook: ' + displayPassbook + ' | Employee: ' + displayEmployee + '</small>' +
				'</div>' +
				'<div style="margin-left: 10px; color: #007bff;">→</div>' +
				'</div>';
		});
		
		$('#member_search_results').html(resultsHtml).show();
		
		// Add click handlers to each result
		$('.member-search-result').click(function() {
			var member = {
				id: $(this).data('member-id'),
				idnumber: $(this).data('member-idnumber'),
				surname: $(this).data('member-surname'),
				name: $(this).data('member-name'),
				passbook_no: $(this).data('member-passbook'),
				cellnumber: $(this).data('member-cell')
			};
			
			select_member(member);
			$('#member_search_results').hide();
		});
	}

	function select_member(member) {
		$('#member_search').val(member.surname + ' ' + member.name);
		$('#member_idnumber').text(member.idnumber);
		$('#member_name').text(member.surname + ' ' + member.name);
		$('#member_passbook').text(member.passbook_no);
		$('#member_cell').text(member.cellnumber);
		$('#selected_member_id').val(member.id);
		$('#member_info').show();
		$('#months_group, #amount_group, #total_group, #description_group, #source_group, #status_group').show();
		
		// Load available months (months not yet subscribed for)
		load_available_months(member.id);
		
		// Fetch calculated payment amount for this member
		fetch_member_payment_amount(member.id);
		
		$('#submit_btn').prop('disabled', false);
	}

	// Load available months (months not yet subscribed for) for the selected member
	function load_available_months(member_id) {
		$.ajax({
			url: "<?php echo base_url('index.php?burial/get_available_months');?>",
			method: 'POST',
			data: {member_id: member_id},
			dataType: 'json',
			success: function(response) {
				if (response.success) {
					var available_months = response.months;
					
					// Clear existing months
					$('#months_container').empty();
					$('#month_search').val('').show();
					$('#month_search_hint').show();
					
					if (available_months.length === 0) {
						$('#months_container').html('<p style="text-align: center; color: #999; margin: 20px 0;">Member has already subscribed for all available months</p>');
						$('#month_search').hide();
						$('#month_search_hint').hide();
						return;
					}
					
					// Generate months HTML
					var months_html = '';
					$.each(available_months, function(index, month) {
						months_html += '<div class="month-item" style="margin-bottom: 8px; display: none;" data-month-value="' + month.value + '" data-month-label="' + month.label + '">' +
							'<label style="font-weight: normal;">' +
							'<input type="checkbox" name="months[]" value="' + month.value + '" class="month-checkbox">' +
							'<span class="month-text">' + month.label + '</span>' +
							'</label>' +
							'</div>';
					});
					
					$('#months_container').html(months_html);
					
					// Show all items initially
					$('.month-item').show();
					
					// Update total when months change
					$('input[name="months[]"]').off('change').on('change', function() {
						calculate_total();
					});
				} else {
					$('#months_container').html('<p style="text-align: center; color: #d32f2f; margin: 20px 0;">Error loading available months</p>');
				}
			},
			error: function() {
				$('#months_container').html('<p style="text-align: center; color: #d32f2f; margin: 20px 0;">Error loading available months</p>');
			}
		});
	}

	// Month search functionality
	$('#month_search').on('keyup', function() {
		var search_term = $(this).val().toLowerCase().trim();
		
		if (search_term === '') {
			// Show all months
			$('.month-item').show();
		} else {
			// Filter months based on search term
			$('.month-item').each(function() {
				var month_label = $(this).data('month-label').toLowerCase();
				var month_value = $(this).data('month-value').toLowerCase();
				
				if (month_label.includes(search_term) || month_value.includes(search_term)) {
					$(this).show();
				} else {
					$(this).hide();
				}
			});
		}
	});

	// Fetch member's calculated payment amount
	function fetch_member_payment_amount(member_id) {
		$.ajax({
			url: "<?php echo base_url('index.php?burial/get_member_payment_amount');?>",
			method: 'POST',
			data: {member_id: member_id},
			dataType: 'json',
			success: function(response) {
				if (response.success) {
					$('#amount_per_month').val(response.amount.toFixed(2));
					// Trigger change to update total
					$('input[name="months[]"]').trigger('change');
				}
			},
			error: function() {
				$('#amount_per_month').val('0.00');
			}
		});
	}

	// Calculate total when months change
	function calculate_total() {
		var selected_months = $('input[name="months[]"]:checked').length;
		var amount_per_month = parseFloat($('#amount_per_month').val()) || 0;
		var total = selected_months * amount_per_month;
		
		$('#total_amount').val('E ' + total.toFixed(2));
	}

	// Close search results when clicking outside
	$(document).click(function(e) {
		if (!$(e.target).closest('#member_search, #member_search_results').length) {
			$('#member_search_results').hide();
		}
	});

	// Validate form on submit
	$('form').submit(function(e) {
		var member_id = $('#selected_member_id').val();
		var months_selected = $('input[name="months[]"]:checked').length;
		var amount = parseFloat($('#amount_per_month').val());
		var source = $('#source_select').val();

		if (!member_id || member_id == '') {
			alert('Please select a member');
			e.preventDefault();
			return false;
		}

		if (months_selected == 0) {
			alert('Please select at least one month');
			e.preventDefault();
			return false;
		}

		if (!amount || amount <= 0) {
			alert('Please enter a valid amount');
			e.preventDefault();
			return false;
		}

		if (!source || source == '') {
			alert('Please select a source');
			e.preventDefault();
			return false;
		}

		return true;
	});

});
</script>