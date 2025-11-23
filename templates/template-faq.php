<?php
/**
 * Template Name: FAQ
 * Description: Template for FAQ/Support page
 *
 * @package TavaLED
 */

get_header();
?>

<div id="primary" class="content-area">
    <main id="main" class="site-main">
        
        <!-- Page Header -->
        <div class="page-header">
            <div class="container">
                <?php tavaled_breadcrumbs(); ?>
                <h1 class="page-title"><?php the_title(); ?></h1>
            </div>
        </div>
        
        <?php while (have_posts()) : the_post(); ?>
            
            <!-- FAQ Categories -->
            <section class="faq-categories section">
                <div class="container">
                    <div class="categories-grid grid grid-4">
                        <button class="category-btn glass-card active" data-category="all">
                            <i class="fas fa-th"></i>
                            <span><?php esc_html_e('Tất cả', 'tavaled-theme'); ?></span>
                        </button>
                        <button class="category-btn glass-card" data-category="product">
                            <i class="fas fa-lightbulb"></i>
                            <span><?php esc_html_e('Sản phẩm', 'tavaled-theme'); ?></span>
                        </button>
                        <button class="category-btn glass-card" data-category="warranty">
                            <i class="fas fa-shield-alt"></i>
                            <span><?php esc_html_e('Bảo hành', 'tavaled-theme'); ?></span>
                        </button>
                        <button class="category-btn glass-card" data-category="technical">
                            <i class="fas fa-cogs"></i>
                            <span><?php esc_html_e('Kỹ thuật', 'tavaled-theme'); ?></span>
                        </button>
                    </div>
                </div>
            </section>
            
            <!-- FAQ Content -->
            <section class="faq-content section">
                <div class="container">
                    <div class="faq-wrapper">
                        <!-- Search FAQ -->
                        <div class="faq-search glass-card">
                            <form class="search-form">
                                <input type="text" class="search-input" placeholder="<?php esc_attr_e('Tìm kiếm câu hỏi...', 'tavaled-theme'); ?>">
                                <button type="submit" class="search-button">
                                    <i class="fas fa-search"></i>
                                </button>
                            </form>
                        </div>
                        
                        <!-- FAQ Items -->
                        <div class="faq-items">
                            <?php
                            // You can use ACF repeater field or custom post type for FAQs
                            // For demo purposes, we'll create static FAQs
                            $faqs = array(
                                array(
                                    'category' => 'product',
                                    'question' => 'Đèn LED của TavaLED có tiết kiệm điện không?',
                                    'answer' => 'Đèn LED của chúng tôi tiết kiệm đến 80% điện năng so với đèn truyền thống, giúp giảm đáng kể chi phí điện hàng tháng.'
                                ),
                                array(
                                    'category' => 'product',
                                    'question' => 'Tuổi thọ của đèn LED là bao lâu?',
                                    'answer' => 'Đèn LED của TavaLED có tuổi thọ trung bình 30,000-50,000 giờ, tương đương 10-15 năm sử dụng.'
                                ),
                                array(
                                    'category' => 'warranty',
                                    'question' => 'Chính sách bảo hành của TavaLED như thế nào?',
                                    'answer' => 'Chúng tôi cung cấp chế độ bảo hành 2-5 năm tùy theo dòng sản phẩm. Bảo hành bao gồm lỗi kỹ thuật và thay thế miễn phí.'
                                ),
                                array(
                                    'category' => 'warranty',
                                    'question' => 'Làm thế nào để kích hoạt bảo hành?',
                                    'answer' => 'Quý khách chỉ cần giữ hóa đơn mua hàng và đăng ký bảo hành trên website hoặc gọi hotline của chúng tôi.'
                                ),
                                array(
                                    'category' => 'technical',
                                    'question' => 'Làm sao để chọn công suất đèn phù hợp?',
                                    'answer' => 'Công suất đèn phụ thuộc vào diện tích và mục đích sử dụng. Chúng tôi có đội ngũ tư vấn sẵn sàng hỗ trợ quý khách chọn sản phẩm phù hợp.'
                                ),
                                array(
                                    'category' => 'technical',
                                    'question' => 'Đèn LED có thể sử dụng với dimmer không?',
                                    'answer' => 'Nhiều dòng đèn LED của chúng tôi hỗ trợ dimmer. Vui lòng kiểm tra thông số kỹ thuật của từng sản phẩm.'
                                ),
                            );
                            
                            foreach ($faqs as $index => $faq) :
                                ?>
                                <div class="faq-item glass-card" data-category="<?php echo esc_attr($faq['category']); ?>">
                                    <div class="faq-question">
                                        <h3><?php echo esc_html($faq['question']); ?></h3>
                                        <button class="faq-toggle" aria-label="Toggle answer">
                                            <i class="fas fa-chevron-down"></i>
                                        </button>
                                    </div>
                                    <div class="faq-answer">
                                        <p><?php echo esc_html($faq['answer']); ?></p>
                                    </div>
                                </div>
                                <?php
                            endforeach;
                            ?>
                        </div>
                        
                        <!-- No Results -->
                        <div class="no-results" style="display: none;">
                            <p><?php esc_html_e('Không tìm thấy câu hỏi phù hợp.', 'tavaled-theme'); ?></p>
                        </div>
                    </div>
                </div>
            </section>
            
            <!-- Contact Support -->
            <section class="contact-support section">
                <div class="container">
                    <div class="support-box glass-card text-center">
                        <h2><?php esc_html_e('Cần hỗ trợ thêm?', 'tavaled-theme'); ?></h2>
                        <p><?php esc_html_e('Nếu bạn không tìm thấy câu trả lời cho câu hỏi của mình, hãy liên hệ với chúng tôi.', 'tavaled-theme'); ?></p>
                        
                        <div class="support-options">
                            <a href="tel:<?php echo tavaled_format_phone(tavaled_get_primary_phone()); ?>" class="glass-button">
                                <i class="fas fa-phone"></i>
                                <?php esc_html_e('Gọi ngay', 'tavaled-theme'); ?>
                            </a>
                            <a href="<?php echo esc_url(home_url('/lien-he')); ?>" class="glass-button secondary">
                                <i class="fas fa-envelope"></i>
                                <?php esc_html_e('Gửi email', 'tavaled-theme'); ?>
                            </a>
                        </div>
                    </div>
                </div>
            </section>
            
            <?php if (get_the_content()) : ?>
                <!-- Additional Content -->
                <section class="additional-content section">
                    <div class="container">
                        <div class="content-wrapper">
                            <?php the_content(); ?>
                        </div>
                    </div>
                </section>
            <?php endif; ?>
            
        <?php endwhile; ?>
        
    </main><!-- #main -->
</div><!-- #primary -->

<script>
(function($) {
    'use strict';
    
    // FAQ Toggle
    $('.faq-toggle').on('click', function() {
        var faqItem = $(this).closest('.faq-item');
        var answer = faqItem.find('.faq-answer');
        var icon = $(this).find('i');
        
        // Close other items
        $('.faq-item').not(faqItem).removeClass('active');
        $('.faq-answer').not(answer).slideUp();
        $('.faq-toggle i').not(icon).removeClass('fa-chevron-up').addClass('fa-chevron-down');
        
        // Toggle current item
        faqItem.toggleClass('active');
        answer.slideToggle();
        icon.toggleClass('fa-chevron-down fa-chevron-up');
    });
    
    // Category Filter
    $('.category-btn').on('click', function() {
        var category = $(this).data('category');
        
        // Update active button
        $('.category-btn').removeClass('active');
        $(this).addClass('active');
        
        // Filter items
        if (category === 'all') {
            $('.faq-item').show();
        } else {
            $('.faq-item').hide();
            $('.faq-item[data-category="' + category + '"]').show();
        }
        
        // Check if no results
        checkNoResults();
    });
    
    // Search
    $('.search-input').on('keyup', function() {
        var searchTerm = $(this).val().toLowerCase();
        
        $('.faq-item').each(function() {
            var question = $(this).find('.faq-question h3').text().toLowerCase();
            var answer = $(this).find('.faq-answer p').text().toLowerCase();
            
            if (question.indexOf(searchTerm) > -1 || answer.indexOf(searchTerm) > -1) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
        
        checkNoResults();
    });
    
    // Check no results
    function checkNoResults() {
        if ($('.faq-item:visible').length === 0) {
            $('.no-results').show();
        } else {
            $('.no-results').hide();
        }
    }
    
})(jQuery);
</script>

<?php
get_footer();