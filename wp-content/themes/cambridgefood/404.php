<?php
/*
 * The template for displaying 404 pages (not found)
 */

get_header();
$banner_image_404 = get_field('banner_image_404','option');
$page_content_404 = get_field('page_content_404','option');
if(!$banner_image_404):
	$banner_image_404 = get_template_directory_uri()."/assets/images/404-bg.jpg";
endif;
?>
	<section class="notfound-page">
		<div class="banner-wrap" style="background-image: url('<?php echo $banner_image_404; ?>');">
			<div class="container">
				<div class="banner-area-cont">
					<div class="banner-text"><?php 
					if($page_content_404):
						echo '<h1>'.$page_content_404.'</h1>';
					else:	?>
						<h1>
						LOOKS LIKE YOU FOUND AN EMPTY PAGE!<br/><br/>
						PLEASE GO BACK TO OUR HOME PAGE TO<br/>
						FIND WHAT YOU’RE LOOKING FOR.
						</h1><?php
					endif; ?>					
					<div class="lbl-yellow"><span>404</span></div>
					<h3>THIS PAGE IS NOT FOUND</h3>
					<div class="back-to-home"><a href="<?php echo home_url(); ?>" class="btn btn-pink">Back To Home</a></div>
					</div>
					
				</div>
			</div>
		</div>
	</section>
<?php
get_footer();
