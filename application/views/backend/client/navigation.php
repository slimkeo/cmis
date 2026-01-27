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
				<a href="<?php echo base_url(); ?>index.php?client/dashboard">
					<i class="fa fa-tachometer"></i>
					<span><?php echo get_phrase('dashboard'); ?></span>
				</a>
			</li>

			<!-- deposits/ withdrawals -->
			<li class="nav-parent <?php
			if ($page_name == 'transfers' ||
					$page_name == 'bymobile' || $page_name == 'byaccount')
				echo 'nav-expanded nav-active';
			?> ">
				<a href="#">
					<i class="fa fa-bank"></i>
					<span><?php echo get_phrase('transfer'); ?></span>
				</a>
				<ul class="nav nav-children">
					<li class="<?php if ($page_name == 'bymobile' ) echo 'nav-active'; ?> ">
						<a href="<?php echo base_url(); ?>index.php?client/bymobile">
							 <i class="fa fa-phone"></i>
							<span><?php echo get_phrase('by_mobile'); ?></span>
						</a>
					</li>
					<li class="<?php if ($page_name == 'byaccount' ) echo 'nav-active'; ?> ">
						<a href="<?php echo base_url(); ?>index.php?client/byaccount">
							 <i class="fa fa-minus"></i>
							<span><?php echo get_phrase('by_account'); ?></span>
						</a>
					</li>

				</ul>
			</li>

			<!-- loans -->
			<li class="<?php if ($page_name == 'loans' ) echo 'nav-active'; ?> ">
				<a href="<?php echo base_url(); ?>index.php?client/myloans">
					 <i class="fa fa-money"></i>
					<span><?php echo get_phrase('my_loans'); ?></span>
				</a>
			</li>
			

	
			<!-- REPORTS MANAGER -->	
						<li class="nav-parent <?php
			if ($page_name == 'statement' ||
					$page_name == 'daterange' || $page_name == 'daterangereport')
				echo 'nav-expanded nav-active';
			?> ">
				<a href="#">
					<i class="fa fa-calendar-check-o"></i>
					<span><?php echo get_phrase('statement'); ?></span>
				</a>
				<ul class="nav nav-children">
				<li class="<?php if ($page_name == 'daterange' ) echo 'nav-active'; ?> ">
				<a href="<?php echo base_url(); ?>index.php?client/daterange">
					 <i class="fa fa-user"></i>
					<span><?php echo get_phrase('daterange'); ?></span>
				</a>
			</li>
				</ul>
			</li>
		<!-- resources -->
		<li class="<?php if ($page_name == 'client_details	') echo 'nav-active'; ?> ">
			<a href="<?php echo base_url(); ?>index.php?client/client_details">
				<i class="fa fa-user"></i>
				<span><?php echo get_phrase('my_details'); ?></span>
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


