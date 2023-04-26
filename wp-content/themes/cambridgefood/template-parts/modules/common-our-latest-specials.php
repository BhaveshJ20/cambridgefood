<!-- Our Latest Specials Section Start -->
<?php
$our_latest_specials_title = get_field('our_latest_specials_title');
$our_latest_specials_link = get_field('our_latest_specials_link');
$add_our_latest_specials = get_field('add_our_latest_specials');
if($add_our_latest_specials): ?>

    <section class="bg-pink">
        <div class="heading1 text-center">
            <h2 class="mb-0">
                <a href="<?php echo $our_latest_specials_link; ?>" ><?php echo ($our_latest_specials_title) ? $our_latest_specials_title : 'Our Latest Specials'; ?></a>
            </h2>
        </div>
    </section>

    <section class="latest-specials">
        <ul><?php
            $our_latest_specials_args = array(
                'posts_per_page' => -1,
                'post_type' => 'our_latest_specials',
                'post_status' => 'publish',
                'post__in' => $add_our_latest_specials,
                'orderby' => 'post__in'
            );
            $the_query = new WP_Query($our_latest_specials_args);

            if($the_query->have_posts()):
                while($the_query->have_posts()):
                    $the_query->the_post();

                    $product_title = get_field('product_title');
                    $product_url = get_field('product_url');
                    $product_main_price = get_field('product_main_price');
                    $product_discount_price = get_field('product_discount_price');
                    $product_total_weight = get_field('product_total_weight');
                    $price_tag_background_color = get_field('price_tag_background_color');
                    $select_price_positions = get_field('select_price_positions'); 
                    $product_image = get_the_post_thumbnail_url( get_the_ID(), array(365,325));
                    $not_found_image = get_stylesheet_directory_uri() . '/assets/images/not-found.png'; 
                    if($select_price_positions == 'Top Left'){
                        $Position = 'left';
                    }elseif ($select_price_positions == 'Top Left Bottom') {
                        $Position = 'left-bottom';
                    }elseif ($select_price_positions == 'Top Right') {
                        $Position = 'right';
                    }elseif ($select_price_positions == 'Top Right Bottom') {
                        $Position = 'right-bottom';
                    } ?>
                    <li><a href="<?php echo $product_url; ?>" target="_blank">
                        <div class="latest-specials-box" style="/*background-image: url('<?php echo ($product_image) ? $product_image : $not_found_image; ?>');">
                            <img class="latest-specials-img" src="<?php echo ($product_image) ? $product_image : $not_found_image; ?>" alt="">
                            <div class="latest-special-price <?php echo $Position; ?>">
                                <div class="latest-special-price-text">
                                <b><?php echo trim($product_main_price); ?><sup><?php echo trim($product_discount_price); ?></sup><sub><?php echo trim($product_total_weight); ?></sub></b><span><?php echo trim($product_title); ?></span>
                                </div>
                            </div>
                        </div></a>
                    </li><?php
                endwhile;
                wp_reset_query();
                wp_reset_postdata();
            endif; ?>
            <div class="clearfix"></div>
        </ul>
    </section><?php
endif; ?>
<!-- Our Latest Specials Section End -->