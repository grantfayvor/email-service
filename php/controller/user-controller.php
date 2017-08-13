<?php
	require_once("../config/session.php");
	require_once("../model/user.php");
	require_once("../service/user-service.php");
    
    if(isset($_GET['id'])){
        $userService = new UserService();
        $username = $userService->findUsernameByUserId(($_GET['id']));
        echo json_encode($username);
    }

    if(isset($_GET['user'])){
        echo json_encode($_SESSION['user']);
    }

?>