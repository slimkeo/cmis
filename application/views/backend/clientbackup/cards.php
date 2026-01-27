<div class="row" style="background-color:#fff;">
	<div class="col-md-12">

		<!---CONTROL TABS START-->
		<div class="tabs">
		<ul class="nav nav-tabs">
			<li class="active">
				<a href="#list" data-toggle="tab"><i class="fa fa-list"></i> 
					<?php echo get_phrase('all_registered_parking_disks');?>
						</a></li>
		
		</ul>
		<!---CONTROL TABS END-->

		<div class="tab-content" style="background-color:#fff;">
		<br>
			<!--TABLE LISTING STARTS-->
			<div class="tab-pane box active" id="list" style="background-color:#fff;">


	    <footer class="panel-footer">
			<div class="text-right mr-lg">
			     
				<button class="btn btn-primary ml-sm" onclick="ExportPdf()">Print Parking Disks</button>
			</div>
		</footer>

<div class="row" id="printMe"  style="background-color:#fff;">
		<div class="pricing-table" style="background-color:#fff;">
		    
		    
		    
		<?php
      // $disks = $this->db->get( 'disks' )->result_array();
       
       $disks = $this->db->get_where( 'disks', array('organization' => 'Municipal Council Of Mbabane') )->result_array();

       
        ?>
		    
		    
		
			<?php
		
     
	
		

		foreach ($disks as $row ): 
				
	
				?>
				
				
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
        <script type="text/javascript">
            function generateBarCode()
            {
                var nric = $('#text').val();
                var url = 'https://api.qrserver.com/v1/create-qr-code/?data=' + nric + '&amp;size=50x50';
                $('#barcode').attr('src', url);
                
            }
        </script>

       
			
				
	
		
		
			<div class="col-lg-6" style="background-color:#fff;">
			
			<div class="plan" style="background-color:#fff;">
			<h6><img src="uploads/diskpalin.png" alt="" height="300px"/></h6>
			<?php if(!empty($row['alt_car_reg'])){
			?>
			
			<h6 style="text-align:right; margin-top:-50px; margin-right:170px; color:#000; font-size:10px;" ><?php echo $row['car_reg']; ?> / <br> <?php echo $row['alt_car_reg']; ?> </h6>
			<h6 style="text-align:right; margin-top:-180px; margin-right:155px" >
			
			<?php }else {  ?>
			
				<h6 style="text-align:right; margin-top:-41px; margin-right:170px; color:#000" ><?php echo $row['car_reg']; ?>  </h6>
				<?php } ?>
			<h6 style="text-align:right; margin-top:-180px; margin-right:145px" >
			<?php
			
			//file path for store images
		    $SERVERFILEPATH = $_SERVER['DOCUMENT_ROOT'].'/uploads/qr_images/';
		   
			$text = $row['qr'];
			$text1= $text;
			
			$folder = $SERVERFILEPATH;
			$file_name1 = $text1. ".png";
			$file_name = $folder.$file_name1;
			QRcode::png($text,$file_name);
			
			echo"<img height='108px' src=".'uploads/qr_images/'.$file_name1." >";
			
			
			?>
			</h6>

			  
			
            
            
			
			</div>
		</div>
		<?php endforeach;?>
	</div>



</div>
</div>

  <?php $date = date('Y-m-d'); ?>
 
           
<script src="https://kendo.cdn.telerik.com/2023.2.621/js/jquery.min.js"></script>
 <script src="https://kendo.cdn.telerik.com/2023.2.621/js/jszip.min.js"></script>
 <script src="https://kendo.cdn.telerik.com/2023.2.621/js/kendo.all.min.js"></script>

<script>
function ExportPdf(){ 
kendo.drawing
.drawDOM("#printMe", 
{ 
forcePageBreak: ".page-break", // add this class to each element where you want manual page break
paperSize: "A4",
margin: { top: "0.4cm", bottom: "0.4cm" },
scale: 0.6,
height: 400, 
template: $("#page-template").html(),
keepTogether: ".prevent-split"
})
.then(function(group){
kendo.drawing.pdf.saveAs(group, "parkingdisks.pdf")
});
}
</script>
      
  
  <script src="assets/javascripts/jspdf.min.js"  crossorigin="anonymous"></script>
  
  <script src="https://unpkg.com/jspdf@latest/dist/jspdf.min.js"></script>
  
  
  
<!--
	<script>
		function printDiv(divName){
			var printContents = document.getElementById(divName).innerHTML;
			var printWindow = window.open('', '', 'height=200,width=400');
			var originalContents = document.body.innerHTML;
			document.body.innerHTML = printContents;
			window.print();
			document.body.innerHTML = originalContents;
		}
	</script>-->
