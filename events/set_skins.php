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

$skinStatus = array("success" => false, "message" => "unkown error");

date_default_timezone_set('Asia/Ho_Chi_Minh');

try
{
	$Query->Connect( MQ_SERVER_ADDR, MQ_SERVER_PORT, MQ_TIMEOUT );
	if(isset($_SESSION["user"])){
		$session_test = mysqli_query($db, "select * from ls_players where last_name='{$_SESSION["user"]}'");
		if(mysqli_num_rows($session_test) > 0){
			if ($rcon->connect())
			{
				//Please install plugin: https://www.spigotmc.org/resources/skinsrestorer.2124/
				//get skin_name on https://namemc.com
				$rcon->sendCommand("skin set {$_SESSION["user"]} {$_POST["skin_name"]}");

				$skinStatus = array("success" => true, "message" => "Sent skin successfully");
			} else {
				$skinStatus = array("success" => false, "message" => "Can't connect api of game server");
			}
		} else {
			$skinStatus = array("success" => false, "message" => "Invaild session");
		}
	} else {
		$skinStatus = array("success" => false, "message" => "Require session");
	}
}
catch (MinecraftQueryException $e)
{
	die(json_encode(array("success" => false, "message" => "Loi may chu")));
}

echo(json_encode($skinStatus));
