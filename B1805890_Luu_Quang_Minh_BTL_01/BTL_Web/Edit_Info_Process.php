<?php
	require_once("DBconnect.php");
	session_start();
	$connect = connectDB();
	$Hoten = $_POST['Hoten'];
	$Address = $_POST['Address'];
	$Tel = $_POST['Tel'];
	$email = $_POST['Email'];
	$query = "update info_user set 
				Hoten_User='".$Hoten."', Diachi_User='".$Address."', SoDT_User='".$Tel."', Email_User='".$email."' 
					where username='".$_SESSION['username']."'";
	mysqli_query($connect, $query);
	header("Location: ManagePage.php");
?>