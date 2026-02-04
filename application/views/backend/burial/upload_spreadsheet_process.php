<div class="row">
	<div class="col-md-8 col-md-offset-2">
		<div class="box">
			<div class="box-header with-border">
				<h3 class="box-title">Processing CSV Upload</h3>
			</div>
			<div class="box-body">
				<p>Your CSV file is being processed in batches to handle the large volume of data...</p>
				
				<!-- Progress Bar -->
				<div class="progress">
					<div class="progress-bar progress-bar-striped active" id="progressBar" role="progressbar" style="width: 0%">
						<span id="progressText">0%</span>
					</div>
				</div>

				<!-- Status Messages -->
				<div id="statusMessages">
					<p>Starting upload process...</p>
				</div>

				<!-- Duplicate Month Warning -->
				<div id="duplicateWarning" style="display: none;" class="alert alert-warning">
					<strong>⚠️ Warning:</strong> This month has already been uploaded before. 
					Duplicate records for members will be automatically skipped.
				</div>

				<!-- Results -->
				<div id="resultsContainer" style="display: none; margin-top: 20px;">
					<div class="alert alert-success" id="successAlert" style="display: none;"></div>
					<div class="alert alert-warning" id="warningAlert" style="display: none;"></div>
					
					<table class="table table-condensed" id="resultsTable">
						<tr>
							<td><strong>Total Inserted:</strong></td>
							<td id="totalInserted">0</td>
						</tr>
						<tr>
							<td><strong>Total Skipped:</strong></td>
							<td id="totalSkipped">0</td>
						</tr>
						<tr>
							<td><strong>Not Matched:</strong></td>
							<td id="totalMissing">0</td>
						</tr>
					</table>

					<!-- Missing Members List -->
					<div id="missingContainer" style="display: none; margin-top: 20px;">
						<h5>Sample of Unmatched Records (First 10)</h5>
						<table class="table table-condensed table-striped">
							<thead>
								<tr>
									<th>Employee No</th>
									<th>ID Number</th>
									<th>Name</th>
								</tr>
							</thead>
							<tbody id="missingTableBody">
							</tbody>
						</table>
					</div>

					<div style="margin-top: 20px;">
						<a href="<?php echo base_url() ?>index.php?burial/upload_spreadsheet" class="btn btn-primary">
							<i class="fa fa-arrow-left"></i> Back to Upload
						</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script>
$(document).ready(function() {
	var sessionId = '<?php echo $session_id; ?>';
	var offset = 0;
	var totalInserted = 0;
	var totalSkipped = 0;
	var totalMissing = 0;
	var allMissing = [];
	var isProcessing = true;

	// Start processing chunks
	processChunk();

	function processChunk() {
		if (!isProcessing) return;

		$.ajax({
			url: '<?php echo base_url() ?>index.php?burial/upload_spreadsheet_chunk',
			type: 'POST',
			dataType: 'json',
			data: {
				session_id: sessionId,
				offset: offset
			},
			success: function(response) {
				if (response.success) {
					// Show duplicate warning if applicable
					if (response.is_duplicate_month && offset === 0) {
						$('#duplicateWarning').show();
					}

					// Accumulate totals
					totalInserted += response.inserted;
					totalSkipped += response.skipped;
					totalMissing += response.missing_count;
					
					// Store missing records
					if (response.missing.length > 0) {
						allMissing = allMissing.concat(response.missing);
					}

					// Update progress
					var percentComplete = Math.min(Math.round((offset + response.rows_processed) / 15000 * 100), 95);
					updateProgress(percentComplete);

					// Add status message
					addStatusMessage(
						'✓ Processed batch: ' + response.rows_processed + ' rows | ' +
						'Inserted: ' + response.inserted + ' | ' +
						'Skipped: ' + response.skipped
					);

					// Check if more rows to process
					if (response.has_more) {
						offset = response.next_offset;
						// Wait a moment before next batch to avoid overwhelming server
						setTimeout(processChunk, 500);
					} else {
						// All done
						completeProcessing();
					}
				} else {
					addStatusMessage('❌ Error: ' + response.error, 'error');
					isProcessing = false;
				}
			},
			error: function(xhr, status, error) {
				addStatusMessage('❌ Request failed: ' + error, 'error');
				isProcessing = false;
			}
		});
	}

	function updateProgress(percent) {
		$('#progressBar').css('width', percent + '%');
		$('#progressText').text(percent + '%');
	}

	function addStatusMessage(msg, type) {
		var className = (type === 'error') ? 'text-danger' : 'text-success';
		$('#statusMessages').append('<p class="' + className + '"><small>' + msg + '</small></p>');
	}

	function completeProcessing() {
		isProcessing = false;
		
		// Update progress to 100%
		updateProgress(100);
		$('#progressBar').removeClass('active');
		
		// Update totals
		$('#totalInserted').text(totalInserted);
		$('#totalSkipped').text(totalSkipped);
		$('#totalMissing').text(totalMissing);

		// Build success/warning messages
		var successMsg = '<strong>✓ Upload Complete!</strong><br>' +
			totalInserted + ' statement(s) successfully inserted.';
		
		if (totalSkipped > 0) {
			successMsg += '<br>' + totalSkipped + ' row(s) skipped (empty/invalid).';
		}

		if (totalMissing > 0) {
			successMsg += '<br>' + totalMissing + ' row(s) could not be matched to members.';
		}

		$('#successAlert').html(successMsg).show();

		// Show missing records if any
		if (allMissing.length > 0) {
			$('#missingContainer').show();
			allMissing.slice(0, 10).forEach(function(record) {
				var row = '<tr>' +
					'<td>' + (record.employeeno || '-') + '</td>' +
					'<td>' + (record.idnumber || '-') + '</td>' +
					'<td>' + (record.fullname || '-') + '</td>' +
					'</tr>';
				$('#missingTableBody').append(row);
			});
		}

		// Show results
		$('#resultsContainer').show();

		// Clean up temp file on server
		$.ajax({
			url: '<?php echo base_url() ?>index.php?burial/upload_spreadsheet_finish',
			type: 'POST',
			dataType: 'json',
			data: {
				session_id: sessionId
			}
		});

		addStatusMessage('✓ Processing complete!');
	}
});
</script>
