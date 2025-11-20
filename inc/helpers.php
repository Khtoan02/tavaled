<?php
/**
 * Helper Functions
 *
 * @package TavaLED
 */

// Ngăn truy cập trực tiếp
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Get post excerpt with custom length
 */
function tavaled_get_excerpt($length = 20, $post_id = null) {
    if (!$post_id) {
        $post_id = get_the_ID();
    }
    
    $excerpt = get_post_field('post_excerpt', $post_id);
    
    if (empty($excerpt)) {
        $content = get_post_field('post_content', $post_id);
        $excerpt = wp_trim_words($content, $length, '...');
    }
    
    return $excerpt;
}

/**
 * Get breadcrumbs
 */
function tavaled_breadcrumbs() {
    if (is_front_page()) {
        return;
    }
    
    $breadcrumbs = array();
    $breadcrumbs[] = array(
        'label' => esc_html__('Trang chủ', 'tavaled-theme'),
        'url'   => home_url('/'),
    );

    if (is_single()) {
        $post_type = get_post_type();

        if ($post_type === 'post') {
            // Thêm "Chia sẻ Kinh nghiệm" hoặc tên trang blog
        $blog_page_id = get_option('page_for_posts');
            $blog_label = '';
            $blog_url = '';
            
        if ($blog_page_id) {
                $blog_title = get_the_title($blog_page_id);
                $blog_label = !empty(trim($blog_title)) ? trim($blog_title) : esc_html__('Chia sẻ Kinh nghiệm', 'tavaled-theme');
                $blog_url = get_permalink($blog_page_id);
            } else {
                $blog_label = esc_html__('Chia sẻ Kinh nghiệm', 'tavaled-theme');
                $blog_url = get_post_type_archive_link('post');
    }
    
            // Chỉ thêm nếu label không rỗng
            if (!empty(trim($blog_label))) {
                $breadcrumbs[] = array(
                    'label' => trim($blog_label),
                    'url'   => $blog_url,
                );
            }
        } else {
            $post_type_object = get_post_type_object($post_type);
            if ($post_type_object && $post_type_object->has_archive) {
                $archive_label = !empty($post_type_object->labels->name) ? trim($post_type_object->labels->name) : trim($post_type_object->label);
                if (!empty($archive_label)) {
                    $breadcrumbs[] = array(
                        'label' => $archive_label,
                        'url'   => get_post_type_archive_link($post_type),
                    );
                }
            }
        }

        // Thêm tên bài viết - chỉ thêm nếu không rỗng
        $post_title = get_the_title();
        $post_title = trim($post_title);
        if (!empty($post_title)) {
            $breadcrumbs[] = array(
                'label' => $post_title,
                'url'   => '',
            );
        }
    } elseif (is_page()) {
        $ancestors = get_post_ancestors(get_the_ID());
        if ($ancestors) {
            $ancestors = array_reverse($ancestors);
            foreach ($ancestors as $ancestor_id) {
                $breadcrumbs[] = array(
                    'label' => get_the_title($ancestor_id),
                    'url'   => get_permalink($ancestor_id),
                );
            }
        }

        $breadcrumbs[] = array(
            'label' => get_the_title(),
            'url'   => '',
        );
    } elseif (is_category()) {
        $current_category = get_queried_object();
        if ($current_category && !is_wp_error($current_category)) {
            $ancestors = array_reverse(get_ancestors($current_category->term_id, 'category'));
            foreach ($ancestors as $ancestor_id) {
                $ancestor = get_term($ancestor_id, 'category');
                if (!is_wp_error($ancestor)) {
                    $breadcrumbs[] = array(
                        'label' => $ancestor->name,
                        'url'   => get_term_link($ancestor),
                    );
                }
            }

            $breadcrumbs[] = array(
                'label' => $current_category->name,
                'url'   => '',
            );
        }
    } elseif (is_tag()) {
        $breadcrumbs[] = array(
            'label' => single_tag_title('', false),
            'url'   => '',
        );
    } elseif (is_search()) {
        $breadcrumbs[] = array(
            'label' => esc_html__('Kết quả tìm kiếm', 'tavaled-theme'),
            'url'   => '',
        );
    } elseif (is_404()) {
        $breadcrumbs[] = array(
            'label' => esc_html__('404 - Không tìm thấy trang', 'tavaled-theme'),
            'url'   => '',
        );
    } elseif (is_archive()) {
        $breadcrumbs[] = array(
            'label' => post_type_archive_title('', false),
            'url'   => '',
        );
    }

    if (empty($breadcrumbs)) {
        return;
    }

    // Filter out empty breadcrumbs - strict check
    $valid_breadcrumbs = array();
    foreach ($breadcrumbs as $crumb) {
        if (!isset($crumb['label'])) {
            continue;
        }
        
        $label = trim($crumb['label']);
        
        // Skip if label is empty or only whitespace
        if (empty($label) || $label === '') {
            continue;
        }
        
        // Only add if label has actual content
        $valid_breadcrumbs[] = array(
            'label' => $label,
            'url'   => isset($crumb['url']) ? $crumb['url'] : '',
        );
    }

    // Remove duplicates based on label
    $seen = array();
    $unique_breadcrumbs = array();
    foreach ($valid_breadcrumbs as $crumb) {
        $label_key = md5($crumb['label']);
        if (!isset($seen[$label_key])) {
            $seen[$label_key] = true;
            $unique_breadcrumbs[] = $crumb;
        }
    }

    if (empty($unique_breadcrumbs)) {
        return;
    }

    echo '<nav class="breadcrumbs" aria-label="Breadcrumb">';
    echo '<ol class="breadcrumb-list">';

    $total_items = count($unique_breadcrumbs);

    foreach ($unique_breadcrumbs as $index => $crumb) {
        $is_last = ($index === $total_items - 1);
        $label = esc_html(trim($crumb['label']));
        $url = isset($crumb['url']) && !empty($crumb['url']) ? $crumb['url'] : '';

        // Skip if label is still empty after trimming
        if (empty($label)) {
            continue;
        }

        $classes = 'breadcrumb-item';
        if ($is_last) {
            $classes .= ' active';
        }

        echo '<li class="' . esc_attr($classes) . '"' . ($is_last ? ' aria-current="page"' : '') . '>';

        if (!$is_last && !empty($url)) {
            echo '<a href="' . esc_url($url) . '">' . $label . '</a>';
        } else {
            echo '<span>' . $label . '</span>';
        }

        echo '</li>';
    }
    
    echo '</ol>';
    echo '</nav>';
}

/**
 * Get related posts
 */
function tavaled_get_related_posts($post_id = null, $number = 3) {
    if (!$post_id) {
        $post_id = get_the_ID();
    }
    
    $post_type = get_post_type($post_id);
    
    // Get categories/taxonomies
    $taxonomies = get_object_taxonomies($post_type);
    $terms = array();
    
    foreach ($taxonomies as $taxonomy) {
        $post_terms = wp_get_post_terms($post_id, $taxonomy, array('fields' => 'ids'));
        if (!empty($post_terms) && !is_wp_error($post_terms)) {
            $terms[$taxonomy] = $post_terms;
        }
    }
    
    if (empty($terms)) {
        return false;
    }
    
    // Build query
    $args = array(
        'post_type'      => $post_type,
        'posts_per_page' => $number,
        'post__not_in'   => array($post_id),
        'orderby'        => 'rand',
        'tax_query'      => array('relation' => 'OR'),
    );
    
    foreach ($terms as $taxonomy => $term_ids) {
        $args['tax_query'][] = array(
            'taxonomy' => $taxonomy,
            'field'    => 'term_id',
            'terms'    => $term_ids,
        );
    }
    
    return new WP_Query($args);
}

/**
 * Check if page has sidebar
 */
function tavaled_has_sidebar() {
    if (is_single() || is_page()) {
        $sidebar_meta = get_post_meta(get_the_ID(), '_tavaled_sidebar', true);
        if ($sidebar_meta == 'none') {
            return false;
        }
    }
    
    return is_active_sidebar('sidebar-1');
}

/**
 * Get social share links
 */
function tavaled_social_share() {
    $url = urlencode(get_permalink());
    $title = urlencode(get_the_title());
    
    $links = array(
        'facebook' => 'https://www.facebook.com/sharer/sharer.php?u=' . $url,
        'twitter'  => 'https://twitter.com/intent/tweet?url=' . $url . '&text=' . $title,
        'linkedin' => 'https://www.linkedin.com/shareArticle?mini=true&url=' . $url . '&title=' . $title,
        'pinterest' => 'https://pinterest.com/pin/create/button/?url=' . $url . '&description=' . $title,
    );
    
    return $links;
}

/**
 * Get reading time
 */
function tavaled_reading_time($post_id = null) {
    if (!$post_id) {
        $post_id = get_the_ID();
    }
    
    $content = get_post_field('post_content', $post_id);
    $word_count = str_word_count(strip_tags($content));
    $reading_time = ceil($word_count / 200); // 200 words per minute
    
    return sprintf(_n('%d phút đọc', '%d phút đọc', $reading_time, 'tavaled-theme'), $reading_time);
}

/**
 * Format phone number for tel: link
 */
function tavaled_format_phone($phone) {
    // Remove all non-numeric characters
    $phone = preg_replace('/[^0-9]/', '', $phone);
    
    // Add country code if not present
    if (substr($phone, 0, 2) != '84') {
        $phone = '84' . ltrim($phone, '0');
    }
    
    return '+' . $phone;
}

/**
 * Get post views count
 */
function tavaled_get_post_views($post_id = null) {
    if (!$post_id) {
        $post_id = get_the_ID();
    }
    
    $views = get_post_meta($post_id, '_tavaled_post_views', true);
    return $views ? $views : 0;
}

/**
 * Set post views count
 */
function tavaled_set_post_views($post_id = null) {
    if (!$post_id) {
        $post_id = get_the_ID();
    }
    
    $views = tavaled_get_post_views($post_id);
    update_post_meta($post_id, '_tavaled_post_views', $views + 1);
}

/**
 * Get archive title without prefix
 */
function tavaled_get_archive_title() {
    $title = '';
    
    if (is_category()) {
        $title = single_cat_title('', false);
    } elseif (is_tag()) {
        $title = single_tag_title('', false);
    } elseif (is_author()) {
        $title = get_the_author();
    } elseif (is_post_type_archive()) {
        $title = post_type_archive_title('', false);
    } elseif (is_tax()) {
        $title = single_term_title('', false);
    } elseif (is_archive()) {
        $title = get_the_archive_title();
    }
    
    return $title;
}

/**
 * Check if current page is a custom post type
 */
function tavaled_is_custom_post_type() {
    $custom_post_types = array('du-an', 'giai-phap', 'tuyen-dung');
    return is_singular($custom_post_types) || is_post_type_archive($custom_post_types);
}

/**
 * Get theme option (for use with ACF options page)
 */
function tavaled_get_option($option_name, $default = '') {
    if (function_exists('get_field')) {
        $value = get_field($option_name, 'option');
        return $value ? $value : $default;
    }
    return $default;
}

/**
 * Premium Walker for Main Navigation Menu
 */
class Premium_Walker_Nav_Menu extends Walker_Nav_Menu {
    
    // Start Level - add premium dropdown classes
    function start_lvl(&$output, $depth = 0, $args = null) {
        $indent = str_repeat("\t", $depth);
        $output .= "\n$indent<div class=\"premium-dropdown\">\n";
        $output .= "$indent\t<ul class=\"dropdown-list\">\n";
    }
    
    // End Level
    function end_lvl(&$output, $depth = 0, $args = null) {
        $indent = str_repeat("\t", $depth);
        $output .= "$indent\t</ul>\n";
        $output .= "$indent</div>\n";
    }
    
    // Start Element
    function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
        $indent = ($depth) ? str_repeat("\t", $depth) : '';
        
        $classes = empty($item->classes) ? array() : (array) $item->classes;
        $classes[] = 'menu-item-' . $item->ID;
        
        // Add premium classes
        if ($depth === 0) {
            $classes[] = 'nav-item';
        }
        
        // Add dropdown class if item has children
        $has_children = in_array('menu-item-has-children', $classes);
        if ($has_children && $depth === 0) {
            $classes[] = 'has-dropdown';
        }
        
        $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args));
        $class_names = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';
        
        $id = apply_filters('nav_menu_item_id', 'menu-item-' . $item->ID, $item, $args);
        $id = $id ? ' id="' . esc_attr($id) . '"' : '';
        
        $output .= $indent . '<li' . $id . $class_names . '>';
        
        $attributes = ! empty($item->attr_title) ? ' title="' . esc_attr($item->attr_title) . '"' : '';
        $attributes .= ! empty($item->target) ? ' target="' . esc_attr($item->target) . '"' : '';
        $attributes .= ! empty($item->xfn) ? ' rel="' . esc_attr($item->xfn) . '"' : '';
        $attributes .= ! empty($item->url) ? ' href="' . esc_attr($item->url) . '"' : '';
        
        // Add premium link class
        if ($depth === 0) {
            $link_class = 'nav-link';
        } else {
            $link_class = 'dropdown-link';
        }
        
        $item_output = isset($args->before) ? $args->before : '';
        $item_output .= '<a class="' . $link_class . '"' . $attributes . '>';
        $item_output .= '<span class="nav-text">' . (isset($args->link_before) ? $args->link_before : '') . apply_filters('the_title', $item->title, $item->ID) . (isset($args->link_after) ? $args->link_after : '') . '</span>';
        
        // Add dropdown arrow for parent items
        if ($has_children && $depth === 0) {
            $item_output .= '<i class="fas fa-chevron-down nav-arrow"></i>';
        }
        
        $item_output .= '</a>';
        $item_output .= isset($args->after) ? $args->after : '';
        
        $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
    }
    
    // End Element
    function end_el(&$output, $item, $depth = 0, $args = null) {
        $output .= "</li>\n";
    }
}

/**
 * Custom Walker for Main Navigation Menu
 */
class Custom_Walker_Nav_Menu extends Walker_Nav_Menu {
    
    // Start Level - add custom dropdown classes
    function start_lvl(&$output, $depth = 0, $args = null) {
        $indent = str_repeat("\t", $depth);
        $output .= "\n$indent<div class=\"mega-dropdown\">\n";
        $output .= "$indent\t<div class=\"dropdown-inner\">\n";
        $output .= "$indent\t\t<ul class=\"dropdown-menu-custom\">\n";
    }
    
    // End Level
    function end_lvl(&$output, $depth = 0, $args = null) {
        $indent = str_repeat("\t", $depth);
        $output .= "$indent\t\t</ul>\n";
        $output .= "$indent\t</div>\n";
        $output .= "$indent</div>\n";
    }
    
    // Start Element
    function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
        $indent = ($depth) ? str_repeat("\t", $depth) : '';
        
        $classes = empty($item->classes) ? array() : (array) $item->classes;
        $classes[] = 'menu-item-' . $item->ID;
        
        // Add custom classes
        if ($depth === 0) {
            $classes[] = 'nav-item-custom';
        }
        
        // Add dropdown class if item has children
        $has_children = in_array('menu-item-has-children', $classes);
        if ($has_children && $depth === 0) {
            $classes[] = 'has-dropdown';
        }
        
        $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args));
        $class_names = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';
        
        $id = apply_filters('nav_menu_item_id', 'menu-item-' . $item->ID, $item, $args);
        $id = $id ? ' id="' . esc_attr($id) . '"' : '';
        
        $output .= $indent . '<li' . $id . $class_names . '>';
        
        $attributes = ! empty($item->attr_title) ? ' title="' . esc_attr($item->attr_title) . '"' : '';
        $attributes .= ! empty($item->target) ? ' target="' . esc_attr($item->target) . '"' : '';
        $attributes .= ! empty($item->xfn) ? ' rel="' . esc_attr($item->xfn) . '"' : '';
        $attributes .= ! empty($item->url) ? ' href="' . esc_attr($item->url) . '"' : '';
        
        // Add custom link class
        if ($depth === 0) {
            $link_class = 'nav-link-custom';
        } else {
            $link_class = 'dropdown-item-custom';
        }
        
        $item_output = isset($args->before) ? $args->before : '';
        $item_output .= '<a class="' . $link_class . '"' . $attributes . '>';
        
        // Add icon for dropdown items
        if ($depth > 0) {
            $item_output .= '<i class="fas fa-angle-right me-2"></i>';
        }
        
        $item_output .= (isset($args->link_before) ? $args->link_before : '') . apply_filters('the_title', $item->title, $item->ID) . (isset($args->link_after) ? $args->link_after : '');
        
        // Add dropdown arrow for parent items
        if ($has_children && $depth === 0) {
            $item_output .= ' <i class="fas fa-chevron-down dropdown-arrow ms-1"></i>';
        }
        
        $item_output .= '</a>';
        $item_output .= isset($args->after) ? $args->after : '';
        
        $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
    }
    
    // End Element
    function end_el(&$output, $item, $depth = 0, $args = null) {
        $output .= "</li>\n";
    }
}

/**
 * Mobile Walker for Navigation Menu
 */
class Mobile_Walker_Nav_Menu extends Walker_Nav_Menu {
    
    // Start Level
    function start_lvl(&$output, $depth = 0, $args = null) {
        $indent = str_repeat("\t", $depth);
        $output .= "\n$indent<ul class=\"mobile-submenu collapse\">\n";
    }
    
    // End Level
    function end_lvl(&$output, $depth = 0, $args = null) {
        $indent = str_repeat("\t", $depth);
        $output .= "$indent</ul>\n";
    }
    
    // Start Element
    function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
        $indent = ($depth) ? str_repeat("\t", $depth) : '';
        
        $classes = empty($item->classes) ? array() : (array) $item->classes;
        $classes[] = 'menu-item-' . $item->ID;
        
        // Add mobile classes
        $classes[] = 'mobile-nav-item';
        
        // Add dropdown class if item has children
        $has_children = in_array('menu-item-has-children', $classes);
        if ($has_children) {
            $classes[] = 'has-children';
        }
        
        $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args));
        $class_names = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';
        
        $id = apply_filters('nav_menu_item_id', 'menu-item-' . $item->ID, $item, $args);
        $id = $id ? ' id="' . esc_attr($id) . '"' : '';
        
        $output .= $indent . '<li' . $id . $class_names . '>';
        
        $attributes = ! empty($item->attr_title) ? ' title="' . esc_attr($item->attr_title) . '"' : '';
        $attributes .= ! empty($item->target) ? ' target="' . esc_attr($item->target) . '"' : '';
        $attributes .= ! empty($item->xfn) ? ' rel="' . esc_attr($item->xfn) . '"' : '';
        $attributes .= ! empty($item->url) ? ' href="' . esc_attr($item->url) . '"' : '';
        
        $item_output = isset($args->before) ? $args->before : '';
        
        if ($has_children) {
            $item_output .= '<div class="mobile-nav-header d-flex justify-content-between align-items-center">';
            $item_output .= '<a class="mobile-nav-link"' . $attributes . '>';
            $item_output .= (isset($args->link_before) ? $args->link_before : '') . apply_filters('the_title', $item->title, $item->ID) . (isset($args->link_after) ? $args->link_after : '');
            $item_output .= '</a>';
            $item_output .= '<button class="mobile-submenu-toggle btn btn-link p-1" data-bs-toggle="collapse" data-bs-target="#submenu-' . $item->ID . '">';
            $item_output .= '<i class="fas fa-chevron-down"></i>';
            $item_output .= '</button>';
            $item_output .= '</div>';
        } else {
            $item_output .= '<a class="mobile-nav-link"' . $attributes . '>';
            $item_output .= (isset($args->link_before) ? $args->link_before : '') . apply_filters('the_title', $item->title, $item->ID) . (isset($args->link_after) ? $args->link_after : '');
            $item_output .= '</a>';
        }
        
        $item_output .= isset($args->after) ? $args->after : '';
        
        $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
    }
    
    // End Element
    function end_el(&$output, $item, $depth = 0, $args = null) {
        $output .= "</li>\n";
    }
}