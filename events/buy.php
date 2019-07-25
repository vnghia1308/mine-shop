<?php
require_once('../Rcon.php');
require_once('../config.php');
$host = $server_ip;
$port = 25575; //default
$password = $RconPassword; // rcon.password setting set in server.properties
$timeout = 3; // How long to timeout.

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

require '../query_mine@1.14.3/MinecraftQuery.php';
require '../query_mine@1.14.3/MinecraftQueryException.php';

$Timer = MicroTime(true);

$Query = new MinecraftQuery();

$buyStatus = array("success" => false, "message" => "unkown error");

date_default_timezone_set('Asia/Ho_Chi_Minh');

try
{
	$Query->Connect( MQ_SERVER_ADDR, MQ_SERVER_PORT, MQ_TIMEOUT );
	if(isset($_SESSION["user"])){
		$session_test = mysqli_query($db, "select * from ls_players where last_name='{$_SESSION["user"]}'");
		if(mysqli_num_rows($session_test) > 0){
			if(!empty($_POST["item_count"]) && isset($_SESSION["current_id_item"]) && $_SESSION["current_id_item"] != null){
				if($_POST["item_count"] > 0 && $_POST["item_count"] <= 64){
					if ($rcon->connect())
					{
						if($Query->GetPlayers( )){
							if (in_array($_SESSION["user"], $Query->GetPlayers( ))) {
								$user_query = mysqli_query($db, "select * from users_data where player_name='{$_SESSION["user"]}'");						
								$user = mysqli_fetch_array($user_query);
								
								$item_query = mysqli_query($db, "select * from shop_items where id='{$_SESSION["current_id_item"]}'");
								$item = mysqli_fetch_array($item_query);
								
								$price = $item["item_price"] * $_POST["item_count"];
								
								if($price > $user["bdcoins"]){
									$buyStatus = array("success" => false, "message" => "You do not have enough money to pay");
								} else {
									if(((int)$user["bdcoins"] - (int)$price) >= 0){
										$new_coins = $user["bdcoins"] - $price;
										$uCoins = mysqli_query($db, "update users_data set bdcoins = '$new_coins' where id='{$user["id"]}'"); 
										
										if(!$uCoins){
											$buyStatus = array("success" => false, "message" => "Can't execute transactions (payment.error.transactions-2)");
										} else {
											$rcon->sendCommand("give {$user["player_name"]} {$item["item_id"]} {$_POST["item_count"]}");

											$dateTime = date("Y-m-d H:i:s");
											mysqli_query($db, "INSERT INTO transaction_history(id, user_id, user_name, item_id, item_count, total_price, method, date_time) VALUES (NULL, '{$user["id"]}', '{$user["player_name"]}','{$item["item_id"]}', '{$_POST["item_count"]}', '$price', '+', '$dateTime')");
											$buyStatus = array("success" => true, "message" => "Successful payment, items will be deposited into your account", "new_coins" => $new_coins);
										}
										
									} else {
										$buyStatus = array("success" => false, "message" => "Can't execute transactions (payment.error.transactions-1)");
									}
								}
							} else {
								$buyStatus = array("success" => false, "message" => "Account doesn't exist or no online.");
							}
						} else {
							$buyStatus = array("success" => false, "message" => "No one is online in server.");
						}
					} else {
						$buyStatus = array("success" => false, "message" => "Server isn't response");
					}
				} else {
					$buyStatus = array("success" => false, "message" => "Item counts must be 1 - 64 number(s)");
				}
			} else {
				$buyStatus = array("success" => false, "message" => "Invaild data");
			}
		} else {
			$buyStatus = array("success" => false, "message" => "Invaild session");
		}
	} else {
		$buyStatus = array("success" => false, "message" => "Require session");
	}
}
catch (MinecraftQueryException $e)
{
	die(json_encode(array("success" => false, "message" => "Loi may chu")));
}

echo(json_encode($buyStatus));
