		<!-- Mobile Metas -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />

		<!-- Web Fonts  -->
		<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800|Shadows+Into+Light" rel="stylesheet" type="text/css">

		<!-- Vendor CSS -->
		<link rel="stylesheet" href="<?php echo base_url();?>assets/vendor/bootstrap/css/bootstrap.css" />
		<link rel="stylesheet" href="<?php echo base_url();?>assets/vendor/font-awesome/css/font-awesome.css" />
		<link rel="stylesheet" href="<?php echo base_url();?>assets/vendor/magnific-popup/magnific-popup.css" />
		<link rel="stylesheet" href="<?php echo base_url();?>assets/vendor/bootstrap-datepicker/css/bootstrap-datepicker3.css" />

		<!-- Specific Page Vendor CSS -->
		<link rel="stylesheet" href="<?php echo base_url();?>assets/vendor/jquery-ui/jquery-ui.css" />
		<link rel="stylesheet" href="<?php echo base_url();?>assets/vendor/jquery-ui/jquery-ui.theme.css" />
		<link rel="stylesheet" href="<?php echo base_url();?>assets/vendor/select2/css/select2.css" />
		<link rel="stylesheet" href="<?php echo base_url();?>assets/vendor/select2-bootstrap-theme/select2-bootstrap.min.css" />
		<link rel="stylesheet" href="<?php echo base_url();?>assets/vendor/bootstrap-multiselect/bootstrap-multiselect.css" />
		<link rel="stylesheet" href="<?php echo base_url();?>assets/vendor/bootstrap-tagsinput/bootstrap-tagsinput.css" />
		<link rel="stylesheet" href="<?php echo base_url();?>assets/vendor/bootstrap-colorpicker/css/bootstrap-colorpicker.css" />
		<link rel="stylesheet" href="<?php echo base_url();?>assets/vendor/bootstrap-timepicker/css/bootstrap-timepicker.css" />
		<link rel="stylesheet" href="<?php echo base_url();?>assets/vendor/dropzone/basic.css" />
		<link rel="stylesheet" href="<?php echo base_url();?>assets/vendor/dropzone/dropzone.css" />
		<link rel="stylesheet" href="<?php echo base_url();?>assets/vendor/bootstrap-markdown/css/bootstrap-markdown.min.css" />
		<link rel="stylesheet" href="<?php echo base_url();?>assets/vendor/summernote/summernote.css" />
		<link rel="stylesheet" href="<?php echo base_url();?>assets/vendor/codemirror/lib/codemirror.css" />
		<link rel="stylesheet" href="<?php echo base_url();?>assets/vendor/codemirror/theme/monokai.css" />
		<!-- Specific Page Vendor CSS -->		<link rel="stylesheet" href="assets/vendor/morris.js/morris.css" />		<link rel="stylesheet" href="assets/vendor/chartist/chartist.min.css" />

        <!-- Pnotify Notifications CSS -->
		<link rel="stylesheet" href="<?php echo base_url();?>assets/vendor/pnotify/pnotify.custom.css" />

        <!-- Datatables Page CSS -->
		<link rel="stylesheet" href="<?php echo base_url();?>assets/vendor/jquery-datatables-bs3/assets/css/datatables.css" />
        
        <!-- Fileupload Page CSS -->
        <link rel="stylesheet" href="<?php echo base_url();?>assets/vendor/bootstrap-fileupload/bootstrap-fileupload.min.css" />
		
		<!-- FULLCALENDAR CSS -->
		<link rel="stylesheet" href="<?php echo base_url();?>assets/vendor/fullcalendar/fullcalendar.css" />

		<!-- Theme CSS -->
		<link rel="stylesheet" href="<?php echo base_url();?>assets/stylesheets/theme.css" />

		<!-- Skin CSS -->
		<link rel="stylesheet" href="<?php echo base_url();?>assets/stylesheets/skins/default.css" />

		<!-- Theme Custom CSS -->
		<link rel="stylesheet" href="<?php echo base_url();?>assets/stylesheets/theme-custom.css">
		
		<!-- Pvs-Systems CSS -->
		<link rel="stylesheet" href="<?php echo base_url();?>assets/stylesheets/pvs-systems.css">

		<!-- Head Libs -->
		<script src="<?php echo base_url();?>assets/vendor/modernizr/modernizr.js"></script>
        
        <!-- Jquery Libs -->
		<script src="<?php echo base_url();?>assets/vendor/jquery/jquery.js"></script>
	
        <!--Web Icon-->
	    <link rel="shortcut icon" href="uploads/logo.png">
		<script src="<?php echo base_url();?>assets/vendor/style-switcher/style.switcher.localstorage.js"></script>

        <!-- Disable Square Borders -->
        <?php
	      $borders_style = $this->db->get_where('settings' , array('type'=>'borders_style'))->row()->description;
	      if ($borders_style == 'false') echo '<link rel="stylesheet" href="assets/stylesheets/skins/square-borders.css" />';
        ?>

        <!--Amcharts-->
        <script src="<?php echo base_url();?>assets/vendor/amcharts/amcharts.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>assets/vendor/amcharts/pie.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>assets/vendor/amcharts/serial.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>assets/vendor/amcharts/gauge.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>assets/vendor/amcharts/funnel.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>assets/vendor/amcharts/radar.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>assets/vendor/amcharts/exporting/amexport.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>assets/vendor/amcharts/exporting/rgbcolor.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>assets/vendor/amcharts/exporting/canvg.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>assets/vendor/amcharts/exporting/jspdf.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>assets/vendor/amcharts/exporting/filesaver.js" type="text/javascript"></script>
        <script src="<?php echo base_url();?>assets/vendor/amcharts/exporting/jspdf.plugin.addimage.js" type="text/javascript"></script>

		<script>
			function checkDelete()
			{
				var chk=confirm("Are You Sure To Delete This !");
				if(chk)
				{
					return true;  
				}
				else{
					return false;
				}
			}
		</script>