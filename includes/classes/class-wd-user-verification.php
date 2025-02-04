<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class WD_User_Verification {
    public function __construct() {
        $this->init();
        $this->email = new WD_Email();
        add_action('user_verification_settings_save', [$this, 'user_verification_settings_save']);
    }

    public function init() {
        $this->includes();
        $this->init_hooks();
    }

    private function includes() {
        $files = [
            'includes/classes/class-wd-setting-tabs.php',
            'includes/classes/class-wd-manage-verification.php',
            'includes/classes/class-wd-email.php',
            'includes/classes/class-wd-woo-users.php',
            'includes/classes/class-wd-wp-users.php',
            'includes/classes/class-wd-column-users.php',
        ];

        foreach ($files as $file) {
            $path = WD_USER_VERIFICATION_PATH . $file;
            if (file_exists($path)) {
                require_once $path;
            } else {
                error_log("WD User Verification: Failed to include $file");
            }
        }
    }

    // Initialize Scripts and Styles for the plugin frontend and admin area on hooks
    private function init_hooks() {
         // Initialize scripts and styles
         add_action('wp_enqueue_scripts', array($this, 'enqueue_frontend_assets'));
         add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_assets'));

    }

    public function enqueue_frontend_assets() {
        wp_enqueue_style(
            'user_verification',
            WD_USER_VERIFICATION_URL . 'assets/frontend/css/style.css',
            array(),
            filemtime(WD_USER_VERIFICATION_PATH . 'assets/frontend/css/style.css')
        );

        wp_enqueue_script(
            'user_verification',
            WD_USER_VERIFICATION_URL . 'assets/frontend/js/scripts.js',
            array(),
            filemtime(WD_USER_VERIFICATION_PATH . 'assets/frontend/js/scripts.js'),
            true
        );

    }

    public function enqueue_admin_assets($hook) {
        $screen = get_current_screen();
        wp_enqueue_style(
            'user_verification_admin',
            WD_USER_VERIFICATION_URL . 'assets/admin/css/style.css',
            array(),
            filemtime(WD_USER_VERIFICATION_PATH . 'assets/admin/css/style.css')
        );
        wp_enqueue_style(
            'user_verification_settings_tabs',
            WD_USER_VERIFICATION_URL . 'assets/settings-tabs/setting-tabs.css',
            array(),
            filemtime(WD_USER_VERIFICATION_PATH . 'assets/settings-tabs/setting-tabs.css')
        );

        wp_enqueue_script(
            'user_verification',
            WD_USER_VERIFICATION_URL . 'assets/settings-tabs/setting-tabs.js',
            array(),
            filemtime(WD_USER_VERIFICATION_PATH . 'assets/settings-tabs/setting-tabs.js'),
            true
        );
    }

    public function user_verification_recursive_sanitize_arr($array)
    {
        foreach ($array as $key => &$value) {
            if (is_array($value)) {
                $value = $this->user_verification_recursive_sanitize_arr($value);
            } else {
                if ($key == 'url') {
                    $value = esc_url_raw($value);
                } else {
                    $value = wp_kses_post($value);
                }
            }
        }
        return $array;
    }

    public function user_verification_settings_save(){
        $user_verification_settings = isset($_POST['user_verification_settings']) ?  $this->user_verification_recursive_sanitize_arr($_POST['user_verification_settings']) : array();
        update_option('user_verification_settings', $user_verification_settings);
    }




}







