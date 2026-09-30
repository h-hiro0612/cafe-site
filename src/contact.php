<?php include __DIR__ . '/includes/header.php'; ?>
<?php include __DIR__ . '/includes/function.php'; ?>
<main>
  <section class="contact-form">
    <div class="contact-form-container container">
      <h1>お問い合わせ</h1>
      <form action="./confirm.php" method="post" class="form">
        <div class="form-group">
          <label for="name">お名前<span class="required">必須</span></label>
          <input type="text" id="name" name="name" value="<?php echo h($_POST['name'] ?? '', ENT_QUOTES); ?>" required>
        </div>
        <div class="form-group">
          <label for="email">メールアドレス<span class="required">必須</span></label>
          <input type="email" id="email" name="email" value="<?php echo h($_POST['email'] ?? '', ENT_QUOTES); ?>" required>
        </div>
        <div class="form-group">
          <label for="message">お問い合わせ内容<span class="required">必須</span></label>
          <textarea id="message" name="message" rows="10" required><?php echo h($_POST['message'] ?? '', ENT_QUOTES); ?></textarea>
        </div>

        <div class="form-btn">
          <input type="submit" value="送信">
        </div>
      </form> 
    </div>
  </section>
</main>

<?php include __DIR__ . '/includes/footer.php'; ?>