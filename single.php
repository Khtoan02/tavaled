<?php
/**
 * The template for displaying all single posts
 *
 * @package TavaLED
 */

get_header();
?>

<div class="single-reading-progress" aria-hidden="true">
    <span class="single-progress-bar"></span>
</div>

<div id="primary" class="content-area single-article-area">
    <main id="main" class="site-main">
        <?php
        while (have_posts()) :
            the_post();

            tavaled_set_post_views();

            $categories = get_the_category();
            $excerpt = tavaled_get_excerpt(36);
            $thumbnail_id = get_post_thumbnail_id();
            $thumbnail_caption = $thumbnail_id ? wp_get_attachment_caption($thumbnail_id) : '';
            ?>

            <section class="single-hero" <?php if (has_post_thumbnail()) : ?>style="background-image: url('<?php echo esc_url(get_the_post_thumbnail_url(get_the_ID(), 'full')); ?>');"<?php endif; ?>>
                <div class="single-hero__overlay"></div>
                <div class="single-hero__pattern"></div>
                <div class="container">
                    <div class="single-hero__content">
                        <div class="single-hero__breadcrumb">
                            <?php tavaled_breadcrumbs(); ?>
                        </div>

                        <?php if (!empty($categories)) : ?>
                            <div class="single-hero__badges">
                                <?php foreach ($categories as $category) : ?>
                                    <a class="single-pill" href="<?php echo esc_url(get_category_link($category->term_id)); ?>">
                                        <i class="fas fa-folder"></i>
                                        <span><?php echo esc_html($category->name); ?></span>
                                    </a>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>

                        <h1 class="single-hero__title"><?php the_title(); ?></h1>

                        <?php if ($excerpt) : ?>
                            <p class="single-hero__excerpt"><?php echo esc_html($excerpt); ?></p>
                        <?php endif; ?>

                        <div class="single-hero__meta">
                            <div class="meta-item">
                                <div class="meta-icon">
                                    <i class="far fa-calendar"></i>
                                </div>
                                <div class="meta-content">
                                    <span class="meta-label"><?php esc_html_e('Ngày đăng', 'tavaled-theme'); ?></span>
                                    <span class="meta-value"><?php echo esc_html(get_the_date('d/m/Y')); ?></span>
                                </div>
                            </div>
                            <div class="meta-item">
                                <div class="meta-icon">
                                    <i class="far fa-user"></i>
                                </div>
                                <div class="meta-content">
                                    <span class="meta-label"><?php esc_html_e('Tác giả', 'tavaled-theme'); ?></span>
                                    <span class="meta-value"><?php the_author(); ?></span>
                                </div>
                            </div>
                            <div class="meta-item">
                                <div class="meta-icon">
                                    <i class="far fa-clock"></i>
                                </div>
                                <div class="meta-content">
                                    <span class="meta-label"><?php esc_html_e('Thời gian đọc', 'tavaled-theme'); ?></span>
                                    <span class="meta-value"><?php echo esc_html(tavaled_reading_time()); ?></span>
                                </div>
                            </div>
                            <div class="meta-item">
                                <div class="meta-icon">
                                    <i class="far fa-eye"></i>
                                </div>
                                <div class="meta-content">
                                    <span class="meta-label"><?php esc_html_e('Lượt xem', 'tavaled-theme'); ?></span>
                                    <span class="meta-value"><?php echo esc_html(number_format_i18n(tavaled_get_post_views())); ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="single-layout">
                <div class="container">
                    <div class="single-main">
                            <article id="post-<?php the_ID(); ?>" <?php post_class('single-post'); ?>>
                                <div class="post-content rich-content">
                                    <?php
                                    the_content();

                                    wp_link_pages(array(
                                        'before' => '<div class="page-links">' . esc_html__('Trang:', 'tavaled-theme'),
                                        'after'  => '</div>',
                                    ));
                                    ?>
                                </div>
                            </article>

                            <section class="single-cta-card">
                                <div class="single-cta-card__content">
                                    <div class="single-cta-card__badge">
                                        <i class="fas fa-bolt"></i>
                                        <span><?php esc_html_e('Nhận tư vấn chuyên gia', 'tavaled-theme'); ?></span>
                                    </div>
                                    <h3><?php echo esc_html(tavaled_get_option('blog_cta_title', 'Để lại số điện thoại để nhận tư vấn ngay')); ?></h3>
                                    <p><?php echo esc_html(tavaled_get_option('blog_cta_description', 'Chúng tôi sẽ liên hệ với bạn trong thời gian sớm nhất')); ?></p>
                                    <ul class="single-cta-card__benefits">
                                        <li><?php esc_html_e('Đề xuất giải pháp phù hợp dự án', 'tavaled-theme'); ?></li>
                                        <li><?php esc_html_e('Bảng giá & timeline triển khai minh bạch', 'tavaled-theme'); ?></li>
                                        <li><?php esc_html_e('Đội ngũ kỹ thuật hỗ trợ 24/7', 'tavaled-theme'); ?></li>
                                    </ul>
                                </div>
                                <div class="single-cta-card__form">
                                    <form class="phone-cta-form" action="<?php echo esc_url(admin_url('admin-ajax.php')); ?>" method="post">
                                        <input type="hidden" name="action" value="tavaled_phone_cta">
                                        <input type="hidden" name="source" value="Single Post - <?php echo esc_attr(get_the_title()); ?>">
                                        <input type="hidden" name="post_id" value="<?php echo esc_attr(get_the_ID()); ?>">
                                        <?php wp_nonce_field('tavaled_phone_cta_nonce', 'phone_cta_nonce'); ?>
                                        <label for="single-phone-field" class="screen-reader-text"><?php esc_html_e('Số điện thoại', 'tavaled-theme'); ?></label>
                                        <div class="phone-form-group">
                                            <input
                                                id="single-phone-field"
                                                type="tel"
                                                name="phone"
                                                class="phone-input"
                                                placeholder="<?php echo esc_attr(tavaled_get_option('blog_cta_placeholder', 'Nhập số điện thoại của bạn')); ?>"
                                                required
                                            >
                                            <button type="submit" class="btn-primary phone-submit">
                                                <span class="button-text"><?php esc_html_e('Nhận tư vấn ngay', 'tavaled-theme'); ?></span>
                                                <span class="button-loading">
                                                    <i class="fas fa-spinner fa-spin"></i>
                                                </span>
                                            </button>
                                        </div>
                                        <div class="phone-form-message"></div>
                                    </form>
                                </div>
                            </section>

                            <div class="post-footer">
                                <?php if (has_tag()) : ?>
                                    <div class="post-tags">
                                        <span class="post-tags__label">
                                            <i class="fas fa-tags"></i>
                                            <?php esc_html_e('Từ khóa:', 'tavaled-theme'); ?>
                                        </span>
                                        <div class="post-tags__list">
                                            <?php the_tags('', '', ''); ?>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <?php if (get_the_author_meta('description')) : ?>
                                <section class="single-author-card">
                                    <div class="single-author-card__avatar">
                                        <?php echo get_avatar(get_the_author_meta('ID'), 96); ?>
                                    </div>
                                    <div class="single-author-card__content">
                                        <span class="single-author-card__eyebrow"><?php esc_html_e('Về tác giả', 'tavaled-theme'); ?></span>
                                        <h4><?php the_author(); ?></h4>
                                        <p><?php echo wp_kses_post(get_the_author_meta('description')); ?></p>
                                        <a class="btn-outline" href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID'))); ?>">
                                            <?php esc_html_e('Xem thêm bài viết', 'tavaled-theme'); ?>
                                        </a>
                                    </div>
                                </section>
                            <?php endif; ?>

                            <?php
                            $related_posts = tavaled_get_related_posts();
                            if ($related_posts && $related_posts->have_posts()) :
                                ?>
                                <section class="related-posts">
                                    <div class="section-header">
                                        <div class="section-badge">
                                            <i class="fas fa-lightbulb"></i>
                                            <span><?php esc_html_e('Có thể bạn quan tâm', 'tavaled-theme'); ?></span>
                                        </div>
                                        <h3><?php esc_html_e('Bài viết liên quan', 'tavaled-theme'); ?></h3>
                                    </div>
                                    <div class="related-posts-grid">
                                        <?php
                                        while ($related_posts->have_posts()) :
                                            $related_posts->the_post();
                                            ?>
                                            <article class="related-card">
                                                <a href="<?php the_permalink(); ?>" class="related-card__thumb" aria-label="<?php echo esc_attr(get_the_title()); ?>">
                                                    <?php
                                                    if (has_post_thumbnail()) {
                                                        $thumbnail_id = get_post_thumbnail_id();
                                                        $thumbnail_alt = get_post_meta($thumbnail_id, '_wp_attachment_image_alt', true);
                                                        if (empty($thumbnail_alt)) {
                                                            $thumbnail_alt = get_the_title();
                                                        }
                                                        echo get_the_post_thumbnail(
                                                            get_the_ID(),
                                                            'large',
                                                            array(
                                                                'alt' => esc_attr($thumbnail_alt),
                                                                'loading' => 'lazy',
                                                            )
                                                        );
                                                    } else {
                                                        echo '<span class="related-card__placeholder">' . esc_html__('TavaLED', 'tavaled-theme') . '</span>';
                                                    }
                                                    ?>
                                                </a>
                                                <div class="related-card__body">
                                                    <div class="related-card__meta">
                                                        <span><?php echo esc_html(get_the_date()); ?></span>
                                                        <span>•</span>
                                                        <span><?php echo esc_html(tavaled_reading_time()); ?></span>
                                                    </div>
                                                    <h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                                                    <p><?php echo esc_html(tavaled_get_excerpt(18)); ?></p>
                                                    <a class="related-card__link" href="<?php the_permalink(); ?>">
                                                        <?php esc_html_e('Đọc tiếp', 'tavaled-theme'); ?>
                                                        <i class="fas fa-arrow-right"></i>
                                                    </a>
                                                </div>
                                            </article>
                                        <?php endwhile; ?>
                                    </div>
                                </section>
                                <?php
                                wp_reset_postdata();
                            endif;
                            ?>

                    </div>
                </div>
            </section>

            <?php
        endwhile;
        ?>
    </main>
</div>

<?php
get_footer();
            
            