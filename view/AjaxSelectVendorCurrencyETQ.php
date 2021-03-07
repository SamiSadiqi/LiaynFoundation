 <?php 
	session_start();
 	require_once("../config/Database.php");
	require_once("../config/necessaryFunctions.php");
	$conn->query("SET NAMES 'utf8'");
	$conn->query('SET CHARACTER SET utf8');
	$userId = decryptIt($_SESSION['userId']);
	
  	$vendorId = $_POST['vendorId'];
		$selectVendor = $conn->query("SELECT * FROM `tbl_vendors` WHERE id = $vendorId AND deleted = 0 ORDER BY id DESC");
		$rowVendor = $selectVendor->fetch_array();
		$currencyId = $rowVendor['currencies_id'];
			echo "<option value=''>انتخاب واحد پولی</option>";

		$currenciesRow= $conn->query("SELECT * FROM `tbl_currencies` WHERE id = $currencyId AND deleted = 0 ORDER BY id DESC");
			while($row = $currenciesRow->fetch_array()){
					
				$id   = $row['id'];
				$name = $row['code'];
				echo "<option value='$id'>$name</option>";
			}	
?>