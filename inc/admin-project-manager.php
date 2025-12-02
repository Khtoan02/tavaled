<?php
/**
 * TavaLED Project Manager (Admin Page)
 * Trang quản lý dự án riêng, không dùng layout bài viết mặc định.
 *
 * Bước 1: Chỉ dựng giao diện theo mẫu HTML/CSS đã cung cấp.
 *
 * @package TavaLED
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Đăng ký menu Trang quản lý Dự án trong Admin
 */
function tavaled_register_project_manager_page() {
    // Trang danh sách dự án
    add_menu_page(
        __('Dự án TavaLED', 'tavaled-theme'),
        __('Dự án TavaLED', 'tavaled-theme'),
        'manage_options',
        'tavaled-project-manager',
        'tavaled_render_project_manager_page',
        'dashicons-screenoptions',
        26
    );

    // Submenu: Thêm / Chỉnh sửa dự án (UI tĩnh bước 2)
    add_submenu_page(
        'tavaled-project-manager',
        __('Thêm / Chỉnh sửa dự án', 'tavaled-theme'),
        __('Thêm dự án mới', 'tavaled-theme'),
        'manage_options',
        'tavaled-project-editor',
        'tavaled_render_project_editor_page'
    );

    // Submenu: Danh mục dự án (UI danh mục riêng)
    add_submenu_page(
        'tavaled-project-manager',
        __('Danh mục dự án', 'tavaled-theme'),
        __('Danh mục dự án', 'tavaled-theme'),
        'manage_options',
        'tavaled-project-categories',
        'tavaled_render_project_categories_page'
    );
}
add_action('admin_menu', 'tavaled_register_project_manager_page');

/**
 * Render nội dung trang quản lý dự án (layout tĩnh – bước 1)
 */
function tavaled_render_project_manager_page() {
    // Xử lý xóa dự án
    if (isset($_GET['tavaled_delete_project'], $_GET['_wpnonce'])) {
        $project_id = absint($_GET['tavaled_delete_project']);
        if ($project_id && current_user_can('manage_options') && wp_verify_nonce($_GET['_wpnonce'], 'tavaled_delete_project_' . $project_id)) {
            wp_trash_post($project_id);
            wp_safe_redirect(remove_query_arg(array('tavaled_delete_project', '_wpnonce')));
            exit;
        }
    }

    // Thống kê dự án
    $counts        = wp_count_posts('tavaled_project');
    $total_projects = 0;
    if ($counts) {
        foreach ($counts as $status => $count) {
            if (is_numeric($count)) {
                $total_projects += (int) $count;
            }
        }
    }
    $published = $counts && isset($counts->publish) ? (int) $counts->publish : 0;
    $drafts    = $counts && isset($counts->draft) ? (int) $counts->draft : 0;

    // Query danh sách dự án
    $projects_query = new WP_Query(array(
        'post_type'      => 'tavaled_project',
        'post_status'    => array('publish', 'draft'),
        'posts_per_page' => 50,
        'orderby'        => 'date',
        'order'          => 'DESC',
    ));

    $add_url = admin_url('admin.php?page=tavaled-project-editor');
    ?>
    <div class="wrap tavaled-project-admin-page">
        <!-- Google Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&family=Rajdhani:wght@500;600;700&display=swap" rel="stylesheet">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

        <style>
            /* --- CORE VARIABLES --- */
            .tavaled-project-admin-page {
                --bg-dark: #0f1633;
                --accent-orange: #f05a25;
                --text-white: #ffffff;
                --text-gray: #b0b8d1;
                --success: #00c853;
                --danger: #ff3d00;
                --glass-bg: rgba(28, 40, 87, 0.7);
                --glass-border: rgba(255, 255, 255, 0.08);
            }

            .tavaled-project-admin-page * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
                font-family: 'Montserrat', sans-serif;
            }

            .tavaled-project-admin-page-inner {
                background-color: var(--bg-dark);
                color: var(--text-white);
                min-height: 100vh;
                padding: 40px;
                margin: 20px 0;
                border-radius: 16px;
                background-image:
                    radial-gradient(circle at 10% 20%, rgba(240, 90, 37, 0.1) 0%, transparent 20%),
                    radial-gradient(circle at 90% 80%, rgba(42, 59, 117, 0.2) 0%, transparent 20%);
            }

            .tavaled-project-admin-page .page-header {
                margin-bottom: 30px;
            }

            /* Stats Cards */
            .tavaled-project-admin-page .stats-grid {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
                gap: 20px;
                margin-bottom: 30px;
            }

            .tavaled-project-admin-page .stat-card {
                background: var(--glass-bg);
                border: 1px solid var(--glass-border);
                border-radius: 12px;
                padding: 20px;
                display: flex;
                align-items: center;
                justify-content: space-between;
                backdrop-filter: blur(10px);
            }

            .tavaled-project-admin-page .stat-info h4 {
                font-size: 12px;
                color: var(--text-gray);
                text-transform: uppercase;
                margin-bottom: 5px;
            }

            .tavaled-project-admin-page .stat-info h2 {
                font-size: 28px;
                font-family: 'Rajdhani', sans-serif;
                font-weight: 700;
            }

            .tavaled-project-admin-page .stat-icon {
                width: 45px;
                height: 45px;
                border-radius: 10px;
                background: rgba(255, 255, 255, 0.05);
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 20px;
                color: var(--accent-orange);
            }

            /* TABLE PANEL */
            .tavaled-project-admin-page .panel {
                background: var(--glass-bg);
                border: 1px solid var(--glass-border);
                border-radius: 16px;
                overflow: hidden;
                display: flex;
                flex-direction: column;
                backdrop-filter: blur(10px);
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            }

            .tavaled-project-admin-page .panel-header {
                padding: 20px 25px;
                border-bottom: 1px solid var(--glass-border);
                display: flex;
                justify-content: space-between;
                align-items: center;
                flex-wrap: wrap;
                gap: 15px;
            }

            .tavaled-project-admin-page .btn-add {
                background: var(--accent-orange);
                color: white;
                border: none;
                padding: 10px 20px;
                border-radius: 6px;
                font-weight: 600;
                cursor: pointer;
                display: flex;
                align-items: center;
                gap: 8px;
                transition: 0.3s;
            }

            .tavaled-project-admin-page .btn-add:hover {
                background: #d1491a;
                transform: translateY(-2px);
            }

            .tavaled-project-admin-page .table-wrapper {
                width: 100%;
                overflow-x: auto;
            }

            .tavaled-project-admin-page table {
                width: 100%;
                border-collapse: collapse;
                min-width: 800px;
            }

            .tavaled-project-admin-page th {
                text-align: left;
                padding: 15px 25px;
                background: rgba(0, 0, 0, 0.2);
                color: var(--text-gray);
                font-size: 11px;
                text-transform: uppercase;
                letter-spacing: 1px;
            }

            .tavaled-project-admin-page td {
                padding: 15px 25px;
                border-bottom: 1px solid var(--glass-border);
                font-size: 14px;
                vertical-align: middle;
            }

            .tavaled-project-admin-page tr:hover {
                background: rgba(255, 255, 255, 0.02);
            }

            .tavaled-project-admin-page .thumb-img {
                width: 50px;
                height: 50px;
                border-radius: 6px;
                object-fit: cover;
                border: 1px solid rgba(255, 255, 255, 0.1);
            }

            .tavaled-project-admin-page .status-badge {
                padding: 4px 10px;
                border-radius: 20px;
                font-size: 11px;
                font-weight: 600;
                text-transform: uppercase;
            }

            .tavaled-project-admin-page .status-active {
                background: rgba(0, 200, 83, 0.2);
                color: var(--success);
                border: 1px solid rgba(0, 200, 83, 0.3);
            }

            .tavaled-project-admin-page .status-draft {
                background: rgba(176, 184, 209, 0.2);
                color: var(--text-gray);
                border: 1px solid rgba(176, 184, 209, 0.3);
            }

            .tavaled-project-admin-page .action-btn {
                width: 30px;
                height: 30px;
                border-radius: 4px;
                border: none;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                cursor: pointer;
                margin-right: 5px;
                transition: 0.2s;
            }

            .tavaled-project-admin-page .btn-edit {
                background: rgba(33, 150, 243, 0.2);
                color: #2196f3;
            }

            .tavaled-project-admin-page .btn-delete {
                background: rgba(255, 61, 0, 0.2);
                color: #ff3d00;
            }

            .tavaled-project-admin-page .action-btn:hover {
                transform: scale(1.1);
                filter: brightness(1.2);
            }

            /* Mobile Responsive */
            @media (max-width: 768px) {
                .tavaled-project-admin-page-inner {
                    padding: 20px;
                }

                .tavaled-project-admin-page .stats-grid {
                    grid-template-columns: 1fr 1fr;
                }

                .tavaled-project-admin-page .panel-header {
                    flex-direction: column;
                    align-items: flex-start;
                }

                .tavaled-project-admin-page .btn-add {
                    width: 100%;
                    justify-content: center;
                }
            }
        </style>

        <div class="tavaled-project-admin-page-inner">
            <div class="page-header">
                <h2 style="font-weight: 700; margin-bottom: 5px;">Quản lý Dự án</h2>
                <p style="color: var(--text-gray); font-size: 14px;">Quản lý tất cả các công trình màn hình LED đã thực hiện.</p>
            </div>

            <!-- STATS -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-info">
                        <h4>Tổng dự án</h4>
                        <h2><?php echo esc_html($total_projects); ?></h2>
                    </div>
                    <div class="stat-icon"><i class="fa-solid fa-folder-open"></i></div>
                </div>
                <div class="stat-card">
                    <div class="stat-info">
                        <h4>Đang hiển thị</h4>
                        <h2 style="color: var(--success);"><?php echo esc_html($published); ?></h2>
                    </div>
                    <div class="stat-icon" style="color: var(--success);"><i class="fa-solid fa-check-circle"></i></div>
                </div>
                <div class="stat-card">
                    <div class="stat-info">
                        <h4>Bản nháp</h4>
                        <h2 style="color: var(--text-gray);"><?php echo esc_html($drafts); ?></h2>
                    </div>
                    <div class="stat-icon" style="color: white;"><i class="fa-solid fa-pen-ruler"></i></div>
                </div>
                <div class="stat-card">
                    <div class="stat-info">
                        <h4>Lượt xem tháng</h4>
                        <h2 style="color: #2196f3;">8.5K</h2>
                    </div>
                    <div class="stat-icon" style="color: #2196f3;"><i class="fa-solid fa-eye"></i></div>
                </div>
            </div>

            <!-- TABLE PANEL -->
            <div class="panel">
                <div class="panel-header">
                    <div style="display: flex; gap: 10px;">
                        <button style="background:transparent; color:white; border:1px solid var(--glass-border); padding: 8px 15px; border-radius:6px; cursor:pointer;">
                            <i class="fa-solid fa-filter"></i> Lọc
                        </button>
                        <button style="background:transparent; color:white; border:1px solid var(--glass-border); padding: 8px 15px; border-radius:6px; cursor:pointer;">
                            <i class="fa-solid fa-sort"></i> Sắp xếp
                        </button>
                        </div>
                        <a href="<?php echo esc_url($add_url); ?>" class="btn-add"><i class="fa-solid fa-plus"></i> Thêm dự án mới</a>
                </div>

                <div class="table-wrapper">
                    <table>
                        <thead>
                            <tr>
                                <th width="80">Hình ảnh</th>
                                <th>Tên dự án</th>
                                <th>Khách hàng</th>
                                <th>Danh mục</th>
                                <th>Ngày đăng</th>
                                <th>Trạng thái</th>
                                <th width="100" style="text-align: right;">Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($projects_query->have_posts()) : ?>
                                <?php while ($projects_query->have_posts()) : $projects_query->the_post(); ?>
                                    <?php
                                    $post_id   = get_the_ID();
                                    $client    = get_post_meta($post_id, '_tavaled_project_client', true);
                                    $location  = get_post_meta($post_id, '_tavaled_project_location', true);
                                    $area      = get_post_meta($post_id, '_tavaled_project_area', true);
                                    $pixel     = get_post_meta($post_id, '_tavaled_project_pixel', true);
                                    $thumb_url = get_the_post_thumbnail_url($post_id, 'project-thumb');
                                    if (!$thumb_url) {
                                        $thumb_url = get_the_post_thumbnail_url($post_id, 'thumbnail');
                                    }
                                    $terms      = wp_get_post_terms($post_id, 'tavaled_project_category');
                                    $cat_label  = '';
                                    if (!empty($terms) && !is_wp_error($terms)) {
                                        $cat_label = $terms[0]->name;
                                    }
                                    $status      = get_post_status($post_id);
                                    $is_published = ($status === 'publish');
                                    $edit_url    = add_query_arg(
                                        array(
                                            'page'       => 'tavaled-project-editor',
                                            'project_id' => $post_id,
                                        ),
                                        admin_url('admin.php')
                                    );
                                    $delete_url = wp_nonce_url(
                                        add_query_arg(
                                            array(
                                                'page'                   => 'tavaled-project-manager',
                                                'tavaled_delete_project' => $post_id,
                                            ),
                                            admin_url('admin.php')
                                        ),
                                        'tavaled_delete_project_' . $post_id
                                    );
                                    ?>
                                    <tr>
                                        <td>
                                            <?php if ($thumb_url) : ?>
                                                <img src="<?php echo esc_url($thumb_url); ?>" class="thumb-img" alt="<?php echo esc_attr(get_the_title()); ?>">
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <div style="font-weight: 600;"><?php echo esc_html(get_the_title()); ?></div>
                                            <div style="font-size: 11px; color: var(--text-gray);">
                                                <?php if ($area) : ?>
                                                    <?php echo esc_html($area); ?>m2
                                                <?php endif; ?>
                                                <?php if ($pixel) : ?>
                                                    • <?php echo esc_html($pixel); ?>
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                        <td><?php echo $client ? esc_html($client) : '—'; ?></td>
                                        <td><?php echo $cat_label ? esc_html($cat_label) : '—'; ?></td>
                                        <td><?php echo esc_html(get_the_date('d/m/Y')); ?></td>
                                        <td>
                                            <?php if ($is_published) : ?>
                                                <span class="status-badge status-active">Hiển thị</span>
                                            <?php else : ?>
                                                <span class="status-badge status-draft">Bản nháp</span>
                                            <?php endif; ?>
                                        </td>
                                        <td style="text-align: right;">
                                            <a class="action-btn btn-edit" href="<?php echo esc_url($edit_url); ?>"><i class="fa-solid fa-pen"></i></a>
                                            <a class="action-btn btn-delete" href="<?php echo esc_url($delete_url); ?>"><i class="fa-solid fa-trash"></i></a>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                                <?php wp_reset_postdata(); ?>
                            <?php else : ?>
                                <tr>
                                    <td colspan="7" style="text-align:center; color: var(--text-gray); padding: 40px;">
                                        Chưa có dự án nào. Hãy bấm "Thêm dự án mới" để bắt đầu.
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <script>
            (function() {
                const container = document.querySelector('.tavaled-project-admin-page-inner');
                if (!container) return;

                const deleteBtns = container.querySelectorAll('.btn-delete');
                deleteBtns.forEach(btn => {
                    btn.addEventListener('click', function() {
                        if (confirm('Bạn có chắc chắn muốn xóa dự án này không?')) {
                            const row = this.closest('tr');
                            if (row) {
                                row.style.opacity = '0.5';
                                row.style.pointerEvents = 'none';
                            }
                        }
                    });
                });

                const statusBadges = container.querySelectorAll('.status-badge');
                statusBadges.forEach(badge => {
                    badge.addEventListener('click', function() {
                        if (this.classList.contains('status-active')) {
                            this.className = 'status-badge status-draft';
                            this.innerText = 'Bản nháp';
                        } else {
                            this.className = 'status-badge status-active';
                            this.innerText = 'Hiển thị';
                        }
                    });
                    badge.style.cursor = 'pointer';
                });
            })();
        </script>
    </div>
    <?php
}
/**
 * Trang Thêm / Chỉnh sửa Dự án
 */
function tavaled_render_project_editor_page() {
    if (!current_user_can('manage_options')) {
        return;
    }

    // Đảm bảo có thể dùng media library của WordPress
    wp_enqueue_media();

    $list_url    = admin_url('admin.php?page=tavaled-project-manager');
    $project_id  = isset($_GET['project_id']) ? absint($_GET['project_id']) : 0;
    $is_edit     = $project_id && get_post_type($project_id) === 'tavaled_project';

    // Handle save
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['tavaled_project_nonce']) && wp_verify_nonce($_POST['tavaled_project_nonce'], 'tavaled_save_project')) {
        $project_id = isset($_POST['project_id']) ? absint($_POST['project_id']) : 0;
        $title      = isset($_POST['project_title']) ? sanitize_text_field($_POST['project_title']) : '';
        $intro      = isset($_POST['project_intro']) ? wp_kses_post($_POST['project_intro']) : '';
        $seo_content = isset($_POST['project_seo_content']) ? wp_kses_post($_POST['project_seo_content']) : '';
        $client     = isset($_POST['project_client']) ? sanitize_text_field($_POST['project_client']) : '';
        $location   = isset($_POST['project_location']) ? sanitize_text_field($_POST['project_location']) : '';
        $area       = isset($_POST['project_area']) ? sanitize_text_field($_POST['project_area']) : '';
        $year       = isset($_POST['project_year']) ? sanitize_text_field($_POST['project_year']) : '';
        $pixel      = isset($_POST['project_pixel']) ? sanitize_text_field($_POST['project_pixel']) : '';
        $category   = isset($_POST['project_category']) ? sanitize_title($_POST['project_category']) : '';
        $is_visible = !empty($_POST['is_visible']);

        $status = $is_visible ? 'publish' : 'draft';

        $post_data = array(
            'post_type'    => 'tavaled_project',
            'post_title'   => $title,
            'post_content' => $seo_content,
            'post_status'  => $status,
        );

        if ($project_id && get_post_type($project_id) === 'tavaled_project') {
            $post_data['ID'] = $project_id;
            $project_id      = wp_update_post($post_data);
        } else {
            $project_id = wp_insert_post($post_data);
        }

        if (!is_wp_error($project_id)) {
            update_post_meta($project_id, '_tavaled_project_intro', $intro);
            update_post_meta($project_id, '_tavaled_project_client', $client);
            update_post_meta($project_id, '_tavaled_project_location', $location);
            update_post_meta($project_id, '_tavaled_project_area', $area);
            update_post_meta($project_id, '_tavaled_project_year', $year);
            update_post_meta($project_id, '_tavaled_project_pixel', $pixel);

            // Dynamic technical specs: mảng label/value
            $spec_labels = isset($_POST['spec_labels']) ? (array) $_POST['spec_labels'] : array();
            $spec_values = isset($_POST['spec_values']) ? (array) $_POST['spec_values'] : array();
            $specs       = array();

            foreach ($spec_labels as $i => $label) {
                $label = trim(wp_strip_all_tags($label));
                $value = isset($spec_values[$i]) ? wp_kses_post($spec_values[$i]) : '';
                if ($label === '' && trim($value) === '') {
                    continue;
                }
                $specs[] = array(
                    'label' => $label,
                    'value' => $value,
                );
            }
            update_post_meta($project_id, '_tavaled_project_specs', $specs);

            // Hero image
            $hero_id = isset($_POST['hero_image_id']) ? absint($_POST['hero_image_id']) : 0;
            update_post_meta($project_id, '_tavaled_project_hero_id', $hero_id);

            // Gallery images (comma-separated IDs)
            $gallery_ids_raw = isset($_POST['gallery_image_ids']) ? sanitize_text_field($_POST['gallery_image_ids']) : '';
            $gallery_ids     = array();
            if ($gallery_ids_raw !== '') {
                $gallery_ids = array_filter(array_map('absint', explode(',', $gallery_ids_raw)));
            }
            update_post_meta($project_id, '_tavaled_project_gallery_ids', $gallery_ids);

            // Category -> taxonomy
            if (!empty($category)) {
                // Đảm bảo term tồn tại
                $term = get_term_by('slug', $category, 'tavaled_project_category');
                if (!$term) {
                    $inserted = wp_insert_term($category, 'tavaled_project_category', array('slug' => $category, 'name' => ucfirst($category)));
                    if (!is_wp_error($inserted) && isset($inserted['term_id'])) {
                        $term = get_term($inserted['term_id'], 'tavaled_project_category');
                    }
                }
                if ($term && !is_wp_error($term)) {
                    wp_set_object_terms($project_id, array($term->term_id), 'tavaled_project_category', false);
                }
            }

            // Redirect để tránh submit lại
            $redirect_url = add_query_arg(
                array(
                    'page'       => 'tavaled-project-editor',
                    'project_id' => $project_id,
                    'updated'    => 1,
                ),
                admin_url('admin.php')
            );
            wp_safe_redirect($redirect_url);
            exit;
        }
    }

    // Load data cho form
    $title        = '';
    $intro        = '';
    $seo_content  = '';
    $client       = '';
    $location     = '';
    $area         = '';
    $year         = '';
    $pixel        = '';
    $category     = 'indoor';
    $is_visible   = true;
    $hero_id      = 0;
    $hero_url     = '';
    $gallery_ids  = array();

    // Load technical specs
    $loaded_specs = array();

    if ($is_edit) {
        $post = get_post($project_id);
        if ($post) {
            $title       = $post->post_title;
            $seo_content = $post->post_content;
            $intro       = get_post_meta($project_id, '_tavaled_project_intro', true);
            $client      = get_post_meta($project_id, '_tavaled_project_client', true);
            $location    = get_post_meta($project_id, '_tavaled_project_location', true);
            $area        = get_post_meta($project_id, '_tavaled_project_area', true);
            $year        = get_post_meta($project_id, '_tavaled_project_year', true);
            $pixel       = get_post_meta($project_id, '_tavaled_project_pixel', true);
            $loaded_specs = get_post_meta($project_id, '_tavaled_project_specs', true);
            if (!is_array($loaded_specs)) {
                $loaded_specs = array();
            }
            $hero_id     = (int) get_post_meta($project_id, '_tavaled_project_hero_id', true);
            if ($hero_id) {
                $hero_url = wp_get_attachment_image_url($hero_id, 'large');
            }
            $gallery_ids = get_post_meta($project_id, '_tavaled_project_gallery_ids', true);
            if (!is_array($gallery_ids)) {
                $gallery_ids = array();
            }
            $is_visible  = ($post->post_status === 'publish');

            $terms = wp_get_post_terms($project_id, 'tavaled_project_category', array('fields' => 'slugs'));
            if (!empty($terms) && !is_wp_error($terms)) {
                $category = $terms[0];
            }
        }
    }

    $heading = $is_edit ? 'Chỉnh sửa Dự Án' : 'Thêm Dự Án Mới';
    ?>
    <div class="wrap tavaled-project-editor-page">
        <!-- Google Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&family=Rajdhani:wght@500;600;700&display=swap" rel="stylesheet">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

        <style>
            .tavaled-project-editor-page {
                --bg-dark: #0f1633;
                --accent-orange: #f05a25;
                --text-white: #ffffff;
                --text-gray: #b0b8d1;
                --success: #00c853;
                --danger: #ff3d00;
                --glass-bg: rgba(28, 40, 87, 0.7);
                --glass-border: rgba(255, 255, 255, 0.08);
                --input-bg: rgba(15, 22, 51, 0.6);
            }

            .tavaled-project-editor-page * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
                font-family: 'Montserrat', sans-serif;
            }

            .tavaled-project-editor-inner {
                background-color: var(--bg-dark);
                color: var(--text-white);
                min-height: 100vh;
                padding: 40px;
                margin: 20px 0;
                border-radius: 16px;
                background-image:
                    radial-gradient(circle at 10% 20%, rgba(240, 90, 37, 0.1) 0%, transparent 20%),
                    radial-gradient(circle at 90% 80%, rgba(42, 59, 117, 0.2) 0%, transparent 20%);
            }

            .tavaled-project-editor-page .editor-header {
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-bottom: 30px;
            }

            .tavaled-project-editor-page .page-title h2 {
                font-weight: 700;
                margin-bottom: 5px;
            }

            .tavaled-project-editor-page .page-title p {
                font-size: 14px;
                color: var(--text-gray);
            }

            .tavaled-project-editor-page .header-actions {
                display: flex;
                gap: 15px;
            }

            .tavaled-project-editor-page .btn {
                padding: 10px 20px;
                border-radius: 6px;
                font-weight: 600;
                cursor: pointer;
                border: none;
                display: flex;
                align-items: center;
                gap: 8px;
                transition: 0.3s;
            }

            .tavaled-project-editor-page .btn-outline {
                background: transparent;
                border: 1px solid var(--glass-border);
                color: var(--text-gray);
            }

            .tavaled-project-editor-page .btn-outline:hover {
                border-color: var(--text-white);
                color: var(--text-white);
            }

            .tavaled-project-editor-page .btn-primary {
                background: var(--accent-orange);
                color: white;
            }

            .tavaled-project-editor-page .btn-primary:hover {
                background: #d1491a;
                transform: translateY(-2px);
                box-shadow: 0 5px 15px rgba(240, 90, 37, 0.3);
            }

            .tavaled-project-editor-page .btn-sm {
                padding: 5px 10px;
                font-size: 12px;
            }

            .tavaled-project-editor-page .editor-grid {
                display: grid;
                grid-template-columns: 2fr 1fr;
                gap: 30px;
            }

            .tavaled-project-editor-page .panel {
                background: var(--glass-bg);
                border: 1px solid var(--glass-border);
                border-radius: 12px;
                padding: 25px;
                margin-bottom: 30px;
                backdrop-filter: blur(10px);
            }

            .tavaled-project-editor-page .panel-header {
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-bottom: 20px;
                padding-bottom: 15px;
                border-bottom: 1px solid var(--glass-border);
            }

            .tavaled-project-editor-page .panel-title {
                font-size: 16px;
                font-weight: 700;
                text-transform: uppercase;
                color: var(--accent-orange);
                letter-spacing: 1px;
                margin: 0;
                padding: 0;
                border: none;
            }

            .tavaled-project-editor-page .form-group {
                margin-bottom: 20px;
            }

            .tavaled-project-editor-page .form-label {
                display: block;
                font-size: 12px;
                font-weight: 600;
                color: var(--text-gray);
                margin-bottom: 8px;
                text-transform: uppercase;
            }

            .tavaled-project-editor-page .form-input,
            .tavaled-project-editor-page .form-select,
            .tavaled-project-editor-page .form-textarea {
                width: 100%;
                background: var(--input-bg);
                border: 1px solid var(--glass-border);
                border-radius: 6px;
                padding: 12px 15px;
                color: white;
                font-family: inherit;
                font-size: 14px;
                outline: none;
                transition: 0.3s;
            }

            .tavaled-project-editor-page .form-input:focus,
            .tavaled-project-editor-page .form-select:focus,
            .tavaled-project-editor-page .form-textarea:focus {
                border-color: var(--accent-orange);
                background: rgba(15, 22, 51, 0.9);
            }

            .tavaled-project-editor-page .form-textarea {
                min-height: 120px;
                resize: vertical;
                line-height: 1.6;
            }

            .tavaled-project-editor-page .form-row {
                display: grid;
                grid-template-columns: 1fr 1fr;
                gap: 20px;
            }

            .tavaled-project-editor-page .spec-row {
                display: flex;
                gap: 10px;
                margin-bottom: 10px;
                align-items: center;
                opacity: 0;
                animation: tavaled-spec-fade-in 0.3s forwards;
            }

            @keyframes tavaled-spec-fade-in {
                to {
                    opacity: 1;
                }
            }

            .tavaled-project-editor-page .spec-label-input {
                flex: 1;
                font-weight: 600;
                color: var(--accent-orange);
            }

            .tavaled-project-editor-page .spec-val-input {
                flex: 1;
            }

            .tavaled-project-editor-page .btn-remove {
                width: 35px;
                height: 35px;
                border-radius: 6px;
                background: rgba(255, 61, 0, 0.1);
                color: var(--danger);
                border: 1px solid rgba(255, 61, 0, 0.2);
                display: flex;
                align-items: center;
                justify-content: center;
                cursor: pointer;
                transition: 0.2s;
                flex-shrink: 0;
            }

            .tavaled-project-editor-page .btn-remove:hover {
                background: var(--danger);
                color: white;
            }

            .tavaled-project-editor-page .rich-editor {
                background: var(--input-bg);
                border: 1px solid var(--glass-border);
                border-radius: 6px;
                overflow: hidden;
            }

            .tavaled-project-editor-page .editor-toolbar {
                background: rgba(255, 255, 255, 0.05);
                padding: 10px;
                border-bottom: 1px solid var(--glass-border);
                display: flex;
                gap: 10px;
            }

            .tavaled-project-editor-page .toolbar-btn {
                width: 30px;
                height: 30px;
                border-radius: 4px;
                border: none;
                background: transparent;
                color: var(--text-gray);
                cursor: pointer;
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .tavaled-project-editor-page .toolbar-btn:hover {
                background: rgba(255, 255, 255, 0.1);
                color: white;
            }

            .tavaled-project-editor-page .editor-content {
                min-height: 300px;
                padding: 20px;
                color: white;
                line-height: 1.6;
                font-size: 14px;
            }

            .tavaled-project-editor-page .upload-zone {
                border: 2px dashed var(--glass-border);
                background: rgba(255, 255, 255, 0.02);
                border-radius: 8px;
                padding: 30px;
                text-align: center;
                cursor: pointer;
                transition: 0.3s;
                position: relative;
                overflow: hidden;
            }

            .tavaled-project-editor-page .upload-zone:hover {
                border-color: var(--accent-orange);
                background: rgba(240, 90, 37, 0.05);
            }

            .tavaled-project-editor-page .upload-icon {
                font-size: 30px;
                color: var(--text-gray);
                margin-bottom: 10px;
            }

            .tavaled-project-editor-page .upload-text {
                font-size: 12px;
                color: var(--text-gray);
            }

            .tavaled-project-editor-page .image-preview {
                width: 100%;
                height: 150px;
                object-fit: cover;
                border-radius: 6px;
                display: none;
                margin-top: 10px;
            }

            .tavaled-project-editor-page .gallery-preview-grid {
                display: grid;
                grid-template-columns: repeat(3, 1fr);
                gap: 10px;
                margin-top: 15px;
            }

            .tavaled-project-editor-page .gallery-thumb {
                aspect-ratio: 1;
                border-radius: 4px;
                overflow: hidden;
                position: relative;
                border: 1px solid var(--glass-border);
            }

            .tavaled-project-editor-page .gallery-thumb img {
                width: 100%;
                height: 100%;
                object-fit: cover;
            }

            .tavaled-project-editor-page .remove-img {
                position: absolute;
                top: 2px;
                right: 2px;
                width: 20px;
                height: 20px;
                background: rgba(0, 0, 0, 0.7);
                color: white;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 10px;
                cursor: pointer;
            }

            .tavaled-project-editor-page .toggle-switch {
                display: flex;
                align-items: center;
                justify-content: space-between;
                padding: 10px 0;
                border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            }

            .tavaled-project-editor-page .switch {
                position: relative;
                display: inline-block;
                width: 40px;
                height: 20px;
            }

            .tavaled-project-editor-page .switch input {
                opacity: 0;
                width: 0;
                height: 0;
            }

            .tavaled-project-editor-page .slider {
                position: absolute;
                cursor: pointer;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background-color: rgba(255, 255, 255, 0.2);
                transition: .4s;
                border-radius: 20px;
            }

            .tavaled-project-editor-page .slider:before {
                position: absolute;
                content: "";
                height: 16px;
                width: 16px;
                left: 2px;
                bottom: 2px;
                background-color: white;
                transition: .4s;
                border-radius: 50%;
            }

            .tavaled-project-editor-page input:checked + .slider {
                background-color: var(--success);
            }

            .tavaled-project-editor-page input:checked + .slider:before {
                transform: translateX(20px);
            }

            @media (max-width: 900px) {
                .tavaled-project-editor-page .editor-grid {
                    grid-template-columns: 1fr;
                }

                .tavaled-project-editor-page .header-actions {
                    flex-direction: column;
                }
            }
        </style>

        <div class="tavaled-project-editor-inner">
            <div class="editor-header">
                <div class="page-title">
                    <a href="<?php echo esc_url($list_url); ?>" style="color: var(--text-gray); font-size: 12px; text-decoration: none; display: flex; align-items: center; gap: 5px; margin-bottom: 5px;">
                        <i class="fa-solid fa-arrow-left"></i> Quay lại danh sách
                    </a>
                    <h2><?php echo esc_html($heading); ?></h2>
                    <p>Thiết lập đầy đủ thông tin, hình ảnh và nội dung SEO cho dự án.</p>
                </div>
                <div class="header-actions">
                    <a href="<?php echo esc_url($list_url); ?>" class="btn btn-outline">Hủy bỏ</a>
                    <button type="submit" form="tavaled-project-form" class="btn btn-primary"><i class="fa-solid fa-save"></i> Lưu</button>
                </div>
            </div>

            <form class="editor-grid" id="tavaled-project-form" method="post">
                <?php wp_nonce_field('tavaled_save_project', 'tavaled_project_nonce'); ?>
                <input type="hidden" name="project_id" value="<?php echo esc_attr($project_id); ?>">
                <div class="col-main">
                    <div class="panel">
                        <div class="panel-header">
                            <h3 class="panel-title">Thông tin chung</h3>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Tên dự án (Tiêu đề)</label>
                            <input type="text" name="project_title" class="form-input" placeholder="Ví dụ: Hội Trường Vingroup Riverside" value="<?php echo esc_attr($title); ?>">
                        </div>

                        <div class="form-group">
                            <label class="form-label">Mô tả ngắn (Intro)</label>
                            <textarea name="project_intro" class="form-textarea" placeholder="Đoạn văn giới thiệu ngắn gọn hiển thị ở đầu trang..."><?php echo esc_textarea($intro); ?></textarea>
                        </div>
                    </div>

                    <div class="panel">
                        <div class="panel-header">
                            <h3 class="panel-title">Thông số kỹ thuật</h3>
                            <button type="button" class="btn btn-sm btn-outline" onclick="tavaledAddSpecRow()">
                                <i class="fa-solid fa-plus"></i> Thêm thông số
                            </button>
                        </div>

                        <div id="tavaled-tech-specs-container">
                            <?php
                            $default_specs = array();
                            if (empty($loaded_specs)) {
                                $default_specs = array(
                                    array('label' => 'Module LED', 'value' => ''),
                                    array('label' => 'IC Điều khiển', 'value' => ''),
                                    array('label' => 'Tần số quét', 'value' => ''),
                                    array('label' => 'Độ sáng', 'value' => ''),
                                );
                            }
                            $specs_to_render = !empty($loaded_specs) ? $loaded_specs : $default_specs;
                            foreach ($specs_to_render as $spec) :
                                $label = isset($spec['label']) ? $spec['label'] : '';
                                $value = isset($spec['value']) ? $spec['value'] : '';
                            ?>
                                <div class="spec-row">
                                    <input type="text" class="form-input spec-label-input" name="spec_labels[]" value="<?php echo esc_attr($label); ?>" placeholder="Tên thông số (VD: Độ sáng)">
                                    <input type="text" class="form-input spec-val-input" name="spec_values[]" value="<?php echo esc_attr($value); ?>" placeholder="Giá trị (VD: 800 nits)">
                                    <button type="button" class="btn-remove" onclick="tavaledRemoveSpec(this)"><i class="fa-solid fa-trash"></i></button>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <div style="font-size: 11px; color: var(--text-gray); margin-top: 10px; font-style: italic;">
                            * Bạn có thể thêm, sửa tên hoặc xóa các thông số tùy ý.
                        </div>
                    </div>

                    <div class="panel">
                        <div class="panel-header">
                            <h3 class="panel-title">Nội dung chi tiết (SEO)</h3>
                        </div>
                        <div class="form-group">
                            <p style="font-size: 12px; color: var(--text-gray); margin-bottom: 10px;">
                                Soạn nội dung chi tiết cho trang dự án. Bạn có thể chèn tiêu đề, danh sách, hình ảnh... giống bài viết thông thường.
                            </p>
                            <div style="background: #fff; border-radius: 6px; overflow: hidden;">
                                <?php
                                // Dùng Classic Editor mặc định của WordPress
                                wp_editor(
                                    $seo_content,
                                    'tavaled_project_content',
                                    array(
                                        'textarea_name' => 'project_seo_content',
                                        'media_buttons' => true,
                                        'teeny'         => false,
                                        'textarea_rows' => 12,
                                        'editor_height' => 260,
                                    )
                                );
                                ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sidebar">
                    <div class="panel">
                        <div class="panel-header">
                            <h3 class="panel-title">Thiết lập</h3>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Trạng thái</label>
                            <div class="toggle-switch">
                                <span style="font-size:14px;">Hiển thị trên web</span>
                                <label class="switch">
                                    <input type="checkbox" name="is_visible" <?php checked($is_visible); ?>>
                                    <span class="slider"></span>
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Danh mục</label>
                            <select class="form-select" name="project_category">
                                <option value="indoor" <?php selected($category, 'indoor'); ?>>Trong nhà (Indoor)</option>
                                <option value="outdoor" <?php selected($category, 'outdoor'); ?>>Ngoài trời (Outdoor)</option>
                                <option value="rental" <?php selected($category, 'rental'); ?>>Sân khấu (Rental)</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Khách hàng / Chủ đầu tư</label>
                            <input type="text" name="project_client" class="form-input" value="<?php echo esc_attr($client); ?>">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Địa điểm</label>
                            <input type="text" name="project_location" class="form-input" value="<?php echo esc_attr($location); ?>">
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label">Diện tích (m2)</label>
                                <input type="number" name="project_area" class="form-input" value="<?php echo esc_attr($area); ?>">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Năm hoàn thành</label>
                                <input type="number" name="project_year" class="form-input" value="<?php echo esc_attr($year); ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Pixel / Cấu hình chính</label>
                            <input type="text" name="project_pixel" class="form-input" value="<?php echo esc_attr($pixel); ?>">
                        </div>
                    </div>

                    <div class="panel">
                        <div class="panel-header">
                            <h3 class="panel-title">Ảnh đại diện (Hero)</h3>
                        </div>
                        <div class="upload-zone" id="tavaled-hero-upload-zone">
                            <i class="fa-solid fa-cloud-arrow-up upload-icon"></i>
                            <p class="upload-text">Chọn ảnh từ thư viện Media</p>
                        </div>
                        <input type="hidden" name="hero_image_id" id="tavaled-hero-id" value="<?php echo esc_attr($hero_id); ?>">
                        <img src="<?php echo $hero_url ? esc_url($hero_url) : ''; ?>" class="image-preview" id="tavaled-hero-preview" style="<?php echo $hero_url ? 'display:block;' : 'display:none;'; ?>">
                    </div>

                    <div class="panel">
                        <div class="panel-header">
                            <h3 class="panel-title">Thư viện ảnh</h3>
                        </div>
                        <div class="upload-zone" id="tavaled-gallery-upload-zone" style="padding: 20px;">
                            <i class="fa-solid fa-images upload-icon" style="font-size: 20px;"></i>
                            <p class="upload-text">Chọn nhiều ảnh từ thư viện Media</p>
                        </div>

                        <?php
                        $gallery_ids_clean = array_filter(array_map('absint', $gallery_ids));
                        $gallery_ids_str   = implode(',', $gallery_ids_clean);
                        ?>
                        <input type="hidden" name="gallery_image_ids" id="tavaled-gallery-ids" value="<?php echo esc_attr($gallery_ids_str); ?>">

                        <div class="gallery-preview-grid" id="tavaled-gallery-preview">
                            <?php if (!empty($gallery_ids_clean)) : ?>
                                <?php foreach ($gallery_ids_clean as $img_id) :
                                    $img_url = wp_get_attachment_image_url($img_id, 'thumbnail');
                                    if (!$img_url) {
                                        continue;
                                    }
                                    ?>
                                    <div class="gallery-thumb" data-attachment-id="<?php echo esc_attr($img_id); ?>">
                                        <img src="<?php echo esc_url($img_url); ?>" alt="">
                                        <span class="remove-img"><i class="fa-solid fa-times"></i></span>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                            <div class="gallery-thumb" id="tavaled-gallery-add-thumb" style="border: 2px dashed var(--glass-border); display:flex; align-items:center; justify-content:center; cursor:pointer;">
                                <i class="fa-solid fa-plus" style="color:var(--text-gray);"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <script>
            function tavaledAddSpecRow() {
                var container = document.getElementById('tavaled-tech-specs-container');
                if (!container) return;
                var newRow = document.createElement('div');
                newRow.className = 'spec-row';
                newRow.innerHTML =
                    '<input type="text" class="form-input spec-label-input" name="spec_labels[]" placeholder="Tên thông số (VD: Tuổi thọ)">' +
                    '<input type="text" class="form-input spec-val-input" name="spec_values[]" placeholder="Giá trị (VD: 100.000 giờ)">' +
                    '<button type="button" class="btn-remove" onclick="tavaledRemoveSpec(this)"><i class="fa-solid fa-trash"></i></button>';
                container.appendChild(newRow);
            }

            function tavaledRemoveSpec(button) {
                if (!button) return;
                var row = button.parentElement;
                if (row && row.parentElement) {
                    row.parentElement.removeChild(row);
                }
            }

            (function($) {
                // Đồng bộ nội dung Classic Editor vào textarea ẩn (phòng khi cần)
                $(document).on('submit', '#tavaled-project-form', function() {
                    if (typeof tinyMCE !== 'undefined' && tinyMCE.get('tavaled_project_content')) {
                        var content = tinyMCE.get('tavaled_project_content').getContent();
                        $('#tavaled-seo-field').val(content);
                    }
                });

                // Hero image selector
                var heroFrame;
                var $heroZone   = $('#tavaled-hero-upload-zone');
                var $heroId     = $('#tavaled-hero-id');
                var $heroPrev   = $('#tavaled-hero-preview');

                if ($heroZone.length) {
                    $heroZone.on('click', function(e) {
                        e.preventDefault();
                        if (heroFrame) {
                            heroFrame.open();
                            return;
                        }
                        heroFrame = wp.media({
                            title: 'Chọn ảnh đại diện dự án',
                            button: { text: 'Chọn ảnh này' },
                            multiple: false
                        });

                        heroFrame.on('select', function() {
                            var attachment = heroFrame.state().get('selection').first().toJSON();
                            $heroId.val(attachment.id);
                            $heroPrev.attr('src', attachment.url).show();
                        });

                        heroFrame.open();
                    });
                }

                // Gallery selector
                var galleryFrame;
                var $galleryZone   = $('#tavaled-gallery-upload-zone');
                var $galleryIds    = $('#tavaled-gallery-ids');
                var $galleryWrap   = $('#tavaled-gallery-preview');
                var $galleryAddBtn = $('#tavaled-gallery-add-thumb');

                function parseIds(value) {
                    if (!value) return [];
                    return value.split(',').map(function(id) {
                        return parseInt(id, 10) || 0;
                    }).filter(function(id) { return id > 0; });
                }

                if ($galleryZone.length) {
                    $galleryZone.on('click', openGalleryFrame);
                    $galleryAddBtn.on('click', openGalleryFrame);

                    $galleryWrap.on('click', '.remove-img', function() {
                        var $thumb = $(this).closest('.gallery-thumb');
                        var id = parseInt($thumb.data('attachment-id'), 10);
                        var ids = parseIds($galleryIds.val());
                        ids = ids.filter(function(item) { return item !== id; });
                        $galleryIds.val(ids.join(','));
                        $thumb.remove();
                    });
                }

                function openGalleryFrame(e) {
                    e.preventDefault();
                    if (galleryFrame) {
                        galleryFrame.open();
                        return;
                    }
                    galleryFrame = wp.media({
                        title: 'Chọn thư viện ảnh dự án',
                        button: { text: 'Chọn ảnh' },
                        multiple: true
                    });

                    galleryFrame.on('select', function() {
                        var selection = galleryFrame.state().get('selection');
                        var ids       = parseIds($galleryIds.val());

                        selection.each(function(attachment) {
                            attachment = attachment.toJSON();
                            if (ids.indexOf(attachment.id) === -1) {
                                ids.push(attachment.id);

                                var thumbUrl = attachment.sizes && attachment.sizes.thumbnail
                                    ? attachment.sizes.thumbnail.url
                                    : (attachment.sizes && attachment.sizes.medium
                                        ? attachment.sizes.medium.url
                                        : attachment.icon || attachment.url);

                                var imgHtml =
                                    '<div class="gallery-thumb" data-attachment-id="' + attachment.id + '">' +
                                        '<img src="' + thumbUrl + '" alt="">' +
                                        '<span class="remove-img"><i class="fa-solid fa-times"></i></span>' +
                                    '</div>';
                                $galleryAddBtn.before(imgHtml);
                            }
                        });

                        $galleryIds.val(ids.join(','));
                    });

                    galleryFrame.open();
                }
            })(jQuery);
        </script>
    </div>
    <?php
}

/**
 * Trang Quản lý Danh mục Dự án (UI tĩnh)
 */
function tavaled_render_project_categories_page() {
    if (!current_user_can('manage_options')) {
        return;
    }

    $dashboard_url = admin_url('admin.php?page=tavaled-project-manager');

    $message = '';
    $error   = '';

    // Xử lý xóa term
    if (isset($_GET['delete_term'], $_GET['_wpnonce'])) {
        $term_id = absint($_GET['delete_term']);
        if ($term_id && wp_verify_nonce($_GET['_wpnonce'], 'tavaled_delete_project_term_' . $term_id)) {
            $deleted = wp_delete_term($term_id, 'tavaled_project_category');
            if (is_wp_error($deleted)) {
                $error = $deleted->get_error_message();
            } else {
                $message = 'Đã xóa danh mục thành công.';
            }
        }
    }

    // Xử lý thêm term
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['tavaled_add_project_cat_nonce']) && wp_verify_nonce($_POST['tavaled_add_project_cat_nonce'], 'tavaled_add_project_category')) {
        $name = isset($_POST['cat_name']) ? sanitize_text_field($_POST['cat_name']) : '';
        $slug = isset($_POST['cat_slug']) ? sanitize_title($_POST['cat_slug']) : '';
        $desc = isset($_POST['cat_desc']) ? sanitize_textarea_field($_POST['cat_desc']) : '';

        if (empty($name)) {
            $error = 'Vui lòng nhập tên danh mục.';
        } else {
            if (empty($slug)) {
                $slug = sanitize_title($name);
            }
            $result = wp_insert_term($name, 'tavaled_project_category', array(
                'slug'        => $slug,
                'description' => $desc,
            ));
            if (is_wp_error($result)) {
                $error = $result->get_error_message();
            } else {
                $message = 'Đã thêm danh mục mới.';
            }
        }
    }

    $terms = get_terms(array(
        'taxonomy'   => 'tavaled_project_category',
        'hide_empty' => false,
    ));
    ?>
    <div class="wrap tavaled-project-category-page">
        <!-- Google Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&family=Rajdhani:wght@500;600;700&display=swap" rel="stylesheet">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

        <style>
            .tavaled-project-category-page {
                --bg-dark: #0f1633;
                --accent-orange: #f05a25;
                --text-white: #ffffff;
                --text-gray: #b0b8d1;
                --success: #00c853;
                --danger: #ff3d00;
                --glass-bg: rgba(28, 40, 87, 0.7);
                --glass-border: rgba(255, 255, 255, 0.08);
                --input-bg: rgba(15, 22, 51, 0.6);
            }

            .tavaled-project-category-page * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
                font-family: 'Montserrat', sans-serif;
            }

            .tavaled-project-category-inner {
                background-color: var(--bg-dark);
                color: var(--text-white);
                min-height: 100vh;
                padding: 40px;
                margin: 20px 0;
                border-radius: 16px;
                background-image:
                    radial-gradient(circle at 10% 20%, rgba(240, 90, 37, 0.1) 0%, transparent 20%),
                    radial-gradient(circle at 90% 80%, rgba(42, 59, 117, 0.2) 0%, transparent 20%);
            }

            .tavaled-project-category-page .page-header {
                margin-bottom: 30px;
                display: flex;
                justify-content: space-between;
                align-items: center;
            }

            .tavaled-project-category-page .page-title h2 {
                font-weight: 700;
                margin-bottom: 5px;
            }

            .tavaled-project-category-page .page-title p {
                font-size: 14px;
                color: var(--text-gray);
            }

            .tavaled-project-category-page .btn-back {
                color: var(--text-gray);
                text-decoration: none;
                font-size: 12px;
                display: flex;
                align-items: center;
                gap: 5px;
                margin-bottom: 5px;
            }

            .tavaled-project-category-page .btn-back:hover {
                color: var(--accent-orange);
            }

            .tavaled-project-category-page .admin-grid {
                display: grid;
                grid-template-columns: 2fr 1fr;
                gap: 30px;
            }

            .tavaled-project-category-page .panel {
                background: var(--glass-bg);
                border: 1px solid var(--glass-border);
                border-radius: 12px;
                padding: 25px;
                backdrop-filter: blur(10px);
                display: flex;
                flex-direction: column;
                height: 100%;
            }

            .tavaled-project-category-page .panel-header {
                margin-bottom: 20px;
                padding-bottom: 15px;
                border-bottom: 1px solid var(--glass-border);
            }

            .tavaled-project-category-page .panel-title {
                font-size: 16px;
                font-weight: 700;
                text-transform: uppercase;
                color: var(--accent-orange);
                letter-spacing: 1px;
                margin: 0;
            }

            .tavaled-project-category-page .table-wrapper {
                flex: 1;
                overflow-y: auto;
            }

            .tavaled-project-category-page table {
                width: 100%;
                border-collapse: collapse;
            }

            .tavaled-project-category-page th {
                text-align: left;
                padding: 12px 15px;
                background: rgba(0, 0, 0, 0.2);
                color: var(--text-gray);
                font-size: 11px;
                text-transform: uppercase;
                letter-spacing: 1px;
                position: sticky;
                top: 0;
            }

            .tavaled-project-category-page td {
                padding: 15px;
                border-bottom: 1px solid var(--glass-border);
                font-size: 14px;
                vertical-align: middle;
            }

            .tavaled-project-category-page tr:hover {
                background: rgba(255, 255, 255, 0.03);
            }

            .tavaled-project-category-page .count-badge {
                background: rgba(255, 255, 255, 0.1);
                padding: 2px 8px;
                border-radius: 4px;
                font-size: 12px;
                color: var(--text-gray);
            }

            .tavaled-project-category-page .form-group {
                margin-bottom: 20px;
            }

            .tavaled-project-category-page .form-label {
                display: block;
                font-size: 12px;
                font-weight: 600;
                color: var(--text-gray);
                margin-bottom: 8px;
                text-transform: uppercase;
            }

            .tavaled-project-category-page .form-input,
            .tavaled-project-category-page .form-textarea {
                width: 100%;
                background: var(--input-bg);
                border: 1px solid var(--glass-border);
                border-radius: 6px;
                padding: 12px 15px;
                color: white;
                font-family: inherit;
                font-size: 14px;
                outline: none;
                transition: 0.3s;
            }

            .tavaled-project-category-page .form-input:focus,
            .tavaled-project-category-page .form-textarea:focus {
                border-color: var(--accent-orange);
                background: rgba(15, 22, 51, 0.9);
            }

            .tavaled-project-category-page .form-note {
                font-size: 11px;
                color: var(--text-gray);
                margin-top: 5px;
                font-style: italic;
            }

            .tavaled-project-category-page .btn-add {
                background: var(--accent-orange);
                color: white;
                border: none;
                padding: 12px;
                border-radius: 6px;
                width: 100%;
                font-weight: 700;
                cursor: pointer;
                text-transform: uppercase;
                letter-spacing: 1px;
                transition: 0.3s;
            }

            .tavaled-project-category-page .btn-add:hover {
                background: #d1491a;
                transform: translateY(-2px);
                box-shadow: 0 5px 15px rgba(240, 90, 37, 0.3);
            }

            .tavaled-project-category-page .btn-icon {
                width: 30px;
                height: 30px;
                border-radius: 6px;
                border: none;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                cursor: pointer;
                transition: 0.2s;
                margin-right: 5px;
            }

            .tavaled-project-category-page .btn-edit {
                background: rgba(33, 150, 243, 0.1);
                color: #2196f3;
            }

            .tavaled-project-category-page .btn-edit:hover {
                background: #2196f3;
                color: white;
            }

            .tavaled-project-category-page .btn-delete {
                background: rgba(255, 61, 0, 0.1);
                color: var(--danger);
            }

            .tavaled-project-category-page .btn-delete:hover {
                background: var(--danger);
                color: white;
            }

            @media (max-width: 900px) {
                .tavaled-project-category-page .admin-grid {
                    grid-template-columns: 1fr;
                }

                .tavaled-project-category-page .col-form {
                    order: -1;
                    margin-bottom: 30px;
                }
            }
        </style>

        <div class="tavaled-project-category-inner">
            <?php if ($message) : ?>
                <div class="notice notice-success is-dismissible"><p><?php echo esc_html($message); ?></p></div>
            <?php endif; ?>
            <?php if ($error) : ?>
                <div class="notice notice-error is-dismissible"><p><?php echo esc_html($error); ?></p></div>
            <?php endif; ?>
            <div class="page-header">
                <div class="page-title">
                    <a href="<?php echo esc_url($dashboard_url); ?>" class="btn-back">
                        <i class="fa-solid fa-arrow-left"></i> Quay lại Dashboard Dự án
                    </a>
                    <h2>Danh Mục Dự Án</h2>
                    <p>Quản lý các loại hình dự án (Sân khấu, Trong nhà, v.v.)</p>
                </div>
            </div>

            <div class="admin-grid">
                <div class="col-list">
                    <div class="panel">
                        <div class="panel-header">
                            <h3 class="panel-title">Danh sách hiện có</h3>
                        </div>
                        <div class="table-wrapper">
                            <table id="tavaled-category-table">
                                <thead>
                                    <tr>
                                        <th>Tên danh mục</th>
                                        <th>Đường dẫn (Slug)</th>
                                        <th>Số dự án</th>
                                        <th style="text-align: right;">Hành động</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($terms) && !is_wp_error($terms)) : ?>
                                        <?php foreach ($terms as $term) : ?>
                                            <?php
                                            $delete_url = wp_nonce_url(
                                                add_query_arg(
                                                    array(
                                                        'page'       => 'tavaled-project-categories',
                                                        'delete_term'=> $term->term_id,
                                                    ),
                                                    admin_url('admin.php')
                                                ),
                                                'tavaled_delete_project_term_' . $term->term_id
                                            );
                                            ?>
                                            <tr>
                                                <td><span style="font-weight: 600; color: white;"><?php echo esc_html($term->name); ?></span></td>
                                                <td style="color: var(--text-gray); font-family: monospace;"><?php echo esc_html($term->slug); ?></td>
                                                <td><span class="count-badge"><?php echo esc_html($term->count); ?></span></td>
                                                <td style="text-align: right;">
                                                    <a class="btn-icon btn-edit" href="<?php echo esc_url(get_edit_term_link($term)); ?>"><i class="fa-solid fa-pen"></i></a>
                                                    <a class="btn-icon btn-delete" href="<?php echo esc_url($delete_url); ?>"><i class="fa-solid fa-trash"></i></a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else : ?>
                                        <tr>
                                            <td colspan="4" style="text-align:center; color: var(--text-gray); padding: 40px;">
                                                Chưa có danh mục nào. Hãy thêm danh mục mới bên phải.
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="col-form">
                    <div class="panel" style="height: auto;">
                        <div class="panel-header">
                            <h3 class="panel-title">Thêm Danh Mục</h3>
                        </div>
                        <form id="tavaled-add-category-form" method="post">
                            <?php wp_nonce_field('tavaled_add_project_category', 'tavaled_add_project_cat_nonce'); ?>
                            <div class="form-group">
                                <label class="form-label">Tên danh mục</label>
                                <input type="text" id="tavaled-cat-name" name="cat_name" class="form-input" placeholder="VD: Màn hình cong" required oninput="tavaledGenerateSlug()">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Đường dẫn tĩnh (Slug)</label>
                                <input type="text" id="tavaled-cat-slug" name="cat_slug" class="form-input" placeholder="man-hinh-cong" style="color: var(--accent-orange);">
                                <p class="form-note">Chuỗi định danh dùng để lọc trên URL (ví dụ: ?category=indoor)</p>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Mô tả (Tùy chọn)</label>
                                <textarea class="form-textarea" name="cat_desc" rows="3" placeholder="Mô tả ngắn về loại hình này..."></textarea>
                            </div>
                            <button type="submit" class="btn-add">
                                <i class="fa-solid fa-plus"></i> Thêm mới
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <script>
            function tavaledGenerateSlug() {
                var nameInput = document.getElementById('tavaled-cat-name');
                var slugInput = document.getElementById('tavaled-cat-slug');
                if (!nameInput || !slugInput) {
                    return;
                }
                var slug = nameInput.value.toLowerCase();

                slug = slug.replace(/á|à|ả|ạ|ã|ă|ắ|ằ|ẳ|ẵ|ặ|â|ấ|ầ|ẩ|ẫ|ậ/g, "a");
                slug = slug.replace(/é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ/g, "e");
                slug = slug.replace(/i|í|ì|ỉ|ĩ|ị/g, "i");
                slug = slug.replace(/ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ/g, "o");
                slug = slug.replace(/ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự/g, "u");
                slug = slug.replace(/ý|ỳ|ỷ|ỹ|ỵ/g, "y");
                slug = slug.replace(/đ/g, "d");

                slug = slug.replace(/[^a-z0-9 -]/g, '')
                           .replace(/\s+/g, '-')
                           .replace(/-+/g, '-');

                slugInput.value = slug;
            }

        </script>
    </div>
    <?php
}



