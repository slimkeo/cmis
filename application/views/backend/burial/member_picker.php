<?php
	$members = $this->db
		->select('id, surname, name, idnumber, passbook, employee')
		->order_by('surname', 'asc')
		->get('members')
		->result_array();
?>

<div class="row">
	<div class="col-md-12">
		<section class="panel">
			<header class="panel-heading">
				<div class="panel-actions">
					<a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
					<a href="#" class="panel-action panel-action-dismiss" data-panel-dismiss></a>
				</div>
				<h2 class="panel-title">Member Report</h2>
			</header>
			<div class="panel-body">
				<?php echo form_open(base_url() . 'index.php?burial/memberreport/' , array('class' => 'form-horizontal form-bordered validate','target'=>'_top'));?>

					<div class="form-group">
						<label class="col-md-3 control-label">Member</label>
						<div class="col-md-6">
							<select name="memberid" class="form-control" required>
								<option value="">-- Select Member --</option>
								<?php foreach ($members as $m): ?>
									<option value="<?php echo (int)$m['id']; ?>">
										<?php
											$label = trim(($m['surname'] ?? '') . ' ' . ($m['name'] ?? ''));
											$meta = [];
											if (!empty($m['idnumber'])) $meta[] = 'ID ' . $m['idnumber'];
											if (!empty($m['passbook'])) $meta[] = 'PB ' . $m['passbook'];
											if (!empty($m['employee'])) $meta[] = 'EMP ' . $m['employee'];
											echo htmlspecialchars($label . (empty($meta) ? '' : ' (' . implode(' | ', $meta) . ')'), ENT_QUOTES, 'UTF-8');
										?>
									</option>
								<?php endforeach; ?>
							</select>
						</div>
					</div>

					<div class="form-group">
						<label class="col-md-3 control-label">Date Range</label>
						<div class="col-md-6">
							<div class="input-daterange input-group" data-plugin-datepicker>
								<span class="input-group-addon">
									<i class="fa fa-calendar"></i>
								</span>
								<input type="text" class="form-control" name="startdate" placeholder="Start date" required>
								<span class="input-group-addon">To</span>
								<input type="text" class="form-control" name="enddate" placeholder="End date" required>
							</div>
						</div>
					</div>

					<div class="form-group">
						<div class="col-sm-offset-3 col-sm-5">
							<button type="submit" class="btn btn-primary btn-sm">
								<i class="fa fa-search"></i> View Member Report
							</button>
						</div>
					</div>

				</form>
			</div>
		</section>
	</div>
</div>
