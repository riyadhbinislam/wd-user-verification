<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

function user_verification_settings_content_email_templates(){
    error_log("Rendering Email Templeats settings content");

    $settings_tabs_field = new WD_Setting_Tabs();

    $class_user_verification_emails = new WD_Email();
    $templates_data_default = $class_user_verification_emails->email_templates_data();
    $email_templates_parameters = $class_user_verification_emails->email_templates_parameters();


    $user_verification_settings = get_option('user_verification_settings');


    $logo_id = isset($user_verification_settings['logo_id']) ? $user_verification_settings['logo_id'] : '';
    $mail_wpautop = isset($user_verification_settings['mail_wpautop']) ? $user_verification_settings['mail_wpautop'] : 'yes';

    $templates_data_saved =  $templates_data_default;
    // $templates_data_saved = isset($user_verification_settings['email_templates_data']) ? $user_verification_settings['email_templates_data'] : $templates_data_default;



?>
    <div class="section">
        <div class="section-title"><?php echo __('Email settings', 'user-verification'); ?></div>
        <p class="description section-description"><?php echo __('Customize email settings.', 'user-verification'); ?></p>

        <?php

        $args = array(
            'id'        => 'logo_id',
            'parent'        => 'user_verification_settings',
            'title'        => __('Email logo', 'user-verification'),
            'details'    => __('Email logo URL to display on mail.', 'user-verification'),
            'type'        => 'media',
            'value'        => $logo_id,
            'default'        => '',
            'placeholder'        => '',
        );

        $settings_tabs_field->generate_field($args);


        $args = array(
            'id'        => 'mail_wpautop',
            'parent'        => 'user_verification_settings',
            'title'        => __('Enable WPAutoP for emails', 'user-verification'),
            'details'    => __('Enable WPautoP for email templates body text.', 'user-verification'),
            'type'        => 'select',
            'value'        => $mail_wpautop,
            'default'        => 'yes',
            'args'        => array('yes' => __('Yes', 'user-verification'), 'no' => __('No', 'user-verification')),
        );

        $settings_tabs_field->generate_field($args);

        ob_start();


        ?>
        <div class="templates_editor expandable">
            <?php




            if (!empty($templates_data_default))
                foreach ($templates_data_default as $key => $templates) {

                    $templates_data_display = isset($templates_data_saved[$key]) ? $templates_data_saved[$key] : $templates;


                    $email_bcc = isset($templates_data_display['email_bcc']) ? $templates_data_display['email_bcc'] : '';
                    $email_from = isset($templates_data_display['email_from']) ? $templates_data_display['email_from'] : '';
                    $email_from_name = isset($templates_data_display['email_from_name']) ? $templates_data_display['email_from_name'] : '';
                    $reply_to = isset($templates_data_display['reply_to']) ? $templates_data_display['reply_to'] : '';
                    $reply_to_name = isset($templates_data_display['reply_to_name']) ? $templates_data_display['reply_to_name'] : '';
                    $email_subject = isset($templates_data_display['subject']) ? $templates_data_display['subject'] : '';

                    $email_body = isset($templates_data_display['html']) ? $templates_data_display['html'] : '';


                    $enable = isset($templates_data_display['enable']) ? $templates_data_display['enable'] : 'yes';
                    $description = isset($templates_data_display['description']) ? $templates_data_display['description'] : '';

                    $parameters = isset($email_templates_parameters[$key]) ? $email_templates_parameters[$key] : array();



            ?>
                <div class="item template <?php echo esc_attr($key); ?>">
                    <div class="header">
                        <span title="<?php echo __('Click to expand', 'user-verification'); ?>" class="expand-icon ">
                            <i class="fa fa-expand"></i>
                            <i class="fa fa-compress"></i>
                        </span>

                        <?php
                        if ($enable == 'yes') :
                        ?>
                            <span title="<?php echo __('Enable', 'user-verification'); ?>" class="is-enable ">
                                <i class="fa fa-check-square"></i>
                            </span>
                        <?php
                        else :
                        ?>
                            <span title="<?php echo __('Disabled', 'user-verification'); ?>" class="is-enable ">
                                <i class="fa fa-times-circle"></i>
                            </span>
                        <?php
                        endif;
                        ?>
                        <span class="expand"><?php echo esc_html($templates['name']); ?></span>

                    </div>
                    <input type="hidden" name="user_verification_settings[email_templates_data][<?php echo esc_attr($key); ?>][name]" value="<?php echo esc_attr($templates['name']); ?>" />
                    <div class="options">
                        <div class="description"><?php echo esc_html($description); ?></div><br /><br />



                        <?php


                        $args = array(
                            'id'        => 'enable',
                            'parent'        => 'user_verification_settings[email_templates_data][' . $key . ']',
                            'title'        => __('Enable?', 'user-verification'),
                            'details'    => __('Enable or disable this email notification.', 'user-verification'),
                            'type'        => 'select',
                            'value'        => $enable,
                            'default'        => 'yes',
                            'args'        => array('yes' => __('Yes', 'user-verification'), 'no' => __('No', 'user-verification')),

                        );

                        $settings_tabs_field->generate_field($args);






                        $args = array(
                            'id'        => 'email_bcc',
                            'parent'        => 'user_verification_settings[email_templates_data][' . $key . ']',
                            'title'        => __('Email Bcc', 'user-verification'),
                            'details'    => __('Send a copy to these email(Bcc)', 'user-verification'),
                            'type'        => 'text',
                            'value'        => $email_bcc,
                            'default'        => '',
                            'placeholder'        => get_bloginfo('admin_email'),


                        );

                        $settings_tabs_field->generate_field($args);


                        $args = array(
                            'id'        => 'email_from_name',
                            'parent'        => 'user_verification_settings[email_templates_data][' . $key . ']',
                            'title'        => __('Email from name', 'user-verification'),
                            'details'    => __('Write email displaying from name', 'user-verification'),
                            'type'        => 'text',
                            'value'        => $email_from_name,
                            'default'        => '',
                            'placeholder'        => get_bloginfo('title'),


                        );

                        $settings_tabs_field->generate_field($args);



                        $args = array(
                            'id'        => 'email_from',
                            'parent'        => 'user_verification_settings[email_templates_data][' . $key . ']',
                            'title'        => __('Email from', 'user-verification'),
                            'details'    => __('Email from email address', 'user-verification'),
                            'type'        => 'text',
                            'value'        => $email_from,
                            'default'        => '',
                            'placeholder'        => get_bloginfo('admin_email'),


                        );

                        $settings_tabs_field->generate_field($args);

                        $args = array(
                            'id'        => 'reply_to_name',
                            'parent'        => 'user_verification_settings[email_templates_data][' . $key . ']',
                            'title'        => __('Reply to name', 'user-verification'),
                            'details'    => __('Email reply to name', 'user-verification'),
                            'type'        => 'text',
                            'value'        => $reply_to_name,
                            'default'        => '',
                            'placeholder'        => get_bloginfo('title'),


                        );

                        $settings_tabs_field->generate_field($args);


                        $args = array(
                            'id'        => 'reply_to',
                            'parent'        => 'user_verification_settings[email_templates_data][' . $key . ']',
                            'title'        => __('Reply to', 'user-verification'),
                            'details'    => __('Reply to email address', 'user-verification'),
                            'type'        => 'text',
                            'value'        => $reply_to,
                            'default'        => '',
                            'placeholder'        => get_bloginfo('admin_email'),


                        );

                        $settings_tabs_field->generate_field($args);



                        $args = array(
                            'id'        => 'subject',
                            'parent'        => 'user_verification_settings[email_templates_data][' . $key . ']',
                            'title'        => __('Email subject', 'user-verification'),
                            'details'    => __('Write email subjects', 'user-verification'),
                            'type'        => 'text',
                            'value'        => wp_specialchars_decode($email_subject, ENT_QUOTES),
                            'default'        => '',
                            'placeholder'        => '',


                        );

                        $settings_tabs_field->generate_field($args);

                        $args = array(
                            'id'        => 'html',
                            'css_id'        => $key,
                            'parent'        => 'user_verification_settings[email_templates_data][' . $key . ']',
                            'title'        => __('Email body', 'user-verification'),
                            'details'    => __('Write email body', 'user-verification'),
                            'type'        => 'wp_editor',

                            'value'        => wp_specialchars_decode($email_body, ENT_QUOTES),

                            'default'        => '',
                            'placeholder'        => '',


                        );

                        $settings_tabs_field->generate_field($args);

                        ob_start();
                        ?>
                        <ul>


                            <?php

                            if (!empty($parameters)) :
                                foreach ($parameters as $parameterId => $parameter) :
                            ?>
                                    <li><code><?php echo esc_html($parameterId); ?></code> => <?php echo esc_html($parameter); ?></li>
                            <?php
                                endforeach;
                            endif;
                            ?>
                        </ul>
                        <?php


                        $custom_html = ob_get_clean();

                        $args = array(
                            'id'        => 'html',
                            //                                    'parent'		=> 'user_verification_settings[email_templates_data]['.$key.']',
                            'title'        => __('Parameter', 'user-verification'),
                            'details'    => __('Available parameter for this email template', 'user-verification'),
                            'type'        => 'custom_html',
                            'html'        => $custom_html,
                            'default'        => '',


                        );

                        $settings_tabs_field->generate_field($args);

                        ?>


                    </div>

                </div>
            <?php

                }


            ?>


        </div>
        <?php


        $html = ob_get_clean();




        $args = array(
            'id'        => 'email_templates',
            //'parent'		=> '',
            'title'        => __('Email templates', 'user-verification'),
            'details'    => __('Customize email templates.', 'user-verification'),
            'type'        => 'custom_html',
            //'multiple'		=> true,
            'html'        => $html,
        );

        $settings_tabs_field->generate_field($args);




        ?>


    </div>
<?php


}

add_action('user_verification_settings_content_email_templates', 'user_verification_settings_content_email_templates');