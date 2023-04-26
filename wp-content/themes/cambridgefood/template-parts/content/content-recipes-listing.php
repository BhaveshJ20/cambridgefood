<section class="contentarea">
    
    <?php echo get_template_part( 'template-parts/modules/common', 'banner' ); ?>

    <?php echo get_template_part( 'template-parts/modules/common', 'overview' ); ?>

    <?php 
    $limit = get_field('recipe_per_page', 'option');

    $RecipePageCount = array(
        'posts_per_page' => -1,
        'post_type' => 'recipes_and_tips',
        'post_status' => 'publish',
        'orderby' => 'date', 
        'order' => 'DESC'
    );

    $RecipePageCountQuery = new WP_Query($RecipePageCount);

    if ($RecipePageCountQuery->have_posts()):
        $ReipePageCount = 0;
        while($RecipePageCountQuery->have_posts()):
            $RecipePageCountQuery->the_post();
            $what_you_want_to_add = get_field('what_you_want_to_add');            
            if($what_you_want_to_add == "Recipe"){  
                $ReipePageCount++;
            }
        endwhile;
        wp_reset_query();
        wp_reset_postdata();
    endif;
    $RecipePageCount = $ReipePageCount;

    ?>

    <div id="RecipeFirstPost"></div>
    
    <section class="container">
        <div class="mb-5">
            <div class="row">
                <div class="col-lg-8 col-bor-r mb-5">
                    <div class="left-part">
                        <div id="RecipeSecondPost"></div>
                    </div>            
                    <img class="RecipeAndTipLoader" id="RecipeLoader" alt="Loading" title="loading" src="<?php echo get_stylesheet_directory_uri().'/assets/images/spinner-101.gif'; ?>">

                    <div class="mt-5">
                        <a href="javascript:void(0);" id="LoadMoreBtn" onclick="getRecipe('loadMore')" class="btn btn-blue">LOAD MORE</a>
                    </div>
                    <input type="hidden" id="limitstart" value="0"/>
                    <input type="hidden" id="limit" value="<?php echo $limit; ?>"/>
                    <input type="hidden" id="totalRecipe" value="<?php echo $RecipePageCount; ?>"/>
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

</section>

<?php echo get_template_part( 'template-parts/modules/common', 'footer-banner' ); ?>
