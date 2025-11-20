<?php
/**
 * Template part for contact popup
 *
 * @package TavaLED
 */
?>

<div id="contact-popup" class="popup-overlay">
    <div class="popup-content glass-card">
        <button class="popup-close" aria-label="<?php esc_attr_e('Đóng', 'tavaled-theme'); ?>">
            <i class="fas fa-times"></i>
        </button>
        
        <div class="popup-header">
            <h3><?php esc_html_e('Nhận báo giá', 'tavaled-theme'); ?></h3>
            <p><?php esc_html_e('Vui lòng điền thông tin để chúng tôi liên hệ tư vấn', 'tavaled-theme'); ?></p>
        </div>
        
        <div class="popup-body">
            <form class="contact-form" action="<?php echo esc_url(admin_url('admin-ajax.php')); ?>" method="post">
                <input type="hidden" name="action" value="tavaled_contact_form">
                <input type="hidden" name="source" value="Contact Popup" id="popup-source">
                <input type="hidden" name="product_id" value="" id="popup-product-id">
                <input type="hidden" name="product_name" value="" id="popup-product-name">
                <input type="hidden" name="category_name" value="" id="popup-category-name">
                <?php wp_nonce_field('tavaled_contact_nonce', 'contact_nonce'); ?>
                
                <div class="form-group">
                    <label for="contact-name"><?php esc_html_e('Họ và tên *', 'tavaled-theme'); ?></label>
                    <input type="text" id="contact-name" name="name" class="form-control" placeholder="<?php esc_attr_e('Nhập họ và tên của bạn', 'tavaled-theme'); ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="contact-phone"><?php esc_html_e('Số điện thoại *', 'tavaled-theme'); ?></label>
                    <input type="tel" id="contact-phone" name="phone" class="form-control" placeholder="<?php esc_attr_e('Nhập số điện thoại của bạn', 'tavaled-theme'); ?>" required>
                </div>
                
                <div class="form-actions">
                    <button type="submit" class="btn-primary submit-button">
                        <span class="button-text"><?php esc_html_e('Gửi yêu cầu', 'tavaled-theme'); ?></span>
                        <span class="button-loading"><i class="fas fa-spinner fa-spin"></i></span>
                    </button>
                </div>
                
                <div class="form-message"></div>
            </form>
        </div>
    </div>
</div>

<script>
(function($) {
    'use strict';
    
    // Popup functionality - handled by main.js initPopups()
    // This script ensures popup works even if main.js hasn't loaded
    $(document).ready(function() {
        var popup = $('#contact-popup');
        var popupTriggers = $('.popup-trigger');
        
        // Open popup
        popupTriggers.on('click', function(e) {
            if ($(this).attr('href') === '#contact-popup') {
                e.preventDefault();
                
                var trigger = $(this);
                var triggerText = trigger.text().trim();
                var triggerClass = trigger.attr('class') || '';
                
                // Read data attributes if available
                var dataSource = trigger.data('source') || '';
                var productId = trigger.data('product-id') || '';
                var productName = trigger.data('product-name') || '';
                var categoryName = trigger.data('category-name') || '';
                
                var source = dataSource || 'Contact Popup';
                
                if (!dataSource) {
                    if (triggerClass.indexOf('btn-quote') !== -1 || triggerText.indexOf('Báo giá') !== -1 || triggerText.indexOf('Nhận báo giá') !== -1) {
                        source = 'Contact Popup - Quote Button';
                    } else if (triggerClass.indexOf('btn-support') !== -1) {
                        source = 'Contact Popup - Support Button';
                    } else if (trigger.closest('.hero-section').length) {
                        source = 'Contact Popup - Hero Section';
                    } else if (trigger.closest('.solutions-section').length) {
                        source = 'Contact Popup - Solutions Section';
                    } else if (trigger.closest('.products-section').length) {
                        source = 'Contact Popup - Products Section';
                    } else if (trigger.closest('.product-category-section').length) {
                        var categoryTitle = trigger.closest('.product-category-section').find('.section-title .section-heading').first().text().trim();
                        source = categoryTitle ? 'Contact Popup - Danh mục: ' + categoryTitle : 'Contact Popup - Product Archive';
                    } else if (trigger.closest('.products-archive-page').length) {
                        source = 'Contact Popup - Product Archive';
                    }
                }
                
                if (productName) {
                    source += ' | Sản phẩm: ' + productName;
                }
                if (categoryName && source.indexOf('Danh mục') === -1) {
                    source += ' | Danh mục: ' + categoryName;
                }
                
                $('#popup-source').val(source);
                $('#popup-product-id').val(productId);
                $('#popup-product-name').val(productName);
                $('#popup-category-name').val(categoryName);
                
                popup.addClass('active');
                $('body').addClass('popup-open');
            }
        });
        
        // Close popup
        popup.find('.popup-close').on('click', function() {
            popup.removeClass('active');
            $('body').removeClass('popup-open');
        });
        
        // Close on overlay click
        popup.on('click', function(e) {
            if (e.target === this) {
                popup.removeClass('active');
                $('body').removeClass('popup-open');
            }
        });
        
        // ESC key to close
        $(document).on('keydown', function(e) {
            if (e.key === 'Escape' && popup.hasClass('active')) {
                popup.removeClass('active');
                $('body').removeClass('popup-open');
            }
        });
    });
    
})(jQuery);
</script>