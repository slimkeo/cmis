<?php
   $query = $this->db->get( 'street' );
   $street = $query->result_array();
?>

<div class="row">
	<div class="col-md-12">

		<!---CONTROL TABS START-->
		<div class="tabs">
		<ul class="nav nav-tabs">
			<li class="active">
				<a href="#import" data-toggle="tab"><i class="fa fa-list"></i> 
					<?php echo get_phrase('import_collections');?>
						</a></li>
			
		</ul>
		<!---CONTROL TABS END-->



			<!--CREATION FORM STARTS-->
			<div class="tab-pane box active" id="import" style="padding: 25px">
				<div class="box-content">
				<form method="post" id="import_csv" enctype="multipart/form-data" class="form-horizontal form-bordered validate">
						
						<div class="form-group">
							<label class="col-md-5 control-label">Excel Upload</label>
												<div class="col-md-7">
													<div class="fileupload fileupload-new" data-provides="fileupload">
														<div class="input-append">
															<div class="uneditable-input">
																<i class="fa fa-file fileupload-exists"></i>
																<span class="fileupload-preview"></span>
															</div>
															<span class="btn btn-default btn-file">
																<span class="fileupload-exists">Change</span>
																<span class="fileupload-new">Select file</span>
																<input type="file" name="csv_file" id="csv_file" required accept=".csv"/>
															</span>
															<a href="#" class="btn btn-default fileupload-exists" data-dismiss="fileupload">Remove</a>
														</div>
													</div>
												</div>
											</div>
											
							<div class="form-group">
							  <div class="col-sm-offset-7 col-sm-5">
								  <button type="submit" name="import_csv" id="import_csv_btn" class="btn btn-primary"><?php echo get_phrase('Import');?></button>
							  </div>
							</div>
							
						</form>     		
							
			</div>
			
			<div id="imported_csv_data"></div>
			
			
			</div>
			<!--UPLOADING ENDS-->

		</div>
	</div>
   </div>
</div>

<script>
$(document).ready(function(){

 load_data();

 function load_data()
 {
  $.ajax({
   url:"<?php echo base_url(); ?>import/load_data",
   method:"POST",
   success:function(data)
   {
    $('#imported_csv_data').html(data);
   }
  })
 }

 $('#import_csv').on('submit', function(event){
  event.preventDefault();
  $.ajax({
   url:"<?php echo base_url(); ?>import/import",
   method:"POST",
   data:new FormData(this),
   contentType:false,
   cache:false,
   processData:false,
   beforeSend:function(){
    $('#import_csv_btn').html('Importing...');
   },
   success:function(data)
   {
    $('#import_csv')[0].reset();
    $('#import_csv_btn').attr('disabled', false);
    $('#import_csv_btn').html('Import Done');
    load_data();
   }
  })
 });
 
});
</script>

