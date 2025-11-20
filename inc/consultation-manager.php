<?php
/**
 * Consultation Manager
 * Quản lý thông tin tư vấn từ form
 *
 * @package TavaLED
 */

// Ngăn truy cập trực tiếp
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Add meta box for consultation details
 */
function tavaled_add_consultation_meta_box() {
    add_meta_box(
        'tavaled_consultation_details',
        __('Thông tin tư vấn', 'tavaled-theme'),
        'tavaled_consultation_meta_box_callback',
        'tavaled_consultation',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'tavaled_add_consultation_meta_box');

/**
 * Meta box callback
 */
function tavaled_consultation_meta_box_callback($post) {
    wp_nonce_field('tavaled_consultation_meta_box', 'tavaled_consultation_meta_box_nonce');
    
    $name = get_post_meta($post->ID, '_consultation_name', true);
    $phone = get_post_meta($post->ID, '_consultation_phone', true);
    $email = get_post_meta($post->ID, '_consultation_email', true);
    $subject = get_post_meta($post->ID, '_consultation_subject', true);
    $source = get_post_meta($post->ID, '_consultation_source', true);
    $referer = get_post_meta($post->ID, '_consultation_referer', true);
    $post_id = get_post_meta($post->ID, '_consultation_post_id', true);
    $date = get_post_meta($post->ID, '_consultation_date', true);
    $status = get_post_meta($post->ID, '_consultation_status', true);
    $notes = get_post_meta($post->ID, '_consultation_notes', true);
    $type = get_post_meta($post->ID, '_consultation_type', true);
    
    ?>
    <table class="form-table">
        <?php if (!empty($name)) : ?>
        <tr>
            <th><label for="consultation_name"><?php esc_html_e('Họ và tên', 'tavaled-theme'); ?></label></th>
            <td>
                <input type="text" id="consultation_name" name="consultation_name" value="<?php echo esc_attr($name); ?>" class="regular-text" />
            </td>
        </tr>
        <?php endif; ?>
        <tr>
            <th><label for="consultation_phone"><?php esc_html_e('Số điện thoại', 'tavaled-theme'); ?></label></th>
            <td>
                <input type="tel" id="consultation_phone" name="consultation_phone" value="<?php echo esc_attr($phone); ?>" class="regular-text" />
                <?php if ($phone) : ?>
                    <a href="tel:<?php echo esc_attr(preg_replace('/[^0-9+]/', '', $phone)); ?>" class="button" style="margin-left: 10px;">
                        <span class="dashicons dashicons-phone" style="vertical-align: middle;"></span> Gọi ngay
                    </a>
                <?php endif; ?>
            </td>
        </tr>
        <?php if (!empty($email)) : ?>
        <tr>
            <th><label for="consultation_email"><?php esc_html_e('Email', 'tavaled-theme'); ?></label></th>
            <td>
                <input type="email" id="consultation_email" name="consultation_email" value="<?php echo esc_attr($email); ?>" class="regular-text" />
                <?php if ($email) : ?>
                    <a href="mailto:<?php echo esc_attr($email); ?>" class="button" style="margin-left: 10px;">
                        <span class="dashicons dashicons-email" style="vertical-align: middle;"></span> Gửi email
                    </a>
                <?php endif; ?>
            </td>
        </tr>
        <?php endif; ?>
        <?php if (!empty($subject)) : ?>
        <tr>
            <th><label for="consultation_subject"><?php esc_html_e('Chủ đề', 'tavaled-theme'); ?></label></th>
            <td>
                <input type="text" id="consultation_subject" name="consultation_subject" value="<?php echo esc_attr($subject); ?>" class="regular-text" readonly />
            </td>
        </tr>
        <?php endif; ?>
        <tr>
            <th><label for="consultation_source"><?php esc_html_e('Nguồn', 'tavaled-theme'); ?></label></th>
            <td>
                <input type="text" id="consultation_source" name="consultation_source" value="<?php echo esc_attr($source); ?>" class="regular-text" readonly />
                <?php if (!empty($referer)) : ?>
                    <p class="description">
                        <a href="<?php echo esc_url($referer); ?>" target="_blank" rel="noopener">
                            <?php esc_html_e('Xem trang nguồn', 'tavaled-theme'); ?> →
                        </a>
                    </p>
                <?php endif; ?>
            </td>
        </tr>
        <tr>
            <th><label for="consultation_post_id"><?php esc_html_e('Bài viết', 'tavaled-theme'); ?></label></th>
            <td>
                <?php if ($post_id && get_post($post_id)) : ?>
                    <a href="<?php echo esc_url(get_edit_post_link($post_id)); ?>" target="_blank">
                        <?php echo esc_html(get_the_title($post_id)); ?>
                    </a>
                    <span class="description">(ID: <?php echo esc_html($post_id); ?>)</span>
                <?php else : ?>
                    <span class="description"><?php esc_html_e('Không có', 'tavaled-theme'); ?></span>
                <?php endif; ?>
            </td>
        </tr>
        <tr>
            <th><label for="consultation_date"><?php esc_html_e('Ngày gửi', 'tavaled-theme'); ?></label></th>
            <td>
                <input type="text" id="consultation_date" name="consultation_date" value="<?php echo esc_attr($date); ?>" class="regular-text" readonly />
            </td>
        </tr>
        <tr>
            <th><label for="consultation_status"><?php esc_html_e('Trạng thái', 'tavaled-theme'); ?></label></th>
            <td>
                <select id="consultation_status" name="consultation_status">
                    <option value="new" <?php selected($status, 'new'); ?>><?php esc_html_e('Mới', 'tavaled-theme'); ?></option>
                    <option value="contacted" <?php selected($status, 'contacted'); ?>><?php esc_html_e('Đã liên hệ', 'tavaled-theme'); ?></option>
                    <option value="in_progress" <?php selected($status, 'in_progress'); ?>><?php esc_html_e('Đang xử lý', 'tavaled-theme'); ?></option>
                    <option value="completed" <?php selected($status, 'completed'); ?>><?php esc_html_e('Hoàn thành', 'tavaled-theme'); ?></option>
                    <option value="cancelled" <?php selected($status, 'cancelled'); ?>><?php esc_html_e('Đã hủy', 'tavaled-theme'); ?></option>
                </select>
            </td>
        </tr>
        <tr>
            <th><label for="consultation_notes"><?php esc_html_e('Ghi chú', 'tavaled-theme'); ?></label></th>
            <td>
                <textarea id="consultation_notes" name="consultation_notes" rows="5" class="large-text"><?php echo esc_textarea($notes); ?></textarea>
                <p class="description"><?php esc_html_e('Ghi chú nội bộ về yêu cầu tư vấn này', 'tavaled-theme'); ?></p>
            </td>
        </tr>
    </table>
    <?php
}

/**
 * Save consultation meta data
 */
function tavaled_save_consultation_meta_box($post_id) {
    // Check nonce
    if (!isset($_POST['tavaled_consultation_meta_box_nonce']) || 
        !wp_verify_nonce($_POST['tavaled_consultation_meta_box_nonce'], 'tavaled_consultation_meta_box')) {
        return;
    }
    
    // Check autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    
    // Check permissions
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }
    
    // Save meta data
    if (isset($_POST['consultation_name'])) {
        update_post_meta($post_id, '_consultation_name', sanitize_text_field($_POST['consultation_name']));
    }
    
    if (isset($_POST['consultation_phone'])) {
        update_post_meta($post_id, '_consultation_phone', sanitize_text_field($_POST['consultation_phone']));
    }
    
    if (isset($_POST['consultation_email'])) {
        update_post_meta($post_id, '_consultation_email', sanitize_email($_POST['consultation_email']));
    }
    
    if (isset($_POST['consultation_source'])) {
        update_post_meta($post_id, '_consultation_source', sanitize_text_field($_POST['consultation_source']));
    }
    
    if (isset($_POST['consultation_status'])) {
        update_post_meta($post_id, '_consultation_status', sanitize_text_field($_POST['consultation_status']));
    }
    
    if (isset($_POST['consultation_notes'])) {
        update_post_meta($post_id, '_consultation_notes', sanitize_textarea_field($_POST['consultation_notes']));
    }
}
add_action('save_post_tavaled_consultation', 'tavaled_save_consultation_meta_box');

/**
 * Add custom columns to consultation list
 */
function tavaled_consultation_columns($columns) {
    $new_columns = array();
    $new_columns['cb'] = $columns['cb'];
    $new_columns['title'] = __('Tiêu đề', 'tavaled-theme');
    $new_columns['name'] = __('Họ và tên', 'tavaled-theme');
    $new_columns['phone'] = __('Số điện thoại', 'tavaled-theme');
    $new_columns['source'] = __('Nguồn', 'tavaled-theme');
    $new_columns['status'] = __('Trạng thái', 'tavaled-theme');
    $new_columns['date'] = __('Ngày', 'tavaled-theme');
    
    return $new_columns;
}
add_filter('manage_tavaled_consultation_posts_columns', 'tavaled_consultation_columns');

/**
 * Display custom column content
 */
function tavaled_consultation_column_content($column, $post_id) {
    switch ($column) {
        case 'name':
            $name = get_post_meta($post_id, '_consultation_name', true);
            echo $name ? esc_html($name) : '—';
            break;
            
        case 'phone':
            $phone = get_post_meta($post_id, '_consultation_phone', true);
            if ($phone) {
                echo '<a href="tel:' . esc_attr(preg_replace('/[^0-9+]/', '', $phone)) . '">' . esc_html($phone) . '</a>';
            } else {
                echo '—';
            }
            break;
            
        case 'source':
            $source = get_post_meta($post_id, '_consultation_source', true);
            echo $source ? esc_html($source) : '—';
            break;
            
        case 'status':
            $status = get_post_meta($post_id, '_consultation_status', true);
            $status_labels = array(
                'new' => array('label' => __('Mới', 'tavaled-theme'), 'color' => '#0073aa'),
                'contacted' => array('label' => __('Đã liên hệ', 'tavaled-theme'), 'color' => '#00a0d2'),
                'in_progress' => array('label' => __('Đang xử lý', 'tavaled-theme'), 'color' => '#f56e28'),
                'completed' => array('label' => __('Hoàn thành', 'tavaled-theme'), 'color' => '#46b450'),
                'cancelled' => array('label' => __('Đã hủy', 'tavaled-theme'), 'color' => '#dc3232'),
            );
            
            if (isset($status_labels[$status])) {
                $status_info = $status_labels[$status];
                echo '<span style="color: ' . esc_attr($status_info['color']) . '; font-weight: bold;">' . esc_html($status_info['label']) . '</span>';
            } else {
                echo '—';
            }
            break;
    }
}
add_action('manage_tavaled_consultation_posts_custom_column', 'tavaled_consultation_column_content', 10, 2);

/**
 * Make columns sortable
 */
function tavaled_consultation_sortable_columns($columns) {
    $columns['phone'] = 'phone';
    $columns['status'] = 'status';
    return $columns;
}
add_filter('manage_edit-tavaled_consultation_sortable_columns', 'tavaled_consultation_sortable_columns');

/**
 * Handle sorting
 */
function tavaled_consultation_orderby($query) {
    if (!is_admin() || !$query->is_main_query()) {
        return;
    }
    
    $orderby = $query->get('orderby');
    
    if ('phone' === $orderby) {
        $query->set('meta_key', '_consultation_phone');
        $query->set('orderby', 'meta_value');
    }
    
    if ('status' === $orderby) {
        $query->set('meta_key', '_consultation_status');
        $query->set('orderby', 'meta_value');
    }
}
add_action('pre_get_posts', 'tavaled_consultation_orderby');

