<?php
require_once(plugin_dir_path(__FILE__) . 'utils.php');

add_action('admin_menu', 'register_my_custom_menu_page');

function register_my_custom_menu_page() {
    add_menu_page(
        'Experience IT Plugin',
        'Configuración Experience IT Plugin', 
        'manage_options', 
        'experience-it', 
        'experience_it_settings_page',
        'dashicons-admin-generic'
    );
}

function experience_it_settings_page() {
   
    if (isset($_POST['submit_settings'])) {
        if (isset($_POST['user_qty'])) {
            update_option('user_qty', $_POST['user_qty']);
        }
        if (isset($_POST['users_limit'])) {
            update_option('users_limit', $_POST['users_limit']);
        }
        echo '<div class="notice notice-success"><p>Settings saved successfully!</p></div>';
    }
    echo '<label for="user_qty">Cantidad de Usuarios a Crear:</label>';
    echo '<input type="number" id="user_qty" name="user_qty" value="' . esc_attr(get_option('user_qty', 10)) . '">';
    echo '<form method="post" action="">';
    echo '<label for="user_limit">Usuarios por página:</label>';
    echo '<input type="hidden" name="import_users" value="true">';
    echo '<button type="submit" class="button-primary">Importar Usuarios</button>';
    echo '</form>';
    echo '<form method="post" action="">
    <input type="hidden" name="delete_users_data" value="true">
    <button type="submit">Eliminar Datos de Usuarios</button>
    </form>';
    echo '<form method="post" action="">';
    echo '<input type="hidden" name="submit_settings" value="true">';
    echo '<button type="submit" class="button-primary">Guardar Preferencias</button>';
    echo '</form>';
}
add_action('add_meta_boxes', 'experience_it_settings_page');

function handle_import_users() {
    if (isset($_POST['import_users']) && $_POST['import_users'] === 'true') {
        insert_users_to_ddbb(get_option('user_qty', 10));
    }
}
add_action('admin_init', 'handle_import_users');

function handle_delete_users() {
    if(isset($_POST['delete_users_data']) && $_POST['delete_users_data'] === 'true'){
        delete_users_data();
    }
}

function save_plugin_settings_config_page($post_id) {
    if (isset($_POST['user_qty'])) {
        update_option('user_qty', $_POST['user_qty']);
    }
    if (isset($_POST['users_limit'])) {
        update_option('users_limit', $_POST['users_limit']);
    }
}

add_action('save_config', 'save_plugin_settings_config_page');