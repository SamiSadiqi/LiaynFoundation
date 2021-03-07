<?php
    require_once("../view/_header.php");
    $tables = '*';
	 
    //Call the core function
    backup_tables(HOST, USERNAME, PASSWORD, DATABASE, $tables);

    //Core function
    function backup_tables($host, $user, $pass, $dbname, $tables = '*'){
        $link = mysqli_connect($host,$user,$pass, $dbname);

        // Check connection
        if (mysqli_connect_errno()){
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
            exit;
        }

        mysqli_query($link, "SET NAMES 'utf8'");

        //get all of the tables
        if($tables == '*'){
            $tables = array();
            $result = mysqli_query($link, 'SHOW TABLES');
            while($row = mysqli_fetch_row($result)){
                $tables[] = $row[0];
            }
        }else{
            $tables = is_array($tables) ? $tables : explode(',',$tables);
        }

        $return = '';
        //cycle through
        foreach($tables as $table){
            $result = mysqli_query($link, 'SELECT * FROM '.$table);
            $num_fields = mysqli_num_fields($result);
            $num_rows = mysqli_num_rows($result);

            $return.= 'DROP TABLE IF EXISTS '.$table.';';
            $row2 = mysqli_fetch_row(mysqli_query($link, 'SHOW CREATE TABLE '.$table));
            $return.= "\n\n".$row2[1].";\n\n";
            $counter = 1;

            //Over tables
            for ($i = 0; $i < $num_fields; $i++){   
                //Over rows
                while($row = mysqli_fetch_row($result)){   
                    if($counter == 1){
                        $return.= 'INSERT INTO '.$table.' VALUES(';
                    }else{
                        $return.= '(';
                    }

                    //Over fields
                    for($j=0; $j<$num_fields; $j++){
                        $row[$j] = addslashes($row[$j]);
                        $row[$j] = str_replace("\n","\\n",$row[$j]);
                        if (isset($row[$j])) { $return.= '"'.$row[$j].'"' ; } else { $return.= '""'; }
                        if ($j<($num_fields-1)) { $return.= ','; }
                    }

                    if($num_rows == $counter){
                        $return.= ");\n";
                    }else{
                        $return.= "),\n";
                    }
                    ++$counter;
                }
            }
            $return.="\n\n\n";
        }

        //Save Backup File
    	$backup_dir = '../backup/';
        $fileName   = date('Y-m-d-h-i-s').'.sql';
		$insertSQL  = "insert into tbl_backup (name,users_id,created_at) VALUES ('$fileName', '9' ,NOW())";
     	$insertQuery= mysqli_query($link,$insertSQL);
    	
    	if ($handle = fopen($backup_dir . '' . $fileName, 'w+')){
    		fwrite($handle, $return);
    		echo "<script>
    		
    				var popout = window.open('../backup/$fileName');
    				window.setTimeout(function(){
    					popout.close();
    				}, 1000);
    		
    			</script>";
    		
    		echo "<meta http-equiv='refresh' content ='1; url=../view/givenBackupACI.php?bSuccess'>";
    		exit();
    		fclose($handle);
    	}else{
    		echo "<meta http-equiv='refresh' content ='1; url=../view/givenBackupACI.php?bSuccess'>";
    		exit();
    	}
    }
?>
<!-- All Rights Reserved By 'Erteqa Soft' -->