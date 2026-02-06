  <?php
	$system_name        =	$this->db->get_where('settings' , array('type'=>'system_name'))->row()->description;
	$system_title       =	$this->db->get_where('settings' , array('type'=>'system_title'))->row()->description;
	$account_type       =	$this->session->userdata('login_type');
	$skin_colour        =   $this->db->get_where('settings' , array('type'=>'skin_colour'))->row()->description;
	$borders_style      =   $this->db->get_where('settings' , array('type'=>'borders_style'))->row()->description;
	$header_colour      =   $this->db->get_where('settings' , array('type'=>'header_colour'))->row()->description;
	$sidebar_colour     =   $this->db->get_where('settings' , array('type'=>'sidebar_colour'))->row()->description;
	$sidebar_size       =   $this->db->get_where('settings' , array('type'=>'sidebar_size'))->row()->description;
	$active_sms_service =   $this->db->get_where('settings' , array('type'=>'active_sms_service'))->row()->description;
	$running_year 		=   $this->db->get_where('settings' , array('type'=>'running_year'))->row()->description;
  ?>
	
<!doctype html>
<html class="fixed<?php if ($skin_colour == 'dark') {echo ' dark';} else {  if ($sidebar_colour == 'sidebar-light') echo ' sidebar-light'; if ($header_colour == 'header-dark') echo ' header-dark'; } if ($sidebar_size != 'sidebar-left-md') echo ' ' . $sidebar_size; if($page_name == 'dashboard' || $page_name == 'streetfeed' || $page_name == 'message' || $page_name == 'student_information') echo ' sidebar-left-collapsed';?>">
	
	<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">

		<!-- Basic -->
		
		<title><?php echo $page_title;?> | <?php echo $system_title;?></title>
			<meta name="keywords" content="SNAT BURIAL AGM Management System"/>
	<meta name="description" content="SNAT BURIAL AGM Management System Management System">
	<meta name="author" content="Sicelo Thabani Hlanze">
		<?php include 'includes/includes_top.php';?>
		
	</head>
	
	<body class="loading-overlay-showing" data-loading-overlay>

	    <!-- Page Loading Overlay 
		<div class="loading-overlay">
			<div class="bounce-loader">
				<div class="bounce1"></div>
				<div class="bounce2"></div>
				<div class="bounce3"></div>
			</div>
		</div>  -->
		
		<section class="body">

			<!-- Include header -->
            <?php include 'includes/header.php';?>
			
			<div class="inner-wrapper">
            
				<!-- Include navigation -->
				<?php include $account_type.'/navigation.php';?>

				<section role="main" class="content-body">
					<header class="page-header">
						<h2><?php echo $page_title;?></h2>
				
						
					</header>

					<!-- start: page -->
					<?php include $account_type.'/'.$page_name.'.php';?>
					<!-- end: page -->
				</section>
			</div>

			
		</section>
        <!-- Includes modal -->
         <?php include 'includes/modal.php';?>
        <!-- Includes bottom -->
		<?php include 'includes/includes_bottom.php';?>

	</body>
</html>