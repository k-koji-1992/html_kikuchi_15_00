<?php
//1. POSTデータ取得
$name = $_POST['name'];
$lid = $_POST['lid'];
$lpw= $_POST['lpw'];


include("funcs.php");
$pdo = db_conn();



//2．データ登録SQL作成
$sql = "INSERT INTO `gs_user_table`(name, lid, lpw) VALUES (:name,:lid,:lpw)";
$stmt = $pdo->prepare($sql); // statement
$stmt->bindValue(':name', $name, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':lid', $lid, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':lpw', $lpw, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$status = $stmt->execute();

//3．データ登録処理後
if($status==false){
  //*** function化を使う！*****************
  sql_error($stmt);
}else{
  //*** function化を使う！*****************
  redirect("login.php");
}
?>