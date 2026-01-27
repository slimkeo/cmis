


<div class="row">
		<div class="pricing-table">
		
			<?php
				$weeks = $this->db->get( 'week' )->result_array();
				foreach ( $weeks as $row ): ?>
			<div class="col-lg-4">
			
			<div class="plan" data-appear-animation="bounceIn">
			<h3><?php echo $row['week'];?><span><?php echo $row['month'];?></span></h3>
				<ul>
				<li>	
					<!-- STUDENT EDITING LINK -->
				<p><?php echo $row['weekstart'];?> - <?php echo $row['weekend'];?></p>
									</li>
				<li>	
					<!-- STUDENT EDITING LINK -->
				<a href="<?php echo base_url();?>index.php?admin/byweek/<?php echo $row['week_id'];?>" class="btn btn-primary btn-sm" data-placement="top" data-toggle="tooltip" data-original-title="<?php echo get_phrase('edit');?>">
                      <i class="fa fa-eye"></i> View Report
                </a>
									</li>
			
				</ul>
			</div>
		</div>
		<?php endforeach;?>
	</div>
</div>

	
		