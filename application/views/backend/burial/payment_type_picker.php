<div class="row">
	<div class="col-md-12">
		<section class="panel">
			<header class="panel-heading">
				<div class="panel-actions">
					<a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
					<a href="#" class="panel-action panel-action-dismiss" data-panel-dismiss></a>
				</div>
				<h2 class="panel-title">Payment Type Report</h2>
			</header>
			<div class="panel-body">
				<?php
					$valid_sources = ['Stop Order', 'EFT', 'Deposit', 'Cash', 'Treasure', 'SNAT Employee', 'Momo'];
					echo form_open(base_url() . 'index.php?burial/payment_type_report/', [
						'class' => 'form-horizontal form-bordered validate',
						'target' => '_top'
					]);
				?>

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
						<label class="col-md-3 control-label">Payment Type</label>
						<div class="col-md-6">
							<select name="payment_type" class="form-control" required>
								<option value="">-- Select Payment Type --</option>
								<?php foreach ($valid_sources as $src): ?>
									<option value="<?php echo htmlspecialchars($src, ENT_QUOTES, 'UTF-8'); ?>">
										<?php echo htmlspecialchars($src); ?>
									</option>
								<?php endforeach; ?>
							</select>
							<small class="text-muted">Matches `statements.source`</small>
						</div>
					</div>

					<div class="form-group">
						<div class="col-sm-offset-3 col-sm-5">
							<button type="submit" class="btn btn-primary btn-sm">
								<i class="fa fa-search"></i> View Report
							</button>
						</div>
					</div>

				</form>
			</div>
		</section>
	</div>
</div>