<div class="row">
	<div class="col-md-12">

		<!---CONTROL TABS START-->
		<div class="tabs">
		<ul class="nav nav-tabs">
			<li class="active">
				<a href="#list" data-toggle="tab"><i class="fa fa-list"></i> 
					<?php echo get_phrase('subscriptions');?>
				</a>
			</li>
		</ul>
		<!---CONTROL TABS END-->
		<div class="row">
			<div class="col-md-12">

				<h4>Member Statement</h4>

				<table class="table table-bordered table-striped mb-none" id="datatable-tabletools1">
					<thead>
						<tr>
							<th>#</th>
							<th>Date</th>
							<th>Description</th>
							<th>Amount</th>
							<th>Type</th>
							<th>Status</th>
							<th>Source</th>
							<th>Created At</th>
						</tr>
					</thead>
					<tbody>
						<!-- Leave empty. DataTables will fill this -->
					</tbody>
				</table>

				<div style="margin-top:15px;">
					<a href="<?php echo base_url('index.php?burial/members/'); ?>" class="btn btn-default">Back to Members</a>
				</div>
			</div>
		</div>
	</div>
</div>

<script>
$(document).ready(function() {

	// Get member ID from the URL (current page context)
	var memberid = '<?php echo isset($memberid) ? $memberid : ""; ?>';

	$('#datatable-tabletools1').DataTable({
		"processing": true,
		"serverSide": true,
		"ajax": {
			"url": "<?php echo base_url('index.php?burial/get_member_statements');?>",
			"type": "POST",
			"data": function(d) {
				d.memberid = memberid;
			}
		},

		// ADD THIS ↓↓↓
		dom: 'Bfrtip',
		buttons: [
			{ extend: 'copy',  text: 'Copy' },
			{ extend: 'excel', text: 'Excel' },
			{ extend: 'pdf',   text: 'PDF' },
			{ extend: 'print', text: 'Print' }
		]
	});

});
</script>