<?php 
global $wpsl_settings, $wpsl;

$output         = $this->get_custom_css(); 
$autoload_class = ( !$wpsl_settings['autoload'] ) ? 'class="wpsl-not-loaded"' : '';

$output .= '<div id="wpsl-search-wrap">';
$output .= '<section class="container">';
$output .= '<div class="storeinformation-wrap">';
$output .= '<form autocomplete="off">';
$output .= '<div class="row justify-content-center">';
$output .= '<div class="col-lg-5">';
$output .= '<div class="form-group">';
$output .= $this->create_category_filter();
$output .= '</div>';
$output .= '</div>';
$output .= '<div class="col-lg-5">';
$output .= '<div class="form-group">';
$output .= '<input id="wpsl-search-input" type="text" value="' . apply_filters( 'wpsl_search_input', '' ) . '" name="wpsl-search-input" placeholder="SEARCH YOUR AREA" aria-required="true" />';
$output .= '</div>';
$output .= '</div>';
$output .= '</div>';
$output .= '<div class="row">';
$output .= '<div class="col-lg-7 offset-lg-4">';
$output .= '<div class="right-to-center">';
$output .= '<input id="wpsl-search-btn" class="btn btn-pink small" type="submit" value="' . esc_attr( $wpsl->i18n->get_translation( 'search_btn_label', __( 'Search', 'wpsl' ) ) ) . '">';
$output .= '</div>';
$output .= '</div>';
$output .= '</form>';
$output .= '</div>';
$output .= '</section>';
$output .= '</div>';




$output .= '<div id="wpsl-wrap" class="wpsl-store-below">' . "\r\n";
$output .= "\t" . '<div class="wpsl-search wpsl-clearfix ' . $this->get_css_classes() . '">' . "\r\n";
// $output .= "\t\t" . '<div id="wpsl-search-wrap">' . "\r\n";
// $output .= "\t\t\t" . '<form autocomplete="off">' . "\r\n";
// $output .= "\t\t\t" . '<div class="wpsl-input">' . "\r\n";
// $output .= "\t\t\t\t" . '<div><label for="wpsl-search-input">' . esc_html( $wpsl->i18n->get_translation( 'search_label', __( 'Your location', 'wpsl' ) ) ) . '</label></div>' . "\r\n";
// $output .= "\t\t\t\t" . '<input id="wpsl-search-input" type="text" value="' . apply_filters( 'wpsl_search_input', '' ) . '" name="wpsl-search-input" placeholder="" aria-required="true" />' . "\r\n";
// $output .= "\t\t\t" . '</div>' . "\r\n";

// if ( $wpsl_settings['radius_dropdown'] || $wpsl_settings['results_dropdown']  ) {
//     $output .= "\t\t\t" . '<div class="wpsl-select-wrap">' . "\r\n";

//     if ( $wpsl_settings['radius_dropdown'] ) {
//         $output .= "\t\t\t\t" . '<div id="wpsl-radius">' . "\r\n";
//         $output .= "\t\t\t\t\t" . '<label for="wpsl-radius-dropdown">' . esc_html( $wpsl->i18n->get_translation( 'radius_label', __( 'Search radius', 'wpsl' ) ) ) . '</label>' . "\r\n";
//         $output .= "\t\t\t\t\t" . '<select id="wpsl-radius-dropdown" class="wpsl-dropdown" name="wpsl-radius">' . "\r\n";
//         $output .= "\t\t\t\t\t\t" . $this->get_dropdown_list( 'search_radius' ) . "\r\n";
//         $output .= "\t\t\t\t\t" . '</select>' . "\r\n";
//         $output .= "\t\t\t\t" . '</div>' . "\r\n";
//     }

//     if ( $wpsl_settings['results_dropdown'] ) {
//         $output .= "\t\t\t\t" . '<div id="wpsl-results">' . "\r\n";
//         $output .= "\t\t\t\t\t" . '<label for="wpsl-results-dropdown">' . esc_html( $wpsl->i18n->get_translation( 'results_label', __( 'Results', 'wpsl' ) ) ) . '</label>' . "\r\n";
//         $output .= "\t\t\t\t\t" . '<select id="wpsl-results-dropdown" class="wpsl-dropdown" name="wpsl-results">' . "\r\n";
//         $output .= "\t\t\t\t\t\t" . $this->get_dropdown_list( 'max_results' ) . "\r\n";
//         $output .= "\t\t\t\t\t" . '</select>' . "\r\n";
//         $output .= "\t\t\t\t" . '</div>' . "\r\n";
//     }
    
//     $output .= "\t\t\t" . '</div>' . "\r\n";
// }

// if ( $this->use_category_filter() ) {
//     $output .= $this->create_category_filter();
// }
 
// $output .= "\t\t\t\t" . '<div class="wpsl-search-btn-wrap"><input id="wpsl-search-btn" type="submit" value="' . esc_attr( $wpsl->i18n->get_translation( 'search_btn_label', __( 'Search', 'wpsl' ) ) ) . '"></div>' . "\r\n";

// $output .= "\t\t" . '</form>' . "\r\n";
// $output .= "\t\t" . '</div>' . "\r\n";
// $output .= "\t" . '</div>' . "\r\n";
    
if ( $wpsl_settings['reset_map'] ) { 
    $output .= "\t" . '<div class="wpsl-gmap-wrap">' . "\r\n";
    $output .= "\t\t" . '<div id="wpsl-gmap" class="wpsl-gmap-canvas"></div>' . "\r\n";
    $output .= "\t" . '</div>' . "\r\n";
} else {
    $output .= "\t" . '<div id="wpsl-gmap" class="wpsl-gmap-canvas"></div>' . "\r\n";
}

$output .= '<section class="container">';
$output .= '<div class="pt-5">';
$output .= "\t" . '<div id="wpsl-result-list">' . "\r\n";
$output .= "\t\t" . '<div style="height:auto !important;" id="wpsl-stores" '. $autoload_class .'>' . "\r\n";
$output .= "\t\t\t" . '<ul class="row"></ul>' . "\r\n";
$output .= "\t\t" . '</div>' . "\r\n";
$output .= "\t\t" . '<div id="wpsl-direction-details">' . "\r\n";
$output .= "\t\t\t" . '<ul></ul>' . "\r\n";
$output .= "\t\t" . '</div>' . "\r\n";
$output .= "\t" . '</div>' . "\r\n";
$output .= '</div>';
$output .= '</section>';

if ( $wpsl_settings['show_credits'] ) { 
    $output .= "\t" . '<div class="wpsl-provided-by">'. sprintf( __( "Search provided by %sWP Store Locator%s", "wpsl" ), "<a target='_blank' href='https://wpstorelocator.co'>", "</a>" ) .'</div>' . "\r\n";
}

$output .= '</div>' . "\r\n";

return $output;