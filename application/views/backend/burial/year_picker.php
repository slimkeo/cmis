<div class="row">
	<div class="col-md-12">
		<section class="panel">
			<header class="panel-heading">
				<div class="panel-actions">
					<a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
					<a href="#" class="panel-action panel-action-dismiss" data-panel-dismiss></a>
				</div>
				<h2 class="panel-title">Yearly Report</h2>
			</header>
			<div class="panel-body">
				<?php
					$currentYear = (int)date('Y');
					echo form_open(base_url() . 'index.php?burial/yearlyreport/', [
						'class' => 'form-horizontal form-bordered validate',
						'target' => '_top'
					]);
				?>

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
						<div class="col-sm-offset-3 col-sm-5">
							<button type="submit" class="btn btn-primary btn-sm">
								<i class="fa fa-search"></i> View Yearly Report
							</button>
						</div>
					</div>

				</form>
			</div>
		</section>
	</div>
</div>