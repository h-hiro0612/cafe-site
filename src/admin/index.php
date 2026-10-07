<?php
session_start();

// 未ログインの場合はログイン画面へ
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
    exit;
}

require_once __DIR__ . '/../dbconnect.php';
require_once __DIR__ . '/../includes/function.php';

// ダッシュボード用の件数取得
$menu_count = 0;
$news_count = 0;

if ($pdo) {
    $menu_count = $pdo->query("SELECT COUNT(*) FROM menus")->fetchColumn();
    // $news_count = $pdo->query("SELECT COUNT(*) FROM news")->fetchColumn();
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>管理者ダッシュボード - 喫茶 雲和</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="admin-container">
        <div class="admin-header">
            <h2>管理画面ダッシュボード</h2>
            <div>
                <span>ようこそ、<?= h($_SESSION['admin_username']); ?> さん</span>
                <a href="logout.php" class="btn-logout">ログアウト</a>
            </div>
        </div>

        <div class="admin-nav">
            <a href="./menu.php" class="card">
                <h3>メニュー管理</h3>
                <div class="count-badge">登録件数: <?= $menu_count; ?> 件</div>
                <p>ドリンクやお食事メニューの追加・削除を行います。</p>
            </a>

            <a href="news.php" class="card">
                <h3>新着情報管理</h3>
                <!-- <div class="count-badge">登録件数: <?= $news_count; ?> 件</div> -->
                <p>お知らせやイベント情報などの投稿・削除を行います。</p>
            </a>
        </div>
    </div>
</body>
</html>