<?php
	session_start();
 	require_once("../config/Database.php");
	require_once("../config/necessaryFunctions.php");
	$conn->query("SET NAMES 'utf8'");
	$conn->query('SET CHARACTER SET utf8');
	$userId = decryptIt($_SESSION['userId']);
 	$temp      = $_GET['temp'];
 	$check_sql = "SELECT * FROM tbl_dealers WHERE (name LIKE '%$temp%' OR family LIKE '%$temp%') AND deleted='0'";
  	$check_query    = $conn->query($check_sql);
	if(isset($check_query)){
		?>
		<ul class='autosearch-ul'>
		<?php
		while($row = $check_query->fetch_array()){
			$id     = $row['id'];
			$name   = $row['name'];
			$family = $row['family'];
 			$temp   = $id . "-" . $name . " " . $family ;
		?>
			<li class='autosearch-li' onClick="getName('<?php echo $temp;?>');"><?php echo $temp;?></li>
			<?php
		}
		
		?>
		</ul>
		<?php
	}
?>