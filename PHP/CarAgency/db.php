<?php

class DBLink {
	private $link;
	
	function __construct($dbName) {
		// Do handle db connection here
		$host = "localhost";
		$uname = "admin";
		$upass = "root";
		
		try {
			$this->link = new PDO("mysql:host=$host;dbname=$dbName", $uname, $upass);
		} catch(PDOException $e) {
			$e->getMessage();
			die("Oops.");
		}
	}

	function query() {

		$sql = "SELECT * FROM cars";
		$stmt = $this->link->prepare($sql);
		$stmt->execute([]);

		$st = $stmt->fetchAll();

		return $st;
	}

	function prepareQuery($input) {

		// Named Parameters
		$sql = "SELECT * FROM songs WHERE Title = :tit";
		$stmt = $this->link->prepare($sql);
		$stmt->execute(['tit' => $input]);

		$results = $stmt->fetchAll();

		foreach ($results as $r) {
			echo $r['id'];
		}
	}

	function getOne($id) {
		$sql = "SELECT * FROM songs WHERE id = :id";
		$stmt = $this->link->prepare($sql);
		$stmt->execute(["id" => $id]);

		$result = $stmt->fetch();

		echo $result['Title'];
	}

	function rowCount() {
		$stmt = $this->link->prepare("SELECT * FROM songs");
		$stmt->execute();
		$count = $stmt->rowCount();

		echo $count;
	}

	function insertData($make, $model, $year, $desc) {
		$sql = "INSERT INTO cars(make, model, year, description, is_posted) 
				VALUES(:make, :model, :year, :description, :isPosted)";
		$stmt = $this->link->prepare($sql);
		$stmt->execute(["make" => $make, "model" => $model,
					"year" => $year, "description" => $desc,
					"isPosted" => '1']);
	}

	function updateData($id, $artist) {
		$sql = "UPDATE cars SET artist = :artist WHERE id = :id";
		$stmt = $this->link->prepare($sql);
		$stmt->execute(["artist" => $artist, "id" => $id]);
	}

	function makeUnAvailable($id) {
		$sql = "UPDATE cars SET is_posted = :yes WHERE id = :id";
		$stmt = $this->link->prepare($sql);
		$stmt->execute(["yes" => 0, "id" => $id]);
	}

	function makeAvailable($id) {
		$sql = "UPDATE cars SET is_posted = :yes WHERE id = :id";
		$stmt = $this->link->prepare($sql);
		$stmt->execute(["yes" => 1, "id" => $id]);
	}

	function deleteData($id) {
		$sql = "DELETE FROM cars WHERE id = :id";
		$stmt = $this->link->prepare($sql);
		$stmt->execute(["id" => $id]);
	}

	function search($value) {
		$sql = "SELECT * FROM songs WHERE rightHand LIKE ?";
		$stmt = $this->link->prepare($sql);
		$stmt->execute([$value]);

		$result = $stmt->fetchAll();

		foreach($result as $r) {
			echo $r['Title'];
		}
	}

	function __destruct() {
		// Close
		$this->link = null;
	}
}

 ?>