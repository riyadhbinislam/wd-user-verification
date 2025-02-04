<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

add_action('user_verification_settings_content_tools', 'user_verification_settings_content_tools');
function user_verification_settings_content_tools($tab){
    error_log("Rendering Tools settings content");

    $settings_tabs_field = new WD_Setting_Tabs();
    $user_verification_settings = get_option('user_verification_settings');

    $delete_unverified_user = isset($user_verification_settings['unverified']['delete_user']) ? $user_verification_settings['unverified']['delete_user'] : 'no';
    $delete_user_interval = isset($user_verification_settings['unverified']['delete_user_interval']) ? $user_verification_settings['unverified']['delete_user_interval'] : 'daily';
    $delete_user_delay = isset($user_verification_settings['unverified']['delay']) ? $user_verification_settings['unverified']['delay'] : 720;
    $delete_max_number = isset($user_verification_settings['unverified']['delete_max_number']) ? $user_verification_settings['unverified']['delete_max_number'] : 20;


    $existing_user_verified = isset($user_verification_settings['unverified']['existing_user_verified']) ? $user_verification_settings['unverified']['existing_user_verified'] : 'no';
    $existing_user_verified_interval = isset($user_verification_settings['unverified']['existing_user_verified_interval']) ? $user_verification_settings['unverified']['existing_user_verified_interval'] : 'daily';


    $disable_new_user_notification_email = isset($user_verification_settings['disable']['new_user_notification_email']) ? $user_verification_settings['disable']['new_user_notification_email'] : 'no';


    $mail_from = isset($user_verification_settings['tools']['mail_from']) ? $user_verification_settings['tools']['mail_from'] : '';
    $mail_from_name = isset($user_verification_settings['tools']['mail_from_name']) ? $user_verification_settings['tools']['mail_from_name'] : '';



    $gmt_offset = get_option('gmt_offset');


    if ($delete_unverified_user == 'yes') {
        if (!wp_next_scheduled('user_verification_delete_unverified_user')) {
            wp_schedule_event(time(), $delete_user_interval, 'user_verification_delete_unverified_user');
        }
    } else {
        wp_clear_scheduled_hook('user_verification_delete_unverified_user');
    }


    if ($existing_user_verified == 'yes') {
        if (!wp_next_scheduled('user_verification_existing_user_verified')) {
            wp_schedule_event(time(), $existing_user_verified_interval, 'user_verification_existing_user_verified');
        }
    } else {
        wp_clear_scheduled_hook('user_verification_existing_user_verified');
    }



    $friendly_date = date("Y-m-d H:i:s", strtotime('+' . $gmt_offset . ' hours', wp_next_scheduled('user_verification_delete_unverified_user')));
    $friendly_date2 = date("Y-m-d H:i:s", strtotime('+' . $gmt_offset . ' hours', wp_next_scheduled('user_verification_existing_user_verified')));




?>
    <div class="section">
        <div class="section-title"><?php echo __('Delete unverified users', 'user-verification'); ?></div>


        <?php



        $des = ($delete_unverified_user == 'yes') ? sprintf(__('Enable to delete unverified users. Next schedule <strong>%s</strong>', 'user-verification'), $friendly_date) : __('Enable to delete unverified users.', 'user-verification');


        $args = array(
            'id'        => 'delete_user',
            'parent'        => 'user_verification_settings[unverified]',
            'title'        => __('Delete unverified users', 'user-verification'),
            'details'    => $des,
            'type'        => 'select',
            'value'        => $delete_unverified_user,
            'default'        => '',
            'args'        => array('yes' => __('Yes', 'user-verification'), 'no' => __('No', 'user-verification')),
        );

        $settings_tabs_field->generate_field($args);

        $args = array(
            'id'        => 'delete_max_number',
            'parent'        => 'user_verification_settings[unverified]',
            'title'        => __('Max number ', 'user-verification'),
            'details'    => __('Set max number of users to delete', 'user-verification'),
            'type'        => 'text',
            'value'        => $delete_max_number,
            'default'        => '',
        );

        $settings_tabs_field->generate_field($args);

        $args = array(
            'id'        => 'delay',
            'parent'        => 'user_verification_settings[unverified]',
            'title'        => __('Delay ', 'user-verification'),
            'details'    => __('Set delay for deliting unverified users. (in minutes)', 'user-verification'),
            'type'        => 'text',
            'value'        => $delete_user_delay,
            'default'        => '',
        );

        $settings_tabs_field->generate_field($args);


        $args = array(
            'id'        => 'delete_user_interval',
            'parent'        => 'user_verification_settings[unverified]',
            'title'        => __('Delete interval unverified users', 'user-verification'),
            'details'    => '',
            'type'        => 'select',
            'value'        => $delete_user_interval,
            'default'        => '',
            'args'        => array(
                '10minute' => __('10 minutes', 'user-verification'),
                '30minute' => __('30 minutes', 'user-verification'),
                '6hours' => __('6 hours', 'user-verification'),
                'hourly' => __('Hourly', 'user-verification'),
                'twicedaily' => __('Twicedaily', 'user-verification'),
                'daily' => __('Daily', 'user-verification'),
                'weekly' => __('Weekly', 'user-verification'),
            ),
        );

        $settings_tabs_field->generate_field($args);




        ?>


    </div>

    <div class="section">
        <div class="section-title"><?php echo __('Existing user', 'user-verification'); ?></div>
        <p></p>

        <?php

        $des = ($existing_user_verified == 'yes') ? sprintf(__('Enable to Mark all existing user as verified. Next schedule <strong>%s</strong>', 'user-verification'), $friendly_date2) : __('Mark all existing user as verified. (*Not Recommended)', 'user-verification');

        $args = array(
            'id'        => 'existing_user_verified',
            'parent'        => 'user_verification_settings[unverified]',
            'title'        => __('Existing user as verified', 'user-verification'),
            'details'    => $des,
            'type'        => 'select',
            'value'        => $existing_user_verified,
            'default'        => '',
            'args'        => array('yes' => __('Yes', 'user-verification'), 'no' => __('No', 'user-verification')),
        );

        $settings_tabs_field->generate_field($args);



        $args = array(
            'id'        => 'existing_user_verified_interval',
            'parent'        => 'user_verification_settings[unverified]',
            'title'        => __('Existing user as verified interval', 'user-verification'),
            'details'    => '',
            'type'        => 'select',
            'value'        => $existing_user_verified_interval,
            'default'        => '',
            'args'        => array(
                '10minute' => __('10 minutes', 'user-verification'),
                '30minute' => __('30 minutes', 'user-verification'),
                '6hours' => __('6 hours', 'user-verification'),
                'hourly' => __('Hourly', 'user-verification'),
                'twicedaily' => __('Twicedaily', 'user-verification'),
                'daily' => __('Daily', 'user-verification'),
                'weekly' => __('Weekly', 'user-verification'),
            ),
        );

        $settings_tabs_field->generate_field($args);



        ?>

    </div>

    <div class="section">
        <div class="section-title"><?php echo __('Default WordPress notification mail', 'user-verification'); ?></div>
        <p></p>
        <?php


        $args = array(
            'id'        => 'new_user_notification_email',
            'parent'        => 'user_verification_settings[disable]',
            'title'        => __('Disable WordPress welcome email', 'user-verification'),
            'details'    => __('You can disable default WordPress notification mail for new user.', 'user-verification'),
            'type'        => 'select',
            'value'        => $disable_new_user_notification_email,
            'default'        => '',
            'args'        => array('yes' => __('Yes', 'user-verification'), 'no' => __('No', 'user-verification')),
        );

        $settings_tabs_field->generate_field($args);

        $args = array(
            'id'        => 'mail_from',
            'parent'        => 'user_verification_settings[tools]',
            'title'        => __('Default email from address', 'user-verification'),
            'details'    => __('Set Default email from address.', 'user-verification'),
            'type'        => 'text',
            'value'        => $mail_from,
            'default'        => '',
        );

        $settings_tabs_field->generate_field($args);


        $args = array(
            'id'        => 'mail_from_name',
            'parent'        => 'user_verification_settings[tools]',
            'title'        => __('Default email from name', 'user-verification'),
            'details'    => __('Set Default email from name.', 'user-verification'),
            'type'        => 'text',
            'value'        => $mail_from_name,
            'default'        => '',
        );

        $settings_tabs_field->generate_field($args);

        ?>
    </div>
<?php } ?>