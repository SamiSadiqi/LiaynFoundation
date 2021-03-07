<?php	 
require_once("dbConstants.php");
	class Database{
		private $host;
		private $user;
		private $password;
		private $database;
		private $startDate;
		private $endDate;
		private $conn;

		public function __construct($host, $user, $password, $database) {

			$this->host     = $host;
			$this->user     = $user;
			$this->password = $password;
			$this->database = $database;

			$isExpired = $this->is_expired($this->startDate, $this->endDate);
			$this->initialize();

			if(!$isExpired){
				$this->conn = @new mysqli($this->host, $this->user, $this->password, $this->database);

				if($this->conn->connect_errno){
					die("Could Not Connect To Database! Error Details : " . mysqli_connect_error());
				}else{;
					return $this->conn;
				}
				
			}else{
				header("location: systemExpire.php");
			}
		}

		//Check wether system is expired or not
		private function is_expired($startDate, $endDate){
			$keyword   = "Mojtaba Bahrami, Erteqa Software Development Company";
			
			$startDate = strtotime($startDate);
		    $endDate   = strtotime($endDate);

		    $userDate  = date("Y/m/d");
			$userDate  = strtotime($userDate);

			//Expire if the usage date is finished
			if($userDate >= $startDate && $userDate <= $endDate){   
				return TRUE;
			}else{	
				return FALSE;
			}
		}

		private function initialize(){
			//Set true if production environment else false for development
			define('IS_ENV_PRODUCTION', false);

			//Configure error reporting options
			if (!IS_ENV_PRODUCTION){
				error_reporting(E_ALL & ~E_NOTICE);
			}

			ini_set('display_errors', !IS_ENV_PRODUCTION);
			ini_set('error_log', '../log/error.txt');

			//Set time zone to use date/time functions without warnings
			date_default_timezone_set('Asia/Kabul');
		}

		//Set method for expiration dates
		public function set_expiration_dates($fromDate, $toDate){
			$this->startDate = $fromDate;
			$this->endDate   = $toDate;
		}
		
		//Query MYSQL Function
		public function query($rawSQL){
			return $this->conn->query($rawSQL);
		}
		
		//Validate text fields basically
		public function safeInput($text){
			return mysqli_real_escape_string($this->conn, strip_tags(htmlspecialchars(stripcslashes(trim($text)))));
		}
		
		//Select And Fetchs Records If There Was Anyone
		public function selectRecord($table, $condition){
			$queryResult = $this->conn->query("SELECT * FROM $table WHERE $condition AND deleted = 0");

			if($queryResult->num_rows > 0){
				return $queryResult->fetch_array();
			}else{
				return FALSE;
			}
		}
		public function paginate($table, $targetPage, $limit, $page){
			
			$totalRecordsRawSQL   = "SELECT COUNT(*) AS totalRecords FROM $table WHERE  deleted = 0 ORDER BY id DESC";
			$totalRecordsSQLQuery = $this->conn->query($totalRecordsRawSQL);
			$totalRecordsReturned = $totalRecordsSQLQuery->fetch_array();
			$totalRecords         = $totalRecordsReturned['totalRecords'];
			
			
			// Initial page num setup
			if($page == 0){
				$page = 1;
			}
			
			$stages = 3;
			$prev   = $page - 1;  
			$next   = $page + 1;                          
			$lastpage   = ceil($totalRecords/$limit);      
			$LastPagem1 = $lastpage - 1;
			$paginate   = '';

			if($lastpage > 1){
				$paginate .= "<div class = 'paginate'>";
				
				//Previous
				if($page > 1){
					$paginate .= "<a href = '$targetPage?page=$prev'>قبلي</a>";
				}else{
					$paginate .= "<span class = 'disabled'>قبلي</span>";
				}
			   
				//Pages  
				if($lastpage < 7 + ($stages * 2)){     // Not enough pages to breaking it up  
					for($counter = 1; $counter <= $lastpage; $counter++){
						if ($counter == $page){
							$paginate .= "<span class = 'current'>$counter</span>";
						}else{
							$paginate .= "<a href = '$targetPage?page=$counter'>$counter</a>";
						}                    
					}
				}elseif($lastpage > 5 + ($stages * 2)){ // Enough pages to hide a few?
					// Beginning only hide later pages
					if($page < 1 + ($stages * 2)){
						for ($counter = 1; $counter < 4 + ($stages * 2); $counter++){
							if($counter == $page){
								$paginate .= "<span class = 'current'>$counter</span>";
							}else{
								$paginate .= "<a href = '$targetPage?page=$counter'>$counter</a>";}                    
						}

						$paginate .= "...";
						$paginate .= "<a href = '$targetPage?page=$LastPagem1'>$LastPagem1</a>";
						$paginate .= "<a href = '$targetPage?page=$lastpage'>$lastpage</a>";       
					}elseif($lastpage - ($stages * 2) > $page && $page > ($stages * 2)){ // Middle hide some front and some back
						$paginate .= "<a href = '$targetPage?page=1'>1</a>";
						$paginate .= "<a href = '$targetPage?page=2'>2</a>";
						$paginate .= "...";
						for($counter = $page - $stages; $counter <= $page + $stages; $counter++){
							if($counter == $page){
								$paginate.= "<span class = 'current'>$counter</span>";
							}else{
								$paginate.= "<a href = '$targetPage?page=$counter'>$counter</a>";}                    
						}
						$paginate .= "...";
						$paginate .= "<a href = '$targetPage?page=$LastPagem1'>$LastPagem1</a>";
						$paginate .= "<a href = '$targetPage?page=$lastpage'>$lastpage</a>";       
					}else{// End only hide early pages
						$paginate .= "<a href = '$targetPage?page=1'>1</a>";
						$paginate .= "<a href = '$targetPage?page=2'>2</a>";
						$paginate .= "...";
						for ($counter = $lastpage - (2 + ($stages * 2)); $counter <= $lastpage; $counter++){
							if($counter == $page){
								$paginate .= "<span class='current'>$counter</span>";
							}else{
								$paginate .= "<a href='$targetPage?page=$counter'>$counter</a>";}                    
						}
					}
				}
							
				//Next
				if($page < $counter - 1){ 
					$paginate .= "<a href = '$targetPage?page=$next'>بعدی</a>";
				}else{
					$paginate .= "<span class = 'disabled'>بعدی</span>";
				}
					
				$paginate.= "</div>";       
			}

			echo "<div class='row'>";
			// pagination
			$end   = ($page < $counter - 1) ? $end = $start + $limit : $end = $totalRecords;
			$start = ($start == 0) ? $start = ++$start : $start = $start;
			
			echo '<div>
					<div class="col-md-6 col-sm-12" style="padding-top: 5px;color: #aaa; float: left">نمايش <span class="adad">' .  $start . '</span> از <span class="adad">' . $end . '</span></div>
					<div class="col-md-6 col-sm-12" id="retrieved_info" style="float: right">' . $paginate . '</div>
				</div>';
			
		}
		public function paginateBank($table, $targetPage, $limit, $page,$totalRecords){
			 
			// Initial page num setup
			if($page == 0){
				$page = 1;
			}
			
			$stages = 3;
			$prev   = $page - 1;  
			$next   = $page + 1;                          
			$lastpage   = ceil($totalRecords/$limit);      
			$LastPagem1 = $lastpage - 1;
			$paginate   = '';

			if($lastpage > 1){
				$paginate .= "<div class = 'paginate'>";
				
				//Previous
				if($page > 1){
					$paginate .= "<a href = '$targetPage?page=$prev'>Previous</a>";
				}else{
					$paginate .= "<span class = 'disabled'>Previous</span>";
				}
			   
				//Pages  
				if($lastpage < 7 + ($stages * 2)){     // Not enough pages to breaking it up  
					for($counter = 1; $counter <= $lastpage; $counter++){
						if ($counter == $page){
							$paginate .= "<span class = 'current'>$counter</span>";
						}else{
							$paginate .= "<a href = '$targetPage?page=$counter'>$counter</a>";
						}                    
					}
				}elseif($lastpage > 5 + ($stages * 2)){ // Enough pages to hide a few?
					// Beginning only hide later pages
					if($page < 1 + ($stages * 2)){
						for ($counter = 1; $counter < 4 + ($stages * 2); $counter++){
							if($counter == $page){
								$paginate .= "<span class = 'current'>$counter</span>";
							}else{
								$paginate .= "<a href = '$targetPage?page=$counter'>$counter</a>";}                    
						}

						$paginate .= "...";
						$paginate .= "<a href = '$targetPage?page=$LastPagem1'>$LastPagem1</a>";
						$paginate .= "<a href = '$targetPage?page=$lastpage'>$lastpage</a>";       
					}elseif($lastpage - ($stages * 2) > $page && $page > ($stages * 2)){ // Middle hide some front and some back
						$paginate .= "<a href = '$targetPage?page=1'>1</a>";
						$paginate .= "<a href = '$targetPage?page=2'>2</a>";
						$paginate .= "...";
						for($counter = $page - $stages; $counter <= $page + $stages; $counter++){
							if($counter == $page){
								$paginate.= "<span class = 'current'>$counter</span>";
							}else{
								$paginate.= "<a href = '$targetPage?page=$counter'>$counter</a>";}                    
						}
						$paginate .= "...";
						$paginate .= "<a href = '$targetPage?page=$LastPagem1'>$LastPagem1</a>";
						$paginate .= "<a href = '$targetPage?page=$lastpage'>$lastpage</a>";       
					}else{// End only hide early pages
						$paginate .= "<a href = '$targetPage?page=1'>1</a>";
						$paginate .= "<a href = '$targetPage?page=2'>2</a>";
						$paginate .= "...";
						for ($counter = $lastpage - (2 + ($stages * 2)); $counter <= $lastpage; $counter++){
							if($counter == $page){
								$paginate .= "<span class='current'>$counter</span>";
							}else{
								$paginate .= "<a href='$targetPage?page=$counter'>$counter</a>";}                    
						}
					}
				}
							
				//Next
				if($page < $counter - 1){ 
					$paginate .= "<a href = '$targetPage?page=$next'>بعدی</a>";
				}else{
					$paginate .= "<span class = 'disabled'>بعدی</span>";
				}
					
				$paginate.= "</div>";       
			}

			echo "<div class='row'>";
			// pagination
			$end   = ($page < $counter - 1) ? $end = $start + $limit : $end = $totalRecords;
			$start = ($start == 0) ? $start = ++$start : $start = $start;
			
			echo '<div>
					<div class="col-md-6 col-sm-12" style="padding-top: 5px;color: #aaa; float: left">نمايش <span class="adad">' .  $start . '</span> از <span class="adad">' . $end . '</span></div>
					<div class="col-md-6 col-sm-12" id="retrieved_info" style="float: right">' . $paginate . '</div>
				</div>';
			
		}
		
		public function changeStockAmount($itemId,$stockId,$amount,$type,$userId){
			//If type inserted equal to one it means we add amount to stock balance else we subtracted.
			$increaseStockAmount = TRUE;
			$decreaseStockAmount = TRUE;
			if($type ==1){
				
				$queryStockBalance  = $this->conn->query("SELECT * FROM  tbl_stock_balance WHERE items_id = $itemId AND stocks_id = $stockId");
				if($queryStockBalance->num_rows > 0){
					
					$rowStockBalance  = $queryStockBalance->fetch_array();
					$existedAmount    = $rowStockBalance['amount'];
					$updatableAmount  = $existedAmount + $amount;
					
					$updateSotckBalance = "UPDATE  tbl_stock_balance SET amount = '$updatableAmount' WHERE items_id = $itemId AND stocks_id = $stockId";
					$increaseStockAmount = $this->conn->query($updateSotckBalance);
				
				}else{
					
					$insertStockBalance =  "INSERT INTO tbl_stock_balance(amount,stocks_id,items_id,users_id) VALUES ('$amount','$stockId','$itemId','$userId')";
					$increaseStockAmount= $this->conn->query($insertStockBalance);
				
				}
				
			}else{
				
				$queryStockBalance  = $this->conn->query("SELECT * FROM  tbl_stock_balance WHERE items_id = $itemId AND stocks_id = $stockId");				
				
				if($queryStockBalance->num_rows > 0){
					
					$rowStockBalance  = $queryStockBalance->fetch_array();
					$existedAmount    = $rowStockBalance['amount'];
					$updatableAmount  = $existedAmount - $amount;
					
					$updateSotckBalance = "UPDATE  tbl_stock_balance SET amount = '$updatableAmount' WHERE items_id = $itemId AND stocks_id = $stockId";
					$decreaseStockAmount= $this->conn->query($updateSotckBalance);
				
				}else{
					
					$insertStockBalance = "INSERT INTO tbl_stock_balance(amount,stocks_id,items_id,users_id) VALUES('-$amount','$stockId','$itemId','$userId')";
					$decreaseStockAmount= $this->conn->query($insertStockBalance);
				
				}
			}
			
			if($increaseStockAmount && $decreaseStockAmount)
				return TRUE;
			else
				return FALSE;
		}
		
		  
		
	}
	$conn      = new Database(HOST, USERNAME, PASSWORD, DATABASE);
	/*
	All Rights Reserved By 'ACI Soft' 
	*/
?>