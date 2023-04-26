<?php echo get_template_part( 'template-parts/modules/common', 'banner' ); ?>

<section class="contentarea">

    <?php echo get_template_part( 'template-parts/modules/common', 'overview' ); ?>

    <section class="container pt-5"><?php 
        $latest_args = array(
            'posts_per_page' => 1,
            'post_type' => 'post',
            'post_status' => 'publish',                
            'orderby' => 'date', 
            'order' => 'DESC',
            'category_name' => 'latest'
        );

        $the_query = new WP_Query($latest_args);        
        if ($the_query->have_posts()):
            while ($the_query->have_posts()):
                $the_query->the_post(); 
                $post_small_description = get_field('post_small_description'); ?>
                <div class="row">
                    <div class="col-md-5">
                        <div class="news-thumb" style="background-image: url('<?php echo get_the_post_thumbnail_url(get_the_ID()); ?>');">         
                            <div class="tag"><div class="tag-text bg-yellow blue-text"><span>Latest</span></div></div>
                        </div>
                    </div>
                    <div class="col-md-7">
                        <div class="news-text">
                            <div class="title3 bg-pink mb-3"><h2 class="mb-0"><a href="<?php echo get_the_permalink(); ?>" class="text-white"><?php echo get_the_title(); ?></a></h2></div>
                            <?php echo $post_small_description; ?>
                            <div class="news-btn text-right"><a href="<?php echo get_the_permalink(); ?>" class="btn btn-blue">Read More</a></div>
                        </div>
                    </div>
                </div>
                <hr class="border-btm"><?php
            endwhile;
            wp_reset_query();
            wp_reset_postdata();
        endif; ?>
    </section>

    <section class="container mb-5">
        <div class="row">
            <div class="col-lg-8 col-bor-r mb-5">
                <div class="left-part">
                <?php        
                    $all_args = array(
                        'posts_per_page' => -1,
                        'post_type' => 'post',
                        'post_status' => 'publish',                
                        'orderby' => 'date', 
                        'order' => 'DESC',
                        'category_name' => 'news,press'
                    );
                    
                    $the_query1 = new WP_Query($all_args);
                    $news_count = $the_query1->post_count;
                    $n_cnt = 1; 
                    if ($the_query1->have_posts()):
                        while ($the_query1->have_posts()): 
                            $the_query1->the_post(); 
                            $post_small_description = get_field('post_small_description');
                            $category_object = get_the_category(get_the_ID());
                            $category_name = $category_object[0]->name;
                            $cat_clr = 'bg-blue';
                            if($category_name == "Press"):
                                $cat_clr = 'bg-pink';
                            endif;
                            ?>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="news-thumb" style="background-image: url('<?php echo get_the_post_thumbnail_url(get_the_ID()); ?>');">
                                    
                                        <div class="tag"><div class="tag-text <?php echo $cat_clr; ?> text-white"><span><?php echo $category_name; ?></span></div></div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="news-text">
                                        <div class="title3 bg-pink mb-3">
                                            <h3 class="mb-0"><a href="<?php echo get_the_permalink(); ?>" class="text-white"><?php echo get_the_title(); ?></a></h3>
                                        </div>
                                        <?php echo $post_small_description; ?>
                                        <div class="news-btn text-right">
                                            <a href="<?php echo get_the_permalink(); ?>" class="btn btn-blue">Read More</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php 
                            if($n_cnt != $news_count):
                                echo '<hr class="border-btm">';
                            endif;
                            $n_cnt++;
                        endwhile;
                        wp_reset_query();
                        wp_reset_postdata();
                    endif; ?>                   
                </div>
                <div class="mt-5"><a href="<?php echo home_url().'/news/news-archives/'?>" class="btn btn-blue">ARCHIVES</a></div>
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