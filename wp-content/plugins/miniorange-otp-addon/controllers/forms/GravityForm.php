<?php

use GFOTP\Handler\Forms\GravityForm;

$handler          = GravityForm::instance();
$gf_addon_enabled = $handler->isFormEnabled() ? 'checked' : '';

$gf_addon_enabled_type     = $handler->getOtpTypeEnabled();
$gf_field_list             = admin_url() . 'admin.php?page=gf_edit_forms';
$gf_addon_otp_enabled      = $handler->getFormDetails();
$gf_type_email             = $handler->getEmailHTMLTag();
$gf_type_phone             = $handler->getPhoneHTMLTag();
$form_name                 = $handler->getFormName();
$gf_addon_button_text      = $handler->getButtonText();
$mogf_notif_template       = get_mo_gf_option( 'mogf_sms_template' ) ? get_mo_gf_option( 'mogf_sms_template' ) : '';
$mogf_admin_notif_template = get_mo_gf_option( 'mogf_admin_sms_template' ) ? get_mo_gf_option( 'mogf_admin_sms_template' ) : '';
$admin_phone_numbers       = $handler->getAdminPhoneNumber();

$mogf_customer_sms_notif_enable = $handler->iscustomerNotifEnabled() ? 'checked' : '';
$mogf_admin_sms_notif_enable    = $handler->isadminNotifEnabled() ? 'checked' : '';


get_plugin_form_link_gf( $handler->getFormDocuments() );

require MOV_GF_DIR . 'views/forms/GravityForm.php';
