<?php echo get_template_part( 'template-parts/modules/common', 'banner' ); ?>
<section class="contentarea">
	<div class="container">
		<div class="py-4">
			<?php
			$send_instant_money_section_title = get_field('section_1_title');		 
			if(have_rows('section_1_steps')):
				?>
				<div class="title2 mb-3">
					<h2 class="pink-text"><?php echo $send_instant_money_section_title; ?></h2>
				</div>
				<?php
				while(have_rows('section_1_steps')):
					the_row();
					$step_title = get_sub_field('step_title');
					$step_description = get_sub_field('step_description');
					?>
					<div class="title2"><h2 class="pink-text"><?php echo $step_title; ?></h2></div>
					<p class="mb-4"><?php echo  $step_description; ?></p>
				<?php endwhile; ?>
				<hr class="border-btm">
			<?php endif; ?>

			<?php
			$section_2_title = get_field('section_2_title'); 
			if(have_rows('section_2_steps')):
				?>
				<div class="title2 mb-3">
					<h2 class="blue-text"><?php echo $section_2_title; ?></h2>
				</div>
				<?php
				while(have_rows('section_2_steps')):
					the_row();
					$step_title = get_sub_field('step_title');
					$step_description = get_sub_field('step_description');
					?>
					<div class="title2"><h2 class="blue-text"><?php echo $step_title; ?></h2></div>
					<p class="mb-4"><?php echo  $step_description; ?></p>
				<?php endwhile;
			endif;
			$banks_section_title = get_field('banks_section_title');
			$banks_section_bottom_text = get_field('banks_section_bottom_text');
			if($banks_section_title){
				echo '<hr class="border-btm">';
			} ?>
			<div class="send-receive">
				<div class="title2 mb-4">
					<h2 class="blue-text"><?php echo $banks_section_title; ?></h2>
				</div>
				<?php if(have_rows('bank_images')): ?>
					<div class="brand-logos">
						<?php 
						while(have_rows('bank_images')):
							the_row();
							$image_title = get_sub_field('image_title');
							$image = get_sub_field('image');
							if($image):
								$img_src = wp_get_attachment_image_src($image['id'],'bank_logo');	
								?>
								<div class="brand-logo-col"><img src="<?php echo $img_src[0]; ?>" alt="<?php echo $image_title; ?>"></div>
								<?php 
							endif; 
						endwhile; 
						?>
					</div>
				<?php endif; ?>
				<p class="mt-3 text-center"><small><?php echo $banks_section_bottom_text; ?></small></p>
			</div>
		</div>
	</div>
</section>