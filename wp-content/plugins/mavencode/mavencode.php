<?php
/*
 * Plugin Name: Code implemented By Sagar (Maven)
 * Description: Custom Coding <strong> (PLEASE DON'T REMOVE THIS PLUGIN)</strong>
 * Author: <strong>Sagar Prajapati (Maven)</strong>
 */

add_action('wp_ajax_getRecipeAndTips', 'getRecipeAndTips');
add_action('wp_ajax_nopriv_getRecipeAndTips', 'getRecipeAndTips');

function getRecipeAndTips() {
    global $wpdb;

    $response = array();
    $htmlFirst = '';
    $htmlList = $htmlSecond = '';

    $count_args = array(
        'posts_per_page' => -1,
        'post_type' => 'recipes_and_tips',
        'post_status' => 'publish',
        'orderby' => 'date', 
        'order' => 'DESC'
    );

    $count_query = new WP_Query($count_args);
    $response['total_recipesandtips'] = $count_query->found_posts;

    $limitstart = $_POST['limitstart'];
    $limit = get_field('recipe_and_tips_per_page', 'option');

    $args = array(
        'posts_per_page' => $limit,
        'offset' => $limitstart,
        'post_type' => 'recipes_and_tips',
        'post_status' => 'publish',        
        'orderby' => 'date', 
        'order' => 'DESC'
    );

    $the_query = new WP_Query($args);

    $RecipeAndTipsCnt = 1;
    if ($the_query->have_posts()):
        while ($the_query->have_posts()):            
            $the_query->the_post(); 
            
            $recipesandtips_thum_id = get_post_thumbnail_id(get_the_ID());
            if($RecipeAndTipsCnt == 1):
                $recipeandtips_thum_image = wp_get_attachment_image_src($recipesandtips_thum_id, 'recipe_tip_thumb_first_image');
            else:
                $recipeandtips_thum_image = wp_get_attachment_image_src($recipesandtips_thum_id, 'recipe_tip_thumb_image');
            endif;

            $what_you_want_to_add = get_field('what_you_want_to_add');
            if($what_you_want_to_add == "Recipe"){                
                $RecipeAndTipCategories = "Recipe";
                $RecipeAndTipCategoriesColour = 'bg-pink';
                $RecipeAndTipServes = get_field('recipe_serves');
                $RecipeAndTipPrepTime = get_field('recipe_prep_time');
                $post_small_description = '';
            }else{
                $RecipeAndTipCategories = "Tip";
                $RecipeAndTipCategoriesColour = 'bg-blue';
                $RecipeAndTipServes = '';
                $RecipeAndTipPrepTime = '';
                $post_small_description = get_field('post_small_description');
            }            
        
            if($RecipeAndTipsCnt == 1 && $_POST['statusType'] == "initial"): 
                $htmlFirst .= '<section class="container">';
                    $htmlFirst .= '<div class="pt-5">';
                        $htmlFirst .= '<div class="row">';
                            $htmlFirst .= '<div class="col-lg-2"><div class="rt_links"><ul>';
                                $htmlFirst .= '<li class="active"><a href="javascript:void(0)" class="btn rt_link-yellow">All</a></li>';
                                $htmlFirst .= '<li><a href="'.home_url().'/specials/recipes/" class="btn rt_link-pink">Recipes</a></li>';
                                $htmlFirst .= '<li><a href="'.home_url().'/specials/tips/" class="btn rt_link-blue">Tips</a></li>';
                        $htmlFirst .= '</ul></div></div>';
                        $htmlFirst .= ' <div class="col-lg-10"><div class="row">';
                            $htmlFirst .= '<div class="col-lg-7 col-md-6">';
                                $htmlFirst .= '<div class="news-thumb" style="background-image: url('.$recipeandtips_thum_image[0].');">';
                                    $htmlFirst .= '<div class="tag"><div class="tag-text '.$RecipeAndTipCategoriesColour.' text-white"><span>'.$RecipeAndTipCategories.'</span></div></div>';
                            $htmlFirst .= '</div></div>';
                            $htmlFirst .= '<div class="col-lg-5 col-md-6"><div class="news-text">';
                                $htmlFirst .= '<div class="title3 bg-pink mb-3"><h2 class="mb-0"><a href="'.get_the_permalink().'" class="text-white">'.get_the_title().'</a></h2></div>';
                                    $htmlFirst .= '<div class="rt_short_info">';
                                        if($RecipeAndTipServes):
                                            $htmlFirst .= '<h4 class="blue-text">SERVES: '.$RecipeAndTipServes.'</h4>';
                                        endif;

                                        if($RecipeAndTipPrepTime):
                                            $htmlFirst .= '<h4 class="pink-text">PREP TIME: '.$RecipeAndTipPrepTime.'</h4>';
                                        endif;                                        
                                    $htmlFirst .= '</div>';
                                    $htmlFirst .= '<div class="news-btn text-right"><a href="'.get_the_permalink().'" class="btn btn-blue">Read More</a></div>';
                            $htmlFirst .= '</div></div>';
                        $htmlFirst .= '</div></div>';
                        $htmlFirst .= '</div><hr class="border-btm">';
                $htmlFirst .= '</div></section>';
            else:
                $htmlSecond .= '<div class="row">'; 
                    $htmlSecond .= '<div class="col-md-6"><div class="news-thumb" style="background-image: url('.$recipeandtips_thum_image[0].');">';
                        $htmlSecond .= '<div class="tag"><div class="tag-text '.$RecipeAndTipCategoriesColour.' text-white"><span>'.$RecipeAndTipCategories.'</span></div></div>';
                    $htmlSecond .= '</div></div>';
                    $htmlSecond .= '<div class="col-md-6"><div class="news-text">';
                        $htmlSecond .= '<div class="title3 bg-pink mb-3"><h3 class="mb-0"><a href="'.get_the_permalink().'" class="text-white">'.get_the_title().'</a></h3></div>';
                            $htmlSecond .= '<div class="rt_short_info">';
                            if($RecipeAndTipServes):
                                $htmlSecond .= '<h4 class="blue-text">SERVES: '.$RecipeAndTipServes.'</h4>';
                            endif;

                            if($RecipeAndTipPrepTime):
                                $htmlSecond .= '<h4 class="pink-text">PREP TIME: '.$RecipeAndTipPrepTime.'</h4>';
                            endif;

                            if($post_small_description):
                                $htmlSecond .= '<p>'.$post_small_description.'</p>';
                            endif;
                            $htmlSecond .= '</div>';
                            $htmlSecond .= '<div class="news-btn text-right"><a href="'.get_the_permalink().'" class="btn btn-blue">Read More</a></div>';
                        $htmlSecond .= '</div></div>';
                $htmlSecond .= '</div>';
                if($RecipeAndTipsCnt != $count_query->found_posts){
                    $htmlSecond .= '<hr class="border-btm">';
                }
            endif;
            $RecipeAndTipsCnt++;
        endwhile;
        wp_reset_query();
    else:
        $htmlSecond .= '<div class="text-center"><p>No Recipes and Tips Found!</p></div>';
    endif;

    $response['htmlFirst'] = $htmlFirst;
    $response['htmlSecond'] = $htmlSecond;
    echo json_encode($response);
    die();
}

add_action('wp_ajax_getRecipe', 'getRecipe');
add_action('wp_ajax_nopriv_getRecipe', 'getRecipe');

function getRecipe() {
    global $wpdb;

    $response = array();
    $htmlFirst = '';
    $htmlList = $htmlSecond = '';

    $count_args = array(
        'posts_per_page' => -1,
        'post_type' => 'recipes_and_tips',
        'post_status' => 'publish',
        'orderby' => 'date', 
        'order' => 'DESC'
    );

    $count_query = new WP_Query($count_args);

    if ($count_query->have_posts()):
        $TCountRecipe = 0;
        while($count_query->have_posts()):
            $count_query->the_post(); 
            $what_you_want_to_add = get_field('what_you_want_to_add');
            if($what_you_want_to_add == "Recipe"){  
                $TCountRecipe++;
            }
        endwhile;
        wp_reset_query();
        wp_reset_postdata();
    endif;

    $response['total_recipes'] = $TCountRecipe;

    $limitstart = $_POST['limitstart'];
    $limit = get_field('recipe_per_page', 'option');

    $args = array(
        'posts_per_page' => $limit,
        'offset' => $limitstart,
        'post_type' => 'recipes_and_tips',
        'post_status' => 'publish',        
        'orderby' => 'date', 
        'order' => 'DESC'
    );

    $the_query = new WP_Query($args);

    $RecipeCnt = 1;
    if ($the_query->have_posts()):
        while ($the_query->have_posts()):            
            $the_query->the_post(); 
            
            $recipes_thum_id = get_post_thumbnail_id(get_the_ID());
            if($RecipeCnt == 1):
                $recipe_thum_image = wp_get_attachment_image_src($recipes_thum_id, 'recipe_tip_thumb_first_image');
            else:
                $recipe_thum_image = wp_get_attachment_image_src($recipes_thum_id, 'recipe_tip_thumb_image');
            endif;

            $what_you_want_to_add = get_field('what_you_want_to_add');
            if($what_you_want_to_add == "Recipe"){                
                $RecipeCategories = "Recipe";
                $RecipeCategoriesColour = 'bg-pink';
                $RecipeServes = get_field('recipe_serves');
                $RecipePrepTime = get_field('recipe_prep_time');

                if($RecipeCnt == 1 && $_POST['statusType'] == "initial"): 
                    $htmlFirst .= '<section class="container">';
                        $htmlFirst .= '<div class="pt-5">';
                            $htmlFirst .= '<div class="row">';
                                $htmlFirst .= '<div class="col-lg-2"><div class="rt_links"><ul>';
                                    $htmlFirst .= '<li><a href="'.home_url().'/specials/recipes-tips/" class="btn rt_link-yellow">All</a></li>';
                                    $htmlFirst .= '<li class="active"><a href="javascript:void(0)" class="btn rt_link-pink">Recipes</a></li>';
                                    $htmlFirst .= '<li><a href="'.home_url().'/specials/tips/" class="btn rt_link-blue">Tips</a></li>';
                            $htmlFirst .= '</ul></div></div>';
                            $htmlFirst .= ' <div class="col-lg-10"><div class="row">';
                                $htmlFirst .= '<div class="col-lg-7 col-md-6">';
                                    $htmlFirst .= '<div class="news-thumb" style="background-image: url('.$recipe_thum_image[0].');">';
                                        $htmlFirst .= '<div class="tag"><div class="tag-text '.$RecipeCategoriesColour.' text-white"><span>'.$RecipeCategories.'</span></div></div>';
                                $htmlFirst .= '</div></div>';
                                $htmlFirst .= '<div class="col-lg-5 col-md-6"><div class="news-text">';
                                    $htmlFirst .= '<div class="title3 bg-pink mb-3"><h2 class="mb-0"><a href="'.get_the_permalink().'" class="text-white">'.get_the_title().'</a></h2></div>';
                                        $htmlFirst .= '<div class="rt_short_info">';
                                            if($RecipeServes):
                                                $htmlFirst .= '<h4 class="blue-text">SERVES: '.$RecipeServes.'</h4>';
                                            endif;
    
                                            if($RecipePrepTime):
                                                $htmlFirst .= '<h4 class="pink-text">PREP TIME: '.$RecipePrepTime.'</h4>';
                                            endif;                                        
                                        $htmlFirst .= '</div>';
                                        $htmlFirst .= '<div class="news-btn text-right"><a href="'.get_the_permalink().'" class="btn btn-blue">Read More</a></div>';
                                $htmlFirst .= '</div></div>';
                            $htmlFirst .= '</div></div>';
                            $htmlFirst .= '</div><hr class="border-btm">';
                    $htmlFirst .= '</div></section>';
                else:
                    $htmlSecond .= '<div class="row">'; 
                        $htmlSecond .= '<div class="col-md-6"><div class="news-thumb" style="background-image: url('.$recipe_thum_image[0].');">';
                            $htmlSecond .= '<div class="tag"><div class="tag-text '.$RecipeCategoriesColour.' text-white"><span>'.$RecipeCategories.'</span></div></div>';
                        $htmlSecond .= '</div></div>';
                        $htmlSecond .= '<div class="col-md-6"><div class="news-text">';
                            $htmlSecond .= '<div class="title3 bg-pink mb-3"><h3 class="mb-0"><a href="'.get_the_permalink().'" class="text-white">'.get_the_title().'</a></h3></div>';
                                $htmlSecond .= '<div class="rt_short_info">';
                                if($RecipeServes):
                                    $htmlSecond .= '<h4 class="blue-text">SERVES: '.$RecipeServes.'</h4>';
                                endif;
    
                                if($RecipePrepTime):
                                    $htmlSecond .= '<h4 class="pink-text">PREP TIME: '.$RecipePrepTime.'</h4>';
                                endif;
                                $htmlSecond .= '</div>';
                                $htmlSecond .= '<div class="news-btn text-right"><a href="'.get_the_permalink().'" class="btn btn-blue">Read More</a></div>';
                            $htmlSecond .= '</div></div>';
                    $htmlSecond .= '</div>';
                    if($RecipeCnt != $TCountRecipe){
                        $htmlSecond .= '<hr class="border-btm">';
                    }
                endif;
            }

            $RecipeCnt++;
        endwhile;
        wp_reset_query();
    else:
        $htmlSecond .= '<div class="text-center"><p>No Recipes Found!</p></div>';
    endif;

    $response['htmlFirst'] = $htmlFirst;
    $response['htmlSecond'] = $htmlSecond;
    echo json_encode($response);
    die();
}