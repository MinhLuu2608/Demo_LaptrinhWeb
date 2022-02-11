<?php
	require_once("DBprocess.php");
	if(isset($_SESSION['username'])){
		$connect = connectDB();
		$query = "SELECT so_du from account WHERE username='".$_SESSION['username']."'";	
		$result = mysqli_query($connect, $query);
		$data = array();
		while($row = mysqli_fetch_array($result, 1)){
			$data[] = $row;
		}
		$so_du = $data[0]['so_du'];
			
		$query = "Select ID_LK, So_luong, Tong from user_cart where username='".$_SESSION['username']."'";
		$result = mysqli_query($connect, $query);
		$data = array();
		while($row = mysqli_fetch_array($result, 1)){
			$data[] = $row;
		}
		$tong_tien=0;
		for($i=0;$i<count($data);$i++){
			$tong_tien += $data[$i]['Tong'];
		}
		if($so_du >= $tong_tien){
			$capnhat_sodu = $so_du - $tong_tien;
			$query = "INSERT INTO `donhang` (`Username_KH`, `Status_DH`, `Ngay_Dat`, Tong_tien) 
					VALUES ('".$_SESSION['username']."', 'Chờ xử lý', sysdate(), '".$tong_tien."')";
			mysqli_query($connect, $query);
			
			$query = "Select max(ID_DH) as max from donhang";	
			$result = mysqli_query($connect, $query);
			$data = array();
			while($row = mysqli_fetch_array($result, 1)){
				$data[] = $row;
			}
			$id_dh = $data[0]['max'];
			
			$query = "SELECT user_cart.ID_LK as ID_LK, user_cart.So_luong as So_luong, linhkien.So_luong as So_luong_max, Don_gia, Tong, Ten_LK 
				FROM `user_cart` join linhkien on user_cart.ID_LK=linhkien.ID_LK where username='".$_SESSION['username']."'";
			$result = mysqli_query($connect, $query);
			$data = array();
			while($row = mysqli_fetch_array($result, 1)){
				$data[] = $row;
			}
			for($i=0;$i<count($data);$i++){
				$id_lk = $data[$i]['ID_LK'];
				$sl_sp = $data[$i]['So_luong'];
				$sl_ton = $data[$i]['So_luong_max'];
				$don_gia = $data[$i]['Don_gia'];
				$query = "INSERT INTO `chitietDH` (`ID_DH`, `ID_LK`, `So_luong`, `Don_gia`) 
					VALUES ('".$id_dh."', '".$id_lk."', '".$sl_sp."', '".$don_gia."')";
				mysqli_query($connect,$query);
				
				$query = "update linhkien set so_luong='".($sl_ton - $sl_sp)."' WHERE id_lk='".$id_lk."'";	
				mysqli_query($connect, $query);
				
				$query = "delete from user_cart where username='".$_SESSION['username']."' and id_lk='".$id_lk."'";
				mysqli_query($connect, $query);
			}
			$query = "update account set so_du='".($so_du - $tong_tien)."' WHERE username='".$_SESSION['username']."'";	
			mysqli_query($connect, $query);
			
			$_SESSION['cart_buy_status'] = "Đã mua thành công.";
			header("Location: ManagePage.php?info=GioHang");
		}
		else{
			$_SESSION['cart_buy_status'] = "Không đủ tiền để mua";
			header("Location: ManagePage.php?info=GioHang");
		}
		
	}
	else{
		header("Location: ManagePage.php?info=GioHang");
	}
?>