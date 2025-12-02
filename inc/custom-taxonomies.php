<?php
/**
 * Custom Taxonomies
 *
 * @package TavaLED
 */

// Ngăn truy cập trực tiếp
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Register Custom Taxonomies
 */
function tavaled_register_taxonomies() {

    /**
     * Loại dự án (Project Categories)
     *
     * Taxonomy riêng cho CPT tavaled_project, dùng để map với
     * các category UI: indoor / outdoor / rental...
     * UI quản lý chính sẽ là trang "Danh mục dự án" custom trong admin.
     */
    $project_cat_labels = array(
        'name'                       => _x('Danh mục dự án', 'Taxonomy general name', 'tavaled-theme'),
        'singular_name'              => _x('Danh mục dự án', 'Taxonomy singular name', 'tavaled-theme'),
        'search_items'               => __('Tìm kiếm danh mục', 'tavaled-theme'),
        'all_items'                  => __('Tất cả danh mục', 'tavaled-theme'),
        'parent_item'                => __('Danh mục cha', 'tavaled-theme'),
        'parent_item_colon'          => __('Danh mục cha:', 'tavaled-theme'),
        'edit_item'                  => __('Chỉnh sửa danh mục', 'tavaled-theme'),
        'update_item'                => __('Cập nhật danh mục', 'tavaled-theme'),
        'add_new_item'               => __('Thêm danh mục mới', 'tavaled-theme'),
        'new_item_name'              => __('Tên danh mục mới', 'tavaled-theme'),
        'menu_name'                  => __('Danh mục dự án', 'tavaled-theme'),
    );

    $project_cat_args = array(
        'hierarchical'      => true,
        'labels'            => $project_cat_labels,
        // Ẩn UI mặc định, chỉ dùng trang admin custom để quản lý
        'show_ui'           => false,
        'show_admin_column' => false,
        'query_var'         => true,
        'rewrite'           => array(
            'slug'       => 'loai-du-an',
            'with_front' => false,
        ),
        'show_in_rest'      => false,
    );

    register_taxonomy('tavaled_project_category', array('tavaled_project'), $project_cat_args);

    // Ngành giải pháp (Solution Industries)
    $solution_industry_labels = array(
        'name'                       => _x('Ngành giải pháp', 'Taxonomy general name', 'tavaled-theme'),
        'singular_name'              => _x('Ngành giải pháp', 'Taxonomy singular name', 'tavaled-theme'),
        'search_items'               => __('Tìm kiếm ngành', 'tavaled-theme'),
        'all_items'                  => __('Tất cả ngành', 'tavaled-theme'),
        'parent_item'                => __('Ngành cha', 'tavaled-theme'),
        'parent_item_colon'          => __('Ngành cha:', 'tavaled-theme'),
        'edit_item'                  => __('Chỉnh sửa ngành', 'tavaled-theme'),
        'update_item'                => __('Cập nhật ngành', 'tavaled-theme'),
        'add_new_item'               => __('Thêm ngành mới', 'tavaled-theme'),
        'new_item_name'              => __('Tên ngành mới', 'tavaled-theme'),
        'menu_name'                  => __('Ngành giải pháp', 'tavaled-theme'),
    );

    $solution_industry_args = array(
        'hierarchical'          => true,
        'labels'                => $solution_industry_labels,
        'show_ui'               => true,
        'show_admin_column'     => true,
        'query_var'             => true,
        'rewrite'               => array('slug' => 'nganh-giai-phap'),
        'show_in_rest'          => true,
    );

    register_taxonomy('nganh-giai-phap', array('giai-phap'), $solution_industry_args);

    // Vị trí tuyển dụng (Career Positions)
    $career_position_labels = array(
        'name'                       => _x('Vị trí tuyển dụng', 'Taxonomy general name', 'tavaled-theme'),
        'singular_name'              => _x('Vị trí', 'Taxonomy singular name', 'tavaled-theme'),
        'search_items'               => __('Tìm kiếm vị trí', 'tavaled-theme'),
        'all_items'                  => __('Tất cả vị trí', 'tavaled-theme'),
        'parent_item'                => __('Vị trí cha', 'tavaled-theme'),
        'parent_item_colon'          => __('Vị trí cha:', 'tavaled-theme'),
        'edit_item'                  => __('Chỉnh sửa vị trí', 'tavaled-theme'),
        'update_item'                => __('Cập nhật vị trí', 'tavaled-theme'),
        'add_new_item'               => __('Thêm vị trí mới', 'tavaled-theme'),
        'new_item_name'              => __('Tên vị trí mới', 'tavaled-theme'),
        'menu_name'                  => __('Vị trí tuyển dụng', 'tavaled-theme'),
    );

    $career_position_args = array(
        'hierarchical'          => true,
        'labels'                => $career_position_labels,
        'show_ui'               => true,
        'show_admin_column'     => true,
        'query_var'             => true,
        'rewrite'               => array('slug' => 'vi-tri-tuyen-dung'),
        'show_in_rest'          => true,
    );

    register_taxonomy('vi-tri-tuyen-dung', array('tuyen-dung'), $career_position_args);

    // Địa điểm làm việc (Work Locations)
    $work_location_labels = array(
        'name'                       => _x('Địa điểm làm việc', 'Taxonomy general name', 'tavaled-theme'),
        'singular_name'              => _x('Địa điểm', 'Taxonomy singular name', 'tavaled-theme'),
        'search_items'               => __('Tìm kiếm địa điểm', 'tavaled-theme'),
        'all_items'                  => __('Tất cả địa điểm', 'tavaled-theme'),
        'edit_item'                  => __('Chỉnh sửa địa điểm', 'tavaled-theme'),
        'update_item'                => __('Cập nhật địa điểm', 'tavaled-theme'),
        'add_new_item'               => __('Thêm địa điểm mới', 'tavaled-theme'),
        'new_item_name'              => __('Tên địa điểm mới', 'tavaled-theme'),
        'menu_name'                  => __('Địa điểm làm việc', 'tavaled-theme'),
    );

    $work_location_args = array(
        'hierarchical'          => false,
        'labels'                => $work_location_labels,
        'show_ui'               => true,
        'show_admin_column'     => true,
        'query_var'             => true,
        'rewrite'               => array('slug' => 'dia-diem-lam-viec'),
        'show_in_rest'          => true,
    );

    register_taxonomy('dia-diem-lam-viec', array('tuyen-dung'), $work_location_args);
}