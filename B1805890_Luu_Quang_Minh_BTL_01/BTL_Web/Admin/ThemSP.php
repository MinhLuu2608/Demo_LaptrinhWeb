<?php
	require_once("../DBconnect.php");
	session_start();
	if(isset($_POST)){
		$connect = connectDB();
		$loai_lk = $_POST['loai_lk'];
		$ten_lk = $_POST['ten_lk'];
		$hang_sx = $_POST['hang_sx'];
		$gia_lk = $_POST['gia_lk'];
		$sl_lk = $_POST['sl_lk'];
		$giamgia_lk = $_POST['giamgia_lk'];
		$status_ban = $_POST['status_ban'];
		$thumuc = "../img/";
		$duong_dan = $thumuc . basename($_FILES['img_lk']['name']);
		if (file_exists($duong_dan)) {
			$_SESSION['status_themsp'] = "Tên file đã tồn tại. Mời đổi tên khác";
			header("Location: QL_SP_Them.php");
		}
		else{
		
			if (move_uploaded_file($_FILES['img_lk']['tmp_name'], $duong_dan)){
				$query = "Select max(ID_Hinh) as max from Hinh_anh";
				$result = mysqli_query($connect, $query);
				$data = array();
				while($row = mysqli_fetch_array($result, 1)){
					$data[] = $row;
				}
				$max_id_hinh = $data[0]['max'] + 1;

				$thumuc = "img/";
				$duong_dan = $thumuc . basename($_FILES['img_lk']['name']);
				$query = "INSERT INTO `Hinh_anh` (`ID_Hinh`, `Ten_Hinh`, `Duong_dan`) 
					VALUES ('".$max_id_hinh."', '".$_FILES['img_lk']['name']."', '".$duong_dan."')";
				mysqli_query($connect, $query);
				
				$query = "Select max(ID_LK) as max from linhkien";
				$result = mysqli_query($connect, $query);
				$data = array();
				while($row = mysqli_fetch_array($result, 1)){
					$data[] = $row;
				}
				$max_id_lk = $data[0]['max'] + 1;
				$query = "INSERT INTO `linhkien` (`ID_LK`, `Ten_LK`, `Loai_LK`, `Gia_LK`, `So_luong`, `Hinh_anh`, `Sale_Status`) 
					VALUES ('".$max_id_lk."' ,'".$ten_lk."', '".$loai_lk."', '".$gia_lk."', '".$sl_lk."', '".$duong_dan."', '".$status_ban."')";
				mysqli_query($connect, $query);
				
				switch($loai_lk){
					case 'CPU':
						$doi_cpu = $_POST['doi_cpu'];
						$core_cpu = $_POST['core_cpu'];
						$xung_cpu = $_POST['xung_cpu'];
						$socket_cpu = $_POST['socket_cpu'];
						$query = "INSERT INTO `cpu` (`ID_LK`, `HangSX`, `Series`, `Core`, `Xung`, `Socket`) 
							VALUES ('".$max_id_lk."', '".$hang_sx."', '".$doi_cpu."', '".$core_cpu."', '".$xung_cpu."', '".$socket_cpu."')";
						mysqli_query($connect, $query);	
						break;
					case 'GPU':
						$chip_gpu = $_POST['chip_gpu'];
						$vmemory_gpu = $_POST['vmemory_gpu'];
						$thehe_gpu = $_POST['thehe_gpu'];
						$query = "INSERT INTO `gpu` (`ID_LK`, `HangSX`, `Chip_do_hoa`, `VMemory`, `The_he_bo_nho`) 
							VALUES ('".$max_id_lk."', '".$hang_sx."', '".$chip_gpu."', '".$vmemory_gpu."', '".$thehe_gpu."')";
						mysqli_query($connect, $query);
						break;
					case 'Mainboard':
						$socket_main = $_POST['socket_main'];
						$chipset_main = $_POST['chipset_main'];
						$chuankt_main = $_POST['chuankt_main'];
						$query = "INSERT INTO `mainboard` (`ID_LK`, `HangSX`, `Socket`, `Chipset`, `Chuan_kich_thuoc`) 
							VALUES ('".$max_id_lk."', '".$hang_sx."', '".$socket_main."', '".$chipset_main."', '".$chuankt_main."')";
						mysqli_query($connect, $query);
						break;
					case 'RAM':
						$ddr_ram = $_POST['ddr_ram'];
						$dl_ram = $_POST['dl_ram'];
						$bus_ram = $_POST['bus_ram'];
						$query = "INSERT INTO `ram` (`ID_LK`, `HangSX`,   `DDR`, `Dung_luong`, `Bus`) 
							VALUES ('".$max_id_lk."', '".$hang_sx."', '".$ddr_ram."', '".$dl_ram."', '".$bus_ram."')";
						mysqli_query($connect, $query);
						break;
					case 'Disk':
						$loai_disk = $_POST['loai_disk'];
						$chuanketnoi_disk = $_POST['chuanketnoi_disk'];
						$kt_disk = $_POST['kt_disk'];
						$dl_disk = $_POST['dl_disk'];
						$query = "INSERT INTO `disk` (`ID_LK`, `HangSX`, `Chuan_ket_noi`, `Kich_thuoc`, `Dung_luong`, `Loai`) 
							VALUES ('".$max_id_lk."', '".$hang_sx."', '".$chuanketnoi_disk."', '".$kt_disk."', '".$dl_disk."', '".$loai_disk."')";
						mysqli_query($connect, $query);
						break;
					case 'Case':
						$kieu_case = $_POST['kieu_case'];
						$mau_case = $_POST['mau_case'];
						$kieumain_case = $_POST['kieumain_case'];
						$cl_case = $_POST['cl_case'];
						$query = "INSERT INTO `case` (`ID_LK`, `HangSX`, `Kieu_case`, `Mau`, `Kieu_mainboard`, `Chat_lieu`) 
							VALUES ('".$max_id_lk."', '".$hang_sx."', '".$kieu_case."', '".$mau_case."', '".$kieumain_case."', '".$cl_case."')";
						mysqli_query($connect, $query);
						break;
				}
				$_SESSION['status_themsp'] = "Đã thêm sản phẩm thành công";
				header("Location: QL_SP.php");
			}
		}
	}
?>