<?php 
	session_start();
 	require_once("../config/Database.php");
	require_once("../config/necessaryFunctions.php");
	$conn->query("SET NAMES 'utf8'");
	$conn->query('SET CHARACTER SET utf8');
	$userId = decryptIt($_SESSION['userId']);
	$currentTime =  time();
	
	$validName = $conn->safeInput($_POST['name']);
	$table = decryptIt($conn->safeInput($_POST['table']));
	if($table == 'tbl_item_units'){
 
		/*======================= Check For Duplicate ================= */
			$selectExistedData  = "SELECT * FROM `$table` WHERE deleted = 0 AND name = '$validName'";
 			$existedQuery = $conn->query($selectExistedData);
 			if($existedQuery->num_rows> 0 ){
				echo 'duplicate';
				exit();
			}
 			/*======================= End Check For Duplicate ================= */
			$conn->query("BEGIN");
			 
			$insertSQLQuery    = $conn->query("INSERT INTO $table (name, users_id, deleted, created_at) VALUES ('$validName', $userId, 0, '$currentTime ')");
			if($insertSQLQuery){
				$conn->query("COMMIT");
				$selectInsertQuery = $conn->query("SELECT * FROM  $table where deleted = 0 and users_id = $userId  ORDER BY id DESC");
				$rowDate = $selectInsertQuery->fetch_array();
				$name = $rowDate['name'];
				$id = $rowDate['id'];
				echo "<option value=".$id.">".$name."</option>";
				exit();
			}else{
				$conn->query("ROLLBACK");
				echo "error";
				exit();
			}
		
	}elseif($table == 'tbl_item_categories'){
 
		/*======================= Check For Duplicate ================= */
			$selectExistedData  = "SELECT * FROM `$table` WHERE deleted = 0 AND name = '$validName'";
 			$existedQuery = $conn->query($selectExistedData);
 			if($existedQuery->num_rows> 0 ){
				echo 'duplicate';
				exit();
			}
 			/*======================= End Check For Duplicate ================= */
			$conn->query("BEGIN");
			 
			$insertSQLQuery    = $conn->query("INSERT INTO $table (name, users_id, deleted, created_at) VALUES ('$validName', $userId, 0, '$currentTime ')");
			if($insertSQLQuery){
				$conn->query("COMMIT");
				$selectInsertQuery = $conn->query("SELECT * FROM  $table where deleted = 0 and users_id = $userId  ORDER BY id DESC");
				$rowDate = $selectInsertQuery->fetch_array();
				$name = $rowDate['name'];
				$id = $rowDate['id'];
				echo "<option value=".$id.">".$name."</option>";
				exit();
			}else{
				$conn->query("ROLLBACK");
				echo "error";
				exit();
			}
		
	}elseif($table == 'tbl_stocks'){
 			$validDescription = $conn->safeInput($_POST['description']);

		/*======================= Check For Duplicate ================= */
			$selectExistedData  = "SELECT * FROM `$table` WHERE deleted = 0 AND name = '$validName' AND description = '$validDescription'";
 			$existedQuery = $conn->query($selectExistedData);
 			if($existedQuery->num_rows> 0 ){
				echo 'duplicate';
				exit();
			}
 			/*======================= End Check For Duplicate ================= */
			$conn->query("BEGIN");
			 
			$insertSQLQuery    = $conn->query("INSERT INTO $table (name,description, users_id, deleted, created_at) VALUES ('$validName','$validDescription', $userId, 0, '$currentTime ')");
			if($insertSQLQuery){
				$conn->query("COMMIT");
				$selectInsertQuery = $conn->query("SELECT * FROM  $table where deleted = 0 and users_id = $userId  ORDER BY id DESC");
				$rowDate = $selectInsertQuery->fetch_array();
				$name = $rowDate['name'];
				$id = $rowDate['id'];
				echo "<option value=".$id.">".$name."</option>";
				exit();
			}else{
				$conn->query("ROLLBACK");
				echo "error";
				exit();
			}
		
	}elseif($table == 'tbl_vendor_categories'){
		
 
		/*======================= Check For Duplicate ================= */
			$selectExistedData  = "SELECT * FROM `$table` WHERE deleted = 0 AND name = '$validName'";
 			$existedQuery = $conn->query($selectExistedData);
 			if($existedQuery->num_rows> 0 ){
				echo 'duplicate';
				exit();
			}
 			/*======================= End Check For Duplicate ================= */
			$conn->query("BEGIN");
			 
			$insertSQLQuery = $conn->query("INSERT INTO $table (name, users_id, deleted, created_at) VALUES ('$validName', $userId, 0,'$currentTime')"); 
			if($insertSQLQuery){
				$conn->query("COMMIT");
				$selectInsertQuery = $conn->query("SELECT * FROM  $table where deleted = 0 and users_id = $userId  ORDER BY id DESC");
				$rowDate = $selectInsertQuery->fetch_array();
				$name = $rowDate['name'];
				$id = $rowDate['id'];
				echo "<option value=".$id.">".$name."</option>";
				exit();
			}else{
				$conn->query("ROLLBACK");
				echo "error";
				exit();
			}
		
	}elseif($table == 'tbl_org_expense_categories'){
		
 
		/*======================= Check For Duplicate ================= */
			$selectExistedData  = "SELECT * FROM `$table` WHERE deleted = 0 AND name = '$validName'";
 			$existedQuery = $conn->query($selectExistedData);
 			if($existedQuery->num_rows> 0 ){
				echo 'duplicate';
				exit();
			}
 			/*======================= End Check For Duplicate ================= */
			$conn->query("BEGIN");
			 
			$insertSQLQuery = $conn->query("INSERT INTO $table (name, users_id, deleted, created_at) VALUES ('$validName', $userId, 0,'$currentTime')"); 
			if($insertSQLQuery){
				$conn->query("COMMIT");
				$selectInsertQuery = $conn->query("SELECT * FROM  $table where deleted = 0 and users_id = $userId  ORDER BY id DESC");
				$rowDate = $selectInsertQuery->fetch_array();
				$name = $rowDate['name'];
				$id = $rowDate['id'];
				echo "<option value=".$id.">".$name."</option>";
				exit();
			}else{
				$conn->query("ROLLBACK");
				echo "error";
				exit();
			}
		
	}