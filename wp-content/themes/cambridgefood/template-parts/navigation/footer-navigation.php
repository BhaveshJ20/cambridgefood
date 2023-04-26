<?php
/**
*
* Footer Navigation
*
**/
?>
<?php
$defaults1 = array(
	'theme_location'  => 'footer-menu',
	'container'       => 'div', 
	'container_class' => 'ma-footer-link', 
	'items_wrap'      => '<ul class="list-inline">%3$s</ul>',
	'depth'           => 1,
	'walker'            => new Custom_Foundation_Nav_Menu(),
);
echo wp_nav_menu($defaults1); 
?>