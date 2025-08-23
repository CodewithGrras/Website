<?php
/**
 * Plugin Name: QSM - Advanced Question Types
 * Plugin URI: https://quizandsurveymaster.com
 * Description: Advance Question Type for your surveys and quizzes
 * Author: QSM Team
 * Author URI: https://quizandsurveymaster.com
 * Version: 1.4.1
 * Text Domain: qsm-advance-question
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * This class is the main class of the plugin
 *
 * When loaded, it loads the included plugin files and add functions to hooks or filters. The class also handles the admin menu
 *
 * @since 1.0.0
 */
class QSM_Advance_Question {

	/**
	 * Version Number
	 *
	 * @var string
	 * @since 1.0.0
	 */
	public $version = '1.4.1';

	/**
	 * Main Construct Function
	 *
	 * Call functions within class
	 *
	 * @since 1.0.0
	 * @uses QSM_Advance_Question::load_dependencies() Loads required filed
	 * @uses QSM_Advance_Question::add_hooks() Adds actions to hooks and filters
	 * @return void
	 */
	public function __construct() {
		define( 'QSM_ADVANCE_QUESTION_ADDON_VERSION', $this->version );
		define( 'QSM_ADVANCE_QUESTION_ADDON_DIR', plugin_dir_path( __FILE__ ) );
		define( 'QSM_ADVANCE_QUESTION_ADDON_URL', plugin_dir_url( __FILE__ ) );
		define( 'QSM_ADVANCE_QUESTION_ADDON_CSS_URL', QSM_ADVANCE_QUESTION_ADDON_URL . 'css' );
		define( 'QSM_ADVANCE_QUESTION_ADDON_JS_URL', QSM_ADVANCE_QUESTION_ADDON_URL . 'js' );
		define( 'QSM_ADVANCE_QUESTION_ADDON_PHP_DIR', QSM_ADVANCE_QUESTION_ADDON_DIR . 'php' );
		define( 'QSM_ADVANCE_QUESTION_ADDON_TXTDOMAIN', 'qsm-advance-question' );
		define( 'QSM_ADVANCE_QUESTION_ITEM', 429053 );
		$this->load_dependencies();
		$this->add_hooks();
		$this->check_license();
	}

	/**
	 * Load File Dependencies
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function load_dependencies() {
		include_once QSM_ADVANCE_QUESTION_ADDON_PHP_DIR . '/license.php';
		include_once QSM_ADVANCE_QUESTION_ADDON_PHP_DIR . '/functions.php';
		include_once QSM_ADVANCE_QUESTION_ADDON_PHP_DIR . '/question-types.php';
		include_once QSM_ADVANCE_QUESTION_ADDON_PHP_DIR . '/qsm-addon-settings.php';
		include_once QSM_ADVANCE_QUESTION_ADDON_PHP_DIR . '/class-qsm-advance-question-review-choice.php';
	}

	/**
	 * Add Hooks
	 *
	 * Adds functions to relavent hooks and filters
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function add_hooks() {
		add_action( 'admin_init', 'qsm_addon_advance_question_register_addon_settings_tabs' );
		add_action( 'admin_init', 'qsm_addon_advance_question_textdomain' );
		add_action( 'wp_ajax_qsm_advance_question_type_validate_license', 'qsm_advance_question_type_validate_license' );
	}

	/**
	 * Checks license
	 *
	 * Checks to see if license is active and, if so, checks for updates
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function check_license() {

		if ( ! class_exists( 'EDD_SL_Plugin_Updater' ) ) {
			// load our custom updater.
			include 'php/EDD_SL_Plugin_Updater.php';
		}

		// Retrieve our license key from the DB.
		$settings    = get_option( 'qsm_addon_advance_question_settings', '' );
		$license_key = isset( $settings['license_key'] ) ? trim( $settings['license_key'] ) : '';

		// Setup the updater.
		$edd_updater = new EDD_SL_Plugin_Updater(
			'https://quizandsurveymaster.com', __FILE__, array(
				'version'   => $this->version,
				'license'   => $license_key,
				'item_name' => 'Advanced Question Types',
				'author'    => 'QSM Team',
			)
		);
	}
}

/**
 * Check if QSM is installed and activated
 *
 * @since 1.0.0
 */
function qsm_addon_customization_advance_question_load() {
	if ( class_exists( 'MLWQuizMasterNext' ) ) {
		$qsm_advance_question = new QSM_Advance_Question();
		/**
		 * Load Translation Support
		 */
		load_plugin_textdomain( QSM_ADVANCE_QUESTION_ADDON_TXTDOMAIN, false, dirname( plugin_basename( __FILE__ ) ) . '/lang/' );
	} else {
		add_action( 'admin_notices', 'qsm_addon_customization_advance_question_missing_qsm' );
	}
}

add_action( 'plugins_loaded', 'qsm_addon_customization_advance_question_load' );

/**
 * Display notice if Quiz And Survey Master isn't installed
 *
 * @since 1.0.0
 */
function qsm_addon_customization_advance_question_missing_qsm() {
	echo '<div class="error"><p>' . esc_html__( 'QSM - Advance Question Type requires Quiz And Survey Master. Please install and activate the Quiz And Survey Master plugin.', 'qsm-advance-question' ) . '</p></div>';
}

/**
 * Adds translation support
 *
 * @since 1.1.2
 */
function qsm_addon_advance_question_textdomain() {
	load_plugin_textdomain( 'qsm-advance-question', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
}

function qsm_advance_question_type_validate_license() {
	global $mlwQuizMasterNext;
	$post_license = isset( $_POST['input'] ) ? sanitize_text_field( wp_unslash( $_POST['input'] ) ) : '';
	$update_status = isset( $_POST['update_status'] ) ? sanitize_text_field( wp_unslash( $_POST['update_status'] ) ) : '';
	if ( "" != $post_license ) {

		$settings    = get_option( 'qsm_addon_advance_question_settings', array() );
		$license     = isset( $settings['license_key'] ) ? trim( $settings['license_key'] ) : '';

		if ( class_exists ( 'QSM_Check_License' ) ) {
			$activation = $mlwQuizMasterNext->check_license->activate( $post_license, 'Advanced Question Types' );
		}else {
			$activation = QSM_license::activate( $post_license, 'Advanced Question Types' );
		}

		if ( ! empty($activation) && ( ( __( 'Attempting to activate a bundle\'s parent license', 'qsm-advance-question' ) == $activation['message'] || __( 'License key revoked', 'qsm-advance-question' ) == $activation['message'] || __( 'No activations left', 'qsm-advance-question' ) == $activation['message'] || __( 'License has expired', 'qsm-advance-question' ) == $activation['message'] ) || 'success' == $activation['status'] ) ) {
			$item_url = 'https://quizandsurveymaster.com/checkout/?edd_license_key='.$license.'&download_id='.QSM_ADVANCE_QUESTION_ITEM;
			$settings['license_key'] = $post_license;
			$settings['license_status'] = 'valid';
			$settings['last_validate'] = date("d-m-Y", time());
			$settings['expiry_date'] = isset($activation['expiry_date']) ? $activation['expiry_date'] : "";
			if ( 'success' == $activation['status'] ) {
				$validate = 1;
				$message = __( 'License validated Successfully', 'qsm-advance-question' );
			}elseif ( __( 'License has expired', 'qsm-advance-question' ) == $activation['message'] ) {
				$validate = 2;
				$message = __('License Key Expired. ', 'qsm-advance-question');
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
			$deactivation = QSM_license::deactivate( $license, 'Advanced Question Types' );
		}
		if ( ! empty( $update_status ) && 'yes' === $update_status ) {
			$keys_to_exclude    = [ 'license_key', 'license_status', 'last_validate', 'expiry_date' ];
			$prev_settings      = array_diff_key($settings, array_flip($keys_to_exclude));
			$settings           = array_merge( $settings, $prev_settings );
		}
		update_option( 'qsm_addon_advance_question_settings', $settings );
		echo wp_json_encode(array(
			'validate' => $validate,
			'message'  => $message,
		));
		wp_die();
	}
}
