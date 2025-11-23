<?php
/**
 * Admin Company Information Management
 * Quản lý thông tin doanh nghiệp cho TavaLED Theme
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Add Company Info menu to WordPress admin
 */
function tavaled_add_company_info_menu() {
    add_menu_page(
        'Thông tin Doanh nghiệp',           // Page title
        'Thông tin Doanh nghiệp',           // Menu title
        'manage_options',                    // Capability
        'tavaled-company-info',             // Menu slug
        'tavaled_company_info_page',        // Callback function
        'dashicons-building',               // Icon
        25                                   // Position
    );
}
add_action('admin_menu', 'tavaled_add_company_info_menu');

/**
 * Register settings
 */
function tavaled_register_company_info_settings() {
    // Register settings for company contact info
    register_setting('tavaled_company_info_contact', 'tavaled_company_phones');
    register_setting('tavaled_company_info_contact', 'tavaled_company_emails');
    register_setting('tavaled_company_info_contact', 'tavaled_company_addresses');
}
add_action('admin_init', 'tavaled_register_company_info_settings');

/**
 * Company Info Admin Page
 */
function tavaled_company_info_page() {
    // Check user capabilities
    if (!current_user_can('manage_options')) {
        return;
    }
    
    // Save settings
    if (isset($_POST['tavaled_save_company_info'])) {
        check_admin_referer('tavaled_company_info_nonce');
        
        // Save contact information
        update_option('tavaled_company_phones', sanitize_textarea_field($_POST['tavaled_company_phones']));
        update_option('tavaled_company_emails', sanitize_textarea_field($_POST['tavaled_company_emails']));
        update_option('tavaled_company_addresses', sanitize_textarea_field($_POST['tavaled_company_addresses']));
        
        // Sync với ACF options (nếu ACF đang được sử dụng)
        if (function_exists('update_field')) {
            $phones = explode("\n", sanitize_textarea_field($_POST['tavaled_company_phones']));
            $emails = explode("\n", sanitize_textarea_field($_POST['tavaled_company_emails']));
            $addresses = explode("\n", sanitize_textarea_field($_POST['tavaled_company_addresses']));
            
            // Lưu số điện thoại và email chính cho backward compatibility
            if (!empty($phones[0])) {
                update_field('phone_number', trim($phones[0]), 'option');
                update_option('tavaled_company_phone', trim($phones[0]));
            }
            if (!empty($emails[0])) {
                update_field('email_address', trim($emails[0]), 'option');
                update_option('tavaled_company_email', trim($emails[0]));
            }
            if (!empty($addresses[0])) {
                update_field('company_address', trim($addresses[0]), 'option');
                update_option('tavaled_company_address', trim($addresses[0]));
            }
        }
        
        echo '<div class="notice notice-success is-dismissible"><p><strong>Đã lưu thay đổi thành công!</strong></p></div>';
    }
    
    // Get current values
    $company_phones = get_option('tavaled_company_phones', get_option('tavaled_company_phone', ''));
    $company_emails = get_option('tavaled_company_emails', get_option('tavaled_company_email', ''));
    $company_addresses = get_option('tavaled_company_addresses', get_option('tavaled_company_address', ''));
    
    // Nếu chưa có, lấy từ ACF options
    if (empty($company_phones) && function_exists('get_field')) {
        $acf_phone = get_field('phone_number', 'option');
        if ($acf_phone) {
            $company_phones = $acf_phone;
        }
    }
    if (empty($company_emails) && function_exists('get_field')) {
        $acf_email = get_field('email_address', 'option');
        if ($acf_email) {
            $company_emails = $acf_email;
        }
    }
    if (empty($company_addresses) && function_exists('get_field')) {
        $acf_address = get_field('company_address', 'option');
        if ($acf_address) {
            $company_addresses = $acf_address;
        }
    }
    
    ?>
    <div class="wrap tavaled-company-info-wrap">
        <h1><i class="dashicons dashicons-building"></i> Quản lý Thông tin Doanh nghiệp</h1>
        <p class="description">Quản lý thông tin liên hệ của công ty. Thông tin này sẽ được hiển thị trên toàn bộ website (header, footer, trang liên hệ, v.v.).</p>
        
        <form method="post" action="" class="tavaled-company-info-form">
            <?php wp_nonce_field('tavaled_company_info_nonce'); ?>
            
            <table class="form-table" role="presentation">
                <tbody>
                    <tr>
                        <th scope="row">
                            <label for="tavaled_company_phones">Số Điện thoại Liên hệ</label>
                        </th>
                        <td>
                            <textarea id="tavaled_company_phones" name="tavaled_company_phones" 
                                      rows="5" class="large-text" 
                                      placeholder="Nhập mỗi số điện thoại trên một dòng&#10;Ví dụ:&#10;0123 456 789&#10;0904 433 799&#10;+84 904 433 799"><?php echo esc_textarea($company_phones); ?></textarea>
                            <p class="description">
                                <i class="dashicons dashicons-info"></i> Mỗi số điện thoại trên một dòng. Số đầu tiên sẽ được sử dụng làm số chính trên header và footer.
                            </p>
                        </td>
                    </tr>
                    
                    <tr>
                        <th scope="row">
                            <label for="tavaled_company_emails">Email Liên hệ</label>
                        </th>
                        <td>
                            <textarea id="tavaled_company_emails" name="tavaled_company_emails" 
                                      rows="5" class="large-text" 
                                      placeholder="Nhập mỗi email trên một dòng&#10;Ví dụ:&#10;info@tavaled.vn&#10;sales@tavaled.vn&#10;support@tavaled.vn"><?php echo esc_textarea($company_emails); ?></textarea>
                            <p class="description">
                                <i class="dashicons dashicons-info"></i> Mỗi email trên một dòng. Email đầu tiên sẽ được sử dụng làm email chính trên header và footer.
                            </p>
                        </td>
                    </tr>
                    
                    <tr>
                        <th scope="row">
                            <label for="tavaled_company_addresses">Địa chỉ</label>
                        </th>
                        <td>
                            <textarea id="tavaled_company_addresses" name="tavaled_company_addresses" 
                                      rows="5" class="large-text" 
                                      placeholder="Nhập mỗi địa chỉ trên một dòng&#10;Ví dụ:&#10;123 Đường ABC, Quận XYZ, TP.HCM&#10;Văn phòng chi nhánh: 456 Đường DEF, Quận UVW, Hà Nội"><?php echo esc_textarea($company_addresses); ?></textarea>
                            <p class="description">
                                <i class="dashicons dashicons-info"></i> Mỗi địa chỉ trên một dòng. Địa chỉ đầu tiên sẽ được sử dụng làm địa chỉ chính trên footer và trang liên hệ.
                            </p>
                        </td>
                    </tr>
                </tbody>
            </table>
            
            <div class="tavaled-info-box" style="background: #f0f0f1; padding: 15px; border-left: 4px solid #2271b1; margin: 20px 0;">
                <h3 style="margin-top: 0;"><i class="dashicons dashicons-yes-alt"></i> Thông tin đã lưu sẽ hiển thị tại:</h3>
                <ul>
                    <li>✓ Header - Thanh thông tin liên hệ phía trên và header chính</li>
                    <li>✓ Footer - Thông tin công ty và liên hệ</li>
                    <li>✓ Trang Liên hệ - Form và thông tin công ty</li>
                    <li>✓ Các trang sản phẩm - Thông tin liên hệ</li>
                    <li>✓ Popup liên hệ - Thông tin hiển thị</li>
                </ul>
            </div>
            
            <p class="submit">
                <button type="submit" name="tavaled_save_company_info" class="button button-primary button-large">
                    <i class="dashicons dashicons-yes"></i> Lưu Thay đổi
                </button>
            </p>
        </form>
    </div>
    
    <style>
    .tavaled-company-info-wrap {
        max-width: 1200px;
    }
    .tavaled-company-info-wrap h1 {
        margin-bottom: 10px;
    }
    .tavaled-company-info-wrap .description {
        margin-bottom: 20px;
        font-size: 14px;
    }
    .tavaled-info-box ul {
        margin: 10px 0;
        padding-left: 20px;
    }
    .tavaled-info-box li {
        margin: 5px 0;
    }
    </style>
    <?php
}

/**
 * Helper functions to get company information
 */

// Get all company phones as array
function tavaled_get_company_phones() {
    $phones = get_option('tavaled_company_phones', '');
    if (empty($phones)) {
        $phones = get_option('tavaled_company_phone', '');
    }
    // Nếu vẫn chưa có, lấy từ ACF
    if (empty($phones) && function_exists('get_field')) {
        $acf_phone = get_field('phone_number', 'option');
        if ($acf_phone) {
            $phones = $acf_phone;
        }
    }
    return array_filter(array_map('trim', explode("\n", $phones)));
}

// Get primary company phone
function tavaled_get_primary_phone() {
    $phones = tavaled_get_company_phones();
    if (!empty($phones)) {
        return $phones[0];
    }
    // Fallback to old option
    $phone = tavaled_get_option('phone_number', '0123 456 789');
    return $phone;
}

// Get all company emails as array
function tavaled_get_company_emails() {
    $emails = get_option('tavaled_company_emails', '');
    if (empty($emails)) {
        $emails = get_option('tavaled_company_email', '');
    }
    // Nếu vẫn chưa có, lấy từ ACF
    if (empty($emails) && function_exists('get_field')) {
        $acf_email = get_field('email_address', 'option');
        if ($acf_email) {
            $emails = $acf_email;
        }
    }
    return array_filter(array_map('trim', explode("\n", $emails)));
}

// Get primary company email
function tavaled_get_primary_email() {
    $emails = tavaled_get_company_emails();
    if (!empty($emails)) {
        return $emails[0];
    }
    // Fallback to old option
    $email = tavaled_get_option('email_address', 'support@tavaled.vn');
    return $email;
}

// Get all company addresses as array
function tavaled_get_company_addresses() {
    $addresses = get_option('tavaled_company_addresses', '');
    if (empty($addresses)) {
        $addresses = get_option('tavaled_company_address', '');
    }
    // Nếu vẫn chưa có, lấy từ ACF
    if (empty($addresses) && function_exists('get_field')) {
        $acf_address = get_field('company_address', 'option');
        if ($acf_address) {
            $addresses = $acf_address;
        }
    }
    return array_filter(array_map('trim', explode("\n", $addresses)));
}

// Get primary company address
function tavaled_get_primary_address() {
    $addresses = tavaled_get_company_addresses();
    if (!empty($addresses)) {
        return $addresses[0];
    }
    // Fallback to old option
    $address = tavaled_get_option('company_address', '123 Đường ABC, Quận XYZ, TP.HCM');
    return $address;
}

/**
 * Template display functions - hiển thị tất cả thông tin liên hệ
 */

// Display all company phones
function tavaled_display_all_phones($separator = '<br>', $echo = true) {
    $phones = tavaled_get_company_phones();
    $output = '';
    
    if (!empty($phones)) {
        $phone_links = array();
        foreach ($phones as $phone) {
            $phone_clean = preg_replace('/[^0-9+]/', '', $phone);
            $phone_links[] = '<a href="tel:' . esc_attr($phone_clean) . '">' . esc_html($phone) . '</a>';
        }
        $output = implode($separator, $phone_links);
    }
    
    if ($echo) {
        echo $output;
    } else {
        return $output;
    }
}

// Display all company emails
function tavaled_display_all_emails($separator = '<br>', $echo = true) {
    $emails = tavaled_get_company_emails();
    $output = '';
    
    if (!empty($emails)) {
        $email_links = array();
        foreach ($emails as $email) {
            $email_links[] = '<a href="mailto:' . esc_attr($email) . '">' . esc_html($email) . '</a>';
        }
        $output = implode($separator, $email_links);
    }
    
    if ($echo) {
        echo $output;
    } else {
        return $output;
    }
}

// Display all company addresses
function tavaled_display_all_addresses($separator = '<br>', $echo = true) {
    $addresses = tavaled_get_company_addresses();
    $output = '';
    
    if (!empty($addresses)) {
        $address_items = array();
        foreach ($addresses as $address) {
            $address_items[] = '<span class="company-address">' . esc_html($address) . '</span>';
        }
        $output = implode($separator, $address_items);
    }
    
    if ($echo) {
        echo $output;
    } else {
        return $output;
    }
}

