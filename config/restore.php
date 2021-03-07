 <?php
  require_once("dbConstans.php");
  ini_set("post_max_size","64M");
  ini_set("upload_max_filesize","64M");
  $tables = '*';
  $backup_dir = '../backup/';

  $filepath = "";
  if(isset($_POST['submit'])){
  	echo $filepath = '../backup/' . $_FILES['file']['name'];
	die;
  }else {
  	$filepath = '../backup/'.$_GET['file'];
  }

  restore(HOST, USERNAME, PASSWORD, DATABASE, $filepath);
  header("Location: ../pages/givenBackupACI.php?rSuccess");
  exit();

  //Get filepath of newest file in $backup_dir
  function getNewestFile($path_array){
    //Init. datetime with the value of first file
    $max_datetime = filemtime($path_array[0]);
    //init. index with 0
    $newest = 0;
    
    //Find the newest file
    foreach($path_array as $i=> $path){
      //If its datetime bigger, means it is newer.
      if(filemtime($path) > $max_datetime){
        $max_datetime = filemtime($path);
        $newest= $i;
      }
    }
    
    //Return the filePath of newest file
    return $path_array[$newest];
  }
  //End getNewestFile()

  //Build a array of filepath, in order to find the newest file with filemtime()
  function getPathOfFiles($backup_dir){
    //Create a new array to store the pathes
    $path_array = array();
    $files =scandir($backup_dir);//return a array of filenames
    foreach($files as $file){
      if($file != '.' && $file !='..'){//we don't need the dir '.' and '..'
        $path_array[] = $backup_dir.$file;//build the path and put it in array
      }
    }
    //Return a array of filepath as result
    return $path_array;
  }
  //End getPathOfFiles()
 
  function restore($dbhost, $dbuser, $dbpassword, $dbname, $filepath){
    set_time_limit ( 100 );
    
    //Connect to MySQL server and select db
    $link = mysqli_connect($dbhost, $dbuser, $dbpassword,$dbname);
    
    //Check connection
    if (mysqli_connect_errno()){
  	echo "Failed to connect to MySQL: " . mysqli_connect_error();
  	exit;
    }
    
    mysqli_query($link, "SET NAMES 'utf8'");
   
    // Temporary variable, used to store current query
    $templine = '';
    
    // Read in entire file
    $lines = file($filepath);
    
    // Loop through each line
    foreach ($lines as $line){
  	  
  	  // Skip it if it's a comment
  	  if (substr($line, 0, 2) == '--' || $line == '')
  		  continue;
  	  // Add this line to the current segment
  	  $templine .= $line;
  	  
  	  // If it has a semicolon at the end, it's the end of the query
  	  if (substr(trim($line), -1, 1) == ';'){
  		  // Perform the query
  		  mysqli_query($link,$templine) or print('Error performing query \'<strong>' . $templine . '\': ' . mysqli_error($link) . '<br /><br />');
  		  // Reset temp variable to empty
  		  $templine = '';
  	  }
    }
    //end foreach 
  }
  //end restore()
?>
<!-- All Rights Reserved By 'Erteqa Soft' -->