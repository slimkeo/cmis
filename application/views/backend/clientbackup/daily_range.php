<div class="row">
<h1>&nbsp;</h1>
<h1>&nbsp;</h1>
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
										<?php echo form_open(base_url() . 'index.php?admin/marshal_range' , array('class' => 'form-horizontal form-bordered validate'));?>
						
											<div class="form-group">
												<label class="col-md-3 control-label">Marshal</label>
												<div class="col-md-6">
													<div class="input-group">
														<span class="input-group-addon">
															<i class="fa fa-user"></i>
														</span>
														
														<?php
															$query = $this->db->get('marshal');
															$marshals = $query->result_array();
														?>
				<select data-plugin-selectTwo class="form-control populate" id="marshal" name="marshal" style="width: 100%">
				<option value=""><?php echo get_phrase('choose_marshal'); ?></option>
					<?php foreach ($marshals as $row): ?>
					<option value="<?php echo $row['marshal_id']; ?>" <?php if ($marshal_id == $row[ 'marshal_id']) echo 'selected'; ?> ><?php echo $row['name']; ?></option>
					<?php endforeach; ?>
				</select>
				
														
														
														
														
													</div>
												</div>
											</div>
						
											<div class="form-group">
												<label class="col-md-3 control-label">Date Range</label>
												<div class="col-md-6">
													<div class="input-daterange input-group" data-plugin-datepicker>
														<span class="input-group-addon">
															<i class="fa fa-calendar"></i>
														</span>
														<input type="text" class="form-control" name="start">
														<span class="input-group-addon">To</span>
														<input type="text" class="form-control" name="end">
													</div>
												</div>
											</div>
						
											<div class="form-group">
							  <div class="col-sm-offset-7 col-sm-5">
								  <button type="submit" class="btn btn-primary block"><i class="fa fa-search"></i> <?php echo get_phrase('view_report');?></button>
							  </div>
							</div>
						
											
						
										</form>
									</div>
								</section>
							</div>
						</div>