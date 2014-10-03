<?php
require_once ('./model/DatabaseConnection.php');
require_once('./model/User.php');

class UserRepository extends DatabaseConnection{
	private $userList = array();
	private static $userId = 'userId';
	private static $username = 'username';
	private static $password = 'password';

	public function __construct(){
		$this->dbTable = 'member';
	}

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

				$this->userList[] = new User($userId, $username, $password);
			}
			return $this->userList;	
		}
		catch(\PDOException $e){
			echo "<pre>";
			var_dump($e);
			echo "</pre>";
			die("Error while connection to database.");
		}
	}

	public function add($username, $password){
		try{
			/*
			$db = $this -> connection();

			$sql = "INSERT INTO $this->dbTable (" . self::$key . ", " . self::$name . ") VALUES (?, ?)";
			$params = array($participant -> getUnique(), $participant -> getName());

			$query = $db -> prepare($sql);
			$query -> execute($params);
			
			foreach($participant->getProjects()->toArray() as $project) {
				$sql = "INSERT INTO ".self::$projectTable." (" . self::$key . ", " . self::$name . ", participantUnique) VALUES (?, ?, ?)";
				$query = $db->prepare($sql);
				$query->execute(array($project->getUnique(), $project->getName(), $participant->getUnique()));
			}
			*/
			$db = $this->connection();

		}
		catch(\PDOException $e){
			die('An unknown error have occured');
		}
	}
}