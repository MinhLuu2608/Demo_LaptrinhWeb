<?php
	require_once("../DBprocess.php");
	require_once('../HTMLprocess.php');
	require_once("HTMLprocess.php");
	if(isset($_SESSION['username'])){
		$connect = connectDB();
		$query = "Select Quyen_han from Account where username = '".$_SESSION['username']."'";
		$result = mysqli_query($connect, $query);
		$data = array();
		while($row = mysqli_fetch_array($result, 1)){
			$data[] = $row;
		}
		$privilege = $data[0]['Quyen_han'];
		if(isset($_SESSION['privilege']))
			if(strcmp($_SESSION['privilege'],"Owner") == 0 || strcmp($_SESSION['privilege'],"Senior Staff") == 0 || strcmp($_SESSION['privilege'],"Staff") == 0){
				if($privilege != $_SESSION['privilege']){
					header("Location: ../index.php");
				}
			}
			else {
				header("Location: ../index.php");
			}
		else{
			header("Location: ../index.php");
		}
	}
	else{
		header("Location: ../index.php");
	}
?>
<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" href="QL_SP_Them.css" />
	<title>Shop linh kiện Demo</title>
</head>
<body>
	<div class="page_Header">
		<div class="Account">
			<ul>
				<li style="border-left-width: 0px;width:500px;"><a href="../index.php">Shop linh kiện DEMO - bán tất cả loại linh kiện máy tính</a></li>
<?php
				if(isset($_SESSION['username'])){
?>
					<li id="Welcome">
						<p>
							<?php echo "Welcome ".$_SESSION['privilege']." ".$_SESSION['username']; ?> 
						</p>
					</li>
					<li id="Money"> Số dư TK: <?php showSoDuTK($_SESSION['username']) ?> VND</li>
					<li><a href ="../Logout.php">Đăng xuất</a></li>
<?php
				}
?>
			</ul>
		</div>
	</div>
	<div class="nav_bar">
		<a href="index.php">Về trang chủ</a>
		<a href="QL_Account.php">Xem thông tin Account</a>
		<a href="QL_SP.php">Quản lí hàng hóa</a>
		<a href="QL_DH.php">Quản lí đơn hàng</a>
	</div>
	<br>
	<br>
	<div class="admin_content">
		<form method="POST" action="" id="frmLoaiSP">
			<p class="header_chitiet">Bạn muốn thêm linh kiện loại nào ?</p>
			<select name="loai_lk" onChange="document.getElementById('frmLoaiSP').submit();">
<?php
				$selected = '';
				echo "<p>POST = ".$_POST['loai_lk']." || selected = ".$selected."</p>";
				$loai_lk = array('CPU', 'GPU', 'Mainboard', 'RAM', 'Disk', 'Case');
				if(isset($_POST['loai_lk'])){
					$selected = $_POST['loai_lk'];
				}
				else{
					echo "<option value=\"\"></option>";
				}
				for($i=0;$i<6;$i++){
					if($loai_lk[$i] == $selected){
						echo "<option value=\"".$loai_lk[$i]."\" selected>".$loai_lk[$i]."</option>";
					}
					else{

						echo "<option value=\"".$loai_lk[$i]."\">".$loai_lk[$i]."</option>";
					}
				}
?>
			</select>
		</form>
		<form method="POST" action="ThemSP.php" id="frmThemSP" enctype="multipart/form-data">
<?php
			if(isset($_POST['loai_lk'])){
				echo '<p class="header_chitiet">Thông tin linh kiện</p>';
				echo '<input type="text" class="hidden_input" name="loai_lk" value="'.$_POST['loai_lk'].'">';
				echo '<div class="chitiet_them"><label>Tên linh kiện: </label><input type="text" name="ten_lk"></div>';
				echo '<div class="chitiet_them"><label>Hãng sản xuất: </label><input type="text" name="hang_sx"></div>';
				echo '<div class="chitiet_them"><label>Giá linh kiện: </label><input type="number" name="gia_lk" min="0"></div>';
				echo '<div class="chitiet_them"><label>Số lượng: </label><input type="number" name="sl_lk" min="0" step="1" value="0"></div>';
				echo '<div class="chitiet_them"><label>Giảm giá: </label>
						<input type="number" lang="en" name="giamgia_lk" min="0" max="0.9" step="0.1" value="0">
					</div>';
				echo '<p class="header_chitiet">Thông số linh kiện</p>';
				show_QL_Them_SP($_POST['loai_lk']);
				echo '<p class="header_chitiet">Xác nhận</p>';
				echo '<div class="chitiet_them">
						<label>Tình trạng bán: </label>
						<select name="status_ban">
							<option value="Đang bán">Bán luôn sau khi thêm</option>
							<option value="Chờ xử lý">Chờ xử lý sản phẩm trước khi bán</option>
						</select>
						
					</div>';
				echo '<div class="chitiet_them"><label>Chọn hình ảnh linh kiện: </label><input type="file" name="img_lk" accept="image/*"></div>';
				echo '<input type="submit" value="Xác nhận thêm sản phẩm">';
			}
?>
		</form>
	</div>
</body>
</html>

<?php
	if(isset($_SESSION['status_themsp'])){
		$alert = "<script>alert('".$_SESSION['status_themsp']."');</script>";
		echo $alert;
		unset($_SESSION['status_themsp']);
	}
?>