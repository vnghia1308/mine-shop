<?php
require_once("../config.php"); // @return $user_data

if(!isset($_SESSION["user"])){
	header("location: login.php");exit;
}

if($user_data["admin"] != 1){
	echo "access denied";
	exit;
}


require_once('../Rcon.php');
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

$userInventory = array();


$adminStatus = array("success" => false, "message" => "unkown error");
try {
	$Query->Connect( MQ_SERVER_ADDR, MQ_SERVER_PORT, MQ_TIMEOUT );
	if ($rcon->connect())
	{
		if($_GET["do"] == "ban_user"){
			$banlist = $rcon->sendCommand("ban {$_POST["user_name"]}");

			$adminStatus = array("success" => true, "message" => "Account's was banned");
		}
		//$banlist = $rcon->sendCommand("banlist");
		//echo $userInventory[0];
	}
} catch (MinecraftQueryException $e) {
	die("May chu khong phan hoi");
}

echo json_encode($adminStatus);