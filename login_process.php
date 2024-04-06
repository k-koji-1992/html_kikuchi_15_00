
<?php
session_start();
include("funcs.php");
$pdo = db_conn();

$username = $_POST['username'];
$password = $_POST['password'];

$sql = "SELECT * FROM users WHERE username = :username";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':username', $username, PDO::PARAM_STR);
$status = $stmt->execute();

if($status==false){
    sql_error($stmt);
}else{
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if($row && password_verify($password, $row['password'])){
        $_SESSION['user_id'] = $row['id'];
        $_SESSION['username'] = $row['username'];
        redirect("index.php");
    }else{
        redirect("login.php");
    }
}
?>