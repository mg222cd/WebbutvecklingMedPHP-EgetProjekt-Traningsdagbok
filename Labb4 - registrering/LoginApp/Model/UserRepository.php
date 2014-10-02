<?php
require_once ('./model/UserList.php');
require_once ('./model/DatabaseConnection.php');

class UserRepository extends DatabaseConnection{
	private $users;
	private $user;
	private static $userId = 'userId';
	private static $username = 'username';
	private static $password = 'password';

	public function __construct(UserList $userList, User $user){
		$this->dbTable = 'member';
		$this->users = $userList;
		$this->user = $user;
	}

	//
	public function query($sql, $params = NULL) {
		try {
			$db = $this -> connection();

			$query = $db -> prepare($sql);
			$result;
			if ($params != NULL) {
				if (!is_array($params)) {
					$params = array($params);
				}

				$result = $query -> execute($params);
			} else {
				$result = $query -> execute();
			}

			if ($result) {
				return $result -> fetchAll();
			}

			return NULL;
		} catch (\PDOException $e) {
			die('An unknown error have occured.');
		}
	}

	//Funktion för att hämta alla namn ur databasen.
	public function getAll(){
		try{
			$db = $this->connection();
			$sql = "SELECT * FROM $this->dbTable";
			$query = $db->prepare($sql);
			$query->execute();

			foreach ($query->fetchAll() as $user) {
				$userId = $user['userId'];
				$username = $user['username'];
				$password = $user['password'];

				$user = new User($userId, $username, $password);
				$this->users->add($user);
			}
			return $this->users;
		}
		catch(\PDOException $e){
			echo "<pre>";
			var_dump($e);
			echo "</pre>";
			die("Error while connection to database.");
		}
	}
}