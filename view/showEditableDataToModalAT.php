 <?php 
	session_start();
 	require_once("../config/Database.php");
	require_once("../config/necessaryFunctions.php");
	$conn->query("SET NAMES 'utf8'");
	$conn->query('SET CHARACTER SET utf8');
	$userId = decryptIt($_SESSION['userId']);
	require_once("../config/pdate.php");

	$genralId = $_POST['edit_data_id'];
 		$exploadeData = explode("+",$genralId);
		$id = $exploadeData[0];
		$table = $exploadeData[1];
 	 
	?>
	<style>
	.modal-form{
		text-align:center !important; 
	}
	</style>
	<?php
	if($table == "tbl_item_categories"){
		$itemsRow = $conn->query("SELECT * FROM `$table` WHERE deleted = 0 AND id = $id ORDER BY id DESC");
		$row = $itemsRow->fetch_array();
				
				$id   = $row['id'];
				$name = $row['name'];
		?>
			<input name="table" value="<?php echo encryptIt($table); ?>" type="hidden"  />
			<input name="id" value="<?php echo encryptIt($id); ?>" type="hidden"  />
			<div class="form-group"> 
				<label class="col-sm-2  modal-form control-label" for="name">کتگوری کالا</label> 
				<div class="col-sm-9"> 
					<input type="text" placeholder="کتگوری کالا" autocomplete="off" id="name" name="name" value="<?php  echo $name;  ?>" class="form-control">
					<p class="help-block"></p>
				 </div> 
			</div> 
			 
		<?php
	//tbl_item_units
	}elseif($table == "tbl_item_units"){
		$itemsRow = $conn->query("SELECT * FROM `$table` WHERE deleted = 0 AND id = $id ORDER BY id DESC");
		$row = $itemsRow->fetch_array();
				
				$id   = $row['id'];
				$name = $row['name'];
		?>
			<input name="table" value="<?php echo encryptIt($table); ?>" type="hidden"  />
			<input name="id" value="<?php echo encryptIt($id); ?>" type="hidden"  />
			<div class="form-group"> 
				<label class="col-sm-2  modal-form control-label" for="name">واحد کالا</label> 
				<div class="col-sm-9"> 
					<input type="text" placeholder="واحد کالا" autocomplete="off" id="name" name="name" value="<?php  echo $name;  ?>" class="form-control">
					<p class="help-block"></p>
				 </div> 
			</div> 
		 
		<?php
		//tbl_items
		}elseif($table == "tbl_items"){
			
		$itemsRow = $conn->query("SELECT * FROM `$table` WHERE deleted = 0 AND id = $id ORDER BY id DESC");
		$row = $itemsRow->fetch_array();
		extract($row);		
  		?>
			<input name="table" value="<?php echo encryptIt($table); ?>" type="hidden"  />
			<input name="id" value="<?php echo encryptIt($id); ?>" type="hidden"  />
			<input name="oldAmount" value="<?php echo encryptIt($opening_balance); ?>" type="hidden"  />
			<input name="oldInventory" value="<?php echo encryptIt($stocks_id); ?>" type="hidden"  />
			<div class="form-group"> 
				<label class="col-sm-2  modal-form control-label" control-label"  for="data">تاریخ</label> 
				<div class="col-sm-9"> 
					<input type="text" placeholder="تاریخ"  autocomplete="off" onchange="checkDate(this.value)"  data-select='datepicker' value="<?php  echo $row['date'];  ?>" name="date" required class="form-control">
					<p class="help-block"></p>
				 </div> 
			</div>
							
			<div class="form-group"> 
				<label class="col-sm-2  modal-form control-label" for="name">کالا</label> 
				<div class="col-sm-9"> 
					<input type="text" placeholder="کالا" autocomplete="off" id="name" name="name" value="<?php  echo $row['name'];  ?>" required class="form-control">
					<p class="help-block"></p>
				 </div> 
			</div> 
			<div class="form-group"> 
				<label class="col-sm-2  modal-form control-label" for="itemUnit">واحد کالا</label> 
				<div class="col-sm-9"> 
				<div id="itemUnitDiv">
					<select id="itemUnit" name="itemUnit" autocomplete="off" required class="select2 form-control">
						<option value="">انتخاب واحد</option>
						<?php
							$itemUnitRow= $conn->query("SELECT * FROM `tbl_item_units` WHERE deleted = 0 ORDER BY id DESC");
							while($row = $itemUnitRow->fetch_array()){
								
								$id   = $row['id'];
								$name = $row['name'];
								if($id == $item_units_id){
									echo "<option  value='$id' selected>$name</option>";
								}else{
									echo "<option  value='$id'>$name</option>";
								}
							}   
						?>
					</select>
				</div>
					<p class="help-block"></p>
				 </div> 
			</div>
			<div class="form-group"> 
				<label class="col-sm-2  modal-form control-label" for="itemCategory">کتگوری کالا</label> 
				<div class="col-sm-9">
				<div  id="itemCategoryDiv" >				
					<select id="itemCategory" name="itemCategory" autocomplete="off" required class="form-control select2">
						<option value="">انتخاب کتگوری کالا</option>
						<?php
							 
							$itemCategoryRow= $conn->query("SELECT * FROM `tbl_item_categories` WHERE deleted = 0 ORDER BY id DESC");
							while($row = $itemCategoryRow->fetch_array()){
							
								$id   = $row['id'];
								$name = $row['name'];
								if($id == 	$item_categories_id){
									echo "<option  value='$id' selected>$name</option>";
								}else{
									echo "<option  value='$id'>$name</option>";
								}
					 
							}   
						
						?>
					</select>
				</div>
					<p class="help-block"></p>
				 </div> 
			</div>	
			<div class="form-group"> 
				<label class="col-sm-2  modal-form control-label" for="openingBalance">حساب افتتاحیه</label> 
				<div class="col-sm-9"> 
					<input type="text" placeholder="حساب افتتاحیه" autocomplete="off" value="<?php echo $opening_balance  ?>"  onKeyPress="return isNumericKey(event)"  id="openingBalance" name="openingBalance" class="form-control">
					<p class="help-block"></p>
				 </div> 
			</div> 
 			<div class="form-group"> 
				<label class="col-sm-2  modal-form control-label" for="itemCategory">گدام</label> 
				<div class="col-sm-9"> 
					<div id="stockIdDiv">
						<select id="stockId" name="stockId" autocomplete="off" required class="select2 form-control">
							<option value="">انتخاب گدام </option>
							<?php
								 
								$stockRow= $conn->query("SELECT * FROM `tbl_stocks` WHERE deleted = 0 ORDER BY id DESC");
								while($row = $stockRow->fetch_array()){
									
									$id   = $row['id'];
									$name = $row['name'];
									if($id == $stocks_id){
										echo "<option  value='$id' selected>$name</option>";
									}else{
										echo "<option  value='$id'>$name</option>";
									}
								}   
							
							?>
						</select>
					</div>
					<p class="help-block"></p>
				 </div> 
			</div>	
			 
			<div class="form-group"> 
				<label class="col-sm-2  modal-form control-label" for="description">Description</label> 
				<div class="col-sm-9"> 
					<textarea    placeholder = 'Description' autocomplete="off" name='description' name='description' class='form-control'><?php echo $description;   ?></textarea>
					<p class="help-block"></p>
				 </div> 
			</div> 
 			 
 		
 			
		<?php
		}elseif($table == "tbl_stocks"){
			
			$itemsRow = $conn->query("SELECT * FROM `$table` WHERE deleted = 0 AND id = $id ORDER BY id DESC");
			$row = $itemsRow->fetch_array();
			extract($row);		
  		?>
			<input name="table" value="<?php echo encryptIt($table); ?>" type="hidden"  />
			<input name="id" value="<?php echo encryptIt($id); ?>" type="hidden"  />
 			<div class="form-group"> 
				<label class="col-sm-2  modal-form control-label" for="name">گدام</label> 
				<div class="col-sm-10"> 
					<input type="text" placeholder="گدام" autocomplete="off" required id="name" value="<?php echo $name;  ?>" name="name" class="form-control">
					<p class="help-block"></p>
				 </div> 
			</div> 
			 
			<div class="form-group"> 
				<label class="col-sm-2  modal-form control-label" for="description">توضیحات</label> 
				<div class="col-sm-10"> 
					<textarea    placeholder = 'توضیحات' autocomplete="off" name='description' name='description' class='form-control'><?php echo $description;   ?></textarea>
					<p class="help-block"></p>
				 </div> 
			</div> 
		<?php
		}elseif($table == "tbl_stock_transaction"){
			
			$itemsRow = $conn->query("SELECT * FROM `$table` WHERE deleted = 0 AND id = $id ORDER BY id DESC");
			$row = $itemsRow->fetch_array();
			extract($row);		
			?>
			<input name="table" value="<?php echo encryptIt($table); ?>" type="hidden"  />
			<input name="id" value="<?php echo encryptIt($id); ?>" type="hidden"  />
			
 			<input name="sourceStockId" value="<?php echo encryptIt($source_stocks_id); ?>" type="hidden"  />
			<input name="destinationStockId" value="<?php echo encryptIt($destination_stocks_id); ?>" type="hidden"  />
			<input name="oldAmount" value="<?php echo encryptIt($transfer_amount); ?>" type="hidden"  />
			<input name="oldItemId" value="<?php echo encryptIt($items_id); ?>" type="hidden"  />
			
 			<div class="form-group"> 
				<label class="col-sm-2  modal-form control-label" for="date">تاریخ</label> 
				<div class="col-sm-10"> 
					<input type="text" placeholder="تاریخ" autocomplete="off" id="btn_move" name="date"  onchange="checkDate(this.value)"  value="<?php   echo $date; ?>" class="form-control">
					<p class="help-block"></p>
				 </div> 
			</div>
			<div class="form-group"> 
				<label class="col-sm-2  modal-form control-label" for="itemCategory">گدام منبع</label> 
				<div class="col-sm-10"> 
					<select id="sourceStocksId" name="sourceStocksId" onchange="readStockAmount(this.value, itemsId.value)" autocomplete="off" class="select2 form-control">
						<option value="">انتخاب گدام منبع</option>
						<?php
							 
							$stockRow= $conn->query("SELECT * FROM `tbl_stocks` WHERE deleted = 0 ORDER BY id DESC");
							while($row = $stockRow->fetch_array()){
								
								$id   = $row['id'];
								$name = $row['name'];
								if($id == $source_stocks_id){
									echo "<option  value='$id' selected>$name</option>";
								}else{
									echo "<option  value='$id'>$name</option>";
								}
							}   
						
						?>
					</select>
					<p class="help-block"></p>
				 </div> 
			</div>
			<div class="form-group"> 
				<label class="col-sm-2  modal-form control-label" for="itemCategory">کالا</label> 
				<div class="col-sm-10"> 
						<select id="itemsId" name="itemsId" autocomplete="off" class="select2 form-control">
						<option value="">انتخاب کالا</option>
						<?php
							 
						$selectItem = $conn->query("SELECT * FROM `tbl_items` WHERE deleted = 0 ORDER BY id DESC");
							while($row = $selectItem->fetch_array()){
								
								$id   = $row['id'];
								$itemName = $row['name'];
								if($id == $items_id){
									echo "<option  value='$id' selected>".$row['name']."</option>";
								}else{
									echo "<option  value='$id'>".$row['name']."</option>";
								}
							} 
						
						?>
					</select>
					<p class="help-block"></p>
 				 </div> 
			</div>				
			 <div class="form-group"> 
				<label class="col-sm-2  modal-form control-label" for="transferAmount">مقدار قابل انتقال</label> 
				<div class="col-sm-10"> 
					<input type="text" placeholder="مقدار قابل انتقال" autocomplete="off" id="transferAmount" value="<?php  echo 	$transfer_amount;  ?>" onKeyPress="return isNumericKey(event)"  name="transferAmount" class="form-control">
					<p class="help-block"></p>
				 </div> 
			</div> 
			<div class="form-group"> 
				<label class="col-sm-2  modal-form control-label" for="itemCategory">گدام مقصد</label> 
				<div class="col-sm-10"> 
					<select id="destinationStocksId" name="destinationStocksId" autocomplete="off" onchange="readDestanitionStock(this.value,itemsId.value)" class="select2 form-control">
							<option value="">گدام مقصد</option>
							<?php
								$sourceStock = $conn->query("SELECT * FROM `tbl_stocks` WHERE deleted = 0 ORDER BY id DESC");
								while($row = $sourceStock->fetch_array()){
									
									$id   = $row['id'];
									$name = $row['name'];
									$default = $row['default'];
									if($destination_stocks_id == $id){
										echo "<option  value='$id' selected>$name</option>";
									}else{
										echo "<option  value='$id'>$name</option>";
									}
								}   
							?>
						</select>
					<p class="help-block"></p>
				 </div> 
			</div>
			<div class="form-group"> 
				<label class="col-sm-2  modal-form control-label" for="description">توضیحات</label> 
				<div class="col-sm-10"> 
					<textarea    placeholder = 'توضیحات' autocomplete="off" name='description' name='description' class='form-control'><?php echo $description;   ?></textarea>
					<p class="help-block"></p>
				 </div> 
			</div> 
		<?php
		}elseif($table == "tbl_vendor_categories"){
				$dataRow = $conn->query("SELECT * FROM `$table` WHERE deleted = 0 AND id = $id ORDER BY id DESC");
				$row = $dataRow->fetch_array();
						
				$id   = $row['id'];
				$name = $row['name'];
		?> 
			<input name="table" value="<?php echo encryptIt($table); ?>" type="hidden"  />
			<input name="id" value="<?php echo encryptIt($id); ?>" type="hidden"  />
			<div class="form-group"> 
				<label class="col-sm-2  modal-form control-label" for="name">کتگوری</label> 
				<div class="col-sm-9"> 
						<input type="text" placeholder="کتگوری" autocomplete="off" id="name" name="name" value="<?php  echo $name;	?>" class="form-control">
					<p class="help-block"></p>
				 </div> 
			</div> 
		 
		<?php
		//tbl_items
		}elseif($table == "tbl_schools"){
				$dataRow = $conn->query("SELECT * FROM `$table` WHERE deleted = 0 AND id = $id ORDER BY id DESC");
				$row = $dataRow->fetch_array();
				extract($row);		
				 
		?> 
			<input name="table" value="<?php echo encryptIt($table); ?>" type="hidden"  />
			<input name="id" value="<?php echo encryptIt($id); ?>" type="hidden"  />
			<div class="form-group"> 
				<label class="col-sm-2  modal-form control-label" for="name">تاریخ</label> 
				<div class="col-sm-9"> 
						<input type="text" placeholder="تاریخ" autocomplete="off" id="date" name="date"  onchange="checkDate(this.value)"  value="<?php  echo $date;	?>" class="form-control">
					<p class="help-block"></p>
				 </div> 
			</div> 
			<div class="form-group"> 
				<label class="col-sm-2  modal-form control-label" for="name">نام مکتب</label> 
				<div class="col-sm-9"> 
						<input type="text" placeholder="نام مکتب" autocomplete="off" id="name" name="name" value="<?php  echo $name;	?>" class="form-control">
					<p class="help-block"></p>
				 </div> 
			</div> 	
			<div class="form-group"> 
				<label class="col-sm-2  modal-form control-label" for="name">نام مدیر</label> 
				<div class="col-sm-9"> 
					<input type="text" placeholder="نام مدیر" autocomplete="off" id="managerId" name="managerId" value="<?php  echo $manager_name;	?>"  class="form-control">
					<p class="help-block"></p>
				 </div> 
			</div> 
			<div class="form-group"> 
				<label class="col-sm-2  modal-form control-label" for="name">شماره تماس</label> 
				<div class="col-sm-9"> 
					<input type="text" placeholder="شماره تماس" autocomplete="off" id="contact" name="contact" value="<?php  echo $contact;	?>"  class="form-control">
					<p class="help-block"></p>
				 </div> 
			</div> 
			<div class="form-group"> 
				<label class="col-sm-2  modal-form control-label" for="districtId">ولسوالی / ناحیه</label> 
				<div class="col-sm-9"> 
					<select class="select2 form-control" name='districtId' autocomplete="off">
						<option value="">انتخاب ولسوالی / ناحیه</option>
						<?php
						 
						$categoryRow= $conn->query("SELECT * FROM `tbl_districts` WHERE deleted = 0 ORDER BY id DESC");
						While($row = $categoryRow->fetch_array()){
								$id = $row['id'];
								$name = $row['name'];
								if($id == $districts_id){
									echo "<option value='$id' selected>$name</option>";
								}else{
									echo "<option value='$id'>$name</option>";

								}
						}   
										
						?>
					</select>
					<p class="help-block"></p>
				 </div> 
			</div>
			<div class="form-group"> 
				<label class="col-sm-2  modal-form control-label" for="schoolGender">نوع مکتب</label> 
				<div class="col-sm-9"> 
						<select class="select2 form-control" name='schoolGender' autocomplete="off" id='schoolGender'>
							<option Value="">نوع مکتب</option>
							<option value="1" <?php if($school_type == 1){echo "selected";}   ?> >اناث</option>
							<option value="2" <?php if($school_type == 2){echo "selected";}   ?> >ذکور</option>
							<option value="3" <?php if($school_type == 3){echo "selected";}   ?> >ذکور و اناث</option>
						</select>
					<p class="help-block"></p>
				 </div> 
			</div> 
		 
			<div class="form-group"> 
				<label class="col-sm-2  modal-form control-label" for="name"> مجموعه شاگردان  </label> 
				<div class="col-sm-9"> 
						<input type="text" placeholder="مجموعه شاگردان " autocomplete="off" id="totalStudent" name="totalStudent"  onKeyPress="return isNumericKey(event)"  value="<?php  echo $total_students;   ?>" class="form-control">
					<p class="help-block"></p>
				 </div> 
			</div> 
		 
			
			<div class="form-group"> 
				<label class="col-sm-2  modal-form control-label" for="address">آدرس</label> 
				<div class="col-sm-9"> 
						<textarea    placeholder = 'آدرس' autocomplete="off" id='address' name='address' class='form-control'><?php  echo $address;	?></textarea>
					<p class="help-block"></p>
				 </div> 
			</div> 
			
		 
		<?php
		//tbl_items
		}elseif($table == "tbl_schools_requests_equipments_details"){
				$dataRow = $conn->query("SELECT * FROM `$table` WHERE deleted = 0 AND id = $id ORDER BY id DESC");
				$row = $dataRow->fetch_array();
				extract($row);		
				$rowItems    = $conn->selectRecord("tbl_items", "id = " . $row['items_id']);
				$rowItemUnits    = $conn->selectRecord("tbl_item_units", "id = " . $row['items_unit_id']);

		?> 
			<input name="table" value="<?php echo encryptIt($table); ?>" type="hidden"  />
			<input name="id" value="<?php echo encryptIt($id); ?>" type="hidden"  />
			
			 
			<div class="form-group"> 
				<label class="col-sm-2  modal-form control-label" for="name">تاریخ توزیع</label> 
				<div class="col-sm-9"> 
						<input type="text" placeholder="تاریخ" autocomplete="off" id="distributionDate" name="distributionDate"  onchange="checkDate(this.value)"  value="<?php  echo pdate('Y-m-d');	?>" class="form-control">
					<p class="help-block"></p>
				 </div> 
			</div> 
			<div class="form-group"> 
				<label class="col-sm-2  modal-form control-label" for="name">مقدار توزیع</label> 
				<div class="col-sm-9"> 
					<input type="text" placeholder="مقدار توزیع" autocomplete="off" id="distributionQuantity" name="distributionQuantity" value="<?php  echo $quantity;	?>"  class="form-control">
					<p class="help-block"></p>
				 </div> 
			</div> 
		 	   
			<div class="form-group"> 
				<label class="col-sm-2  modal-form control-label" for="address">توضیحات توزیع</label> 
				<div class="col-sm-9"> 
						<textarea    placeholder = 'توضیحات توزیع' autocomplete="off" id='distDescription' name='distDescription' class='form-control'><?php  echo $address;	?></textarea>
					<p class="help-block"></p>
				 </div> 
			</div> 
		<?php
		//tbl_vendors
		}elseif($table == "tbl_vendors"){
				$dataRow = $conn->query("SELECT * FROM `$table` WHERE deleted = 0 AND id = $id ORDER BY id DESC");
				$row = $dataRow->fetch_array();
				extract($row);		
				 
		?> 
			<input name="table" value="<?php echo encryptIt($table); ?>" type="hidden"  />
			<input name="id" value="<?php echo encryptIt($id); ?>" type="hidden"  />
			<div class="form-group"> 
				<label class="col-sm-2  modal-form control-label" for="name">تاریخ</label> 
				<div class="col-sm-9"> 
						<input type="text" placeholder="تاریخ" autocomplete="off" id="date" name="date"  onchange="checkDate(this.value)"  value="<?php  echo $date;	?>" class="form-control">
					<p class="help-block"></p>
				 </div> 
			</div> 
			<div class="form-group"> 
				<label class="col-sm-2  modal-form control-label" for="name">نام</label> 
				<div class="col-sm-9"> 
						<input type="text" placeholder="نام" autocomplete="off" id="name" name="name" value="<?php  echo $name;	?>" class="form-control">
					<p class="help-block"></p>
				 </div> 
			</div> 
			<div class="form-group"> 
				<label class="col-sm-2  modal-form control-label" for="vendorType"></label> 
				<div class="col-sm-9"> 
					<select class="select2 form-control" name='vendorType' autocomplete="off">
						<option value="">Select Vendor</option>
						<?php
						 
						$vendorCategoryRow= $conn->query("SELECT * FROM `tbl_vendor_categories` WHERE deleted = 0 ORDER BY id DESC");
						while($row = $vendorCategoryRow->fetch_array()){
							
							$id   = $row['id'];
							$name = $row['name'];
							if($id == $vendor_type){
								echo "<option value='$id' selected>$name</option>";
							}else{
								echo "<option value='$id'>$name</option>";
							}
						}   
					
						?>
					</select>
					<p class="help-block"></p>
				 </div> 
			</div>
			<div class="form-group"> 
				<label class="col-sm-2  modal-form control-label" for="name">Contact / Email</label> 
				<div class="col-sm-9"> 
						<input type="text" placeholder="Contact / Email" autocomplete="off" id="contact" name="contact" value="<?php  echo $contact;	?>" class="form-control">
					<p class="help-block"></p>
				 </div> 
			</div> 
			
			<div class="form-group"> 
				<label class="col-sm-2  modal-form control-label" for="currenciesId">Currency</label> 
				<div class="col-sm-9"> 
					<select class="select2 form-control" name='currenciesId'   onchange="readCurrencyRate(this.value),selectBanks(this.value)"  autocomplete="off" id='currenciesId'>
						<option value="">Select Currency</option>
						<?php
						 
						$currenciesRow= $conn->query("SELECT * FROM `tbl_currencies` WHERE  deleted = 0 ORDER BY id DESC");
						while($row = $currenciesRow->fetch_array()){
							
							$id   = $row['id'];
							$name = $row['code'];
							if($id == $currencies_id){
								echo "<option value='$id' selected>$name</option>";
							}else{
								echo "<option value='$id'>$name</option>";
							}
				 
						}   
					
						?>
					</select>
					<p class="help-block"></p>
				 </div> 
			</div>
			<div class="form-group"> 
				<label class="col-sm-2  modal-form control-label" for="name">Opening Balance</label> 
				<div class="col-sm-9"> 
						<input type="text" placeholder="Opening Balance" autocomplete="off" id="openingBalance" name="openingBalance"  onKeyPress="return isNumericKey(event)"  value="<?php  echo $opening_balance;   ?>" class="form-control">
					<p class="help-block"></p>
				 </div> 
			</div> 
			<div class="form-group"> 
				<label class="col-sm-2  modal-form control-label" for="rate">Rate</label> 
				<div class="col-sm-9"> 
						<input type="text" placeholder="Rate" autocomplete="off" id="rate" name="rate" value="<?php  echo $rate;  ?>" onKeyPress="return isNumericKey(event)"  class="form-control">
					<p class="help-block"></p>
				 </div> 
			</div> 
			
		 <div class="form-group"> 
				<label class="col-sm-2  modal-form control-label" for="address">Address</label> 
				<div class="col-sm-9"> 
						<textarea    placeholder = 'Address' autocomplete="off" id='address' name='address' class='form-control'><?php  echo $address;	?></textarea>
					<p class="help-block"></p>
				 </div> 
			</div> 
			
		 
		<?php
		//tbl_items
		}elseif($table == "tbl_vendor_payment"){
				$dataRow = $conn->query("SELECT * FROM `$table` WHERE deleted = 0 AND id = $id ORDER BY id DESC");
				$row = $dataRow->fetch_array();
				
				extract($row);
				 
				 
		?> 
			<input name="table" value="<?php echo encryptIt($table); ?>" type="hidden"  />
			<input name="id" value="<?php echo encryptIt($id); ?>" type="hidden"  />
			<div class="form-group"> 
				<label class="col-sm-2  modal-form control-label" for="name">Date</label> 
				<div class="col-sm-9"> 
						<input type="text" placeholder="Date" autocomplete="off" id="date" name="date"  onchange="checkDate(this.value)"  value="<?php  echo $date;	?>" class="form-control">
					<p class="help-block"></p>
				 </div> 
			</div> 
			
			<div class="form-group">  
				<label class="col-sm-2  modal-form control-label" for="bankId">Vendor Name</label> 
				<div class="col-sm-9"> 
						<select class="select2 form-control" name='vendorId' onchange = "selectVendorCurrency(this.value)" autocomplete="off" id='vendorId'>
							<option Value="">Select Vendor</option>
							<?php
							 
							$vendorRow= $conn->query("SELECT * FROM `tbl_vendors` WHERE deleted = 0 ORDER BY id DESC");
							while($row = $vendorRow->fetch_array()){
								
								$id   = $row['id'];
								$name = $row['name'];
								if($id == $vendors_id){
									echo "<option value='$id' selected>$name</option>";
								}else{
									echo "<option value='$id'>$name</option>";
								}
					 
							}   
						
							?>
						</select>
						<p class="help-block"></p>
				 </div> 
			</div>
			<div class="form-group"> 
				<label class="col-sm-2  modal-form control-label" for="bankId">Currency</label> 
				<div class="col-sm-9"> 
					<select class="select2 form-control" name='currenciesId' id='currenciesId'  onchange="readCurrencyRate(this.value),selectBanks(this.value);"  autocomplete="off">
						<option Value="">Select Currency</option>
						   <?php			 
											 
							$currenciesRow= $conn->query("SELECT * FROM `tbl_currencies` WHERE id = $currencies_id AND deleted = 0 ORDER BY id DESC");
							while($row = $currenciesRow->fetch_array()){
								
								$id   = $row['id'];
								$name = $row['code'];

								echo "<option value='$id' selected>$name</option>";
								
  							}   
						
						?>
					</select>
					<p class="help-block"></p>
				 </div> 
			</div>
			<div class="form-group"> 
				<label class="col-sm-2  modal-form control-label" for="name">Amount</label> 
				<div class="col-sm-9"> 
						<input type="text" placeholder="Amount" autocomplete="off" id="amount" name="amount" onKeyPress="return isNumericKey(event)"  value="<?php  echo $amount;	?>" class="form-control">
					<p class="help-block"></p>
				 </div> 
			</div> 
			<div class="form-group"> 
				<label class="col-lg-2 col-md-2 col-sm-4   control-label" for="bankId">Bank</label> 
				<div class="col-sm-9"> 
					<select class="select2 form-control" name='bankId' autocomplete="off" id='bankId'>
						<option Value="">Select Bank</option>
						<?php
					   
						$bankRow= $conn->query( "SELECT * FROM `tbl_banks` WHERE currencies_id = '$currencies_id' AND deleted = 0");
						While($row = $bankRow->fetch_array()){
									$id = $row['id'];
									$name = $row['name'];
								if($id == $banks_id){
									echo "<option   value='$id' selected>$name</option>";
								}else{
									echo "<option   value='$id'>$name</option>";
								}
						}   
					 
						?>
					</select>
					<p class="help-block"></p>
 				 </div> 
			</div>
			  
			<div class="form-group"> 
				<label class="col-sm-2  modal-form control-label" for="rate">Rate</label> 
				<div class="col-sm-9"> 
						<input type="text" placeholder="Rate" autocomplete="off" id="rate" name="rate" onKeyPress="return isNumericKey(event)"  value="<?php  echo $rate;  ?>" class="form-control">
					<p class="help-block"></p>
				 </div> 
			</div> 
			
		 <div class="form-group"> 
				<label class="col-sm-2  modal-form control-label" for="Description">Description</label> 
				<div class="col-sm-9"> 
						<textarea    placeholder = 'Description' autocomplete="off" id='description' name='description' class='form-control'><?php  echo $description;	?></textarea>
					<p class="help-block"></p>
				 </div> 
			</div> 
			
		 
		<?php
 		}elseif($table == "tbl_customer_categories"){
				$dataRow = $conn->query("SELECT * FROM `$table` WHERE deleted = 0 AND id = $id ORDER BY id DESC");
				$row = $dataRow->fetch_array();
						
				$id   = $row['id'];
				$name = $row['name'];
		?> 
			<input name="table" value="<?php echo encryptIt($table); ?>" type="hidden"  />
			<input name="id" value="<?php echo encryptIt($id); ?>" type="hidden"  />
			<div class="form-group"> 
				<label class="col-sm-2  modal-form control-label" for="name">Customer Type</label> 
				<div class="col-sm-9"> 
						<input type="text" placeholder="Customer Type" autocomplete="off" id="name" name="name" value="<?php  echo $name;	?>" class="form-control">
					<p class="help-block"></p>
				 </div> 
			</div> 
		 
		<?php
		//tbl_items
		}elseif($table == "tbl_customers"){
				$dataRow = $conn->query("SELECT * FROM `$table` WHERE deleted = 0 AND id = $id ORDER BY id DESC");
				$row = $dataRow->fetch_array();
				extract($row);		
				 
		?> 
			<input name="table" value="<?php echo encryptIt($table); ?>" type="hidden"  />
			<input name="id" value="<?php echo encryptIt($id); ?>" type="hidden"  />
			<div class="form-group"> 
				<label class="col-sm-2  modal-form control-label" for="name">Date</label> 
				<div class="col-sm-9"> 
						<input type="text" placeholder="Date" autocomplete="off" id="date" name="date"  onchange="checkDate(this.value)"  value="<?php  echo $date;	?>" class="form-control">
					<p class="help-block"></p>
				 </div> 
			</div> 
			<div class="form-group"> 
				<label class="col-sm-2  modal-form control-label" for="name">Name</label> 
				<div class="col-sm-9"> 
						<input type="text" placeholder="Name" autocomplete="off" id="name" name="name" value="<?php  echo $name;	?>" class="form-control">
					<p class="help-block"></p>
				 </div> 
			</div> 
			<div class="form-group"> 
				<label class="col-sm-2  modal-form control-label" for="vendorType">Customer Type</label> 
				<div class="col-sm-9"> 
						<select class="select2 form-control" name='customerType'   autocomplete="off">
							<option value="">Customer Type</option>
							<?php
							 
							$customerCategoryRow= $conn->query("SELECT * FROM `tbl_customer_categories` WHERE  deleted = 0 ORDER BY id DESC");
							while($row = $customerCategoryRow->fetch_array()){
								
								$id   = $row['id'];
								$name = $row['name'];
								if($id == $customer_type){
									echo "<option value='$id' selected>$name</option>";
								}else{
									echo "<option value='$id'>$name</option>";
								}
							}   
						
							?>
						</select>
					<p class="help-block"></p>
				 </div> 
			</div>
			<div class="form-group"> 
				<label class="col-sm-2  modal-form control-label" for="firstContact">Contact / Email</label> 
				<div class="col-sm-9"> 
						<input type="text" placeholder="Contact / Email" autocomplete="off" id="contact" name="contact" value="<?php  echo $contact;	?>" class="form-control">
					<p class="help-block"></p>
				 </div> 
			</div> 
			<div class="form-group"> 
				<label class="col-sm-2  modal-form control-label" for="name">Opening Balance</label> 
				<div class="col-sm-9"> 
						<input type="text" placeholder="Opening Balance" autocomplete="off" id="openingBalance" onKeyPress="return isNumericKey(event)"  name="openingBalance" value="<?php  echo $opening_balance;   ?>" class="form-control">
					<p class="help-block"></p>
				 </div> 
			</div>
			<div class="form-group"> 
				<label class="col-sm-2  modal-form control-label" for="currenciesId">Currency</label> 
				<div class="col-sm-9"> 
					<select class="select2 form-control" name='currenciesId'   onchange="readCurrencyRate(this.value),selectBanks(this.value)"  autocomplete="off" id='currenciesId'>
						<option value="">Select Currency</option>
						<?php
						 
						$currenciesRow= $conn->query("SELECT * FROM `tbl_currencies` WHERE  deleted = 0 ORDER BY id DESC");
						while($row = $currenciesRow->fetch_array()){
							
							$id   = $row['id'];
							$name = $row['code'];
							if($id == $currencies_id){
								echo "<option value='$id' selected>$name</option>";
							}else{
								echo "<option value='$id'>$name</option>";
							}
				 
						}   
					
						?>
					</select>
					<p class="help-block"></p>
				 </div> 
			</div>
			 
			<div class="form-group"> 
				<label class="col-sm-2  modal-form control-label" for="rate">Rate</label> 
				<div class="col-sm-9"> 
						<input type="text" placeholder="Rate" autocomplete="off" id="rate" name="rate" onKeyPress="return isNumericKey(event)"  value="<?php  echo $rate;  ?>" class="form-control">
					<p class="help-block"></p>
				 </div> 
			</div> 
			
		 <div class="form-group"> 
				<label class="col-sm-2  modal-form control-label" for="address">Address</label> 
				<div class="col-sm-9"> 
						<textarea    placeholder = 'Address' autocomplete="off" id='address' name='address' class='form-control'><?php  echo $address;	?></textarea>
					<p class="help-block"></p>
				 </div> 
			</div> 
			
		 
		<?php
		//tbl_items
		}elseif($table == "tbl_customer_payment"){
				$dataRow = $conn->query("SELECT * FROM `$table` WHERE deleted = 0 AND id = $id ORDER BY id DESC");
				$row = $dataRow->fetch_array();
				extract($row);
		?> 
			<input name="table" value="<?php echo encryptIt($table); ?>" type="hidden"  />
			<input name="id" value="<?php echo encryptIt($id); ?>" type="hidden"  />
  							
			<div class="form-group"> 
				<label class="col-sm-2  modal-form control-label" for="name">Date</label> 
				<div class="col-sm-9"> 
						<input type="text" placeholder="Date" autocomplete="off" id="date" name="date"  onchange="checkDate(this.value)"  value="<?php  echo $date;	?>" class="form-control">
					<p class="help-block"></p>
				 </div> 
			</div>
			<div class="form-group">  
				<label class="col-sm-2  modal-form control-label" for="bankId">Customer Name</label> 
				<div class="col-sm-9"> 
					<select class="select2 form-control" name='customerId' onchange="selectCustomerCurrency(this.value)" autocomplete="off" id='customerId'>
							<option Value="">Select Customer</option>
							<?php
							 
							$customerRow= $conn->query("SELECT * FROM `tbl_customers` WHERE deleted = 0 ORDER BY id DESC");
							while($row = $customerRow->fetch_array()){
								
								$id   = $row['id'];
								$name = $row['name'];
								if($id == $customers_id){
									echo "<option value='$id' selected>$name</option>";
								}else{
									echo "<option value='$id'>$name</option>";
								}
							}   
						
							?>
						</select>
						<p class="help-block"></p>
				 </div> 
			</div>
			<div class="form-group"> 
				<label class="col-sm-2  modal-form control-label" for="currenciesId">Currency</label> 
				<div class="col-sm-9"> 
					<select class="select2 form-control" name='currenciesId' id='currenciesId'  onchange="readCurrencyRate(this.value),selectBanks(this.value);"  autocomplete="off">
						<option Value="">Select Currency</option>
						 <?php			 
											 
							$currenciesRow= $conn->query("SELECT * FROM `tbl_currencies` WHERE id = $currencies_id AND deleted = 0 ORDER BY id DESC");
							while($row = $currenciesRow->fetch_array()){
								
								$id   = $row['id'];
								$name = $row['code'];

								echo "<option value='$id' selected>$name</option>";
								
  							}   
						
						?>
					</select>
					<p class="help-block"></p>
				 </div> 
			</div>			
			<div class="form-group"> 
				<label class="col-sm-2  modal-form control-label" for="name">Amount</label> 
				<div class="col-sm-9"> 
						<input type="text" placeholder="Amount" autocomplete="off" id="amount" name="amount" onKeyPress="return isNumericKey(event)"  value="<?php  echo $amount;	?>" class="form-control">
					<p class="help-block"></p>
				 </div> 
			</div> 
		  
			<div class="form-group"> 
				<label class="col-sm-2  modal-form control-label" for="bankId">Bank</label> 
				<div class="col-sm-9"> 
					<select class="select2 form-control" name='bankId' autocomplete="off" id='bankId'>
						<option Value="">Select Bank</option>
						<?php
					   
						$bankRow= $conn->query( "SELECT * FROM `tbl_banks` WHERE deleted = 0 AND currencies_id = $currencies_id");
						While($row = $bankRow->fetch_array()){
									$id = $row['id'];
									$name = $row['name'];
								if($id == $banks_id){
									echo "<option   value='$id' selected>$name</option>";
								}else{
									echo "<option   value='$id'>$name</option>";
								}
						}   
					 
						?>
					</select>
					<p class="help-block"></p>
 				 </div> 
			</div>
			  
			<div class="form-group"> 
				<label class="col-sm-2  modal-form control-label" for="rate">Rate</label> 
				<div class="col-sm-9"> 
						<input type="text" placeholder="Rate" autocomplete="off" id="rate" name="rate" onKeyPress="return isNumericKey(event)"  value="<?php  echo $rate;  ?>" class="form-control">
					<p class="help-block"></p>
				 </div> 
			</div> 
			
		 <div class="form-group"> 
				<label class="col-sm-2  modal-form  control-label" for="Description">Description</label> 
				<div class="col-sm-9"> 
						<textarea    placeholder = 'Description' autocomplete="off" id='description' name='description' class='form-control'><?php  echo $description;	?></textarea>
					<p class="help-block"></p>
				 </div> 
			</div> 
			
		 
		<?php
 		}elseif($table == "tbl_banks"){
				$dataRow = $conn->query("SELECT * FROM `$table` WHERE deleted = 0 AND id = $id ORDER BY id DESC");
				$row = $dataRow->fetch_array();	
				extract($row);
		?> 
			<input name="table" value="<?php echo encryptIt($table); ?>" type="hidden"  />
			<input name="id" value="<?php echo encryptIt($id); ?>" type="hidden"  />
  							
			<div class="form-group"> 
				<label class="col-sm-2  modal-form  control-label" for="name">تاریخ</label> 
				<div class="col-sm-9"> 
						<input type="text" placeholder="تاریخ" autocomplete="off" id="date" name="date"  onchange="checkDate(this.value)"  value="<?php  echo $date;	?>" class="form-control">
					<p class="help-block"></p>
				 </div> 
			</div>				
			<div class="form-group"> 
				<label class="col-sm-2  modal-form pull-left control-label" for="name">نام</label> 
				<div class="col-sm-9"> 
						<input type="text" placeholder="نام" autocomplete="off" id="name" name="name" value="<?php   echo $name;  ?>" class="form-control">
					<p class="help-block"></p>
				 </div> 
			</div>
			<div class="form-group">  
				<label class="col-sm-2  modal-form control-label" for="bankId"> کتگوری بانک </label> 
				<div class="col-sm-9"> 
					<select class="select2 form-control" name='bankCategory' autocomplete="off" id='bankCategory'>
						<option Value="">Bank Category</option>
						<?php
						$categoryRow= $conn->query("SELECT * FROM `tbl_banks_category` WHERE deleted = 0 ORDER BY id DESC");
							While($row = $categoryRow->fetch_array()){
									$id = $row['id'];
									$name = $row['name'];
									if($id == $category_id){
										echo "<option value='$id' selected>$name</option>";
									}else{
										echo "<option value='$id'>$name</option>";
									}
					 
							}   
						
						?>
					</select>
					<p class="help-block"></p>
				 </div> 
			</div>
			<div class="form-group"> 
				<label class="col-sm-2  modal-form  pull-left control-label" for="name"> حساب افتتاحیه</label> 
				<div class="col-sm-9"> 
						<input type="text" placeholder="Opening Balance" autocomplete="off" id="openingBalance"   onKeyPress="return isNumericKey(event)" value="<?php   echo $opening_balance;   ?>" name="openingBalance" class="form-control">
					<p class="help-block"></p>
				 </div> 
			</div>
			<div class="form-group">  
				<label class="col-sm-2  modal-form control-label" for="bankId">واحد پولی</label> 
				<div class="col-sm-9"> 
					<select class="select2 form-control" name='currenciesId'  onchange="readCurrencyRate(this.value)" autocomplete="off" id='currenciesId'>
						<option Value="">انتخاب واحد پولی</option>
						<?php
							$currenciesRow= $conn->query("SELECT * FROM `tbl_currencies` WHERE deleted = 0 ORDER BY id DESC");
							while($row = $currenciesRow->fetch_array()){
								
								$id   = $row['id'];
								$name = $row['code'];
								if($id == $currencies_id){
									echo "<option value='$id' selected >$name</option>";
								}else{
									echo "<option value='$id'>$name</option>";
								}
							}     
						
						?>
					</select>
					<p class="help-block"></p>
				 </div> 
			</div>
			  
			<div class="form-group"> 
				<label class="col-sm-2  modal-form control-label" for="rate">نرخ</label> 
				<div class="col-sm-9"> 
						<input type="text" placeholder="Rate" autocomplete="off" id="rate" name="rate" onKeyPress="return isNumericKey(event)" onKeyPress="return isNumericKey(event)"  value="<?php  echo $rate;  ?>" class="form-control">
					<p class="help-block"></p>
				 </div> 
			</div> 
			
			<div class="form-group"> 
				<label class="col-sm-2  modal-form control-label" for="Description">توضیحات</label> 
				<div class="col-sm-9"> 
						<textarea  placeholder = 'توضیحات' autocomplete="off" id='description' name='description' class='form-control'><?php  echo $description;	?></textarea>
					<p class="help-block"></p>
				 </div> 
			</div> 
			
		 
		<?php
 		}elseif($table == "tbl_banks_category"){
				$dataRow = $conn->query("SELECT * FROM `$table` WHERE deleted = 0 AND id = $id ORDER BY id DESC");
				$row = $dataRow->fetch_array();	
				extract($row);
		?> 
			<input name="table" value="<?php echo encryptIt($table); ?>" type="hidden"  />
			<input name="id" value="<?php echo encryptIt($id); ?>" type="hidden"  />
  							
			 		
			<div class="form-group"> 
				<label class="col-sm-2  modal-form pull-left control-label" for="name">کتگوری بانک</label> 
				<div class="col-sm-9"> 
						<input type="text" placeholder="کتگوری بانک" autocomplete="off" id="name" name="name" value="<?php   echo $name;  ?>" class="form-control">
					<p class="help-block"></p>
				 </div> 
			</div>
		 
		 
		<?php
 		}elseif($table == "tbl_bank_statement"){
				$dataRow = $conn->query("SELECT * FROM `$table` WHERE deleted = 0 AND id = $id ORDER BY id DESC");
				$row = $dataRow->fetch_array();	
				extract($row);
		?> 
			<input name="table" value="<?php echo encryptIt($table); ?>" type="hidden"  />
			<input name="id" value="<?php echo encryptIt($id); ?>" type="hidden"  />
  							
			<div class="form-group"> 
				<label class="col-sm-2  modal-form  control-label" for="name">Date</label> 
				<div class="col-sm-9"> 
						<input type="text" placeholder="Date" autocomplete="off" id="date" name="date"  onchange="checkDate(this.value)"  value="<?php  echo $date;	?>" class="form-control">
					<p class="help-block"></p>
				 </div> 
			</div>
			<div class="form-group"> 
				<label class="col-sm-2  modal-form control-label" for="bankId">Bank</label> 
				<div class="col-sm-9"> 
					<select class="select2 form-control" name='bankId' required onchange="selectBankCurrency(this.value);" autocomplete="off" id='bankId'>
							<option Value="">Select Bank</option>
							<?php
							 
							$bankRow= $conn->query("SELECT * FROM `tbl_banks` WHERE  deleted = 0 ORDER BY id DESC");
							While($row = $bankRow->fetch_array()){
									$id = $row['id'];
									$name = $row['name'];
									if($id == $banks_id){
										echo "<option   value='$id' selected>$name</option>";
									}else{
										echo "<option   value='$id'>$name</option>";
									}
				 
							}
							?>
					</select>
					<p class="help-block"></p>
				 </div> 
			</div>
			<div class="form-group"> 
				<label class="col-sm-2  modal-form control-label" for="currenciesId">Currency</label> 
				<div class="col-sm-9"> 
					<select class="select2 form-control" name='currenciesId' required onchange="readCurrencyRate(this.value);" autocomplete="off" id='currenciesId'>
							<option Value="">Select Currency</option>
							<?php  
 							$currenciesRow= $conn->query("SELECT * FROM `tbl_currencies` WHERE id = $currencies_id AND deleted = 0 ORDER BY id DESC");
								while($row = $currenciesRow->fetch_array()){
									
									$id   = $row['id'];
									$name = $row['code'];
									echo "<option value='$id' selected>$name</option>";
								} 
							?>
					</select>
					<p class="help-block"></p>
				 </div> 
			</div>
			<div class="form-group"> 
				<label class="col-sm-2  modal-form control-label" for="transactionType">Transaction Type</label> 
				<div class="col-sm-9"> 
					<select class="select2 form-control" name='transactionType'  id='transactionType'  autocomplete="off">
						<option value="">Select Transaction Type</option>
						 <option value="1" <?php if($transaction_type == 1){ echo "selected";} ?> > Credit </option>
						 <option value="2" <?php if($transaction_type == 2){ echo "selected";} ?> > Debit </option>
					</select>
					<p class="help-block"></p>
				 </div> 
			</div>
			<div class="form-group"> 
				<label class="col-sm-2  modal-form control-label" for="rate">Amount</label> 
				<div class="col-sm-9"> 
						<input type="text" placeholder="Amount" autocomplete="off" id="amount" name="amount"  value="<?php  echo $amount;   ?>" onKeyPress="return isNumericKey(event)" class="form-control">
					<p class="help-block"></p>
				 </div> 
			</div> 
			
			<div class="form-group"> 
				<label class="col-sm-2  modal-form control-label" for="rate">Rate</label> 
				<div class="col-sm-9"> 
						<input type="text" placeholder="Rate" autocomplete="off" id="rate" name="rate"  onKeyPress="return isNumericKey(event)"  value="<?php  echo $rate;  ?>" class="form-control">
					<p class="help-block"></p>
				 </div> 
			</div> 
			
			<div class="form-group"> 
				<label class="col-sm-2  modal-form control-label" for="Description">Description</label> 
				<div class="col-sm-9"> 
						<textarea    placeholder = 'Description' autocomplete="off" id='description' name='description' class='form-control'><?php  echo $description;	?></textarea>
					<p class="help-block"></p>
				 </div> 
			</div> 
			
		 
		<?php
 		}elseif($table == "tbl_bank_exchange"){
				$dataRow = $conn->query("SELECT * FROM `$table` WHERE deleted = 0 AND id = $id ORDER BY id DESC");
				$row = $dataRow->fetch_array();	
				extract($row);
										
				$rowCurrency = $conn->selectRecord ("tbl_currencies","id  = ". $currencies_id);
				$rowSourceBank = $conn->selectRecord ("tbl_banks","id  = ". $source_bank_id);
				$rowDistinationeBank = $conn->selectRecord ("tbl_banks","id  = ". $destination_banks_id);
				$rowCurrencyDes = $conn->selectRecord ("tbl_currencies","id  = ". $des_currencies_id);
			
		?> 
			<input name="table" value="<?php echo encryptIt($table); ?>" type="hidden"  />
			<input name="id" value="<?php echo encryptIt($id); ?>" type="hidden"  />
  							
			<div class="form-group"> 
				<label class="col-sm-2  modal-form  control-label" for="name">Date</label> 
				<div class="col-sm-9"> 
						<input type="text" placeholder="Date" autocomplete="off" id="date"  onchange="checkDate(this.value)"  name="date" value="<?php  echo $date;	?>" class="form-control">
					<p class="help-block"></p>
				 </div> 
			</div>
			<div class="form-group"> 
				<label class="col-sm-2  modal-form control-label" for="bankId">Source Bank</label> 
				<div class="col-sm-9"> 
					<select class="select2 form-control" name='sourceBank' required  onchange = "transferBankAdjustment(this.value)" autocomplete="off" id='sourceBank'>
							<option Value="">Select Source Bank</option>
							<?php
						
								$bankRow= $conn->query("SELECT * FROM `tbl_banks` WHERE deleted = 0 ORDER BY id DESC");
								While($row = $bankRow->fetch_array()){
											$id = $row['id'];
											$name = $row['name'];
										if($source_bank_id == $id){
											echo "<option   value='$id' selected>$name</option>";
										}else{
											echo "<option   value='$id'>$name</option>";
										}
								}   
							 
							?>
					</select>
					<p class="help-block"></p>
				 </div> 
			</div>
			<div class="form-group"> 
				<label class="col-sm-2  modal-form control-label" for="">SB Currency</label> 
				<div class="col-sm-9"> 
					<input type="text" id="currenciesIdSourceBank" required value="<?php echo $rowCurrency['code']; ?>" readonly class="form-control">
					<p class="help-block"></p>
				 </div> 
			</div>
			 
			 <div class="form-group"> 
				<label class="col-sm-2  modal-form control-label" for="rate">Exchange Rate</label> 
				<div class="col-sm-9"> 
					<input type="text" placeholder="Exchanage Rate" autocomplete="off" id="exchanageRate" name="exchanageRate"  value="<?php echo $exchange_rate;?>" onKeyPress="return isNumericKey(event)" class="form-control">
					<p class="help-block"></p>
				 </div> 
			</div>		
			<div class="form-group"> 
				<label class="col-sm-2  modal-form control-label" for="amount">Transfer Amount</label> 
				<div class="col-sm-9"> 
					<input type="text" placeholder="Transfer Amount" autocomplete="off" id="amount" name="amount" onblur="calculateTransferableAmount();" value="<?php  echo $amount;?>"  onKeyPress="return isNumericKey(event)" class="form-control">
					<p class="help-block"></p>
				 </div> 
			</div>
			
			<div class="form-group"> 
				<label class="col-sm-2  modal-form control-label" for="rate">Transferable Amount</label> 
				<div class="col-sm-9"> 
					<input type="text" placeholder="Transferable Amount" autocomplete="off" id="transferableAmount" value="<?php echo $des_amount;  ?>" readonly name="transferableAmount" class="form-control">
					<p class="help-block"></p>
				 </div> 
			</div>
			<div class="form-group"> 
				<label class="col-sm-2  modal-form control-label" for="destinationBank">Destination Bank</label> 
				<div class="col-sm-9"> 
					<select class="select2 form-control" name='destinationBank' required autocomplete="off"  onchange ="currenciesDestinationBank(this.value),existanceDistinationBank(this.value)" id='destinationBank'>
							<option Value="">Destination Bank</option>
							<?php
							
								$bankRow= $conn->query("SELECT * FROM `tbl_banks` WHERE  deleted = 0 ORDER BY id DESC");
								While($row = $bankRow->fetch_array()){
											$id = $row['id'];
											$name = $row['name'];
										if($destination_banks_id == $id){
											echo "<option   value='$id' selected>$name</option>";
										}else{
											echo "<option   value='$id'>$name</option>";
										}
								}  
							?>
					</select>
					<p class="help-block"></p>
				 </div> 
			</div>
			<div class="form-group"> 
				<label class="col-sm-2  modal-form control-label" for="">Currency of DB</label> 
				<div class="col-sm-9"> 
									<input type="text"  readonly class="form-control" id="desCurrenciesCode" name ="desCurrenciesId" value="<?php echo  $rowCurrencyDes['code'];   ?>" >
					<p class="help-block"></p>
				 </div> 
			</div>
			 
			<div class="form-group"> 
				<label class="col-sm-2  modal-form control-label" for="rate">Source Rate</label> 
				<div class="col-sm-9"> 
									<input type="text" placeholder="Rate" autocomplete="off" id="rate" value="<?php  echo $rate; ?>" name="rate" onKeyPress="return isNumericKey(event)" required class="form-control">
					<p class="help-block"></p>
				 </div> 
			</div> 
			<div class="form-group"> 
				<label class="col-sm-2  modal-form control-label" for="rate">Destination Rate</label> 
				<div class="col-sm-9"> 
					<input type="text" placeholder="Rate" autocomplete="off" id="destinationRate" name="destinationRate" value="<?php echo $des_rate;?>" required onKeyPress="return isNumericKey(event)" class="form-control">
					<p class="help-block"></p>
				 </div> 
			</div>
			 
			<div class="form-group"> 
				<label class="col-sm-2  modal-form control-label" for="Description">Description</label> 
				<div class="col-sm-9"> 
						<textarea    placeholder = 'Description' autocomplete="off" id='description' name='description' class='form-control'><?php  echo $description;	?></textarea>
					<p class="help-block"></p>
				 </div> 
			</div> 
			
		 
		<?php
 		}elseif($table == "tbl_expense_categories"){
				$dataRow = $conn->query("SELECT * FROM `$table` WHERE deleted = 0 AND id = $id ORDER BY id DESC");
				$row = $dataRow->fetch_array();	
				extract($row);
		?> 
			<input name="table" value="<?php echo encryptIt($table); ?>" type="hidden"  />
			<input name="id" value="<?php echo encryptIt($id); ?>" type="hidden" />
  						
			<div class="form-group"> 
				<label class="col-sm-2  modal-form pull-left control-label" for="name">Category Name</label> 
				<div class="col-sm-9"> 
							<input type="text" placeholder="Category Name" autocomplete="off" value="<?php  echo $name;  ?>" id="name" name="name" class="form-control">
					<p class="help-block"></p>
				 </div> 
			</div>
		 
		 
		<?php
 		}elseif($table == "tbl_expense_types"){
				$dataRow = $conn->query("SELECT * FROM `$table` WHERE deleted = 0 AND id = $id ORDER BY id DESC");
				$row = $dataRow->fetch_array();	
				extract($row);
		?> 
			<input name="table" value="<?php echo encryptIt($table); ?>" type="hidden"  />
			<input name="id" value="<?php echo encryptIt($id); ?>" type="hidden"  />
  							
			 		
			<div class="form-group"> 
				<label class="col-sm-2  modal-form pull-left control-label" for="name">Category Name</label> 
				<div class="col-sm-9"> 

					<select class="select2 form-control" name='expenseCategory' autocomplete="off" id='expenseCategory'>
						<option Value="">Select Expense Category</option>
						<?php
						 
						$categoryRow= $conn->query("SELECT * FROM `tbl_expense_categories` WHERE deleted = 0 ORDER BY id DESC");
						while($row = $categoryRow->fetch_array()){
							
							$id   = $row['id'];
							$name = $row['name'];
							echo "<option value='$id'>$name</option>";

						}   

						?>
					</select>
					<p class="help-block"></p>
				 </div> 
			</div>
			<div class="form-group"> 
				<label class="col-sm-2 modal-form pull-left control-label" for="name">Expense Type</label> 
				<div class="col-sm-9"> 
									<input type="text" placeholder="Expense Type Name" autocomplete="off" id="name" name="name" value="<?php  echo $name;   ?>" class="form-control">
					<p class="help-block"></p>
				 </div> 
			</div>
		 
		<?php
 		}elseif($table == "tbl_expenses"){
				$dataRow = $conn->query("SELECT * FROM `$table` WHERE deleted = 0 AND id = $id ORDER BY id DESC");
				$row = $dataRow->fetch_array();	
				extract($row);
		?> 
			<input name="table" value="<?php echo encryptIt($table); ?>" type="hidden"  />
			<input name="id" value="<?php echo encryptIt($id); ?>" type="hidden"  />
  			<input name="oldDocument" value="<?php echo $document; ?>" type="hidden"  />
		
			<div class="form-group"> 
				<label class="col-sm-2 modal-form pull-left control-label" for="data">Date</label> 
				<div class="col-sm-9"> 
					<input type="text" placeholder="Date" autocomplete="off" id="date"  onchange="checkDate(this.value)"  data-select='datepicker' value="<?PHP  echo $date;  ?>" name="date" class="form-control">
					<p class="help-block"></p>
				 </div> 
			</div>
			 
			<div class="form-group"> 
				<label class="col-sm-2 modal-form pull-left control-label" for="expenseCategory">Category</label> 
				<div class="col-sm-9"> 
					<select class="select2 form-control" name='expenseCategory' autocomplete="off" onchange ="readExpenses(this.value)" id='expenseCategory'>
							<option Value="">Select Category</option>
							<?php
							 
							$categoryRow= $conn->query("SELECT * FROM `tbl_expense_categories` WHERE deleted = 0 ORDER BY id DESC");
							While($row = $categoryRow->fetch_array()){
									$id = $row['id'];
									$name = $row['name'];
									if($id == $expense_category_id){
										echo "<option   value='$id' selected>$name</option>";
									}else{
										echo "<option   value='$id'>$name</option>";
									}
							}   
						
							?>
					</select>
					<p class="help-block"></p>
				 </div> 
			</div>
			<div class="form-group"> 
				<label class="col-sm-2 modal-form pull-left control-label" for="expenseType">Expense Type</label> 
				<div class="col-sm-9"> 
					<select class="select2 form-control" name='expenseType' autocomplete="off" id='expenseType'>
							<option Value="">Expense Type</option>
							 <?php
							$expenseTypeCategoryRow= $conn->query("SELECT * FROM `tbl_expense_types` WHERE deleted = 0 ORDER BY id DESC");
							While($row = $expenseTypeCategoryRow->fetch_array()){
									$id = $row['id'];
									$name = $row['name'];
									if($id == $expense_type_id){
										echo "<option   value='$id' selected>$name</option>";
									} 
							}   
							?>
					</select>
					<p class="help-block"></p>
				 </div> 
			</div>
			 
			<div class="form-group"> 
				<label class="col-sm-2 modal-form pull-left control-label" for="unit">Currency</label> 
				<div class="col-sm-9"> 
					<select class="select2 form-control" name='currenciesId' autocomplete="off"  onchange="readCurrencyRate(this.value),selectBanks(this.value)" id='currenciesId'>
					  <?php
						 
						$currenciesRow= $conn->query("SELECT * FROM `tbl_currencies` WHERE  deleted = 0 ORDER BY id DESC");
						while($row = $currenciesRow->fetch_array()){
							
							$id   = $row['id'];
							$name = $row['code'];
							if($currencies_id == $id){
								echo "<option value='$id' selected >$name</option>";
							}else{
								echo "<option value='$id'>$name</option>";

							}
						}   
					
						?>
					</select>
					<p class="help-block"></p>
				 </div> 
			</div>
			<div class="form-group"> 
				<label class="col-sm-2 modal-form pull-left control-label" for="amount">Amount</label> 
				<div class="col-sm-9"> 
					<input type="text" placeholder="Amount" autocomplete="off" id="amount" name="amount" value="<?php echo $amount;   ?>" onKeyPress="return isNumericKey(event)" onchange  = "exchangerUsd()" class="form-control">
					<p class="help-block"></p>
				 </div> 
			</div> 
			
		
			 
			<div class="form-group"> 
				<label class="col-sm-2 modal-form pull-left control-label" for="rate">Rate</label> 
				<div class="col-sm-9"> 
					<input type="text" placeholder="Rate" autocomplete="off" id="rate" name="rate" value="<?php echo $rate;    ?>" onKeyPress="return isNumericKey(event)" onblur  = "exchangerUsd()" class="form-control">
					<p class="help-block"></p>
				 </div> 
			</div>
			<div class="form-group"> 
				<label class="col-sm-2 modal-form pull-left control-label" for="amount">Usd Amount</label> 
				<div class="col-sm-9"> 
					<input type="text" placeholder="Usd Amount" autocomplete="off" id="usdAmount" name="usdAmount"  readonly onKeyPress="return isNumericKey(event)" value="<?php echo $home_amount;     ?>" class="form-control">
					<p class="help-block"></p>
				 </div> 
			</div>	
			<div class="form-group"> 
				<label class="col-sm-2 modal-form pull-left control-label" for="bankId">Bank</label> 
				<div class="col-sm-9"> 
					<select class="select2 form-control" name='bankId' autocomplete="off" id='bankId'>
							<option Value="">Select Bank</option>
							<?php
							  
							$bankRow= $conn->query("SELECT * FROM `tbl_banks` WHERE deleted = 0 ORDER BY id DESC");
							while($row = $bankRow->fetch_array()){
									$id = $row['id'];
									$name = $row['name'];
								if($banks_id == $id){
									echo "<option   value='$id' selected>$name</option>";
								}else{
									echo "<option   value='$id'>$name</option>";
								}
							}
							?>
					</select>
					<p class="help-block"></p>
				 </div> 
			</div>
	  
			<div class="form-group"> 
				<label class="col-sm-2 modal-form pull-left control-label" for="checkCash">Uplode File</label> 
				<div class="col-sm-9"> 
						<input type="file" title="You Can Uplode About 1.5MB Files " autocomplete="off" id="fileName" name="fileName" max-file-size=2048  class="form-control">
					<p class="help-block"></p>
				 </div> 
			</div>
			 <div class="form-group"> 
				<label class="col-sm-2 modal-form pull-left control-label" for="description">Description</label> 
				<div class="col-sm-9">  
					<textarea    placeholder = "Description" autocomplete="off" name="description" name="description"  class="form-control"><?php echo $description;    ?></textarea>
					<p class="help-block"></p>
				 </div> 
			</div>	
							 
		<?php
 		}elseif($table == "tbl_income_categories"){
				$dataRow = $conn->query("SELECT * FROM `$table` WHERE deleted = 0 AND id = $id ORDER BY id DESC");
				$row = $dataRow->fetch_array();	
				extract($row);
		?> 
			<input name="table" value="<?php echo encryptIt($table); ?>" type="hidden"  />
			<input name="id" value="<?php echo encryptIt($id); ?>" type="hidden" />
  						
			<div class="form-group"> 
				<label class="col-sm-2  modal-form pull-left control-label" for="name">Category Name</label> 
				<div class="col-sm-9"> 
							<input type="text" placeholder="Category Name" autocomplete="off" value="<?php  echo $name;  ?>" id="name" name="name" class="form-control">
					<p class="help-block"></p>
				 </div> 
			</div>
		 
		 
		<?php
 		}elseif($table == "tbl_income_types"){
				$dataRow = $conn->query("SELECT * FROM `$table` WHERE deleted = 0 AND id = $id ORDER BY id DESC");
				$row = $dataRow->fetch_array();	
				extract($row);
 		?> 
			<input name="table" value="<?php echo encryptIt($table); ?>" type="hidden"  />
			<input name="id" value="<?php echo encryptIt($id); ?>" type="hidden"  />
  							
			 		
			<div class="form-group"> 
				<label class="col-sm-2  modal-form pull-left control-label" for="incomeCategory">Category Name</label> 
				<div class="col-sm-9"> 

					<select class="select2 form-control" name='incomeCategory' autocomplete="off" id='incomeCategory'>
						<option Value="">Select Income Category</option>
						<?php
						 
						$categoryRow= $conn->query("SELECT * FROM `tbl_income_categories` WHERE deleted = 0  ORDER BY id DESC");
						while($row = $categoryRow->fetch_array()){
							
							$id   = $row['id'];
							$categoryName = $row['name'];
							if($id == $income_categories_id){
								echo "<option value='$id' selected>$categoryName</option>";
							}else{
								echo "<option value='$id'>$categoryName</option>";
							}

						}   

						?>
					</select>
					<p class="help-block"></p>
				 </div> 
			</div>
			<div class="form-group"> 
				<label class="col-sm-2 modal-form pull-left control-label" for="name">Income Type</label> 
				<div class="col-sm-9"> 
						<input type="text" placeholder="Income Type Name" autocomplete="off" id="name" name="name" value="<?php  echo $name;   ?>" class="form-control">
					<p class="help-block"></p>
				 </div> 
			</div>
		 
		<?php
 		}elseif($table == "tbl_incomes"){
				$dataRow = $conn->query("SELECT * FROM `$table` WHERE deleted = 0 AND id = $id ORDER BY id DESC");
				$row = $dataRow->fetch_array();	
				extract($row);
		?> 
			<input name="table" value="<?php echo encryptIt($table); ?>" type="hidden"  />
			<input name="id" value="<?php echo encryptIt($id); ?>" type="hidden"  />
 		
			<div class="form-group"> 
				<label class="col-sm-2 modal-form pull-left control-label" for="data">Date</label> 
				<div class="col-sm-9"> 
					<input type="text" placeholder="Date" autocomplete="off" id="date"  onchange="checkDate(this.value)"  data-select="datepicker" value="<?PHP  echo $date;  ?>" name="date" class="form-control">
					<p class="help-block"></p>
				 </div> 
			</div>
			 
			<div class="form-group"> 
				<label class="col-sm-2 modal-form pull-left control-label" for="incomeCategory">Category</label> 
				<div class="col-sm-9"> 
					<select class="select2 form-control" name='incomeCategory' autocomplete="off" onchange ="readIncomes(this.value)" id='incomeCategory'>
							<option Value="">Select Category</option>
							<?php
							 
							$categoryRow= $conn->query("SELECT * FROM `tbl_income_categories` WHERE deleted = 0 ORDER BY id DESC");
							While($row = $categoryRow->fetch_array()){
									$id = $row['id'];
									$name = $row['name'];
									if($id == $income_category_id){
										echo "<option   value='$id' selected>$name</option>";
									}else{
										echo "<option   value='$id'>$name</option>";
									}
							}   
						
							?>
					</select>
					<p class="help-block"></p>
				 </div> 
			</div>
			<div class="form-group"> 
				<label class="col-sm-2 modal-form pull-left control-label" for="incomeType">Income Type</label> 
				<div class="col-sm-9"> 
					<select class="select2 form-control" name='incomeType' autocomplete="off" id='incomeType'>
							<option Value="">Income Type</option>
							 <?php
							$incomeTypeCategoryRow = $conn->query("SELECT * FROM `tbl_income_types` WHERE deleted = 0 ORDER BY id DESC");
							While($row = $incomeTypeCategoryRow->fetch_array()){
									$id = $row['id'];
									$name = $row['name'];
									if($id == $income_type_id){
										echo "<option   value='$id' selected>$name</option>";
									} 
							}   
							?>
					</select>
					<p class="help-block"></p>
				 </div> 
			</div>
			<div class="form-group"> 
				<label class="col-sm-2 modal-form pull-left control-label" for="amount">Amount</label> 
				<div class="col-sm-9"> 
					<input type="text" placeholder="Amount" autocomplete="off" id="amount" name="amount" value="<?php echo $amount;   ?>"  onKeyPress="return isNumericKey(event)" class="form-control">
					<p class="help-block"></p>
				 </div> 
			</div> 
			
			<div class="form-group"> 
				<label class="col-sm-2 modal-form pull-left control-label" for="unit">Currency</label> 
				<div class="col-sm-9"> 
					<select class="select2 form-control" name='currenciesId' autocomplete="off"  onchange="readCurrencyRate(this.value),selectBanks(this.value)" id='currenciesId'>
					  <?php
						 
						$currenciesRow= $conn->query("SELECT * FROM `tbl_currencies` WHERE  deleted = 0 ORDER BY id DESC");
						while($row = $currenciesRow->fetch_array()){
							
							$id   = $row['id'];
							$name = $row['code'];
							if($currencies_id == $id){
								echo "<option value='$id' selected >$name</option>";
							}else{
								echo "<option value='$id'>$name</option>";

							}
						}   
					
						?>
					</select>
					<p class="help-block"></p>
				 </div> 
			</div>
			 
			<div class="form-group"> 
				<label class="col-sm-2 modal-form pull-left control-label" for="rate">Rate</label> 
				<div class="col-sm-9"> 
					<input type="text" placeholder="Rate" autocomplete="off" id="rate" name="rate" value="<?php echo $rate;    ?>"  onKeyPress="return isNumericKey(event)" class="form-control">
					<p class="help-block"></p>
				 </div> 
			</div>
			<div class="form-group"> 
				<label class="col-sm-2 modal-form pull-left control-label" for="bankId">Bank</label> 
				<div class="col-sm-9"> 
					<select class="select2 form-control" name='bankId' autocomplete="off" id='bankId'>
							<option Value="">Select Bank</option>
							<?php
							  
							$bankRow= $conn->query("SELECT * FROM `tbl_banks` WHERE deleted = 0 ORDER BY id DESC");
							while($row = $bankRow->fetch_array()){
									$id = $row['id'];
									$name = $row['name'];
								if($banks_id == $id){
									echo "<option   value='$id' selected>$name</option>";
								}else{
									echo "<option   value='$id'>$name</option>";
								}
						 }
							?>
					</select>
					<p class="help-block"></p>
				 </div> 
			</div>
		 
			 <div class="form-group"> 
				<label class="col-sm-2 modal-form pull-left control-label" for="description">Description</label> 
				<div class="col-sm-9">  
					<textarea    placeholder = "Description" autocomplete="off" name="description" name="description"  class="form-control"><?php echo $description;    ?></textarea>
					<p class="help-block"></p>
				 </div> 
			</div>	
							 
		<?php
 		}elseif($table == "tbl_dealers"){
				$dataRow = $conn->query("SELECT * FROM `$table` WHERE deleted = 0 AND id = $id ORDER BY id DESC");
				$row = $dataRow->fetch_array();	
				extract($row);
		?> 
			<input name="table" value="<?php echo encryptIt($table); ?>" type="hidden"  />
			<input name="id" value="<?php echo encryptIt($id); ?>" type="hidden"  />
 			<input name="currenciesIdOld" value="<?php echo encryptIt($currencies_id); ?>" type="hidden"  />

											
			<div class="form-group"> 
				<label class="col-sm-2 modal-form pull-left control-label" for="data">Date</label> 
				<div class="col-sm-9"> 
					<input type="text" placeholder="Date" autocomplete="off"  onchange="checkDate(this.value)"  id="date" data-select='datepicker' value="<?PHP  echo $date;  ?>" name="date" class="form-control">
					<p class="help-block"></p>
				 </div> 
			</div>
			
			<div class="form-group"> 
				<label class="col-sm-2 modal-form pull-left control-label" for="name">Name</label> 
				<div class="col-sm-9"> 
					<input type="text" placeholder="Name" id="name" autocomplete="off" name="name" value="<?php  echo $name;   ?>" class="form-control">
					<p class="help-block"></p>
				 </div> 
			</div> 
			
			<div class="form-group"> 
				<label class="col-sm-2 modal-form pull-left control-label" for="family">Last Name</label> 
				<div class="col-sm-9"> 
					<input type="text" placeholder="Last Name" id="family" autocomplete="off" value="<?PHp   echo $family;  ?>" name="family" class="form-control">
					<p class="help-block"></p>
				 </div> 
			</div> 
			
			<div class="form-group"> 
				<label class="col-sm-2 modal-form pull-left control-label" for="contact">Contact</label> 
				<div class="col-sm-9"> 
					<input type="text" placeholder="Contact" autocomplete="off" value="<?php  echo $contact;   ?>" id="contact" name="contact" class="form-control">
					<p class="help-block"></p>
				 </div> 
			</div>
			 
			<div class="form-group"> 
				<label class="col-sm-2 modal-form pull-left control-label" for="unit">Currency</label> 
				<div class="col-sm-9"> 
					<select class="select2 form-control" name='currenciesId' autocomplete="off"   onchange="readCurrencyRate(this.value)" id='currenciesId'>
					  <?php
						 
						$currenciesRow= $conn->query("SELECT * FROM `tbl_currencies` WHERE  deleted = 0 ORDER BY id DESC");
						while($row = $currenciesRow->fetch_array()){
							
							$id   = $row['id'];
							$name = $row['code'];
							if($currencies_id == $id){
								echo "<option value='$id' selected >$name</option>";
							}else{
								echo "<option value='$id'>$name</option>";

							}
						}   
					
						?>
					</select>
					<p class="help-block"></p>
				 </div> 
			</div>	
			<div class="form-group"> 
				<label class="col-sm-2 modal-form pull-left control-label" for="address">Address</label> 
				<div class="col-sm-9"> 
					<textarea    placeholder = 'Address' autocomplete="off" id='address' name='address' class='form-control'><?php   echo $address;   ?></textarea>
					<p class="help-block"></p>
				 </div> 
			</div>
							 
		<?php
 		}elseif($table == "tbl_dealer_transaction"){
				$dataRow = $conn->query("SELECT * FROM `$table` WHERE deleted = 0 AND id = $id ORDER BY id DESC");
				$row = $dataRow->fetch_array();	
				extract($row);
		?> 
			<input name="table" value="<?php echo encryptIt($table); ?>" type="hidden"  />
			<input name="id" value="<?php echo encryptIt($id); ?>" type="hidden"  />
 			<div class="form-group"> 
				<label class="col-sm-2 modal-form pull-left control-label" for="data">تاریخ</label> 
				<div class="col-sm-9"> 
					<input type="text" placeholder="تاریخ" autocomplete="off"  onchange="checkDate(this.value)"  id="date" required value="<?PHP  echo $date;  ?>" data-select='datepicker' name="date" class="form-control">
					<p class="help-block"></p>
				 </div> 
			</div>
			<div class="form-group"> 
				<label class="col-sm-2 modal-form pull-left control-label" for="data">تاریخ ختم</label> 
				<div class="col-sm-9"> 
					<input type="text" placeholder="تاریخ ختم" autocomplete="off" id="dueDate"  onchange="checkDate(this.value)"  value="<?PHP  echo $due_date;  ?>" data-select='datepicker' name="dueDate" class="form-control">
					<p class="help-block"></p>	
				 </div> 

			</div>
			<div class="form-group"> 
				<label class="col-sm-2 modal-form pull-left control-label" for="dealerId">نام دیلر</label> 
				<div class="col-sm-9"> 
					<select class="select2 form-control" name='dealerId' required onchange="selectDealerCurrency(this.value)" autocomplete="off" id='dealerId'>
						<option Value="">انتخاب دیلر</option>
						<?php
						 
						$dealerRow= $conn->query("SELECT * FROM `tbl_dealers` WHERE deleted = 0 ORDER BY id DESC");
						while($row = $dealerRow->fetch_array()){
							
							$id   = $row['id'];
							$name = $row['name'];
							if($id == $dealers_id){
								echo "<option value='$id' selected >$name</option>";
							}else{
								echo "<option value='$id'>$name</option>";
							}
						}   
					
						?>
					</select>
					<p class="help-block"></p>
				 </div> 
			</div>
			<div class="form-group"> 
				<label class="col-sm-2 modal-form pull-left control-label" for="type">نوع ترانزکشن</label> 
				<div class="col-sm-9"> 
					<select class="select2 form-control" name='type' autocomplete="off" required id='type'>
						<option Value="">انتخاب نوع ترانزکشن</option>
						<option Value="2" <?php  if($type == 2){echo "selected";}  ?> >دیبت</option>
						<option Value="1" <?php  if($type == 1){echo "selected";}  ?> >کریدت</option>
					</select>
					<p class="help-block"></p>
				 </div> 
			</div>
			<div class="form-group"> 
				<label class="col-sm-2  modal-form control-label" for="currenciesId">واحد پولی</label> 
				<div class="col-sm-9"> 
					<select class="select2 form-control" name='currenciesId' id='currenciesId' required  onchange="readCurrencyRate(this.value),selectBanks(this.value);"  autocomplete="off">
						<option Value="">انتخاب واحد پولی</option>
						 <?php
										 
						 
						
						?>
					</select>
					<p class="help-block"></p>
				 </div> 
			</div>	 
			<div class="form-group"> 
				<label class="col-sm-2 modal-form pull-left control-label" for="amount">مقدار</label> 
				<div class="col-sm-9"> 
					<input type="text" placeholder="مقدار" autocomplete="off" id="amount" name="amount" value="<?php  echo $amount;   ?>" onKeyPress="return isNumericKey(event)"  class="form-control">
					<p class="help-block"></p>
				 </div> 
			</div> 
			<div class="form-group"> 
				<label class="col-sm-2 modal-form pull-left control-label" for="bankId">بانک</label> 
				<div class="col-sm-9"> 
					<select class="select2 form-control" name='bankId' required autocomplete="off" id='bankId'>
							<option Value="">انتخاب بانک</option>
							<?php
						   
								$bankRow= $conn->query( "SELECT * FROM `tbl_banks` WHERE deleted = 0");
								While($row = $bankRow->fetch_array()){
											$id = $row['id'];
											$name = $row['name'];
										if($banks_id == $id){
											echo "<option   value='$id' selected>$name</option>";
										}else{
											echo "<option   value='$id'>$name</option>";
										}
								}   
						 
							?>
					</select>
					<p class="help-block"></p>
				 </div> 
			</div> 
			<div class="form-group"> 
				<label class="col-sm-2 modal-form pull-left control-label" for="rate">نرخ</label> 
				<div class="col-sm-9"> 
					<input type="text" placeholder="نرخ" autocomplete="off" id="rate" name="rate" value="<?PHP echo $rate;    ?>" onKeyPress="return isNumericKey(event)"  class="form-control">
					<p class="help-block"></p>
				 </div> 
			</div>
			 
			<div class="form-group"> 
				<label class="col-sm-2 modal-form pull-left control-label" for="description">توضیحات</label> 
				<div class="col-sm-9"> 
					<textarea    placeholder = 'توضیحات' autocomplete="off" name='description' name='description' class='form-control'><?php  echo $description;  ?></textarea>
					<p class="help-block"></p>
				 </div> 
			</div>
		<?php
 		}elseif($table == "tbl_asset_types"){
				$dataRow = $conn->query("SELECT * FROM `$table` WHERE deleted = 0 AND id = $id ORDER BY id DESC");
				$row = $dataRow->fetch_array();	
				extract($row);
		?> 
			<input name="table" value="<?php echo encryptIt($table); ?>" type="hidden"  />
			<input name="id" value="<?php echo encryptIt($id); ?>" type="hidden"  />
 			<div class="form-group"> 
				<label class="col-sm-2 modal-form pull-left control-label" for="name">Asset Type</label> 
				<div class="col-sm-9"> 
					<input type="text" placeholder="Asset Type" autocomplete="off" id="name" value="<?php echo $name;    ?>"  name="name" class="form-control">
					<p class="help-block"></p>
				 </div> 
			</div>
		<?php
 		}elseif($table == "tbl_assets"){
				$dataRow = $conn->query("SELECT * FROM `$table` WHERE deleted = 0 AND id = $id ORDER BY id DESC");
				$row = $dataRow->fetch_array();	
				extract($row);
		?> 
			<input name="table" value="<?php echo encryptIt($table); ?>" type="hidden"  />
			<input name="id" value="<?php echo encryptIt($id); ?>" type="hidden"  />
 			 															
			<div class="form-group"> 
				<label class="col-sm-2 modal-form pull-left control-label" for="data">Date</label> 
				<div class="col-sm-9"> 
					<input type="text" placeholder="Date" autocomplete="off" id="date"  data-select='datepicker'   onchange="checkDate(this.value)"   value="<?php  echo $date;  ?>" name="date" class="form-control">
					<p class="help-block"></p>
				 </div> 
			</div>
			 <div class="form-group"> 
				<label class="col-sm-2 modal-form pull-left control-label" for="assetType">Asset Type</label> 
				<div class="col-sm-9"> 
					<select class="select2 form-control" name="assetType" autocomplete="off" id="assetType">
						<option value="">Select Asset Type</option>
						
						<?php
						
							$assetRow= $conn->query("SELECT * FROM `tbl_asset_types` WHERE deleted = 0 ORDER BY id DESC");
							While($row = $assetRow->fetch_array()){
							
								$id   = $row['id'];
								$name = $row['name'];
								if($asset_types_id == $id){
									echo "<option value='$id' selected>$name</option>";
								}else{
									echo "<option value='$id'>$name</option>";
								}
							}   
							
						?>
						 
					</select>
					<p class="help-block"></p>
				 </div> 
			</div>
			<div class="form-group"> 
				<label class="col-sm-2 modal-form pull-left control-label" for="currenciesId">Currency</label> 
				<div class="col-sm-9"> 
					<select class="select2 form-control" name='currenciesId' autocomplete="off"  onchange="readCurrencyRate(this.value),selectBanks(this.value)"   onchange="readCurrencyRate(this.value)" id='currenciesId'>
					  <?php
						 
						$currenciesRow= $conn->query("SELECT * FROM `tbl_currencies` WHERE deleted = 0 ORDER BY id DESC");
						while($row = $currenciesRow->fetch_array()){
							
							$id   = $row['id'];
							$name = $row['code'];
							if($currencies_id == $id){
								echo "<option value='$id' selected >$name</option>";
							}else{
								echo "<option value='$id'>$name</option>";

							}
						}   
					
						?>
					</select>
					<p class="help-block"></p>
				 </div> 
			</div> 
			
			<div class="form-group"> 
				<label class="col-sm-2 modal-form pull-left control-label" for="Cost">Cost</label> 
				<div class="col-sm-9"> 
					<input type="text" placeholder="Cost" autocomplete="off" id="cost" name="cost" value="<?php  echo $cost;   ?>" onKeyPress="return isNumericKey(event)"  class="form-control">
					<p class="help-block"></p>
				 </div> 
			</div> 
			
			<div class="form-group"> 
				<label class="col-sm-2 modal-form pull-left control-label" for="rate">Rate</label> 
				<div class="col-sm-9"> 
					<input type="text" placeholder="Rate" autocomplete="off" id="rate" name="rate" value="<?php echo $rate;    ?>" onKeyPress="return isNumericKey(event)"  class="form-control">
					<p class="help-block"></p>
				 </div> 
			</div>
			<div class="form-group"> 
				<label class="col-sm-2 modal-form pull-left control-label" for="bankId">Bank</label> 
				<div class="col-sm-9"> 
					<select class="select2 form-control" name='bankId' autocomplete="off" id='bankId'>
							<option Value="">Select Bank</option>
							<?php
							  
							$bankRow= $conn->query("SELECT * FROM `tbl_banks` WHERE deleted = 0 ORDER BY id DESC");
							while($row = $bankRow->fetch_array()){
									$id = $row['id'];
									$name = $row['name'];
								if($banks_id == $id){
									echo "<option   value='$id' selected>$name</option>";
								}else{
									echo "<option   value='$id'>$name</option>";
								}
							}
							?>
					</select>
					<p class="help-block"></p>
				 </div> 
			</div>		
			<div class="form-group"> 
				<label class="col-sm-2 modal-form pull-left control-label" for="usefulAge">Usefull Life</label> 
				<div class="col-sm-9"> 
					<input type="text" placeholder="Usefull Life" id="usefulAge" autocomplete="off" onKeyPress="return isNumericKey(event)"  name="usefulAge" value = "<?php echo $useful_age; ?>" class="form-control">
					<p class="help-block"></p>
				 </div> 
			</div> 
			 
			<div class="form-group"> 
				<label class="col-sm-2 modal-form pull-left control-label" for="address">Description</label> 
				<div class="col-sm-9"> 
					<textarea    placeholder = "Description" autocomplete="off" name="description" name="description" class="form-control"><?php   echo $description; ?> </textarea>
					<p class="help-block"></p>
				 </div> 
			</div>
		<?php
 		}elseif($table == "tbl_vendor_bill_title"){
				$dataRow = $conn->query("SELECT * FROM `$table` WHERE deleted = 0 AND id = $id ORDER BY id DESC");
				$row = $dataRow->fetch_array();	
				extract($row);
		?> 
			<input name="table" value="<?php echo encryptIt($table); ?>" type="hidden"  />
			<input name="id" value="<?php echo encryptIt($id); ?>" type="hidden"  />
 			 															
			<div class="form-group"> 
				<label class="col-sm-2 modal-form pull-left control-label" for="data">Date</label> 
				<div class="col-sm-9"> 
					<input type="text" placeholder="Date" autocomplete="off" id="date"  onchange="checkDate(this.value)"  data-select='datepicker' value="<?php  echo $date;  ?>" name="date" class="form-control">
					<p class="help-block"></p>
				 </div> 
			</div>
			 
			<div class="form-group"> 
				<label class="col-sm-2 modal-form pull-left control-label" for="bankId">Vendor</label> 
				<div class="col-sm-9"> 
					<select class="select2 form-control" name='vendorId' onchange = "selectVendorCurrency(this.value)" autocomplete="off" id='vendorId'>
						<option Value="">Select Vendor</option>
						<?php
						 
						$vendorRow= $conn->query("SELECT * FROM `tbl_vendors` WHERE deleted = 0 ORDER BY id DESC");
						while($row = $vendorRow->fetch_array()){
							
							$id   = $row['id'];
							$name = $row['name'];
							if($id == $vendors_id){
								echo "<option value='$id' selected>$name</option>";
							}else{
								echo "<option value='$id' >$name</option>";
							}
				 
						}   
					
						?>
					</select>
					<p class="help-block"></p>
				 </div> 
			</div>	
			
			<div class="form-group"> 
				<label class="col-sm-2 modal-form pull-left control-label" for="bankId">Currency</label> 
				<div class="col-sm-9"> 
					<select class="select2 form-control" name='currenciesId' autocomplete="off" onchange="readCurrencyRate(this.value),selectBanks(this.value)"  id='currenciesId'>
					<option Value="">Select Currency</option>
					<?php
						$currenciesRow= $conn->query("SELECT * FROM `tbl_currencies` WHERE deleted = 0 AND id = $currencies_id ORDER BY id DESC");
						while($row = $currenciesRow->fetch_array()){
							
							$id   = $row['id'];
							$name = $row['code'];
							if($currencies_id == $id){
								echo "<option value='$id' selected >$name</option>";
							}else{
								echo "<option value='$id'>$name</option>";

							}
						} 
					?>					
					</select>
					<p class="help-block"></p>
				 </div> 
			</div>

			<div class="form-group"> 
				<label class="col-sm-2 modal-form pull-left control-label" for="bankId">Bank</label> 
				<div class="col-sm-9"> 
					<select class="select2 form-control" name='bankId' autocomplete="off" id='bankId'>
							<option Value="">Select Bank</option>
							<?php
							  
							$bankRow= $conn->query("SELECT * FROM `tbl_banks` WHERE deleted = 0 ORDER BY id DESC");
							while($row = $bankRow->fetch_array()){
									$id = $row['id'];
									$name = $row['name'];
								if($banks_id == $id){
									echo "<option   value='$id' selected>$name</option>";
								}else{
									echo "<option   value='$id'>$name</option>";
								}
							}
							?>
					</select>
					<p class="help-block"></p>
				 </div> 
			</div>				
			<div class="form-group"> 
				<label class="col-sm-2 modal-form pull-left control-label" for="address">Bill Number</label> 
				<div class="col-sm-9"> 
					<input type="text" placeholder="Bill Number" autocomplete="off" id="factorNumber" name="factorNumber" value="<?php  echo $factor_number;  ?>" class="form-control">
					<p class="help-block"></p>
				 </div> 
			</div>
			
			<div class="form-group"> 
				<label class="col-sm-2 modal-form pull-left control-label" for="rate">Rate</label> 
				<div class="col-sm-9"> 
					<input type="text" placeholder="Rate" autocomplete="off" id="rate" name="rate" value="<?php echo $rate;    ?>" class="form-control">
					<p class="help-block"></p>
				 </div> 
			</div>
			<div class="form-group"> 
				<label class="col-sm-2 modal-form pull-left control-label" for="address">Payment Amount</label> 
				<div class="col-sm-9"> 
					<input type="text" placeholder="Payment Amount"   autocomplete="off" id="factorPayment" name="factorPayment" value="<?php echo $factor_payment;  ?>" class="form-control">
					<p class="help-block"></p>
				 </div> 
			</div>
			
			<div class="form-group"> 
				<label class="col-sm-2 modal-form pull-left control-label" for="address">Description</label> 
				<div class="col-sm-9"> 
					<textarea    placeholder = " Factor Description" autocomplete="off" name="description" name="description" class="form-control"><?php   echo $description; ?> </textarea>
					<p class="help-block"></p>
				 </div> 
			</div>
		<?php
 		}elseif($table == "tbl_vendor_bill_details"){
				$dataRow = $conn->query("SELECT * FROM `$table` WHERE deleted = 0 AND id = $id ORDER BY id DESC");
				$row = $dataRow->fetch_array();	
				extract( $row);
		?> 
			<input name="table" value="<?php echo encryptIt($table); ?>" type="hidden"  />
			<input name="id" value="<?php echo encryptIt($id); ?>" type="hidden"  />
			<input name="oldStockAmount" value="<?php echo $amount; ?>" type="hidden"  />
			<input name="titleId" value="<?php echo $title_bills_id; ?>" type="hidden"  />
			<div class="form-group"> 
				<label class="col-sm-2 modal-form pull-left control-label" for="bankId">Item</label> 
				<div class="col-sm-9"> 
					 <select class="select2 form-control" name='itemId' onchange='selectItemUnit(this.value)' autocomplete="off" id='itemId'>
						<option Value="">Select Item</option>
						<?php
						 
						$itemsRow= $conn->query("SELECT * FROM `tbl_items` WHERE  deleted = 0 ORDER BY id DESC");
						while($row = $itemsRow->fetch_array()){
							
							$id   = $row['id'];
							$name = $row['name'];
							if($id == $items_id){
								echo "<option value='$id' selected >$name</option>";
							}else{
								echo "<option value='$id'>$name</option>";
							}
						}   
					
						?>
					</select>
					<p class="help-block"></p>
				 </div> 
			</div>	
			 
			<div class="form-group"> 
				<label class="col-sm-2 modal-form pull-left control-label" for="bankId">Item Unit</label> 
				<div class="col-sm-9"> 
					 <select class="select2 form-control"  name='itemUnit' autocomplete="off" id='itemUnit'>
						<option Value="">Select Unit</option> 
						<?php
						 
							$itemUnitRow = $conn->query("SELECT * FROM `tbl_item_units` WHERE id = $items_unit_id AND deleted = 0 ORDER BY id DESC");
							while($row = $itemUnitRow->fetch_array()){
								
								$id   = $row['id'];
								$name = $row['name'];
								 
									echo "<option value='$id' selected >$name</option>";
							}   
						
						?>
					</select>
					<p class="help-block"></p>
				 </div> 
			</div>	
			 
			<div class="form-group"> 
				<label class="col-sm-2 modal-form pull-left control-label" for="rate">Quantity</label> 
				<div class="col-sm-9"> 
					<input type="text" placeholder="Quantity" autocomplete="off" onkeyup="calculateTotal()" value="<?php  echo  $amount;  ?>" onKeyPress="return isNumericKey(event)"  id="amount" name="amount" class="form-control">
					<p class="help-block"></p>
				 </div> 
			</div>
			 
			<div class="form-group"> 
				<label class="col-sm-2 modal-form pull-left control-label" for="rate">Unit Price</label> 
				<div class="col-sm-9"> 
					<input type="text" placeholder="Fee" autocomplete="off" onkeyup="calculateTotal()" id="fee" value="<?php echo $fee;    ?>" onKeyPress="return isNumericKey(event)"  name="fee" class="form-control">
					<p class="help-block"></p>
				 </div> 
			</div> 
			
			<div class="form-group"> 
				<label class="col-sm-2 modal-form pull-left control-label" for="rate">Total Amount</label> 
				<div class="col-sm-9"> 
					<input type="text" placeholder="Total Amount" autocomplete="off" onkeyup="calculateTotal()" id="totalFee" onKeyPress="return isNumericKey(event)"  name="totalFee" class="form-control totalFee">
					<p class="help-block"></p>
				 </div> 
			</div>
			<div class="form-group"> 
				<label class="col-sm-2 modal-form pull-left control-label" for="bankId">Inventory</label> 
				<div class="col-sm-9"> 
					<select class="select2 form-control" name='stockId' autocomplete="off" id='stockId'>
						<option Value="">Select Inventory</option>
						<?php
						 
						$stockRow= $conn->query("SELECT * FROM `tbl_stocks` WHERE deleted = 0 ORDER BY id DESC");
						while($row = $stockRow->fetch_array()){
							
							$id   = $row['id'];
							$name = $row['name'];
							if($id == $stocks_id){
								echo "<option value='$id' selected>$name</option>";
							}else{
								echo "<option value='$id'>$name</option>";
							}
						}   
					
						?>
					</select>
					<p class="help-block"></p>
				 </div> 
			</div>
			<div class="form-group"> 
				<label class="col-sm-2 modal-form pull-left control-label" for="address">Description</label> 
				<div class="col-sm-9"> 
					<textarea    placeholder = " Factor Description" autocomplete="off" name="subDescription" name="subDescription" class="form-control"><?php   echo $description; ?> </textarea>
					<p class="help-block"></p>
				 </div> 
			</div>
		<?php
 		}
		?> 
		  <div class="form-group">
			<div class="col-sm-offset-2 col-sm-10">
			<button class="btn btn-success btn-outline" id="update" type="button"> ویرایش  <i class="fa fa-paste"></i>  </button>
			<button type="button"  id="btn" type="submit"class="btn btn-danger btn-outline" data-dismiss="modal"> لغو </button>    
			</div>
		  </div>