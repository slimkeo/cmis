<?php
	$memberid  = isset($memberid) ? (int)$memberid : 0;
	$startdate = isset($startdate) ? $startdate : null;
	$enddate   = isset($enddate) ? $enddate : null;

	$member = $memberid ? $this->db->get_where('members', ['id' => $memberid])->row_array() : null;
	$member_name = $member ? trim(($member['surname'] ?? '') . ' ' . ($member['name'] ?? '')) : 'Unknown Member';

	// Statements for this member in range
	$this->db->from('statements')->where('memberid', $memberid);
	if (!empty($startdate)) $this->db->where('date >=', $startdate);
	if (!empty($enddate)) $this->db->where('date <=', $enddate);
	$statements = $this->db->order_by('date', 'asc')->get()->result_array();

	// Claims for this member in range
	$this->db->from('claims')->where('member_id', $memberid);
	if (!empty($startdate)) $this->db->where('claim_date >=', $startdate);
	if (!empty($enddate)) $this->db->where('claim_date <=', $enddate);
	$claims = $this->db->order_by('claim_date', 'asc')->get()->result_array();

	$statement_total = 0.0;
	foreach ($statements as $s) $statement_total += (float)($s['amount'] ?? 0);

	$claim_total = 0.0;
	foreach ($claims as $c) $claim_total += (float)($c['amount'] ?? 0);
?>

<div class="row">
	<div class="col-md-12">
		<section class="panel">
			<header class="panel-heading">
				<h2 class="panel-title">
					Member Report: <?php echo htmlspecialchars($member_name, ENT_QUOTES, 'UTF-8'); ?>
					<?php if ($startdate && $enddate): ?>
						<small style="display:block; margin-top:6px; color:#666;">
							<?php echo htmlspecialchars($startdate); ?> to <?php echo htmlspecialchars($enddate); ?>
						</small>
					<?php endif; ?>
				</h2>
			</header>
			<div class="panel-body">
				<?php if ($member): ?>
					<div class="alert alert-info">
						<strong>Member:</strong> <?php echo htmlspecialchars($member_name, ENT_QUOTES, 'UTF-8'); ?>
						<?php if (!empty($member['idnumber'])): ?>
							&nbsp; | <strong>ID:</strong> <?php echo htmlspecialchars($member['idnumber'], ENT_QUOTES, 'UTF-8'); ?>
						<?php endif; ?>
						<?php if (!empty($member['passbook'])): ?>
							&nbsp; | <strong>Passbook:</strong> <?php echo htmlspecialchars($member['passbook'], ENT_QUOTES, 'UTF-8'); ?>
						<?php endif; ?>
						<?php if (!empty($member['employee'])): ?>
							&nbsp; | <strong>Employee:</strong> <?php echo htmlspecialchars($member['employee'], ENT_QUOTES, 'UTF-8'); ?>
						<?php endif; ?>
					</div>
				<?php endif; ?>

				<div class="row">
					<div class="col-md-4">
						<div class="alert alert-success">
							<strong>Statements Total</strong><br>
							E <?php echo number_format($statement_total, 2); ?><br>
							Count: <?php echo count($statements); ?>
						</div>
					</div>
					<div class="col-md-4">
						<div class="alert alert-warning">
							<strong>Claims Total</strong><br>
							E <?php echo number_format($claim_total, 2); ?><br>
							Count: <?php echo count($claims); ?>
						</div>
					</div>
					<div class="col-md-4">
						<div class="alert alert-info">
							<strong>Net</strong><br>
							E <?php echo number_format($statement_total - $claim_total, 2); ?>
						</div>
					</div>
				</div>

				<h4>Statements</h4>
				<table class="table table-bordered table-striped table-condensed">
					<thead>
						<tr>
							<th>#</th>
							<th>Date</th>
							<th>Description</th>
							<th>Type</th>
							<th>Source</th>
							<th style="text-align:right;">Amount (E)</th>
						</tr>
					</thead>
					<tbody>
						<?php if (empty($statements)): ?>
							<tr><td colspan="6">No statements found.</td></tr>
						<?php else: ?>
							<?php $i = 1; foreach ($statements as $s): ?>
								<tr>
									<td><?php echo $i++; ?></td>
									<td><?php echo htmlspecialchars($s['date'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
									<td><?php echo htmlspecialchars($s['description'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
									<td><?php echo htmlspecialchars($s['type'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
									<td><?php echo htmlspecialchars($s['source'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
									<td style="text-align:right;"><?php echo number_format((float)($s['amount'] ?? 0), 2); ?></td>
								</tr>
							<?php endforeach; ?>
						<?php endif; ?>
					</tbody>
				</table>

				<h4>Claims</h4>
				<table class="table table-bordered table-striped table-condensed">
					<thead>
						<tr>
							<th>#</th>
							<th>Claim Date</th>
							<th>Claim Type</th>
							<th>Claimant</th>
							<th>Status</th>
							<th style="text-align:right;">Amount (E)</th>
						</tr>
					</thead>
					<tbody>
						<?php if (empty($claims)): ?>
							<tr><td colspan="6">No claims found.</td></tr>
						<?php else: ?>
							<?php $i = 1; foreach ($claims as $c): ?>
								<?php
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
									<td><?php echo htmlspecialchars($c['claim_type'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
									<td><?php echo htmlspecialchars($claimant, ENT_QUOTES, 'UTF-8'); ?></td>
									<td><?php echo htmlspecialchars($c['status'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
									<td style="text-align:right;"><?php echo number_format((float)($c['amount'] ?? 0), 2); ?></td>
								</tr>
							<?php endforeach; ?>
						<?php endif; ?>
					</tbody>
				</table>

			</div>
		</section>
	</div>
</div>