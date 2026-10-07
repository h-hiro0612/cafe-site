<?php
session_start();
require_once __DIR__ . '/../dbconnect.php';
require_once __DIR__ . '/../includes/function.php';

if (!isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header('Location: login.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>管理者メニュー画面 - 喫茶 雲和</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="menuindex-container container">
        <div class="admin-header">
            <h2>メニュー管理</h2>
            <div>
                <span>ようこそ、<?= h($_SESSION['admin_username']); ?> さん</span>
                <a href="logout.php" class="btn-logout">ログアウト</a>
            </div>
        </div>

        <div class="menu-items">
            
        </div>

        <div class="menu-forms">
            <form action="" method="post" enctype="multipart/form-data">
                <div class="menu-form">
                    <label for="category">カテゴリー<span class="required">必須</span></label>
                    <select id="category">
                        <option>選択してください</option>
                        <option value="drink">飲み物</option>
                        <option value="foods">お食事</option>
                    </select>
                </div>
                <div class="menu-form">
                    <label for="title">商品名<span class="required">必須</span></label>
                    <input type="text" id="title" name="title" />
                </div>
                <div class="menu-form price-form">
                    <label for="price">価格（税込）<span class="required">必須</span></label>
                    <input type="number" id="price" name="price" />
                </div>
                <div class="menu-form">
                    <label for="item-pic">商品画像</label>
                    <input id="item-pic" type="file" name="image-path" size="35" />
                </div>

                <div class="form-btn">
                    <input type="submit" value="追加">
                </div>
            </form>
        </div>
    </div>
</body>
</html>