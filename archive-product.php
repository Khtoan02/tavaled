<?php
/**
 * WooCommerce Product Archive Template
 *
 * Hiển thị các danh mục WooCommerce như những section độc lập với slider sản phẩm.
 *
 * @package TavaLED
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header();

$is_woocommerce_active = class_exists('WooCommerce');
$product_stats = wp_count_posts('product');
$total_products = isset($product_stats->publish) ? (int) $product_stats->publish : 0;
$total_categories = (int) wp_count_terms(array(
    'taxonomy'   => 'product_cat',
    'hide_empty' => true,
));

$product_categories = $is_woocommerce_active ? get_terms(array(
    'taxonomy'   => 'product_cat',
    'hide_empty' => true,
    'orderby'    => 'menu_order',
    'order'      => 'ASC',
)) : array();

if (is_wp_error($product_categories)) {
    $product_categories = array();
}

if (!function_exists('tavaled_render_wc_product_card')) {
    /**
     * Render WooCommerce product card for archive sections
     *
     * @param WC_Product $product
     * @param WP_Term|null $term
     * @return string
     */
    function tavaled_render_wc_product_card($product, $term = null) {
        if (!$product instanceof WC_Product) {
            return '';
        }

        $product_id    = $product->get_id();
        $term_name     = $term instanceof WP_Term ? $term->name : '';
        $term_slug     = $term instanceof WP_Term ? $term->slug : '';
        $product_link  = $product->get_permalink();
        $product_title = $product->get_name();
        $category_terms = wp_get_post_terms($product_id, 'product_cat');
        $category_name  = (!empty($category_terms) && !is_wp_error($category_terms)) ? $category_terms[0]->name : '';
        $excerpt        = wp_trim_words($product->get_short_description() ?: $product->get_description(), 18);

        $image_id  = $product->get_image_id();
        $image_tag = $image_id
            ? wp_get_attachment_image($image_id, 'product-thumb', false, array('class' => 'card-image'))
            : sprintf(
                '<img src="%1$s" alt="%2$s" class="card-image placeholder-image" />',
                esc_url(get_template_directory_uri() . '/assets/images/product-placeholder.jpg'),
                esc_attr($product_title)
            );

        $badge_label = '';
        if ($product->is_featured()) {
            $badge_label = esc_html__('Nổi bật', 'tavaled-theme');
        } elseif ($product->is_on_sale()) {
            $badge_label = esc_html__('Giảm giá', 'tavaled-theme');
        } elseif ($product->get_date_created() && $product->get_date_created()->getTimestamp() >= strtotime('-30 days')) {
            $badge_label = esc_html__('Mới', 'tavaled-theme');
        }

        $quote_source = $term_name
            ? sprintf(__('Nhận báo giá - %s', 'tavaled-theme'), $term_name)
            : sprintf(__('Nhận báo giá - %s', 'tavaled-theme'), $product_title);

        ob_start();
        ?>
        <article class="category-product-card glass-card" data-category="<?php echo esc_attr($term_slug); ?>">
            <div class="card-media">
                <a href="<?php echo esc_url($product_link); ?>">
                    <?php echo $image_tag; ?>
                </a>
                <?php if ($badge_label) : ?>
                    <span class="card-badge"><?php echo esc_html($badge_label); ?></span>
                <?php endif; ?>
            </div>

            <div class="card-body">
                <?php if ($category_name) : ?>
                    <p class="card-eyebrow"><?php echo esc_html($category_name); ?></p>
                <?php endif; ?>

                <p class="card-title">
                    <a href="<?php echo esc_url($product_link); ?>"><?php echo esc_html($product_title); ?></a>
                </p>

                <p class="card-excerpt"><?php echo esc_html($excerpt); ?></p>

                <div class="card-actions">
                    <a href="<?php echo esc_url($product_link); ?>" class="btn-view-product">
                        <span><?php esc_html_e('Xem chi tiết', 'tavaled-theme'); ?></span>
                        <i class="fas fa-arrow-right"></i>
                    </a>
                    <a href="#contact-popup"
                       class="btn-quote popup-trigger"
                       data-source="<?php echo esc_attr($quote_source); ?>"
                       data-product-id="<?php echo esc_attr($product_id); ?>"
                       data-product-name="<?php echo esc_attr($product_title); ?>"
                       data-category-name="<?php echo esc_attr($term_name); ?>">
                        <i class="fas fa-calculator"></i>
                        <span><?php esc_html_e('Nhận báo giá', 'tavaled-theme'); ?></span>
                    </a>
                </div>
            </div>
        </article>
        <?php
        return ob_get_clean();
    }
}
?>

<div id="primary" class="content-area products-archive-page">
    <main id="main" class="site-main">

        <section class="products-archive-hero">
            <div class="container">
        <div class="products-hero-grid">
            <div class="products-hero-content">
                <p class="archive-eyebrow"><?php esc_html_e('Danh mục sản phẩm', 'tavaled-theme'); ?></p>
                <p class="archive-title"><?php woocommerce_page_title(); ?></p>
                <p class="hero-lead">
                    <?php esc_html_e('Trải nghiệm kho giải pháp LED được chuẩn hoá theo nhu cầu dự án, đồng bộ trực tiếp từ WooCommerce và sẵn sàng cho mọi yêu cầu báo giá.', 'tavaled-theme'); ?>
                </p>

                <div class="hero-metrics">
                    <div class="metric-item">
                        <span class="metric-number"><?php echo esc_html(number_format_i18n($total_categories)); ?></span>
                        <span class="metric-label"><?php esc_html_e('Danh mục chuyên sâu', 'tavaled-theme'); ?></span>
                    </div>
                    <div class="metric-item">
                        <span class="metric-number"><?php echo esc_html(number_format_i18n($total_products)); ?></span>
                        <span class="metric-label"><?php esc_html_e('Sản phẩm đang triển khai', 'tavaled-theme'); ?></span>
                    </div>
                    <div class="metric-item">
                        <span class="metric-number">24/7</span>
                        <span class="metric-label"><?php esc_html_e('Hỗ trợ kỹ thuật', 'tavaled-theme'); ?></span>
                    </div>
                </div>

                <div class="hero-actions">
                    <a href="#contact-popup" class="btn-primary popup-trigger" data-source="<?php esc_attr_e('Báo giá - Trang sản phẩm', 'tavaled-theme'); ?>">
                        <i class="fas fa-headset"></i>
                        <span><?php esc_html_e('Nhận tư vấn & báo giá', 'tavaled-theme'); ?></span>
                    </a>
                    <a href="<?php echo esc_url(home_url('/lien-he')); ?>" class="btn-secondary">
                        <i class="fas fa-phone"></i>
                        <span><?php esc_html_e('Liên hệ trực tiếp', 'tavaled-theme'); ?></span>
                    </a>
                </div>
            </div>

            <div class="products-hero-visual">
                <div class="hero-highlight-card glass-card">
                    <p class="highlight-eyebrow"><?php esc_html_e('Tối ưu dự án', 'tavaled-theme'); ?></p>
                    <p class="highlight-title"><?php esc_html_e('Tư vấn miễn phí cho từng ngành hàng', 'tavaled-theme'); ?></p>
                    <ul class="highlight-list">
                        <li><?php esc_html_e('Đề xuất cấu hình LED phù hợp ngân sách', 'tavaled-theme'); ?></li>
                        <li><?php esc_html_e('Lộ trình triển khai & bảo hành minh bạch', 'tavaled-theme'); ?></li>
                        <li><?php esc_html_e('Báo giá trong 24 giờ làm việc', 'tavaled-theme'); ?></li>
                    </ul>
                    <div class="highlight-meta">
                        <span><i class="fas fa-shield-alt"></i> <?php esc_html_e('Đối tác tin cậy của 500+ doanh nghiệp', 'tavaled-theme'); ?></span>
                    </div>
                </div>
            </div>
        </div>
            </div>
        </section>

        <?php if (!$is_woocommerce_active) : ?>
            <section class="product-category-section">
                <div class="container">
                    <div class="category-empty-state glass-card">
                        <div class="empty-icon">
                            <i class="fas fa-info-circle"></i>
                        </div>
                        <div class="empty-content">
                            <p class="section-heading"><?php esc_html_e('WooCommerce chưa được kích hoạt', 'tavaled-theme'); ?></p>
                            <p><?php esc_html_e('Vui lòng cài đặt và kích hoạt WooCommerce để quản lý sản phẩm.', 'tavaled-theme'); ?></p>
                        </div>
                    </div>
                </div>
            </section>
        <?php else : ?>
            <?php
            if (!empty($product_categories)) :
                $section_index = 0;
                foreach ($product_categories as $category) :
                    $section_index++;
                    $section_id        = 'category-' . $category->slug;
                    $category_desc     = term_description($category) ?: __('Danh mục chưa có mô tả. Vui lòng cập nhật mô tả để hiển thị tại đây.', 'tavaled-theme');
                    $category_products = new WP_Query(array(
                        'post_type'      => 'product',
                        'posts_per_page' => 10,
                        'post_status'    => 'publish',
                        'tax_query'      => array(
                            array(
                                'taxonomy' => 'product_cat',
                                'field'    => 'term_id',
                                'terms'    => $category->term_id,
                            ),
                        ),
                    ));
                    $has_products = $category_products->have_posts();
                    ?>
                    <section id="<?php echo esc_attr($section_id); ?>" class="product-category-section">
                        <div class="container">
                            <div class="section-header">
                                <div class="section-title">
                                    <p class="section-eyebrow"><?php esc_html_e('Danh mục sản phẩm', 'tavaled-theme'); ?></p>
                                    <p class="section-heading"><?php echo esc_html($category->name); ?></p>
                                    <div class="section-description">
                                        <?php echo wp_kses_post(wpautop($category_desc)); ?>
                                    </div>
                                </div>
                                <div class="section-meta">
                                    <span class="meta-count">
                                        <i class="fas fa-layer-group"></i>
                                        <?php
                                        printf(
                                            esc_html__('%d sản phẩm', 'tavaled-theme'),
                                            (int) $category->count
                                        );
                                        ?>
                                    </span>
                                    <a href="<?php echo esc_url(get_term_link($category)); ?>" class="meta-link">
                                        <span><?php esc_html_e('Xem tất cả danh mục', 'tavaled-theme'); ?></span>
                                        <i class="fas fa-arrow-right"></i>
                                    </a>
                                </div>
                            </div>

                            <?php if ($has_products) : ?>
                                <div class="category-slider" data-slider="<?php echo esc_attr($category->slug); ?>">
                                    <div class="category-slider-track">
                                        <?php
                                        while ($category_products->have_posts()) :
                                            $category_products->the_post();
                                            $product = wc_get_product(get_the_ID());
                                            if (!$product) {
                                                continue;
                                            }
                                            echo tavaled_render_wc_product_card($product, $category);
                                        endwhile;
                                        ?>
                                    </div>
                                    <button type="button" class="category-slider-nav prev" aria-label="<?php esc_attr_e('Xem nhóm sản phẩm trước', 'tavaled-theme'); ?>">
                                        <i class="fas fa-chevron-left"></i>
                                    </button>
                                    <button type="button" class="category-slider-nav next" aria-label="<?php esc_attr_e('Xem nhóm sản phẩm tiếp theo', 'tavaled-theme'); ?>">
                                        <i class="fas fa-chevron-right"></i>
                                    </button>
                                </div>
                            <?php else : ?>
                                <div class="category-empty-state glass-card">
                                    <div class="empty-icon">
                                        <i class="fas fa-box-open"></i>
                                    </div>
                                    <div class="empty-content">
                                        <p class="section-heading"><?php esc_html_e('Danh mục chưa có sản phẩm', 'tavaled-theme'); ?></p>
                                        <p><?php esc_html_e('Chúng tôi đang cập nhật thêm sản phẩm cho danh mục này. Vui lòng quay lại sau hoặc gửi yêu cầu báo giá để được tư vấn nhanh.', 'tavaled-theme'); ?></p>
                                        <a href="#contact-popup" class="btn-primary popup-trigger" data-source="<?php echo esc_attr(sprintf(__('Danh mục trống - %s', 'tavaled-theme'), $category->name)); ?>">
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
            else :
                ?>
                <section class="product-category-section">
                    <div class="container">
                        <div class="category-empty-state glass-card">
                            <div class="empty-icon">
                                <i class="fas fa-info-circle"></i>
                            </div>
                            <div class="empty-content">
                                <p class="section-heading"><?php esc_html_e('Chưa có danh mục sản phẩm', 'tavaled-theme'); ?></p>
                                <p><?php esc_html_e('Vui lòng tạo danh mục WooCommerce để hiển thị nội dung tại đây.', 'tavaled-theme'); ?></p>
                            </div>
                        </div>
                    </div>
                </section>
                <?php
            endif;
        endif; ?>

        <section class="products-archive-cta">
            <div class="container">
                <div class="cta-card glass-card">
                    <div class="cta-content">
                        <p class="cta-eyebrow"><?php esc_html_e('Cần tư vấn chuyên sâu?', 'tavaled-theme'); ?></p>
                        <p class="cta-title"><?php esc_html_e('Đội ngũ kỹ thuật của TavaLED sẵn sàng hỗ trợ bạn 24/7', 'tavaled-theme'); ?></p>
                        <p><?php esc_html_e('Mô tả nhu cầu triển khai màn hình LED của bạn và chúng tôi sẽ gợi ý giải pháp cùng báo giá chi tiết trong vòng 24 giờ.', 'tavaled-theme'); ?></p>
                    </div>
                    <div class="cta-actions">
                        <a href="#contact-popup" class="btn-primary popup-trigger" data-source="<?php esc_attr_e('CTA cuối trang sản phẩm', 'tavaled-theme'); ?>">
                            <i class="fas fa-paper-plane"></i>
                            <span><?php esc_html_e('Gửi yêu cầu báo giá', 'tavaled-theme'); ?></span>
                        </a>
                        <a href="tel:<?php echo esc_attr(tavaled_format_phone(tavaled_get_option('phone_number', '0123456789'))); ?>" class="btn-secondary">
                            <i class="fas fa-phone"></i>
                            <span><?php echo esc_html(tavaled_get_option('phone_number', '0123 456 789')); ?></span>
                        </a>
                    </div>
                </div>
            </div>
        </section>

    </main><!-- #main -->
</div><!-- #primary -->

<?php
get_footer();

