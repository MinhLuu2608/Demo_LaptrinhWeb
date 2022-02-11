<?php
	require_once('DBconnect.php');
	function showSoDuTK($username){
		$connect = connectDB();
		$query = "Select So_du from account where username ='".$username."'";
		$result = mysqli_query($connect, $query);
		$data = array();
		while($row = mysqli_fetch_array($result, 1)){
			$data[] = $row;
		}
		echo $data[0]['So_du'];
	}
	function showThongTinSPAt($data, $index, $rowName){
		echo $data[$index][$rowName];
	}
	function getThongTinSPAt($data, $index, $rowName){
		return $data[$index][$rowName];
	}
	function showThongSoSPAt($loai_lk, $dataThongSo, $current_index){
		switch($loai_lk){
			case 'cpu':
?>
				<p class="thongso_sp">Đời: <?php showThongTinSPAt($dataThongSo, $current_index, "Series") ?> </p>
				<p class="thongso_sp">Số core: <?php showThongTinSPAt($dataThongSo, $current_index, "Core") ?> </p>
				<p class="thongso_sp">Xung: <?php showThongTinSPAt($dataThongSo, $current_index, "Xung") ?> </p>
				<p class="thongso_sp">Socket: <?php showThongTinSPAt($dataThongSo, $current_index, "Socket") ?> </p>
<?php
				break;
			case 'gpu':
?>
				<p class="thongso_sp">Chip đồ họa: <?php showThongTinSPAt($dataThongSo, $current_index, "Chip_do_hoa") ?> </p>
				<p class="thongso_sp">VMemory: <?php showThongTinSPAt($dataThongSo, $current_index, "VMemory") ?> </p>
				<p class="thongso_sp">Thế hệ bộ nhớ: <?php showThongTinSPAt($dataThongSo, $current_index, "The_he_bo_nho") ?> </p>
<?php
				break;
			case 'mainboard':
?>
				<p class="thongso_sp">Socket: <?php showThongTinSPAt($dataThongSo, $current_index, "Socket") ?> </p>
				<p class="thongso_sp">Chipset: <?php showThongTinSPAt($dataThongSo, $current_index, "Chipset") ?> </p>
				<p class="thongso_sp">Chuẩn kích thước : <?php showThongTinSPAt($dataThongSo, $current_index, "Chuan_kich_thuoc") ?> </p>
<?php
				break;
			case 'ram':
?>
				<p class="thongso_sp">DDR: <?php showThongTinSPAt($dataThongSo, $current_index, "DDR") ?> </p>
				<p class="thongso_sp">Dung lượng: <?php showThongTinSPAt($dataThongSo, $current_index, "Dung_luong") ?> </p>
				<p class="thongso_sp">Bus: <?php showThongTinSPAt($dataThongSo, $current_index, "Bus") ?> </p>
<?php			
				break;
			case 'disk':
?>
				<p class="thongso_sp">Chuẩn kết nối: <?php showThongTinSPAt($dataThongSo, $current_index, "Chuan_ket_noi") ?> </p>
				<p class="thongso_sp">Kích thước: <?php showThongTinSPAt($dataThongSo, $current_index, "Kich_thuoc") ?> </p>
				<p class="thongso_sp">Dung lượng: <?php showThongTinSPAt($dataThongSo, $current_index, "Dung_luong") ?> </p>
				<p class="thongso_sp">Loại disk: <?php showThongTinSPAt($dataThongSo, $current_index, "Loai") ?> </p>
<?php			
				break;
			case 'case':
?>
				<p class="thongso_sp">Kiểu case: <?php showThongTinSPAt($dataThongSo, $current_index, "Kieu_case") ?> </p>
				<p class="thongso_sp">Màu: <?php showThongTinSPAt($dataThongSo, $current_index, "Mau") ?> </p>
				<p class="thongso_sp">Kiểu Mainboard tương thích: <?php showThongTinSPAt($dataThongSo, $current_index, "Kieu_mainboard") ?> </p>
				<p class="thongso_sp">Chất liệu case: <?php showThongTinSPAt($dataThongSo, $current_index, "Chat_lieu") ?> </p>
<?php			
				break;
			
		}
	}
	function showAllSP(){
		$connect = connectDB();
		//Lay so luong san pham
		$query = "Select count(*) as amount from linhkien where Sale_Status='Đang bán'";
		$result = mysqli_query($connect, $query);
		$data = array();
		while($row = mysqli_fetch_array($result, 1)){
			$data[] = $row;
		}
		$amount = $data[0]['amount'];  
		$so_hang = ceil($amount/4);
		
		//Lay thong tin san pham
		$query = "Select * from linhkien where Sale_Status='Đang bán'";
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
						<img src="<?php showThongTinSPAt($data, $current_index, "Hinh_anh") ?>" class="img_sp">
						<p class="ten_sp" title="<?php showThongTinSPAt($data, $current_index, "Ten_LK") ?>">
							<?php showThongTinSPAt($data, $current_index, "Ten_LK") ?>
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
					<img src="<?php showThongTinSPAt($data, $current_index, "Hinh_anh") ?>" class="img_sp">
					<p class="ten_sp" title="<?php showThongTinSPAt($data, $current_index, "Ten_LK") ?>">
							<?php showThongTinSPAt($data, $current_index, "Ten_LK") ?>
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
	function showSearchSP(){
		$connect = connectDB();
		$search_key = $_GET['search_key'];
		//Lay so luong san pham
		$query = "Select count(*) as amount from linhkien where `Ten_LK` like '%".$search_key."%' and Sale_Status='Đang bán'";
		$result = mysqli_query($connect, $query);
		$data = array();
		while($row = mysqli_fetch_array($result, 1)){
			$data[] = $row;
		}
		$amount = $data[0]['amount'];  
		$so_hang = ceil($amount/4);
		
		//Lay thong tin san pham
		$query = "Select * from linhkien where `Ten_LK` like '%".$search_key."%' and Sale_Status='Đang bán'";
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
						<img src="<?php showThongTinSPAt($data, $current_index, "Hinh_anh") ?>" class="img_sp">
						<p class="ten_sp" title="<?php showThongTinSPAt($data, $current_index, "Ten_LK") ?>">
							<?php showThongTinSPAt($data, $current_index, "Ten_LK") ?>
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
					<img src="<?php showThongTinSPAt($data, $current_index, "Hinh_anh") ?>" class="img_sp">
					<p class="ten_sp" title="<?php showThongTinSPAt($data, $current_index, "Ten_LK") ?>">
							<?php showThongTinSPAt($data, $current_index, "Ten_LK") ?>
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
	function showChiTietSP(){
		if(isset($_GET['id_lk'])){
			$connect = connectDB();
			$query = "Select * from linhkien where Sale_Status='Đang bán' and ID_LK = ".$_GET['id_lk'];
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
?>
				<div class="hang_ngang">
					<img src="<?php showThongTinSPAt($linhkien, $current_index, "Hinh_anh") ?>" class="img_sp">
					<div class="Chi_tiet_SP">
						<p class="ten_sp"><?php showThongTinSPAt($linhkien, $current_index, "Ten_LK") ?></p>
						<p class="thongso_sp">Hãng sản xuất: <?php showThongTinSPAt($thongso, $current_index, "HangSX") ?>  </p>
						<p class="thongso_sp" name="sl_ton">Số lượng hàng tồn: <?php showThongTinSPAt($linhkien, $current_index, "So_luong") ?>  </p>
<?php
						showThongSoSPAt(strtolower($_GET['loai_lk']), $thongso, $current_index);
?>
						<form method="POST" id="frmMua">
							<input type="text" name="id_lk" class="hidden_input" value="<?php echo $_GET['id_lk'] ?>">
							<input type="text" name="loai_lk" class="hidden_input" value="<?php echo $_GET['loai_lk'] ?>">
							<input type="text" name="sl_ton" class="hidden_input" value="<?php showThongTinSPAt($linhkien, $current_index, "So_luong") ?>">
							<input type="button" class="dau" value="-" onClick="document.getElementById('soluong_sp').value--;">
							<input type="number" name="sl_sp" class="so_luong" value="1" min="1" id="soluong_sp">
							<input type="button" class="dau" value="+" onClick="document.getElementById('soluong_sp').value++;">
							<input type="submit" value="Mua ngay" class="gio_hang" id="Buy" onClick="frmMua.action='muaNgay.php'">
							<input type="submit" value="Thêm vào giỏ hàng" class="gio_hang" id="add_Cart" onClick="frmMua.action='addCart.php'">
						</form>
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
				header("Location: index.php");
			}
		}
		else header("Location: index.php");
	}
	
	function showUserInfo(){
		$connect = connectDB();
		$query = "Select * from info_user where username = '".$_SESSION['username']."'";
		$result = mysqli_query($connect, $query);
		$data = array();
		while($row = mysqli_fetch_array($result, 1)){
			$data[] = $row;
		}
		$current_index = 0;
?>
		<div class="thong_tin">
			<div class="div_edit_status">
<?php
				if(!isset($_GET['editor_status']) || $_GET['editor_status'] == 'false'){
?>
					<a href="ManagePage.php?editor_status=true">Thực hiện chỉnh sửa </a>
<?php
				}
				else{
?>
					<a href="ManagePage.php?editor_status=false">Hủy trạng thái chỉnh sửa </a>
<?php
				}
?>
			</div>
			<form method="POST" action="Edit_Info_Process.php" class="frmUserInfo">
<?php		
				if(!isset($_GET['editor_status']) || $_GET['editor_status'] == 'false'){ 
?>
					<table class="tblRegister">
						<tr>
							<td class="title">Họ và tên: </td>
							<td class="info"><?php showThongTinSPAt($data, $current_index, "Hoten_User") ?></td>
						</tr>
						<tr>
							<td class="title">Địa chỉ: </td>
							<td class="info"><?php showThongTinSPAt($data, $current_index, "Diachi_User") ?></td>
						</tr>
						<tr>
							<td class="title">Số điện thoại: </td>
							<td class="info"><?php showThongTinSPAt($data, $current_index, "SoDT_User") ?></td>
						</tr>
						<tr>
							<td class="title">Email: </td>
							<td class="info"><?php showThongTinSPAt($data, $current_index, "Email_User") ?></td>
						</tr>
					</table>
<?php
				}
				else{
?>
					<table class="tblRegister">
						<tr>
							<td class="title">Họ và tên: </td>
							<td class="info">
								<input type="text" name="Hoten" value="<?php showThongTinSPAt($data, $current_index, "Hoten_User"); ?>" >
							</td>
						</tr>
						<tr>
							<td class="title">Địa chỉ: </td>
							<td class="info">
								<input type="text" name="Address" value="<?php showThongTinSPAt($data, $current_index, "Diachi_User"); ?>">
							</td>
						</tr>
						<tr>
							<td class="title">Số điện thoại: </td>
							<td class="info">
								<input type="tel" name="Tel" value="<?php showThongTinSPAt($data, $current_index, "SoDT_User") ?>" pattern="[0-9]{10}">
							</td>
						</tr>
						<tr>
							<td class="title">Email: </td>
							<td class="info">
								<input type="email" name="Email" value="<?php showThongTinSPAt($data, $current_index, "Email_User") ?>">
							</td>
						</tr>
					</table>
<?php
				}
				if(isset($_GET['editor_status']) && $_GET['editor_status'] == 'true'){
?>
					<input type="submit" value="Xác nhận chỉnh sửa" class="xac_nhan">
<?php
				}
?>
			</form>
		</div>
<?php			
		closeDB($connect);
	}
	function showChangePass(){
?>
		<div class="thong_tin">
			<form method="POST" action="changePass.php" class="frmChangePass">
				<table class="tblChangePass">
					<tr>
						<td class="title">Nhập password hiện tại:</td>
						<td class="info"><input type="password" name="oldPass"></td>
					</tr>
					<tr>
						<td class="title">Nhập password mới:</td>
						<td class="info"><input type="password" name="newPass"></td>
					</tr>
					<tr>
						<td class="title">Nhập lại password mới:</td>
						<td class="info"><input type="password" name="re-newPass"> </td>
					</tr>
				</table>
				<br>
				<input type="submit" value="Xác nhận đổi mật khẩu" class="xac_nhan_pass">
			</form>
		</div>
<?php	
	}
	
	function showCart(){
		$connect = connectDB();
		$query = "SELECT user_cart.ID_LK as ID_LK, user_cart.So_luong as So_luong, linhkien.So_luong as So_luong_max, Don_gia, Tong, Ten_LK FROM `user_cart` 
			join linhkien on user_cart.ID_LK=linhkien.ID_LK where username='".$_SESSION['username']."'";
		$result = mysqli_query($connect, $query);
		$data = array();
		while($row = mysqli_fetch_array($result, 1)){
			$data[] = $row;
		}
		$Tong_cong = 0;
?>
		<div class="divCart">
			<table class="tblCart">
				<tr>
					<th>ID Linh kiện</th>
					<th class="ten_sp">Tên sản phẩm</th>
					<th colspan="3">Số lượng</td>
					<th class="don_gia">Đơn giá</th>
				</tr>
<?php
				if(count($data) != 0){
					for($i=0;$i<count($data);$i++){
						$id = getThongTinSPAt($data, $i, 'ID_LK');
						$ten = getThongTinSPAt($data, $i, 'Ten_LK');
						$sl = getThongTinSPAt($data, $i, 'So_luong');
						$sl_max = getThongTinSPAt($data, $i, 'So_luong_max');
						$don_gia = getThongTinSPAt($data, $i, 'Don_gia');
						$tong = getThongTinSPAt($data, $i, 'Tong');						
						$Tong_cong += $tong;
?>
						</tr>
							<form method="POST" id="frm_GioHang_<?php echo $i ?>" action="">
								<input type="text" name="id_lk" class="hidden_input" value="<?php echo $id ?>">
								<input type="text" id="sl_hientai_<?php echo $i ?>" name="sl_hientai" class="hidden_input" value="<?php echo $sl ?>">
								<input type="text" name="dongia_lk" class="hidden_input" value="<?php echo $don_gia ?>">
								<td><?php echo $id ?></td>
								<td><?php echo $ten ?></td>
								<td>
									<input type="button" class="dau" value="-" 
										onClick="if(document.getElementById('soluong_sp<?php echo $i ?>').value - 1 >= document.getElementById('soluong_sp<?php echo $i ?>').min){
												document.getElementById('soluong_sp<?php echo $i ?>').value--;
												document.getElementById('sl_hientai_<?php echo $i ?>').value=document.getElementById('soluong_sp<?php echo $i ?>').value;
												frm_GioHang_<?php echo $i ?>.action='Capnhat_soluong_Cart.php';
												document.getElementById('frm_GioHang_<?php echo $i ?>').submit();
											}">
											
								</td>
								<td><input type="number" id="soluong_sp<?php echo $i ?>" name="sl_sp" class="so_luong" value="<?php echo $sl ?>" min="1" max="<?php echo $sl_max ?>"></td>
								<td>
									<input type="button" class="dau" value="+" 
										onClick="if(document.getElementById('soluong_sp<?php echo $i ?>').value + 1 <= document.getElementById('soluong_sp<?php echo $i ?>').max){
												document.getElementById('soluong_sp<?php echo $i ?>').value++;
												document.getElementById('sl_hientai_<?php echo $i ?>').value=document.getElementById('soluong_sp<?php echo $i ?>').value;
												frm_GioHang_<?php echo $i ?>.action='Capnhat_soluong_Cart.php';
												document.getElementById('frm_GioHang_<?php echo $i ?>').submit();
											}">
								</td>
								<td><?php echo $don_gia ?></td>
								<td>
									<p class="xoa_button" onClick="frm_GioHang_<?php echo $i ?>.action='Xoa_sp_Cart.php';document.getElementById('frm_GioHang_<?php echo $i ?>').submit();">
										Xóa
									</p>
								</td>
							</form>
						<tr>
<?php
					}
?>
					<tr>
						<th class="Tong_cong" colspan="3">Tổng cộng:</td>
						<th class="Tong_tien" colspan="3"><?php echo $Tong_cong ?></th>
					</tr>
<?php
				}						
?>				
			</table>	
			<br>
<?php
			if(count($data) != 0){
?>
				<a href="MuaNgay_Cart.php" class="MuaNgay_Cart"> Mua Ngay </a>
<?php
			}
			else{
?>
				<a href="index.php" class="MuaNgay_Cart"> Giỏ hàng rỗng. Đi mua ngay </a>
<?php
			}
?>
		</div>
<?php		
		closeDB($connect);
	}
	
	function showHoaDon(){
		$connect = connectDB();
		$query = "Select * from donhang where username_KH='".$_SESSION['username']."'";
		$result = mysqli_query($connect, $query);
		$data = array();
		while($row = mysqli_fetch_array($result, 1)){
			$data[] = $row;
		}
?>
		<div class="div_HoaDon">
			<div class="HD_ngang">
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
					<details class="Details_HD_ngang">
						<summary>
							<p class="ID_DH"><?php echo $id_dh ?></p>
							<p class="Date"><?php echo $ngay_dat ?></p>
							<p class="Date"><?php echo $ngay_giao ?></p>
							<p class="Status"><?php echo $tinh_trang ?></p>
							<p class="Total"><?php echo $tong_tien ?></p>
						</summary>
						<div class="Chitiet_HD_header">
							<label class="ID_LK"> ID LK</label>
							<label class="Ten_LK"> Tên LK</label>
							<label class="SL_LK"> Số lượng</label>
							<label class="Don_gia"> Đơn giá</label>
						</div>
<?php						
						for($j=0;$j<count($data2);$j++){
							$id_lk = $data2[$j]['ID_LK'];
							$ten_lk = $data2[$j]['Ten_LK'];
							$sl_lk = $data2[$j]['So_luong'];
							$don_gia = $data2[$j]['Don_gia'];
?>	
							<div class="Chitiet_HD">
								<label class="ID_LK"><?php echo $id_lk ?> </label>
								<label class="Ten_LK"><?php echo $ten_lk ?></label>
								<label class="SL_LK"><?php echo $sl_lk ?></label>
								<label class="Don_gia"><?php echo $don_gia ?></label>
							</div>
<?php							
						}
?>						
					</details>
					
<?php
				}
			}
?>
		</div>
<?php
		closeDB($connect);
	}
	
?>