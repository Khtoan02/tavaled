<?php
/**
 * Single Project Template
 * 
 * Template hiển thị chi tiết một dự án tiêu biểu của TavaLED
 * URL format: /du-an/{project-slug}/
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

    /* Single Project Page Specific Styles */
    .single-project-wrapper {
        padding-bottom: 60px;
    }

    .breadcrumb-nav {
        display: flex;
        align-items: center;
        font-size: 14px;
    }

    .breadcrumb-nav a {
        transition: color 0.3s ease;
        text-decoration: none;
    }

    .breadcrumb-nav a:hover {
        color: var(--accent-orange) !important;
    }

    /* --- 5. DETAIL PAGE STYLES --- */
    .detail-wrapper {
        padding-top: 0;
        padding-bottom: 60px;
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

    .back-button {
        background: none;
        border: none;
        color: var(--text-gray);
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 14px;
        font-weight: 500;
        text-transform: uppercase;
        padding: 10px 0;
        transition: all 0.3s ease;
        text-decoration: none;
    }

    .back-button:hover {
        color: var(--white);
        transform: translateX(-5px);
    }

    .back-button i {
        color: var(--accent-orange);
        transition: transform 0.3s ease;
    }

    .back-button:hover i {
        transform: translateX(-3px);
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

<div id="primary" class="content-area single-project-page">
    <main id="main" class="site-main">
        <div class="projects-page-wrapper single-project-wrapper">
            <div class="container">
                <!-- Breadcrumb & Back Button -->
                <div style="padding-top: 60px; margin-bottom: 40px; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 20px;">
                    <div class="breadcrumb-nav">
                        <a href="<?php echo esc_url(home_url()); ?>">Trang chủ</a>
                        <span style="color: var(--text-gray); margin: 0 10px;">/</span>
                        <?php
                        $projectsPage = get_pages(array(
                            'meta_key' => '_wp_page_template',
                            'meta_value' => 'template-project.php'
                        ));
                        if (!empty($projectsPage)) {
                            $projectsPageUrl = get_permalink($projectsPage[0]->ID);
                            $projectsPageTitle = $projectsPage[0]->post_title;
                        } else {
                            $pageBySlug = get_page_by_path("du-an-tieu-bieu");
                            if ($pageBySlug) {
                                $projectsPageUrl = get_permalink($pageBySlug->ID);
                                $projectsPageTitle = $pageBySlug->post_title;
                            } else {
                                $projectsPageUrl = home_url();
                                $projectsPageTitle = 'Dự Án';
                            }
                        }
                        ?>
                        <a href="<?php echo esc_url($projectsPageUrl); ?>" style="color: var(--text-gray); text-decoration: none; font-size: 14px;"><?php echo esc_html($projectsPageTitle); ?></a>
                        <span style="color: var(--text-gray); margin: 0 10px;">/</span>
                        <span style="color: var(--accent-orange); font-size: 14px; font-weight: 600;">Chi tiết dự án</span>
                    </div>
                    <a href="<?php echo esc_url($projectsPageUrl); ?>" class="back-button" style="margin-bottom: 0;">
                        <i class="fa-solid fa-arrow-left"></i> Quay lại danh sách
                    </a>
                </div>

                <div id="app-content">
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
    // --- PROJECT DATA với SLUG ---
    <?php
    $tavaled_projects_js = function_exists('tavaled_get_projects_js_data') ? tavaled_get_projects_js_data() : array();
    if (!empty($tavaled_projects_js)) :
    ?>
    const projects = <?php echo wp_json_encode($tavaled_projects_js); ?>;
    <?php else : ?>
    // Fallback MOCK DATA với SLUG
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

    // --- INIT ---
    // Lấy URL trang danh sách dự án từ PHP
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
            $projectsPageUrl = home_url();
        }
    }
    ?>
    const projectsPageUrl = '<?php echo esc_url($projectsPageUrl); ?>';

    function initSingleProject() {
        const app = document.getElementById('app-content');
        if (!app) {
            console.error('app-content element not found');
            setTimeout(initSingleProject, 100);
            return;
        }

        // Lấy project slug từ URL
        // Format: /du-an/{slug}/ hoặc /{trang-du-an}/{slug}/
        let projectSlug = null;
        const pathParts = window.location.pathname.split('/').filter(p => p);
        
        // Tìm slug trong URL path
        // Có thể là: /du-an/{slug}/ hoặc /{trang-du-an}/{slug}/
        if (pathParts.length >= 2) {
            // Lấy phần cuối cùng làm slug
            projectSlug = pathParts[pathParts.length - 1];
        }
        
        // Nếu không tìm thấy trong path, thử query parameter (fallback)
        if (!projectSlug) {
            const urlParams = new URLSearchParams(window.location.search);
            projectSlug = urlParams.get('slug') || urlParams.get('project_slug');
        }
        
        if (!projectSlug) {
            document.getElementById('app-content').innerHTML = `
                <div style="text-align: center; padding: 60px 20px;">
                    <h2 style="color: var(--white); margin-bottom: 20px;">Không tìm thấy dự án</h2>
                    <p style="color: var(--text-gray); margin-bottom: 20px;">Vui lòng chọn dự án từ trang danh sách.</p>
                    <a href="${projectsPageUrl}" class="back-button">
                        <i class="fa-solid fa-arrow-left"></i> Quay lại danh sách
                    </a>
                </div>
            `;
            return;
        }
        
        // Tìm project theo slug
        const project = projects.find(p => p.slug === projectSlug);
        if (!project) {
            document.getElementById('app-content').innerHTML = `
                <div style="text-align: center; padding: 60px 20px;">
                    <h2 style="color: var(--white); margin-bottom: 20px;">Không tìm thấy dự án</h2>
                    <p style="color: var(--text-gray); margin-bottom: 20px;">Dự án "${projectSlug}" không tồn tại.</p>
                    <a href="${projectsPageUrl}" class="back-button">
                        <i class="fa-solid fa-arrow-left"></i> Quay lại danh sách
                    </a>
                </div>
            `;
            return;
        }
        
        renderDetail(project.id);
    }

    // Khởi tạo khi DOM ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initSingleProject);
    } else {
        initSingleProject();
    }

    // --- RENDER DETAIL ---
    function renderDetail(id) {
        const p = projects.find(item => item.id === id);
        if (!p) {
            document.getElementById('app-content').innerHTML = `
                <div style="text-align: center; padding: 60px 20px;">
                    <h2 style="color: var(--white); margin-bottom: 20px;">Không tìm thấy dự án</h2>
                    <a href="${projectsPageUrl}" class="back-button">
                        <i class="fa-solid fa-arrow-left"></i> Quay lại danh sách
                    </a>
                </div>
            `;
            return;
        }

        window.scrollTo(0, 0);
        const app = document.getElementById('app-content');
        const seoText = p.content && p.content.trim() !== '' ? p.content : generateSEOContent(p);
        const galleryHTML = generateSmartGallery(p.images);

        // Build dynamic technical specs HTML from p.specs (label/value),
        // fallback về 4 trường tech cũ nếu specs chưa có dữ liệu
        let specsHtml = '';
        if (Array.isArray(p.specs) && p.specs.length > 0) {
            specsHtml = p.specs.map(function(spec) {
                if (!spec || (!spec.label && !spec.value)) return '';
                const label = spec.label || '';
                const value = spec.value || '';
                return `
                    <div class="detail-item">
                        <span>${label}</span>
                        <b>${value}</b>
                    </div>
                `;
            }).join('');
        } else {
            const tech = p.tech || {};
            specsHtml = `
                <div class="detail-item"><span>Module</span><b>${tech.module || ''}</b></div>
                <div class="detail-item"><span>IC Driver</span><b>${tech.ic || ''}</b></div>
                <div class="detail-item"><span>Tần số</span><b>${tech.refresh || ''}</b></div>
                <div class="detail-item"><span>Độ sáng</span><b>${tech.nit ? tech.nit + ' nits' : ''}</b></div>
            `;
        }

        app.innerHTML = `
            <div class="detail-wrapper">
                <div class="hero-split" style="margin-top: 0;">
                    <div class="info-panel">
                        <div style="margin-bottom: 20px;">
                            <span style="color: var(--accent-orange); font-weight: 800; text-transform: uppercase; letter-spacing: 2px; font-size: 12px; display: block; margin-bottom: 15px;">Case Study #${p.id < 10 ? '0'+p.id : p.id}</span>
                            <h1 style="font-size: clamp(32px, 5vw, 48px); line-height: 1.1; margin-bottom: 20px; font-weight: 800; color: var(--white);">${p.title}</h1>
                            <div style="display: flex; align-items: center; gap: 20px; margin-bottom: 25px; padding-bottom: 20px; border-bottom: 1px solid rgba(255,255,255,0.1);">
                                <div style="display: flex; align-items: center; gap: 8px; color: var(--text-gray); font-size: 14px;">
                                    <i class="fa-solid fa-location-dot" style="color: var(--accent-orange);"></i>
                                    <span>${p.location}</span>
                                </div>
                                <div style="width: 1px; height: 20px; background: rgba(255,255,255,0.2);"></div>
                                <div style="display: flex; align-items: center; gap: 8px; color: var(--text-gray); font-size: 14px;">
                                    <i class="fa-solid fa-calendar" style="color: var(--accent-orange);"></i>
                                    <span>${p.year}</span>
                                </div>
                                <div style="width: 1px; height: 20px; background: rgba(255,255,255,0.2);"></div>
                                <div style="display: flex; align-items: center; gap: 8px; color: var(--text-gray); font-size: 14px;">
                                    <i class="fa-solid fa-ruler-combined" style="color: var(--accent-orange);"></i>
                                    <span>${p.area} m²</span>
                                </div>
                            </div>
                        </div>
                        <p style="color: var(--text-gray); line-height: 1.8; margin-bottom: 30px; font-size: 16px;">
                            ${p.desc} Đây là công trình tiêu biểu sử dụng công nghệ mới nhất của TavaLED, thể hiện sự chuyên nghiệp và tinh thần đổi mới trong lĩnh vực giải pháp màn hình LED.
                        </p>
                        <div style="background: rgba(255,255,255,0.03); border-radius: 12px; padding: 25px; margin-bottom: 25px; border: 1px solid rgba(255,255,255,0.05);">
                            <h3 style="color: var(--white); font-size: 14px; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 20px; font-weight: 700; display: flex; align-items: center; gap: 10px;">
                                <i class="fa-solid fa-microchip" style="color: var(--accent-orange);"></i>
                                Thông số kỹ thuật
                            </h3>
                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                                ${specsHtml}
                            </div>
                        </div>
                        <div style="background: rgba(255,255,255,0.03); border-radius: 12px; padding: 20px; margin-bottom: 30px; border: 1px solid rgba(255,255,255,0.05);">
                            <div style="display: flex; align-items: center; gap: 15px;">
                                <div style="flex: 1;">
                                    <span style="display: block; font-size: 11px; color: var(--accent-orange); text-transform: uppercase; margin-bottom: 5px; font-weight: 600;">Chủ đầu tư</span>
                                    <b style="font-family: 'Rajdhani', sans-serif; font-size: 18px; font-weight: 600; color: var(--white);">${p.client}</b>
                                </div>
                                <div style="width: 1px; height: 40px; background: rgba(255,255,255,0.1);"></div>
                                <div style="flex: 1;">
                                    <span style="display: block; font-size: 11px; color: var(--accent-orange); text-transform: uppercase; margin-bottom: 5px; font-weight: 600;">Pixel Pitch</span>
                                    <b style="font-family: 'Rajdhani', sans-serif; font-size: 18px; font-weight: 600; color: var(--white);">${p.pixel}</b>
                                </div>
                            </div>
                        </div>
                        <button class="btn-glow" style="width: 100%; justify-content: center;">
                            <i class="fa-solid fa-bolt"></i> Yêu cầu báo giá
                        </button>
                    </div>
                    <div class="hero-image-wrapper">
                        <img src="${p.heroImage}" alt="${p.title} - Main View" loading="lazy">
                        <div style="position: absolute; bottom: 20px; right: 20px; background: rgba(0,0,0,0.7); backdrop-filter: blur(10px); padding: 8px 15px; border-radius: 6px; color:white; font-size: 12px; border: 1px solid rgba(255,255,255,0.2); display: flex; align-items: center; gap: 8px; cursor: pointer; transition: all 0.3s ease;">
                            <i class="fa-solid fa-expand"></i> <span>Phóng to</span>
                        </div>
                    </div>
                </div>

                <div class="gallery-section">
                    <h2 style="font-size: 28px; font-weight: 700; border-left: 4px solid var(--accent-orange); padding-left: 15px; margin-bottom: 20px; color: var(--white);">
                        Thư viện hình ảnh thực tế
                    </h2>
                    <div class="gallery-grid">
                        ${galleryHTML}
                    </div>
                </div>

                <div class="seo-section">
                    <h3 style="color: var(--white); font-size: 14px; text-transform: uppercase; font-weight: 700; margin-bottom: 20px; opacity: 0.5;">
                        Thông tin chi tiết dự án
                    </h3>
                    <div class="seo-content">${seoText}</div>

                    <div class="disclaimer-box">
                        <p class="disclaimer-text">
                            * Lưu ý: Các thông số kỹ thuật và hình ảnh trong bài viết mang tính chất tham khảo dựa trên hồ sơ thiết kế và thực tế thi công tại thời điểm nghiệm thu. Để có giải pháp hiển thị tối ưu nhất phù hợp với không gian và ngân sách của Quý khách, vui lòng liên hệ trực tiếp với đội ngũ kỹ thuật của TavaLED để được khảo sát và tư vấn chính xác.
                        </p>
                    </div>

                    <div class="bottom-cta-container">
                        <button class="btn-glow">
                            <i class="fa-solid fa-phone"></i> Liên hệ tư vấn ngay
                        </button>
                    </div>
                </div>
            </div>
        `;
    }

    // --- SMART GALLERY GRID CALCULATOR ---
    function generateSmartGallery(images) {
        if (!images || images.length === 0) return '<p>Đang cập nhật hình ảnh...</p>';
        const count = images.length;
        const columns = 4;
        let totalSlots = 4 + (count - 1);
        let remainder = totalSlots % columns;
        let missing = remainder === 0 ? 0 : columns - remainder;
        let classes = new Array(count).fill('');
        classes[0] = 'g-span-2-col g-span-2-row';

        if (missing > 0 && count > 1) {
            const lastIdx = count - 1;
            if (missing === 1) {
                classes[lastIdx] = 'g-span-2-col';
            } else if (missing === 2) {
                if (count >= 3) {
                    classes[lastIdx] = 'g-span-2-col';
                    classes[lastIdx - 1] = 'g-span-2-col';
                } else {
                    classes[lastIdx] = 'g-span-2-col';
                }
            } else if (missing === 3) {
                classes[lastIdx] = 'g-span-full';
            }
        }
        return images.map((img, index) => `
            <div class="gallery-item ${classes[index]}">
                <img src="${img}" loading="lazy" alt="Chi tiết dự án ${index + 1}">
                <div class="gallery-overlay">
                    <div class="gallery-tag">Ảnh ${index + 1}</div>
                </div>
            </div>
        `).join('');
    }

    function generateSEOContent(p) {
        const baseContent = `
            <h2>Tổng quan về dự án ${p.title}</h2>
            <p>Dự án <strong>${p.title}</strong> do TavaLED thực hiện tại <strong>${p.location}</strong> là một trong những cột mốc quan trọng khẳng định năng lực thi công màn hình LED chuyên nghiệp của chúng tôi. Với tổng diện tích hiển thị lên tới <strong>${p.area} mét vuông</strong>, công trình này không chỉ đáp ứng nhu cầu trình chiếu nội dung chất lượng cao mà còn là điểm nhấn kiến trúc độc đáo cho không gian của <strong>${p.client}</strong>.</p>
            <h3>1. Yêu cầu kỹ thuật và Thách thức</h3>
            <p>Đối với dự án này, chủ đầu tư yêu cầu khắt khe về độ sáng và độ tương phản. Cụ thể, màn hình phải đạt độ sáng tối thiểu <strong>${p.tech.nit} nits</strong> để đảm bảo hiển thị rõ ràng dưới điều kiện ánh sáng môi trường mạnh. Bên cạnh đó, tần số làm tươi <strong>${p.tech.refresh}</strong> là bắt buộc để đảm bảo khi quay phim, chụp ảnh không xảy ra hiện tượng sọc nhiễu.</p>
            <p>Thách thức lớn nhất trong quá trình thi công là việc xử lý kết cấu khung giá đỡ. Đội ngũ kỹ thuật của TavaLED đã phải tính toán tải trọng kỹ lưỡng, sử dụng vật liệu hợp kim nhôm siêu nhẹ nhưng siêu bền để đảm bảo an toàn tuyệt đối.</p>
            <h3>2. Giải pháp công nghệ từ TavaLED</h3>
            <p>Chúng tôi đã đề xuất sử dụng dòng Module LED <strong>${p.tech.module}</strong> tích hợp IC điều khiển <strong>${p.tech.ic}</strong>. Đây là dòng linh kiện cao cấp, cho phép kiểm soát từng điểm ảnh (pixel-by-pixel correction), mang lại độ đồng đều màu sắc tuyệt đối.</p>
        `;
        return baseContent + baseContent;
    }
</script>

<?php
get_footer();
?>

