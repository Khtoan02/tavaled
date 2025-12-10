<?php
/**
 * Template Name: Trang Hệ Thống Âm Thanh
 * 
 * Template để hiển thị các sản phẩm có tag "hệ thống âm thanh" được nhóm theo danh mục
 *
 * @package TavaLED
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header();

// Lấy tag "hệ thống âm thanh"
$audio_tag = get_term_by('slug', 'he-thong-am-thanh', 'product_tag');
if (!$audio_tag) {
    $audio_tag = get_term_by('name', 'hệ thống âm thanh', 'product_tag');
}

$is_woocommerce_active = class_exists('WooCommerce');

// Load hàm render product card nếu chưa có
if (!function_exists('tavaled_render_wc_product_card')) {
    require_once get_template_directory() . '/inc/product-card-helper.php';
}

// Lấy tất cả các danh mục sản phẩm
$product_categories = $is_woocommerce_active ? get_terms(array(
    'taxonomy'   => 'product_cat',
    'hide_empty' => false,
    'orderby'    => 'menu_order',
    'order'      => 'ASC',
)) : array();

if (is_wp_error($product_categories)) {
    $product_categories = array();
}

// Lọc các danh mục có sản phẩm với tag "hệ thống âm thanh"
$categories_with_audio_products = array();
$total_audio_products = 0;

if ($audio_tag && $is_woocommerce_active) {
    foreach ($product_categories as $category) {
        // Lấy sản phẩm trong danh mục này có tag "hệ thống âm thanh"
        $audio_products_query = new WP_Query(array(
            'post_type'      => 'product',
            'posts_per_page' => -1,
            'post_status'    => 'publish',
            'tax_query'      => array(
                'relation' => 'AND',
                array(
                    'taxonomy' => 'product_cat',
                    'field'    => 'term_id',
                    'terms'    => $category->term_id,
                ),
                array(
                    'taxonomy' => 'product_tag',
                    'field'    => 'term_id',
                    'terms'    => $audio_tag->term_id,
                ),
            ),
        ));
        
        if ($audio_products_query->have_posts()) {
            $category->audio_product_count = $audio_products_query->found_posts;
            $categories_with_audio_products[] = $category;
            $total_audio_products += $category->audio_product_count;
            wp_reset_postdata();
        }
    }
}
?>

<div id="primary" class="content-area audio-system-page">
    <main id="main" class="site-main">

        <section class="audio-system-hero">
            <div class="container">
                <div class="audio-system-hero-grid">
                    <div class="audio-system-hero-content">
                        <p class="audio-system-eyebrow"><?php esc_html_e('Danh mục sản phẩm', 'tavaled-theme'); ?></p>
                        <h1 class="audio-system-title"><?php esc_html_e('Hệ Thống Âm Thanh', 'tavaled-theme'); ?></h1>
                        <p class="audio-system-lead">
                            <?php esc_html_e('Khám phá bộ sưu tập hệ thống âm thanh đa dạng với công nghệ tiên tiến, chất lượng cao và giải pháp lắp đặt chuyên nghiệp. Từ hệ thống âm thanh hội trường đến phòng họp, chúng tôi cung cấp giải pháp phù hợp cho mọi nhu cầu dự án của bạn.', 'tavaled-theme'); ?>
                        </p>

                        <div class="audio-system-metrics">
                            <div class="audio-system-metric-item">
                                <span class="audio-system-metric-number"><?php echo esc_html(count($categories_with_audio_products)); ?></span>
                                <span class="audio-system-metric-label"><?php esc_html_e('Danh mục', 'tavaled-theme'); ?></span>
                            </div>
                            <div class="audio-system-metric-item">
                                <span class="audio-system-metric-number"><?php echo esc_html($total_audio_products); ?></span>
                                <span class="audio-system-metric-label"><?php esc_html_e('Sản phẩm', 'tavaled-theme'); ?></span>
                            </div>
                            <div class="audio-system-metric-item">
                                <span class="audio-system-metric-number">24/7</span>
                                <span class="audio-system-metric-label"><?php esc_html_e('Hỗ trợ kỹ thuật', 'tavaled-theme'); ?></span>
                            </div>
                        </div>

                        <div class="audio-system-hero-actions">
                            <a href="#contact-popup" class="audio-system-btn-primary popup-trigger" data-source="<?php esc_attr_e('Báo giá - Trang Hệ Thống Âm Thanh', 'tavaled-theme'); ?>">
                                <i class="fas fa-headset"></i>
                                <span><?php esc_html_e('Nhận tư vấn & báo giá', 'tavaled-theme'); ?></span>
                            </a>
                            <a href="<?php echo esc_url(home_url('/lien-he')); ?>" class="audio-system-btn-secondary">
                                <i class="fas fa-phone"></i>
                                <span><?php esc_html_e('Liên hệ trực tiếp', 'tavaled-theme'); ?></span>
                            </a>
                        </div>
                    </div>

                    <div class="audio-system-hero-visual">
                        <div class="audio-system-highlight-card">
                            <p class="audio-system-highlight-eyebrow"><?php esc_html_e('Giải pháp Âm thanh', 'tavaled-theme'); ?></p>
                            <p class="audio-system-highlight-title"><?php esc_html_e('Tư vấn miễn phí cho từng dự án', 'tavaled-theme'); ?></p>
                            <ul class="audio-system-highlight-list">
                                <li><?php esc_html_e('Đề xuất cấu hình âm thanh phù hợp ngân sách', 'tavaled-theme'); ?></li>
                                <li><?php esc_html_e('Lộ trình triển khai & bảo hành minh bạch', 'tavaled-theme'); ?></li>
                                <li><?php esc_html_e('Báo giá trong 24 giờ làm việc', 'tavaled-theme'); ?></li>
                            </ul>
                            <div class="audio-system-highlight-meta">
                                <span><i class="fas fa-shield-alt"></i> <?php esc_html_e('Đối tác tin cậy của 500+ doanh nghiệp', 'tavaled-theme'); ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <?php if (!$is_woocommerce_active) : ?>
            <section class="audio-system-category-section">
                <div class="container">
                    <div class="audio-system-empty-state">
                        <div class="audio-system-empty-icon">
                            <i class="fas fa-info-circle"></i>
                        </div>
                        <div class="audio-system-empty-content">
                            <p class="audio-system-empty-heading"><?php esc_html_e('WooCommerce chưa được kích hoạt', 'tavaled-theme'); ?></p>
                            <p><?php esc_html_e('Vui lòng cài đặt và kích hoạt WooCommerce để quản lý sản phẩm.', 'tavaled-theme'); ?></p>
                        </div>
                    </div>
                </div>
            </section>
        <?php elseif (empty($categories_with_audio_products)) : ?>
            <section class="audio-system-category-section">
                <div class="container">
                    <div class="audio-system-empty-state">
                        <div class="audio-system-empty-icon">
                            <i class="fas fa-box-open"></i>
                        </div>
                        <div class="audio-system-empty-content">
                            <p class="audio-system-empty-heading"><?php esc_html_e('Chưa có sản phẩm hệ thống âm thanh', 'tavaled-theme'); ?></p>
                            <p><?php esc_html_e('Chúng tôi đang cập nhật thêm sản phẩm cho danh mục này. Vui lòng quay lại sau hoặc gửi yêu cầu báo giá để được tư vấn nhanh.', 'tavaled-theme'); ?></p>
                            <a href="#contact-popup" class="audio-system-btn-primary popup-trigger" data-source="<?php esc_attr_e('Danh mục trống - Hệ Thống Âm Thanh', 'tavaled-theme'); ?>">
                                <i class="fas fa-headset"></i>
                                <span><?php esc_html_e('Nhận tư vấn ngay', 'tavaled-theme'); ?></span>
                            </a>
                        </div>
                    </div>
                </div>
            </section>
        <?php else : ?>
            <?php
            $section_index = 0;
            foreach ($categories_with_audio_products as $category) :
                $section_index++;
                $section_id = 'audio-category-' . $category->slug;
                $category_desc = term_description($category) ?: __('Danh mục chưa có mô tả. Vui lòng cập nhật mô tả để hiển thị tại đây.', 'tavaled-theme');
                
                // Lấy sản phẩm trong danh mục này có tag "hệ thống âm thanh"
                $category_products = new WP_Query(array(
                    'post_type'      => 'product',
                    'posts_per_page' => 10,
                    'post_status'    => 'publish',
                    'tax_query'      => array(
                        'relation' => 'AND',
                        array(
                            'taxonomy' => 'product_cat',
                            'field'    => 'term_id',
                            'terms'    => $category->term_id,
                        ),
                        array(
                            'taxonomy' => 'product_tag',
                            'field'    => 'term_id',
                            'terms'    => $audio_tag->term_id,
                        ),
                    ),
                ));
                $has_products = $category_products->have_posts();
                ?>
                <section id="<?php echo esc_attr($section_id); ?>" class="audio-system-category-section">
                    <div class="container">
                        <div class="audio-system-section-header">
                            <div class="audio-system-section-title">
                                <p class="audio-system-section-eyebrow"><?php esc_html_e('Danh mục sản phẩm', 'tavaled-theme'); ?></p>
                                <p class="audio-system-section-heading"><?php echo esc_html($category->name); ?></p>
                                <div class="audio-system-section-description">
                                    <?php echo wp_kses_post(wpautop($category_desc)); ?>
                                </div>
                            </div>
                            <div class="audio-system-section-meta">
                                <span class="audio-system-meta-count">
                                    <i class="fas fa-layer-group"></i>
                                    <?php
                                    printf(
                                        esc_html__('%d sản phẩm', 'tavaled-theme'),
                                        (int) $category->audio_product_count
                                    );
                                    ?>
                                </span>
                                <a href="<?php echo esc_url(get_term_link($category)); ?>" class="audio-system-meta-link">
                                    <span><?php esc_html_e('Xem tất cả danh mục', 'tavaled-theme'); ?></span>
                                    <i class="fas fa-arrow-right"></i>
                                </a>
                            </div>
                        </div>

                        <?php if ($has_products) : ?>
                            <div class="audio-system-category-slider products-carousel active" data-carousel="<?php echo esc_attr($category->slug); ?>">
                                <div class="carousel-wrapper">
                                    <div class="carousel-container">
                                        <div class="audio-system-category-slider-track carousel-track">
                                            <?php
                                            while ($category_products->have_posts()) :
                                                $category_products->the_post();
                                                $product = wc_get_product(get_the_ID());
                                                if (!$product) {
                                                    continue;
                                                }
                                                echo tavaled_render_showcase_product_card($product);
                                            endwhile;
                                            ?>
                                        </div>
                                    </div>

                                    <button type="button" class="carousel-nav carousel-prev audio-system-slider-nav audio-system-slider-prev" aria-label="<?php esc_attr_e('Xem nhóm sản phẩm trước', 'tavaled-theme'); ?>">
                                        <i class="fas fa-chevron-left"></i>
                                    </button>
                                    <button type="button" class="carousel-nav carousel-next audio-system-slider-nav audio-system-slider-next" aria-label="<?php esc_attr_e('Xem nhóm sản phẩm tiếp theo', 'tavaled-theme'); ?>">
                                        <i class="fas fa-chevron-right"></i>
                                    </button>
                                </div>
                            </div>
                        <?php else : ?>
                            <div class="audio-system-empty-state">
                                <div class="audio-system-empty-icon">
                                    <i class="fas fa-box-open"></i>
                                </div>
                                <div class="audio-system-empty-content">
                                    <p class="audio-system-empty-heading"><?php esc_html_e('Danh mục chưa có sản phẩm', 'tavaled-theme'); ?></p>
                                    <p><?php esc_html_e('Chúng tôi đang cập nhật thêm sản phẩm cho danh mục này. Vui lòng quay lại sau hoặc gửi yêu cầu báo giá để được tư vấn nhanh.', 'tavaled-theme'); ?></p>
                                    <a href="#contact-popup" class="audio-system-btn-primary popup-trigger" data-source="<?php echo esc_attr(sprintf(__('Danh mục trống - %s', 'tavaled-theme'), $category->name)); ?>">
                                        <i class="fas fa-headset"></i>
                                        <span><?php esc_html_e('Nhận tư vấn ngay', 'tavaled-theme'); ?></span>
                                    </a>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </section>
                <?php
                wp_reset_postdata();
            endforeach;
            ?>
        <?php endif; ?>

        <section class="audio-system-cta">
            <div class="container">
                <div class="audio-system-cta-card">
                    <div class="audio-system-cta-content">
                        <p class="audio-system-cta-eyebrow"><?php esc_html_e('Cần tư vấn chuyên sâu?', 'tavaled-theme'); ?></p>
                        <p class="audio-system-cta-title"><?php esc_html_e('Đội ngũ kỹ thuật của TavaLED sẵn sàng hỗ trợ bạn 24/7', 'tavaled-theme'); ?></p>
                        <p><?php esc_html_e('Mô tả nhu cầu triển khai hệ thống âm thanh của bạn và chúng tôi sẽ gợi ý giải pháp cùng báo giá chi tiết trong vòng 24 giờ.', 'tavaled-theme'); ?></p>
                    </div>
                    <div class="audio-system-cta-actions">
                        <a href="#contact-popup" class="audio-system-btn-primary popup-trigger" data-source="<?php esc_attr_e('CTA cuối trang Hệ Thống Âm Thanh', 'tavaled-theme'); ?>">
                            <i class="fas fa-paper-plane"></i>
                            <span><?php esc_html_e('Gửi yêu cầu báo giá', 'tavaled-theme'); ?></span>
                        </a>
                        <a href="tel:<?php echo esc_attr(tavaled_format_phone(tavaled_get_primary_phone())); ?>" class="audio-system-btn-secondary">
                            <i class="fas fa-phone"></i>
                            <span><?php echo esc_html(tavaled_get_primary_phone()); ?></span>
                        </a>
                    </div>
                </div>
            </div>
        </section>

    </main><!-- #main -->
</div><!-- #primary -->

<?php
get_footer();

