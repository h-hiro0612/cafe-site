<?php include __DIR__ . '/includes/header.php'; ?>
<?php include __DIR__ . '/includes/function.php'; ?>
<main>
  <section class="contact-form">
    <div class="contact-form-container container">
      <h1>お問い合わせ-確認-</h1>
      <form action="./contact_process.php" method="post" class="form">
        
        <input type="hidden" name="name" value="<?php echo h($_POST['name']); ?>">
        <input type="hidden" name="email" value="<?php echo h($_POST['email']); ?>">
        <input type="hidden" name="message" value="<?php echo h($_POST['message']); ?>">

        <div class="confirm-group">
          <dt>お名前<span class="required">必須</span></dt>
          <dd><?php echo h($_POST['name']); ?></dd>
        </div>

        <div class="confirm-group">
          <dt>メールアドレス<span class="required">必須</span></dt>
          <dd><?php echo h($_POST['email']); ?></dd>
        </div>

        <div class="confirm-group">
          <dt>お問い合わせ内容<span class="required">必須</span></dt>
          <!-- 改行文字を <br> に変換して表示 -->
          <dd><?php echo nl2br(h($_POST['message'])); ?></dd>
        </div>

        <div class="form-btn">
          <!-- 修正用に戻るボタンを置くのが一般的です -->
          <button type="button" onclick="history.back()">修正する</button>
          <input type="submit" value="送信する">
        </div>

      </form> 
    </div>
  </section>
</main>

<?php include __DIR__ . '/includes/footer.php'; ?>