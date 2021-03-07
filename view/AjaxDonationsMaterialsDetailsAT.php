<?php
	session_start();
 	require_once("../config/Database.php");
	require_once("../config/necessaryFunctions.php");
	$conn->query("SET NAMES 'utf8'");
	$conn->query('SET CHARACTER SET utf8');
 	$userId = decryptIt($_SESSION['userId']);
  	$titleId = $_POST['rowId'];
  	$table = $_POST['table'];

   	$selectDate = $conn->query("SELECT * FROM tbl_donations_materials_details WHERE titles_id ='$titleId' AND deleted = 0");
	 
	?>
	<table class="table table-bordered table-hover">
			<thead>
				<tr>
					<th class="text-center table-title" colspan="12">
					جزئیات توزیع اقلام
					</th>
				</tr>
				<tr class="table-header"> 
					<th class='text-center'>شماره</th>
					<th class='text-center'>کالا</th>
					<th class='text-center'>گدام</th>
					<th class='text-center'>واحد</th>
					<th class='text-center'>مقدار مصرف</th>
					<th class='text-center'>فی</th>
					<th class='text-center'>مجموعه</th>
 					<th class='text-center'>توضیحات</th>
				</tr> 
			</thead> 
			<tbody> 
			
			<?php
		
		 
			while($row = $selectDate->fetch_array()){	
			++$counter;
			$rowItems = $conn->selectRecord ("tbl_items","id  = ". $row['items_id']);
			$rowInventory = $conn->selectRecord ("tbl_stocks","id  = ". $row['stocks_id']);
			$rowUnits = $conn->selectRecord ("tbl_item_units","id  = ". $row['items_unit_id']);
			?>
			
			<tr> 
				<td class="small text-center "><?php echo $counter; ?></td>
				<td class='text-center '><?php echo $rowItems['name']; ?></td>
				<td class='text-center '><?php echo $rowInventory['name']; ?></td>
				<td class='text-center'><?php  echo $rowUnits['name']; ?></td>
				<td class='text-center '><?php  echo $row['amount']; ?></td>
				<td class='text-center '><?php  echo $row['fee']; ?></td>
				<td class='text-center '><?php  echo $row['total_amount']; ?></td>
				<td class='text-center'><?php  echo $row['description']; ?></td>
			 </tr>
			
			<?php
				
			} 
			
			?>
			
			</tbody> 
		</table>
	
	 