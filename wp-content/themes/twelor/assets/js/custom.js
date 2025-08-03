/**
 * Twelorテーマ カスタムJavaScript
 */

(function($) {
    'use strict';
    
    // ドキュメント読み込み完了時
    $(document).ready(function() {
        
        // スムーススクロール
        $('a[href^="#"]').on('click', function(e) {
            e.preventDefault();
            
            var target = this.hash;
            var $target = $(target);
            
            $('html, body').stop().animate({
                'scrollTop': $target.offset().top - 70
            }, 900, 'swing', function() {
                window.location.hash = target;
            });
        });

        // ギャラリータブの切り替え
        $('.nav-pills a').on('click', function(e) {
            e.preventDefault();
            $(this).tab('show');
        });

        // スマホメニューの開閉
        var $menuToggle = $('.menu-toggle');
        var $spMenu = $('.sp-menu');
        var $overlay = $('.menu-overlay');

        $menuToggle.on('click', function() {
            $spMenu.toggleClass('active');
            $overlay.toggleClass('active');
        });

        $overlay.on('click', function() {
            $spMenu.removeClass('active');
            $overlay.removeClass('active');
        });
        
        // モバイルメニューのスクロール対応
        if (window.innerWidth < 768) {
            var $nav = $('.twelor-nav');
            var activeLink = $nav.find('a.active');
            
            if (activeLink.length) {
                var linkOffset = activeLink.offset().left;
                var navWidth = $nav.width();
                var linkWidth = activeLink.width();
                
                $nav.scrollLeft(linkOffset - (navWidth / 2) + (linkWidth / 2));
            }
        }
        
        // 画像の遅延読み込み
        if ('loading' in HTMLImageElement.prototype) {
            const images = document.querySelectorAll('img[loading="lazy"]');
            images.forEach(img => {
                img.src = img.dataset.src;
            });
        } else {
            // Fallback for browsers that don't support lazy loading
            const script = document.createElement('script');
            script.src = 'https://cdnjs.cloudflare.com/ajax/libs/lazysizes/5.3.2/lazysizes.min.js';
            document.body.appendChild(script);
        }
        
        // カードの高さを揃える
        function equalizeCardHeights() {
            $('.row').each(function() {
                var highestCard = 0;
                var cards = $(this).find('.card');
                
                cards.height('auto');
                
                cards.each(function() {
                    if ($(this).height() > highestCard) {
                        highestCard = $(this).height();
                    }
                });
                
                cards.height(highestCard);
            });
        }
        
        // ウィンドウのリサイズ時にカードの高さを再調整
        $(window).on('resize', function() {
            equalizeCardHeights();
        });
        
        // 初期表示時にカードの高さを調整
        equalizeCardHeights();

        // スクロールアニメーション
        function handleScrollAnimation() {
            $('.fade-in-section').each(function() {
                var $element = $(this);
                var elementTop = $element.offset().top;
                var elementBottom = elementTop + $element.outerHeight();
                var viewportTop = $(window).scrollTop();
                var viewportBottom = viewportTop + $(window).height();
                
                // 要素が画面に入ったかチェック
                if (elementBottom > viewportTop && elementTop < viewportBottom) {
                    $element.addClass('is-visible');
                }
            });
        }
        
        // スクロール時にアニメーションをチェック
        $(window).on('scroll', handleScrollAnimation);
        
        // 初期表示時にもチェック
        handleScrollAnimation();
        
    });
    
})(jQuery);