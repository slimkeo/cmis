<?php 
 $agms = $this->db->get_where('agms')->result_array();
?>
<div class="row">
	<div class="col-md-12">

		<!---CONTROL TABS START-->
		<div class="tabs">
		<ul class="nav nav-tabs">
			<li class="active">
				<a href="#list" data-toggle="tab"><i class="fa fa-list"></i> 
					<?php echo get_phrase('all_agms');?>
				</a>
			</li>
		</ul>
		<!---CONTROL TABS END-->

		<div class="tab-content">
		<br>

			<!--TABLE LISTING STARTS-->
			<div class="tab-pane box active" id="list">
				<table class="table table-bordered table-striped mb-none" id="datatable-tabletools">
					<thead>
						<tr>
							<th><?php echo get_phrase('#');?></th>
							<th><?php echo get_phrase('description');?></th>
							<th><?php echo get_phrase('date');?></th>
							<th><?php echo get_phrase('year');?></th>
							<th><?php echo get_phrase('attendance');?></th>
							<th><?php echo get_phrase('createdate');?></th>
							<th><?php echo get_phrase('options');?></th>
						</tr>
					</thead>
					<tbody>
						<?php
						$i = 1;
						foreach ($agms as $row): ?>
							<tr>
								<td><?php echo $i++;?></td>
								<td><?php echo $row['description'];?></td>
								<td><?php echo $row['date'];?></td>
								<td><?php echo $row['year'];?></td>
								<td>
									<?php 
									// Count how many members attended this AGM
									$attendance = $this->db->where('agm', $row['id'])
									                       ->from('attendance')
									                       ->count_all_results();
									echo $attendance;
									?>
								</td>
								<td><?php echo $row['createdate'];?></td>
								<td>

									<!-- VIEW -->
									<a href="<?php echo base_url(); ?>index.php?burial/pay_with_momo/<?php echo $row['id'];?>" 
									   class="btn btn-xs btn-info" data-toggle="tooltip" 
									   data-original-title="<?php echo get_phrase('pay_with_momo');?>" target="_blank">
										<i class="fa fa-eye"></i>
									</a>

								</td>
							</tr>
						<?php endforeach;?>
					</tbody>
				</table>
			</div>
			<!--TABLE LISTING ENDS-->

		</div>
	</div>
   </div>
</div>
