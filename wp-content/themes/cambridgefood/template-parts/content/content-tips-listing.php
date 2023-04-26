<?php echo get_template_part( 'template-parts/modules/common', 'banner' ); ?>

<?php echo get_template_part( 'template-parts/modules/common', 'overview' ); ?>

<?php 
$TipsArgs = array(
    'posts_per_page' => -1,
    'post_type' => 'recipes_and_tips',
    'post_status' => 'publish',        
    'orderby' => 'date', 
    'order' => 'DESC'
);

$the_query = new WP_Query($TipsArgs);
?>

<section class="container">
    <div class="py-5">
        <div class="row">
            <div class="col-lg-2">
                <div class="rt_links">
                    <ul>
                        <li><a href="<?php echo home_url().'/specials/recipes-tips/'; ?>" class="btn rt_link-yellow">All</a></li>
                        <li><a href="<?php echo home_url().'/specials/recipes/'; ?>" class="btn rt_link-pink">Recipes</a></li>
                        <li class="active"><a href="javascript:void(0)" class="btn rt_link-blue">Tips</a></li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
            </div>
            <div class="col-lg-10">
                <div class="row tips-box"><?php
                    if ($the_query->have_posts()):
                        while ($the_query->have_posts()):            
                            $the_query->the_post(); 

                            $tips_thum_id = get_post_thumbnail_id(get_the_ID());
                            $tips_thum_image = wp_get_attachment_image_src($tips_thum_id, 'recipe_tip_thumb_image');

                            $what_you_want_to_add = get_field('what_you_want_to_add');

                                if($what_you_want_to_add == "Tip"): ?>
                                    <div class="col-lg-4">
                                        <div class="box-slide">
                                            <div class="box-slide-content">
                                                <div class="box-slide-content-blk" style="background-image: url('<?php echo $tips_thum_image[0]; ?>');">
                                                    <div class="box-slide-content-text">                                                        
                                                        <div class="box-slide-btn bottom"><a href="<?php echo  get_the_permalink(); ?>" class="btn btn-blue"><span><?php echo get_the_title(); ?></span></a></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div><?php
                                endif;
                        endwhile;
                        wp_reset_query();
                        wp_reset_postdata();
                    endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<?php echo get_template_part( 'template-parts/modules/common', 'footer-banner' ); ?>