<?php
ob_start();
function durationWroking($time_ago)
	{
		$time_elapsed   =  $time_ago;
		$seconds    = $time_elapsed ;
		$minutes    = round($time_elapsed / 60 );
		$hours      = round($time_elapsed / 3600);
		$days       = round($time_elapsed / 86400 );
		$weeks      = round($time_elapsed / 604800);
		$months     = round($time_elapsed / 2600640 );
		$years      = round($time_elapsed / 31207680 );
		// Seconds
		if($seconds <= 60){
			return "$seconds minutes";
		}
		//Minutes
		else if($minutes <=60){
			if($minutes==1){
				return "one minute";
			}
			else{
				return "$minutes minutes";
			}
		}
		//Hours
		else if($hours <=24){
			if($hours==1){
				return "one hour";
			}else{
				return "$hours hrs";
			}
		}
		//Days
		else if($days <= 24){
			 
				return "$days days";
			 
		}
		//Weeks
		else if($weeks <= 4.3){
			 
				return "$weeks weeks";
			 
		}
		//Months
		else if($months <=12){
			if($months==1){
				return "a month ago";
			}else{
				return "$months months";
			}
		}
		//Years
		else{
			if($years==1){
				return "one year";
			}else{
				return "$years years";
			}
		}
	}
	// GmailFormat Which I am creating
	  function gmailFormat($created_at)
	{
	  
		$cur_time   = time();
	 
		$time_elapsed   = $cur_time - $created_at;
		
		$seconds    = $time_elapsed ;
		$minutes    = round($time_elapsed / 60 );
		$hours      = round($time_elapsed / 3600);
		$days       = round($time_elapsed / 86400 );
		 
		// Seconds
		if($seconds <= 60){
			return "just now";
		}
		//Minutes
		else if($minutes <=60){
			if($minutes==1){
				return "one minute ago";
			}
			else{
				return "$minutes minutes ago";
			}
		}
		//Hours
		else if($hours <=24){
			if($hours==1){
				return "one hour ago";
			}else{
				return "$hours hrs ago";
			}
		}
	 
		else if($days == 1){
			 
				return "24 hours ago";
			 
			 
		}else{
			 return  date("d-m-Y - H:i:A", $created_at);
		}
		 
	}  
	
	//functin for datadiffernt or the duration of online or offline.
	function onlineOffline($durationLogin)
	{
	 
		$time_elapsed   =  $durationLogin;
		 
		$seconds    = $time_elapsed ;
		$minutes    = round($time_elapsed / 60 );
		$hours      = round($time_elapsed / 3600);
		$days       = round($time_elapsed / 86400 );
		$weeks      = round($time_elapsed / 604800);
		$months     = round($time_elapsed / 2600640 );
		$years      = round($time_elapsed / 31207680 );
		// Seconds
		if($seconds <= 60){
			return "last seen 60s ago";
		}
		//Minutes
		else if($minutes <=60){
			if($minutes==1){
				return "Last seen 1 minute ago";
			}
			else{
				return "Last seen $minutes minutes ago";
			}
		}
		//Hours
		else if($hours <=24){
			if($hours==1){
				return "Last seen an hour ago";
			}else{
				return "Last seen $hours hrs ago";
			}
		}
		//Days
		else if($days <= 7){
			if($days==1){
				return "Last seen one day ago";
			}else{
				return "Last seen $days days ago";
			}
		}
		//Weeks
		else if($weeks <= 4.3){
			if($weeks==1){
				return "Last seen  a week ago";
			}else{
				return "Last seen $weeks weeks ago";
			}
		}
		//Months
		else if($months <=12){
			if($months==1){
				return "Last seen 1 month ago";
			}else{
				return "Last seen $months months ago";
			}
		}
		//Years
		else{
			if($years==1){
				return "Last seen one year";
			}else{
				return "Last seen $years years";
			}
		}
	}
	//Tow way encryption algorithm
	function encryptIt( $q ) {
		$qEncoded      = base64_encode($q);
		return( $qEncoded );
	}
 
 	//Tow way decryption algorithm
	function decryptIt( $q ) {
		$qDecoded  = base64_decode($q);
		return( $qDecoded );
	}
	//Check User Block

	//Check user is logged in or not 
	function isLoggedIn(){
	    if(!isset($_SESSION['userId']) || !$_SESSION['Login'] === TRUE || empty($_SESSION['username'])){
	        header('location:login.php');
	        exit();
	    }
	}
	function isBannedUser($userId){
		$conn      = new Database(HOST, USERNAME, PASSWORD, DATABASE);
		$queryResult = $conn->query("SELECT * FROM tbl_users where id = $userId AND deleted = 0 AND status = 1")or trigger_error(mysqli_error());
		$result =  $queryResult->fetch_array();
		if($result['status'] == 1){
			 header('location:logout.php');
		}
		
	}
	//check Timestamp Login
	function checkTimeStamp(){
		if(time() - $_SESSION['last_login_timpestamp'] > 900) { //subtract new timestamp from the old one
			echo"<script>alert('15 Minutes over!');</script>";
			header("Location: logout.php"); //redirect to index.php
			exit;
		}else {
			$_SESSION['last_login_timpestamp'] = time(); //set new timestamp
		}
	}
	//Set active class to site navigation
	function addActiveClass($pageUrl){
	  if(stripos($_SERVER['REQUEST_URI'], $pageUrl)){
		    echo 'active'; 
		}
	}

	//Get system base URL
	function getBaseURL(){
	    $base_url="http://".$_SERVER['SERVER_NAME'].dirname($_SERVER["REQUEST_URI"].'?').'/';
	    return $base_url;
	}

	//Get system's Model root directory
	function getRootModel(){
		//Returns the current URL
	    $parts = explode("view", $_SERVER['REQUEST_URI']);
	    $dir   = "http://".$_SERVER['SERVER_NAME'];
	   
	    for ($i=0; $i < count($parts)-1; $i++) { 
	    	$dir .= $parts[$i];
	    }
	    return $dir . 'models/';
	}
	 
	
	function fetchFormSubmissionButtons(){
		echo '<div class="form-group"> 
				<div class="col-lg-6 col-md-8 col-sm-10 col-lg-offset-4 col-md-offset-3 col-sm-offset-2"> 
					<button class="btn btn-success btn-outline" type="button" id="insertId"> ثبت  <i class="fa fa-paste"></i>  </button>
					<button class="btn btn-warning btn-outline" type="reset">پاک کردن <i class="fa fa-refresh"></i></button> 

				</div> 
			</div>';
	}
	function fetchFormSubmissionActionButtons(){
		echo '<div class="form-group"> 
				<div class="col-lg-6 col-md-8 col-sm-10 col-lg-offset-4 col-md-offset-3 col-sm-offset-2"> 
					<button class="btn btn-success btn-outline" type="submit"  > ثبت  <i class="fa fa-paste"></i>  </button>
					<button class="btn btn-warning btn-outline" type="reset">پاک کردن <i class="fa fa-refresh"></i></button> 

				</div> 
			</div>';
	}
	 
	function editFormSubmissionButtons($url){
  		echo '<div class="form-group"> 
				<div class="col-lg-6 col-md-8 col-sm-10 col-lg-offset-4 col-md-offset-3 col-sm-offset-2"> 
					<button class="btn btn-success btn-outline" type="submit"> ویرایش <i class="fa fa-paste"></i> </button>
					<button class="btn btn-info btn-outline" type="reset"  onclick =window.location.replace("'.$url.'");> &nbsp;Return&nbsp; <i class="fa fa-forward"></i></i></button> 
				</div> 
			</div>';
	}
	
	function searchFormSubmissionButtons(){
  		echo '<div class="form-group"> 
				<div class="col-lg-6 col-md-8 col-sm-10 col-lg-offset-4 col-md-offset-3 col-sm-offset-2"> 
					<button class="btn btn-warning btn-outline" type="reset"><i class="fa fa-refresh"></i> &nbsp;پاک کردن&nbsp; </button> 
					<button class="btn btn-success btn-outline" type="submit"> <i class="fa fa-search"></i> جستجو </button>
				</div> 
			</div>';
	}
	function goBackward($url){
	
		echo '<li><a   onclick =window.location.replace("'.$url.'"); class="btn btn-success">بازگشت</a></li>';

	}
	
function restoreMysqlDB($filePath)
{
	$conn      = new Database(HOST, USERNAME, PASSWORD, DATABASE);
	
    $sql = '';
    $error = '';
    
    if (file_exists($filePath)) {
        $lines = file($filePath);
        
        foreach ($lines as $line) {
            
            // Ignoring comments from the SQL script
            if (substr($line, 0, 2) == '--' || $line == '') {
                continue;
            }
            
            $sql .= $line;
            
            if (substr(trim($line), - 1, 1) == ';') {
                $result = $conn->query($conn, $sql);
                if (! $result) {
                    $error .= $conn->mysqli_error($conn) . "\n";
                }
                $sql = '';
            }
        } // end foreach
        
        if ($error) {
            $response = array(
                "type" => "error",
                "message" => $error
            );
        } else {
            $response = array(
                "type" => "success",
                "message" => "Database Restore Completed Successfully."
            );
        }
        exec('rm ' . $filePath);
    } // end if file exists
    
    return $response;
}
//function to reading the number_format
function convertNumberToWord($num = false)
{
    $num = str_replace(array(',', ' '), '' , trim($num));
    if(! $num) {
        return false;
    }
    $num = (int) $num;
    $words = array();
    $list1 = array('', 'one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine', 'ten', 'eleven',
        'twelve', 'thirteen', 'fourteen', 'fifteen', 'sixteen', 'seventeen', 'eighteen', 'nineteen'
    );
    $list2 = array('', 'ten', 'twenty', 'thirty', 'forty', 'fifty', 'sixty', 'seventy', 'eighty', 'ninety', 'hundred');
    $list3 = array('', 'thousand', 'million', 'billion', 'trillion', 'quadrillion', 'quintillion', 'sextillion', 'septillion',
        'octillion', 'nonillion', 'decillion', 'undecillion', 'duodecillion', 'tredecillion', 'quattuordecillion',
        'quindecillion', 'sexdecillion', 'septendecillion', 'octodecillion', 'novemdecillion', 'vigintillion'
    );
    $num_length = strlen($num);
    $levels = (int) (($num_length + 2) / 3);
    $max_length = $levels * 3;
    $num = substr('00' . $num, -$max_length);
    $num_levels = str_split($num, 3);
    for ($i = 0; $i < count($num_levels); $i++) {
        $levels--;
        $hundreds = (int) ($num_levels[$i] / 100);
        $hundreds = ($hundreds ? ' ' . $list1[$hundreds] . ' hundred' . ' ' : '');
        $tens = (int) ($num_levels[$i] % 100);
        $singles = '';
        if ( $tens < 20 ) {
            $tens = ($tens ? ' ' . $list1[$tens] . ' ' : '' );
        } else {
            $tens = (int)($tens / 10);
            $tens = ' ' . $list2[$tens] . ' ';
            $singles = (int) ($num_levels[$i] % 10);
            $singles = ' ' . $list1[$singles] . ' ';
        }
        $words[] = $hundreds . $tens . $singles . ( ( $levels && ( int ) ( $num_levels[$i] ) ) ? ' ' . $list3[$levels] . ' ' : '' );
    } //end for loop
    $commas = count($words);
    if ($commas > 1) {
        $commas = $commas - 1;
    }
    return implode(' ', $words);
}
?>