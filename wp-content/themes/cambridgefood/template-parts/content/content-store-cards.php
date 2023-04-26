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
								</div><?php 
								if(get_field('benefit_apply_button_url')): ?>
									<a href="<?php echo get_field('benefit_apply_button_url'); ?>" class="btn btn-pink" target="_blank">
										<?php echo get_field('benefit_apply_button_title')?get_field('benefit_apply_button_title'): 'Apply Now'; ?>
									</a>
								<?php endif; ?>
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

			<?php if(have_rows('for_your_protection')): ?>
				<div class="title2 pt-3 mb-3">
					<h2 class="blue-text"><?php the_field('for_your_protection_title'); ?></h2>
				</div>
				<div class="row">
					<?php 
					$cnt = 0;
					$total = count(get_field('for_your_protection'));
					$first = round($total/2);
					while(have_rows('for_your_protection')): 
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
									<li><?php echo get_sub_field('requirement'); ?></li>	
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

			<?php if(have_rows('how_to_apply')): ?>
				<div class="title2 pt-3 mb-3">
					<h2 class="pink-text"><?php the_field('how_to_apply_section_title'); ?></h2>
				</div>
				<div class="row">
					<?php 
					$cnt = 0;
					$total = count(get_field('how_to_apply'));
					$first = round($total/2);
					while(have_rows('how_to_apply')): 
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
									<li><?php echo get_sub_field('requirement'); ?></li>	
									<?php if($cnt == $first): ?>
									</ul>
								</div><?php 
								if(get_field('apply_button_link')): ?>
									<a href="<?php echo get_field('apply_button_link'); ?>" class="btn btn-pink" target="_blank">
										<?php echo get_field('apply_button_title')?get_field('apply_button_title'): 'Apply Now'; ?>
									</a>
								<?php endif; ?>

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

			<?php if(have_rows('application_criteria')): ?>
				<div class="title2 pt-3 mb-3">
					<h2 class="blue-text"><?php the_field('application_criteria_section_title'); ?></h2>
				</div>
				<div class="row">
					<?php 
					$cnt = 0;
					$total = count(get_field('application_criteria'));
					$first = round($total/2);
					while(have_rows('application_criteria')): 
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
									<li><?php echo get_sub_field('policy'); ?></li>	
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

			<?php if(have_rows('manage_your_account')): ?>
				<div class="title2 pt-3 mb-3">
					<h2 class="pink-text"><?php the_field('manage_your_account_title'); ?></h2>
				</div>
				<div class="row">
					<?php 
					$cnt = 0;
					$total = count(get_field('manage_your_account'));
					$first = round($total/2);
					while(have_rows('manage_your_account')): 
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
									<li><?php echo get_sub_field('requirements'); ?></li>	
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

			<?php if(get_field('contact_us')): ?>
				<div class="title2 pt-3 mb-3">
					<h2 class="blue-text">Contact Us</h2>
				</div>
				<div class="row">
				<div class="col-lg-6">
					<?php the_field('contact_us'); ?>
				</div>
				</div>			
			<?php endif; ?>
		</div>
	</div>
</section>