<html>
	<head>
		<title>Pascal 4fun | Đăng ký</title>
		<meta charset="utf-8"/>

		<link rel="stylesheet" type="text/css" href="css/style.css">

		<script src="js/jquery-1.11.3.js"></script>
		<script src="js/script.js"></script>
		
		
	</head>
	<body>
		<header>
			<a href='index.php' class='Link'></a>
			<span id="profile">
				<a href="index.php">Trang chủ</a> | <a href="login.php">Đăng nhập</a>
			</span>
		</header>
		<div id="content">
			<h2>Đăng ký</h2>
			<form method="post" action="register_process.php">
			<table class="small">
			<?php
				$error = isset($_GET['error']) ? $_GET['error'] : '';
				if($error == 1){
			?>
			<tr>
				<td colspan="2" align="center"> 
					<span class="error">Đăng ký không thành công</span>
				</td>	
			</tr>
			<?php	
				}else if($error==2){
			?>
			<tr>
				<td colspan="2" align="center"> 
					<span class="error">Mật khẩu không hợp lệ</span>
				</td>	
			</tr>	
			<?php	
				}else if($error==3){
			?>
			<tr>
				<td colspan="2" align="center"> 
					<span class="error" >Tài khoản không hợp lệ hoặc đã tồn tại</span>
				</td>	
			</tr>	
			<?php
				}			
			?>
			<tr>
				<td valign="top">
					Tài khoản:
				</td>
				<td> 
					<input type="text" name="username" maxlength = "15" style="width: 180px"/>
				</td>	
			</tr>
			<tr>
				<td valign="top">
					Mật khẩu:
				</td>
				<td> 
					<input type="password" name="password" maxlength = "10" style="width: 180px"/>
				</td>	
			</tr>
			<tr>
				<td valign="top">
					Nhập lại mật khẩu:
				</td>
				<td> 
					<input type="password" name="repassword" maxlength = "10" style="width: 180px" />
				</td>	
			</tr>
			<tr>
				<td valign="top">
					Họ và tên:
				</td>
				<td> 
					<input type="text" name="fullname" style="width: 180px" />
				</td>	
			</tr>
			<tr>
				<td>				
				</td>
				<td>
					<input type="submit" class="btn btn2" value="Đồng ý" id="register" />
					<input type="reset" class="btn" value="Hủy bỏ" id="cancel" />
				</td>									
			</tr>
			
			</table>
			</form>
		</div>
	</body>
</html>
