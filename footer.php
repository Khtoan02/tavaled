<?php
/**
 * The template for displaying the footer
 *
 * @package TavaLED
 */
?>
    </div><!-- #content -->
    
    <footer id="colophon" class="site-footer">
        <!-- Footer Main Content -->
        <div class="footer-main">
            <div class="container">
                <div class="footer-content">
                    <!-- Company Information -->
                    <div class="footer-section company-info">
                        <div class="footer-logo">
                            <?php
                            if (has_custom_logo()) :
                                the_custom_logo();
                            else :
                                ?>
                                <div class="logo-container">
                                    <a href="<?php echo esc_url(home_url('/')); ?>" class="logo-link">
                                        <h3 class="site-title">TavaLED</h3>
                                        <span class="site-tagline">Giải pháp LED toàn diện</span>
                                    </a>
                                    <div class="logo-shape"></div>
                                </div>
                                <?php
                            endif;
                            ?>
                        </div>
                        
                        <div class="company-description">
                            <p>TavaLED - Đơn vị tiên phong trong lĩnh vực giải pháp LED toàn diện tại Việt Nam. Chúng tôi cung cấp các sản phẩm và dịch vụ chất lượng cao với đội ngũ kỹ thuật chuyên nghiệp.</p>
                        </div>
                        
                        <div class="company-stats">
                            <div class="stat-item">
                                <div class="stat-number">500+</div>
                                <div class="stat-label">Dự án hoàn thành</div>
                            </div>
                            <div class="stat-item">
                                <div class="stat-number">10+</div>
                                <div class="stat-label">Năm kinh nghiệm</div>
                            </div>
                            <div class="stat-item">
                                <div class="stat-number">50+</div>
                                <div class="stat-label">Tỉnh thành</div>
                            </div>
                        </div>
                        
                        <div class="social-links">
                            <h5>Kết nối với chúng tôi</h5>
                            <div class="social-icons">
                                <a href="<?php echo esc_url(tavaled_get_option('facebook_url', '#')); ?>" target="_blank" rel="noopener noreferrer" aria-label="Facebook">
                                    <i class="fab fa-facebook-f"></i>
                                </a>
                                <a href="<?php echo esc_url(tavaled_get_option('youtube_url', '#')); ?>" target="_blank" rel="noopener noreferrer" aria-label="YouTube">
                                    <i class="fab fa-youtube"></i>
                                </a>
                                <a href="<?php echo esc_url(tavaled_get_option('linkedin_url', '#')); ?>" target="_blank" rel="noopener noreferrer" aria-label="LinkedIn">
                                    <i class="fab fa-linkedin-in"></i>
                                </a>
                                <a href="<?php echo esc_url(tavaled_get_option('zalo_url', '#')); ?>" target="_blank" rel="noopener noreferrer" aria-label="Zalo">
                                    <i class="fas fa-comments"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Solutions & Services -->
                    <div class="footer-section solutions">
                        <h4 class="footer-title">Giải pháp & Dịch vụ</h4>
                        <ul class="footer-menu">
                            <li><a href="/giai-phap-hien-thi">Màn hình LED</a></li>
                            <li><a href="/giai-phap-am-thanh">Thiết bị âm thanh</a></li>
                            <li><a href="/giai-phap-anh-sang">Thiết bị ánh sáng</a></li>
                            <li><a href="/den-led-duong">Đèn LED đường</a></li>
                            <li><a href="/den-led-nha-xuong">Đèn LED nhà xưởng</a></li>
                            <li><a href="/den-led-van-phong">Đèn LED văn phòng</a></li>
                            <li><a href="/den-led-san-vuon">Đèn LED sân vườn</a></li>
                            <li><a href="/den-led-trang-tri">Đèn LED trang trí</a></li>
                        </ul>
                        
                        <div class="service-highlights">
                            <div class="highlight-item">
                                <i class="fas fa-tools"></i>
                                <span>Lắp đặt & Bảo trì</span>
                            </div>
                            <div class="highlight-item">
                                <i class="fas fa-calculator"></i>
                                <span>Tư vấn & Báo giá</span>
                            </div>
                            <div class="highlight-item">
                                <i class="fas fa-truck"></i>
                                <span>Giao hàng toàn quốc</span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Company Information -->
                    <div class="footer-section company-details">
                        <h4 class="footer-title">Thông tin công ty</h4>
                        <ul class="footer-menu">
                            <li><a href="/gioi-thieu">Giới thiệu</a></li>
                            <li><a href="/ho-so-nang-luc">Hồ sơ năng lực</a></li>
                            <li><a href="/du-an-tieu-bieu">Dự án tiêu biểu</a></li>
                            <li><a href="/tin-tuc">Tin tức & Sự kiện</a></li>
                            <li><a href="/tuyen-dung">Tuyển dụng</a></li>
                            <li><a href="/lien-he">Liên hệ</a></li>
                        </ul>
                        
                        <div class="certifications">
                            <h5>Chứng nhận & Giải thưởng</h5>
                            <div class="cert-items">
                                <div class="cert-item">
                                    <i class="fas fa-certificate"></i>
                                    <span>ISO 9001:2015</span>
                                </div>
                                <div class="cert-item">
                                    <i class="fas fa-award"></i>
                                    <span>Top 10 LED Việt Nam</span>
                                </div>
                                <div class="cert-item">
                                    <i class="fas fa-medal"></i>
                                    <span>Giải thưởng chất lượng</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Contact Information -->
                    <div class="footer-section contact-info">
                        <h4 class="footer-title">Liên hệ & Hỗ trợ</h4>
                        
                        <div class="contact-details">
                            <div class="contact-item">
                                <div class="contact-icon">
                                    <i class="fas fa-map-marker-alt"></i>
                                </div>
                                <div class="contact-content">
                                    <h6>Trụ sở chính</h6>
                                    <p>123 Đường ABC, Quận 1, TP.HCM</p>
                                </div>
                            </div>
                            
                            <div class="contact-item">
                                <div class="contact-icon">
                                    <i class="fas fa-phone-alt"></i>
                                </div>
                                <div class="contact-content">
                                    <h6>Điện thoại</h6>
                                    <p>
                                        <a href="tel:<?php echo tavaled_format_phone(tavaled_get_option('phone_number', '0123 456 789')); ?>">
                                            <?php echo esc_html(tavaled_get_option('phone_number', '0123 456 789')); ?>
                                        </a>
                                    </p>
                                </div>
                            </div>
                            
                            <div class="contact-item">
                                <div class="contact-icon">
                                    <i class="fas fa-envelope"></i>
                                </div>
                                <div class="contact-content">
                                    <h6>Email</h6>
                                    <p>
                                        <a href="mailto:<?php echo esc_attr(tavaled_get_option('email_address', 'support@tavaled.vn')); ?>">
                                            <?php echo esc_html(tavaled_get_option('email_address', 'support@tavaled.vn')); ?>
                                        </a>
                                    </p>
                                </div>
                            </div>
                            
                            <div class="contact-item">
                                <div class="contact-icon">
                                    <i class="fas fa-clock"></i>
                                </div>
                                <div class="contact-content">
                                    <h6>Giờ làm việc</h6>
                                    <p>Thứ 2 - Thứ 6: 8:00 - 17:30<br>
                                    Thứ 7: 8:00 - 12:00</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="support-cta">
                            <h5>Hỗ trợ khách hàng 24/7</h5>
                            <a href="#contact-popup" class="btn-support popup-trigger">
                                <i class="fas fa-headset"></i>
                                Tư vấn miễn phí
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Footer Bottom -->
        <div class="footer-bottom">
            <div class="container">
                <div class="footer-bottom-content">
                    <!-- Copyright & Legal -->
                    <div class="footer-legal">
                        <div class="copyright">
                            <p>&copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?>. 
                            <?php esc_html_e('All rights reserved.', 'tavaled-theme'); ?>
                        Designed by <a href="https://zalo.me/0329249536">Khánh Toàn</a></p>
                        </div>
                        
                        <div class="legal-links">
                            <a href="/chinh-sach-bao-mat">Chính sách bảo mật</a>
                            <a href="/dieu-khoan-su-dung">Điều khoản sử dụng</a>
                            <a href="/chinh-sach-hoan-tien">Chính sách hoàn tiền</a>
                            <a href="/chinh-sach-bao-hanh">Chính sách bảo hành</a>
                        </div>
                    </div>
                    <!-- Back to Top -->
                    <div class="back-to-top-wrapper">
                        <button id="back-to-top" class="back-to-top" aria-label="<?php esc_attr_e('Back to top', 'tavaled-theme'); ?>">
                            <i class="fas fa-chevron-up"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        
    </footer><!-- #colophon -->
</div><!-- #page -->

<!-- Contact Popup -->
<?php get_template_part('template-parts/popup/popup-contact'); ?>

<!-- Newsletter Success Modal -->
<div class="modal fade" id="newsletterModal" tabindex="-1" aria-labelledby="newsletterModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header border-0">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <i class="fas fa-check-circle text-success" style="font-size: 3rem;"></i>
                <h5 class="mt-3">Đăng ký thành công!</h5>
                <p class="text-muted">Cảm ơn bạn đã đăng ký nhận tin tức từ TavaLED.</p>
            </div>
        </div>
    </div>
</div>

<?php wp_footer(); ?>

<!-- Additional Scripts -->
<script>
(function() {
    // Back to top button
    var backToTop = document.getElementById('back-to-top');
    
    window.addEventListener('scroll', function() {
        if (window.pageYOffset > 300) {
            backToTop.classList.add('show');
        } else {
            backToTop.classList.remove('show');
        }
    });
    
    backToTop.addEventListener('click', function() {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    });
    
    // Newsletter subscription
    var subscribeForm = document.querySelector('.subscribe-form');
    var newsletterModal = new bootstrap.Modal(document.getElementById('newsletterModal'));
    
    if (subscribeForm) {
        subscribeForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Simulate form submission
            setTimeout(function() {
                newsletterModal.show();
                subscribeForm.reset();
            }, 500);
        });
    }
    
    // Mobile menu
    var mobileToggle = document.querySelector('.mobile-menu-toggle');
    var mobileMenu = document.querySelector('.mobile-menu');
    var mobileOverlay = document.querySelector('.mobile-menu-overlay');
    var mobileClose = document.querySelector('.mobile-menu-close');
    var body = document.body;
    
    function toggleMobileMenu() {
        body.classList.toggle('mobile-menu-active');
    }
    
    if (mobileToggle) {
        mobileToggle.addEventListener('click', toggleMobileMenu);
    }
    
    if (mobileClose) {
        mobileClose.addEventListener('click', toggleMobileMenu);
    }
    
    if (mobileOverlay) {
        mobileOverlay.addEventListener('click', toggleMobileMenu);
    }
    
    // Animate stats on scroll
    var stats = document.querySelectorAll('.stat-number');
    var animated = false;
    
    function animateStats() {
        if (animated) return;
        
        var statsSection = document.querySelector('.company-stats');
        if (!statsSection) return;
        
        var rect = statsSection.getBoundingClientRect();
        if (rect.top < window.innerHeight && rect.bottom > 0) {
            stats.forEach(function(stat) {
                var target = parseInt(stat.textContent);
                var current = 0;
                var increment = target / 50;
                
                var timer = setInterval(function() {
                    current += increment;
                    if (current >= target) {
                        stat.textContent = target + '+';
                        clearInterval(timer);
                    } else {
                        stat.textContent = Math.floor(current) + '+';
                    }
                }, 50);
            });
            animated = true;
        }
    }
    
    window.addEventListener('scroll', animateStats);
    animateStats(); // Check on load

    // Product Carousel Logic
    const carousels = document.querySelectorAll('.products-carousel');

    carousels.forEach(carousel => {
        const track = carousel.querySelector('.carousel-track');
        const prevBtn = carousel.querySelector('.prev-btn');
        const nextBtn = carousel.querySelector('.next-btn');
        const cards = track.querySelectorAll('.product-card');

        if (!track || !prevBtn || !nextBtn || cards.length === 0) {
            if (prevBtn) prevBtn.style.display = 'none';
            if (nextBtn) nextBtn.style.display = 'none';
            return;
        }

        let isDown = false;
        let startX;
        let scrollLeft;

        const updateNavButtons = () => {
            // Use a small timeout to wait for scroll to settle
            setTimeout(() => {
                const scrollAmount = track.scrollLeft;
                const maxScroll = track.scrollWidth - track.clientWidth;
                
                // Hide buttons if carousel is not scrollable
                if (track.scrollWidth <= track.clientWidth) {
                    prevBtn.style.display = 'none';
                    nextBtn.style.display = 'none';
                } else {
                    prevBtn.style.display = scrollAmount > 10 ? 'flex' : 'none';
                    nextBtn.style.display = scrollAmount < maxScroll - 10 ? 'flex' : 'none';
                }
            }, 350); // 350ms matches smooth scroll behavior
        };

        // Initial check
        updateNavButtons();
        window.addEventListener('resize', updateNavButtons); // Re-check on resize

        // Event listeners for nav buttons
        nextBtn.addEventListener('click', () => {
            const cardStyle = window.getComputedStyle(cards[0]);
            const cardWidth = cards[0].offsetWidth + parseFloat(cardStyle.marginRight) + parseFloat(cardStyle.marginLeft);
            track.scrollBy({ left: cardWidth, behavior: 'smooth' });
        });

        prevBtn.addEventListener('click', () => {
            const cardStyle = window.getComputedStyle(cards[0]);
            const cardWidth = cards[0].offsetWidth + parseFloat(cardStyle.marginRight) + parseFloat(cardStyle.marginLeft);
            track.scrollBy({ left: -cardWidth, behavior: 'smooth' });
        });

        // Event listeners for drag-to-scroll
        track.addEventListener('mousedown', (e) => {
            isDown = true;
            track.classList.add('active');
            startX = e.pageX - track.offsetLeft;
            scrollLeft = track.scrollLeft;
            e.preventDefault(); // Prevent text selection
        });

        track.addEventListener('mouseleave', () => {
            isDown = false;
            track.classList.remove('active');
        });

        track.addEventListener('mouseup', () => {
            isDown = false;
            track.classList.remove('active');
        });

        track.addEventListener('mousemove', (e) => {
            if (!isDown) return;
            e.preventDefault();
            const x = e.pageX - track.offsetLeft;
            const walk = (x - startX) * 2; // Scroll-fast
            track.scrollLeft = scrollLeft - walk;
        });

        track.addEventListener('scroll', updateNavButtons);
    });
})();
</script>

</body>
</html>