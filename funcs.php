
<?php
function db_conn(){
    try {
        //localhostの場合
        $db_name = "gs_db00";    //データベース名
        $db_id   = "root";      //アカウント名
        $db_pw   = "";          //パスワード：XAMPPはパスワード無しに修正してください。
        $db_host = "localhost"; //DBホスト

        //localhost以外＊＊自分で書き直してください！！＊＊
        if ($_SERVER["HTTP_HOST"] != 'localhost') {
            $db_name = "k-koji_unit1";  //データベース名
            $db_id   = "k-koji";  //アカウント名（さくらコントロールパネルに表示されています）
            $db_pw   = "53r4ijgAXtnVUhY_";  //パスワード(さくらサーバー最初にDB作成する際に設定したパスワード)
            $db_host = "mysql57.k-koji.sakura.ne.jp"; //例）mysql**db.ne.jp...
        }
        return new PDO('mysql:dbname=' . $db_name . ';charset=utf8;host=' . $db_host, $db_id, $db_pw);
    } catch (PDOException $e) {
        exit('DB Connection Error:' . $e->getMessage());
    }
}

function sql_error($stmt){
    $error = $stmt->errorInfo();
    exit("SQLError:" . print_r($error, true));
}

function redirect($file_name){
    header("Location: " . $file_name);
    exit();
}
?>