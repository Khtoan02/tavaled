<?php
/**
 * Enqueue scripts and styles
 *
 * @package TavaLED
 */

// Ngăn truy cập trực tiếp
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Enqueue scripts and styles.
 */
function tavaled_enqueue_scripts() {
    // Bootstrap CSS
    wp_enqueue_style(
        'bootstrap',
        'https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css',
        array(),
        '5.3.2'
    );
    
    // Theme stylesheet
    wp_enqueue_style('tavaled-style', get_stylesheet_uri(), array('bootstrap'), TAVALED_THEME_VERSION);

    // Google Fonts
    wp_enqueue_style('tavaled-google-fonts', 'https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800&family=Inter:wght@300;400;500;600;700&display=swap', array(), null);

    // Font Awesome
    wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css', array(), '6.4.0');

    // Vendor CSS (if any)
    if (file_exists(get_template_directory() . '/assets/css/vendor.css')) {
        wp_enqueue_style('tavaled-vendor', get_template_directory_uri() . '/assets/css/vendor.css', array(), TAVALED_THEME_VERSION);
    }

    // Main CSS
    if (file_exists(get_template_directory() . '/assets/css/main.css')) {
        wp_enqueue_style('tavaled-main', get_template_directory_uri() . '/assets/css/main.css', array('tavaled-style'), TAVALED_THEME_VERSION);
    }

    // Vendor JS (if any)
    if (file_exists(get_template_directory() . '/assets/js/vendor.js')) {
        wp_enqueue_script('tavaled-vendor', get_template_directory_uri() . '/assets/js/vendor.js', array('jquery'), TAVALED_THEME_VERSION, true);
    }

    // Bootstrap JS
    wp_enqueue_script(
        'bootstrap',
        'https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js',
        array('jquery'),
        '5.3.2',
        true
    );
    
    // Main JS
    if (file_exists(get_template_directory() . '/assets/js/main.js')) {
        wp_enqueue_script('tavaled-main', get_template_directory_uri() . '/assets/js/main.js', array('jquery', 'bootstrap'), TAVALED_THEME_VERSION, true);
    } else {
        // Create a placeholder main.js
        wp_enqueue_script('tavaled-main-inline', '', array('jquery'), TAVALED_THEME_VERSION, true);
        wp_add_inline_script('tavaled-main-inline', '
            (function($) {
                "use strict";
                
                // Header scroll effect
                $(window).on("scroll", function() {
                    if ($(this).scrollTop() > 100) {
                        $(".site-header").addClass("scrolled");
                    } else {
                        $(".site-header").removeClass("scrolled");
                    }
                });
                
                // Mobile menu toggle
                $(".mobile-menu-toggle").on("click", function() {
                    $("body").toggleClass("mobile-menu-active");
                });
                
                // Smooth scroll for anchor links
                $("a[href^=\'#\']").on("click", function(e) {
                    var target = $(this.getAttribute("href"));
                    if (target.length) {
                        e.preventDefault();
                        $("html, body").animate({
                            scrollTop: target.offset().top - 100
                        }, 1000);
                    }
                });
                
                // Search toggle
                $(".search-toggle").on("click", function() {
                    $(".header-search").toggleClass("active");
                });
                
                // Initialize animations on scroll
                function initScrollAnimations() {
                    var animateElements = $(".animate-on-scroll");
                    
                    function checkIfInView() {
                        var windowHeight = $(window).height();
                        var windowTopPosition = $(window).scrollTop();
                        var windowBottomPosition = (windowTopPosition + windowHeight);
                        
                        $.each(animateElements, function() {
                            var element = $(this);
                            var elementHeight = element.outerHeight();
                            var elementTopPosition = element.offset().top;
                            var elementBottomPosition = (elementTopPosition + elementHeight);
                            
                            if ((elementBottomPosition >= windowTopPosition) &&
                                (elementTopPosition <= windowBottomPosition)) {
                                element.addClass("in-view");
                            }
                        });
                    }
                    
                    $(window).on("scroll resize", checkIfInView);
                    $(window).trigger("scroll");
                }
                
                initScrollAnimations();
                
            })(jQuery);
        ');
    }

    // Comment reply script
    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }

    // Localize script for AJAX - sử dụng handle đúng tùy theo file có tồn tại hay không
    $main_script_handle = file_exists(get_template_directory() . '/assets/js/main.js') ? 'tavaled-main' : 'tavaled-main-inline';
    wp_localize_script($main_script_handle, 'tavaled_ajax', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce'    => wp_create_nonce('tavaled_nonce'),
    ));

    // Enqueue CSS và JS cho trang Màn Hình LED
    if (is_page_template('template-man-hinh-led.php')) {
        // CSS cho trang Màn Hình LED
        if (file_exists(get_template_directory() . '/assets/css/led-screen-page.css')) {
            wp_enqueue_style(
                'tavaled-led-screen-page',
                get_template_directory_uri() . '/assets/css/led-screen-page.css',
                array('tavaled-style', 'tavaled-main'),
                TAVALED_THEME_VERSION
            );
        }

        // JS cho trang Màn Hình LED
        if (file_exists(get_template_directory() . '/assets/js/led-screen-page.js')) {
            wp_enqueue_script(
                'tavaled-led-screen-page',
                get_template_directory_uri() . '/assets/js/led-screen-page.js',
                array('jquery', 'tavaled-main'),
                TAVALED_THEME_VERSION,
                true
            );
        }
    }

    // Enqueue CSS và JS cho trang Hệ Thống Âm Thanh
    if (is_page_template('template-he-thong-am-thanh.php')) {
        // CSS cho trang Hệ Thống Âm Thanh
        if (file_exists(get_template_directory() . '/assets/css/audio-system-page.css')) {
            wp_enqueue_style(
                'tavaled-audio-system-page',
                get_template_directory_uri() . '/assets/css/audio-system-page.css',
                array('tavaled-style', 'tavaled-main'),
                TAVALED_THEME_VERSION
            );
        }

        // JS cho trang Hệ Thống Âm Thanh
        if (file_exists(get_template_directory() . '/assets/js/audio-system-page.js')) {
            wp_enqueue_script(
                'tavaled-audio-system-page',
                get_template_directory_uri() . '/assets/js/audio-system-page.js',
                array('jquery', 'tavaled-main'),
                TAVALED_THEME_VERSION,
                true
            );
        }
    }

    // Enqueue CSS và JS cho trang Hệ Thống Ánh Sáng
    if (is_page_template('template-he-thong-anh-sang.php')) {
        // CSS cho trang Hệ Thống Ánh Sáng
        if (file_exists(get_template_directory() . '/assets/css/lighting-system-page.css')) {
            wp_enqueue_style(
                'tavaled-lighting-system-page',
                get_template_directory_uri() . '/assets/css/lighting-system-page.css',
                array('tavaled-style', 'tavaled-main'),
                TAVALED_THEME_VERSION
            );
        }

        // JS cho trang Hệ Thống Ánh Sáng
        if (file_exists(get_template_directory() . '/assets/js/lighting-system-page.js')) {
            wp_enqueue_script(
                'tavaled-lighting-system-page',
                get_template_directory_uri() . '/assets/js/lighting-system-page.js',
                array('jquery', 'tavaled-main'),
                TAVALED_THEME_VERSION,
                true
            );
        }
    }
}

/**
 * Enqueue admin scripts and styles
 */
function tavaled_admin_scripts() {
    wp_enqueue_style('tavaled-admin', get_template_directory_uri() . '/assets/css/admin.css', array(), TAVALED_THEME_VERSION);
}
add_action('admin_enqueue_scripts', 'tavaled_admin_scripts');

/**
 * Add async/defer attributes to scripts
 */
function tavaled_script_loader_tag($tag, $handle, $src) {
    // Add async to specific scripts
    $async_scripts = array('font-awesome');
    
    if (in_array($handle, $async_scripts)) {
        return str_replace(' src', ' async src', $tag);
    }
    
    // Add defer to specific scripts
    $defer_scripts = array('tavaled-main');
    
    if (in_array($handle, $defer_scripts)) {
        return str_replace(' src', ' defer src', $tag);
    }
    
    return $tag;
}
add_filter('script_loader_tag', 'tavaled_script_loader_tag', 10, 3);

/**
 * Preload key resources
 */
function tavaled_preload_resources() {
    // Preload fonts
    echo '<link rel="preload" href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&family=Open+Sans:wght@300;400;600;700&display=swap" as="style">';
    echo '<link rel="preconnect" href="https://fonts.googleapis.com">';
    echo '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>';
}
add_action('wp_head', 'tavaled_preload_resources', 1);