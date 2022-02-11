<?php
	require_once("DBprocess.php");
	require_once("HTMLprocess.php");
	if(!isset($_SESSION['username'])){
		header("Location: index.php");
	}
?>
<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" href="ManagePage.css" />
	<title>Shop linh kiện Demo</title>
</head>
<body>
	<div class="page_Header">
		<div class="Account">
			<ul>
				<form method="POST" action="" id="frmAccount">
					<li style="border-left-width: 0px;width:500px;"><p>Shop linh kiện DEMO - bán tất cả loại linh kiện máy tính</p></li>
				<?php
					if(isset($_SESSION['username'])){
				?>
						<li id="Welcome">
							<a href="ManagePage.php">
								<?php echo "Welcome ".$_SESSION['username']; ?> 
							</a>
						</li>
						<li id="Money"> Số dư TK: <?php showSoDuTK($_SESSION['username']) ?> VND</li>
						<li><a href ="Logout.php">Đăng xuất</a></li>
				<?php
					}
					else{
				?>
							<li>
								<input type="text" name="username" size="20" value="" placeholder="Nhập vào username" style="height:30px">
							</li>
							<li>
								<input type="password" name="password" size="20" placeholder="Nhập vào password" style="height:30px">
							</li>
							<li><label id="Login" onClick="document.getElementById('frmAccount').submit();">Đăng nhập </label></li>
							<li><a href ="Register_form.php" id="Register">Đăng ký </a></li>
				<?php
					}
				?>
				</form>
			</ul>
		</div>
	</div>
	<div class="nav_bar">
		<a href="index.php">Trang chủ</a>
		<a href="">Giới thiệu</a>
		<a href="">Tin tức</a>
		<a href="">Khuyến mãi</a>
		<a href="">Liên hệ</a>
	</div>
	<br>
	<div class="hang_ngang">
		<div class="danh_muc">
			<a href="ManagePage.php?info=userInfo" id="userInfo"> Thông tin tài khoản </a>
			<a href="ManagePage.php?info=changePass" id="changePass"> Thay đổi mật khẩu </a>
			<a href="ManagePage.php?info=GioHang" id="gioHang"> Xem giỏ hàng </a>
			<a href="ManagePage.php?info=hoaDon" id="hoaDon"> Xem hóa đơn </a>
<?php
			if(strcmp($_SESSION['privilege'],"Owner") == 0 || strcmp($_SESSION['privilege'],"Senior Staff") == 0 || strcmp($_SESSION['privilege'],"Staff") == 0){
				echo "<a href=\"Admin/index.php\"> Đến trang quản lý </a>";
			}
?>
		</div>
<?php
		if(isset($_GET['info'])){
			if($_GET['info'] == "userInfo"){
				showUserInfo();
			}
			if($_GET['info'] == "changePass"){
				showChangePass();
			}
			if($_GET['info'] == "GioHang"){
				showCart();
			}
			if($_GET['info'] == "hoaDon"){
				showHoaDon();
			}
		}
		else showUserInfo();
?>
</body>
</html>

<?php
	if(isset($_SESSION['changePass_status'])){
		$alert = "<script>alert('".$_SESSION['changePass_status']."');</script>";
		echo $alert;
		unset($_SESSION['changePass_status']);
	}
	if(isset($_SESSION['cart_buy_status'])){
		$alert = "<script>alert('".$_SESSION['cart_buy_status']."');</script>";
		echo $alert;
		unset($_SESSION['cart_buy_status']);
	}
?>