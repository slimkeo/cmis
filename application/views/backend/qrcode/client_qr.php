<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">


<title>QR Code - <?php echo $page_title; ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.1/dist/css/bootstrap.min.css" rel="stylesheet">
<script type="text/javascript" src="<?php echo base_url();?>assets/qrcode/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/qrcode/qrcode.js"></script>


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
<?php
 foreach ( $client_details as $row ): ?>
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
<small>System:</small>
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
<strong class="text-inverse"><?php echo $row['lastname']." ".$row['fullname'];?></strong><br>
<?php echo $row['address'];?><br>
City, Zip Code<br>
Phone: <?php echo $row['contact']; ?><br>
Email: <?php echo $row['email']; ?>
</address>
</div>
<div class="invoice-date">
<div class="date text-inverse m-t-5"><?php echo date("M").", ".date("d")." ".date("Y"); ?></div>
<div class="invoice-detail">
#<?php echo $row['id']; ?><br>
Account CODE DETAILS
</div>
</div>
</div>


<div class="invoice-content">
<div id="qrcode" style="width:300px; height:300px; margin-top:15px;"></div>
      
</div>


<div class="invoice-note">
* Make all payements to this accounts under our terms and conditions<br>
* Scan Code to make payment<br>
* If you have any questions concerning this payment method, contact us 
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
var qrcode = new QRCode(document.getElementById("qrcode"), {
    width : 300,
    height : 300
});

function makeCode () {  
    qrcode.makeCode("<?php echo $accountid; ?>");
}

makeCode();

$("#text").
    on("blur", function () {
        makeCode();
    }).
    on("keydown", function (e) {
        if (e.keyCode == 13) {
            makeCode();
        }
    });
</script>
<?php
endforeach;
?>
</body>

</html>