
<?php
$edit_data = $this->db->get_where( 'admin', array( 'id' => $param2 ) )->result_array();
foreach ( $edit_data as $row ):
  ?>
  <div class="row">
    <div class="col-md-12">
      <section class="panel">
      
        <?php echo form_open(base_url() . 'index.php?burial/manage_users/do_update/'.$row['id'] , array('class' => 'form-horizontal form-bordered','target'=>'_top', 'id' => 'form', 'enctype' => 'multipart/form-data'));?>
        
        <div class="panel-heading">
          <h4 class="panel-title">
                <i class="fa fa-pencil-square"></i>
          <?php echo " User : ".$row['name'];?>
              </h4>
        
        </div>

        <div class="panel-body">
        <div class="form-group">
            <label class="col-md-3 control-label">
              NATIONAL ID
            </label>
            <div class="col-md-7">
              <input type="text" class="form-control" required name="national_id" value="<?php echo $row['national_id'];?>"/>
            </div>
          </div>
          <div class="form-group">
            <label class="col-md-3 control-label">
              FULL NAME
            </label>
            <div class="col-md-7">
              <input type="text" class="form-control" required name="name" value="<?php echo $row['name'];?>"/>
            </div>
          </div>  
          <div class="form-group">
            <label class="col-md-3 control-label">
              EMAIL
            </label>
            <div class="col-md-7">
              <input type="text" class="form-control" required name="email" value="<?php echo $row['email'];?>"/>
            </div>
          </div>          
          <div class="form-group">
					<label class="col-md-3 control-label">
						<?php echo get_phrase('admin_previleges');?>
					</label>

					<div class="col-md-7">
          <select name="level" data-plugin-selectTwo data-minimum-results-for-search="Infinity" data-width="100%" class="form-control populate" required>
            <option value=""><?php echo get_phrase('select'); ?></option>
            
            <?php
            // Fetch levels from database
            $levels = $this->db->get('admin_privileges')->result_array(); // Adjust table name if needed
            
            foreach ($levels as $level) {
                $selected = ($row['level'] == $level['id']) ? 'selected' : '';
                ?>
                <option value="<?php echo $level['id']; ?>" <?php echo $selected; ?>>
                    <?php echo $level['description']; ?> 
                </option>
                <?php
            }
            ?>
         </select>
					</div>	
				</div>           

        </div>
        <footer class="panel-footer">
          <div class="row">
            <div class="col-sm-9 col-sm-offset-3">
              <button type="submit" class="btn btn-primary">EDIT USER</button>
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