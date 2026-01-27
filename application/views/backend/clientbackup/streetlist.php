


<div class="row">
		<div class="pricing-table">
		
			<?php
				$streets = $this->db->get( 'street' )->result_array();
				foreach ( $streets as $row ): 
				
				$street_id = $row['street_id'];
				$total_count = $this->db->count_all('bays', array('street_id' => $row['street_id']));
				
				
									
										switch ($street_id) {
									
										case "1":
											$t = $total_count;
											break;
										case "2":
											$t = $total_count;
											break;
										case "2":
											$t = $total_count;
											break;
										case "3":
											$t = $total_count;
											break;
										case "4":
											$t = $total_count;
											break;
										case "5":
											$t = $total_count;
											break;
										case "6":
											$t = $total_count;
											break;
										case "7":
											$t = $total_count;
											break;
										case "7":
											$t = $total_count;
											break;	
										
										case "9":
											$t = $total_count;
											break;
										case "10":
											$t = $total_count;
											break;
											
										
										default:
										}
				
				?>
				
				
			<div class="col-lg-4">
			
			<div class="plan">
			<h3><?php echo $row['street_name'];?><span> <?php echo $row['street_id']; ?></span></h3>
				<ul>
				<li>	<!-- STUDENT EDITING LINK -->
								<!-- STUDENT EDITING LINK -->
									<a href="<?php echo base_url();?>index.php?admin/streetreport/<?php echo $row['street_id'];?>" class="btn btn-primary btn-xs" data-placement="top" data-toggle="tooltip" data-original-title="<?php echo get_phrase('view');?>">
                                    <i class="fa fa-eye"></i> View Report
                                    </a>
									</li>
			
				</ul>
			</div>
		</div>
		<?php endforeach;?>
	</div>
</div>

	
		