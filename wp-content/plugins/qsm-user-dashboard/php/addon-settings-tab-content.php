<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


add_filter( 'qmn_end_shortcode', 'qsm_user_dashboard_inline', 4, 10 );
if ( ! function_exists( 'qsm_user_dashboard_inline' ) ) {
	/**
	 * QSM breeze theme style
	 *
	 * @since 1.0.0
	 * @param object $qmn_quiz_options Quiz options.
	 * @return void
	 */
	function qsm_user_dashboard_inline( $return_display, $qmn_quiz_options, $qmn_array_for_variables, $shortcode_args ) {
		$quiz_settings = unserialize($qmn_quiz_options->quiz_settings);
		$quiz_id = $qmn_quiz_options->quiz_id;
		global $wpdb, $mlwQuizMasterNext;
		if ( (isset($qmn_quiz_options->end_quiz_if_wrong) && 0 === intval($qmn_quiz_options->end_quiz_if_wrong)) || isset($qmn_quiz_options->enable_quick_result_mc) && 0 === intval($qmn_quiz_options->enable_quick_result_mc) ) {
			$qpages_arr = isset($quiz_settings['qpages']) ? maybe_unserialize($quiz_settings['qpages']) : array();
			$quiz_options = maybe_unserialize( $quiz_settings['quiz_options'] );
			$correct_answer_logic = isset($quiz_options['correct_answer_logic']) ? $quiz_options['correct_answer_logic'] : NULL;
			$encryption['correct_answer_logic'] = $correct_answer_logic;
			$enc_questions = array();
			if ( ! empty( $qpages_arr ) ) {
				foreach ( $qpages_arr as $item ) {
					$enc_questions = array_merge($enc_questions, $item['questions']);
				}
			}
			$enc_questions = implode(',', $enc_questions);
			$question_array = $wpdb->get_results(
				"SELECT quiz_id, question_id, answer_array, question_answer_info, question_type_new, question_settings
				FROM {$wpdb->prefix}mlw_questions
				WHERE question_id IN ($enc_questions)", ARRAY_A);
			foreach ( $question_array as $key => $question ) {
				$encryption[ $question['question_id'] ]['question_type_new'] = $question['question_type_new'];
				$encryption[ $question['question_id'] ]['answer_array'] = maybe_unserialize( $question['answer_array'] );
				$encryption[ $question['question_id'] ]['settings'] = maybe_unserialize( $question['question_settings'] );
				$encryption[ $question['question_id'] ]['correct_info_text'] = isset( $question['question_answer_info'] ) ? html_entity_decode( $question['question_answer_info'] ) : '';
				$encryption[ $question['question_id'] ]['correct_info_text'] = $mlwQuizMasterNext->pluginHelper->qsm_language_support( $encryption[ $question['question_id'] ]['correct_info_text'], "correctanswerinfo-{$question['question_id']}" );
			}
			$qsm_inline_encrypt_js = '
			if (encryptionKey === undefined) {
					var encryptionKey = {};
			}
			if (data === undefined) {
					var data = {};
			}
			if (jsonString === undefined) {
					var jsonString = {};
			}
			if (encryptedData === undefined) {
					var encryptedData = {};
			}
			
			encryptionKey['.$quiz_id.'] = "'.hash('sha256',time().$quiz_id).'";
			
			data['.$quiz_id.'] = '.wp_json_encode($encryption).';
			jsonString['.$quiz_id.'] = JSON.stringify(data['.$quiz_id.']);
			encryptedData['.$quiz_id.'] = CryptoJS.AES.encrypt(jsonString['.$quiz_id.'], encryptionKey['.$quiz_id.']).toString();';
			wp_add_inline_script('qsm_encryption', $qsm_inline_encrypt_js, 'after');
		}
		$quiz_inline_results_count = 0;
		if ( isset($quiz_settings['quiz_inline_results']) ) {
			$quiz_inline_results_count = $quiz_settings['quiz_inline_results']['quiz_inline_results_count'];
		}
		$inline_dashboard = 0;
		if ( isset($quiz_inline_results_count) && 1 == $quiz_inline_results_count ) {
			wp_enqueue_style( 'qsm_user-dashboard_css', QSM_USER_DASHBOARD_URL . '/qsm-user-dashboard-style.css', array(), QSM_USER_DASHBOARD_VERSION );
			wp_enqueue_script( 'qsm_user-dashboard_js', QSM_USER_DASHBOARD_URL . '/qsm-user-dashboard.js', array( 'jquery' ), QSM_USER_DASHBOARD_VERSION, true );
			$inline_dashboard = $quiz_inline_results_count;
		}
		wp_localize_script( 'qsm_user-dashboard_js', 'inline_dashboard', array( 'inline_dashboard' => $inline_dashboard ) );

		return $return_display;
	}
}

/**
 * Registers your tab in the addon settings page
 *
 * @since 1.1.1
 * @return void
 */
function qsm_addon_user_dashboard_register_addon_settings_tabs() {
	global $mlwQuizMasterNext;
	if ( ! is_null( $mlwQuizMasterNext ) && ! is_null( $mlwQuizMasterNext->pluginHelper ) && method_exists( $mlwQuizMasterNext->pluginHelper, 'register_quiz_settings_tabs' ) ) {
		$mlwQuizMasterNext->pluginHelper->register_addon_settings_tab( "User Dashboard Settings", 'qsm_addon_user_dashboard_addon_settings_tabs_content' );
	}
}

function qsm_addon_user_dashboard_addon_license_tabs_content() {
	global $mlwQuizMasterNext;
	
	$params      = array(
		'invalid' => __('<span class="dashicons dashicons-warning"></span><b>Incorrect License!</b> Please enter a valid license key.', 'qsm-user-dashboard'),
		'hold'    => __('Please Wait! We are validating your license', 'qsm-user-dashboard'),
		'empty'   => __('Please enter a license key.', 'qsm-user-dashboard'),
	);
	wp_localize_script( 'qsm_user-dashboard_js', 'qsm_license_validate_obj', $params );

	$date_now = date("d-m-Y");
	$settings    = wp_parse_args( get_option('mlw_qmn_dashboard_option', array()), array( 'license_key' => '' ) ) ;
	$license         = isset( $settings['license_key'] ) ? trim( $settings['license_key'] ) : '';
	$license_status  = isset( $settings['license_status'] ) ? $settings['license_status'] : '';

	if ( '' !== $license && 'valid' === $license_status ) {
		?>
		<div class="qsm-license-container">
			<div class="qsm-license-header">
				<p class="qsm-heading">
					<?php esc_html_e( 'Manage License', 'qsm-user-dashboard' ); ?>
				</p>
			</div>
			<div class='qsm-license-content'>
			<?php 
				if ( (isset($settings['expiry_date']) && "" !== $settings['expiry_date']) && (isset($settings['last_validate']) && "" !== $settings['last_validate']) && strtotime($date_now) > strtotime($settings['expiry_date']) && strtotime($date_now) >= strtotime($settings['last_validate']) ) { 
					$item_url = 'https://quizandsurveymaster.com/checkout/?edd_license_key='.$license.'&download_id='.USER_DASHBOARD_ITEM;
				?>
				<div class="qsm-license-info">
					<p class='qsm-valid-msg'>
						<img class="qsm-warning" src="<?php echo esc_attr( QSM_USER_DASHBOARD_URL . '/img/warning.png' ); ?>" alt="">
						<span class='qsm-msg qsm-addon-title'><b><?php esc_html_e( 'User Dashboard License', 'qsm-user-dashboard' ); ?></b></span>
						<span class='qsm-msg qsm-addon-status'>
							<?php esc_html_e( 'Your license is expired.', 'qsm-user-dashboard' ); ?>
							<a target="_blank" href="<?php echo esc_url( $item_url ); ?>"><?php esc_html_e( 'Renew', 'qsm-user-dashboard' ); ?></a>
						</span>
					</p>
					<a data-toggle='0' class="qsm-toggleButton" href=""><?php esc_attr_e( 'Change License', 'qsm-user-dashboard' ); ?></a>
				</div>
			<?php } else { ?>
				<div class="qsm-license-info">
					<p class='qsm-valid-msg'>
						<span class="dashicons dashicons-yes-alt"></span>
						<span class='qsm-msg qsm-addon-title'><b><?php esc_html_e( 'User Dashboard License', 'qsm-user-dashboard' ); ?></b></span>
						<span class='qsm-msg qsm-addon-status'><?php esc_html_e( 'Valid till ', 'qsm-user-dashboard' ); ?><?php esc_html_e( date( 'd M, Y', strtotime($settings['expiry_date'])), 'qsm-user-dashboard' ); ?></span>
					</p>
					<a data-toggle='0' class="qsm-toggleButton" href=""><?php esc_attr_e( 'Change License', 'qsm-user-dashboard' ); ?></a>
				</div>
			<?php } ?>
				<form id="qsm-license_entry" action="" method="post" style="display: none;">
					<input type="text" name="license_key" placeholder="<?php esc_html_e( 'Enter License key', 'qsm-user-dashboard' ); ?>"/>
					<button id="qsm-validate_btn" class="button button-primary"><?php esc_html_e( 'Validate', 'qsm-user-dashboard' ); ?></button>
					<a data-toggle='1' class="qsm-toggleButton" href=""><?php esc_html_e( 'Cancel', 'qsm-user-dashboard' ); ?></a>
					<p class="qsm-validate-msg"></p>
				</form>
			</div>
		</div>
		<?php
	} else {
		$params      = array(
			'please_wait' => __('Please Wait! We are validating your license', 'qsm-user-dashboard'),
			'license_msg' => __('License Key Required.', 'qsm-user-dashboard'),
			'invalid'     => __('<span class="dashicons dashicons-warning"></span><b>Incorrect License!</b> Please enter a valid license key.', 'qsm-user-dashboard'),
		);
		wp_localize_script( 'qsm_user-dashboard_js', 'qsm_user_dashboard_obj', $params );
		?>
		<div class="qsm-license-form-parent">
			<div class="qsm-license-header">
				<p class="qsm-heading">
					<?php esc_html_e( 'Manage License', 'qsm-user-dashboard' ); ?>
				</p>
			</div>
			<div class="qsm_user_dashboard_validate_parent">
				<form class="rq_validata-license" method="POST">
					<input type="text" placeholder="<?php echo esc_html("Enter your license key"); ?>" class="qsm_user_dashboard_validate_input" name="qsm_user_dashboard_validate_input" />
					<input value="Validate" type="submit" name="qsm_user_dashboard_validate_button" class="qsm_user_dashboard_validate_button button button-primary" />
				</form>
			</div>
			<div id="qsm-license_message" style="display: none; padding: 0 0 0 22px;"><p><strong class="qsm_user_dashboard_validate_message"></strong></div>
		</div>
		<?php
	}
}

/**
 * Generates the content for your addon settings tab
 *
 * @since 1.1.1
 * @return void
 */
function qsm_addon_user_dashboard_addon_settings_tabs_content() {
	
	wp_enqueue_script( 'qsm_user-dashboard_js', QSM_USER_DASHBOARD_URL . '/qsm-user-dashboard.js', array( 'jquery' ), QSM_USER_DASHBOARD_VERSION, true );
	wp_enqueue_style( 'qsm_user-dashboard_css', QSM_USER_DASHBOARD_URL . '/qsm-user-dashboard-style.css', array(), QSM_USER_DASHBOARD_VERSION );
	$settings    = get_option( 'mlw_qmn_dashboard_option', array() );
	global $mlwQuizMasterNext;
	$default_notice = 1;
	$license_key = isset($settings['license_key']) ? $settings['license_key'] : '';

	//If nonce is correct, update settings from passed input
	if ( isset($_POST["user_dashboard_nonce"]) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['user_dashboard_nonce'] ) ), 'user_dashboard') ) {
		
		$new_settings = array(
			'view_text_check'                   => isset($_POST["view_text_check"]) ? 1 : 0,
			'view_header_text'                  => isset($_POST["view_header_text"]) ? sanitize_text_field(wp_unslash($_POST["view_header_text"])) : __("View Results", "qsm-user-dashboard"),
			'view_text'                         => isset($_POST["view_text"]) ? sanitize_text_field(wp_unslash($_POST["view_text"])) : __("View", "qsm-user-dashboard"),
			'quiz_name_check'                   => isset($_POST["quiz_name_check"]) ? 1 : 0,
			'quiz_name_text'                    => isset($_POST["quiz_name_text"]) ? sanitize_text_field(wp_unslash($_POST["quiz_name_text"])) : __("Quiz Title", "qsm-user-dashboard"),
			'quiz_score_check'                  => isset($_POST["quiz_score_check"]) ? 1 : 0,
			'quiz_score_text'                   => isset($_POST["quiz_score_text"]) ? sanitize_text_field(wp_unslash($_POST["quiz_score_text"])) : __("Score", "qsm-user-dashboard"),
			'quiz_time_check'                   => isset($_POST["quiz_time_check"]) ? 1 : 0,
			'quiz_time_text'                    => isset($_POST["quiz_time_text"]) ? sanitize_text_field(wp_unslash($_POST["quiz_time_text"])) : __("Time Taken", "qsm-user-dashboard"),
			'quiz_time_text_date_format'        => isset($_POST["quiz_time_text_date_format"]) ? sanitize_text_field(wp_unslash($_POST["quiz_time_text_date_format"])) : 0,
			'quiz_time_text_time_format'        => isset($_POST["quiz_time_text_time_format"]) ? sanitize_text_field(wp_unslash($_POST["quiz_time_text_time_format"])) : 0,
			'quiz_time_text_custom_date_format' => isset($_POST["quiz_time_text_custom_date_format"]) ? sanitize_text_field(wp_unslash($_POST["quiz_time_text_custom_date_format"])) : '',
			'quiz_time_text_custom_time_format' => isset($_POST["quiz_time_text_custom_time_format"]) ? sanitize_text_field(wp_unslash($_POST["quiz_time_text_custom_time_format"])) : '',
			'quiz_time_to_complete_check'       => isset($_POST["quiz_time_to_complete_check"]) ? 1 : 0,
			'quiz_time_to_complete_text'        => isset($_POST["quiz_time_to_complete_text"]) ? sanitize_text_field(wp_unslash($_POST["quiz_time_to_complete_text"])) : __("Time to complete", "qsm-user-dashboard"),
			'quiz_time_to_complete_time_format' => isset($_POST["quiz_time_to_complete_time_format"]) ? sanitize_text_field(wp_unslash($_POST["quiz_time_to_complete_time_format"])) : 0,
			'quiz_certificate_link_check'       => isset($_POST["quiz_certificate_link_check"]) ? 1 : 0,
			'quiz_certificate_link_text'        => isset($_POST["quiz_certificate_link_text"]) ? sanitize_text_field(wp_unslash($_POST["quiz_certificate_link_text"])) : __("View", "qsm-user-dashboard"),
			'quiz_certificate_link_header_text' => isset($_POST["quiz_certificate_link_header_text"]) ? sanitize_text_field(wp_unslash($_POST["quiz_certificate_link_header_text"])) : __("View Certificate", "qsm-user-dashboard"),
			'quiz_back_button_text'             => isset($_POST["quiz_back_button_text"]) ? sanitize_text_field(wp_unslash($_POST["quiz_back_button_text"])) : '',
			'results_template'                  => isset($_POST["results_template"]) ? wp_kses_post(stripslashes(wp_unslash($_POST["results_template"]))) : '',
			'next_button_text'                  => isset($_POST["next_button_text"]) ? sanitize_text_field(wp_unslash($_POST["next_button_text"])) : '',
			'previous_button_text'              => isset($_POST["previous_button_text"]) ? sanitize_text_field(wp_unslash($_POST["previous_button_text"])) : '',
			'not_user_text'                     => isset($_POST["not_user_text"]) ? sanitize_text_field(wp_unslash($_POST["not_user_text"])) : '',
			'quiz_correct_answer_check'         => isset($_POST["quiz_correct_answer_check"]) ? 1 : 0,
			'quiz_correct_answer_text_format'   => isset($_POST["quiz_correct_answer_text_format"]) ? sanitize_text_field(wp_unslash($_POST["quiz_correct_answer_text_format"])) : __("%AMOUNT_CORRECT% out of %TOTAL_QUESTIONS%", "qsm-user-dashboard"),
			'quiz_correct_answer_text'          => isset($_POST["quiz_correct_answer_text"]) ? sanitize_text_field(wp_unslash($_POST["quiz_correct_answer_text"])) : __("Correct Answer", "qsm-user-dashboard"),
			'quiz_total_points_text_format'     => isset($_POST["quiz_total_points_text_format"]) ? sanitize_text_field(wp_unslash($_POST["quiz_total_points_text_format"])) : __("%POINT_SCORE% out of %MAXIMUM_POINTS%", "qsm-user-dashboard"),
			'quiz_total_points_check'           => isset($_POST["quiz_total_points_check"]) ? 1 : 0,
			'quiz_total_points_text'            => isset($_POST["quiz_total_points_text"]) ? sanitize_text_field(wp_unslash($_POST["quiz_total_points_text"])) : __("Total Points", "qsm-user-dashboard"),
			'quiz_score_percent_text_format'    => isset($_POST["quiz_score_percent_text_format"]) ? sanitize_text_field(wp_unslash($_POST["quiz_score_percent_text_format"])) : 0,
			'quiz_score_percent_check'          => isset($_POST["quiz_score_percent_check"]) ? 1 : 0,
			'quiz_score_percent_text'           => isset($_POST["quiz_score_percent_text"]) ? sanitize_text_field(wp_unslash($_POST["quiz_score_percent_text"])) : __("Score Percentage", "qsm-user-dashboard"),
			'dashboard_options_order'           => isset($_POST["dashboard_options_order"]) ? rest_sanitize_array(wp_unslash($_POST["dashboard_options_order"])) : array(),
		);
		$new_settings['license_key'] = isset($settings['license_key']) ? $settings['license_key'] : '';
		$new_settings['license_status'] = isset($settings['license_status']) ? $settings['license_status'] : '';
		$new_settings['last_validate'] = isset($settings['last_validate']) ? $settings['last_validate'] : 'invalid';
		$new_settings['expiry_date'] = isset($settings['expiry_date']) ? $settings['expiry_date'] : '';
		
		update_option('mlw_qmn_dashboard_option', $new_settings);
	}

	$date_now = date("d-m-Y");
	$settings    = get_option('mlw_qmn_dashboard_option', array());
	$license         = isset( $settings['license_key'] ) ? trim( $settings['license_key'] ) : '';
	$license_status  = isset( $settings['license_status'] ) ? $settings['license_status'] : '';
	// Load settings
	$results_template    = '<h1>Quiz Results</h1>
	You scored %CORRECT_SCORE%!

	Out of %TOTAL_QUESTIONS%, you got %AMOUNT_CORRECT% correct. Here are your answers:

	%QUESTIONS_ANSWERS%';
	$user_dashboard_data = wp_parse_args(
		get_option('mlw_qmn_dashboard_option', array()),
		array(
			'license_key'                       => '',
			'quiz_name_check'                   => 1,
			'quiz_name_text'                    => __("Quiz Title", "qsm-user-dashboard"),
			'quiz_time_check'                   => 1,
			'quiz_time_text_date_format'        => 0,
			'quiz_time_text_time_format'        => 0,
			'quiz_time_text_custom_date_format' => '',
			'quiz_time_text_custom_time_format' => '',
			'quiz_time_text'                    => __("Time Taken", "qsm-user-dashboard"),
			'quiz_correct_answer_check'         => 0,
			'quiz_correct_answer_text_format'   => __("%AMOUNT_CORRECT% out of %TOTAL_QUESTIONS%", "qsm-user-dashboard"),
			'quiz_correct_answer_text'          => __("Correct Answer", "qsm-user-dashboard"),
			'quiz_total_points_check'           => 0,
			'quiz_total_points_text_format'     => __("%POINT_SCORE% out of %MAXIMUM_POINTS%", "qsm-user-dashboard"),
			'quiz_total_points_text'            => __("Total Points", "qsm-user-dashboard"),
			'quiz_score_percent_check'          => 0,
			'quiz_score_percent_text_format'    => 0,
			'quiz_score_percent_text'           => __("Score Percentage", "qsm-user-dashboard"),
			'quiz_time_to_complete_check'       => 0,
			'quiz_time_to_complete_time_format' => 0,
			'quiz_certificate_link_check'       => 0,
			'quiz_time_to_complete_text'        => __("Time to Complete", "qsm-user-dashboard"),
			'quiz_certificate_link_text'        => __("View", "qsm-user-dashboard"),
			'quiz_certificate_link_header_text' => __("View Certificate", "qsm-user-dashboard"),
			'quiz_back_button_text'             => __('Go Back', 'qsm-user-dashboard'),
			'results_template'                  => $results_template,
			'next_button_text'                  => __('Next', 'qsm-user-dashboard'),
			'previous_button_text'              => __('Previous', 'qsm-user-dashboard'),
			'view_text'                         => __('View', 'qsm-user-dashboard'),
			'view_text_check'                   => 1,
			'view_header_text'                  => __('View Results', 'qsm-user-dashboard'),
			'not_user_text'                     => __('You must be logged in to see your results.', 'qsm-user-dashboard'),
			'dashboard_options_order'           => [ 
				'view_text',
				'quiz_name',
				'quiz_score',
				'quiz_time', 
				'quiz_time_to_complete', 
				'quiz_certificate_link',
				'quiz_correct_answer', 
				'quiz_total_points',
				'quiz_score_percent',
			],
		)
	);
	?>
	<nav class="nav-tab-wrapper">
		<a class="nav-tab <?php echo ! isset( $_GET['license'] ) ? esc_attr( 'nav-tab-active' ) : ''; ?>" href="
			<?php
			echo esc_url(
				add_query_arg(
					array(
						'page' => 'qmn_addons',
						'tab'  => 'user-dashboard-settings',
					),
					admin_url( 'admin.php' )
				)
			);
			?>
		"><?php esc_html_e( 'User Dashboard Settings', 'qsm-user-dashboard' ); ?></a>
		<a class="nav-tab <?php echo  isset( $_GET['license'] ) ? esc_attr( 'nav-tab-active' ) : ''; ?>" href="
			<?php
			echo esc_url(
				add_query_arg(
					array(
						'page'    => 'qmn_addons',
						'tab'     => 'user-dashboard-settings',
						'license' => true,
					),
					admin_url( 'admin.php' )
				)
			);
			?>
		"><?php esc_html_e( 'License', 'qsm-user-dashboard' ); ?></a>
	</nav>
	<?php 
	if ( isset( $_GET['license'] ) ) {
		qsm_addon_user_dashboard_addon_license_tabs_content();
	} else {
		if ( '' !== $license && 'valid' === $license_status ) {
			if ( version_compare( $mlwQuizMasterNext->version, '8.1.6', '>' ) && (isset($settings['expiry_date']) && "" !== $settings['expiry_date']) && (isset($settings['last_validate']) && "" !== $settings['last_validate']) && strtotime($date_now) > strtotime($settings['expiry_date']) && strtotime($date_now) >= strtotime($settings['last_validate']) && 1 === $default_notice ) { 
				$item_url = 'https://quizandsurveymaster.com/checkout/?edd_license_key='.$license.'&download_id='.USER_DASHBOARD_ITEM;
				$target_text = __('License Key Expired. ', 'qsm-user-dashboard');
				$target_link = sprintf( $target_text.'<a style="font-weight: 500;" href="%s" target="_blank">%s</a>', esc_url( $item_url ), __( 'Click here to renew', 'qsm-user-dashboard' ) );
				$mlwQuizMasterNext->alertManager->newAlert( $target_link, 'error' );
			}
			$mlwQuizMasterNext->alertManager->showAlerts();
			qsm_user_dashboard_addon_settings_tab_content( $user_dashboard_data );  
		}else {
			$params      = array(
				'please_wait' => __('Please Wait! We are validating your license', 'qsm-user-dashboard'),
				'license_msg' => __('License Key Required.', 'qsm-user-dashboard'),
				'invalid'     => __('<span class="dashicons dashicons-warning"></span><b>Incorrect License!</b> Please enter a valid license key.', 'qsm-user-dashboard'),
			);
			wp_localize_script( 'qsm_user-dashboard_js', 'qsm_user_dashboard_obj', $params );
			?>
			<div class="qsm-license-form-parent">
				<div class="qsm-license-header">
					<p class="qsm-heading">
						<?php esc_html_e( 'Manage License', 'qsm-user-dashboard' ); ?>
					</p>
				</div>
				<div class="qsm_user_dashboard_validate_parent">
					<form class="rq_validata-license" method="POST">
						<input type="text" placeholder="<?php echo esc_html("Enter your license key"); ?>" class="qsm_user_dashboard_validate_input" name="qsm_user_dashboard_validate_input" />
						<input value="Validate" type="submit" name="qsm_user_dashboard_validate_button" class="qsm_user_dashboard_validate_button button button-primary" />
					</form>
				</div>
				<div id="qsm-license_message" style="display: none; padding: 0 0 0 22px;"><p><strong class="qsm_user_dashboard_validate_message"></strong></div>
			</div>
			<?php
		}
	}   
}
function enqueue_multiselect_assets_admin() {
    if (isset($_GET['page'], $_GET['tab']) && $_GET['page'] === 'qmn_addons' && $_GET['tab'] === 'user-dashboard-settings') {
        wp_enqueue_script( 'qsm-user-dashboard-jquery-multiselect-js', QSM_USER_DASHBOARD_URL . '/jquery.multiselect.min.js', array( 'jquery' ), QSM_USER_DASHBOARD_VERSION, true );
        wp_enqueue_style( 'jquery-multiselect-css', QSM_USER_DASHBOARD_URL . '/jquery.multiselect.min.css', array(), QSM_USER_DASHBOARD_VERSION );

        wp_localize_script( 'qsm-user-dashboard-jquery-multiselect-js', 'qsm_dashboard_object', array(
            'select_quiz' => __( 'Select quizzes', 'qsm-user-dashboard' ),
        ) );

        wp_add_inline_script( 'qsm-user-dashboard-jquery-multiselect-js', '
            jQuery(document).ready(function($) {
                $(".select2-multiselect").multiselect({
                    placeholder: qsm_dashboard_object.select_quiz,
                    selectAll: true,
                    minWidth: 200
                });
            });
        ' );
    }
}
add_action( 'admin_enqueue_scripts', 'enqueue_multiselect_assets_admin' );

function qsm_user_dashboard_addon_settings_tab_content( $user_dashboard_data ) {
	global $wpdb;
	$quiz_data  = $wpdb->get_results( "SELECT `quiz_id`, `quiz_name` FROM `{$wpdb->prefix}mlw_quizzes` WHERE `deleted`='0' ORDER BY quiz_id DESC" );
?>
	<div class="wrap">
		<h2><?php esc_html_e('Manage your user\'s dashboard', 'qsm-user-dashboard'); ?></h2>
		<p><?php echo esc_html__('Use a custom table to display participant performance, with access to personalized quiz results pages. Embed the table using shortcodes in any page or post.', 'qsm-user-dashboard'); ?></p>
		<form method="post" action="" class="user-dashboard-form">
			<?php wp_nonce_field('user_dashboard', 'user_dashboard_nonce'); ?>
			<table class="form-table" style="width: 100%;">
				<!------------ General Settings Section ----------->
				<tr valign="top">
					<th class="section-heading" scope="row" col-span="2"><?php esc_html_e('General Settings', 'qsm-user-dashboard'); ?></th>
				</tr>
				<tr valign="top">
					<th scope="row"><?php esc_html_e('Use Shortcode', 'qsm-user-dashboard'); ?></th>
					<td>
						<div class="dashboard-options-notloop">
							<div class="dashboard-options-field active">
								<div class="dashboard-options-group leaderboard-options-inputs">
									<input class="qsm-dashboard-shortcode-print" disabled type="text" value="[user_dashboard]" style="width: 280px; background: #f5f5f5;" />
								</div>
								<div class="dashboard-options-group dashboard-options-switch">
									<button class="button dashboard-generate-shortcode-button" title="<?php echo esc_attr__('Copy Shortcode', 'qsm-user-dashboard'); ?>">
										<span class="dashicons dashicons-admin-page"></span>
									</button>
								</div>
								<div class="dashboard-options-group dashboard-options-actions">
									<a href="javascript:void(0)" class="settings-field" title="<?php echo esc_attr__('Customize', 'qsm-user-dashboard'); ?>">
										<span class="dashicons dashicons-edit"></span>
									</a>
								</div>
								<div class="dashboard-options-field-settings arrow-left" style="display:none;">
									<div class="dashboard-options-group">
										<label class="dashboard-options-label"><?php esc_html_e("Select Quizzes", "qsm-user-dashboard"); ?></label>
										<select id="quizzes" name="quizzes[]" multiple class="select2-multiselect">
											<?php foreach ($quiz_data as $quiz): ?>
													<option value="<?php echo esc_attr($quiz->quiz_id); ?>"><?php echo esc_html($quiz->quiz_name); ?></option>
											<?php endforeach; ?>
										</select>
									</div>
								<button class="button-primary qsm-save-quizzes"><?php esc_html_e('Save Changes', 'qsm-user-dashboard'); ?></button>
							</div>
						</div>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"><?php esc_html_e('Total points shortcode', 'qsm-user-dashboard'); ?></th>
					<td>
						<div class="qsm-user-dashboard-shortcode-main button-secondary">
							<span class="qsm-user-dashboard-shortcode">[user_total_points]</span>
							<span class="qsm-user-dashboard-shortcode-info">
								<span class="qsm-user-dashboard-copy-msg">
									<?php esc_html_e( 'Click to Copy', 'qsm-user-dashboard' ); ?>
								</span>
								<span class="qsm-user-dashboard-copy-success">
									<?php esc_html_e( 'Code Copied!', 'qsm-user-dashboard' ); ?>
								</span>
							</span>
						</div>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"><?php esc_html_e('Message for non-logged in user', 'qsm-user-dashboard'); ?></th>
					<td><input type="text" name="not_user_text" value="<?php echo $user_dashboard_data['not_user_text']; ?>" /></td>
				</tr>
				<!------------ Manage Table Report Section ----------->
				<tr valign="top">
					<th class="section-heading" scope="row" col-span="2"><?php esc_html_e('Manage Table Report', 'qsm-user-dashboard'); ?></th>
				</tr>
				<tr valign="bottom">
					<th scope="row">
						<?php esc_html_e('Set Labels for Table Header', 'qsm-user-dashboard'); ?><br>
						<small><?php esc_html_e('Rearrange headers by dragging and dropping labels. Customize titles. Show/hide headers. Click the settings icon for more customization options.', 'qsm-user-dashboard'); ?></small>
					</th>
					<td>
						<div class="dashboard-options">
							<?php
							foreach ( $user_dashboard_data['dashboard_options_order'] as $field ) {
								if ( 'quiz_score' === $field && ! isset( $user_dashboard_data[ $field.'_check' ], $user_dashboard_data[ $field.'_text' ] ) ) {
									continue;
								} else {
									echo qsm_user_dashboard_sortable_fields($field, $user_dashboard_data);
								}
							}
							?>
						</div>
					</td>
				</tr>
				<!------------ Buttons Section ----------->
				<tr valign="top">
					<th class="section-heading" scope="row" col-span="2"><?php esc_html_e('Buttons', 'qsm-user-dashboard'); ?></th>
				</tr>
				<tr valign="top">
					<th scope="row"><?php esc_html_e('Next Button Label', 'qsm-user-dashboard'); ?></th>
					<td><input type="text" name="next_button_text" value="<?php echo $user_dashboard_data['next_button_text']; ?>" /></td>
				</tr>
				<tr valign="top">
					<th scope="row"><?php esc_html_e('Previous Button Label', 'qsm-user-dashboard'); ?></th>
					<td><input type="text" name="previous_button_text" value="<?php echo $user_dashboard_data['previous_button_text']; ?>" /></td>
				</tr>
				<!------------ Dashboard Results Section ----------->
				<tr valign="top">
					<th class="section-heading" scope="row" col-span="2"><?php esc_html_e('Dashboard Results', 'qsm-user-dashboard'); ?></th>
				</tr>
				<tr valign="top">
					<th scope="row"><?php esc_html_e('Back Button Label', 'qsm-user-dashboard'); ?></th>
					<td><input type="text" name="quiz_back_button_text" value="<?php echo $user_dashboard_data['quiz_back_button_text']; ?>" /></td>
				</tr>
				<tr valign="top">
					<th scope="row"><?php esc_html_e('Results Template', 'qsm-user-dashboard'); ?></th>
					<td>
						<?php 
						wp_editor( htmlspecialchars_decode( $user_dashboard_data["results_template"], ENT_QUOTES ), 'results_template' );
						?>
					</td>
				</tr>			
			</table>
			<div class="dashboard-footer">
				<a class="button-secondary" href="<?php echo esc_attr(qsm_get_plugin_link( 'docs/add-ons/user-dashboard-add-on/' )); ?>"><?php esc_html_e('Documentation', 'qsm-user-dashboard'); ?></a>
				<button class="button-primary"><?php esc_html_e('Save Changes', 'qsm-user-dashboard'); ?></button>
			</div>
		</form>
	</div>
<?php
}

function qsm_user_dashboard_sortable_fields( $field_name, $user_dashboard_data ) {
	$quiz_score_text = isset( $user_dashboard_data["quiz_score_text"] ) ? $user_dashboard_data["quiz_score_text"] : '';
	$quiz_score_check = isset( $user_dashboard_data["quiz_score_check"] ) ? $user_dashboard_data["quiz_score_check"] : '';
	$sortable_fields = array(
		'quiz_name'             => '<div class="dashboard-options-field">
										<div class="dashboard-options-group sortable-handle">
											<a href="javascript:void(0)" class="move-field" title="Move"><img src="'. QSM_USER_DASHBOARD_URL .'img/draggable.png"></a>
										</div>								
										<div class="dashboard-options-group dashboard-options-inputs">
											<input type="text" name="quiz_name_text" value="'. __($user_dashboard_data["quiz_name_text"], 'qsm-user-dashboard') .'" />
											<input type="hidden" name="dashboard_options_order[]" value="quiz_name" />
										</div>
										<div class="dashboard-options-group dashboard-options-switch">
											<label class="qsm-switch" title="Enable / Disable Field">
												<input name="quiz_name_check" class="enable-control" type="checkbox" value="1" '.checked("1", $user_dashboard_data["quiz_name_check"], false).' />
												<span class="switch-slider"></span>
											</label>
										</div>
										<div class="dashboard-options-group dashboard-options-actions">
											<div class="dashboard-options-actions-box">
											</div>
										</div>
									</div>',
		'quiz_score'            => '<div class="dashboard-options-field" title="Legacy Option">
										<div class="dashboard-options-group sortable-handle">
											<a href="javascript:void(0)" class="move-field" title="Move"><img src="'. QSM_USER_DASHBOARD_URL .'img/draggable.png"></a>
										</div>								
										<div class="dashboard-options-group dashboard-options-inputs">
											<input type="text" name="quiz_score_text" value="'. __($quiz_score_text, 'qsm-user-dashboard') .'" />
											<input type="hidden" name="dashboard_options_order[]" value="quiz_score" />
										</div>
										<div class="dashboard-options-group dashboard-options-switch">
											<label class="qsm-switch" title="Enable / Disable Field">
												<input name="quiz_score_check" class="enable-control" type="checkbox" value="1" '.checked("1", $quiz_score_check, false).' />
												<span class="switch-slider"></span>
											</label>
										</div>
										<div class="dashboard-options-group dashboard-options-actions">
											<div class="dashboard-options-actions-box">
											</div>
										</div>
									</div>',
		'quiz_time'             => '<div class="dashboard-options-field">
										<div class="dashboard-options-group sortable-handle">
											<a href="javascript:void(0)" class="move-field" title="Move"><img src="'. QSM_USER_DASHBOARD_URL .'img/draggable.png"></a>
										</div>
										<div class="dashboard-options-group dashboard-options-inputs">
											<input type="text" name="quiz_time_text" value="'. __( $user_dashboard_data["quiz_time_text"], 'qsm-user-dashboard' ) .'" />
											<input type="hidden" name="dashboard_options_order[]" value="quiz_time" />
										</div>
										<div class="dashboard-options-group dashboard-options-switch">
											<label class="qsm-switch" title="Enable / Disable Field">
												<input name="quiz_time_check" class="enable-control" type="checkbox" value="1" '.checked("1", $user_dashboard_data["quiz_time_check"], false).' />
												<span class="switch-slider"></span>
											</label>
										</div>
										<div class="dashboard-options-group dashboard-options-actions">
											<div class="dashboard-options-actions-box">
												<a href="javascript:void(0)" class="settings-field" title="Settings"><span class="dashicons dashicons-admin-generic"></span></a>
											</div>
										</div>
										<div class="dashboard-options-field-settings arrow-left" style="display:none;">
											<b>'. __("Select a format of start time", "qsm-user-dashboard") .'</b>
											<hr>
											<p class="sub-heading"><b>'. __("Date Format", "qsm-user-dashboard") .'</b></p>
											<div class="dashboard-options-group">
												<label class="dashboard-options-label">
													<input type="radio" name="quiz_time_text_date_format" value="0"'.checked("0", $user_dashboard_data["quiz_time_text_date_format"], false).'><span>'. __("January 8, 2024", "qsm-user-dashboard") .'</span>
												</label>
												<label class="dashboard-options-label">
													<input type="radio" name="quiz_time_text_date_format" value="1"'.checked("1", $user_dashboard_data["quiz_time_text_date_format"], false).'><span>'. __("2024-01-08", "qsm-user-dashboard") .'</span>
												</label>
												<label class="dashboard-options-label">
													<input type="radio" name="quiz_time_text_date_format" value="2"'.checked("2", $user_dashboard_data["quiz_time_text_date_format"], false).'><span>'. __("01/08/2024", "qsm-user-dashboard") .'</span>
												</label>
												<label class="dashboard-options-label">
													<input type="radio" name="quiz_time_text_date_format" value="3"'.checked("3", $user_dashboard_data["quiz_time_text_date_format"], false).'><span>'. __("08/01/2024", "qsm-user-dashboard") .'</span>
												</label>
												<label class="dashboard-options-label">
													<input type="radio" name="quiz_time_text_date_format" value="4"'.checked("4", $user_dashboard_data["quiz_time_text_date_format"], false).'><span>'. __("Custom", "qsm-user-dashboard") .'</span>
													<input type="text" name="quiz_time_text_custom_date_format" value="'. __($user_dashboard_data["quiz_time_text_custom_date_format"], 'qsm-user-dashboard') .'">
												</label>
											</div>	
											<p class="sub-heading"><b>'. __("Time Format", "qsm-user-dashboard") .'</b></p>
											<div class="dashboard-options-group">
												<label class="dashboard-options-label">
													<input type="radio" name="quiz_time_text_time_format" value="0"'.checked("0", $user_dashboard_data["quiz_time_text_time_format"], false).'><span>'. __("08:29 am", "qsm-user-dashboard") .'</span>
												</label>
												<label class="dashboard-options-label">
													<input type="radio" name="quiz_time_text_time_format" value="1"'.checked("1", $user_dashboard_data["quiz_time_text_time_format"], false).'><span>'. __("08:29 AM", "qsm-user-dashboard") .'</span>
												</label>
												<label class="dashboard-options-label">
													<input type="radio" name="quiz_time_text_time_format" value="2"'.checked("2", $user_dashboard_data["quiz_time_text_time_format"], false).'><span>'. __("08:29:25 am", "qsm-user-dashboard") .'</span>
												</label>
												<label class="dashboard-options-label">
													<input type="radio" name="quiz_time_text_time_format" value="3"'.checked("3", $user_dashboard_data["quiz_time_text_time_format"], false).'><span>'. __("08:29:25 AM", "qsm-user-dashboard") .'</span>
												</label>
												<label class="dashboard-options-label">
													<input type="radio" name="quiz_time_text_time_format" value="4"'.checked("4", $user_dashboard_data["quiz_time_text_time_format"], false).'><span>'. __("Custom", "qsm-user-dashboard") .'</span>
													<input type="text" name="quiz_time_text_custom_time_format" value="'. __($user_dashboard_data["quiz_time_text_custom_time_format"], 'qsm-user-dashboard') .'">
												</label>
											</div>
										</div>
									</div>',
		'quiz_time_to_complete' => '<div class="dashboard-options-field">
										<div class="dashboard-options-group sortable-handle">
											<a href="javascript:void(0)" class="move-field" title="Move"><img src="'. QSM_USER_DASHBOARD_URL .'img/draggable.png"></a>
										</div>
										<div class="dashboard-options-group dashboard-options-inputs">
											<input type="text" name="quiz_time_to_complete_text" value="'. __($user_dashboard_data["quiz_time_to_complete_text"], 'qsm-user-dashboard') .'" />
											<input type="hidden" name="dashboard_options_order[]" value="quiz_time_to_complete" />
										</div>
										<div class="dashboard-options-group dashboard-options-switch">
											<label class="qsm-switch" title="Enable / Disable Field">
												<input name="quiz_time_to_complete_check" class="enable-control" type="checkbox" value="1"'. checked("1", $user_dashboard_data["quiz_time_to_complete_check"], false) .' />
												<span class="switch-slider"></span>
											</label>
										</div>
										<div class="dashboard-options-group dashboard-options-actions">
											<div class="dashboard-options-actions-box">
												<a href="javascript:void(0)" class="settings-field" title="Settings"><span class="dashicons dashicons-admin-generic"></span></a>
											</div>
										</div>
										<div class="dashboard-options-field-settings arrow-left" style="display:none;">
											<b>'. __("Select Quiz Duration Format", "qsm-user-dashboard") .'</b>
											<hr>
											<div class="dashboard-options-group">
												<label class="dashboard-options-label">
													<input type="radio" name="quiz_time_to_complete_time_format" value="0" '.checked("0", $user_dashboard_data["quiz_time_to_complete_time_format"], false).'><span>'. __("HH:MM:SS", "qsm-user-dashboard") .'</span>
												</label>
												<label class="dashboard-options-label">
													<input type="radio" name="quiz_time_to_complete_time_format" value="1" '.checked("1", $user_dashboard_data["quiz_time_to_complete_time_format"], false).'><span>'. __("HH:MM", "qsm-user-dashboard") .'</span>
												</label>
												<label class="dashboard-options-label">
													<input type="radio" name="quiz_time_to_complete_time_format" value="2" '.checked("2", $user_dashboard_data["quiz_time_to_complete_time_format"], false).'><span>'. __("MM:SS", "qsm-user-dashboard") .'</span>
												</label>
											</div>
										</div>
									</div>',
		'quiz_correct_answer'   => '<div class="dashboard-options-field">
										<div class="dashboard-options-group sortable-handle">
											<a href="javascript:void(0)" class="move-field" title="Move"><img src="'. QSM_USER_DASHBOARD_URL .'img/draggable.png"></a>
										</div>
										<div class="dashboard-options-group dashboard-options-inputs">
											<input type="text" name="quiz_correct_answer_text" value="'. __($user_dashboard_data["quiz_correct_answer_text"], 'qsm-user-dashboard') .'" />
											<input type="hidden" name="dashboard_options_order[]" value="quiz_correct_answer" />
										</div>
										<div class="dashboard-options-group dashboard-options-switch">
											<label class="qsm-switch" title="Enable / Disable Field">
												<input name="quiz_correct_answer_check" class="enable-control" type="checkbox" value="1"'. checked("1", $user_dashboard_data["quiz_correct_answer_check"], false) .' />
												<span class="switch-slider"></span>
											</label>
										</div>
										<div class="dashboard-options-group dashboard-options-actions">
											<div class="dashboard-options-actions-box">
												<a href="javascript:void(0)" class="settings-field" title="Settings"><span class="dashicons dashicons-admin-generic"></span></a>
											</div>
										</div>
										<div class="dashboard-options-field-settings arrow-left" style="display:none;">
											<p><b>'. __("Manage Correct Asnwer Settings", "qsm-user-dashboard") .'</b></p>
											<hr>
											<div class="dashboard-options-group">
												<label class="dashboard-options-label">
													<input type="text" name="quiz_correct_answer_text_format" value="'. __($user_dashboard_data["quiz_correct_answer_text_format"], 'qsm-user-dashboard') .'">
												</label>
											</div>
										</div>
									</div>',
		'quiz_total_points'     => '<div class="dashboard-options-field">
										<div class="dashboard-options-group sortable-handle">
											<a href="javascript:void(0)" class="move-field" title="Move"><img src="'. QSM_USER_DASHBOARD_URL .'img/draggable.png"></a>
										</div>
										<div class="dashboard-options-group dashboard-options-inputs">
											<input type="text" name="quiz_total_points_text" value="'. __($user_dashboard_data["quiz_total_points_text"], 'qsm-user-dashboard') .'" />
											<input type="hidden" name="dashboard_options_order[]" value="quiz_total_points" />
										</div>
										<div class="dashboard-options-group dashboard-options-switch">
											<label class="qsm-switch" title="Enable / Disable Field">
												<input name="quiz_total_points_check" class="enable-control" type="checkbox" value="1"'. checked("1", $user_dashboard_data["quiz_total_points_check"], false) .' />
												<span class="switch-slider"></span>
											</label>
										</div>
										<div class="dashboard-options-group dashboard-options-actions">
											<div class="dashboard-options-actions-box">
												<a href="javascript:void(0)" class="settings-field" title="Settings"><span class="dashicons dashicons-admin-generic"></span></a>
											</div>
										</div>
										<div class="dashboard-options-field-settings arrow-left" style="display:none;">
											<b>'. __("Manage Quiz Points Settings", "qsm-user-dashboard") .'</b>
											<hr>
											<div class="dashboard-options-group">
												<label class="dashboard-options-label">
													<input type="text" name="quiz_total_points_text_format" value="'. __($user_dashboard_data["quiz_total_points_text_format"], 'qsm-user-dashboard') .'"><span>
												</label>
											</div>
										</div>
									</div>',
		'quiz_score_percent'    => '<div class="dashboard-options-field">
										<div class="dashboard-options-group sortable-handle">
											<a href="javascript:void(0)" class="move-field" title="Move"><img src="'. QSM_USER_DASHBOARD_URL .'img/draggable.png"></a>
										</div>
										<div class="dashboard-options-group dashboard-options-inputs">
											<input type="text" name="quiz_score_percent_text" value="'. __($user_dashboard_data["quiz_score_percent_text"], 'qsm-user-dashboard') .'" />
											<input type="hidden" name="dashboard_options_order[]" value="quiz_score_percent" />
										</div>
										<div class="dashboard-options-group dashboard-options-switch">
											<label class="qsm-switch" title="Enable / Disable Field">
												<input name="quiz_score_percent_check" class="enable-control" type="checkbox" value="1"'. checked("1", $user_dashboard_data["quiz_score_percent_check"], false) .' />
												<span class="switch-slider"></span>
											</label>
										</div>
										<div class="dashboard-options-group dashboard-options-actions">
											<div class="dashboard-options-actions-box">
												<a href="javascript:void(0)" class="settings-field" title="Settings"><span class="dashicons dashicons-admin-generic"></span></a>
											</div>
										</div>
										<div class="dashboard-options-field-settings arrow-left" style="display:none;">
											<b>'. __("Manage Quiz Scores Decimal places", "qsm-user-dashboard") .'</b>
											<hr>
											<div class="dashboard-options-group">
												<label class="dashboard-options-label">
													<input type="number" name="quiz_score_percent_text_format" min="0" value="'. __($user_dashboard_data["quiz_score_percent_text_format"], 'qsm-user-dashboard') .'">
												</label>
											</div>
										</div>
									</div>',
		'view_text'             => '<div class="dashboard-options-field">
										<div class="dashboard-options-group sortable-handle">
											<a href="javascript:void(0)" class="move-field" title="Move"><img src="'. QSM_USER_DASHBOARD_URL .'img/draggable.png"></a>
										</div>
										<div class="dashboard-options-group dashboard-options-inputs">
											<input type="text" name="view_header_text" value="'. __($user_dashboard_data["view_header_text"], 'qsm-user-dashboard') .'" />
											<input type="hidden" name="dashboard_options_order[]" value="view_text" />
										</div>
										<div class="dashboard-options-group dashboard-options-switch">
											<label class="qsm-switch" title="Enable / Disable Field">
												<input name="view_text_check" class="enable-control" type="checkbox" value="1"'. checked("1", $user_dashboard_data["view_text_check"], false) .' />
												<span class="switch-slider" disabled></span>
											</label>
										</div>
										<div class="dashboard-options-group dashboard-options-actions">
											<div class="dashboard-options-actions-box">
												<a disabled href="javascript:void(0)" class="settings-field" title="Settings"><span class="dashicons dashicons-admin-generic"></span></a>
											</div>
										</div>
										<div class="dashboard-options-field-settings arrow-left" style="display:none;">
											<p><b>'. __("Manage Results Button", "qsm-user-dashboard") .'</b></p>
											<hr>
											<p>'. __("Set view result button text", "qsm-user-dashboard") .'</p>
											<input type="text" name="view_text" value="'. __($user_dashboard_data["view_text"], 'qsm-user-dashboard') .'" />
										</div>
									</div>',
		'quiz_certificate_link' => '<div class="dashboard-options-field">
										<div class="dashboard-options-group sortable-handle">
											<a href="javascript:void(0)" class="move-field" title="Move"><img src="'. QSM_USER_DASHBOARD_URL .'img/draggable.png" /></a>
										</div>
										<div class="dashboard-options-group dashboard-options-inputs">
											<input type="text" name="quiz_certificate_link_header_text" value="'. __($user_dashboard_data["quiz_certificate_link_header_text"], 'qsm-user-dashboard') .'" />
											<input type="hidden" name="dashboard_options_order[]" value="quiz_certificate_link" />
										</div>
										<div class="dashboard-options-group dashboard-options-switch">
											<label class="qsm-switch" title="Enable / Disable Field">
												<input name="quiz_certificate_link_check" class="enable-control" type="checkbox" value="1"'. checked("1", $user_dashboard_data["quiz_certificate_link_check"], false) .' />
												<span class="switch-slider"></span>
											</label>
										</div>
										<div class="dashboard-options-group dashboard-options-actions">
											<div class="dashboard-options-actions-box">
												<a href="javascript:void(0)" class="settings-field" title="Settings"><span class="dashicons dashicons-admin-generic"></span></a>
											</div>
										</div>
										<div class="dashboard-options-field-settings arrow-left" style="display:none;">
											<p><b>'. __("Manage Certificate Button", "qsm-user-dashboard") .'</b></p>
											<hr>
											<p>'. __("Set certificate download button text", "qsm-user-dashboard") .'</p>
											<input type="text" name="quiz_certificate_link_text" value="'. __($user_dashboard_data["quiz_certificate_link_text"], 'qsm-user-dashboard') .'" />
										</div>
									</div>',                                
	);
	return $sortable_fields[ $field_name ];
}