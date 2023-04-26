<?php echo get_template_part( 'template-parts/modules/common', 'banner' ); ?>

<?php echo get_template_part( 'template-parts/modules/common', 'overview' ); ?>


<section class="container">
    <div class="news-archives">
        <div class="row"><?php
            $all_args = array(
                'posts_per_page' => -1,
                'post_type' => 'post',
                'post_status' => 'approved',                
                'orderby' => 'date', 
                'order' => 'DESC',
            );
            $the_query1 = new WP_Query($all_args);
            $postCnt = wp_count_posts()->archive;
            $secondlastvalue = $postCnt - 1;            

            $news_count = $the_query1->post_count;
            $n_cnt = 1; 
            if ($the_query1->have_posts()):
                while ($the_query1->have_posts()): 
                    $the_query1->the_post();
                    $post_small_description = get_field('post_small_description');
                    if($n_cnt % 2 == 0){
            echo    '<div class="col-lg-6 even">';
                    }else{
            echo    '<div class="col-lg-6 odd">';
                    } ?>
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <div class="title3 bg-pink mb-3"><h4 class="mb-0"><a href="<?php echo get_the_permalink(); ?>" class="text-white"><?php echo str_replace('Archived:','',get_the_title()); ?></a></h4></div>
                            </div>
                            <div class="col-md-6">
                                <div class="news-thumb" style="">
                                    <img class="img-full" src="<?php echo get_the_post_thumbnail_url(get_the_ID()); ?>" alt="">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="news-text"><?php
                                    $pos=strpos($post_small_description, ' ', 250);
                                    echo substr($post_small_description,0,$pos );  ?>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="news-btn text-right"><a href="<?php echo get_the_permalink(); ?>" class="btn btn-blue">Read More</a></div>
                            </div>
                        </div>
                        <?php 
                        if($n_cnt != $postCnt && $n_cnt != $secondlastvalue){
                            echo '<hr class="border-btm">';
                        }
                        ?>                        
                    </div><?php                
                    $n_cnt++;
                endwhile;
            endif; ?>
        </div>
    </div>
</section>

<?php echo get_template_part( 'template-parts/modules/common', 'footer-banner' ); ?>