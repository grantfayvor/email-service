<?php
	require_once("constants.php");

	class Database {

		private $dbHost;
		private $dbUsername;
		private $dbPassword;
		private $dbName;
		private $dbConnection;
		private $dbSelect;

		public function __construct() {
			$this->dbHost = DB_HOST;
			$this->dbUsername = DB_USERNAME;
			$this->dbPassword = DB_PASSWORD;
			$this->dbName = DB_NAME;
			$this->connect();
		}

		public function connect(){
			
			$this->dbConnection = mysqli_connect($this->dbHost, $this->dbUsername, $this->dbPassword, $this->dbName);

			if($this->dbConnection->connect_errno){
				printf("connection failed: %s\n", $this->dbConnection->connect_err);
				// exit();
			}

		}

		public function query($sql){
			$result = $this->dbConnection->query($sql);
			if (!$result) {
				die("Database query failed: " .$this->dbConnection->error());
			} else {
				return $result;
			}
		}

		public function escapeString($string){
			if (get_magic_quotes_gpc()) {
				$string = stripslashes($string); 
			}
			return trim($this->dbConnection->real_escape_string($string));
		}

		public function disconnect(){

			if(isset($this->dbConnection)){
				$this->dbConnection->close($this->dbConnection);
				unset($this->dbConnection);
			}

		}

	}