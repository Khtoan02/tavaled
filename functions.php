<?php
/**
 * TavaLED Theme Functions
 *
 * @package TavaLED
 * @since 1.0.0
 */

// Ngăn truy cập trực tiếp
if (!defined('ABSPATH')) {
    exit;
}

// Định nghĩa các hằng số
define('TAVALED_THEME_VERSION', '1.0.0');
define('TAVALED_THEME_DIR', get_template_directory());
define('TAVALED_THEME_URI', get_template_directory_uri());

// Include các file chức năng
require_once TAVALED_THEME_DIR . '/inc/theme-setup.php';
require_once TAVALED_THEME_DIR . '/inc/enqueue.php';
require_once TAVALED_THEME_DIR . '/inc/custom-post-types.php';
require_once TAVALED_THEME_DIR . '/inc/consultation-manager.php';
require_once TAVALED_THEME_DIR . '/inc/custom-taxonomies.php';
require_once TAVALED_THEME_DIR . '/inc/woocommerce-sample-data.php';
require_once TAVALED_THEME_DIR . '/inc/helpers.php';
require_once TAVALED_THEME_DIR . '/inc/acf-blog-cta-fields.php';

/**
 * Đảm bảo WooCommerce có trang cửa hàng sử dụng slug /san-pham
 */
function tavaled_ensure_woocommerce_shop_page() {
    if (!class_exists('WooCommerce')) {
        return;
    }

    // Tránh chạy trong AJAX admin để không gây chậm
    if (is_admin() && wp_doing_ajax()) {
        return;
    }

    $desired_slug    = 'san-pham';
    $desired_title   = __('Sản phẩm', 'tavaled-theme');
    $needs_flush     = false;
    $shop_page_id    = wc_get_page_id('shop');
    $shop_page_post  = ($shop_page_id && $shop_page_id > 0) ? get_post($shop_page_id) : null;

    // Nếu trang cửa hàng không tồn tại hoặc đang trong thùng rác, tạo / dùng trang mới
    if (!$shop_page_post || 'trash' === $shop_page_post->post_status) {
        $existing_page = get_page_by_path($desired_slug);

        if ($existing_page && 'trash' !== $existing_page->post_status) {
            $shop_page_id   = $existing_page->ID;
            $shop_page_post = $existing_page;
        } else {
            $shop_page_id = wp_insert_post(array(
                'post_title'   => $desired_title,
                'post_name'    => $desired_slug,
                'post_status'  => 'publish',
                'post_type'    => 'page',
                'post_content' => '',
            ));

            if (is_wp_error($shop_page_id)) {
                return;
            }

            $shop_page_post = get_post($shop_page_id);
            $needs_flush    = true;
        }
    }

    if (!$shop_page_post) {
        return;
    }

    // Đảm bảo trang được gán làm WooCommerce shop page
    if ((int) get_option('woocommerce_shop_page_id') !== (int) $shop_page_id) {
        update_option('woocommerce_shop_page_id', (int) $shop_page_id);
        $needs_flush = true;
    }

    // Đảm bảo trạng thái publish
    if ('publish' !== $shop_page_post->post_status) {
        wp_update_post(array(
            'ID'          => $shop_page_id,
            'post_status' => 'publish',
        ));
    }

    // Ép slug là /san-pham để khớp URL mong muốn
    if ($shop_page_post->post_name !== $desired_slug) {
        wp_update_post(array(
            'ID'       => $shop_page_id,
            'post_name'=> $desired_slug,
        ));
        $needs_flush = true;
    }

    if ($needs_flush) {
        flush_rewrite_rules(false);
    }
}
add_action('init', 'tavaled_ensure_woocommerce_shop_page', 20);

// Kích hoạt theme
add_action('after_setup_theme', 'tavaled_theme_setup');

/**
 * Remove WooCommerce breadcrumb globally (đã thiết kế lại custom)
 */
function tavaled_disable_wc_breadcrumb() {
    remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20);
}
add_action('init', 'tavaled_disable_wc_breadcrumb', 20);

// Enqueue scripts và styles
add_action('wp_enqueue_scripts', 'tavaled_enqueue_scripts');

// Đăng ký Custom Post Types
add_action('init', 'tavaled_register_post_types');

// Đăng ký Custom Taxonomies
add_action('init', 'tavaled_register_taxonomies');

// Đăng ký widget areas
add_action('widgets_init', 'tavaled_widgets_init');
function tavaled_widgets_init() {
    // Sidebar chính
    register_sidebar(array(
        'name'          => __('Sidebar', 'tavaled-theme'),
        'id'            => 'sidebar-1',
        'description'   => __('Add widgets here.', 'tavaled-theme'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));

    // Footer widgets
    for ($i = 1; $i <= 4; $i++) {
        register_sidebar(array(
            'name'          => sprintf(__('Footer %d', 'tavaled-theme'), $i),
            'id'            => 'footer-' . $i,
            'description'   => __('Add widgets here.', 'tavaled-theme'),
            'before_widget' => '<div id="%1$s" class="footer-widget %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h3 class="widget-title">',
            'after_title'   => '</h3>',
        ));
    }
}

// Custom excerpt length
add_filter('excerpt_length', 'tavaled_excerpt_length');
function tavaled_excerpt_length($length) {
    return 20;
}

// Custom excerpt more
add_filter('excerpt_more', 'tavaled_excerpt_more');
function tavaled_excerpt_more($more) {
    return '...';
}

// Add body classes
add_filter('body_class', 'tavaled_body_classes');
function tavaled_body_classes($classes) {
    // Add page slug if it doesn't exist
    if (is_single() || is_page() && !is_front_page()) {
        if (!in_array(basename(get_permalink()), $classes)) {
            $classes[] = basename(get_permalink());
        }
    }
    
    // Add class if sidebar is active
    if (is_active_sidebar('sidebar-1')) {
        $classes[] = 'has-sidebar';
    }
    
    return $classes;
}

// Custom logo support
add_theme_support('custom-logo', array(
    'height'      => 100,
    'width'       => 400,
    'flex-height' => true,
    'flex-width'  => true,
    'header-text' => array('site-title', 'site-description'),
));

// Add theme support for selective refresh for widgets
add_theme_support('customize-selective-refresh-widgets');

// Add support for responsive embeds
add_theme_support('responsive-embeds');

// Add support for editor styles
add_theme_support('editor-styles');

// Add support for block styles
add_theme_support('wp-block-styles');

// Add support for wide alignment
add_theme_support('align-wide');

// Remove WordPress version from RSS feeds
add_filter('the_generator', '__return_empty_string');

// Disable WordPress emoji
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');
remove_action('admin_print_scripts', 'print_emoji_detection_script');
remove_action('admin_print_styles', 'print_emoji_styles');

// Custom pagination
function tavaled_pagination($query = null, $args = array()) {
    if (!$query instanceof WP_Query) {
        global $wp_query;
        $query = $wp_query;
    }

    if (!$query instanceof WP_Query || $query->max_num_pages <= 1) {
        return;
    }

    $defaults = array(
        'prev_text'     => __('&laquo; Trước', 'tavaled-theme'),
        'next_text'     => __('Sau &raquo;', 'tavaled-theme'),
        'wrapper_class' => 'pagination-wrapper',
        'list_class'    => 'pagination-list',
        'item_class'    => 'pagination-item',
        'end_size'      => 2,
        'mid_size'      => 1,
    );

    $args = wp_parse_args($args, $defaults);

    $current_page = $query->get('paged') ? (int) $query->get('paged') : (int) get_query_var('paged');
    if ($current_page < 1) {
        $current_page = 1;
    }

    $big = 999999999;
    $paginate_links = paginate_links(array(
        'base'      => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
        'format'    => '?paged=%#%',
        'current'   => $current_page,
        'total'     => (int) $query->max_num_pages,
        'prev_text' => $args['prev_text'],
        'next_text' => $args['next_text'],
        'type'      => 'array',
        'end_size'  => (int) $args['end_size'],
        'mid_size'  => (int) $args['mid_size'],
    ));

    if (!$paginate_links) {
        return;
    }

    echo '<nav class="' . esc_attr($args['wrapper_class']) . '">';
    echo '<ul class="' . esc_attr($args['list_class']) . '">';
    foreach ($paginate_links as $link) {
        echo '<li class="' . esc_attr($args['item_class']) . '">' . $link . '</li>';
    }
    echo '</ul>';
    echo '</nav>';
}

// Custom search form
add_filter('get_search_form', 'tavaled_search_form');
function tavaled_search_form($form) {
    $form = '<form role="search" method="get" class="search-form" action="' . home_url('/') . '">
        <label>
            <span class="screen-reader-text">' . _x('Search for:', 'label', 'tavaled-theme') . '</span>
            <input type="search" class="search-field" placeholder="' . esc_attr_x('Search &hellip;', 'placeholder', 'tavaled-theme') . '" value="' . get_search_query() . '" name="s" />
        </label>
        <button type="submit" class="search-submit glass-button">
            <span class="screen-reader-text">' . _x('Search', 'submit button', 'tavaled-theme') . '</span>
            <i class="fas fa-search"></i>
        </button>
    </form>';
    
    return $form;
}

// Add custom image sizes
add_action('after_setup_theme', 'tavaled_custom_image_sizes');
function tavaled_custom_image_sizes() {
    add_image_size('product-thumb', 400, 400, true);
    add_image_size('product-large', 800, 800, true);
    add_image_size('blog-thumb', 600, 400, true);
    add_image_size('project-thumb', 600, 450, true);
    add_image_size('banner', 1920, 600, true);
}

// Register custom menus locations
function tavaled_register_menus() {
    register_nav_menus(array(
        'primary'   => __('Primary Menu', 'tavaled-theme'),
        'footer'    => __('Footer Menu', 'tavaled-theme'),
        'mobile'    => __('Mobile Menu', 'tavaled-theme'),
        'top-bar'   => __('Top Bar Menu', 'tavaled-theme'),
    ));
}
add_action('init', 'tavaled_register_menus');

// Force blog listings to 9 posts per page
function tavaled_adjust_posts_per_page($query) {
    if (is_admin() || !$query->is_main_query()) {
        return;
    }

    if ($query->is_home() || $query->is_category() || $query->is_tag() || ($query->is_archive() && !$query->is_post_type_archive())) {
        $query->set('posts_per_page', 9);
        $query->set('post_type', 'post');
    }
}
add_action('pre_get_posts', 'tavaled_adjust_posts_per_page');

// Add ACF options page (if ACF is active)
if (function_exists('acf_add_options_page')) {
    acf_add_options_page(array(
        'page_title' => 'Theme Settings',
        'menu_title' => 'Theme Settings',
        'menu_slug'  => 'theme-settings',
        'capability' => 'edit_posts',
        'redirect'   => false
    ));
    
    acf_add_options_sub_page(array(
        'page_title'  => 'Header Settings',
        'menu_title'  => 'Header',
        'parent_slug' => 'theme-settings',
    ));
    
    acf_add_options_sub_page(array(
        'page_title'  => 'Footer Settings',
        'menu_title'  => 'Footer',
        'parent_slug' => 'theme-settings',
    ));
    
    acf_add_options_sub_page(array(
        'page_title'  => 'Blog CTA Settings',
        'menu_title'  => 'Blog CTA',
        'menu_slug'   => 'blog-cta-settings',
        'parent_slug' => 'theme-settings',
    ));
}

// AJAX Handler for Contact Form
add_action('wp_ajax_tavaled_contact_form', 'tavaled_handle_contact_form');
add_action('wp_ajax_nopriv_tavaled_contact_form', 'tavaled_handle_contact_form');

function tavaled_handle_contact_form() {
    // Verify nonce
    if (!isset($_POST['contact_nonce']) || !wp_verify_nonce($_POST['contact_nonce'], 'tavaled_contact_nonce')) {
        wp_send_json_error(array('message' => 'Bảo mật không hợp lệ.'));
    }
    
    // Get form data
    $name = sanitize_text_field($_POST['name'] ?? '');
    $phone = sanitize_text_field($_POST['phone'] ?? '');
    $email = isset($_POST['email']) ? sanitize_email($_POST['email']) : '';
    $subject = isset($_POST['subject']) ? sanitize_text_field($_POST['subject']) : '';
    $message_content = isset($_POST['message']) ? sanitize_textarea_field($_POST['message']) : '';
    
    // Validate required fields
    if (empty($name) || empty($phone)) {
        wp_send_json_error(array('message' => 'Vui lòng điền đầy đủ thông tin.'));
    }
    
    // Validate phone number (basic)
    if (!preg_match('/^[0-9\s\-\+\(\)]+$/', $phone)) {
        wp_send_json_error(array('message' => 'Số điện thoại không hợp lệ.'));
    }
    
    // Get source and product info (where the form was submitted from)
    $source = isset($_POST['source']) ? sanitize_text_field($_POST['source']) : 'Contact Popup';
    $product_id = isset($_POST['product_id']) ? absint($_POST['product_id']) : 0;
    $product_name = isset($_POST['product_name']) ? sanitize_text_field($_POST['product_name']) : '';
    $category_name = isset($_POST['category_name']) ? sanitize_text_field($_POST['category_name']) : '';
    $referer = isset($_SERVER['HTTP_REFERER']) ? esc_url_raw($_SERVER['HTTP_REFERER']) : '';
    
    // Try to detect page from referer if source is generic
    if (empty($source) || $source === 'Contact Popup') {
        if (strpos($referer, home_url()) !== false) {
            $parsed_url = parse_url($referer);
            $path = isset($parsed_url['path']) ? trim($parsed_url['path'], '/') : '';
            
            if (empty($path) || $path === '') {
                $source = 'Contact Popup - Homepage';
            } elseif (strpos($path, 'san-pham') !== false) {
                $source = 'Contact Popup - Product Page';
            } elseif (strpos($path, 'du-an') !== false) {
                $source = 'Contact Popup - Project Page';
            } elseif (strpos($path, 'giai-phap') !== false) {
                $source = 'Contact Popup - Solution Page';
            } else {
                $source = 'Contact Popup - ' . $path;
            }
        } else {
            $source = 'Contact Popup - External';
        }
    }
    
    // Create consultation post
    $title = 'Tư vấn - ' . $name . ' - ' . $phone;
    if (!empty($subject)) {
        $title .= ' - ' . $subject;
    }
    $title .= ' - ' . current_time('d/m/Y H:i');
    
    $consultation_data = array(
        'post_title'    => $title,
        'post_content'  => !empty($message_content) ? $message_content : '',
        'post_status'   => 'publish',
        'post_type'     => 'tavaled_consultation',
    );
    
    $consultation_id = wp_insert_post($consultation_data);
    
    if (is_wp_error($consultation_id)) {
        wp_send_json_error(array('message' => 'Có lỗi xảy ra khi lưu thông tin. Vui lòng thử lại.'));
    }
    
    // Save meta data
    update_post_meta($consultation_id, '_consultation_name', $name);
    update_post_meta($consultation_id, '_consultation_phone', $phone);
    if (!empty($email)) {
        update_post_meta($consultation_id, '_consultation_email', $email);
    }
    if (!empty($subject)) {
        update_post_meta($consultation_id, '_consultation_subject', $subject);
    }
    update_post_meta($consultation_id, '_consultation_source', $source);
    update_post_meta($consultation_id, '_consultation_referer', $referer);
    update_post_meta($consultation_id, '_consultation_date', current_time('mysql'));
    update_post_meta($consultation_id, '_consultation_status', 'new');
    update_post_meta($consultation_id, '_consultation_type', 'contact_form');
    
    // Save product information if available
    if ($product_id > 0) {
        update_post_meta($consultation_id, '_consultation_product_id', $product_id);
    }
    if (!empty($product_name)) {
        update_post_meta($consultation_id, '_consultation_product_name', $product_name);
    }
    if (!empty($category_name)) {
        update_post_meta($consultation_id, '_consultation_category_name', $category_name);
    }
    
    // Prepare email
    $to = tavaled_get_option('email_address', get_option('admin_email'));
    $email_subject = 'Nhận báo giá mới - ' . get_bloginfo('name');
    $email_message = "Bạn có yêu cầu nhận báo giá mới:\n\n";
    $email_message .= "Họ và tên: " . $name . "\n";
    $email_message .= "Số điện thoại: " . $phone . "\n";
    if (!empty($email)) {
        $email_message .= "Email: " . $email . "\n";
    }
    if (!empty($subject)) {
        $email_message .= "Chủ đề: " . $subject . "\n";
    }
    if (!empty($message_content)) {
        $email_message .= "Nội dung: " . $message_content . "\n";
    }
    if (!empty($product_name) || !empty($category_name) || $product_id > 0) {
        $email_message .= "\n--- Thông tin sản phẩm ---\n";
        if (!empty($product_name)) {
            $email_message .= "Sản phẩm: " . $product_name . "\n";
        }
        if (!empty($category_name)) {
            $email_message .= "Danh mục: " . $category_name . "\n";
        }
        if ($product_id > 0) {
            $email_message .= "Link sản phẩm: " . get_permalink($product_id) . "\n";
        }
    }
    $email_message .= "\n--- Thông tin nguồn ---\n";
    $email_message .= "Nguồn: " . $source . "\n";
    $email_message .= "Trang tham chiếu: " . $referer . "\n";
    $email_message .= "Thời gian: " . current_time('mysql') . "\n";
    $email_message .= "\nXem chi tiết: " . admin_url('post.php?post=' . $consultation_id . '&action=edit');
    
    $headers = array('Content-Type: text/html; charset=UTF-8');
    
    // Send email
    wp_mail($to, $email_subject, nl2br($email_message), $headers);
    
        wp_send_json_success(array('message' => 'Cảm ơn bạn! Chúng tôi sẽ liên hệ với bạn trong thời gian sớm nhất.'));
}

// AJAX Handler for Phone CTA Form
add_action('wp_ajax_tavaled_phone_cta', 'tavaled_handle_phone_cta');
add_action('wp_ajax_nopriv_tavaled_phone_cta', 'tavaled_handle_phone_cta');

function tavaled_handle_phone_cta() {
    // Verify nonce
    if (!isset($_POST['phone_cta_nonce']) || !wp_verify_nonce($_POST['phone_cta_nonce'], 'tavaled_phone_cta_nonce')) {
        wp_send_json_error(array('message' => 'Bảo mật không hợp lệ.'));
    }
    
    // Get form data
    $phone = sanitize_text_field($_POST['phone'] ?? '');
    
    // Validate required fields
    if (empty($phone)) {
        wp_send_json_error(array('message' => 'Vui lòng nhập số điện thoại.'));
    }
    
    // Validate phone number (basic)
    if (!preg_match('/^[0-9\s\-\+\(\)]+$/', $phone)) {
        wp_send_json_error(array('message' => 'Số điện thoại không hợp lệ.'));
    }
    
    // Get source (where the form was submitted from)
    $source = isset($_POST['source']) ? sanitize_text_field($_POST['source']) : 'Blog CTA Form';
    $post_id = isset($_POST['post_id']) ? intval($_POST['post_id']) : 0;
    
    // Create consultation post
    $consultation_data = array(
        'post_title'    => 'Tư vấn - ' . $phone . ' - ' . current_time('d/m/Y H:i'),
        'post_content'  => '',
        'post_status'   => 'publish',
        'post_type'     => 'tavaled_consultation',
    );
    
    $consultation_id = wp_insert_post($consultation_data);
    
    if (is_wp_error($consultation_id)) {
        wp_send_json_error(array('message' => 'Có lỗi xảy ra khi lưu thông tin. Vui lòng thử lại.'));
    }
    
    // Save meta data
    update_post_meta($consultation_id, '_consultation_phone', $phone);
    update_post_meta($consultation_id, '_consultation_source', $source);
    update_post_meta($consultation_id, '_consultation_post_id', $post_id);
    update_post_meta($consultation_id, '_consultation_date', current_time('mysql'));
    update_post_meta($consultation_id, '_consultation_status', 'new');
    update_post_meta($consultation_id, '_consultation_type', 'phone_cta');
    
    // Prepare email
    $to = tavaled_get_option('email_address', get_option('admin_email'));
    $subject = 'Yêu cầu tư vấn mới - ' . get_bloginfo('name');
    $message = "Bạn có yêu cầu tư vấn mới:\n\n";
    $message .= "Số điện thoại: " . $phone . "\n";
    $message .= "Nguồn: " . $source . "\n";
    if ($post_id) {
        $message .= "Bài viết: " . get_the_title($post_id) . "\n";
    }
    $message .= "Thời gian: " . current_time('mysql') . "\n";
    $message .= "\nXem chi tiết: " . admin_url('post.php?post=' . $consultation_id . '&action=edit');
    
    $headers = array('Content-Type: text/html; charset=UTF-8');
    
    // Send email
    wp_mail($to, $subject, nl2br($message), $headers);
    
        wp_send_json_success(array('message' => 'Cảm ơn bạn! Chúng tôi sẽ liên hệ với bạn trong thời gian sớm nhất.'));
}