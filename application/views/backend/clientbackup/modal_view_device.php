<?php 
$edit_data		=	$this->db->get_where('device' , array('device_id' => $param2) )->result_array();
?>

<section class="panel">
	<?php foreach($edit_data as $row):?>
	<?php echo form_open(base_url() . 'index.php?admin/devices/do_update/'.$row['device_id'] , array('class' => 'form-horizontal form-bordered validate','target'=>'_top'));?>
	<div class="panel-heading">
		<h4 class="panel-title" >
			<i class="fa fa-tablet"></i>
			<?php echo $row['device_name'];?> - <?php echo $row['serial'];?>
		</h4>
	</div>
	
		<div class="panel-body">
			<table class="table table-striped table-bordered  mb-none">
                
                   

                    
                
                    <tr>
                        <td><?php echo get_phrase('device');?></td>
                        <td><b><?php echo $row['device_name'];?></b></td>
                    </tr>
               
                    <tr>
                        <td><?php echo get_phrase('serial');?></td>
                        <td><b><?php echo $row['serial'];?></b></td>
                    </tr>
                    <tr>
                        <td><?php echo get_phrase('MTN_#');?></td>
                        <td><b><?php echo $row['mtnphone'];?></b></td>
                    </tr>
                    
                    <tr>
                        <td><?php echo get_phrase('MTN_PUK');?></td>
                        <td><b><?php echo $row['mtnpuk'];?></b></td>
                    </tr>
                    <tr>
                        <td><?php echo get_phrase('MTN_sim');?></td>
                        <td><b><?php echo $row['mtnsim'];?></b></td>
                    </tr>
                    <tr>
                        <td><?php echo get_phrase('swazi_mobile');?></td>
                        <td><b><?php echo $row['smmobile'];?></b></td>
                    </tr>
                    <tr>
                        <td><?php echo get_phrase('SM_sim');?></td>
                        <td><b><?php echo $row['smsim'];?></b>
                        </td>
                    </tr>
					
					 <tr>
                        <td><?php echo get_phrase('SM_PUK');?></td>
                        <td><b><?php echo $row['smpuk'];?></b>
                        </td>
                    </tr>
                   
                </table>
				
		</div>
	
		
 </form>
 <?php endforeach;?>
</section> 
        
        