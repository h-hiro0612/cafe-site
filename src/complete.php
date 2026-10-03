<?php include __DIR__ . '/includes/header.php'; ?>
<?php include __DIR__ . '/includes/function.php'; ?>
<?php

$name    = isset($_POST['name']) ? $_POST['name'] : '';
$email   = isset($_POST['email']) ? $_POST['email'] : '';
$message = isset($_POST['message']) ? $_POST['message'] : '';

$site_name = "喫茶 雲和";

// --- Resend HTTP API でメールを送信する関数（SMTPを使わないためブロックされません）---
function sendResendEmail($api_key, $from, $to, $subject, $text_content, $reply_to = null) {
    $url = 'https://api.resend.com/emails';

    $data = [
        'from'    => $from,
        'to'      => [$to],
        'subject' => $subject,
        'text'    => $text_content,
    ];

    if ($reply_to) {
        $data['reply_to'] = $reply_to;
    }

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Authorization: Bearer ' . $api_key,
        'Content-Type: application/json',
    ]);

    $response = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $curl_error = curl_error($ch);
    curl_close($ch);

    if ($curl_error) {
        throw new Exception("cURL接続エラー: " . $curl_error);
    }

    if ($http_code < 200 || $http_code >= 300) {
        $res_data = json_decode($response, true);
        $err_msg = isset($res_data['message']) ? $res_data['message'] : $response;
        throw new Exception("Resend API エラー (HTTP {$http_code}): " . $err_msg);
    }

    return true;
}

try {
    // APP_ENV の判定
    $app_env = getenv('APP_ENV') ?: ($_ENV['APP_ENV'] ?? ($_SERVER['APP_ENV'] ?? 'local'));

    // Resend APIキーの取得
    $resend_api_key = getenv('RESEND_API_KEY') ?: ($_ENV['RESEND_API_KEY'] ?? ($_SERVER['RESEND_API_KEY'] ?? ''));
    if (empty($resend_api_key)) {
        $resend_api_key = getenv('MAIL_PASSWORD') ?: ($_ENV['MAIL_PASSWORD'] ?? ($_SERVER['MAIL_PASSWORD'] ?? ''));
    }

    if (empty($resend_api_key)) {
        throw new Exception("Renderの環境変数（RESEND_API_KEY または MAIL_PASSWORD）が読み込めていません。");
    }

    // 送信元メールアドレスの取得
    $from_email = getenv('MAIL_FROM_ADDRESS') ?: ($_ENV['MAIL_FROM_ADDRESS'] ?? ($_SERVER['MAIL_FROM_ADDRESS'] ?? 'onboarding@resend.dev'));
    $from_header = "{$site_name} <{$from_email}>";

    // 管理者通知用アドレスの取得
    $admin_email = getenv('ADMIN_EMAIL') ?: ($_ENV['ADMIN_EMAIL'] ?? ($_SERVER['ADMIN_EMAIL'] ?? ''));
    if (empty($admin_email)) {
        $admin_email = getenv('SMTP_USER') ?: ($_ENV['SMTP_USER'] ?? ($_SERVER['SMTP_USER'] ?? ''));
    }

    if (empty($admin_email)) {
        throw new Exception("管理者用メールアドレス（ADMIN_EMAIL または SMTP_USER）が設定されていません。");
    }

    // 1. 管理者宛てメールの送信
    $admin_subject = "【{$site_name}】お問い合わせが届きました";
    $admin_body  = "Webサイトから新しいお問い合わせが届きました。\n\n";
    $admin_body .= "--------------------------------------------------\n";
    $admin_body .= "■お名前：\n" . $name . "\n\n";
    $admin_body .= "■メールアドレス：\n" . $email . "\n\n";
    $admin_body .= "■お問い合わせ内容：\n" . $message . "\n";
    $admin_body .= "--------------------------------------------------\n";

    sendResendEmail($resend_api_key, $from_header, $admin_email, $admin_subject, $admin_body, $email);

    // 2. お客様宛て自動返信メールの送信（メアド入力時のみ）
    if (!empty($email)) {
        $user_subject = "【{$site_name}】お問い合わせを受け付けました（自動送信）";
        $user_body  = $name . " 様\n\n";
        $user_body .= "この度はお問い合わせいただき、誠にありがとうございます。\n";
        $user_body .= "以下の内容でお問い合わせを受け付けいたしました。\n\n";
        $user_body .= "--------------------------------------------------\n";
        $user_body .= "■お名前：\n" . $name . "\n\n";
        $user_body .= "■メールアドレス：\n" . $email . "\n\n";
        $user_body .= "■お問い合わせ内容：\n" . $message . "\n";
        $user_body .= "--------------------------------------------------\n\n";
        $user_body .= "※本メールは送信専用です。\n喫茶 雲和\n";

        sendResendEmail($resend_api_key, $from_header, $email, $user_subject, $user_body);
    }

} catch (Exception $e) {
    echo "<div style='color:red; background:#fee; padding:15px; margin:20px; border:1px solid red;'>";
    echo "<h3>メール送信エラーが発生しました</h3>";
    echo "<p>エラー詳細: " . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8') . "</p>";
    echo "</div>";
    exit;
}
?>
  <section class="contact-form">
    <div class="contact-form-container container">
      <h1>お問い合わせ-完了-</h1>
      <div class="contact-complete">
        <p>
            お問い合わせいただきありがとうございます<br>
            確認のために、お客様に自動送信メールをお送りしております。
        </p>
      </div>
      <div class="back_btn">
        <a href="./index.php">ホームへ</a>
      </div>
    </div>
  </section>
</main>

<?php include __DIR__ . '/includes/footer.php'; ?>