// ハンバーガーメニュー
document.addEventListener('DOMContentLoaded', () => {
   const hamburger = document.getElementById('js-hamburger');
   const nav = document.getElementById('js-nav');
   const navLinks = document.querySelectorAll('.header_nav a');

   if(hamburger && nav) {
    hamburger.addEventListener('click', () => {
        hamburger.classList.toggle('open');
        nav.classList.toggle('active');
    });

    navLinks.forEach(link => {
        link.addEventListener('click', () => {
        hamburger.classList.remove('open');
        nav.classList.remove('active');
        });
    });
   }
});

// スクロール時ふわっと表示
  const targetSections = document.querySelectorAll('.concept, .menu, .news, .access, .contact');

    const observerOptions = {
        root: null,
        rootMargin: '0px 0px -10% 0px',
        threshold: 0.1
    };

    const observer = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                // 画面に入ったら is-show クラスを付与
                entry.target.classList.add('is-show');
                // 一度表示されたら監視を解除（1回だけアニメーションさせる場合）
                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);

    targetSections.forEach(section => {
        observer.observe(section);
    });
    

    // メニューセクションスライダー
    const track = document.querySelector('.menu-items');
    const dots = document.querySelectorAll('.carousel-dots .dot');

    if (track && track.children.length > 0) {
        const slideCount = track.children.length;
        let currentIndex = 0;
        const intervalTime = 3000;
        let timerId = null;
        let firstClone = null;

        const mediaQuery = window.matchMedia('(max-width: 767px)');

         function updateDots(index) {
            if (dots.length === 0) return;
            dots.forEach(dot => dot.classList.remove('active'));

            const targetIndex = index === slideCount ? 0 : index;
            if (dots[targetIndex]) {
                dots[targetIndex].classList.add('active');
            }
         }

         function updateSlide() {
            currentIndex++;
            track.style.transition = 'transform 0.5s ease';
            track.style.transform = `translateX(-${currentIndex * 100}%)`;

            updateDots(currentIndex);

            if (currentIndex === track.children.length - 1) {
                setTimeout(() => {
                    track.style.transition = 'none';
                    currentIndex = 0;
                    track.style.transform = `translateX(0%)`;
                }, 500);
            }

         }

         function startSlider() {
            if(!firstClone) {
                firstClone = track.children[0].cloneNode(true);
                track.appendChild(firstClone);
            }

            updateDots(0);

            if (!timerId) {
                timerId = setInterval(updateSlide, intervalTime);
            }
         }

         function stopSlider() {
            if (timerId) {
                clearInterval(timerId);
                timerId = null;
            }

            if (firstClone && firstClone.parentNode) {
                track.removeChild(firstClone);
                firstClone = null;
            }

            currentIndex = 0;
            track.style.transition = 'none';
            track.style.transform = 'translateX(0%)';

            dots.forEach(dot => dot.classList.remove('active'));
         }

         function handleResize(e) {
            if (e.matches) {
                startSlider();
            } else {
                stopSlider();
            }
         }

         dots.forEach(dot => {
            dot.addEventListener('click', (e) => {
                if (!mediaQuery.matches) return;

                clearInterval(timerId);

                const index = Number(e.target.dataset.index);
                currentIndex = index;

                track.style.transition = 'transform 0.5s ease';
                track.style.transform = `translateX(-${currentIndex * 100}%)`;
                updateDots(currentIndex);

                timerId = setInterval(updateSlide, intervalTime);
            });
         });

         mediaQuery.addEventListener('change', handleResize);
         handleResize(mediaQuery);
    }

    // メニューアイテムクリック時
    document.addEventListener('DOMContentLoaded', () => {
    // 必要な要素をHTMLから取得する
    const menuItems = document.querySelectorAll('.menu-item');
    const modal = document.getElementById('menu-modal');
    const modalImg = document.getElementById('modal-img');
    const modalCaption = document.getElementById('modal-caption');
    const closeBtn = document.querySelector('.modal-close');

    // 1. 各メニューアイテムにクリックイベントを設定する
    menuItems.forEach(item => {
        item.style.cursor = 'pointer';

        item.addEventListener('click', () => {
            const img = item.querySelector('img');
            const text = item.querySelector('.menu-detail').textContent;

            modalImg.src = img.src;
            modalImg.alt = img.alt;
            modalCaption.textContent = text;

            modal.classList.add('is-active');
        });
    });

    closeBtn.addEventListener('click', () => {
        modal.classList.remove('is-active');
    });

    modal.addEventListener('click', (e) => {
        if (e.target === modal) {
            modal.classList.remove('is-active');
        }
    });
});