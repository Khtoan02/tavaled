/**
 * JavaScript cho trang Hệ Thống Âm Thanh
 * Namespace: audioSystemPage
 * Đảm bảo không ảnh hưởng đến các JS mặc định của WordPress và WooCommerce
 */

(function ($) {
  "use strict";

  // Namespace object để tránh conflict
  var audioSystemPage = {
    // Initialize
    init: function () {
      // Chỉ chạy trên trang hệ thống âm thanh
      if (!$(".audio-system-page").length) {
        return;
      }

      this.initSliders();
      this.initResponsive();
    },

    // Initialize category sliders
    initSliders: function () {
      var sliders = $(".audio-system-page .products-carousel");
      if (!sliders.length) {
        return;
      }

      sliders.each(function () {
        var slider = $(this);
        var track = slider.find(".carousel-track");
        var cards = track.find(".product-card");
        var container = slider.find(".carousel-container");
        var prevBtn = slider.find(".carousel-prev");
        var nextBtn = slider.find(".carousel-next");
        var transitionValue = track.css("transition");

        if (!cards.length) {
          slider.addClass("is-static");
          prevBtn.hide();
          nextBtn.hide();
          return;
        }

        var currentIndex = 0;
        var cardWidth = 0;
        var cardSpacing = 0;
        var containerWidth = 0;
        var visibleCards = 1;
        var maxIndex = 0;

        function recalcDimensions() {
          cardWidth = cards.first().outerWidth();
          var computedStyles = window.getComputedStyle(track[0]);
          cardSpacing =
            parseFloat(computedStyles.columnGap || computedStyles.gap || 0) ||
            0;
          containerWidth = container.innerWidth() || slider.innerWidth();
          visibleCards = Math.max(
            1,
            Math.floor(containerWidth / (cardWidth + cardSpacing))
          );
          maxIndex = Math.max(0, cards.length - visibleCards);
          currentIndex = Math.min(currentIndex, maxIndex);
        }

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
          track.css("transition", transitionValue);
          track.css("transform", "translateX(" + translateX + "px)");
          updateNavState();
        }

        prevBtn.off("click.audioSlider").on("click.audioSlider", function () {
          if (currentIndex > 0) {
            currentIndex--;
            moveSlider();
          }
        });

        nextBtn.off("click.audioSlider").on("click.audioSlider", function () {
          if (currentIndex < maxIndex) {
            currentIndex++;
            moveSlider();
          }
        });

        // Drag / swipe support with smart axis lock
        var startX = 0;
        var startY = 0;
        var lastX = 0;
        var isDragging = false;
        var dragAxis = null;

        track
          .off("touchstart.audioDrag mousedown.audioDrag")
          .on("touchstart.audioDrag mousedown.audioDrag", function (e) {
            if (e.type === "mousedown" && e.which !== 1) return;
            var point = e.type === "mousedown" ? e : e.originalEvent.touches[0];
            isDragging = true;
            dragAxis = null;
            startX = point.pageX;
            startY = point.pageY;
            lastX = startX;
            track.addClass("is-dragging").css("transition", "none");
          });

        track
          .off("touchmove.audioDrag mousemove.audioDrag")
          .on("touchmove.audioDrag mousemove.audioDrag", function (e) {
            if (!isDragging) return;
            var point = e.type === "mousemove" ? e : e.originalEvent.touches[0];
            var diffX = point.pageX - startX;
            var diffY = point.pageY - startY;

            if (dragAxis === null) {
              if (Math.abs(diffX) > 6 || Math.abs(diffY) > 6) {
                dragAxis = Math.abs(diffX) > Math.abs(diffY) ? "x" : "y";
              }
            }

            if (dragAxis !== "x") {
              return;
            }

            lastX = point.pageX;
            track.css(
              "transform",
              "translateX(" +
                (-currentIndex * (cardWidth + cardSpacing) + diffX) +
                "px)"
            );
            if (e.cancelable) {
              e.preventDefault();
            }
            e.stopPropagation();
          });

        track
          .off("touchend.audioDrag mouseup.audioDrag mouseleave.audioDrag")
          .on(
            "touchend.audioDrag mouseup.audioDrag mouseleave.audioDrag",
            function () {
              if (!isDragging) return;
              isDragging = false;
              track
                .removeClass("is-dragging")
                .css("transition", transitionValue);

              if (dragAxis !== "x") {
                moveSlider();
                return;
              }

              var diff = lastX - startX;
              var threshold = Math.max(cardWidth * 0.2, 24);

              if (Math.abs(diff) > threshold) {
                if (diff > 0 && currentIndex > 0) {
                  currentIndex--;
                } else if (diff < 0 && currentIndex < maxIndex) {
                  currentIndex++;
                }
              }

              moveSlider();
            }
          );

        // Mouse wheel / trackpad horizontal scrolling with axis guard
        track
          .off("wheel.audioCategory")
          .on("wheel.audioCategory", function (event) {
            var e = event.originalEvent || event;
            var deltaX = e.deltaX || 0;
            var deltaY = e.deltaY || 0;
            var absX = Math.abs(deltaX);
            var absY = Math.abs(deltaY);

            if (absY > absX && absY > 8) {
              return;
            }

            var primaryDelta = absX >= absY ? deltaX : deltaY;

            if (primaryDelta > 0 && currentIndex < maxIndex) {
              currentIndex++;
              moveSlider();
            } else if (primaryDelta < 0 && currentIndex > 0) {
              currentIndex--;
              moveSlider();
            }

            if (event.cancelable) {
              event.preventDefault();
            }
            event.stopPropagation();
          });

        recalcDimensions();
        moveSlider();

        var resizeTimer;
        $(window)
          .off("resize.audioSlider" + slider.data("carousel"))
          .on("resize.audioSlider" + slider.data("carousel"), function () {
            clearTimeout(resizeTimer);
            resizeTimer = setTimeout(function () {
              recalcDimensions();
              moveSlider();
            }, 250);
          });
      });
    },

    // Initialize responsive behaviors
    initResponsive: function () {
      var sliders = $(".audio-system-page .products-carousel");

      function checkMobileNav() {
        var windowWidth = $(window).width();

        sliders.each(function () {
          var slider = $(this);
          var cards = slider.find(".product-card");
          var navButtons = slider.find(".carousel-nav");

          if (cards.length <= 1) {
            navButtons.hide();
            return;
          }

          if (windowWidth <= 768) {
            navButtons.hide();
          } else {
            navButtons.show();
          }
        });
      }

      $(window)
        .off("resize.audioNav")
        .on("resize.audioNav", function () {
          checkMobileNav();
        });

      checkMobileNav();
    },
  };

  // Initialize when document is ready
  $(document).ready(function () {
    audioSystemPage.init();
  });

  // Reinitialize on AJAX content load (if needed)
  $(document).on("audioSystemPageReinit", function () {
    audioSystemPage.init();
  });
})(jQuery);
