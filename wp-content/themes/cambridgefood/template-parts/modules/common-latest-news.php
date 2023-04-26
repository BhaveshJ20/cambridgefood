<section class="box-slider-wrap latest-news-slider">
    <div class="container">
        <div class="title blue-text text-center">
            <h2 class="mt-0">LATEST NEWS</h2>
        </div>
        <div class="owl-carousel box-slider owl-theme">
            <?php
            $args = array(
                'posts_per_page' => -1,
                'post_type' => 'post',
                'post_status' => 'publish',                
                'orderby' => 'date', 
                'order' => 'DESC'
            );
        
            $the_query = new WP_Query($args);        
            if ($the_query->have_posts()):
                while ($the_query->have_posts()):
                    $the_query->the_post(); ?>
                    <div class="item">
                        <div class="box-slide">
                            <div class="box-slide-content">
                                <div class="box-slide-content-blk" style="background-image: url('<?php echo get_the_post_thumbnail_url( get_the_ID(), array(354,342)); ?>');">
                                    <div class="box-slide-content-text">                                    
                                        <div class="box-slide-btn bottom"><a href="#" class="btn btn-pink"><span><?php echo get_the_title(); ?></span></a></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><?php
                endwhile;
                wp_reset_query();
                wp_reset_postdata();                
            endif; ?>               
        </div>
    </div>
</section>