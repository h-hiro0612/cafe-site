<?php
// 環境変数があれば優先し、無ければローカル（Docker）のデフォルト値を使用
$db_host = getenv('DB_HOST')     ?: ($_ENV['DB_HOST']     ?? 'db');
$db_name = getenv('DB_NAME')     ?: ($_ENV['DB_NAME']     ?? 'cafe_db');
$db_user = getenv('DB_USER')     ?: ($_ENV['DB_USER']     ?? 'cafe_kumonagi');
$db_pass = getenv('DB_PASSWORD') ?: ($_ENV['DB_PASSWORD'] ?? 'password');
$db_port = getenv('DB_PORT')     ?: ($_ENV['DB_PORT']     ?? '3306');

try {
    $dsn = "mysql:host={$db_host};port={$db_port};dbname={$db_name};charset=utf8mb4";
    $pdo = new PDO($dsn, $db_user, $db_pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_TIMEOUT => 2 // 接続タイムアウト（2秒）
    ]);
} catch (Throwable $e) {
    // 画面にエラーを出力（echo）せず、サーバーのログにのみ記録
    error_log("DB接続失敗: " . $e->getMessage());
    $pdo = null; // $pdo を null にして以降の処理を安全に継続
}
?>