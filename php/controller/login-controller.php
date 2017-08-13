<?php
	require_once("../config/session.php");
	require_once("../service/user-service.php");
	
	$obj = json_decode(file_get_contents('php://input'), true);

	if(!empty($obj)){

		$username = $obj['username'];
		$password = $obj['password'];

		$userService = new UserService();

		$authenticatedUser = $userService->authenticateUser($username, $password);

	}

	if(isset($authenticatedUser['id'])){
		$_SESSION['id'] = $authenticatedUser['id'];
		$_SESSION['role'] = $authenticatedUser['account_type'];
		$_SESSION['user'] = $authenticatedUser['username'];
		echo json_encode(array("role" => $_SESSION['role']));
	}

	if(isset($_GET['logout'])){
		echo session_destroy();
	}
?>