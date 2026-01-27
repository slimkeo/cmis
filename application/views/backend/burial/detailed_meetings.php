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
						
										<h2 class="panel-title">AGM  Picker</h2>
									</header>
									<div class="panel-body">
										<?php echo form_open(base_url() . 'index.php?burial/report_per_agm' , array('class' => 'form-horizontal form-bordered validate'));?>
						
											<div class="form-group">
												<label class="col-md-3 control-label">Annual General Meeting</label>
												<div class="col-md-6">
													<div class="input-group">
														<span class="input-group-addon">
															<i class="fa fa-user"></i>
														</span>
														
														<?php
															$query = $this->db->get('agms');
															$agms = $query->result_array();
														?>
												<select data-plugin-selectTwo class="form-control populate" id="agm" name="agm" style="width: 100%" required>
												<option value=""><?php echo get_phrase('choose_meeting'); ?></option>
													<?php foreach ($agms as $row): ?>
													<option value="<?php echo $row['id']; ?>"><?php echo $row['description']; ?></option>
													<?php endforeach; ?>
												</select>
				
														
														
														
														
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