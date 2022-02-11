<?php
	session_start();
	require_once("DBconnect.php");
	$connect = connectDB();
	$id_lk = $_POST['id_lk'];
	$loai_lk = $_POST['loai_lk'];
	$sl_sp = $_POST['sl_sp'];
	$sl_ton = $_POST['sl_ton'];
	
	if(isset($_SESSION['username'])){
		if($sl_sp <= $sl_ton){
			$query = "SELECT round(`Gia_LK`*(1-`Giam_gia`),0) as Gia_giam FROM `linhkien` WHERE id_LK='".$id_lk."';";	
			$result = mysqli_query($connect, $query);
			$data = array();
			while($row = mysqli_fetch_array($result, 1)){
				$data[] = $row;
			}
			$gia_giam = $data[0]['Gia_giam'];
			
			$query = "Select * from `user_cart` where username = '".$_SESSION['username']."' and id_lk='".$id_lk."'";
			$result = mysqli_query($connect, $query);
			$data= array();
			while ($row = mysqli_fetch_array($result,1)){
				$data[] = $row;
			}	
			if(count($data) == 0){
				$query = "INSERT INTO `user_cart` (`Username`, `ID_LK`, `So_luong`, `Don_gia`, `Tong`) 
							VALUES ('".$_SESSION['username']."', '".$id_lk."', '".$sl_sp."', 
								'".$gia_giam."', '".($gia_giam * $sl_sp)."')";
				mysqli_query($connect, $query);
			}
			else{
				$query = "Select So_luong from `user_cart` where username = '".$_SESSION['username']."' and id_lk='".$id_lk."'";
				$result = mysqli_query($connect, $query);
				$data= array();
				while ($row = mysqli_fetch_array($result,1)){
					$data[] = $row;
				}
				$old_sl = $data[0]['So_luong'];
				$query = "update `user_cart` set So_luong ='".($sl_sp + $old_sl)."', Tong='".($gia_giam * ($sl_sp + $old_sl))."' 
							where username = '".$_SESSION['username']."' and id_lk='".$id_lk."'";
				mysqli_query($connect, $query);
			}
			$_SESSION['addCart_status'] = "Thêm vào giỏ hàng thành công.";
			header("Location: chitiet_SP.php?id_lk=".$id_lk."&loai_lk=".$loai_lk);
		}
		else{
			$_SESSION['addCart_status'] = "Số lượng vượt quá số hàng tồn kho";
			header("Location: chitiet_SP.php?id_lk=".$id_lk."&loai_lk=".$loai_lk);
		}
	}
	else{
		$_SESSION['addCart_status'] = "Hãy đăng nhập trước khi thực hiện thêm giỏ hàng";
		header("Location: chitiet_SP.php?id_lk=".$id_lk."&loai_lk=".$loai_lk);
	}
	
?>