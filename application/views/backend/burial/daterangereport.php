<?php
	$startdate = isset($startdate) ? $startdate : null;
	$enddate   = isset($enddate) ? $enddate : null;
	$user_id   = isset($user_id) ? (int)$user_id : null;

	$is_user_report = !empty($user_id);

	// Statements (subscriptions/payments)
	$this->db->from('statements');
	if (!empty($startdate)) $this->db->where('date >=', $startdate);
	if (!empty($enddate)) $this->db->where('date <=', $enddate);
	if ($is_user_report) {
		// For per-user reports, user activity is best tracked by created_at + user column
		$this->db->where('user', $user_id);
		if (!empty($startdate)) $this->db->where('created_at >=', $startdate);
		if (!empty($enddate)) $this->db->where('created_at <=', $enddate);
	}
	$statements = $this->db->order_by('date', 'asc')->get()->result_array();

	// Claims
	$this->db->from('claims');
	if ($is_user_report) {
		$this->db->where('processed_by', $user_id);
		if (!empty($startdate)) $this->db->where('created_at >=', $startdate . ' 00:00:00');
		if (!empty($enddate)) $this->db->where('created_at <=', $enddate . ' 23:59:59');
	} else {
		if (!empty($startdate)) $this->db->where('claim_date >=', $startdate);
		if (!empty($enddate)) $this->db->where('claim_date <=', $enddate);
	}
	$claims = $this->db->order_by('claim_date', 'asc')->get()->result_array();

	// Totals
	$statement_total = 0.0;
	$statement_count = count($statements);
	$by_source = [];
	$by_type = [];

	foreach ($statements as $s) {
		$amount = (float)($s['amount'] ?? 0);
		$statement_total += $amount;
		$source = trim((string)($s['source'] ?? ''));
		$type   = trim((string)($s['type'] ?? ''));
		if ($source === '') $source = 'Unknown';
		if ($type === '') $type = 'Unknown';
		$by_source[$source] = ($by_source[$source] ?? 0) + $amount;
		$by_type[$type] = ($by_type[$type] ?? 0) + $amount;
	}

	$claim_total = 0.0;
	$claim_count = count($claims);
	$claims_by_status = [];
	foreach ($claims as $c) {
		$claim_total += (float)($c['amount'] ?? 0);
		$status = trim((string)($c['status'] ?? ''));
		if ($status === '') $status = 'Unknown';
		$claims_by_status[$status] = ($claims_by_status[$status] ?? 0) + 1;
	}

	// Optional: resolve user label
	$user_label = null;
	if ($is_user_report) {
		$u = $this->db->get_where('admin', ['id' => $user_id])->row_array();
		$user_label = $u ? ($u['name'] ?? ('User ' . $user_id)) : ('User ' . $user_id);
	}
?>

<div class="row">
	<div class="col-md-12">
		<section class="panel">
			<header class="panel-heading">
				<h2 class="panel-title">
					<?php if ($is_user_report): ?>
						Per User Report: <?php echo htmlspecialchars($user_label, ENT_QUOTES, 'UTF-8'); ?>
					<?php else: ?>
						Date Range Report
					<?php endif; ?>
					<?php if ($startdate && $enddate): ?>
						<small style="display:block; margin-top:6px; color:#666;">
							<?php echo htmlspecialchars($startdate); ?> to <?php echo htmlspecialchars($enddate); ?>
						</small>
					<?php endif; ?>
				</h2>
			</header>
			<div class="panel-body">

				<div class="row">
					<div class="col-md-4">
						<div class="alert alert-info">
							<strong>Statements</strong><br>
							Count: <?php echo (int)$statement_count; ?><br>
							Total: E <?php echo number_format($statement_total, 2); ?>
						</div>
					</div>
					<div class="col-md-4">
						<div class="alert alert-warning">
							<strong>Claims</strong><br>
							Count: <?php echo (int)$claim_count; ?><br>
							Total: E <?php echo number_format($claim_total, 2); ?>
						</div>
					</div>
					<div class="col-md-4">
						<div class="alert alert-success">
							<strong>Net</strong><br>
							Statements - Claims<br>
							E <?php echo number_format($statement_total - $claim_total, 2); ?>
						</div>
					</div>
				</div>

				<div class="row" style="margin-top: 10px;">
					<div class="col-md-6">
						<h4>Statements by Source</h4>
						<table class="table table-bordered table-condensed">
							<thead>
								<tr>
									<th>Source</th>
									<th style="text-align:right;">Total (E)</th>
								</tr>
							</thead>
							<tbody>
								<?php if (empty($by_source)): ?>
									<tr><td colspan="2">No statements found.</td></tr>
								<?php else: ?>
									<?php foreach ($by_source as $src => $amt): ?>
										<tr>
											<td><?php echo htmlspecialchars($src, ENT_QUOTES, 'UTF-8'); ?></td>
											<td style="text-align:right;"><?php echo number_format($amt, 2); ?></td>
										</tr>
									<?php endforeach; ?>
								<?php endif; ?>
							</tbody>
						</table>
					</div>
					<div class="col-md-6">
						<h4>Statements by Type</h4>
						<table class="table table-bordered table-condensed">
							<thead>
								<tr>
									<th>Type</th>
									<th style="text-align:right;">Total (E)</th>
								</tr>
							</thead>
							<tbody>
								<?php if (empty($by_type)): ?>
									<tr><td colspan="2">No statements found.</td></tr>
								<?php else: ?>
									<?php foreach ($by_type as $type => $amt): ?>
										<tr>
											<td><?php echo htmlspecialchars($type, ENT_QUOTES, 'UTF-8'); ?></td>
											<td style="text-align:right;"><?php echo number_format($amt, 2); ?></td>
										</tr>
									<?php endforeach; ?>
								<?php endif; ?>
							</tbody>
						</table>
					</div>
				</div>

				<h4 style="margin-top: 20px;">Statements (Detail)</h4>
				<table class="table table-bordered table-striped table-condensed">
					<thead>
						<tr>
							<th>#</th>
							<th>Date</th>
							<th>Member</th>
							<th>Description</th>
							<th>Type</th>
							<th>Source</th>
							<th style="text-align:right;">Amount (E)</th>
							<?php if ($is_user_report): ?>
								<th>Captured</th>
							<?php endif; ?>
						</tr>
					</thead>
					<tbody>
						<?php if (empty($statements)): ?>
							<tr><td colspan="<?php echo $is_user_report ? 8 : 7; ?>">No statements found.</td></tr>
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
									<?php if ($is_user_report): ?>
										<td><?php echo htmlspecialchars($s['created_at'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
									<?php endif; ?>
								</tr>
							<?php endforeach; ?>
						<?php endif; ?>
					</tbody>
				</table>

				<h4 style="margin-top: 20px;">Claims (Detail)</h4>
				<table class="table table-bordered table-striped table-condensed">
					<thead>
						<tr>
							<th>#</th>
							<th>Claim Date</th>
							<th>Member</th>
							<th>Claim Type</th>
							<th>Claimant</th>
							<th>Status</th>
							<th style="text-align:right;">Amount (E)</th>
							<?php if ($is_user_report): ?>
								<th>Captured</th>
							<?php endif; ?>
						</tr>
					</thead>
					<tbody>
						<?php if (empty($claims)): ?>
							<tr><td colspan="<?php echo $is_user_report ? 8 : 7; ?>">No claims found.</td></tr>
						<?php else: ?>
							<?php $i = 1; foreach ($claims as $c): ?>
								<?php
									$m = $this->db->get_where('members', ['id' => (int)$c['member_id']])->row_array();
									$mname = $m ? trim(($m['surname'] ?? '') . ' ' . ($m['name'] ?? '')) : '-';
									$claimant = '-';
									if (($c['claim_type'] ?? '') === 'BENEFICIARY' && !empty($c['beneficiary_id'])) {
										$b = $this->db->get_where('beneficiaries', ['id' => (int)$c['beneficiary_id']])->row_array();
										$claimant = $b ? ($b['fullname'] ?? '-') : '-';
									} elseif (!empty($c['nominee_id'])) {
										$n = $this->db->get_where('nominee', ['id' => (int)$c['nominee_id']])->row_array();
										$claimant = $n ? ($n['fullname'] ?? '-') : 'Member Claim';
									} else {
										$claimant = 'Member Claim';
									}
								?>
								<tr>
									<td><?php echo $i++; ?></td>
									<td><?php echo htmlspecialchars($c['claim_date'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
									<td><?php echo htmlspecialchars($mname, ENT_QUOTES, 'UTF-8'); ?></td>
									<td><?php echo htmlspecialchars($c['claim_type'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
									<td><?php echo htmlspecialchars($claimant, ENT_QUOTES, 'UTF-8'); ?></td>
									<td><?php echo htmlspecialchars($c['status'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
									<td style="text-align:right;"><?php echo number_format((float)($c['amount'] ?? 0), 2); ?></td>
									<?php if ($is_user_report): ?>
										<td><?php echo htmlspecialchars($c['created_at'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
									<?php endif; ?>
								</tr>
							<?php endforeach; ?>
						<?php endif; ?>
					</tbody>
				</table>

			</div>
		</section>
	</div>
</div>