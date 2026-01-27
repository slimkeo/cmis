
<?php
$page = $_SERVER['PHP_SELF'];
$sec = "30";
?>		
 <meta http-equiv="refresh" content="<?php echo $sec?>;URL='<?php echo base_url(); ?>index.php?admin/incident'">

<div class="row">
	<div class="col-md-12">

		<!---CONTROL TABS START-->
		<div class="tabs">
		<ul class="nav nav-tabs">
			<li class="active">
				<a href="#list" data-toggle="tab"><i class="fa fa-list"></i> 
					<?php echo get_phrase('incident_list');?>
						</a></li>
			
		</ul>
		<!---CONTROL TABS END-->

		<div class="tab-content">
		<br>
			<!--TABLE LISTING STARTS-->
			<div class="tab-pane box active" id="list">
				<table class="table table-bordered table-striped table-condensed mb-none" id="datatable-tabletools">
					<thead>
						<tr>
							<th></th>
							<th><div><?php echo get_phrase('marshal');?></div></th>
							<th><div><?php echo get_phrase('bayset');?></div></th>
							<th><div><?php echo get_phrase('incident');?></div></th>
							<th><div><?php echo get_phrase('logtime');?></div></th>
							<th><div><?php echo get_phrase('status');?></div></th>
							<th><div><?php echo get_phrase('options');?></div></th>
						</tr>
					</thead>
					<tbody>
						<?php $count = 1;
						foreach($incident as $row):?>
						<tr>
						<td><?php echo $count++;?></td>
							<td><?php echo $row['marshal'];?></td>
							<td><?php echo $row['bayset'];?></td>							
							<td><?php echo $row['incident'];?></td>
							<td><?php echo $row['logtime'];?></td>
							<td><?php echo $row['status'];?></td>
							<td>


								<!-- EDITING LINK -->
								<a href="#" class="btn btn-success btn-xs" data-placement="top" data-toggle="tooltip" data-original-title="<?php echo get_phrase('view');?>" onClick="showAjaxModal('<?php echo base_url();?>index.php?modal/popup/modal_attend/<?php echo $row['id'];?>');">
								<i class="fa fa-eye"></i> View
								</a>

<!-- EDITING LINK -->
							<!-- DELETION LINK -->
								<a href="#" class="btn btn-primary btn-xs" data-placement="top" data-toggle="tooltip" data-original-title="<?php echo get_phrase('attend');?>" onClick="confirm_modal('<?php echo base_url();?>index.php?admin/incident/delete/<?php echo $row['id'];?>');">
								<i class="fa fa-check-square"></i> Attend
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
