


<div class="row">
		<div class="pricing-table">
		
			<?php
				$marshals = $this->db->get( 'marshal' )->result_array();
				foreach ( $marshals as $row ): ?>
			<div class="col-lg-4">
			
			<div class="plan">
			<h3><?php echo $row['name'];?><span><img src="<?php echo $this->crud_model->get_image_url('marshal',$row['marshal_id']);?>" width="60"/></span></h3>
				<ul>
				<li>	<!-- STUDENT EDITING LINK -->
								<!-- STUDENT EDITING LINK -->
									<a href="<?php echo base_url();?>index.php?accountant/marshalreport/<?php echo $row['marshal_id'];?>" class="btn btn-primary btn-xs" data-placement="top" data-toggle="tooltip" data-original-title="<?php echo get_phrase('edit');?>">
                                    <i class="fa fa-eye"></i> View Report
                                    </a>
									</li>
			
				</ul>
			</div>
		</div>
		<?php endforeach;?>
	</div>
</div>

	
		