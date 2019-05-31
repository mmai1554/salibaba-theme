<?php

// Defines
define( 'FL_CHILD_THEME_DIR', get_stylesheet_directory() );
define( 'FL_CHILD_THEME_URL', get_stylesheet_directory_uri() );

// Classes
require_once 'classes/class-fl-child-theme.php';
require_once 'classes/MIHTML.class.php';

// Actions
add_action( 'fl_head', 'FLChildTheme::stylesheet' );
add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );
function theme_enqueue_styles() {
	wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
}

// ------------
function mi_script() {
	wp_register_script( 'mi', FL_CHILD_THEME_URL . '/js/mi.js', array( 'jquery' ), false, true );
	wp_enqueue_script( 'mi' );
}

add_action( 'wp_enqueue_scripts', 'mi_script' );
// enable Shortcodes in Widgets:
add_filter( 'widget_text', 'do_shortcode' );


function load_template_part( $template_name, $part_name = null ) {
	ob_start();
	get_template_part( $template_name, $part_name );
	$var = ob_get_contents();
	ob_end_clean();
	return $var;
}

add_shortcode( 'speisekarte', function ( $atts ) {
	$atts   = shortcode_atts( [ 'tpl' => '' ], $atts );
	$template = $atts['tpl'];
	if (empty($template)) {
		return '';
	}
	ob_start();
	include FL_CHILD_THEME_DIR.'/speisekarte/speisekarte_'.$template.'.php';
	$content = ob_get_clean();
	return $content;
} );

add_shortcode( 'mi_email', function ( $atts ) {
	return'<a href="mailto:#">E-Mail:&nbsp;info@</a>';
} );

add_shortcode( 'copyright', function ( $atts ) {
	return sprintf('<span>© %s Salibaba.de</span>',date('Y'));
} );

add_shortcode( 'mi_oeff', function ( $atts ) {
	$s[] = '<table class="mi-oeff">';
	$s[] = '<tr>';
	$s[] = '<td class="col0">Mo-Fr:</td>';
	$s[] = '<td>07:00 - 18:00 Uhr</td>';
	$s[] = '</tr>';
	$s[] = '</table>';
	return implode( '', $s );
} );