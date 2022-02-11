<?php
	require_once("DBprocess.php");
	if(isset($_POST)){
		$connect = connectDB();
		$id = $_POST['id_lk'];
		$username = $_SESSION['username'];
		$soluong = $_POST['sl_hientai'];
		$dongia = $_POST['dongia_lk'];
		
		$query = "update user_cart set So_luong='".$soluong."', Tong='".($soluong * $dongia)."' 
			where username='".$username."' and id_lk='".$id."' ";
		mysqli_query($connect, $query);
		header("Location: ManagePage.php?info=GioHang");
	}
?>