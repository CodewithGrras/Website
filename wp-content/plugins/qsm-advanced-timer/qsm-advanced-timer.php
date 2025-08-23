<?php
/**
 * Plugin Name: Advanced Timer
 * Plugin URI: https://quizandsurveymaster.com
 * Description: More advanced options for quiz timer
 * Author: QSM Team
 * Author URI: https://quizandsurveymaster.com
 * Version: 2.3.0
 * Text Domain: qsm-advanced-timer
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'QSM_ADVANCED_TIMER_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'QSM_ADVANCED_TIMER_VERSION', '2.3.0' );

/**
 * This class is the main class of the plugin
 *
 * When loaded, it loads the included plugin files and add functions to hooks or filters. The class also handles the admin menu
 *
 * @since 1.0.0
 */
class QSM_AdvancedTimer {

	/**
	 * Version Number
	 *
	 * @var string
	 * @since 1.0.0
	 */
	public $version = QSM_ADVANCED_TIMER_VERSION;

	/**
	 * Main Construct Function
	 *
	 * Call functions within class
	 *
	 * @since 1.0.0
	 * @uses QSM_AdvancedTimer::load_dependencies() Loads required filed
	 * @uses QSM_AdvancedTimer::add_hooks() Adds actions to hooks and filters
	 * @return void
	 */
	public function __construct() {
		$this->load_dependencies();
		$this->add_hooks();
		$this->check_license();
		define( 'QSM_ADVANCED_TIMER_ITEM', 109654 );
	}

	/**
	 * Load File Dependencies
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function load_dependencies() {
		include 'php/license.php';
		include 'php/addon-settings-tab-content.php';
		include 'php/quiz-settings-tab-content.php';
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

		add_action( 'admin_init', 'qsm_addon_advanced_timer_register_stats_tabs' );

		// Load quiz settings.
		add_action( 'admin_init', 'qsm_addon_advanced_timer_register_quiz_settings_tabs' );
		add_filter( 'qmn_json_data', array( $this, 'qsm_addon_advanced_timer_json_data' ), 10, 3 );
		add_filter( 'qmn_end_quiz_form', array( $this, 'qsm_addon_advanced_timer_stop_timer_btn' ), 10, 3 );
		add_filter( 'qmn_begin_quiz_options', array( $this, 'qsm_addon_advanced_timer_update_timer_values' ), 2, 2 );
		add_filter( 'qmn_begin_quiz_form', array( $this, 'qsm_addon_advanced_timer_check' ), 20, 3 );
		add_filter( 'qmn_begin_quiz_form', array( $this, 'qsm_addon_advanced_timer_check_before' ), 10, 3 );
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ), 9999 );
		add_filter( 'qsm_load_setting_fields_before', array( $this, 'qmn_reordering_setting_tab' ), 10, 1 );
		add_action( 'qmn_quiz_created', array( $this, 'qsm_default_advance_timer_option'), 1, 1 );

		// Enqueue front js.
		add_action( 'wp_enqueue_scripts', array( &$this, 'qsm_advanced_timer_enqueue_front_script' ) );
		add_filter( 'qmn_begin_quiz', array( $this, 'qsm_addon_advanced_timer_check_before_begin_quiz' ), 32, 3 );

		add_filter('qsm_register_settings_before', array($this, 'qsm_advanced_timer_add_hour_minute_fields'), 10, 2);
		// Check QSM core plugin.
		add_action( 'admin_notices', array( $this, 'qsm_addon_advanced_timer_notice' ) );
		add_action( 'qsm_action_quiz_page_attributes_fields', array( $this, 'qsm_action_quiz_page_attributes_fields' ) );

		// Add popup for stop timer.
		add_filter( 'qmn_end_shortcode', array( $this, 'qsm_addon_advanced_timer_display_popup_div' ), 20, 3 );

		/**
		 * Page Timer Functions
		 */
		add_action( 'qsm_action_before_page', array( $this, 'qsm_timer_before_page' ), 10, 2 );
		add_filter( 'qsm_auto_page_begin_pagination', array( $this, 'qsm_timer_before_auto_page' ), 20, 4 );
		add_filter( 'qmn_end_shortcode', array( $this, 'qsm_page_timer_display_popup_div' ), 20, 3 );
		add_filter( 'mlw_qmn_template_variable_results_page', array( $this, 'qsm_show_timer_perpage_on_front' ), 10, 2 );
		add_filter( 'qmn_email_template_variable_results', array( $this, 'qsm_show_timer_perpage_on_front' ), 10, 2 );
		add_filter( 'qsm_quiz_submission_section_before', array( $this, 'qsm_quiz_submission_section_before_func' ), 10, 2 );

		add_action( 'plugins_loaded', array( $this, 'qsm_addon_qsm_advanced_timer_textdomain' ) );
		add_action( 'wp_ajax_qsm_advanced_t_validate_license', array( $this, 'qsm_advanced_t_validate_license' ) );

	}

	public function qsm_quiz_submission_section_before_func( $settings, $fields ) {
		$hours   = isset( $settings['timer_limit_hour'] ) ? $settings['timer_limit_hour'] : 0;
		$seconds = isset( $settings['timer_limit_seconds'] ) ? $settings['timer_limit_seconds'] : 0;
		$minutes = isset( $settings['timer_limit'] ) ? $settings['timer_limit'] : 0;

		$hoursInSeconds = $hours * 3600;
		$minutesInSeconds = $minutes * 60;

		// Add up all seconds
		$totalSeconds = $hoursInSeconds + $minutesInSeconds + $seconds;

		// Calculate hours, minutes, and remaining seconds
		$calculatedHours = floor($totalSeconds / 3600);
		$remainingSeconds = $totalSeconds % 3600;
		$calculatedMinutes = floor($remainingSeconds / 60);

		// Update settings array
		$settings['timer_limit_hour'] = $calculatedHours;
		$settings['timer_limit'] = $calculatedMinutes;

		return $settings;
	}

	public function qsm_addon_advanced_timer_update_timer_values($options, $quiz_data){
		$timer_limit = 0;
		$timer_limit_hour = 0;
		$timer_limit_seconds = 0;

		if (!empty($options->timer_limit) && $options->timer_limit > 0) {
			$timer_limit = $options->timer_limit;
		}
		if (!empty($options->timer_limit_hour) && $options->timer_limit_hour > 0) {
			$timer_limit_hour = $options->timer_limit_hour;
		}
		if (!empty($options->timer_limit_seconds) && $options->timer_limit_seconds > 0) {
			$timer_limit_seconds = $options->timer_limit_seconds;
		}

		$minutes = $timer_limit;
		$minutes = $minutes + $timer_limit_hour * 60;
		if (!empty($timer_limit_seconds) && $timer_limit_seconds > 0) {
			$minutes = $minutes + $timer_limit_seconds / 60;
			$minutes = number_format($minutes, 4);
		}

		$options->timer_limit = $minutes;
		return $options;
	}

	public function qsm_advanced_timer_add_hour_minute_fields($field_array){
		if(isset($field_array['type']) && $field_array['type'] === 'multiple_fields') {
			if(isset($field_array['fields']['timer_limit'])) {
				$timer_limit_found = false;
				$temp_fields = array();

				foreach($field_array['fields'] as $key => $field) {
					if($key === 'timer_limit') {
						$timer_limit_found = true;
						$temp_fields['timer_limit_hour'] = array(
							'type' => 'number',
							'placeholder' =>  __( 'Hours', 'qsm-advanced-timer' ),
							'prefix_text' =>  __( 'Hours', 'qsm-advanced-timer' ),
							'default' => 0
						);
					}
					$temp_fields[$key] = $field;
					if($timer_limit_found && $key === 'timer_limit') {
						$temp_fields['timer_limit_seconds'] = array(
							'type' => 'number',
							'placeholder' => __( 'Seconds', 'qsm-advanced-timer' ),
							'prefix_text' => __( 'Seconds', 'qsm-advanced-timer' ),
							'default' => 0,
							'max' => 60
						);
					}
				}
				$temp_fields['timer_limit']['placeholder'] = __( 'Minutes', 'qsm-advanced-timer' );
				$temp_fields['timer_limit']['prefix_text'] = __( 'Minutes', 'qsm-advanced-timer' );
				$temp_fields['timer_limit']['suffix_text'] = '<label class="qsm-opt-desc">' . __( 'Set it to 0 or blank to remove the time restriction.', 'qsm-advanced-timer' ) . '</small></i></label>';
				$field_array['fields'] = $temp_fields;
			}
		}
		return $field_array;
	}

	public function qsm_addon_advanced_timer_check_before_begin_quiz( $html, $options, $quiz_data ){
		global $mlwQuizMasterNext;
		$at_data = $mlwQuizMasterNext->pluginHelper->get_quiz_setting( "advanced_timer_integration_settings" );
		if ( !empty( $at_data['qsm_refresh_timer_on_reload'] ) ) {
			$quiz_id = $options->quiz_id;
			$html .= "<script>
			if (typeof qmn_quiz_data != 'undefined' && qmn_quiz_data) {
				var quiz_id = {$quiz_id};
				localStorage.setItem('mlw_started_quiz' + quiz_id, 'no');
				localStorage.setItem('mlw_time_consumed_quiz' + quiz_id, 1);
				localStorage.setItem('mlw_time_quiz' + quiz_id, parseFloat(qmn_quiz_data[quiz_id].timer_limit) * 60);
				jQuery.each(qmn_quiz_data[quiz_id].qpages, function (qpageId, qpage) {
					localStorage.removeItem('qsm_quiz_current_page_started_at_' + quiz_id + 'page_' + qpage.id);
					localStorage.removeItem('time_taken_' + quiz_id + '_page' + qpage.id);
					localStorage.removeItem('mlw_started_q' + quiz_id + '_page' + qpage.id);
					localStorage.removeItem('mlw_stoped_q' + quiz_id + '_page' + qpage.id);
					localStorage.removeItem('mlw_time_q' + quiz_id + '_page' + qpage.id);
					if (typeof qpage.timerInterval !== 'undefined') {
						clearInterval(qpage.timerInterval);
					}
				});
			}
			</script>";
		}
		return $html;
	}

	public function qsm_default_advance_timer_option(){
		global $mlwQuizMasterNext;
		$at_defaults = array(
			'timer_design'                  => 'oval_timer',
		);
		$mlwQuizMasterNext->pluginHelper->update_quiz_setting( "advanced_timer_integration_settings", $at_defaults );
	}

	public function admin_enqueue_scripts(){
		wp_enqueue_script( 'advanced-t-c-admin_js', plugins_url( 'js/admin.js' , __FILE__ ), array( 'jquery' ), QSM_ADVANCED_TIMER_VERSION );
	}

	public function qsm_timer_before_auto_page( $display, $current_page, $quiz_options, $questions ) {
		if ( ! empty( $quiz_options->pagination ) && ( ! empty($quiz_options->advance_per_page_timer) || ! empty($quiz_options->advance_per_page_timer_seconds)) ) {
			?>
			<div class="page-timer-wrapper">
				<div id="qsm-pagetimer-<?php echo esc_attr( $current_page ); ?>" class="qsm-pagetimer" data-id="<?php echo esc_attr( $current_page ); ?>" style="display:none;"></div>
				<div style="display: none;" id="qsm-pagetimer-warning-<?php echo esc_attr( $current_page ); ?>" class="qsm-pagetimer-warning"><?php esc_html_e( 'You are running out of time! few seconds are remaining.', 'qsm-advanced-timer' ); ?></div>
				<input type="hidden" name="pagetime[<?php echo esc_attr( $current_page ); ?>]" id="pagetime_<?php echo esc_attr( $current_page ); ?>">
			</div>
			<?php
		}
	}

	/**
	 * Reordering settings tab
	 *
	 * @since 1.0.1
	 * @param array $field_array An array of the components for the settings field
	 */
	public function qmn_reordering_setting_tab( $field_array ) {
		$id1 = 'question_numbering';
		$id3 = 'advance_per_page_timer';
		$key1 = null;
		$key3 = null;
		// Find the keys for the elements with the specified "id" values
		foreach ( $field_array as $key => $item ) {
			if ( $item['id'] === $id1 ) {
				$key1 = $key;
			} elseif ( $item['id'] === $id3 ) {
				$key3 = $key;
			}
			// Break the loop if both keys are found
			if ( $key1 !== null && $key3 !== null ) {
				break;
			}
		}
		// Swap the elements if both keys are found
		if ( $key1 !== null && $key3 !== null ) {
			$temp = $field_array[ $key1 ];
			$field_array[ $key1 ] = $field_array[ $key3 ];
			$field_array[ $key3 ] = $temp;
		}

		return $field_array;
	}

	/**
	 * Add notice for QSM main plugin.
	 *
	 * @since 1.0.0
	 */
	public function qsm_addon_advanced_timer_notice() {
		wp_enqueue_style( 'advance_timer_admin_style', plugins_url( 'css/admin.css', __FILE__ ), array(), $this->version );
		if ( class_exists( 'MLWQuizMasterNext' ) ) {
			global $mlwQuizMasterNext;
			$current_version = $mlwQuizMasterNext->version;
			$link = "https://wordpress.org/plugins/quiz-master-next/";
			if ( version_compare( $current_version, '6.4.8', '>=' ) ) {
				// do nothing.
			} else {
				echo '<div class="error"><p>' . esc_html_e( "QSM - Advanced Timer requires at least Quiz And Survey Master V6.4.8.", "qsm-advanced-timer" ) . '</p></div>';
			}
			if ( version_compare($current_version, '8.2.0', '<') ) {
				echo '<div class="warning notice notice-warning is-dismissible"><p>' . __( 'We\'ve noticed that you\'re using a new advanced timer version (2.0 or higher), which is now compatible with QSM core 8.2.0. To access all of the advanced timer functions, ', 'qsm-advanced-timer' ).'<a href="'.esc_url($link).'">'.__( 'update QSM core', 'qsm-advanced-timer').'</a>'. __( ' to 8.2.0 or latest.', 'qsm-advanced-timer' ) . '</p></div>';
			}
		} else {
			echo '<div class="error"><p>' . esc_html_e( "QSM - Advanced Timer requires Quiz And Survey Master. Please install and activate the Quiz And Survey Master plugin.", "qsm-advanced-timer" ) . '</p></div>';
		}
	}

	/**
	 * Display the big timer.
	 *
	 * @since 1.0.0
	 * @param string $display Content.
	 * @param object $qmn_quiz_options Quiz option.
	 * @param array  $qmn_array_for_variables Quiz variables.
	 * @return string
	 */
	public function qsm_addon_advanced_timer_check( $display, $qmn_quiz_options, $qmn_array_for_variables ) {
		$x                                   = maybe_unserialize( $qmn_quiz_options->quiz_settings );
		$default_both_timer = 'no';
		$advanced_timer_integration_settings = isset( $x['advanced_timer_integration_settings'] ) ? maybe_unserialize( $x['advanced_timer_integration_settings'] ) : array();
		if(!isset($advanced_timer_integration_settings['show_both_timers'])) {
			if ( (! empty( $qmn_quiz_options->timer_limit ) && 0 < $qmn_quiz_options->timer_limit) && (! empty($qmn_quiz_options->advance_per_page_timer) && 0 < $qmn_quiz_options->advance_per_page_timer )) {
				$default_both_timer = 'yes';
			}
		}
		$default_timer_face = 'oval_timer';
		if(!isset($advanced_timer_integration_settings['timer_design'])) {
			$default_timer_face = 'right_bottom_timer';
		}
		$at_defaults = array(
			'start_timer_page'              => '1',
			'custome_timer_warning'         => __('Your quiz time is about to finish. Few seconds left.', 'qsm-advanced-timer'),
			'show_stop_timer'               => 'no',
			'timer_design'                  => $default_timer_face,
			'time_text_color'               => '#000000',
			'time_progress_color'           => '#1dd969',
			'time_background_color'         => '#ffffff',
			'show_warning'                  => 'no',
			'timer_continues_after_closing' => 'no',
			'show_both_timers'              => $default_both_timer,
		);

		$advanced_timer_integration_settings = wp_parse_args($advanced_timer_integration_settings, $at_defaults);
		if ( isset( $advanced_timer_integration_settings['timer_design'] ) && $advanced_timer_integration_settings['timer_design'] == 'big_timer' ) {
			$display  = str_replace( 'mlw_qmn_timer', '', $display );
			$display .= '<div class="second circle circle-custom-timer" style="display: none;"><strong></strong></div><div style="display: none;" class="hiddentimer">0</div>';
		}elseif ( isset( $advanced_timer_integration_settings['timer_design'] ) && $advanced_timer_integration_settings['timer_design'] == 'linear_timer' ) {
			$display  = str_replace( 'mlw_qmn_timer', '', $display );
			$display .= '<div class="linear-custom-timer" style="display: none;">
			<div class="linear-timer-span">
			<span></span>
			<span></span>
			<span></span>
			<span></span>
			<span></span>
			<span></span>
			<span></span>
			<span></span>
			<span></span>
			<span></span>
			</div>
			<div class="linear-timer-text">00:00
			</div>
			<div class="linear-timer-status"></div>
			</div>';
		}elseif ( isset( $advanced_timer_integration_settings['timer_design'] ) && $advanced_timer_integration_settings['timer_design'] == 'v_line_timer' ) {
			$display  = str_replace( 'mlw_qmn_timer', '', $display );
			$display .= '<div class="qsm-v-line-timer-top" style="display: none;">
			<div style="text-align: center;">
			<div class="qsm-v-line-time-text">00:00</div>
			<div class="qsm-v-line-time-status"></div></div>
			<div class="qsm-v-line-timer-progressbar" >
			<div class="qsm-v-line-timer-percentage-line"></div>
		</div></div>
		';
		}elseif ( isset( $advanced_timer_integration_settings['timer_design'] ) && $advanced_timer_integration_settings['timer_design'] == 'box_timer' ) {
			$display  = str_replace( 'mlw_qmn_timer', '', $display );
			$display .= '<div class="box-timer-top" style="display: none;">
			<div class="box-timer-text">12:55</div>
			<div class="box-timer-status"></div>
			<div class="box-timer-progressbar">
			<div class="box-timer-percentage-line"></div>
			</div>
			</div>';
		}elseif ( isset( $advanced_timer_integration_settings['timer_design'] ) && $advanced_timer_integration_settings['timer_design'] == 'oval_timer' ) {
			$display  = str_replace( 'mlw_qmn_timer', '', $display );
			$display .= '<div class="oval-timer-top" style="display: none;">
			<span class="oval-timer-label-top"></span>
			<span class="hour">00</span>
			<span class="minute">00</span>
			<span class="second">00</span>
			<span class="oval-timer-label-bottom"></span>
			<div class="oval-timer-progressbar"><div class="oval-timer-percentage-line"></div></div>
			</div>';
		}elseif ( isset( $advanced_timer_integration_settings['timer_design'] ) && $advanced_timer_integration_settings['timer_design'] == 'half_timer' ) {
			$display  = str_replace( 'mlw_qmn_timer', '', $display );
		$display .= '<div class="half-circle-timer" style="display: none;"><div class="base-timer">
			<svg class="base-timer_svg" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
			<g class="base-timer_circle">
			<circle class="base-timer_path-elapsed" cx="50" cy="0" r="47" />
			<circle class="base-timer_path-remaining" cx="50" cy="0" r="47" />
			</g>
			</svg>
			<span class="half-timer_label">
			</span>
			</div>
			<span class="half-timer_text_label">00
			</span></div>';
		}elseif ( isset( $advanced_timer_integration_settings['timer_design'] ) && $advanced_timer_integration_settings['timer_design'] == 'shade_timer' ) {
			$display  = str_replace( 'mlw_qmn_timer', '', $display );
			$display .= '<div class="qsm-shade-circle-timer" style="display: none;" ><div class="base-timer">
				<svg class="base-timer_svg" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
				<g class="base-timer_circle">
				<circle class="base-timer_path-elapsed" cx="50" cy="50" r="47" />
				<circle class="base-timer_path-remaining" cx="50" cy="50" r="47" />
				</g>
				</svg>
				<span class="qsm-shade-timer-label">
				</span>
				</div>
				<span class="qsm-shade-timer-text-label">
				</span></div>';
			}

		return $display;
	}

	public function qsm_addon_advanced_timer_check_before( $display, $qmn_quiz_options, $qmn_array_for_variables ) {
		$x                                   = maybe_unserialize( $qmn_quiz_options->quiz_settings );
		$default_both_timer = 'no';
		$advanced_timer_integration_settings = isset( $x['advanced_timer_integration_settings'] ) ? maybe_unserialize( $x['advanced_timer_integration_settings'] ) : array();
		if(!isset($advanced_timer_integration_settings['show_both_timers'])) {
			if ( (! empty( $qmn_quiz_options->timer_limit ) && 0 < $qmn_quiz_options->timer_limit) && (! empty($qmn_quiz_options->advance_per_page_timer) && 0 < $qmn_quiz_options->advance_per_page_timer )) {
				$default_both_timer = 'yes';
			}
		}
		$default_timer_face = 'oval_timer';
		if(!isset($advanced_timer_integration_settings['timer_design'])) {
			$default_timer_face = 'right_bottom_timer';
		}
		$at_defaults = array(
			'start_timer_page'              => '1',
			'custome_timer_warning'         => __('Your quiz time is about to finish. Few seconds left.', 'qsm-advanced-timer'),
			'show_stop_timer'               => 'no',
			'timer_design'                  => $default_timer_face,
			'time_text_color'               => '#000000',
			'time_progress_color'           => '#1dd969',
			'time_background_color'         => '#ffffff',
			'show_warning'                  => 'no',
			'timer_continues_after_closing' => 'no',
			'show_both_timers'              => $default_both_timer,
		);
		$advanced_timer_integration_settings = wp_parse_args($advanced_timer_integration_settings, $at_defaults);
		if ( isset( $advanced_timer_integration_settings['show_both_timers'] ) && "no" == $advanced_timer_integration_settings['show_both_timers'] ) {
			global $mlwQuizMasterNext;
			$pages = $mlwQuizMasterNext->pluginHelper->get_quiz_setting( 'pages', array() );
			if ( 0 == $qmn_quiz_options->question_from_total && 0 == $qmn_quiz_options->pagination && is_countable($pages) && 0 !== count( $pages ) ) {
				$qpages = $mlwQuizMasterNext->pluginHelper->get_quiz_setting( 'qpages', array() );
				$minutes = 0;
				$seconds = 0;
				$total = 0;
				if ( ! empty($qpages) ) {
					foreach ( $qpages as $key => $pagevalue ) {
						if ( isset($pagevalue['pagetimer']) && 0 != $pagevalue['pagetimer'] ) {
							$minutes = (int)$pagevalue['pagetimer'];
						}
						if ( isset($pagevalue['pagetimer_second']) && 0 != $pagevalue['pagetimer_second'] ) {
							$seconds = (int)$pagevalue['pagetimer_second'];
						}
						$total = $minutes + $seconds;
					}
				}
				if ( 0 < $total ) {
					$qmn_quiz_options->timer_limit = 0;
				}
			} else {
				if ( ! empty($qmn_quiz_options->advance_per_page_timer) || ! empty($qmn_quiz_options->advance_per_page_timer_seconds) ) {

					$qmn_quiz_options->timer_limit = 0;
				}
			}
			if ( isset( $advanced_timer_integration_settings['timer_design'] ) && $advanced_timer_integration_settings['timer_design'] == 'right_bottom_timer' ) {
				$display                     .= '<div style="display: none;" class=" custom-mlw_qmn_timer"></div>';
			}
			return $display;
		}
	}

	/**
	 * Add the scripts and style for front.
	 *
	 * @since 1.0.0
	 */
	public function qsm_advanced_timer_enqueue_front_script() {
		wp_enqueue_script( 'qsm-at-circle-progress-js', plugin_dir_url( __FILE__ ) . 'js/circle-progress.js', array( 'jquery', 'qsm_quiz' ), $this->version, true );
		wp_enqueue_script( 'qsm-at-front-js', plugin_dir_url( __FILE__ ) . 'js/front.js', array( 'jquery', 'qsm_quiz' ), $this->version, true );
		// Enqueue the style.
		wp_enqueue_style( 'qsm-at-front-css', plugin_dir_url( __FILE__ ) . 'css/front.css', array( 'qmn_quiz_common_style' ), $this->version );
	}

	/**
	 * Return stop timer div structure
	 *
	 * @since 1.0.0
	 * @param string $quiz_display Display content.
	 * @param object $options Quiz options.
	 * @param array  $quiz_data Quiz data.
	 * @return string
	 */
	public function qsm_addon_advanced_timer_stop_timer_btn( $quiz_display, $options, $quiz_data ) {
		$x                                   = maybe_unserialize( $options->quiz_settings );
		$advanced_timer_integration_settings = isset( $x['advanced_timer_integration_settings'] ) ? maybe_unserialize( $x['advanced_timer_integration_settings'] ) : array();
		$default_timer_face = 'oval_timer';
		if(!isset($advanced_timer_integration_settings['timer_design'])) {
			$default_timer_face = 'right_bottom_timer';
		}
		$at_defaults = array(
			'custome_timer_warning'         => __('Your quiz time is about to finish. Few seconds left.', 'qsm-advanced-timer'),
			'show_stop_timer'               => 'no',
			'timer_design'                  => $default_timer_face
		);

		$advanced_timer_integration_settings = wp_parse_args($advanced_timer_integration_settings, $at_defaults);
		if ( isset( $advanced_timer_integration_settings['show_stop_timer'] ) && $advanced_timer_integration_settings['show_stop_timer'] == 'yes' ) {
			$quiz_display .= '<p class="stoptimer-p" style="margin-bottom:20px;display: none;text-align: center;"><a href="javascript:;" class="button stoptimer"><span class="qsm-stop-icon"></span>' . __( 'Stop Timer', 'qsm-advanced-timer' ) . '</a></p>';
		}
		if ( isset( $advanced_timer_integration_settings['show_warning'] ) && $advanced_timer_integration_settings['show_warning'] == 'yes' ) {
			$quiz_display .= '<div style="display: none;" class="qsm_ninety_warning">' . esc_html($advanced_timer_integration_settings['custome_timer_warning']) . '</div>';
		}
		return $quiz_display;
	}

	/**
	 * Add the advanced timer array.
	 *
	 * @since 1.0.0
	 * @param array  $qmn_json_data Quiz data.
	 * @param object $qmn_quiz_options Quiz options.
	 * @param array  $qmn_array_for_variables Quiz variables.
	 * @return array
	 */
	public function qsm_addon_advanced_timer_json_data( $qmn_json_data, $qmn_quiz_options, $qmn_array_for_variables ) {
		$x                                   = maybe_unserialize( $qmn_quiz_options->quiz_settings );
		$default_both_timer = 'no';
		$default_timer_face = 'oval_timer';
		$advanced_timer_integration_settings = isset( $x['advanced_timer_integration_settings'] ) ? maybe_unserialize( $x['advanced_timer_integration_settings'] ) : array();
		if(!isset($advanced_timer_integration_settings['show_both_timers'])) {
			if ( (! empty( $qmn_quiz_options->timer_limit ) && 0 < $qmn_quiz_options->timer_limit) && (! empty($qmn_quiz_options->advance_per_page_timer) && 0 < $qmn_quiz_options->advance_per_page_timer )) {
				$default_both_timer = 'yes';
			}
		}
		if(!isset($advanced_timer_integration_settings['timer_design'])) {
			$default_timer_face = 'right_bottom_timer';
		}
		$at_defaults = array(
			'start_timer_page'              => '1',
			'custome_timer_warning'         => __('Your quiz time is about to finish. Few seconds left.', 'qsm-advanced-timer'),
			'show_stop_timer'               => 'no',
			'timer_design'                  => $default_timer_face,
			'time_text_color'               => '#000000',
			'time_progress_color'           => '#1dd969',
			'time_background_color'         => '#ffffff',
			'show_warning'                  => 'no',
			'timer_continues_after_closing' => 'no',
			'show_both_timers'              => $default_both_timer,
			'hours'              			=> __( 'Hours', 'qsm-advanced-timer' ),
			'minutes'              			=> __( 'Minutes', 'qsm-advanced-timer' ),
			'seconds'              			=> __( 'Seconds', 'qsm-advanced-timer' ),
			'hrs'              				=> __( 'HRS', 'qsm-advanced-timer' ),
			'min'              				=> __( 'MIN', 'qsm-advanced-timer' ),
			'sec'              				=> __( 'SEC', 'qsm-advanced-timer' ),
			'check_hour'              		=> ! empty( $qmn_quiz_options->timer_limit_hour ) && 0 < $qmn_quiz_options->timer_limit_hour ? 1 : 0,
            'qsm_continue_after_timer_ends' => 0,
		);
		$advanced_timer_integration_settings = wp_parse_args($advanced_timer_integration_settings, $at_defaults);
		$qmn_json_data['advanced_timer']     = $advanced_timer_integration_settings;
		$pagination_option = $qmn_quiz_options->pagination;
		if ( (isset($qmn_quiz_options->advance_per_page_timer) || isset($qmn_quiz_options->advance_per_page_timer_seconds)) && 0 != $pagination_option ) {
			$seconds = isset($qmn_quiz_options->advance_per_page_timer_seconds) ? (int)$qmn_quiz_options->advance_per_page_timer_seconds : 0;
			$minutesecond = isset($qmn_quiz_options->advance_per_page_timer) ? (int)$qmn_quiz_options->advance_per_page_timer * 60 : 0;
			$totalSeconds = $minutesecond + $seconds;
			$decimalMinutes = $totalSeconds / 60;
			$each_page_time = number_format($decimalMinutes, 4);
			$qmn_json_data['advance_per_page_timer'] = $each_page_time;
			$each_page_question = intval( $qmn_quiz_options->pagination );
			$pages = $qmn_json_data['qpages'];
			if(isset($qmn_json_data['question_list'])) {
				$total_questions = count($qmn_json_data['question_list']);
				$total_pages  = ceil( $total_questions / $each_page_question );
				$index = 0;
				for ( $i = 1; $i <= $total_pages; $i++ ) {
					$pages[ $i ]['id'] = $i;
					$pages[ $i ]['quizID'] = $qmn_json_data['quiz_id'];
					$pages[ $i ]['pagekey'] = ! isset($pages[ $i ]['pagekey']) ? uniqid() : $pages[ $i ]['pagekey'];
					$pages[ $i ]['hide_prevbtn'] = 0;
					$pages[ $i ]['pagetimer'] = $each_page_time;
					$pages[ $i ]['pagetimer_warning'] = 0.05;
				}
			}
			$qmn_json_data['qpages'] = $pages;
		}
		return $qmn_json_data;
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
			// Load our custom updater.
			include 'php/EDD_SL_Plugin_Updater.php';
		}
		// Retrieves our license key from the DB.
		$settings    = get_option( 'qsm_addon_advanced_timer_settings', '' );
		$license_key = isset( $settings['license_key'] ) ? trim( $settings['license_key'] ) : '';

		// Sets up the updater.
		$edd_updater = new EDD_SL_Plugin_Updater(
			'https://quizandsurveymaster.com', __FILE__, array(
				'version'   => $this->version,
				'license'   => $license_key,
				'item_name' => urlencode( 'Advanced Timer' ),
				'author'    => 'QSM Team',
			)
		);
	}

	public function qsm_action_quiz_page_attributes_fields() {
		global $mlwQuizMasterNext;
		$current_version = $mlwQuizMasterNext->version;
		if ( version_compare($current_version, '8.2.0', '<') ) {
			?>
			<div class="qsm-row">
				<div class="qsm-popup-upgrade-info " style="max-width: 500px;">
					<span><?php _e( 'To access all the Advanced Timer features, kindly update to QSM core version 8.2.0 or later.', 'qsm-advanced-timer' ); ?></span>
				</div>
			</div>
			<?php
		}
	}

	/**
	 * Advance Timer display popup
	 *
	 * @param string $return_display display content.
	 * @param object $qmn_quiz_options Quiz options.
	 * @param array  $qmn_array_for_variables Quiz varibales.
	 * @return string $return_display
	 */
	public function qsm_addon_advanced_timer_display_popup_div( $return_display, $qmn_quiz_options, $qmn_array_for_variables ) {
		$x                                   = maybe_unserialize( $qmn_quiz_options->quiz_settings );
		$advanced_timer_integration_settings = isset( $x['advanced_timer_integration_settings'] ) ? maybe_unserialize( $x['advanced_timer_integration_settings'] ) : array();
		if ( isset( $advanced_timer_integration_settings['show_stop_timer'] ) && "yes" == $advanced_timer_integration_settings['show_stop_timer'] ) {
			$return_display .= '<div class="qsm-popup qsm-popup-slide" id="stop-timer-popup" aria-hidden="false" style="display: none;">';
			$return_display .= '<div class="qsm-popup__overlay" tabindex="-1" data-micromodal-close="">';
			$return_display .= '<div class="qsm-popup__container qmn_quiz_container" role="dialog" aria-modal="true" >';
			$return_display .= '<div class="qsm-popup__content">';
			$return_display .= '<p class="qsm-time-up-text">';
			$return_display .= __( 'Are you sure you want to submit this quiz?', 'qsm-advanced-timer' );
			$return_display .= '</p>';
			$return_display .= '</div>';
			$return_display .= '<footer class="qsm-popup__footer"><button class="qsm-popup-secondary-button qmn_btn stop-timer-continue-the-quiz" data-micromodal-close="" aria-label="Close this dialog window">' . __( 'Continue Quiz', 'qsm-advanced-timer' ) . '</button><button data-quiz_id="' . $qmn_quiz_options->quiz_id . '" class="stop-timer-submit-the-form qmn_btn">' . __( 'Submit Quiz.', 'qsm-advanced-timer' ) . '</button></footer>';
			$return_display .= '</div>';
			$return_display .= '</div>';
			$return_display .= '</div>';
		}
		return $return_display;
	}

	/**
	 * Add Timer Block before Page content
	 *
	 * @param int   $qpage_id Quiz page ID.
	 * @param array $qpage Quiz array.
	 * @return void
	 */
	public function qsm_timer_before_page( $qpage_id, $qpage ) {

		if ( (!isset( $qpage['warning_checkbox'] ) && isset( $qpage['pagetimer_warning'] ) && $qpage['pagetimer_warning'] > 0) || (isset( $qpage['pagetimer'] ) && $qpage['pagetimer'] > 0) || isset( $qpage['pagetimer_second'] ) && $qpage['pagetimer_second'] > 0 ) {
			?>
			<div class="page-timer-wrapper">
				<div id="qsm-pagetimer-<?php echo esc_attr( $qpage_id ); ?>" class="qsm-pagetimer" data-id="<?php echo esc_attr( $qpage_id ); ?>" style="display:none;"></div>
				<div style="display: none;" id="qsm-pagetimer-warning-<?php echo esc_attr( $qpage_id ); ?>" class="qsm-pagetimer-warning"><?php esc_html_e( 'You are running out of time! few seconds are remaining.', 'qsm-advanced-timer' ); ?></div>
				<input type="hidden" name="pagetime[<?php echo esc_attr( $qpage['pagekey'] ); ?>]" id="pagetime_<?php echo esc_attr( $qpage_id ); ?>">
			</div>
			<?php
		}
	}

	/**
	 * Show per page timer content.
	 *
	 * @since 1.0.6
	 * @param string $content Result page content.
	 * @param array  $mlw_quiz_array Quiz result data.
	 * @return $content
	 */
	public function qsm_show_timer_perpage_on_front( $content, $mlw_quiz_array ) {
		global $wpdb;
		$result_id    = isset( $mlw_quiz_array['result_id'] ) ? intval( $mlw_quiz_array['result_id'] ) : 0;
		$results_data = $wpdb->get_var( $wpdb->prepare( "SELECT quiz_results FROM {$wpdb->prefix}mlw_results WHERE result_id = %d", $result_id ) );
		$results      = maybe_unserialize( $results_data );
		$normal_time  = '';
		$minutes_time = '';
		$seconds_time = '';
		$table_head   = '';
		$table_close  = '';
		$pagetime     = isset( $results['pagetime'] ) ? $results['pagetime'] : array();
		if ( ! empty( $pagetime ) ) {
			$table_head = '<table border="1"  class="qsm-advance-timer-table"><thead><tr><th>' . __( 'Page', 'qsm-advanced-timer' ) . '</th><th>' . __( 'Time', 'qsm-advanced-timer' ) . '</th></tr></thead>';
			foreach ( $pagetime as $key => $seconds ) {
				$seconds = round( intval( $seconds ) );
				$hours   = floor( $seconds / 3600 );
				$mins    = floor( $seconds / 60 % 60 );
				$secs    = floor( $seconds % 60 );

				$hours_html = $hours > 0 ? $hours . __( 'hours', 'qsm-advanced-timer' ) . ' : ' : '';
				$mins_html  = $mins > 0 ? sprintf( '%02d', $mins ) . __( 'minutes', 'qsm-advanced-timer' ) . ' : ' : '';

				$table_row       = '<tr><td>' . $key . '</td><td>';
				$table_row_close = '</td></tr>';

				$normal_time  .= $table_row . $hours_html . $mins_html . sprintf( '%02d', $secs ) . __( 'seconds', 'qsm-advanced-timer' ) . $table_row_close;
				$minutes_time .= $table_row . $mins_html . $table_row_close;
				$seconds_time .= $table_row . sprintf( '%02d', $seconds ) . __( ' seconds', 'qsm-advanced-timer' ) . $table_row_close;
			}
			$table_close = '</table>';
		}
		$content = str_replace( '%TIME_PER_PAGE%', $table_head . $normal_time . $table_close, $content );
		while ( strpos( $content, '%TIME_PER_PAGE_' ) !== false ) {
			$page_name = mlw_qmn_get_string_between( $content, '%TIME_PER_PAGE_', '%' );
			$str       = '';
			if ( isset( $pagetime[ $page_name ] ) ) {
				$seconds    = round( $pagetime[ $page_name ] );
				$seconds    = round( $seconds );
				$hours      = floor( $seconds / 3600 );
				$mins       = floor( $seconds / 60 % 60 );
				$secs       = floor( $seconds % 60 );
				$hours_html = $hours > 0 ? $hours . __( ' hours ', 'qsm-advanced-timer' ) . ' : ' : '';
				$mins_html  = $mins > 0 ? sprintf( '%02d', $mins ) . __( ' minutes ', 'qsm-advanced-timer' ) . ' : ' : '';
				$str        = $hours_html . $mins_html . sprintf( '%02d', $secs ) . __( ' seconds ', 'qsm-advanced-timer' );
			}
			$content = str_replace( '%TIME_PER_PAGE_' . $page_name . '%', $str, $content );
		}

		return $content;
	}

	/**
	 * Page Timer End Popup
	 *
	 * @param string $return_display Display content.
	 * @param object $qmn_quiz_options Quiz options.
	 * @param array  $qmn_array_for_variables Quiz variables.
	 * @return string
	 */
	public function qsm_page_timer_display_popup_div( $return_display, $qmn_quiz_options, $qmn_array_for_variables ) {
		$return_display .= '<div style="display: none;" class="qsm-popup qsm-popup-slide" id="modal-page-1" aria-hidden="false">';
		$return_display .= '<div class="qsm-popup__overlay" tabindex="-1" data-micromodal-close="">';
		$return_display .= '<div class="qsm-popup__container qmn_quiz_container" role="dialog" aria-modal="true">';
		$return_display .= '<main class="qsm-popup__content">';
		$return_display .= '<img src="' . QSM_PLUGIN_URL . '/assets/clock.png' . '" alt="clock"/>';
		$return_display .= '<p class="qsm-time-up-text">' . __( 'Time is Up!', 'qsm-advanced-timer' ) . '</p>';
		$return_display .= '</main>';
		$return_display .= '<footer class="qsm-popup__footer">';
		$return_display .= '<button class="qmn_btn qsm-btn qmn_btn pagetime-goto-nextpage pagetime-goto-nextslide" data-quiz_id="' . $qmn_quiz_options->quiz_id . '" style="margin: 0 10px;" data-micromodal-close="" aria-label="Close this dialog window">' . __( 'Continue', 'qsm-advanced-timer' ) . '</button>';
		$return_display .= '</footer>';
		$return_display .= '</div>';
		$return_display .= '</div>';
		$return_display .= '</div>';
		return $return_display;
	}
	/**
	 * Adds localization support for Advanced timer addon
	 */
	public function qsm_addon_qsm_advanced_timer_textdomain() {
		load_plugin_textdomain( 'qsm-advanced-timer', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
	}


	public function qsm_advanced_t_validate_license() {
		global $mlwQuizMasterNext;
		$post_license = isset( $_POST['input'] ) ? sanitize_text_field( wp_unslash( $_POST['input'] ) ) : '';
		$update_status = isset( $_POST['update_status'] ) ? sanitize_text_field( wp_unslash( $_POST['update_status'] ) ) : '';
		if ( "" != $post_license ) {

			$settings    = get_option( 'qsm_addon_advanced_timer_settings', array() );
			$license     = isset( $settings['license_key'] ) ? trim( $settings['license_key'] ) : '';

			if ( class_exists ( 'QSM_Check_License' ) ) {
				$activation = $mlwQuizMasterNext->check_license->activate( $post_license, 'Advanced Timer' );
			}else {
				$activation = QSM_license::activate( $post_license, 'Advanced Timer' );
			}

			if ( ! empty($activation) && ( ( __( 'Attempting to activate a bundle\'s parent license', 'qsm-advanced-timer' ) == $activation['message'] || __( 'License key revoked', 'qsm-advanced-timer' ) == $activation['message'] || __( 'No activations left', 'qsm-advanced-timer' ) == $activation['message'] || __( 'License has expired', 'qsm-advanced-timer' ) == $activation['message'] ) || 'success' == $activation['status'] ) ) {
				$item_url = 'https://quizandsurveymaster.com/checkout/?edd_license_key='.$license.'&download_id='.QSM_ADVANCED_TIMER_ITEM;
				$settings['license_key'] = $post_license;
				$settings['license_status'] = 'valid';
				$settings['last_validate'] = gmdate("d-m-Y", time());
				$settings['expiry_date'] = isset($activation['expiry_date']) ? $activation['expiry_date'] : "";
				if ( 'success' == $activation['status'] ) {
					$validate = 1;
					$message = __( 'License validated Successfully', 'qsm-advanced-timer' );
				}elseif ( __( 'License has expired', 'qsm-advanced-timer' ) == $activation['message'] ) {
					$validate = 2;
					$message = __('License Key Expired. ', 'qsm-advanced-timer');
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
				$deactivation = QSM_license::deactivate( $license, 'Advanced Timer' );
			}
			if ( ! empty( $update_status ) && 'yes' === $update_status ) {
				$keys_to_exclude    = [ 'license_key', 'license_status', 'last_validate', 'expiry_date' ];
				$prev_settings      = array_diff_key($settings, array_flip($keys_to_exclude));
				$settings           = array_merge( $settings, $prev_settings );
			}
			update_option( 'qsm_addon_advanced_timer_settings', $settings );
			echo wp_json_encode(array(
				'validate' => $validate,
				'message'  => $message,
			));
			wp_die();
		}
	}

}

/**
 * Add notice for QSM main plugin.
 *
 * @since 1.0.0
 */
function qsm_addon_advanced_timer_notice() {
	if ( class_exists( 'MLWQuizMasterNext' ) ) {
		new QSM_AdvancedTimer();
	} else {
		echo '<div class="error"><p>' . esc_html__( "QSM - Advanced Timer requires Quiz And Survey Master. Please install and activate the Quiz And Survey Master plugin.", "qsm-advanced-timer" ) . '</p></div>';
	}
}
add_action( 'plugins_loaded', 'qsm_addon_advanced_timer_notice' );

function qsm_timer_up_rename_cancel_button_text( $button_text ) {
	global $mlwQuizMasterNext;
    $at_data = $mlwQuizMasterNext->pluginHelper->get_quiz_setting( "advanced_timer_integration_settings" );
	if ( isset( $at_data['qsm_continue_after_timer_ends'] ) && 1 == $at_data['qsm_continue_after_timer_ends'] ) {
		return __( 'Continue', 'qsm-advanced-timer' );
	}
	return $button_text;
}
add_filter( 'qsm_timer_up_cancel_button_text_after', 'qsm_timer_up_rename_cancel_button_text', 10, 1 );

function qsm_add_overtime_taken_by_user( $content, $mlw_qmn_results_array ) {
	global $mlwQuizMasterNext;
	wp_enqueue_style( 'advance_timer_admin_style', plugins_url( 'css/admin.css', __FILE__ ), array(), QSM_ADVANCED_TIMER_VERSION );
	$at_data = $mlwQuizMasterNext->pluginHelper->get_quiz_setting( "advanced_timer_integration_settings" );
	$quiz_options = $mlwQuizMasterNext->pluginHelper->get_quiz_setting( 'quiz_options' );
	$hours   = isset( $quiz_options['timer_limit_hour'] ) ? $quiz_options['timer_limit_hour'] : 0;
	$seconds = isset( $quiz_options['timer_limit_seconds'] ) ? $quiz_options['timer_limit_seconds'] : 0;
	$minutes = isset( $quiz_options['timer_limit'] ) ? $quiz_options['timer_limit'] : 0;

	$hoursInSeconds = $hours * 3600;
	$minutesInSeconds = $minutes * 60;

	// Add up all seconds
	$totalSeconds = $hoursInSeconds + $minutesInSeconds + $seconds;
	$extraTimeString = '';
	if ( isset( $at_data['qsm_continue_after_timer_ends'] ) && 1 == $at_data['qsm_continue_after_timer_ends'] ) {
		$overdueTime = $mlw_qmn_results_array[0] - $totalSeconds;
		if ( $overdueTime > 0 ) {
			$hours = floor($overdueTime / 3600);
			$minutes = floor(($overdueTime % 3600) / 60);
			$seconds = $overdueTime % 60;
			$extraTimeString = $hours > 0 ? $hours . ':' : '';
			$extraTimeString .= $minutes < 10 ? '0' . $minutes . ':' : $minutes . ':';
			$extraTimeString .= $seconds < 10 ? '0' . $seconds : $seconds;
		}
		$overdueTimeSpan = '<span class="qsm-time-overdue">' . __('Overdue','quiz-master-next') . ' - ' . $extraTimeString . '</span>';
		return $overdueTimeSpan;
	}
}
add_filter( 'qsm_admin_results_details_timer_after', 'qsm_add_overtime_taken_by_user', 10, 2 );