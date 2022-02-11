<?php
	require_once("../DBprocess.php");
	if(isset($_POST)){
		$connect = connectDB();
		$id_lk = $_POST['id_lk'];
		$loai_lk = $_POST['loai_lk'];
		$ten_lk = $_POST['ten_lk'];
		$hang_sx = $_POST['hang_sx'];
		$sl_ton = $_POST['sl_ton'];
		$gia_goc = $_POST['gia_goc'];
		$giam_gia = $_POST['giam_gia'];
		$query = "update linhkien set ten_lk='".$ten_lk."', gia_lk='".$gia_goc."', giam_gia='".$giam_gia."', so_luong='".$sl_ton."' 
			where id_lk='".$id_lk."' and loai_lk='".$loai_lk."'";
		mysqli_query($connect, $query);
		switch(strtolower($loai_lk)){
			case 'cpu':
				$doi_cpu = $_POST['doi_cpu'];
				$core_cpu = $_POST['core_cpu'];
				$xung_cpu = $_POST['xung_cpu'];
				$socket_cpu = $_POST['socket_cpu'];
				$query = "update cpu set hangsx='".$hang_sx."', series='".$doi_cpu."', 
					core='".$core_cpu."', xung='".$xung_cpu."', socket='".$socket_cpu."'  where id_lk='".$id_lk."'";
				mysqli_query($connect, $query);
				$_SESSION['status_suatt'] = "Sửa thông tin sản phẩm thành công";
				header("Location: chitiet_SP.php?id_lk=".$id_lk."&loai_lk=".$loai_lk);
				break;
			case 'gpu':
				$chip_gpu = $_POST['chip_gpu'];
				$vmemory_gpu = $_POST['vmemory_gpu'];
				$thehe_gpu = $_POST['thehe_gpu'];
				$query = "update gpu set hangsx='".$hang_sx."', chip_do_hoa='".$chip_gpu."', vmemory='".$vmemory_gpu."', the_he_bo_nho='".$thehe_gpu."' 
					where id_lk='".$id_lk."'";
				mysqli_query($connect, $query);
				$_SESSION['status_suatt'] = "Sửa thông tin sản phẩm thành công";
				header("Location: chitiet_SP.php?id_lk=".$id_lk."&loai_lk=".$loai_lk);
				break;
			case 'mainboard':
				$socket_mainboard = $_POST['socket_mainboard'];
				$chipset_mainboard = $_POST['chipset_mainboard'];
				$kt_mainboard = $_POST['kt_mainboard'];
				$query = "update mainboard set hangsx='".$hang_sx."', socket='".$socket_mainboard."', chipset='".$chipset_mainboard."', chuan_kich_thuoc='".$kt_mainboard."' 
					where id_lk='".$id_lk."'";
				mysqli_query($connect, $query);
				$_SESSION['status_suatt'] = "Sửa thông tin sản phẩm thành công";
				header("Location: chitiet_SP.php?id_lk=".$id_lk."&loai_lk=".$loai_lk);
				break;
			case 'ram':
				$ddr_ram = $_POST['ddr_ram'];
				$dl_ram = $_POST['dl_ram'];
				$bus_ram = $_POST['bus_ram'];
				$query = "update ram set hangsx='".$hang_sx."', ddr='".$ddr_ram."', dung_luong='".$dl_ram."', bus='".$bus_ram."' 
					where id_lk='".$id_lk."'";
				mysqli_query($connect, $query);
				$_SESSION['status_suatt'] = "Sửa thông tin sản phẩm thành công";
				header("Location: chitiet_SP.php?id_lk=".$id_lk."&loai_lk=".$loai_lk);
				break;
			case 'disk':
				$chuanketnoi_disk = $_POST['chuanketnoi_disk'];
				$kt_disk = $_POST['kt_disk'];
				$dl_disk = $_POST['dl_disk'];
				$loai_disk = $_POST['loai_disk'];
				$query = "update disk set hangsx='".$hang_sx."', chuan_ket_noi='".$chuanketnoi_disk."', 
					kich_thuoc='".$kt_disk."', dung_luong='".$dl_disk."', loai='".$loai_disk."' where id_lk='".$id_lk."'";
				mysqli_query($connect, $query);
				$_SESSION['status_suatt'] = "Sửa thông tin sản phẩm thành công";
				header("Location: chitiet_SP.php?id_lk=".$id_lk."&loai_lk=".$loai_lk);
				break;
			case 'case':
				$kieu_case = $_POST['kieu_case'];
				$mau_case = $_POST['mau_case'];
				$kieumain_case = $_POST['kieumain_case'];
				$cl_case = $_POST['cl_case'];
				$query = "update `case` set hangsx='".$hang_sx."', kieu_case='".$kieu_case."', 
					mau='".$mau_case."', kieu_mainboard='".$kieumain_case."', chat_lieu='".$cl_case."' where id_lk='".$id_lk."'";
				mysqli_query($connect, $query);
				$_SESSION['status_suatt'] = "Sửa thông tin sản phẩm thành công";
				header("Location: chitiet_SP.php?id_lk=".$id_lk."&loai_lk=".$loai_lk);
				break;
		}
	}
?>