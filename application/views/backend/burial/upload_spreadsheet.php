<div class="row">
	<div class="col-md-12">

		<!---CONTROL TABS START-->
		<div class="tabs">
		<ul class="nav nav-tabs">
			<li class="active">
				<a href="#treasurer" data-toggle="tab"><i class="fa fa-upload"></i>
					Upload Treasurer Spreadsheet
				</a>
			</li>
			<li>
				<a href="#snat" data-toggle="tab"><i class="fa fa-upload"></i>
					Upload SNAT Staff Spreadsheet
				</a>
			</li>
		</ul>
		<!---CONTROL TABS END-->

		<div class="tab-content">
		<br>

			<!-- TREASURER UPLOAD -->
			<div class="tab-pane box active" id="treasurer" style="padding: 15px">
				<div class="box-content">
					<p><strong>CSV Format (there should be headers):</strong> Each row must have exactly 4 columns in this order:<br>
					<code>employeeno, fullname, idnumber, amount</code><br>
					We attempt to match by employee number or ID number and insert a statement per matched member.</p>
					<?php echo form_open(base_url() . 'index.php?burial/upload_spreadsheet_do', array('class' => 'form-horizontal','enctype'=>'multipart/form-data'));?>
					<input type="hidden" name="upload_type" value="treasurer" />
					<div class="form-group">
						<label class="col-md-3 control-label">Month</label>
						<div class="col-md-5">
							<select name="month" class="form-control month-select" required>
								<option value="">Select month</option>
								<?php
								for ($i = 0; $i < 36; $i++) {
									$val = date('Y-m', strtotime("-{$i} months"));
									$label = date('F Y', strtotime("-{$i} months"));
									echo "<option value=\"{$val}\">{$label}</option>";
								}
								?>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label">CSV File</label>
						<div class="col-md-5">
							<input type="file" name="csv_file" accept=".csv" required />
						</div>
						<div class="col-md-4">
							<button type="submit" class="btn btn-primary">Upload Treasurer CSV</button>
						</div>
					</div>
					</form>
				</div>
			</div>

			<!-- SNAT STAFF UPLOAD -->
			<div class="tab-pane box" id="snat" style="padding: 15px">
				<div class="box-content">
					<p><strong>CSV Format (there should be headers):</strong> Each row must have exactly 4 columns in this order:<br>
					<code>employeeno, fullname, idnumber, amount</code><br>
					The system will match members by ID or Employee number and create statements.</p>
					<?php echo form_open(base_url() . 'index.php?burial/upload_spreadsheet_do', array('class' => 'form-horizontal','enctype'=>'multipart/form-data'));?>
					<input type="hidden" name="upload_type" value="snat" />
					<div class="form-group">
						<label class="col-md-3 control-label">Month</label>
						<div class="col-md-9">
							<select name="month" class="form-control month-select" required>
								<option value="">Select month</option>
								<?php
								for ($i = 0; $i < 36; $i++) {
									$val = date('Y-m', strtotime("-{$i} months"));
									$label = date('F Y', strtotime("-{$i} months"));
									echo "<option value=\"{$val}\">{$label}</option>";
								}
								?>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label">CSV File</label>
						<div class="col-md-5">
							<input type="file" name="csv_file" accept=".csv" required />
						</div>
						<div class="col-md-4">
							<button type="submit" class="btn btn-primary">Upload SNAT CSV</button>
						</div>
					</div>
					</form>
				</div>
			</div>

		</div>
	</div>
   </div>
</div>
<script>
$(document).ready(function() {


	// initialize select2 for month selector if available
	if (typeof $.fn.select2 !== 'undefined') {
		$('.month-select').select2({ width: 'resolve', placeholder: 'Select month' });
	}

});
</script>