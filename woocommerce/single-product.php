<?php
/**
 * WooCommerce Single Product Template (TavaLED minimal)
 *
 * @package TavaLED
 */

defined('ABSPATH') || exit;

// Load hàm render product card nếu chưa có
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

    // Breadcrumb đơn giản: Trang chủ > ... > Sản phẩm
    $breadcrumb_items = array(
        array(
            'label' => __('Trang chủ', 'tavaled-theme'),
            'url'   => home_url('/'),
        ),
    );

    if (!empty($product_categories) && !is_wp_error($product_categories)) {
        $sorted_terms = get_ancestors($product_categories[0]->term_id, 'product_cat');
        $sorted_terms = array_reverse($sorted_terms);
        $sorted_terms[] = $product_categories[0]->term_id;

        foreach ($sorted_terms as $term_id) {
            $term = get_term($term_id, 'product_cat');
            if ($term && !is_wp_error($term)) {
                $breadcrumb_items[] = array(
                    'label' => $term->name,
                    'url'   => get_term_link($term),
                );
            }
        }
    }

    $breadcrumb_items[] = array(
        'label' => get_the_title(),
        'url'   => '',
    );

    ob_start();
    woocommerce_template_single_add_to_cart();
    $add_to_cart_html = trim(ob_get_clean());
    ?>

    <article id="product-<?php the_ID(); ?>" <?php wc_product_class('tavaled-single-product minimal', $product); ?>>
        <section class="sp-hero">
            <div class="container">
                <div class="sp-hero-grid">
                    <div class="sp-gallery">
                        <?php do_action('woocommerce_before_single_product_summary'); ?>
                    </div>
                    <div class="sp-summary">
                        <?php if (!empty($breadcrumb_items)) : ?>
                            <nav class="sp-breadcrumb">
                                <?php foreach ($breadcrumb_items as $index => $item) : ?>
                                    <?php if (!empty($item['url']) && $index < count($breadcrumb_items) - 1) : ?>
                                        <a href="<?php echo esc_url($item['url']); ?>"><?php echo esc_html($item['label']); ?></a>
                                        <span>&rsaquo;</span>
                                    <?php else : ?>
                                        <span class="current"><?php echo esc_html($item['label']); ?></span>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </nav>
                        <?php endif; ?>

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

                        <div class="sp-price-highlight">
                            <div class="sp-price">
                                <?php woocommerce_template_single_price(); ?>
                            </div>
                            <div class="sp-service-badge">
                                <i class="fas fa-tools"></i>
                                <span><?php esc_html_e('Thi công lắp đặt toàn quốc', 'tavaled-theme'); ?></span>
                            </div>
                        </div>

                        <div class="sp-quick-support">
                            <?php if ($add_to_cart_html) : ?>
                                <div class="sp-buy-button">
                                    <?php echo $add_to_cart_html; ?>
                                </div>
                            <?php endif; ?>
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
                <div class="sp-content-wrapper">
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

        <?php
        // Lấy sản phẩm liên quan: ưu tiên cùng danh mục, sau đó bổ sung từ danh mục khác
        $related_ids = wc_get_related_products($product_id, 4);
        $target_count = 4; // Số lượng sản phẩm muốn hiển thị
        
        // Nếu không đủ sản phẩm cùng danh mục, lấy thêm từ danh mục khác
        if (count($related_ids) < $target_count) {
            $exclude_ids = array_merge(array($product_id), $related_ids);
            
            // Lấy thêm sản phẩm từ tất cả danh mục (trừ sản phẩm hiện tại và đã có)
            $additional_query = new WP_Query(array(
                'post_type'      => 'product',
                'post__not_in'   => $exclude_ids,
                'posts_per_page' => $target_count - count($related_ids),
                'orderby'        => array('menu_order' => 'ASC', 'date' => 'DESC'),
                'post_status'    => 'publish',
            ));
            
            if ($additional_query->have_posts()) {
                while ($additional_query->have_posts()) {
                    $additional_query->the_post();
                    $related_ids[] = get_the_ID();
                }
                wp_reset_postdata();
            }
        }
        
        // Giới hạn số lượng
        $related_ids = array_slice($related_ids, 0, $target_count);
        
        if (!empty($related_ids)) :
            $related_query = new WP_Query(array(
                'post_type'      => 'product',
                'post__in'       => $related_ids,
                'posts_per_page' => $target_count,
                'orderby'        => 'post__in',
            ));
            if ($related_query->have_posts()) :
                ?>
                <section class="sp-related">
                    <div class="container">
                        <div class="sp-related-header">
                            <p class="section-eyebrow"><?php esc_html_e('Sản phẩm tương tự', 'tavaled-theme'); ?></p>
                            <h2><?php esc_html_e('Có thể bạn sẽ quan tâm', 'tavaled-theme'); ?></h2>
                        </div>
                        <div class="sp-related-grid">
                            <?php
                            while ($related_query->have_posts()) :
                                $related_query->the_post();
                                $related_product = wc_get_product(get_the_ID());
                                if (!$related_product) {
                                    continue;
                                }
                                // Sử dụng hàm render card từ archive-product.php
                                echo tavaled_render_wc_product_card($related_product, null);
                            endwhile;
                            wp_reset_postdata();
                            ?>
                        </div>
                    </div>
                </section>
                <?php
            endif;
        endif;
        ?>

        <?php do_action('woocommerce_after_single_product'); ?>
    </article>

<?php endwhile; ?>

<?php
do_action('woocommerce_after_main_content');

get_footer();

