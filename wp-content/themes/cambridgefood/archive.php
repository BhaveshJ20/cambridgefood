<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage Twenty_Nineteen
 * @since 1.0.0
 */

get_header();
    if (have_posts()) :
        while (have_posts()) :
            the_post();
                get_template_part('template-parts/content/content', 'single'); 
        endwhile;
    endif;
get_footer(); ?>
