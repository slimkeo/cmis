<?php 

ini_set('display_errors', 1);
error_reporting(E_ALL);


$branches=$this->db->get('branches')->result_array();
$employment_status=$this->db->get('employment_status')->result_array();

?>
<div class="row">
	<div class="col-md-12">

		<!---CONTROL TABS START-->
		<div class="tabs">
		<ul class="nav nav-tabs">
			<li class="active">
				<a href="#list" data-toggle="tab"><i class="fa fa-list"></i> 
					ALL ATTENDEES
						</a></li>
			<li>
				<a href="#add" data-toggle="tab"><i class="fa fa-plus-circle"></i>
					ADD ATTENDEE
						</a></li>
		</ul>
		<!---CONTROL TABS END-->

		<div class="tab-content">
		<br>
			<!--TABLE LISTING STARTS-->
			<div class="tab-pane box active" id="list">
				<table class="table table-bordered table-striped mb-none" id="datatable-tabletools12">
			<thead>
				<tr>
                    <th>#</th>
                    <th>National ID</th>
                    <th>FULLNAME</th>
                    <th>MOMO</th>
                    <th>OTP</th>
                    <th>STATUS</th>
                    <th>OPTION</th>
				</tr>
			</thead>

	    <tbody>
	        <!-- Leave empty. DataTables will fill this -->
	    </tbody>

		</table>
			</div>
			<!--CREATION FORM STARTS-->
			<div class="tab-pane box" id="add" style="padding: 5px">
				<div class="box-content">
					<?php echo form_open(base_url() . 'index.php?union/add_attendee/'.$event_id , array('class' => 'form-horizontal form-bordered validate','enctype'=>'multipart/form-data'));?>

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
									<div class="input-group date" data-provide="datepicker"data-date-format="yyyy-mm-dd">
										<input type="text"
											class="form-control"
											name="dob"
											id="dob_input"
											pattern="\d{4}-(?:0?[1-9]|1[0-2])-(?:0?[1-9]|[12]\d|3[01])"
											placeholder="yyyy-mm-dd"
											title="Format: yyyy-mm-dd (e.g. 2026-02-17)"
											>
										<span class="input-group-addon">
											<i class="glyphicon glyphicon-calendar"></i>   <!-- or font-awesome etc. -->
										</span>
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
			        <!-- Employement Status -->
			        <div class="form-group">
			            <label class="col-md-3 control-label">Employement Type</label>
			            <div class="col-md-7">
			                <select name="employment_status" data-plugin-selectTwo data-minimum-results-for-search="4" data-width="100%" class="form-control populate">
			                    <option value="">Select</option>
								<?php foreach ($employment_status as $rowz): ?>
								<option value="<?php echo $rowz['id']; ?>"><?php echo $rowz['description']; ?></option>
								<?php endforeach; ?>
			                </select>
			            </div>
			        </div>					
			        <!-- Branch -->
			        <div class="form-group">
			            <label class="col-md-3 control-label">Branch</label>
			            <div class="col-md-7">
			                <select name="branch" data-plugin-selectTwo data-minimum-results-for-search="4" data-width="100%" class="form-control populate">
			                    <option value="">Select</option>
								<?php foreach ($branches as $rowz): ?>
								<option value="<?php echo $rowz['id']; ?>"><?php echo $rowz['name']; ?></option>
								<?php endforeach; ?>
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
					<div class="form-group">
							  <div class="col-sm-offset-3 col-sm-5">
								  <button type="submit" class="btn btn-primary"><?php echo get_phrase('add_attandee');?></button>
							  </div>
							</div>
					</form>                
				</div>                
			</div>
			<!--CREATION FORM ENDS-->

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

    var event_id = "<?php echo $event_id; ?>"; // OR get from dropdown/input

    $('#datatable-tabletools12').DataTable({
        "processing": true,
        "serverSide": true,
        "pageLength": 500,  

        "ajax": {
            "url": "<?php echo base_url('index.php?union/get_attendance');?>",
            "type": "POST",

            // ✅ SEND EXTRA PARAMETER
            "data": function(d) {
                d.event_id = event_id;
            }
        },

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
<script>
document.querySelector("form").addEventListener("submit", function(e) {
    var momo = document.querySelector("input[name='momo']").value.trim();

    // Remove spaces or unwanted characters
    momo = momo.replace(/[^0-9]/g, '');

    // VALIDATION RULES:
    var startsCorrectly = momo.startsWith("268");
    var correctLength = momo.length === 11;

    if (!startsCorrectly || !correctLength) {
        e.preventDefault(); // Stop submission

        alert("Invalid MOMO number.\n\nMOMO must:\n• Start with 268\n• Be exactly 11 digits long");

        return false;
    }
});
</script>
<script>
$(document).on('click', '.resend-otp', function (e) {
    e.preventDefault();

    let url = $(this).data('url');

    $.ajax({
        url: url,
        type: 'GET',
        success: function () {
            // Do nothing — completely silent
        },
        error: function () {
            // Still silent — or you can show a message
        }
    });
});
</script>

