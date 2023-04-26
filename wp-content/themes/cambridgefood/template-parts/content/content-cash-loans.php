<?php echo get_template_part( 'template-parts/modules/common', 'banner' ); ?>
<section class="contentarea">
	<div class="container">
		<div class="pt-4">
			<?php
			$introduction_section_title = get_field('introduction_section_title');
			$introduction_section_sub_title = get_field('introduction_section_sub_title');
			?>
			<div class="text-center mb-4">
				<div class="title2">
					<h2 class="pink-text"><?php echo $introduction_section_title; ?></h2>
				</div>
				<p><?php echo $introduction_section_sub_title; ?></p>
			</div>
			<?php if(have_rows('benefits')): ?>
				<div class="title2 pt-3 mb-3">
					<h2 class="pink-text"><?php the_field('benefits_section_title'); ?></h2>
				</div>
				<div class="row">
					<?php 
					$cnt = 0;
					$total = count(get_field('benefits'));
					$first = round($total/2);
					while(have_rows('benefits')): 
						the_row();

						if($cnt == 0):
							?>
							<div class="col-lg-6">
								<div class="list1">
									<ul>
										<?php 
									endif; 
									$cnt++;
									?>		
									<li><?php echo get_sub_field('benefit'); ?></li>	
									<?php if($cnt == $first): ?>
									</ul>
								</div>
							</div>
							<div class="col-lg-6">
								<div class="list1">
									<ul>
										<?php 
									endif;
									if($cnt == $total):
										?>
									</ul>
								</div>
							</div>
							<?php
						endif;
					endwhile; 
					?>
				</div>
				<hr class="border-btm">
			<?php endif; ?>

			<div class="title2 mb-3">
				<h2 class="blue-text"><?php the_field('how_to_apply_section_title'); ?></h2>
			</div>
			<div class="title2">
				<h3 class="blue-text"><?php the_field('apply__from_website_title'); ?></h3>
			</div>
			<p class="mb-4"><a class="blk-link" href="<?php the_field('apply__from_website_link'); ?>"><?php the_field('apply_from_website_link_title'); ?></a></p>
			<div class="title2">
				<h2 class="blue-text"><?php the_field('apply__from_mobile_title'); ?></h2>
			</div>
			<p><?php the_field('apply_from_mobile_description'); ?></p>
			<div class="title2">
				<h2 class="blue-text"><?php the_field('apply_from_call_center_title'); ?></h2>
			</div>
			<p><?php the_field('apply_from_call_center_description'); ?></p>

			<hr class="border-btm">
			<?php
			$what_do_you_need_section_title = get_field('what_do_you_need_section_title');
			if(have_rows('requirements')) :
				?>
				<div class="title2 mb-3">
					<h2 class="pink-text"><?php echo $what_do_you_need_section_title; ?></h2>
				</div>
				<div class="list1">
					<ul>
						<?php
						while(have_rows('requirements')) :
							the_row();
							?>
							<li><?php the_sub_field('requirement'); ?></li>
						<?php endwhile; ?>
					</ul>
				</div>
				<hr class="border-btm">
				<?php 
			endif;

			$customer_protection_insurance_section_title  = get_field('customer_protection_insurance_section_title');
			$customer_protection_insurance_section_subtitle  = get_field('customer_protection_insurance_section_subtitle');
			if(have_rows('insurance_includes')):
				?>
				<div class="title2 mb-3">
					<h2 class="blue-text"><?php echo $customer_protection_insurance_section_title; ?></h2>
				</div>
				<div class="list1 mb-4">
					<p><?php echo $customer_protection_insurance_section_subtitle; ?></p>
					<ul>
						<?php 
						while(have_rows('insurance_includes')): 
							the_row();
							?>
							<li><?php  the_sub_field('policy'); ?></li>
						<?php endwhile; ?> 
					</ul>
				</div>
			<?php endif; ?>
			<?php

			$image = get_field('powered_by_image');
			if($image):
				$img_src = wp_get_attachment_image_src($image['id'],'powered_by');	
				?>
				<div class="send-receive">
					<div class="text-center">
						<img src="<?php echo $img_src[0]; ?>" alt="Powered By">
					</div>
					<p class="mt-3 text-center"><small><?php the_field('powered_by_text'); ?></small></p>
				</div>

			<?php endif;?>
			<hr class="border-btm">
		</div>
	</div>
</section>