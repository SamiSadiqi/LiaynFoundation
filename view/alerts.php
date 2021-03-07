<span class="hide text-info" id="duplicate2" style="text-align:center;font-size:20px;margin-bottom:30px;"><div class='alert alert-info' >هشدار! اطلاعات وارده موجود است.</div></span>
<span class="hide text-warning" id="empty" style="text-align:center;font-size:20px;margin-bottom:30px;"><div class='alert alert-warning' >هشدار : فورم خالی میباشد!</div></span>
<span class="hide text-danger" id="error" style="text-align:center;font-size:20px;margin-bottom:30px;"><div class='alert alert-danger'>هشدار! اطلاعات متاسفانه ثبت نشد، دوباره امتحان نمایید.</div></span>
<span class="hide text-warning" id="deleted" style="text-align:center;font-size:20px;margin-bottom:30px;"><div class='alert alert-warning'>اطلاعات موفقانه حذف گردید!</div></span>
<span class="hide text-success" id="saved" style="text-align:center;font-size:20px;margin-bottom:30px;"><div class='alert alert-success'>تبریک!اطلاعات وارده موفقانه ثبت گردید.</div></span>
 <?php   
		if($_SERVER['REQUEST_METHOD'] == 'GET' AND isset($_GET["save"])){
		?>	
			<div id='alertId' class="alert alert-success" style='margin-right:20%;margin-left:35%'>
			  <p style='text-align:center' ><strong>موفق!</strong>اطلاعات موفقانه ذخیره شد.</p>
			</div>
		<?php 
		}else if($_SERVER['REQUEST_METHOD'] == 'GET' AND isset($_GET["duplicate"])){
		?>
			<div id='alertId' class="alert alert-warning" style='margin-right:20%;margin-left:35%'>
			  <strong>هشدار!</strong> اطلاعات وارده تکرار می باشد.
			</div>
		<?php
		}else if($_SERVER['REQUEST_METHOD'] == 'GET' AND isset($_GET["error"])){
	 
		?>
			<div id='alertId' class="alert alert-danger" style='margin-right:20%;margin-left:35%'>
			  <strong>معلومات!</strong> اطلاعات اشتباهی وارد شده است
			</div>
		<?php
		}
		  
		if($_SERVER['REQUEST_METHOD'] == 'GET' AND isset($_GET["edit"])){
		?>	
			<div id='alertId' class="alert alert-success" style='margin-right:20%;margin-left:35%'>
			  <p style='text-align:center' ><strong>Success!</strong> Your Date Successfully Edited.</p>
			</div>
		<?php 
		}  
		if($_SERVER['REQUEST_METHOD'] == 'GET' AND isset($_GET["deleted"])){
		?>	
			<div id='alertId' class="alert alert-success" style='margin-right:20%;margin-left:35%'>
			  <p style='text-align:center' ><strong>Success!</strong> Your Data Successfully Deleted</p>
			</div>
		<?php 
		}
?>