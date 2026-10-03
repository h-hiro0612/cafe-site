<?php include __DIR__ . '/includes/header.php'; ?>
<?php include __DIR__ . '/includes/function.php'; ?>
<?php
// PHPMailerの読み込み
require_once __DIR__ . '/vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$name    = isset($_POST['name']) ? $_POST['name'] : '';
$email   = isset($_POST['email']) ? $_POST['email'] : '';
$message = isset($_POST['message']) ? $_POST['message'] : '';

$site_name = "喫茶 雲和";

// --- メールの設定関数 ---
function createMailer() {
    $mail = new PHPMailer(true);
    $mail->isSMTP();
    $mail->CharSet = 'UTF-8';
    $mail->Timeout = 20; // タイムアウトを20秒に延長

    // APP_ENV の取得（getenv / $_ENV / $_SERVER から順に確認）
    $app_env = getenv('APP_ENV') ?: ($_ENV['APP_ENV'] ?? ($_SERVER['APP_ENV'] ?? 'local'));

    // 環境変数 APP_ENV による自動分岐
    if ($app_env === 'production') {
        // 【本番環境：Render】
        $host     = getenv('MAIL_HOST')     ?: ($_ENV['MAIL_HOST']     ?? ($_SERVER['MAIL_HOST']     ?? 'smtp.resend.com'));
        $username = getenv('MAIL_USERNAME') ?: ($_ENV['MAIL_USERNAME'] ?? ($_SERVER['MAIL_USERNAME'] ?? 'resend'));
        $port     = getenv('MAIL_PORT')     ?: ($_ENV['MAIL_PORT']     ?? ($_SERVER['MAIL_PORT']     ?? 587));

        // APIキー（パスワード）の取得
        $password = getenv('RESEND_API_KEY') ?: ($_ENV['RESEND_API_KEY'] ?? ($_SERVER['RESEND_API_KEY'] ?? ''));
        if (empty($password)) {
            $password = getenv('MAIL_PASSWORD') ?: ($_ENV['MAIL_PASSWORD'] ?? ($_SERVER['MAIL_PASSWORD'] ?? ''));
        }

        if (empty($password)) {
            throw new Exception("Renderの環境変数（RESEND_API_KEY または MAIL_PASSWORD）が読み込めていません。");
        }

        $mail->Host       = $host;
        $mail->SMTPAuth   = true;
        $mail->Username   = $username;
        $mail->Password   = $password;

        // STARTTLS と ポート587 を明示的に指定
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = (int)$port;

        // クラウド環境での SSL/TLS 接続時の検証エラーによる接続失敗を防止
        $mail->SMTPOptions = [
            'ssl' => [
                'verify_peer'       => false,
                'verify_peer_name'  => false,
                'allow_self_signed' => true,
            ],
        ];
    } else {
        // 【ローカル環境 or APP_ENVが取得できていない場合】
        throw new Exception("APP_ENVが判定できませんでした。（現在の判定値: '{$app_env}'）");
    }
    return $mail;
}

try {
    // APP_ENV の再判定
    $app_env = getenv('APP_ENV') ?: ($_ENV['APP_ENV'] ?? ($_SERVER['APP_ENV'] ?? 'local'));

    // 送信元メールアドレスの取得
    $from_email  = ($app_env === 'production') 
                    ? (getenv('MAIL_FROM_ADDRESS') ?: ($_ENV['MAIL_FROM_ADDRESS'] ?? ($_SERVER['MAIL_FROM_ADDRESS'] ?? 'onboarding@resend.dev'))) 
                    : 'admin@example.com';

    // 管理者通知用アドレスの取得
    $admin_email = getenv('ADMIN_EMAIL') ?: ($_ENV['ADMIN_EMAIL'] ?? ($_SERVER['ADMIN_EMAIL'] ?? ''));
    if (empty($admin_email)) {
        $admin_email = getenv('SMTP_USER') ?: ($_ENV['SMTP_USER'] ?? ($_SERVER['SMTP_USER'] ?? 'admin@example.com'));
    }

    // 1. 管理者宛てメールの送信
    $adminMail = createMailer();
    $adminMail->setFrom($from_email, $site_name);
    $adminMail->addAddress($admin_email); // 管理者（自分）へ届く
    if (!empty($email)) {
        $adminMail->addReplyTo($email, $name); // フォーム送信者への返信設定
    }

    $adminMail->Subject = "【{$site_name}】お問い合わせが届きました";
    $admin_body  = "Webサイトから新しいお問い合わせが届きました。\n\n";
    $admin_body .= "--------------------------------------------------\n";
    $admin_body .= "■お名前：\n" . $name . "\n\n";
    $admin_body .= "■メールアドレス：\n" . $email . "\n\n";
    $admin_body .= "■お問い合わせ内容：\n" . $message . "\n";
    $admin_body .= "--------------------------------------------------\n";
    $adminMail->Body = $admin_body;

    $adminMail->send();

    // 2. お客様宛て自動返信メールの送信（メアドが入力されている場合のみ）
    if (!empty($email)) {
        $userMail = createMailer();
        $userMail->setFrom($from_email, $site_name);
        $userMail->addAddress($email, $name); // お客様へ届く

        $userMail->Subject = "【{$site_name}】お問い合わせを受け付けました（自動送信）";
        $user_body  = $name . " 様\n\n";
        $user_body .= "この度はお問い合わせいただき、誠にありがとうございます。\n";
        $user_body .= "以下の内容でお問い合わせを受け付けいたしました。\n\n";
        $user_body .= "--------------------------------------------------\n";
        $user_body .= "■お名前：\n" . $name . "\n\n";
        $user_body .= "■メールアドレス：\n" . $email . "\n\n";
        $user_body .= "■お問い合わせ内容：\n" . $message . "\n";
        $user_body .= "--------------------------------------------------\n\n";
        $user_body .= "※本メールは送信専用です。\n喫茶 雲和\n";
        $userMail->Body = $user_body;

        $userMail->send();
    }

} catch (Exception $e) {
    // 送信エラー時の赤枠表示
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