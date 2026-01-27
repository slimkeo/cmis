<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<?php
 foreach ( $loan_details as $row ): ?>

<title>Loan Details : <?php echo $row['id'] ?> </title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.1/dist/css/bootstrap.min.css" rel="stylesheet">
<style type="text/css">
    	body{
    margin-top:20px;
    background:#eee;
}

.invoice {
    background: #fff;
    padding: 20px
}

.invoice-company {
    font-size: 20px
}

.invoice-header {
    margin: 0 -20px;
    background: #f0f3f4;
    padding: 20px
}

.invoice-date,
.invoice-from,
.invoice-to {
    display: table-cell;
    width: 1%
}

.invoice-from,
.invoice-to {
    padding-right: 20px
}

.invoice-date .date,
.invoice-from strong,
.invoice-to strong {
    font-size: 16px;
    font-weight: 600
}

.invoice-date {
    text-align: right;
    padding-left: 20px
}

.invoice-price {
    background: #f0f3f4;
    display: table;
    width: 100%
}

.invoice-price .invoice-price-left,
.invoice-price .invoice-price-right {
    display: table-cell;
    padding: 20px;
    font-size: 20px;
    font-weight: 600;
    width: 75%;
    position: relative;
    vertical-align: middle
}

.invoice-price .invoice-price-left .sub-price {
    display: table-cell;
    vertical-align: middle;
    padding: 0 20px
}

.invoice-price small {
    font-size: 12px;
    font-weight: 400;
    display: block
}

.invoice-price .invoice-price-row {
    display: table;
    float: left
}

.invoice-price .invoice-price-right {
    width: 25%;
    background: #2d353c;
    color: #fff;
    font-size: 28px;
    text-align: right;
    vertical-align: bottom;
    font-weight: 300
}

.invoice-price .invoice-price-right small {
    display: block;
    opacity: .6;
    position: absolute;
    top: 10px;
    left: 10px;
    font-size: 12px
}

.invoice-footer {
    border-top: 1px solid #ddd;
    padding-top: 10px;
    font-size: 10px
}

.invoice-note {
    color: #999;
    margin-top: 80px;
    font-size: 85%
}

.invoice>div:not(.invoice-footer) {
    margin-bottom: 20px
}

.btn.btn-white, .btn.btn-white.disabled, .btn.btn-white.disabled:focus, .btn.btn-white.disabled:hover, .btn.btn-white[disabled], .btn.btn-white[disabled]:focus, .btn.btn-white[disabled]:hover {
    color: #2d353c;
    background: #fff;
    border-color: #d9dfe3;
}
    </style>
</head>
<body>

<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
<div class="container">
<div class="col-md-12">
<div class="invoice">

<div class="invoice-company text-inverse f-w-600">
<span class="pull-right hidden-print">
<a href="javascript:;" class="btn btn-sm btn-white m-b-10 p-l-5"><i class="fa fa-file t-plus-1 text-danger fa-fw fa-lg"></i> Export as PDF</a>
<a href="javascript:;" onclick="window.print()" class="btn btn-sm btn-white m-b-10 p-l-5"><i class="fa fa-print t-plus-1 fa-fw fa-lg"></i> Print</a>
</span>
<?php echo $this->db->get_where('settings' , array('type' =>'system_name'))->row()->description;?>
</div>


<div class="invoice-header">
<div class="invoice-from">
<small>Company:</small>
<address class="m-t-5 m-b-5">
<strong class="text-inverse"><?php echo $this->db->get_where('settings' , array('type' =>'system_name'))->row()->description;?></strong><br>
<?php echo $this->db->get_where('settings' , array('type' =>'address'))->row()->description;?><br>
City, Zip Code<br>
Phone: <?php echo $this->db->get_where('settings' , array('type' =>'phone'))->row()->description;?><br>
Email: <?php echo $this->db->get_where('settings' , array('type' =>'system_email'))->row()->description;?>
</address>
</div>
<div class="invoice-to">
<small>Client</small>
<address class="m-t-5 m-b-5">
<strong class="text-inverse"><?php echo $this->db->get_where('client' , array('id' =>$row['client_id']))->row()->lastname." ".$this->db->get_where('client' , array('id' =>$row['client_id']))->row()->fullname;?></strong><br>
<?php echo $this->db->get_where('client' , array('id' =>$row['client_id']))->row()->address;?><br>
City, Zip Code<br>
Phone: <?php echo $this->db->get_where('client' , array('id' =>$row['client_id']))->row()->contact;?><br>
Email: <?php echo $this->db->get_where('client' , array('id' =>$row['client_id']))->row()->email;?>
</address>
</div>
<div class="invoice-date">
<small>Invoice / July period</small>
<div class="date text-inverse m-t-5"><?php echo date("M").", ".date("d")." ".date("Y"); ?></div>
<div class="invoice-detail">
#<?php echo $row['id']; ?><br>
LOAN DETAILS
</div>
</div>
</div>


<div class="invoice-content">

<div class="table-responsive">
<table class="table table-invoice">
<thead>
<tr>
<th>PREVIOUS TRANSACTIONS #</th>
<th class="text-center" width="10%">TYPE</th>
<th class="text-center" width="10%">AMOUNT</th>
<th class="text-right" width="20%">REMAINING BALANCE</th>
</tr>
</thead>
<tbody>
<?php 
$transactions=$this->db->get_where( 'loan_transaction', array( 'loan_id' => $row["id"] ) )->result_array();
foreach($transactions as $rowz): ?>
<tr>
<td>
<span class="text-inverse"><?php echo $rowz['timestamp']; ?></span><br>
</td>
<td class="text-center"><?php if($rowz['type']=="-"){ echo "Debit"; }else { echo "Credit"; } ?></td>
<td class="text-center"><?php echo $rowz['amount']; ?></td>
<td class="text-right"><?php echo $rowz['total_balance']; ?></td>
</tr>
<?php endforeach; ?>
</tbody>
</table>
</div>


<div class="invoice-price">
<div class="invoice-price-left">
<div class="invoice-price-row">
<div class="sub-price">
<small>INITIAL AMOUNT</small>
<span class="text-inverse"><?php echo $row['amount']; ?></span>
</div>
<div class="sub-price">
<i class="fa fa-plus text-muted"></i>
</div>
<div class="sub-price">
<small>ACCUMUCULATED INTEREST FOR <?php echo $this->db->get_where('plan',array('id'=>$row['plan']))->row()->months." Months   ".$this->db->get_where('plan',array('id'=>$row['plan']))->row()->rate."%"; ?></small>
</div>
</div>
</div>
<div class="invoice-price-right">
<small>TOTAL BALANCE</small> <span class="f-w-600"><?php echo $row['total_balance']; ?></span>
</div>
</div>

</div>


<div class="invoice-note">
* Make all cheques payable to <?php echo $this->db->get_where('settings' , array('type' =>'system_name'))->row()->description;?><br>
* Payment is due within 30 days<br>
* If you have any questions concerning this invoice, contact us 
</div>


<div class="invoice-footer">
<p class="text-center m-b-5 f-w-600">
THANK YOU FOR YOUR BUSINESS
</p>
<p class="text-center">
<span class="m-r-10"><i class="fa fa-fw fa-lg fa-globe"></i> <?php echo $this->db->get_where('settings' , array('type' =>'system_email'))->row()->description;?></span>
<span class="m-r-10"><i class="fa fa-fw fa-lg fa-phone-volume"></i> T: <?php echo $this->db->get_where('settings' , array('type' =>'phone'))->row()->description;?></span>
</p>
</div>

</div>
</div>
</div>
<script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script><script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.1/dist/js/bootstrap.bundle.min.js"></script>
<script type="text/javascript">
	
</script>
<?php
endforeach;
?>
</body>
</html>