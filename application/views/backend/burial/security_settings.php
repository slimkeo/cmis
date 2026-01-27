<div class="row" data-appear-animation="fadeInRight" data-appear-animation-delay="100">
    <?php echo form_open(base_url() . 'index.php?burial/security_settings/update' , 
      array('class' => 'form-horizontal form-bordered validate'));?>
        <div class="col-md-6">
            
            <div class="panel" >
            
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <?php echo get_phrase('security_settings');?>
                    </h4>
                </div>
                
                <div class="panel-body">
                    
                  <div class="form-group">
                      
                      <label  class="col-sm-3 control-label"><?php echo get_phrase('full_name');?></label>
                      <div class="col-sm-9">
                          <input type="text" class="form-control" name="name" 
                              value="<?php echo $this->db->get_where('user' , array('id' =>$this->session->userdata('user_id')))->row()->name;?>" required="">
                      </div>
                  </div>
                    
                  <div class="form-group">
                      <label  class="col-sm-3 control-label"><?php echo get_phrase('email');?></label>
                      <div class="col-sm-9">
                          <input type="text" class="form-control" name="email" 
                              value="<?php echo $this->db->get_where('user' , array('id' =>$this->session->userdata('user_id')))->row()->email;?>" required="">
                      </div>
                  </div>
                  <div class="form-group">
                      <label  class="col-sm-3 control-label"><?php echo get_phrase('old_password');?></label>
                      <div class="col-sm-9">
                          <input type="password" class="form-control" name="old_password" required="">
                      </div>
                  </div>                    
                  <div class="form-group">
                      <label  class="col-sm-3 control-label"><?php echo get_phrase('new_password');?></label>
                      <div class="col-sm-9">
                          <input type="password" class="form-control" name="new_password" required="">
                      </div>
                  </div>


                    
                </div>
                
				<footer class="panel-footer">
					<div class="row">
						<div class="col-sm-9 col-sm-offset-3">
						 <button type="submit" class="btn btn-primary"><?php echo get_phrase('Update Settings');?></button>
						</div>
					</div>	
				</footer>
                <?php echo form_close();?>
            </div>
        </div>
        

    </div>
    

     