<?php
	require_once("DBprocess.php");
	if(isset($_POST)){
		$connect = connectDB();
		$id = $_POST['id_lk'];
		$username = $_SESSION['username'];
		
		$query = "delete from user_cart where username='".$username."' and id_lk='".$id."' ";
		mysqli_query($connect, $query);
		header("Location: ManagePage.php?info=GioHang");
	}
?>