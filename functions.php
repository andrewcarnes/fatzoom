<?php
/*
Plugin Name: FatZoom
Plugin URI:  http://labs.andrewcarnes.com/opensource/fatzoom
Description: Adds support for Medium-like image zooming for images inserted with the WYSIWYG.
Version:     1.0
Author:      Andrew Carnes
Author URI:  http://acarn.es
License:     MIT
License URI: https://opensource.org/licenses/MIT
Domain Path: /languages
Text Domain: fatzoom
*/

function fatzoom_scripts() {
	wp_register_style( 'fatzoom-style', plugin_dir_url( __FILE__ ) . 'css/zoom.css');
	wp_enqueue_style( 'fatzoom-style' );

	wp_register_script( 'bootstrap', plugin_dir_url( __FILE__ ) . 'js/bootstrap.min.js', array(), null, true);
	wp_enqueue_script( 'bootstrap' );

	wp_register_script( 'zoom-js', plugin_dir_url( __FILE__ ) . 'js/zoom.js', array('jquery', 'bootstrap'), false, true);
	wp_enqueue_script( 'zoom-js' );
}
add_action( 'wp_enqueue_scripts', 'fatzoom_scripts' );

function append_data_attr($html, $id, $caption, $title, $align, $url, $size, $alt = '' ){
	$img_url = wp_get_attachment_url($id);
	list( $img_src, $width, $height ) = image_downsize($id, $size);
	$hwstring = image_hwstring($width, $height);

	$html = '<img src="' . $img_url . '" alt="' . $title . '" ' . $hwstring . 'class="align' . $align . ' size-' . $size . ' wp-image-' . $id . '" data-action="zoom" />';

	return $html;
}
add_filter('image_send_to_editor','append_data_attr',10,8);