/**
 * JavaScript cho trang Màn Hình LED
 * Namespace: ledScreenPage
 * Đảm bảo không ảnh hưởng đến các JS mặc định của WordPress và WooCommerce
 */

(function ($) {
  "use strict";

  // Namespace object để tránh conflict
  var ledScreenPage = {
    // Initialize
    init: function () {
      // Chỉ chạy trên trang màn hình LED
      if (!$(".led-screen-page").length) {
        return;
      }

      this.initSliders();
      this.initResponsive();
    },

    // Initialize category sliders
    initSliders: function () {
      var sliders = $(".led-screen-page .led-screen-category-slider");
      if (!sliders.length) {
        return;
      }

      sliders.each(function () {
        var slider = $(this);
        var track = slider.find(".led-screen-category-slider-track");
        var cards = track.find(".category-product-card");
        var prevBtn = slider.find(".led-screen-slider-nav.led-screen-slider-prev");
        var nextBtn = slider.find(".led-screen-slider-nav.led-screen-slider-next");

        if (!cards.length) {
          slider.addClass("is-static");
          prevBtn.hide();
          nextBtn.hide();
          return;
        }

        // Nếu có 4 sản phẩm trở xuống, không hiển thị slider
        if (cards.length <= 4) {
          slider.addClass("is-static");
          prevBtn.hide();
          nextBtn.hide();
          track.css("transform", "none");
          return;
        }

        var currentIndex = 0;
        var cardWidth = cards.first().outerWidth();
        var initialStyles = window.getComputedStyle(track[0]);
        var cardSpacing =
          parseFloat(initialStyles.columnGap || initialStyles.gap || 0) || 0;
        var containerWidth = slider.innerWidth();
        var visibleCards = Math.max(
          1,
          Math.floor(containerWidth / (cardWidth + cardSpacing))
        );
        var maxIndex = Math.max(0, cards.length - visibleCards);

        function updateNavState() {
          if (cards.length <= visibleCards) {
            slider.addClass("is-static");
            prevBtn.hide();
            nextBtn.hide();
          } else {
            slider.removeClass("is-static");
            prevBtn.show();
            nextBtn.show();
            prevBtn.prop("disabled", currentIndex === 0);
            nextBtn.prop("disabled", currentIndex >= maxIndex);
          }
        }

        function moveSlider() {
          var translateX = -currentIndex * (cardWidth + cardSpacing);
          track.css("transform", "translateX(" + translateX + "px)");
          updateNavState();
        }

        function recalcDimensions() {
          cardWidth = cards.first().outerWidth();
          var computedStyles = window.getComputedStyle(track[0]);
          cardSpacing =
            parseFloat(computedStyles.columnGap || computedStyles.gap || 0) || 0;
          containerWidth = slider.innerWidth();
          visibleCards = Math.max(
            1,
            Math.floor(containerWidth / (cardWidth + cardSpacing))
          );
          maxIndex = Math.max(0, cards.length - visibleCards);
          currentIndex = Math.min(currentIndex, maxIndex);
        }

        // Previous button click
        prevBtn.on("click", function () {
          if (currentIndex > 0) {
            currentIndex--;
            moveSlider();
          }
        });

        // Next button click
        nextBtn.on("click", function () {
          if (currentIndex < maxIndex) {
            currentIndex++;
            moveSlider();
          }
        });

        // Drag / swipe support
        var startX = 0;
        var currentX = 0;
        var isDragging = false;

        track.on("touchstart mousedown", function (e) {
          if (e.type === "mousedown" && e.which !== 1) return;
          isDragging = true;
          startX = e.type === "mousedown" ? e.pageX : e.touches[0].pageX;
          currentX = startX;
          track.addClass("is-dragging");
        });

        track.on("touchmove mousemove", function (e) {
          if (!isDragging) return;
          currentX = e.type === "mousemove" ? e.pageX : e.touches[0].pageX;
          var diff = currentX - startX;
          track.css(
            "transform",
            "translateX(" + (-currentIndex * (cardWidth + cardSpacing) + diff) + "px)"
          );
          if (e.type === "mousemove") {
            e.preventDefault();
          }
        });

        track.on("touchend mouseup mouseleave", function () {
          if (!isDragging) return;
          isDragging = false;
          track.removeClass("is-dragging");
          var diff = currentX - startX;
          var threshold = cardWidth / 4;

          if (Math.abs(diff) > threshold) {
            if (diff > 0 && currentIndex > 0) {
              currentIndex--;
            } else if (diff < 0 && currentIndex < maxIndex) {
              currentIndex++;
            }
          }

          moveSlider();
        });

        // Initial calculation
        recalcDimensions();
        moveSlider();

        // Responsive recalculation
        var resizeTimer;
        $(window).on("resize", function () {
          clearTimeout(resizeTimer);
          resizeTimer = setTimeout(function () {
            // Kiểm tra lại số lượng sản phẩm sau khi resize
            if (cards.length <= 4) {
              slider.addClass("is-static");
              prevBtn.hide();
              nextBtn.hide();
              track.css("transform", "none");
              return;
            }
            recalcDimensions();
            moveSlider();
          }, 250);
        });
      });
    },

    // Initialize responsive behaviors
    initResponsive: function () {
      // Hide navigation buttons on mobile (chỉ cho các slider có > 4 sản phẩm)
      function checkMobileNav() {
        var windowWidth = $(window).width();
        var sliders = $(".led-screen-page .led-screen-category-slider");
        
        sliders.each(function () {
          var slider = $(this);
          var cards = slider.find(".category-product-card");
          var navButtons = slider.find(".led-screen-slider-nav");
          
          // Nếu có <= 4 sản phẩm, luôn ẩn nút
          if (cards.length <= 4) {
            navButtons.hide();
            return;
          }
          
          // Nếu > 4 sản phẩm, ẩn trên mobile, hiện trên desktop
          if (windowWidth <= 768) {
            navButtons.hide();
          } else {
            navButtons.show();
          }
        });
      }

      $(window).on("resize", function () {
        checkMobileNav();
      });

      checkMobileNav();
    },
  };

  // Initialize when document is ready
  $(document).ready(function () {
    ledScreenPage.init();
  });

  // Reinitialize on AJAX content load (if needed)
  $(document).on("ledScreenPageReinit", function () {
    ledScreenPage.init();
  });
})(jQuery);

