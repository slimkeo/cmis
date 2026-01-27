<div class="row">
	<div class="col-md-12">
	<div class="col-lg-12">
								<section class="panel">
									<header class="panel-heading">
										<div class="panel-actions">
											<a href="#" class="panel-action panel-action-toggle" data-panel-toggle></a>
											<a href="#" class="panel-action panel-action-dismiss" data-panel-dismiss></a>
										</div>
						
										<h2 class="panel-title">Date Picker</h2>
									</header>
									<div class="panel-body">
									<?php echo form_open(base_url() . 'index.php?client/client_statement/search/' , array('class' => 'form-horizontal form-bordered validate','target'=>'_top'));?>
											<div class="form-group">
															<label class="col-sm-3 control-label"><?php echo get_phrase('account');?></label>
															<div class="col-sm-7">
															<select data-plugin-selectTwo class="form-control populate" name="account" onchange="class_section(this.value)" style="width: 80%">
																<?php 
														$account_data = $this->db->get_where( 'account', array( 'client_id' =>$this->session->userdata('client_id') ) )->result_array();
														foreach ( $account_data as $data ):  ?>
																<option value="<?php echo $data['id']; ?>"><?php echo $data['id']; ?></option>
																<?php endforeach; ?>
															</select>
															</div>
											</div>						
						
											<div class="form-group">
												<label class="col-md-3 control-label">Date Range</label>
												<div class="col-md-6">
													<div class="input-daterange input-group" data-plugin-datepicker>
														<span class="input-group-addon">
															<i class="fa fa-calendar"></i>
														</span>
														<input type="text" class="form-control" name="startdate">
														<span class="input-group-addon">To</span>
														<input type="text" class="form-control" name="enddate">
													</div>
												</div>
											</div>
						
											<div class="form-group">
							  <div class="col-sm-offset-7 col-sm-5">
								  <button type="submit" class="btn btn-default btn-sm"><i class="fa fa-search"></i> <?php echo get_phrase('view_report');?></button>
							  </div>
							</div>
						
											
						
										</form>
									</div>
								</section>
							</div>
						</div>



		
	
			


   </div>
</div>
