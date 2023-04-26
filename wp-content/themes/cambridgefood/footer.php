<?php
/*
 * The footer for our theme
 */
?>
<?php
$contact_us_title = get_field('contact_us_title','option');
$add_contacts = get_field('add_contacts','option');
if($add_contacts && !is_404()): ?>
	<section class="contactus-slide-wrap">
		<div class="container-fluid">
			<div class="title blue-text text-center">
				<h2 class="my-0"><?php echo ($contact_us_title) ? $contact_us_title : 'Contact Us'; ?></h2>
			</div>
			<div class="owl-carousel contact-slider owl-theme"><?php
				foreach($add_contacts as $contacts_value): ?>
					<div class="item">
						<div class="contactus-slide-content-blk">
							<div class="contactus-slide-content">
								<div class="contactus-slide-content-text">
									<h6><?php echo $contacts_value['contact_type_name']; ?></h6>
									<p>TEL: <?php echo $contacts_value['contact_telephone']; ?></p>
									<p>WHATSAPP: <?php echo $contacts_value['contact_whatsapp_no']; ?></p>
									<p><a href="mailto:<?php  echo $contacts_value['contact_email'];  ?>"><?php echo $contacts_value['contact_email']; ?></a></p>
								</div>
							</div>
						</div>
					</div> <?php
				endforeach; ?>				
			</div>
		</div>
	</section><?php
endif;

$subscribe_section_title = get_field('subscribe_section_title','option');
$add_form_shortcode = get_field('add_form_shortcode','option');
$subscribe_section_link =  get_field('subscribe_section_link', 'option');
if(!is_404()): ?>
	<section class="container d-none d-lg-block d-xl-block">
	<div class="subscribe-now">
		<div class="mb-4">
			<div class="btn text-pink" style="display: block;margin: auto;width: max-content;">
				<?php echo $subscribe_section_title; ?>				
			</div>
		</div><?php
		if($add_form_shortcode){ ?>
			<div class="subscribe-form">
				<div class="input-group">
					<div class="input-group-prepend">
						<div class="input-group-text"><img src="<?php echo get_stylesheet_directory_uri() . '/assets/images/email.svg' ?>" alt=""></div>
					</div>
					<?php echo do_shortcode('[contact-form-7 id="175" title="Subscribe"]'); ?>
				</div>
			</div><?php
		} ?>		
	</div>
</section><?php
endif; ?>

<footer class="footer">
	<section class="footer-top">
		<div class="container">
			<div class="row"><?php
				$footer_image_section = get_field('footer_image_section','option');
				if($footer_image_section): ?>
					<div class="col-lg-3 col-md-6 order-1">
						<div class="masscash-logo"><img src="<?php echo $footer_image_section; ?>" alt=""></div>
					</div><?php
				endif; 
				$footer_menu_cnt = 2;				
				if( have_rows('footer_menu_section','option') ):						
					while ( have_rows('footer_menu_section','option') ) : the_row();
						$footer_menu_ext_class = 'd-none d-md-block d-lg-block';
						$footer_menu_title = get_sub_field('footer_menu_title','option');
						$select_footer_menu = get_sub_field('select_footer_menu');								
						if($footer_menu_cnt == 2): $footer_menu_ext_class = ''; endif; ?>
						<div class="col-lg-3 col-md-6 order-<?php echo $footer_menu_cnt.' '.$footer_menu_ext_class; ?>">
							<div class="heading-pink">
								<h3 class="mb-0"><?php echo ($footer_menu_title) ? $footer_menu_title : 'QUICK LINKS'; ?></h3>
							</div>
							<div class="footer-links">
								<?php echo $select_footer_menu; ?>
							</div>
						</div><?php
						$footer_menu_cnt++;
					endwhile;
					wp_reset_query();
				endif; ?>				
			</div>
			<div class="social-media">
				<ul><?php 				
					if( have_rows('add_social_media_details','option') ):						
						while ( have_rows('add_social_media_details','option') ) : the_row(); 
							$enable_social_icon = get_sub_field('enable_social_icon');
							if($enable_social_icon[0] == "Enable Social Icon"): ?>
								<li><a href="<?php the_sub_field('social_media_url'); ?>" target="_blank"><img src="<?php  the_sub_field('social_media_icon'); ?>" alt=""></a></li><?php
							endif;
						endwhile;
						wp_reset_query();
					endif; ?>
				</ul>

				<p><?php
				$page_cnt = count(get_field('add_footer_page_links','option'));				
				$i = 1;
				if( have_rows('add_footer_page_links','option') ):						
					while ( have_rows('add_footer_page_links','option') ) : the_row(); ?>
						<a href="<?php the_sub_field('footer_page_link'); ?>" target="<?php the_sub_field('footer_page_link_target'); ?>"><?php the_sub_field('footer_page_title'); ?></a><span><?php
						if($i != $page_cnt): echo '|'; endif;
					$i++;
					endwhile;
					wp_reset_query();
				endif; ?>				
				</p>
			</div>
		</div>
	</section>
	<section class="copyright">
		<div class="container"><?php
			$footer_copyrights = get_field('footer_copyrights','option');
			if($footer_copyrights):
				echo '<p>'.$footer_copyrights.'</p>';
			endif; ?>		
		</div>
	</section>
</footer>
 <div class="modal fade" id="ContactModal" tabindex="-1" role="dialog" aria-labelledby="ContactModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header bg-pink">
                <h3 class="modal-title text-white text-center" id="ContactModalLabel">Thank you</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">x</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <p>Your message has been sent. A representative will be in touch.</p>
            </div>
            <div class="modal-footer text-center">
                <button type="button" class="btn btn-pink" data-dismiss="modal">Okay</button>
            </div>
            </div>
        </div>
    </div>


 <!-- IF COOKIE IS NOT SET < FOR POPUP <THEN construct popup -->
<?php 
if(!isset($_COOKIE['maven_website_popup'])) {
   // setcookie('maven_website_popup', '1');
   		$popup_status=get_field('popup_status','option');
   	if($popup_status=='enable'):
	    $popup_right_image=get_field('popup_right_image','option');
	    $popup_title=get_field('popup_title','option');
	    $popup_short_description=get_field('popup_short_description','option');
	    $popup_button_label=get_field('popup_button_label','option');
	    $popup_button_link=get_field('popup_button_link','option');
	 	$image_position=get_field('image_position','option');
	 	$image_position=!empty($image_position)?get_field('image_position','option'):"right";
	 if( ($popup_title && $popup_short_description) || $popup_right_image  || ($popup_button_label && $popup_button_link) ) :
    ?>
<div class="modal fade" id="websitePopupModal" tabindex="-1" role="dialog" aria-labelledby="WebsitePopupLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		 <button type="button" class="close popup_close" data-dismiss="modal">&times;</button>
		<div class="modal-content">
			<div class="row">
					<?php if($popup_right_image && $image_position=='left'): ?>
				<div class="col-md-5" style="background:url(<?php echo $popup_right_image; ?>);background-size: cover;">					
				</div>
				<?php endif; ?>
				<div class="col-md-7">
					<div class="popup_desc">
					<?php if($popup_title):?> <h3 class="modal-title text-center"><?php echo $popup_title; ?> </h3> <?php endif; ?>
					<?php if($popup_short_description):?> <p class="text-center"><?php echo $popup_short_description; ?> </p> <?php endif; ?>
					<?php if($popup_button_label && $popup_button_link):?>
						<a href='<?php echo $popup_button_link; ?>' target="_blank" class="popup_link"><?php echo $popup_button_label; ?></a>
					<?php endif; ?>					
					</div>
				</div>
				<?php if($popup_right_image && $image_position=='right' ): ?>
				<div class="col-md-5" style="background:url(<?php echo $popup_right_image; ?>);background-size: cover;">					
				</div>
				<?php endif; ?>
			</div>

	</div>
</div>
</div>
    <?php	
	endif;
endif;
} ?>
 <!-- IF COOKIE IS NOT SET < FOR POPUP <THEN construct popup -->

<?php wp_footer(); ?>
</body>
</html>
