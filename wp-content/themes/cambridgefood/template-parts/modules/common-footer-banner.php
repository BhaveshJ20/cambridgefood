<?php
$footer_banner_text = get_field('footer_banner_text');
$footer_banner_image = wp_get_attachment_image_src(get_field('footer_banner_image')['id'],'page_banner');
if($footer_banner_image[0]): ?>
    <section class="hero-banner hero-sub-banner">
        <div class="banner-wrap" style="background-image: url('<?php echo $footer_banner_image[0]; ?>');">
            <div class="container">
                <div class="banner-area-cont">
                    <div class="banner-text"><h2><?php echo $footer_banner_text; ?></h2></div>
                </div>
            </div>
        </div>
    </section><?php
endif; ?>