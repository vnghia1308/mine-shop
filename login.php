<?php
require_once("config.php");

if(isset($_SESSION["user"])){
	header("location: shop.php");exit;
}

if(!empty($_POST["username"]) && !empty($_POST["password"])){
	$username = $_POST["username"];
	$password = $_POST["password"];
	$user_query = mysqli_query($db, "select * from ls_players where last_name='$username'");
	
	if(mysqli_num_rows($user_query) > 0){
		$user = mysqli_fetch_array($user_query);
		if(password_verify($password, $user["password"])){
			$_SESSION["user"] = $username;
			echo json_encode(array("success" => true, "message" => "login successfully"));
		} else {
			echo json_encode(array("success" => false, "message" => "Wrong password!"));
		}
		
	} else {
		echo json_encode(array("success" => false, "message" => "Username's not found."));
	}
	exit;
}

?>
<!-- Theme: Bootstrap / Code by Vy Nghia / Libary is public source -->
<html>
<head>
	<meta charset="utf-8" />
	<title>MineBede - Login</title>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="css/home.css">
</head>
<body>
<div class="container" id="main">
	<div class="container"></div>
	<div class="row">
		<div class="col-xs-12">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<h3 class="panel-title">Login</h3>
				</div>
				<div class="panel-body">
					<div class="form-group">
						<form id="loginForm">
						  <div class="form-group">
						  	Use your account on game server. 
							<pre>/login <strong>&lt;password&gt;</strong></pre>
							<label for="username">Username</label>
							<input type="text" class="form-control" name="username" id="username" placeholder="Username">
						  </div>
						  <div class="form-group">
							<label for="password">Password</label>
							<input type="password" class="form-control" name="password" id="password" placeholder="Password">
						  </div>
						  <input id="loginBtn" type="submit" class="btn btn-primary" value="Login"></input><br />
						  Not registered account? <a href="register.php">Register now!</a>
						  <pre style="display:none;color:red;" id="status"><div id="status_text"></div></pre>
						</form>
					</div>
				</div>
				<div class="panel-footer"> &copy; 2018 <strong><a href="https://www.facebook.com/nghiadev" target="_blank">Vy Nghia</a></strong></div>
			</div>
		</div>
	</div>
</div>
<script src="js/jquery-2.1.1.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script>
$("#loginForm").on('submit',(function(e) {
	e.preventDefault();
	
	if($("#username").val() != "" && $("#password").val() != ""){
		$.ajax({
			url: "login.php",
			type: "POST",
			data:  new FormData(this),
			dataType:  'json',
			contentType: false,
			cache: false,
			processData:false,
			beforeSend: function () {
				$("#status").hide()
				$('#loginBtn').val('Processing...').prop('disabled', true)
			},
			success: function(r) {
				if(r.success){
					location.reload()
				} else {
					$("#status").show()
					$("#status_text").html(r.message)
				}
			},
			error: function(){
				
				
			},
			complete: function(){
				$('#loginBtn').val('Login').prop('disabled', false)
			}
	   });
	} else {
		$("#status").show()
		$("#status_text").html("Please input username and password!")
	}
}));
</script>
</body>
</html>