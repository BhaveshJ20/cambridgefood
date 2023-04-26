<?php echo get_template_part( 'template-parts/modules/common', 'banner' ); ?>
<section class="">
	<div class="container">
		<div class="pt-5">
			<?php
			if(have_rows('content_sections')):
				$total = count(get_field('content_sections'));
				$cnt = 1;
				while(have_rows('content_sections')):
					the_row();
					?>
					<div class="title2 mb-3">
						<h2 class="pink-text"><?php echo get_sub_field('section_title'); ?></h2>
					</div>
					<p class="mb-4"><?php echo get_sub_field('section_description'); ?></p>
					<?php if($cnt < $total): ?>
						<hr class="border-btm">
						<?php
					endif;
					$cnt++;
				endwhile;
			endif; 
			?>
		</div>
	</div>
	<div class="stokvel-gallery">
		<div class="container-fluid">
			<div class="row no-gutters"><?php 
				$stokvel_gallery_count = count(get_field('add_image_gallery'));
				$galleryCnt = 1;				
				if( have_rows('add_image_gallery') ):			
					while ( have_rows('add_image_gallery') ) : the_row();						
						$add_stokvels_gallery_image = get_sub_field('add_stokvels_gallery_image');
						if($add_stokvels_gallery_image):
							if($galleryCnt == 1 || $galleryCnt == $stokvel_gallery_count):
								$imageType = 'stokvels_gallery_horizontal';
								$extClass = "h-100";
							else:
								$extClass = "half-img";
								$imageType = 'stokvels_gallery_vertical';
							endif;

							$stokvels_img_src = wp_get_attachment_image_src($add_stokvels_gallery_image['id'],$imageType);

							if($galleryCnt != 3 && $galleryCnt != 5):
								echo '<div class="col-lg-3 col-md-6">';
							endif; ?>	
								<div class="<?php echo $extClass; ?>">
									<img class="stokvel-thumb" src="<?php echo $stokvels_img_src[0]; ?>" alt="<?php echo $imageType; ?>">
								</div><?php
							if($galleryCnt != 2 && $galleryCnt != 4):
								echo '</div>';
							endif;
							$galleryCnt++;
						endif;
					endwhile;
				endif; ?>				
			</div>
		</div>
	</div>
	<?php
	$bottom_image_title = get_field('bottom_image_title');
	$bottom_image = get_field('bottom_image');
	if($bottom_image):
		$img_src = wp_get_attachment_image_src($bottom_image['id'],'stokvel_bottom_image');
		?>
		<section class="bottom-sub-banner mb-3">
			<div><img src="<?php echo $img_src[0]; ?>" alt="<?php echo $bottom_image_title; ?>"></div>
		</section>

		<?php 
	endif;
	?>
</section>