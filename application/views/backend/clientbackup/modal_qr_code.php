<?php 
$edit_data		=	$this->db->get_where('disks' , array('disk_id' => $param2) )->result_array();

	foreach($edit_data as $row):
	
	$qr_code = $row['qr'];
	$name = $row['name'];
	$car_reg = $row['car_reg'];
	$alt_car_reg = $row['alt_car_reg'];
	$organization = $row['organization'];
	
	endforeach;
?>


<section class="panel">

	<div class="panel-heading">
		<h4 class="panel-title" >
			<i class="fa fa-pencil-square"></i>
			<?php echo get_phrase('generate_QR');?>
		</h4>
	</div>
	
		<div class="panel-body">
				<div class="form-group">
					<label class="col-sm-3 control-label"><?php echo get_phrase('bay_name');?></label>
					<div class="col-sm-7">
					
					<div class="fileinput-new thumbnail" id="image" style="width: 200px; height: 200px;" data-trigger="fileinput">
								
					</div>
					
						
					</div>
				</div>
				
				
				<div class="form-group">
						<label class="col-md-3 control-label">
							<?php echo get_phrase('name');?>
						</label>
						<div class="col-md-7">
							<input type="text" readonly="readonly" class="form-control" value="<?php echo $row['name'];?>"/>
						</div>
				</div>
						
					<div class="form-group">
						<label class="col-md-3 control-label">
							<?php echo get_phrase('car_reg');?>
						</label>
						<div class="col-md-7">
							<input type="text" readonly="readonly" class="form-control" value="<?php echo $row['car_reg'];?>"/>
						</div>
					</div>
					
					<div class="form-group">
						<label class="col-md-3 control-label">
							<?php echo get_phrase('alt_car_reg');?>
						</label>
						<div class="col-md-7">
							<input type="text" readonly="readonly" class="form-control" value="<?php echo $row['alt_car_reg'];?>"/>
						</div>
					</div>
					
					<div class="form-group">
						<label class="col-md-3 control-label">
							<?php echo get_phrase('organization');?>
						</label>
						<div class="col-md-7">
							<input type="text" readonly="readonly" class="form-control" value="<?php echo $row['organization'];?>"/>
						</div>
					</div>
			
		</div>
	
		<footer class="panel-footer">
			<div class="row">
			<div class="col-sm-9 col-sm-offset-3">
				<form id="generator"> 
						
				 <input type="hidden" onClick="myFunction()" id="codeData" name="codeData" size="50" value="<?php echo $qr_code; ?>"/ >
        		 <input type="hidden" id="codeSize" value="155" name="codeSize"/ >
				<button class="btn btn-primary" id="generate">Generate QR</button>
				</form>
		
			</div>
			</div>
		</footer>
		
 </form>

</section> 



<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>


<script>
function myFunction() {
     document.getElementById("alert").innerHTML = "";
	}
	
$("#generate").on("click", function () {
var data = $("#codeData").val();
var size = $("#codeSize").val();
if(data == "") {
    $("#alert").append("<p style='color:#fff;font-size:20px'>Please Enter A Url Or Text</p>"); // If Input Is Blank
    return false;
} else {
    if( $("#image").is(':empty')) {
		
	  //QR Code Image
      $("#image").append("<img src='http://chart.apis.google.com/chart?cht=qr&chl=" + data + "&chs=" + size + "' alt='qr' />");
	  
	  //This Provide An Image Download Link
      $("#link").append("<a style='color:#fff;' href='http://chart.apis.google.com/chart?cht=qr&chl=" + data + "&chs=" + size + "'>Download QR Code</a>");
	  
	  //This Provide the Image Link Path In Text
      $("#code").append("<p style='color:#fff;'><strong>Image Link:</strong> http://chart.apis.google.com/chart?cht=qr&chl=" + data + "&chs=" + size + "</p>");
      return false;
} else {
      $("#image").html("");
      $("#link").html("");
      $("#code").html("");
	  
      //QR Code Image
      $("#image").append("<img src='http://chart.apis.google.com/chart?cht=qr&chl=" + data + "&chs=" + size + "' alt='qr' />");
	  
	  //This Provide An Image Download Link
      $("#link").append("<a style='color:#fff;' href='http://chart.apis.google.com/chart?cht=qr&chl=" + data + "&chs=" + size + "'>Download QR Code</a>");
	  
	  //This Provide the Image Link Path In Text
      $("#code").append("<p style='color:#fff;'><strong>Image Link:</strong> http://chart.apis.google.com/chart?cht=qr&chl=" + data + "&chs=" + size + "</p>");
      return false;
    }
  }
});
</script>
        
        