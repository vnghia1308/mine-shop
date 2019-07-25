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
define( 'MQ_SERVER_ADDR', $server_ip);
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

$sellStatus = array("success" => false, "message" => "unkown error");

date_default_timezone_set('Asia/Ho_Chi_Minh');

try
{
	$Query->Connect( MQ_SERVER_ADDR, MQ_SERVER_PORT, MQ_TIMEOUT );
	if(isset($_SESSION["user"])){
		$session_test = mysqli_query($db, "select * from ls_players where last_name='{$_SESSION["user"]}'");
		if(mysqli_num_rows($session_test) > 0){
			if(!empty($_POST["item_count"]) && !empty($_GET["item_id"]) && $_GET["item_id"] != "null"){
				if($_POST["item_count"] > 0 && $_POST["item_count"] <= 64){
					if ($rcon->connect())
					{
						if($Query->GetPlayers( )){
							$item_count = $_POST["item_count"]; $item_id = $_GET["item_id"];
							if (in_array($_SESSION["user"], $Query->GetPlayers( ))) {
								$user_query = mysqli_query($db, "SELECT * FROM users_data WHERE player_name='{$_SESSION["user"]}'");						
								$user = mysqli_fetch_array($user_query);
								
								$item_query = mysqli_query($db, "SELECT * FROM shop_items WHERE item_id='{$item_id}'");
								$item = mysqli_fetch_array($item_query);
								
								$price = ($item["item_price"] - (($item["item_price"] * 30) / 100)) * $item_count;

								$userIventory = explode('"', $rcon->sendCommand("data get entity {$user["player_name"]} Inventory"));
								if(in_array($item["item_id"], $userIventory)){
									$rItem = explode(" ", $rcon->sendCommand("clear {$user["player_name"]} {$item["item_id"]} {$item_count}"));

									if((int)$rItem[1] >= (int)$item_count) {
										$new_coins = $user["bdcoins"] += (int)$price;
										$updateCoins = mysqli_query($db, "UPDATE users_data SET bdcoins = '{$new_coins}' WHERE player_name='{$user["player_name"]}'");

										if($updateCoins){
											$sellStatus = array("success" => true, "message" => "Successful transaction.", "new_coins" => $new_coins);

											$dateTime = date("Y-m-d H:i:s");
											mysqli_query($db, "INSERT INTO transaction_history(id, user_id, user_name, item_id, item_count, total_price, method, date_time) VALUES (NULL, '{$user["id"]}', '{$user["player_name"]}','{$item["item_id"]}', '{$_POST["item_count"]}', '$price', '-', '$dateTime')");
										} else {
											$sellStatus = array("success" => false, "message" => "Unable to trade, we will return  your item to you within a few minutes.");
											$rcon->sendCommand("give {$user["player_name"]} {$item["item_id"]} {$rItem[1]}");
										}
										
									} else {
										$sellStatus = array("success" => false, "message" => "Unable to trade, we will return  your item to you within a few minutes.");
										$rcon->sendCommand("give {$user["player_name"]} {$item["item_id"]} {$rItem[1]}");
									}
								} else {
									$sellStatus = array("success" => false, "message" => "Item doesn't exist in your inventory.");
								}
								
								/*
								if($price > $user["bdcoins"]){
									$sellStatus = array("success" => false, "message" => "You do not have enough money to pay");
								} else {
									if(((int)$user["bdcoins"] - (int)$price) >= 0){
										$new_coins = $user["bdcoins"] - $price;
										$uCoins = mysqli_query($db, "update users_data set bdcoins = '$new_coins' where id='{$user["id"]}'"); 
										
										if(!$uCoins){
											$sellStatus = array("success" => false, "message" => "Can't execute transactions (payment.error.transactions-2)");
										} else {
											$rcon->sendCommand("give {$user["player_name"]} {$item["item_id"]} {$_POST["item_count"]}");
											mysqli_query($db, "INSERT INTO transaction_history(id, user_id, user_name, item_id, item_count, total+price) VALUES (NULL, '{$user["id"]}', '{$user["player_name"]}','{$item["item_id"]}', '{$_POST["item_count"]}', '$price')");
											$sellStatus = array("success" => true, "message" => "Successful payment, items will be deposited into your account", "new_coins" => $new_coins);
										}
										
									} else {
										$sellStatus = array("success" => false, "message" => "Can't execute transactions (payment.error.transactions-1)");
									}
								} */
							} else {
								$sellStatus = array("success" => false, "message" => "Account doesn't exist or no online.");
							}
						} else {
							$sellStatus = array("success" => false, "message" => "No one is online in server.");
						}
					} else {
						$sellStatus = array("success" => false, "message" => "Server isn't response");
					}
				} else {
					$sellStatus = array("success" => false, "message" => "Item counts must be 1 - 64 number(s)");
				}
			} else {
				$sellStatus = array("success" => false, "message" => "Invaild data");
			}
		} else {
			$sellStatus = array("success" => false, "message" => "Invaild session");
		}
	} else {
		$sellStatus = array("success" => false, "message" => "Require session");
	}
}
catch (MinecraftQueryException $e)
{
	die(json_encode(array("success" => false, "message" => "Loi may chu")));
}

echo(json_encode($sellStatus));
