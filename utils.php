<?php
define('WP_USE_THEMES', false);
//require_once( plugin_dir_path( __FILE__ ) . '../../wp-load.php' );
require_once( ABSPATH . 'wp-load.php' );
require_once 'vendor/autoload.php';
global $wpdb;

use Faker\Factory;
function insert_users_to_ddbb($qty) {
    global $wpdb;
    $tableName = $wpdb->prefix.'custom_users';
    if ($wpdb->get_var("SHOW TABLES LIKE '$tableName'") != $tableName) {
        create_custom_users_table();
    }
    for ($i = 0; $i < $qty; $i++) {
        $user = create_user_data();
        $insertUser = insert_user_to_database($user);
        echo $insertUser. "<br>";
    }
}

function create_custom_users_table() {
    global $wpdb;
    $tableName = $wpdb->prefix.'custom_users';
    $charset_collate = 'DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci';

    $sql = "CREATE TABLE IF NOT EXISTS $tableName (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user VARCHAR(100) NOT NULL,
        email VARCHAR(100) NOT NULL,
        password VARCHAR(100),
        name VARCHAR(100),
        surname1 VARCHAR(100),
        surname2 VARCHAR(100)
    ) $charset_collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
}

function create_user_data() {
    $faker = Factory::create();

    return array(
        'user'=>$faker->username(),
        'email'=>$faker->email(),
        'password'=>wp_generate_password(),
        'name'=>$faker->name(),
        'surname1'=>$faker->lastName(),
        'surname2'=>$faker->lastName()
    );
}

function insert_user_to_database($userData) {
    global $wpdb;
    $tableName = $wpdb->prefix . 'custom_users';

    $userId = $wpdb->insert($tableName,
        array (
        'user' => $userData['user'],
        'email' => $userData['email'],
        'password' => $userData['password'],
        'name' => $userData['name'],
        'surname1' => $userData['surname1'],
        'surname2' => $userData['surname1'] . ' ' . $userData['surname2']
    ));

    if ($userId === false) {
        return 'Error al insertar el usuario: ' . $userId;
    }
    return 'Usuario insertado correctamente.';
}

function delete_users_data() {
    if(isset($_POST['delete_users_data'])){
        global $wpdb;
        $table_name = $wpdb->prefix . 'users';
        $wpdb->query("DELETE FROM $table_name");
    }
}