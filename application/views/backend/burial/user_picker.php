<?php
	// System users are stored in `admin`
	$users = $this->db
		->select('id, name, email')
		->order_by('name', 'asc')
		->get('admin')
		->result_array();
	$currentYear = (int)date('Y');
?>

<div class="row">
	<div class="col-md-12">
		<section class="panel">
			<header class="panel-heading">
				<div class="panel-actions">
					<a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
					<a href="#" class="panel-action panel-action-dismiss" data-panel-dismiss></a>
				</div>
				<h2 class="panel-title">Per User Report</h2>
			</header>
			<div class="panel-body">
				<?php echo form_open(base_url() . 'index.php?burial/userreport/' , array('class' => 'form-horizontal form-bordered validate','target'=>'_top'));?>

					<div class="form-group">
						<label class="col-md-3 control-label">Year</label>
						<div class="col-md-6">
							<select name="year" class="form-control" required>
								<option value="">-- Select Year --</option>
								<?php for ($y = $currentYear; $y >= $currentYear - 10; $y--): ?>
									<option value="<?php echo $y; ?>"><?php echo $y; ?></option>
								<?php endfor; ?>
							</select>
						</div>
					</div>

					<div class="form-group">
						<label class="col-md-3 control-label">User</label>
						<div class="col-md-6">
							<select name="user_id" class="form-control" required>
								<option value="">-- Select User --</option>
								<?php foreach ($users as $u): ?>
									<option value="<?php echo (int)$u['id']; ?>">
										<?php
											$label = $u['name'] ?? ('User ' . $u['id']);
											$email = $u['email'] ?? '';
											echo htmlspecialchars($label . ($email ? ' (' . $email . ')' : ''), ENT_QUOTES, 'UTF-8');
										?>
									</option>
								<?php endforeach; ?>
							</select>
						</div>
					</div>

					<div class="form-group">
						<div class="col-sm-offset-3 col-sm-5">
							<button type="submit" class="btn btn-primary btn-sm">
								<i class="fa fa-search"></i> View User Report
							</button>
						</div>
					</div>

				</form>
			</div>
		</section>
	</div>
</div>
