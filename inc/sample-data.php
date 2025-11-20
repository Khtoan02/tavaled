<?php
/**
 * Sample Data Generator
 *
 * @package TavaLED
 */

// Ngăn truy cập trực tiếp
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Create sample product categories
 */
function tavaled_create_sample_categories() {
    $categories = array(
        'Màn hình LED' => array(
            'description' => 'Các loại màn hình LED chất lượng cao',
            'slug' => 'man-hinh-led'
        ),
        'Thiết bị âm thanh' => array(
            'description' => 'Hệ thống âm thanh chuyên nghiệp',
            'slug' => 'thiet-bi-am-thanh'
        ),
        'Thiết bị ánh sáng' => array(
            'description' => 'Đèn LED và thiết bị chiếu sáng',
            'slug' => 'thiet-bi-anh-sang'
        )
    );
    
    foreach ($categories as $name => $data) {
        if (!term_exists($name, 'danh-muc-san-pham')) {
            wp_insert_term($name, 'danh-muc-san-pham', array(
                'description' => $data['description'],
                'slug' => $data['slug']
            ));
        }
    }
}

/**
 * Create sample brands
 */
function tavaled_create_sample_brands() {
    $brands = array(
        'TavaLED' => 'Thương hiệu LED hàng đầu Việt Nam',
        'Samsung' => 'Thương hiệu điện tử toàn cầu',
        'LG' => 'Thương hiệu màn hình chất lượng cao',
        'Philips' => 'Thương hiệu chiếu sáng chuyên nghiệp'
    );
    
    foreach ($brands as $name => $description) {
        if (!term_exists($name, 'thuong-hieu')) {
            wp_insert_term($name, 'thuong-hieu', array(
                'description' => $description
            ));
        }
    }
}

/**
 * Create sample products
 */
function tavaled_create_sample_products() {
    $sample_products = array(
        array(
            'title' => 'Màn hình LED Indoor 55 inch',
            'content' => 'Màn hình LED Indoor chất lượng cao với độ phân giải 4K, phù hợp cho quảng cáo trong nhà và sự kiện.',
            'excerpt' => 'Màn hình LED Indoor 55 inch với độ phân giải 4K, chất lượng hình ảnh sắc nét.',
            'category' => 'Màn hình LED',
            'brand' => 'TavaLED',
            'price' => '25,000,000 VNĐ',
            'old_price' => '30,000,000 VNĐ',
            'rating' => '5',
            'badge' => 'hot',
            'featured' => 'yes',
            'specs' => array(
                'model' => 'TL-55IN-2024',
                'resolution' => '3840x2160 (4K)',
                'size' => '55 inch',
                'power' => '150W',
                'warranty' => '3 năm'
            ),
            'features' => "Độ phân giải 4K Ultra HD\nTiết kiệm 60% điện năng\nBảo hành chính hãng 3 năm\nTương thích đa nền tảng"
        ),
        array(
            'title' => 'Màn hình LED Outdoor 75 inch',
            'content' => 'Màn hình LED Outdoor chống nước, chống bụi với độ sáng cao, phù hợp cho quảng cáo ngoài trời.',
            'excerpt' => 'Màn hình LED Outdoor 75 inch chống nước, độ sáng cao cho quảng cáo ngoài trời.',
            'category' => 'Màn hình LED',
            'brand' => 'Samsung',
            'price' => '45,000,000 VNĐ',
            'old_price' => '55,000,000 VNĐ',
            'rating' => '5',
            'badge' => 'sale',
            'featured' => 'yes',
            'specs' => array(
                'model' => 'SS-75OUT-2024',
                'resolution' => '1920x1080 (Full HD)',
                'size' => '75 inch',
                'power' => '200W',
                'warranty' => '3 năm'
            ),
            'features' => "Chống nước IP65\nĐộ sáng cao 5000 nits\nChống bụi và va đập\nTương thích thời tiết khắc nghiệt"
        ),
        array(
            'title' => 'Loa công suất cao 2000W',
            'content' => 'Loa công suất cao 2000W với âm thanh sắc nét, phù hợp cho sự kiện lớn và hội trường.',
            'excerpt' => 'Loa công suất cao 2000W với âm thanh sắc nét cho sự kiện lớn.',
            'category' => 'Thiết bị âm thanh',
            'brand' => 'TavaLED',
            'price' => '8,500,000 VNĐ',
            'rating' => '4',
            'badge' => 'new',
            'featured' => 'yes',
            'specs' => array(
                'model' => 'TL-AUD-2000W',
                'power' => '2000W',
                'frequency' => '40Hz-20kHz',
                'impedance' => '8Ω',
                'warranty' => '2 năm'
            ),
            'features' => "Công suất cao 2000W\nÂm thanh sắc nét\nTương thích đa thiết bị\nBảo hành chính hãng"
        ),
        array(
            'title' => 'Đèn LED công nghiệp 100W',
            'content' => 'Đèn LED công nghiệp 100W tiết kiệm điện, tuổi thọ cao, phù hợp cho nhà xưởng và kho bãi.',
            'excerpt' => 'Đèn LED công nghiệp 100W tiết kiệm điện, tuổi thọ cao cho nhà xưởng.',
            'category' => 'Thiết bị ánh sáng',
            'brand' => 'Philips',
            'price' => '850,000 VNĐ',
            'old_price' => '1,200,000 VNĐ',
            'rating' => '4',
            'badge' => 'sale',
            'featured' => 'yes',
            'specs' => array(
                'model' => 'PH-IND-100W',
                'power' => '100W',
                'luminosity' => '12000 lumens',
                'color_temp' => '6500K',
                'warranty' => '3 năm'
            ),
            'features' => "Tiết kiệm 70% điện năng\nTuổi thọ 50,000 giờ\nÁnh sáng tự nhiên\nBảo hành chính hãng"
        ),
        array(
            'title' => 'Ampli kỹ thuật số 4 kênh',
            'content' => 'Ampli kỹ thuật số 4 kênh với công nghệ DSP tiên tiến, phù hợp cho hệ thống âm thanh chuyên nghiệp.',
            'excerpt' => 'Ampli kỹ thuật số 4 kênh với công nghệ DSP cho hệ thống âm thanh chuyên nghiệp.',
            'category' => 'Thiết bị âm thanh',
            'brand' => 'TavaLED',
            'price' => '12,500,000 VNĐ',
            'rating' => '5',
            'badge' => 'hot',
            'featured' => 'yes',
            'specs' => array(
                'model' => 'TL-AMP-4CH',
                'channels' => '4 kênh',
                'power' => '500W/channel',
                'dsp' => 'Có',
                'warranty' => '2 năm'
            ),
            'features' => "Công nghệ DSP tiên tiến\n4 kênh độc lập\nĐiều khiển từ xa\nBảo hành chính hãng"
        ),
        array(
            'title' => 'Đèn LED trang trí RGB',
            'content' => 'Đèn LED trang trí RGB với 16 triệu màu sắc, điều khiển qua smartphone, phù hợp cho trang trí sự kiện.',
            'excerpt' => 'Đèn LED trang trí RGB với 16 triệu màu sắc, điều khiển qua smartphone.',
            'category' => 'Thiết bị ánh sáng',
            'brand' => 'TavaLED',
            'price' => '2,500,000 VNĐ',
            'rating' => '4',
            'badge' => 'new',
            'featured' => 'yes',
            'specs' => array(
                'model' => 'TL-DEC-RGB',
                'colors' => '16 triệu màu',
                'control' => 'Smartphone',
                'power' => '50W',
                'warranty' => '2 năm'
            ),
            'features' => "16 triệu màu sắc\nĐiều khiển qua smartphone\nHiệu ứng ánh sáng đa dạng\nTương thích IoT"
        )
    );
    
    foreach ($sample_products as $product_data) {
        // Check if product already exists
        $existing_product = get_page_by_title($product_data['title'], OBJECT, 'san-pham');
        if ($existing_product) {
            continue;
        }
        
        // Create product post
        $post_data = array(
            'post_title' => $product_data['title'],
            'post_content' => $product_data['content'],
            'post_excerpt' => $product_data['excerpt'],
            'post_status' => 'publish',
            'post_type' => 'san-pham'
        );
        
        $post_id = wp_insert_post($post_data);
        
        if ($post_id) {
            // Set category
            if ($product_data['category']) {
                $category_term = get_term_by('name', $product_data['category'], 'danh-muc-san-pham');
                if ($category_term) {
                    wp_set_object_terms($post_id, $category_term->term_id, 'danh-muc-san-pham');
                }
            }
            
            // Set brand
            if ($product_data['brand']) {
                $brand_term = get_term_by('name', $product_data['brand'], 'thuong-hieu');
                if ($brand_term) {
                    wp_set_object_terms($post_id, $brand_term->term_id, 'thuong-hieu');
                }
            }
            
            // Set meta fields
            update_post_meta($post_id, '_product_price', $product_data['price']);
            if (isset($product_data['old_price'])) {
                update_post_meta($post_id, '_product_old_price', $product_data['old_price']);
            }
            update_post_meta($post_id, '_product_rating', $product_data['rating']);
            update_post_meta($post_id, '_product_badge', $product_data['badge']);
            update_post_meta($post_id, '_product_featured', $product_data['featured']);
            
            // Set specs
            if (isset($product_data['specs'])) {
                foreach ($product_data['specs'] as $key => $value) {
                    update_post_meta($post_id, '_product_' . $key, $value);
                }
            }
            
            // Set features
            if (isset($product_data['features'])) {
                update_post_meta($post_id, '_product_features', $product_data['features']);
            }
        }
    }
}

/**
 * Initialize sample data
 */
function tavaled_init_sample_data() {
    if (!post_type_exists('san-pham')) {
        return;
    }
    
    // Only run once
    if (get_option('tavaled_sample_data_created')) {
        return;
    }
    
    tavaled_create_sample_categories();
    tavaled_create_sample_brands();
    tavaled_create_sample_products();
    
    update_option('tavaled_sample_data_created', true);
}

// Run sample data creation on theme activation
add_action('after_switch_theme', 'tavaled_init_sample_data'); 