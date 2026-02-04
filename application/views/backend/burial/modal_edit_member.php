
<?php
$edit_data = $this->db->get_where('members', array('id' => $param2))->result_array();
foreach ($edit_data as $row):

    // Fetch existing nominee for this member (if any).
    // Even if multiple exist from historic data, we only care about the first,
    // and update logic in the controller will enforce only ONE going forward.
    $nominee = $this->db
        ->order_by('id', 'ASC')
        ->get_where('nominee', ['member_id' => $row['id']])
        ->row_array();
?>
  <div class="row">
    <div class="col-md-12">
      <section class="panel">
      
        <?php echo form_open(base_url() . 'index.php?burial/members/do_update/'.$row['id'] , array('class' => 'form-horizontal form-bordered','target'=>'_top', 'id' => 'form', 'enctype' => 'multipart/form-data'));?>
        
        <div class="panel-heading">
          <h4 class="panel-title">
                <i class="fa fa-pencil-square"></i>
          <?php echo "Edit Member: " . $row['surname'] . " " . $row['name'];?>
              </h4>
        
        </div>

        <div class="panel-body">
          <!-- EMPLOYEE NO -->
          <div class="form-group">
            <label class="col-md-3 control-label">Employee No</label>
            <div class="col-md-7">
              <input type="text" class="form-control" name="employeeno" value="<?php echo htmlspecialchars($row['employeeno'] ?? '');?>"/>
            </div>
          </div>

          <!-- TSC NO -->
          <div class="form-group">
            <label class="col-md-3 control-label">TSC No</label>
            <div class="col-md-7">
              <input type="text" class="form-control" name="tscno" value="<?php echo htmlspecialchars($row['tscno'] ?? '');?>"/>
            </div>
          </div>
          <!-- ID NUMBER -->
          <div class="form-group">
            <label class="col-md-3 control-label">ID Number</label>
            <div class="col-md-7">
              <input type="text" class="form-control" required name="idnumber" value="<?php echo htmlspecialchars($row['idnumber']);?>"/>
            </div>
          </div>



          <!-- SURNAME -->
          <div class="form-group">
            <label class="col-md-3 control-label">Surname</label>
            <div class="col-md-7">
              <input type="text" class="form-control" required name="surname" value="<?php echo htmlspecialchars($row['surname']);?>"/>
            </div>
          </div>

          <!-- NAME -->
          <div class="form-group">
            <label class="col-md-3 control-label">Name</label>
            <div class="col-md-7">
              <input type="text" class="form-control" required name="name" value="<?php echo htmlspecialchars($row['name']);?>"/>
            </div>
          </div>

          <!-- PASSBOOK NO -->
          <div class="form-group">
            <label class="col-md-3 control-label">Passbook No</label>
            <div class="col-md-7">
              <input type="text" class="form-control" required name="passbook_no" value="<?php echo htmlspecialchars($row['passbook_no']);?>"/>
            </div>
          </div>

          <!-- CELL NUMBER -->
          <div class="form-group">
            <label class="col-md-3 control-label">Cell Number</label>
            <div class="col-md-7">
              <input type="text" class="form-control" required name="cellnumber" maxlength="11" minlength="11" value="<?php echo htmlspecialchars($row['cellnumber']);?>"/>
            </div>
          </div>

          <!-- DOB -->
          <div class="form-group">
            <label class="col-md-3 control-label">Date of Birth</label>
            <div class="col-md-7">
              <input type="text" class="form-control" name="dob" value="<?php echo htmlspecialchars($row['dob'] ?? '');?>"/>
            </div>
          </div>

          <!-- GENDER -->
          <div class="form-group">
            <label class="col-md-3 control-label">Gender</label>
            <div class="col-md-7">
              <select name="gender" class="form-control" required>
                <option value="">Select</option>
                <option value="M" <?php echo ($row['gender'] == 'M') ? 'selected' : ''; ?>>Male</option>
                <option value="F" <?php echo ($row['gender'] == 'F') ? 'selected' : ''; ?>>Female</option>
              </select>
            </div>
          </div>

          <!-- SCHOOL CODE -->
          <div class="form-group">
            <label class="col-md-3 control-label">School Code</label>
            <div class="col-md-7">
              <input type="text" class="form-control" name="schoolcode" value="<?php echo htmlspecialchars($row['schoolcode'] ?? '');?>"/>
            </div>
          </div>

          <!-- PERMANENT RESIDENCY -->
          <div class="form-group">
            <label class="col-md-3 control-label">Permanent Residency</label>
            <div class="col-md-7">
              <input type="text" class="form-control" name="resident" value="<?php echo htmlspecialchars($row['resident'] ?? ''); ?>"/>
            </div>
          </div>

          <!-- NOMINEE (ONLY ONE PER MEMBER) -->
          <div class="form-group">
            <label class="col-md-3 control-label">Nominee</label>
            <div class="col-md-7">
              <input type="text"
                     class="form-control"
                     name="nominee_fullname"
                     placeholder="Nominee full name"
                     value="<?php echo isset($nominee['fullname']) ? htmlspecialchars($nominee['fullname']) : ''; ?>"/>
              <small class="form-text text-muted">
                Only one nominee is allowed per member.
              </small>
            </div>
          </div>


        </div>
        <footer class="panel-footer">
          <div class="row">
            <div class="col-sm-9 col-sm-offset-3">
              <button type="submit" class="btn btn-primary">Update Member</button>
            </div>
          </div>
        </footer>
        <?php echo form_close();?>
      </section>
    </div>
  </div>

<?php
endforeach;
?>