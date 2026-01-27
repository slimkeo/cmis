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
				<a href="<?php echo base_url(); ?>index.php?burial/dashboard">
					<i class="fa fa-tachometer"></i>
					<span><?php echo get_phrase('dashboard'); ?></span>
				</a>
			</li> 
			<li class="<?php if ($page_name == 'claims'|| $page_name=='user_details' ) echo 'nav-active'; ?> ">
				<a href="<?php echo base_url(); ?>index.php?burial/claims">
					 <i class="fa fa-slideshare"></i>
					<span><?php echo get_phrase('manage_claims'); ?></span>
				</a>
			</li> 
			<li class="<?php if ($page_name == 'attendance'|| $page_name=='user_details' ) echo 'nav-active'; ?> ">
				<a href="<?php echo base_url(); ?>index.php?burial/attendance">
					 <i class="fa fa-slideshare"></i>
					<span><?php echo get_phrase('manage_attendance'); ?></span>
				</a>
			</li>									
			<!-- manage attendance -->
			<?php if ($this->session->userdata('level')==1) { ?>
			<li class="nav-parent <?php
				if ($page_name == 'communication' ||
						$page_name == 'sms_batch_invite' || $page_name == 'sms_communique')
					echo 'nav-expanded nav-active';
				?> ">
					<a href="#">
						<i class="fa fa-users"></i>
						<span>SMS Communication</span>
					</a>
				<ul class="nav nav-children">
					<li class="<?php if ($page_name == 'sms_batch_invite' ) echo 'nav-active'; ?> ">
						<a href="<?php echo base_url(); ?>index.php?burial/sms_batch_invite">
							 <i class="fa fa-address-book"></i>
							<span>Invite SMS</span>
						</a>
					</li>
					<li class="<?php if ($page_name == 'sms_communique' ) echo 'nav-active'; ?> ">
						<a href="<?php echo base_url(); ?>index.php?burial/sms_communique">
							 <i class="fa fa-address-book-o"></i>
							<span>SMS Communiqua</span>
						</a>
					</li>									
				</ul>
			</li>

			<li class="nav-parent <?php
				if ($page_name == 'members' ||
						$page_name == 'detailed_meetings' || $page_name == 'detailed_meetings')
					echo 'nav-expanded nav-active';
				?> ">
					<a href="#">
						<i class="fa fa-users"></i>
						<span>Members</span>
					</a>
				<ul class="nav nav-children">
					<li class="<?php if ($page_name == 'members' ) echo 'nav-active'; ?> ">
						<a href="<?php echo base_url(); ?>index.php?burial/members">
							 <i class="fa fa-address-book"></i>
							<span>All Members</span>
						</a>
					</li>
<!-- 					<li class="<?php if ($page_name == 'replace_member' ) echo 'nav-active'; ?> ">
						<a href="<?php echo base_url(); ?>index.php?burial/replace_member">
							 <i class="fa fa-address-book-o"></i>
							<span><?php echo get_phrase('replace_member'); ?></span>
						</a>
					</li>
					<li class="<?php if ($page_name == 'replace_memberreplace_member' ) echo 'nav-active'; ?> ">
						<a href="<?php echo base_url(); ?>index.php?burial/deactivate_members">
							 <i class="fa fa-user"></i>
							<span>Deactivate Members</span>
						</a>
					</li>	
					<li class="<?php if ($page_name == 'manage_beneficiaries' ) echo 'nav-active'; ?> ">
						<a href="<?php echo base_url(); ?>index.php?burial/manage_beneficiaries">
							 <i class="fa fa-address-card"></i>
							<span>Deactivate Members</span>
						</a>
					</li> -->									
				</ul>
			</li>			
			<?php } ?>
			<!-- ADMIN MANAGEMENT PANEL -->
			<?php if ($this->session->userdata('level') == 1 || $this->session->userdata('level') == 3  ) { ?>		
			<li class="nav-parent <?php
				if ($page_name == 'momo_agm' ||
						$page_name == 'detailed_meetings' || $page_name == 'detailed_meetings')
					echo 'nav-expanded nav-active';
				?> ">
					<a href="#">
						<i class="fa fa-calendar-check-o"></i>
						<span>AGM Reports</span>
					</a>
				<ul class="nav nav-children">
					<li class="<?php if ($page_name == 'detailed_meetings' ) echo 'nav-active'; ?> ">
						<a href="<?php echo base_url(); ?>index.php?burial/detailed_meetings">
							 <i class="fa fa-user"></i>
							<span><?php echo get_phrase('detailed_meetings'); ?></span>
						</a>
					</li>
					<li class="<?php if ($page_name == 'momo_agm' ) echo 'nav-active'; ?> ">
						<a href="<?php echo base_url(); ?>index.php?burial/pay_with_momo/3">
							 <i class="fa fa-user"></i>
							<span><?php echo get_phrase('pay_with_momo'); ?></span>
						</a>
					</li>
				</ul>
			</li>
				<?php } ?>	
			<!-- ADMIN MANAGEMENT PANEL -->
			<?php if ($this->session->userdata('level') == 1) { ?>						
			<li class="nav-parent <?php
			if ($page_name == 'manage_users' ||
					$page_name == 'agms' || $page_name == 'security_settings' || $page_name == 'manage_system' )
				echo 'nav-expanded nav-active';
			?> ">
				<a href="#">
					<i class="fa fa-street-view"></i>
					<span><?php echo get_phrase('administrative'); ?></span>
				</a>
				<ul class="nav nav-children">
					<!-- \Manage USers -->
			<li class="<?php if ($page_name == 'manage_users') echo 'nav-active'; ?> ">
				<a href="<?php echo base_url(); ?>index.php?burial/manage_users">
					<i class="fa fa-slideshare"></i> 
					<span><?php echo get_phrase('manage_users'); ?></span>
				</a>
			</li>

					<!-- AGMS LIST Addition -->
			<li class="<?php if ($page_name == 'agms') echo 'nav-active'; ?> ">
				<a href="<?php echo base_url(); ?>index.php?burial/agms">
					<i class="fa fa-bullhorn"></i> 
					<span><?php echo get_phrase('annual_general_meetings'); ?></span>
				</a>
			</li>						<!-- manage System -->
			<li class="<?php if ($page_name == 'manage_system' ) echo 'nav-active'; ?> ">
				<a href="<?php echo base_url(); ?>index.php?burial/manage_system">
					 <i class="fa fa-circle-o"></i>
					<span><?php echo get_phrase('manage_system'); ?></span>
				</a>
			</li>
					<!-- manage Security settings -->
			<li class="<?php if ($page_name == 'security_settings') echo 'nav-active'; ?> ">
				<a href="<?php echo base_url(); ?>index.php?burial/security_settings">
					<i class="fa fa-unlock-alt"></i> 
					<span><?php echo get_phrase('security_settings'); ?></span>
				</a>
			</li>
			
			
			
				</ul>
			</li>
			
				<?php } ?>	
	

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


