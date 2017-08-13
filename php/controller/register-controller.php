<?php
	require_once("../config/session.php");
	require_once("../model/user.php");
	require_once("../service/user-service.php");
	
	$obj = json_decode(file_get_contents('php://input'), true);

	if (!empty($obj)) {
		$firstname = $obj['firstname'];
		$lastname = $obj['lastname'];
		$username = $obj['username'];
		$password = $obj['password'];
		$email = $obj['email'];
		$phoneNumber = $obj['phoneNumber'];

		$user = new User();
		$user->setFirstname($firstname);
		$user->setLastname($lastname);
		$user->setUsername($username);
		$user->setPassword($password);
		$user->setEmail($email);
		$user->setPhoneNumber($phoneNumber);
		if(isset($obj['admin'])){
			$user->setAccountType("ADMIN");
		} else{
			$user->setAccountType("USER");
		}

		$userService = new UserService();

		$registered = $userService->registerUser($user);

		if ($registered) {
			echo json_encode(array("result" => $registered));
		} else{
			echo json_encode(array("result" => $registered));
		}
	}

?>