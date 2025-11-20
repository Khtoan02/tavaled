<?php
/**
 * ACF Fields for Blog CTA Section
 * 
 * This file automatically registers ACF fields for Blog CTA settings
 * If ACF is not active, you can manually create these fields in ACF Options page
 *
 * @package TavaLED
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// Register ACF Fields for Blog CTA (if ACF is active)
if (function_exists('acf_add_local_field_group')) {
    
    acf_add_local_field_group(array(
        'key' => 'group_blog_cta_settings',
        'title' => 'Blog CTA Settings',
        'fields' => array(
            array(
                'key' => 'field_blog_cta_title',
                'label' => 'Tiêu đề CTA',
                'name' => 'blog_cta_title',
                'type' => 'text',
                'instructions' => 'Tiêu đề hiển thị trong form CTA ở cuối section Blog',
                'default_value' => 'Để lại số điện thoại để nhận tư vấn ngay',
                'placeholder' => 'Để lại số điện thoại để nhận tư vấn ngay',
            ),
            array(
                'key' => 'field_blog_cta_description',
                'label' => 'Mô tả CTA',
                'name' => 'blog_cta_description',
                'type' => 'textarea',
                'instructions' => 'Mô tả ngắn gọn hiển thị dưới tiêu đề',
                'default_value' => 'Chúng tôi sẽ liên hệ với bạn trong thời gian sớm nhất',
                'rows' => 2,
            ),
            array(
                'key' => 'field_blog_cta_placeholder',
                'label' => 'Placeholder cho ô nhập SĐT',
                'name' => 'blog_cta_placeholder',
                'type' => 'text',
                'instructions' => 'Placeholder text hiển thị trong ô nhập số điện thoại',
                'default_value' => 'Nhập số điện thoại của bạn',
                'placeholder' => 'Nhập số điện thoại của bạn',
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'options_page',
                    'operator' => '==',
                    'value' => 'acf-options-blog-cta-settings',
                ),
            ),
        ),
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
    ));
}

/**
 * Manual ACF Fields Setup Instructions:
 * 
 * If ACF fields are not automatically created, please create them manually:
 * 
 * 1. Go to WordPress Admin > Theme Settings > Blog CTA
 * 2. Create the following fields:
 * 
 *    Field 1:
 *    - Label: Tiêu đề CTA
 *    - Name: blog_cta_title
 *    - Type: Text
 *    - Default Value: Để lại số điện thoại để nhận tư vấn ngay
 * 
 *    Field 2:
 *    - Label: Mô tả CTA
 *    - Name: blog_cta_description
 *    - Type: Textarea
 *    - Default Value: Chúng tôi sẽ liên hệ với bạn trong thời gian sớm nhất
 * 
 *    Field 3:
 *    - Label: Placeholder cho ô nhập SĐT
 *    - Name: blog_cta_placeholder
 *    - Type: Text
 *    - Default Value: Nhập số điện thoại của bạn
 */

