<?php
require_once("../repository/user-repository.php");
require_once("../model/user.php");
	
class UserService {

	private $repository;

	public function __construct() {
		$this->repository = new UserRepository(); 
	}

	public function authenticateUser($username, $password){

		$password = md5($password);

		$foundUser = $this->repository->findByUsernameAndPassword($username, $password);

		if ($foundUser->num_rows == 1) {
			$authenticatedUser = $foundUser->fetch_array();
			return $authenticatedUser;
		} else{
			return null;
		}
	}

	public function findUserIdByUsername($username){
		return $this->repository->findUserIdByUsername($username)->fetch_array();
	}

	public function findUsernameByUserId($id){
		return $this->repository->findUsernameByUserId($id)->fetch_array();
	}

	public function registerUser($user){

		$user->setPassword(md5($user->getPassword()));

		$foundUser = $this->repository->findByUsername($user->getUsername());
		
		if($foundUser->num_rows <= 0){
			return $this->repository->save($user);
		} else{
			return false;
		}
		
		
	}

}