<?php

$current_tab = isset($_REQUEST['tab']) ? sanitize_text_field($_REQUEST['tab']) : 'email_verification';

$user_verification_settings_tab = array();

$user_verification_settings_tab[] = array(
    'id' => 'email_verification',
    'title' => sprintf(__('%s Email Verification', 'user-verification'), ''),
    'priority' => 1,
    'active' => ($current_tab == 'email_verification') ? true : false,
);

$user_verification_settings_tab[] = array(
    'id' => 'email_otp',
    'title' => sprintf(__('%s  Email OTP', 'user-verification'), '<i class="fas fa-key"></i>'),
    'priority' => 2,
    'active' => ($current_tab == 'email_otp') ? true : false,
);

$user_verification_settings_tab[] = array(
    'id' => 'email_templates',
    'title' => sprintf(__('%s Email Templates', 'user-verification'), '<i class="fas fa-envelope-open-text"></i>'),
    'priority' => 10,
    'active' => ($current_tab == 'email_templates') ? true : false,
);

$user_verification_settings_tab[] = array(
    'id' => 'tools',
    'title' => sprintf(__('%s Tools', 'user-verification'), '<i class="fas fa-magic"></i>'),
    'priority' => 80,
    'active' => ($current_tab == 'tools') ? true : false,
);

$user_verification_settings_tab = apply_filters('user_verification_settings_tabs', $user_verification_settings_tab);

$tabs_sorted = array();

if (!empty($user_verification_settings_tab))
    foreach ($user_verification_settings_tab as $page_key => $tab) $tabs_sorted[$page_key] = isset($tab['priority']) ? $tab['priority'] : 0;
array_multisort($tabs_sorted, SORT_ASC, $user_verification_settings_tab);

$user_verification_settings = get_option('user_verification_settings');

?>

<div class="wrap">
    <div id="icon-tools" class="icon32"><br></div>
    <h2><?php echo sprintf(__('%s Settings', 'user-verification'), __('User Verification', 'user-verification')) ?></h2>
    <form method="post" action="<?php echo str_replace('%7E', '~', esc_url_raw($_SERVER['REQUEST_URI'])); ?>">
        <input type="hidden" name="user_verification_hidden" value="Y">
        <input type="hidden" name="tab" value="<?php echo esc_attr($current_tab); ?>">

        <?php
        if (!empty($_POST['user_verification_hidden'])) {
            $nonce = sanitize_text_field($_POST['_wpnonce']);
            if (wp_verify_nonce($nonce, 'user_verification_nonce') && $_POST['user_verification_hidden'] == 'Y') {
                do_action('user_verification_settings_save');
        ?>
                <div class="updated notice is-dismissible">
                    <p><strong><?php _e('Changes Saved.', 'user-verification'); ?></strong></p>
                </div>
        <?php
            }
        }
        ?>

        <!-- If settings are not empty, show the tabs, else show the loading spinner -->
        <?php if (empty($user_verification_settings)) : ?>
            <div class="settings-tabs-loading">Loading...</div>
        <?php else : ?>
            <div class="settings-tabs vertical has-right-panel">
                <ul class="tab-navs">
                    <li class="tab-nav <?php echo ($current_tab == 'email_verification') ? 'active' : ''; ?>" data-id="email_verification"> Email Verification </li>
                    <li class="tab-nav <?php echo ($current_tab == 'email_otp') ? 'active' : ''; ?>" data-id="email_otp">   Email OTP </li>
                    <li class="tab-nav <?php echo ($current_tab == 'email_templates') ? 'active' : ''; ?>" data-id="email_templates">   Email Templates </li>
                    <li class="tab-nav <?php echo ($current_tab == 'tools') ? 'active' : ''; ?>" data-id="tools">   Tools </li>
                </ul>

                <div class="tab-content">
                    <div class="right-panel-content right-panel-content-email_verification <?php echo ($current_tab == 'email_verification') ? 'active' : ''; ?>" id="email_verification">
                        <?php include(WD_USER_VERIFICATION_PATH . 'includes/modules/wd-email.php'); ?>
                    </div>
                    <div class="right-panel-content right-panel-content-email_otp <?php echo ($current_tab == 'email_otp') ? 'active' : ''; ?>" id="email_otp">
                        <?php include(WD_USER_VERIFICATION_PATH . 'includes/modules/wd-email-otp.php'); ?>
                    </div>
                    <div class="right-panel-content right-panel-content-email_templates <?php echo ($current_tab == 'email_templates') ? 'active' : ''; ?>" id="email_templates">
                        <?php include(WD_USER_VERIFICATION_PATH . 'includes/modules/wd-email-templates.php'); ?>
                    </div>
                    <div class="right-panel-content right-panel-content-tools <?php echo ($current_tab == 'tools') ? 'active' : ''; ?>" id="tools">
                        <?php include(WD_USER_VERIFICATION_PATH . 'includes/modules/wd-tools.php'); ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <p class="submit">
            <?php wp_nonce_field('user_verification_nonce'); ?>
            <input class="button button-primary" type="submit" name="Submit" value="<?php _e('Save Changes', 'user-verification'); ?>" />
        </p>
    </form>
</div>