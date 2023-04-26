<?php echo get_template_part( 'template-parts/modules/common', 'banner' ); ?>

<?php echo get_template_part( 'template-parts/modules/common', 'overview' ); ?>

<section class="mc_wrap">
    <div class="container">
        <div class="row"><?php
            if( have_rows('add_moeny_center_sections') ):
                while ( have_rows('add_moeny_center_sections') ) : the_row();
                    $mc_title = get_sub_field('mc_title');
                    $mc_sub_title = get_sub_field('mc_sub_title');
                    $mc_colour = get_sub_field('mc_colour');                    
                    $mc_important_notes = get_sub_field('mc_important_notes');
                    $mc_button_text = get_sub_field('mc_button_text');
                    $mc_button_link = get_sub_field('mc_button_link');
                    $mc_thumbnail_image = wp_get_attachment_image_src(get_sub_field('mc_thumbnail_image')['id'],'money_centre_image'); 
                    if($mc_colour == "Pink"){
                        $sectionColor = 'heading-pink';
                        $textColor = 'pink-text';
                        $btnColor = 'btn-pink';
                    }elseif($mc_colour == "Blue") {
                        $sectionColor = 'heading-blue';
                        $textColor = 'blue-text';
                        $btnColor = 'btn-blue';
                    }
                    
                    ?>
                    <div class="col-lg-6">
                        <div class="mc_top_box d-flex flex-column">
                            <div class="mc_top_img">
                                <img class="img-full" src="<?php echo $mc_thumbnail_image[0]; ?>" alt="">
                            </div>
                            <div class="mc_btm_box text-center ">
                                <div class="<?php echo $sectionColor; ?>">
                                    <h4 class="mb-0"><?php echo ($mc_title) ? $mc_title : 'Money Center'; ?></h4>
                                </div>
                                <div class="mc_cont_box">
                                    <div class="mc_cont_box_inner">
                                        <div class="title2">
                                            <h2 class="<?php echo $textColor; ?>">
                                                <?php echo ($mc_sub_title) ? $mc_sub_title : 'Pay your accounts at any of the till points or at our Money Centre where a member of our team will assist you.'; ?>
                                            </h2>
                                        </div><?php
                                        if( have_rows('mc_brand_partner_logo') ):
                                            while ( have_rows('mc_brand_partner_logo') ) : the_row();
                                                $mc_brand_partner_logo = wp_get_attachment_image_src(get_sub_field('add_brand_partner_logo')['id'],''); ?>
                                                <img src="<?php echo $mc_brand_partner_logo[0]; ?>" alt=""><?php
                                            endwhile;
                                            wp_reset_query();
                                        endif;                                 
                                        if($mc_important_notes): ?>
                                            <p class="mt-4">
                                                <small><?php echo $mc_important_notes; ?></small>
                                            </p><?php
                                        endif; ?>
                                    </div>
                                </div>
                            </div>
                            <div class="mc_btn">
                                <a href="<?php echo ($mc_button_link) ? $mc_button_link : 'javascript:void(0)'; ?>" class="btn <?php echo $btnColor; ?>"><?php echo ($mc_button_text)? $mc_button_text : 'MORE INFO'; ?></a>
                            </div>
                        </div>
                    </div>
                    <?php
                endwhile;
            endif; ?>            
        </div>
    </div>
</section>

<?php echo get_template_part( 'template-parts/modules/common', 'available-store' ); ?>

<?php echo get_template_part( 'template-parts/modules/common', 'footer-banner' ); ?> 