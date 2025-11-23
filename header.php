<?php
/**
 * The header for our theme
 *
 * @package TavaLED
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div id="page" class="site">
    <a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e('Skip to content', 'tavaled-theme'); ?></a>
    
    <header id="masthead" class="site-header">
        <!-- Top Header - Thông tin cơ bản -->
        <div class="header-top">
            <div class="container">
                <div class="header-top-content">
                    <div class="header-top-left">
                        <div class="top-info-item working-hours">
                            <i class="fas fa-clock"></i>
                            <span>Thứ 2 - Thứ 6: 8:00 - 17:30</span>
                        </div>
                        <div class="top-info-item">
                            <i class="fas fa-envelope"></i>
                            <span>Hỗ trợ 24/7: <?php echo esc_html(tavaled_get_primary_email()); ?></span>
                        </div>
                    </div>
                    <div class="header-top-right">
                        <div class="social-links">
                            <a href="#" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                            <a href="#" aria-label="YouTube"><i class="fab fa-youtube"></i></a>
                            <a href="#" aria-label="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
                            <a href="#" aria-label="Zalo"><i class="fas fa-comments"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Header - Navigation chính -->
        <div class="header-main">
            <div class="container">
                <div class="header-main-content">
                    <!-- Left: Main Menu -->
                    <nav class="main-navigation">
                        <?php
                        wp_nav_menu(array(
                            'theme_location' => 'primary',
                            'menu_id'        => 'primary-menu',
                            'container'      => false,
                            'menu_class'     => 'nav-menu',
                            'fallback_cb'    => false,
                            'walker'         => new Premium_Walker_Nav_Menu(),
                        ));
                        ?>
                    </nav>
                    
                    <!-- Center: Logo -->
                    <div class="site-branding">
                        <?php
                        if (has_custom_logo()) :
                            the_custom_logo();
                        else :
                            ?>
                            <a href="<?php echo esc_url(home_url('/')); ?>" class="logo-link">
                                <h1 class="site-title">TavaLED</h1>
                                <span class="site-tagline">Giải pháp LED toàn diện</span>
                            </a>
                            <?php
                        endif;
                        ?>
                    </div>
                    
                    <!-- Right: Contact & CTA -->
                    <div class="header-contact">
                        <?php
                        $phone = tavaled_get_primary_phone();
                        $email = tavaled_get_primary_email();
                        ?>
                        <div class="contact-info-unified">
                            <div class="contact-lines">
                                <div class="contact-line phone-line">
                                    <i class="fas fa-phone-alt"></i>
                                    <a href="tel:<?php echo tavaled_format_phone($phone); ?>" class="contact-link">
                                        <?php echo esc_html($phone); ?>
                                    </a>
                                </div>
                                <div class="contact-line email-line">
                                    <i class="fas fa-envelope"></i>
                                    <a href="mailto:<?php echo esc_attr($email); ?>" class="contact-link">
                                        <?php echo esc_html($email); ?>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="header-cta">
                            <a href="#contact-popup" class="btn-quote popup-trigger">
                                <i class="fas fa-calculator"></i>
                                <span class="btn-text">Báo giá</span>
                            </a>
                        </div>
                        
                        <!-- Mobile Menu Toggle - Bên phải -->
                        <button class="mobile-menu-toggle d-lg-none" data-bs-toggle="offcanvas" data-bs-target="#mobileMenu" aria-label="Toggle menu">
                            <span class="hamburger-line"></span>
                            <span class="hamburger-line"></span>
                            <span class="hamburger-line"></span>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bottom Header - Danh mục & Thông tin công ty -->
        <div class="header-bottom">
            <div class="container">
                <div class="header-bottom-content">
                    <!-- Left: Categories -->
                    <div class="category-menu">
                        <div class="category-item">
                            <a href="/giai-phap-hien-thi" class="category-link">
                                <i class="fas fa-tv"></i>
                                <span>Giải pháp hiển thị</span>
                                <small>Màn hình LED</small>
                            </a>
                        </div>
                        <div class="category-item">
                            <a href="/giai-phap-am-thanh" class="category-link">
                                <i class="fas fa-volume-up"></i>
                                <span>Giải pháp âm thanh</span>
                                <small>Thiết bị âm thanh</small>
                            </a>
                        </div>
                        <div class="category-item">
                            <a href="/giai-phap-anh-sang" class="category-link">
                                <i class="fas fa-lightbulb"></i>
                                <span>Giải pháp ánh sáng</span>
                                <small>Thiết bị ánh sáng</small>
                            </a>
                        </div>
                    </div>
                    
                    <!-- Right: Company Info -->
                    <div class="company-info">
                        <div class="company-item">
                            <a href="<?php echo esc_url(get_permalink(get_page_by_path('lien-he')) ?: home_url('/lien-he')); ?>" class="company-link">
                                <i class="fas fa-map-marker-alt"></i>
                                <span>Trụ sở & Chi nhánh</span>
                            </a>
                        </div>
                        <div class="company-item">
                            <a href="<?php echo esc_url(get_permalink(get_page_by_path('lien-he')) ?: home_url('/lien-he')); ?>" class="company-link">
                                <i class="fas fa-award"></i>
                                <span>Hồ sơ năng lực</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header><!-- #masthead -->

    <!-- Search Modal -->
    <div class="modal fade" id="searchModal" tabindex="-1" aria-labelledby="searchModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title" id="searchModalLabel">
                        <i class="fas fa-search text-primary me-2"></i>
                        Tìm kiếm sản phẩm
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body pt-0">
                    <div class="search-form-wrapper">
                        <?php get_search_form(); ?>
                    </div>
                    <div class="search-suggestions mt-3">
                        <small class="text-muted">Từ khóa phổ biến:</small>
                        <div class="mt-2">
                            <span class="badge bg-light text-dark me-2">Đèn LED</span>
                            <span class="badge bg-light text-dark me-2">Đèn pha</span>
                            <span class="badge bg-light text-dark me-2">Đèn đường</span>
                            <span class="badge bg-light text-dark">Đèn nhà xưởng</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Mobile Offcanvas Menu -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="mobileMenu" aria-labelledby="mobileMenuLabel">
        <div class="offcanvas-header border-bottom">
            <h5 class="offcanvas-title" id="mobileMenuLabel">
                <i class="fas fa-bars text-primary me-2"></i>
                Menu
            </h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body p-0">
            <?php
            wp_nav_menu(array(
                'theme_location' => 'primary',
                'menu_id'        => 'mobile-menu',
                'container'      => false,
                'menu_class'     => 'mobile-nav-menu list-unstyled mb-0',
                'fallback_cb'    => false,
                'walker'         => new Mobile_Walker_Nav_Menu(),
            ));
            ?>
            <div class="p-3 border-top mt-3">
                <a href="#contact-popup" class="btn btn-primary w-100 popup-trigger">
                    <i class="fas fa-paper-plane me-2"></i>
                    <?php esc_html_e('Nhận báo giá', 'tavaled-theme'); ?>
                </a>
            </div>
        </div>
    </div>
    
    <!-- Mobile Menu Overlay -->
    <div class="mobile-menu-overlay"></div>
    
    <!-- Mobile Menu -->
    <div class="mobile-menu">
        <div class="mobile-menu-header">
            <h3><?php esc_html_e('Menu', 'tavaled-theme'); ?></h3>
            <button class="mobile-menu-close">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="mobile-menu-content">
            <?php
            wp_nav_menu(array(
                'theme_location' => 'mobile',
                'menu_id'        => 'mobile-menu',
                'container'      => false,
                'fallback_cb'    => false,
            ));
            ?>
        </div>
    </div>
    
    <div id="content" class="site-content">