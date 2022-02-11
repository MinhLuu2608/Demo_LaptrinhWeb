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
	<link rel="stylesheet" href="chitiet_SP.css" />
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
<?php
		if(isset($_GET['edit'])){
			if($_GET['edit'] == "false"){
				echo '<div class="sua_thongtin">
						<a href="chitiet_SP.php?id_lk='.$_GET['id_lk'].'&loai_lk='.$_GET['loai_lk'].'&edit=true">Sửa</a>';
				$connect = connectDB();
				$query = "Select Sale_status from linhkien where ID_LK = ".$_GET['id_lk'];
				$result = mysqli_query($connect, $query);
				$data = array();
				while($row = mysqli_fetch_array($result, 1)){
					$data[] = $row;
				}
				if(strcmp($data[0]['Sale_status'],"Ngừng bán") == 0){
					echo '<form method="POST" action="suaSaleStatus.php" id="frmSuaSale">
							<input type="text" class="hidden_input" name="id_lk" value="'.$_GET['id_lk'].'">
							<input type="text" class="hidden_input" name="loai_lk" value="'.$_GET['loai_lk'].'">
							<input type="text" class="hidden_input" name="sale_status" value="Đang bán">
							<input type="submit" value="Bán">
						</form>
					</div>';
				}
				else{
					echo '<form method="POST" action="suaSaleStatus.php" id="frmSuaSale">
							<input type="text" class="hidden_input" name="id_lk" value="'.$_GET['id_lk'].'">
							<input type="text" class="hidden_input" name="loai_lk" value="'.$_GET['loai_lk'].'">
							<input type="text" class="hidden_input" name="sale_status" value="Ngừng bán">
							<input type="submit" value="Ngừng bán">
						</form>
					</div>';
				}
			}
			else{
				echo '<div class="sua_thongtin">
						<a href="chitiet_SP.php?id_lk='.$_GET['id_lk'].'&loai_lk='.$_GET['loai_lk'].'&edit=false">Hủy bỏ</a> 
					</div>';
			}
		}
		else{
			echo '<div class="sua_thongtin">
					<a href="chitiet_SP.php?id_lk='.$_GET['id_lk'].'&loai_lk='.$_GET['loai_lk'].'&edit=true">Sửa</a>';
			$connect = connectDB();
			$query = "Select Sale_status from linhkien where ID_LK = ".$_GET['id_lk'];
			$result = mysqli_query($connect, $query);
			$data = array();
			while($row = mysqli_fetch_array($result, 1)){
				$data[] = $row;
			}
			if(strcmp($data[0]['Sale_status'],"Ngừng bán") == 0){
				echo '<form method="POST" action="suaSaleStatus.php" id="frmSuaSale">
						<input type="text" class="hidden_input" name="id_lk" value="'.$_GET['id_lk'].'">
						<input type="text" class="hidden_input" name="loai_lk" value="'.$_GET['loai_lk'].'">
						<input type="text" class="hidden_input" name="sale_status" value="Đang bán">
						<input type="submit" value="Bán">
					</form>
				</div>';
			}
			else{
				echo '<form method="POST" action="suaSaleStatus.php" id="frmSuaSale">
						<input type="text" class="hidden_input" name="id_lk" value="'.$_GET['id_lk'].'">
						<input type="text" class="hidden_input" name="loai_lk" value="'.$_GET['loai_lk'].'">
						<input type="text" class="hidden_input" name="sale_status" value="Ngừng bán">
						<input type="submit" value="Ngừng bán">
					</form>
				</div>';
			}
		}
?>
		<div class="admin_content">
			<div class="content">
				<?php show_QL_ChiTiet_SP(); ?>
			</div>
		</div>
	
</body>
</html>

<?php
	if(isset($_SESSION['status_suatt'])){
		$alert = "<script>alert('".$_SESSION['status_suatt']."');</script>";
		echo $alert;
		unset($_SESSION['status_suatt']);
	}
	if(isset($_SESSION['sale_status'])){
		$alert = "<script>alert('".$_SESSION['sale_status']."');</script>";
		echo $alert;
		unset($_SESSION['sale_status']);
	}
?>