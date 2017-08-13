<?php
	require_once("../config/database.php");
	require_once("../model/user.php");
	
	class UserRepository {

		private $database;

		public function __construct() {
			$this->database = new Database();
		}

		public function findUserIdByUsername($username){
			$username = $this->database->escapeString($username);
			$sql = "SELECT id FROM user WHERE username =  '{$username}'";
			return $this->database->query($sql);
		}

		public function findUsernameByUserId($id){
			$username = $this->database->escapeString($id);
			$sql = "SELECT username FROM user WHERE id =  '{$id}'";
			return $this->database->query($sql);
		}

		public function findByUsername($username){
			$username = $this->database->escapeString($username);
			$sql = "SELECT * FROM user WHERE username =  '{$username}'";
			return $this->database->query($sql);
		}

		public function findByUsernameAndPassword($username, $password){
			$username = $this->database->escapeString($username);
			$password = $this->database->escapeString($password);
			$sql = "SELECT * FROM user WHERE username =  '{$username}' AND password = '{$password}'";
			return $this->database->query($sql);
		}

		public function save($user){
			$firstname = $this->database->escapeString($user->getFirstname());
			$lastname = $this->database->escapeString($user->getLastname());
			$username = $this->database->escapeString($user->getUsername());
			$password = $this->database->escapeString($user->getPassword());
			$email = $this->database->escapeString($user->getEmail());
			$phoneNumber = $this->database->escapeString($user->getPhoneNumber());
			$accountType = $this->database->escapeString($user->getAccountType());
			$sql =  "INSERT INTO user(first_name, last_name, username, password, phone_number, email, account_type) VALUES('{$firstname}', '{$lastname}', '{$username}', '{$password}', '{$phoneNumber}', '{$email}', '{$accountType}')"; 
			return $this->database->query($sql);
		}

	}