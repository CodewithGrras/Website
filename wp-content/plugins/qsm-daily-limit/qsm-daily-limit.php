<?php
/**
 * Plugin Name: QSM - Daily Limit
 * Plugin URI: https://quizandsurveymaster.com
 * Description: This addon adds a daily limit to your quiz or survey
 * Author: QSM Team
 * Author URI: https://quizandsurveymaster.com
 * Version: 1.2.0
 * Text Domain: qsm-daily-limit
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * This class is the main class of the plugin
 *
 * When loaded, it loads the included plugin files and add functions to hooks or filters. The class also handles the admin menu
 *
 * @since 1.1.1
 */
class QSM_Daily_Limit {

	/**
	 * Version Number
	 *
	 * @var string
	 * @since 1.1.1
	 */
	public $version = '1.2.0';

	/**
	 * Main Construct Function
	 *
	 * Call functions within class
	 *
	 * @since 1.1.1
	 * @uses QSM_Daily_Limit::load_dependencies() Loads required filed
	 * @uses QSM_Daily_Limit::add_hooks() Adds actions to hooks and filters
	 * @return void
	 */
	function __construct() {
		$this->load_dependencies();
		$this->add_hooks();
		$this->check_license();
		define( 'QSM_DAILY_LIMIT_VERSION', $this->version );
		define( 'QSM_DAILY_LIMIT_ITEM', 1732 );
		define( 'QSM_DAILY_LIMIT_ADDON_URL', plugin_dir_url( __FILE__ ) );
	}

	/**
	 * Load File Dependencies
	 *
	 * @since 1.1.0
	 * @return void
	 */
	public function load_dependencies() {
		include 'php/license.php';
		include "php/addon-settings-tab-content.php";
		include "php/quiz-settings-tab-content.php";
		include "php/limit.php";
	}

	/**
	 * Add Hooks
	 *
	 * Adds functions to relavent hooks and filters
	 *
	 * @since 1.1.0
	 * @return void
	 * @todo If you are not setting up the addon settings tab, the quiz settings tab, or variables, simply remove the relevant add_action below
	 */
	public function add_hooks() {
		add_action( 'admin_init', 'qsm_addon_daily_limit_register_quiz_settings_tabs' );
		add_action( 'admin_init', 'qsm_addon_daily_limit_register_addon_settings_tabs' );
		add_filter( 'qmn_begin_shortcode', 'qsm_addon_daily_limit_begin_shortcode', 10, 3 );
		add_filter( 'qmn_begin_results', 'qsm_addon_daily_limit_begin_results', 10, 3 );
		add_action( 'wp_ajax_qsm_daily_limit_validate_license', 'qsm_daily_limit_validate_license' );
	}

	/**
	 * Checks license
	 *
	 * Checks to see if license is active and, if so, checks for updates
	 *
	 * @since 1.1.0
	 * @return void
	 */
	public function check_license() {
		if ( ! class_exists( 'EDD_SL_Plugin_Updater' ) ) {
			// load our custom updater
			include( 'php/EDD_SL_Plugin_Updater.php' );
		}
		/**
		 * Retrieve license key from the DB
		 */
		$settings    = get_option( 'qsm_addon_daily_limit_settings', '' );
		$license_key = isset( $settings['license_key'] ) ? trim( $settings['license_key'] ) : '';
		/**
		 * Setup The Updater
		 */
		$edd_updater = new EDD_SL_Plugin_Updater( 'https://quizandsurveymaster.com', __FILE__, array(
			'version'   => $this->version,
			'license'   => $license_key,
			'item_name' => 'Daily Limit',
			'author'    => 'Frank Corso',
		)
		);
	}

}

/**
 * Loads the addon if QSM is installed and activated
 *
 * @since 1.1.0
 * @return void
 */
function qsm_addon_daily_limit_load() {
	// Make sure QSM is active
	if ( class_exists( 'MLWQuizMasterNext' ) ) {
		$qsm_daily_limit = new QSM_Daily_Limit();
		load_plugin_textdomain( 'qsm-daily-limit', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
	} else {
		add_action( 'admin_notices', 'qsm_addon_daily_limit_missing_qsm' );
	}
}

add_action( 'plugins_loaded', 'qsm_addon_daily_limit_load' );

/**
 * Display notice if Quiz And Survey Master isn't installed
 *
 * @since       1.1.0
 * @return      string The notice to display
 */
function qsm_addon_daily_limit_missing_qsm() {
	echo '<div class="error"><p>QSM - Daily Limit requires Quiz And Survey Master. Please install and activate the Quiz And Survey Master plugin.</p></div>';
}

function qsm_daily_limit_validate_license() {
	global $mlwQuizMasterNext;
	$post_license   = isset( $_POST['input'] ) ? sanitize_text_field( wp_unslash( $_POST['input'] ) ) : '';
	$update_status  = isset( $_POST['update_status'] ) ? sanitize_text_field( wp_unslash( $_POST['update_status'] ) ) : '';
	if ( "" != $post_license ) {

		$settings    = get_option( 'qsm_addon_daily_limit_settings', array() );
		$license     = isset( $settings['license_key'] ) ? trim( $settings['license_key'] ) : '';

		if ( class_exists ( 'QSM_Check_License' ) ) {
			$activation = $mlwQuizMasterNext->check_license->activate( $post_license, 'Daily Limit' );
		}else {
			$activation = QSM_license::activate( $post_license, 'Daily Limit' );
		}

		if ( ! empty($activation) && ( ( __( 'Attempting to activate a bundle\'s parent license', 'quiz-master-next' ) == $activation['message'] || __( 'License key revoked', 'quiz-master-next' ) == $activation['message'] || __( 'No activations left', 'quiz-master-next' ) == $activation['message'] || __( 'License has expired', 'quiz-master-next' ) == $activation['message'] ) || 'success' == $activation['status'] ) ) {
			$item_url = 'https://quizandsurveymaster.com/checkout/?edd_license_key='.$license.'&download_id='.QSM_DAILY_LIMIT_ITEM;
			$settings['license_key'] = $post_license;
			$settings['license_status'] = 'valid';
			$settings['last_validate'] = date("d-m-Y", time());
			$settings['expiry_date'] = isset($activation['expiry_date']) ? $activation['expiry_date'] : "";
			if ( 'success' == $activation['status'] ) {
				$validate = 1;
				$message = __( 'License validated Successfully', 'qsm-daily-limit' );
			}elseif ( __( 'License has expired', 'qsm-daily-limit' ) == $activation['message'] ) {
				$validate = 2;
				$message = __('License Key Expired. ', 'qsm-daily-limit');
			}else {
				$validate = 0;
				$message = $activation['message'];
			}
		} else {
			$validate = 0;
			$settings['license_key'] = '';
			$settings['license_status'] = '';
			$settings['last_validate'] = 'invalid';
			$settings['expiry_date'] = '';
			$message = $activation['message'];
		}
		// If same license key was entered.
		if ( $license != $post_license ) {
			$deactivation = QSM_license::deactivate( $license, 'Daily Limit' );
		}
		if ( ! empty( $update_status ) && 'yes' === $update_status ) {
			$keys_to_exclude    = [ 'license_key', 'license_status', 'last_validate', 'expiry_date' ];
			$prev_settings      = array_diff_key($settings, array_flip($keys_to_exclude));
			$settings           = array_merge( $settings, $prev_settings );
		}
		update_option( 'qsm_addon_daily_limit_settings', $settings );
		echo wp_json_encode(array(
			'validate' => $validate,
			'message'  => $message,
		));
		wp_die();
	}
}