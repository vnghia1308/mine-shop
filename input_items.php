<?php
require_once("config.php");

if(isset($_GET["u"])){
	if($_GET["u"] !== "@_vynghia1308"){
		exit;
	}
} else {
	exit;
}

if(!empty( $_POST["item_name"]) && !empty($_POST["item_id"]) && !empty($_POST["item_icon"]) && !empty($_POST["item_price"])){
	$item_id = $_POST["item_id"];
	$item_name = $_POST["item_name"];
	$item_icon = $_POST["item_icon"];
	$item_price = $_POST["item_price"];
	$query = mysqli_query($db, "select * from shop_items where item_id='$item_id'");
	
	if(mysqli_num_rows($query) < 1){
		$additem = mysqli_query($db, "INSERT INTO shop_items (id, item_name, item_id, item_icon, item_price) VALUES (NULL, '$item_name', '$item_id', '$item_icon', '$item_price')");
		if(!$additem){
			die(json_encode(array("success" => false, "message" => "Can't add item, please try again")));
		}
		
		echo json_encode(array("success" => true, "message" => "Add item successfully"));
	} else {
		echo json_encode(array("success" => false, "message" => "Item's exists."));
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
	<link rel="stylesheet" href="css/mine.css">
</head>
<body>
<div class="container" id="main">
	<div class="container"></div>
	<div class="row">
		<div class="col-xs-12">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<h3 class="panel-title">Input items</h3>
				</div>
				<div class="panel-body">
					<div class="form-group">
						<form id="inputForm">
						  <div class="form-group">
							<label for="item_name">Item name</label>
							<input type="text" class="form-control" name="item_name" id="item_name" placeholder="item name">
						  </div>
						  
						  <div class="form-group">
							<label for="item_id">Item id</label>
							<input type="text" class="form-control" name="item_id" id="item_id" placeholder="item icon">
						  </div>
						  
						  <div class="form-group">
							<label for="item_icon">Item icon</label>
							<input type="text" class="form-control" name="item_icon" id="item_icon" placeholder="item icon">
						  </div>
						  
						  <div class="form-group">
							<label for="item_price">Item price</label>
							<input type="number" class="form-control" name="item_price" id="item_price" placeholder="item price">
						  </div>
						  <input id="inputBtn" type="submit" class="btn btn-primary" value="Input"></input>
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
$("#inputForm").on('submit',(function(e) {
	e.preventDefault();
	
	if($("#item_name").val() != "" && $("#item_id").val() != ""  && $("#item_icon").val() != "" && $("#item_price").val() != ""){
		$.ajax({
			url: "input_items.php?u=@_vynghia1308",
			type: "POST",
			data:  new FormData(this),
			dataType:  'json',
			contentType: false,
			cache: false,
			processData:false,
			beforeSend: function () {
				$("#status").hide()
				$('#inputBtn').val('Processing...').prop('disabled', true)
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
				$('#inputBtn').val('Input').prop('disabled', false)
			}
	   });
	} else {
		$("#status").show()
		$("#pre_text").css("color", "red")
		$("#status_text").html("Some is empty input!")
	}
}));
</script>
</body>
</html>