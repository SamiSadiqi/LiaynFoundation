<?php
	session_start();
 	require_once("../config/Database.php");
	require_once("../config/necessaryFunctions.php");
	$conn->query("SET NAMES 'utf8'");
	$conn->query('SET CHARACTER SET utf8');
 	$userId = decryptIt($_SESSION['userId']);
  	$titleId = $_POST['titleId'];

   	$selectDate = $conn->query("SELECT * FROM tbl_schools_requests_equipments_details WHERE id ='$titleId' AND deleted = 0");
	 
	?>
	<table class="table table-bordered table-hover">
			<thead>
				<tr>
					<th class="text-center table-title" colspan="12">
					جزئیات کالای درخواستی
					</th>
				</tr>
				<tr class="table-header"> 
					<th class='text-center'>شماره</th>
					<th class='text-center'>کالا</th>
					<th class='text-center'>واحد</th>
					<th class='text-center'>مقدار</th>
					<th class='text-center'>توضیحات</th>
				</tr> 
			</thead> 
			<tbody> 
			
			<?php
		
		 
			while($row = $selectDate->fetch_array()){	
			++$counter;
			$rowItems = $conn->selectRecord ("tbl_items","id  = ". $row['items_id']);
			$rowUnits = $conn->selectRecord ("tbl_item_units","id  = ". $row['items_unit_id']);
			?>
			
			<tr> 
				<td class="small text-center "><?php echo $counter; ?></td>
				<td class='text-center '><?php echo $rowItems['name']; ?></td>
				<td class='text-center'><?php  echo $rowUnits['name']; ?></td>
				<td class='text-center '><?php  echo $row['quantity']; ?></td>
				<td class='text-center'><?php  echo $row['description']; ?></td>
			 </tr>
			
			<?php
				
			} 
			
			?>
			
			</tbody> 
		</table>
	
	 