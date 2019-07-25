<?php
require_once("config.php");

if(!isset($_SESSION["user"])){
	header("location: login.php");exit;
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
					<h3 class="panel-title">Set Skins -- <a href="shop.php">[Shop]</a> -- <a href="trade.php">[Sell Items]</a> -- <a href="logout.php">[Logout]</a></h3>
				</div>
				<div class="panel-body">
					<div class="form-group">
						<form id="skinForm">
						  <div class="form-group">
						  	<pre>Free in now :) Greetings, vynghia.</pre>
							<label for="skin_name">Skin model</label>
							<input type="text" class="form-control" name="skin_name" id="skin_name" placeholder="skin_name">
						  </div>
						  <input id="loginBtn" type="submit" class="btn btn-primary" value="Change"></input>
						  <div style="display:none;" id="status"><br /><pre id="pre_text"><div id="status_text"></div></pre></div>
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
$("#skinForm").on('submit',(function(e) {
	e.preventDefault();
	
	if($("#skin_name").val()){
		$.ajax({
			url: "events/set_skins.php",
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
					$("#status").show()
					$("#pre_text").css("color", "green")
					$("#status_text").html(r.message)
				} else {
					$("#status").show()
					$("#pre_text").css("color", "red")
					$("#status_text").html(r.message)
				}
			},
			error: function(){
				
				
			},
			complete: function(){
				$('#loginBtn').val('Change').prop('disabled', false)
			}
	   });
	} else {
		$("#status").show()
		$("#pre_text").css("color", "red")
		$("#status_text").html("Can't empty input!")
	}
}));
</script>
</body>
</html>