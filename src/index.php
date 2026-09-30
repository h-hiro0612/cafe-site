<?php 
include __DIR__ . '/includes/function.php'; 
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>喫茶 雲和</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

    <header class="home-header">
        <div class="header-inner">
            <div class="hamburger" id="js-hamburger" aria-label="メニューを開く">
                <span></span>
                <span></span>
                <span></span>
            </div>

            <nav class="header_nav" id="js-nav">
                <ul>
                    <li><a href="../index.php">ホーム</a></li>
                    <li><a href="#concept">こだわり</a></li>
                    <li><a href="#menu">メニュー</a></li>
                    <li><a href="#news">お知らせ</a></li>
                    <li><a href="#access">店舗案内</a></li>
                    <li><a href="#contact">お問い合わせ</a></li>
                </ul>
            </nav>
        </div>
    </header>
    <main>
        <section class="hero">

                <div class="hero-image">
                   <img src="./images/hero-image.png" alt="喫茶 雲和">
                </div>  
                <div class="hero_content">
                    <h1>喫茶 雲和</h1>
                    <p>日常にそっと寄り添う、和の心地よさ。</p>
                </div>
   
        </section>

        <section id="concept">
            <div class="concept">
                <h2>こだわり</h2>
                <div class="concept-container container">
                    <div class="concept-image">
                        <img src="./images/concept-image.png" alt="こだわり">
                    </div>
                    <div class="concept-text">
                        <p>木漏れ日が差し込む大きな窓と、心地よい木の温もり。
                            地元の旬の素材を使い、ひとつひとつ丁寧に仕込んだ和のスイーツと温かいお茶をご用意しました。
                            季節の風を感じながら、ほっと心がほぐれる時間をお過ごしください。
                        </p>
                    </div>
                </div>
            </div>    
        </section>

        <section id="menu">
            <div class="menu">
                <h2>メニュー</h2>
                <div class="menu-container container">
                    <div class="menu-items">
                        <div class="menu-item">
                            <img src="./images/menu1.png" alt="抹茶ラテ">
                            <p class="menu-detail">抹茶ラテ</p>
                        </div>  
                        <div class="menu-item">
                            <img src="./images/menu2.png" alt="ドリップコーヒー">
                            <p class="menu-detail">ドリップコーヒー</p>
                        </div>  
                        <div class="menu-item">
                            <img src="./images/menu3.png" alt="窯出しプリン">
                            <p class="menu-detail">窯出しプリン</p>
                        </div>  
                    </div>

                    <div class="carousel-dots">
                        <button class="dot active" data-index="0"></button>
                        <button class="dot" data-index="1"></button>
                        <button class="dot" data-index="2"></button>
                    </div>

                    <a href="#">
                        <div class="more_btn">
                        もっと見る
                        </div>   
                    </a>
                </div>
            </div>    
        </section>

        <section id="news">
            <div class="news">
                <h2>お知らせ</h2>
                <div class="news-container container">
                    <div class="news-items">
                        <div class="news-item">
                            <div class="news-item-pic">
                                <img src="./images/news-item1.png">
                            </div>
                            <div class="news-item-tex">
                                <p>新しいコーヒー豆を入荷しました！</p>
                            </div>
                        </div>
                        <div class="news-item">
                            <div class="news-item-pic">
                                <img src="./images/news-item2.png">
                            </div>
                            <div class="news-item-tex">
                                <p>駐車場のご案内</p>
                            </div>
                        </div>
                    </div>

                    <a href="#">
                        <div class="more_btn">
                        もっと見る
                        </div>   
                    </a>
                </div>
            </div>        
        </section>

        <section id="access">
            <div class="access">
                <h2>店舗案内</h2>
                <div class="access-container container">
                    <div class="access-map">
                        <iframe  
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3240.831769147457!2d139.76448647670253!3d35.6811441299773!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x60188bfbd89f700b%3A0x277c49ba34ed38!2z5p2x5Lqs6aeF!5e0!3m2!1sja!2sjp!4v1790140634933!5m2!1sja!2sjp"
                        width="80%" 
                        height="500"
                        style="border:0;" 
                        allowfullscreen="" 
                        loading="lazy" 
                        referrerpolicy="strict-origin-when-cross-origin">
                        </iframe>
                    </div>
                    <div class="access-details">
                        <dl>
                            <dt>所在地<span>：</span></dt>
                            <dd>〒000-0000 ○○県○○市○○町 1-2-3</dd>
                            <dt>電話番号<span>：</span></dt>
                            <dd>000-0000-0000</dd>
                            <dt>営業時間<span>：</span></dt>
                            <dd>11:00 〜 18:00（L.O. 17:30）</dd>
                            <dt>定休日<span>：</span></dt>
                            <dd>水曜日・第2火曜日</dd>
                            <dt>座席<span>：</span></dt>
                            <dd>18席（全席禁煙）</dd>
                            <dt>お支払い<span>：</span></dt>
                            <dd>現金、クレジットカード、各種電子マネー可</dd>
                        </dl>
                    </div>
                </div>
            </div>    
        </section>

        <section id="contact">
            <div class="contact">
                <h2>お問い合わせ</h2>
                <div class="contact-container container">
                    <div class="contact-tex">
                        <p>
                            ご予約・お席のお問い合わせや、取材・貸切等のご相談は、お電話または下記のお問い合わせフォームより承っております。
                        </p>
                        <ul>
                            <li>お電話でのご予約・お問い合わせ<br>025-XXX-XXXX（受付時間：11:00〜18:00 / 水曜定休）</li>
                            <li>※当日のご予約やお急ぎの場合はお電話にてご連絡ください。</li>
                            <li>フォームからのお問い合わせ<br>（※ご返信までに1〜2営業日ほどいただく場合がございます。）</li>
                        </ul>
                        <a class="contact-form" href="./contact.php">
                            <div class="contact-btn">
                                お問い合わせフォームへ
                            </div>
                        </a>
                    </div>
                    <div class="contact-pic">
                        <img src="./images/contact-image.png" alt="お問い合わせ">
                    </div>
                </div>
            </div>    
        </section>
    </main>

    <!-- メニューアイテムクリック時のモーダル -->
    <div id="menu-modal" class="modal">
        <span class="modal-close">&times;</span>
        <div class="modal-content">
            <img id="modal-img" src="" alt="">
            <p id="modal-caption"></p>
        </div>
    </div>

<?php include __DIR__ . '/includes/footer.php'; ?>