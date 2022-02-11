<?php
	require_once("../DBconnect.php");
	
	function showThongBao(){
		$connect = connectDB();
		$query = "Select * from linhkien where so_luong = 0";
		$result = mysqli_query($connect, $query);
		$data = array();
		while($row = mysqli_fetch_array($result, 1)){
			$data[] = $row;
		}
		if(count($data)>0){
			echo "<p class=\"header_content\">Các linh kiện hết hàng</p>";
			for($i=0;$i<count($data);$i++){
				$id = $data[$i]['ID_LK'];
				echo "<p class=\"chitiet_content\"> Linh kiện ID ".$id." hết hàng</p>";
			}
			echo "<hr>";
		}
		
		$query = "Select * from donhang where Status_DH = 'Chờ xử lý'";
		$result = mysqli_query($connect, $query);
		$data = array();
		while($row = mysqli_fetch_array($result, 1)){
			$data[] = $row;
		}
		if(count($data)>0){
			echo "<p class=\"header_content\">Các đơn hàng chờ xử lý</p>";
			for($i=0;$i<count($data);$i++){
				$id = $data[$i]['ID_DH'];
				echo "<p class=\"chitiet_content\"> Đơn hàng ID ".$id." đang chờ xử lý</p>";
			}
		}
		closeDB($connect);
	}
	function showAllAccount(){
		$connect = connectDB();
		$query = "Select * from account";
		$result = mysqli_query($connect, $query);
		$data = array();
		while($row = mysqli_fetch_array($result, 1)){
			$data[] = $row;
		}
		echo "<div class=\"content\">
				<div class=\"header_content\">
					<p class=\"trai\">Username</p>
					<p>Quyền hạn</p>
				</div>
			";
		for($i=0;$i<count($data);$i++){
			$username = $data[$i]['Username'];
			$quyen_han = $data[$i]['Quyen_han'];
			echo "<div class=\"noidung\">
					<a href=\"QL_Account.php?username=".$username."\" class=\"trai\">".$username."</a>
					<a href=\"QL_Account.php?username=".$username."\">".$quyen_han."</a>
				</div>";
		}
		echo "</div>";
		closeDB($connect);
	}
	function showAccount(){
		if(isset($_GET['username'])){
			$connect = connectDB();
			$query = "Select account.username as username, Quyen_han, hoten_user, diachi_user, sodt_user from account 
				join info_user on account.Username=info_user.Username 
				where account.Username='".$_GET['username']."'";
			$result = mysqli_query($connect, $query);
			$data = array();
			while($row = mysqli_fetch_array($result, 1)){
				$data[] = $row;
			}
			if(count($data)>0){
				$username = $data[0]['username'];
				if($data[0]['Quyen_han'] != null) $quyen_han = $data[0]['Quyen_han'];
				$hoten = $data[0]['hoten_user'];
				$diachi = $data[0]['diachi_user'];
				$sdt = $data[0]['sodt_user'];
				echo "<div class=\"content_chitiet_account\">
						<div class=\"header_chitiet_account\">
							<p>Thông tin tài khoản</p>
						</div>
					";
					
				echo "<div class=\"chitiet_account\">
						<p>Username: ".$username."</p>";
				if($data[0]['Quyen_han'] != null) echo "<p>Quyền hạn: ".$quyen_han."</p>";
				else echo "<p>Quyền hạn: Không có</p>";	
				echo "<p>Họ và tên: ".$hoten."</p>
						<p>Địa chỉ: ".$diachi."</p>
						<p>Số điện thoại: ".$sdt."</p>
					</div>";
					
				if(strcmp($_SESSION['privilege'],"Owner") == 0){
					echo "<div class=\"header_chitiet_account\">
							<p>Cập nhật quyền hạn tài khoản</p>
						</div>
						<div class=\"chitiet_account\">
							<form method=\"POST\" class=\"frmQuyenHan\" action=\"Capnhat_Quyenhan.php\">
								<label>Quyền hạn:</label>
								<input type=\"text\" class=\"hidden_input\" name=\"username\" value=\"".$_GET['username']."\">
								<select name=\"quyen_han\">
									<option value=\"None\">None</option>
									<option value=\"Staff\">Staff</option>
									<option value=\"Senior Staff\">Senior Staff</option>
									<option value=\"Owner\">Owner</option>
								</select>
								<br>
								<input type=\"submit\" value=\"Xác nhận cập nhật\">
							</form>
						</div>";
					
				}
				echo "</div>";
			}
			closeDB($connect);
		}
	}
	function show_QL_All_SP(){
		$connect = connectDB();
		//Lay so luong san pham
		$query = "Select count(*) as amount from linhkien";
		$result = mysqli_query($connect, $query);
		$data = array();
		while($row = mysqli_fetch_array($result, 1)){
			$data[] = $row;
		}
		$amount = $data[0]['amount'];  
		$so_hang = ceil($amount/4);
		
		//Lay thong tin san pham
		$query = "Select * from linhkien";
		$result = mysqli_query($connect, $query);
		$data = array();
		while($row = mysqli_fetch_array($result, 1)){
			$data[] = $row;
		}
		$current_index = 0;
		for($i = 0; $i < $so_hang-1; $i++){
?>
			<div class="hang_ngang">
<?php		
			for($j=0;$j<4;$j++){
?>
				<div class="san_pham">
					<a href="chitiet_SP.php?id_lk=<?php showThongTinSPAt($data, $current_index, "ID_LK") ?>&loai_lk=<?php showThongTinSPAt($data, $current_index, "Loai_LK") ?>" class="chitiet_sp">
						<img src="<?php echo "../".$data[$current_index]['Hinh_anh']; ?>" class="img_sp">
						<p class="ten_sp" title="<?php showThongTinSPAt($data, $current_index, "Ten_LK") ?>">
							<?php showThongTinSPAt($data, $current_index, "Ten_LK") ?>
						</p>
						<p <?php if(strcmp($data[$current_index]['Sale_Status'],"Ngừng bán") ==0){ echo 'class="ngung_ban"';} ?>>
							<?php showThongTinSPAt($data, $current_index, "Sale_Status") ?>
						</p>
						<p class="gia_giam">
							<?php 
								echo getThongTinSPAt($data, $current_index, "Gia_LK")*(1 - getThongTinSPAt($data, $current_index, "Giam_gia")); 
							?>
						</p>
						<p class="gia_sp">
							<del><?php showThongTinSPAt($data, $current_index, "Gia_LK") ?> </del>
							<label>&nbsp;-<?php echo 100*getThongTinSPAt($data, $current_index, "Giam_gia"); ?>%<label>
						</p>
					</a>
				</div>
<?php
				$current_index++;
			}
		}
?>		
		<br>
		<div class="hang_ngang">
<?php
		for($i=$current_index;$i<$amount;$i++){
?>
			<div class="san_pham">
				<a href="chitiet_SP.php?id_lk=<?php showThongTinSPAt($data, $current_index, "ID_LK") ?>&loai_lk=<?php showThongTinSPAt($data, $current_index, "Loai_LK") ?>" class="chitiet_sp">
					<img src="<?php echo "../".$data[$current_index]['Hinh_anh']; ?>" class="img_sp">
					<p class="ten_sp" title="<?php showThongTinSPAt($data, $current_index, "Ten_LK") ?>">
							<?php showThongTinSPAt($data, $current_index, "Ten_LK") ?>
					</p>
					<p <?php if(strcmp($data[$current_index]['Sale_Status'],"Ngừng bán") ==0){ echo 'class="ngung_ban"';} ?>>
						<?php showThongTinSPAt($data, $current_index, "Sale_Status") ?>
					</p>
					<p class="gia_giam">
						<?php 
							echo getThongTinSPAt($data, $current_index, "Gia_LK")*(1 - getThongTinSPAt($data, $current_index, "Giam_gia")); 
						?>
					</p>
					<p class="gia_sp">
						<del><?php showThongTinSPAt($data, $current_index, "Gia_LK") ?> </del>
						<label>&nbsp;-<?php echo 100*getThongTinSPAt($data, $current_index, "Giam_gia"); ?>%<label>
					</p>
				</a>
			</div>
<?php
			$current_index++;
		}
		closeDB($connect);
	}
	function show_QL_Them_SP($loai_lk){
		switch($loai_lk){
			case 'CPU':
				echo '<div class="chitiet_them"><label>Đời: </label><input type="number" name="doi_cpu" min="0"></div>';
				echo '<div class="chitiet_them"><label>Số Core: </label><input type="number" name="core_cpu" min="0"></div>';
				echo '<div class="chitiet_them"><label>Xung: </label><input type="text" name="xung_cpu"></div>';
				echo '<div class="chitiet_them"><label>Socket: </label><input type="text" name="socket_cpu"></div>';
				break;
			case 'GPU':
				echo '<div class="chitiet_them"><label>Chip đồ họa: </label><input type="text" name="chip_gpu"></div>';
				echo '<div class="chitiet_them"><label>VMemory: </label><input type="number" name="vmemory_gpu" min="0"></div>';
				echo '<div class="chitiet_them"><label>Thế hệ bộ nhớ: </label><input type="text" name="thehe_gpu"></div>';
				break;
			case 'Mainboard':
				echo '<div class="chitiet_them"><label>Socket: </label><input type="text" name="socket_main"></div>';
				echo '<div class="chitiet_them"><label>Chipset: </label><input type="text" name="chipset_main"></div>';
				echo '<div class="chitiet_them"><label>Chuẩn kích thước: </label><input type="text" name="chuankt_main"></div>';
				break;
			case 'RAM':
				echo '<div class="chitiet_them"><label>Loại DDR: </label><input type="text" name="ddr_ram"></div>';
				echo '<div class="chitiet_them"><label>Dung lượng: </label><input type="number" name="dl_ram" min="0"></div>';
				echo '<div class="chitiet_them"><label>Bus: </label><input type="number" name="bus_ram" min="0"></div>';
				break;
			case 'Disk':
				echo '<div class="chitiet_them"><label>Loại disk: </label><input type="text" name="loai_disk"></div>';
				echo '<div class="chitiet_them"><label>Chuẩn kết nối: </label><input type="text" name="chuanketnoi_disk"></div>';
				echo '<div class="chitiet_them"><label>Kích thước: </label><input type="text" name="kt_disk"></div>';
				echo '<div class="chitiet_them"><label>Dung lượng: </label><input type="text" name="dl_disk"></div>';
				break;
			case 'Case':
				echo '<div class="chitiet_them"><label>Kiểu case: </label><input type="text" name="kieu_case"></div>';
				echo '<div class="chitiet_them"><label>Màu: </label><input type="text" name="mau_case"></div>';
				echo '<div class="chitiet_them"><label>Kiểu Mainboard: </label><input type="text" name="kieumain_case"></div>';
				echo '<div class="chitiet_them"><label>Chất liệu: </label><input type="text" name="cl_case"></div>';
				break;
		}
	}
	function show_QL_Search_SP(){
		$connect = connectDB();
		$search_key = $_GET['search_key'];
		//Lay so luong san pham
		$query = "Select count(*) as amount from linhkien where `Ten_LK` like '%".$search_key."%'";
		$result = mysqli_query($connect, $query);
		$data = array();
		while($row = mysqli_fetch_array($result, 1)){
			$data[] = $row;
		}
		$amount = $data[0]['amount'];  
		$so_hang = ceil($amount/4);
		
		//Lay thong tin san pham
		$query = "Select * from linhkien where `Ten_LK` like '%".$search_key."%'";
		$result = mysqli_query($connect, $query);
		$data = array();
		while($row = mysqli_fetch_array($result, 1)){
			$data[] = $row;
		}
		$current_index = 0;
		for($i = 0; $i < $so_hang-1; $i++){
?>
			<div class="hang_ngang">
<?php		
			for($j=0;$j<4;$j++){
?>
				<div class="san_pham">
					<a href="chitiet_SP.php?id_lk=<?php showThongTinSPAt($data, $current_index, "ID_LK") ?>&loai_lk=<?php showThongTinSPAt($data, $current_index, "Loai_LK") ?>" class="chitiet_sp">
						<img src="<?php echo "../".$data[$current_index]['Hinh_anh']; ?>" class="img_sp">
						<p class="ten_sp" title="<?php showThongTinSPAt($data, $current_index, "Ten_LK") ?>">
							<?php showThongTinSPAt($data, $current_index, "Ten_LK") ?>
						</p>
						<p <?php if(strcmp($data[$current_index]['Sale_Status'],"Ngừng bán") ==0){ echo 'class="ngung_ban"';} ?>>
							<?php showThongTinSPAt($data, $current_index, "Sale_Status") ?>
						</p>
						<p class="gia_giam">
							<?php 
								echo getThongTinSPAt($data, $current_index, "Gia_LK")*(1 - getThongTinSPAt($data, $current_index, "Giam_gia")); 
							?>
						</p>
						<p class="gia_sp">
							<del><?php showThongTinSPAt($data, $current_index, "Gia_LK") ?> </del>
							<label>&nbsp;-<?php echo 100*getThongTinSPAt($data, $current_index, "Giam_gia"); ?>%<label>
						</p>
					</a>
				</div>
<?php
				$current_index++;
			}
		}
?>		
		<br>
		<div class="hang_ngang">
<?php
		for($i=$current_index;$i<$amount;$i++){
?>
			<div class="san_pham">
				<a href="chitiet_SP.php?id_lk=<?php showThongTinSPAt($data, $current_index, "ID_LK") ?>&loai_lk=<?php showThongTinSPAt($data, $current_index, "Loai_LK") ?>" class="chitiet_sp">
					<img src="<?php echo "../".$data[$current_index]['Hinh_anh']; ?>" class="img_sp">
					<p class="ten_sp" title="<?php showThongTinSPAt($data, $current_index, "Ten_LK") ?>">
							<?php showThongTinSPAt($data, $current_index, "Ten_LK") ?>
					</p>
					<p <?php if(strcmp($data[$current_index]['Sale_Status'],"Ngừng bán") ==0){ echo 'class="ngung_ban"';} ?>>
						<?php showThongTinSPAt($data, $current_index, "Sale_Status") ?>
					</p>
					<p class="gia_giam">
						<?php 
							echo getThongTinSPAt($data, $current_index, "Gia_LK")*(1 - getThongTinSPAt($data, $current_index, "Giam_gia")); 
						?>
					</p>
					<p class="gia_sp">
						<del><?php showThongTinSPAt($data, $current_index, "Gia_LK") ?> </del>
						<label>&nbsp;-<?php echo 100*getThongTinSPAt($data, $current_index, "Giam_gia"); ?>%<label>
					</p>
				</a>
			</div>
<?php
			$current_index++;
		}
		closeDB($connect);
	}
	function show_QL_ThongSoSPAt($loai_lk, $dataThongSo, $current_index){
		switch($loai_lk){
			case 'cpu':
?>
				<label>Đời: </label>
				<input type="number" min="1" class="input_thongso_sp" name="doi_cpu" value="<?php showThongTinSPAt($dataThongSo, $current_index, "Series") ?>">
				<label>Số core: </label>
				<input type="number" min="1" class="input_thongso_sp" name="core_cpu" value="<?php showThongTinSPAt($dataThongSo, $current_index, "Core") ?>">
				<label>Xung: </label>
				<input class="input_thongso_sp" name="xung_cpu" value="<?php showThongTinSPAt($dataThongSo, $current_index, "Xung") ?>">
				<label>Socket: </label>
				<input class="input_thongso_sp" name="socket_cpu" value="<?php showThongTinSPAt($dataThongSo, $current_index, "Socket") ?>">
<?php
				break;
			case 'gpu':
?>
				<label>Chip đồ họa: </label>
				<input class="input_thongso_sp" name="chip_gpu" value="<?php showThongTinSPAt($dataThongSo, $current_index, "Chip_do_hoa") ?>">
				<label>VMemory: </label>
				<input type="number" min="1" class="input_thongso_sp" name="vmemory_gpu"  value="<?php showThongTinSPAt($dataThongSo, $current_index, "VMemory") ?>">
				<label>Thế hệ bộ nhớ: </label>
				<input class="input_thongso_sp" name="thehe_gpu" value="<?php showThongTinSPAt($dataThongSo, $current_index, "The_he_bo_nho") ?>">
<?php
				break;
			case 'mainboard':
?>
				<label>Socket: </label>
				<input class="input_thongso_sp" name="socket_mainboard" value="<?php showThongTinSPAt($dataThongSo, $current_index, "Socket") ?>">
				<label>Chipset: </label>
				<input class="input_thongso_sp" name="chipset_mainboard" value="<?php showThongTinSPAt($dataThongSo, $current_index, "Chipset") ?>">
				<label>Chuẩn kích thước : </label>
				<input class="input_thongso_sp" name="kt_mainboard" value="<?php showThongTinSPAt($dataThongSo, $current_index, "Chuan_kich_thuoc") ?>"> 
<?php
				break;
			case 'ram':
?>
				<label>DDR: </label>
				<input class="input_thongso_sp" name="ddr_ram" value="<?php showThongTinSPAt($dataThongSo, $current_index, "DDR") ?>"> 
				<label>Dung lượng:(GB) </label>
				<input type="number" min="1" class="input_thongso_sp" name="dl_ram" value="<?php showThongTinSPAt($dataThongSo, $current_index, "Dung_luong") ?>">
				<label>Bus: </label>
				<input type="number" min="1" class="input_thongso_sp" name="bus_ram" value="<?php showThongTinSPAt($dataThongSo, $current_index, "Bus") ?>">
<?php			
				break;
			case 'disk':
?>
				<label>Chuẩn kết nối: </label>
				<input class="input_thongso_sp" name="chuanketnoi_disk" value="<?php showThongTinSPAt($dataThongSo, $current_index, "Chuan_ket_noi") ?>">
				<label>Kích thước: </label>
				<input class="input_thongso_sp" name="kt_disk" value="<?php showThongTinSPAt($dataThongSo, $current_index, "Kich_thuoc") ?>">
				<label>Dung lượng: </label>
				<input class="input_thongso_sp" name="dl_disk" value="<?php showThongTinSPAt($dataThongSo, $current_index, "Dung_luong") ?>">
				<label>Loại disk: </label>
				<input class="input_thongso_sp" name="loai_disk" value="<?php showThongTinSPAt($dataThongSo, $current_index, "Loai") ?>">
<?php			
				break;
			case 'case':
?>
				<label>Kiểu case: </label>
				<input class="input_thongso_sp" name="kieu_case" value="<?php showThongTinSPAt($dataThongSo, $current_index, "Kieu_case") ?>">
				<label>Màu: </label>
				<input class="input_thongso_sp" name="mau_case" value="<?php showThongTinSPAt($dataThongSo, $current_index, "Mau") ?>">
				<label>Kiểu Mainboard tương thích: </label>
				<input class="input_thongso_sp" name="kieumain_case" value="<?php showThongTinSPAt($dataThongSo, $current_index, "Kieu_mainboard") ?>">
				<label>Chất liệu case: </label>
				<input class="input_thongso_sp" name="cl_case" value="<?php showThongTinSPAt($dataThongSo, $current_index, "Chat_lieu") ?>">
<?php			
				break;
			
		}
	}
	function show_QL_ChiTiet_SP(){
		if(isset($_GET['id_lk'])){
			$connect = connectDB();
			$query = "Select * from linhkien where ID_LK = ".$_GET['id_lk'];
			$result = mysqli_query($connect, $query);
			$data = array();
			while($row = mysqli_fetch_array($result, 1)){
				$data[] = $row;
			}	
			if(count($data)>0){
				$query = "Select * from linhkien where ID_LK = ".$_GET['id_lk'];
				$result = mysqli_query($connect, $query);
				$linhkien = array();
				while($row = mysqli_fetch_array($result, 1)){
					$linhkien[] = $row;
				}
				
				$query = "Select * from `".$_GET['loai_lk']."` where ID_LK = ".$_GET['id_lk'];
				$result = mysqli_query($connect, $query);
				$thongso = array();
				while($row = mysqli_fetch_array($result, 1)){
					$thongso[] = $row;
				}
				$current_index=0;
				if(isset($_GET['edit'])){
					if($_GET['edit'] == "false"){
?>
						<div class="hang_ngang">
							<img src="<?php echo "../".$linhkien[$current_index]['Hinh_anh']; ?>" class="img_sp">
							<div class="Chi_tiet_SP">
								<p class="ten_sp"><?php showThongTinSPAt($linhkien, $current_index, "Ten_LK") ?></p>
								<p class="thongso_sp">Hãng sản xuất: <?php showThongTinSPAt($thongso, $current_index, "HangSX") ?>  </p>
								<p class="thongso_sp" name="sl_ton">Số lượng hàng tồn: <?php showThongTinSPAt($linhkien, $current_index, "So_luong") ?>  </p>
<?php
								showThongSoSPAt(strtolower($_GET['loai_lk']), $thongso, $current_index);
?>
							</div>
						</div>
						<div class="hang_ngang2">
							<p class="gia_giam">
								<?php echo getThongTinSPAt($linhkien, $current_index, "Gia_LK")*(1 - getThongTinSPAt($linhkien, $current_index, "Giam_gia")); ?>
							</p>
							<div class="hang_doc2">
								<p>-<?php echo 100*getThongTinSPAt($linhkien, $current_index, "Giam_gia"); ?>%</p>
								<del class="gia_goc">
									<?php showThongTinSPAt($linhkien, $current_index, "Gia_LK") ?>
								</del>
							</div>
						</div>
<?php			
						closeDB($connect);
					}
					else{
?>
						<div class="hang_ngang">
							<img src="<?php echo "../".$linhkien[$current_index]['Hinh_anh']; ?>" class="img_sp">
							<div class="Chi_tiet_SP">
								<form method="POST" action="suaTT.php" id="frmSuaTT">
									<input type="text" class="hidden_input" name="id_lk" value="<?php echo $_GET['id_lk'] ?>">
									<input type="text" class="hidden_input" name="loai_lk" value="<?php echo $_GET['loai_lk'] ?>">
									<label>Tên sản phẩm:</label> 
									<input type="text" class="input_ten_sp" name="ten_lk" value="<?php echo $linhkien[$current_index]['Ten_LK'] ?>">
									<label>Hãng sản xuất:</label> 
									<input type="text" class="input_thongso_sp" name="hang_sx" value="<?php showThongTinSPAt($thongso, $current_index, "HangSX") ?> ">
									<label>Số lượng hàng tồn:</label> 
									<input type="text" class="input_thongso_sp" name="sl_ton" value="<?php showThongTinSPAt($linhkien, $current_index, "So_luong") ?>">
<?php
									show_QL_ThongSoSPAt(strtolower($_GET['loai_lk']), $thongso, $current_index);
?>
									<label>Giá:</label> 
									<input type="number" class="input_gia" name="gia_goc" value="<?php showThongTinSPAt($linhkien, $current_index, "Gia_LK") ?>" min="0">
									<label>Giảm giá:</label> 
									<input type="number" class="input_gia" name="giam_gia" lang="en" value="<?php showThongTinSPAt($linhkien, $current_index, "Giam_gia") ?>" min="0" max="0.9" step="0.1">
									<br/>
									<input type="submit" value="Xác nhận chỉnh sửa" class="xac_nhan">
								</form>
							</div>
						</div>
<?php			
						closeDB($connect);
					}
				}
				else{
?>
					<div class="hang_ngang">
						<img src="<?php echo "../".$linhkien[$current_index]['Hinh_anh']; ?>" class="img_sp">
						<div class="Chi_tiet_SP">
							<p class="ten_sp"><?php showThongTinSPAt($linhkien, $current_index, "Ten_LK") ?></p>
							<p class="thongso_sp">Hãng sản xuất: <?php showThongTinSPAt($thongso, $current_index, "HangSX") ?>  </p>
							<p class="thongso_sp" name="sl_ton">Số lượng hàng tồn: <?php showThongTinSPAt($linhkien, $current_index, "So_luong") ?>  </p>
<?php
							showThongSoSPAt(strtolower($_GET['loai_lk']), $thongso, $current_index);
?>
						</div>
					</div>
					<div class="hang_ngang2">
						<p class="gia_giam">
							<?php echo getThongTinSPAt($linhkien, $current_index, "Gia_LK")*(1 - getThongTinSPAt($linhkien, $current_index, "Giam_gia")); ?>
						</p>
						<div class="hang_doc2">
							<p>-<?php echo 100*getThongTinSPAt($linhkien, $current_index, "Giam_gia"); ?>%</p>
							<del class="gia_goc">
								<?php showThongTinSPAt($linhkien, $current_index, "Gia_LK") ?>
							</del>
						</div>
					</div>
<?php			
					closeDB($connect);
				}
			}
			else{
				header("Location: QL_SP.php");
			}
		}
		else header("Location: QL_SP.php");
	}
	function show_QL_DH(){
		if(empty($_GET)){
			$connect = connectDB();
			$query = "Select * from donhang order by ID_DH DESC";
			$result = mysqli_query($connect, $query);
			$data = array();
			while($row = mysqli_fetch_array($result, 1)){
				$data[] = $row;
			}
?>
			<div class="content_DH">
				<div class="DH_ngang">
					<label class="ID_DH"> ID ĐH</label>
					<label class="Date"> Ngày đặt hàng</label>
					<label class="Date"> Ngày giao hàng</label>
					<label class="Status"> Tình trạng</label>
					<label class="Total"> Tổng tiền</label>
				</div>
<?php
				if(count($data)!=0){
					for($i=0;$i<count($data);$i++){
						$id_dh = $data[$i]['ID_DH'];
						$ngay_dat = $data[$i]['Ngay_Dat'];
						$ngay_giao = $data[$i]['Ngay_Giao'];
						$tinh_trang = $data[$i]['Status_DH'];
						$tong_tien = $data[$i]['Tong_tien'];
						
						$query = "Select linhkien.id_lk as ID_LK, linhkien.ten_lk as Ten_LK, chitietdh.So_luong as So_luong, round((Gia_LK*Giam_gia)) as Don_gia from chitietdh join linhkien on chitietdh.id_lk = linhkien.id_lk where ID_DH='".$id_dh."'";
						$result = mysqli_query($connect, $query);
						$data2 = array();
						while($row = mysqli_fetch_array($result, 1)){
							$data2[] = $row;
						}
?>
						<div class="DH_ngang">
							<a class="ID_DH" href="QL_DH.php?ID_DH=<?php echo $id_dh ?>"><?php echo $id_dh ?></a>
							<a class="Date" href="QL_DH.php?ID_DH=<?php echo $id_dh ?>"><?php echo $ngay_dat ?></a>
							<a class="Date" href="QL_DH.php?ID_DH=<?php echo $id_dh ?>"><?php echo $ngay_giao ?></a>
<?php
							if(strcmp($tinh_trang, "Chờ xử lý") == 0){
								echo "<a class=\"Status_ChoXuLy\" href=\"QL_DH.php?ID_DH=".$id_dh."\"> ".$tinh_trang." </a>";
							}
							else{
								echo "<a class=\"Status_DaXuLy\" href=\"QL_DH.php?ID_DH=".$id_dh."\">".$tinh_trang."</a>";
							}
?>
							<a class="Total" href="QL_DH.php?ID_DH=<?php echo $id_dh ?>"><?php echo $tong_tien ?></a>
						</div>
						
<?php
					}
				}
?>
			</div>
<?php
			closeDB($connect);
		}
		else{
			$connect = connectDB();
			$id_dh = $_GET['ID_DH'];
			$query = "Select * from donhang where ID_DH='".$id_dh."'";
			$result = mysqli_query($connect, $query);
			$data = array();
			while($row = mysqli_fetch_array($result, 1)){
				$data[] = $row;
			}
			
			$query = "SELECT chitietdh.ID_LK as ID_LK, chitietdh.So_luong as So_luong, ten_lk, don_gia 
				FROM `chitietdh` join linhkien on chitietdh.ID_LK=linhkien.ID_LK where ID_DH='".$id_dh."'";
			$result = mysqli_query($connect, $query);
			$data2 = array();
			while($row = mysqli_fetch_array($result, 1)){
				$data2[] = $row;
			}
			if(count($data)>0){
				$username_kh = $data[0]['Username_KH'];
				$status = $data[0]['Status_DH'];
				$ngay_dat = $data[0]['Ngay_Dat'];
				$tong_tien = $data[0]['Tong_tien'];
				echo "<div class=\"content_chitiet_dh\">
						<div class=\"header_chitiet_dh\">
							<p>Thông tin đơn hàng</p>
						</div>";
				echo "<div class=\"chitiet_dh\">
						<p>Username Khách hàng: ".$username_kh."</p>";
				if($data[0]['Username_QL'] != null) echo "<p>Username nhân viên: ".$data[0]['Username_QL']."</p>";
				else echo "<p>Username nhân viên: Chưa có nhân viên xử lý đơn hàng</p>";	
				echo "<p>Ngày đặt hàng: ".$ngay_dat."</p>";
				if($data[0]['Ngay_Giao'] != null) echo "<p>Ngày giao hàng: ".$data[0]['Ngay_Giao']."</p>";
				else echo "<p>Ngày giao hàng: Đơn hàng chưa được xử lý</p>";	
				echo "<p>Tổng tiền: ".$tong_tien."</p>";
				echo "</div>";
				echo "<div class=\"header_chitiet_dh\">
						<p>Chi tiết đơn hàng</p>
					</div>";
				echo "<table class=\"tbl_chitiet_dh\">
						<tr>
							<th class=\"id_lk\">ID LK</th>
							<th class=\"ten_lk\">Tên linh kiện</th>
							<th class=\"sl_lk\">Số lượng</th>
							<th class=\"dg_lk\">Đơn giá</th>
						</tr>";
				for($i=0;$i<count($data2);$i++){
					$id_lk = $data2[$i]['ID_LK'];
					$ten_lk = $data2[$i]['ten_lk'];
					$sl_lk = $data2[$i]['So_luong'];
					$dg_lk = $data2[$i]['don_gia'];
					echo "<tr>
							<td class=\"id_lk\">".$id_lk."</td>
							<td class=\"ten_lk\">".$ten_lk."</td>
							<td class=\"sl_lk\">".$sl_lk."</td>
							<td class=\"dg_lk\">".$dg_lk."</td>
						</tr>";
				}
				echo "</table>";
				if(strcmp($status,"Chờ xử lý") == 0){
					echo "<div class=\"header_chitiet_dh\">
							<p>Xứ lý đơn hàng</p>
						</div>";
					echo "<div class=\"chitiet_dh\">
							<form class=\"frmXuLy\" method=\"POST\" action=\"\">
								<input type=\"text\" name=\"id_dh\" value=\"".$id_dh."\" class=\"hidden_input\">
								<p>Ngày giao hàng:</p>
								Ngày:<input type=\"text\" name=\"ngay\">
								Tháng:<input type=\"text\" name=\"thang\">
								Năm:<input type=\"text\" name=\"nam\">
								<br>
								<input type=\"submit\" value=\"Xác nhận\" class=\"submit_dh\">
							</form>
						</div>";
				}					
				echo "</div>";
			}
			closeDB($connect);
		}
	}
?>