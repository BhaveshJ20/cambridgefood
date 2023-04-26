<?php echo get_template_part( 'template-parts/modules/common', 'banner' ); ?>
<section class="mc_wrap">
	<div class="container">
		<?php if(have_rows('competitions')): ?>
			<div class="title2 text-center mb-5">
				<h2 class="pink-text"><?php the_field('competition_section_title'); ?></h2>
			</div>
			<ul class="competition-box">
				<?php
				while(have_rows('competitions')):
					the_row();
					$competition_title = get_sub_field('competition_title');
					$competition_image = get_sub_field('competition_image');
					if($competition_image):
						$img_src = wp_get_attachment_image_src($competition_image['id'],'competition_images');
					endif;
					$competition_description = get_sub_field('competition_description');
					$competition_terms_condition_button_text = get_sub_field('competition_terms_condition_button_text');
					$competition_terms_conditions_title = get_sub_field('competition_terms_conditions_title');
					$competition_terms_conditions = get_sub_field('competition_terms_conditions');
					?>
					<li class="competition-list">
						<div class="mc_top_box comp_box">
							<?php if($competition_image): ?>
								<div class="mc_top_img">
									<img class="img-full" src="<?php echo $img_src[0]; ?>" alt="<?php echo $competition_title; ?>">
								</div>
							<?php endif; ?>
							<div class="mc_btm_box text-center">
								<div class="heading-pink">
									<h4 class="mb-0"><span><?php echo $competition_title; ?></span></h4>
								</div>
								<div class="mc_cont_box">
									<div class="mc_cont_box_inner">
										<div class="title2">
											<h2 class="pink-text"><?php echo $competition_description; ?></h2>
										</div>
									</div>
								</div>
							</div>
							<div class="desclaimer-block">
								<div class="mc_btn">
									<a href="javascript:void(0);" class="btn btn-pink desclaimer_box_show"><?php echo $competition_terms_condition_button_text; ?></a>
								</div>
								<div class="desclaimer_content">
									<div class="text-right"><a href="javascript:void(0);" class="desclaimer_box_hide">X</a></div>
									<h3 class="text-white text-center mt-3 mb-0"><?php echo $competition_terms_conditions_title; ?></h3>
									<div class="scrollcontent content">
										<div class="list2">
											<?php echo $competition_terms_conditions; ?>
										</div>
									</div>
								</div>
							</div>
						</div>
					</li>
					<?php
				endwhile;
				?>
			</ul>
		<?php endif; ?>
		<div class="clearfix"></div>
	</div>
</section>
<?php if(have_rows('winners_list')): ?>
	<section class="container">
		<div class="title text-center my-4">
			<h3 class="blue-text text-uppercase"><?php the_field('competition_winners_section_title'); ?></h3>
		</div>
		<div class="slider-for slider">
			<?php
			while(have_rows('winners_list')):
				the_row();
				$winner_title = get_sub_field('winner_title');
				$winner_image = get_sub_field('winner_image');
				if($winner_image):
					$img_src = wp_get_attachment_image_src($winner_image['id'],'winner');            			
					?>
					<div>
						<img src="<?php echo $img_src[0]; ?>" alt="<?php echo $winner_title; ?>">
					</div>
					<?php 
				endif;
			endwhile; 
			?>
		</div>
		<div class="slider-nav slider">
			<?php
			while(have_rows('winners_list')):
				the_row();
				$winner_title = get_sub_field('winner_title');
				$winner_image = get_sub_field('winner_image');
				if($winner_image):
					$img_src = wp_get_attachment_image_src($winner_image['id'],'winner_thumb');            			
					?>
					<div>
						<div class="slick-slide-box">
							<img src="<?php echo $img_src[0]; ?>" alt="<?php echo $winner_title; ?>">
						</div>
					</div>
					<?php 
				endif;
			endwhile; 
			?>
		</div>
	</section>
<?php endif; ?>
