<?php
/**
 * Cambridge functions and definitions
 *
 */
add_theme_support('post-thumbnails');
add_image_size('logo', 295, 79, true);
add_image_size('page_banner', '', 600, true);
add_image_size('our_latest_specials', 470, 470, true);
add_image_size('page_carsoul', 354, 342, true);
add_image_size('company_profile_data_image', '', 300, true);
add_image_size('money_centre_image', 675, 515, true);
add_image_size('recipe_tip_thumb_first_image', 729, 486, true);
add_image_size('recipe_tip_thumb_image', 600, 600, true);
add_image_size('tips_detail_inner_banner_image', 1030, 415, true);
add_image_size('tips_scroller_thumb_image', 220, 205, true);
add_image_size('tip_listing_thumb_image', 360, 390, true);
add_image_size('bank_logo', 260, 70, true);
add_image_size('powered_by', 520, 100, true);
add_image_size('tips_detail_banner_image', 1030, 415, true);
add_image_size('stokvel_bottom_image', 1900, 735, true);
add_image_size('competition_images', 545, 375, true);
add_image_size('winner', 1090, 1090, true);
add_image_size('winner_thumb', 220, 220, true);
add_image_size('community_gallery', '', 1090, true);
add_image_size('stokvels_gallery_vertical', 420, 278, true);
add_image_size('stokvels_gallery_horizontal', 420, 560, true);

add_action('after_setup_theme', 'register_my_menu');
remove_filter('the_content', 'wpautop');

function register_my_menu() {

	register_nav_menu('main-menu', 'Main Menu');
	register_nav_menu('footer-menu-1', 'Footer Menu 1');
	register_nav_menu('footer-menu-2', 'Footer Menu 2');
	register_nav_menu('footer-menu-3', 'Footer Menu 3');
}
if (function_exists('acf_add_options_page')) {

    acf_add_options_page(array(
        'page_title' => 'Theme General Settings',
        'menu_title' => 'Theme Settings',
        'menu_slug' => 'theme-general-settings',
        'capability' => 'edit_posts',
        'redirect' => false
    ));
}

add_action('wp_enqueue_scripts', 'theme_enqueue_styles');

function theme_enqueue_styles() {
	
	wp_enqueue_style('bootstrap', get_stylesheet_directory_uri() . '/assets/css/bootstrap.min.css');	
	wp_enqueue_style('owl-carousel-css', get_stylesheet_directory_uri() . '/assets/css/owl.carousel.min.css');
	wp_enqueue_style('stellarnav-css', get_stylesheet_directory_uri() . '/assets/css/stellarnav.min.css');
	wp_enqueue_style('multipurpose-tabcontent-css', get_stylesheet_directory_uri() . '/assets/css/multipurpose_tabcontent.css');
	wp_enqueue_style('slick-main', get_stylesheet_directory_uri() . '/assets/css/slick.css');
	wp_enqueue_style('slick-theme', get_stylesheet_directory_uri() . '/assets/css/slick-theme.css');
	wp_enqueue_style('preloader', get_stylesheet_directory_uri() . '/assets/css/preloader.css');
	wp_enqueue_style('mCustomScrollbar', get_stylesheet_directory_uri() . '/assets/css/jquery.mCustomScrollbar.css');
	wp_enqueue_style('custom', get_stylesheet_directory_uri() . '/assets/css/custom.css'); 
    wp_enqueue_style('bootstrap-select', 'https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.2/css/bootstrap-select.min.css');          
    wp_enqueue_style('main-style', get_stylesheet_directory_uri() . '/assets/css/style.css');    		
	wp_enqueue_style('responsive', get_stylesheet_directory_uri() . '/assets/css/responsive.css');
		
}

add_action('get_footer', 'enqueue_styles_footer');

function enqueue_styles_footer() {

	wp_enqueue_script('jquery-js', 'https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js', false);
	wp_enqueue_script('popper-min', 'https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js', false); 
	wp_enqueue_script('boostrap-js', get_stylesheet_directory_uri() . '/assets/js/bootstrap.min.js', false); 
	wp_enqueue_script('stellarnav-js', get_stylesheet_directory_uri() . '/assets/js/stellarnav.js', false); 
	wp_enqueue_script('select-picker', 'https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.2/js/bootstrap-select.min.js', false); 
	wp_enqueue_script('owl-carousel-ja', get_stylesheet_directory_uri() . '/assets/js/owl.carousel.min.js', false);
	wp_enqueue_script('multipurpose-tabcontent-ja', get_stylesheet_directory_uri() . '/assets/js/jquery.multipurpose_tabcontent.js', false);	
	wp_enqueue_script('script-ja', get_stylesheet_directory_uri() . '/assets/js/script.js', false); 
	wp_enqueue_script('mCustomScrollbar-js', get_stylesheet_directory_uri() . '/assets/js/jquery.mCustomScrollbar.concat.min.js', false); 
	wp_enqueue_script('main-js', get_stylesheet_directory_uri() . '/assets/js/common.js', false);
	wp_enqueue_script('slick-js', get_stylesheet_directory_uri() . '/assets/js/slick.min.js', false);

	if (is_page('recipes-tips')):
		wp_enqueue_script('recipes-tips-js', get_stylesheet_directory_uri() . '/assets/js/recipes-tips.js', false);
		wp_localize_script('recipes-tips-js', 'ajaxurl', admin_url('admin-ajax.php'));
	endif;

	if (is_page('recipes')):
		wp_enqueue_script('recipes-js', get_stylesheet_directory_uri() . '/assets/js/recipes.js', false);
		wp_localize_script('recipes-js', 'ajaxurl', admin_url('admin-ajax.php'));
	endif;

}

function new_nav_menu_items($items, $args) {
	$mobile_social_menu_item = '';
    if($args->theme_location == 'main-menu'){
	   	$mobile_social_menu_item .= '<li class="social-media">';
	   	$mobile_social_menu_item .= '<ul>';
	   	if( have_rows('add_social_media_details','option') ):						
			while ( have_rows('add_social_media_details','option') ) : the_row();
                $enable_social_icon = get_sub_field('enable_social_icon');
                if($enable_social_icon[0] == "Enable Social Icon"):
				    $mobile_social_menu_item .= '<li><a href="'.get_sub_field('social_media_url').'"><img src="'.get_sub_field('social_media_icon').'"></a></li>';
                endif;
			endwhile;
			wp_reset_query();
		endif;
		$mobile_social_menu_item .= '</ul>';
		$page_cnt = count(get_field('add_footer_page_links','option'));				
		$i = 1;		
		if( have_rows('add_footer_page_links','option') ):
			$mobile_social_menu_item .= '<p>';
			while ( have_rows('add_footer_page_links','option') ) : the_row();
				$mobile_social_menu_item .= '<a href="'.get_sub_field('footer_page_link').'">'.get_sub_field('footer_page_title').'</a>';
				if($i != $page_cnt): $mobile_social_menu_item .= '<span>|</span>'; endif;
			$i++;
			endwhile;
			$mobile_social_menu_item .= '</p>';
			wp_reset_query();
		endif;   
	   	$mobile_social_menu_item .= '</li>';
       	$items = $items . $mobile_social_menu_item;
    }
    return $items;
}
add_filter('wp_nav_menu_items', 'new_nav_menu_items', 10, 2);

add_filter( 'style_loader_src', 'sdt_remove_ver_css_js', 9999 );
add_filter( 'script_loader_src', 'sdt_remove_ver_css_js', 9999 );

function sdt_remove_ver_css_js( $src ) {
	if ( strpos( $src, 'ver=' ) )
		$src = remove_query_arg( 'ver', $src );
	return $src;
}

function add_file_types_to_uploads($file_types){
	$new_filetypes = array();
	$new_filetypes['svg'] = 'image/svg+xml';
	$file_types = array_merge($file_types, $new_filetypes );
	return $file_types;
}
add_action('upload_mimes', 'add_file_types_to_uploads');

function remove_editor_menu() {
    remove_action('admin_menu', '_add_themes_utility_last', 101);
}
add_action('_admin_menu', 'remove_editor_menu', 1);

add_action( 'wp_footer', 'mycustom_wp_footer' );
 
function mycustom_wp_footer() {
?>
<script type="text/javascript">
document.addEventListener( 'wpcf7mailsent', function( event ) {
    var apiResponse = event.detail.apiResponse.message;
    $("#ContactModal .modal-body").html('<p>'+apiResponse+'</p>')
    $('#ContactModal').modal('show');
    // setTimeout(function(){ location.reload(); }, 3000);
}, false );
</script>
<?php
}

add_filter( 'wpsl_templates', 'custom_templates' );

function custom_templates( $templates ) {

    /**
     * The 'id' is for internal use and must be unique ( since 2.0 ).
     * The 'name' is used in the template dropdown on the settings page.
     * The 'path' points to the location of the custom template,
     * in this case the folder of your active theme.
     */
    $templates[] = array (
        'id'   => 'custom',
        'name' => 'Custom template',
        'path' => get_stylesheet_directory() . '/' . 'wpsl-templates/custom.php',
    );

    return $templates;
}

add_filter( 'wpsl_listing_template', 'custom_listing_template' );

function custom_listing_template() {

    global $wpsl, $wpsl_settings;
    
    $listing_template = '<li class="col-lg-6" data-store-id="<%= id %>">' . "\r\n";
    $listing_template .= "\t\t" . '<div class="wpsl-store-location">' . "\r\n";
    $listing_template .= "\t\t\t" . '<p><%= thumb %>' . "\r\n";
    $listing_template .= "\t\t\t\t" . wpsl_store_header_template( 'listing' ) . "\r\n"; // Check which header format we use
    $listing_template .= "\t\t\t\t" . '<span class="wpsl-street"><%= address %></span>' . "\r\n";
    $listing_template .= "\t\t\t\t" . '<% if ( address2 ) { %>' . "\r\n";
    $listing_template .= "\t\t\t\t" . '<span class="wpsl-street"><%= address2 %></span>' . "\r\n";
    $listing_template .= "\t\t\t\t" . '<% } %>' . "\r\n";
    $listing_template .= "\t\t\t\t" . '<span>' . wpsl_address_format_placeholders() . '</span>' . "\r\n"; // Use the correct address format

    if ( !$wpsl_settings['hide_country'] ) {
        $listing_template .= "\t\t\t\t" . '<span class="wpsl-country"><%= country %></span>' . "\r\n";
    }
    if ( !$wpsl_settings['hide_distance'] ) {
        $listing_template .= "\t\t\t" . ' - <%= distance %> ' . esc_html( $wpsl_settings['distance_unit'] ) . '' . "\r\n";
    }
    $listing_template .= "\t\t\t" . '</p>' . "\r\n";
    
   

    // Show the phone, fax or email data if they exist.
    if ( $wpsl_settings['show_contact_details'] ) {
        $listing_template .= "\t\t\t" . '<p class="wpsl-contact-details">' . "\r\n";
        $listing_template .= "\t\t\t" . '<% if ( phone ) { %>' . "\r\n";
        $listing_template .= "\t\t\t" . '<span><strong>' . esc_html( $wpsl->i18n->get_translation( 'phone_label', __( 'Phone', 'wpsl' ) ) ) . '</strong>: <%= formatPhoneNumber( phone ) %></span>' . "\r\n";
        $listing_template .= "\t\t\t" . '<% } %>' . "\r\n";
        $listing_template .= "\t\t\t" . '<% if ( fax ) { %>' . "\r\n";
        $listing_template .= "\t\t\t" . '<span><strong>' . esc_html( $wpsl->i18n->get_translation( 'fax_label', __( 'Fax', 'wpsl' ) ) ) . '</strong>: <%= fax %></span>' . "\r\n";
        $listing_template .= "\t\t\t" . '<% } %>' . "\r\n";
        $listing_template .= "\t\t\t" . '<% if ( email ) { %>' . "\r\n";
        $listing_template .= "\t\t\t" . '<span><strong>' . esc_html( $wpsl->i18n->get_translation( 'email_label', __( 'Email', 'wpsl' ) ) ) . '</strong>: <%= email %></span>' . "\r\n";
        $listing_template .= "\t\t\t" . '<% } %>' . "\r\n";
        $listing_template .= "\t\t\t" . '</p>' . "\r\n";
    }

    $listing_template .= "\t\t\t" . wpsl_more_info_template() . "\r\n"; // Check if we need to show the 'More Info' link and info
    
    $listing_template .= "\t\t" . '</div>' . "\r\n";
    $listing_template .= "\t\t" . '<div class="wpsl-direction-wrap">' . "\r\n";
    $listing_template .= "\t\t\t" . '<%= createDirectionUrl() %>' . "\r\n"; 
    $listing_template .= "\t\t" . '</div>' . "\r\n";
    $listing_template .= "\t" . '</li>';

    return $listing_template;
}

add_filter( 'wpsl_admin_marker_dir', 'custom_admin_marker_dir' );

function custom_admin_marker_dir() {

    $admin_marker_dir = get_stylesheet_directory() . '/wpsl-markers/';
    
    return $admin_marker_dir;
}
define( 'WPSL_MARKER_URI', dirname( get_bloginfo( 'stylesheet_url') ) . '/wpsl-markers/' );

add_filter( 'wpsl_dropdown_category_args', 'custom_dropdown_category_args' );

function custom_dropdown_category_args( $args ) {

    $args['class'] = 'form-control wpsl-dropdown';
    
    return $args;
}

add_filter( 'wpsl_marker_props', 'custom_marker_props' );

function custom_marker_props( $marker_props ) {
            
    $marker_props['scaledSize'] = '35,35'; // Set this to 50% of the original siz    
    return $marker_props;
}

add_action( 'init', 'my_custom_status_creation' );

function my_custom_status_creation(){
    register_post_status( 'approved', array(
        'label'                     => _x( 'Archived', 'post' ),
        'label_count'               => _n_noop( 'Archived <span class="count">(%s)</span>', 'Archived <span class="count">(%s)</span>'),
        'public'                    => true,
        'exclude_from_search'       => false,
        'show_in_admin_all_list'    => true,
        'show_in_admin_status_list' => true
    ));
}

add_action('admin_footer-edit.php','my_custom_status_add_in_quick_edit');

function my_custom_status_add_in_quick_edit() {
    echo "<script>
    jQuery(document).ready( function() {
        jQuery( 'select[name=\"_status\"]' ).append( '<option value=\"approved\">Archived</option>' );      
    }); 
    </script>";
}

add_action('admin_footer-post.php', 'my_custom_status_add_in_post_page');
add_action('admin_footer-post-new.php', 'my_custom_status_add_in_post_page');

function my_custom_status_add_in_post_page() {
    echo "<script>
    jQuery(document).ready( function() {        
        jQuery( 'select[name=\"post_status\"]' ).append( '<option value=\"approved\">Archived</option>' );
    });
    </script>";
}


function maven_store_dynamic_select_field_values ( $scanned_tag, $replace ) {  
  
    if ( $scanned_tag['name'] != 'storelocator' )  
        return $scanned_tag;

    $rows = get_posts(
        array ( 
         'post_type' => 'wpsl_stores',  
         'numberposts' => -1,  
         'orderby' => 'title',  
         'order' => 'ASC' 
        )
    );  
  
    if ( ! $rows )  
        return $scanned_tag;

    foreach ( $rows as $row ) {  
        $scanned_tag['raw_values'][] = $row->post_title . '|' . $row->post_title;
    }

    $pipes = new WPCF7_Pipes($scanned_tag['raw_values']);

    $scanned_tag['values'] = $pipes->collect_befores();
    $scanned_tag['pipes'] = $pipes;
  
    return $scanned_tag;  
}  

add_filter( 'wpcf7_form_tag', 'maven_store_dynamic_select_field_values', 10, 2);  