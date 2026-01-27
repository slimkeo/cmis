
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
	<!--	<form action="<?php echo base_url() ?>csv/importcsv" method="post" enctype="multipart/form-data" name="form1" id="form1"> -->

				<?php echo form_open(base_url() . 'index.php?csv/importcsv' , array('class' => 'form-horizontal form-bordered validate'));?>
							
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
