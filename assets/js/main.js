/**
 * TavaLED Theme - Main JavaScript
 */

(function ($) {
  "use strict";

  // Document ready
  $(document).ready(function () {
    // Initialize all modules
    initHeaderScroll();
    initMobileMenu();
    initSearchToggle();
    initDropdownMenu();
    initSmoothScroll();
    initBackToTop();
    initAnimations();
    initProductFilter();
    initProductsTabs();
    initProductsCarousel();
    initCategorySliders();
    initPopups();
    initForms();
    initReadingProgress();
  });

  // Header scroll effect - Tối ưu cho mobile
  function initHeaderScroll() {
    var header = $(".site-header");
    var headerMain = $(".header-main");
    var scrollThreshold = 50; // Giảm threshold cho mobile
    var lastScrollTop = 0;
    var isScrolling = false;

    $(window).on("scroll", function () {
      if (isScrolling) return;
      isScrolling = true;

      requestAnimationFrame(function () {
        var scrollTop = $(this).scrollTop();
        var windowWidth = $(window).width();

        // Điều chỉnh threshold theo kích thước màn hình
        var threshold = windowWidth <= 768 ? 30 : 100;

        if (scrollTop > threshold) {
          header.addClass("scrolled");
          
          // Ẩn header khi scroll xuống, hiện khi scroll lên (chỉ trên mobile)
          if (windowWidth <= 768) {
            if (scrollTop > lastScrollTop && scrollTop > 100) {
              headerMain.addClass("header-hidden");
            } else {
              headerMain.removeClass("header-hidden");
            }
          }
        } else {
          header.removeClass("scrolled");
          headerMain.removeClass("header-hidden");
        }

        lastScrollTop = scrollTop;
        isScrolling = false;
      }.bind(this));
    });
  }

  // Mobile menu
  function initMobileMenu() {
    var toggle = $(".mobile-menu-toggle");
    var close = $(".mobile-menu-close");
    var overlay = $(".mobile-menu-overlay");
    var body = $("body");

    toggle.on("click", function () {
      body.toggleClass("mobile-menu-active");
    });

    close.on("click", function () {
      body.removeClass("mobile-menu-active");
    });

    overlay.on("click", function () {
      body.removeClass("mobile-menu-active");
    });

    // Close menu on escape key
    $(document).on("keydown", function (e) {
      if (e.keyCode === 27 && body.hasClass("mobile-menu-active")) {
        body.removeClass("mobile-menu-active");
      }
    });
  }

  // Search toggle
  function initSearchToggle() {
    var toggle = $(".search-toggle");
    var searchDropdown = $(".header-search");
    var searchClose = $(".search-close");

    toggle.on("click", function () {
      searchDropdown.toggleClass("active");
      if (searchDropdown.hasClass("active")) {
        searchDropdown.find(".search-field").focus();
      }
    });

    searchClose.on("click", function () {
      searchDropdown.removeClass("active");
    });

    // Close on click outside
    $(document).on("click", function (e) {
      if (!$(e.target).closest(".search-toggle, .header-search").length) {
        searchDropdown.removeClass("active");
      }
    });

    // Close on escape key
    $(document).on("keydown", function (e) {
      if (e.keyCode === 27 && searchDropdown.hasClass("active")) {
        searchDropdown.removeClass("active");
      }
    });
  }

  // Dropdown menu - Tối ưu cho mobile
  function initDropdownMenu() {
    var dropdownItems = $(".has-dropdown");
    var dropdownMenus = $(".dropdown-menu");

    // Show dropdown on hover for desktop
    dropdownItems.on("mouseenter", function () {
      if ($(window).width() > 1024) {
        $(this).find(".dropdown-menu").addClass("show");
      }
    });

    dropdownItems.on("mouseleave", function () {
      if ($(window).width() > 1024) {
        $(this).find(".dropdown-menu").removeClass("show");
      }
    });

    // Toggle dropdown on click for mobile
    dropdownItems.find("a").on("click", function (e) {
      if ($(window).width() <= 1024) {
        var parentItem = $(this).closest(".has-dropdown");
        var dropdownMenu = parentItem.find(".dropdown-menu");

        if (dropdownMenu.length && $(this).attr("href") === "#") {
          e.preventDefault();
          dropdownMenu.slideToggle(300);
          parentItem.toggleClass("active");
        }
      }
    });

    // Mobile menu submenu toggle
    $(".mobile-nav-link").on("click", function (e) {
      var $this = $(this);
      var $parent = $this.closest(".mobile-nav-item");
      var $submenu = $parent.find(".mobile-submenu");
      var href = $this.attr("href");

      // Nếu có submenu và không phải là link thực sự
      if ($submenu.length && (!href || href === "#")) {
        e.preventDefault();
        $parent.toggleClass("active");
        $this.toggleClass("active");
        
        // Đóng các submenu khác
        $(".mobile-nav-item").not($parent).removeClass("active");
        $(".mobile-nav-link").not($this).removeClass("active");
      }
    });

    // Close dropdowns when clicking outside
    $(document).on("click", function (e) {
      if (!$(e.target).closest(".has-dropdown").length) {
        dropdownMenus.removeClass("show");
        dropdownItems.removeClass("active");
        if ($(window).width() <= 1024) {
          dropdownMenus.slideUp();
        }
      }
    });
  }

  // Smooth scroll
  function initSmoothScroll() {
    $('a[href^="#"]').on("click", function (e) {
      var target = $(this.getAttribute("href"));
      if (target.length) {
        e.preventDefault();
        $("html, body").animate(
          {
            scrollTop: target.offset().top - 100,
          },
          1000
        );
      }
    });
  }

  // Back to top
  function initBackToTop() {
    var button = $(".back-to-top");
    var showThreshold = 300;

    $(window).on("scroll", function () {
      if ($(this).scrollTop() > showThreshold) {
        button.addClass("show");
      } else {
        button.removeClass("show");
      }
    });

    button.on("click", function () {
      $("html, body").animate(
        {
          scrollTop: 0,
        },
        600
      );
    });
  }

  // Scroll animations
  function initAnimations() {
    var animateElements = $(
      ".animate-fadeIn, .animate-slideInLeft, .animate-slideInRight"
    );

    function checkIfInView() {
      var windowHeight = $(window).height();
      var windowTopPosition = $(window).scrollTop();
      var windowBottomPosition = windowTopPosition + windowHeight;

      $.each(animateElements, function () {
        var element = $(this);
        var elementHeight = element.outerHeight();
        var elementTopPosition = element.offset().top;
        var elementBottomPosition = elementTopPosition + elementHeight;

        // Check if element is in viewport
        if (
          elementBottomPosition >= windowTopPosition &&
          elementTopPosition <= windowBottomPosition
        ) {
          element.addClass("in-view");
        }
      });
    }

    $(window).on("scroll resize", checkIfInView);
    $(window).trigger("scroll");
  }


  // Product filter functionality
  function initProductFilter() {
    var filterBtns = $(".filter-btn");
    var productCards = $(".product-card");
    var productCount = $(".product-count strong");

    filterBtns.on("click", function () {
      var filter = $(this).data("filter");

      // Update active button
      filterBtns.removeClass("active");
      $(this).addClass("active");

      // Filter products
      if (filter === "all") {
        productCards.fadeIn(300);
        productCount.text(productCards.length);
        $(".no-products-message").remove();
      } else {
        productCards.hide();
        var filteredCards = productCards.filter(
          '[data-category="' + filter + '"]'
        );
        filteredCards.fadeIn(300);
        productCount.text(filteredCards.length);

        // Show message if no products found
        if (filteredCards.length === 0) {
          if ($(".no-products-message").length === 0) {
            $(".products-grid").append(
              '<div class="no-products-message"><p>Không có sản phẩm nào trong danh mục này.</p></div>'
            );
          }
        } else {
          $(".no-products-message").remove();
        }
      }
    });

    // Wishlist functionality
    $(".wishlist-btn").on("click", function () {
      var $this = $(this);
      var icon = $this.find("i");

      if (icon.hasClass("far")) {
        icon.removeClass("far").addClass("fas");
        $this.addClass("active");
        showNotification("Đã thêm vào yêu thích", "success");
      } else {
        icon.removeClass("fas").addClass("far");
        $this.removeClass("active");
        showNotification("Đã xóa khỏi yêu thích", "info");
      }
    });

    // Quick view functionality
    $(".quick-view").on("click", function () {
      var productTitle = $(this)
        .closest(".product-card")
        .find(".product-title a")
        .text();
      showNotification("Tính năng xem nhanh đang phát triển", "info");
    });
  }

  // Notification system
  function showNotification(message, type) {
    var notification = $(
      '<div class="notification notification-' +
        type +
        '">' +
        message +
        "</div>"
    );
    $("body").append(notification);

    setTimeout(function () {
      notification.addClass("show");
    }, 100);

    setTimeout(function () {
      notification.removeClass("show");
      setTimeout(function () {
        notification.remove();
      }, 300);
    }, 3000);
  }

  // Popups
  function initPopups() {
    var triggers = $('.popup-trigger, .header-cta[href*="lien-he"]');
    var popup = $("#contact-popup");
    var close = popup.find(".popup-close");

    triggers.on("click", function (e) {
      if ($(this).attr("href") === "#contact-popup") {
        e.preventDefault();
        popup.addClass("active");
        $("body").addClass("popup-open");
      }
    });

    close.on("click", function () {
      popup.removeClass("active");
      $("body").removeClass("popup-open");
    });

    popup.on("click", function (e) {
      if (e.target === this) {
        popup.removeClass("active");
        $("body").removeClass("popup-open");
      }
    });
  }

  // Forms
  function initForms() {
    // Contact form validation
    $(".contact-form").on("submit", function (e) {
      e.preventDefault();

      var form = $(this);
      var submitBtn = form.find('button[type="submit"]');
      var messageDiv = form.find('.form-message');
      var buttonText = submitBtn.find('.button-text');
      var buttonLoading = submitBtn.find('.button-loading');

      // Basic validation
      var isValid = true;
      form.find("input[required], textarea[required]").each(function () {
        if (!$(this).val().trim()) {
          isValid = false;
          $(this).addClass("error");
        } else {
          $(this).removeClass("error");
        }
      });

      if (isValid) {
        submitBtn.prop("disabled", true).addClass("loading");
        buttonText.hide();
        buttonLoading.show();
        messageDiv.removeClass("success error").empty();

        // Submit via AJAX
        $.ajax({
          url: form.attr("action"),
          type: "POST",
          data: form.serialize(),
          success: function (response) {
            if (response.success) {
              messageDiv.addClass("success").html(response.data.message || "Cảm ơn bạn! Chúng tôi sẽ liên hệ sớm nhất.");
              form[0].reset();
              
              // Close popup after 3 seconds if it's a popup form
              if (form.closest('.popup-overlay').length) {
                setTimeout(function () {
                  form.closest('.popup-overlay').removeClass('active');
                  $('body').removeClass('popup-open');
                }, 3000);
              }
            } else {
              messageDiv.addClass("error").html(response.data.message || "Có lỗi xảy ra. Vui lòng thử lại.");
            }
          },
          error: function () {
            messageDiv.addClass("error").html("Có lỗi xảy ra. Vui lòng thử lại.");
          },
          complete: function () {
            submitBtn.prop("disabled", false).removeClass("loading");
            buttonText.show();
            buttonLoading.hide();
          }
        });
      } else {
        messageDiv.addClass("error").html("Vui lòng điền đầy đủ thông tin.");
      }
    });

    // Phone CTA form
    $(".phone-cta-form").on("submit", function (e) {
      e.preventDefault();

      var form = $(this);
      var submitBtn = form.find('button[type="submit"]');
      var messageDiv = form.find('.phone-form-message');
      var phoneInput = form.find('input[name="phone"]');

      // Basic validation
      if (!phoneInput.val().trim()) {
        messageDiv.addClass("error").html("Vui lòng nhập số điện thoại.").show();
        phoneInput.focus();
        return;
      }

      submitBtn.prop("disabled", true).addClass("loading");
      messageDiv.removeClass("success error").empty().hide();

      // Submit via AJAX
      $.ajax({
        url: form.attr("action"),
        type: "POST",
        data: form.serialize(),
        success: function (response) {
          if (response.success) {
            messageDiv.addClass("success").html(response.data.message || "Cảm ơn bạn! Chúng tôi sẽ liên hệ sớm nhất.").show();
            form[0].reset();
          } else {
            messageDiv.addClass("error").html(response.data.message || "Có lỗi xảy ra. Vui lòng thử lại.").show();
          }
        },
        error: function () {
          messageDiv.addClass("error").html("Có lỗi xảy ra. Vui lòng thử lại.").show();
        },
        complete: function () {
          submitBtn.prop("disabled", false).removeClass("loading");
        }
      });
    });
  }

  // Reading progress indicator
  function initReadingProgress() {
    var progressBar = document.querySelector(".single-progress-bar");
    if (!progressBar) {
      return;
    }

    var updateProgress = function () {
      var scrollTop = window.scrollY || document.documentElement.scrollTop;
      var docHeight =
        document.documentElement.scrollHeight - window.innerHeight;
      var progress = docHeight > 0 ? scrollTop / docHeight : 0;
      progress = Math.min(Math.max(progress, 0), 1);
      progressBar.style.transform = "scaleX(" + progress + ")";
    };

    window.addEventListener("scroll", updateProgress);
    window.addEventListener("resize", updateProgress);
    updateProgress();
  }

  // Products Tabs
  function initProductsTabs() {
    var tabButtons = $(".tab-btn");
    var productCarousels = $(".products-carousel");

    tabButtons.on("click", function () {
      var targetTab = $(this).data("tab");

      // Remove active class from all tabs and carousels
      tabButtons.removeClass("active");
      productCarousels.removeClass("active");

      // Add active class to clicked tab
      $(this).addClass("active");

      // Show corresponding carousel
      $('.products-carousel[data-tab="' + targetTab + '"]').addClass("active");

      // Reinitialize carousel for the active tab
      initCarouselForTab(targetTab);
    });
  }

  // Products Carousel
  function initProductsCarousel() {
    // Initialize carousel for the default active tab
    var activeTab = $(".tab-btn.active").data("tab");
    if (activeTab) {
      initCarouselForTab(activeTab);
    }
  }

  function initCarouselForTab(tabName) {
    var carousel = $('.products-carousel[data-tab="' + tabName + '"]');
    if (!carousel.length) return;
    
    var container = carousel.find(".carousel-container");
    var track = carousel.find(".carousel-track");
    var prevBtn = carousel.find(".carousel-prev");
    var nextBtn = carousel.find(".carousel-next");
    var cards = track.find(".product-card");

    if (cards.length === 0) return;

    var currentIndex = 0;
    var cardWidth = 0;
    var containerWidth = 0;
    var visibleCards = 0;
    var maxIndex = 0;

    // Calculate dimensions
    function calculateDimensions() {
      cardWidth = cards.first().outerWidth(true);
      containerWidth = container.width();
      visibleCards = Math.max(1, Math.floor(containerWidth / cardWidth));
      maxIndex = Math.max(0, cards.length - visibleCards);
      
      if (currentIndex > maxIndex) {
        currentIndex = maxIndex;
      }
    }

    // Update navigation buttons
    function updateNavButtons() {
      prevBtn.prop("disabled", currentIndex === 0);
      nextBtn.prop("disabled", currentIndex >= maxIndex);
    }

    // Move carousel
    function moveCarousel() {
      var translateX = -currentIndex * cardWidth;
      track.css("transform", "translateX(" + translateX + "px)");
      updateNavButtons();
    }

    // Initialize
    calculateDimensions();
    updateNavButtons();

    // Previous button click
    prevBtn.off("click").on("click", function () {
      if (currentIndex > 0) {
        currentIndex--;
        moveCarousel();
      }
    });

    // Next button click
    nextBtn.off("click").on("click", function () {
      if (currentIndex < maxIndex) {
        currentIndex++;
        moveCarousel();
      }
    });

    // Touch/swipe support for mobile
    var startX = 0;
    var currentX = 0;
    var isDragging = false;

    track.on("touchstart mousedown", function (e) {
      if (e.type === "mousedown" && e.which !== 1) return;
      isDragging = true;
      startX = e.type === "mousedown" ? e.pageX : e.touches[0].pageX;
      currentX = startX;
      track.css("transition", "none");
    });

    track.on("touchmove mousemove", function (e) {
      if (!isDragging) return;
      e.preventDefault();
      currentX = e.type === "mousemove" ? e.pageX : e.touches[0].pageX;
      var diff = currentX - startX;
      track.css("transform", "translateX(" + (-currentIndex * cardWidth + diff) + "px)");
    });

    track.on("touchend mouseup", function (e) {
      if (!isDragging) return;
      isDragging = false;
      track.css("transition", "transform 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94)");

      var diff = currentX - startX;
      var threshold = cardWidth / 3;

      if (Math.abs(diff) > threshold) {
        if (diff > 0 && currentIndex > 0) {
          currentIndex--;
        } else if (diff < 0 && currentIndex < maxIndex) {
          currentIndex++;
        }
      }

      moveCarousel();
    });

    // Responsive handling
    var resizeTimer;
    $(window).on("resize", function () {
      clearTimeout(resizeTimer);
      resizeTimer = setTimeout(function () {
        calculateDimensions();
        moveCarousel();
      }, 250);
    });
  }

  // Category sliders on product archive
  function initCategorySliders() {
    var sliders = $(".category-slider");
    if (!sliders.length) {
      return;
    }

    sliders.each(function () {
      var slider = $(this);
      var track = slider.find(".category-slider-track");
      var cards = track.find(".category-product-card");
      var prevBtn = slider.find(".category-slider-nav.prev");
      var nextBtn = slider.find(".category-slider-nav.next");

      if (!cards.length) {
        slider.addClass("is-static");
        prevBtn.prop("disabled", true);
        nextBtn.prop("disabled", true);
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
          prevBtn.prop("disabled", true);
          nextBtn.prop("disabled", true);
        } else {
          slider.removeClass("is-static");
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

      prevBtn.on("click", function () {
        if (currentIndex > 0) {
          currentIndex--;
          moveSlider();
        }
      });

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
          recalcDimensions();
          moveSlider();
        }, 250);
      });
    });
  }
})(jQuery);
