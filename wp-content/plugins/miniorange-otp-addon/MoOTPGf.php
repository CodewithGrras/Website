<?php

namespace GFOTP;

use GFOTP\Handler\EmailVerificationLogic;
use GFOTP\Handler\FormActionHandler;
use GFOTP\Handler\MoOTPActionHandlerHandlerGF;
use GFOTP\Handler\MoRegistrationHandler;
use GFOTP\Handler\PhoneVerificationLogic;
use GFOTP\Helper\CountryList;
use GFOTP\Helper\GatewayFunctions;
use GFOTP\Helper\MenuItems;
use GFOTP\Helper\MoConstants;
use GFOTP\Helper\MoDisplayMessages;
use GFOTP\Helper\MoMessages;
use GFOTP\Helper\MoUtility;
// use GFOTP\Helper\MOVisualTour;
use GFOTP\Helper\PolyLangStrings;
use GFOTP\Helper\Templates\DefaultPopup;
use GFOTP\Helper\Templates\ErrorPopup;
use GFOTP\Helper\Templates\ExternalPopup;
use GFOTP\Helper\Templates\UserChoicePopup;
use GFOTP\Objects\PluginPageDetails;
use GFOTP\Objects\TabDetails;
use GFOTP\Objects\Tabs;
use GFOTP\Traits\Instance;
// use GFOTP\Helper\MoAddonListContent;
// use GFOTP\Helper\MoOffer;
// use GFOTP\Handler\CustomForm;
use GFOTP\Helper\MocURLOTP;
use GFOTP\Objects\BaseMessages;
use GFOTP\Helper\MoVersionUpdate;
use GFOTP\Helper\MoOTPAlphaNumeric;
use GFOTP\Helper\MoSMSBackupGateway;
use GFOTP\Helper\MoGloballyBannedPhone;
use GFOTP\Helper\MoWhatsApp;
use GFOTP\Helper\MoMasterOTP;
use GFOTP\Helper\MoReporting;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class MoOTPGf {


	use Instance;

	private function __construct() {
		$this->initializeHooks();
		$this->initializeGlobals();
		$this->initializeHelpers();
		$this->initializeHandlers();
		$this->registerPolyLangStrings();
		$this->registerAddOns();
	}


	private function initializeHooks() {
		add_action( 'plugins_loaded', array( $this, 'otp_load_textdomain' ) );
		add_action( 'admin_menu', array( $this, 'miniorange_customer_validation_menu' ) );

		if ( ! function_exists( 'is_plugin_active' ) ) {
			include_once ABSPATH . 'wp-admin/includes/plugin.php';
		}
		if ( ! is_plugin_active( 'miniorange-otp-verification/miniorange_validation_settings.php' ) ) {
		add_action( 'admin_enqueue_scripts', array( $this, 'mogf_registration_plugin_settings_style' ) );
		}
		add_action( 'admin_enqueue_scripts', array( $this, 'mogf_registration_plugin_settings_script' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'mogf_registration_plugin_frontend_scripts' ), 99 );
		add_action( 'login_enqueue_scripts', array( $this, 'mogf_registration_plugin_frontend_scripts' ), 99 );
		add_action( 'mo_registration_show_message', array( $this, 'mo_show_otp_message' ), 1, 2 );
		add_action( 'hourlySync', array( $this, 'hourlySync' ) );
		add_filter( 'wp_mail_from_name', array( $this, 'custom_wp_mail_from_name' ) );
		add_filter( 'plugin_row_meta', array( $this, 'mo_meta_links' ), 10, 2 );
		add_action( 'wp_enqueue_scripts', array( $this, 'load_jquery_on_forms' ) );
		add_action( 'admin_footer', array( $this, 'feedback_request' ) );


		//add_action( 'plugin_action_links_' . MOV_GF_ADDON_NAME, array( $this, 'plugin_action_links' ), 10, 1 );

	}


	function load_jquery_on_forms() {
		if ( ! wp_script_is( 'jquery', 'enqueued' ) ) {
			wp_enqueue_script( 'jquery' );
		}
	}


	private function initializeHelpers() {
		MoMessages::instance();
		// MoAddonListContent::instance();
		// MoOffer::instance();
		PolyLangStrings::instance();
		// MOVisualTour::instance();
		if ( file_exists( MOV_GF_DIR . 'helper/MoVersionUpdate.php' ) ) {
			MoVersionUpdate::instance();
		}
		if ( file_exists( MOV_GF_DIR . 'helper/MoOTPAlphaNumeric.php' ) ) {
			MoOTPAlphaNumeric::instance();
		}
		if ( file_exists( MOV_GF_DIR . 'helper/MoSMSBackupGateway.php' ) ) {
			MoSMSBackupGateway::instance();
		}
		if ( file_exists( MOV_GF_DIR . 'helper/MoGloballyBannedPhone.php' ) ) {
			MoGloballyBannedPhone::instance();
		}
		if ( file_exists( MOV_GF_DIR . 'helper/MoWhatsApp.php' ) ) {
			MoWhatsApp::instance();
		}
		if ( file_exists( MOV_GF_DIR . 'helper/MoMasterOTP.php' ) ) {
			MoMasterOTP::instance();
		}
		if ( file_exists( MOV_GF_DIR . 'helper/MoReporting.php' ) ) {
			MoReporting::instance();
		}
	}


	private function initializeHandlers() {
		 FormActionHandler::instance();
		MoOTPActionHandlerHandlerGF::instance();
		DefaultPopup::instance();
		ErrorPopup::instance();
		ExternalPopup::instance();
		UserChoicePopup::instance();
		MoRegistrationHandler::instance();
		// CustomForm::instance();
	}


	private function initializeGlobals() {
		global $phoneLogic,$emailLogic;
		$phoneLogic = PhoneVerificationLogic::instance();
		$emailLogic = EmailVerificationLogic::instance();
	}


	function miniorange_customer_validation_menu() {
		MenuItems::instance();
	}



	function mo_customer_validation_options() {
		 include MOV_GF_DIR . 'controllers/main-controller-gf.php';
	}



	function mogf_registration_plugin_settings_style() {
		wp_enqueue_style( 'mo_customer_validation_admin_settings_style', MOV_GF_CSS_URL );
		wp_enqueue_style( 'mo_customer_validation_inttelinput_style', MO_GF_INTTELINPUT_CSS );
		wp_enqueue_style( 'mo_main_style', MOV_GF_MAIN_CSS );
	}



	function mogf_registration_plugin_settings_script() {
		 $countryVal = array();
		wp_enqueue_script( 'mo_customer_validation_admin_settings_script', MOV_GF_JS_URL, array( 'jquery' ) );
		wp_enqueue_script( 'mo_customer_validation_form_validation_script', MOGF_VALIDATION_JS_URL, array( 'jquery' ) );
		wp_register_script( 'mo_customer_validation_inttelinput_script', MO_GF_INTTELINPUT_JS, array( 'jquery' ) );
		$countriesavail = CountryList::getCountryCodeList();
		$countriesavail = apply_filters( 'selected_countries', $countriesavail );
		foreach ( $countriesavail as $key => $value ) {
			array_push( $countryVal, $value );
		}
		wp_localize_script(
			'mo_customer_validation_inttelinput_script',
			'moselecteddropdown',
			array(
				'selecteddropdown' => $countryVal,
			)
		);
		wp_enqueue_script( 'mo_customer_validation_inttelinput_script' );
	}



	function mogf_registration_plugin_frontend_scripts() {
		$countryVal = array();
		if ( ! get_mo_gf_option( 'show_dropdown_on_form' ) ) {
			return;
		}
		$selector = apply_filters( 'mo_phone_dropdown_selector', array() );
		if ( MoUtility::isBlank( $selector ) ) {
			return;
		}
		$selector       = array_unique( $selector );
		$countriesavail = CountryList::getCountryCodeList();
		$countriesavail = apply_filters( 'selected_countries', $countriesavail );
		foreach ( $countriesavail as $key => $value ) {
			array_push( $countryVal, $value );
		}
		$defaultCountry = CountryList::getDefaultCountryIsoCode();
		$getIpcountry   = apply_filters( 'mo_get_default_country', $defaultCountry );
		wp_register_script( 'mo_customer_validation_inttelinput_script', MO_GF_INTTELINPUT_JS, array( 'jquery' ) );
		wp_localize_script(
			'mo_customer_validation_inttelinput_script',
			'moselecteddropdown',
			array(
				'selecteddropdown' => $countryVal,

			)
		);
		wp_enqueue_script( 'mo_customer_validation_inttelinput_script' );

		wp_enqueue_style( 'mo_customer_validation_inttelinput_style', MO_GF_INTTELINPUT_CSS );
		wp_register_script( 'mo_customer_validation_dropdown_script', MO_GF_DROPDOWN_JS, array( 'jquery' ), MOV_GF_VERSION, true );
		wp_localize_script(
			'mo_customer_validation_dropdown_script',
			'modropdownvars',
			array(
				'selector'       => json_encode( $selector ),
				'defaultCountry' => $getIpcountry,
				'onlyCountries'  => CountryList::getOnlyCountryList(),
			)
		);
		wp_enqueue_script( 'mo_customer_validation_dropdown_script' );
	}



	function mo_show_otp_message( $content, $type ) {
		new MoDisplayMessages( $content, $type );
	}



	function otp_load_textdomain() {
		// load_plugin_textdomain( 'miniorange-otp-verification', FALSE, dirname( plugin_basename(__FILE__) ) . '/lang/' );
		// do_action('mo_otp_verification_add_on_lang_files');
	}



	private function registerPolylangStrings() {
		if ( ! MoUtility::_is_polylang_installed() ) {
			return;
		}
		foreach ( unserialize( MO_GF_POLY_STRINGS ) as $key => $value ) {
			pll_register_string( $key, $value, 'miniorange-otp-addon' );
		}
	}



	private function registerAddOns() {

		$gateway = GatewayFunctions::instance();
		$gateway->registerAddOns();
	}



	function feedback_request() {
		include MOV_GF_DIR . 'controllers/feedback.php';
	}



	function mo_meta_links( $meta_fields, $file ) {
		if ( MOV_GF_ADDON_NAME === $file ) {
			$meta_fields[] = "<span class='dashicons dashicons-sticky'></span>
            <a href='" . MoConstants::FAQ_URL . "' target='_blank'>" . mogf_( 'FAQs' ) . '</a>';
		}
		return $meta_fields;
	}



	function plugin_action_links( $links ) {

		$tabDetails = TabDetails::instance();

		$formSettingsTab = $tabDetails->_tabDetails[ Tabs::FORMS ];
		if ( is_plugin_active( MOV_GF_ADDON_NAME ) ) {
			$links = array_merge(
				array(
					'<a href="' . esc_url( admin_url( 'admin.php?page=' . $formSettingsTab->_menuSlug ) ) . '">' .
						mogf_( 'Settings' )
					. '</a>',
				),
				$links
			);
		}
		return $links;
	}


	function hourlySync() {
		$gateway = GatewayFunctions::instance();
		$gateway->hourlySync();
	}


	function custom_wp_mail_from_name( $original_email_from ) {

		$gateway = GatewayFunctions::instance();
		return $gateway->custom_wp_mail_from_name( $original_email_from );
	}
}
