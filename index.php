<?php
/***
	Plugin Name: Launchpad Popular Posts
	Plugin URI: https://vinhdd.com
	Description: Add Related, Featured, Latest and Popular Posts to your WordPress. Connect your blog readers with a relevant content.
	Version: 1.0
	Author: Launchpad.vn
	Author URI: https://launchpad.vn
	Author Email: vinhdd.cntt@gmail.com
	Text Domain: launchpad-popular posts
	Domain Path: /languages
***/


if(!defined('ABSPATH')){
    exit;
}


require_once(plugin_dir_path(__FILE__).'/includes/popular-posts-script.php');
require_once(plugin_dir_path(__FILE__).'/includes/popular-posts-widget.php');
require_once(plugin_dir_path(__FILE__).'/includes/popular-posts-views.php');

function launchpad_popular_post_widget_register(){
    register_widget('Launchpad_Most_Popular_Post_Widget');
}
add_action('widgets_init','launchpad_popular_post_widget_register');

add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), 'customize_link_p' );
function customize_link_p( $links ) {
   $links[] = '<a href="#">Customize</a>';
   return $links;
}