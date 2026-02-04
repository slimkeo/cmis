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
                    <th>ID Number</th>
					<th>Emp NO:</th>
                    <th>Surname</th>
                    <th>Name</th>
                    <th>Passbook No</th>
                    <th>Cell Number</th>
                    <th>Gender</th>
                    <th>School Code</th>
					<th><?php echo get_phrase('options');?></th>
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
// Extract DOB from Swazi ID number
// Format: YYMMDD (first 6 digits)
// Example: 9702206100465 -> 1997-02-20
function extractDOBFromID() {
    const idInput = document.getElementById('idnumber_input');
    const dobInput = document.getElementById('dob_input');
    const idValue = idInput.value.trim();
    
    // Must be at least 6 digits
    if (idValue.length >= 6) {
        const dateStr = idValue.substring(0, 6);
        const yy = parseInt(dateStr.substring(0, 2));
        const mm = dateStr.substring(2, 4);
        const dd = dateStr.substring(4, 6);
        
        // Determine full year: if YY <= current year's last 2 digits, it's 20YY, else 19YY
        const currentYear = new Date().getFullYear();
        const currentYY = currentYear % 100;
        const fullYear = yy <= currentYY ? 2000 + yy : 1900 + yy;
        
        // Format as YYYY-MM-DD
        const dobValue = fullYear + '-' + mm + '-' + dd;
        dobInput.value = dobValue;
    }
}

$(document).ready(function() {

    $('#datatable-tabletools1').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": "<?php echo base_url('index.php?burial/get_pending_members');?>",
            "type": "POST"
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

    // Switch to "Add Member" tab when button is clicked
    $('#add_member_btn').on('click', function () {
        $('.nav-tabs a[href="#add"]').tab('show');
    });

});
</script>