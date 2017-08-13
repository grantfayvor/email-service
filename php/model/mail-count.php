<?php
	class MailCount {

		private $allMails;
		private $sentMails;
		private $receivedMails;
		private $spamMails;
		private $systemMails;

		public function __construct($allMails, $sentMails, $receivedMails, $spamMails) {
			$this->allMails = $allMails;
			$this->sentMails = $sentMails;
			$this->receivedMails = $receivedMails;
			$this->spamMails = $spamMails;
		}

		public function getAllMails(){
			return $this->allMails;
		}

		public function getSentMails(){
			return $this->sentMails;
		}

		public function getReceivedMails(){
			return $this->receivedMails;
		}

		public function getSpamMails(){
			return $this->spamMails;
		}

		public function setSystemMails($systemMails){
			$this->systemMails = $systemMails;
		}

		public function getSystemMails(){
			return $this->systemMails;
		}
	}

?>