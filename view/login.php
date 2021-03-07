<?php
ob_start();
session_start();
require_once("../config/dbConstants.php");
require_once("../config/Database.php");
require_once("../config/necessaryFunctions.php");
$pageTitle = "Assist Consultants Incorporated | ACI - Login";
$conn = new Database(HOST, USERNAME, PASSWORD, DATABASE);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="Assist Tech Software Development Company Provides ICT Services and Consultations">
<meta name="keywords" content="Assist Tech, MIS, Abdul Sami, ICT, Web Design, Web Development, Kabul, Afghanistan">
<!-- Site favicon -->
<link rel='shortcut icon' type='image/x-icon' href='../assets/images/favicon.ico' />
<!-- /site favicon -->

<!-- Entypo font stylesheet -->
<link href="../assets/css/entypo.css" rel="stylesheet">
<!-- /entypo font stylesheet -->

<!-- Font awesome stylesheet -->
<link href="../assets/css/font-awesome.min.css" rel="stylesheet">
<!-- /font awesome stylesheet -->

<!-- CSS3 Animate It Plugin Stylesheet -->
<link href="../assets/css/plugins/css3-animate-it-plugin/animations.css" rel="stylesheet">
<!-- /css3 animate it plugin stylesheet -->

<!-- Bootstrap stylesheet min version -->
<link href="../assets/css/bootstrap.min.css" rel="stylesheet">
<!-- /bootstrap stylesheet min version -->

<!-- Mouldifi core stylesheet -->
<link href="../assets/css/mouldifi-core.css" rel="stylesheet">
<!-- /mouldifi core stylesheet -->

<link href="../assets/css/mouldifi-forms.css" rel="stylesheet">


<!-- Custome Stylesheet -->
<link href="../assets/css/custome.css" rel="stylesheet">
<!-- /Custome Stylesheet -->

<?php
if(isset($_POST['submit'])){
		//============================ Retrive Data From Form ===========================================================
		$username = $conn->safeInput($_POST['username']);
		$remember = $conn->safeInput($_POST['remember']);
		$password = $conn->safeInput($_POST['password']);
		$shaOneChange = hash('sha256',$password);
		$ePassword= encryptIt($shaOneChange);
		
		//============================ Check User ========================================================
		$usersRawSQLQuery   = "SELECT * FROM tbl_users WHERE `username`='$username' AND `password`='$ePassword' AND deleted = 0 AND status = 0";
		$usersSQLQuery      = $conn->query($usersRawSQLQuery);

		$isError=0;
		if($usersSQLQuery->num_rows > 0){
			
			$usersReturenedRows = $usersSQLQuery->fetch_array();
			$fetchedUsername= encryptIt($usersReturenedRows['username']);
			$fetchedPassword= encryptIt($usersReturenedRows['password']);
			$fetchedUserId  = encryptIt($usersReturenedRows['id']);
			$fetchUserIdLogin  = $usersReturenedRows['id'];
			$fetchUserType = $usersReturenedRows['user_type'];
			$currentTime = time();
			
			$insertQuery = $conn->query("INSERT INTO tbl_login_details (users_id,login_date,last_seen_visit) VALUES ('$fetchUserIdLogin','$currentTime','$currentTime')");
 			if($insertQuery){
				
				//Set Session
				$_SESSION['Login']   = TRUE; 
				$_SESSION['userId']  = strip_tags($fetchedUserId);
				$_SESSION['username']= strip_tags($fetchedUsername);
				$_SESSION['userType']= strip_tags($fetchUserType);
				$_SESSION['last_login_timpestamp']= time();
				
					header("location:index.php");
					exit();
			}else{
				$isError = 1;
			}
		}else{	
			$isError = 1;
		}
	}
?>
</head>
<body class="login-page">
	<div class="login-pag-inner">
		<div class="animatedParent animateOnce z-index-50">
			<div class="login-container animated growIn slower">
				<div class="login-branding">
					<img src="../assets/images/ACI.png" class="img img-responsive" />
				</div>

				<div class="login-content">
                    <?php
					     //Show Loging Error
						if($isError){
							echo "<div class='btn btn-danger btn-block animated fadeInDown' style='margin-bottom:10px;'>Login Faild</div>"; 
						}
					 ?>
					<h2 class=""> <img src="../assets/icons/welcome.png" style='width:60%;height:45px;'></img></h2>

					<form method="post" action="<?php htmlspecialchars($_SERVER['PHP_SELF']); ?>"> 
					
						<div class="form-group">
							<input type="text" name='username' placeholder="Username" class="form-control">
						</div>                        
						<div class="form-group">
							<input type="password" name='password' placeholder="Password" class="form-control">
						</div>
						<div class="form-group">
							 <div class="checkbox checkbox-replace checkbox-primary">
								<input type="checkbox" value="1" id="remember" name="remember"  >
								<label for="remember">Keep Me Login!</label>
							  </div>
						 </div>
						<div class="form-group">
							<button class="btn btn-primary btn-block" name="submit">Login</button>
						</div>
					</form>
				</div>
				
				 
			</div>
		</div>
	</div>
<!--Load JQuery-->
<script src="../assets/js/jquery.min.js"></script>
<!-- Load CSS3 Animate It Plugin JS -->
<script src="../assets/js/plugins/css3-animate-it-plugin/css3-animate-it.js"></script>
<script src="../assets/js/bootstrap.min.js"></script>
</body>
</html>