<?php
	require_once("../config/Database.php");
	require_once("../config/necessaryFunctions.php");
	$conn->query("SET NAMES 'utf8'");
	$conn->query('SET CHARACTER SET utf8');
	$userId = decryptIt($_SESSION['userId']);

	//List All Item Categories
	function listItemCategories($returnPage,$validationEditCondition,$validationRemoveCondition){
		global $conn;
		global $userId;
		
		$table = "tbl_item_categories";
		$limit = 10;
		$page  = (isset($_GET['page']) ? $page = $conn->safeInput($_GET['page']) : $page = 0);
		$start = ($page ? $start = (($page - 1) * $limit) : $start = 0);
		 
		
		$itemCategoriesRawSQLQuery    = "SELECT * FROM $table WHERE  deleted = 0  ORDER BY id DESC LIMIT $start, $limit";
		$itemCategoriesSQLQuery            = $conn->query($itemCategoriesRawSQLQuery);
		
		
		if($itemCategoriesSQLQuery->num_rows > 0){
		
		?>
		<div class="table-responsive">
			<table class="table table-bordered table-hover">
				<thead>
					<tr>
						<th class="text-center table-title" colspan="4">
							کتگوری اجناس
						</th>
					</tr>
					<tr class="table-header"> 
						<th class="small text-center">شماره</th>
						<th class='text-center'>نام</th>
						<?php if($validationEditCondition == 1 || $validationRemoveCondition == 1){   ?> 
  						<th class="small text-center" colspan="2">عملیات</th>
						<?php   } ?>
					</tr> 
				</thead> 
				<tbody> 
				
				<?php
				
					while($row = $itemCategoriesSQLQuery->fetch_array()){
						++$counter;
					?>
					
					<tr id='row-<?php echo $row['id']; ?>'> 
						<td class="small text-center "><?php echo $counter; ?></td>
						<td class='text-center'><?php echo $row['name']; ?></td>
						<?php if($validationEditCondition == 1){   ?>
						<td class="small text-center"><button title="Edit Records" class="edit_data fa fa-edit btn btn-blue btn-outline" id="<?php   echo $row['id']."+".$table;  ?>"></button></td>
						<?php }if($validationRemoveCondition == 1){ ?>
						<td class="small text-center"><a title="Remove" onclick="verifyRemoveFunction('<?php echo $table;    ?>',<?php echo $row['id']; ?>)"  ><i class="fa fa-times btn btn-red btn-outline"></i></a></td>
						<?php } ?>
					</tr>
					
					<?php
						
					}
				
				?>
				
				</tbody> 
			</table>
		</div>
			
		<?php
			$conn->paginate($table,$returnPage, $limit, $page);
		}
	}//List All Item Categories
	function schoolsTable($returnPage,$validationEditCondition,$validationRemoveCondition){
		global $conn;
		global $userId;
		
		$table = "tbl_schools";
		$limit = 10;
		$page  = (isset($_GET['page']) ? $page = $conn->safeInput($_GET['page']) : $page = 0);
		$start = ($page ? $start = (($page - 1) * $limit) : $start = 0);
		 
		
		$tableSql    = "SELECT * FROM $table WHERE  deleted = 0  ORDER BY id DESC LIMIT $start, $limit";
		$tableQuery            = $conn->query($tableSql);
		
		
		if($tableQuery->num_rows > 0){
		
		?>
		<div class="table-responsive">
			<table class="table table-bordered table-hover">
				<thead>
					<tr>
						<th class="text-center table-title" colspan="11">
							لیست مکاتب
						</th>
					</tr>
					<tr class="table-header"> 
						<th class="small text-center">شماره</th>
						<th class='text-center'>تاریخ</th>
						<th class='text-center'>نام</th>
						<th class='text-center'>مدیر</th>
						<th class='text-center'>شماره تماس</th>
						<th class='text-center'>ولسوالی/ ناحیه</th>
						<th class='text-center'>نوع مکتب</th>
 						<th class='text-center'>آدرس</th>
						<?php if($validationEditCondition == 1 || $validationRemoveCondition == 1){   ?> 
  						<th class="small text-center" colspan="2">Operation</th>
						<?php   } ?>
					</tr> 
				</thead> 
				<tbody> 
				
				<?php
				
					while($row = $tableQuery->fetch_array()){
						++$counter;
 						$rowDistricts    = $conn->selectRecord("tbl_districts", "id = " . $row['districts_id']);
					?>
					
					<tr id='row-<?php echo $row['id']; ?>'> 
						<td class="small text-center "><?php echo $counter; ?></td>
						<td class='text-center'><?php echo $row['date']; ?></td>
						<td class='text-center'><?php echo $row['name']; ?></td>
						<td class='text-center'><?php echo $row['manager_name']; ?></td>
						<td class='text-center'><?php echo $row['contact']; ?></td>
						<td class='text-center'><?php echo $rowDistricts['name']; ?></td>
						<td class='text-center'><?php if($row['school_type']==1){ echo "ذکور";}elseif($row['school_type']==2){echo "اناث";}else{ echo "ذکور و اناث";} ?></td>
 						<td class='text-center'><?php echo $row['address']; ?></td>
						<?php if($validationEditCondition == 1){   ?>
						<td class="small text-center"><button title="Edit Records" class="edit_data fa fa-edit btn btn-blue btn-outline" id="<?php   echo $row['id']."+".$table;  ?>"></button></td>
						<?php }if($validationRemoveCondition == 1){ ?>
						<td class="small text-center"><a title="Remove" onclick="verifyRemoveFunction('<?php echo $table;    ?>',<?php echo $row['id']; ?>)"  ><i class="fa fa-times btn btn-red btn-outline"></i></a></td>
						<?php } ?>
					</tr>
					
					<?php
						
					}
				
				?>
				
				</tbody> 
			</table>
		</div>
			
		<?php
			$conn->paginate($table,$returnPage, $limit, $page);
		}
	}
	
	function schoolManagersTable($returnPage,$validationEditCondition,$validationRemoveCondition){
		global $conn;
		global $userId;
		
		$table = "tbl_school_managers";
		$limit = 10;
		$page  = (isset($_GET['page']) ? $page = $conn->safeInput($_GET['page']) : $page = 0);
		$start = ($page ? $start = (($page - 1) * $limit) : $start = 0);
		 
		
		$tableSql    = "SELECT * FROM $table WHERE  deleted = 0  ORDER BY id DESC LIMIT $start, $limit";
		$tableQuery            = $conn->query($tableSql);
		
		
		if($tableQuery->num_rows > 0){
		
		?>
		<div class="table-responsive">
			<table class="table table-bordered table-hover">
				<thead>
					<tr>
						<th class="text-center table-title" colspan="10">
							لیست مدیران مکاتب
						</th>
					</tr>
					<tr class="table-header"> 
						<th class="small text-center">شماره</th>
						<th class='text-center'>تاریخ</th>
						<th class='text-center'>نام</th>
						<th class='text-center'>شماره تماس</th>
  						<th class='text-center'>توضیحات</th>
 						<?php if($validationEditCondition == 1 || $validationRemoveCondition == 1){   ?> 
  						<th class="small text-center" colspan="2">Operation</th>
						<?php   } ?>
					</tr> 
				</thead> 
				<tbody> 
				
				<?php
				
					while($row = $tableQuery->fetch_array()){
						++$counter;
						$rowSchools = $conn->selectRecord("tbl_schools", "id = " . $row['schools_id']);
 					?>
					
					<tr id='row-<?php echo $row['id']; ?>'> 
						<td class="small text-center "><?php echo $counter; ?></td>
						<td class='text-center'><?php echo $row['date']; ?></td>
						<td class='text-center'><?php echo $row['name']; ?></td>
						<td class='text-center'><?php echo $row['contact']; ?></td>
  						<td class='text-center'><?php echo $row['description']; ?></td>
						<?php if($validationEditCondition == 1){   ?>
						<td class="small text-center"><button title="Edit Records" class="edit_data fa fa-edit btn btn-blue btn-outline" id="<?php   echo $row['id']."+".$table;  ?>"></button></td>
						<?php }if($validationRemoveCondition == 1){ ?>
						<td class="small text-center"><a title="Remove" onclick="verifyRemoveFunction('<?php echo $table;    ?>',<?php echo $row['id']; ?>)"  ><i class="fa fa-times btn btn-red btn-outline"></i></a></td>
						<?php } ?>
					</tr>
					
					<?php
						
					}
				
				?>
				
				</tbody> 
			</table>
		</div>
			
		<?php
			$conn->paginate($table,$returnPage, $limit, $page);
		}
	}
	function districtsTable($returnPage,$validationEditCondition,$validationRemoveCondition){
		global $conn;
		global $userId;
		
		$table = "tbl_districts";
		$limit = 10;
		$page  = (isset($_GET['page']) ? $page = $conn->safeInput($_GET['page']) : $page = 0);
		$start = ($page ? $start = (($page - 1) * $limit) : $start = 0);
		 
		
		$tableSql    = "SELECT * FROM $table WHERE  deleted = 0  ORDER BY id DESC LIMIT $start, $limit";
		$tableQuery            = $conn->query($tableSql);
		
		
		if($tableQuery->num_rows > 0){
		
		?>
		<div class="table-responsive">
			<table class="table table-bordered table-hover">
				<thead>
					<tr>
						<th class="text-center table-title" colspan="10">
							لیست ولسوالی /ناحیه ها
						</th>
					</tr>
					<tr class="table-header"> 
						<th class="small text-center">شماره</th>
 						<th class='text-center'>نام</th>
 						<?php if($validationEditCondition == 1 || $validationRemoveCondition == 1){   ?> 
  						<th class="small text-center" colspan="2">Operation</th>
						<?php   } ?>
					</tr> 
				</thead> 
				<tbody> 
				
				<?php
				
					while($row = $tableQuery->fetch_array()){
						++$counter;
  					?>
					
					<tr id='row-<?php echo $row['id']; ?>'> 
						<td class="small text-center "><?php echo $counter; ?></td>
 						<td class='text-center'><?php echo $row['name']; ?></td>
 						<?php if($validationEditCondition == 1){   ?>
						<td class="small text-center"><button title="Edit Records" class="edit_data fa fa-edit btn btn-blue btn-outline" id="<?php   echo $row['id']."+".$table;  ?>"></button></td>
						<?php }if($validationRemoveCondition == 1){ ?>
						<td class="small text-center"><a title="Remove" onclick="verifyRemoveFunction('<?php echo $table;    ?>',<?php echo $row['id']; ?>)"  ><i class="fa fa-times btn btn-red btn-outline"></i></a></td>
						<?php } ?>
					</tr>
					
					<?php
						
					}
				
				?>
				
				</tbody> 
			</table>
		</div>
			
		<?php
			$conn->paginate($table,$returnPage, $limit, $page);
		}
	}
	
	function requestOrganizationsMaterials($returnPage,$validationEditCondition,$validationRemoveCondition){
		global $conn;
		global $userId;
		
		$table = "tbl_org_req_materials_title";
		$limit = 10;
		$page  = (isset($_GET['page']) ? $page = $conn->safeInput($_GET['page']) : $page = 0);
		$start = ($page ? $start = (($page - 1) * $limit) : $start = 0);
		 
		
		$rowQuery    = "SELECT * FROM $table WHERE  deleted = 0  ORDER BY id DESC LIMIT $start, $limit";
		$sqlQuery            = $conn->query($rowQuery);
		

		if($sqlQuery->num_rows > 0){
		
		?>
		<div class="table-responsive">
			<table class="table table-bordered table-hover">
				<thead>
					<tr>
						<th class="text-center table-title" colspan="12">
						لیست درخواست تجهیزات به مکاتب
						</th>
					</tr>
					<tr class="table-header"> 
						<th class='text-center'>شماره</th>
						<th class='text-center'>تاریخ</th>
						<th class='text-center'>مکتب</th>
						<th class='text-center'>فایل</th>
 						<th class='text-center'>شماره درخواست</th>
						<?php  if($validationEditCondition == 1){ ?>
						<th class='text-center'>جزئیات درخواست</th>
						<?php   } ?>
  						<th class="small text-center" colspan="2">عملیات</th>
					</tr> 
				</thead> 
				<tbody> 
				
				<?php
			
				while($row = $sqlQuery->fetch_array()){
					++$counter;
					
				$rowSchools = $conn->selectRecord ("tbl_schools","id  = ". $row['schools_id']);
				$rowDistricts = $conn->selectRecord ("tbl_districts","id  = ". $row['districts_id']);
 				?>
				
				<tr id='row-<?php echo $row['id']; ?>'> 
					<td class="small text-center "><?php echo $counter; ?></td>
					<td class='text-center '><?php echo $row['date']; ?></td>
					<td class='text-center'><?php  echo $rowSchools['name']; ?></td>
					<td class='text-center'><a href='download.php?name=<?php echo $row['document']; ?>' title="download document" class='glyphicon glyphicon-download'></a></td>
 					<td class='text-center'><?php  echo $row['request_number']; ?></td>
					<?php  if($validationEditCondition == 1){   ?>
					<td class="text-center"><button title="Edit Records" class="edit_data fa fa-edit btn btn-blue btn-outline" id="<?php   echo $row['id']."+".$table;  ?>"></button></td>
					<?php   } ?>
					<td class="text-center"><a title="Edit Details" href="editRequestSchoolsEquipmentAT.php?id=<?php echo encryptIt($row['id']); ?>"><i class="fa fa-edit btn btn-blue btn-outline"></i></a></td>
					<?php if($validationRemoveCondition == 1){ ?>
					<?php  
					
							$selectDetailsRawMaterials = $conn->query("SELECT * FROM 	 where 	title_bills_id = ".$row['id']." AND deleted = 0");
  							if($selectDetailsRawMaterials->num_rows > 0){
						?>
							
							<td class="small text-center"><a title="Remove"><i class="fa fa-times btn btn-outline-info"></i></a></td>
						<?php
							}else{
						?>
							<td class="small text-center"><a title="Remove" onclick="verifyRemoveFunction('<?php echo $table;    ?>',<?php echo $row['id']; ?>)"  ><i class="fa fa-times btn btn-red btn-outline"></i></a></td>
						<?php
							}
							}
						?>
				</tr>
				
					<?php
					 
					}
				
				?>
				
				</tbody> 
			</table>
		</div>
			
		<?php
			
			$conn->paginate($table,$returnPage, $limit, $page, $userId);
		}
	
	}
	//List All Expense Categories
	 
	function schoolOrgExpensesCategoryTable($validationEditCondition,$validationRemoveCondition){
		global $conn;
		global $userId;
		
		$table = "tbl_org_expense_categories";
		$limit = 30;
		$page  = (isset($_GET['page']) ? $page = $conn->safeInput($_GET['page']) : $page = 0);
		$start = ($page ? $start = (($page - 1) * $limit) : $start = 0);
		 
		
		$expenseCategoriesRawSQLQuery    = "SELECT * FROM $table WHERE deleted = 0 ORDER BY id DESC LIMIT $start, $limit";
		$expenseCategoriesSQLQuery       = $conn->query($expenseCategoriesRawSQLQuery);
		
		
		if($expenseCategoriesSQLQuery->num_rows > 0){
		
		?>
			
			
		<div class="table-responsive">
			<table class="table table-bordered table-hover">
				<thead>
					<tr>
						<th class="text-center table-title" colspan="4">
							کتگوری مصرف مکاتب
						</th>
					</tr>
					<tr class="table-header"> 
						<th class="small text-center">شماره</th>
						<th class='text-center'>نام</th>
						<?php if($validationEditCondition == 1 || $validationRemoveCondition == 1){   ?> 
						<th class="small text-center" colspan="2">عملیات</th>
						<?php   } ?>
					</tr> 
				</thead> 
				<tbody> 
				
				<?php
				
					while($row = $expenseCategoriesSQLQuery->fetch_array()){
						++$counter;
					?>
					
					<tr id='row-<?php echo $row['id']; ?>'> 
						<td class="small text-center "><?php echo $counter; ?></td>
						<td class='text-center'><?php echo $row['name']; ?></td>
						<?php if($validationEditCondition == 1){   ?>
						<td class="small text-center"><button title="Edit Records" class="edit_data fa fa-edit btn btn-blue btn-outline" id="<?php   echo $row['id']."+".$table;  ?>"></button></td>
						<?php }if($validationRemoveCondition == 1){ ?>
						<td class="small text-center"><a title="Remove" onclick="verifyRemoveFunction('<?php echo $table;    ?>',<?php echo $row['id']; ?>)"  ><i class="fa fa-times btn btn-red btn-outline"></i></a></td>
						<?php   } ?>
					</tr>
					
					<?php
						
					}
				
				?>
				
				</tbody> 
			</table>
		</div>
			
		<?php
			
			$conn->paginate($table, "addExpenseCategoryETQ.php", $limit, $page);
		}
		
	} 
	//List All Item Units
	function listItemUnits($returnPage,$validationEditCondition,$validationRemoveCondition){
		global $conn;
		global $userId;
		
		$table = "tbl_item_units";
		$limit = 10;
		$page  = (isset($_GET['page']) ? $page = $conn->safeInput($_GET['page']) : $page = 0);
		$start = ($page ? $start = (($page - 1) * $limit) : $start = 0);
		 
		
		$itemUnitsRawSQLQuery    = "SELECT * FROM $table WHERE  deleted = 0 ORDER BY id DESC LIMIT $start, $limit";
		$itemUnitsSQLQuery            = $conn->query($itemUnitsRawSQLQuery);
		
		
		if($itemUnitsSQLQuery->num_rows > 0){
		
		?>
			
			
		<div class="table-responsive">
			<table class="table table-bordered table-hover">
				<thead>
					<tr>
						<th class="text-center table-title" colspan="4">
							لیست واحد کالا
						</th>
					</tr>
					<tr class="table-header"> 
						<th class="small text-center">شماره</th>
						<th class='text-center'>نام</th>
					<?php if($validationEditCondition == 1 || $validationRemoveCondition == 1){   ?> 
  						<th class="small text-center" colspan="2">عملیات</th>
						<?php   } ?>
					</tr> 
				</thead> 
				<tbody> 
				
				<?php
				
					while($row = $itemUnitsSQLQuery->fetch_array()){
						++$counter;
					?>
					
					<tr id='row-<?php echo $row['id']; ?>'> 
						<td class="small text-center"><?php echo $counter; ?></td>
						<td class='text-center'><?php echo $row['name']; ?></td>
						<?php if($validationEditCondition == 1){   ?>
						<td class="small text-center"><button title="ویرایش ریکورد" class="edit_data fa fa-edit btn btn-blue btn-outline" id="<?php   echo $row['id']."+".$table;  ?>"></button></td>
						<?php }if($validationRemoveCondition == 1){ ?>
						<td class="small text-center"><a title="حذف" onclick="verifyRemoveFunction('<?php echo $table;    ?>',<?php echo $row['id']; ?>)"  ><i class="fa fa-times btn btn-red btn-outline"></i></a></td>
						<?php } ?>
					</tr>
					
					<?php
						
					}
				
				?>
				
				</tbody> 
			</table>
		</div>
			
		<?php
			
			$conn->paginate($table,$returnPage, $limit, $page);
		}
		
	}
	//List All Items
	function listItems($returnPage,$validationEditCondition,$validationRemoveCondition){
		global $conn;
		global $userId;
		
		$table = "tbl_items";
		$limit = 10;
		$page  = (isset($_GET['page']) ? $page = $conn->safeInput($_GET['page']) : $page = 0);
		$start = ($page ? $start = (($page - 1) * $limit) : $start = 0);
		 
		
		$itemsRawSQLQuery    = "SELECT * FROM $table WHERE deleted = 0 ORDER BY id DESC LIMIT $start, $limit";
		$itemsSQLQuery            = $conn->query($itemsRawSQLQuery);
		
		
		if($itemsSQLQuery->num_rows > 0){
		
		?>
			
			
		<div class="table-responsive">
			<table class="table table-bordered table-hover">
				<thead>
					<tr>
						<th class="text-center table-title" colspan="12">
							لیست اجناس
						</th>
					</tr>
					<tr class="table-header"> 
						<th class="small text-center">شماره</th>
 						<th class='text-center'>تاریخ</th>
 						<th class='text-center'>نام</th>
						<th class='text-center'>واحد</th>
						<th class='text-center'>کتگوری</th>
						<th class='text-center'>حساب افتتاحیه</th>
						<th class='text-center'>گدام</th>
 						<th class='text-center'>توضیحات</th>
						<?php if($validationEditCondition == 1 || $validationRemoveCondition == 1){   ?> 
  						<th class="small text-center" colspan="2">عملیات</th>
						<?php   } ?>
					</tr> 
				</thead> 
				<tbody> 
				
				<?php
				
					while($row = $itemsSQLQuery->fetch_array()){
						++$counter;
						
						$unitName     = $conn->selectRecord("tbl_item_units","id = " . $row['item_units_id']);
						$categoryName = $conn->selectRecord("tbl_item_categories", "id = " . $row['item_categories_id']);
						$stockName    = $conn->selectRecord("tbl_stocks", "id = " . $row['stocks_id']);
						$itemType = $row['item_type'];
						
					?>
					
					<tr id='row-<?php echo $row['id']; ?>'> 
						<td class="small text-center "><?php echo $counter; ?></td>
 						<td class='text-center'><?php echo $row['date']; ?></td>
 						<td class='text-center'><?php echo $row['name']; ?></td>
						<td class='text-center'><?php echo $unitName['name']; ?></td>
						<td class='text-center'><?php echo $categoryName['name']; ?></td>
						<td class='text-center '><?php echo $row['opening_balance']; ?></td>
						<td class='text-center'><?php echo $stockName['name']; ?></td>
 						<td class='text-center'><?php echo $row['description']; ?></td>
						<?php if($validationEditCondition == 1){   ?>
						<td class="small text-center"><button title="Edit Records" class="edit_data fa fa-edit btn btn-blue btn-outline" id="<?php   echo $row['id']."+".$table;  ?>"></button></td>
						<?php }if($validationRemoveCondition == 1){ ?>
						<td class="small text-center"><a title="Remove" onclick="verifyRemoveFunction('<?php echo $table;    ?>',<?php echo $row['id']; ?>)"  ><i class="fa fa-times btn btn-red btn-outline"></i></a></td>
						<?php } ?>
					</tr>
					
					<?php
						
					}
				
				?>
				
				</tbody> 
			</table>
		</div>
			
		<?php
			
			$conn->paginate($table,$returnPage, $limit, $page);
		}
		
	}	//List All Items
	//List All School Expenses
	function allOrganizationExpensesTransaction($returnPage,$validationEditCondition,$validationRemoveCondition){
		global $conn;
		global $userId;
		
		$table = "tbl_organization_expense_transactions";
		$limit = 10;
		$page  = (isset($_GET['page']) ? $page = $conn->safeInput($_GET['page']) : $page = 0);
		$start = ($page ? $start = (($page - 1) * $limit) : $start = 0);
		 
		
		$itemsRawSQLQuery    = "SELECT * FROM $table WHERE deleted = 0 ORDER BY id DESC LIMIT $start, $limit";
		$itemsSQLQuery            = $conn->query($itemsRawSQLQuery);
		
		
		if($itemsSQLQuery->num_rows > 0){
		
		?>
		<div class="table-responsive">
			<table class="table table-bordered table-hover">
				<thead>
					<tr>
						<th class="text-center table-title" colspan="12">
							لیست مصارف مکاتب
						</th>
					</tr>
					<tr class="table-header"> 
						<th class="small text-center">شماره</th>
 						<th class='text-center'>تاریخ</th>
 						<th class='text-center'>نام مکتب</th>
						<th class='text-center'>کتگوری مصرف</th>
						<th class='text-center'>مقدار</th>
 						<th class='text-center'>بانک</th>
  						<th class='text-center'>فایل</th>
 						<th class='text-center'>توضیحات</th>
						<?php if($validationEditCondition == 1 || $validationRemoveCondition == 1){   ?> 
  						<th class="small text-center" colspan="2">عملیات</th>
						<?php   } ?>
					</tr> 
				</thead> 
				<tbody> 
				
				<?php
				
					while($row = $itemsSQLQuery->fetch_array()){
						++$counter;
						
						$rowExpenseCategory     = $conn->selectRecord("tbl_org_expense_categories","id = " . $row['expense_categories_id']);
						$rowSchools     = $conn->selectRecord("tbl_schools","id = " . $row['schools_id']);
 						$rowBank    = $conn->selectRecord("tbl_banks", "id = " . $row['banks_id']);
 						
					?>
					
					<tr id='row-<?php echo $row['id']; ?>'> 
						<td class="small text-center "><?php echo $counter; ?></td>
 						<td class='text-center'><?php echo $row['date']; ?></td>
 						<td class='text-center'><?php echo $rowSchools['name']; ?></td>
						<td class='text-center'><?php echo $rowExpenseCategory['name']; ?></td>
						<td class='text-center'><?php echo $row['amount']; ?></td>
 						<td class='text-center'><?php echo $rowBank['name']; ?></td>
 						<td class='text-center'><a href='download.php?name=<?php echo $row['document']; ?>' title="download document" class='glyphicon glyphicon-download'></a></td>
 						<td class='text-center'><?php echo $row['description']; ?></td>
						<?php if($validationEditCondition == 1){   ?>
						<td class="small text-center"><button title="Edit Records" class="edit_data fa fa-edit btn btn-blue btn-outline" id="<?php   echo $row['id']."+".$table;  ?>"></button></td>
						<?php }if($validationRemoveCondition == 1){ ?>
						<td class="small text-center"><a title="Remove" onclick="verifyRemoveFunction('<?php echo $table;    ?>',<?php echo $row['id']; ?>)"  ><i class="fa fa-times btn btn-red btn-outline"></i></a></td>
						<?php } ?>
					</tr>
					
					<?php
						
					}
				
				?>
				
				</tbody> 
			</table>
		</div>
			
		<?php
			
			$conn->paginate($table,$returnPage, $limit, $page);
		}
		
	}
	
	function allRecipientPaymentAT($returnPage,$validationEditCondition,$validationRemoveCondition){
		global $conn;
		global $userId;
		
		$table = "tbl_recipients_payment";
		$limit = 10;
		$page  = (isset($_GET['page']) ? $page = $conn->safeInput($_GET['page']) : $page = 0);
		$start = ($page ? $start = (($page - 1) * $limit) : $start = 0);
		 
		
		$itemsRawSQLQuery    = "SELECT * FROM $table WHERE deleted = 0 ORDER BY id DESC LIMIT $start, $limit";
		$itemsSQLQuery            = $conn->query($itemsRawSQLQuery);
		
		
		if($itemsSQLQuery->num_rows > 0){
		
		?>
		<div class="table-responsive">
			<table class="table table-bordered table-hover">
				<thead>
					<tr>
						<th class="text-center table-title" colspan="12">
							لیست پرداخت کمک ها 
						</th>
					</tr>
					<tr class="table-header"> 
						<th class="small text-center">شماره</th>
 						<th class='text-center'>تاریخ</th>
 						<th class='text-center'>نام کمک گیرنده</th>
 						<th class='text-center'>مقدار کمک</th>
						<th class='text-center'>بانک</th>
						<th class='text-center'>فایل</th>
 						<th class='text-center'>توضیحات</th>
						<?php if($validationEditCondition == 1 || $validationRemoveCondition == 1){   ?> 
  						<th class="small text-center" colspan="2">عملیات</th>
						<?php   } ?>
					</tr> 
				</thead> 
				<tbody> 
				
				<?php
				
					while($row = $itemsSQLQuery->fetch_array()){
						++$counter;
						
 						$rowRecipients     = $conn->selectRecord("tbl_recipients","id = " . $row['recipients_id']);
 						$rowBank    = $conn->selectRecord("tbl_banks", "id = " . $row['banks_id']);
 						
					?>
					
					<tr id='row-<?php echo $row['id']; ?>'> 
						<td class="small text-center "><?php echo $counter; ?></td>
 						<td class='text-center'><?php echo $row['date']; ?></td>
 						<td class='text-center'><?php echo $rowRecipients['name']; ?></td>
 						<td class='text-center'><?php echo $row['amount']; ?></td>
 						<td class='text-center'><?php echo $rowBank['name']; ?></td>
 						<td class='text-center'><a href='download.php?name=<?php echo $row['document']; ?>' title="download document" class='glyphicon glyphicon-download'></a></td>
 						<td class='text-center'><?php echo $row['description']; ?></td>
						<?php if($validationEditCondition == 1){   ?>
						<td class="small text-center"><button title="Edit Records" class="edit_data fa fa-edit btn btn-blue btn-outline" id="<?php   echo $row['id']."+".$table;  ?>"></button></td>
						<?php }if($validationRemoveCondition == 1){ ?>
						<td class="small text-center"><a title="Remove" onclick="verifyRemoveFunction('<?php echo $table;    ?>',<?php echo $row['id']; ?>)"  ><i class="fa fa-times btn btn-red btn-outline"></i></a></td>
						<?php } ?>
					</tr>
					
					<?php
						
					}
				
				?>
				
				</tbody> 
			</table>
		</div>
			
		<?php
			
			$conn->paginate($table,$returnPage, $limit, $page);
		}
		
	}
	//List of supported transaction of ceremonies
	 
	function allSupportedTransactionsCeremonies($returnPage,$validationEditCondition,$validationRemoveCondition){
		global $conn;
		global $userId;
		
		$table = "tbl_support_ceremonies_response_tran";
		$limit = 10;
		$page  = (isset($_GET['page']) ? $page = $conn->safeInput($_GET['page']) : $page = 0);
		$start = ($page ? $start = (($page - 1) * $limit) : $start = 0);
		 
		
		$itemsRawSQLQuery    = "SELECT * FROM $table WHERE deleted = 0 ORDER BY id DESC LIMIT $start, $limit";
		$itemsSQLQuery            = $conn->query($itemsRawSQLQuery);
		
		
		if($itemsSQLQuery->num_rows > 0){
		
		?>
		<div class="table-responsive">
			<table class="table table-bordered table-hover">
				<thead>
					<tr>
						<th class="text-center table-title" colspan="12">
							لیست تمویل محافل ملی
						</th>
					</tr>
					<tr class="table-header"> 
						<th class="small text-center">شماره</th>
 						<th class='text-center'>تاریخ</th>
 						<th class='text-center'>نام سازمان</th>
 						<th class='text-center'>نام محفل</th>
 						<th class='text-center'>مقدار</th>
 						<th class='text-center'>بانک</th>
  						<th class='text-center'>فایل</th>
 						<th class='text-center'>توضیحات</th>
						<?php if($validationEditCondition == 1 || $validationRemoveCondition == 1){   ?> 
  						<th class="small text-center" colspan="2">عملیات</th>
						<?php   } ?>
					</tr> 
				</thead> 
				<tbody> 
				
				<?php
				
					while($row = $itemsSQLQuery->fetch_array()){
						++$counter;
						
						$rowCeremonies     = $conn->selectRecord("tbl_support_ceremonies_requests","id = " . $row['ceremonies_id']);
						$rowSchools     = $conn->selectRecord("tbl_schools","id = " . $rowCeremonies['schools_id']);
 						$rowBank    = $conn->selectRecord("tbl_banks", "id = " . $row['banks_id']);
 						
					?>
					
					<tr id='row-<?php echo $row['id']; ?>'> 
						<td class="small text-center "><?php echo $counter; ?></td>
 						<td class='text-center'><?php echo $row['date']; ?></td>
 						<td class='text-center'><?php echo $rowSchools['name']; ?></td>
 						<td class='text-center'><?php echo $rowCeremonies['name']; ?></td>
 						<td class='text-center'><?php echo $row['amount']; ?></td>
 						<td class='text-center'><?php echo $rowBank['name']; ?></td>
 						<td class='text-center'><a href='download.php?name=<?php echo $row['document']; ?>' title="download document" class='glyphicon glyphicon-download'></a></td>
 						<td class='text-center'><?php echo $row['description']; ?></td>
						<?php if($validationEditCondition == 1){   ?>
						<td class="small text-center"><button title="Edit Records" class="edit_data fa fa-edit btn btn-blue btn-outline" id="<?php   echo $row['id']."+".$table;  ?>"></button></td>
						<?php }if($validationRemoveCondition == 1){ ?>
						<td class="small text-center"><a title="Remove" onclick="verifyRemoveFunction('<?php echo $table;    ?>',<?php echo $row['id']; ?>)"  ><i class="fa fa-times btn btn-red btn-outline"></i></a></td>
						<?php } ?>
					</tr>
					
					<?php
						
					}
				
				?>
				
				</tbody> 
			</table>
		</div>
			
		<?php
			
			$conn->paginate($table,$returnPage, $limit, $page);
		}
		
	}
	function expenseSchoolTransactionsInnerSchoolAccount($schoolId,$validationEditCondition,$validationRemoveCondition){
		global $conn;
		global $userId;
		
		$table = "tbl_school_expense_transactions";
		$limit = 400000;
		$page  = (isset($_GET['page']) ? $page = $conn->safeInput($_GET['page']) : $page = 0);
		$start = ($page ? $start = (($page - 1) * $limit) : $start = 0);
		 
		
		$itemsRawSQLQuery    = "SELECT * FROM $table WHERE deleted = 0 AND schools_id = $schoolId ORDER BY id DESC LIMIT $start, $limit";
		$itemsSQLQuery            = $conn->query($itemsRawSQLQuery);
		
		
		if($itemsSQLQuery->num_rows > 0){
		
		?>
			
			
		<div class="table-responsive">
			<table class="table table-bordered table-hover">
				<thead>
					<tr>
						<th class="text-center table-title" colspan="12">
							لیست مصارف مکاتب
						</th>
					</tr>
					<tr class="table-header"> 
						<th class="small text-center">شماره</th>
 						<th class='text-center'>تاریخ</th>
 						<th class='text-center'>نام مکتب /سازمان</th>
						<th class='text-center'>کتگوری مصرف</th>
						<th class='text-center'>مقدار</th>
						<th class='text-center'>واحد پولی</th>
						<th class='text-center'>بانک</th>
 						<th class='text-center'>نرخ</th>
 						<th class='text-center'>مقدار ( دالر )</th>
 						<th class='text-center'>توضیحات</th>
					 </tr> 
				</thead> 
				<tbody> 
				
				<?php
				
					while($row = $itemsSQLQuery->fetch_array()){
						++$counter;
						
						$rowExpenseCategory     = $conn->selectRecord("tbl_school_expense_categories","id = " . $row['expense_categories_id']);
						$rowCurrency = $conn->selectRecord("tbl_currencies", "id = " . $row['currencies_id']);
						$rowBank    = $conn->selectRecord("tbl_banks", "id = " . $row['banks_id']);
						$rowSchools    = $conn->selectRecord("tbl_schools", "id = " . $row['schools_id']);
 						$totalExpenseAmoutn += $row['amount'];
 						$totalExpenseAmountUSD += $row['home_amount'];
					?>
					
					<tr id='row-<?php echo $row['id']; ?>'> 
						<td class="small text-center "><?php echo $counter; ?></td>
 						<td class='text-center'><?php echo $row['date']; ?></td>
 						<td class='text-center'><?php echo $rowSchools['name']; ?></td>
						<td class='text-center'><?php echo $rowExpenseCategory['name']; ?></td>
						<td class='text-center'><?php echo number_format($row['amount'],2); ?></td>
						<td class='text-center '><?php echo $rowCurrency['code']; ?></td>
						<td class='text-center'><?php echo $rowBank['name']; ?></td>
						<td class='text-center'><?php echo $row['rate']; ?></td>
						<td class='text-center'><?php echo number_format($row['home_amount'],2); ?></td>
 						<td class='text-center'><?php echo $row['description']; ?></td>
					</tr>
					<?php
							
						}
					
					?>
					<tr>
						<td colspan="4" class="text-center"><b>مجموعه مصارف افغانی</b></td>
 						<td><?php echo number_format($totalExpenseAmoutn,2);   ?></td>
						<td colspan="3" class="text-center"><b>مجموعه مصارف دالر</b></td>
						<td><?php echo number_format($totalExpenseAmountUSD,2);   ?></td>
					
					</tr>
				</tbody> 
			</table>
		</div>
			
		<?php
			
			$conn->paginate($table,$returnPage, $limit, $page);
		}
		
	}	
	//List All Stocks
	function listStocks($returnPage,$validationEditCondition,$validationRemoveCondition){
		global $conn;
		global $userId;
		
		$table = "tbl_stocks";
		$limit = 10;
		$page  = (isset($_GET['page']) ? $page = $conn->safeInput($_GET['page']) : $page = 0);
		$start = ($page ? $start = (($page - 1) * $limit) : $start = 0);
		 
		
		$stocksRawSQLQuery    = "SELECT * FROM $table WHERE deleted = 0 ORDER BY id DESC LIMIT $start, $limit";
		$stocksSQLQuery            = $conn->query($stocksRawSQLQuery);
		
		
		if($stocksSQLQuery->num_rows > 0){
		
		?>
		<div class="table-responsive">
			<table class="table table-bordered table-hover">
				<thead>
					<tr>
						<th class="text-center table-title" colspan="5">
							لیست گدام ها
						</th>
					</tr>
					<tr class="table-header"> 
						<th class="small text-center">شماره</th>
						<th class='text-center'>نام</th>
						<th class='text-center'>توضیحات</th>
						<?php if($validationEditCondition == 1 || $validationRemoveCondition == 1){   ?> 
  						<th class="small text-center" colspan="2">عملیات</th>
						<?php   } ?>
					</tr> 
				</thead> 
				<tbody> 
				
				<?php
				
					while($row = $stocksSQLQuery->fetch_array()){
						++$counter;
					?>
					
					<tr id='row-<?php echo $row['id']; ?>'> 
						<td class="small text-center "><?php echo $counter; ?></td>
						<td class='text-center'><?php echo $row['name']; ?></td>
						<td class='text-center'><?php echo $row['description']; ?></td>
						<?php if($validationEditCondition == 1){   ?>
						<td class="small text-center"><button title="Edit Records" class="edit_data fa fa-edit btn btn-blue btn-outline" id="<?php   echo $row['id']."+".$table;  ?>"></button></td>
						<?php }if($validationRemoveCondition == 1){ ?>
						<td class="small text-center"><a title="Remove" onclick="verifyRemoveFunction('<?php echo $table;    ?>',<?php echo $row['id']; ?>)"  ><i class="fa fa-times btn btn-red btn-outline"></i></a></td>
						<?php } ?>
					</tr>
					
					<?php
						
					}
				
				?>
				
				</tbody> 
			</table>
		</div>
			
		<?php
			
			$conn->paginate($table,$returnPage, $limit, $page);
		}
		
	}
	//List All Transfer Item
	function listTransferItem($returnPage,$validationEditCondition,$validationRemoveCondition){
		global $conn;
		global $userId;
		
		$table = "tbl_stock_transaction";
		$limit = 10;
		$page  = (isset($_GET['page']) ? $page = $conn->safeInput($_GET['page']) : $page = 0);
		$start = ($page ? $start = (($page - 1) * $limit) : $start = 0);
		 
		
		$transferItemsRawSQLQuery    = "SELECT * FROM $table WHERE deleted = 0 ORDER BY id DESC LIMIT $start, $limit";
		$transferItemsSQLQuery            = $conn->query($transferItemsRawSQLQuery);
		
		
		if($transferItemsSQLQuery->num_rows > 0){
		
		?>
			
			
		<div class="table-responsive">
			<table class="table table-bordered table-hover">
				<thead>
					<tr>
						<th class="text-center table-title" colspan="11">
							انتقالات بین گدامها
						</th>
					</tr>
					<tr class="table-header"> 
						<th class="small text-center">شماره</th>
						<th class='text-center'>تاریخ</th>
						<th class='text-center'>گدام منبع</th>
						<th class='text-center'>نام کالا</th>
						<th class='text-center'>گدام مقصد</th>
						<th class='text-center'>مقدار قابل انتقال</th>
						<th class='text-center'>توضیحات</th>
						<?php if($validationEditCondition == 1 || $validationRemoveCondition == 1){   ?> 
  						<th class="small text-center" colspan="2">Operation</th>
						<?php   } ?>
					</tr> 
				</thead> 
				<tbody> 
				
				<?php
				
					while($row = $transferItemsSQLQuery->fetch_array()){
						++$counter;
						
						$sourceStock      = $conn->selectRecord("tbl_stocks","id = " . $row['source_stocks_id']);
						$destinationStock = $conn->selectRecord("tbl_stocks", "id = " . $row['destination_stocks_id']);
						$itemName         = $conn->selectRecord("tbl_items", "id = " . $row['items_id']);
					?>
					<tr id='row-<?php echo $row['id']; ?>'> 
						<td class="small text-center"><?php echo $counter; ?></td>
						<td class='text-center'><?php echo $row['date']; ?></td>
						<td class='text-center'><?php echo $sourceStock['name']; ?></td>
						<td class='text-center'><?php echo $itemName['name']; ?></td>
						<td class='text-center'><?php echo $destinationStock['name']; ?></td>
						<td class='text-center'><?php echo $row['transfer_amount']; ?></td>
						<td class='text-center'><?php echo $row['description']; ?></td>
						<?php if($validationEditCondition == 1){   ?>
						<td class="small text-center"><button title="Edit Records" class="edit_data fa fa-edit btn btn-blue btn-outline" id="<?php   echo $row['id']."+".$table;  ?>"></button></td>
						<?php }if($validationRemoveCondition == 1){ ?>
						<td class="small text-center"><a title="Remove" onclick="verifyRemoveFunction('<?php echo $table;    ?>',<?php echo $row['id']; ?>)"  ><i class="fa fa-times btn btn-red btn-outline"></i></a></td>
						<?php } ?>
					</tr>
					
					<?php
						
					}
				
				?>
				
				</tbody> 
			</table>
		</div>
			
		<?php
			
			$conn->paginate($table,$returnPage, $limit, $page);
		}
		
	}
	// Vendor Categories List.
	function listVendorCategories($returnPage,$validationEditCondition,$validationRemoveCondition){
		global $conn;
		global $userId;
		
		$table = "tbl_vendor_categories";
		$limit = 10;
		$page  = (isset($_GET['page']) ? $page = $conn->safeInput($_GET['page']) : $page = 0);
		$start = ($page ? $start = (($page - 1) * $limit) : $start = 0);
		 
		
		$vendorCategoriesRawSQLQuery    = "SELECT * FROM $table WHERE deleted = 0 ORDER BY id DESC LIMIT $start, $limit";
		$vendorCategoriesSQLQuery       = $conn->query($vendorCategoriesRawSQLQuery);
		
		
		if($vendorCategoriesSQLQuery->num_rows > 0){
		
		?>
			
			
		<div class="table-responsive">
			<table class="table table-bordered table-hover">
				<thead>
					<tr>
						<th class="text-center table-title" colspan="4">
							کتگوری های فروشنده گان
						</th>
					</tr>
					<tr class="table-header"> 
						<th class="small text-center">شماره</th>
						<th class='text-center'>نام</th>
						 <?php if($validationEditCondition == 1 || $validationRemoveCondition == 1){   ?> 
						<th class="small text-center" colspan="2">عملیات</th>
						 <?php   } ?>
					</tr> 
				</thead> 
				<tbody> 
				
					<?php
					while($row = $vendorCategoriesSQLQuery->fetch_array()){
						++$counter;
					?>
					
					<tr id='row-<?php echo $row['id']; ?>'> 
						<td class="small text-center "><?php echo $counter; ?></td>
						<td class='text-center'><?php echo $row['name']; ?></td>
						<?php if($validationEditCondition == 1){   ?>
						<td class="small text-center"><button title="Edit Records" class="edit_data fa fa-edit btn btn-blue btn-outline" id="<?php   echo $row['id']."+".$table;  ?>"></button></td>
						<?php }if($validationRemoveCondition == 1){ ?>
						<td class="small text-center"><a title="Remove" onclick="verifyRemoveFunction('<?php echo $table;    ?>',<?php echo $row['id']; ?>)"  ><i class="fa fa-times btn btn-red btn-outline"></i></a></td>
						<?php } ?>
					</tr>
					
					<?php
						
					}
				
				?>
				
				</tbody> 
			</table>
		</div>
			
		<?php
			
			$conn->paginate($table,$returnPage, $limit, $page);
		}
		
	}
	
	//List All Vendors
	function listVendors($returnPage,$validationEditCondition,$validationRemoveCondition){
		global $conn;
		global $userId;
		
		$table = "tbl_vendors";
		$limit = 10;
		$page  = (isset($_GET['page']) ? $page = $conn->safeInput($_GET['page']) : $page = 0);
		$start = ($page ? $start = (($page - 1) * $limit) : $start = 0);
		 
		
		$vendorsRawSQLQuery    = "SELECT * FROM $table WHERE deleted = 0 ORDER BY id DESC LIMIT $start, $limit";
		$vendorsSQLQuery       = $conn->query($vendorsRawSQLQuery);
		
		
		if($vendorsSQLQuery->num_rows > 0){
		
		?>
			
			
		<div class="table-responsive">
			<table class="table table-bordered table-hover">
				<thead>
					<tr>
						<th class="text-center table-title" colspan="11">
							لیست فروشنده گان
						</th>
					</tr>
					<tr class="table-header"> 
						<th class="small text-center">شماره </th>
						<th class='text-center'>تاریخ</th>
						<th class='text-center'>نام</th>
						<th class='text-center'>کتگوری فروشنده گان</th>
						<th class='text-center'>شماره موبایل</th>
						<th class='text-center'>حساب افتتاحیه</th>
  						<th class='text-center'>آدرس</th>
						<?php if($validationEditCondition == 1 || $validationRemoveCondition == 1){   ?> 
  						<th class="small text-center" colspan="2">عملیات</th>
						<?php   } ?>
					</tr> 
				</thead> 
				<tbody> 
				
				<?php
				
					while($row = $vendorsSQLQuery->fetch_array()){
						++$counter;
 					$rowVendor = $conn->selectRecord ("tbl_vendor_categories","id  = ". $row['vendor_type']);

					?>
					
					<tr id='row-<?php echo $row['id']; ?>'> 
						<td class="small text-center "><?php echo $counter; ?></td>
						<td class='text-center'><?php echo $row['date'];?></td>
						<td class='text-center'><?php echo $row['name'];?></td>
						<td class='text-center'><?php echo $rowVendor['name'];?></td>
						<td class='text-center '><?php echo $row['contact'];?></td>
						<td class='text-center '><?php echo $row['opening_balance']; ?></td>
 						<td class='text-center'><?php echo $row['address']; ?></td>
						<?php if($validationEditCondition == 1){   ?>
						<td class="small text-center"><button title="Edit Records" class="edit_data fa fa-edit btn btn-blue btn-outline" id="<?php   echo $row['id']."+".$table;  ?>"></button></td>
						<?php }if($validationRemoveCondition == 1){ ?>
						<td class="small text-center"><a title="Remove" onclick="verifyRemoveFunction('<?php echo $table;    ?>',<?php echo $row['id']; ?>)"  ><i class="fa fa-times btn btn-red btn-outline"></i></a></td>
						<?php } ?>
					</tr>
					
					<?php
						
					}
				
				?>
				
				</tbody> 
			</table>
		</div>
			
		<?php
			
			$conn->paginate($table,$returnPage, $limit, $page, $userId);
		}
		
	}
	//List All Vendors
	function listvendorReport($returnPage,$validationEditCondition,$validationRemoveCondition){
		global $conn;
		global $userId;
		
		$table = "tbl_vendors";
		$limit = 10;
		$page  = (isset($_GET['page']) ? $page = $conn->safeInput($_GET['page']) : $page = 0);
		$start = ($page ? $start = (($page - 1) * $limit) : $start = 0);
		 
		
		$vendorsRawSQLQuery    = "SELECT * FROM $table WHERE deleted = 0 ORDER BY id DESC LIMIT $start, $limit";
		$vendorsSQLQuery       = $conn->query($vendorsRawSQLQuery);
		
		
		if($vendorsSQLQuery->num_rows > 0){
		
		?>
			
			
		<div class="table-responsive">
			<table class="table table-bordered table-hover">
				<thead>
					<tr>
						<th class="text-center table-title" colspan="11">
							Vendors List
						</th>
					</tr>
					<tr class="table-header"> 
						<th class="small text-center">No</th>
						<th class='text-center'>Created At</th>
						<th class='text-center'>Date</th>
						<th class='text-center'>Name</th>
						<th class='text-center'>Vendor Category</th>
						<th class='text-center'>Contact / Email</th>
						<th class='text-center'>Opening Balance</th>
						<th class='text-center'>Currency</th>
						<th class='text-center'>Rate</th>
						<th class='text-center'>Address</th>
 					</tr> 
				</thead> 
				<tbody> 
				
				<?php
				
					while($row = $vendorsSQLQuery->fetch_array()){
						++$counter;
					$rowCurrency = $conn->selectRecord ("tbl_currencies","id  = ". $row['currencies_id']);
					$rowVendor = $conn->selectRecord ("tbl_vendor_categories","id  = ". $row['vendor_type']);

					?>
					
					<tr id='row-<?php echo $row['id']; ?>'> 
						<td class="small text-center "><?php echo $counter; ?></td>
						<td class='text-center'><?php echo $row['date'];?></td>
						<td class='text-center'><?php echo $row['date'];?></td>
						<td class='text-center'><?php echo $row['name'];?></td>
						<td class='text-center'><?php echo $rowVendor['name'];?></td>
						<td class='text-center '><?php echo $row['contact'];?></td>
						<td class='text-center '><?php echo $row['opening_balance']; ?></td>
						<td class='text-center'><?php echo $rowCurrency['code']; ?></td>
						<td class='text-center '><?php echo $row['rate']; ?></td>
						<td class='text-center'><?php echo $row['address']; ?></td>
					</tr>
					
					<?php
						
					}
				
				?>
				
				</tbody> 
			</table>
		</div>
			
		<?php
			
			$conn->paginate($table,$returnPage, $limit, $page, $userId);
		}
		
	}
	
	function listPurchaseBill($returnPage,$validationEditCondition,$validationRemoveCondition){
		global $conn;
		global $userId;
		
		$table = "tbl_vendor_bill_title";
		$limit = 10;
		$page  = (isset($_GET['page']) ? $page = $conn->safeInput($_GET['page']) : $page = 0);
		$start = ($page ? $start = (($page - 1) * $limit) : $start = 0);
		 
		
		$purchaseRawSQLQuery    = "SELECT * FROM $table WHERE  deleted = 0  ORDER BY id DESC LIMIT $start, $limit";
		$purchaseSQLQuery            = $conn->query($purchaseRawSQLQuery);
		

		if($purchaseSQLQuery->num_rows > 0){
		
		?>
		<div class="table-responsive">
			<table class="table table-bordered table-hover">
				<thead>
					<tr>
						<th class="text-center table-title" colspan="12">
						لیست خریداری ها 
						</th>
					</tr>
					<tr class="table-header"> 
						<th class='text-center'>شماره</th>
						<th class='text-center'>تاریخ</th>
						<th class='text-center'>فروشنده</th>
 						<th class='text-center'>واحد پولی</th>
						<th class='text-center'>بانک</th>
						<th class='text-center'>نرخ</th>
 						<th class='text-center'>شماره فاکتور</th>
 						<th class='text-center'>مقدار پرداختی</th>
						<th class='text-center'>پرنت</th>
						<?php  if($validationEditCondition == 1){ ?>
						<th class='text-center'>ویرایش جزئیات</th>
						<?php   } ?>
  						<th class="small text-center" colspan="2">عملیات</th>
					</tr> 
				</thead> 
				<tbody> 
				
				<?php
			
				while($row = $purchaseSQLQuery->fetch_array()){
					++$counter;
					
				$rowVendor = $conn->selectRecord ("tbl_vendors","id  = ". $row['vendors_id']);
				$rowCurrency = $conn->selectRecord ("tbl_currencies","id  = ". $row['currencies_id']);
				$rowBank = $conn->selectRecord ("tbl_banks","id  = ". $row['banks_id']	);
				?>
				
				<tr id='row-<?php echo $row['id']; ?>'> 
					<td class="small text-center "><?php echo $counter; ?></td>
					<td class='text-center '><?php echo $row['date']; ?></td>
					<td class='text-center'><?php  echo $rowVendor['name']; ?></td>
					<td class='text-center '><?php  echo $rowCurrency['code']; ?></td>
					<td class='text-center'><?php  echo $rowBank['name']; ?></td>
					<td class='text-center '><?php  echo $row['rate']; ?></td>
					<td class='text-center'><?php  echo $row['factor_number']; ?></td>
					<td class='text-center'><?php  echo $row['factor_payment']; ?></td>
					<td class="text-center"><a title="Print Bill" href="printVendorFactorAT.php?id=<?php echo encryptIt($row['id']); ?>" target="_"><i class="fa fa-print btn btn-blue btn-outline"></i></a></td>
					<?php  if($validationEditCondition == 1){   ?>
					<td class="text-center"><button title="Edit Records" class="edit_data fa fa-edit btn btn-blue btn-outline" id="<?php   echo $row['id']."+".$table;  ?>"></button></td>
					<?php   } ?>
					<td class="text-center"><a title="Edit Details" href="editPurchasesBillAT.php?id=<?php echo encryptIt($row['id']); ?>"><i class="fa fa-edit btn btn-blue btn-outline"></i></a></td>
					<?php if($validationRemoveCondition == 1){ ?>
					<?php  
					
							$selectDetailsRawMaterials = $conn->query("SELECT * FROM tbl_vendor_bill_details where 	title_bills_id = ".$row['id']." AND deleted = 0");
  							if($selectDetailsRawMaterials->num_rows > 0){
						?>
							
							<td class="small text-center"><a title="Remove"><i class="fa fa-times btn btn-outline-info"></i></a></td>
						<?php
							}else{
						?>
							<td class="small text-center"><a title="Remove" onclick="verifyRemoveFunction('<?php echo $table;    ?>',<?php echo $row['id']; ?>)"  ><i class="fa fa-times btn btn-red btn-outline"></i></a></td>
						<?php
							}
							}
						?>
				</tr>
				
					<?php
					 
					}
				
				?>
				
				</tbody> 
			</table>
		</div>
			
		<?php
			
			$conn->paginate($table,$returnPage, $limit, $page, $userId);
		}
	
	}	
	// لیست توزیع اقلام
	function materialsListDistribution($returnPage,$validationEditCondition,$validationRemoveCondition){
		global $conn;
		global $userId;
		
		$table = "tbl_donations_materials_title";
		$limit = 10;
		$page  = (isset($_GET['page']) ? $page = $conn->safeInput($_GET['page']) : $page = 0);
		$start = ($page ? $start = (($page - 1) * $limit) : $start = 0);
		 
		
		$purchaseRawSQLQuery    = "SELECT * FROM $table WHERE  deleted = 0  ORDER BY id DESC LIMIT $start, $limit";
		$purchaseSQLQuery            = $conn->query($purchaseRawSQLQuery);
		
		if($purchaseSQLQuery->num_rows > 0){
		
		?>
		<div class="table-responsive">
			<table class="table table-bordered table-hover">
				<thead>
					<tr>
						<th class="text-center table-title" colspan="12">
							لیست توزیع اجناس  
						</th>
					</tr>
					<tr class="table-header"> 
						<th class='text-center'>شماره</th>
						<th class='text-center'>تاریخ</th>
						<th class='text-center'>مکتب</th>
 						<th class='text-center'>بانک</th>
  						<th class='text-center'>شماره درخواست</th>
 						<th class='text-center'>پرنت</th>
						<?php  if($validationEditCondition == 1){ ?>
						<th class='text-center'>ویرایش جزئیات</th>
						<?php   } ?>
  						<th class="small text-center" colspan="2">عملیات</th>
					</tr> 
				</thead> 
				<tbody> 
				
				<?php
			
				while($row = $purchaseSQLQuery->fetch_array()){
					++$counter;
					
				$rowSchools = $conn->selectRecord ("tbl_schools","id  = ". $row['schools_id']);
 				$rowBank = $conn->selectRecord ("tbl_banks","id  = ". $row['banks_id']	);
				?>
				
				<tr id='row-<?php echo $row['id']; ?>'> 
					<td class="small text-center "><?php echo $counter; ?></td>
					<td class='text-center '><?php echo $row['date']; ?></td>
					<td class='text-center'><?php  echo $rowSchools['name']; ?></td>
 					<td class='text-center'><?php  echo $rowBank['name']; ?></td>
 					<td class='text-center'><?php  echo $row['request_number']; ?></td>
 					<td class="text-center"><a title="Print Bill" href="printMaterialsDistributionAT.php?id=<?php echo encryptIt($row['id']); ?>" target="_"><i class="fa fa-print btn btn-blue btn-outline"></i></a></td>
					<?php  if($validationEditCondition == 1){   ?>
					<td class="text-center"><button title="Edit Records" class="edit_data fa fa-edit btn btn-blue btn-outline" id="<?php   echo $row['id']."+".$table;  ?>"></button></td>
					<?php   } ?>
					<td class="text-center"><a title="Edit Details" href="editMaterialsDistributionsAT.php?id=<?php echo encryptIt($row['id']); ?>"><i class="fa fa-edit btn btn-blue btn-outline"></i></a></td>
					<?php if($validationRemoveCondition == 1){ ?>
					<?php  
					
							$selectDetailsRawMaterials = $conn->query("SELECT * FROM tbl_donations_materials_details where 	titles_id = ".$row['id']." AND deleted = 0");
  							if($selectDetailsRawMaterials->num_rows > 0){
						?>
							
							<td class="small text-center"><a title="Remove"><i class="fa fa-times btn btn-outline-info"></i></a></td>
						<?php
							}else{
						?>
							<td class="small text-center"><a title="Remove" onclick="verifyRemoveFunction('<?php echo $table;    ?>',<?php echo $row['id']; ?>)"  ><i class="fa fa-times btn btn-red btn-outline"></i></a></td>
						<?php
							}
							}
						?>
				</tr>
				
					<?php
					 
					}
				
				?>
				
				</tbody> 
			</table>
		</div>
			
		<?php
			
			$conn->paginate($table,$returnPage, $limit, $page, $userId);
		}
	
	}
	function editVendorsDetails($rowId,$validationEditCondition,$validationRemoveCondition){
		global $conn;
		global $userId;
		$table = "tbl_vendor_bill_details";
		 
		$purchaseRawSQLQuery    = "SELECT * FROM  tbl_vendor_bill_details WHERE deleted = 0 AND  title_bills_id = $rowId";
		$purchaseSQLQuery            = $conn->query($purchaseRawSQLQuery);
		
		if($purchaseSQLQuery->num_rows > 0){
		?>
		<div class="table-responsive">
			<table class="table table-bordered table-hover">
				<thead>
					<tr>
						<th class="text-center table-title" colspan="12">
							جزئیات فاکتور خریداری
						</th>
					</tr>
					<tr class="table-header"> 
						<th class='text-center'>شماره</th>
						<th class='text-center'>جنس</th>
						<th class='text-center'>واحد</th>
 						<th class='text-center'>مقدار</th>
						<th class='text-center'>فی</th>
  						<th class='text-center'>مجمعه</th>
  						<th class='text-center'>گدام</th>
						<th class='text-center'>توضیحات</th>
   						<?php if($validationEditCondition == 1 || $validationRemoveCondition == 1){   ?> 
  						<th class="small text-center" colspan="2">عملیات</th>
						<?php   } ?>
					</tr> 
				</thead> 
				<tbody> 
				
				<?php
				while($row = $purchaseSQLQuery->fetch_array()){	
					++$counter;
					$rowItems = $conn->selectRecord ("tbl_items","id  = ". $row['items_id']);
					$rowUnits = $conn->selectRecord ("tbl_item_units","id  = ". $row['items_unit_id']);
					$rowStock = $conn->selectRecord ("tbl_stocks","id  = ". $row['stocks_id']);
				?>
				
				<tr id='row-<?php echo $row['id']; ?>'> 
					<td class="small text-center "><?php echo $counter; ?></td>
					<td class='text-center '><?php echo $rowItems['name']; ?></td>
					<td class='text-center'><?php  echo $rowUnits['name']; ?></td>
					<td class='text-center '><?php  echo $row['amount']; ?></td>
					<td class='text-center'><?php  echo $row['fee']; ?></td>
 					<td class='text-center '><?php  echo $row['total_amount']; ?></td>
 					<td class='text-center '><?php  echo $rowStock['name']; ?></td>
					<td class='text-center'><?php  echo $row['description']; ?></td>
					<?php if($validationEditCondition == 1){   ?>
 					<td class="text-center"><button title="Edit Records" class="edit_data fa fa-edit btn btn-blue btn-outline" id="<?php   echo $row['id']."+".$table;  ?>"></button></td>
					<?php }if($validationRemoveCondition == 1){ ?>
					<td class="small text-center"><a title="Remove" onclick="verifyRemoveFunction('<?php echo $table;    ?>',<?php echo $row['id']; ?>)"  ><i class="fa fa-times btn btn-red btn-outline"></i></a></td>
					<?php   } ?>
				</tr>
				
				<?php
					
				} 
				
				?>
				
				</tbody> 
			</table>
		</div>
		<?php
		 }
		  
	}function editMaterialsDistributions($rowId,$validationEditCondition,$validationRemoveCondition){
		global $conn;
		global $userId;
		$table = "tbl_donations_materials_details";
		 
		$purchaseRawSQLQuery    = "SELECT * FROM  tbl_donations_materials_details WHERE deleted = 0 AND  titles_id = $rowId";
		$purchaseSQLQuery            = $conn->query($purchaseRawSQLQuery);
		
		if($purchaseSQLQuery->num_rows > 0){
		?>
		<div class="table-responsive">
			<table class="table table-bordered table-hover">
				<thead>
					<tr>
						<th class="text-center table-title" colspan="12">
							جزئیات توزیع اقلام
						</th>
					</tr>
					<tr class="table-header"> 
						<th class='text-center'>شماره</th>
						<th class='text-center'>اجناس</th>
						<th class='text-center'>واحد</th>
 						<th class='text-center'>مقدار</th>
						<th class='text-center'>واحد</th>
  						<th class='text-center'>مجموعه</th>
  						<th class='text-center'>گدام</th>
						<th class='text-center'>توضیحات</th>
   						<?php if($validationEditCondition == 1 || $validationRemoveCondition == 1){   ?> 
  						<th class="small text-center" colspan="2">عملیات</th>
						<?php   } ?>
					</tr> 
				</thead> 
				<tbody> 
				
				<?php
			
			 
				while($row = $purchaseSQLQuery->fetch_array()){	
				++$counter;
				$rowItems = $conn->selectRecord ("tbl_items","id  = ". $row['items_id']);
				$rowUnits = $conn->selectRecord ("tbl_item_units","id  = ". $row['items_unit_id']);
				$rowStock = $conn->selectRecord ("tbl_stocks","id  = ". $row['stocks_id']);
				?>
				
				<tr id='row-<?php echo $row['id']; ?>'> 
					<td class="small text-center "><?php echo $counter; ?></td>
					<td class='text-center '><?php echo $rowItems['name']; ?></td>
					<td class='text-center'><?php  echo $rowUnits['name']; ?></td>
					<td class='text-center '><?php  echo $row['amount']; ?></td>
					<td class='text-center'><?php  echo $row['fee']; ?></td>
 					<td class='text-center '><?php  echo $row['total_amount']; ?></td>
 					<td class='text-center '><?php  echo $rowStock['name']; ?></td>
					<td class='text-center'><?php  echo $row['description']; ?></td>
					<?php if($validationEditCondition == 1){   ?>
 					<td class="text-center"><button title="Edit Records" class="edit_data fa fa-edit btn btn-blue btn-outline" id="<?php   echo $row['id']."+".$table;  ?>"></button></td>
					<?php }if($validationRemoveCondition == 1){ ?>
					<td class="small text-center"><a title="Remove" onclick="verifyRemoveFunction('<?php echo $table;    ?>',<?php echo $row['id']; ?>)"  ><i class="fa fa-times btn btn-red btn-outline"></i></a></td>
					<?php   } ?>
				</tr>
				
				<?php
					
				} 
				
				?>
				
				</tbody> 
			</table>
		</div>
		<?php
		 }
		  
	}function editOrgRequestMaterials($rowId,$validationEditCondition,$validationRemoveCondition){
		global $conn;
		global $userId;
		$table = "tbl_org_req_materials_details";
		 
		$requestEquipmentsDetails    = "SELECT * FROM  tbl_org_req_materials_details WHERE deleted = 0 AND  request_title_id = $rowId";
		$requestEquipmentsQuery            = $conn->query($requestEquipmentsDetails);
		
		if($requestEquipmentsQuery->num_rows > 0){
		?>
		<div class="table-responsive">
			<table class="table table-bordered table-hover">
				<thead>
					<tr>
						<th class="text-center table-title" colspan="12">
							جزئیات کالای درخواستی
						</th>
					</tr>
					<tr class="table-header"> 
						<th class='text-center'>شماره</th>
						<th class='text-center'>کالا</th>
						<th class='text-center'>واحد</th>
 						<th class='text-center'>مقدار</th>
						<th class='text-center'>توضیحات</th>
    						<?php if($validationEditCondition == 1 || $validationRemoveCondition == 1){   ?> 
  						<th class="small text-center" colspan="2">عملیات</th>
						<?php   } ?>
					</tr> 
				</thead> 
				<tbody> 
				
				<?php
			
			 
				while($row = $requestEquipmentsQuery->fetch_array()){	
				++$counter;
				$rowItems = $conn->selectRecord ("tbl_items","id  = ". $row['items_id']);
				$rowUnits = $conn->selectRecord ("tbl_item_units","id  = ". $row['items_unit_id']);
 				?>
				
				<tr id='row-<?php echo $row['id']; ?>'> 
					<td class="small text-center "><?php echo $counter; ?></td>
					<td class='text-center '><?php echo $rowItems['name']; ?></td>
					<td class='text-center'><?php  echo $rowUnits['name']; ?></td>
					<td class='text-center '><?php  echo $row['quantity']; ?></td>
 					<td class='text-center'><?php  echo $row['description']; ?></td>
					<?php if($validationEditCondition == 1){   ?>
 					<td class="text-center"><button title="Edit Records" class="edit_data fa fa-edit btn btn-blue btn-outline" id="<?php   echo $row['id']."+".$table;  ?>"></button></td>
					<?php }if($validationRemoveCondition == 1){ ?>
					<td class="small text-center"><a title="Remove" onclick="verifyRemoveFunction('<?php echo $table;    ?>',<?php echo $row['id']; ?>)"  ><i class="fa fa-times btn btn-red btn-outline"></i></a></td>
					<?php   } ?>
				</tr>
				
				<?php
					
				} 
				
				?>
				
				</tbody> 
			</table>
		</div>
		<?php
		 }
	}function listVendorsPayments($validationEditCondition,$validationRemoveCondition){
		global $conn;
		global $userId;
		
		$table = "tbl_vendor_payment";
		$limit = 10;
		$page  = (isset($_GET['page']) ? $page = $conn->safeInput($_GET['page']) : $page = 0);
		$start = ($page ? $start = (($page - 1) * $limit) : $start = 0);
		 
		
		$paymentRawSQLQuery  = "SELECT * FROM $table WHERE deleted = 0 AND payment_type = 2 ORDER BY id DESC LIMIT $start, $limit";
		$paymentSQLQuery    = $conn->query($paymentRawSQLQuery);
		

		if($paymentSQLQuery->num_rows > 0){
		
		?>
		<div class="table-responsive">
			<table class="table table-bordered table-hover">
				<thead>
					<tr>
						<th class="text-center table-title" colspan="12">
						پرداختی های به فروشنده
						</th>
					</tr>
					<tr class="table-header"> 
						<th class='text-center'>شماره</th>
						<th class='text-center'>تاریخ</th>
						<th class='text-center'>شماره پرداختی</th>
						<th class='text-center'>نام فروشنده</th>
 						<th class='text-center'>مقدار</th>
 						<th class='text-center'>بانک</th>
						<th class='text-center'>توضیحات</th>
						<th class='text-center'>پرنت</th>
 						<?php if($validationEditCondition == 1 || $validationRemoveCondition == 1){   ?> 
							<th class="small text-center" colspan="2">عملیات</th>
						<?php   } ?>
					</tr> 
				</thead> 
				<tbody> 
				
				<?php
				
					while($row = $paymentSQLQuery->fetch_array()){
						++$counter;
						
					$rowCurrency = $conn->selectRecord ("tbl_currencies","id  = ". $row['currencies_id']);
 					$rowBank = $conn->selectRecord ("tbl_banks","id  = ". $row['banks_id']	);
					$rowVendors = $conn->selectRecord ("tbl_vendors","id  = ". $row['vendors_id']);
					?>
					
					<tr id='row-<?php echo $row['id']; ?>'> 
						<td class="small text-center "><?php echo $counter; ?></td>
						<td class='text-center '><?php echo $row['date']; ?></td>
						<td class='text-center '><?php  echo $row['factor_number']; ?></td>
						<td class='text-center'><?php  echo $rowVendors['name']; ?></td>
  						<td class='text-center '><?php  echo $row['amount']; ?></td>
 						<td class='text-center'><?php  echo $rowBank['name']; ?></td>
 						<td class='text-center'><?php  echo $row['description']; ?></td>
						<td class="small text-center"><a title="Print Factor" target="_" href="printVendorPaymentFactor.php?id=<?php echo encryptIt($row['id']); ?>"><i class="fa fa-print btn btn-blue btn-outline"></i></a></td>
						<?php if($validationEditCondition == 1){   ?>
						<td class="small text-center"><button title="Edit Records" class="edit_data fa fa-edit btn btn-blue btn-outline" id="<?php   echo $row['id']."+".$table;  ?>"></button></td>
						<?php }if($validationRemoveCondition == 1){ ?>
						<td class="small text-center"><a title="Remove" onclick="verifyRemoveFunction('<?php echo $table;    ?>',<?php echo $row['id']; ?>)"  ><i class="fa fa-times btn btn-red btn-outline"></i></a></td>
						<?php   } ?>
					</tr>
					
					<?php
						
					}
				
				?>
				
				</tbody> 
			</table>
		</div>
			
		<?php
			
			$conn->paginate($table, "vendorPaymentAT.php", $limit, $page, $userId);
		}
		
	}
	function listBalanceSheetVendors($fromDate,$toDate,$vendorId){
		global $conn;
		global $userId;
		 
		$table = "tbl_vendor_statement";
		$limit = 10;
		$page  = (isset($_GET['page']) ? $page = $conn->safeInput($_GET['page']) : $page = 0);
		$start = ($page ? $start = (($page - 1) * $limit) : $start = 0);
		 
		if($fromDate != 0 && $toDate != 0){
			$vendorRawSQLQuery    = "SELECT * FROM $table WHERE  date BETWEEN '$fromDate' AND '$toDate' AND deleted = 0 AND vendors_id = $vendorId  ORDER BY id DESC LIMIT $start, $limit";
			$tableHeader = "Vendor's Account From : $fromDate Up to $toDate";
		}else{
			$vendorRawSQLQuery    = "SELECT * FROM $table WHERE deleted = 0 AND vendors_id = $vendorId   ORDER BY id DESC LIMIT $start, $limit";
		}
		$vendorRawSQLQuery            = $conn->query($vendorRawSQLQuery);
		

		if($vendorRawSQLQuery->num_rows > 0){
		
		?>
		<div class="table-responsive">
			<table class="table table-bordered table-hover">
				<thead>
					<tr>
						<th class="text-center table-title" colspan="12">
						<?php if(isset($tableHeader)){echo $tableHeader;}else{ echo "بلانس شیت فروشنده گان";}  ?>
 						</th>
					</tr>
					<tr class="table-header"> 
						<th class='text-center'>شماره</th>
						<th class='text-center'>تاریخ</th>
  						<th class='text-center'>مسیر انتقالات</th>
  						<th class='text-center'>توضیحات</th>
						<th class='text-center'>دیبت</th>
						<th class='text-center'>کریدت</th>
 						<th class='text-center'>بلانس فعلی</th>
 					</tr> 
				</thead> 
				<tbody> 
				
				<?php
					$counter    = 0;
					$total      = 0;
					$recievable = 0;
					$payable    = 0;
					while($row = $vendorRawSQLQuery->fetch_array()){
						++$counter;
						$amount = $row['amount'];
						$type   = $row['transaction_type'];
						
						if($type == 2){
							$total -= $amount;
							$payable  += $amount;
						}else if($type == 1){
							$total += $amount;
							$recievable += $amount;
						}	

					?>
					
					<tr> 
						<td class="small text-center "><?php echo $counter; ?></td>
						<td class='text-center'><?php echo $row['date']; ?></td>
						<td class='text-center'><?php echo $row['place']; ?></td>
						<td class='text-center'><?php echo $row['description']; ?></td>
 						<td class='text-center'><?php echo ($type == 2 ? $amount : "") ?></td>
						<td class='text-center'><?php echo ($type == 1 ? $amount : "") ?></td>
						<td class='text-center'><?php echo $total; ?></td>
  					</tr>
					
					<?php
						
					}
					?>
					<tr  style="background-color: #aaa;"> 
 						<td class='text-center' colspan='4'>مجموعه حسابات</td>
						<td class='text-center'><?php echo number_format($payable,2);?></td>
 						<td class='text-center'><?php echo number_format($recievable,2);?></td>
						<td class='text-center'><?php echo number_format($recievable - $payable,2);  ?></td>
   					</tr> 
				 
				</tbody> 
			</table>
		</div>
			
		<?php
			
			$conn->paginate($table, "vendorBalanceSheetETQ.php", $limit, $page, $userId);
		}
		
	}
	function listPaymentVendors($fromDate,$toDate){
		global $conn;
		global $userId;
		 
		$table = "tbl_vendor_payment";
		$limit = 10;
		$page  = (isset($_GET['page']) ? $page = $conn->safeInput($_GET['page']) : $page = 0);
		$start = ($page ? $start = (($page - 1) * $limit) : $start = 0);
		 
		if($fromDate != 0 && $toDate != 0){
			$vendorPaymentRawSQL    = "SELECT * FROM $table WHERE date BETWEEN '$fromDate' AND '$toDate' AND deleted = 0 AND payment_type = 2 ORDER BY id DESC LIMIT $start, $limit";
			$tableHeader = "Vendor's payment From : $fromDate Up to  $toDate";
		}else{
			$vendorPaymentRawSQL   = "SELECT * FROM $table WHERE deleted = 0  AND payment_type = 2  ORDER BY id DESC LIMIT $start, $limit";
		}
		$vendorPaymentRawSQLQuery            = $conn->query($vendorPaymentRawSQL);
		

		if($vendorPaymentRawSQLQuery->num_rows > 0){
		
		?>
		<div class="table-responsive">
			<table class="table table-bordered table-hover">
				<thead>
					<tr>
						<th class="text-center table-title" colspan="12">
						<?php if(isset($tableHeader)){echo $tableHeader;}else{ echo "پرداختی ها به فروشنده";}  ?>
 						</th>
					</tr>
					<tr class="table-header"> 
						<th class='text-center'>شماره</th>
						<th class='text-center'>تاریخ</th>
						<th class='text-center'>شماره پرداختی</th>
  						<th class='text-center'>واحد پولی</th>
  						<th class='text-center'>مقدار</th>
 						<th class='text-center'>توضیحات</th>
 					</tr> 
				</thead> 
				<tbody> 
				
				<?php
					 
					while($row = $vendorPaymentRawSQLQuery->fetch_array()){
					$rowEmployee = $conn->selectRecord ("tbl_customers","id  = ". $row['employee_id']);
					$rowCurrency = $conn->selectRecord ("tbl_currencies","id  = ". $row['currencies_id']);
						++$counter;
					?>
					<tr id='row-<?php echo $row['id']; ?>'> 
						<td class="small text-center"><?php echo $counter; ?></td>
						<td class='text-center'><?php echo $row['date']; ?></td>
						<td class='text-center'><?php echo $row['factor_number']; ?></td>
 						<td class='text-center'><?php echo $rowCurrency['code']; ?></td>
						<td class='text-center'><?php echo $row['amount']; ?></td>
						<td class='text-center'><?php echo $row['description']; ?></td>
   					</tr>
					
					<?php
						
					}
					?>
				</tbody> 
			</table>
		</div>
			
		<?php
			
			$conn->paginate($table, "vendorPaymentReportAT.php", $limit, $page);
		}
		
	}
	
	function listBalanceSheetStocks(){
		global $conn;
		global $userId;
		 
		$table = "tbl_stock_statement";
		$limit = 10;
		$page  = (isset($_GET['page']) ? $page = $conn->safeInput($_GET['page']) : $page = 0);
		$start = ($page ? $start = (($page - 1) * $limit) : $start = 0);
		 
		if($fromDate != 0 && $toDate != 0){
			$customerRawSQLQuery    = "SELECT * FROM $table WHERE date BETWEEN '$fromDate' AND '$toDate' AND deleted = 0  ORDER BY id DESC LIMIT $start, $limit";
			$tableHeader = "Customer Account From  : $fromDate Up to $toDate";
		}else{
			$customerRawSQLQuery    = "SELECT * FROM $table WHERE deleted = 0  ORDER BY id DESC LIMIT $start, $limit";
		}
		$customerRawSQLQuery            = $conn->query($customerRawSQLQuery);
		

		if($customerRawSQLQuery->num_rows > 0){
		
		?>
		<div class="table-responsive">
			<table class="table table-bordered table-hover">
				<thead>
					<tr>
						<th class="text-center table-title" colspan="12">
						<?php if(isset($tableHeader)){echo $tableHeader;}else{ echo "Customer Balance Sheet";}  ?>
 						</th>
					</tr>
					<tr class="table-header"> 
						<th class='text-center'>No</th>
						<th class='text-center'>Date</th>
  						<th class='text-center'>Transaction Way</th>
  						<th class='text-center'>Item</th>
  						<th class='text-center'>Description</th>
						<th class='text-center'>Debit</th>
						<th class='text-center'>Credit</th>
 						<th class='text-center'>Current Balance</th>
 					</tr> 
				</thead> 
				<tbody> 
				
				<?php
					$counter    = 0;
					$total      = 0;
					$recievable = 0;
					$payable    = 0;
					while($row = $customerRawSQLQuery->fetch_array()){
						++$counter;
						$amount = $row['amount'];
						$type   = $row['transaction_type'];
						
						if($type == 2){
							$total -= $amount;
							$payable  += $amount;
						}else if($type == 1){
							$total += $amount;
							$recievable += $amount;
						}
						
									$rowItems = $conn->selectRecord ("tbl_items","id  = ". $row['items_id']	);
 					?>
					<tr> 
						<td class="small text-center "><?php echo $counter; ?></td>
						<td class='text-center '><?php echo $row['date']; ?></td>
						<td class='text-center '><?php echo $row['place']; ?></td>
						<td class='text-center '><?php echo $rowItems['name']; ?></td>
						<td class='text-center '><?php echo $row['description']; ?></td>
 						<td class='text-center '><?php echo ($type == 2 ? $amount : "") ?></td>
						<td class='text-center '><?php echo ($type == 1 ? $amount : "") ?></td>
						<td class='text-center '><?php echo $total; ?></td>
  					</tr>
					
					<?php
						
					}
					?>
					<tr  style="background-color: #aaa;"> 
 						<td class='text-center ' colspan='5'> Total </td>
						<td class='text-center '><?php echo number_format($payable,2);?></td>
 						<td class='text-center '><?php echo number_format($recievable,2);?></td>
						<td class='text-center '><?php echo number_format($recievable - $payable,2);  ?></td>
   					</tr> 
				 
				</tbody> 
			</table>
		</div>
			
		<?php
			
			$conn->paginate($table, "customerBalanceSheetETQ.php", $limit, $page, $userId);
		}
		
	}
	
	//List All Currencies
	function listCurrencies($validationRemoveCondition){
		global $conn;
		global $userId;
		
		$table = "tbl_currencies";
		$limit = 30;
		$page  = (isset($_GET['page']) ? $page = $conn->safeInput($_GET['page']) : $page = 0);
		$start = ($page ? $start = (($page - 1) * $limit) : $start = 0);
		 
		
		$currenciesRawSQLQuery    = "SELECT * FROM $table WHERE  deleted = 0 AND verified = 1 ORDER BY id DESC LIMIT $start, $limit";
		$currenciesSQLQuery            = $conn->query($currenciesRawSQLQuery);
		
		
		if($currenciesSQLQuery->num_rows > 0){
		
		?>
		<div class="table-responsive ">
			<table class="table table-bordered table-hover">
				<thead>
					<tr>
						<th class="text-center table-title" colspan="11">
							لیست واحدهای پولی
						</th>
					</tr>
					<tr class="table-header"> 
						<th class="small text-center">شماره</th>
						<th class='text-center'>نام</th>
						<?php if($validationRemoveCondition == 1){   ?> 
 						<th class="small text-center" colspan="2">عملیات</th>
						<?php  } ?>
					</tr> 
				</thead> 
				<tbody> 
				
				<?php
				
					while($row = $currenciesSQLQuery->fetch_array()){
						++$counter;
					 
					?>
					
					<tr id='row-<?php echo $row['id']; ?>'> 						
						<td class="small text-center "><?php echo $counter; ?></td>
  						<td class='text-center'><?php echo $row['code']; ?></td>
						<?php if($validationRemoveCondition == 1){   ?>
						<td class="small text-center"><a title="Remove" onclick="verifyRemoveFunction('<?php echo $table;    ?>',<?php echo $row['id']; ?>)"  ><i class="fa fa-times btn btn-red btn-outline"></i></a></td>
						<?php  } ?>
					</tr>
					
					<?php
						
					}
				
				?>
				
				</tbody> 
			</table>
		</div>
			
		<?php
			
			$conn->paginate($table, "addCurrencyETQ.php", $limit, $page);
		}
		
	}
	
	//List All Currency Rates
	function listCurrenciesRate($validationRemoveCondition){
		global $conn;
		global $userId;
		
		$table = "tbl_currency_rate";
		$limit = 30;
		$page  = (isset($_GET['page']) ? $page = $conn->safeInput($_GET['page']) : $page = 0);
		$start = ($page ? $start = (($page - 1) * $limit) : $start = 0);
		 
		
		$currenciesRateRawSQLQuery    = "SELECT * FROM $table WHERE deleted = 0 AND verified = 1 ORDER BY id DESC LIMIT $start, $limit";
		$currenciesRateSQLQuery            = $conn->query($currenciesRateRawSQLQuery);
		

		if($currenciesRateSQLQuery->num_rows > 0){
		
		?>
		<div class="table-responsive">
			<table class="table table-bordered table-hover">
				<thead>
					<tr>
						<th class="text-center table-title" colspan="11">
							ثبت نرخ ها واحدات پولی
						</th>
					</tr>
					<tr class="table-header"> 
						<th class="small text-center">شماره</th>
						<th class='text-center'>تاریخ</th>
						<th class='text-center'>واحد پولی</th>
						<th class='text-center'>نرخ</th>
						<?php if($validationRemoveCondition == 1){   ?> 
 						<th class="small text-center" colspan="2">عملیات</th>
						<?php   } ?>
					</tr> 
				</thead> 
				<tbody> 
				
				<?php
				
					while($row = $currenciesRateSQLQuery->fetch_array()){
						++$counter;
						
					$currencyRow      = $conn->selectRecord("tbl_currencies","id = " . $row['currencies_id']);
 					
					?>
					
					<tr id='row-<?php echo $row['id']; ?>'> 
						<td class="small text-center "><?php echo $counter; ?></td>
  						<td class='text-center '><?php echo $row['date']; ?></td>
  						<td class='text-center'><?php echo $currencyRow['code']; ?></td>
  						<td class='text-center '><?php echo $row['rate']; ?></td>
						<?php if($validationRemoveCondition == 1){   ?>
						<td class="small text-center"><a title="Remove" onclick="verifyRemoveFunction('<?php echo $table;    ?>',<?php echo $row['id']; ?>)"  ><i class="fa fa-times btn btn-red btn-outline"></i></a></td>
						<?php   } ?>
					</tr>
					
					<?php
						
					}
				
				?>
				
				</tbody> 
			</table>
		</div>
			
		<?php
			
			$conn->paginate($table, "addCurrencyRateETQ.php", $limit, $page);
		}
		
	}
	
	//List All Banks
	function listBanks($validationEditCondition,$validationRemoveCondition){
		global $conn;
		global $userId;
		
		$table = "tbl_banks";
		$limit = 30;
		$page  = (isset($_GET['page']) ? $page = $conn->safeInput($_GET['page']) : $page = 0);
		$start = ($page ? $start = (($page - 1) * $limit) : $start = 0);
		 
		
		$banksRawSQLQuery    = "SELECT * FROM $table WHERE deleted = 0 ORDER BY id DESC LIMIT $start, $limit";
		$banksSQLQuery       = $conn->query($banksRawSQLQuery);
		if($banksSQLQuery->num_rows > 0){
		
		?>
		<div class="table-responsive">
			<table class="table table-bordered table-hover">
				<thead>
					<tr>
						<th class="text-center table-title" colspan="11">
							لیست بانک ها 
						</th>
					</tr>
					<tr class="table-header"> 
						<th class="small text-center">شماره</th>
						<th class="text-center">تاریخ</th>
						<th class="text-center">نام</th>
						<th class="text-center">کتگوری بانک</th>
						<th class="text-center">حساب افتتاحیه</th>
 						<th class="text-center">توضیحات</th>
						<?php if($validationEditCondition == 1 || $validationRemoveCondition == 1){   ?> 
						<th class="small text-center" colspan="2">عملیات</th>
						<?php   } ?>
					</tr> 
				</thead> 
				<tbody> 
				
				<?php
				
					while($row = $banksSQLQuery->fetch_array()){
						++$counter;
						$rowCategory = $conn->selectRecord ("tbl_banks_category","id  = ". $row['category_id']);

					?>
					
					<tr id='row-<?php echo $row['id']; ?>'> 
						<td class="small text-center"><?php echo $counter; ?></td>
						<td class='text-center'><?php echo $row['date']; ?></td>
						<td class='text-center'><?php echo $row['name']; ?></td>
						<td class='text-center'><?php echo $rowCategory['name']; ?></td>
						<td class='text-center'><?php echo $row['opening_balance']; ?></td>
 						<td   class='text-center'><div style="width:100%;max-height:60px;overflow-y:scroll;"> <?php echo $row['description']; ?></div></td>
						<?php if($validationEditCondition == 1){   ?>
						<td class="small text-center"><button title="Edit Records" class="edit_data fa fa-edit btn btn-blue btn-outline" id="<?php   echo $row['id']."+".$table;  ?>"></button></td>
						<?php }if($validationRemoveCondition == 1){ ?>
						<td class="small text-center"><a title="Remove" onclick="verifyRemoveFunction('<?php echo $table;    ?>',<?php echo $row['id']; ?>)"  ><i class="fa fa-times btn btn-red btn-outline"></i></a></td>
						<?php   } ?>
					</tr>
					
					<?php
						
					}
				
				?>
				
				</tbody> 
			</table>
		</div>
			
		<?php
			
			$conn->paginate($table, "addBankETQ.php", $limit, $page);
		}
		
	}
	//List Constructions Request
	function orgConstructionRequests($returnPage,$validationEditCondition,$validationRemoveCondition){
		global $conn;
		global $userId;
		
		$table = "tbl_org_construction_requests";
		$limit = 20;
		$page  = (isset($_GET['page']) ? $page = $conn->safeInput($_GET['page']) : $page = 0);
		$start = ($page ? $start = (($page - 1) * $limit) : $start = 0);
		 
		
		$banksRawSQLQuery    = "SELECT * FROM $table WHERE deleted = 0 ORDER BY id DESC LIMIT $start, $limit";
		$requestConstructionSQLQuery       = $conn->query($banksRawSQLQuery);
		if($requestConstructionSQLQuery->num_rows > 0){
		
		?>
		<div class="table-responsive">
			<table class="table table-bordered table-hover">
				<thead>
					<tr>
						<th class="text-center table-title" colspan="11">
							درخواست های سازمان ها بخاطر تعمیر
						</th>
					</tr>
					<tr class="table-header"> 
						<th class="small text-center">شماره</th>
						<th class="text-center">تاریخ</th>
						<th class="text-center">شماره درخواستی</th>
						<th class="text-center">نام مکتب</th>
						<th class="text-center">نوع درخواست تعمیری</th>
						<th class="text-center">مقدار</th>
						<th class="text-center">فایل</th>
						<th class="text-center">توضیحات</th>
 						<?php if($validationEditCondition == 1 || $validationRemoveCondition == 1){   ?> 
						<th class="small text-center" colspan="2">عملیات</th>
						<?php   } ?>
					</tr> 
				</thead> 
				<tbody> 
				
				<?php
				
					while($row = $requestConstructionSQLQuery->fetch_array()){
						++$counter;
						 
						$rowSchools = $conn->selectRecord ("tbl_schools","id  = ". $row['schools_id']);
						$rowConstructions = $conn->selectRecord ("tbl_constructions_type","id  = ". $row['construction_types_id']);

					?>
					
					<tr id='row-<?php echo $row['id']; ?>'> 
						<td class="small text-center"><?php echo $counter; ?></td>
						<td class='text-center'><?php echo $row['date']; ?></td>
						<td class='text-center'><?php echo $row['request_number']; ?></td>
						<td class='text-center'><?php echo $rowSchools['name']; ?></td>
						<td class='text-center'><?php echo $rowConstructions['name']; ?></td>
						<td class='text-center'><?php echo $row['quantity']; ?></td>
						<td class='text-center'><a href='download.php?name=<?php echo $row['document']; ?>' title="download document" class='glyphicon glyphicon-download'></a></td>
 						<td   class='text-center'><div style="width:100%;max-height:60px;overflow-y:scroll;"> <?php echo $row['description']; ?></div></td>
						<?php if($validationEditCondition == 1){   ?>
						<td class="small text-center"><button title="Edit Records" class="edit_data fa fa-edit btn btn-blue btn-outline" id="<?php   echo $row['id']."+".$table;  ?>"></button></td>
						<?php }if($validationRemoveCondition == 1){ ?>
						<td class="small text-center"><a title="Remove" onclick="verifyRemoveFunction('<?php echo $table;    ?>',<?php echo $row['id']; ?>)"  ><i class="fa fa-times btn btn-red btn-outline"></i></a></td>
						<?php   } ?>
					</tr>
					
					<?php
						
					}
				
				?>
				
				</tbody> 
			</table>
		</div>
			
		<?php
			
			$conn->paginate($table,$returnPage,$limit, $page);
		}
		
	}
	//List Constructions Request
	function supportCeremoniesRequestAT($returnPage,$validationEditCondition,$validationRemoveCondition){
		global $conn;
		global $userId;
		
		$table = "tbl_support_ceremonies_requests";
		$limit = 20;
		$page  = (isset($_GET['page']) ? $page = $conn->safeInput($_GET['page']) : $page = 0);
		$start = ($page ? $start = (($page - 1) * $limit) : $start = 0);
		 
		
		$banksRawSQLQuery    = "SELECT * FROM $table WHERE deleted = 0 ORDER BY id DESC LIMIT $start, $limit";
		$requestConstructionSQLQuery       = $conn->query($banksRawSQLQuery);
		if($requestConstructionSQLQuery->num_rows > 0){
		
		?>
		<div class="table-responsive">
			<table class="table table-bordered table-hover">
				<thead>
					<tr>
						<th class="text-center table-title" colspan="9">
							لیست درخواست های تمویل محافل
						</th>
					</tr>
					<tr class="table-header"> 
						<th class="small text-center">شماره</th>
						<th class="text-center">تاریخ</th>
						<th class="text-center">شماره درخواستی</th>
						<th class="text-center">نام محفل</th>
 						<th class="text-center">مکتب / سازمان</th>
 						<th class="text-center">فایل</th>
 						<th class="text-center">توضیحات</th>
 						<?php if($validationEditCondition == 1 || $validationRemoveCondition == 1){   ?> 
						<th class="small text-center" colspan="2">عملیات</th>
						<?php   } ?>
					</tr> 
				</thead> 
				<tbody> 
				
				<?php
				
					while($row = $requestConstructionSQLQuery->fetch_array()){
						++$counter;
						 
						$rowSchools = $conn->selectRecord ("tbl_schools","id  = ". $row['schools_id']);
						$rowConstructions = $conn->selectRecord ("tbl_constructions_type","id  = ". $row['construction_types_id']);
				?>
					
					<tr id='row-<?php echo $row['id']; ?>'> 
						<td class="small text-center"><?php echo $counter; ?></td>
						<td class='text-center'><?php echo $row['date']; ?></td>
						<td class='text-center'><?php echo $row['request_number']; ?></td>
						<td class='text-center'><?php echo $row['name']; ?></td>
 						<td class='text-center'><?php echo $rowSchools['name']; ?></td>
						<td class='text-center'><a href='download.php?name=<?php echo $row['document']; ?>' title="download document" class='glyphicon glyphicon-download'></a></td>
  						<td   class='text-center'><div style="width:100%;max-height:60px;overflow-y:scroll;"> <?php echo $row['description']; ?></div></td>
						<?php if($validationEditCondition == 1){   ?>
						<td class="small text-center"><button title="Edit Records" class="edit_data fa fa-edit btn btn-blue btn-outline" id="<?php   echo $row['id']."+".$table;  ?>"></button></td>
						<?php }if($validationRemoveCondition == 1){ ?>
						<td class="small text-center"><a title="Remove" onclick="verifyRemoveFunction('<?php echo $table;    ?>',<?php echo $row['id']; ?>)"  ><i class="fa fa-times btn btn-red btn-outline"></i></a></td>
						<?php   } ?>
					</tr>
					
					<?php
						
					}
				
				?>
				
				</tbody> 
			</table>
		</div>
			
		<?php
			
			$conn->paginate($table,$returnPage, $limit, $page);
		}
		
	}
	//Donation Circle List
	function donationsTransactionList($schoolId,$validationEditCondition,$validationRemoveCondition){
		global $conn;
		global $userId;
		
		$table = "tbl_literary_circle_requests";
		$limit = 20;
		$page  = (isset($_GET['page']) ? $page = $conn->safeInput($_GET['page']) : $page = 0);
		$start = ($page ? $start = (($page - 1) * $limit) : $start = 0);
		 
		
		$banksRawSQLQuery    = "SELECT * FROM $table WHERE deleted = 0 AND schools_id = $schoolId ORDER BY id DESC LIMIT $start, $limit";
		$requestConstructionSQLQuery       = $conn->query($banksRawSQLQuery);
		if($requestConstructionSQLQuery->num_rows > 0){
		
		?>
		<div class="table-responsive">
			<table class="table table-bordered table-hover">
				<thead>
					<tr>
						<th class="text-center table-title" colspan="17">
							برنامه های تمویل شده 
						</th>
					</tr>
					<tr class="table-header"> 
						<th class="small text-center">شماره</th>
						<th class="text-center">تاریخ</th>
						<th class="text-center">شماره درخواستی</th>
						<th class="text-center">نام محفل</th>
						<th class="text-center">نوع سازمان</th>
						<th class="text-center">مکتب / سازمان</th>
 						<th class="text-center">فایل</th>
 						<th class="text-center">توضیحات درخواستی</th>
 						<th class="text-center">مقدار</th>
 						<th class="text-center">بانک</th>
 						<th class="text-center">واحد پولی</th>
 						<th class="text-center">نرخ</th>
 						<th class="text-center">توضیحات تمویل</th>
 						<?php if($validationEditCondition == 1 || $validationRemoveCondition == 1){   ?> 
						<th class="small text-center" colspan="2">عملیات</th>
						<?php   } ?>
					</tr> 
				</thead> 
				<tbody> 
				
				<?php
				
					while($row = $requestConstructionSQLQuery->fetch_array()){
						++$counter;
						 
						$rowSchools = $conn->selectRecord ("tbl_schools","id  = ". $row['schools_id']);
						$rowBank = $conn->selectRecord ("tbl_banks","id  = ". $row['banks_id']);
						$rowCurrency = $conn->selectRecord ("tbl_currencies","id  = ". $row['currencies_id']);
						$rowConstructions = $conn->selectRecord ("tbl_constructions_type","id  = ". $row['construction_types_id']);
						if($row['organizations_type'] == 1){
							
							$rowSchools = $conn->selectRecord ("tbl_schools","id  = ". $row['schools_id']);
						
						}elseif($row['organizations_type'] == 2){
							
							$rowSchools = $conn->selectRecord ("tbl_organizations","id  = ". $row['organizations_id']);
						}
					?>
					
					<tr id='row-<?php echo $row['id']; ?>'> 
						<td class="small text-center"><?php echo $counter; ?></td>
						<td class='text-center'><?php echo $row['date']; ?></td>
						<td class='text-center'><?php echo $row['request_number']; ?></td>
						<td class='text-center'><?php echo $row['name']; ?></td>
						<td class='text-center'><?php if($row['organizations_type'] == 1){ echo "مکتب";}else{ echo "سازمان";} ?></td>
						<td class='text-center'><?php echo $rowSchools['name']; ?></td>
						<td class='text-center'><a href='download.php?name=<?php echo $row['document']; ?>' title="download document" class='glyphicon glyphicon-download'></a></td>
  						<td   class='text-center'><div style="width:100%;max-height:60px;overflow-y:scroll;"> <?php echo $row['description']; ?></div></td>
						<td class='text-center'><?php echo $row['amount']; ?></td>
						<td class='text-center'><?php echo $rowBank['amount']; ?></td>
						<td class='text-center'><?php echo $rowCurrency['code']; ?></td>
						<td class='text-center'><?php echo $row['rate']; ?></td>
						<td   class='text-center'><div style="width:100%;max-height:60px;overflow-y:scroll;"> <?php echo $row['donation_description']; ?></div></td>
						<?php if($validationEditCondition == 1){   ?>
						<td class="small text-center"><button title="Edit Records" class="edit_data fa fa-edit btn btn-blue btn-outline" id="<?php   echo $row['id']."+".$table;  ?>"></button></td>
						<?php }if($validationRemoveCondition == 1){ ?>
						<td class="small text-center"><a title="Remove" onclick="verifyRemoveFunction('<?php echo $table;    ?>',<?php echo $row['id']; ?>)"  ><i class="fa fa-times btn btn-red btn-outline"></i></a></td>
						<?php   } ?>
					</tr>
					
					<?php
						
					}
				
				?>
				
				</tbody> 
			</table>
		</div>
			
		<?php
			
			$conn->paginate($table, "constructionsRequestsAT.php", $limit, $page);
		}
		
	}
	//List Bank Categories
	function listBankCategory($validationEditCondition,$validationRemoveCondition){
		global $conn;
		global $userId;
		
		$table = "tbl_banks_category";
		$limit = 30;
		$page  = (isset($_GET['page']) ? $page = $conn->safeInput($_GET['page']) : $page = 0);
		$start = ($page ? $start = (($page - 1) * $limit) : $start = 0);
		 
		
		$expenseCategoriesRawSQLQuery    = "SELECT * FROM $table WHERE  deleted = 0 ORDER BY id DESC LIMIT $start, $limit";
		$expenseCategoriesSQLQuery       = $conn->query($expenseCategoriesRawSQLQuery);
		
		
		if($expenseCategoriesSQLQuery->num_rows > 0){
		
		?>
			
			
		<div class="table-responsive">
			<table class="table table-bordered table-hover">
				<thead>
					<tr>
						<th class="text-center table-title" colspan="4">
							لیست کتگوری بانک ها
						</th>
					</tr>
					<tr class="table-header"> 
						<th class="small text-center">شماره</th>
						<th class='text-center'>نام</th>
						<?php if($validationEditCondition == 1 || $validationRemoveCondition == 1){   ?> 
						<th class="small text-center" colspan="2">عملیات</th>
						<?php   } ?>
					</tr> 
				</thead> 
				<tbody> 
				
				<?php
				
					while($row = $expenseCategoriesSQLQuery->fetch_array()){
						++$counter;
					?>
					
					<tr id='row-<?php echo $row['id']; ?>'> 
						<td class="small text-center "><?php echo $counter; ?></td>
						<td class='text-center'><?php echo $row['name']; ?></td>
						<?php if($validationEditCondition == 1){   ?>
						<td class="small text-center"><button title="Edit Records" class="edit_data fa fa-edit btn btn-blue btn-outline" id="<?php   echo $row['id']."+".$table;  ?>"></button></td>
						<?php }if($validationRemoveCondition == 1){ ?>
						<td class="small text-center"><a title="Remove" onclick="verifyRemoveFunction('<?php echo $table;    ?>',<?php echo $row['id']; ?>)"  ><i class="fa fa-times btn btn-red btn-outline"></i></a></td>
						<?php   } ?>
					</tr>
					
					<?php
						
					}
				
				?>
				
				</tbody> 
			</table>
		</div>
			
		<?php
			
			$conn->paginate($table, "addProjectExpensesACI.php", $limit, $page);
		}
		
	} 
	function listBalanceSheetBanks($fromDate,$toDate,$bankId){
		global $conn;
		global $userId;
		 
		$table = "tbl_bank_statement";
		$limit = 2000;
		$page  = (isset($_GET['page']) ? $page = $conn->safeInput($_GET['page']) : $page = 0);
		$start = ($page ? $start = (($page - 1) * $limit) : $start = 0);
		 
		if($fromDate != 0 && $toDate != 0){
			$bankRawSQL    = "SELECT * FROM $table WHERE  date BETWEEN '$fromDate' AND '$toDate' AND banks_id = $bankId AND deleted = 0 ORDER BY id DESC LIMIT $start, $limit";
			$tableHeader = "Accounts of Bank From : $fromDate Up to  $toDate";
			//find total Rows
		 
			$totalRecordsRawSQL   = $conn->query("SELECT COUNT(*) AS totalRecords FROM $table WHERE  date BETWEEN '$fromDate' AND '$toDate' AND banks_id = $bankId AND deleted = 0 ORDER BY id DESC");
 			$totalRecordsReturned = $totalRecordsRawSQL->fetch_array();
			$totalRecords     = $totalRecordsReturned['totalRecords'];
			
		}else{
			$bankRawSQL    = "SELECT * FROM $table WHERE  deleted = 0 AND banks_id = $bankId ORDER BY id DESC LIMIT $start, $limit";
			//find total Rows
			$totalRecordsRawSQL   = $conn->query("SELECT COUNT(*) AS totalRecords FROM $table WHERE banks_id = $bankId AND deleted = 0 ORDER BY id DESC");
 			$totalRecordsReturned = $totalRecordsRawSQL->fetch_array();
			$totalRecords         = $totalRecordsReturned['totalRecords'];
			
		}
		$bankRawSQLQuery            = $conn->query($bankRawSQL);
		

		if($bankRawSQLQuery->num_rows > 0){
			$rowBank = $conn->selectRecord ("tbl_banks","id  = ". $bankId);
			$rowCurrency = $conn->selectRecord ("tbl_currencies","id  = ". $rowBank['currencies_id']);

		?>
		<div class="table-responsive" id='section-to-print'>
			<table class="table table-bordered table-hover">
				<thead>
					<tr>
						<th class="text-center table-title" colspan="12">
						<?php echo "<span style='font-weight:bold'>".$rowBank['name']."</span>"; echo "<BR>"; if(isset($tableHeader)){echo $tableHeader;}else{ echo "بلانس شیت";}  ?>
 						</th>
					</tr>
					<tr class="table-header"> 
						<th class='text-center'>شماره</th>
						<th class='text-center'>تاریخ</th>
  						<th class='text-center'>مسیر ترانزکش</th>
  						<th class='text-center'>توضیحات</th>
						<th class='text-center'>خروج</th>
						<th class='text-center'>ورود</th>
 						<th class='text-center'>حساب فعلی</th>
 					</tr> 
				</thead> 
				<tbody> 
				
				<?php
					$counter    = 0;
					$total      = 0;
					$recievable = 0;
					$payable    = 0;
					while($row = $bankRawSQLQuery->fetch_array()){
						++$counter;
						$amount = $row['amount'];
						$type   = $row['transaction_type'];
						
						if($type == 2){
							$total -= $amount;
							$payable  += $amount;
						}else if($type == 1){
							$total += $amount;
							$recievable += $amount;
						}	
					?>
					
					<tr> 
						<td class="small text-center"><?php echo $counter; ?></td>
						<td class='text-center'><?php echo $row['date']; ?></td>
						<td class='text-center'><?php echo $row['place']; ?></td>
						<td class='text-center'><?php echo $row['description']; ?></td>
 						<td class='text-center'><?php echo ($type == 2 ? number_format($amount,2) : "") ?></td>
						<td class='text-center'><?php echo ($type == 1 ? number_format($amount,2) : "") ?></td>
						<td class='text-center ' dir='ltr'><?php echo number_format($total,2	); ?></td>
  					</tr>
					
					<?php
					}
					?>
					<tr  style="background-color: #aaa;"> 
 						<td class='text-center' colspan='4'>مجموعه:</td>
						<td class='text-center'><?php echo number_format($payable,2);?></td>
 						<td class='text-center'><?php echo number_format($recievable,2);?></td>
						<td class='text-center'><?php echo number_format($recievable - $payable ,2);  ?><span style="font-weight:bold;color:black"><b> &nbsp;&nbsp;&nbsp;&nbsp;افغانی </b></span></td>
   					</tr> 
				 
				</tbody> 
			</table>
		</div>
			
		<?php
			
			$conn->paginateBank($table, "bankBalanceSheetETQ.php", $limit, $page,$totalRecords);
		}
		
	}
		function listBankTransactionsList($fromDate,$toDate,$bankId){
		global $conn;
		global $userId;
		 
		$table = "tbl_bank_statement";
		$limit = 100000;
		$page  = (isset($_GET['page']) ? $page = $conn->safeInput($_GET['page']) : $page = 0);
		$start = ($page ? $start = (($page - 1) * $limit) : $start = 0);
		 
		if($fromDate != 0 && $toDate != 0){
			$bankRawSQL    = "SELECT * FROM $table WHERE   date BETWEEN '$fromDate' AND '$toDate' AND banks_id = $bankId AND deleted = 0 ORDER BY id DESC LIMIT $start, $limit";
			$bankRawSQLQuery            = $conn->query($bankRawSQL);
			$tableHeader = "Transaction From   : $fromDate Up to  $toDate";
			//Find total rows 
			$totalRecordsRawSQL   = $conn->query("SELECT COUNT(*) AS totalRecords FROM $table WHERE  date BETWEEN '$fromDate' AND '$toDate' AND banks_id = $bankId AND deleted = 0");
 			$totalRecordsReturned = $totalRecordsRawSQL->fetch_array();
			$totalRecords     = $totalRecordsReturned['totalRecords'];
		}else{
			$bankRawSQL    = "SELECT * FROM $table WHERE deleted = 0 AND banks_id = $bankId ORDER BY id DESC LIMIT $start, $limit";
			$bankRawSQLQuery            = $conn->query($bankRawSQL);
			//find total Rows
			$totalRecordsRawSQL   = $conn->query("SELECT COUNT(*) AS totalRecords FROM $table WHERE banks_id = $bankId AND deleted = 0");
 			$totalRecordsReturned = $totalRecordsRawSQL->fetch_array();
			$totalRecords         = $totalRecordsReturned['totalRecords'];
		}
	
		if($bankRawSQLQuery->num_rows > 0){

		?>
		<div class="table-responsive">
			<table class="table table-bordered table-hover">
				<thead>
					<tr>
						<th class="text-center table-title" colspan="12">
						<?php if(isset($tableHeader)){echo $tableHeader;}else{ echo "بلانس شیت بانک";}  ?>
 						</th>
					</tr>
					<tr class="table-header"> 
						<th class='text-center'>شماره</th>
						<th class='text-center'>تاریخ</th>
						<th class='text-center'>بانک</th>
						<th class='text-center'>نوع ترانزکشن</th>
  						<th class='text-center'>مقدار</th>
   						<th class='text-center'>کتگوری</th>
 						<th class='text-center'>سب کتگوری</th>
						<th class='text-center'>مسیر ترانزکشن</th>
 						<th class='text-center'>توضیحات</th>
  					</tr> 
				</thead> 
				<tbody> 
					<?Php
					while($row = $bankRawSQLQuery->fetch_array()){
						++$counter;
						
						$categoryId = $row['categories_id'];
						$subCategoryId = $row['sub_categories_id'];
						 
						if($row['place'] == 'Opening Balance'){
 							
							$targetCategory  = "Opening Balance";
							$targetSubCategory = "";
						 
						}elseif($row['place'] == 'Vendor Payment Bill'){
							
 							$rowTargetCategory  = $conn->selectRecord ("tbl_vendors","id  = ". $categoryId);
							$targetCategory = $rowTargetCategory['name'];
							$targetSubCategory  = "Vendor Payment from Bill";
						 
						}elseif($row['place'] == 'Vendor Payment'){
							 
							$rowTargetCategory  = $conn->selectRecord ("tbl_vendors","id  = ". $categoryId);
							$targetCategory = $rowTargetCategory['name'];
							$targetSubCategory  = "Vendor Payment Transaction";
						 
						}elseif($row['place'] == 'Customer Payment Invoice'){
							
 							$rowTargetCategory  = $conn->selectRecord ("tbl_customers","id  = ". $categoryId);
							$targetCategory = $rowTargetCategory['name'];
							$targetSubCategory  = "Customer Payment from Invoice";
						 
						}elseif($row['place'] == 'Customer Payment'){
							 
							$rowTargetCategory  = $conn->selectRecord ("tbl_customers","id  = ". $categoryId);
							$targetCategory = $rowTargetCategory['name'];
							$targetSubCategory  = "Customer Payment Transaction";
						 
						}elseif($row['place'] == 'Payment to Service Provider'){
							 
							$rowTargetCategory  = $conn->selectRecord ("tbl_service_provider","id  = ". $categoryId);
							$targetCategory = $rowTargetCategory['name'];
							$targetSubCategory  = "Payment to Service Provider";
						 
						}elseif($row['place'] == 'Services Provider Payment'){
							 
							$rowTargetCategory  = $conn->selectRecord ("tbl_service_provider","id  = ". $categoryId);
							$targetCategory = $rowTargetCategory['name'];
							$targetSubCategory  = "Payment to Service Provider";
						 
						}elseif($row['place'] == 'Bank Transaction'){
						 
							$targetCategory  = 'Bank Transaction';
							$targetSubCategory  = "";
						 
						}elseif($row['place'] == 'Bank Transfer'){
							 
							$targetCategory  = 'Bank Transfer Between Account';
							$targetSubCategory  = "";
						 	
						}elseif($row['place'] == 'Office Expenses Transaction'){
							
							$rowTargetCategory  = $conn->selectRecord ("tbl_expense_categories","id  = ". $categoryId);
 							$rowSubTargetCategory  = $conn->selectRecord ("tbl_expense_types","id  = ". $subCategoryId);

							$targetCategory  = $rowTargetCategory['name'];
							$targetSubCategory  = $rowSubTargetCategory['name'];
						 	
						}elseif($row['place'] == 'Incomes Transaction'){
							 
							$rowTargetCategory  = $conn->selectRecord ("tbl_income_categories","id  = ". $categoryId);
 							$rowSubTargetCategory  = $conn->selectRecord ("tbl_income_types","id  = ". $subCategoryId);

							$targetCategory  = $rowTargetCategory['name'];
							$targetSubCategory  = $rowSubTargetCategory['name'];
							
						}elseif($row['place'] == 'Customer Payment Invoice'){
							 
							$rowTargetCategory  = $conn->selectRecord ("tbl_income_categories","id  = ". $categoryId);
 							$rowSubTargetCategory  = $conn->selectRecord ("tbl_income_types","id  = ". $subCategoryId);

							$targetCategory  = $rowTargetCategory['name'];
							$targetSubCategory  = $rowSubTargetCategory['name'];
							
						}
						elseif($row['place'] == 'Dealer Transaction'){
							  
							$rowTargetCategory  = $conn->selectRecord ("tbl_dealers","id  = ". $categoryId);
 
							$targetCategory  = $rowTargetCategory['name'];
							$targetSubCategory  = "Dealer Transaction";
							
						}elseif($row['place'] == 'Procurement Assets'){
							 
							$rowTargetCategory  = $conn->selectRecord ("tbl_asset_types","id  = ". $categoryId);
 
							$targetCategory  = $rowTargetCategory['name'];
							$targetSubCategory  = "Procurement Assets";
							
						}
						$rowCurrency = $conn->selectRecord ("tbl_currencies","id  = ". $row['currencies_id']);
						$transactionType = $row['transaction_type'];
						$rowBank = $conn->selectRecord ("tbl_banks","id  = ". $bankId);

					?>
					
					<tr> 
						<td class="small text-center "><?php echo $counter; ?></td>
						<td class='text-center '><?php echo $row['date']; ?></td>
						<td class='text-center'><?php  echo $rowBank['name']; ?></td>
						<td class='text-center'><?php echo  ($transactionType == 1) ? 'کریدیت' : 'دیبیت'?></td>
   						<td class='text-center '><?php  echo $row['amount']; ?></td>
  						<td class='text-center'><?php  echo $targetCategory ?></td>
 						<td class='text-center '><?php  echo $targetSubCategory ?></td>
 						<td class='text-center '><?php  echo $row['place']; ?></td>
						<td   class='text-center'><div style="width:100%;max-height:60px;overflow-y:scroll;"> <?php echo $row['description']; ?></div></td>
					<tr> 
					<?php
						
					}
					?>
					 
				</tbody> 
			</table>
		</div>
			
		<?php
			
			$conn->paginateBank($table, "bankTransactionReportsETQ.php", $limit, $page,$totalRecords);
		}
		
	}
	function listTransactionBanks($validationEditCondition,$validationRemoveCondition){
		global $conn;
		global $userId;
		
		$table = "tbl_bank_statement";
		$limit = 30;
		$page  = (isset($_GET['page']) ? $page = $conn->safeInput($_GET['page']) : $page = 0);
		$start = ($page ? $start = (($page - 1) * $limit) : $start = 0);
		 
		
		$bankStatementSql    = "SELECT * FROM $table WHERE  deleted = 0 AND place = 'انتقالات بانکی' ORDER BY id DESC LIMIT $start, $limit";
		$bankStatementQuery            = $conn->query($bankStatementSql);
		 
		//find total Rows
		$totalRecordsRawSQL   = $conn->query("SELECT COUNT(*) AS totalRecords FROM $table WHERE place ='انتقالات بانکی' AND deleted = 0 ORDER BY id DESC");
		$totalRecordsReturned = $totalRecordsRawSQL->fetch_array();
		$totalRecords     = $totalRecordsReturned['totalRecords'];
			

		if($bankStatementQuery->num_rows > 0){
		
		?>
		<div class="table-responsive">
			<table class="table table-bordered table-hover">
				<thead>
					<tr>
						<th class="text-center table-title" colspan="12">
						ترانزکشن های بانکی
						</th>
					</tr>
					<tr class="table-header"> 
						<th class='text-center'>شماره</th>
						<th class='text-center'>تاریخ</th>
						<th class='text-center'>بانک</th>
						<th class='text-center'>مسیر ترانزکشن</th>
  						<th class='text-center'>مقدار</th>
   						<th class='text-center'>توضیحات</th>
						<?php if($validationEditCondition == 1 || $validationRemoveCondition == 1){   ?> 
   						<th class="small text-center" colspan="2">عملیات</th>
						<?php   } ?>
					</tr> 
				</thead> 
				<tbody> 
				
				<?php
				
					while($row = $bankStatementQuery->fetch_array()){
						++$counter;
						
					$rowBank = $conn->selectRecord ("tbl_banks","id  = ". $row['banks_id']);
					$rowCurrency = $conn->selectRecord ("tbl_currencies","id  = ". $row['currencies_id']);
					$transactionType = $row['transaction_type'];
				 
					?>
					
					<tr id='row-<?php echo $row['id']; ?>'> 
						<td class="small text-center "><?php echo $counter; ?></td>
						<td class='text-center '><?php echo $row['date']; ?></td>
						<td class='text-center'><?php  echo $rowBank['name']; ?></td>
						<td class='text-center'><?php echo  ($transactionType == 1) ? 'Credit' : 'Debit'?></td>
						<td class='text-center '><?php  echo $row['amount']; ?></td>
						<td   class='text-center'><div style="width:100%;max-height:60px;overflow-y:scroll;"> <?php echo $row['description']; ?></div></td>
						<?php if($validationEditCondition == 1){   ?>
						<td class="small text-center"><button title="Edit Records" class="edit_data fa fa-edit btn btn-blue btn-outline" id="<?php   echo $row['id']."+".$table;  ?>"></button></td>
						<?php }if($validationRemoveCondition == 1){ ?>
						<td class="small text-center"><a title="Remove" onclick="verifyRemoveFunction('<?php echo $table;    ?>',<?php echo $row['id']; ?>)"  ><i class="fa fa-times btn btn-red btn-outline"></i></a></td>
						<?php   } ?>
					</tr>
					
					<?php
						
					}
				?>
				
				</tbody> 
			</table>
		</div>
			
		<?php
			
			$conn->paginateBank($table, "bankTransactionETQ.php", $limit, $page,$totalRecords);
		}
		
	}function listTransferExchangeBanks($validationEditCondition,$validationRemoveCondition){
		global $conn;
		global $userId;
		
		$table = "tbl_bank_exchange";
		$limit = 30;
		$page  = (isset($_GET['page']) ? $page = $conn->safeInput($_GET['page']) : $page = 0);
		$start = ($page ? $start = (($page - 1) * $limit) : $start = 0);
		 
		
		$bankExchangeSql    = "SELECT * FROM $table WHERE deleted = 0 ORDER BY id DESC LIMIT $start, $limit";
		$bankExchangeQuery            = $conn->query($bankExchangeSql);
		

		if($bankExchangeQuery->num_rows > 0){
		
		?>
		<div class="table-responsive">
			<table class="table table-bordered table-hover">
				<thead>
					<tr>
						<th class="text-center table-title" colspan="15">
						انتقالات بین بانکها 
						</th>
					</tr>
					<tr class="table-header"> 
						<th class='text-center'>شماره</th>
						<th class='text-center'>تاریخ</th>
						<th class='text-center'>بانک منبع</th>
  						<th class='text-center'>مقدار انتقالی</th>
 						<th class='text-center'>بانک مقصد</th>
   						<th class='text-center'>توضیحات</th>
 						<?php if($validationEditCondition == 1 || $validationRemoveCondition == 1){   ?> 
   						<th class="small text-center" colspan="2">عملیات</th>
						<?php   } ?>
					</tr> 
				</thead> 
				<tbody> 
				
				<?php
				
					while($row = $bankExchangeQuery->fetch_array()){
						++$counter;
						
					$rowSourceBank = $conn->selectRecord ("tbl_banks","id  = ". $row['source_bank_id']);
					$rowDistinationeBank = $conn->selectRecord ("tbl_banks","id  = ". $row['destination_banks_id']);
 					 
 					?>
					
					<tr id='row-<?php echo $row['id']; ?>'> 
						<td class="small text-center"><?php echo $counter; ?></td>
						<td class='text-center'><?php echo $row['date']; ?></td>
						<td class='text-center'><?php  echo $rowSourceBank['name']; ?></td>
  						<td class='text-center'><?php  echo $row['amount']; ?></td>
 						<td class='text-center'><?php  echo $rowDistinationeBank['name']; ?></td>
						<td   class='text-center'><div style="width:100%;max-height:60px;overflow-y:scroll;"> <?php echo $row['description']; ?></div></td>
 						<?php if($validationEditCondition == 1){   ?>
						<td class="small text-center"><button title="Edit Records" class="edit_data fa fa-edit btn btn-blue btn-outline" id="<?php   echo $row['id']."+".$table;  ?>"></button></td>
 						<?php }if($validationRemoveCondition == 1){ ?>
						<td class="small text-center"><a title="Remove" onclick="verifyRemoveFunction('<?php echo $table;    ?>',<?php echo $row['id']; ?>)"  ><i class="fa fa-times btn btn-red btn-outline"></i></a></td>
						<?php   } ?>
					</tr>
					
					<?php
						
					}
				
				?>
				
				</tbody> 
			</table>
		</div>
			
		<?php
			
			$conn->paginate($table, "bankTransferETQ.php", $limit, $page);
		}
		
	}
	  
	//List All Expense Categories
	function listExpenseCategories($validationEditCondition,$validationRemoveCondition){
		global $conn;
		global $userId;
		
		$table = "tbl_expense_categories";
		$limit = 30;
		$page  = (isset($_GET['page']) ? $page = $conn->safeInput($_GET['page']) : $page = 0);
		$start = ($page ? $start = (($page - 1) * $limit) : $start = 0);
		 
		
		$expenseCategoriesRawSQLQuery    = "SELECT * FROM $table WHERE deleted = 0 ORDER BY id DESC LIMIT $start, $limit";
		$expenseCategoriesSQLQuery       = $conn->query($expenseCategoriesRawSQLQuery);
		
		
		if($expenseCategoriesSQLQuery->num_rows > 0){
		
		?>
			
			
		<div class="table-responsive">
			<table class="table table-bordered table-hover">
				<thead>
					<tr>
						<th class="text-center table-title" colspan="4">
							لیست کتگوری ها 
						</th>
					</tr>
					<tr class="table-header"> 
						<th class="small text-center">شماره</th>
						<th class='text-center'>نام</th>
						<?php if($validationEditCondition == 1 || $validationRemoveCondition == 1){   ?> 
						<th class="small text-center" colspan="2">عملیات</th>
						<?php   } ?>
					</tr> 
				</thead> 
				<tbody> 
				
				<?php
				
					while($row = $expenseCategoriesSQLQuery->fetch_array()){
						++$counter;
					?>
					
					<tr id='row-<?php echo $row['id']; ?>'> 
						<td class="small text-center "><?php echo $counter; ?></td>
						<td class='text-center'><?php echo $row['name']; ?></td>
						<?php if($validationEditCondition == 1){   ?>
						<td class="small text-center"><button title="Edit Records" class="edit_data fa fa-edit btn btn-blue btn-outline" id="<?php   echo $row['id']."+".$table;  ?>"></button></td>
						<?php }if($validationRemoveCondition == 1){ ?>
						<td class="small text-center"><a title="Remove" onclick="verifyRemoveFunction('<?php echo $table;    ?>',<?php echo $row['id']; ?>)"  ><i class="fa fa-times btn btn-red btn-outline"></i></a></td>
						<?php   } ?>
					</tr>
					
					<?php
						
					}
				
				?>
				
				</tbody> 
			</table>
		</div>
			
		<?php
			
			$conn->paginate($table, "addExpenseCategoryETQ.php", $limit, $page);
		}
		
	}
	
	//List All Expense Types
	function listExpenseTypes($returnPage,$validationEditCondition,$validationRemoveCondition){
		global $conn;
		global $userId;
		
		$table = "tbl_expense_types";
		$limit = 30;
		$page  = (isset($_GET['page']) ? $page = $conn->safeInput($_GET['page']) : $page = 0);
		$start = ($page ? $start = (($page - 1) * $limit) : $start = 0);
		 
		
		$expenseTypesRawSQLQuery    = "SELECT * FROM $table WHERE deleted = 0 ORDER BY id DESC LIMIT $start, $limit";
		$expenseTypesSQLQuery       = $conn->query($expenseTypesRawSQLQuery);
		
		
		if($expenseTypesSQLQuery->num_rows > 0){
		
		?>
			
			
		<div class="table-responsive">
			<table class="table table-bordered table-hover">
				<thead>
					<tr>
						<th class="text-center table-title" colspan="5">
							لیست انواع مصارف
						</th>
					</tr>
					<tr class="table-header"> 
						<th class="small text-center">شماره</th>
						<th class='text-center'>کتگوری مصرف</th>
						<th class='text-center'>نوع مصرف</th>
						<?php if($validationEditCondition == 1 || $validationRemoveCondition == 1){   ?> 
						<th class="small text-center" colspan="2">عملیات</th>
						<?php   } ?>
					</tr> 
				</thead> 
				<tbody> 
				
				<?php
				
					while($row = $expenseTypesSQLQuery->fetch_array()){
						++$counter;
						$selectExpenseCategoryDetails = $conn->selectRecord("tbl_expense_categories", "deleted = 0 AND id = " . $row['expense_categories_id']);
					?>
					
					<tr id='row-<?php echo $row['id']; ?>'>  
						<td class="small text-center "><?php echo $counter; ?></td>
						<td class='text-center'><?php echo $selectExpenseCategoryDetails['name']; ?></td>
						<td class='text-center'><?php echo $row['name']; ?></td>
						<?php if($validationEditCondition == 1){   ?>
						<td class="small text-center"><button title="Edit Records" class="edit_data fa fa-edit btn btn-blue btn-outline" id="<?php   echo $row['id']."+".$table;  ?>"></button></td>
						<?php }if($validationRemoveCondition == 1){ ?>
						<td class="small text-center"><a title="Remove" onclick="verifyRemoveFunction('<?php echo $table;    ?>',<?php echo $row['id']; ?>)"  ><i class="fa fa-times btn btn-red btn-outline"></i></a></td>
						<?php   } ?>
					</tr>
					
					<?php
						
					}
				
				?>
				
				</tbody> 
			</table>
		</div>
			
		<?php
			
			$conn->paginate($table, $returnPage, $limit, $page);
		}
		
	}
	
	
	function listExpenses($targetPage,$validationEditCondition,$validationRemoveCondition){
		global $conn;
		global $userId;
		
		$table = "tbl_expenses";
		$limit = 20;
		$page  = (isset($_GET['page']) ? $page = $conn->safeInput($_GET['page']) : $page = 0);
		$start = ($page ? $start = (($page - 1) * $limit) : $start = 0);
		 
		
		$expensesRawSQLQuery    = "SELECT * FROM $table WHERE deleted = 0 ORDER BY id DESC LIMIT $start, $limit";
		$expensesSQLQuery            = $conn->query($expensesRawSQLQuery);
		

		if($expensesSQLQuery->num_rows > 0){
		
		?>
		<div class="table-responsive">
			<table class="table table-bordered table-hover">
				<thead>
					<tr>
						<th class="text-center table-title" colspan="18">
							مصارف 
						</th>
					</tr>
					<tr class="table-header"> 
						<th class='text-center'>شماره</th>
 						<th class='text-center'>یوزر</th>
						<th class='text-center'>تاریخ</th>
						<th class='text-center'>نام کتگوری</th>
						<th class='text-center'>نوع مصرف</th>
 						<th class='text-center'>مقدار</th>
 						<th class='text-center'>بانک</th>
						<th class='text-center'>فاکتور</th>
 						<th class='text-center'>توضیحات</th>
 						<?php if($validationEditCondition == 1 || $validationRemoveCondition == 1){   ?> 
 						<th class="small text-center" colspan="2">عملیات</th>
						<?php   } ?>
					</tr> 
				</thead> 
				<tbody> 
				
				<?php
				
					while($row = $expensesSQLQuery->fetch_array()){
						++$counter;
				
						$rowCurrency = $conn->selectRecord ("tbl_currencies","id  = ". $row['currencies_id']);
						$rowExpenseCategory = $conn->selectRecord ("tbl_expense_categories","id  = ". $row['expense_category_id']);
						$rowExpenseType = $conn->selectRecord ("tbl_expense_types","id  = ". $row['expense_type_id']);
						$rowBank = $conn->selectRecord ("tbl_banks","id  = ". $row['banks_id']	);
						$rowExpenser = $conn->selectRecord ("tbl_staff","id  = ". $row['expensers_id']);
						 
						$selectResponsibleAddition = $conn->query("SELECT * FROM tbl_users WHERE  id = ".$row['users_id']);
	                	$userResponsibleData = $selectResponsibleAddition->fetch_array();
						
					?>
					
					<tr id='row-<?php echo $row['id']; ?>'>  
						<td class="small text-center"><?php echo $counter; ?></td>
 						<td style='width:40px'><b></b></B><?php echo $userResponsibleData['name']." ". $userResponsibleData['family']; ?></b></td>
						<td class='text-center'><?php echo $row['date']; ?></td>
						<td class='text-center'><?php  echo $rowExpenseCategory['name']; ?></td>
						<td class='text-center'><?php  echo $rowExpenseType['name']; ?></td>
 						<td class='text-center'><?php  echo $row['amount']; ?></td>
  						<td class='text-center'><?php  echo $rowBank['name']; ?></td>
 						<td class='text-center'><a href='download.php?name=<?php echo $row['document']; ?>' title="download document" class='glyphicon glyphicon-download'></a></td>
 						<td class='text-center'><div style="width:100%;max-height:60px;overflow-y:scroll;"> <?php echo $row['description']; ?></div></td>
						<?php if($validationEditCondition == 1){   ?>
						<td class="small text-center"><button title="Edit Records" class="edit_data fa fa-edit btn btn-blue btn-outline" id="<?php   echo $row['id']."+".$table;  ?>"></button></td>
					 	<?php }if($validationRemoveCondition == 1){ ?>
						<td class="small text-center"><a title="Remove" onclick="verifyRemoveFunction('<?php echo $table;    ?>',<?php echo $row['id']; ?>)"  ><i class="fa fa-times btn btn-red btn-outline"></i></a></td>
						<?php   } ?>
					</tr>
					
					<?php
						
					}
				
				?>
				
				</tbody> 
			</table>
		</div>
			
		<?php
			
			$conn->paginate($table,$targetPage, $limit, $page);
		}
		
	}
	
	//List All Staff
	function listStaff($validationEditCondition,$validationRemoveCondition){
		global $conn;
		global $userId;
		
		$table = "tbl_staff";
		$limit = 30;
		$page  = (isset($_GET['page']) ? $page = $conn->safeInput($_GET['page']) : $page = 0);
		$start = ($page ? $start = (($page - 1) * $limit) : $start = 0);
		 
		
		$staffRawSQLQuery    = "SELECT * FROM $table WHERE deleted = 0 ORDER BY id DESC LIMIT $start, $limit";
		$staffSQLQuery       = $conn->query($staffRawSQLQuery);
		
		
		if($staffSQLQuery->num_rows > 0){
		
		?>
			
			
		<div class="table-responsive">
			<table class="table table-bordered table-hover">
				<thead>
					<tr>
						<th class="text-center table-title" colspan="10">
							Staff List
						</th>
					</tr>
					<tr class="table-header"> 
						<th class="small text-center">No.</th>
						<th class='text-center'>Name AND Last Name</th>
						<th class='text-center'>Contact</th>
						<th class='text-center'>Opening Balance</th>
						<th class='text-center'>Currency</th>
						<th class='text-center'>Rate</th>
						<th class='text-center'>Address</th>
						<?php if($validationEditCondition == 1 || $validationRemoveCondition == 1){   ?> 
						<th class="small text-center" colspan="2">Operation</th>
						<?php   } ?>
					</tr> 
				</thead> 
				<tbody> 
				
				<?php
				
					while($row = $staffSQLQuery->fetch_array()){
						++$counter;
						$rowCurrency = $conn->selectRecord ("tbl_currencies","id  = ". $row['currencies_id']);

					?>
					
					<tr id='row-<?php echo $row['id']; ?>'>  
						<td class="small text-center "><?php echo $counter; ?></td>
						<td class='text-center'><?php echo $row['name'] . " " . $row['family']; ?></td>
						<td class='text-center '><?php echo $row['contact']; ?></td>
						<td class='text-center '><?php echo $row['opening_balance']; ?></td>
						<td class='text-center'><?php echo $rowCurrency['code']; ?></td>
						<td class='text-center '><?php echo $row['rate']; ?></td>
						<td class='text-center'><?php echo $row['address']; ?></td>
						<?php if($validationEditCondition == 1){   ?>
						<td class="small text-center"><button title="Edit Records" class="edit_data fa fa-edit btn btn-blue btn-outline" id="<?php   echo $row['id']."+".$table;  ?>"></button></td>
						<?php }if($validationRemoveCondition == 1){ ?>
						<td class="small text-center"><a title="Remove" onclick="verifyRemoveFunction('<?php echo $table;    ?>',<?php echo $row['id']; ?>)"  ><i class="fa fa-times btn btn-red btn-outline"></i></a></td>
						<?php   } ?>
					</tr>
					
					<?php
						
					}
				
				?>
				
				</tbody> 
			</table>
		</div>
			
		<?php
			
			$conn->paginate($table, "addStaffETQ.php", $limit, $page);
		}
		
	}
	//List All Dealers
	function listDealers($targetPage,$validationEditCondition,$validationRemoveCondition){
		global $conn;
		global $userId;
		
		$table = "tbl_dealers";
		$limit = 30;
		$page  = (isset($_GET['page']) ? $page = $conn->safeInput($_GET['page']) : $page = 0);
		$start = ($page ? $start = (($page - 1) * $limit) : $start = 0);
		 
		
		$dealersRawSQLQuery    = "SELECT * FROM $table WHERE deleted = 0 ORDER BY id DESC LIMIT $start, $limit";
		$dealersSQLQuery       = $conn->query($dealersRawSQLQuery);
		
		
		if($dealersSQLQuery->num_rows > 0){
		
		?>
		<div class="table-responsive">
			<table class="table table-bordered table-hover">
				<thead>
					<tr>
						<th class="text-center table-title" colspan="10">
							لیست قرض گیرنده ها 
						</th>
					</tr>
					<tr class="table-header"> 
						<th class="small text-center"> شماره </th>
						<th class='text-center'> تاریخ </th>
						<th class='text-center'> نام </th>
 						<th class='text-center'>شماره تماس</th>
 						<th class='text-center'>توضیحات</th>
						<?php if($validationEditCondition == 1 || $validationRemoveCondition == 1){   ?> 
						<th class="small text-center" colspan="2">عملیات</th>
						<?php   } ?>
					</tr> 
				</thead> 
				<tbody> 
				
				<?php
				
					while($row = $dealersSQLQuery->fetch_array()){
					
 						++$counter;
					?>
						<tr id='row-<?php echo $row['id']; ?>'>  
							<td class="small text-center "><?php echo $counter; ?></td>
							<td class='text-center'><?php echo $row['date'];?></td>
							<td class='text-center'><?php echo $row['name'] . " " . $row['family']; ?></td>
							<td class='text-center '><?php echo $row['contact']; ?></td>
 							<td class='text-center'><?php echo $row['address']; ?></td>
							<?php if($validationEditCondition == 1){   ?>
							<td class="small text-center"><button title="Edit Records" class="edit_data fa fa-edit btn btn-blue btn-outline" id="<?php   echo $row['id']."+".$table;  ?>"></button></td>
							<?php }if($validationRemoveCondition == 1){ ?>
							<td class="small text-center"><a title="Remove" onclick="verifyRemoveFunction('<?php echo $table;    ?>',<?php echo $row['id']; ?>)"  ><i class="fa fa-times btn btn-red btn-outline"></i></a></td>
							<?php   } ?>
						</tr>
					<?php
						
					}
				
				?>
				
				</tbody> 
			</table>
		</div>
			
		<?php
			
			$conn->paginate($table, $targetPage, $limit, $page);
		}
		
	}
	
	function listBalanceSheetDealers($fromDate,$toDate,$dealerId){
		global $conn;
		global $userId;
		 
		$table = "tbl_dealer_statement";
		$limit = 30;
		$page  = (isset($_GET['page']) ? $page = $conn->safeInput($_GET['page']) : $page = 0);
		$start = ($page ? $start = (($page - 1) * $limit) : $start = 0);
		 
		if($fromDate != 0 && $toDate != 0){
			$dealerRawSQLQuery    = "SELECT * FROM $table WHERE dealers_id = $dealerId AND date BETWEEN '$fromDate' AND '$toDate' AND deleted = 0 ORDER BY id DESC LIMIT $start, $limit";
			$tableHeader = "Account of Dealer  : $fromDate UP to $toDate";
		}else{
			$dealerRawSQLQuery    = "SELECT * FROM $table WHERE dealers_id = $dealerId  AND deleted = 0 ORDER BY id DESC LIMIT $start, $limit";
		}
		$dealerRawSQLQuery      = $conn->query($dealerRawSQLQuery);
		
		$rowDealer = $conn->selectRecord ("tbl_dealers","id  = ".$dealerId);
		$rowCurrency = $conn->selectRecord ("tbl_currencies","id  = ". $rowDealer['currencies_id']);

		if($dealerRawSQLQuery->num_rows > 0){
		
		?>
		<div class="table-responsive">
			<table class="table table-bordered table-hover">
				<thead>
					<tr>
						<th class="text-center table-title" colspan="12">
						<?php echo "<span style='font-weight:bold'>".$rowDealer["name"]." - ".$rowDealer['family']."</span><br>"; if(isset($tableHeader)){echo $tableHeader;}else{ echo "بلانس دیلر";}  ?>
 						</th>
					</tr>
					<tr class="table-header"> 
						<th class='text-center'>شماره</th>
						<th class='text-center'>تاریخ</th>
						<th class='text-center'>توضیحات</th>
  						<th class='text-center'>نوع ترانزکشن</th>
						<th class='text-center'>کریدت</th>
						<th class='text-center'>دیبت</th>
 						<th class='text-center'>بلانس فعلی</th>
 					</tr> 
				</thead> 
				<tbody> 
				
				<?php
					$counter    = 0;
					$total      = 0;
					$recievable = 0;
					$payable    = 0;
					while($row = $dealerRawSQLQuery->fetch_array()){
						++$counter;
						$amount = $row['amount'];
						$type   = $row['transaction_type'];
						
						if($type == 2){
							$total -= $amount;
							$payable  += $amount;
						}else if($type == 1){
							$total += $amount;
							$recievable += $amount;
						}	

					?>
					
					<tr id='row-<?php echo $row['id']; ?>'> 
						<td class="small text-center "><?php echo $counter; ?></td>
						<td class='text-center '><?php echo $row['date']; ?></td>
						<td class='text-center '><?php echo $row['description']; ?></td>
						<td class='text-center '><?php echo $row['place']; ?></td>
 						<td class='text-center '><?php echo ($type == 2 ? $amount : "") ?></td>
						<td class='text-center '><?php echo ($type == 1 ? $amount : "") ?></td>
						<td class='text-center '><?php echo $total; ?></td>
  					</tr>
					
					<?php
						
					}
					?>
					<tr  style="background-color: #aaa;"> 
 						<td class='text-center ' colspan='4'>مجموعه حسابات</td>
						<td class='text-center '><?php echo number_format($payable,2);?></td>
 						<td class='text-center '><?php echo number_format($recievable,2);?></td>
						<td class='text-center ' dir="ltr">    <?php echo number_format($recievable - $payable,2);  ?>    <span><b><?php  echo "  ".$rowCurrency['code'];   ?></b></span> </td>
   					</tr> 
				 
				</tbody> 
			</table>
		</div>
			
		<?php
			
			$conn->paginate($table, "dealerBalnaceSheetETQ.php", $limit, $page);
		}
		
	}
	function listDealerTransaction($validationEditCondition,$validationRemoveCondition){
		global $conn;
		global $userId;
		
		$table = "tbl_dealer_transaction";
		$limit = 30;
		$page  = (isset($_GET['page']) ? $page = $conn->safeInput($_GET['page']) : $page = 0);
		$start = ($page ? $start = (($page - 1) * $limit) : $start = 0);
		 
		
		$dealerRawSQLQuery    = "SELECT * FROM $table WHERE deleted = 0 ORDER BY id DESC LIMIT $start, $limit";
		$dealerSQLQuery            = $conn->query($dealerRawSQLQuery);
		

		if($dealerSQLQuery->num_rows > 0){
		
		?>
		<div class="table-responsive">
			<table class="table table-bordered table-hover">
				<thead>
					<tr>
						<th class="text-center table-title" colspan="13">
							ترانزکش های دیلر	
						</th>
					</tr>
					<tr class="table-header"> 
						<th class='text-center'>شماره</th>
						<th class='text-center'>تاریخ</th>
 						<th class='text-center'>تاریخ ختم</th>
 						<th class='text-center'>نام دیلر</th>
						<th class='text-center'>نوع ترانزکش</th>
 						<th class='text-center'>مقدار</th>
 						<th class='text-center'>بانک</th>
 						<th class='text-center'>توضیحات</th>
						<?php if($validationEditCondition == 1 || $validationRemoveCondition == 1){   ?> 
  						<th class="small text-center" colspan="2">عملیات</th>
						<?php   } ?>
					</tr> 
				</thead> 
				<tbody> 
				
				<?php
				
					while($row = $dealerSQLQuery->fetch_array()){
						++$counter;
						
  					$rowBank = $conn->selectRecord ("tbl_banks","id  = ". $row['banks_id']	);
					$rowDealers = $conn->selectRecord ("tbl_dealers","id  = ". $row['dealers_id']);
					$type = $row['type'];
					if($type == '1'){
						$textType = 'کریدت';
					}elseif($type == '2'){
						$textType = 'دیبت';
					}
					
					?>
					
					<tr id='row-<?php echo $row['id']; ?>'> 
						<td class="small text-center "><?php echo $counter; ?></td>
						<td class='text-center '><?php echo $row['date']; ?></td>
						<td class='text-center '><?php echo $row['due_date']; ?></td>
						<td class='text-center '><?php echo $rowDealers['name']." ". $rowDealers['family']; ?></td>
						<td class='text-center '><?php  echo $textType; ?></td>
 						<td class='text-center '><?php  echo $row['amount']; ?></td>
 						<td class='text-center'><?php  echo $rowBank['name']; ?></td>
 						<td   class='text-center'><div style="width:100%;max-height:60px;overflow-y:scroll;"> <?php echo $row['description']; ?></div></td>
						<?php if($validationEditCondition == 1){   ?>
						<td class="small text-center"><button title="Edit Records" class="edit_data fa fa-edit btn btn-blue btn-outline" id="<?php   echo $row['id']."+".$table;  ?>"></button></td>
 						<?php }if($validationRemoveCondition == 1){ ?>
						<td class="small text-center"><a title="Remove" onclick="verifyRemoveFunction('<?php echo $table;    ?>',<?php echo $row['id']; ?>)"  ><i class="fa fa-times btn btn-red btn-outline"></i></a></td>
						<?php   } ?>
					</tr>
					
					<?php
						
					}
				
				?>
				
				</tbody> 
			</table>
		</div>
			
		<?php
			
			$conn->paginate($table, "dealerPaymentETQ.php", $limit, $page);
		}
		
	}
	function listBackup($validationEditCondition,$validationRemoveCondition){
		global $conn;
		global $userId;
		
		$table = "tbl_backup";
		$limit = 30;
		$page  = (isset($_GET['page']) ? $page = $conn->safeInput($_GET['page']) : $page = 0);
		$start = ($page ? $start = (($page - 1) * $limit) : $start = 0);
		 
		
		$backupData    = "SELECT * FROM $table WHERE  deleted = 0  AND verified = 1 ORDER BY id DESC LIMIT $start, $limit";
		$bakcupDataQuery            = $conn->query($backupData);
		

		if($bakcupDataQuery->num_rows > 0){
		
		?>
		<div class="table-responsive">
			<table class="table table-bordered table-hover">
				<thead>
					<tr>
						<th class="text-center table-title" colspan="12">
								Backup Data List	
						</th>
					</tr>
					<tr class="table-header"> 
						<th class='text-center'>NO.</th>
 						<th class='text-center'>Name</th>
 						<th class='text-center'>Download</th>
 						<?php if($validationEditCondition == 1 || $validationRemoveCondition == 1){   ?> 
   						<th class="small text-center" colspan="2">Operation</th>
						<?php   } ?>
					</tr> 
				</thead> 
				<tbody> 
				
				<?php
				
					while($row = $bakcupDataQuery->fetch_array()){
						++$counter;
					 
					?>
					
					<tr id='row-<?php echo $row['id']; ?>'> 
						<td class="small text-center "><?php echo $counter; ?></td>
						<td class='text-center '><?php echo $row['name']; ?></td>
  						<td class='text-center'><a href='download.php?name=../backup/<?php echo $row['name']; ?>' title="download document" class='glyphicon glyphicon-download'></a></td>
 						 <?php  if($validationRemoveCondition == 1){ ?>
						<td class="small text-center"><a title="Remove" onclick="verifyRemoveFunction('<?php echo $table;    ?>',<?php echo $row['id']; ?>)"  ><i class="fa fa-times btn btn-red btn-outline"></i></a></td>
						<?php   } ?>
					</tr>
					
					<?php
						
					}
				
				?>
				
				</tbody> 
			</table>
		</div>
			
		<?php
			
			$conn->paginate($table, "vendorPaymentETQ.php", $limit, $page);
		}
		
	}
	//List All Activity
	function listPosition($validationEditCondition,$validationRemoveCondition){
		global $conn;
		global $userId;
		
		$table = "tbl_positions";
		$limit = 30;
		$page  = (isset($_GET['page']) ? $page = $conn->safeInput($_GET['page']) : $page = 0);
		$start = ($page ? $start = (($page - 1) * $limit) : $start = 0);
		 
		
		$selectDate    = "SELECT * FROM $table WHERE  deleted = 0 ORDER BY id DESC LIMIT $start, $limit";
		$selectDataQueryRow            = $conn->query($selectDate);	
		if($selectDataQueryRow->num_rows > 0){
	
		?>
		<div class="table-responsive">
			<table class="table table-bordered table-hover">
				<thead>
					<tr>
						<th class="text-center table-title" colspan="9">
							List of Position's Name
						</th>
					</tr>
					<tr class="table-header"> 
						<th class="small text-center">No.</th>
						<th class='text-center'>Name</th>
 						<th class='text-center'>Description</th>
						<?php if($validationEditCondition == 1 || $validationRemoveCondition == 1){   ?> 
						<th class="small text-center" colspan="2">Operations</th>
						<?php   } ?>
					</tr> 
				</thead> 
				<tbody> 
				
				<?php
				
					while($row = $selectDataQueryRow->fetch_array()){
						++$counter;
 					 
					?>
					<tr id='row-<?php echo $row['id']; ?>'> 
						<td class="small text-center "><?php echo $counter; ?></td>
 						<td class='text-center'><?php echo $row['name']; ?></td>
 						<td class='text-center'><div style="width:100%;max-height:70px;overflow-y:scroll;"> <?php echo $row['description']; ?></div></td>
						<?php if($validationEditCondition == 1){   ?>
						<td class="small text-center"><a title="Edit" href="editPositionAT.php?id=<?php echo encryptIt($row['id']); ?>"><i class="fa fa-edit btn btn-blue btn-outline"></i></a></td>
						<?php }if($validationRemoveCondition == 1){ ?>
						<td class="small text-center"><a title="Remove" onclick="verifyRemoveFunction('<?php echo $table;    ?>',<?php echo $row['id']; ?>)"  ><i class="fa fa-times btn btn-red btn-outline"></i></a></td>
						<?php   } ?>
					</tr>
					
					<?php
						
					}
				
				?>
				
				</tbody> 
			</table>
		</div>
			
		<?php
			
			$conn->paginate($table, "addPositionAT.php", $limit, $page);
		}
		
	}//List All Discussion
	 
		function interfaceList($returnPage,$validationEditCondition,$validationRemoveCondition){
		global $conn;
		global $userId;
		
		$table = "tbl_interface";
		$limit = 10;
		$page  = (isset($_GET['page']) ? $page = $conn->safeInput($_GET['page']) : $page = 0);
		$start = ($page ? $start = (($page - 1) * $limit) : $start = 0);
		 
		
		$tableSql    = "SELECT * FROM $table WHERE  deleted = 0  ORDER BY id DESC LIMIT $start, $limit";
		$tableQuery            = $conn->query($tableSql);
		
		
		if($tableQuery->num_rows > 0){
		
		?>
		<div class="table-responsive">
			<table class="table table-bordered table-hover">
				<thead>
					<tr>
						<th class="text-center table-title" colspan="10">
							لیست های بخش بندی
						</th>
					</tr>
					<tr class="table-header"> 
						<th class="small text-center">شماره</th>
 						<th class='text-center'>نام</th>
  						<?php if($validationEditCondition == 1 || $validationRemoveCondition == 1){   ?> 
  						<th class="small text-center" colspan="2">عملیات</th>
						<?php   } ?>
					</tr> 
				</thead> 
				<tbody> 
				
				<?php
				
					while($row = $tableQuery->fetch_array()){
						++$counter;
  					?>
					
					<tr id='row-<?php echo $row['id']; ?>'> 
						<td class="small text-center "><?php echo $counter; ?></td>
 						<td class='text-center'><?php echo $row['name']; ?></td>
 						<?php if($validationEditCondition == 1){   ?>
						<td class="small text-center"><button title="Edit Records" class="edit_data fa fa-edit btn btn-blue btn-outline" id="<?php   echo $row['id']."+".$table;  ?>"></button></td>
						<?php }if($validationRemoveCondition == 1){ ?>
						<td class="small text-center"><a title="Remove" onclick="verifyRemoveFunction('<?php echo $table;    ?>',<?php echo $row['id']; ?>)"  ><i class="fa fa-times btn btn-red btn-outline"></i></a></td>
						<?php } ?>
					</tr>
					
					<?php
						
					}
				
				?>
				
				</tbody> 
			</table>
		</div>
			
		<?php
			$conn->paginate($table,$returnPage, $limit, $page);
		}
	}
	
		function educationDegree($returnPage,$validationEditCondition,$validationRemoveCondition){
		global $conn;
		global $userId;
		
		$table = "tbl_degree";
		$limit = 10;
		$page  = (isset($_GET['page']) ? $page = $conn->safeInput($_GET['page']) : $page = 0);
		$start = ($page ? $start = (($page - 1) * $limit) : $start = 0);
		 
		
		$tableSql    = "SELECT * FROM $table WHERE  deleted = 0  ORDER BY id DESC LIMIT $start, $limit";
		$tableQuery            = $conn->query($tableSql);
		
		
		if($tableQuery->num_rows > 0){
		
		?>
		<div class="table-responsive">
			<table class="table table-bordered table-hover">
				<thead>
					<tr>
						<th class="text-center table-title" colspan="10">
							رشته های تحصیلی
						</th>
					</tr>
					<tr class="table-header"> 
						<th class="small text-center">شماره</th>
 						<th class='text-center'>نام</th>
  						<?php if($validationEditCondition == 1 || $validationRemoveCondition == 1){   ?> 
  						<th class="small text-center" colspan="2">عملیات</th>
						<?php   } ?>
					</tr> 
				</thead> 
				<tbody> 
				
				<?php
				
					while($row = $tableQuery->fetch_array()){
						++$counter;
  					?>
					
					<tr id='row-<?php echo $row['id']; ?>'> 
						<td class="small text-center "><?php echo $counter; ?></td>
 						<td class='text-center'><?php echo $row['name']; ?></td>
 						<?php if($validationEditCondition == 1){   ?>
						<td class="small text-center"><button title="Edit Records" class="edit_data fa fa-edit btn btn-blue btn-outline" id="<?php   echo $row['id']."+".$table;  ?>"></button></td>
						<?php }if($validationRemoveCondition == 1){ ?>
						<td class="small text-center"><a title="Remove" onclick="verifyRemoveFunction('<?php echo $table;    ?>',<?php echo $row['id']; ?>)"  ><i class="fa fa-times btn btn-red btn-outline"></i></a></td>
						<?php } ?>
					</tr>
					
					<?php
						
					}
				
				?>
				
				</tbody> 
			</table>
		</div>
			
		<?php
			$conn->paginate($table,$returnPage, $limit, $page);
		}
	}
	
	function recipientsList($returnPage,$validationEditCondition,$validationRemoveCondition){
		global $conn;
		global $userId;
		
		$table = "tbl_recipients";
		$limit = 10;
		$page  = (isset($_GET['page']) ? $page = $conn->safeInput($_GET['page']) : $page = 0);
		$start = ($page ? $start = (($page - 1) * $limit) : $start = 0);
		 
		
		$tableSql    = "SELECT * FROM $table WHERE  deleted = 0  ORDER BY id DESC LIMIT $start, $limit";
		$tableQuery            = $conn->query($tableSql);
		
		
		if($tableQuery->num_rows > 0){
		
		?>
		<div class="table-responsive">
			<table class="table table-bordered table-hover">
				<thead>
					<tr>
						<th class="text-center table-title" colspan="11">
							لیست کمک گیرنده گان
						</th>
					</tr>
					<tr class="table-header"> 
						<th class="small text-center">شماره</th>
						<th class='text-center'>تاریخ</th>
						<th class='text-center'>نام</th>
 						<th class='text-center'>شماره تماس</th>
						<th class='text-center'>مرتبط به</th>
						<th class='text-center'>درجه تحصیل</th>
						<th class='text-center'>جنسیت</th>
						<th class='text-center'>درجه فقر</th>
 						<th class='text-center'>آدرس</th>
						<?php if($validationEditCondition == 1 || $validationRemoveCondition == 1){   ?> 
  						<th class="small text-center" colspan="2">عملیات</th>
						<?php   } ?>
					</tr> 
				</thead> 
				<tbody> 
				
				<?php
				
					while($row = $tableQuery->fetch_array()){
						++$counter;
 						$rowInterface    = $conn->selectRecord("tbl_interface", "id = " . $row['interface_id']);
 						$rowDegree    = $conn->selectRecord("tbl_degree", "id = " . $row['degree_id']);
						echo $row['poverty_degree'];
						
					?>
					
					<tr id='row-<?php echo $row['id']; ?>'> 
						<td class="small text-center "><?php echo $counter; ?></td>
						<td class='text-center'><?php echo $row['date']; ?></td>
						<td class='text-center'><?php echo $row['name']; ?></td>
 						<td class='text-center'><?php echo $row['contact']; ?></td>
						<td class='text-center'><?php echo $rowInterface['name']; ?></td>
						<td class='text-center'><?php echo $rowDegree['name']; ?></td>
						<td class='text-center'><?php if($row['gender']==1){ echo "مذکر";}elseif($row['gender']==2){echo "مؤنث";}?></td>
						<td class='text-center'><?php if($row['poverty_degree']==1){ echo "شدید";}elseif($row['poverty_degree']==2){echo "متوسط";}elseif($row['poverty_degree']==3){echo "خوب";}?></td>
 						<td class='text-center'><?php echo $row['address']; ?></td>
						<?php if($validationEditCondition == 1){   ?>
						<td class="small text-center"><button title="Edit Records" class="edit_data fa fa-edit btn btn-blue btn-outline" id="<?php   echo $row['id']."+".$table;  ?>"></button></td>
						<?php }if($validationRemoveCondition == 1){ ?>
						<td class="small text-center"><a title="Remove" onclick="verifyRemoveFunction('<?php echo $table;    ?>',<?php echo $row['id']; ?>)"  ><i class="fa fa-times btn btn-red btn-outline"></i></a></td>
						<?php } ?>
					</tr>
					
					<?php
						
					}
				
				?>
				
				</tbody> 
			</table>
		</div>
			
		<?php
			$conn->paginate($table,$returnPage, $limit, $page);
		}
	}
	
	function districtsTable2($returnPage,$validationEditCondition,$validationRemoveCondition){
		global $conn;
		global $userId;
		
		$table = "h_tbl_districts";
		$limit = 10;
		$page  = (isset($_GET['page']) ? $page = $conn->safeInput($_GET['page']) : $page = 0);
		$start = ($page ? $start = (($page - 1) * $limit) : $start = 0);
		 
		
		$tableSql    = "SELECT * FROM $table WHERE  deleted = 0  ORDER BY id DESC LIMIT $start, $limit";
		$tableQuery            = $conn->query($tableSql);
		
		
		if($tableQuery->num_rows > 0){
		
		?>
		<div class="table-responsive">
			<table class="table table-bordered table-hover">
				<thead>
					<tr>
						<th class="text-center table-title" colspan="10">
							لیست ولسوالی /ناحیه ها
						</th>
					</tr>
					<tr class="table-header"> 
						<th class="small text-center">شماره</th>
 						<th class='text-center'>نام</th>
 						<?php if($validationEditCondition == 1 || $validationRemoveCondition == 1){   ?> 
  						<th class="small text-center" colspan="2">Operation</th>
						<?php   } ?>
					</tr> 
				</thead> 
				<tbody> 
				
				<?php
				
					while($row = $tableQuery->fetch_array()){
						++$counter;
  					?>
					
					<tr id='row-<?php echo $row['id']; ?>'> 
						<td class="small text-center "><?php echo $counter; ?></td>
 						<td class='text-center'><?php echo $row['name']; ?></td>
 						<?php if($validationEditCondition == 1){   ?>
						<td class="small text-center"><button title="Edit Records" class="edit_data fa fa-edit btn btn-blue btn-outline" id="<?php   echo $row['id']."+".$table;  ?>"></button></td>
						<?php }if($validationRemoveCondition == 1){ ?>
						<td class="small text-center"><a title="Remove" onclick="verifyRemoveFunction('<?php echo $table;    ?>',<?php echo $row['id']; ?>)"  ><i class="fa fa-times btn btn-red btn-outline"></i></a></td>
						<?php } ?>
					</tr>
					
					<?php
						
					}
				
				?>
				
				</tbody> 
			</table>
		</div>
			
		<?php
			$conn->paginate($table,$returnPage, $limit, $page);
		}
	}
	
		function listHelpingAT($returnPage,$validationEditCondition,$validationRemoveCondition){
		global $conn;
		global $userId;
		
		$table = "h_tbl_helps_transactions";
		$limit = 10;
		$page  = (isset($_GET['page']) ? $page = $conn->safeInput($_GET['page']) : $page = 0);
		$start = ($page ? $start = (($page - 1) * $limit) : $start = 0);
		 
		
		$tableSql    = "SELECT * FROM $table WHERE  deleted = 0  ORDER BY id DESC LIMIT $start, $limit";
		$tableQuery            = $conn->query($tableSql);
		
		
		if($tableQuery->num_rows > 0){
		
		?>
		<div class="table-responsive">
			<table class="table table-bordered table-hover">
				<thead>
					<tr>
						<th class="text-center table-title" colspan="13">
							لیست مستحقین
						</th>
					</tr>
					<tr class="table-header"> 
						<th class="small text-center">شماره</th>
						<th class='text-center'>تاریخ</th>
						<th class='text-center'>نام</th>
						<th class='text-center'>نام پدر</th>
						<th class='text-center'>شماره تذکره</th>
						<th class='text-center'>شماره تماس</th>
						<th class='text-center'>ناحیه / ولسوالی</th>
						<th class='text-center'>فرد رابط</th>
						<th class='text-center'>توضیحات</th>
						<th class='text-center'>اضافه شده توسط</th>
						<th class='text-center'>توضیح شده توسط</th>
						<?php if($validationEditCondition == 1 || $validationRemoveCondition == 1){   ?> 
  						<th class="small text-center" colspan="2">عملیات</th>
						<?php   } ?>
					</tr> 
				</thead> 
				<tbody> 
				
				<?php
				
					while($row = $tableQuery->fetch_array()){
						++$counter;
 						$rowDistricts    = $conn->selectRecord("h_tbl_districts", "id = " . $row['districts_id']);
 						$rowStaffs    = $conn->selectRecord("h_tbl_staff_managers", "id = " . $row['staffs_id']);
						$userEntry = $conn->selectRecord("tbl_users", "id = " . $row['users_id']);
						$userDsitributed = $conn->selectRecord("tbl_users", "id = " . $row['distributed_id']);
					?>
					
					<tr id='row-<?php echo $row['id']; ?>'> 
						<td class="small text-center "><?php echo $counter; ?></td>
						<td class='text-center'><?php echo $row['date']; ?></td>
						<td class='text-center'><?php echo $row['name']; ?></td>
						<td class='text-center'><?php echo $row['father']; ?></td>
						<td class='text-center'><?php echo $row['SSN']; ?></td>
						<td class='text-center'><?php echo $row['contact']; ?></td>
						<td class='text-center'><?php echo $rowDistricts['name']; ?></td>
						<td class='text-center'><?php echo $rowStaffs['name']; ?></td>
						<td class='text-center'><?php echo $row['description']; ?></td>
						<td class='text-center'><?php echo $userEntry['name']." ".$userEntry['family']; ?></td>
						<td class='text-center'><?php echo $userDsitributed['name']." ".$userDsitributed['family']; ?></td>
 						<?php if($validationEditCondition == 1){   ?>
						<td class="small text-center"><button title="Edit Records" class="edit_data fa fa-edit btn btn-blue btn-outline" id="<?php   echo $row['id']."+".$table;  ?>"></button></td>
						<?php }if($validationRemoveCondition == 1){ ?>
						<td class="small text-center"><a title="Remove" onclick="verifyRemoveFunction('<?php echo $table;    ?>',<?php echo $row['id']; ?>)"  ><i class="fa fa-times btn btn-red btn-outline"></i></a></td>
						<?php } ?>
					</tr>
					
					<?php
						
					}
				
				?>
				
				</tbody> 
			</table>
		</div>
			
		<?php
			$conn->paginate($table,$returnPage, $limit, $page);
		}
	}
		
		function listHelpingATStatu0($returnPage,$validationEditCondition,$validationRemoveCondition){
		global $conn;
		global $userId;
		
		$table = "h_tbl_helps_transactions";
		$limit = 10;
		$page  = (isset($_GET['page']) ? $page = $conn->safeInput($_GET['page']) : $page = 0);
		$start = ($page ? $start = (($page - 1) * $limit) : $start = 0);
		 
		
		$tableSql    = "SELECT * FROM $table WHERE  deleted = 0 AND status = 0 ORDER BY id DESC LIMIT $start, $limit";
		$tableQuery            = $conn->query($tableSql);
		
		
		if($tableQuery->num_rows > 0){
		
		?>
		<div class="table-responsive">
			<table class="table table-bordered table-hover">
				<thead>
					<tr>
						<th class="text-center table-title" colspan="11">
							لیست مستحقین
						</th>
					</tr>
					<tr class="table-header"> 
						<th class="small text-center">شماره</th>
						<th class='text-center'>تاریخ</th>
						<th class='text-center'>نام</th>
						<th class='text-center'>نام پدر</th>
						<th class='text-center'>شماره تذکره</th>
						<th class='text-center'>شماره تماس</th>
						<th class='text-center'>ناحیه / ولسوالی</th>
						<th class='text-center'>فرد رابط</th>
						<th class='text-center'>توضیحات</th>
						<th class='text-center'>اضافه شده توسط</th>
						<?php if($validationEditCondition == 1 || $validationRemoveCondition == 1){   ?> 
  						<th class="small text-center" colspan="2">Operation</th>
						<?php   } ?>
					</tr> 
				</thead> 
				<tbody> 
				
				<?php
				
					while($row = $tableQuery->fetch_array()){
						++$counter;
 						$rowDistricts    = $conn->selectRecord("h_tbl_districts", "id = " . $row['districts_id']);
 						$rowStaffs    = $conn->selectRecord("h_tbl_staff_managers", "id = " . $row['staffs_id']);
						$userEntry = $conn->selectRecord("tbl_users", "id = " . $row['users_id']);
 					?>
					
					<tr id='row-<?php echo $row['id']; ?>'> 
						<td class="small text-center "><?php echo $counter; ?></td>
						<td class='text-center'><?php echo $row['date']; ?></td>
						<td class='text-center'><?php echo $row['name']; ?></td>
						<td class='text-center'><?php echo $row['father']; ?></td>
						<td class='text-center'><?php echo $row['SSN']; ?></td>
						<td class='text-center'><?php echo $row['contact']; ?></td>
						<td class='text-center'><?php echo $rowDistricts['name']; ?></td>
						<td class='text-center'><?php echo $rowStaffs['name']; ?></td>
						<td class='text-center'><?php echo $row['description']; ?></td>
						<td class='text-center'><?php echo $userEntry['name']." ".$userEntry['family']; ?></td>

 						<?php if($validationEditCondition == 1){   ?>
						<td class="small text-center"><button title="Edit Records" class="edit_data fa fa-edit btn btn-blue btn-outline" id="<?php   echo $row['id']."+".$table;  ?>"></button></td>
						<?php }if($validationRemoveCondition == 1){ ?>
						<td class="small text-center"><a title="Remove" onclick="verifyRemoveFunction('<?php echo $table;    ?>',<?php echo $row['id']; ?>)"  ><i class="fa fa-times btn btn-red btn-outline"></i></a></td>
						<?php } ?>
					</tr>
					
					<?php
						
					}
				
				?>
				
				</tbody> 
			</table>
		</div>
			
		<?php
			$conn->paginate($table,$returnPage, $limit, $page);
		}
	}
			
		function listHelpingATStatus1($returnPage,$validationEditCondition,$validationRemoveCondition){
		global $conn;
		global $userId;
		
		$table = "h_tbl_helps_transactions";
		$limit = 10;
		$page  = (isset($_GET['page']) ? $page = $conn->safeInput($_GET['page']) : $page = 0);
		$start = ($page ? $start = (($page - 1) * $limit) : $start = 0);
		 
		
		$tableSql    = "SELECT * FROM $table WHERE  deleted = 0 AND status = 1 ORDER BY id DESC LIMIT $start, $limit";
		$tableQuery            = $conn->query($tableSql);
		
		
		if($tableQuery->num_rows > 0){
		
		?>
		<div class="table-responsive">
			<table class="table table-bordered table-hover">
				<thead>
					<tr>
						<th class="text-center table-title" colspan="11">
							لیست مستحقین
						</th>
					</tr>
					<tr class="table-header"> 
						<th class="small text-center">شماره</th>
						<th class='text-center'>تاریخ</th>
						<th class='text-center'>نام</th>
						<th class='text-center'>نام پدر</th>
						<th class='text-center'>شماره تذکره</th>
						<th class='text-center'>شماره تماس</th>
						<th class='text-center'>ناحیه / ولسوالی</th>
						<th class='text-center'>فرد رابط</th>
						<th class='text-center'>توضیحات</th>
						<th class='text-center'>اضافه شده توسط</th>
						<th class='text-center'>توزیع کننده کمک</th>
						<?php if($validationEditCondition == 1 || $validationRemoveCondition == 1){   ?> 
  						<th class="small text-center" colspan="2">Operation</th>
						<?php   } ?>
					</tr> 
				</thead> 
				<tbody> 
				
				<?php
				
					while($row = $tableQuery->fetch_array()){
						++$counter;
 						$rowDistricts    = $conn->selectRecord("h_tbl_districts", "id = " . $row['districts_id']);
 						$rowStaffs    = $conn->selectRecord("h_tbl_staff_managers", "id = " . $row['staffs_id']);
						$userEntry = $conn->selectRecord("tbl_users", "id = " . $row['users_id']);
						$userDsitributed = $conn->selectRecord("tbl_users", "id = " . $row['distributed_id']);
					?>
					
					<tr id='row-<?php echo $row['id']; ?>'> 
						<td class="small text-center "><?php echo $counter; ?></td>
						<td class='text-center'><?php echo $row['date']; ?></td>
						<td class='text-center'><?php echo $row['name']; ?></td>
						<td class='text-center'><?php echo $row['father']; ?></td>
						<td class='text-center'><?php echo $row['SSN']; ?></td>
						<td class='text-center'><?php echo $row['contact']; ?></td>
						<td class='text-center'><?php echo $rowDistricts['name']; ?></td>
						<td class='text-center'><?php echo $rowStaffs['name']; ?></td>
						<td class='text-center'><?php echo $row['description']; ?></td>
						<td class='text-center'><?php echo $userEntry['name']." ".$userEntry['family']; ?></td>
						<td class='text-center'><?php echo $userDsitributed['name']." ".$userDsitributed['family']; ?></td>
 						<?php if($validationEditCondition == 1){   ?>
						<td class="small text-center"><button title="Edit Records" class="edit_data fa fa-edit btn btn-blue btn-outline" id="<?php   echo $row['id']."+".$table;  ?>"></button></td>
						<?php }if($validationRemoveCondition == 1){ ?>
						<td class="small text-center"><a title="Remove" onclick="verifyRemoveFunction('<?php echo $table;    ?>',<?php echo $row['id']; ?>)"  ><i class="fa fa-times btn btn-red btn-outline"></i></a></td>
						<?php } ?>
					</tr>
					
					<?php
						
					}
				
				?>
				
				</tbody> 
			</table>
		</div>
			
		<?php
			$conn->paginate($table,$returnPage, $limit, $page);
		}
	}
		function poorTable($poorId){
		global $conn;
		global $userId;
		
		$table = "h_tbl_helps_transactions";
		$limit = 10;
		$page  = (isset($_GET['page']) ? $page = $conn->safeInput($_GET['page']) : $page = 0);
		$start = ($page ? $start = (($page - 1) * $limit) : $start = 0);
		 
		
		$tableSql    = "SELECT * FROM $table WHERE  deleted = 0 AND  id = $poorId ORDER BY id DESC LIMIT $start, $limit";
		$tableQuery            = $conn->query($tableSql);
		
		
		if($tableQuery->num_rows > 0){
		
		?>
		<div class="table-responsive">
			<table class="table table-bordered table-hover">
				<thead>
					<tr>
						<th class="text-center table-title" colspan="11">
							فرد مورد نظر 
						</th>
					</tr>
					<tr class="table-header"> 
						<th class="small text-center">شماره</th>
						<th class='text-center'>تاریخ</th>
						<th class='text-center'>نام</th>
						<th class='text-center'>نام پدر</th>
						<th class='text-center'>شماره تذکره</th>
						<th class='text-center'>شماره تماس</th>
						<th class='text-center'>ناحیه / ولسوالی</th>
						<th class='text-center'>فرد رابط</th>
						<th class='text-center'>توضیحات</th>
						<th class='text-center'>عملیات</th>
						 
					</tr> 
				</thead> 
				<tbody> 
				
				<?php
				
					while($row = $tableQuery->fetch_array()){
						++$counter;
 						$rowDistricts    = $conn->selectRecord("h_tbl_districts", "id = " . $row['districts_id']);
 						$rowStaffs    = $conn->selectRecord("h_tbl_staff_managers", "id = " . $row['staffs_id']);
					?>
					
					<tr id='row-<?php echo $row['id']; ?>'> 
						<td class="small text-center "><?php echo $counter; ?></td>
						<td class='text-center'><?php echo $row['date']; ?></td>
						<td class='text-center'><?php echo $row['name']; ?></td>
						<td class='text-center'><?php echo $row['father']; ?></td>
						<td class='text-center'><?php echo $row['SSN']; ?></td>
						<td class='text-center'><?php echo $row['contact']; ?></td>
						<td class='text-center'><?php echo $rowDistricts['name']; ?></td>
						<td class='text-center'><?php echo $rowStaffs['name']; ?></td>
						<td class='text-center'><?php echo $row['description']; ?></td>
						<td class='text-center'>
 						<?php 
 							if($row['status'] == 0){
						?>
						 
							 
							<input type="checkbox" name="movementStatus" class="form-control"  value="1" onclick="changeType('h_tbl_helps_transactions',this.value,<?php echo $row['id'];  ?>)" >

						<?php
							}else{
						?>
						 
							<input type="checkbox" checked class="form-control" >

	
						<?php
							}
						?>
						</td>
 						
					</tr>
					
					<?php
						
					}
				
				?>
				
				</tbody> 
			</table>
		</div>
			
		<?php
			$conn->paginate($table,$returnPage, $limit, $page);
		}
	}
	
	