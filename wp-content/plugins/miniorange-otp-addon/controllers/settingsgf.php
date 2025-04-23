<?php

use GFOTP\Helper\MoConstants;
use GFOTP\Helper\MoUtility;
use GFOTP\Objects\PluginPageDetails;
use GFOTP\Objects\Tabs;

$page_list = admin_url() . 'edit.php?post_type=page';
$plan_type = MoUtility::micv() ? 'wp_otp_verification_upgrade_plan' : 'wp_otp_verification_basic_plan';

// $nonce = $adminHandler->getNonceValue();
$action        = add_query_arg(
	array(
		'page' => $tabDetails->_tabDetails[ Tabs::FORMS ]->_menuSlug,
		'form' => 'GravityForm#GravityForm',
	)
);
$formsListPage = add_query_arg(
	'page',
	$tabDetails->_tabDetails[ Tabs::FORMS ]->_menuSlug . '#form_search',
	remove_query_arg( array( 'form' ) )
);

$formName            = isset( $_GET['form'] ) ? sanitize_text_field( $_GET['form'] ) : false;
$showConfiguredForms = $formName == 'configured_forms';


require MOV_GF_DIR . 'views/settingsgf.php';
// include MOV_GF_DIR . 'views/forms/GravityForm.php'; // added
