<?php
	session_start();
 	require_once("../config/Database.php");
	require_once("../config/necessaryFunctions.php");
	$conn->query("SET NAMES 'utf8'");
	$conn->query('SET CHARACTER SET utf8');
	$userId = decryptIt($_SESSION['userId']);
 	$factorId      = $_GET['temp'];
	$check_sql = "SELECT * FROM tbl_customer_bill_title WHERE (factor_number LIKE '%$factorId%' OR id LIKE '%$factorId%') AND deleted='0' AND users_id = $userId";
   	
	$check_query    = $conn->query($check_sql);
	if(isset($check_query)){
		?>
		<ul class='autosearch-ul'>
		<?php
		while($row = $check_query->fetch_array()){
			$id     = $row['id'];
			$factorIdSuggest   = $row['factor_number'];
  			$temp   = $id . "-" . $factorIdSuggest ;
		?>
			<li class='autosearch-li' onClick="getName('<?php echo $temp;?>');"><?php echo $temp;?></li>
			<?php
		}
		
		?>
		</ul>
		<?php
	}
?>