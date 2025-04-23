<?php

use GFOTP\Helper\MoConstants;
use GFOTP\Helper\MoMessages;
use GFOTP\Objects\Tabs;
use GFOTP\Helper\MoUtility;

$request_uri   = remove_query_arg( array( 'addon', 'form', 'subpage' ), $_SERVER['REQUEST_URI'] );
$profile_url   = add_query_arg( array( 'page' => $tabDetails->_tabDetails[ Tabs::ACCOUNT ]->_menuSlug ), $request_uri );
$help_url      = MoConstants::FAQ_URL;
$registerMsg   = MoMessages::showMessage( MoMessages::REGISTER_WITH_US, array( 'url' => $profile_url ) );
$activationMsg = MoMessages::showMessage( MoMessages::ACTIVATE_PLUGIN, array( 'url' => $profile_url ) );
$active_tab          = sanitize_text_field( $_GET['page'] );
$nonce               = $adminHandler->getNonceValue();
$is_logged_in          = MoUtility::micr();
$remaining_email     = get_mo_gf_option( 'email_transactions_remaining' );
$remaining_sms       = get_mo_gf_option( 'phone_transactions_remaining' );
$remaining_total_txn = $remaining_email + $remaining_sms;
$active_class        = $remaining_total_txn < 15 ? 'mo-active-notice-bar' : '';
$is_free_plugin        = strcmp( MOV_GF_TYPE, 'MiniOrangeGateway' ) === 0;
$pricing_url         = MOV_PORTAL . '/moas/login?redirectUrl=' . MOV_PORTAL . '/moas/initializepayment&amp;requestOrigin=wp_otp_verification_basic_plan';
//TO DO: Custom Gateway Integration
// $gatewayMsg     = MoMessages::showMessage(MoMessages::CONFIG_GATEWAY,[ "url"=> $gateway_url ]);

require MOV_GF_DIR . 'views/navbargf.php';
