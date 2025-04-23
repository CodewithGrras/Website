<?php

use GFOTP\Handler\MoRegistrationHandler;
use GFOTP\Helper\MoConstants;
use GFOTP\Helper\MoUtility;

$url = MoConstants::HOSTNAME . '/moas/login' . '?redirectUrl=' . MoConstants::HOSTNAME . '/moas/viewlicensekeys';

$handler = MoRegistrationHandler::instance();

if ( get_mo_gf_option( 'registration_status_gf' ) === 'MO_OTP_DELIVERED_SUCCESS'
		|| get_mo_gf_option( 'registration_status_gf' ) === 'MO_OTP_VALIDATION_FAILURE'
		|| get_mo_gf_option( 'registration_status_gf' ) === 'MO_OTP_DELIVERED_FAILURE' ) {
	$admin_phone = get_mo_gf_option( 'admin_phone_gf' ) ? get_mo_gf_option( 'admin_phone_gf' ) : '';
	$nonce       = $handler->getNonceValue();
	include MOV_GF_DIR . 'views/account/verify.php';
} elseif ( get_mo_gf_option( 'verify_customer' ) ) {
	$admin_email = get_mo_gf_option( 'admin_email_gf' ) ? get_mo_gf_option( 'admin_email_gf' ) : '';
	$nonce       = $handler->getNonceValue();
	include MOV_GF_DIR . 'views/account/login.php';
} elseif ( ! MoUtility::micr() ) {
	$current_user = wp_get_current_user();
	$admin_phone  = get_mo_gf_option( 'admin_phone_gf' ) ? get_mo_gf_option( 'admin_phone_gf' ) : '';
	$nonce        = $handler->getNonceValue();
	delete_site_option( 'password_mismatch_gf' );
	update_mo_gf_option( 'new_registration_gf', 'true' );
	include MOV_GF_DIR . 'views/account/register.php';
} elseif ( MoUtility::micr() && ! MoUtility::mclv() ) {
	$nonce = $handler->getNonceValue();
	include MOV_GF_DIR . 'views/account/verify-lk.php';
} else {
	$customer_id = get_mo_gf_option( 'admin_customer_key_gf' );
	$email       = get_mo_gf_option( 'admin_email_gf' );
	$api_key     = get_mo_gf_option( 'admin_api_key_gf' );
	$token       = get_mo_gf_option( 'customer_token_gf' );
	$vl          = MoUtility::mclv() && ! MoUtility::isMG();
	$nonce       = $adminHandler->getNonceValue();
	$regnonce    = $handler->getNonceValue();

	include MOV_GF_DIR . 'views/account/profile.php';
}
