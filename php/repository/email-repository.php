<?php
	require_once("../config/database.php");
	require_once("../model/email.php");
	
	class EmailRepository {

		private $database;

		public function __construct(){
			$this->database = new Database();
		}

		public function findAll(){
			$sql = "SELECT * FROM email ORDER BY date_sent DESC";
			return $this->database->query($sql);
		}

		public function findMessageById($emailId){
			$emailId = $this->database->escapeString($emailId);
			$sql = "SELECT message FROM email WHERE id = '{$emailId}'";
			return $this->database->query($sql);
		}

		public function save($email){
			$senderId = $this->database->escapeString($email->getSenderId());
			$recipientId = $this->database->escapeString($email->getRecipientId());
			$subject = $this->database->escapeString($email->getSubject());
			$message = $this->database->escapeString($email->getMessage());
			$spam = $this->database->escapeString($email->isSpam());

			$sql = "INSERT INTO email(sender_id, recipient_id, subject, message, spam, date_sent) VALUES ('{$senderId}', '{$recipientId}', '{$subject}', '{$message}', '{$spam}', NOW())";

			return $this->database->query($sql);
		}

		public function findUserAllMails($userId){
			$userId = $this->database->escapeString($userId);

			$sql = "SELECT * FROM email WHERE sender_id = '{$userId}' OR recipient_id = '{$userId}' AND !spam ORDER BY date_sent DESC";

			return $this->database->query($sql);
		}

		public function findUserSentMails($userId){
			$userId = $this->database->escapeString($userId);

			$sql = "SELECT * FROM email WHERE sender_id = '{$userId}' ORDER BY date_sent DESC";

			return $this->database->query($sql);
		}

		public function findUserReceivedMails($userId){
			$userId = $this->database->escapeString($userId);

			$sql = "SELECT * FROM email WHERE recipient_id = '{$userId}' AND !spam ORDER BY date_sent DESC";

			return $this->database->query($sql);
		}

		public function findUserSpamMails($userId){
			$userId = $this->database->escapeString($userId);

			$sql = "SELECT * FROM email WHERE recipient_id = '{$userId}' AND spam ORDER BY date_sent DESC";

			return $this->database->query($sql);
		}

		public function setAsSpam($emailId){
			$emailId = $this->database->escapeString($emailId);
			$sql = "UPDATE email SET spam = 1 WHERE id = '{$emailId}'";
			return $this->database->query($sql);
		}

		public function setAsHam($emailId){
			$emailId = $this->database->escapeString($emailId);
			$sql = "UPDATE email SET spam = 0 WHERE id = '{$emailId}'";
			return $this->database->query($sql);
		}

	}