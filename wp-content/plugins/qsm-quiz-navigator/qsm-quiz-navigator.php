<?php
/**
 * Plugin Name: QSM - Quiz Navigator
 * Plugin URI: https://quizandsurveymaster.com
 * Description: Adds quiz page navigation functionality
 * Author: QSM Team
 * Author URI: https://quizandsurveymaster.com
 * Version: 1.0.1
 *
 * @author QSM Team
 * @version 1.0.0
 */
if ( ! defined('ABSPATH') ) {
    exit;
}
/**
 * This class is the main class of the plugin
 *
 * When loaded, it loads the included plugin files and add functions to hooks or filters. The class also handles the admin menu
 *
 * @since 1.0.0
 */
class QSM_Quiz_Navigator
{
    /**
     * Version Number
     *
     * @var string
     * @since 1.0.0
     */
    public $version = '1.0.1';
    /**
     * Main Construct Function
     *
     * Call functions within class
     *
     * @since 1.0.0
     * @uses QSM_Quiz_Navigator::load_dependencies() Loads required filed
     * @uses QSM_Quiz_Navigator::add_hooks() Adds actions to hooks and filters
     * @return void
     */
    public function __construct() {
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
        define( 'QSM_QUIZ_NAVIGATOR_VERSION', $this->version );
        define( 'QSM_QUIZ_NAVIGATOR_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
        define('QSM_QUIZ_NAVIGATOR_PLUGIN_DIR', plugin_dir_path(__FILE__));
        define('QSM_QUIZ_NAVIGATOR_ITEM', 567900);
        require QSM_QUIZ_NAVIGATOR_PLUGIN_DIR. 'php/license.php';
        require QSM_QUIZ_NAVIGATOR_PLUGIN_DIR. 'php/functions.php';
        require QSM_QUIZ_NAVIGATOR_PLUGIN_DIR. 'php/quiz-setting-tab-content.php';

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
        add_action( 'wp_enqueue_scripts', array( $this, 'qsm_scripts_style' ) );
        add_action( 'admin_enqueue_scripts', array( $this, 'qsm_admin_scripts_style' ) );
        add_action( 'admin_init', 'qsm_quiz_navigator_register_quiz_settings_tabs' );
		add_action( 'admin_init', 'quiz_navigator_register_addon_settings_tabs' );
        add_filter('qmn_end_quiz', 'qsm_quiz_navigator_front', 3, 50);
        add_shortcode('qsm_navigator', 'qsm_quiz_navigator_shortcode');
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
			// load our custom updater
			include 'php/EDD_SL_Plugin_Updater.php';
		}

		// retrieve our license key from the DB
		$quiz_navigator_data     = get_option( 'qsm_quiz_navigator_settings', '' );
		$license_key = isset( $quiz_navigator_data['license_key'] ) ? trim( $quiz_navigator_data['license_key'] ) : '';

		// setup the updater
		$edd_updater = new EDD_SL_Plugin_Updater(
			'https://quizandsurveymaster.com', __FILE__, array(
				'version'   => $this->version, // current version number
				'license'   => $license_key, // license key (used get_option above to retrieve from DB)
				'item_name' => 'Quiz Navigator', // name of this plugin
				'author'    => 'QSM Team', // author of this plugin
			)
		);
	}


    public function qsm_scripts_style() {
        wp_enqueue_script('qsm-quiz-navigator-front', QSM_QUIZ_NAVIGATOR_PLUGIN_URL . 'js/front.js', array( 'qsm_quiz' ), $this->version, 'true' );
        wp_enqueue_style('qsm-quiz-navigator-front', QSM_QUIZ_NAVIGATOR_PLUGIN_URL . 'css/style.css', array(), $this->version );
    }

    public function qsm_admin_scripts_style( $hook ) {
		if ( 'admin_page_mlw_quiz_options' === $hook ) {
            wp_enqueue_script('wp-color-picker');
            wp_enqueue_style('wp-color-picker');
            wp_enqueue_script('qsm-quiz-navigator-admin', QSM_QUIZ_NAVIGATOR_PLUGIN_URL . 'js/admin.js', array( 'jquery' ), $this->version, 'true' );
            wp_enqueue_style('qsm-quiz-navigator-admin', QSM_QUIZ_NAVIGATOR_PLUGIN_URL . 'css/admin.css', array(), $this->version );
        }
    }

}
/**
 * Loads the addon if QSM is installed and activated
 *
 * @since 1.0.0
 */
function qsm_quiz_navigator_load() {
    // Make sure QSM is active.
    if ( class_exists('MLWQuizMasterNext') ) {
        $qsm_membership = new QSM_Quiz_Navigator();
    }
    else {
        add_action('admin_notices', 'qsm_quiz_navigator_missing_qsm');
    }
}
add_action('plugins_loaded', 'qsm_quiz_navigator_load');
/**
 * Display notice if Quiz And Survey Master isn't installed
 *
 * @since 1.0.0
 */
function qsm_quiz_navigator_missing_qsm() {
    echo '<div class="error"><p>';
	esc_html_e( 'QSM - Quiz Navigator requires Quiz And Survey Master. Please install and activate the Quiz And Survey Master plugin.', 'qsm-quiz-navigator' );
	echo '</p></div>';
}


