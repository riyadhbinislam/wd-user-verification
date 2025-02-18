<?php
/*
Plugin Name: WD User Verification
Plugin URI: https://wolfdevs.com/products/
Description: WD User Verification ensures secure access to your website by verifying WooCommerce users and site members. It features email OTP verification, customizable email templates, and more to enhance user authentication.
Version: 1.1.0
Text Domain: wd_verification
Author: WOLFDEVS
Author URI: https://wolfdevs.com/
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/


if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}


/**
 * Define plugin root path
 * Define plugin root URL
 * Define plugin basename
 */

 define('WD_USER_VERIFICATION_VERSION', '1.1.0');
 define('WD_USER_VERIFICATION_URL', plugin_dir_url(__FILE__));
 define('WD_USER_VERIFICATION_PATH', plugin_dir_path(__FILE__));


// Autoloader
 spl_autoload_register(function ($class) {
     if (strpos($class, 'WD_') === 0) {
         $class_file = WD_USER_VERIFICATION_PATH . 'includes/classes/class-' . strtolower(str_replace('_', '-', $class)) . '.php';
         if (file_exists($class_file)) {
             require_once $class_file;
         }
     }
 });

/**
* Include the main plugin class
* Initialize the plugin
*/
 require_once WD_USER_VERIFICATION_PATH . 'includes/classes/class-wd-user-verification.php';


 /// Initialize main plugin class
 function wd_user_verification_init() {
     global $wd_user_verification;
     $wd_user_verification = new WD_User_Verification();
     $wd_user_verification->init();
    }


    add_action('init', 'wd_user_verification_init', 0);


function wd_user_verification_activate() {
    // Version checks
    if (version_compare(PHP_VERSION, '7.2', '<')) {
        wp_die(__('WD User Verification requires PHP 7.2 or higher.', 'wd_verification'));
    }
    if (version_compare(get_bloginfo('version'), '5.0', '<')) {
        wp_die(__('WD User Verification requires WordPress 5.0 or higher.', 'wd_verification'));
    }
    // Flush rewrite rules
    flush_rewrite_rules();
}

// Activation hook
register_activation_hook(__FILE__, 'wd_user_verification_activate');

function wd_user_verification_deactivate() {
    flush_rewrite_rules();
}



// Deactivation hook
register_deactivation_hook(__FILE__, 'wd_user_verification_deactivate');

