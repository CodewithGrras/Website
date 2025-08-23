<?php
/**
 * Plugin Name: QSM - Extra Shortcodes
 * Plugin URI: https://quizandsurveymaster.com/
 * Description: Add extra shortcodes to use with Quiz And Survey Master
 * Author: QSM Team
 * Author URI: https://quizandsurveymaster.com/
 * Version: 3.3.0
 * Text Domain: qsm-extra-shortcodes
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * This class is the main class of the plugin
 *
 * When loaded, it loads the included plugin files and add functions to hooks or filters. The class also handles the admin menu
 *
 * @since 2.0.0
 */
class QSM_Extra_Shortcodes {

	/**
	 * Version Number
	 *
	 * @var string
	 * @since 0.1.0
	 */
	public $version = '3.3.0';

	/**
	 * Main Construct Function
	 *
	 * Call functions within class
	 *
	 * @since 2.0.0
	 * @uses QSM_Extra_Shortcodes::load_dependencies() Loads required filed
	 * @uses QSM_Extra_Shortcodes::add_hooks() Adds actions to hooks and filters
	 * @return void
	 */
	function __construct() {
		$this->load_dependencies();
		$this->add_hooks();
		$this->check_license();
		define( 'QSM_EXTRA_SHORTCODES_ITEM', 1898 );
	}

	/**
	 * Load File Dependencies
	 *
	 * @since 2.0.0
	 * @return void
	 */
	public function load_dependencies() {
		define( 'QSM_EXTRA_SHORTCODES_VER', $this->version );
		define( 'QSM_EXTRA_SHORTCODES_URL', plugin_dir_url( __FILE__ ) );
		define( 'QSM_EXTRA_SHORTCODES_JS_URL', QSM_EXTRA_SHORTCODES_URL . 'js' );
		include 'php/license.php';
		include 'php/addon-settings-tab-content.php';
		include 'php/shortcodes.php';
	}

	/**
	 * Add Hooks
	 *
	 * Adds functions to relavent hooks and filters
	 *
	 * @since 2.0.0
	 * @return void
	 */
	public function add_hooks() {
		add_action( 'admin_init', 'qsm_addon_extra_shortcodes_register_addon_settings_tabs' );
		add_shortcode( 'qsm_passed', 'qsm_addon_extra_shortcodes_passed_score_shortcode' );
		add_shortcode( 'qsm_passed_points', 'qsm_addon_extra_shortcodes_passed_point_shortcode' );
		add_shortcode( 'qsm_failed', 'qsm_addon_extra_shortcodes_failed_score_shortcode' );
		add_shortcode( 'qsm_failed_points', 'qsm_addon_extra_shortcodes_failed_point_shortcode' );
		add_shortcode( 'qsm_average', 'qsm_addon_extra_shortcodes_average_score_shortcode' );
		add_shortcode( 'qsm_average_points', 'qsm_addon_extra_shortcodes_average_point_shortcode' );
		add_shortcode( 'qsm_taken', 'qsm_addon_extra_shortcodes_taken_shortcode' );
		add_shortcode( 'qsm_recent', 'qsm_addon_extra_shortcodes_recent_shortcode' );
		add_shortcode( 'qsm_all_quizzes', 'qsm_addon_extra_shortcodes_all_quizzes_shortcode' );
		add_shortcode( 'qsm_popular', 'qsm_addon_extra_shortcodes_popular_shortcode' );
		add_shortcode( 'qsm_assessment_compare', 'qsm_addon_extra_shortcodes_assessment_compare' );
		add_shortcode('mlw_qmn_score_leaderboard', 'qsm_addon_extra_shortcodes_display_score');
		add_shortcode('qsm_display_score', 'qsm_addon_extra_shortcodes_display_score');
		add_action( 'wp_ajax_qsm_extra_shortcodes_validate_license', 'qsm_extra_shortcodes_validate_license' );
		add_action( 'wp_ajax_qsm_extra_shortcode_save_shortcode', 'qsm_extra_shortcode_save_shortcode' );

		add_action( 'admin_enqueue_scripts', array( $this, 'qsm_admin_scripts_style' ), 15 );
		add_filter( 'mlw_qmn_template_variable_results_page', 'qsm_category_score_shortcode', 10, 2 );
		add_filter( 'mlw_qmn_template_variable_results_page', 'qsm_conditions_shortcode', 10, 2 );
		add_filter('mlw_qmn_template_variable_results_page', 'qsm_calc_filter', 25, 2);
		add_action( 'qsm_result_page_content_before', array( $this, 'qsm_extra_shortcode_qsm_result_page_content_before' ), 10, 2 );
		add_action( 'qsm_email_page_content_before', array( $this, 'qsm_extra_shortcode_qsm_result_page_content_before' ), 10, 2 );
		add_action( 'qsm_options_results_tab_content_before', array( $this, 'add_input_field' ), 10 );
		add_action( 'qsm_options_email_tab_content_before', array( $this, 'add_input_field' ), 10 );
		//
	}

	// Method to output the input field
    public function add_input_field() {
		wp_enqueue_script( 'qsm_extra_shortcodes_admin_script', QSM_EXTRA_SHORTCODES_JS_URL . '/qsm-extra-shortcodes-admin.js', array( 'jquery' ), QSM_EXTRA_SHORTCODES_VER, true );
		wp_enqueue_style( 'qsm_extra_shortcodes-admin-css', QSM_EXTRA_SHORTCODES_URL . 'css/admin.css', array(), QSM_EXTRA_SHORTCODES_VER );
		$quiz_id = isset($_GET['quiz_id']) ? sanitize_text_field( wp_unslash( $_GET['quiz_id'] ) ) : 0;
		$categories = QSM_Questions::get_quiz_categories( $quiz_id );
		$params      = array(
			'copytext'          => __('Shortcode Copied!', 'qsm-extra-shortcodes'),
			'copyshortcode'     => __('Copy Rule', 'qsm-extra-shortcodes'),
			'select'            => __('Select Category', 'qsm-extra-shortcodes'),
			'score_placeholder' => __('Score', 'qsm-extra-shortcodes'),
			'point_placeholder' => __('Point', 'qsm-extra-shortcodes'),
			'categories'        => $categories,
			'remove_image_url'  => esc_url(QSM_PLUGIN_URL . 'assets/trash-light.svg'),
		);
		wp_localize_script( 'qsm_extra_shortcodes_admin_script', 'qsm_extra_shortcodes_obj', $params );
		?>
		<div class="qsm-popup qsm-popup-slide " id="qsm-extra-shortcode-modal" aria-hidden="true">
			<div class="qsm-popup__overlay" tabindex="-1" data-micromodal-close>
				<div class="qsm-popup__container" role="dialog" aria-modal="true" aria-labelledby="modal-1-title">
					<header class="qsm-popup__header">
						<img src="<?php echo esc_url(QSM_PLUGIN_URL . '/assets/icon-128x128.png'); ?>" />
						<h2 class="qsm-popup__title" id="qsm-extra-shortcode-modal-title"><?php esc_html_e( 'Output Rules', 'qsm-extra-shortcodes' ); ?> <span
								style="display: none;">[ ID: <span id="edit-page-id"></span> ]</span></h2>
						<a class="qsm-popup__close" aria-label="Close modal" data-micromodal-close></a>
					</header>
					<main class="qsm-popup__content qsm-extra-shortcode-popup-container"  id="qsm-extra-shortcode-modal-content">
						<div class="qsm-extra-shortcode-result-container">
							<div class="qsm-extra-shortcode-settings">
								<p class="qsm-extra-shortcode-info"><?php esc_html_e( 'If you have similar content with minor condition variations, simply ', 'quiz-master-next' ); ?><a target="_blank" class="qsm-extra-shortcode-documentation" href="<?php echo esc_attr(qsm_get_plugin_link( 'docs/add-ons/extra-shortcodes/' )); ?>"><?php echo esc_html_e( 'add rules', 'qsm-analysis' ); ?></a><?php esc_html_e( ' instead of creating new result pages', 'quiz-master-next' ); ?></p>
								<div class="qsm-extra-shortcode-quiz-section">
									<div class="qsm-extra-shortcode-quiz-section-inside-top">
										<div class="qsm-extra-shortcode-quiz-section-inside-field">
											<label for="qsm-extra-shortcode-condition-type"><?php echo esc_html__("Select Mode", "qsm-extra-shortcodes"); ?></label>
											<select id="qsm-extra-shortcode-condition-type" name="qsm_extra_shortcode_condition_type" class="qsm-extra-shortcode-condition-type">
												<option value="quiz" selected><?php echo esc_html__("Quiz", "qsm-extra-shortcodes"); ?></option>
												<option value="category"><?php echo esc_html__("Category", "qsm-extra-shortcodes"); ?></option>
											</select>
										</div>
									</div>
									<div class="qsm-extra-shortcode-quiz-section-inside-bottom">
										<div class="qsm-extra-shortcode-quiz-section-inside-field">
											<label for="qsm-extra-shortcode-type"><?php echo esc_html__("Type", "qsm-extra-shortcodes"); ?></label>
											<select id="qsm-extra-shortcode-type" name="qsm_extra_shortcode_type" class="qsm-extra-shortcode-type">
												<option value="points" selected><?php echo esc_html__("Points", "qsm-extra-shortcodes"); ?></option>
												<option value="score"><?php echo esc_html__("Score", "qsm-extra-shortcodes"); ?></option>
											</select>
										</div>
										<div class="qsm-extra-shortcode-quiz-section-inside-field">
											<label for="qsm-extra-shortcode-relation"><?php echo esc_html__("Condition", "qsm-extra-shortcodes"); ?></label>
											<select id="qsm-extra-shortcode-relation" name="qsm_extra_shortcode_relation" class="qsm-extra-shortcode-relation">
												<option value="equal" >
													<?php echo esc_html__("Equal", "qsm-extra-shortcodes"); ?>
												</option>
												<option value="greater">
													<?php echo esc_html__("Greater", "qsm-extra-shortcodes"); ?>
												</option>
												<option value="lessthan">
													<?php echo esc_html__("Less than", "qsm-extra-shortcodes"); ?>
												</option>
												<option value="between">
													<?php echo esc_html__("Between", "qsm-extra-shortcodes"); ?>
												</option>
											</select>
										</div>
										<div class="qsm-extra-shortcode-quiz-section-inside-field">
											<label for="qsm-extra-shortcode-condition-quiz-value"><?php echo esc_html__("Value", "qsm-extra-shortcodes"); ?></label>
											<input type="text" id="qsm-extra-shortcode-condition-quiz-value" placeholder="<?php echo esc_attr('Value', 'qsm-extra-shortcodes'); ?>" class="small-text qsm-small-text" name="qsm_extra_shortcode_condition_quiz_value"  value=""  placeholder="" >
										</div>
									</div>
								</div>
								<div class="qsm-extra-shortcode-category-section">
									<div class="qsm-extra-shortcode-category-section-top">
										<div class="qsm-extra-shortcode-quiz-section-inside-field">
											<label for="qsm-extra-shortcode-type-category"><?php echo esc_html__("Type", "qsm-extra-shortcodes"); ?></label>
											<select id="qsm-extra-shortcode-type-category" name="qsm_extra_shortcode_type_category" class="qsm-extra-shortcode-type">
												<option value="points" selected><?php echo esc_html__("Points", "qsm-extra-shortcodes"); ?></option>
												<option value="score"><?php echo esc_html__("Score", "qsm-extra-shortcodes"); ?></option>
											</select>
										</div>
										<div class="qsm-extra-shortcode-quiz-section-inside-field">
											<label for="qsm-extra-shortcode-relation-category"><?php echo esc_html__("Condition", "qsm-extra-shortcodes"); ?></label>
											<select id="qsm-extra-shortcode-relation-category" name="qsm_extra_shortcode_relation" class="qsm-extra-shortcode-relation">
												<option value="equal" >
													<?php echo esc_html__("Equal", "qsm-extra-shortcodes"); ?>
												</option>
												<option value="greater">
													<?php echo esc_html__("Greater", "qsm-extra-shortcodes"); ?>
												</option>
												<option value="lessthan">
													<?php echo esc_html__("Less than", "qsm-extra-shortcodes"); ?>
												</option>
												<option value="between">
													<?php echo esc_html__("Between", "qsm-extra-shortcodes"); ?>
												</option>
											</select>
										</div>

										<div class="qsm-extra-shortcode-quiz-section-inside-field qsm-extra-shortcode-logical">
											<label for="qsm-extra-shortcode-condition"><?php echo esc_html__("Type", "qsm-extra-shortcodes"); ?></label>
											<select id="qsm-extra-shortcode-condition" name="qsm_extra_shortcode_logic_condition" class="qsm-extra-shortcode-condition">
												<option value="AND" selected><?php echo esc_html__("AND", "qsm-extra-shortcodes"); ?></option>
												<option value="OR"><?php echo esc_html__("OR", "qsm-extra-shortcodes"); ?></option>
											</select>
										</div>
									</div>
									<div class="qsm-extra-shortcode-category-section-bottom qsm-extra-shortcode-select-category-container">
										<div class="qsm-extra-shortcode-select-category-multiple">
											<div class="qsm-field-row">
												<?php if ( ! empty( $categories ) ) { ?>
													<div class = "qsm-extra-shortcode-select-category">
														<select name="extra_shortcode_multiple_quiz[]" multiple="multiple" class="extra-shortcode-multiple-categories" >
															<?php
															if ( ! empty($categories['list'] ) ) {
																foreach ( $categories['list'] as $key => $single_cat ) {
																	?><option value="<?php echo esc_attr( $single_cat ); ?>"><?php echo esc_attr( $single_cat ); ?></option><?php
																}
															} ?>
														</select>
														<input type="text" placeholder="<?php echo esc_attr('Value', 'qsm-extra-shortcodes'); ?>" class="small-text qsm-small-text" name="qsm_extra_shortcode_category_value"  value=""  placeholder="" >
														<a href="javascript:void(0)" class="delete-category-button">
															<img class="qsm-common-svg-image-class" src="<?php echo esc_url(QSM_PLUGIN_URL . 'assets/trash-light.svg'); ?>" alt="trash-light.svg"/>
														</a>
													</div>
													<div class="qsm-extra-shortcode-add-more-link">
														<a href="javascript:void(0)" class="qsm-extra-shortcode-add-more-category" >+ <?php esc_html_e('Add category','qsm-extra-shortcodes'); ?></a>
													</div>
												<?php } else { ?>
													<p><?php esc_html_e('No categories assign to the questions.','qsm-extra-shortcodes'); ?></p>
												<?php } ?>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="qsm-extra-shortcode-description">
								<div class="qsm-extra-shortcode-quiz-section-inside-field">
									<label class="qsm-extra-shortcodes-options-label"><?php echo __("Output", "qsm-extra-shortcodes"); ?></label>
									<div class="qsm-extra-shortcodes-order-field qsm-extra-shortcodes-field-inside">
										<textarea id="qsm-extra-shortcodes-description" name="qsm_extra_shortcodes_description" rows="2" cols="50" placeholder="<?php esc_attr_e('Enter your output here...', 'qsm-extra-shortcodes'); ?>"></textarea>
									</div>
								</div>
								<p class="section-hint"><?php esc_html_e('This output will be shown if the conditions are met.', 'qsm-extra-shortcodes'); ?></p>
							</div>
						</div>

					</main>
					<footer class="qsm-popup__footer">
						<button class="button qsm-common-button-styles qsm-extra-shortcode-copy"><?php esc_html_e( 'Copy Rule', 'qsm-extra-shortcodes' ); ?></button>
						<button class="qsm-common-button-styles button-primary qsm-extra-shortcode-insert qsm-result-editor-custom-button"><?php esc_html_e( 'Insert Rule', 'qsm-extra-shortcodes' ); ?></button>
					</footer>
				</div>
			</div>
		</div>
		<?php
    }

	public function qsm_admin_scripts_style(){
		wp_enqueue_script( 'qsm_extra_shortcodes_admin_script', QSM_EXTRA_SHORTCODES_JS_URL . '/qsm-extra-shortcodes-admin.js', array( 'jquery' ), QSM_EXTRA_SHORTCODES_VER, true );
		wp_enqueue_style( 'qsm_extra_shortcodes-admin-css', QSM_EXTRA_SHORTCODES_URL . 'css/admin.css', array(), QSM_EXTRA_SHORTCODES_VER );
	}

	public function qsm_extra_shortcode_qsm_result_page_content_before( $quiz_id, $categories ) {
		?>
		<button type="button" data-id="<?php esc_attr($quiz_id); ?>" class="button qsm-extra-shortcode-resultpage-button qsm-extra-shortcode-emailpage-button qsm-extra-shortcode-conditional-button">
			<img class="qsm-common-svg-image-class" src="<?php echo esc_url(QSM_PLUGIN_URL . 'assets/flow-chart.svg'); ?>" alt="flow-chart.svg"/>
			<?php esc_html_e('Output Rules', 'qsm-extra-shortcodes'); ?>
		</button>
		<?php
	}

	/**
	 * Checks license
	 *
	 * Checks to see if license is active and, if so, checks for updates
	 *
	 * @since 2.0.0
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
		$settings    = get_option( 'qsm_addon_extra_shortcodes_settings', '' );
		$license_key = isset( $settings['license_key'] ) ? trim( $settings['license_key'] ) : '';
		/**
		 * Setup The Updater
		 */
		$edd_updater = new EDD_SL_Plugin_Updater( 'https://quizandsurveymaster.com', __FILE__, array(
			'version'   => $this->version,
			'license'   => $license_key,
			'item_name' => 'Extra Shortcodes',
			'author'    => 'QSM Team',
		)
		);
	}

}

/**
 * Loads the addon if QSM is installed and activated
 *
 * @since 2.0.0
 * @return void
 */
function qsm_addon_extra_shortcodes_load() {
	// Make sure QSM is active
	if ( class_exists( 'MLWQuizMasterNext' ) ) {
		$qsm_extra_shortcodes = new QSM_Extra_Shortcodes();
		load_plugin_textdomain( 'qsm-extra-shortcodes', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
	} else {
		add_action( 'admin_notices', 'qsm_addon_extra_shortcodes_missing_qsm' );
	}
}

add_action( 'plugins_loaded', 'qsm_addon_extra_shortcodes_load' );

/**
 * Display notice if Quiz And Survey Master isn't installed
 *
 * @since       2.0.0
 * @return      string The notice to display
 */
function qsm_addon_extra_shortcodes_missing_qsm() {
	echo '<div class="error"><p>' .__('QSM - Extra Shortcodes requires Quiz And Survey Master. Please install and activate the Quiz And Survey Master plugin.', 'qsm-extra-shortcodes') .'</p></div>';
}

function qsm_extra_shortcodes_validate_license() {
	global $mlwQuizMasterNext;
	$post_license   = isset( $_POST['input'] ) ? sanitize_text_field( wp_unslash( $_POST['input'] ) ) : '';
	$update_status  = isset( $_POST['update_status'] ) ? sanitize_text_field( wp_unslash( $_POST['update_status'] ) ) : '';
	if ( "" != $post_license ) {

		$settings    = get_option( 'qsm_addon_extra_shortcodes_settings', array() );
		$license     = isset( $settings['license_key'] ) ? trim( $settings['license_key'] ) : '';

		if ( class_exists ( 'QSM_Check_License' ) ) {
			$activation = $mlwQuizMasterNext->check_license->activate( $post_license, 'Extra Shortcodes' );
		}else {
			$activation = QSM_license::activate( $post_license, 'Extra Shortcodes' );
		}

		if ( ! empty($activation) && ( ( __( 'Attempting to activate a bundle\'s parent license', 'qsm-extra-shortcodes' ) == $activation['message'] || __( 'License key revoked', 'qsm-extra-shortcodes' ) == $activation['message'] || __( 'No activations left', 'qsm-extra-shortcodes' ) == $activation['message'] || __( 'License has expired', 'qsm-extra-shortcodes' ) == $activation['message'] ) || 'success' == $activation['status'] ) ) {
			$item_url = 'https://quizandsurveymaster.com/checkout/?edd_license_key='.$license.'&download_id='.QSM_EXTRA_SHORTCODES_ITEM;
			$settings['license_key'] = $post_license;
			$settings['license_status'] = 'valid';
			$settings['last_validate'] = gmdate("d-m-Y", time());
			$settings['expiry_date'] = isset($activation['expiry_date']) ? $activation['expiry_date'] : "";
			if ( 'success' == $activation['status'] ) {
				$validate = 1;
				$message = __( 'License validated Successfully', 'qsm-extra-shortcodes' );
			}elseif ( __( 'License has expired', 'qsm-extra-shortcodes' ) == $activation['message'] ) {
				$validate = 2;
				$message = __('License Key Expired. ', 'qsm-extra-shortcodes');
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
			$deactivation = QSM_license::deactivate( $license, 'Extra Shortcodes' );
		}
		if ( ! empty( $update_status ) && 'yes' === $update_status ) {
			$keys_to_exclude    = [ 'license_key', 'license_status', 'last_validate', 'expiry_date' ];
			$prev_settings      = array_diff_key($settings, array_flip($keys_to_exclude));
			$settings           = array_merge( $settings, $prev_settings );
		}
		update_option( 'qsm_addon_extra_shortcodes_settings', $settings );
		echo wp_json_encode(array(
			'validate' => $validate,
			'message'  => $message,
		));
		wp_die();
	}
}