<?php
	require_once("../DBconnect.php");
	session_start();
	if(isset($_POST['quyen_han'])){
		$connect = connectDB();
		$username = $_POST['username'];
		$quyen_han = $_POST['quyen_han'];
		if(strcmp($quyen_han,"None") == 0){
			$query = "update account set Quyen_han=null where username ='".$username."'";
			mysqli_query($connect, $query);
		}
		else{
			$query = "update account set Quyen_han='".$quyen_han."' where username ='".$username."'";
			mysqli_query($connect, $query);
		}
		$_SESSION['Capnhat_quyenhan'] = "Cập nhật quyền hạn thành công";
		echo $_SESSION['Capnhat_quyenhan'];
		closeDB($connect);
		header("Location: QL_Account.php?username=".$username);
	}
	else{
		header("Location: QL_Account.php");
	}
?>