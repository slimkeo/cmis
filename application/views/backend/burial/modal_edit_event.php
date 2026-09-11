
<?php
$edit_data = $this->db->get_where( 'event', array( 'id' => $param2 ) )->result_array();
foreach ( $edit_data as $row ):
  ?>
  <div class="row">
    <div class="col-md-12">
      <section class="panel">
      
        <?php echo form_open(base_url() . 'index.php?burial/manage_events/do_update/'.$row['id'] , array('class' => 'form-horizontal form-bordered','target'=>'_top', 'id' => 'form', 'enctype' => 'multipart/form-data'));?>
        
        <div class="panel-heading">
          <h4 class="panel-title">
                <i class="fa fa-pencil-square"></i>
          Edit Event
              </h4>
        
        </div>

        <div class="panel-body">
        <div class="form-group">
            <label class="col-md-3 control-label">
              <?php echo get_phrase('description');?>
            </label>
            <div class="col-md-7">
              <input type="text" class="form-control" required name="description" value="<?php echo $row['description'];?>"/>
            </div>
          </div>
          <div class="form-group">
            <label class="col-md-3 control-label">
              <?php echo get_phrase('date');?>
            </label>
            <div class="col-md-7">
              <input type="text" class="form-control" required name="date" value="<?php echo $row['date'];?>"/>
            </div>
          </div>  
          <div class="form-group">
            <label class="col-md-3 control-label">
              <?php echo get_phrase('time');?>
            </label>
            <div class="col-md-7">
              <input type="text" class="form-control" required name="time" value="<?php echo $row['time'];?>"/>
            </div>
          </div>  
          <div class="form-group">
            <label class="col-md-3 control-label">
              <?php echo get_phrase('location');?>
            </label>
            <div class="col-md-7">
              <input type="text" class="form-control" required name="location" value="<?php echo $row['location'];?>"/>
            </div>
          </div>  
          <div class="form-group">
            <label class="col-md-3 control-label">
              <?php echo get_phrase('year');?>
            </label>
            <div class="col-md-7">
              <input type="text" class="form-control" required name="year" value="<?php echo $row['year'];?>"/>
            </div>
          </div>          
          

        </div>
        <footer class="panel-footer">
          <div class="row">
            <div class="col-sm-9 col-sm-offset-3">
              <button type="submit" class="btn btn-primary">EDIT AGM</button>
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