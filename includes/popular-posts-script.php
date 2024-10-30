<?php
 // add script

 function launchpad_most_popular_plugn_style(){
 	wp_enqueue_style('style', plugins_url( 'asset/css/style.css', dirname(__FILE__) ) );
 }
 add_action('wp_enqueue_scripts','launchpad_most_popular_plugn_style');
