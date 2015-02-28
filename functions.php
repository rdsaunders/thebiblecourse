<?php
add_action( 'after_setup_theme', 'bc_theme_setup' );

function bc_theme_setup() {

    // Theme Support

        // Enable support for Post Thumbnails on posts.
        add_theme_support( 'post-thumbnails', array( 'post' ) );

        // Add default posts and comments RSS feed links to head.
        add_theme_support( 'automatic-feed-links' );

        // Switch default core markup for search form, comment form, and comments to output valid HTML5.
        add_theme_support( 'html5', array( 'comment-list', 'comment-form', 'search-form', 'gallery', 'caption' ) );


    // Actions

        // Load theme styles
        add_action( 'wp_enqueue_scripts', 'bc_load_styles' );

        // Load theme JavaScript files
        add_action( 'wp_enqueue_scripts', 'bc_load_scripts' );



}
//////////////////////////////////////////////////////////////
// Theme Header
/////////////////////////////////////////////////////////////
function bc_load_scripts() {

    // Register scripts for use
    wp_register_script( 'Modernizr', get_template_directory_uri() . '/js/modernizr-2.6.2-respond-1.1.0.min.js', array('jquery'), '2.1.1', true );
    wp_register_script( 'SmoothScroll', get_template_directory_uri() . '/js/jquery.smooth-scroll.js', array('jquery'), null, true );
    wp_register_script( 'FancyBox', get_template_directory_uri() . '/js/jquery.fancybox.js', array('jquery'), null, true );
    wp_register_script( 'FitVid', get_template_directory_uri() . '/js/jquery.fitvids.js', array('jquery'), null, true );
    wp_register_script( 'Main', get_template_directory_uri() . '/js/main.js', array('jquery'), null, true );

    // Enqueue required Scripts
    wp_enqueue_script( 'Modernizr' );
    wp_enqueue_script( 'SmoothScroll' );
    wp_enqueue_script( 'FancyBox' );
    wp_enqueue_script( 'FitVid' );
    wp_enqueue_script( 'Main' );


}

function bc_load_styles() {

  wp_register_style('Primary', get_template_directory_uri().'/style.css', array(), '1', 'all');
	wp_enqueue_style('Primary');
	wp_register_style('fancybox', get_template_directory_uri().'/css/fancybox.css', array(), '1', 'all');
	wp_enqueue_style('fancybox');

}


//////////////////////////////////////////////////////////////
// Button Shortcode
/////////////////////////////////////////////////////////////

function bc_button($a) {
	extract(shortcode_atts(array(
		'label' 	=> 'Button Text',
		'id' 	=> '1',
		'url'	=> '',
		'target' => '_parent',
		'color'	=> '',
		'ptag'	=> false
	), $a));

	$link = $url ? $url : get_permalink($id);

	if($ptag) :
		return  wpautop('<a href="'.$link.'" target="'.$target.'" class="btn '.$color.'">'.$label.'</a>');
	else :
		return '<a href="'.$link.'" target="'.$target.'" class="btn '.$color.'">'.$label.'</a>';
	endif;
}

add_shortcode('button', 'bc_button');


//////////////////////////////////////////////////////////////
// Column Shortcodes
/////////////////////////////////////////////////////////////

function bc_one_third( $atts, $content = null ) {
   return '<div class="one_third">' . do_shortcode($content) . '</div>';
}
add_shortcode('one_third', 'bc_one_third');

function bc_one_third_last( $atts, $content = null ) {
   return '<div class="one_third last">' . do_shortcode($content) . '</div>';
}
add_shortcode('one_third_last', 'bc_one_third_last');






function bc_one_quarter( $atts, $content = null ) {
   return '<div class="one_quarter">' . do_shortcode($content) . '</div>';
}
add_shortcode('one_quarter', 'bc_one_quarter');

function bc_one_quarter_last( $atts, $content = null ) {
   return '<div class="one_quarter last">' . do_shortcode($content) . '</div>';
}
add_shortcode('one_quarter_last', 'bc_one_quarter_last');

function bc_two_thirds( $atts, $content = null ) {
   return '<div class="two_thirds">' . do_shortcode($content) . '</div>';
}
add_shortcode('two_thirds', 'bc_two_thirds');

function bc_two_thirds_last( $atts, $content = null ) {
   return '<div class="two_thirds last">' . do_shortcode($content) . '</div>';
}
add_shortcode('two_thirds_last', 'bc_two_thirds_last');

function bc_one_half( $atts, $content = null ) {
   return '<div class="one_half">' . do_shortcode($content) . '</div>';
}
add_shortcode('one_half', 'bc_one_half');

function bc_one_half_last( $atts, $content = null ) {
   return '<div class="one_half last">' . do_shortcode($content) . '</div>';
}
add_shortcode('one_half_last', 'bc_one_half_last');

function bc_callout( $atts, $content = null ) {
   return '<div class="callout">' . do_shortcode($content) . '</div>';
}
add_shortcode('callout', 'bc_callout');


//////////////////////////////////////////////////////////////
// Make Column Shortcodes Validate
/////////////////////////////////////////////////////////////

function webtreats_formatter($content) {
	$new_content = '';

	/* Matches the contents and the open and closing tags */
	$pattern_full = '{(\[raw\].*?\[/raw\])}is';

	/* Matches just the contents */
	$pattern_contents = '{\[raw\](.*?)\[/raw\]}is';

	/* Divide content into pieces */
	$pieces = preg_split($pattern_full, $content, -1, PREG_SPLIT_DELIM_CAPTURE);

	/* Loop over pieces */
	foreach ($pieces as $piece) {
		/* Look for presence of the shortcode */
		if (preg_match($pattern_contents, $piece, $matches)) {

			/* Append to content (no formatting) */
			$new_content .= $matches[1];
		} else {

			/* Format and append to content */
			$new_content .= wptexturize(wpautop($piece));
		}
	}

	return $new_content;
}

// Remove the 2 main auto-formatters
remove_filter('the_content', 'wpautop');
remove_filter('the_content', 'wptexturize');

// Before displaying for viewing, apply this function
add_filter('the_content', 'webtreats_formatter', 99);
add_filter('widget_text', 'webtreats_formatter', 99);



//////////////////////////////////////////////////////////////
// Remove Admin Menus
/////////////////////////////////////////////////////////////

function remove_menus () {
global $menu;
	$restricted = array(('Posts'), ('Comments'));
	end ($menu);
	while (prev($menu)){
		$value = explode(' ',$menu[key($menu)][0]);
		if(in_array($value[0] != NULL?$value[0]:"" , $restricted)){unset($menu[key($menu)]);}
	}
}
add_action('admin_menu', 'remove_menus');


?>