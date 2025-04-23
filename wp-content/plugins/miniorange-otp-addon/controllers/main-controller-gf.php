<?php

use GFOTP\Handler\MoOTPActionHandlerHandlerGF;
use GFOTP\Helper\MoUtility;
use GFOTP\Objects\TabDetails;

$registered        = MoUtility::micr();
$activated         = MoUtility::mclv();
$gatewayconfigured = MoUtility::isGatewayConfig();
$plan              = MoUtility::micv();
$disabled          = ( ( $registered && $activated ) || ( strcmp( MOV_GF_TYPE, 'MiniOrangeGateway' ) === 0 ) ) ? '' : 'disabled';
$current_user      = wp_get_current_user();
$email             = get_mo_gf_option( 'admin_email_gf' );
$phone             = get_mo_gf_option( 'admin_phone' );
$controller        = MOV_GF_DIR . 'controllers/';
$adminHandler      = MoOTPActionHandlerHandlerGF::instance();


$tabDetails = TabDetails::instance();
echo '
<div id="mogf-main-outer-div">';
require $controller . 'navbargf.php';
echo '      <div class="bg-mo-primary-bg rounded-mo-smooth mo-main-content" style="width:98%; font-family: Inter, sans-serif;">
                <div id="moblock" class="mo_customer_validation-modal-backdrop dashboard">' .
					'<img src="' . esc_url( MOV_GF_LOADER_URL ) . '">' .
				'</div>';

if ( isset( $_GET['page'] ) ) {

	foreach ( $tabDetails->_tabDetails as $tabs ) {

		if ( $tabs->_menuSlug == sanitize_text_field( $_GET['page'] ) ) {
			include $controller . $tabs->_view;
			echo' </div>
</div>';
		}
	}
}

require $controller . 'support.php';



