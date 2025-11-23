<?php
/**
 * The front page template file - Redesigned
 *
 * @package TavaLED
 */

get_header();
?>

<div id="primary" class="content-area">
    <main id="main" class="site-main">
        
        <!-- Hero Section -->
        <section class="hero-section">
            <div class="hero-background">
                <div class="hero-overlay"></div>
            </div>
            <div class="container">
                <div class="hero-content">
                    <div class="hero-text">
                        <div class="hero-badge">
                            <i class="fas fa-star"></i>
                            <span>Giải pháp LED hàng đầu Việt Nam</span>
                        </div>
                        <h1 class="hero-title">
                            <span class="title-highlight">TavaLED</span> - 
                            <span class="title-main">Chuyên nghiệp trong từng giải pháp</span>
                        </h1>
                        <p class="hero-subtitle">
                            Chúng tôi là <strong>doanh nghiệp chuyên cung cấp giải pháp màn hình LED</strong> với công nghệ tiên tiến, 
                            <strong>chất lượng đảm bảo</strong> và <strong>dịch vụ tận tâm</strong> cho mọi dự án
                        </p>
                        
                        <div class="hero-usps">
                            <div class="usp-item">
                                <div class="usp-icon">
                                    <i class="fas fa-award"></i>
                                </div>
                                <div class="usp-content">
                                    <h4>Chất lượng đỉnh cao</h4>
                                    <p>Sản phẩm đạt chuẩn quốc tế, uy tín hàng đầu</p>
                                </div>
                            </div>
                            <div class="usp-item">
                                <div class="usp-icon">
                                    <i class="fas fa-handshake"></i>
                                </div>
                                <div class="usp-content">
                                    <h4>Đối tác tin cậy</h4>
                                    <p>500+ dự án thành công, hàng trăm khách hàng hài lòng</p>
                                </div>
                            </div>
                            <div class="usp-item">
                                <div class="usp-icon">
                                    <i class="fas fa-shield-alt"></i>
                                </div>
                                <div class="usp-content">
                                    <h4>Bảo hành & Hỗ trợ</h4>
                                    <p>Bảo hành 3 năm, hỗ trợ 24/7, dịch vụ sau bán hàng tận tâm</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="hero-actions">
                            <a href="<?php echo esc_url(home_url('/san-pham')); ?>" class="btn-primary">
                                <i class="fas fa-eye"></i>
                                <span>Khám phá sản phẩm</span>
                            </a>
                            <a href="#contact-popup" class="btn-secondary popup-trigger">
                                <i class="fas fa-calculator"></i>
                                <span>Nhận báo giá miễn phí</span>
                            </a>
                        </div>
                        
                        <div class="hero-trust">
                            <div class="trust-item">
                                <i class="fas fa-users"></i>
                                <span>500+ Khách hàng tin tưởng</span>
                            </div>
                            <div class="trust-item">
                                <i class="fas fa-project-diagram"></i>
                                <span>500+ Dự án hoàn thành</span>
                            </div>
                            <div class="trust-item">
                                <i class="fas fa-map-marker-alt"></i>
                                <span>Phục vụ toàn quốc</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="hero-visual">
                        <div class="hero-showcase">
                            <div class="showcase-main">
                                <div class="showcase-item featured">
                                    <div class="showcase-image">
                                        <img src="https://channel.mediacdn.vn/428462621602512896/2024/1/8/photo-1-1704700996370761002934.jpg" alt="Màn hình LED Indoor">
                                    </div>
                                    <div class="showcase-label">
                                        <i class="fas fa-tv"></i>
                                        <span>Màn hình LED Indoor</span>
                                    </div>
                                </div>
                                <div class="showcase-item">
                                    <div class="showcase-image">
                                        <img src="https://phucthanhnhan.com/contents_images/images/kich-thuoc-man-hinh-led-2.jpg" alt="Màn hình LED Outdoor">
                                    </div>
                                    <div class="showcase-label">
                                        <i class="fas fa-sun"></i>
                                        <span>LED Outdoor</span>
                                    </div>
                                </div>
                                <div class="showcase-item">
                                    <div class="showcase-image">
                                        <img src="https://ledvietking.com.vn/wp-content/uploads/2020/05/man-hinh-led-fashion-tv-show.jpg" alt="Màn hình LED Sự kiện">
                                    </div>
                                    <div class="showcase-label">
                                        <i class="fas fa-calendar-alt"></i>
                                        <span>LED Sự kiện</span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="hero-stats">
                                <div class="stat-item">
                                    <div class="stat-number" data-count="500">0</div>
                                    <div class="stat-label">Dự án hoàn thành</div>
                                </div>
                                <div class="stat-item">
                                    <div class="stat-number" data-count="500">0</div>
                                    <div class="stat-label">Khách hàng tin tưởng</div>
                                </div>
                                <div class="stat-item">
                                    <div class="stat-number" data-count="5">0</div>
                                    <div class="stat-label">Năm kinh nghiệm</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        
        <!-- About & Mission Section -->
        <section class="about-mission-section">
            <div class="container">
                <div class="section-header">
                    <div class="section-badge">
                        <i class="fas fa-building"></i>
                        <span>Về chúng tôi</span>
                    </div>
                    <div class="section-title">
                        <h2>Doanh nghiệp màn hình LED chuyên nghiệp</h2>
                        <p>TavaLED tự hào là đơn vị hàng đầu trong lĩnh vực cung cấp giải pháp màn hình LED tại Việt Nam</p>
                    </div>
                </div>
                
                <div class="about-content">
                    <div class="about-text">
                        <div class="about-item">
                            <div class="about-icon">
                                <i class="fas fa-bullseye"></i>
                            </div>
                            <div class="about-content-text">
                                <h3>Sứ mệnh của chúng tôi</h3>
                                <p>Mang đến những giải pháp màn hình LED chất lượng cao, công nghệ tiên tiến, giúp khách hàng thể hiện thông điệp một cách ấn tượng và hiệu quả nhất. Chúng tôi cam kết đặt chất lượng và sự hài lòng của khách hàng lên hàng đầu.</p>
                            </div>
                        </div>
                        
                        <div class="about-item">
                            <div class="about-icon">
                                <i class="fas fa-eye"></i>
                            </div>
                            <div class="about-content-text">
                                <h3>Tầm nhìn</h3>
                                <p>Trở thành doanh nghiệp dẫn đầu về giải pháp màn hình LED tại Việt Nam và khu vực, được công nhận bởi chất lượng sản phẩm, dịch vụ chuyên nghiệp và sự tin cậy từ đối tác, khách hàng.</p>
                            </div>
                        </div>
                        
                        <div class="about-item">
                            <div class="about-icon">
                                <i class="fas fa-gem"></i>
                            </div>
                            <div class="about-content-text">
                                <h3>Giá trị cốt lõi</h3>
                                <p><strong>Chất lượng:</strong> Sản phẩm đạt chuẩn quốc tế, bền bỉ theo thời gian. <strong>Uy tín:</strong> Cam kết thực hiện đúng như đã hứa. <strong>Chuyên nghiệp:</strong> Đội ngũ giàu kinh nghiệm, dịch vụ tận tâm. <strong>Đổi mới:</strong> Luôn cập nhật công nghệ mới nhất.</p>
                            </div>
                        </div>
                        
                        <div class="about-item">
                            <div class="about-icon">
                                <i class="fas fa-sync-alt"></i>
                            </div>
                            <div class="about-content-text">
                                <h3>Đồng bộ thông số dự án</h3>
                                <p>Chúng tôi đảm bảo đồng bộ hóa toàn bộ thông số kỹ thuật cho mọi dự án, từ thiết kế đến thi công và bảo trì, đảm bảo tính nhất quán và hiệu quả tối đa.</p>
                            </div>
                        </div>
                        
                        <div class="about-item">
                            <div class="about-icon">
                                <i class="fas fa-chart-line"></i>
                            </div>
                            <div class="about-content-text">
                                <h3>Kinh nghiệm</h3>
                                <p>Với nhiều năm kinh nghiệm trong ngành, chúng tôi đã thực hiện hàng trăm dự án thành công, từ các dự án nhỏ đến các dự án quy mô lớn trên toàn quốc.</p>
                            </div>
                        </div>
                        
                        <div class="about-item">
                            <div class="about-icon">
                                <i class="fas fa-handshake"></i>
                            </div>
                            <div class="about-content-text">
                                <h3>Khách hàng</h3>
                                <p>Chúng tôi tự hào phục vụ hàng trăm khách hàng uy tín, từ các doanh nghiệp nhỏ đến các tập đoàn lớn, với tỷ lệ hài lòng và quay lại sử dụng dịch vụ rất cao.</p>
                            </div>
                        </div>
                        
                        <div class="about-item">
                            <div class="about-icon">
                                <i class="fas fa-clipboard-list"></i>
                            </div>
                            <div class="about-content-text">
                                <h3>Sản phẩm với thông số</h3>
                                <p>Tất cả sản phẩm của chúng tôi đều được cung cấp đầy đủ thông số kỹ thuật chi tiết, giúp khách hàng dễ dàng lựa chọn và so sánh sản phẩm phù hợp nhất với nhu cầu của mình.</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="about-stats">
                        <div class="stat-box">
                            <div class="stat-icon">
                                <i class="fas fa-tv"></i>
                            </div>
                            <div class="stat-number" data-count="120">0</div>
                            <div class="stat-label">Sản phẩm đa dạng</div>
                        </div>
                        <div class="stat-box">
                            <div class="stat-icon">
                                <i class="fas fa-users"></i>
                            </div>
                            <div class="stat-number" data-count="1800">0</div>
                            <div class="stat-label">Khách hàng hài lòng</div>
                        </div>
                        <div class="stat-box">
                            <div class="stat-icon">
                                <i class="fas fa-project-diagram"></i>
                            </div>
                            <div class="stat-number" data-count="1200">0</div>
                            <div class="stat-label">Dự án thành công</div>
                        </div>
                        <div class="stat-box">
                            <div class="stat-icon">
                                <i class="fas fa-calendar-alt"></i>
                            </div>
                            <div class="stat-number" data-count="8">0</div>
                            <div class="stat-label">Năm kinh nghiệm</div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        
        <!-- Solutions Section -->
        <section class="solutions-section">
            <div class="container">
                <div class="section-header">
                    <div class="section-badge">
                        <i class="fas fa-cogs"></i>
                        <span>Giải pháp chuyên nghiệp</span>
                    </div>
                    <div class="section-title">
                        <h2>Giải pháp LED toàn diện</h2>
                        <p>Chúng tôi cung cấp đầy đủ giải pháp LED chất lượng cao, đáp ứng mọi nhu cầu từ quảng cáo đến chiếu sáng thông minh</p>
                    </div>
                </div>
                
                <div class="solutions-grid">
                    <div class="solution-card" data-category="display">
                        <div class="solution-header">
                            <div class="solution-icon">
                                <i class="fas fa-tv"></i>
                            </div>
                            <div class="solution-badge">Bán chạy</div>
                        </div>
                        <div class="solution-content">
                            <h3>Giải pháp hiển thị</h3>
                            <p class="solution-description">Màn hình LED chất lượng cao cho quảng cáo, sự kiện và thông tin với độ phân giải sắc nét</p>
                            
                            <div class="solution-features">
                                <div class="feature-item">
                                    <i class="fas fa-check"></i>
                                    <span>Màn hình LED Indoor/Outdoor</span>
                                </div>
                                <div class="feature-item">
                                    <i class="fas fa-check"></i>
                                    <span>Màn hình LED cho sân khấu</span>
                                </div>
                                <div class="feature-item">
                                    <i class="fas fa-check"></i>
                                    <span>Màn hình LED cho sự kiện</span>
                                </div>
                                <div class="feature-item">
                                    <i class="fas fa-check"></i>
                                    <span>Độ phân giải 4K Ultra HD</span>
                                </div>
                            </div>
                            
                            <div class="solution-benefits">
                                <div class="benefit-item">
                                    <i class="fas fa-bolt"></i>
                                    <span>Tiết kiệm 60% điện</span>
                                </div>
                                <div class="benefit-item">
                                    <i class="fas fa-shield-alt"></i>
                                    <span>Bảo hành 3 năm</span>
                                </div>
                            </div>
                            
                            <div class="solution-actions">
                                <a href="/giai-phap-hien-thi" class="btn-primary">
                                    <span>Xem chi tiết</span>
                                </a>
                                <a href="#contact-popup" class="btn-outline popup-trigger">
                                    <span>Báo giá</span>
                                </a>
                            </div>
                        </div>
                    </div>
                    
                    <div class="solution-card" data-category="audio">
                        <div class="solution-header">
                            <div class="solution-icon">
                                <i class="fas fa-volume-up"></i>
                            </div>
                            <div class="solution-badge">Chuyên nghiệp</div>
                        </div>
                        <div class="solution-content">
                            <h3>Giải pháp âm thanh</h3>
                            <p class="solution-description">Hệ thống âm thanh chuyên nghiệp với công nghệ tiên tiến cho mọi không gian và sự kiện</p>
                            
                            <div class="solution-features">
                                <div class="feature-item">
                                    <i class="fas fa-check"></i>
                                    <span>Loa công suất cao</span>
                                </div>
                                <div class="feature-item">
                                    <i class="fas fa-check"></i>
                                    <span>Ampli và mixer chuyên nghiệp</span>
                                </div>
                                <div class="feature-item">
                                    <i class="fas fa-check"></i>
                                    <span>Hệ thống âm thanh hội trường</span>
                                </div>
                                <div class="feature-item">
                                    <i class="fas fa-check"></i>
                                    <span>Âm thanh surround 7.1</span>
                                </div>
                            </div>
                            
                            <div class="solution-benefits">
                                <div class="benefit-item">
                                    <i class="fas fa-volume-up"></i>
                                    <span>Âm thanh sắc nét</span>
                                </div>
                                <div class="benefit-item">
                                    <i class="fas fa-tools"></i>
                                    <span>Lắp đặt chuyên nghiệp</span>
                                </div>
                            </div>
                            
                            <div class="solution-actions">
                                <a href="/giai-phap-am-thanh" class="btn-primary">
                                    <span>Xem chi tiết</span>
                                </a>
                                <a href="#contact-popup" class="btn-outline popup-trigger">
                                    <span>Báo giá</span>
                                </a>
                            </div>
                        </div>
                    </div>
                    
                    <div class="solution-card" data-category="lighting">
                        <div class="solution-header">
                            <div class="solution-icon">
                                <i class="fas fa-lightbulb"></i>
                            </div>
                            <div class="solution-badge">Thông minh</div>
                        </div>
                        <div class="solution-content">
                            <h3>Giải pháp ánh sáng</h3>
                            <p class="solution-description">Chiếu sáng LED thông minh với công nghệ IoT, tiết kiệm năng lượng và thân thiện môi trường</p>
                            
                            <div class="solution-features">
                                <div class="feature-item">
                                    <i class="fas fa-check"></i>
                                    <span>Đèn LED công nghiệp</span>
                                </div>
                                <div class="feature-item">
                                    <i class="fas fa-check"></i>
                                    <span>Đèn LED trang trí</span>
                                </div>
                                <div class="feature-item">
                                    <i class="fas fa-check"></i>
                                    <span>Hệ thống điều khiển thông minh</span>
                                </div>
                                <div class="feature-item">
                                    <i class="fas fa-check"></i>
                                    <span>Điều khiển qua smartphone</span>
                                </div>
                            </div>
                            
                            <div class="solution-benefits">
                                <div class="benefit-item">
                                    <i class="fas fa-leaf"></i>
                                    <span>Tiết kiệm 70% điện</span>
                                </div>
                                <div class="benefit-item">
                                    <i class="fas fa-mobile-alt"></i>
                                    <span>Điều khiển từ xa</span>
                                </div>
                            </div>
                            
                            <div class="solution-actions">
                                <a href="/giai-phap-anh-sang" class="btn-primary">
                                    <span>Xem chi tiết</span>
                                </a>
                                <a href="#contact-popup" class="btn-outline popup-trigger">
                                    <span>Báo giá</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="solutions-cta">
                    <div class="cta-content">
                        <h3>Không tìm thấy giải pháp phù hợp?</h3>
                        <p>Đội ngũ chuyên gia của chúng tôi sẽ tư vấn và thiết kế giải pháp riêng biệt cho dự án của bạn</p>
                        <div class="cta-actions">
                            <a href="#contact-popup" class="btn-primary popup-trigger">
                                <i class="fas fa-headset"></i>
                                <span>Tư vấn miễn phí</span>
                            </a>
                            <a href="tel:<?php echo tavaled_format_phone(tavaled_get_primary_phone()); ?>" class="btn-secondary">
                                <i class="fas fa-phone"></i>
                                <span>Gọi ngay</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        
        <!-- Quality & Trust Section -->
        <section class="quality-trust-section">
            <div class="container">
                <div class="section-header">
                    <div class="section-badge">
                        <i class="fas fa-certificate"></i>
                        <span>Chất lượng & Uy tín</span>
                    </div>
                    <div class="section-title">
                        <h2>Cam kết chất lượng và uy tín</h2>
                        <p>Chúng tôi tự hào về chất lượng sản phẩm và dịch vụ, được khẳng định bởi các chứng nhận và sự tin tưởng của khách hàng</p>
                    </div>
                </div>
                
                <div class="quality-content">
                    <div class="quality-grid">
                        <div class="quality-item">
                            <div class="quality-icon">
                                <i class="fas fa-star"></i>
                            </div>
                            <h3>Chất lượng đảm bảo</h3>
                            <p>Sản phẩm được lựa chọn kỹ lưỡng từ các nhà sản xuất uy tín, đảm bảo an toàn và đáng tin cậy.</p>
                        </div>
                        
                        <div class="quality-item">
                            <div class="quality-icon">
                                <i class="fas fa-shield-alt"></i>
                            </div>
                            <h3>Bảo hành dài hạn</h3>
                            <p>Bảo hành 3 năm cho sản phẩm, hỗ trợ kỹ thuật 24/7, dịch vụ bảo trì định kỳ.</p>
                        </div>
                        
                        <div class="quality-item">
                            <div class="quality-icon">
                                <i class="fas fa-check-circle"></i>
                            </div>
                            <h3>Kiểm tra nghiêm ngặt</h3>
                            <p>Mỗi sản phẩm đều được kiểm tra kỹ lưỡng trước khi giao hàng, đảm bảo chất lượng 100%.</p>
                        </div>
                        
                        <div class="quality-item">
                            <div class="quality-icon">
                                <i class="fas fa-handshake"></i>
                            </div>
                            <h3>Đối tác uy tín</h3>
                            <p>Hợp tác với các nhà sản xuất hàng đầu thế giới, đảm bảo nguồn gốc và chất lượng sản phẩm.</p>
                        </div>
                    </div>
                    
                    <div class="service-commitments">
                        <h3>Cam kết dịch vụ</h3>
                        <div class="commitment-grid">
                            <div class="commitment-item">
                                <i class="fas fa-clock"></i>
                                <span>Phản hồi nhanh chóng</span>
                                <p>Trả lời trong 30 phút</p>
                            </div>
                            <div class="commitment-item">
                                <i class="fas fa-tools"></i>
                                <span>Lắp đặt chuyên nghiệp</span>
                                <p>Đội ngũ kỹ thuật giàu kinh nghiệm</p>
                            </div>
                            <div class="commitment-item">
                                <i class="fas fa-headset"></i>
                                <span>Hỗ trợ 24/7</span>
                                <p>Luôn sẵn sàng phục vụ</p>
                            </div>
                            <div class="commitment-item">
                                <i class="fas fa-heart"></i>
                                <span>Dịch vụ tận tâm</span>
                                <p>Đặt khách hàng lên hàng đầu</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        
        <!-- Featured Products Section -->
        <section class="products-section">
            <div class="container">
                <div class="section-header">
                    <div class="section-badge">
                        <i class="fas fa-star"></i>
                        <span>Sản phẩm chất lượng</span>
                    </div>
                    <div class="section-title">
                        <h2>Sản phẩm LED nổi bật</h2>
                        <p>Khám phá bộ sưu tập sản phẩm LED chất lượng cao, đa dạng mẫu mã và giá cả cạnh tranh</p>
                    </div>
                </div>
                
                <!-- Products Tabs -->
                <div class="products-tabs">
                    <div class="tabs-nav">
                        <button class="tab-btn active" data-tab="all">
                            <i class="fas fa-th-large"></i>
                            <span>Tất cả sản phẩm</span>
                        </button>
                        <button class="tab-btn" data-tab="man-hinh-led">
                            <i class="fas fa-tv"></i>
                            <span>Màn hình LED</span>
                        </button>
                        <button class="tab-btn" data-tab="he-thong-am-thanh">
                            <i class="fas fa-volume-up"></i>
                            <span>Âm thanh</span>
                        </button>
                        <button class="tab-btn" data-tab="he-thong-anh-sang">
                            <i class="fas fa-lightbulb"></i>
                            <span>Ánh sáng</span>
                        </button>
                    </div>
                </div>
                
                <!-- Products Carousels -->
                <?php
                // Helper function to render product card
                if (!function_exists('tavaled_render_product_card')) {
                    function tavaled_render_product_card($product) {
                        if (!$product) return '';
                        
                        $product_id = $product->get_id();
                        $product_title = $product->get_name();
                        $product_image_id = $product->get_image_id();
                        $product_image_url = $product_image_id ? wp_get_attachment_image_url($product_image_id, 'medium') : get_template_directory_uri() . '/assets/images/product-placeholder.jpg';
                        $category_names = wp_get_post_terms($product_id, 'product_cat', array('fields' => 'names'));
                        
                        // Determine badge
                        $product_badge = '';
                        if ($product->is_on_sale()) {
                            $product_badge = 'sale';
                        } elseif ($product->is_featured()) {
                            $product_badge = 'hot';
                        } elseif (strtotime($product->get_date_created()) > strtotime('-30 days')) {
                            $product_badge = 'new';
                        }
                        
                        ob_start();
                        ?>
                        <div class="product-card">
                            <div class="product-image-wrapper">
                                <?php if ($product_badge) : ?>
                                    <div class="product-badge">
                                        <?php if ($product_badge === 'hot') : ?>
                                            <span class="badge-hot">Bán chạy</span>
                                        <?php elseif ($product_badge === 'new') : ?>
                                            <span class="badge-new">Mới</span>
                                        <?php elseif ($product_badge === 'sale') : ?>
                                            <span class="badge-sale">Giảm giá</span>
                                        <?php endif; ?>
                                    </div>
                                <?php endif; ?>
                                
                                <a href="<?php echo esc_url($product->get_permalink()); ?>" class="product-image-link">
                                    <img src="<?php echo esc_url($product_image_url); ?>" alt="<?php echo esc_attr($product_title); ?>" class="product-image">
                                </a>
                                
                                <div class="product-quick-action">
                                    <a href="<?php echo esc_url($product->get_permalink()); ?>" class="quick-btn" title="Xem chi tiết">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="#contact-popup" class="quick-btn popup-trigger" title="Báo giá">
                                        <i class="fas fa-calculator"></i>
                                    </a>
                                </div>
                            </div>
                            
                            <div class="product-content">
                                <div class="product-category">
                                    <i class="fas fa-tag"></i>
                                    <span><?php echo !empty($category_names) ? esc_html($category_names[0]) : 'Sản phẩm LED'; ?></span>
                                </div>
                                
                                <h3 class="product-title">
                                    <a href="<?php echo esc_url($product->get_permalink()); ?>"><?php echo esc_html($product_title); ?></a>
                                </h3>
                                
                                <p class="product-description"><?php echo wp_trim_words($product->get_short_description() ?: $product->get_description(), 12); ?></p>
                                
                                <div class="product-footer">
                                    <a href="<?php echo esc_url($product->get_permalink()); ?>" class="product-link-btn">
                                        <span>Xem chi tiết</span>
                                        <i class="fas fa-arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <?php
                        return ob_get_clean();
                    }
                }
                
                // Check if WooCommerce is active
                if (class_exists('WooCommerce')) {
                    // Tab: All Products
                    $all_products_args = array(
                        'post_type' => 'product',
                        'post_status' => 'publish',
                        'posts_per_page' => 12,
                        'orderby' => 'date',
                        'order' => 'DESC'
                    );
                    $all_products_query = new WP_Query($all_products_args);
                    ?>
                    
                    <!-- All Products Carousel -->
                    <div class="products-carousel active" data-tab="all">
                        <div class="carousel-wrapper">
                            <div class="carousel-container">
                                <div class="carousel-track">
                                    <?php
                                    if ($all_products_query->have_posts()) :
                                        while ($all_products_query->have_posts()) :
                                            $all_products_query->the_post();
                                            $product = wc_get_product(get_the_ID());
                                            if (!$product) continue;
                                            echo tavaled_render_product_card($product);
                                        endwhile;
                                        wp_reset_postdata();
                                    endif;
                                    ?>
                                </div>
                            </div>
                            
                            <button class="carousel-nav carousel-prev" aria-label="Sản phẩm trước">
                                <i class="fas fa-chevron-left"></i>
                            </button>
                            
                            <button class="carousel-nav carousel-next" aria-label="Sản phẩm sau">
                                <i class="fas fa-chevron-right"></i>
                            </button>
                        </div>
                    </div>
                    
                    <?php
                    // Tab: Màn hình LED
                    $led_products_args = array(
                        'post_type' => 'product',
                        'post_status' => 'publish',
                        'posts_per_page' => 12,
                        'tax_query' => array(
                            array(
                                'taxonomy' => 'product_cat',
                                'field' => 'slug',
                                'terms' => 'man-hinh-led'
                            )
                        )
                    );
                    $led_products_query = new WP_Query($led_products_args);
                    ?>
                    
                    <!-- LED Products Carousel -->
                    <div class="products-carousel" data-tab="man-hinh-led">
                        <div class="carousel-wrapper">
                            <div class="carousel-container">
                                <div class="carousel-track">
                                    <?php
                                    if ($led_products_query->have_posts()) :
                                        while ($led_products_query->have_posts()) :
                                            $led_products_query->the_post();
                                            $product = wc_get_product(get_the_ID());
                                            if (!$product) continue;
                                            echo tavaled_render_product_card($product);
                                        endwhile;
                                        wp_reset_postdata();
                                    else : ?>
                                        <div class="no-products-message">
                                            <p>Chưa có sản phẩm màn hình LED nào.</p>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            
                            <button class="carousel-nav carousel-prev" aria-label="Sản phẩm trước">
                                <i class="fas fa-chevron-left"></i>
                            </button>
                            
                            <button class="carousel-nav carousel-next" aria-label="Sản phẩm sau">
                                <i class="fas fa-chevron-right"></i>
                            </button>
                        </div>
                    </div>
                    
                    <?php
                    // Tab: Hệ thống âm thanh
                    $audio_products_args = array(
                        'post_type' => 'product',
                        'post_status' => 'publish',
                        'posts_per_page' => 12,
                        'tax_query' => array(
                            array(
                                'taxonomy' => 'product_cat',
                                'field' => 'slug',
                                'terms' => 'he-thong-am-thanh'
                            )
                        )
                    );
                    $audio_products_query = new WP_Query($audio_products_args);
                    ?>
                    
                    <!-- Audio Products Carousel -->
                    <div class="products-carousel" data-tab="he-thong-am-thanh">
                        <div class="carousel-wrapper">
                            <div class="carousel-container">
                                <div class="carousel-track">
                                    <?php
                                    if ($audio_products_query->have_posts()) :
                                        while ($audio_products_query->have_posts()) :
                                            $audio_products_query->the_post();
                                            $product = wc_get_product(get_the_ID());
                                            if (!$product) continue;
                                            echo tavaled_render_product_card($product);
                                        endwhile;
                                        wp_reset_postdata();
                                    else : ?>
                                        <div class="no-products-message">
                                            <p>Chưa có sản phẩm âm thanh nào.</p>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            
                            <button class="carousel-nav carousel-prev" aria-label="Sản phẩm trước">
                                <i class="fas fa-chevron-left"></i>
                            </button>
                            
                            <button class="carousel-nav carousel-next" aria-label="Sản phẩm sau">
                                <i class="fas fa-chevron-right"></i>
                            </button>
                        </div>
                    </div>
                    
                    <?php
                    // Tab: Hệ thống ánh sáng
                    $lighting_products_args = array(
                        'post_type' => 'product',
                        'post_status' => 'publish',
                        'posts_per_page' => 12,
                        'tax_query' => array(
                            array(
                                'taxonomy' => 'product_cat',
                                'field' => 'slug',
                                'terms' => 'he-thong-anh-sang'
                            )
                        )
                    );
                    $lighting_products_query = new WP_Query($lighting_products_args);
                    ?>
                    
                    <!-- Lighting Products Carousel -->
                    <div class="products-carousel" data-tab="he-thong-anh-sang">
                        <div class="carousel-wrapper">
                            <div class="carousel-container">
                                <div class="carousel-track">
                                    <?php
                                    if ($lighting_products_query->have_posts()) :
                                        while ($lighting_products_query->have_posts()) :
                                            $lighting_products_query->the_post();
                                            $product = wc_get_product(get_the_ID());
                                            if (!$product) continue;
                                            echo tavaled_render_product_card($product);
                                        endwhile;
                                        wp_reset_postdata();
                                    else : ?>
                                        <div class="no-products-message">
                                            <p>Chưa có sản phẩm ánh sáng nào.</p>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            
                            <button class="carousel-nav carousel-prev" aria-label="Sản phẩm trước">
                                <i class="fas fa-chevron-left"></i>
                            </button>
                            
                            <button class="carousel-nav carousel-next" aria-label="Sản phẩm sau">
                                <i class="fas fa-chevron-right"></i>
                            </button>
                        </div>
                    </div>
                    
                <?php } else { ?>
                    <div class="no-products-message">
                        <p>WooCommerce chưa được kích hoạt. Vui lòng cài đặt và kích hoạt WooCommerce plugin.</p>
                    </div>
                <?php } ?>
                
                <div class="products-cta">
                    <div class="cta-content">
                        <h3>Không tìm thấy sản phẩm phù hợp?</h3>
                        <p>Liên hệ ngay để được tư vấn và nhận báo giá chi tiết cho dự án của bạn</p>
                        <div class="cta-actions">
                            <a href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>" class="btn-primary">
                                <i class="fas fa-th-large"></i>
                                <span>Xem tất cả sản phẩm</span>
                            </a>
                            <a href="#contact-popup" class="btn-secondary popup-trigger">
                                <i class="fas fa-headset"></i>
                                <span>Tư vấn miễn phí</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        
        <!-- Why Choose Us Section -->
        <section class="why-choose-section">
            <div class="container">
                <div class="section-header">
                    <div class="section-badge">
                        <i class="fas fa-question-circle"></i>
                        <span>Tại sao chọn chúng tôi</span>
                    </div>
                    <div class="section-title">
                        <h2>Tại sao chọn TavaLED?</h2>
                        <p>Những lý do khiến hàng trăm khách hàng tin tưởng và lựa chọn chúng tôi</p>
                    </div>
                </div>
                
                <div class="why-choose-grid">
                    <div class="why-item">
                        <div class="why-icon">
                            <i class="fas fa-medal"></i>
                        </div>
                        <h3>Chất lượng đỉnh cao</h3>
                        <p>Sản phẩm đạt chuẩn quốc tế ISO 9001, CE, RoHS. Mỗi sản phẩm đều được kiểm tra nghiêm ngặt trước khi giao hàng.</p>
                    </div>
                    
                    <div class="why-item">
                        <div class="why-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <h3>Đội ngũ chuyên nghiệp</h3>
                        <p>Đội ngũ kỹ sư giàu kinh nghiệm, tư vấn tận tâm, hỗ trợ kỹ thuật 24/7, đảm bảo dự án hoàn thành đúng tiến độ.</p>
                    </div>
                    
                    <div class="why-item">
                        <div class="why-icon">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <h3>Bảo hành dài hạn</h3>
                        <p>Bảo hành 3 năm cho sản phẩm, dịch vụ bảo trì định kỳ, hỗ trợ kỹ thuật miễn phí trong suốt thời gian sử dụng.</p>
                    </div>
                    
                    <div class="why-item">
                        <div class="why-icon">
                            <i class="fas fa-headset"></i>
                        </div>
                        <h3>Hỗ trợ 24/7</h3>
                        <p>Tư vấn tận tình mọi lúc, giải đáp thắc mắc nhanh chóng, xử lý sự cố kịp thời, đảm bảo khách hàng hài lòng.</p>
                    </div>
                    
                    <div class="why-item">
                        <div class="why-icon">
                            <i class="fas fa-dollar-sign"></i>
                        </div>
                        <h3>Giá cả cạnh tranh</h3>
                        <p>Giá cả hợp lý, minh bạch, không phát sinh chi phí ẩn. Báo giá nhanh chóng, chính xác trong 24h.</p>
                    </div>
                    
                    <div class="why-item">
                        <div class="why-icon">
                            <i class="fas fa-shipping-fast"></i>
                        </div>
                        <h3>Giao hàng nhanh</h3>
                        <p>Giao hàng toàn quốc, đúng hẹn, đóng gói cẩn thận. Hỗ trợ lắp đặt và vận chuyển chuyên nghiệp.</p>
                    </div>
                </div>
            </div>
        </section>
        
        <!-- Partners Section -->
        <section class="partners-section">
            <div class="container">
                <div class="section-header">
                    <div class="section-badge">
                        <i class="fas fa-handshake"></i>
                        <span>Đối tác & Khách hàng</span>
                    </div>
                    <div class="section-title">
                        <h2>Đối tác tin cậy</h2>
                        <p>Chúng tôi tự hào được hợp tác với nhiều doanh nghiệp và tổ chức uy tín trên toàn quốc</p>
                    </div>
                </div>
                
                <div class="partners-slider">
                    <div class="partners-track">
                        <!-- Partner logos would go here -->
                        <div class="partner-placeholder">
                            <p>Logo đối tác sẽ được hiển thị tại đây</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        
        <!-- CTA Section -->
        <section class="cta-section">
            <div class="container">
                <div class="cta-content">
                    <h2>Sẵn sàng bắt đầu dự án của bạn?</h2>
                    <p>Liên hệ ngay để nhận tư vấn miễn phí từ các chuyên gia của chúng tôi</p>
                    <div class="cta-actions">
                        <a href="#contact-popup" class="btn-primary popup-trigger">
                            <i class="fas fa-headset"></i>
                            <span>Nhận tư vấn miễn phí</span>
                        </a>
                        <a href="tel:<?php echo tavaled_format_phone(tavaled_get_primary_phone()); ?>" class="btn-secondary">
                            <i class="fas fa-phone"></i>
                            <span>Gọi ngay: <?php echo esc_html(tavaled_get_primary_phone()); ?></span>
                        </a>
                    </div>
                </div>
            </div>
        </section>
        
        <!-- Blog Section -->
        <section class="blog-section">
            <div class="container">
                <div class="section-header">
                    <div class="section-badge">
                        <i class="fas fa-newspaper"></i>
                        <span>Tin tức & Kiến thức</span>
                    </div>
                    <div class="section-title">
                        <h2>Tin tức & Kiến thức</h2>
                        <p>Cập nhật thông tin mới nhất về ngành màn hình LED và giải pháp chiếu sáng</p>
                    </div>
                </div>
                
                <?php
                $recent_posts = new WP_Query(array(
                    'post_type' => 'post',
                    'posts_per_page' => 3,
                ));
                
                if ($recent_posts->have_posts()) :
                    ?>
                    <div class="blog-grid grid grid-3">
                        <?php
                        while ($recent_posts->have_posts()) :
                            $recent_posts->the_post();
                            get_template_part('template-parts/content', get_post_type());
                        endwhile;
                        ?>
                    </div>
                    <?php
                    wp_reset_postdata();
                endif;
                ?>
                
                <div class="blog-footer">
                    <div class="blog-cta-link">
                        <a href="<?php echo esc_url(home_url('/blog')); ?>" class="btn-outline">
                            <i class="fas fa-newspaper"></i>
                            <span>Xem tất cả bài viết</span>
                        </a>
                    </div>
                    
                    <div class="blog-phone-cta">
                        <div class="phone-cta-content">
                            <h3><?php echo esc_html(tavaled_get_option('blog_cta_title', 'Để lại số điện thoại để nhận tư vấn ngay')); ?></h3>
                            <p><?php echo esc_html(tavaled_get_option('blog_cta_description', 'Chúng tôi sẽ liên hệ với bạn trong thời gian sớm nhất')); ?></p>
                            <form class="phone-cta-form" action="<?php echo esc_url(admin_url('admin-ajax.php')); ?>" method="post">
                                <input type="hidden" name="action" value="tavaled_phone_cta">
                                <input type="hidden" name="source" value="Homepage - Blog Section">
                                <input type="hidden" name="post_id" value="0">
                                <?php wp_nonce_field('tavaled_phone_cta_nonce', 'phone_cta_nonce'); ?>
                                <div class="phone-form-group">
                                    <input 
                                        type="tel" 
                                        name="phone" 
                                        class="phone-input" 
                                        placeholder="<?php echo esc_attr(tavaled_get_option('blog_cta_placeholder', 'Nhập số điện thoại của bạn')); ?>"
                                        required
                                    >
                                    <button type="submit" class="btn-primary phone-submit">
                                        <i class="fas fa-paper-plane"></i>
                                        <span>Gửi</span>
                                    </button>
                                </div>
                                <div class="phone-form-message"></div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        
    </main><!-- #main -->
</div><!-- #primary -->

<?php
get_footer();