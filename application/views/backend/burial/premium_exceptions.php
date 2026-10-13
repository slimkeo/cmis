<div class="row">
	<div class="col-md-12">

		<!---CONTROL TABS START-->
		<div class="tabs">
		<ul class="nav nav-tabs">
			<li class="active">
				<a href="#list" data-toggle="tab"><i class="fa fa-list"></i> 
					<?php echo get_phrase('all_members');?>
				</a>
			</li>
		</ul>
		<!---CONTROL TABS END-->

		<div class="tab-content">
		<br>

			<!--TABLE LISTING STARTS-->
			<div class="tab-pane box active" id="list">

				<table class="table table-bordered table-striped mb-none" id="datatable-tabletools1">
			<thead>
				<tr>
                    <th>#</th>
                    <th>Passbook No</th>
                    <th>ID Number</th>
					<th>Emp NO:</th>
                    <th>Full Name</th>
                    <th>Cell Number</th>
                    <th>Actual Premium</th>
                    <th>Paid Premium</th>
					<th>Difference</th>
                    <th>Option</th>
				</tr>
			</thead>

	    <tbody>
	        <!-- Leave empty. DataTables will fill this -->
	    </tbody>

		</table>
		</div>
		<!--TABLE LISTING ENDS-->
		</div>
	</div>
   </div>
</div>
<script>

$(document).ready(function() {

    $('#datatable-tabletools1').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": "<?php echo base_url('index.php?burial/get_premium_exceptions');?>",
            "type": "POST"
        },
        "order": [[0, "desc"]],
        "columnDefs": [
            { "targets": [6, 7, 8], "className": "text-right" }
        ],
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
