<?php

/*
Plugin Name: Experience IT Plugin
Description: Prueba Técnica Experience IT
Version: 1.0
Author: Javier Catalán Casado
 */
require_once(plugin_dir_path(__FILE__) . 'settings.php');
require_once(plugin_dir_path(__FILE__) . 'admin-ajax.php');

add_action('wp_enqueue_scripts', 'experience_it_enqueue_scripts');
function experience_it_enqueue_scripts() {

    wp_enqueue_style('experience_it_styles', plugins_url( '/assets/css/styles.css', __FILE__ ));
    wp_enqueue_script('experience_it_script', plugins_url('/assets/js/script.js', __FILE__), array('jquery'), null, true);
    wp_localize_script('experience_it_script', 'get_users_ajax', array('ajaxurl' => admin_url('admin-ajax.php')));

}



add_shortcode( 'users_shortcode_experience_it', 'experience_it_shortcode');
function experience_it_shortcode() {
    ob_start();
    include(plugin_dir_path(__FILE__).'templates/user-listing.php');
    return ob_get_clean();
}



