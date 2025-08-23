<?php
/**
 * Plugin Name: QSM - Extra Template Variables
 * Plugin URI: https://quizandsurveymaster.com
 * Description: Adds several new template variables to be used in your quizzes and surveys
 * Author: QSM Team
 * Author URI: https://quizandsurveymaster.com
 * Version: 1.4.0
 * Text Domain: qsm-extra-variables
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * This class is the main class of the plugin
 *
 * When loaded, it loads the included plugin files and add functions to hooks or filters. The class also handles the admin menu
 *
 * @since 1.1.0
 */
class QSM_Extra_Variables {

	/**
	 * Version Number
	 *
	 * @var string
	 * @since 1.1.0
	 */
	public $version = '1.4.0';

	/**
	 * Main Construct Function
	 *
	 * Call functions within class
	 *
	 * @since 1.1.0
	 * @uses QSM_Extra_Variables::load_dependencies() Loads required filed
	 * @uses QSM_Extra_Variables::add_hooks() Adds actions to hooks and filters
	 * @return void
	 */
	function __construct() {
		$this->load_dependencies();
		$this->add_hooks();
		$this->check_license();
	}

	/**
	 * Load File Dependencies
	 *
	 * @since 1.1.0
	 * @return void
	 */
	public function load_dependencies() {
		include 'php/license.php';
		include 'php/addon-settings-tab-content.php';
		include 'php/variables.php';
		define( 'QSM_EXTRA_VARIABLES_ADDON_URL', plugin_dir_url( __FILE__ ) );
		define( 'QSM_EXTRA_VARIABLES_VERSION', $this->version );
		define( 'QSM_EXTRA_VARIABLES_ITEM', 1893 );
	}

	/**
	 * Add Hooks
	 *
	 * Adds functions to relavent hooks and filters
	 *
	 * @since 1.1.0
	 * @return void
	 */
	public function add_hooks() {
		add_action( 'admin_init', 'qsm_addon_extra_variables_register_addon_settings_tabs' );
		add_action( 'qmn_template_variable_list', 'qsm_addon_extra_variables_display_variables' );
		add_filter( 'qsm_text_variable_list', 'qsm_addon_extra_variables_display_variables_popup', 10, 1 );
		add_filter( 'mlw_qmn_template_variable_results_page', 'qsm_addon_extra_variables_group_by_answer', 10, 2 );
		add_filter( 'mlw_qmn_template_variable_results_page', 'qsm_addon_extra_variables_incorrect_answers', 10, 2 );
		add_filter( 'mlw_qmn_template_variable_results_page', 'qsm_addon_extra_variables_correct_answers', 10, 2 );
		add_filter( 'mlw_qmn_template_variable_results_page', 'qsm_addon_extra_variables_custom_message_points', 10, 2 );
		add_filter( 'mlw_qmn_template_variable_results_page', 'qsm_addon_extra_variables_custom_message_correct', 10, 2 );
		add_filter( 'mlw_qmn_template_variable_results_page', 'qsm_addon_extra_variables_quiz_percentage', 10, 2 );
		add_filter( 'mlw_qmn_template_variable_results_page', 'qsm_addon_extra_variables_quiz_category_percentage', 10, 2 );
		add_filter( 'mlw_qmn_template_variable_results_page', 'qsm_addon_extra_variables_custom_question_point', 10, 2 );
		add_filter( 'mlw_qmn_template_variable_results_page', 'qsm_addon_extra_variables_total_time', 10, 2 );
		add_filter( 'mlw_qmn_template_variable_results_page', 'qsm_addon_extra_variable_total_unattempted_questions', 10, 2 );
		add_filter( 'mlw_qmn_template_variable_results_page', 'qsm_addon_extra_variable_display_result_date', 10, 2 );
		add_filter( 'mlw_qmn_template_variable_results_page', 'qsm_addon_extra_variable_question_answers', 10, 2 );
		add_filter( 'mlw_qmn_template_variable_results_page', 'qsm_addon_extra_variable_display_quiz_retake_button', 10, 2 );
		add_filter( 'mlw_qmn_template_variable_results_page', 'qsm_addon_extra_variable_display_remaining_attempts', 10, 2 );
		add_filter( 'mlw_qmn_template_variable_results_page', 'qsm_addon_extra_variables_quiz_category_max_points', 10, 2 );
		add_filter( 'mlw_qmn_template_variable_results_page', 'qsm_addon_extra_variables_quiz_category_percentage_points', 10, 2 );
		add_filter( 'mlw_qmn_template_variable_quiz_page', 'qsm_addon_extra_variables_total_time', 10, 2 );
		add_filter( 'qsm_register_settings_before', 'qsm_addon_extra_variables_add_total_time', 10, 1 );
		add_action( 'wp_ajax_qsm_extra_variables_validate_license', 'qsm_extra_variables_validate_license' );
	}

	/**
	 * Checks license
	 *
	 * Checks to see if license is active and, if so, checks for updates
	 *
	 * @since 1.3.0
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
		$settings    = get_option( 'qsm_addon_extra_variables_settings', '' );
		$license_key = isset( $settings['license_key'] ) ? trim( $settings['license_key'] ) : '';
		/**
		 * Setup The Updater
		 */
		$edd_updater = new EDD_SL_Plugin_Updater( 'https://quizandsurveymaster.com', __FILE__, array(
			'version'   => $this->version,
			'license'   => $license_key,
			'item_name' => 'Extra Template Variables',
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
function qsm_addon_extra_variables_load() {
	// Make sure QSM is active
	if ( class_exists( 'MLWQuizMasterNext' ) ) {
		$qsm_extra_variables = new QSM_Extra_Variables();
		load_plugin_textdomain( 'qsm-extra-variables', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
	} else {
		add_action( 'admin_notices', 'qsm_addon_extra_variables_missing_qsm' );
	}
}

add_action( 'plugins_loaded', 'qsm_addon_extra_variables_load' );

/**
 * Display notice if Quiz And Survey Master isn't installed
 *
 * @since       1.1.0
 * @return      string The notice to display
 */
function qsm_addon_extra_variables_missing_qsm() {
	echo '<div class="error"><p>QSM - Extra Template Variables requires Quiz And Survey Master. Please install and activate the Quiz And Survey Master plugin.</p></div>';
}

function qsm_extra_variables_validate_license() {
	global $mlwQuizMasterNext;
	$post_license = isset( $_POST['input'] ) ? sanitize_text_field( wp_unslash( $_POST['input'] ) ) : '';
	$update_status = isset( $_POST['update_status'] ) ? sanitize_text_field( wp_unslash( $_POST['update_status'] ) ) : '';
	if ( "" != $post_license ) {

		$settings    = get_option( 'qsm_addon_extra_variables_settings', array() );
		$license     = isset( $settings['license_key'] ) ? trim( $settings['license_key'] ) : '';

		if ( class_exists ( 'QSM_Check_License' ) ) {
			$activation = $mlwQuizMasterNext->check_license->activate( $post_license, 'Extra Template Variables' );
		}else {
			$activation = QSM_license::activate( $post_license, 'Extra Template Variables' );
		}

		if ( ! empty($activation) && ( ( __( 'Attempting to activate a bundle\'s parent license', 'quiz-master-next' ) == $activation['message'] || __( 'License key revoked', 'quiz-master-next' ) == $activation['message'] || __( 'No activations left', 'quiz-master-next' ) == $activation['message'] || __( 'License has expired', 'quiz-master-next' ) == $activation['message'] ) || 'success' == $activation['status'] ) ) {
			$item_url = 'https://quizandsurveymaster.com/checkout/?edd_license_key='.$license.'&download_id='.QSM_EXTRA_VARIABLES_ITEM;
			$settings['license_key'] = $post_license;
			$settings['license_status'] = 'valid';
			$settings['last_validate'] = date("d-m-Y", time());
			$settings['expiry_date'] = isset($activation['expiry_date']) ? $activation['expiry_date'] : "";
			if ( 'success' == $activation['status'] ) {
				$validate = 1;
				$message = __( 'License validated Successfully', 'qsm-extra-variables' );
			}elseif ( __( 'License has expired', 'qsm-extra-variables' ) == $activation['message'] ) {
				$validate = 2;
				$message = __('License Key Expired. ', 'qsm-extra-variables');
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
			$deactivation = QSM_license::deactivate( $license, 'Extra Template Variables' );
		}
		if ( ! empty( $update_status ) && 'yes' === $update_status ) {
			$keys_to_exclude    = [ 'license_key', 'license_status', 'last_validate', 'expiry_date' ];
			$prev_settings      = array_diff_key($settings, array_flip($keys_to_exclude));
			$settings           = array_merge( $settings, $prev_settings );
		}
		update_option( 'qsm_addon_extra_variables_settings', $settings );
		echo wp_json_encode(array(
			'validate' => $validate,
			'message'  => $message,
		));
		wp_die();
	}
}