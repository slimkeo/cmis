		<!-- Vendor -->
		<script src="assets/vendor/jquery-browser-mobile/jquery.browser.mobile.js"></script>
		<script src="assets/vendor/bootstrap/js/bootstrap.js"></script>
		<script src="assets/vendor/nanoscroller/nanoscroller.js"></script>
		<script src="assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
		<script src="assets/vendor/magnific-popup/jquery.magnific-popup.js"></script>
		<script src="assets/vendor/jquery-placeholder/jquery-placeholder.js"></script>
		
				<!-- Specific Page Vendor -->		
				<script src="assets/vendor/jquery-ui/jquery-ui.js"></script>		
				<script src="assets/vendor/jqueryui-touch-punch/jqueryui-touch-punch.js"></script>		
				<script src="assets/vendor/jquery-appear/jquery-appear.js"></script>		
				<script src="assets/vendor/jquery.easy-pie-chart/jquery.easy-pie-chart.js"></script>		
				<script src="assets/vendor/flot/jquery.flot.js"></script>		
				<script src="assets/vendor/flot.tooltip/flot.tooltip.js"></script>		
				<script src="assets/vendor/flot/jquery.flot.pie.js"></script>		
				<script src="assets/vendor/flot/jquery.flot.categories.js"></script>		
				<script src="assets/vendor/flot/jquery.flot.resize.js"></script>		
				<script src="assets/vendor/jquery-sparkline/jquery-sparkline.js"></script>		
				<script src="assets/vendor/raphael/raphael.js"></script>		
				<script src="assets/vendor/morris.js/morris.js"></script>		
				<script src="assets/vendor/owl.carousel/owl.carousel.js"></script>

		<!-- Specific Page Vendor -->
		<script src="assets/vendor/jquery-ui/jquery-ui.js"></script>
		<script src="assets/vendor/jqueryui-touch-punch/jqueryui-touch-punch.js"></script>
		<script src="assets/vendor/select2/js/select2.js"></script>
		<script src="assets/vendor/bootstrap-multiselect/bootstrap-multiselect.js"></script>
		<script src="assets/vendor/jquery-maskedinput/jquery.maskedinput.js"></script>
		<script src="assets/vendor/bootstrap-tagsinput/bootstrap-tagsinput.js"></script>
		<script src="assets/vendor/bootstrap-colorpicker/js/bootstrap-colorpicker.js"></script>
		<script src="assets/vendor/bootstrap-timepicker/bootstrap-timepicker.js"></script>
		<script src="assets/vendor/fuelux/js/spinner.js"></script>
		<script src="assets/vendor/dropzone/dropzone.js"></script>
		<script src="assets/vendor/bootstrap-markdown/js/markdown.js"></script>
		<script src="assets/vendor/bootstrap-markdown/js/to-markdown.js"></script>
		<script src="assets/vendor/bootstrap-markdown/js/bootstrap-markdown.js"></script>
		<script src="assets/vendor/codemirror/lib/codemirror.js"></script>
		<script src="assets/vendor/codemirror/addon/selection/active-line.js"></script>
		<script src="assets/vendor/codemirror/addon/edit/matchbrackets.js"></script>
		<script src="assets/vendor/codemirror/mode/javascript/javascript.js"></script>
		<script src="assets/vendor/codemirror/mode/xml/xml.js"></script>
		<script src="assets/vendor/codemirror/mode/htmlmixed/htmlmixed.js"></script>
		<script src="assets/vendor/codemirror/mode/css/css.js"></script>
		<script src="assets/vendor/summernote/summernote.js"></script>
		<script src="assets/vendor/bootstrap-maxlength/bootstrap-maxlength.js"></script>
		<script src="assets/vendor/ios7-switch/ios7-switch.js"></script>
		<script src="assets/vendor/bootstrap-confirmation/bootstrap-confirmation.js"></script>

	
        
        <!-- Fileinput Vendor -->
		<script src="assets/javascripts/fileinput.js"></script>
		<script src="assets/vendor/bootstrap-fileupload/bootstrap-fileupload.min.js"></script>
        	
		<!-- Pnotify Notifications JS -->
		<script src="assets/vendor/pnotify/pnotify.custom.js"></script>
		
		<!-- Animations appear JS -->
		<script src="assets/vendor/jquery-appear/jquery-appear.js"></script>

        <!-- Form Validation -->
		<script src="assets/vendor/jquery-validation/jquery.validate.js"></script>

		<!-- Theme Base, Components and Settings -->
		<script src="assets/javascripts/theme.js"></script>
		
		<!-- Theme Custom -->
		<script src="assets/javascripts/theme.custom.js"></script>
		
		<!-- Theme Initialization Files -->
		<script src="assets/javascripts/theme.init.js"></script>

        <!-- Calendar Files -->
        <script src="assets/vendor/moment/moment.js"></script>
		<script src="assets/vendor/fullcalendar/fullcalendar.js"></script>

        <!-- Chart Files -->
		<script src="assets/vendor/flot/jquery.flot.js"></script>
		<script src="assets/vendor/flot.tooltip/flot.tooltip.js"></script>
		<script src="assets/vendor/flot/jquery.flot.pie.js"></script>
		<script src="assets/vendor/flot/jquery.flot.categories.js"></script>
		<script src="assets/vendor/flot/jquery.flot.resize.js"></script>
		<script src="assets/vendor/liquid-meter/liquid.meter.js"></script>
		<script src="assets/vendor/snap.svg/snap.svg.js"></script>
		

		<!-- SHOW PNOTIFIVATION -->
		<?php if ($this->session->flashdata('flash_message') != ""):?>
		<script type="text/javascript">
			new PNotify({
				title: 'Successful',
				text: '<?php echo $this->session->flashdata("flash_message");?>',
				shadow: true,
				type: 'success',
				buttons: {
				sticker: false
				}
				});
		</script>
		<?php endif;?>

		<?php if ($this->session->flashdata('flash_message_error') != ""):?>
		<script type="text/javascript">
			new PNotify({
				title: 'Error',
				text: '<?php echo $this->session->flashdata("flash_message_error");?>',
				shadow: true,
				type: 'error',
				buttons: {
				sticker: false
				}
				});
		</script>
		<?php endif;

			if ($this->session->flashdata('flash_message_error')) {
			    $this->session->set_flashdata('flash_message_error' , null);
			}
			if ($this->session->flashdata('flash_message')) {
			    $this->session->set_flashdata('flash_message' , null);
			}

		?>
		

			<!-- Specific Page Vendor Data Tables--> 		
		<script src="vendor/select2/js/select2.js"></script>		
		<script src="vendor/datatables/media/js/jquery.dataTables.min.js"></script>		
		<script src="vendor/datatables/media/js/dataTables.bootstrap4.min.js"></script>		
		<script src="vendor/datatables/extras/TableTools/Buttons-1.4.2/js/dataTables.buttons.min.js"></script>		
		<script src="vendor/datatables/extras/TableTools/Buttons-1.4.2/js/buttons.bootstrap4.min.js"></script>		
		<script src="vendor/datatables/extras/TableTools/Buttons-1.4.2/js/buttons.html5.min.js"></script>		
		<script src="vendor/datatables/extras/TableTools/Buttons-1.4.2/js/buttons.print.min.js"></script>		
		<script src="vendor/datatables/extras/TableTools/JSZip-2.5.0/jszip.min.js"></script>		
		<script src="vendor/datatables/extras/TableTools/pdfmake-0.1.32/pdfmake.min.js"></script>		
		<script src="vendor/datatables/extras/TableTools/pdfmake-0.1.32/vfs_fonts.js"></script>

			<!-- Examples -->
		<script src="js/examples/examples.datatables.default.js"></script>
		<script src="js/examples/examples.datatables.row.with.details.js"></script>
		<script src="js/examples/examples.datatables.tabletools.js"></script>

		<script src="assets/javascripts/dashboard/examples.dashboard.js"></script>
		<script src="assets/javascripts/forms/custom_validation.js"></script>
    
		
		<script src="assets/javascripts/ui-elements/examples.charts.js"></script>

		<script>
		$(document).ready(function () {
			$('.datepicker').datepicker({
				format: 'dd-mm-yyyy',
				autoclose: true,
				todayHighlight: true
			});
		});
		</script>


              


