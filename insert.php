<?php
include("funcs.php");
$pdo = db_conn();

$uname = $_POST["uname"];
$text = $_POST["text"];
$userId = $_POST["userId"];
$address1 = $_POST["address1"];
$address2 = $_POST["address2"];
$latitude = $_POST["latitude"];
$longitude = $_POST["longitude"];

$sql = "INSERT INTO pins (latitude, longitude, address, content) VALUES (?, ?, ?, ?)";
$stmt = $pdo->prepare($sql);
$stmt->execute([$latitude, $longitude, $address2, $text]);
?>