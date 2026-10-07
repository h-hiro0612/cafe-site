<?php
session_start();
require_once __DIR__ . '/../dbconnect.php';
require_once __DIR__ . '/../includes/function.php';

// 既にログイン済みの場合は管理画面へリダイレクト
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header('Location: index.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if ($username !== '' && $password !== '') {
        if ($pdo) {
            $stmt = $pdo->prepare("SELECT * FROM admins WHERE username = :username");
            $stmt->bindValue(':username', $username, PDO::PARAM_STR);
            $stmt->execute();
            $admin = $stmt->fetch();

            // ユーザーが存在し、パスワードが一致するか検証
            if ($admin && password_verify($password, $admin['password'])) {
                session_regenerate_id(true); // セッション固定攻撃対策
                $_SESSION['admin_logged_in'] = true;
                $_SESSION['admin_username']  = $admin['username'];
                
                header('Location: index.php');
                exit;
            } else {
                $error = 'ユーザー名またはパスワードが正しくありません。';
            }
        } else {
            $error = 'データベース接続エラーが発生しました。';
        }
    } else {
        $error = 'ユーザー名とパスワードを入力してください。';
    }
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>管理者ログイン - 喫茶 雲和</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="login-container">
        <h2>管理者ログイン</h2>
        <?php if ($error): ?><p class="err"><?= h($error); ?></p><?php endif; ?>
        <form action="" method="POST" class="login-form">
            <div>
                <label>ユーザー名</label>
                <input type="text" name="username" required>
            </div>
            <div>
                <label>パスワード</label>
                <input type="password" name="password" required>
            </div>
            <button type="submit" class="btn-login">ログイン</button>
        </form>
    </div>
</body>
</html>