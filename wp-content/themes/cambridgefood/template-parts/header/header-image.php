<?php
/**
* Header Logo
*
**/

$company_logo = get_field('company_logo','option');
if($company_logo){
    $logo_image = wp_get_attachment_image_src($company_logo['id'], 'logo');	
}
?>
<div class="logo">
    <a href="<?php echo get_site_url(); ?>" title="<?php bloginfo( 'name' ); ?>">
    <img src="<?php echo ($logo_image) ? $logo_image[0] : get_stylesheet_directory_uri().'/assets/images/logo.png'; ?>" alt="<?php bloginfo( 'name' ); ?>">
    </a>
</div>