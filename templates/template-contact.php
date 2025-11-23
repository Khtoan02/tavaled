<?php
/**
 * Template Name: Contact
 * Template Post Type: page
 * Description: Template for Contact page with form, map, FAQ and CTA sections
 *
 * @package TavaLED
 */

get_header(); ?>

<main id="main" class="site-main contact-page">
    <!-- Hero Section -->
    <section class="contact-hero">
        <div class="container">
            <div class="hero-content">
                <h1 class="hero-title">Liên hệ với chúng tôi</h1>
                <p class="hero-subtitle">Hãy liên hệ với chúng tôi để được tư vấn miễn phí về dự án của bạn</p>
            </div>
        </div>
    </section>

    <!-- Contact Form Section -->
    <section class="contact-form-section">
        <div class="container">
            <div class="row g-5">
                <!-- Contact Form -->
                <div class="col-lg-8">
                    <div class="contact-form-wrapper">
                        <div class="form-header">
                            <h3>Gửi tin nhắn cho chúng tôi</h3>
                            <p>Điền thông tin bên dưới và chúng tôi sẽ liên hệ lại trong thời gian sớm nhất</p>
                        </div>
                        
                        <form id="contact-form" method="post" action="<?php echo admin_url('admin-ajax.php'); ?>" class="contact-form">
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="contact-name" class="form-label">Họ và tên *</label>
                                        <input type="text" class="form-control" id="contact-name" name="contact_name" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="contact-email" class="form-label">Email *</label>
                                        <input type="email" class="form-control" id="contact-email" name="contact_email" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="contact-phone" class="form-label">Số điện thoại</label>
                                        <input type="tel" class="form-control" id="contact-phone" name="contact_phone">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="contact-company" class="form-label">Công ty</label>
                                        <input type="text" class="form-control" id="contact-company" name="contact_company">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="contact-subject" class="form-label">Chủ đề *</label>
                                        <select class="form-select" id="contact-subject" name="contact_subject" required>
                                            <option value="">Chọn chủ đề</option>
                                            <option value="tu-van">Tư vấn dự án</option>
                                            <option value="san-pham">Hỏi về sản phẩm</option>
                                            <option value="ho-tro">Hỗ trợ kỹ thuật</option>
                                            <option value="hop-tac">Hợp tác kinh doanh</option>
                                            <option value="khac">Khác</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="contact-message" class="form-label">Tin nhắn *</label>
                                        <textarea class="form-control" id="contact-message" name="contact_message" rows="6" required placeholder="Vui lòng mô tả chi tiết nhu cầu của bạn..."></textarea>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="contact-newsletter" name="contact_newsletter" value="1">
                                        <label class="form-check-label" for="contact-newsletter">
                                            Tôi muốn nhận thông tin về các sản phẩm và dịch vụ mới
                                        </label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary btn-lg contact-submit-btn">
                                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M22 2L11 13"></path>
                                            <polygon points="22,2 15,22 11,13 2,9"></polygon>
                                        </svg>
                                        Gửi tin nhắn
                                    </button>
                                </div>
                            </div>
                            <input type="hidden" name="action" value="tavaled_contact_form">
                            <input type="hidden" name="source" value="Contact Page">
                            <?php wp_nonce_field('tavaled_contact_nonce', 'contact_nonce'); ?>
                        </form>
                    </div>
                </div>

                <!-- Contact Info -->
                <div class="col-lg-4">
                    <div class="contact-info-wrapper">
                        <div class="contact-info-header">
                            <h3>Thông tin liên hệ</h3>
                            <p>Chúng tôi luôn sẵn sàng hỗ trợ bạn</p>
                        </div>
                        
                        <div class="contact-info-list">
                            <!-- Địa chỉ -->
                            <?php 
                            $addresses = tavaled_get_company_addresses();
                            if (!empty($addresses)) : 
                            ?>
                            <div class="contact-item">
                                <div class="contact-icon">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                                        <circle cx="12" cy="10" r="3"></circle>
                                    </svg>
                                </div>
                                <div class="contact-content">
                                    <h6>Địa chỉ</h6>
                                    <div class="contact-list">
                                        <?php foreach ($addresses as $address) : ?>
                                            <p class="contact-list-item"><?php echo esc_html($address); ?></p>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>
                            <?php endif; ?>

                            <!-- Số điện thoại -->
                            <?php 
                            $phones = tavaled_get_company_phones();
                            if (!empty($phones)) : 
                            ?>
                            <div class="contact-item">
                                <div class="contact-icon">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                                    </svg>
                                </div>
                                <div class="contact-content">
                                    <h6>Điện thoại</h6>
                                    <div class="contact-list">
                                        <?php foreach ($phones as $phone) : 
                                            $phone_clean = preg_replace('/[^0-9+]/', '', $phone);
                                        ?>
                                            <p class="contact-list-item">
                                                <a href="tel:<?php echo esc_attr(tavaled_format_phone($phone)); ?>"><?php echo esc_html($phone); ?></a>
                                            </p>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>
                            <?php endif; ?>

                            <!-- Email -->
                            <?php 
                            $emails = tavaled_get_company_emails();
                            if (!empty($emails)) : 
                            ?>
                            <div class="contact-item">
                                <div class="contact-icon">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                                        <polyline points="22,6 12,13 2,6"></polyline>
                                    </svg>
                                </div>
                                <div class="contact-content">
                                    <h6>Email</h6>
                                    <div class="contact-list">
                                        <?php foreach ($emails as $email) : ?>
                                            <p class="contact-list-item">
                                                <a href="mailto:<?php echo esc_attr($email); ?>"><?php echo esc_html($email); ?></a>
                                            </p>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>
                            <?php endif; ?>

                            <div class="contact-item">
                                <div class="contact-icon">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <circle cx="12" cy="12" r="10"></circle>
                                        <polyline points="12,6 12,12 16,14"></polyline>
                                    </svg>
                                </div>
                                <div class="contact-content">
                                    <h6>Giờ làm việc</h6>
                                    <p>
                                        Thứ 2 - Thứ 6: <?php echo esc_html(tavaled_get_option('weekday_hours', '8:00 - 17:00')); ?><br>
                                        Thứ 7: <?php echo esc_html(tavaled_get_option('saturday_hours', '8:00 - 12:00')); ?><br>
                                        Chủ nhật: <?php echo esc_html(tavaled_get_option('sunday_hours', 'Nghỉ')); ?>
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Social Media -->
                        <div class="social-media-section">
                            <h6>Kết nối với chúng tôi</h6>
                            <div class="social-links">
                                <?php 
                                $facebook_url = tavaled_get_option('facebook_url', '#');
                                $youtube_url = tavaled_get_option('youtube_url', '#');
                                $linkedin_url = tavaled_get_option('linkedin_url', '#');
                                $zalo_url = tavaled_get_option('zalo_url', '#');
                                ?>
                                <?php if ($facebook_url && $facebook_url !== '#') : ?>
                                <a href="<?php echo esc_url($facebook_url); ?>" class="social-link" target="_blank" rel="noopener noreferrer">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                    </svg>
                                </a>
                                <?php endif; ?>
                                <?php if ($youtube_url && $youtube_url !== '#') : ?>
                                <a href="<?php echo esc_url($youtube_url); ?>" class="social-link" target="_blank" rel="noopener noreferrer">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                                    </svg>
                                </a>
                                <?php endif; ?>
                                <?php if ($linkedin_url && $linkedin_url !== '#') : ?>
                                <a href="<?php echo esc_url($linkedin_url); ?>" class="social-link" target="_blank" rel="noopener noreferrer">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                                    </svg>
                                </a>
                                <?php endif; ?>
                                <?php if ($zalo_url && $zalo_url !== '#') : ?>
                                <a href="<?php echo esc_url($zalo_url); ?>" class="social-link" target="_blank" rel="noopener noreferrer">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M12.017 0C5.396 0 .029 5.367.029 11.987c0 5.079 3.158 9.417 7.618 11.174-.105-.949-.199-2.403.041-3.439.219-.937 1.406-5.957 1.406-5.957s-.359-.72-.359-1.781c0-1.663.967-2.911 2.168-2.911 1.024 0 1.518.769 1.518 1.688 0 1.029-.653 2.567-.992 3.992-.285 1.193.6 2.165 1.775 2.165 2.128 0 3.768-2.245 3.768-5.487 0-2.861-2.063-4.869-5.008-4.869-3.41 0-5.409 2.562-5.409 5.199 0 1.033.394 2.143.889 2.741.099.12.112.225.085.345-.09.375-.293 1.199-.334 1.363-.053.225-.172.271-.402.165-1.495-.69-2.433-2.878-2.433-4.646 0-3.776 2.748-7.252 7.92-7.252 4.158 0 7.392 2.967 7.392 6.923 0 4.135-2.607 7.462-6.233 7.462-1.214 0-2.357-.629-2.746-1.378l-.748 2.853c-.271 1.043-1.002 2.35-1.492 3.146C9.57 23.812 10.763 24.009 12.017 24.009c6.624 0 11.99-5.367 11.99-11.988C24.007 5.367 18.641.001 12.017.001z"/>
                                    </svg>
                                </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Map Section -->
    <section class="map-section">
        <div class="container">
            <div class="map-container">
                <div class="ratio ratio-16x9">
                    <?php
                    $map_embed = tavaled_get_option('google_map_embed');
                    if ($map_embed) {
                        echo $map_embed;
                    } else {
                        // Default map embed
                        ?>
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3727.999177617507!2d106.70327410000002!3d20.8720834!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x314a7adc297467ef%3A0x2d9f6796b87197c!2zMjIgTmfDtCBRdXnhu4FuLCBU4buVIGTDom4gcGjhu5Egc-G7kSA1LCBOZ8O0IFF1eeG7gW4sIEjhuqNpIFBow7JuZw!5e0!3m2!1svi!2s!4v1754320853116!5m2!1svi!2s" 
                            width="100%" 
                            height="400" 
                            style="border:0; border-radius: 16px;" 
                            allowfullscreen="" 
                            loading="lazy" 
                            referrerpolicy="no-referrer-when-downgrade">
                        </iframe>
                        <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="faq-section">
        <div class="container">
            <div class="section-header">
                <h2>Câu hỏi thường gặp</h2>
                <p>Những câu hỏi phổ biến về dịch vụ của chúng tôi</p>
            </div>
            <div class="faq-container">
                <div class="accordion" id="faqAccordion">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="faq1">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse1" aria-expanded="true" aria-controls="collapse1">
                                Thời gian thực hiện một dự án là bao lâu?
                            </button>
                        </h2>
                        <div id="collapse1" class="accordion-collapse collapse show" aria-labelledby="faq1" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Thời gian thực hiện dự án phụ thuộc vào độ phức tạp và yêu cầu cụ thể. Thông thường, một dự án hệ thống LED cơ bản mất 1-2 tuần, dự án phức tạp có thể mất 1-2 tháng.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="faq2">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse2" aria-expanded="false" aria-controls="collapse2">
                                Chi phí cho một dự án là bao nhiêu?
                            </button>
                        </h2>
                        <div id="collapse2" class="accordion-collapse collapse" aria-labelledby="faq2" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Chi phí được tính dựa trên phạm vi và độ phức tạp của dự án. Chúng tôi cung cấp báo giá chi tiết sau khi trao đổi yêu cầu cụ thể với khách hàng.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="faq3">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse3" aria-expanded="false" aria-controls="collapse3">
                                Có hỗ trợ sau khi hoàn thành dự án không?
                            </button>
                        </h2>
                        <div id="collapse3" class="accordion-collapse collapse" aria-labelledby="faq3" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Có, chúng tôi cung cấp dịch vụ bảo trì và hỗ trợ kỹ thuật trong 12 tháng đầu miễn phí. Sau đó, khách hàng có thể gia hạn gói bảo trì theo nhu cầu.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="contact-cta">
        <div class="container">
            <div class="cta-content">
                <h2>Sẵn sàng bắt đầu dự án?</h2>
                <p>Hãy liên hệ ngay để được tư vấn và báo giá chi tiết</p>
                <div class="cta-buttons">
                    <a href="tel:<?php echo esc_attr(tavaled_format_phone(tavaled_get_primary_phone())); ?>" class="btn btn-primary">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                        </svg>
                        Gọi ngay
                    </a>
                    <a href="mailto:<?php echo esc_attr(tavaled_get_primary_email()); ?>" class="btn btn-secondary">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                            <polyline points="22,6 12,13 2,6"></polyline>
                        </svg>
                        Gửi email
                    </a>
                </div>
            </div>
        </div>
    </section>
</main>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Contact form submission
    const contactForm = document.getElementById('contact-form');
    if (contactForm) {
        contactForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const submitBtn = this.querySelector('.contact-submit-btn');
            const originalText = submitBtn.innerHTML;
            
            // Show loading state
            submitBtn.innerHTML = `
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="spinning">
                    <path d="M21 12a9 9 0 11-6.219-8.56"></path>
                </svg>
                Đang gửi...
            `;
            submitBtn.disabled = true;
            
            // Submit form via AJAX
            const formData = new FormData(this);
            
            fetch(this.action, {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Show success message
                    alert('Cảm ơn bạn! Tin nhắn đã được gửi thành công. Chúng tôi sẽ liên hệ lại sớm nhất.');
                    this.reset();
                } else {
                    // Show error message
                    alert(data.data && data.data.message ? data.data.message : 'Có lỗi xảy ra. Vui lòng thử lại sau.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Có lỗi xảy ra. Vui lòng thử lại sau.');
            })
            .finally(() => {
                // Reset button state
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            });
        });
    }
});
</script>

<style>
/* Contact Page Styles - TavaLED Colors */
.contact-page {
    background: linear-gradient(135deg, rgba(28, 40, 87, 0.02) 0%, rgba(240, 90, 37, 0.03) 100%);
}

/* Fix Header z-index on contact page */
.contact-page .main-header {
    position: relative;
    z-index: 1000;
}

.contact-page .top-header {
    position: relative;
    z-index: 1001;
}

.contact-hero {
    background: linear-gradient(135deg, var(--color-secondary, #1c2857) 0%, #243a6b 100%);
    color: #fff;
    padding: 80px 0;
    text-align: center;
    position: relative;
    overflow: hidden;
    z-index: 1;
}

.contact-hero::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="50" cy="50" r="1" fill="rgba(255,255,255,0.1)"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
    opacity: 0.3;
}

.contact-hero .hero-content {
    position: relative;
    z-index: 2;
}

.contact-hero .hero-title {
    font-size: 3rem;
    font-weight: 700;
    margin-bottom: 1rem;
    background: linear-gradient(45deg, #fff, rgba(255,255,255,0.9));
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.contact-hero .hero-subtitle {
    font-size: 1.25rem;
    opacity: 0.9;
    max-width: 600px;
    margin: 0 auto;
}

.contact-form-section {
    padding: 80px 0;
    background: #fff;
}

.contact-form-wrapper {
    background: #fff;
    border-radius: 20px;
    padding: 40px;
    box-shadow: 0 20px 40px rgba(28, 40, 87, 0.1);
    border: 1px solid rgba(28, 40, 87, 0.05);
}

.form-header {
    text-align: center;
    margin-bottom: 40px;
}

.form-header h3 {
    font-size: 2rem;
    font-weight: 700;
    margin-bottom: 1rem;
    color: var(--color-secondary, #1c2857);
}

.form-header p {
    color: rgba(28, 40, 87, 0.7);
    font-size: 1.1rem;
}

.contact-form .form-group {
    margin-bottom: 1.5rem;
}

.contact-form .form-label {
    font-weight: 600;
    color: var(--color-secondary, #1c2857);
    margin-bottom: 0.5rem;
    display: block;
}

.contact-form .form-control,
.contact-form .form-select {
    border: 2px solid rgba(28, 40, 87, 0.1);
    border-radius: 12px;
    padding: 12px 16px;
    font-size: 1rem;
    transition: all 0.3s ease;
    background: rgba(28, 40, 87, 0.02);
}

.contact-form .form-control:focus,
.contact-form .form-select:focus {
    border-color: var(--color-primary, #f05a25);
    box-shadow: 0 0 0 3px rgba(240, 90, 37, 0.1);
    background: #fff;
    outline: none;
}

.contact-submit-btn {
    background: linear-gradient(135deg, var(--color-primary, #f05a25), #f88432);
    border: none;
    border-radius: 12px;
    padding: 15px 30px;
    font-size: 1.1rem;
    font-weight: 600;
    color: #fff;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 10px;
    cursor: pointer;
}

.contact-submit-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 25px rgba(240, 90, 37, 0.3);
    color: #fff;
    background: linear-gradient(135deg, #f88432, #fe9b46);
}

.contact-submit-btn:disabled {
    opacity: 0.7;
    cursor: not-allowed;
}

.contact-submit-btn svg {
    transition: transform 0.3s ease;
}

.contact-submit-btn:hover svg {
    transform: translateX(3px);
}

.contact-submit-btn .spinning {
    animation: spin 1s linear infinite;
}

@keyframes spin {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}

.contact-info-wrapper {
    background: linear-gradient(135deg, rgba(28, 40, 87, 0.02) 0%, rgba(240, 90, 37, 0.03) 100%);
    border-radius: 20px;
    padding: 40px;
    height: 100%;
    border: 1px solid rgba(28, 40, 87, 0.05);
}

.contact-info-header {
    text-align: center;
    margin-bottom: 40px;
}

.contact-info-header h3 {
    font-size: 1.75rem;
    font-weight: 700;
    margin-bottom: 1rem;
    color: var(--color-secondary, #1c2857);
}

.contact-info-header p {
    color: rgba(28, 40, 87, 0.7);
}

.contact-info-list {
    margin-bottom: 40px;
}

.contact-info-wrapper .contact-item {
    display: flex;
    align-items: flex-start;
    margin-bottom: 20px;
    padding: 18px;
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(28, 40, 87, 0.06);
    transition: all 0.3s ease;
}

.contact-info-wrapper .contact-item:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 16px rgba(28, 40, 87, 0.1);
}

.contact-info-wrapper .contact-item:last-child {
    margin-bottom: 0;
}

.contact-info-wrapper .contact-icon {
    background: linear-gradient(135deg, var(--color-primary, #f05a25), #f88432);
    color: #fff;
    width: 44px;
    height: 44px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 16px;
    flex-shrink: 0;
}

.contact-info-wrapper .contact-icon svg {
    width: 20px;
    height: 20px;
}

.contact-info-wrapper .contact-content h6 {
    font-weight: 600;
    color: var(--color-secondary, #1c2857);
    margin-bottom: 8px;
    font-size: 1rem;
}

.contact-info-wrapper .contact-content p {
    color: rgba(28, 40, 87, 0.7);
    margin: 0;
    line-height: 1.6;
    font-size: 0.95rem;
}

.contact-info-wrapper .contact-content a {
    color: var(--color-secondary, #1c2857);
    text-decoration: none;
    transition: color 0.3s ease;
    font-weight: 500;
}

.contact-info-wrapper .contact-content a:hover {
    color: var(--color-primary, #f05a25);
}

.contact-info-wrapper .contact-list {
    display: flex;
    flex-direction: column;
    gap: 6px;
}

.contact-info-wrapper .contact-list-item {
    margin: 0 !important;
    padding: 6px 0;
    line-height: 1.6;
    color: rgba(28, 40, 87, 0.7);
    font-size: 0.95rem;
}

.contact-info-wrapper .contact-list-item:first-child {
    padding-top: 0;
}

.contact-info-wrapper .contact-list-item a {
    color: var(--color-secondary, #1c2857);
    text-decoration: none;
    font-weight: 500;
    transition: color 0.2s ease;
}

.contact-info-wrapper .contact-list-item a:hover {
    color: var(--color-primary, #f05a25);
}

.social-media-section {
    text-align: center;
    padding-top: 30px;
    border-top: 1px solid rgba(28, 40, 87, 0.1);
}

.social-media-section h6 {
    font-weight: 600;
    color: var(--color-secondary, #1c2857);
    margin-bottom: 20px;
}

.social-links {
    display: flex;
    justify-content: center;
    gap: 15px;
    flex-wrap: wrap;
}

.social-link {
    background: #fff;
    color: var(--color-secondary, #1c2857);
    width: 45px;
    height: 45px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    text-decoration: none;
    transition: all 0.3s ease;
    box-shadow: 0 5px 15px rgba(28, 40, 87, 0.08);
}

.social-link:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 25px rgba(240, 90, 37, 0.2);
    background: linear-gradient(135deg, var(--color-primary, #f05a25), #f88432);
    color: #fff;
}

.map-section {
    padding: 80px 0;
    background: rgba(28, 40, 87, 0.02);
}

.section-header {
    text-align: center;
    margin-bottom: 50px;
}

.section-header h2 {
    font-size: 2.5rem;
    font-weight: 700;
    margin-bottom: 1rem;
    color: var(--color-secondary, #1c2857);
}

.section-header p {
    color: rgba(28, 40, 87, 0.7);
    font-size: 1.1rem;
    max-width: 600px;
    margin: 0 auto;
}

.map-container {
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 20px 40px rgba(28, 40, 87, 0.1);
}

.map-container iframe {
    border-radius: 16px;
}

.faq-section {
    padding: 80px 0;
    background: #fff;
}

.faq-container {
    max-width: 800px;
    margin: 0 auto;
}

.accordion-item {
    border: none;
    margin-bottom: 20px;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 5px 15px rgba(28, 40, 87, 0.08);
}

.accordion-button {
    background: rgba(28, 40, 87, 0.02);
    border: none;
    padding: 20px 25px;
    font-weight: 600;
    color: var(--color-secondary, #1c2857);
    font-size: 1.1rem;
}

.accordion-button:not(.collapsed) {
    background: linear-gradient(135deg, var(--color-primary, #f05a25), #f88432);
    color: #fff;
}

.accordion-button:focus {
    box-shadow: none;
    border: none;
}

.accordion-button::after {
    filter: brightness(0) invert(1);
}

.accordion-button:not(.collapsed)::after {
    filter: brightness(0) invert(1);
}

.accordion-body {
    padding: 25px;
    background: #fff;
    color: rgba(28, 40, 87, 0.7);
    line-height: 1.6;
}

.contact-cta {
    padding: 80px 0;
    background: linear-gradient(135deg, var(--color-secondary, #1c2857) 0%, #243a6b 100%);
    color: #fff;
    text-align: center;
}

.contact-cta h2 {
    font-size: 2.5rem;
    font-weight: 700;
    margin-bottom: 1rem;
}

.contact-cta p {
    font-size: 1.25rem;
    opacity: 0.9;
    margin-bottom: 40px;
    max-width: 600px;
    margin-left: auto;
    margin-right: auto;
}

.cta-buttons {
    display: flex;
    justify-content: center;
    gap: 20px;
    flex-wrap: wrap;
}

.cta-buttons .btn {
    padding: 15px 30px;
    font-size: 1.1rem;
    font-weight: 600;
    border-radius: 12px;
    display: inline-flex;
    align-items: center;
    gap: 10px;
    transition: all 0.3s ease;
    text-decoration: none;
}

.cta-buttons .btn-primary {
    background: linear-gradient(135deg, var(--color-primary, #f05a25), #f88432);
    color: #fff;
    border: none;
}

.cta-buttons .btn-primary:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 25px rgba(240, 90, 37, 0.3);
    color: #fff;
    background: linear-gradient(135deg, #f88432, #fe9b46);
}

.cta-buttons .btn-secondary {
    background: transparent;
    color: #fff;
    border: 2px solid rgba(255, 255, 255, 0.6);
}

.cta-buttons .btn-secondary:hover {
    background: rgba(255, 255, 255, 0.1);
    color: #fff;
    border-color: #fff;
    transform: translateY(-3px);
}

/* Responsive Design */
@media (max-width: 768px) {
    .contact-hero .hero-title {
        font-size: 2rem;
    }
    
    .contact-hero .hero-subtitle {
        font-size: 1rem;
    }
    
    .contact-form-wrapper,
    .contact-info-wrapper {
        padding: 30px 20px;
    }
    
    .form-header h3 {
        font-size: 1.5rem;
    }
    
    .section-header h2 {
        font-size: 2rem;
    }
    
    .contact-cta h2 {
        font-size: 2rem;
    }
    
    .cta-buttons {
        flex-direction: column;
        align-items: center;
    }
    
    .cta-buttons .btn {
        width: 100%;
        max-width: 300px;
        justify-content: center;
    }
}

@media (max-width: 480px) {
    .contact-hero {
        padding: 60px 0;
    }
    
    .contact-form-section,
    .map-section,
    .faq-section,
    .contact-cta {
        padding: 60px 0;
    }
    
    .contact-hero .hero-title {
        font-size: 1.75rem;
    }
    
    .form-header h3 {
        font-size: 1.25rem;
    }
    
    .section-header h2 {
        font-size: 1.75rem;
    }
    
    .contact-cta h2 {
        font-size: 1.75rem;
    }
}
</style>

<?php get_footer(); ?>
