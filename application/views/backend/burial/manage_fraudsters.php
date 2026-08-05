<?php 

$this->db
->select('fr.recovery_id, fr.member_id, fr.amount_owed, fr.arrangement_date, fr.status, fr.case_description, m.idnumber, m.passbook_no,m.cellnumber, m.employeeno, m.surname, m.name, IFNULL(SUM(fp.amount_paid),0) AS total_paid', false)
->from('fraud_recoveries fr')
->join('members m', 'm.id = fr.member_id', 'left')
->join('fraud_recovery_payments fp', 'fp.recovery_id = fr.recovery_id', 'left')
->group_by('fr.recovery_id');

$fraudsters = $this->db->get()->result_array();

?>
<div class="row">
    <div class="col-md-12">
        <div class="tabs">
            <ul class="nav nav-tabs">
                <li class="active">
                    <a href="#list" data-toggle="tab"><i class="fa fa-list"></i> Fraud Recoveries</a>
                </li>
                <li>
                    <a href="#add" data-toggle="tab"><i class="fa fa-plus-circle"></i> Add Fraud Arrangement</a>
                </li>
            </ul>

            <div class="tab-content">
                <br>
			<!--TABLE LISTING STARTS-->
			<div class="tab-pane box active" id="list">
				<table class="table table-bordered table-striped table-condensed mb-none" id="datatable-tabletools1">
					<thead>
						<tr>
							<th><div><?php echo get_phrase('idnumber');?></div></th>
							<th><div><?php echo get_phrase('passbook_no');?></div></th>
							<th><div><?php echo get_phrase('cellnumber');?></div></th>
							<th><div><?php echo get_phrase('employeeno');?></div></th>
							<th><div><?php echo get_phrase('arrangement_date');?></div></th>
							<th><div><?php echo get_phrase('options');?></div></th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($fraudsters as $row):?>
						<tr>
							<td><?php echo $row['idnumber'];?></td>
							<td><?php echo $row['passbook_no'];?></td>
							<td><?php echo $row['cellnumber'];?></td>
							<td><?php echo $row['employeeno'];?></td>
							<td><?php echo date('d-m-Y', strtotime($row['arrangement_date'])) ?? '-';?></td>
							<td>

									<!-- VIEW LINK -->
                                    <a href="<?php echo base_url('index.php?burial/fraud_statement/' . $row['recovery_id']);?>" class="btn btn-xs btn-info" target="_blank" data-toggle="tooltip" title="View Fraud Statement">
                                        <i class="fa fa-money"></i>
                                    </a>
                                    <a href="<?php echo base_url('index.php?burial/member_details/' . $row['member_id']);?>" class="btn btn-xs btn-primary" target="_blank" data-toggle="tooltip" title="View Member">
                                        <i class="fa fa-eye"></i>
                                    </a>

							</td>
						</tr>
						<?php endforeach;?>
					</tbody>
				</table>
			</div>
			<!--TABLE LISTING ENDS-->

                <div class="tab-pane box" id="add" style="padding: 10px;">
                    <?php echo form_open(base_url('index.php?burial/create_fraud_recovery'), array('class' => 'form-horizontal form-bordered validate')); ?>
                    
                    <div class="form-group">
                        <label class="col-md-3 control-label">Search Member <span style="color: red;">*</span></label>
                        <div class="col-md-7">
                            <div style="position: relative;">
                                <input type="text" class="form-control" id="member_search"
                                       placeholder="Search by ID Number, Name, Passbook No, or Employee No" required>
                                <small class="form-text text-muted">Start typing to search for member</small>

                                <div id="member_search_results" style="position: absolute; top: 100%; left: 0; right: 0; background: white; border: 1px solid #ddd; border-top: none; border-radius: 0 0 4px 4px; max-height: 300px; overflow-y: auto; z-index: 1000; display: none; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
                                </div>
                            </div>
                            <div class="alert alert-info" id="member_info" style="display: none; margin-top: 10px;">
                                <strong>ID Number:</strong> <span id="member_idnumber"></span><br>
                                <strong>Name:</strong> <span id="member_name"></span><br>
                                <strong>Passbook No:</strong> <span id="member_passbook"></span><br>
                                <strong>Cell Number:</strong> <span id="member_cell"></span>
                            </div>
                            <input type="hidden" id="selected_member_id" name="selected_member_id" value="">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label">Amount Owed</label>
                        <div class="col-md-7">
                            <input type="number" step="0.01" min="0.01" class="form-control" name="amount_owed" required placeholder="0.00">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label">Arrangement Date</label>
                        <div class="col-md-7">
                            <div class="input-group date" data-provide="datepicker" data-date-format="yyyy-mm-dd">
                                <input type="text"
                                    class="form-control"
                                    name="arrangement_date"
                                    pattern="\d{4}-(?:0?[1-9]|1[0-2])-(?:0?[1-9]|[12]\d|3[01])"
                                    placeholder="yyyy-mm-dd"
                                    title="Format: yyyy-mm-dd (e.g. 2026-02-17)"
                                    required>
                                <span class="input-group-addon">
                                    <i class="glyphicon glyphicon-calendar"></i>
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label">Status</label>
                        <div class="col-md-7">
                            <select class="form-control" name="status">
                                <option value="Active">Active</option>
                                <option value="Paid">Paid</option>
                                <option value="Written Off">Written Off</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label">Case Description</label>
                        <div class="col-md-7">
                            <textarea class="form-control" name="case_description" rows="4" placeholder="Describe the fraudulent claim/case"></textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-7 col-md-offset-3">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-save"></i> Save Arrangement
                            </button>
                        </div>
                    </div>
                    <?php echo form_close(); ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {


    // ===== Member search (unchanged) =====
    $('#member_search').keyup(function() {
        var search = $(this).val();

        if (search.length < 2) {
            $('#member_search_results').hide();
            $('#member_info').hide();
            $('#selected_member_id').val('');
            return;
        }

        $.ajax({
            url: "<?php echo base_url('index.php?burial/search_members');?>",
            method: 'POST',
            data: {search: search},
            dataType: 'json',
            success: function(response) {
                if (response.success && response.members.length > 0) {
                    display_search_results(response.members);
                } else {
                    $('#member_search_results').html('<div style="padding: 10px; text-align: center; color: #999;">No members found</div>').show();
                    $('#member_info').hide();
                    $('#selected_member_id').val('');
                }
            },
            error: function() {
                $('#member_search_results').html('<div style="padding: 10px; text-align: center; color: #d32f2f;">Error loading members</div>').show();
            }
        });
    });

    function display_search_results(members) {
        var resultsHtml = '';

        $.each(members, function(index, member) {
            var displayName = member.surname + ' ' + member.name;
            var displayId = member.idnumber;
            var displayPassbook = member.passbook_no || 'N/A';
            var displayEmployee = member.employeeno || 'N/A';

            resultsHtml += '<div class="member-search-result" style="padding: 10px 15px; border-bottom: 1px solid #f0f0f0; cursor: pointer; transition: background 0.2s; display: flex; justify-content: space-between; align-items: center;" ' +
                'data-member-id="' + member.id + '" ' +
                'data-member-idnumber="' + member.idnumber + '" ' +
                'data-member-surname="' + member.surname + '" ' +
                'data-member-name="' + member.name + '" ' +
                'data-member-passbook="' + (member.passbook_no || '') + '" ' +
                'data-member-cell="' + (member.cellnumber || '') + '">' +
                '<div style="flex-grow: 1;">' +
                '<strong style="display: block; margin-bottom: 3px;">' + displayName + '</strong>' +
                '<small style="color: #666; display: block;">ID: ' + displayId + ' | Passbook: ' + displayPassbook + ' | Employee: ' + displayEmployee + '</small>' +
                '</div>' +
                '<div style="margin-left: 10px; color: #007bff;">→</div>' +
                '</div>';
        });

        $('#member_search_results').html(resultsHtml).show();

        $('.member-search-result').click(function() {
            var member = {
                id: $(this).data('member-id'),
                idnumber: $(this).data('member-idnumber'),
                surname: $(this).data('member-surname'),
                name: $(this).data('member-name'),
                passbook_no: $(this).data('member-passbook'),
                cellnumber: $(this).data('member-cell')
            };

            $('#member_search').val(member.surname + ' ' + member.name);
            $('#member_idnumber').text(member.idnumber || '');
            $('#member_name').text(member.surname + ' ' + member.name);
            $('#member_passbook').text(member.passbook_no || 'N/A');
            $('#member_cell').text(member.cellnumber || 'N/A');
            $('#selected_member_id').val(member.id);
            $('#member_info').show();
            $('#member_search_results').hide();
        });
    }

    $(document).click(function(e) {
        if (!$(e.target).closest('#member_search, #member_search_results').length) {
            $('#member_search_results').hide();
        }
    });

    $('form').on('submit', function(e) {
        if (!$('#selected_member_id').val()) {
            e.preventDefault();
            alert('Please search and select a member.');
        }
    });
});
</script>
