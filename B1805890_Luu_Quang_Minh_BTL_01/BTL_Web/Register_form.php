<?php
	require_once("DBprocess.php");
	if(isset($_SESSION['username'])){
		header("Location: index.php");
	}
	if(isset($_POST['username']) && isset($_POST['password'])){
		login();	
	}
?>
<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" href="Register_form.css" />
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
						<li id="Welcome"><?php echo "Welcome ".$_SESSION['username']; ?> </li>
						<li id="Money"> Số dư TK: VND</li>
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
	<div class="register">
		<form method="POST" action="" class="frmRegister">
			<table class="tblRegister">
				<tr>
					<td>Họ và tên: </td>
					<td><input type="text" name="hoten" size="50"></td>
				</tr>
				<tr>
					<td>Username: </td>
					<td><input type="text" name="reg_username" size="50"></td>
				</tr>
				<tr>
					<td>Password: </td>
					<td><input type="password" name="reg_password" size="50"></td>
				</tr>
				<tr>
					<td>Retype Password: </td>
					<td><input type="password" name="re-pass" size="50"></td>
				</tr>
				<tr>
					<td>Email: </td>
					<td><input type="email" name="email" size="50" placeholder="abc@gmail.com"></td>
				</tr>
				<tr>
					<td>Địa chỉ: </td>
					<td><input type="text" name="address" size="50"></td>
				</tr>
				<tr>
					<td>Số điện thoại: </td>
					<td><input type="tel" name="phone_number" size="50" pattern="[0-9]{10}" placeholder="0123456789"></td>
				</tr>
			<table>
			<br>
			<input type="submit" value="Đăng ký" class="button"> &nbsp;
			<input type="reset" value="Hủy bỏ" class="button"><br>
		</form>
	</div>
</body>
</html>

<?php
	if(isset($_SESSION['login_status'])){
		$alert = "<script>alert('".$_SESSION['login_status']."');</script>";
		echo $alert;
		unset($_SESSION['login_status']);
	}
	if(isset($_SESSION['register_status'])){
		$alert = "<script>alert('".$_SESSION['register_status']."');</script>";
		echo $alert;
		unset($_SESSION['register_status']);
	}
	if(isset($_POST['reg_username']) && isset($_POST['reg_password']) && isset($_POST['hoten']) && isset($_POST['re-pass'])
		&& isset($_POST['email']) && isset($_POST['address']) && isset($_POST['phone_number']) )
	{
		register();	
	}
?>