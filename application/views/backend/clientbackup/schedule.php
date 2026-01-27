<?php
   $query = $this->db->get( 'weeks' );
   $week = $query->result_array();
?>

<section class="panel panel-featured panel-featured-primary">

	<header class="panel-heading">
	<a href="<?php echo base_url();?>index.php?admin/create_schedule" class="mr-xs btn btn-primary btn-sm">
       <i class="fa fa-plus-circle"></i>
       <?php echo get_phrase('create_schedule'); ?>
    </a>
	</header>
	
	<div class="panel-body">

		<div class="form-group">
			<label class="col-sm-6 col-sm-offset-3 control-label" style="margin-bottom: 5px; text-align: center;">
				<?php echo get_phrase('week'); ?>
			</label>
			<div class="col-sm-6 col-sm-offset-3">
				<select data-plugin-selectTwo class="form-control populate" name="class_id" onChange="class_section(this.value)" style="width: 100%">
					<option value=""><?php echo get_phrase('select_week'); ?></option>
					<?php foreach ($week as $row): ?>
					<option value="<?php echo $row['week_id']; ?>" <?php if ($week_id == $row[ 'week_id']) echo 'selected'; ?>><?php echo $row['week']; ?>- <?php echo $row['month']; ?></option>
					<?php endforeach; ?>
				</select>
			</div>
		</div>

			<?php
		$query = $this->db->get_where( 'schedulet', array( 'week_id' => $week_id ) );
		if ( $query->num_rows() > 0 && $week_id != '' ):
			$sections = $query->result_array();
		foreach ( $sections as $row ):
			?>
		
		<div class="tabs tabs-primary">
			<ul class="nav nav-tabs">
				<li class="active">
					<a href="#home" data-toggle="tab">
                    <span class="visible-xs"><i class="fa fa-users"></i></span>
                    <span class="hidden-xs"><?php echo get_phrase('scheduled_marshals');?></span>
					</a>
				</li>

				
			</ul>
			<div class="tab-content">
				<div id="home" class="tab-pane active">
					
					
					
					<table cellpadding="0" cellspacing="0" border="0" class="table table-bordered">
							<tbody>
								<?php 
								for($d=1;$d<=29;$d++):

								if($d==1)$day='Khulie Khumalo';
								else if($d==2)$day='Sindie Dlamini';
								else if($d==3)$day='Zandile Tsabedze';
								else if($d==4)$day='Ntombi Tfwala';
								else if($d==5)$day='Sanele Masuku';
								else if($d==6)$day='Londiwe Dladla';
								else if($d==7)$day='Bongane Tembe';
								else if($d==8)$day='Bongane Mohammed';
								else if($d==9)$day='Nokuthula Magagula';
								else if($d==10)$day='Dumsile Thomo';
								else if($d==11)$day='Khanyisile Dlamini';
								else if($d==12)$day='Lucia Maseko';
								else if($d==13)$day='Loveness Mavuso';
								else if($d==14)$day='Mancoba Shongwe';
								else if($d==15)$day='Zodwa Nhlabatsi';
								else if($d==16)$day='Mduduzi Maseko';
								else if($d==17)$day='Bongekile Dlamini';
								else if($d==18)$day='Mancoba Nkambule';
								else if($d==19)$day='Nomphilo Sibandze';
								else if($d==20)$day='Nozipho Ginindza';
								else if($d==21)$day='Nobuhle Tsabedze';
								else if($d==22)$day='Mpendulo Tsikati';
								else if($d==23)$day='Wakhile Dlamini';
								else if($d==24)$day='Bongani Ndzabandzaba';
								else if($d==25)$day='Senziwe Matsenjwa';
								else if($d==26)$day='Nomsa Dlamini';
								else if($d==27)$day='Nomvula Makhanya';
								else if($d==28)$day='Sibongile Ngwenya';
								else if($d==29)$day='Nomcebo Nkabinde';
								?>
								<tr class="gradeA">
								<?php $count = 1; ?>
									
									<td width="200">
										<?php echo strtoupper($day);?>
									</td>
									<td>
										
										<div class="btn-group">
											<button class="mb-xs mt-xs mr-xs btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown">
												<?php echo $this->db->get_where('bays' , array(
                                        'bay_id' => $row['bay_id']
                                    ))->row()->bay_name;
                                ?>
												<span class="caret"></span>
											</button>
											
										</div>
									
									</td>
								</tr>
								<?php endfor;?>
							</tbody>
						</table>

					
					
							
				</div>

			

			</div>
		</div>
		<?php endforeach;?>
		<?php endif;?>
	</div>
</section>

<script type="text/javascript">
	function class_section( week_id ) {
		window.location.href = '<?php echo base_url(); ?>index.php?admin/schedule/' + week_id;
	}
</script>