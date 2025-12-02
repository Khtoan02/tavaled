<?php
/**
 * Template Name: Dự Án Tiêu Biểu
 * Template Post Type: page
 * 
 * Template hiển thị danh sách và chi tiết các dự án tiêu biểu của TavaLED
 *
 * @package TavaLED
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header();
?>

<!-- Google Fonts -->
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800&family=Rajdhani:wght@500;600;700&display=swap" rel="stylesheet">
<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
    /* --- 1. CORE VARIABLES --- */
    :root {
        --primary-dark: #1c2857;
        --primary-deep: #0f1633;
        --accent-orange: #f05a25;
        --accent-orange-glow: rgba(240, 90, 37, 0.5);
        --white: #ffffff;
        --text-gray: #b0b8d1;
        
        /* Glass System */
        --glass-bg: rgba(20, 28, 60, 0.6);
        --glass-border: rgba(255, 255, 255, 0.08);
        --glass-highlight: rgba(255, 255, 255, 0.15);
    }

    /* --- 2. GLOBAL RESET & BASE --- */
    .projects-page-wrapper {
        font-family: 'Montserrat', sans-serif;
        background-color: var(--primary-dark);
        color: var(--white);
        min-height: 100vh;
        /* Tech Grid Background */
        background-image: 
            linear-gradient(var(--primary-dark) 0%, var(--primary-deep) 100%),
            linear-gradient(rgba(255,255,255,0.03) 1px, transparent 1px),
            linear-gradient(90deg, rgba(255,255,255,0.03) 1px, transparent 1px);
        background-size: 100% 100%, 40px 40px, 40px 40px;
        background-blend-mode: normal, overlay, overlay;
        overflow-x: hidden;
        position: relative;
    }

    .projects-page-wrapper * {
        font-family: 'Montserrat', sans-serif;
    }

    /* Font chuyên dụng cho thông số kỹ thuật */
    .font-tech { font-family: 'Rajdhani', sans-serif; }

    .projects-page-wrapper .container {
        max-width: 1280px;
        margin: 0 auto;
        padding: 0 20px;
    }

    /* Orbs Background */
    .projects-page-wrapper::before {
        content: '';
        position: fixed;
        top: -100px;
        left: -100px;
        width: 500px;
        height: 500px;
        background: var(--accent-orange);
        filter: blur(150px);
        opacity: 0.15;
        z-index: 0;
        pointer-events: none;
    }

    .projects-page-wrapper::after {
        content: '';
        position: fixed;
        bottom: 0;
        right: -100px;
        width: 600px;
        height: 600px;
        background: #004e92;
        filter: blur(180px);
        opacity: 0.2;
        z-index: 0;
        pointer-events: none;
    }

    .projects-page-wrapper > * {
        position: relative;
        z-index: 1;
    }

    /* Header Section */
    .projects-page-header {
        text-align: center;
        margin-bottom: 60px;
        padding-top: 60px;
    }

    .projects-page-header h1 {
        font-size: 48px;
        font-weight: 800;
        margin-bottom: 15px;
        text-transform: uppercase;
        letter-spacing: -1px;
        color: var(--white);
    }

    .projects-page-header h1 .highlight {
        color: var(--accent-orange);
        text-shadow: 0 0 20px rgba(240,90,37,0.4);
    }

    .projects-page-header p {
        max-width: 600px;
        margin: 0 auto;
        color: var(--text-gray);
        font-size: 16px;
        line-height: 1.6;
    }

    /* --- 3. UI COMPONENTS --- */

    /* Filter Tabs */
    .filter-wrapper {
        display: flex;
        justify-content: center;
        gap: 15px;
        margin-bottom: 60px;
        flex-wrap: wrap;
    }

    .filter-btn {
        background: transparent;
        border: 1px solid rgba(255, 255, 255, 0.1);
        color: var(--text-gray);
        padding: 12px 30px;
        border-radius: 4px;
        cursor: pointer;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1px;
        font-size: 12px;
        transition: 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        position: relative;
        overflow: hidden;
        backdrop-filter: blur(5px);
    }

    .filter-btn::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 0%;
        height: 100%;
        background: var(--accent-orange);
        z-index: -1;
        transition: 0.4s ease;
        transform: skewX(-20deg);
    }

    .filter-btn:hover,
    .filter-btn.active {
        color: var(--white);
        border-color: var(--accent-orange);
        box-shadow: 0 0 15px var(--accent-orange-glow);
    }

    .filter-btn:hover::before,
    .filter-btn.active::before {
        width: 150%;
        left: -20%;
    }

    /* --- 4. LISTING PAGE STYLES --- */
    .projects-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(380px, 1fr));
        gap: 40px;
        padding-bottom: 100px;
    }

    .pro-card {
        position: relative;
        height: 450px;
        border-radius: 20px;
        overflow: hidden;
        cursor: pointer;
        background: var(--glass-bg);
        border: 1px solid var(--glass-border);
        transition: all 0.5s ease;
        box-shadow: 0 20px 40px rgba(0,0,0,0.4), inset 0 0 0 1px rgba(255,255,255,0.05);
        isolation: isolate; /* Tạo stacking context mới */
    }

    .pro-card:hover {
        border-color: rgba(240, 90, 37, 0.4);
        box-shadow: 0 30px 60px rgba(0,0,0,0.5), 0 0 20px rgba(240, 90, 37, 0.2);
        transform: translateY(-10px);
    }

    .pro-card-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.8s ease;
        filter: brightness(0.9);
    }

    .pro-card:hover .pro-card-img {
        transform: scale(1.1);
        filter: brightness(1.1);
    }

    .pro-card-overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(to top, var(--primary-dark) 0%, transparent 60%);
        z-index: 1;
        pointer-events: none; /* Không chặn các tương tác */
    }

    .tech-badge {
        position: absolute;
        top: 20px;
        left: 20px;
        z-index: 2;
        background: rgba(28, 40, 87, 0.8);
        backdrop-filter: blur(8px);
        padding: 6px 16px;
        border-radius: 4px;
        border-left: 3px solid var(--accent-orange);
        font-family: 'Rajdhani', sans-serif;
        font-weight: 700;
        font-size: 16px;
        color: var(--white);
        box-shadow: 0 5px 15px rgba(0,0,0,0.3);
        transition: 0.3s;
    }

    .pro-card:hover .tech-badge {
        background: var(--accent-orange);
        color: white;
        border-left-color: white;
    }

    .pro-card-content {
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        padding: 30px;
        padding-right: 80px; /* Tạo không gian cho action-icon */
        z-index: 3;
        transition: transform 0.5s ease;
        pointer-events: none; /* Cho phép click qua content để click vào card */
        box-sizing: border-box;
    }

    .pro-card-content > * {
        pointer-events: auto; /* Khôi phục pointer events cho các phần tử con */
        position: relative;
        z-index: 1;
    }

    .pro-meta {
        display: flex;
        align-items: center;
        gap: 15px;
        margin-bottom: 10px;
        opacity: 0.8;
        font-size: 13px;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: var(--white);
    }

    .pro-title {
        font-size: 24px;
        font-weight: 700;
        line-height: 1.3;
        margin-bottom: 20px;
        color: var(--white);
        text-shadow: 0 2px 4px rgba(0,0,0,0.5);
    }

    .pro-details-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 15px;
        border-top: 1px solid rgba(255,255,255,0.15);
        padding-top: 20px;
        margin-top: 20px;
        max-height: 0;
        opacity: 0;
        overflow: hidden;
        transition: max-height 0.5s ease, opacity 0.5s ease, padding-top 0.5s ease, margin-top 0.5s ease;
        padding-bottom: 0;
        margin-bottom: 0;
    }

    .pro-card:hover .pro-details-grid {
        max-height: 100px; /* Thay vì height cố định, dùng max-height */
        opacity: 1;
        padding-bottom: 0;
        margin-bottom: 0;
    }

    .detail-item span {
        display: block;
        font-size: 11px;
        color: var(--accent-orange);
        text-transform: uppercase;
        margin-bottom: 2px;
        font-weight: 600;
    }

    .detail-item b {
        font-family: 'Rajdhani', sans-serif;
        font-size: 18px;
        font-weight: 600;
        color: var(--white);
    }

    .action-icon {
        position: absolute;
        bottom: 30px;
        right: 30px;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: rgba(255,255,255,0.1);
        backdrop-filter: blur(5px);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        z-index: 10; /* Tăng z-index cao hơn để luôn ở trên */
        border: 1px solid rgba(255,255,255,0.2);
        transition: 0.3s;
        pointer-events: auto; /* Đảm bảo có thể click được */
    }

    .pro-card:hover .action-icon {
        background: var(--accent-orange);
        border-color: var(--accent-orange);
        transform: rotate(-45deg);
        box-shadow: 0 5px 15px rgba(240, 90, 37, 0.4);
    }

    /* --- 5. DETAIL PAGE STYLES --- */
    .detail-wrapper {
        padding-top: 20px;
        animation: slideIn 0.5s ease;
    }

    /* UPDATED HERO SPLIT - BALANCED LAYOUT */
    .hero-split {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 40px;
        margin-bottom: 80px;
        align-items: stretch;
    }

    .info-panel {
        background: var(--glass-bg);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 20px;
        padding: 50px 40px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        display: flex;
        flex-direction: column;
        justify-content: center;
        height: 100%;
    }

    .hero-image-wrapper {
        height: 100%;
        min-height: 500px;
        border-radius: 20px;
        overflow: hidden;
        position: relative;
        border: 1px solid rgba(255,255,255,0.1);
        box-shadow: 0 20px 50px rgba(0,0,0,0.4);
    }

    .hero-image-wrapper img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    /* --- SMART GALLERY GRID --- */
    .gallery-section {
        margin-bottom: 80px;
    }

    .gallery-section h2 {
        font-size: 28px;
        font-weight: 700;
        border-left: 4px solid var(--accent-orange);
        padding-left: 15px;
        margin-bottom: 20px;
        color: var(--white);
    }

    .gallery-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        grid-auto-rows: 250px;
        gap: 15px;
        margin-top: 30px;
    }

    .gallery-item {
        position: relative;
        overflow: hidden;
        border-radius: 12px;
        border: 1px solid rgba(255,255,255,0.1);
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .gallery-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.7s cubic-bezier(0.2, 0.8, 0.2, 1);
    }

    .gallery-overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(to top, rgba(0,0,0,0.8), transparent);
        opacity: 0;
        transition: 0.3s;
        display: flex;
        align-items: flex-end;
        justify-content: flex-start;
        padding: 20px;
    }

    .gallery-item:hover {
        z-index: 2;
        box-shadow: 0 15px 30px rgba(0,0,0,0.5);
        border-color: var(--accent-orange);
        transform: scale(1.02);
    }

    .gallery-item:hover img {
        transform: scale(1.15);
    }

    .gallery-item:hover .gallery-overlay {
        opacity: 1;
    }

    .gallery-tag {
        background: var(--accent-orange);
        color: white;
        padding: 5px 10px;
        border-radius: 4px;
        font-size: 10px;
        font-weight: 700;
        text-transform: uppercase;
    }

    /* Utility Classes */
    .g-span-2-col {
        grid-column: span 2;
    }

    .g-span-2-row {
        grid-row: span 2;
    }

    .g-span-full {
        grid-column: 1 / -1;
        height: 350px;
    }

    /* --- UPDATED SEO & FOOTER SECTION --- */
    .seo-section {
        background: rgba(0,0,0,0.2);
        padding: 60px 40px;
        border-radius: 16px;
        margin-bottom: 60px;
        border-top: 1px solid rgba(255,255,255,0.05);
        max-width: 900px;
        margin-left: auto;
        margin-right: auto;
    }

    .seo-content {
        font-size: 12px;
        line-height: 1.8;
        color: var(--text-gray);
        column-count: 1;
        text-align: justify;
    }

    .seo-content h2 {
        font-size: 18px;
        color: var(--white);
        margin: 30px 0 15px 0;
        border-left: 3px solid var(--accent-orange);
        padding-left: 10px;
    }

    .seo-content h3 {
        font-size: 14px;
        color: var(--accent-orange);
        margin: 20px 0 10px 0;
        opacity: 1;
    }

    .seo-content p {
        margin-bottom: 15px;
    }

    /* Disclaimer Style */
    .disclaimer-box {
        margin-top: 40px;
        padding: 20px;
        background: rgba(240, 90, 37, 0.05);
        border: 1px dashed rgba(240, 90, 37, 0.3);
        border-radius: 8px;
        text-align: center;
    }

    .disclaimer-text {
        font-size: 11px;
        color: rgba(255,255,255,0.6);
        font-style: italic;
        margin-bottom: 0;
    }

    /* Bottom CTA Container */
    .bottom-cta-container {
        text-align: center;
        margin-top: 30px;
    }

    .btn-glow {
        background: linear-gradient(90deg, var(--accent-orange), #ff7e5f);
        border: none;
        color: white;
        padding: 15px 40px;
        border-radius: 50px;
        font-weight: 700;
        cursor: pointer;
        text-transform: uppercase;
        letter-spacing: 1px;
        box-shadow: 0 10px 20px rgba(240, 90, 37, 0.3);
        display: inline-flex;
        align-items: center;
        gap: 10px;
        transition: 0.3s;
        font-size: 14px;
    }

    .btn-glow:hover {
        transform: translateY(-2px);
        box-shadow: 0 15px 30px rgba(240, 90, 37, 0.5);
    }

    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @media (max-width: 900px) {
        .hero-split {
            grid-template-columns: 1fr;
        }

        .hero-image-wrapper {
            height: 400px;
            order: -1;
        }

        .gallery-grid {
            grid-template-columns: repeat(2, 1fr);
        }

        .g-span-full {
            height: 200px;
        }

        .projects-grid {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 600px) {
        .gallery-grid {
            display: flex;
            flex-direction: column;
        }

        .gallery-item {
            height: 250px;
        }

        .info-panel {
            padding: 30px 20px;
        }
    }
</style>

<div id="primary" class="content-area projects-page">
    <main id="main" class="site-main">
        <div class="projects-page-wrapper">
            <div class="container">
                <!-- Header Section -->
                <div id="main-page-header" class="projects-page-header">
                    <h1>
                        Dự Án <span class="highlight">Tiêu Biểu</span>
                    </h1>
                    <p>
                        Khám phá bộ sưu tập các công trình màn hình LED đẳng cấp, kết hợp công nghệ hiển thị đỉnh cao và giải pháp kỹ thuật toàn diện từ TavaLED.
                    </p>
                </div>

                <!-- App Container -->
                <div id="app-content" class="container">
                    <!-- Content sẽ được load bởi JavaScript -->
                    <div style="text-align: center; padding: 40px;">
                        <p style="color: var(--text-gray);">Đang tải nội dung...</p>
                    </div>
                </div>
            </div>
        </div>
    </main><!-- #main -->
</div><!-- #primary -->

<script type="text/javascript">
    // --- PROJECT DATA ---
    <?php
    // Ưu tiên dữ liệu thật từ CPT; nếu chưa có, fallback về mock để giao diện không bị trống
    $tavaled_projects_js = function_exists('tavaled_get_projects_js_data') ? tavaled_get_projects_js_data() : array();
    if (!empty($tavaled_projects_js)) :
    ?>
    const projects = <?php echo wp_json_encode($tavaled_projects_js); ?>;
    <?php else : ?>
    // Fallback MOCK DATA (sẽ được thay thế dần bằng dữ liệu thật)
    const projects = [
        {
            id: 1,
            slug: "hoi-truong-vingroup-riverside",
            title: "Hội Trường Vingroup Riverside",
            category: "indoor",
            client: "Vingroup",
            location: "Hà Nội",
            area: "45",
            pixel: "P2.5 Pro",
            year: "2023",
            thumb: "https://images.unsplash.com/photo-1544531586-fde5298cdd40?q=80&w=800&auto=format&fit=crop",
            heroImage: "https://images.unsplash.com/photo-1544531586-fde5298cdd40?q=80&w=1600&auto=format&fit=crop",
            desc: "Hệ thống màn hình cong High-Refresh Rate phục vụ hội nghị cấp cao.",
            tech: { module: "TavaLED P2.5", ic: "MBI5124", refresh: "3840Hz", nit: "800" },
            images: [
                "https://images.unsplash.com/photo-1544531586-fde5298cdd40?q=80&w=800",
                "https://images.unsplash.com/photo-1505373877733-3e648b49f21b?q=80&w=800",
                "https://images.unsplash.com/photo-1492684223066-81342ee5ff30?q=80&w=800",
                "https://images.unsplash.com/photo-1517245386807-bb43f82c33c4?q=80&w=800",
                "https://images.unsplash.com/photo-1551818255-e6e10975bc17?q=80&w=800",
                "https://images.unsplash.com/photo-1497366216548-37526070297c?q=80&w=800",
                "https://images.unsplash.com/photo-1556761175-5973dc0f32e7?q=80&w=800",
                "https://images.unsplash.com/photo-1560520653-9e0e4c89eb11?q=80&w=800"
            ]
        },
        {
            id: 2,
            slug: "3d-naked-eye-ab-tower",
            title: "3D Naked Eye - AB Tower",
            category: "outdoor",
            client: "AB Corp",
            location: "TP.HCM",
            area: "120",
            pixel: "P4 Outdoor",
            year: "2024",
            thumb: "https://images.unsplash.com/photo-1563205764-6e11b2382a92?q=80&w=800&auto=format&fit=crop",
            heroImage: "https://images.unsplash.com/photo-1563205764-6e11b2382a92?q=80&w=1600&auto=format&fit=crop",
            desc: "Màn hình 3D góc vuông đầu tiên tại trung tâm Sài Gòn.",
            tech: { module: "NationStar Gold", ic: "PWM High-Eff", refresh: "1920Hz", nit: "6500" },
            images: [
                "https://images.unsplash.com/photo-1563205764-6e11b2382a92?q=80&w=800",
                "https://images.unsplash.com/photo-1534661848522-83b54d72834b?q=80&w=800",
                "https://images.unsplash.com/photo-1519389950473-47ba0277781c?q=80&w=800",
                "https://images.unsplash.com/photo-1480714378408-67cf0d13bc1b?q=80&w=800",
                "https://images.unsplash.com/photo-1449824913929-4b8a6143f36c?q=80&w=800",
                "https://images.unsplash.com/photo-1477959858617-67f85cf4f1df?q=80&w=800"
            ]
        },
        {
            id: 3,
            slug: "tiger-crystal-rave-event",
            title: "Tiger Crystal Rave Event",
            category: "rental",
            client: "Tiger Beer",
            location: "Vũng Tàu",
            area: "200",
            pixel: "P3.91 Rental",
            year: "2023",
            thumb: "https://images.unsplash.com/photo-1470225620780-dba8ba36b745?q=80&w=800&auto=format&fit=crop",
            heroImage: "https://images.unsplash.com/photo-1470225620780-dba8ba36b745?q=80&w=1600&auto=format&fit=crop",
            desc: "Sân khấu EDM ngoài trời với khả năng chịu gió bão.",
            tech: { module: "Die-Cast Alu", ic: "MBI5153", refresh: "3840Hz", nit: "5000" },
            images: [
                "https://images.unsplash.com/photo-1470225620780-dba8ba36b745?q=80&w=800",
                "https://images.unsplash.com/photo-1514525253440-b393452e3726?q=80&w=800",
                "https://images.unsplash.com/photo-1459749411177-0473ef7161a8?q=80&w=800",
                "https://images.unsplash.com/photo-1492684223066-81342ee5ff30?q=80&w=800",
                "https://images.unsplash.com/photo-1533174072545-e8d4aa97edf9?q=80&w=800"
            ]
        },
        {
            id: 4,
            slug: "phong-hop-bo-cong-thuong",
            title: "Phòng Họp Bộ Công Thương",
            category: "indoor",
            client: "BCT",
            location: "Hà Nội",
            area: "18",
            pixel: "P1.53 GOB",
            year: "2023",
            thumb: "https://images.unsplash.com/photo-1576723652876-068345a33719?q=80&w=800&auto=format&fit=crop",
            heroImage: "https://images.unsplash.com/photo-1576723652876-068345a33719?q=80&w=1600&auto=format&fit=crop",
            desc: "Công nghệ GOB chống va đập, thay thế máy chiếu.",
            tech: { module: "GOB Tech", ic: "Novastar", refresh: "3840Hz", nit: "600" },
            images: [
                "https://images.unsplash.com/photo-1576723652876-068345a33719?q=80&w=800",
                "https://images.unsplash.com/photo-1577962917302-cd874c4e3169?q=80&w=800",
                "https://images.unsplash.com/photo-1497366216548-37526070297c?q=80&w=800",
                "https://images.unsplash.com/photo-1542744173-8e7e53415bb0?q=80&w=800"
            ]
        },
        {
            id: 5,
            slug: "showroom-vinfast-luxury",
            title: "Showroom Vinfast Luxury",
            category: "indoor",
            client: "Vinfast",
            location: "Hải Phòng",
            area: "60",
            pixel: "P2.0 Black",
            year: "2023",
            thumb: "https://images.unsplash.com/photo-1501281668745-f7f57925c3b4?q=80&w=800&auto=format&fit=crop",
            heroImage: "https://images.unsplash.com/photo-1501281668745-f7f57925c3b4?q=80&w=1600&auto=format&fit=crop",
            desc: "Màn hình độ tương phản cao tôn vinh vẻ đẹp xe điện.",
            tech: { module: "Black Face LED", ic: "MBI5124", refresh: "3840Hz", nit: "900" },
            images: [
                "https://images.unsplash.com/photo-1501281668745-f7f57925c3b4?q=80&w=800",
                "https://images.unsplash.com/photo-1552519507-da3b142c6e3d?q=80&w=800",
                "https://images.unsplash.com/photo-1494976388531-d1058494cdd8?q=80&w=800",
                "https://images.unsplash.com/photo-1519641471654-76ce0107ad1b?q=80&w=800"
            ]
        },
        {
            id: 6,
            slug: "bien-chao-cong-tinh-bac-ninh",
            title: "Biển Chào Cổng Tỉnh Bắc Ninh",
            category: "outdoor",
            client: "UBND BN",
            location: "Bắc Ninh",
            area: "80",
            pixel: "P5 Outdoor",
            year: "2022",
            thumb: "https://images.unsplash.com/photo-1627918544603-c0d117512271?q=80&w=800&auto=format&fit=crop",
            heroImage: "https://images.unsplash.com/photo-1627918544603-c0d117512271?q=80&w=1600&auto=format&fit=crop",
            desc: "Hoạt động bền bỉ 24/7 dưới mọi thời tiết.",
            tech: { module: "DIP LED", ic: "Meanwell", refresh: "1920Hz", nit: "7000" },
            images: [
                "https://images.unsplash.com/photo-1627918544603-c0d117512271?q=80&w=800",
                "https://images.unsplash.com/photo-1595844825983-50305885e3cb?q=80&w=800",
                "https://images.unsplash.com/photo-1618585472714-c1d428fa6b8a?q=80&w=800",
                "https://images.unsplash.com/photo-1495603889488-42d1d66e5523?q=80&w=800"
            ]
        }
    ];
    <?php endif; ?>

    let currentFilter = 'all';

    // --- HELPER FUNCTION ---
    function getSingleProjectUrl(project) {
        // Tạo URL với format: /{trang-du-an}/{slug}/
        <?php
        $projectsPage = get_pages(array(
            'meta_key' => '_wp_page_template',
            'meta_value' => 'template-project.php'
        ));
        if (!empty($projectsPage)) {
            $projectsPageUrl = get_permalink($projectsPage[0]->ID);
        } else {
            $pageBySlug = get_page_by_path("du-an-tieu-bieu");
            if ($pageBySlug) {
                $projectsPageUrl = get_permalink($pageBySlug->ID);
            } else {
                $projectsPageUrl = home_url('/du-an/');
            }
        }
        // Lấy slug của trang (không có trailing slash)
        $projectsPageSlug = rtrim(str_replace(home_url(), '', $projectsPageUrl), '/');
        ?>
        const baseUrl = '<?php echo esc_url($projectsPageUrl); ?>';
        const homeUrl = '<?php echo esc_url(home_url()); ?>';
        // Tạo URL: {home-url}/{trang-du-an}/{project-slug}/
        return homeUrl + '<?php echo esc_js($projectsPageSlug); ?>/' + project.slug + '/';
    }

    // --- INIT ---
    // Đảm bảo DOM đã sẵn sàng
    function initProjectsPage() {
        const app = document.getElementById('app-content');
        if (app) {
            renderListing();
        } else {
            console.error('app-content element not found');
            // Retry after a short delay
            setTimeout(initProjectsPage, 100);
        }
    }

    // Khởi tạo khi DOM ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initProjectsPage);
    } else {
        // DOM đã sẵn sàng
        initProjectsPage();
    }

    // --- RENDER LISTING ---
    function renderListing() {
        const app = document.getElementById('app-content');
        if (!app) {
            console.error('app-content element not found');
            return;
        }
        const header = document.getElementById('main-page-header');
        if (header) header.style.display = 'block';
        window.scrollTo(0, 0);

        const filtered = currentFilter === 'all'
            ? projects
            : projects.filter(p => p.category === currentFilter);

        app.innerHTML = `
            <div class="filter-wrapper">
                ${renderFilterBtn('all', 'Tất cả')}
                ${renderFilterBtn('indoor', 'Trong nhà')}
                ${renderFilterBtn('outdoor', 'Ngoài trời')}
                ${renderFilterBtn('rental', 'Sân khấu')}
            </div>

            <div class="projects-grid">
                ${filtered.map(p => {
                    // Lấy URL trang chi tiết dự án với slug
                    const singleProjectUrl = getSingleProjectUrl(p);
                    return `
                    <article class="pro-card" onclick="window.location.href='${singleProjectUrl}'">
                        <div class="tech-badge">${p.pixel}</div>
                        <img src="${p.thumb}" class="pro-card-img" alt="${p.title}" loading="lazy">
                        <div class="pro-card-overlay"></div>
                        <div class="action-icon"><i class="fa-solid fa-arrow-right"></i></div>
                        <div class="pro-card-content">
                            <div class="pro-meta font-tech">
                                <span><i class="fa-solid fa-location-dot" style="color:var(--accent-orange)"></i> ${p.location}</span>
                                <span style="width: 1px; height: 12px; background: rgba(255,255,255,0.3); margin: 0 10px;"></span>
                                <span>${p.year}</span>
                            </div>
                            <h3 class="pro-title">${p.title}</h3>
                            <div class="pro-details-grid">
                                <div class="detail-item"><span>Diện tích</span><b>${p.area} m²</b></div>
                                <div class="detail-item"><span>Chủ đầu tư</span><b>${p.client}</b></div>
                            </div>
                        </div>
                    </article>
                `;
                }).join('')}
            </div>
        `;
    }

    function renderFilterBtn(id, name) {
        const isActive = currentFilter === id;
        return `<button class="filter-btn ${isActive ? 'active' : ''}" onclick="setFilter('${id}')">${name}</button>`;
    }

    function setFilter(id) {
        currentFilter = id;
        renderListing();
    }
</script>

<?php
get_footer();
?>
