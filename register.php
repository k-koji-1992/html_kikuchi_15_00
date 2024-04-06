<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>ユーザー登録</title>
</head>
<body>
    <h1>ユーザー登録</h1>
    <form action="register_process.php" method="post">
        <input type="text" name="username" placeholder="ユーザー名" required>
        <input type="password" name="password" placeholder="パスワード" required>
        <button type="submit">登録</button>
    </form>
</body>
</html>