<?php
/**
 * Template Name: Recipes and Tips | Specials
 * The front page template file
 *
 */
get_header(); ?>
		<?php
		if ( have_posts() ) :
			while ( have_posts() ) : the_post();
				get_template_part( 'template-parts/content/content', 'recipes-and-tips' );
			endwhile;
		else :
			get_template_part( 'template-parts/content/content', 'none' );
		endif; ?>
<?php get_footer();