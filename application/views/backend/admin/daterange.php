<div class="row">
	<div class="col-md-12">
	    
	    <?php
	    
	    
	    
			$this->db->select("*");
            $this->db->where('year',$year);
            $this->db->from('inmonths');
            $q = $this->db->get();
            $incount = $q->result_array();
	    
	    	foreach ($incount as $moh): 
												
			$startdated = $moh['startdate'];
			$enddated   = $moh['enddate'];
								
								
			endforeach;
	    
	    
	  
	    
	    ?>






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
									<?php echo form_open(base_url() . 'index.php?admin/daterange/search/' , array('class' => 'form-horizontal form-bordered validate','target'=>'_top'));?>
						
						
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
