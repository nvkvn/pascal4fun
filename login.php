<html>
	<head>
		<title>Pascal 4fun | Login</title>
		<meta charset="utf-8"/>

		<link rel="stylesheet" type="text/css" href="css/style.css">

	</head>
	<body>
		<header>
			<a href='index.php' class='Link'></a>
			<span id="profile">
				<a href="index.php">Trang chủ</a> | <a href="register.php">Đăng ký</a>
			</span>
		</header>
		<div id="content">
		<h2>Đăng nhập</h2>
		<form method="post" action="login_process.php">
		<table class="small">
		<tr>
			<td valign="top">
				Tài khoản
			</td>
			<td> 
				<input type="text" name="username" style="width: 180px" />
			</td>	
		</tr>
		
		<tr>
			<td valign="top">
				Mật khẩu
			</td>
			<td>
				<input type="password" name="password" style="width: 180px" />
			</td>									
		</tr>
		<tr>
			<td>				
			</td>
			<td>
				<input type="submit" class="btn btn2" value="Đồng ý" id="login" />
				<input type="reset" class="btn" value="Hủy bỏ" id="cancel" />
			</td>									
		</tr>
		
		</table>
		</form>
		</div>
	</body>
</html>
