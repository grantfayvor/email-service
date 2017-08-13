<?php
	class Email {

		private $id;
		private $senderId;
		private $recipientId;
		private $subject;
		private $message;
		private $spam;
		private $dateSent;

		/*public function __construct() {
		}*/

		public function __construct($senderId, $recipientId, $subject, $message) {
			$this->senderId = $senderId;
			$this->recipientId = $recipientId;
			$this->subject = $subject;
			$this->message = $message;
		}

		public function setId($id){
			$this->id = $id;
		}

		public function getId(){
			return $this->id;
		}

		public function setSenderId($senderId){
			$this->senderId = $senderId;
		}

		public function getSenderId(){
			return $this->senderId;
		}

		public function setRecipientId($recipientId){
			$this->recipientId = $recipientId;
		}

		public function getRecipientId(){
			return $this->recipientId;
		}

		public function setSubject($subject){
			$this->subject = $subject;
		}

		public function getSubject(){
			return $this->subject;
		}

		public function setMessage($message){
			$this->message = $message;
		}

		public function getMessage(){
			return $this->message;
		}

		public function setSpam($spam){
			$this->spam = $spam;
		}

		public function isSpam(){
			return $this->spam;
		}

		public function getDateSent(){
			return $this->dateSent;
		}
	}