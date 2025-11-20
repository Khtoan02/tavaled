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

    // Loại dự án (Project Types)
    $project_type_labels = array(
        'name'                       => _x('Loại dự án', 'Taxonomy general name', 'tavaled-theme'),
        'singular_name'              => _x('Loại dự án', 'Taxonomy singular name', 'tavaled-theme'),
        'search_items'               => __('Tìm kiếm loại dự án', 'tavaled-theme'),
        'all_items'                  => __('Tất cả loại dự án', 'tavaled-theme'),
        'parent_item'                => __('Loại dự án cha', 'tavaled-theme'),
        'parent_item_colon'          => __('Loại dự án cha:', 'tavaled-theme'),
        'edit_item'                  => __('Chỉnh sửa loại dự án', 'tavaled-theme'),
        'update_item'                => __('Cập nhật loại dự án', 'tavaled-theme'),
        'add_new_item'               => __('Thêm loại dự án mới', 'tavaled-theme'),
        'new_item_name'              => __('Tên loại dự án mới', 'tavaled-theme'),
        'menu_name'                  => __('Loại dự án', 'tavaled-theme'),
    );

    $project_type_args = array(
        'hierarchical'          => true,
        'labels'                => $project_type_labels,
        'show_ui'               => true,
        'show_admin_column'     => true,
        'query_var'             => true,
        'rewrite'               => array('slug' => 'loai-du-an'),
        'show_in_rest'          => true,
    );

    register_taxonomy('loai-du-an', array('du-an'), $project_type_args);

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