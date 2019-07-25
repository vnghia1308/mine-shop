<?php
require_once("config.php");

if(isset($_SESSION["user"])){
	header("location: shop.php");exit;
}

if(!empty($_POST["username"]) && !empty($_POST["password"])){
	$username = $_POST["username"];
	$password = $_POST["password"];
	$query = mysqli_query($db, "select * from mine_users where username='$username'");
	
	if(mysqli_num_rows($query) < 1){
		$register = mysqli_query($db, "INSERT INTO user(id, username, password, bdcoins) VALUES (NULL,'$username','$password', 10000)");
		if(!$register){
			die(json_encode(array("success" => false, "message" => "Can't register account, please try again")));
		}
		
		$_SESSION["user"] = $username;
		echo json_encode(array("success" => true, "message" => "Register successfully"));
	} else {
		echo json_encode(array("success" => false, "message" => "Account's exists."));
	}
	exit;
}

?>
<!-- Theme: Bootstrap / Code by Vy Nghia / Libary is public source -->
<html>
<head>
	<meta charset="utf-8" />
	<title>MineBede - Register</title>
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
					<h3 class="panel-title">Register</h3>
				</div>
				<div class="panel-body">
					<div class="form-group">
					Use your account on game server. 
					<pre>/register <strong>&lt;password&gt;</strong></pre>
					Have an account? <a href="login.php">Login now!</a>
					<?php /* <form id="registerForm">
						  <div class="form-group">
							<label for="username">Username</label>
							<input type="text" class="form-control" name="username" id="username" placeholder="Username">
						  </div>
						  <div class="form-group">
							<label for="password">Password</label>
							<input type="password" class="form-control" name="password" id="password" placeholder="Password">
						  </div>
						  <input id="loginBtn" type="submit" class="btn btn-primary" value="Register"></input><br />
						  Have an account? <a href="login.php">Login now!</a>
						  <pre style="display:none;color:red;" id="status"><div id="status_text"></div></pre>
						</form> */ ?>
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
$("#registerForm").on('submit',(function(e) {
	e.preventDefault();
	
	if($("#username").val() != "" && $("#password").val() != ""){
		$.ajax({
			url: "register.php",
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
				$('#loginBtn').val('Register').prop('disabled', false)
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