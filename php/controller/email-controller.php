<?php
	require_once("../config/session.php");
	require_once("../service/email-service.php");
	require_once("../service/user-service.php");
	require_once("../model/email.php");
	require_once("../model/mail-count.php");

	$obj = json_decode(file_get_contents('php://input'), true);

	$emailService = new EmailService();
	$userService = new UserService();

	if (isset($obj['sendMail'])) {
		$recipient = $userService->findUserIdByUsername($obj['recipient']);
		if($_SESSION['id'] == $recipient['id']){
			echo json_encode(array("result" => false));
		} elseif(is_null($recipient) || empty($recipient)){
			echo json_encode(array("result" => false));
		}
		 else{
			$email = new Email($_SESSION['id'], $recipient['id'], $obj['subject'], $obj['message']);
			echo json_encode(array("result" => $emailService->saveEmail($email)));
			// echo json_encode($spamService->saveExample($email->message, $email->isSpam() ? "spam" : 1));
		}
	} 

	if (isset($_GET['system'])) {
		$mails = array();
		$result = $emailService->findAllEmails();
		$i = 0;
		while($i < $result->num_rows){
			$row = $result->fetch_row();
			$row_array['id'] = $row[0];
			$row_array['senderId'] = $row[1];
			$row_array['recipientId'] = $row[2];
			$row_array['subject'] = $row[3];
			$row_array['message'] = $row[4];
			$row_array['dateSent'] = $row[6];
			$row_array['spam'] = $row[5];
			array_push($mails, $row_array);
			$i++;
		}
		echo json_encode($mails); 
	}

	if (isset($_GET['all'])) {
		$mails = array();
		$result = $emailService->findUserAllMails($_SESSION['id']);
		$i = 0;
		while($i < $result->num_rows){
			$row = $result->fetch_row();
			$row_array['id'] = $row[0];
			$row_array['senderId'] = $row[1];
			$row_array['recipientId'] = $row[2];
			$row_array['subject'] = $row[3];
			$row_array['message'] = $row[4];
			$row_array['dateSent'] = $row[6];
			$row_array['spam'] = $row[5];
			if($_SESSION['id'] == $row_array['senderId']){
				$row_array['mailType'] = "SENT";
			} elseif($_SESSION['id'] == $row_array['recipientId']){
				$row_array['mailType'] = "RECEIVED";
			} else{
				$row_array['mailType'] = "SPAM";
			}
			array_push($mails, $row_array);
			$i++;
		}
		echo json_encode($mails); 
	}

	if (isset($_GET['sent'])) {
		$mails = array();
		$result = $emailService->findUserSentMails($_SESSION['id']);
		$i = 0;
		while($i < $result->num_rows){
			$row = $result->fetch_row();
			$row_array['id'] = $row[0];
			$row_array['senderId'] = $row[1];
			$row_array['recipientId'] = $row[2];
			$row_array['subject'] = $row[3];
			$row_array['message'] = $row[4];
			$row_array['dateSent'] = $row[6];
			$row_array['spam'] = $row[5];
			array_push($mails, $row_array);
			$i++;
		}
		echo json_encode($mails); 
	}

	if (isset($_GET['received'])) {
		$mails = array();
		$result = $emailService->findUserReceivedMails($_SESSION['id']);
		$i = 0;
		while($i < $result->num_rows){
			$row = $result->fetch_row();
			$row_array['id'] = $row[0];
			$row_array['senderId'] = $row[1];
			$row_array['recipientId'] = $row[2];
			$row_array['subject'] = $row[3];
			$row_array['message'] = $row[4];
			$row_array['dateSent'] = $row[6];
			$row_array['spam'] = $row[5];
			array_push($mails, $row_array);
			$i++;
		}
		echo json_encode($mails); 
	}

	if (isset($_GET['spam'])) {
		$mails = array();
		$result = $emailService->findUserSpamMails($_SESSION['id']);
		$i = 0;
		while($i < $result->num_rows){
			$row = $result->fetch_row();
			$row_array['id'] = $row[0];
			$row_array['senderId'] = $row[1];
			$row_array['recipientId'] = $row[2];
			$row_array['subject'] = $row[3];
			$row_array['message'] = $row[4];
			$row_array['dateSent'] = $row[6];
			$row_array['spam'] = $row[5];
			array_push($mails, $row_array);
			$i++;
		}
		echo json_encode($mails); 
	}

	if (isset($_GET['count'])) {
		if($_SESSION['role'] == "USER"){
			$mailCount = $emailService->countUserMails($_SESSION['id']);
			$mailCount = array('allMails' => $mailCount->getAllMails(), 'sentMails' => $mailCount->getSentMails(), 'receivedMails' => $mailCount->getReceivedMails(), 'spamMails' => $mailCount->getSpamMails());
		} elseif ($_SESSION['role'] == "ADMIN") {
			$mailCount = $emailService->countUserMails($_SESSION['id']);
			$systemMailCount = $emailService->countSystemMails();
			$mailCount = array('systemMails' => $systemMailCount, 'allMails' => $mailCount->getAllMails(), 'sentMails' => $mailCount->getSentMails(), 'receivedMails' => $mailCount->getReceivedMails(), 'spamMails' => $mailCount->getSpamMails());
		}
		echo json_encode($mailCount);
	}

	if(isset($_GET['isspam'])){
		if($_SESSION['role'] == "ADMIN"){
			$result = $emailService->setAsSpam($_GET['emailId']);
			echo json_encode(array('result' => $result));
		}
	}

	if(isset($_GET['isham'])){
		if($_SESSION['role'] == "ADMIN"){
			$result = $emailService->setAsHam($_GET['emailId']);
			echo json_encode(array('result' => $result));
		}
	}

?>