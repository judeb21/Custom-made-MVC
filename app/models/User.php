<?php 
	class User {
		private $db;

		public function __construct() {
			$this->db = new Database;
		}

		public function loginUser($email, $password) {
			$sql = "SELECT * FROM users WHERE email= :email";
			// prepare the sql statement
			$this->db->query($sql);
			// bind the values
			$this->db->bind(":email", $email);
			// The returned row as an object
			$row = $this->db->single();
			// password associated in the db with $email
			$hashed_password = $row->password;

			// Check if password user entered matches password
			// in database. If it does return the entire row
			// for setting user $_SESSION
			if (password_verify($password, $hashed_password)) {
				return $row;
			} else {
				return false;
			}
		}

		public function registerUser($data) {
			// Query to insert user data in appropriate database table
			$sql = "INSERT INTO users (name, email, password)
				 VALUES (:name, :email, :password)";
			$this->db->query($sql);

			// Bind Values
			$this->db->bind(":name", $data["name"]);
			$this->db->bind(":email", $data["email"]);
			$this->db->bind(":password", $data["password"]);

			// var_dump($this->db->execute());
			// $this->db->execute returns NULL 
			// The code would have to account for this

			$concl = ($this->db->execute() ? true : false);
			//$concl = !($this->db->execute());

			return $concl;
		}

		public function findUserByEmail($email) {
			// Access Database class and its methods 
			// to prepare the sql statement
			$this->db->query("SELECT email FROM users WHERE email = :email");

			// Bind the values 
			$this->db->bind(":email", $email);

			// Execute and returned result
			$result = $this->db->single();

			$concl = ($this->db->rowCount() > 0) ? true : false;
			return $concl;
		}

		public function getUserById($id) {
			$sql = "SELECT * FROM users WHERE id = :id";

			$this->db->query($sql);

			//Bind values
			$this->db->bind(":id", $id);

			$row = $this->db->single();
			return $row;
		}
	}
 ?>