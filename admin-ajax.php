<?php
define('WP_USE_THEMES', false);
require_once( ABSPATH . 'wp-load.php' );

function get_users_ajax(){
    global $wpdb;
    $table = $wpdb->prefix.'custom_users';
    $users = $wpdb->get_results("SELECT * FROM $table");
    if ($users === false) {
        wp_send_json_error('Error al obtener los usuarios.');
    } else {
        wp_send_json($users);
    } 
}

add_action('wp_ajax_get_users_action', 'get_users_ajax');
add_action('wp_ajax_nopriv_get_users_action', 'get_users_ajax');

function get_users_paginated() {
    global $wpdb;
    $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
    $users_per_page = isset($_POST['users_per_page']) ? intval($_POST['users_per_page']) : 5;
    $offset = ($page - 1) * $users_per_page;

    $table = $wpdb->prefix . 'custom_users';
    $users = $wpdb->get_results("SELECT * FROM $table LIMIT $offset, $users_per_page");

    $total_users = $wpdb->get_var("SELECT COUNT(*) FROM $table");
    $total_pages = ceil($total_users / $users_per_page);

    $response = array(
        'users' => $users,
        'total_pages' => $total_pages,
        'current_page' => $page,
    );

    wp_send_json($response);
}
add_action('wp_ajax_get_users_paginated_action','get_users_paginated');
add_action('wp_ajax_nopriv_get_users_paginated_action', 'get_users_ajax');


function search_users_ajax() {
    global $wpdb;

    /* if (!empty($_POST['search_term_name']) || (!empty($_POST['search_term_surname1'])) || (!empty($_POST['search_term_surname2'])) || (!empty($_POST['search_term_email']))) { */
        if (!empty($_POST['search_term_name'])) {
            $field = 'name';
            $search_term = sanitize_text_field($_POST['search_term_name']);
            if(!empty($search_term)){
            $table = $wpdb->prefix . 'custom_users';
            $query = $wpdb->prepare(
                "SELECT * FROM $table WHERE $field LIKE %s",
                '%' . $wpdb->esc_like($search_term) . '%'
            );
            $users = $wpdb->get_results($query);
            if ($users) {
                wp_send_json($users);
            } else { wp_send_json_error('No se encontraron usuarios.');}
            } 
        } 
    
        if (!empty($_POST['search_term_surname1'])) {
            $field = 'surname1';
            $search_term = sanitize_text_field($_POST['search_term_surname1']);
            if(!empty($search_term)){
            $table = $wpdb->prefix . 'custom_users';
            $query = $wpdb->prepare(
                "SELECT * FROM $table WHERE $field LIKE %s",
                '%' . $wpdb->esc_like($search_term) . '%'
            );
            $users = $wpdb->get_results($query);
            if ($users) {
                wp_send_json($users);
            } else {wp_send_json_error('No se encontraron usuarios.');}
    
        }
        } 
    
        if (!empty($_POST['search_term_surname2'])) {
            $field = 'surname2';
            $search_term = sanitize_text_field($_POST['search_term_surname2']);
            if(!empty($search_term)){
            $table = $wpdb->prefix . 'custom_users';
            $query = $wpdb->prepare(
                "SELECT * FROM $table WHERE $field LIKE %s",
                '%' . $wpdb->esc_like($search_term) . '%'
            );
            $users = $wpdb->get_results($query);
            if ($users) {
                wp_send_json($users);
            } else {wp_send_json_error('No se encontraron usuarios.');}
        }
        } 
    
        if (!empty($_POST['search_term_email'])) {
            $field = 'email';
            $search_term = sanitize_text_field($_POST['search_term_email']);
            if(!empty($search_term)){
            $table = $wpdb->prefix . 'custom_users';
            $query = $wpdb->prepare(
                "SELECT * FROM $table WHERE $field LIKE %s",
                '%' . $wpdb->esc_like($search_term) . '%'
            );
            $users = $wpdb->get_results($query);
            if ($users) {
                wp_send_json($users);
            } else {wp_send_json_error('No se encontraron usuarios.');}
    
        }
        } 
    /* } else { wp_send_json_error('No se proporcionó un término de búsqueda.');} */

}

add_action('wp_ajax_search_users_ajax_action', 'search_users_ajax');
add_action('wp_ajax_nopriv_search_users_ajax_action', 'search_users_ajax');
?>
