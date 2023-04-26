<section class="contentarea">

	<?php echo get_template_part( 'template-parts/modules/common', 'banner' ); ?>

	<?php echo get_template_part( 'template-parts/modules/common', 'overview' ); 

		$what_you_want_to_add = get_field('what_you_want_to_add');

		if($what_you_want_to_add == "Recipe"): ?>
			<section class="container">
				<div class="pt-5">
					<div class="row">
						<div class="col-lg-2">
							<div class="rt_links">								
								<ul>
									<li><a href="<?php echo home_url().'/specials/recipes-tips/' ?>" class="btn rt_link-yellow">All</a></li>
									<li class="active"><a href="<?php echo home_url().'/specials/recipes/'; ?>" class="btn rt_link-pink">Recipes</a></li>
									<li><a href="<?php echo home_url().'/specials/tips/'; ?>" class="btn rt_link-blue">Tips</a></li>
								</ul>
								<div class="clearfix"></div>
							</div>
							<div class="return_back go-back"><a href="<?php echo home_url().'/specials/recipes/'; ?>" class="btn btn-blue d-block">Go Back</a></div>
						</div><?php
						$recipe_serves = get_field('recipe_serves');
						$recipe_prep_time = get_field('recipe_prep_time');
						$add_recipe_ingredients = get_field('add_recipe_ingredients');
						$recipe_method = get_field('recipe_method');

						$lenIngredients = count($add_recipe_ingredients);
						$firstIngredients = array_slice($add_recipe_ingredients, 0, $lenIngredients / 2);
						$secondIngredients = array_slice($add_recipe_ingredients, $lenIngredients / 2);
						?>
						<div class="col-lg-10">
							<div class="news-text h-auto">
								<div class="rt_short_info mb-4">
									<?php
									if($recipe_serves):
										echo '<h4 class="blue-text">SERVES: '.$recipe_serves.'</h4>';
									endif;
									if($recipe_prep_time):
										echo '<h4 class="pink-text">PREP TIME: '.$recipe_prep_time.'</h4>';
									endif;
									?>
									<div class="recipe-smedia">
										<?php echo sharethis_inline_buttons(); ?>
									</div>
								</div>
							</div>
							<?php
							if(!empty($firstIngredients) || !empty($secondIngredients)): ?>
								<div class="title2 mb-3">
									<h2 class="pink-text">Ingredients</h2>
								</div>
								<div class="row"><?php
									if($firstIngredients): ?>
										<div class="col-lg-6">
											<div class="list1">
												<ul><?php
												foreach ($firstIngredients as $firstIngredientsValue):
													echo '<li>'.$firstIngredientsValue['recipe_ingredients'].'</li>';
												endforeach; ?>
												</ul>
											</div>
										</div><?php
									endif;
									if($secondIngredients): ?>
										<div class="col-lg-6">
											<div class="list1">
												<ul><?php
												foreach ($secondIngredients as $secondIngredientsValue):
													echo '<li>'.$secondIngredientsValue['recipe_ingredients'].'</li>';
												endforeach; ?>
												</ul>
											</div>
										</div>
										<?php
									endif;?>	                        
								</div><?php
							endif;

							if($recipe_method): ?>
								<hr class="border-btm">
								<div class="title2 mb-3">
									<h2 class="pink-text">Method:</h2>
								</div>
								<?php echo $recipe_method; 
							endif; ?>
						</div>
					</div>
				</div>
			</section><?php
		elseif ($what_you_want_to_add == "Tip"):
			$tip_title = get_field('tip_title');
			$tip_banner_image = wp_get_attachment_image_src(get_field('tip_banner_image')['id'],'tips_detail_banner_image');
			$tip_short_description = get_field('tip_short_description'); ?>
			<div class="py-5">
				<div class="container">
					<div class="row">
						<div class="col-lg-2 relative mx-h">
							<div class="rt_links mb-68">
								<ul>
									<li><a href="<?php echo home_url().'/specials/recipes-tips/' ?>" class="btn rt_link-yellow">All</a></li>
									<li><a href="<?php echo home_url().'/specials/recipes/'; ?>" class="btn rt_link-pink">Recipes</a></li>
									<li class="active"><a href="<?php echo home_url().'/specials/tips/'; ?>" class="btn rt_link-blue">Tips</a></li>
								</ul>
								<div class="clearfix"></div>
							</div>
							<div class="return_back"><a href="<?php echo home_url().'/specials/tips/'; ?>" class="btn btn-blue d-block">Go Back</a></div>
						</div>
						<div class="col-lg-10">

							<div class="tips-detail" id="main-tip-section"><?php
								if($tip_banner_image[0]): ?>
									<div class="tips-img">
										<img src="<?php echo $tip_banner_image[0]; ?>" alt="">
									</div><?php
								endif; ?>					
								<div class="tips-detail-text">
									<div class="title">
										<h2 class="blue-text"><?php echo $tip_title; ?></h2>
									</div><?php
									if($tip_short_description):
										echo '<p>'.$tip_short_description.'</p>';
									endif; ?>									
								</div>
							</div>
							<input type="hidden" name="currentTipDisplay" id="currentTipDisplay"><?php
							if( have_rows('add_tips') ):										
								while ( have_rows('add_tips') ) : the_row();
									$tips_title = get_sub_field('tips_title');
									$tips_full_description = get_sub_field('tips_full_description');
									$tips_banner_image = wp_get_attachment_image_src(get_sub_field('tips_banner_image')['id'],'tips_detail_banner_image'); 
									$tipId = 'single-'.strtolower(str_replace(' ','-',$tips_title)); ?>

									<div class="tips-detail" id="<?php echo $tipId; ?>" style="display:none;"><?php
										if($tips_banner_image[0]): ?>
											<div class="tips-img">
												<img src="<?php echo $tips_banner_image[0]; ?>" alt="">
											</div><?php
										endif; ?>					
										<div class="tips-detail-text">
											<div class="title">
												<h2 class="blue-text"><?php echo $tips_title; ?></h2>
											</div><?php
											if($tips_full_description):
												echo '<p>'.$tips_full_description.'</p>';
											endif; ?>									
										</div>
									</div><?php
								endwhile;
								wp_reset_postdata();
								wp_reset_query();
							endif; ?>

							<div class="tips-slider-wrap">
								<div class="owl-carousel tips-slider owl-theme"><?php									
									if( have_rows('add_tips') ):										
										while ( have_rows('add_tips') ) : the_row();								
											$tips_title = get_sub_field('tips_title');
											$tips_short_description = get_sub_field('tips_short_description');
											$tips_thumbnail_image = wp_get_attachment_image_src(get_sub_field('tips_thumbnail_image')['id'],'tips_scroller_thumb_image'); ?>

											<div class="item">
												<div class="tips-slide-content-blk">
													<div class="tips-slide-cotent-inner">
														<div class="tips-slide-content" style="background-image: url('<?php echo $tips_thumbnail_image[0]; ?>');">
															<div class="blk-overlay"></div>
															<div class="tips-slide-content-text">
																<h3 class="text-white mb-1">
																	<a href="javascript:void(0);" onclick="openTips('single-<?php echo strtolower(str_replace(' ','-',$tips_title)); ?>')" ><?php echo $tips_title; ?></a>
																</h3>
																<p class="text-white"><?php echo $tips_short_description; ?></p>
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
						</div>
					</div>
				</div>
			</div><?php
		endif; ?>                
</section>