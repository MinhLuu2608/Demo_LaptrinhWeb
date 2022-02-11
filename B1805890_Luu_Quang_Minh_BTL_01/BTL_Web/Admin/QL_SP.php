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
	<link rel="stylesheet" href="QL_SP.css" />
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
		<div class="search_bar">
			<ul>
				<li>
					<form method="GET" action="" id="frmSearch">
						<input type="text" name="search_key" placeholder="Nhập tên sản phẩm" class="search_box">
						<input type="submit" class="search_submit" value="Search">
					</form>
				</li>
			</ul>
		</div>
		<div class="danh_muc">
			<a href="QL_SP_Them.php"> Thêm sản phẩm</a>
		</div>
		<br>
<?php
		if(empty($_GET)){
			show_QL_All_SP();
		}
		if(isset($_GET['search_key'])){
			show_QL_Search_SP();
		}
		
?>
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
	