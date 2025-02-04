<?php
if (!defined('ABSPATH')) exit;  // if direct access

include_once WD_USER_VERIFICATION_PATH . 'includes/modules/wd-email.php';
include_once WD_USER_VERIFICATION_PATH . 'includes/modules/wd-email-otp.php';
include_once WD_USER_VERIFICATION_PATH . 'includes/modules/wd-email-templates.php';
include_once WD_USER_VERIFICATION_PATH . 'includes/modules/wd-tools.php';

$current_tab = isset($_REQUEST['tab']) ? sanitize_text_field($_REQUEST['tab']) : 'email_verification';

$user_verification_settings_tab = array();

$user_verification_settings_tab[] = array(
    'id' => 'email_verification',
    'title' => sprintf(__('%s Email Verification', 'user-verification'), '<i class="far fa-envelope"></i>'),
    'priority' => 1,
    'active' => ($current_tab == 'email_verification') ? true : false,
);

$user_verification_settings_tab[] = array(
    'id' => 'email_otp',
    'title' => sprintf(__('%s  Email OTP', 'user-verification'), '<i class="fas fa-key"></i>'),
    'priority' => 2,
    'active' => ($current_tab == 'email_otp') ? true : false,
);

// $user_verification_settings_tab[] = array(
//    'id' => 'sms_otp',
//    'title' => sprintf(__('%s  SMS OTP','user-verification'),'<i class="fas fa-sms"></i>'),
//    'priority' => 2,
//    'active' => ($current_tab == 'sms_otp') ? true : false,
// );


$user_verification_settings_tab[] = array(
    'id' => 'email_templates',
    'title' => sprintf(__('%s Email Templates', 'user-verification'), '<i class="fas fa-envelope-open-text"></i>'),
    'priority' => 10,
    'active' => ($current_tab == 'email_templates') ? true : false,
);


// $user_verification_settings_tab[] = array(
//  'id' => 'temp_login',
//  'title' => sprintf(__('%s Temp Login','user-verification'),'<i class="fab fa-keycdn"></i>'),
//  'priority' => 80,
//  'active' => ($current_tab == 'temp_login') ? true : false,
// );


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

//delete_option('user_verification_settings');

function user_verification_get_pages_list()
    {
        $array_pages['none'] = __('None', 'user-verification');

        $args = array(
            'sort_order' => 'asc',
            'sort_column' => 'post_title',
            'hierarchical' => 1,
            'exclude' => '',
            'include' => '',
            'meta_key' => '',
            'meta_value' => '',
            'authors' => '',
            'child_of' => 0,
            'parent' => -1,
            'exclude_tree' => '',
            'number' => '',
            'offset' => 0,
            'post_type' => 'page',
            'post_status' => 'publish,private'
        );
        $pages = get_pages($args);

        //$array_pages[0] = 'None';

        foreach ($pages as $page) {
            if ($page->post_title) $array_pages[$page->ID] = $page->post_title;
        }


        return $array_pages;
    }


function user_verification_user_roles()
{

    $wp_roles = new WP_Roles();

    $roles = $wp_roles->get_names();

    return  $roles;
    // Below code will print the all list of roles.

}


?>
<div class="wrap">
    <div id="icon-tools" class="icon32"><br></div>
    <h2><?php echo sprintf(__('%s Settings', 'user-verification'), 'WD User Verification') ?></h2>
    <form method="post" action="<?php echo str_replace('%7E', '~', esc_url_raw($_SERVER['REQUEST_URI'])); ?>">
        <input type="hidden" name="user_verification_hidden" value="Y">
        <input type="hidden" name="tab" value="<?php echo esc_attr($current_tab); ?>">
        <?php
        if (!empty($_POST['user_verification_hidden'])) {
            $nonce = sanitize_text_field($_POST['_wpnonce']);
            if (wp_verify_nonce($nonce, 'user_verification_nonce') && $_POST['user_verification_hidden'] == 'Y') {
                do_action('user_verification_settings_save');
        ?>
                <div class="updated notice  is-dismissible">
                    <p><strong><?php _e('Changes Saved.', 'user-verification'); ?></strong></p>
                </div>
        <?php
            }
        }
        ?>

        <div class="settings-tabs-loading" style="">Loading...</div>

        <div class="settings-tabs vertical has-right-panel" style="display: none">

            <ul class="tab-navs">
                <?php
                if (!empty($user_verification_settings_tab))
                    foreach ($user_verification_settings_tab as $tab) {
                        $id = $tab['id'];
                        $title = $tab['title'];
                        $active = $tab['active'];
                        $data_visible = isset($tab['data_visible']) ? $tab['data_visible'] : '';
                        $hidden = isset($tab['hidden']) ? $tab['hidden'] : false;
                        $is_pro = isset($tab['is_pro']) ? $tab['is_pro'] : false;
                        $pro_text = isset($tab['pro_text']) ? $tab['pro_text'] : '';
                ?>
                    <li <?php if (!empty($data_visible)) :  ?> data_visible="<?php echo esc_attr($data_visible); ?>" <?php endif; ?> class="tab-nav <?php if ($hidden) echo 'hidden'; ?> <?php if ($active) echo 'active'; ?>" data-id="<?php echo esc_attr($id); ?>">
                        <?php echo wp_kses_post($title); ?>
                        <?php
                        if ($is_pro) :
                        ?><span class="pro-feature"><?php echo esc_attr($pro_text); ?></span> <?php
                                                                                            endif;
                                                                                                ?>
                    </li>
                <?php
                    }
                ?>
            </ul>

            <?php
            if (!empty($user_verification_settings_tab))
                foreach ($user_verification_settings_tab as $tab) {
                    $id = $tab['id'];
                    $title = $tab['title'];
                    $active = $tab['active'];
                    error_log("Tab ID: $id, Title: $title, Active: $active");
            ?>
            <div class="tab-content <?php if ($active) echo 'active'; ?>" id="<?php echo esc_attr($id); ?>">
                <?php
                do_action('user_verification_settings_content_' . $id, $tab);
                ?>
            </div>
            <?php
                }
            ?>

            <div class="clear clearfix"></div>
            <p class="submit">
                <?php wp_nonce_field('user_verification_nonce'); ?>
                <input class="button button-primary" type="submit" name="Submit" value="<?php _e('Save Changes', 'user-verification'); ?>" />
            </p>
        </div>
    </form>
</div>