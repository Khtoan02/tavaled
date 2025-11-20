<?php
/**
 * WooCommerce Single Product Template (TavaLED minimal)
 *
 * @package TavaLED
 */

defined('ABSPATH') || exit;

get_header();

do_action('woocommerce_before_main_content');

while (have_posts()) :
    the_post();
    global $product;

    if (!$product instanceof WC_Product) {
        continue;
    }

    if (post_password_required()) {
        echo get_the_password_form();
        continue;
    }

    $product_id   = $product->get_id();
    $contact_phone = tavaled_get_option('phone_number', '096 123 4567');
    
    // Lấy tên danh mục đầu tiên
    $product_categories = wp_get_post_terms($product_id, 'product_cat', array('orderby' => 'term_order', 'number' => 1));
    $category_name = !empty($product_categories) && !is_wp_error($product_categories) ? $product_categories[0]->name : '';
    ?>

    <article id="product-<?php the_ID(); ?>" <?php wc_product_class('tavaled-single-product minimal', $product); ?>>
        <section class="sp-hero">
            <div class="container">
                <div class="sp-hero-grid">
                    <div class="sp-gallery">
                        <?php do_action('woocommerce_before_single_product_summary'); ?>
                    </div>
                    <div class="sp-summary">
                        <?php if ($category_name) : ?>
                            <p class="section-eyebrow"><?php echo esc_html($category_name); ?></p>
                        <?php endif; ?>
                        <h1 class="sp-title"><?php the_title(); ?></h1>

                        <div class="sp-rating">
                            <?php woocommerce_template_single_rating(); ?>
                        </div>

                        <div class="sp-excerpt">
                            <?php woocommerce_template_single_excerpt(); ?>
                        </div>

                        <div class="sp-quick-support">
                            <a class="btn-primary popup-trigger"
                               href="#contact-popup"
                               data-source="<?php echo esc_attr(sprintf(__('Quan tâm sản phẩm - %s', 'tavaled-theme'), get_the_title())); ?>">
                                <i class="fas fa-paper-plane"></i>
                                <span><?php esc_html_e('Nhận tư vấn nhanh', 'tavaled-theme'); ?></span>
                            </a>
                            <a class="btn-secondary" href="tel:<?php echo esc_attr(tavaled_format_phone($contact_phone)); ?>">
                                <i class="fas fa-phone"></i>
                                <span><?php echo esc_html($contact_phone); ?></span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="sp-content">
            <div class="container">
                <div class="sp-card">
                    <?php the_content(); ?>
                </div>
            </div>
        </section>

        <section class="sp-cta">
            <div class="container">
                <div class="sp-cta-card sp-card">
                    <div>
                        <p class="section-eyebrow"><?php esc_html_e('Cần báo giá?', 'tavaled-theme'); ?></p>
                        <h2><?php esc_html_e('Chia sẻ dự án, nhận tư vấn trong 24h', 'tavaled-theme'); ?></h2>
                        <p><?php esc_html_e('Đội ngũ TavaLED đồng hành cùng bạn trong toàn bộ hành trình thiết kế, lắp đặt và bảo trì màn hình LED.', 'tavaled-theme'); ?></p>
                    </div>
                    <div class="sp-cta-actions">
                        <a class="btn-primary popup-trigger"
                           href="#contact-popup"
                           data-source="<?php echo esc_attr(sprintf(__('CTA single product - %s', 'tavaled-theme'), get_the_title())); ?>">
                            <i class="fas fa-envelope-open-text"></i>
                            <span><?php esc_html_e('Gửi yêu cầu', 'tavaled-theme'); ?></span>
                        </a>
                        <a class="btn-outline" href="mailto:<?php echo esc_attr(tavaled_get_option('email', 'hello@tavaled.vn')); ?>">
                            <i class="fas fa-at"></i>
                            <span><?php esc_html_e('Email cho chúng tôi', 'tavaled-theme'); ?></span>
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <section class="sp-related">
            <div class="container">
                <div class="sp-related-header">
                    <p class="section-eyebrow"><?php esc_html_e('Sản phẩm tương tự', 'tavaled-theme'); ?></p>
                    <h2><?php esc_html_e('Có thể bạn sẽ quan tâm', 'tavaled-theme'); ?></h2>
                </div>
                <?php woocommerce_output_related_products(array('posts_per_page' => 4)); ?>
            </div>
        </section>

        <?php do_action('woocommerce_after_single_product'); ?>
    </article>

<?php endwhile; ?>

<?php
do_action('woocommerce_after_main_content');

get_footer();

