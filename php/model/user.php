<?php
	class User {

		private $id;
		private $firstname;
		private $lastname;
		private $username;
		private $email;
		private $password;
		private $phoneNumber;
		private $accountType;

		public function __construct(){
			
		}

		/*public function __construct($username, $password){
			$this->username = $username;
			$this->password = $password;
		}*/

		/*public function __construct($firstname, $lastname, $username, $email, $password, $phoneNumber){
			$this->firstname = $firstname;
			$this->lastname = $lastname;
			$this->username = $username;
			$this->email = $email;
			$this->password = $password;
			$this->phoneNumber = $phoneNumber
		}
		*/

		public function setId($id){
			$this->id = $id;
		}

		public function getId(){
			return $this->id;
		}
		
		public function setFirstname($firstname){
			$this->firstname = $firstname;
		}

		public function getFirstname(){
			return $this->firstname;
		}

		public function setLastname($lastname){
			$this->lastname = $lastname;
		}

		public function getLastname(){
			return $this->lastname;
		}

		public function setUsername($username){
			$this->username = $username;
		}

		public function getUsername(){
			return $this->username;
		}

		public function setEmail($email){
			$this->email = $email;
		}

		public function getEmail(){
			return $this->email;
		}

		public function setPassword($password){
			$this->password = $password;
		}

		public function getPassword(){
			return $this->password;
		}

		public function setPhoneNumber($phoneNumber){
			$this->phoneNumber = $phoneNumber;
		}

		public function getPhoneNumber(){
			return $this->phoneNumber;
		}

		public function setAccountType($accountType){
			$this->accountType = $accountType;
		}

		public function getAccountType(){
			return $this->accountType;
		}

	}