<?php
	require_once("../php/config/session.php");

	if (!isset($_SESSION['id'])) {
		header("Location: ../../email/resources/login.html");
	}

    if($_SESSION['role'] != "ADMIN"){
        header("Location: index.php");
    }
?>

<!DOCTYPE html>
<html lang="en" data-ng-app="email">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="">
	<meta name="author" content="">
	<title>Register Admin | Email-service</title>
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/font-awesome.min.css" rel="stylesheet">
	<link href="css/prettyPhoto.css" rel="stylesheet">
	<link href="css/price-range.css" rel="stylesheet">
	<link href="css/animate.css" rel="stylesheet">
	<link href="css/main.css" rel="stylesheet">
	<link href="css/responsive.css" rel="stylesheet">
	<!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]-->
	<link rel="shortcut icon" href="images/ico/favicon.ico">
	<link rel="apple-touch-icon-precomposed" sizes="144x144" href="images/ico/apple-touch-icon-144-precomposed.png">
	<link rel="apple-touch-icon-precomposed" sizes="114x114" href="images/ico/apple-touch-icon-114-precomposed.png">
	<link rel="apple-touch-icon-precomposed" sizes="72x72" href="images/ico/apple-touch-icon-72-precomposed.png">
	<link rel="apple-touch-icon-precomposed" href="images/ico/apple-touch-icon-57-precomposed.png">
</head>
<!--/head-->

<body data-ng-controller="UserController">

	<!--<section id="form">-->
	<!--form-->
	<div class="container">
		<div class="row">
			<div class="row">
				<div class="col-sm-12" style="margin-top:40px;">
					<a href="admin.php"> <h2 class="title">EMAIL <strong>SERVICE</strong></h2></a>
				</div>
			</div>
			<div class="col-sm-4" style="margin-top:60px; margin-right:30%; margin-left:30%; margin:auto;">
				<div class="signup-form login-form">
					<!--sign up form-->
					<h2>New Admin Signup!</h2>
					<div id="fade1" class="status alert alert-success" data-ng-show="registered == 1">User has successfully been registered</div>
					<div id="fade2" class="status alert alert-danger" data-ng-show="registered == 0">Username already exists</div>
					<form>
						<input type="text" placeholder="Firstname" name="firstname" data-ng-model="new_user.firstname" />
						<input type="text" placeholder="Lastname" name="lastname" data-ng-model="new_user.lastname" />
						<input type="text" placeholder="Username" name="username" data-ng-model="new_user.username" />
						<input type="email" placeholder="Email Address" name="email" data-ng-model="new_user.email" />
						<input type="text" placeholder="Phone Number" name="phoneNumber" data-ng-model="new_user.phoneNumber" />
						<input type="password" name="password" placeholder="Password" data-ng-model="new_user.password" />
                        <span>
								<input type="checkbox" class="checkbox" data-ng-model="new_user.admin"> 
								Register as admin
							</span>
						<button type="submit" class="btn btn-default" data-ng-click="registerAdmin()">Signup</button>
					</form>
				</div>
				<!--/sign up form-->
			</div>
		</div>
	</div>
	<!--</section>-->
	<!--/form-->

	<script src="js/jquery.js"></script>
	<script src="js/price-range.js"></script>
	<script src="js/jquery.scrollUp.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/jquery.prettyPhoto.js"></script>
	<script src="js/main.js"></script>
	<script type="text/javascript" src="../app/angular.js"></script>
	<script type="text/javascript" src="../app/config/config.js"></script>
	<script type="text/javascript" src="../app/service/api-service.js"></script>
	<script type="text/javascript" src="../app/modules/user/user.js"></script>

</body>

</html>