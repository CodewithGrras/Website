<?php
/**
 * Plugin Name: QSM - Logic
 * Plugin URI: https://quizandsurveymaster.com
 * Description: Allows you to show and hide different questions based on previous answers
 * Author: QSM Team
 * Author URI: https://quizandsurveymaster.com
 * Version: 2.3.0
 * Text Domain: qsm-logic
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * This class is the main class of the plugin
 *
 * When loaded, it loads the included plugin files and add functions to hooks or filters. The class also handles the admin menu
 *
 * @since 0.1.0
 */
class QSM_Logic {


	/**
	 * Version Number
	 *
	 * @var string
	 * @since 0.1.0
	 */
	public $version = '2.3.0';

	/**
	 * Main Construct Function
	 *
	 * Call functions within class
	 *
	 * @since 0.1.0
	 * @uses QSM_Logic::load_dependencies() Loads required filed
	 * @uses QSM_Logic::add_hooks() Adds actions to hooks and filters
	 * @uses QSM_Logic::check_license() Checks if license is active and if updates are available
	 * @return void
	 */
	public function __construct() {
		define( 'QSM_LOGIC_ID', 1899 );
		$this->load_dependencies();
		$this->add_hooks();
		$this->check_license();
	}

	/**
	 * Load File Dependencies
	 *
	 * @since 0.1.0
	 * @return void
	 */
	public function load_dependencies() {
		include 'php/license.php';
		include 'php/addon-settings-tab-content.php';
		include 'php/quiz-settings-tab-content.php';
		include 'php/ajax.php';
		include 'php/quiz-conditions.php';
		include 'php/qsm-intergration.php';
		define( 'QSM_LOGIC_ADDON_URL', plugin_dir_url( __FILE__ ) );
		define( 'QSM_LOGIC_VERSION', $this->version );
	}

	/**
	 * Add Hooks
	 *
	 * Adds functions to relavent hooks and filters
	 *
	 * @since 0.1.0
	 * @return void
	 */
	public function add_hooks() {
		add_action( 'admin_init', 'qsm_addon_logic_register_quiz_settings_tabs' );
		add_action( 'admin_init', 'qsm_addon_logic_register_addon_settings_tabs' );
		add_action( 'admin_init', 'qsm_check_logic_update' );
		add_action( 'wp_ajax_qsm_save_logic', 'qsm_addon_logic_ajax' );
		add_action( 'wp_ajax_qsm_delete_logic', 'qsm_addon_logic_ajax_delete' );
		add_action( 'wp_ajax_qsm_edit_logic', 'qsm_addon_logic_ajax_edit' );
		add_action( 'wp_ajax_qsm_delete_logic_bulk', 'qsm_addon_logic_ajax_bulk_delete' );
		add_action( 'wp_ajax_nopriv_qsm_save_logic', 'qsm_addon_logic_ajax' );
		add_filter( 'qmn_begin_quiz', 'qsm_addon_logic_script_integration', 10, 3 );
		if ( empty( get_option( 'qsm-addon-logic-dismissed' ) ) ) {
			add_action( 'admin_notices', array( $this, 'qsm_addon_logic_global_admin_notice' ) );
			add_action( 'admin_footer', array( $this, 'qsm_addon_logic_global_admin_notice_js' ) );
		}
		add_action( 'wp_ajax_qsm_addon_logic_dismiss_notice', array( $this, 'qsm_addon_logic_dismiss_notice' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'qsm_logic_admin_enqueue_scripts' ) );
		add_action( 'wp_ajax_qsm_logic_validate_license', 'qsm_logic_validate_license' );
	}

	/**
	 * Add admin notice
	 *
	 * @since 2.0.4
	 */
	public function qsm_logic_admin_enqueue_scripts(){

		global $wpdb;
		global $mlwQuizMasterNext;

		if ( !isset($_GET['quiz_id'] ) || ! isset($_GET['tab'] ) || 'logic' !== $_GET['tab'] ) {
			return;
		}
		// Prepares our data to be sent to JavaScript.
		$quiz_id = intval( $_GET['quiz_id'] );
		$get_quiz_settings = $wpdb->get_var( $wpdb->prepare( "SELECT `quiz_settings` FROM `{$wpdb->prefix}mlw_quizzes` WHERE `quiz_id`=%d", $quiz_id ) );
		$get_quiz_settings = maybe_unserialize( $get_quiz_settings );
		$get_quiz_qpages = maybe_unserialize( $get_quiz_settings['qpages'] );
		foreach ($get_quiz_qpages as $value) {
			$temp['id'] = $value['id'];
			$temp['pagekey'] = $value['pagekey'];
			$get_quiz_page_id[] = $temp;
		}

		// checking if data is available in logic table
		$table_exists = get_option( "logic_rules_quiz_$quiz_id" );
		if ( empty( $table_exists ) ) {
			$logic_rules = $mlwQuizMasterNext->pluginHelper->get_quiz_setting( 'logic_rules' );
			$logic_rules = maybe_unserialize( $logic_rules );
			if ( is_array( $logic_rules ) ) {
				if ( sizeof( $logic_rules ) == 0 ) {
					$logic_rules = false;
				}
			} else {
				$logic_rules = false;
			}
			$json_data = array(
				'quizID'     => $quiz_id,
				'logicRules' => $logic_rules,
				'nonce'      => wp_create_nonce( 'wp_rest' ),
				'ajaxurl'    => admin_url( 'admin-ajax.php' ),
				'load_modal' => true,
				'lyr_image'  => plugin_dir_url( __FILE__ ) . "images/layer.png",
				'quiz_qpages_id'=> $get_quiz_page_id,
			);
		} else {
			$query            = "SELECT id, logic FROM {$wpdb->prefix}mlw_logic where quiz_id = %d";
			$logic_rules_data = $wpdb->get_results( $wpdb->prepare( $query, $quiz_id ) );
			$logic_rules      = $ids = array();
			foreach ( $logic_rules_data as $data ) {
				$logic_rules[] = maybe_unserialize( $data->logic );
				$ids[]         = $data->id;
			}
			$json_data = array(
				'quizID'     => $quiz_id,
				'logicRules' => $logic_rules,
				'ids'        => $ids,
				'nonce'      => wp_create_nonce( 'wp_rest' ),
				'ajaxurl'    => admin_url( 'admin-ajax.php' ),
				'load_modal' => false,
				'lyr_image'  => plugin_dir_url( __FILE__ ) . "images/layer.png",
				'quiz_qpages_id'=> $get_quiz_page_id,
			);
		}

		wp_enqueue_script( 'qsm_logic_admin_script', plugins_url( '/js/qsm-logic-admin.js', __FILE__ ), array( 'jquery', 'backbone', 'underscore', 'wp-util', 'wp-i18n' ), QSM_LOGIC_VERSION, true );
		wp_set_script_translations('qsm_logic_admin_script', 'qsm-logic',  plugin_dir_path(__FILE__) . 'languages/');
		wp_localize_script( 'qsm_logic_admin_script', 'qsmLogicObject', $json_data );
		wp_enqueue_style( 'qsm_logic_admin_style', plugins_url( '/css/qsm-logic-admin.css', __FILE__ ), array(), QSM_LOGIC_VERSION );
		wp_enqueue_editor();
		wp_enqueue_media();
	}

	/**
	 * Add admin notice
	 *
	 * @since 1.0.8
	 */
	public function qsm_addon_logic_global_admin_notice() {
		$notice   = esc_html__("v1.0.8 - We have disabled the Logic rules for Auto Pagination, meaning – You cannot use Logic Addon when Auto Pagination (Questions Per Page option) is Enabled in the Options Tab of Quiz and Survey Master Plugin.", "qsm-logic") . "<a href='https://quizandsurveymaster.com/docs/add-ons/logic/' target='_blank'>". __("Check out documentation", "qsm-logic") . "</a>.";
		echo "<div class='notice error qsm-addon-logic is-dismissible'><p>" . wp_kses_post( $notice ) . "</p></div>";
	}

	/**
	 * Dismiss admin notice ajax function.
	 *
	 * @since 1.0.8
	 */
	public function qsm_addon_logic_global_admin_notice_js() {
		echo "<script type='text/javascript'>jQuery(document).on('click', '.qsm-addon-logic .notice-dismiss', function () {jQuery.ajax({url: ajaxurl,data: {action: 'qsm_addon_logic_dismiss_notice'}});});</script>";
	}

	/**
	 * Update the option method
	 *
	 * @since 1.0.8
	 */
	public function qsm_addon_logic_dismiss_notice() {
		update_option( 'qsm-addon-logic-dismissed', 1 );
		exit;
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
			include 'php/EDD_SL_Plugin_Updater.php';
		}

		// retrieve our license key from the DB
		$logic_data  = get_option( 'qsm_addon_logic_settings', '' );
		$license_key = isset( $logic_data['license_key'] ) ? trim( $logic_data['license_key'] ) : '';

		// setup the updater
		$edd_updater = new EDD_SL_Plugin_Updater(
			'https://quizandsurveymaster.com', __FILE__, array(
				'version'   => $this->version, // current version number
				'license'   => $license_key, // license key (used get_option above to retrieve from DB)
				'item_name' => 'Logic', // name of this plugin
				'author'    => 'QSM Team', // author of this plugin
			)
		);
	}

	/**
	 * Creates separate table mlw_logic to store quiz logic
	 *
	 * @since       2.0.0
	 */

	public static function qsm_install_logic() {
		global $wpdb;

		$charset_collate = $wpdb->get_charset_collate();
		$table_name      = $wpdb->prefix . 'mlw_logic';

		$sql = "CREATE TABLE IF NOT EXISTS $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        quiz_id mediumint(9) NOT NULL,
        logic text NOT NULL,
        updated DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        PRIMARY KEY  (id)
      ) $charset_collate;";

		require_once ABSPATH . 'wp-admin/includes/upgrade.php';
		dbDelta( $sql );
	}
}

/**
 * Loads the addon if QSM is installed and activated
 *
 * @since 0.1.0
 * @return void
 */
function qsm_addon_logic_load() {
	// Make sure QSM is active
	if ( class_exists( 'MLWQuizMasterNext' ) ) {
		$qsm_logic = new QSM_Logic();
		load_plugin_textdomain( 'qsm-logic', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
	} else {
		add_action( 'admin_notices', 'qsm_addon_logic_missing_qsm' );
	}
}
add_action( 'plugins_loaded', 'qsm_addon_logic_load' );

/**
 * Display notice if Quiz And Survey Master isn't installed
 *
 * @since       0.1.0
 * @return      string The notice to display
 */
function qsm_addon_logic_missing_qsm() {
	echo '<div class="error"><p>' . esc_html__("QSM - Logic requires Quiz And Survey Master. Please install and activate the Quiz And Survey Master plugin.", "qsm-logic") . '</p></div>';
}

/**
 * Checks and creates table if not exists.
 */
function qsm_check_logic_update() {
	global $wpdb;
	$logic_table_name = $wpdb->prefix . 'mlw_logic';
	if ( $wpdb->get_var( "SHOW TABLES LIKE '$logic_table_name'" ) != $logic_table_name ) {
		QSM_LOGIC::qsm_install_logic();
	}
}
function qsm_logic_validate_license() {
	global $mlwQuizMasterNext;
	$post_license = isset( $_POST['input'] ) ? sanitize_text_field( wp_unslash( $_POST['input'] ) ) : '';
	$update_status = isset( $_POST['update_status'] ) ? sanitize_text_field( wp_unslash( $_POST['update_status'] ) ) : '';
	if ( "" != $post_license ) {

		$settings	 = get_option( 'qsm_addon_logic_settings', array() );
		$license	 = isset( $settings['license_key'] ) ? trim( $settings['license_key'] ) : '';

		if( class_exists ( 'QSM_Check_License' )) {
			$activation = $mlwQuizMasterNext->check_license->activate( $post_license, 'Logic' );
		}else{
			$activation = QSM_license::activate( $post_license, 'Logic' );
		}

		if( !empty($activation) && ( ( __( 'Attempting to activate a bundle\'s parent license', 'quiz-master-next' ) === $activation['message'] || __( 'License key revoked', 'quiz-master-next' ) === $activation['message'] || __( 'No activations left', 'quiz-master-next' ) === $activation['message'] || __( 'License has expired', 'quiz-master-next' ) === $activation['message'] ) || 'success' === $activation['status'] ) ) {
			$item_url = 'https://quizandsurveymaster.com/checkout/?edd_license_key='.$license.'&download_id='.QSM_LOGIC_ID;
			$settings['license_key'] = $post_license;
			$settings['license_status'] = 'valid';
			$settings['last_validate'] = date("d-m-Y", time());
			$settings['expiry_date'] = isset($activation['expiry_date']) ? $activation['expiry_date'] : "";
			if('success' == $activation['status']) {
				$validate = 1;
				$message = __( 'License validated Successfully', 'qsm-logic' );
			}elseif(__( 'License has expired', 'qsm-logic' ) == $activation['message'] ){
				$validate = 2;
				$message = __('License Key Expired. ', 'qsm-logic');
			}else{
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
		if($license != $post_license) {
			$deactivation = QSM_license::deactivate( $license, 'Logic' );
		}
		if ( ! empty( $update_status ) && 'yes' === $update_status ) {
			$keys_to_exclude    = [ 'license_key', 'license_status', 'last_validate', 'expiry_date' ];
			$prev_settings      = array_diff_key($settings, array_flip($keys_to_exclude));
			$settings           = array_merge( $settings, $prev_settings );
		}
		update_option( 'qsm_addon_logic_settings', $settings );
		echo wp_json_encode(array('validate' => $validate, 'message' => $message));
		wp_die();
	}
}
register_activation_hook( __FILE__, array( 'QSM_LOGIC', 'qsm_install_logic' ) );