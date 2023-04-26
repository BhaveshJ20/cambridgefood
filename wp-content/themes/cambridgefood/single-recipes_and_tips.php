<?php
/**
 * The template for displaying all guide single posts and attachments
 *
 * @package WordPress
 * @subpackage Twenty_Sixteen
 * @since Twenty Sixteen 1.0
 */

get_header();
    if (have_posts()) :
        while (have_posts()) :
            the_post();
                get_template_part('template-parts/content/content', 'recipes-tip-detail'); 
        endwhile;
    endif;
get_footer(); ?>