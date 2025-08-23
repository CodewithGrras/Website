<?php
/**
 * Plugin Name: QSM - User Dashboard
 * Description: Use this plugin to add a dashboard for users to see and review their results
 * Version: 2.3.1
 * Author: QSM Team
 * Author URI: http://www.quizandsurveymaster.com/
 * Plugin URI: http://www.quizandsurveymaster.com/
 * Text Domain: qsm-user-dashboard
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'QSM_USER_DASHBOARD_DIR', plugin_dir_path( __FILE__ ) );
define( 'QSM_USER_DASHBOARD_URL', plugin_dir_url( __FILE__ ) );
define( 'QSM_USER_DASHBOARD_PHP_DIR', QSM_USER_DASHBOARD_DIR . 'php' );
define( 'QSM_USER_DASHBOARD_TEMPLATE_DIR', QSM_USER_DASHBOARD_DIR . 'templates' );

require QSM_USER_DASHBOARD_PHP_DIR . '/install.php';
register_activation_hook( __FILE__, 'qsm_user_dashboard_activate' );

/**
 * The main class of the addon
 *
 * @since 1.1.0
 */
class QSM_User_Dashboard {

	/**
	 * Version Number
	 *
	 * @var string
	 * @since 0.1.0
	 */
	public $version = '2.3.1';

	/**
	 * Main Construct Function
	 *
	 * Call functions within class
	 *
	 * @since 1.1.0
	 * @uses QSM_User_Dashboard::load_dependencies() Loads required filed
	 * @uses QSM_User_Dashboard::add_hooks() Adds actions to hooks and filters
	 * @return void
	 */
	public function __construct() {
		define( 'QSM_USER_DASHBOARD_VERSION', $this->version );
		define( 'USER_DASHBOARD_ITEM', 1900 );
		$this->load_dependencies();
		$this->add_hooks();
		$this->check_license();
	}

	/**
	 * Load file dependecies
	 *
	 * @since 1.1.0
	 * @return void
	 */
	public function load_dependencies() {
		include QSM_USER_DASHBOARD_PHP_DIR . '/license.php';
		include QSM_USER_DASHBOARD_PHP_DIR . '/addon-settings-tab-content.php';
		include QSM_USER_DASHBOARD_PHP_DIR . '/quiz-settings-tab-content.php';
		include QSM_USER_DASHBOARD_PHP_DIR . '/shortcode.php';
		include QSM_USER_DASHBOARD_PHP_DIR . '/user-dashboard-page.php';
	}

	/**
	 * Add hooks
	 *
	 * Adds functions to relavent hooks and filters
	 *
	 * @since 1.1.0
	 * @return void
	 */
	public function add_hooks() {
		add_action( 'admin_menu', array( $this, 'add_dashboard_pages' ) );
		add_action( 'admin_init', 'qsm_addon_user_dashboard_register_addon_settings_tabs' );
		add_action( 'admin_init', 'qsm_addon_user_dashboard_register_quiz_settings_tabs' );
		add_shortcode( 'user_dashboard', 'qsm_user_dashboard_shortcode' );
		add_shortcode( 'user_total_points', 'qsm_user_total_points_shortcode' );
		add_action( 'admin_notices', 'qsm_addon_user_dashboard_notices' );
		add_action( 'wp_ajax_qsm_user_dashboard_validate_license', 'qsm_user_dashboard_validate_license' );
		// For backwards compatibility
		add_shortcode( 'mlw_qmn_user_dashboard', 'qsm_user_dashboard_shortcode' );
		add_filter( 'qmn_begin_quiz_form', array( $this, 'qsm_addon_user_dashboard_questions_results' ), 10, 2 );
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
		$settings    = get_option( 'mlw_qmn_dashboard_option', '' );
		$license_key = isset( $settings['license_key'] ) ? trim( $settings['license_key'] ) : '';
		/**
		 * Setup The Updater
		 */
		$edd_updater = new EDD_SL_Plugin_Updater( 'https://quizandsurveymaster.com', __FILE__, array(
			'version'   => $this->version,
			'license'   => $license_key,
			'item_name' => 'User Dashboard',
			'author'    => 'QSM Team',
		)
		);
	}

	/**
	 * Adds My Results page to WP dashboard
	 */
	public function add_dashboard_pages() {
		if ( function_exists( 'add_menu_page' ) ) {
			add_menu_page( 'My Results', 'My Results', 'read', 'qsm_user_dashboard_admin_menu', 'qsm_user_dashboard_admin', 'dashicons-feedback' );
		}
	}

	function qsm_addon_user_dashboard_questions_results( $quiz_display ) {
		global $mlwQuizMasterNext;
		global $wpdb;
		$quiz_id = $mlwQuizMasterNext->quizCreator->get_id();
		$single_quiz_data = $wpdb->get_row(
			$wpdb->prepare(
				"SELECT quiz_settings FROM {$wpdb->prefix}mlw_quizzes WHERE quiz_id = %d",
				$quiz_id
			)
		);
		$quiz_settings = unserialize($single_quiz_data->quiz_settings);
		$details = "";
		if ( isset($quiz_settings['quiz_inline_results']) ) {
			if ( 1 === intval($quiz_settings['quiz_inline_results']['quiz_inline_results_count']) ) {
				$correct_results_count_text = __('Correct Answers', 'qsm-user-dashboard');
				$incorrect_results_count_text = __('Incorrect Answers', 'qsm-user-dashboard');
				$skipped_results_count_text = __('Skipped Answers', 'qsm-user-dashboard');
				if ( isset($quiz_settings['quiz_inline_results']) ) {
					$correct_results_count_text = $quiz_settings['quiz_inline_results']['correct_results_count_text'];
					$incorrect_results_count_text = $quiz_settings['quiz_inline_results']['incorrect_results_count_text'];
					$skipped_results_count_text = $quiz_settings['quiz_inline_results']['skipped_results_count_text'];
				}
				$details .= '<div class="qsm-question-container">';
					$details .= '<div class="qsm-question-count-dashboard">';
						$details .= '<div class="qsm-correct-count">';
							$details .= '<span class="dashicons dashicons-saved icon"></span>';
							$details .= '<span class="qsm-correct-count-label">'.$correct_results_count_text.'</span>';
							$details .= '<span class="qsm-correct-count-text text">0</span>';
						$details .= '</div>';
						$details .= '<div class="qsm-incorrect-count">';
							$details .= '<span class="dashicons dashicons-no-alt icon"></span>';
							$details .= '<span class="qsm-correct-count-label">'.$incorrect_results_count_text.'</span>';
							$details .= '<span class="qsm-incorrect-count-text text">0</span>';
						$details .= '</div>';
						$details .= '<div class="qsm-unanswer-count">';
							$details .= '<span class="dashicons dashicons-minus icon"></span>';
							$details .= '<span class="qsm-correct-count-label">'.$skipped_results_count_text.'</span>';
							$details .= '<span class="qsm-unanswer-count-text text">0</span>';
						$details .= '</div>';
					$details .= '</div>';
				$details .= '</div>';
			}
		}
		return $quiz_display.$details;
	}

}

/**
 * Loads the addon if QSM is installed and activated
 *
 * @since 1.1.0
 * @return void
 */
function qsm_user_dashboard_load() {
	// Make sure QSM is active
	if ( class_exists( 'MLWQuizMasterNext' ) ) {
		$qsm_user_dashboard = new QSM_User_Dashboard();
		load_plugin_textdomain( 'qsm-user-dashboard', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
	} else {
		add_action( 'admin_notices', 'qsm_user_dashboard_missing_qsm' );
	}
}

add_action( 'plugins_loaded', 'qsm_user_dashboard_load' );

/**
 * Display notice if Quiz And Survey Master isn't installed
 *
 * @since       1.1.0
 * @return      string The notice to display
 */
function qsm_user_dashboard_missing_qsm() {
	echo '<div class="error"><p>' . __( 'QSM - User Dashboard requires Quiz And Survey Master. Please install and activate the Quiz And Survey Master plugin.', 'qsm-user-dashboard' ) . '</p></div>';
}

/**
 * Shows admin notices
 *
 * @since 1.1.11
 */
function qsm_addon_user_dashboard_notices() {
	$notice_status = get_option( 'certificate_compatibility' );
	if ( ! $notice_status ) {
		echo '<div class="updated is-dismissible">
			<p>QSM - User Dashboard Compatible with <a href="https://quizandsurveymaster.com/downloads/quiz-certificate/" target="__blank" rel="noopener">QSM Certificate 1.0.12</a></p>
		</div>';
		update_option( 'certificate_compatibility', '1.0.12' );
	}
}
function qsm_user_dashboard_validate_license() {
	global $mlwQuizMasterNext;
	$post_license = isset( $_POST['input'] ) ? sanitize_text_field( wp_unslash( $_POST['input'] ) ) : '';
	$update_status = isset( $_POST['update_status'] ) ? sanitize_text_field( wp_unslash( $_POST['update_status'] ) ) : '';
	if ( "" !== $post_license ) {

		$settings    = get_option( 'mlw_qmn_dashboard_option', array() );
		$license     = isset( $settings['license_key'] ) ? trim( $settings['license_key'] ) : '';

		if ( class_exists ( 'QSM_Check_License' ) ) {
			$activation = $mlwQuizMasterNext->check_license->activate( $post_license, 'User Dashboard' );
		}else {
			$activation = QSM_license::activate( $post_license, 'User Dashboard' );
		}

		if ( ! empty($activation) && ( ( __( 'Attempting to activate a bundle\'s parent license', 'quiz-master-next' ) === $activation['message'] || __( 'License key revoked', 'quiz-master-next' ) === $activation['message'] || __( 'No activations left', 'quiz-master-next' ) === $activation['message'] || __( 'License has expired', 'quiz-master-next' ) === $activation['message'] ) || 'success' === $activation['status'] ) ) {
			$item_url = 'https://quizandsurveymaster.com/checkout/?edd_license_key='.$license.'&download_id='.USER_DASHBOARD_ITEM;
			$settings['license_key'] = $post_license;
			$settings['license_status'] = 'valid';
			$settings['last_validate'] = date("d-m-Y", time());
			$settings['expiry_date'] = isset($activation['expiry_date']) ? $activation['expiry_date'] : "";
			if ( 'success' === $activation['status'] ) {
				$validate = 1;
				$message = __( 'License validated Successfully', 'quiz-master-next' );
			}elseif ( __( 'License has expired', 'quiz-master-next' ) == $activation['message'] ) {
				$validate = 2;
				$message = __('License Key Expired. ', 'quiz-master-next');
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
		if ( $license !== $post_license ) {
			$deactivation = QSM_license::deactivate( $license, 'User Dashboard' );
		}
		if ( ! empty( $update_status ) && 'yes' === $update_status ) {
			$keys_to_exclude    = [ 'license_key', 'license_status', 'last_validate', 'expiry_date' ];
			$prev_settings      = array_diff_key($settings, array_flip($keys_to_exclude));
			$settings           = array_merge( $settings, $prev_settings );
		}
		update_option( 'mlw_qmn_dashboard_option', $settings );
		echo wp_json_encode(array(
			'validate' => $validate,
			'message'  => $message,
		));
		wp_die();
	}
}
