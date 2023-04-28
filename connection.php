<?php
// Create class a new connection to the MySQL server
class DBController {
	private $host = "mysql.rackhost.hu";
	private $user = "c44825info_group";
	private $password = "vegetarsgr";
	private $database = "c44825register";
	private $conn;
	
	function __construct() {
		$this->conn = $this->connectDB();
	}
	
	function connectDB() {
		$conn = mysqli_connect($this->host,$this->user,$this->password,$this->database);
		return $conn;
	}
	
	function runQuery($query) {
		$result = mysqli_query($this->conn,$query);
		while($row=mysqli_fetch_assoc($result)) {
			$resultset[] = $row;
		}		
		if(!empty($resultset))
			return $resultset;
	}
	
	function numRows($query) {
		$result  = mysqli_query($this->conn,$query);
		$rowcount = mysqli_num_rows($result);
		return $rowcount;	
	}
}

define ("host" , "mysql.rackhost.hu");
define ("user" , "c44825info_group");
define ("password" , "vegetarsgr");
define("database" , "c44825register");
$conn = new mysqli(host,user,password,database);
?>
