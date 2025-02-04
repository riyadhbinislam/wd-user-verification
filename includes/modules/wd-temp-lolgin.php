<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

add_action('user_verification_settings_content_temp_login', 'user_verification_settings_content_temp_login');
function user_verification_settings_content_temp_login($tab)
    {

        $settings_tabs_field = new WD_Setting_Tabs();
        $user_verification_settings = get_option('user_verification_settings');

        $enable = isset($user_verification_settings['temp_login']['enable']) ? $user_verification_settings['temp_login']['enable'] : 'no';
        $duration = isset($user_verification_settings['temp_login']['duration']) ? $user_verification_settings['temp_login']['duration'] : 3600;
        $require_verification = isset($user_verification_settings['temp_login']['require_verification']) ?
            $user_verification_settings['temp_login']['require_verification'] : 'no';

        //var_dump($delete_unverified_user);






    ?>
        <div class="section">
            <div class="section-title"><?php echo __('Temporary login', 'user-verification'); ?></div>


            <?php

            $args = array(
                'id'        => 'enable',
                'parent'        => 'user_verification_settings[temp_login]',
                'title'        => __('Enable', 'user-verification'),
                'details'    => __('Enable temporary login via url.', 'user-verification'),
                'type'        => 'select',
                'value'        => $enable,
                'default'        => '',
                'args'        => array('yes' => __('Yes', 'user-verification'), 'no' => __('No', 'user-verification')),
            );

            $settings_tabs_field->generate_field($args);

            $args = array(
                'id'        => 'require_verification',
                'parent'        => 'user_verification_settings[temp_login]',
                'title'        => __('Require verification', 'user-verification'),
                'details'    => __('Require email verification for temporary login.', 'user-verification'),
                'type'        => 'select',
                'value'        => $require_verification,
                'default'        => '',
                'args'        => array('yes' => __('Yes', 'user-verification'), 'no' => __('No', 'user-verification')),
            );

            $settings_tabs_field->generate_field($args);


            $args = array(
                'id'        => 'duration',
                'parent'        => 'user_verification_settings[temp_login]',
                'title'        => __('Duration', 'user-verification'),
                'details'    => __('maximum duration for temp login. ex: 3600 (in second)', 'user-verification'),
                'type'        => 'text',
                'value'        => $duration,
                'default'        => '',
            );

            $settings_tabs_field->generate_field($args);


            ?>


        </div>
    <?php


    }