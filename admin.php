<!-- Theme: Bootstrap / Code by Vy Nghia / Libary is public source -->
<?php
require_once("config.php"); // @return $user_data

if(!isset($_SESSION["user"])){
	header("location: login.php");exit;
}

if($user_data["admin"] != 1){
	echo "access denied";
	exit;
}


require_once('Rcon.php');
$host = '127.0.0.1'; // Server host name or IP
$port = 25575;                      // Port rcon is listening on
$password = '@nghiaiuthien'; // rcon.password setting set in server.properties
$timeout = 3;                       // How long to timeout.

use Thedudeguy\Rcon;

$rcon = new Rcon($host, $port, $password, $timeout);

use xPaw\MinecraftQuery;
use xPaw\MinecraftQueryException;

// Edit this ->
define( 'MQ_SERVER_ADDR', 'localhost' );
define( 'MQ_SERVER_PORT', 25565 );
define( 'MQ_TIMEOUT', 1 );
// Edit this <-

// Display everything in browser, because some people can't look in logs for errors
Error_Reporting( E_ALL | E_STRICT );
Ini_Set( 'display_errors', true );

require 'query_mine@1.14.3/MinecraftQuery.php';
require 'query_mine@1.14.3/MinecraftQueryException.php';

$Timer = MicroTime(true);

$Query = new MinecraftQuery();

$userInventory = array();
try {
	$Query->Connect( MQ_SERVER_ADDR, MQ_SERVER_PORT, MQ_TIMEOUT );
	if ($rcon->connect())
	{
		$banlist = $rcon->sendCommand("banlist");
		var_dump(stripos("Long2", $banlist));
		
		//echo $userInventory[0];
	}
} catch (MinecraftQueryException $e) {
	die("May chu khong phan hoi");
}

$users_query = mysqli_query($db, "SELECT * FROM ls_players WHERE 1");
?>
<html>
<head>
	<meta charset="utf-8" />
	<title>MineBede - Admin</title>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="css/mine.css">
	<link rel="stylesheet" href="css/home.css">
</head>
<body>
<div class="container" id="main">
	<div class="container"></div>
	<div class="row">
		<div class="col-xs-12">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<h3 class="panel-title">Shop <?= (isset($_GET["id"])) ? '-- <a href="trade.php">[Back]</a>' : ""; ?> -- <a href="shop.php">[Shop]</a> -- <a href="logout.php">[Logout]</a></h3>
				</div>
				<div class="panel-body">
					<table class="table">
					    <thead>
					      <tr>
					        <th>player_name</th>
					        <th>bdcoins</th>
					        <th>actions</th>
					      </tr>
					    </thead>
					    <tbody>
					    <?php while($user = mysqli_fetch_array($users_query)): 
					    $user_data_query = mysqli_query($db, "SELECT * FROM users_data WHERE player_name='{$user["last_name"]}'");
					    $user_data = mysqli_fetch_array($user_data_query);

					    if(strpos($user["last_name"] . " was", $rcon->sendCommand("banlist")) !== FALSE){
					    	echo "banned";
					    } else {
					    	echo "no banned";
					    }
					    ?>
					      <tr>
					        <td><?= $user["last_name"] ?></td>
					        <td><?= ($user_data["bdcoins"] != null) ? $user_data["bdcoins"] : 0; ?></td>
					        <td><a style="cursor:pointer;" onclick="ban_user('<?= $user["last_name"] ?>')">[Ban user]</a> <a style="cursor:pointer;" onclick="unban_user('<?= $user["last_name"] ?>')">[Unban user]</a></td>
					      </tr>
					    <?php endwhile; ?>
					    </tbody>
					  </table>

					  <hr />
					    <form id="creativeForm">
					    Change user gamode
					    <div class="radio">
							  <label><input type="radio" name="optradio" checked>Creative</label>
							</div>
							<div class="radio">
							  <label><input type="radio" name="optradio">Survival</label>
							</div>
							<div class="form-group">
								<label for="item_name">player_name</label>
								<input type="text" class="form-control" name="user_name" id="user_name" placeholder="user_name" value="">
							</div>
						  <input id="changeBtn" type="submit" class="btn btn-primary" value="Change"></input>
						  <pre style="display:none;color:red;" id="status"><div id="status_text"></div></pre>
						</form>
					<div style="display:none;" id="status"><br /><pre id="pre_text"><div id="status_text"></div></pre></div>
				</div>
				<div class="panel-footer"> &copy; 2018 <strong><a href="https://www.facebook.com/nghiadev" target="_blank">Vy Nghia</a></strong></div>
			</div>
		</div>
	</div>
</div>
<script src="js/jquery-2.1.1.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script>
const default_reason = "Banned by an operator.";

function ban_user(user_name){
	if(user_name != ""){
		$.ajax({
			url: "events/admin_action.php?do=ban_user",
			type: "POST",
			data: {
				user_name: user_name
			},
			dataType:  'json',
			beforeSend: function () {
				$("#status").hide()
				$('#buyBtn').val('Processing...').prop('disabled', true)
			},
			success: function(r) {
				if(r.success){
					//$("#bdcoins").text(r.new_coins)

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
				//$('#buyBtn').val('Buy').prop('disabled', false)
			}
	   });
	}
}

function unban_user(user_name){
	if(user_name != ""){
		$.ajax({
			url: "events/admin_action.php?do=unban_user",
			type: "POST",
			data: {
				user_name: user_name
			},
			dataType:  'json',
			beforeSend: function () {
				$("#status").hide()
				//$('#buyBtn').val('Processing...').prop('disabled', true)
			},
			success: function(r) {
				if(r.success){
					//$("#bdcoins").text(r.new_coins)

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
				//$('#buyBtn').val('Buy').prop('disabled', false)
			}
	   });
	}
}

$("#creativeForm").on('submit',(function(e) {
	e.preventDefault();
	
	$.ajax({
		url: "events/admin_action.php?do=gamemode_user",
		type: "POST",
		data:  new FormData(this),
		dataType:  'json',
		contentType: false,
		cache: false,
		processData:false,
		beforeSend: function () {
			$("#status").hide()
			$('#changeBtn').val('Processing...').prop('disabled', true)
		},
		success: function(r) {
			if(r.success){
				$("#bdcoins").text(r.new_coins)

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
			$('#changeBtn').val('Change').prop('disabled', false)
		}
   });
}));
</script>
</body>
</html>