<?php
session_start();
$db = mysqli_connect("localhost","root","") or die("can't connect this database");
mysqli_select_db($db, "minecraft");
mysqli_set_charset($db, 'utf8');

$server_ip 		= '127.0.0.1'; //default, no need change
$RconPassword 	= 'XXXXXXXXX'; // rcon.password setting set in server.properties

if(isset($_SESSION["user"])){
	$user_query = mysqli_query($db, "select * from ls_players where last_name='{$_SESSION["user"]}'");

	if(mysqli_num_rows($user_query) > 0){
		$user = mysqli_fetch_array($user_query);

		$user_data_query = mysqli_query($db, "select * from users_data where player_name='{$user["last_name"]}'");

		if(mysqli_num_rows($user_data_query) > 0){
			$user_data = mysqli_fetch_array($user_data_query);
		} else {
			$default_bdcoins = 5000;
			$default_loot_box = 10;
			mysqli_query($db, "INSERT INTO users_data(id, player_name, bdcoins, loot_box, admin) VALUES (NULL, '{$user["last_name"]}', '$default_bdcoins', '$default_loot_box', 0)");

			$user_data_query = mysqli_query($db, "select * from users_data where player_name='{$user["last_name"]}'");
			$user_data = mysqli_fetch_array($user_data_query);
		}
	} else {
		session_destroy();header("location: login.php");exit;
	}
}