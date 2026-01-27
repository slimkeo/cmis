<div class="row">
	<div class="col-md-12">

		<!---CONTROL TABS START-->
		<div class="tabs">
		<ul class="nav nav-tabs">
			<li class="active">
				<a href="#list" data-toggle="tab"><i class="fa fa-list"></i> 
					<?php echo get_phrase('all_attendance');?>
						</a></li>
			<li>
				<a href="#add" data-toggle="tab"><i class="fa fa-plus-circle"></i>
					<?php echo get_phrase('new_attendee'); ?>
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
                    <th>Passbook No</th>
                    <th>National ID</th>
                    <th>AGM</th>
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
					<?php echo form_open(base_url() . 'index.php?burial/attendance/create' , array('class' => 'form-horizontal form-bordered validate','enctype'=>'multipart/form-data'));?>
					<div class="form-group">
					<label class="col-md-3 control-label">
						<?php echo get_phrase('national_id');?>
					</label>

					<div class="col-md-7">
				<input type="number" class="form-control" name="national_id" required title="<?php echo get_phrase('value_required');?>" value="" autofocus>
					</div>
				</div>

						<div class="form-group">
					<label class="col-md-3 control-label">
						<?php echo get_phrase('fullname');?> <span class="required">*</span>
					</label>

					<div class="col-md-7">
						<input type="text" class="form-control" name="fullname" required title="<?php echo get_phrase('value_required');?>" value="" autofocus>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-3 control-label">
						<?php echo get_phrase('passbook_no');?> <span class="required">*</span>
					</label>

					<div class="col-md-7">
						<input type="number" class="form-control" name="passbook_no" required title="<?php echo get_phrase('value_required');?>" value="" autofocus>
					</div>
				</div>
			        <!-- CELL NUMBER -->
			        <div class="form-group">
			            <label class="col-md-3 control-label">Momo</label>
			            <div class="col-md-7">
                        <input type="text"
                               class="form-control"
                               name="momo"
                               maxlength="11"
                               minlength="11"
                               pattern="268[0-9]{8}"
                               oninput="this.value = this.value.replace(/[^0-9]/g, '');"
                               placeholder="268XXXXXXXX"
                               title="Eswatini number must start with 268 and be 11 digits (e.g., 26876123456)"
                               required>

			            </div>
			        </div>
				<div class="form-group">
				<label class="col-sm-3 control-label">AGM</label>
					<div class="col-sm-7">
						<select data-plugin-selectTwo class="form-control populate" name="agm" onchange="class_section(this.value)" style="width: 100%" required>
									<?php foreach ($agms as $rowz): ?>
									<option value="<?php echo $rowz['id']; ?>" ><?php echo $rowz['description']; ?></option>
									<?php endforeach; ?>
								</select>
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
$(document).ready(function() {

    $('#datatable-tabletools12').DataTable({
        "processing": true,
        "serverSide": true,
        "pageLength": 500,  
        "ajax": {
            "url": "<?php echo base_url('index.php?burial/get_attendance');?>",
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
