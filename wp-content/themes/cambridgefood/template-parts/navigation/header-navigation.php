<?php
/**
*
*Header Navigation
*
**/
?>
<?php
$defaults = array(
	'theme_location'  => 'main-menu',
	'container'       => '', 
	'container_class' => '', 
	'items_wrap'      => '<ul class="menu-desk">%3$s</ul>',
);
echo wp_nav_menu($defaults);
?>
