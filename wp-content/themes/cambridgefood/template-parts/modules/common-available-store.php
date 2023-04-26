<section class="box-slider-wrap mc_slider">
    <div class="title blue-text text-center"><h3>ALSO AVAILABLE IN-STORE:</h3></div>
    <div class="container">
        <div class="owl-carousel mc_box_slider owl-theme"><?php
        if( have_rows('select_pages') ):
            while( have_rows('select_pages') ): the_row();
                $select_page_link = get_sub_field('select_page_link');
                $thumb_image = wp_get_attachment_image_src(get_sub_field('thumb_image')['id'],'');
                $button_text = get_sub_field('button_text'); ?>
                <div class="item">
                    <div class="box-slide">
                        <div class="box-slide-content">
                            <div class="box-slide-content-blk" style="background-image: url('<?php echo $thumb_image[0]; ?>');">
                                <div class="box-slide-content-text">                                        
                                    <div class="box-slide-btn top">
                                        <?php if($select_page_link): ?>
                                            <a href="<?php echo $select_page_link; ?>" class="btn btn-pink"><span><?php echo $button_text; ?></span></a>
                                            <?php else: ?>
                                            <div class="heading-pink">
                                                <h5><?php echo $button_text; ?></h5>
                                            </div>
                                        <?php endif;?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    </div><?php                    
                endwhile;
                wp_reset_query();
            endif; ?>
        </div>
    </div>
</section>