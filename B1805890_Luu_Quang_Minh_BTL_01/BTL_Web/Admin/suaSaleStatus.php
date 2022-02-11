<?php
	require_once("../DBprocess.php");
	if(isset($_POST)){
		$connect = connectDB();
		$id_lk = $_POST['id_lk'];
		$loai_lk = $_POST['loai_lk'];
		$sale_status = $_POST['sale_status'];
		$query = "update linhkien set sale_status='".$sale_status."' where id_lk='".$id_lk."'";
		mysqli_query($connect, $query);
		$_SESSION['sale_status'] = "Sửa trạng thái bán sản phẩm thành công";
		closeDB($connect);
		header("Location: chitiet_SP.php?id_lk=".$id_lk."&loai_lk=".$loai_lk);
	}
?>