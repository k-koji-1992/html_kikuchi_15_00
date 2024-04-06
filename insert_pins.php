
<?php
// 1. POSTデータ取得
$uname = $_POST["uname"];
$text = $_POST["text"];
$userId = $_POST["userId"];
$address1 = $_POST["address1"];
$address2 = $_POST["address2"];
$latitude = $_POST["latitude"];
$longitude = $_POST["longitude"];

include("funcs.php");
$pdo = db_conn();

//2．データ登録SQL作成
$sql = "INSERT INTO `gs_bm_table`(uname, address1, address2, comment, latitude, longitude, indate) VALUES (:uname, :address1, :address2, :comment, :latitude, :longitude, sysdate())";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':uname', $uname, PDO::PARAM_STR);
$stmt->bindValue(':address1', $address1, PDO::PARAM_STR);
$stmt->bindValue(':address2', $address2, PDO::PARAM_STR);
$stmt->bindValue(':comment', $comment, PDO::PARAM_STR);
$stmt->bindValue(':latitude', $latitude, PDO::PARAM_STR);
$stmt->bindValue(':longitude', $longitude, PDO::PARAM_STR);
$status = $stmt->execute();

//3．データ登録処理後
if ($status == false) {
  sql_error($stmt);
} else {
  echo "success";
}
