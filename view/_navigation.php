<!-- Site header  -->
		<header class="site-header">
		  <div class="site-logo"><a href="index.php"><img style="display: none;" id="logo" src="../assets/images/ACI.png" alt="Erteqa Soft" title="Erteqa Soft"></a></div>
		  <div class="sidebar-collapse hidden-xs"><a class="sidebar-collapse-icon" href="#"><i class="icon-menu"></i></a></div>
		  <div class="sidebar-mobile-menu visible-xs"><a data-target="#side-nav" data-toggle="collapse" class="mobile-menu-icon" href="#"><i class="icon-menu"></i></a></div>
		</header>
		<!-- /site header -->
		
		<!-- Main navigation -->
		<ul id="side-nav" class="main-menu navbar-collapse collapse">
			<li class=""><a href="index.php"><i class="fa fa-home"></i><span class="title">صفحه اصلی</span></a></li>
			<li class="has-sub <?php if($menu === "definationAT") echo "active"; ?>"><a href="javascript:void(0);"><i class="fa fa-list-ul"></i><span class="title">تعریف ها</span></a>
				<ul class="nav collapse">
 					<li class="<?php echo addActiveClass("ItemCategoryAT"); ?>"><a href="addItemCategoryAT.php" target="_"><i class="fa fa-plus"></i><span class="title">ثبت کتگوری اجناس</span></a></li>
					<li class="<?php echo addActiveClass("ItemUnitAT"); ?>"><a href="addItemUnitAT.php" target="_"><i class="fa fa-plus"></i><span class="title">ثبت واحد اجناس</span></a></li>
					<li class="<?php echo addActiveClass("addItemAT"); ?>"><a href="addItemAT.php" target="_"><i class="fa fa-plus"></i><span class="title">ثبت اجناس</span></a></li>
   				</ul>
			</li>
			
			<li class="has-sub <?php if($menu === "stocksAT") echo "active"; ?>"><a href="javascript:void(0);"><i class="fa fa-building"></i><span class="title">گدام</span></a>
				<ul class="nav collapse">
					<li class="<?php echo addActiveClass("StockAT"); ?>"><a href="addStockAT.php" target="_"><i class="fa fa-plus"></i><span class="title">ثبت گدام</span></a></li>
					<li class="<?php echo addActiveClass("stockTransferAT"); ?>"><a href="stockTransferAT.php" target="_"><i class="fa fa-plus"></i><span class="title">انتقال بین گدامها</span></a></li>
 				</ul>
			</li>
			 
			<li class="has-sub <?php if($menu === "schoolsAT") echo "active"; ?>"><a href="javascript:void(0);"><i class="fa fa-list-ul"></i><span class="title">مکاتب</span></a>
				<ul class="nav collapse">
					<li class="<?php echo addActiveClass("addDistrictsAT"); ?>"><a href="addDistrictsAT.php"  target="_"><i class="fa fa-plus"></i><span class="title">ثبت ولسوالی</span></a></li>
				 <!--	<li class="<?php echo addActiveClass("addManagerAT"); ?>"><a href="addManagerAT.php" target="_"><i class="fa fa-plus"></i><span class="title">ثبت مدیر</span></a></li>-->
					<li class="<?php echo addActiveClass("addSchoolsAT"); ?>"><a href="addSchoolsAT.php" target="_"><i class="fa fa-plus"></i><span class="title">ثبت مکتب</span></a></li>
					<li class="<?php echo addActiveClass("addOrganizationsRequestAT"); ?>"><a href="addOrganizationsRequestAT.php" target="_"><i class="fa fa-plus"></i><span class="title">ثبت درخواست ها </span></a></li>
					<li class="<?php echo addActiveClass("requestStatusDetailsAT"); ?>"><a href="requestStatusDetailsAT.php" target="_"><i class="fa fa-plus"></i><span class="title">وضعیت درخواست ها</span></a></li>
					<li class="<?php echo addActiveClass("addSchoolExpensesCategoryAT"); ?>"><a href="addSchoolExpensesCategoryAT.php" target="_"><i class="fa fa-plus"></i><span class="title"> ثبت کتگوری مصارف</span></a></li>
					<li class="<?php echo addActiveClass("addOrgGenralExpenseTransactionsAT.php"); ?>"><a href="addOrgGenralExpenseTransactionsAT.php" target="_"><i class="fa fa-plus"></i><span class="title">ثبت مصارف تعمیراتی</span></a></li>
					<li class="<?php echo addActiveClass("addSupportCeremoniesTransactions"); ?>"><a href="addSupportCeremoniesTransactions.php" target="_"><i class="fa fa-plus"></i><span class="title">ثبت مصارف تمویل</span></a></li>
					<li class="<?php echo addActiveClass("addMaterialsDistributionsAT"); ?>"><a href="addMaterialsDistributionsAT.php" target="_"><i class="fa fa-plus"></i><span class="title">ثبت توزیع اقلام</span></a></li>
				 	<li class="<?php echo addActiveClass("organizationAccountsAT"); ?>"><a href="organizationAccountsAT.php"  ="_"><i class="fa fa-plus"></i><span class="title">حسابات مکتب</span></a></li>
				</ul>
			</li>
			
			<li class="has-sub <?php if($menu === "banksAT") echo "active"; ?>"><a href="javascript:void(0);"><i class="fa fa-money"></i><span class="title">حسابات بانک</span></a>
				<ul class="nav collapse">
 					<li class="<?php echo addActiveClass("addBankCategory"); ?>"><a href="addBankCategory.php" target="_"><i class="fa fa-plus"></i><span class="title">ثبت کتگوری بانک</span></a></li>
					<li class="<?php echo addActiveClass("BankETQ"); ?>"><a href="addBankETQ.php" target="_"><i class="fa fa-plus"></i><span class="title">ثبت بانک</span></a></li>
					<li class="<?php echo addActiveClass("bankTransactionETQ"); ?>"><a href="bankTransactionETQ.php" target="_"><i class="fa fa-user-secret"></i><span class="title">بانک ترانزکشن</span></a></li>
					<li class="<?php echo addActiveClass("bankTransferETQ"); ?>"><a href="bankTransferETQ.php" target="_"><i class="fa fa-user-secret"></i><span class="title">انتقالات بانکی</span></a></li>
 					<li class="<?php echo addActiveClass("bankAccountETQ"); ?>"><a href="bankAccountETQ.php" target="_"><i class="fa fa-user-secret"></i><span class="title">حسابات بانک</span></a></li>
				</ul>
			</li>
			<li class="has-sub <?php if($menu === "vendorsAT") echo "active"; ?>"><a href="javascript:void(0);"><i class="fa fa-user"></i><span class="title">فروشنده</span></a>
				<ul class="nav collapse">
					<li class="<?php echo addActiveClass("addVendorCategoryAT"); ?>"><a href="addVendorCategoryAT.php" target="_"><i class="fa fa-user-plus"></i><span class="title">ثبت نوع فروشنده</span></a></li>
					<li class="<?php echo addActiveClass("addVendorAT"); ?>"><a href="addVendorAT.php" target="_"><i class="fa fa-user-plus"></i><span class="title">ثبت فروشنده</span></a></li>
					<li class="<?php echo addActiveClass("purchasesBillAT"); ?>"><a href="purchasesBillAT.php" target="_"><i class="fa fa-file-word-o"></i><span class="title">فاکتور</span></a></li>
					<li class="<?php echo addActiveClass("vendorPaymentAT"); ?>"><a href="vendorPaymentAT.php" target="_"><i class="fa fa-file-word-o"></i><span class="title">پرداخت فروشنده</span></a></li>
					<li class="<?php echo addActiveClass("vendorAccountAT"); ?>"><a href="vendorAccountAT.php" target="_"><i class="fa fa-user-secret"></i><span class="title">حسابات فروشنده</span></a></li>
				</ul>
			</li>
			 
			<li class="has-sub <?php if($menu === "helpingAT") echo "active"; ?>"><a href="javascript:void(0);"><i class="fa fa-user"></i><span class="title">کمک رسانی</span></a>
				<ul class="nav collapse">
					<li class="<?php echo addActiveClass("addInterefaceOrgAT"); ?>"><a href="addInterefaceOrgAT.php" target="_"><i class="fa fa-plus"></i><span class="title">ثبت رابط</span></a></li>
					<li class="<?php echo addActiveClass("addEducationDegreeAT"); ?>"><a href="addEducationDegreeAT.php" target="_"><i class="fa fa-plus"></i><span class="title">ثبت درجه تحصیل</span></a></li>
					<li class="<?php echo addActiveClass("addRecipientsAT"); ?>"><a href="addRecipientsAT.php" target="_"><i class="fa fa-user-plus"></i><span class="title">ثبت کمک گیرنده</span></a></li>
 					<li class="<?php echo addActiveClass("recipentPaymentAidAT"); ?>"><a href="recipentPaymentAidAT.php" target="_"><i class="fa fa-file-word-o"></i><span class="title">پرداخت کمک</span></a></li>
					<li class="<?php echo addActiveClass("recipientAccountsAT"); ?>"><a href="recipientAccountsAT.php" target="_"><i class="fa fa-file-word-o"></i><span class="title">حسابات کمک شده</span></a></li>
 				</ul>
			</li>
			
			<li class="has-sub <?php if($menu === "expensesETQ") echo "active"; ?>"><a href="javascript:void(0);"><i class="glyphicon glyphicon-oil"></i><span class="title">مصارف</span></a>
				<ul class="nav collapse">
					<li class="<?php echo addActiveClass("ExpenseCategoryETQ"); ?>"><a href="addExpenseCategoryETQ.php" target="_"><i class="fa fa-plus"></i><span class="title"> ثبت کتگوری مصارف</span></a></li>
					<li class="<?php echo addActiveClass("ExpenseTypeETQ"); ?>"><a href="addExpenseTypeETQ.php" target="_"><i class="fa fa-plus"></i><span class="title">ثبت نوع مصارف</span></a></li>
					<li class="<?php echo addActiveClass("ExpenseETQ"); ?>"><a href="addExpenseETQ.php" target="_"><i class="fa fa-money"></i><span class="title">ثبت مصرف</span></a></li>
					<li class="<?php echo addActiveClass("addMultiExpensesACI"); ?>"><a href="addMultiExpensesACI.php" target="_" ><i class="fa fa-money"></i><span class="title">ثبت چندین مصرف</span></a></li>
 					<!--- <li class="<?php echo addActiveClass("expensesServicesReportAT"); ?>"><a href="expensesServicesReportAT.php" target="_"><i class="fa fa-money"></i><span class="title">Expenses Services Reports</span></a></li> ---->
				</ul>
			</li>
			<li class="has-sub <?php if($menu === "staffETQ") echo "active"; ?>"><a href="javascript:void(0);"><i class="fa fa-user"></i><span class="title">ثبت کارمندان</span></a>
				<ul class="nav collapse">
					<li class="<?php echo addActiveClass("StaffETQ"); ?>"><a href="addStaffETQ.php"><i class="fa fa-user-plus"></i><span class="title">ثبت کارمند</span></a></li>
 				</ul>
			</li>
			<li class="has-sub <?php if($menu === "dealerETQ") echo "active"; ?>"><a href="javascript:void(0);"><i class="fa fa-user"></i><span class="title">قرض گیرنده</span></a>
				<ul class="nav collapse">
					<li class="<?php echo addActiveClass("DealerETQ"); ?>"><a href="addDealerETQ.php" target="_"><i class="fa fa-user-plus"></i><span class="title">ثبت قرض گیرنده</span></a></li>
					<li class="<?php echo addActiveClass("dealerPaymentETQ"); ?>"><a href="dealerPaymentETQ.php" target="_"><i class="fa fa-user-secret"></i><span class="title">پرداخت قرض گیرنده</span></a></li>
					<li class="<?php echo addActiveClass("dealerAccountETQ"); ?>"><a href="dealerAccountETQ.php" target="_"><i class="fa fa-user-secret"></i><span class="title">حسابات قرض گیرنده</span></a></li>
 				</ul>
			</li>
 			<!---- <li class="has-sub <?php if($menu === "helpingAT") echo "active"; ?>"><a href="javascript:void(0);"><i class="fa fa-list-ul"></i><span class="title">کمک ها </span></a>
				<ul class="nav collapse">
					<li class="<?php echo addActiveClass("addRelativePersonAT"); ?>"><a href="addRelativePersonAT.php" target="_"><i class="fa fa-plus"></i><span class="title">ثبت فرد رابط</span></a></li>
					<li class="<?php echo addActiveClass("addLocationsAT"); ?>"><a href="addLocationsAT.php"  ="_"><i class="fa fa-plus"></i><span class="title">ثبت منطقه </span></a></li>
					<li class="<?php echo addActiveClass("addPoorsAT"); ?>"><a href="addPoorsAT.php" target="_"><i class="fa fa-plus"></i><span class="title">ثبت مستحقین</span></a></li>
					<li class="<?php echo addActiveClass("addMultPoorsAT"); ?>"><a href="addMultPoorsAT.php" target="_"><i class="fa fa-plus"></i><span class="title">ثبت مستحقین بیشتر</span></a></li>
					<li class="<?php echo addActiveClass("setDefaults"); ?>"><a href="setDefaultsAT.php"><i class="fa fa-user"></i><span class="title">تعین پیش فرض ها</span></a></li>
				</ul>
			</li>
		
			<li class="has-sub <?php if($menu === "distributionAT") echo "active"; ?>"><a href="distributionHelpingAT.php" ><i class="fa fa-list-ul"></i><span class="title">توزیع کمک ها</span></a>
			 
			</li>
			
			 ---->
			<li class="has-sub <?php if($menu === "reportsAT") echo "active"; ?>"><a href="javascript:void(0);"><i class="fa fa-list-ul"></i><span class="title">گزارشات</span></a>
				<ul class="nav collapse">
 					<li class="<?php echo addActiveClass("stockBalanceHomeAT"); ?>"><a href="stockBalanceHomeAT.php" target="_"><i class="fa fa-user"></i><span class="title">گدام ها </span></a></li> 
  					<li class="<?php echo addActiveClass("expenseTotalReportETQ"); ?>"><a href="expenseTotalReportETQ.php" target="_"><i class="glyphicon glyphicon-tree-deciduous"></i><span class="title">مصارف متفرقه</span></a></li>
 					<li class="<?php echo addActiveClass("banksReportsAT"); ?>"><a href="banksReportsAT.php" target="_"><i class="glyphicon glyphicon-list-alt"></i><span class="title">بانک ها </span></a></li>
					<li class="<?php echo addActiveClass("genralReportETQ"); ?>"><a href="genralReportETQ.php" target="_"><i class="glyphicon glyphicon-list-alt"></i><span class="title">گزارش قرض ها </span></a></li>
					<li class="<?php echo addActiveClass("dailyReportsAT"); ?>"><a href="dailyReportsAT.php" target="_"><i class="glyphicon glyphicon-list-alt"></i><span class="title">گزارشات روزانه</span></a></li>
				</ul>
			</li>
			<li class="has-sub <?php if($menu === "systemManagementETQ") echo "active"; ?>"><a href="javascript:void(0);"><i class="fa fa-cog"></i><span class="title">مدیریت</span></a>
				<ul class="nav collapse">
					<li class="<?php echo addActiveClass("setDefaults"); ?>"><a href="setDefaultsAT.php"><i class="fa fa-user"></i><span class="title">تعین پیش فرض ها</span></a></li>
					<li class="<?php echo addActiveClass("addUserETQ"); ?>"><a href="addUserETQ.php"><i class="fa fa-user"></i><span class="title">ثبت کاربر</span></a></li>
					<li class="<?php echo addActiveClass("responsibleUserACI"); ?>"><a href="responsibleUserACI.php"><i class="fa fa-users"></i><span class="title">مسئولیت کاربرها</span></a></li>
					<li class="<?php echo addActiveClass("userStatusMessage"); ?>"><a href="userStatusMessage.php	"><i class="fa fa-user"></i><span class="title">حالت کاربرها</span></a></li>
					<li class="<?php echo addActiveClass("addPositionAT"); ?>"><a href="addPositionAT.php"><i class="fa fa-plus"></i><span class="title">ثبت وظیفه</span></a></li>
					<li class="<?php echo addActiveClass("givenBackupACI"); ?>"><a href="givenBackupACI.php"><i class="glyphicon glyphicon-download-alt"></i><span class="title">پشتیبانی سیستم</span></a></li>
					<li class="<?php echo addActiveClass("checkRestore"); ?>"><a href="checkRestore.php"><i class="glyphicon glyphicon-upload"></i><span class="title">برگشت دتابس</span></a></li>
					<li class="<?php echo addActiveClass("loginLogDetailsACI"); ?>"><a href="loginLogDetailsACI.php"><i class="glyphicon glyphicon-download-alt"></i><span class="title">حزئیات ورودی و خروجی کاربر</span></a></li>
 					<li><a href="logout.php"><i class="glyphicon glyphicon-log-out"></i><span class="title">خروج</span></a></li>
				</ul>
			</li>
			
		</ul>
		<!-- /main navigation -->