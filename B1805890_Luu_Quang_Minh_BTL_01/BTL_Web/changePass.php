<?php
	session_start();
	require_once("DBconnect.php");
	$connect = connectDB();
	$oldPass = $_POST['oldPass'];
	$newPass = $_POST['newPass'];
	$rePass = $_POST['re-newPass'];
	
	$query = "Select password from account where username = '".$_SESSION['username']."'";
	$result = mysqli_query($connect, $query);
	$data = array();
	while($row = mysqli_fetch_array($result, 1)){
		$data[] = $row;
	}
	if($data[0]['password'] == $oldPass){
		if($newPass == $rePass){
			$query = "update account set password='".$newPass."' where username = '".$_SESSION['username']."'";
			mysqli_query($connect, $query);
			unset($_SESSION['username']);
			$_SESSION['changePass_status'] = "Thay đổi mật khẩu thành công. Hãy đăng nhập lại";
			header("Location: index.php");
		}
		else{
			$_SESSION['changePass_status'] = "Password và Repass không giống nhau";
			header("Location: ManagePage.php?info=changePass");
		}
	}
	else{
		$_SESSION['changePass_status'] = "Password hiện tại không đúng";
		header("Location: ManagePage.php?info=changePass");
	}
?>