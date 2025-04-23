<?php

use GFOTP\Helper\GravityFormList;
use GFOTP\Helper\FormSessionData;
use GFOTP\Helper\MoUtility;
use GFOTP\Objects\FormHandler;
use GFOTP\Objects\IFormHandler;
use GFOTP\SplClassLoaderGravityForm;


if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'MOV_GF_DIR', plugin_dir_path( __FILE__ ) );
define( 'MOV_GF_URL', plugin_dir_url( __FILE__ ) );



$response    = wp_remote_retrieve_body( wp_remote_get( MOV_GF_URL . 'package.json', array( 'sslverify' => false ) ) );
$packageData = json_decode( $response );
if ( json_last_error() !== 0 ) {
	$packageData = json_decode( initializePackageJsonGF() );
}

define( 'MOV_GF_VERSION', $packageData->version );
define( 'MOV_GF_TYPE', $packageData->type );
define( 'MOV_GF_HOST', $packageData->hostname );
define( 'MOV_PORTAL', 'https://portal.miniorange.com' );
define( 'MOV_GF_DEFAULT_CUSTOMERKEY', $packageData->dCustomerKey );
define( 'MOV_GF_DEFAULT_APIKEY', $packageData->dApiKey );
define( 'MOV_GF_SSL_VERIFY', $packageData->sslVerify );
define( 'MOV_GF_CSS_URL', MOV_GF_URL . 'includes/css/mogf_customer_validation_style.css?version=' . MOV_GF_VERSION );
define( 'MOV_GF_FORM_CSS', MOV_GF_URL . 'includes/css/mo_forms_css.min.css?version=' . MOV_GF_VERSION );
define( 'MO_GF_INTTELINPUT_CSS', MOV_GF_URL . 'includes/css/intlTelInput.min.css?version=' . MOV_GF_VERSION );
define( 'MOV_GF_JS_URL', MOV_GF_URL . 'includes/js/settings.min.js?version=' . MOV_GF_VERSION );
define( 'MOGF_VALIDATION_JS_URL', MOV_GF_URL . 'includes/js/formValidation.min.js?version=' . MOV_GF_VERSION );
define( 'MO_GF_INTTELINPUT_JS', MOV_GF_URL . 'includes/js/intlTelInput.min.js?version=' . MOV_GF_VERSION );
define( 'MO_GF_DROPDOWN_JS', MOV_GF_URL . 'includes/js/dropdown.min.js?version=' . MOV_GF_VERSION );
define( 'MOV_GF_LOADER_URL', MOV_GF_URL . 'includes/images/loader.gif' );
define( 'MOV_GF_LOGO_URL', MOV_GF_URL . 'includes/images/logo.png' );
define( 'MOV_GF_ICON', MOV_GF_URL . 'includes/images/miniorange_icon.png' );
define( 'MOV_GF_ICON_GIF', MOV_GF_URL . 'includes/images/mo_icon.gif' );
define( 'MOV_GF_USE_POLYLANG', true );
define( 'MO_GF_TEST_MODE', $packageData->testMode );
define( 'MO_GF_FAIL_MODE', $packageData->failMode );
define( 'MOV_GF_SESSION_TYPE', $packageData->session );
define( 'MOV_GF_FEATURES_GRAPHIC', MOV_GF_URL . 'includes/images/mo_features_graphic.png' );
define( 'MOV_GF_TYPE_PLAN', $packageData->typePlan );
define( 'MOV_GF_LICENSE_NAME', $packageData->licenseName );

define( 'MOV_GF_MAIN_CSS', MOV_GF_URL . 'includes/css/mogf-main.css' );

require 'SplClassLoaderGravityForm.php';

$idpClassLoader = new SplClassLoaderGravityForm( 'GFOTP', realpath( __DIR__ . DIRECTORY_SEPARATOR . '..' ) );
$idpClassLoader->register();
require_once 'views/addon-frontend.php';
// require_once 'views/forms/GravityForm.php';
initializeAddOn();

function initializeAddOn() {
	$iterator = new RecursiveIteratorIterator(
		new RecursiveDirectoryIterator( MOV_GF_DIR . 'handler/forms', RecursiveDirectoryIterator::SKIP_DOTS ),
		RecursiveIteratorIterator::LEAVES_ONLY
	);

	foreach ( $iterator as $it ) {
		$filename    = $it->getFilename();
		$className   = 'GFOTP\\Handler\\Forms\\' . str_replace( '.php', '', $filename );
		$handlerList = GravityFormList::instance();

		$formHandler = $className::instance();

		$handlerList->add( $formHandler->getFormKey(), $formHandler );
	}
}




function gf_admin_post_url() {
	return admin_url( 'admin-post.php' ); }


function gf_wp_ajax_url() {
	return admin_url( 'admin-ajax.php' ); }


function mogf_( $string ) {
	$textDomain = 'miniorange-otp-addon';
	$string     = preg_replace( '/\s+/S', ' ', $string );
	return is_scalar( $string )
			? ( MoUtility::_is_polylang_installed() && MOV_GF_USE_POLYLANG ? pll__( $string ) : __( $string, $textDomain ) )
			: $string;
}

function mo_gf_esc_string( $string, $type ) {

	if ( $type == 'attr' ) {
		return esc_attr( $string );
	} elseif ( $type == 'url' ) {
		return esc_url( $string );
	}

	return esc_attr( $string );

}


function get_mo_gf_option( $string, $prefix = null ) {
	$string = ( $prefix === null ? 'mo_customer_validation_' : $prefix ) . $string;
	return apply_filters( 'get_mo_gf_option', get_site_option( $string ) );
}


function update_mo_gf_option( $string, $value, $prefix = null ) {
	$string = ( $prefix === null ? 'mo_customer_validation_' : $prefix ) . $string;
	update_site_option( $string, apply_filters( 'update_mo_gf_option', $value, $string ) );
}


function delete_mo_gf_option( $string, $prefix = null ) {
	$string = ( $prefix === null ? 'mo_customer_validation_' : $prefix ) . $string;
	delete_site_option( $string );
}


function get_mo_gf_class( $obj ) {
	$namespaceClass = get_class( $obj );
	return substr( $namespaceClass, strrpos( $namespaceClass, '\\' ) + 1 );
}


function initializePackageJsonGF() {
			$package = json_encode(
				array(
					'name'         => 'miniorange-otp-addon',
					'version'      => '3.1.0',
					'type'         => 'MiniOrangeGateway',
					'testMode'     => false,
					'failMode'     => false,
					'hostname'     => 'https://login.xecurify.com',
					'dCustomerKey' => '16555',
					'dApiKey'      => 'fFd2XcvTGDemZvbw1bcUesNJWEqKbbUq',
					'sslVerify'    => false,
					'session'      => 'TRANSIENT',
					'typePlan'     => 'wp_otp_verification_basic_plan',
					'licenseName'  => 'WP_OTP_VERIFICATION_PLUGIN',
				)
			);
			return $package;
}
