<?php
	const HOST = "localhost";
	const USERNAME = "root";
	const PASSWORD = "";
	const DATABASE = "ct42801_B1805890";
	function connectDB(){
		$connect = new mysqli(HOST, USERNAME, PASSWORD, DATABASE);
		mysqli_set_charset($connect, "utf8");
		if($connect->connect_error){
			var_dump($connect->connect_error);
			die();
		}
		return $connect;
		
	}
	function closeDB($connect){
		$connect->close();
	}
?>