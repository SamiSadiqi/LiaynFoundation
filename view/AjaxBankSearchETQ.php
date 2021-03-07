<?php
	session_start();
 	require_once("../config/Database.php");
	require_once("../config/necessaryFunctions.php");
	$conn->query("SET NAMES 'utf8'");
	$conn->query('SET CHARACTER SET utf8');
	$userId = decryptIt($_SESSION['userId']);
 	$temp      = $_GET['temp'];
 	$check_sql = "SELECT * FROM tbl_banks WHERE (id LIKE '%$temp%' OR name LIKE '%$temp%') AND deleted='0'";
  	$check_query    = $conn->query($check_sql);
	if(isset($check_query)){
		?>
		<ul class='autosearch-ul'>
		<?php
		while($row = $check_query->fetch_array()){
			$id     = $row['id'];
			$name   = $row['name'];
		 
 			$temp   = $id . "-" . $name;
		?>
			<li class='autosearch-li' onClick="getName('<?php echo $temp;?>');"><?php echo $temp;?></li>
			<?php
		}
		
		?>
		</ul>
		<?php
	}
?>