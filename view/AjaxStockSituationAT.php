 <?php 
	session_start();
 	require_once("../config/Database.php");
	require_once("../config/necessaryFunctions.php");
	$conn->query("SET NAMES 'utf8'");
	$conn->query('SET CHARACTER SET utf8');
	$userId = decryptIt($_SESSION['userId']);
	
  	$itemId = $_GET['itemId'];
	$stockId = $_GET['stockId'];
	
	$totalItemsExisted = $conn->query("SELECT * FROM tbl_stock_balance WHERE items_id ='$itemId' AND  stocks_id = '$stockId'");
	
 	if($totalItemsExisted-> num_rows > 0){
	$totalRow = $totalItemsExisted ->fetch_array();
		echo  $existanceAmount = $totalRow['amount'];
		exit();
 	}else{
		echo "empty";
		exit();
	}
  	
 	
?>