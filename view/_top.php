<div class="se-pre-con"></div>
	<div class="col-sm-6 col-xs-7">
		<?php    

			$selectUserIdentity = $conn->query("SELECT * FROM tbl_users where id = $userId and deleted = 0");
			$userIdentity = $selectUserIdentity->fetch_array();
			$name = $userIdentity['name'];
			$family = $userIdentity['family'];	
			$photo = $userIdentity['photo'];	
			
		?>
		<!-- User info -->
        <ul class="user-info pull-left">          
			<li class="profile-info dropdown"><a data-toggle="dropdown" class="dropdown-toggle" href="#" aria-expanded="false"> <img width="44" class="img-circle avatar" alt="" src="<?php  echo $photo  ?>"><?php echo $name." ".$family;    ?><span class="caret"></span></a>
			<!-- User action menu -->
				<ul class="dropdown-menu">
				  <li><a href="profileUserACI.php"><i class="icon-user"></i>My profile</a></li>
				  <li class="divider"></li>
				  <li><a href="profileUserACI.php?id=1"><i class="icon-cog"></i>Account settings</a></li>
				  <li><a href="logout.php"><i class="icon-logout"></i>Logout</a></li>
				</ul>
			<!-- /user action menu -->
			</li>
		</ul>
		<!-- /user info -->
    </div>
	<div class="col-sm-6 col-xs-5">
		<div class="pull-right">
			<!-- User alerts -->
			<ul class="user-info pull-left">
			 <!-- Notifications-->
			  <li class="notifications dropdown">
				<a title="Requested Notifications" data-close-others="true" data-hover="dropdown" data-toggle="dropdown" class="dropdown-toggle" href="#"><i class="icon-plus-squared"></i><span class="badge badge-info"><span class="stockOutdated"></span></span></a>
				<ul class="dropdown-menu pull-right">
					<li class="first">
						<div>  You have <strong ><span class="stockOutdated"></span> </strong> New Notifications.</div>
					</li>
					<li>
						<ul class="dropdown-list approvalBoss">
						<?php
						$requestRawSQLQuery    = $conn->query("SELECT * FROM tbl_stock_balance");

						While($row = $requestRawSQLQuery->fetch_array()){
 								$rowItems = $conn->query("SELECT * from tbl_items where deleted = 0 AND id = ".$row['items_id']);
								$fetchSumAmount = $rowItems->fetch_array();
								
								$minimum  = $fetchSumAmount['minimum']; 
 								$itemName = $fetchSumAmount['name'];
								
								if($row['amount']  < $minimum){ 
								?>
									<li class="unread notification-danger"><a href="viewAllStockBalamceOutdatedAT.php"><i class="icon-home pull-right"></i><span class="block-line strong"><b><?php echo $itemName; ?> </b> <span class="text-danger"> went to red zone.</span></span></a></li>
								<?php
								}
								}
	 
								?>
							<li class="external-last"> <a href="viewAllStockBalamceOutdatedAT.php" target="_" class="danger">View All</a> </li>

						</ul>
					</li>

				</ul>
			  </li>
		</div>
	 
		<div class="pull-right">
			<!-- User alerts -->
			<ul class="user-info pull-left">
			 <!-- Notifications for rquested Payment of super approval or for Boss-->
			  <li class="notifications dropdown">
				<a title="Requested Notifications" data-close-others="true" data-hover="dropdown" data-toggle="dropdown" class="dropdown-toggle" href="#"><i class="icon-plus-squared"></i><span class="badge badge-danger"><span class="dealerOutdated"></span></span></a>
				<ul class="dropdown-menu pull-right">
					<li class="first">
					</li>
					<li>
						<ul class="dropdown-list approvalBoss">
						<?php
						$today = date("Y-m-d");
 						$dealerTransaction  = $conn->query("SELECT * FROM tbl_dealer_transaction where '$today' >= tbl_dealer_transaction.due_date  AND deleted = 0 AND status = 0 ORDER BY id desc");
						While($fetchData = $dealerTransaction->fetch_array()){
							$dealerTransactionId  = $fetchData['id'];
							$dealerId  = $fetchData['dealers_id'];
							$rowDealers = $conn->selectRecord ("tbl_dealers","id  = ". $fetchData['dealers_id']);

							if($rowDealers){
						 
						?>
							<li class="unread notification-danger"><a href="alldealerOutdateAT.php?id=<?php  echo $dealerTransactionId;  ?>"><i class="icon-home pull-right"></i><span class="block-line strong"><b>Oudated Dealer Loan of --> <?php echo $rowDealers['name']." ". $rowDealers['family']; ?> </b></span></a></li>
						<?php
							}
						}
						?>
							<li class="external-last"> <a href="alldealerOutdateAT.php" target="_" class="danger">View All Outdated Notificaitons</a> </li>

						</ul>
					</li>

				</ul>
			  </li>
		</div>
	</div> 