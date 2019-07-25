<!-- Theme: Bootstrap / Code by Vy Nghia / Libary is public source -->
<?php
require_once('Rcon.php');
require_once("config.php"); // @return $user_data
$host = $server_ip;
$port = 25575; //default
$password = $RconPassword; // rcon.password setting set in server.properties
$timeout = 3; // How long to timeout.

use Thedudeguy\Rcon;

$rcon = new Rcon($host, $port, $password, $timeout);

use xPaw\MinecraftQuery;
use xPaw\MinecraftQueryException;

// Edit this ->
define( 'MQ_SERVER_ADDR', $server_ip);
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
		$rcon->sendCommand("data get entity {$_SESSION["user"]} Inventory");
		$GetUserInventory = $rcon->sendCommand("data get entity {$_SESSION["user"]} Inventory");
		$items = explode('"', $GetUserInventory);
		
		foreach($items as $item){
			if(strpos($item, "minecraft:") !== FALSE){
				array_push($userInventory, $item);
			}
		}
		//echo $userInventory[0];
	}
} catch (MinecraftQueryException $e) {
	die("May chu khong phan hoi");
}
?>
<html>
<head>
	<meta charset="utf-8" />
	<title>MineBede - Shop</title>
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
					<pre>Your BedeCoints: <span id="bdcoins"><?= $user_data["bdcoins"] ?></span></pre>
					<?php
					if ($Query->GetPlayers( ) != null && in_array($_SESSION["user"], $Query->GetPlayers( ))):
					if(!isset($_GET["id"])):
					$_SESSION["current_id_item"] = null;

					foreach($userInventory as $inven){
					$shop_query = mysqli_query($db, "select * from shop_items where item_id='$inven'");
					if(mysqli_num_rows($shop_query)){
					$items = mysqli_fetch_array($shop_query);
					$price = ($items["item_price"] - (($items["item_price"] * 30) / 100));
					?>
					<table id="rows" class="items">
					<tbody>
						<tr class="row">
						  <td class="id">$<?= $price ?></td>
						  <td class="row-icon"><div class="<?= $items["item_icon"] ?>"></div></td>
						  <td class="row-desc"><span class="name"><?= $items["item_name"] ?></span><br>
						  <a href="?id=<?= $items["item_id"] ?>"><span class="text-id">Sell</span></a></td>
						</tr>
					<?php }
					} ?>
					</tbody></table>
					<?php else:
					if(isset($_GET["id"])): 
					$_SESSION["current_id_item"] = $_GET["id"];
					
					$items_query = mysqli_query($db, "select * from shop_items where item_id='{$_GET["id"]}'");
					if(mysqli_num_rows($items_query) > 0){ 
					$items = mysqli_fetch_array($items_query);
					$price = ($items["item_price"] - (($items["item_price"] * 30) / 100));
					?>
					<table id="rows" class="items">
					<tbody>
						<tr class="row">
						  <td class="id">X</td>
						  <td class="row-icon"><div class="<?= $items["item_icon"] ?>"></div></td>
						  <td class="row-desc"><span class="name"><?= $items["item_name"] ?></span><br>
						  <span class="text-id">Sell Price: <?= $price ?></span></td>
						</tr>
					</tbody></table>
					<form id="sellForm">
						<div class="form-group">
							<label for="item_name">Number of count (limit 64)</label>
							<input type="number" class="form-control" name="item_count" id="item_count" placeholder="item count" value="1">
						</div>
						<div class="form-group">
							<label for="item_price">Price: $<span id="total_price"><?= $price ?></span></label>
							<input style="display:none;" type="number" class="form-control" name="item_price" id="item_price" value="<?= $price ?>">
						</div>
						<input id="buyBtn" type="submit" class="btn btn-primary" value="Sell"></input>
						<div style="display:none;" id="status"><br /><pre id="pre_text"><div id="status_text"></div></pre></div>
					</form>
					<?php } else {
						echo "Items doesn't exists";
					} 
					endif;endif;
					else:
						echo "Require login to game server";
					endif; ?>
				</div>
				<div class="panel-footer"> &copy; 2018 <strong><a href="https://www.facebook.com/nghiadev" target="_blank">Vy Nghia</a></strong></div>
			</div>
		</div>
	</div>
</div>
<script src="js/jquery-2.1.1.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script>
$('#item_count').keyup(function () {
	if($(this).val() != ""){
		$("#total_price").text(parseInt($("#item_price").val(), 10) * parseInt($("#item_count").val(), 10))
	} else {
		$("#total_price").text("0")
	}
});

$("#sellForm").on('submit',(function(e) {
	e.preventDefault();
	
	if($("#item_count").val() != ""){
		$.ajax({
			url: "events/sell.php?item_id=<?php if(isset($_GET["id"])) echo $_GET["id"]; else echo "null"; ?>",
			type: "POST",
			data:  new FormData(this),
			dataType:  'json',
			contentType: false,
			cache: false,
			processData:false,
			beforeSend: function () {
				$("#status").hide()
				$('#buyBtn').val('Processing...').prop('disabled', true)
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
				$('#buyBtn').val('Buy').prop('disabled', false)
			}
	   });
	} else {
		$("#status").show()
		$("#pre_text").css("color", "red")
		$("#status_text").html("Please enter item count!")
	}
}));
</script>
</body>
</html>