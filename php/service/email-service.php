<?php
	require_once("../repository/email-repository.php");
	require_once("../model/email.php");
	require_once("../model/mail-count.php");
	require_once("spam-service.php");
	require_once("user-service.php");
	
	class EmailService {

		private $repository;
		
		public function __construct() {
			$this->repository = new EmailRepository();
		}

		public function findAllEmails(){
			return $this->repository->findAll();
		}

		public function saveEmail($email){
			$spamService = new SpamService();
			$email->setSpam($spamService->isItSpam($email->getMessage()));
			$spamService->saveExample($email->getMessage(), $email->isSpam() ? "spam" :1);
			return $this->repository->save($email);
		}

		public function getUsernameByUserId($id){
			$userService = new UserService();
			return $userService->findUsernameByUserId($id);
		}

		public function findUserAllMails($userId){
			return $this->repository->findUserAllMails($userId);
		}

		public function findUserSentMails($userId){
			return $this->repository->findUserSentMails($userId);
		}

		public function findUserReceivedMails($userId){
			return $this->repository->findUserReceivedMails($userId);
		}

		public function findUserSpamMails($userId){
			return $this->repository->findUserSpamMails($userId);
		}

        public function findMessageById($emailId){
            return $this->repository->findMessageById($emailId);
        }

		public function countUserMails($userId){
			// $allMailCount = $this->countUserAllMails($_SESSION['id']);
			$sentMailCount = $this->countUserSentMails($_SESSION['id']);
			$receivedMailCount = $this->countUserReceivedMails($_SESSION['id']);
			$spamMailCount = $this->countUserSpamMails($_SESSION['id']);
			$allMailCount = $sentMailCount + $receivedMailCount;
			$mailCount = new MailCount($allMailCount, $sentMailCount, $receivedMailCount, $spamMailCount);
			return $mailCount;
		}

        public function countSystemMails(){
			return $this->findAllEmails()->num_rows;
		}

		public function countUserAllMails($userId){
			return $this->findUserAllMails($userId)->num_rows;
		}

		public function countUserSentMails($userId){
			return $this->findUserSentMails($userId)->num_rows;
		}

		public function countUserReceivedMails($userId){
			return $this->findUserReceivedMails($userId)->num_rows;
		}

		public function countUserSpamMails($userId){
			return $this->findUserSpamMails($userId)->num_rows;
		}

        public function setAsSpam($emailId){
            $spamService = new SpamService();
            $row = $this->findMessageById($emailId)->fetch_row();
            $spamService->updateExample($row[0], "spam");
            return $this->repository->setAsSpam($emailId);
        }

        public function setAsHam($emailId){
            $spamService = new SpamService();
            $row = $this->findMessageById($emailId)->fetch_row();
            $spamService->updateExample($row[0], "1");
            return $this->repository->setAsHam($emailId);
        }

	}