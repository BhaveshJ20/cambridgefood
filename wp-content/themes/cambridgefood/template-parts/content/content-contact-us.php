<?php echo get_template_part( 'template-parts/modules/common', 'banner' ); ?>
<section class="container">
   <div class="pt-5 mb-5">
        <div class="row">
            <div class="col-lg-8 col-bor-r">
                <div class="left-part">
                    <?php the_content(); ?>
                </div>
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
    </div>
</section>

<?php echo get_template_part( 'template-parts/modules/common', 'footer-banner' ); ?>