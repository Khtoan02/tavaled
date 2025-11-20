<?php
/**
 * Shared loop template for blog listings
 *
 * @package TavaLED
 */

$custom_query = get_query_var('tavaled_blog_query');
$pagination_args = get_query_var('tavaled_blog_pagination');

$active_query = ($custom_query instanceof WP_Query) ? $custom_query : $GLOBALS['wp_query'];

if ($active_query instanceof WP_Query && $active_query->have_posts()) :
    ?>
    <div class="posts-grid grid grid-3">
        <?php
        while ($active_query->have_posts()) :
            $active_query->the_post();
            get_template_part('template-parts/content', get_post_type());
        endwhile;
        ?>
    </div>
    <?php
    if ($pagination_args !== false) :
        $pagination_config = is_array($pagination_args) ? $pagination_args : array();
        tavaled_pagination($active_query, $pagination_config);
    endif;
else :
    get_template_part('template-parts/content', 'none');
endif;

if ($custom_query instanceof WP_Query) {
    wp_reset_postdata();
}

set_query_var('tavaled_blog_query', null);
set_query_var('tavaled_blog_pagination', null);

