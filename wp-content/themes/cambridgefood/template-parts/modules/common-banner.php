<!-- Banner Section Start -->
<?php
$banner_type = get_field('banner_type');
if($banner_type):
    if($banner_type == "Full Width Image Slider"):                      
        if( have_rows('add_slider_images') ):
            echo '<section class="owl-carousel hero-slider owl-theme">';
            while ( have_rows('add_slider_images') ) : the_row();
                $slider_image_text = get_sub_field('slider_image_text');
                $slider_image = wp_get_attachment_image_src(get_sub_field('slider_image')['id'],''); ?>
                <div class="item">
                    <div class="banner-wrap" style="background-image: url('<?php echo $slider_image[0]; ?>');">
                        <div class="container">
                            <div class="banner-area">
                                <div class="banner-area-cont">
                                    <div class="banner-text"><?php
                                        if(is_front_page()): ?>
                                            <h1><i><?php echo $slider_image_text; ?></i></h1><?php
                                        else:?>
                                            <h1><?php echo $slider_image_text; ?></h1><?php
                                        endif; ?>                                       
                                    </div>
                                </div>
                            </div> 
                        </div>
                    </div>
                </div><?php                
            endwhile;
            echo '</section>';
        endif;
    elseif ($banner_type == "Full Width Single Image"):  
        $add_banner_image_text = get_field('add_banner_image_text');
        $add_banner_image = wp_get_attachment_image_src(get_field('add_banner_image')['id'],''); ?>
        <section class="hero-banner">
            <div class="banner-wrap" style="background-image: url('<?php echo ($add_banner_image) ? $add_banner_image[0] : get_stylesheet_directory_uri() . '/images/hero-slide1.jpg'; ?>');">
                <div class="container">
                    <div class="banner-area-cont">
                        <div class="banner-text">
                        <h1><?php
                            if (is_singular('post')):
                                echo ($add_banner_image_text) ? $add_banner_image_text : get_the_title();
                            else:
                                echo ($add_banner_image_text) ? $add_banner_image_text : '';
                        endif; ?>
                       </h1></div>
                    </div>
                </div>
            </div>
        </section><?php
    endif;                
endif;
?>
<!-- Banner Section End -->
