<!-- start: sidebar -->
				<aside id="sidebar-left" class="sidebar-left">
				
				    <div class="sidebar-header">
				        <div class="sidebar-title">
				            Navigation
				        </div>
				        <div class="sidebar-toggle hidden-xs" data-toggle-class="sidebar-left-collapsed" data-target="html" data-fire-event="sidebar-left-toggle">
				            <i class="fa fa-bars" aria-label="Toggle sidebar"></i>
				        </div>
				    </div>
	<div class="nano">
		<div class="nano-content">
			<nav id="menu" class="nav-main" role="navigation">
				<ul class="nav nav-main">

			<!-- DASHBOARD -->
			<li class="<?php if ($page_name == 'dashboard') echo 'nav-active'; ?> ">
				<a href="<?php echo base_url(); ?>index.php?accountant/dashboard">
					<i class="fa fa-tachometer"></i>
					<span><?php echo get_phrase('dashboard'); ?></span>
				</a>
			</li>

		
			
			<!-- CLIENT RELATIONS MANAGER -->
			<li class="nav-parent <?php
			if ($page_name == 'client' ||
					$page_name == 'municipality')
				echo 'nav-expanded nav-active';
			?> ">
				<a href="#">
					<i class="fa fa-user-plus"></i>
					<span><?php echo get_phrase('CRM'); ?></span>
				</a>
				<ul class="nav nav-children">
		
			<li class="<?php if ($page_name == 'municipality') echo 'nav-active'; ?> ">
				<a href="<?php echo base_url(); ?>index.php?accountant/municipality">
					<i class="fa fa-circle-o"></i> 
					<span><?php echo get_phrase('municipality'); ?></span>
				</a>
			</li>
			
			
			
				</ul>
			</li>
			
			
			<!-- PAYMENTS -->
			<li class="nav-parent <?php
			if ($page_name == 'disks' ||
					$page_name == 'cards')
				echo 'nav-expanded nav-active';
			?> ">
				<a href="#">
					<i class="fa fa-credit-card"></i>
					<span><?php echo get_phrase('subscribers'); ?></span>
				</a>
				<ul class="nav nav-children">
					<!-- MEMBERS -->
			<li class="<?php if ($page_name == 'disks') echo 'nav-active'; ?> ">
				<a href="<?php echo base_url(); ?>index.php?accountant/disks">
					<i class="fa fa-circle-o"></i> 
					<span><?php echo get_phrase('parking_disks'); ?></span>
				</a>
			</li>
		
			
			
			
				</ul>
			</li>
			
		

		
			
		
		

			
			<!-- MANAGE PARKING -->
			<li class="nav-parent <?php
			if ($page_name == 'street' || $page_name == 'devices' ||
					$page_name == 'bays')
				echo 'nav-expanded nav-active';
			?> ">
				<a href="#">
					<i class="fa fa-car"></i>
					<span><?php echo get_phrase('parking'); ?></span>
				</a>
				<ul class="nav nav-children">
				
				<li class="<?php if ($page_name == 'devices') echo 'nav-active'; ?> ">
						<a href="<?php echo base_url(); ?>index.php?accountant/devices">
							<span><i class="fa fa-circle-o"></i> <?php echo get_phrase('manage_gadgets'); ?></span>
						</a>
					</li>
				
					<li class="<?php if ($page_name == 'street') echo 'nav-active'; ?> ">
						<a href="<?php echo base_url(); ?>index.php?accountant/street">
							<span><i class="fa fa-circle-o"></i> <?php echo get_phrase('manage_streets'); ?></span>
						</a>
					</li>
					<li class="<?php if ($page_name == 'bays') echo 'nav-active'; ?> ">
						<a href="<?php echo base_url(); ?>index.php?accountant/bays">
							<span><i class="fa fa-circle-o"></i> <?php echo get_phrase('manage_bays'); ?></span>
						</a>
					</li>
				</ul>
			</li>
			
			<!-- CHECK INS -->
			<li class="nav-parent <?php if ($page_name == 'daily' || 
											$page_name == 'byweek' || $page_name == 'weekslist' ||
											$page_name == 'bymonths' || $page_name == 'monthlist' ) 
										echo 'nav-expanded nav-active'; ?> ">
				<a href="#">
					<i class="fa fa-money"></i>
					<span><?php echo get_phrase('banking'); ?></span>
				</a>
				<ul class="nav nav-children">
				<li class="<?php if (($page_name == 'daily')) echo 'nav-active'; ?>">
					<a href="<?php echo base_url(); ?>index.php?accountant/daily">
					<span><i class="fa fa-circle-o"></i> <?php echo get_phrase('daily'); ?></span>
					</a>
				</li>
						
				</ul>
			</li>

		
	<!-- CHECK INS -->
			<li class="nav-parent <?php if ($page_name == 'daily_report' || 
											$page_name == 'bydate' || 
											$page_name == 'marshallist' ||
											$page_name == 'by_street' || $page_name == 'streetlist' || $page_name == 'streetreport' ||
											$page_name == 'reportpermonth' ||
											$page_name == 'permonthlist' || 
											$page_name == 'per_marshal' || $page_name == 'marshallist' || $page_name == 'marshalreport' || 
											$page_name == 'summary') 
										echo 'nav-expanded nav-active'; ?> ">
				<a href="#">
					<i class="fa fa-folder"></i>
					<span><?php echo get_phrase('Reports'); ?></span>
				</a>
				<ul class="nav nav-children">
				<li class="<?php if (($page_name == 'daily_report')) echo 'nav-active'; ?>">
							<a href="<?php echo base_url(); ?>index.php?accountant/daily_report">
								<span><i class="fa fa-circle-o"></i> <?php echo get_phrase('daily_report'); ?></span>
							</a>
						</li>
						
					<li class="<?php if (($page_name == 'bydate')) echo 'nav-active'; ?>">
							<a href="<?php echo base_url(); ?>index.php?accountant/bydate">
								<span><i class="fa fa-circle-o"></i> <?php echo get_phrase('system_daily'); ?></span>
							</a>
					</li>
					
					<li class="<?php if (($page_name == 'permonthlist' || $page_name == 'reportpermonth')) echo 'nav-active'; ?>">
							<a href="<?php echo base_url(); ?>index.php?accountant/permonthlist">
								<span><i class="fa fa-circle-o"></i> <?php echo get_phrase('by_month'); ?></span>
							</a>
					</li>
					
				<li class="<?php if (($page_name == 'daily')) echo 'nav-active'; ?>">
							<a href="<?php echo base_url(); ?>index.php?accountant/daily">
								<span><i class="fa fa-circle-o"></i> <?php echo get_phrase('by_date'); ?></span>
							</a>
						</li>
						<li class="<?php if (($page_name == 'marshallist')) echo 'nav-active'; ?>">
							<a href="<?php echo base_url(); ?>index.php?accountant/marshallist">
								<span><i class="fa fa-circle-o"></i> <?php echo get_phrase('by_marshal'); ?></span>
							</a>
						</li>
						

						<li class="<?php if (($page_name == 'streetlist')) echo 'nav-active'; ?>">
							<a href="<?php echo base_url(); ?>index.php?accountant/streetlist">
								<span><i class="fa fa-circle-o"></i> <?php echo get_phrase('by_street'); ?></span>
							</a>
						</li>
						
						<li class="<?php if (($page_name == 'daily_range')) echo 'nav-active'; ?>">
							<a href="<?php echo base_url(); ?>index.php?accountant/daily_range">
								<span><i class="fa fa-circle-o"></i> <?php echo get_phrase('date_range'); ?></span>
							</a>
						</li>

					
						
						

				</ul>
			</li>


		   <!-- ACCOUNTING -->
			<li class="nav-parent <?php
			if ($page_name == 'marshal' || $page_name == 'supervisor' || $page_name == 'accountant' ||$page_name == 'support')
				echo 'nav-expanded nav-active';
			?> ">
				<a href="#">
					<i class="fa fa-spinner"></i>
					<span><?php echo get_phrase('HRM'); ?></span>
				</a>
				<ul class="nav nav-children">
					<li class="<?php if ($page_name == 'marshal') echo 'nav-active'; ?> ">
						<a href="<?php echo base_url(); ?>index.php?accountant/marshal">
							<span><i class="fa fa-circle-o"></i> <?php echo get_phrase('manage_marshal'); ?></span>
						</a>
					</li>
					<li class="<?php if ($page_name == 'supervisor') echo 'nav-active'; ?> ">
						<a href="<?php echo base_url(); ?>index.php?accountant/supervisor">
							<span><i class="fa fa-circle-o"></i> <?php echo get_phrase('manage_supervisor'); ?></span>
						</a>
					</li>
					
					<li class="<?php if ($page_name == 'accountant') echo 'nav-active'; ?> ">
						<a href="<?php echo base_url(); ?>index.php?accountant/accountant">
							<span><i class="fa fa-circle-o"></i> <?php echo get_phrase('manage_accountant'); ?></span>
						</a>
					</li>
					
					<li class="<?php if ($page_name == 'support') echo 'nav-active'; ?> ">
						<a href="<?php echo base_url(); ?>index.php?accountant/support">
							<span><i class="fa fa-circle-o"></i> <?php echo get_phrase('manage_support'); ?></span>
						</a>
					</li>
					
				</ul>
			</li>

			<!-- NOTICEBOARD -->
			<li class="<?php if ($page_name == 'noticeboard') echo 'nav-active'; ?> ">
				<a href="<?php echo base_url(); ?>index.php?accountant/noticeboard">
					<i class="fa fa-file-text-o"></i>
					<span><?php echo get_phrase('noticeboard'); ?></span>
				</a>
			</li>

			<!-- MESSAGE -->
			<li class="<?php if ($page_name == 'security_settings') echo 'nav-active'; ?> ">
				<a href="<?php echo base_url(); ?>index.php?accountant/security_settings">
					<i class="fa fa-lock"></i>
					<span><?php echo get_phrase('security_settings'); ?></span>
				</a>
			</li>

		

		</ul>
	 </nav>

	</div>

	      <script>
				            // Maintain Scroll Position
				            if (typeof localStorage !== 'undefined') {
				                if (localStorage.getItem('sidebar-left-position') !== null) {
				                    var initialPosition = localStorage.getItem('sidebar-left-position'),
				                        sidebarLeft = document.querySelector('#sidebar-left .nano-content');
				                    
				                    sidebarLeft.scrollTop = initialPosition;
				                }
				            }
				        </script>
	</div>		
</aside>
<!-- end: sidebar -->


