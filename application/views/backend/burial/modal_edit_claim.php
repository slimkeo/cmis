<?php
$edit_data = $this->db->get_where('claims', array('id' => $param2))->result_array();
foreach ($edit_data as $row):

    // Banks enum
    if (isset($this->Enum_model) && method_exists($this->Enum_model, 'get_enum_values')) {
        $enum_banks = $this->Enum_model->get_enum_values('claims', 'bank');
        $enum_status = $this->Enum_model->get_enum_values('claims', 'status');
    } else {
        $bank_col = $this->db->query("SHOW COLUMNS FROM `claims` LIKE 'bank'")->row();
        $status_col = $this->db->query("SHOW COLUMNS FROM `claims` LIKE 'status'")->row();
        $enum_banks = [];
        $enum_status = [];
        if ($bank_col && preg_match("/^enum\((.*)\)$/", $bank_col->Type, $m)) {
            $enum_banks = explode(",", str_replace("'", "", $m[1]));
        }
        if ($status_col && preg_match("/^enum\((.*)\)$/", $status_col->Type, $m)) {
            $enum_status = explode(",", str_replace("'", "", $m[1]));
        }
        if (empty($enum_status)) {
            $enum_status = ['PENDING', 'APPROVED', 'REJECTED', 'PAID'];
        }
    }

    $member = $this->db->get_where('members', array('id' => $row['member_id']))->row_array();
    $claim_type = !empty($row['claim_type']) ? $row['claim_type'] : 'BENEFICIARY';
    $is_beneficiary = ($claim_type === 'BENEFICIARY');

    // Prefill beneficiaries / nominees for current member
    $beneficiaries = [];
    $nominees = [];
    if (!empty($row['member_id'])) {
        $beneficiaries = $this->db->get_where('beneficiaries', ['member_id' => $row['member_id']])->result_array();
        $nominees = $this->db->get_where('nominee', ['member_id' => $row['member_id']])->result_array();
    }

    // Ensure current beneficiary is in the list even if filtered out elsewhere
    if (!empty($row['beneficiary_id'])) {
        $current_ben = $this->db->get_where('beneficiaries', ['id' => $row['beneficiary_id']])->row_array();
        if ($current_ben) {
            $found = false;
            foreach ($beneficiaries as $b) {
                if ($b['id'] == $current_ben['id']) { $found = true; break; }
            }
            if (!$found) {
                $beneficiaries[] = $current_ben;
            }
        }
    }
?>
<div class="row">
  <div class="col-md-12">
    <section class="panel">

      <?php echo form_open(base_url() . 'index.php?burial/claims/do_update/'.$row['id'] , array('class' => 'form-horizontal form-bordered','target'=>'_top', 'id' => 'edit_claim_form', 'enctype' => 'multipart/form-data'));?>

      <div class="panel-heading">
        <h4 class="panel-title">
          <i class="fa fa-pencil-square"></i>
          Edit Claim #<?php echo htmlspecialchars($row['id']); ?>
        </h4>
      </div>

      <div class="panel-body">

        <!-- CLAIM TYPE -->
        <div class="form-group">
          <label class="col-md-3 control-label">Claim Type <span class="required">*</span></label>
          <div class="col-md-7">
            <div class="radio">
              <label>
                <input type="radio" name="claim_type" id="edit_claim_type_beneficiary" value="BENEFICIARY" <?php echo $is_beneficiary ? 'checked' : ''; ?> required>
                Beneficiary Claim
              </label>
            </div>
            <div class="radio">
              <label>
                <input type="radio" name="claim_type" id="edit_claim_type_member" value="NOMINEE" <?php echo !$is_beneficiary ? 'checked' : ''; ?> required>
                Member/Policy Holder Claim (Nominee)
              </label>
            </div>
          </div>
        </div>

        <!-- SEARCH MEMBER -->
        <div class="form-group">
          <label class="col-md-3 control-label">Search Member <span class="required">*</span></label>
          <div class="col-md-7">
            <div style="position: relative;">
              <input type="text" class="form-control" id="edit_member_search"
                value="<?php echo $member ? htmlspecialchars(($member['surname'] ?? '') . ' ' . ($member['name'] ?? '')) : ''; ?>"
                placeholder="Search by ID, Name, Passbook, Employee No" required>
              <small class="form-text text-muted">Start typing to search for another member</small>
              <div id="edit_member_search_results" style="position: absolute; top: 100%; left: 0; right: 0; background: white; border: 1px solid #ddd; border-top: none; border-radius: 0 0 4px 4px; max-height: 300px; overflow-y: auto; z-index: 1000; display: none; box-shadow: 0 4px 6px rgba(0,0,0,0.1);"></div>
            </div>
          </div>
        </div>

        <!-- SELECTED MEMBER INFO -->
        <div class="form-group">
          <label class="col-md-3 control-label">Selected Member</label>
          <div class="col-md-7">
            <div class="alert alert-info" id="edit_member_info" style="<?php echo $member ? '' : 'display: none;'; ?>">
              <strong>ID Number:</strong> <span id="edit_member_idnumber"><?php echo htmlspecialchars($member['idnumber'] ?? ''); ?></span> <br>
              <strong>Name:</strong> <span id="edit_member_name"><?php echo $member ? htmlspecialchars(($member['surname'] ?? '') . ' ' . ($member['name'] ?? '')) : ''; ?></span> <br>
              <strong>Passbook No:</strong> <span id="edit_member_passbook"><?php echo htmlspecialchars($member['passbook_no'] ?? 'N/A'); ?></span> <br>
              <strong>Cell Number:</strong> <span id="edit_member_cell"><?php echo htmlspecialchars($member['cellnumber'] ?? ''); ?></span>
            </div>
            <input type="hidden" id="edit_selected_member_id" name="member_id" value="<?php echo htmlspecialchars($row['member_id'] ?? ''); ?>" required>
          </div>
        </div>

        <!-- NOMINEE -->
        <div class="form-group" id="edit_nominee_group" style="<?php echo $is_beneficiary ? 'display: none;' : ''; ?>">
          <label class="col-md-3 control-label">Nominee <span class="required">*</span></label>
          <div class="col-md-7">
            <select class="form-control" id="edit_nominee_select" name="nominee_id" <?php echo $is_beneficiary ? '' : 'required'; ?>>
              <option value="">-- Select Nominee --</option>
              <?php foreach ($nominees as $nominee): ?>
                <option value="<?php echo $nominee['id']; ?>" <?php echo ($row['nominee_id'] == $nominee['id']) ? 'selected' : ''; ?>>
                  <?php echo htmlspecialchars($nominee['fullname']); ?>
                </option>
              <?php endforeach; ?>
            </select>
            <small class="form-text text-muted">Select a nominee for this member claim</small>
          </div>
        </div>

        <!-- BENEFICIARY -->
        <div class="form-group" id="edit_beneficiary_group" style="<?php echo $is_beneficiary ? '' : 'display: none;'; ?>">
          <label class="col-md-3 control-label">Beneficiary <span class="required">*</span></label>
          <div class="col-md-7">
            <select class="form-control" id="edit_beneficiary_select" name="beneficiary_id" <?php echo $is_beneficiary ? 'required' : 'disabled'; ?>>
              <option value="">-- Select Beneficiary --</option>
              <?php foreach ($beneficiaries as $ben): ?>
                <?php if (in_array(trim($ben['status'] ?? ''), ['DELETED'], true) && $ben['id'] != $row['beneficiary_id']) continue; ?>
                <option value="<?php echo $ben['id']; ?>" <?php echo ($row['beneficiary_id'] == $ben['id']) ? 'selected' : ''; ?>>
                  <?php echo htmlspecialchars(($ben['fullname'] ?? '') . ' (' . ($ben['idnumber'] ?? '') . ')'); ?>
                </option>
              <?php endforeach; ?>
            </select>
            <small class="form-text text-muted">Current and available beneficiaries for this member</small>
          </div>
        </div>

        <!-- NATIONAL ID -->
        <div class="form-group">
          <label class="col-md-3 control-label">National ID <span class="required">*</span></label>
          <div class="col-md-7">
            <input type="text" class="form-control" name="national_id" required
              value="<?php echo htmlspecialchars($row['national_id'] ?? ''); ?>">
          </div>
        </div>

        <!-- MORTUARY -->
        <div class="form-group">
          <label class="col-md-3 control-label">Mortuary</label>
          <div class="col-md-7">
            <input type="text" class="form-control" name="mortuary"
              value="<?php echo htmlspecialchars($row['mortuary'] ?? ''); ?>">
          </div>
        </div>

        <!-- DATE OF ENTRY -->
        <div class="form-group">
          <label class="col-md-3 control-label">Date of Entry</label>
          <div class="col-md-7">
            <div class="input-group date" data-provide="datepicker" data-date-format="yyyy-mm-dd">
              <input type="text" class="form-control" name="date_of_entry"
                value="<?php echo htmlspecialchars($row['date_of_entry'] ?? ''); ?>"
                placeholder="yyyy-mm-dd">
              <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
            </div>
          </div>
        </div>

        <!-- DATE OF BURIAL -->
        <div class="form-group" id="edit_date_of_burial_group">
          <label class="col-md-3 control-label">Date of Burial</label>
          <div class="col-md-7">
            <div class="input-group date" data-provide="datepicker" data-date-format="yyyy-mm-dd">
              <input type="text" class="form-control" name="date_of_burial" id="edit_date_of_burial"
                value="<?php echo htmlspecialchars($row['date_of_burial'] ?? ''); ?>"
                placeholder="yyyy-mm-dd">
              <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
            </div>
          </div>
        </div>

        <!-- PLACE OF BURIAL -->
        <div class="form-group" id="edit_place_of_burial_group">
          <label class="col-md-3 control-label"><?php echo get_phrase('place_of_burial');?></label>
          <div class="col-md-7">
            <input type="text" class="form-control" name="place_of_burial" id="edit_place_of_burial"
              value="<?php echo htmlspecialchars($row['place_of_burial'] ?? ''); ?>">
          </div>
        </div>

        <!-- BANK -->
        <div class="form-group">
          <label class="col-md-3 control-label"><?php echo get_phrase('bank');?> <span class="required">*</span></label>
          <div class="col-md-7">
            <select name="bank" id="edit_bank_select" class="form-control" required>
              <option value="">-- Select Bank --</option>
              <?php foreach ($enum_banks as $value): ?>
                <option value="<?= $value ?>" <?php echo (($row['bank'] ?? '') === $value) ? 'selected' : ''; ?>>
                  <?= ucfirst($value) ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>
        </div>

        <!-- ACCOUNT -->
        <div class="form-group">
          <label class="col-md-3 control-label"><?php echo get_phrase('account_number');?> <span class="required">*</span></label>
          <div class="col-md-7">
            <input type="number" class="form-control" name="account" required
              value="<?php echo htmlspecialchars($row['account'] ?? ''); ?>" step="0.01" min="0">
          </div>
        </div>

        <!-- AMOUNT -->
        <div class="form-group">
          <label class="col-md-3 control-label"><?php echo get_phrase('amount');?> <span class="required">*</span></label>
          <div class="col-md-7">
            <input type="number" class="form-control" name="amount" required
              value="<?php echo htmlspecialchars($row['amount'] ?? ''); ?>" step="0.01" min="0">
          </div>
        </div>

        <!-- CLAIM DATE -->
        <div class="form-group">
          <label class="col-md-3 control-label"><?php echo get_phrase('claim_date');?></label>
          <div class="col-md-7">
            <input type="text" class="form-control" name="claim_date"
              value="<?php echo htmlspecialchars($row['claim_date'] ?? ''); ?>" readonly>
          </div>
        </div>

        <!-- STATUS -->
        <div class="form-group">
          <label class="col-md-3 control-label">Status <span class="required">*</span></label>
          <div class="col-md-7">
            <select name="status" class="form-control" required>
              <?php foreach ($enum_status as $status_val): ?>
                <option value="<?= $status_val ?>" <?php echo (($row['status'] ?? '') === $status_val) ? 'selected' : ''; ?>>
                  <?= $status_val ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>
        </div>

        <!-- PROCESSED BY (preserve existing) -->
        <input type="hidden" name="processed_by" value="<?php echo htmlspecialchars($row['processed_by'] ?? ''); ?>">

        <!-- NOTES -->
        <div class="form-group">
          <label class="col-md-3 control-label"><?php echo get_phrase('notes');?></label>
          <div class="col-md-7">
            <textarea class="form-control" name="notes" rows="4"><?php echo htmlspecialchars($row['notes'] ?? ''); ?></textarea>
          </div>
        </div>

      </div>

      <footer class="panel-footer">
        <div class="row">
          <div class="col-sm-9 col-sm-offset-3">
            <button type="submit" class="btn btn-primary">Update Claim</button>
          </div>
        </div>
      </footer>
      <?php echo form_close();?>
    </section>
  </div>
</div>

<script>
(function() {
  function loadEditNominees(memberId, selectedId) {
    $.ajax({
      url: '<?php echo base_url('index.php?burial/get_nominees');?>',
      method: 'POST',
      data: {member_id: memberId},
      dataType: 'json',
      success: function(response) {
        var options = '<option value="">-- Select Nominee --</option>';
        if (response.success && response.nominees.length > 0) {
          $.each(response.nominees, function(i, nominee) {
            var sel = (selectedId && String(nominee.id) === String(selectedId)) ? ' selected' : '';
            options += '<option value="' + nominee.id + '"' + sel + '>' + nominee.fullname + '</option>';
          });
        }
        $('#edit_nominee_select').html(options);
      }
    });
  }

  function loadEditBeneficiaries(memberId, selectedId) {
    $.ajax({
      url: '<?php echo base_url('index.php?burial/get_matured_beneficiaries');?>',
      method: 'POST',
      data: {member_id: memberId},
      dataType: 'json',
      success: function(resp) {
        var options = '<option value="">-- Select Beneficiary --</option>';
        var foundSelected = false;
        if (resp.success && resp.beneficiaries.length > 0) {
          $.each(resp.beneficiaries, function(i, ben) {
            var sel = (selectedId && String(ben.id) === String(selectedId)) ? ' selected' : '';
            if (sel) foundSelected = true;
            options += '<option value="' + ben.id + '"' + sel + '>' + ben.fullname + ' (' + ben.idnumber + ')</option>';
          });
        }
        // Keep current selection if not in matured list
        if (selectedId && !foundSelected) {
          var currentText = $('#edit_beneficiary_select option[value="' + selectedId + '"]').text();
          if (currentText) {
            options += '<option value="' + selectedId + '" selected>' + currentText + '</option>';
          }
        }
        $('#edit_beneficiary_select').html(options);
      }
    });
  }

  function applyEditClaimType(claimType) {
    var memberId = $('#edit_selected_member_id').val();
    if (claimType === 'NOMINEE') {
      $('#edit_nominee_group').show();
      $('#edit_beneficiary_group').hide();
      $('#edit_beneficiary_select').prop('disabled', true).prop('required', false);
      $('#edit_nominee_select').prop('required', true);
      if (memberId) loadEditNominees(memberId, '<?php echo $row['nominee_id'] ?? ''; ?>');
    } else {
      $('#edit_nominee_group').hide();
      $('#edit_beneficiary_group').show();
      $('#edit_nominee_select').prop('required', false);
      $('#edit_beneficiary_select').prop('disabled', false).prop('required', true);
    }
  }

  $('#edit_member_search').off('keyup.editClaim').on('keyup.editClaim', function() {
    var search = $(this).val();
    if (search.length < 2) {
      $('#edit_member_search_results').hide();
      return;
    }
    $.ajax({
      url: '<?php echo base_url('index.php?burial/search_members');?>',
      method: 'POST',
      data: {search: search},
      dataType: 'json',
      success: function(response) {
        if (response.success && response.members.length > 0) {
          var resultsHtml = '';
          $.each(response.members, function(index, member) {
            resultsHtml += '<div class="edit-member-search-result" style="padding: 10px 15px; border-bottom: 1px solid #f0f0f0; cursor: pointer;" ' +
              'data-member-id="' + member.id + '" ' +
              'data-member-idnumber="' + member.idnumber + '" ' +
              'data-member-surname="' + member.surname + '" ' +
              'data-member-name="' + member.name + '" ' +
              'data-member-passbook="' + (member.passbook_no || '') + '" ' +
              'data-member-cell="' + (member.cellnumber || '') + '" ' +
              'data-member-status="' + (member.status || '') + '">' +
              '<strong>' + member.surname + ' ' + member.name + '</strong> ' +
              '<small style="color: #666;">ID: ' + member.idnumber + ' | Passbook: ' + (member.passbook_no || 'N/A') + '</small>' +
              '</div>';
          });
          $('#edit_member_search_results').html(resultsHtml).show();

          $('.edit-member-search-result').off('click').on('click', function() {
            var member = {
              id: $(this).data('member-id'),
              idnumber: $(this).data('member-idnumber'),
              surname: $(this).data('member-surname'),
              name: $(this).data('member-name'),
              passbook_no: $(this).data('member-passbook'),
              cellnumber: $(this).data('member-cell'),
              status: $(this).data('member-status')
            };

            $('#edit_member_search').val(member.surname + ' ' + member.name);
            $('#edit_member_idnumber').text(member.idnumber);
            $('#edit_member_name').text(member.surname + ' ' + member.name);
            $('#edit_member_passbook').text(member.passbook_no || 'N/A');
            $('#edit_member_cell').text(member.cellnumber);
            $('#edit_selected_member_id').val(member.id);

            var $info = $('#edit_member_info');
            if (member.status == 0 || member.status === '0') {
              $info.removeClass('alert-info').addClass('alert-danger');
            } else {
              $info.removeClass('alert-danger').addClass('alert-info');
            }
            $info.show();

            var claimType = $('input[name="claim_type"]:checked').val();
            if (claimType === 'NOMINEE') {
              loadEditNominees(member.id, null);
            } else {
              loadEditBeneficiaries(member.id, null);
            }
            $('#edit_member_search_results').hide();
          });
        } else {
          $('#edit_member_search_results').html('<div style="padding: 10px; text-align: center; color: #999;">No members found</div>').show();
        }
      }
    });
  });

  $('input[name="claim_type"]').off('change.editClaim').on('change.editClaim', function() {
    applyEditClaimType($(this).val());
  });

  $(document).off('click.editClaimSearch').on('click.editClaimSearch', function(e) {
    if (!$(e.target).closest('#edit_member_search, #edit_member_search_results').length) {
      $('#edit_member_search_results').hide();
    }
  });

  // Init datepickers inside modal if plugin available
  if ($.fn.datepicker) {
    $('#edit_claim_form .input-group.date').datepicker({ format: 'yyyy-mm-dd', autoclose: true });
  }
})();
</script>
<?php
endforeach;
?>
