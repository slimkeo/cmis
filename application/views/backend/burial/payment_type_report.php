<?php
	$startdate = isset($startdate) ? $startdate : null;
	$enddate   = isset($enddate) ? $enddate : null;
	$payment_type = isset($payment_type) ? $payment_type : null;

	$this->db->from('statements');
	if (!empty($startdate)) $this->db->where('date >=', $startdate);
	if (!empty($enddate)) $this->db->where('date <=', $enddate);
	if (!empty($payment_type)) $this->db->where('source', $payment_type);
	$statements = $this->db->order_by('date', 'asc')->get()->result_array();

	$total = 0.0;
	foreach ($statements as $s) $total += (float)($s['amount'] ?? 0);
?>

<div class="row">
	<div class="col-md-12">
		<section class="panel">
			<header class="panel-heading">
				<h2 class="panel-title">
					Payment Type Report
					<?php if (!empty($payment_type)): ?>
						: <?php echo htmlspecialchars($payment_type, ENT_QUOTES, 'UTF-8'); ?>
					<?php endif; ?>
					<?php if ($startdate && $enddate): ?>
						<small style="display:block; margin-top:6px; color:#666;">
							<?php echo htmlspecialchars($startdate); ?> to <?php echo htmlspecialchars($enddate); ?>
						</small>
					<?php endif; ?>
				</h2>
			</header>
			<div class="panel-body">
				<div class="alert alert-info">
					<strong>Total</strong>: E <?php echo number_format($total, 2); ?>
					&nbsp; | <strong>Count</strong>: <?php echo count($statements); ?>
				</div>

				<table class="table table-bordered table-striped table-condensed" id="datatable-tabletools">
					<thead>
						<tr>
							<th>#</th>
							<th>Date</th>
							<th>Member</th>
							<th>Description</th>
							<th>Type</th>
							<th>Source</th>
							<th style="text-align:right;">Amount (E)</th>
						</tr>
					</thead>
					<tbody>
						<?php if (empty($statements)): ?>
							<tr><td colspan="7">No statements found.</td></tr>
						<?php else: ?>
							<?php $i = 1; foreach ($statements as $s): ?>
								<?php
									$m = null;
									if (!empty($s['memberid'])) {
										$m = $this->db->get_where('members', ['id' => (int)$s['memberid']])->row_array();
									}
									$mname = $m ? trim(($m['surname'] ?? '') . ' ' . ($m['name'] ?? '')) : '-';
								?>
								<tr>
									<td><?php echo $i++; ?></td>
									<td><?php echo htmlspecialchars($s['date'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
									<td><?php echo htmlspecialchars($mname, ENT_QUOTES, 'UTF-8'); ?></td>
									<td><?php echo htmlspecialchars($s['description'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
									<td><?php echo htmlspecialchars($s['type'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
									<td><?php echo htmlspecialchars($s['source'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
									<td style="text-align:right;"><?php echo number_format((float)($s['amount'] ?? 0), 2); ?></td>
								</tr>
							<?php endforeach; ?>
						<?php endif; ?>
					</tbody>
				</table>
			</div>
		</section>
	</div>
</div>

