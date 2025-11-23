<?php
/**
 * Helper function để render WooCommerce product card
 * 
 * @package TavaLED
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Render WooCommerce product card
 *
 * @param WC_Product $product
 * @param WP_Term|null $term
 * @return string
 */
if (!function_exists('tavaled_render_wc_product_card')) {
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

