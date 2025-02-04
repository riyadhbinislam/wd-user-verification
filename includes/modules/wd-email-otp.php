<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

add_action('user_verification_settings_content_email_otp', 'user_verification_settings_content_email_otp');


function user_verification_settings_content_email_otp() {
    error_log("Rendering Email OTP settings content");

    $settings_tabs_field = new WD_Setting_Tabs();


    $user_verification_settings = get_option('user_verification_settings');

    //delete_option('user_verification_settings');


    $enable_default_login = isset($user_verification_settings['email_otp']['enable_default_login']) ? $user_verification_settings['email_otp']['enable_default_login'] : 'no';
    $required_email_verified = isset($user_verification_settings['email_otp']['required_email_verified']) ? $user_verification_settings['email_otp']['required_email_verified'] : 'no';


    $enable_wc_login = isset($user_verification_settings['email_otp']['enable_wc_login']) ? $user_verification_settings['email_otp']['enable_wc_login'] : 'no';


    $enable_default_register = isset($user_verification_settings['email_otp']['enable_default_register']) ? $user_verification_settings['email_otp']['enable_default_register'] : 'no';
    $length = isset($user_verification_settings['email_otp']['length']) ? $user_verification_settings['email_otp']['length'] : 6;
    $character_source = isset($user_verification_settings['email_otp']['character_source']) ? $user_verification_settings['email_otp']['character_source'] : ['uppercase', 'lowercase'];
    $allow_password = isset($user_verification_settings['email_otp']['allow_password']) ? $user_verification_settings['email_otp']['allow_password'] : 'yes';

    //$password = user_verification_random_password($length, $character_source)

?>

<div class="section">
    <div class="section-title"><?php echo __('Email OTP', 'user-verification'); ?></div>
    <p class="description section-description"><?php echo __('Customize options for email OTP.', 'user-verification'); ?></p>

    <?php


    $args = array(
        'id'        => 'enable_default_login',
        'parent'        => 'user_verification_settings[email_otp]',
        'title'        => __('Enable on default login', 'user-verification'),
        'details'    => __('Enable OTP on default login page. every time a user try to login will require a OTP send via mail.', 'user-verification'),
        'type'        => 'select',
        'value'        => $enable_default_login,
        'default'        => '',
        'args'        => array('yes' => __('Yes', 'user-verification'), 'no' => __('No', 'user-verification')),
    );

    $settings_tabs_field->generate_field($args);

    $args = array(
        'id'        => 'required_email_verified',
        'parent'        => 'user_verification_settings[email_otp]',
        'title'        => __('Required email verified', 'user-verification'),
        'details'    => __('Send OTP to only email verified users.', 'user-verification'),
        'type'        => 'select',
        'value'        => $required_email_verified,
        'default'        => '',
        'args'        => array('yes' => __('Yes', 'user-verification'), 'no' => __('No', 'user-verification')),
    );

    $settings_tabs_field->generate_field($args);




    $args = array(
        'id'        => 'allow_password',
        'parent'        => 'user_verification_settings[email_otp]',
        'title'        => __('Allow Passowrd', 'user-verification'),
        'details'    => __('Allow password in OTP field', 'user-verification'),
        'type'        => 'select',
        'value'        => $allow_password,
        'default'        => '',
        'args'        => array('yes' => __('Yes', 'user-verification'), 'no' => __('No', 'user-verification')),
    );

    $settings_tabs_field->generate_field($args);


    $args = array(
        'id'        => 'enable_wc_login',
        'parent'        => 'user_verification_settings[email_otp]',
        'title'        => __('Enable on WooCommerce login', 'user-verification'),
        'details'    => __('Enable OTP on WooCommerce login page. every time a user try to login via WooCommerce login form will require a OTP send via mail.', 'user-verification'),
        'disabled'        => ($enable_default_login != 'yes') ? true : false,
        'disabledMessage'        => 'Please enable OTP on default login first',
        'conditions' => array(
            'field' => 'user_verification_settings[email_otp][enable_default_login]',
            'value' => 'yes',
            'type' => '='
        ),
        'type'        => 'select',
        'value'        => $enable_wc_login,
        'default'        => '',
        'args'        => array('yes' => __('Yes', 'user-verification'), 'no' => __('No', 'user-verification')),
    );

    $settings_tabs_field->generate_field($args);


    $args = array(
        'id'        => 'enable_default_register',
        'parent'        => 'user_verification_settings[email_otp]',
        'title'        => __('Enable on default register', 'user-verification'),
        'details'    => __('Enable OTP on default registration page. every time a user try to register will require a OTP send via mail.', 'user-verification'),
        'type'        => 'select',
        'value'        => $enable_default_register,
        'default'        => '',
        'args'        => array('yes' => __('Yes', 'user-verification'), 'no' => __('No', 'user-verification')),
    );

    //$settings_tabs_field->generate_field($args);

    $args = array(
        'id'        => 'length',
        'parent'        => 'user_verification_settings[email_otp]',
        'title'        => __('OTP Length', 'user-verification'),
        'details'    => __('Set custom length for OTP.', 'user-verification'),
        'type'        => 'text',
        'value'        => $length,
        'default'        => '',
    );

    $settings_tabs_field->generate_field($args);



    $args = array(
        'id'        => 'character_source',
        'parent'        => 'user_verification_settings[email_otp]',
        'title'        => __('OTP character source', 'user-verification'),
        'details'    => __('Set OTP character source to generate', 'user-verification'),
        'type'        => 'checkbox',
        'value'        => $character_source,
        'default'        => [],
        'args'        => array(
            'number' => __('Numbers(0-9)', 'user-verification'),
            'uppercase' => __('Uppercase characters', 'user-verification'),
            'lowercase' => __('Lowercase characters', 'user-verification'),
            'special' => __('Special characters', 'user-verification'),
            'extraspecial' => __('Extra Special characters', 'user-verification'),

        ),
    );

    $settings_tabs_field->generate_field($args);




    ?>

</div>

<?php
}



