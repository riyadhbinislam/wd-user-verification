<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
    function user_verification_settings_content_email_verification(){
        error_log("Rendering Email Verification settings content");
        $settings_tabs_field = new WD_Setting_Tabs();


    $user_verification_settings = get_option('user_verification_settings');

    //delete_option('user_verification_settings');


    $email_verification_enable = isset($user_verification_settings['email_verification']['enable']) ? $user_verification_settings['email_verification']['enable'] : 'yes';
    $verification_page_id = isset($user_verification_settings['email_verification']['verification_page_id']) ? $user_verification_settings['email_verification']['verification_page_id'] : '';
    $redirect_after_verification = isset($user_verification_settings['email_verification']['redirect_after_verification']) ? $user_verification_settings['email_verification']['redirect_after_verification'] : '';
    $login_after_verification = isset($user_verification_settings['email_verification']['login_after_verification']) ? $user_verification_settings['email_verification']['login_after_verification'] : '';
    $exclude_user_roles = isset($user_verification_settings['email_verification']['exclude_user_roles']) ? $user_verification_settings['email_verification']['exclude_user_roles'] : array();
    $email_update_reverify = isset($user_verification_settings['email_verification']['email_update_reverify']) ? $user_verification_settings['email_verification']['email_update_reverify'] : 'no';



    ?>
    <div class="section">
        <div class="section-title"><?php echo __('Email verification', 'user-verification'); ?></div>
        <p class="description section-description"><?php echo __('Customize options for email verification.', 'user-verification'); ?></p>

        <?php


        $args = array(
            'id'        => 'enable',
            'parent'        => 'user_verification_settings[email_verification]',
            'title'        => __('Enable email verification', 'user-verification'),
            'details'    => __('Select to enable or disable email verification.', 'user-verification'),
            'type'        => 'select',
            'value'        => $email_verification_enable,
            'default'        => '',
            'args'        => array('yes' => __('Yes', 'user-verification'), 'no' => __('No', 'user-verification')),
        );

        $settings_tabs_field->generate_field($args);


        $args = array(
            'id'        => 'verification_page_id',
            'parent'        => 'user_verification_settings[email_verification]',
            'title'        => __('Choose verification page', 'user-verification'),
            'details'    => __('Select page where verification will process. default home page if select none.', 'user-verification'),
            'type'        => 'select',
            'value'        => $verification_page_id,
            'default'        => '',
            'args'        => user_verification_get_pages_list(),

        );

        $settings_tabs_field->generate_field($args);


        $args = array(
            'id'        => 'redirect_after_verification',
            'parent'        => 'user_verification_settings[email_verification]',
            'title'        => __('Redirect after verification', 'user-verification'),
            'details'    => __('Redirect to any page after successfully verified account.', 'user-verification'),
            'type'        => 'select',
            'value'        => $redirect_after_verification,
            'default'        => '',
            'args'        => user_verification_get_pages_list(),

        );

        $settings_tabs_field->generate_field($args);


        $args = array(
            'id'        => 'login_after_verification',
            'parent'        => 'user_verification_settings[email_verification]',
            'title'        => __('Automatically login after verification', 'user-verification'),
            'details'    => __('Set yes to login automatically after verification completed, otherwise set no.', 'user-verification'),
            'type'        => 'select',
            'value'        => $login_after_verification,
            'default'        => 'yes',
            'args'        => array('yes' => __('Yes', 'user-verification'), 'no' => __('No', 'user-verification')),

        );

        $settings_tabs_field->generate_field($args);


        $args = array(
            'id'        => 'email_update_reverify',
            'parent'        => 'user_verification_settings[email_verification]',
            'title'        => __('Required verification on email change?', 'user-verification'),
            'details'    => __('Resend email verification when user update their email.', 'user-verification'),
            'type'        => 'select',
            'value'        => $email_update_reverify,
            'default'        => 'no',
            'args'        => array('yes' => __('Yes', 'user-verification'), 'no' => __('No', 'user-verification')),

        );

        $settings_tabs_field->generate_field($args);


        $args = array(
            'id'        => 'exclude_user_roles',
            'parent'        => 'user_verification_settings[email_verification]',
            'title'        => __('Exclude user role', 'user-verification'),
            'details'    => __('You can exclude verification for these user roles to login on your site.', 'user-verification'),
            'type'        => 'select2',
            'multiple'        => true,
            'value'        => $exclude_user_roles,
            'default'        => array('administrator'),
            'attributes'        => array('grid_id' => 'sdfs'),

            'args'        => user_verification_user_roles(),
        );

        $settings_tabs_field->generate_field($args);




        ?>

    </div>


    <div class="section">
        <div class="section-title"><?php echo __('Error messages', 'user-verification'); ?></div>
        <p class="description section-description"><?php echo __('Customize error messages.', 'user-verification'); ?></p>

        <?php

        $messages = isset($user_verification_settings['messages']) ? $user_verification_settings['messages'] : array();

        $invalid_key = isset($messages['invalid_key']) ? $messages['invalid_key'] : __('Sorry, activation key is not valid.', 'user-verification');
        $activation_sent = isset($messages['activation_sent']) ? $messages['activation_sent'] : __('Verification mail has been sent.', 'user-verification');
        $verify_email = isset($messages['verify_email']) ? $messages['verify_email'] : __('Verify your email first!', 'user-verification');
        $registration_success = isset($messages['registration_success']) ? $messages['registration_success'] : __('Registration complete. Please verify the mail first, then visit the <a href="%s">login page</a>.', 'user-verification');
        $verification_success = isset($messages['verification_success']) ? $messages['verification_success'] : __('Thanks for Verifying.', 'user-verification');
        $verification_fail = isset($messages['verification_fail']) ? $messages['verification_fail'] : __('Sorry! Verification failed.', 'user-verification');
        $please_wait = isset($messages['please_wait']) ? $messages['please_wait'] : __('Please wait.', 'user-verification');
        $mail_instruction = isset($messages['mail_instruction']) ? $messages['mail_instruction'] : __('Please check your mail inbox and follow the instruction. don\'t forget to check spam or trash folder.', 'user-verification');

        $redirect_after_verify = isset($messages['redirect_after_verify']) ? $messages['redirect_after_verify'] : __('You will redirect after verification', 'user-verification');
        $not_redirect = isset($messages['not_redirect']) ? $messages['not_redirect'] : __('Click if not redirect automatically', 'user-verification');


        $title_checking_verification = isset($messages['title_checking_verification']) ? $messages['title_checking_verification'] : __('Checking Verification', 'user-verification');
        $title_sending_verification = isset($messages['title_sending_verification']) ? $messages['title_sending_verification'] : __('Sending verification mail', 'user-verification');

        $captcha_error = isset($messages['captcha_error']) ? $messages['captcha_error'] : __('Captcha not resolved.', 'user-verification');
        $otp_sent_success = isset($messages['otp_sent_success']) ? $messages['otp_sent_success'] : __('OTP has been sent successfully.', 'user-verification');
        $otp_sent_error = isset($messages['otp_sent_error']) ? $messages['otp_sent_error'] : __('OTP generated, but unable to send mail.', 'user-verification');





        $args = array(
            'id'        => 'invalid_key',
            'parent'        => 'user_verification_settings[messages]',
            'title'        => __('Invalid activation key', 'user-verification'),
            'details'    => __('Show custom message when user activation key is invalid or wrong', 'user-verification'),
            'type'        => 'textarea',
            'value'        => $invalid_key,
            'default'        => '',

        );

        $settings_tabs_field->generate_field($args);


        $args = array(
            'id'        => 'activation_sent',
            'parent'        => 'user_verification_settings[messages]',
            'title'        => __('Activation key has sent', 'user-verification'),
            'details'    => __('Show custom message when activation key is sent to user email', 'user-verification'),
            'type'        => 'textarea',
            'value'        => $activation_sent,
            'default'        => '',

        );

        $settings_tabs_field->generate_field($args);


        $args = array(
            'id'        => 'verify_email',
            'parent'        => 'user_verification_settings[messages]',
            'title'        => __('Verify email address', 'user-verification'),
            'details'    => __('Show custom message when user try to login without verifying email with proper activation key', 'user-verification'),
            'type'        => 'textarea',
            'value'        => $verify_email,
            'default'        => '',

        );

        $settings_tabs_field->generate_field($args);



        $args = array(
            'id'        => 'registration_success',
            'parent'        => 'user_verification_settings[messages]',
            'title'        => __('Registration success message', 'user-verification'),
            'details'    => __('User will get this message as soon as registered on your website', 'user-verification'),
            'type'        => 'textarea',
            'value'        => $registration_success,
            'default'        => '',

        );

        $settings_tabs_field->generate_field($args);



        $args = array(
            'id'        => 'verification_success',
            'parent'        => 'user_verification_settings[messages]',
            'title'        => __('Verification successful', 'user-verification'),
            'details'    => __('Show custom message when user successfully verified', 'user-verification'),
            'type'        => 'textarea',
            'value'        => $verification_success,
            'default'        => '',

        );

        $settings_tabs_field->generate_field($args);


        $args = array(
            'id'        => 'verification_fail',
            'parent'        => 'user_verification_settings[messages]',
            'title'        => __('Verification fail', 'user-verification'),
            'details'    => __('Show custom message when verification failed', 'user-verification'),
            'type'        => 'textarea',
            'value'        => $verification_fail,
            'default'        => '',
        );

        $settings_tabs_field->generate_field($args);

        $args = array(
            'id'        => 'please_wait',
            'parent'        => 'user_verification_settings[messages]',
            'title'        => __('Please wait text', 'user-verification'),
            'details'    => __('Show custom for "please wait"', 'user-verification'),
            'type'        => 'textarea',
            'value'        => $please_wait,
            'default'        => '',
        );

        $settings_tabs_field->generate_field($args);

        $args = array(
            'id'        => 'mail_instruction',
            'parent'        => 'user_verification_settings[messages]',
            'title'        => __('Mail instruction text', 'user-verification'),
            'details'    => __('Add custom text for mail instructions.', 'user-verification'),
            'type'        => 'textarea',
            'value'        => $mail_instruction,
            'default'        => '',
        );

        $settings_tabs_field->generate_field($args);

        $args = array(
            'id'        => 'redirect_after_verify',
            'parent'        => 'user_verification_settings[messages]',
            'title'        => __('Redirect after verify text', 'user-verification'),
            'details'    => __('Add custom text redirect after verification.', 'user-verification'),
            'type'        => 'textarea',
            'value'        => $redirect_after_verify,
            'default'        => '',
        );

        $settings_tabs_field->generate_field($args);


        $args = array(
            'id'        => 'not_redirect',
            'parent'        => 'user_verification_settings[messages]',
            'title'        => __('Not redirect text', 'user-verification'),
            'details'    => __('Add custom text not redirect automatically.', 'user-verification'),
            'type'        => 'textarea',
            'value'        => $not_redirect,
            'default'        => '',
        );

        $settings_tabs_field->generate_field($args);


        $args = array(
            'id'        => 'title_checking_verification',
            'parent'        => 'user_verification_settings[messages]',
            'title'        => __('Popup title checking verification', 'user-verification'),
            'details'    => __('Show custom for "checking verification"', 'user-verification'),
            'type'        => 'textarea',
            'value'        => $title_checking_verification,
            'default'        => '',
        );

        $settings_tabs_field->generate_field($args);

        $args = array(
            'id'        => 'title_sending_verification',
            'parent'        => 'user_verification_settings[messages]',
            'title'        => __('Popup title sending verification', 'user-verification'),
            'details'    => __('Show custom for "sending verification"', 'user-verification'),
            'type'        => 'textarea',
            'value'        => $title_sending_verification,
            'default'        => '',
        );

        $settings_tabs_field->generate_field($args);


        $args = array(
            'id'        => 'captcha_error',
            'parent'        => 'user_verification_settings[messages]',
            'title'        => __('Captcha error message', 'user-verification'),
            'details'    => __('Show custom message when captcha error occurred.', 'user-verification'),
            'type'        => 'textarea',
            'value'        => $captcha_error,
            'default'        => '',

        );

        $settings_tabs_field->generate_field($args);

        $args = array(
            'id'        => 'otp_sent_success',
            'parent'        => 'user_verification_settings[messages]',
            'title'        => __('OTP sent success message', 'user-verification'),
            'details'    => __('Show custom message when OTP sent successfully.', 'user-verification'),
            'type'        => 'textarea',
            'value'        => $otp_sent_success,
            'default'        => '',

        );

        $settings_tabs_field->generate_field($args);


        $args = array(
            'id'        => 'otp_sent_error',
            'parent'        => 'user_verification_settings[messages]',
            'title'        => __('OTP error message', 'user-verification'),
            'details'    => __('Show custom message when OTP sending error occured.', 'user-verification'),
            'type'        => 'textarea',
            'value'        => $otp_sent_error,
            'default'        => '',

        );

        $settings_tabs_field->generate_field($args);


        ?>

    </div>
    <?php

    }

    add_action('user_verification_settings_content_email_verification', 'user_verification_settings_content_email_verification');