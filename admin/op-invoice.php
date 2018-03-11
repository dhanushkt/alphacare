<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!-- Site Title -->
	<title>AlphaCare - Invoice page</title>
	<!-- Favicon Icon -->
	<link rel="icon" type="image/x-icon" href="../landerpage/images/fevicon1.png" />
	<!-- Font Awesoeme Stylesheet CSS -->
	<link rel="stylesheet" href="../landerpage/font-awesome/css/font-awesome.min.css" />
	<!-- Google web Font -->
	<link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Montserrat:400">
	<!-- Bootstrap core CSS -->
	<link rel="stylesheet" href="../landerpage/css/bootstrap.min.css">
	<!-- Material Design Lite Stylesheet CSS -->
	<link rel="stylesheet" href="../landerpage/css/material.min.css" />
	<!-- Custom Main Stylesheet CSS -->
	<link rel="stylesheet" href="../landerpage/css/invoice.css">
</head>
<body>
	<div class="container">
		<table class="invoice-hdr">	
			<tr>
				<td>
					<h4>JAYASHREE HOSPITAL</h4>
					<p>KS RAO ROAD</p>
					<p>Email-ID: jayashree@gmail.com</p>
					<p>Contact: 0824-2429729</p>
				</td>
				<td class="invoice-logo">
					<img src="../plugins/images/invoice-logo.png" alt="">
				</td>
			</tr>
		</table>
		<div class="invoice-bdy">
			<center><h4>OUTPATIENT BILL</h4></center>
			<div class="row">
				<div class="col-6">
					<table class="invoice-info">
						<tr>
							<td class="dark">Patient Name</td>
							<td><input type="text"></td>
						</tr>
						<tr>
							<td class="dark">Age</td>
							<td><input type="text"></td>
						</tr>
						<tr>
						<td class="dark">Sex</td>
						 <td><input class="text"></td>
						</tr>
						<tr>
							<td class="dark">Mobile Number</td>
							<td><input type="text"></td>
						</tr>
					</table>
				</div>
				<div class="col-6">
					<table class="pull-right invoice-info">
						<tr>
							<td class="dark">Address</td>
							<td><input type="text"></td>
						</tr>
						<tr>
							<td class="dark">Date</td>
							<td><input type="text"></td>
						</tr>
						<tr>
							<td class="dark">Payment Method</td>
							<td><input type="text"></td>
						</tr>
					</table>
				</div>
			</div>
			<div class="items">
				<table>
					<tr>
						<th>Item Name</th>
						<th>Description</th>
						<th>Unit Cost</th>
						<th>Quantity</th>
						<th>Tax( in % )</th>
						<th>Tax( in &#8377;)</th>
						<th>Price( in &#8377;)</th>
					</tr>
					<tr class="item-row">
						<td>
							<textarea class="font-14" placeholder="Item Name"></textarea>
							<a class="item-delete">x</a>
						</td>
						<td>
							<textarea class="item-description" rows="3" placeholder="Item Description"></textarea>
						</td>
						<td class="item-width">
							<textarea class="item-cost"></textarea>
						</td>
						<td class="item-width">
							<textarea class="item-quantity"></textarea>
						</td>
						<td class="item-width">
							<textarea class="item-tax"></textarea>
						</td>
						<td class="item-width item-tax-price"></td>
						<td class="item-width item-total-price"></td>
					</tr>
					<tr class="item-hide">
						<td colspan="7">
							<a class="item-add">Add Item</a>
						</td>
					</tr>
					<tr>
						<td colspan="3" class="blank"></td>
						<td colspan="2" class="text-right">Sub Total( in &#8377; )</td>
						<td colspan="2">
							<span id="subtotal"></span>
						</td>
					</tr>
					<tr>
						<td colspan="3" class="blank"></td>
						<td colspan="2" class="text-right">Tax( in &#8377; )</td>
						<td colspan="2">
							<span id="tax"></span>
						</td>
					</tr>
					<tr>
						<td colspan="3" class="blank"></td>
						<td colspan="2" class="text-right">Discount( in &#8377;)</td>
						<td colspan="2">
							<input type="text" id="discount" placeholder="">
						</td>
					</tr>
					<tr>
						<td colspan="3" class="blank"></td>
						<td colspan="2" class="text-right">Total Amount( in &#8377; )</td>
						<td colspan="2">
							<span id="total"></span>
						</td>
					</tr>
					<tr>
						<td colspan="3" class="blank"></td>
						<td colspan="2" class="text-right">Amount Paid( in &#8377; )</td>
						<td colspan="2">
							<input type="text" id="paid" placeholder="">
						</td>
					</tr>
					<tr>
						<td colspan="3" class="blank"></td>
						<td colspan="2" class="text-right">Amount Due( in &#8377; )</td>
						<td colspan="2">
							<span id="due"></span>
						</td>
					</tr>
					<!--<tr><td colspan="3"><button onClick="myFunction()">Print</button></td></tr>-->
					<tr class="item-hide">
						<td colspan="7">
							<center><button onClick="window.print()" class="mdl-button mdl-js-button">Print</button></center>
						</td>
					</tr>
				</table>
			</div>
		</div>
		<div class="invoice-ftr">
			<p>Note</p>
			<textarea placeholder="PLEASE CHECK THE BILL BEFORE LEAVING "></textarea>
			<center><h6>THANK YOU (AlphaCare Team)</h6></center>
		</div>
</div>
	<!-- Jquery Library 2.1 JavaScript-->
<script language="JavaScript"> 
if (window.print) {
document.write('<form><input type=button name=print value="Print" onClick="window.print()"></form>');
}
</script>
	<script src="../landerpage/js/jquery-2.1.4.min.js"></script>
    <!-- Popper JavaScript-->
    <script src="../landerpage/js/popper.min.js"></script>
	<!-- Bootstrap Core JavaScript-->
	<script src="../landerpage/js/bootstrap.min.js"></script>
	<!-- Material Design Lite JavaScript-->
	<script src="../landerpage/js/material.min.js"></script>
	<!-- main invoice JavaScript-->
	<script src="../landerpage/js/invoice.js"></script>
</body>
</html>