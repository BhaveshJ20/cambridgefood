<?php echo get_template_part( 'template-parts/modules/common', 'banner' ); ?>

<section class="contentarea">

    <?php echo get_template_part( 'template-parts/modules/common', 'overview' ); ?>

    <section class="container pt-5 mb-5">
        <div class="row">
            <div class="col-lg-8 col-bor-r">
                <div class="left-part"><?php
                    if( have_rows('add_community_data') ):
                        $community_cnt = 1;
                        while ( have_rows('add_community_data') ) : the_row();
                            $title = get_sub_field('title');
                            $title_colour = get_sub_field('title_colour');
                            $description = get_sub_field('description'); ?>
                            <div class="<?php if($community_cnt == 1): echo 'text-center'; else: 'content-text mb-4'; endif; ?>">
                                <div class="title2">
                                    <h2 class="<?php echo $title_colour; ?>-text"><?php echo $title; ?></h2>
                                </div>
                            </div>
                            <div class="content-text mb-4"><?php echo $description; ?></div><?php
                            $community_cnt++;
                        endwhile;
                        wp_reset_query();
                        wp_reset_postdata();
                    endif; ?>

                    <div class="who-we-brand community-brand mt-5"><?php
                        if( have_rows('add_brand_image') ):
                            while ( have_rows('add_brand_image') ) : the_row();
                                $brand_image = wp_get_attachment_image_src(get_sub_field('brand_image')['id'],''); 
                                if($brand_image): ?>
                                    <span><img src="<?php echo $brand_image[0]; ?>" alt=""></span><?php
                                endif;
                            endwhile;
                        endif; ?>
                    </div>
                </div>
                <?php if(have_rows('gallery_image_list')): ?>
                    <div class="title text-center my-4">
                        <h3 class="blue-text text-uppercase"><?php the_field('gallery_section_title'); ?></h3>
                    </div>
                    <div class="community-slider-for slider">
                        <?php
                        while(have_rows('gallery_image_list')):
                            the_row();
                            $gallery_image_title = get_sub_field('gallery_image_title');
                            $gallery_image = get_sub_field('gallery_image');
                            if($gallery_image):
                                $img_src = wp_get_attachment_image_src($gallery_image['id'],'community_gallery');            			
                                ?>
                                <div>
                                    <img src="<?php echo $img_src[0]; ?>" alt="<?php echo $winner_title; ?>">
                                </div>
                                <?php 
                            endif;
                        endwhile; 
                        ?>
                    </div>
                    <div class="community-slider-nav slider ">
                        <?php
                        while(have_rows('gallery_image_list')):
                            the_row();
                            $gallery_image_title = get_sub_field('gallery_image_title');
                            $gallery_image = get_sub_field('gallery_image');
                            if($gallery_image):
                                $img_src = wp_get_attachment_image_src($gallery_image['id'],'winner_thumb');            			
                                ?>
                                <div>
                                    <div class="slick-slide-box">
                                        <img src="<?php echo $img_src[0]; ?>" alt="<?php echo $gallery_image_title; ?>">
                                    </div>
                                </div>
                                <?php 
                            endif;
                        endwhile; 
                        ?>
                    </div>
                <?php endif; ?>
            </div><?php 
            if ( !wp_is_mobile() ): ?>
                <div class="col-lg-4">
                    <div class="right-part">
                        <div class="title blue-text text-center">
                            <h2 class="mt-0">FOLLOW US!</h2>
                            <div class="fb-page" data-href="https://www.facebook.com/CambridgeFoodSA/" data-tabs="home, about, photos, reviews, videos, posts, message, timeline" data-width="500" data-height="1000" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true"><blockquote cite="https://www.facebook.com/CambridgeFoodSA/" class="fb-xfbml-parse-ignore"><a href="https://www.facebook.com/CambridgeFoodSA/">Cambridge Food SA</a></blockquote></div>             
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <?php echo get_template_part( 'template-parts/modules/common', 'footer-banner' ); ?>

</section>
