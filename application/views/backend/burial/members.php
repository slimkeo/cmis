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
			<li>
				<a href="#add" data-toggle="tab"><i class="fa fa-plus-circle"></i>
					<?php echo get_phrase('new_member'); ?>
				</a>
			</li>
		</ul>
		<!---CONTROL TABS END-->

		<div class="tab-content">
		<br>

			<!--TABLE LISTING STARTS-->
			<div class="tab-pane box active" id="list">

                <div class="row" style="margin-bottom: 10px;">
                    <div class="col-md-12 text-right">
                        <button type="button" class="btn btn-primary" id="add_member_btn">
                            <i class="fa fa-plus"></i> Add Member
                        </button>
                    </div>
                </div>

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
			<!-- CREATION FORM STARTS -->
			<div class="tab-pane box" id="add" style="padding: 5px">
			    <div class="box-content">

			        <?php echo form_open(base_url() . 'index.php?burial/members/create',
			        array('class' => 'form-horizontal form-bordered validate','enctype'=>'multipart/form-data'));?>

			        <!-- ID NUMBER -->
			        <div class="form-group">
			            <label class="col-md-3 control-label">ID Number</label>
			            <div class="col-md-7">
			                <input type="text" minlength="13" maxlength="13" class="form-control" 
			                       id="idnumber_input" name="idnumber" required placeholder="Enter 13-digit ID number" oninput="extractDOBFromID()">
			            </div>
			        </div>

			        <!-- SURNAME -->
			        <div class="form-group">
			            <label class="col-md-3 control-label">Surname</label>
			            <div class="col-md-7">
			                <input type="text" class="form-control" name="surname" 
			                       required placeholder="Surname">
			            </div>
			        </div>

			        <!-- NAME -->
			        <div class="form-group">
			            <label class="col-md-3 control-label">Name</label>
			            <div class="col-md-7">
			                <input type="text" class="form-control" name="name" 
			                       required placeholder="First Name(s)">
			            </div>
			        </div>

			        <!-- PASSBOOK NO -->
			        <div class="form-group">
			            <label class="col-md-3 control-label">Passbook No</label>
			            <div class="col-md-7">
			                <input type="number" class="form-control" name="passbook_no" 
			                       required placeholder="Enter passbook number">
			            </div>
			        </div>

			        <!-- CELL NUMBER -->
			        <div class="form-group">
			            <label class="col-md-3 control-label">Cell Number</label>
			            <div class="col-md-7">
                            <input type="text"
                                   class="form-control"
                                   name="cellnumber"
                                   maxlength="11"
                                   minlength="11"
                                   pattern="268[0-9]{8}"
                                   oninput="this.value = this.value.replace(/[^0-9]/g, '');"
                                   placeholder="268XXXXXXXX"
                                   title="Eswatini number must start with 268 and be 11 digits (e.g., 26876123456)"
                                   required>

			            </div>
			        </div>

			        <!-- EMPLOYEE NO -->
			        <div class="form-group">
			            <label class="col-md-3 control-label">Employee No</label>
			            <div class="col-md-7">
			                <input type="number" class="form-control" name="employeeno" 
			                       placeholder="Employee number (optional)">
			            </div>
			        </div>

			        <!-- TSC NO -->
			        <div class="form-group">
			            <label class="col-md-3 control-label">TSC No</label>
			            <div class="col-md-7">
			                <input type="text" class="form-control" name="tscno" 
			                       placeholder="TSC number (optional)">
			            </div>
			        </div>

			        <!-- DOB -->
					<div class="form-group">
					    <label class="col-md-3 control-label">Date of Birth</label>
					    <div class="col-md-7">
													<div class="input-daterange input-group" data-plugin-datepicker>
														<span class="input-group-addon">
															<i class="fa fa-calendar"></i>
														</span>
														<input type="text" class="form-control" id="dob_input" name="dob" placeholder="Auto-filled from ID">
													</div>
					    </div>
					</div>

			        <!-- GENDER -->
			        <div class="form-group">
			            <label class="col-md-3 control-label">Gender</label>
			            <div class="col-md-7">
			                <select name="gender" class="form-control" required>
			                    <option value="">Select</option>
			                    <option value="M">Male</option>
			                    <option value="F">Female</option>
			                </select>
			            </div>
			        </div>

			        <!-- SCHOOL CODE -->
			        <div class="form-group">
			            <label class="col-md-3 control-label">School Code</label>
			            <div class="col-md-7">
			                <input type="number" class="form-control" name="schoolcode" 
			                       placeholder="School code">
			            </div>
			        </div>
			        <!-- SCHOOL CODE -->
			        <div class="form-group">
			            <label class="col-md-3 control-label">Permanent Residency</label>
			            <div class="col-md-7">
			                <input type="text" class="form-control" name="resident" 
			                       placeholder="Plot 4" require>
			            </div>
			        </div>

		        <!-- NOMINEE SECTION (ONLY ONE ALLOWED) -->
		        <div class="form-group">
		            <label class="col-md-3 control-label">Nominee</label>
		            <div class="col-md-7">
                        <input type="text"
                               class="form-control"
                               name="nominee_fullname"
                               placeholder="Nominee full name">
		                <small class="form-text text-muted">
                            Only one nominee is allowed per member.
                        </small>
		            </div>
		        </div>

                <!-- SUBMIT BUTTON -->
                <div class="form-group">
                    <div class="col-md-7 col-md-offset-3">
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-save"></i> Add Member
                        </button>
                    </div>
                </div>

			        </form>
			    </div>
			</div>
			<!-- CREATION FORM ENDS -->

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
            "url": "<?php echo base_url('index.php?burial/get_members');?>",
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