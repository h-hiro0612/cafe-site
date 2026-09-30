<?php include __DIR__ . '/includes/header.php'; ?>
<?php include __DIR__ . '/includes/function.php'; ?>
<?php
// PHPMailerの読み込み（autoload.phpのパスはプロジェクト構造に合わせて調整してください）
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

    // 環境変数 APP_ENV による自動分岐
    if (getenv('APP_ENV') === 'production') {
        // 【本番環境：Render】Gmail経由で送信
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = getenv('SMTP_USER'); // Renderで設定したGmailアドレス
        $mail->Password   = getenv('SMTP_PASS'); // Googleのアプリパスワード
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;
    } else {
        // 【ローカル環境：Docker】Mailpitへ送信
        $mail->Host       = 'mailpit';
        $mail->Port       = 1025;
        $mail->SMTPAuth   = false;
    }
    return $mail;
}

try {
    $admin_email = getenv('SMTP_USER') ?: 'admin@example.com';

    // 1. 管理者宛てメールの送信
    $adminMail = createMailer();
    $adminMail->setFrom($admin_email, $site_name);
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
        $userMail->setFrom($admin_email, $site_name);
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
    // 開発時の確認用ログ（本番ではエラーログ出力など）
    error_log("Mail Error: " . $e->getMessage());
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