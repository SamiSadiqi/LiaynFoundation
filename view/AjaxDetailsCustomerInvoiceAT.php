<?php
session_start();
 	require_once("../config/Database.php");
	require_once("../config/necessaryFunctions.php");
	$conn->query("SET NAMES 'utf8'");
	$conn->query('SET CHARACTER SET utf8');
	$userId = decryptIt($_SESSION['userId']);
	
	 $rowId = $_POST['id'];
	$purchaseRawSQLQuery    = "SELECT * FROM  tbl_customer_bill_title WHERE deleted = 0 AND  id = $rowId";
	$purchaseSQLQuery            = $conn->query($purchaseRawSQLQuery);

	if($purchaseSQLQuery->num_rows > 0){
	?>
	<div class="table-responsive">
	<table class="table table-bordered table-hover">
		<thead>
			<tr>
				<th class="text-center table-title" colspan="12">
				Customer Invoice List
				</th>
			</tr>
			<tr class="table-header"> 
				<th class='text-center'>No</th>
				<th class='text-center'>Item</th>
				<th class='text-center'>Unit</th>
				<th class='text-center'>Quantity</th>
				<th class='text-center'>Unit Price</th>
				<th class='text-center'>Total</th>
				<th class='text-center'>Inventory</th>
				<th class='text-center'>description</th>
			</tr> 
		</thead> 
		<tbody> 
		
		<?php

	 
			$rowTitle = $purchaseSQLQuery->fetch_array();
			$rowIdTitle = $rowTitle['id'];
			
			$selctCustomerDetails = $conn->query("SELECT * FROM tbl_customer_bill_details WHERE deleted = 0 AND  title_bills_id = $rowIdTitle");
			
		while($row = $selctCustomerDetails->fetch_array()){

		++$counter;
		$rowItems = $conn->selectRecord ("tbl_items","id  = ". $row['items_id']);
		$rowUnits = $conn->selectRecord ("tbl_item_units","id  = ". $row['items_unit_id']);
		$rowStock = $conn->selectRecord ("tbl_stocks","id  = ". $row['stocks_id']);
		?>
		
		<tr id='row-<?php echo $row['id']; ?>'> 
			<td class="small text-center "><?php echo $counter; ?></td>
			<td class='text-center '><?php echo $rowItems['name']; ?></td>
			<td class='text-center'><?php  echo $rowUnits['name']; ?></td>
			<td class='text-center '><?php  echo $row['amount']; ?></td>
			<td class='text-center'><?php  echo $row['fee']; ?></td>
			<td class='text-center '><?php  echo $row['total_amount']; ?></td>
			<td class='text-center '><?php  echo $rowStock['name']; ?></td>
			<td class='text-center'><?php  echo $row['description']; ?></td>
		</tr>
		
		<?php
			
		} 
		
		?>
		
		</tbody> 
	</table>
	</div>
	<?php  } ?>