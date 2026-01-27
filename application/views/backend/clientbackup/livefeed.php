


<div class="row">
		<div class="pricing-table">
		
			<?php
				$streets = $this->db->get( 'street' )->result_array();
				foreach ( $streets as $row ): 
				
				
				
				
						$number = $this->db ->where('street_id', $row['street_id'])->count_all_results('sensor');
				
				
				
				?>
				
				
			<div class="col-lg-4">
			
			<div class="plan">
			<h3><?php echo $row['street_name'];?><span> <?php echo $number; ?></span></h3>
				<ul>
				<li>	
								<!-- STREET FEED LINK -->
									<a href="<?php echo base_url();?>index.php?admin/streetfeed/<?php echo $row['street_id'];?>" class="btn btn-success btn-xs" data-placement="top" data-toggle="tooltip" data-original-title="<?php echo get_phrase('view_heartbeat');?>">
                                    <i class="fa fa-eye"></i> Heartbeat
                                    </a>
                                    &nbsp;
                                    <a href="<?php echo base_url();?>index.php?admin/rawdata/<?php echo $row['street_id'];?>" class="btn btn-primary btn-xs" data-placement="top" data-toggle="tooltip" data-original-title="<?php echo get_phrase('view_raw');?>">
                                    <i class="fa fa-eye"></i> Raw
                                    </a>
									</li>
								
			
				</ul>
			</div>
		</div>
		<?php endforeach;?>
	</div>
</div>

	
		