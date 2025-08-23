<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Registers your tab in the addon  settings page
 *
 * @since 2.0.0
 * @return void
 */
function qsm_addon_extra_shortcodes_register_addon_settings_tabs() {
	global $mlwQuizMasterNext;
	if ( ! is_null( $mlwQuizMasterNext ) && ! is_null( $mlwQuizMasterNext->pluginHelper ) && method_exists( $mlwQuizMasterNext->pluginHelper, 'register_quiz_settings_tabs' ) ) {
		$mlwQuizMasterNext->pluginHelper->register_addon_settings_tab( "Extra Shortcodes", 'qsm_addon_extra_shortcodes_addon_settings_tabs_content' );
	}
}

/**
 * Generates the content for your addon settings tab
 *
 * @since 2.0.0
 * @return void
 */
function qsm_addon_extra_shortcodes_addon_settings_tabs_content() {
	global $mlwQuizMasterNext;
	wp_enqueue_script( 'qsm_extra_shortcodes_admin_script', QSM_EXTRA_SHORTCODES_JS_URL . '/qsm-extra-shortcodes-admin.js', array( 'jquery' ), QSM_EXTRA_SHORTCODES_VER, true );
	wp_enqueue_style( 'qsm_extra_shortcodes-admin-css', QSM_EXTRA_SHORTCODES_URL . 'css/admin.css', array(), QSM_EXTRA_SHORTCODES_VER );
	$params      = array(
		'copytext' => __('Copied!', 'qsm-extra-shortcodes'),
		'copy_image_url' => esc_url(QSM_PLUGIN_URL . 'assets/copy.svg'),
	);
	wp_localize_script( 'qsm_extra_shortcodes_admin_script', 'qsm_license_validate_obj', $params );
	?>
	<nav class="nav-tab-wrapper">
		<a class="nav-tab <?php echo ( ! isset($_GET['license'])) ? esc_attr( 'nav-tab-active' ) : ''; ?>" href="
			<?php
			echo esc_url(
				add_query_arg(
					array(
						'page' => 'qmn_addons',
						'tab'  => 'extra-shortcodes',
					),
					admin_url( 'admin.php' )
				)
			);
			?>
		"><?php esc_html_e( 'Extra Shortcodes Settings', 'qsm-extra-shortcodes' ); ?></a>
		<a class="nav-tab <?php echo ( isset($_GET['license']) ) ? esc_attr( 'nav-tab-active' ) : ''; ?>" href="
			<?php
			echo esc_url(
				add_query_arg(
					array(
						'page'    => 'qmn_addons',
						'tab'     => 'extra-shortcodes',
						'license' => '1',
					),
					admin_url( 'admin.php' )
				)
			);
			?>
		"><?php esc_html_e( 'License', 'qsm-extra-shortcodes' ); ?></a>
	</nav>
	<?php
	$date_now = gmdate("d-m-Y");
	$settings = wp_parse_args(
		get_option( 'qsm_addon_extra_shortcodes_settings', array() ),
		array( 'license_key' => '' )
	);
	$license        = isset( $settings['license_key'] ) ? trim( $settings['license_key'] ) : '';
	$license_status = isset( $settings['license_status'] ) ? trim( $settings['license_status'] ) : '';
	if ( ! isset($_GET['license']) ) {
		qsm_all_shortcodes_display( $license, $license_status );
	} else {
		if ( '' !== $license && 'valid' === $license_status ) {
			$params      = array(
				'invalid' => __('<span class="dashicons dashicons-warning"></span><b>Incorrect License!</b> Please enter a valid license key.', 'qsm-extra-shortcodes'),
				'hold'    => __('Please Wait! We are validating your license', 'qsm-extra-shortcodes'),
				'empty'   => __('Please enter a license key.', 'qsm-extra-shortcodes'),
			);
			wp_localize_script( 'qsm_extra_shortcodes_admin_script', 'qsm_license_validate_obj', $params );
			?>
			<div class="qsm-extra-shortcodes-license-container">
				<div class="qsm-license-header">
					<p class="qsm-heading">
						<?php esc_html_e( 'Manage License', 'qsm-extra-shortcodes' ); ?>
					</p>
				</div>
				<div class='qsm-license-content'>
				<?php
					if ( (isset($settings['expiry_date']) && "" !== $settings['expiry_date']) && (isset($settings['last_validate']) && "" !== $settings['last_validate']) && strtotime($date_now) > strtotime($settings['expiry_date']) && strtotime($date_now) >= strtotime($settings['last_validate']) ) {
						$item_url = 'https://quizandsurveymaster.com/checkout/?edd_license_key='.$license.'&download_id='.QSM_EXTRA_SHORTCODES_ITEM;
					?>
					<div class="qsm-license-info">
						<p class='qsm-valid-msg'>
							<img class="qsm-warning" src="<?php echo esc_attr( QSM_EXTRA_SHORTCODES_URL . '/img/warning.png' ); ?>" alt="">
							<span class='qsm-msg qsm-addon-title'><b><?php esc_html_e( 'Extra Shortcodes License', 'qsm-extra-shortcodes' ); ?></b></span>
							<span class='qsm-msg qsm-addon-status'>
								<?php esc_html_e( 'Your license is expired.', 'qsm-extra-shortcodes' ); ?>
								<a target="_blank" href="<?php echo esc_url( $item_url ); ?>"><?php esc_html_e( 'Renew', 'qsm-extra-shortcodes' ); ?></a>
							</span>
						</p>
						<a data-toggle='0' class="qsm-toggleButton" href=""><?php esc_attr_e( 'Change License', 'qsm-extra-shortcodes' ); ?></a>
					</div>
				<?php } else { ?>
					<div class="qsm-license-info">
						<p class='qsm-valid-msg'>
							<span class="dashicons dashicons-yes-alt"></span>
							<span class='qsm-msg qsm-addon-title'><b><?php esc_html_e( 'Extra Shortcodes License', 'qsm-extra-shortcodes' ); ?></b></span>
							<span class='qsm-msg qsm-addon-status'><?php esc_html_e( 'Valid till ', 'qsm-extra-shortcodes' ); ?><?php esc_html_e( gmdate( 'd M, Y', strtotime($settings['expiry_date'])), 'qsm-extra-shortcodes' ); ?></span>
						</p>
						<a data-toggle='0' class="qsm-toggleButton" href=""><?php esc_attr_e( 'Change License', 'qsm-extra-shortcodes' ); ?></a>
					</div>
				<?php } ?>
					<form id="qsm-license_entry" action="" method="post" style="display: none;">
						<input type="text" name="license_key" placeholder="<?php esc_html_e( 'Enter License key', 'qsm-extra-shortcodes' ); ?>"/>
						<button id="qsm-validate_btn" class="button button-primary"><?php esc_html_e( 'Validate', 'qsm-extra-shortcodes' ); ?></button>
						<a data-toggle='1' class="qsm-toggleButton" href=""><?php esc_html_e( 'Cancel', 'qsm-extra-shortcodes' ); ?></a>
						<p class="qsm-validate-msg"></p>
					</form>
				</div>
			</div>
		<?php
		} else {
			$params      = array(
				'please_wait' => __('Please Wait! We are validating your license', 'qsm-extra-shortcodes'),
				'license_msg' => __('License Key Required.', 'qsm-extra-shortcodes'),
				'invalid'     => __('<span class="dashicons dashicons-warning"></span><b>Incorrect License!</b> Please enter a valid license key.', 'qsm-extra-shortcodes'),
			);
			wp_localize_script( 'qsm_extra_shortcodes_admin_script', 'qsm_extra_shortcodes_obj', $params );?>
			<div class="qsm-license-form-parent">
				<div class="qsm-license-header">
					<p class="qsm-heading">
						<?php esc_html_e( 'Manage License', 'qsm-extra-shortcodes' ); ?>
					</p>
				</div>
				<div class="qsm_extra_shortcodes_validate_parent">
					<form class="rq_validata-license" method="POST">
						<input type="text" placeholder="<?php echo esc_html("Enter your license key"); ?>" class="qsm_extra_shortcodes_validate_input" name="qsm_extra_shortcodes_validate_input" />
						<input type="submit" name="qsm_extra_shortcodes_validate_button" class="qsm_extra_shortcodes_validate_button button button-primary" value="Validate" />
					</form>
				</div>
				<div id="qsm-license_message" style="display: none; padding: 0 0 0 22px;"><strong class="qsm_extra_shortcodes_validate_message"></strong></div>
			</div>
		<?php
		}
	}
}

function qsm_all_shortcodes_display( $license, $license_status ) {
	global $wpdb;
	wp_enqueue_style( 'wp-color-picker');
	wp_enqueue_script( 'wp-color-picker');

	$quizzes = $wpdb->get_results( "SELECT quiz_id, quiz_name FROM {$wpdb->prefix}mlw_quizzes WHERE deleted=0 ORDER BY quiz_id" );
	$doc_url = esc_url( qsm_get_plugin_link( 'docs/advanced-topics/qsm-calculations/' ) );
	$doc_link = '<a href="' . $doc_url . '" target="_blank">' . __( 'documentation', 'qsm-extra-shortcodes' ) . '</a>';
	$quiz_html = '<select class="qsm_quiz_param" multiple="multiple">';
	foreach ( $quizzes as $quiz ) {
		$quiz_html .= '<option value="'. esc_attr( $quiz->quiz_id ) .'">'. esc_attr( $quiz->quiz_name ) .'</option>';
	}
	$quiz_html .= '</select>';

	$extra_shortcodes = array(
		'qsm_passed'             => array(
			'heading'     => __( 'Show participants with high score' , 'qsm-extra-shortcodes' ),
			'description' => __( 'No. of Participants who scored more than specific score' , 'qsm-extra-shortcodes' ),
			'shortcode'   => 'quiz_id, score',
			'settings'    => [ 'quiz_id', 'score' ],
			'demo'        => '[qsm_passed quiz_id=1 score=90]',
		),
		'qsm_passed_points'      => array(
			'heading'     => __( 'Show participants with high points' , 'qsm-extra-shortcodes' ),
			'description' => __( 'No. of participants who earned more than specific points' , 'qsm-extra-shortcodes' ),
			'shortcode'   => 'quiz_id, score',
			'settings'    => [ 'quiz_id', 'score' ],
			'demo'        => '[qsm_passed_points quiz_id=1 score=90]',
		),
		'qsm_failed'             => array(
			'heading'     => __( 'Show participants with low scores' , 'qsm-extra-shortcodes' ),
			'description' => __( 'No. of participants who scored less than specific score' , 'qsm-extra-shortcodes' ),
			'shortcode'   => 'quiz_id, score',
			'settings'    => [ 'quiz_id', 'score' ],
			'demo'        => '[qsm_failed quiz_id=1 score=90]',
		),
		'qsm_failed_points'      => array(
			'heading'     => __( 'Show participants with low points' , 'qsm-extra-shortcodes' ),
			'description' => __( 'No. of participants who scored less than specific points' , 'qsm-extra-shortcodes' ),
			'shortcode'   => 'quiz_id, score',
			'settings'    => [ 'quiz_id', 'score' ],
			'demo'        => '[qsm_failed_points quiz_id=1 score=90]',
		),
		'qsm_average'            => array(
			'heading'     => __( 'Average Score Shortcode' , 'qsm-extra-shortcodes' ),
			'description' => __( 'Show the average score earned in quizzes' , 'qsm-extra-shortcodes' ),
			'shortcode'   => 'quiz_id, decimal',
			'settings'    => [ 'quiz_id', 'decimal' ],
			'demo'        => '[qsm_average quiz_id=1 decimal=2]',
		),
		'qsm_average_points'     => array(
			'heading'     => __( 'Average Point Shortcode' , 'qsm-extra-shortcodes' ),
			'description' => __( 'Show the average point earned in quizzes' , 'qsm-extra-shortcodes' ),
			'shortcode'   => 'quiz_id, decimal',
			'settings'    => [ 'quiz_id', 'decimal' ],
			'demo'        => '[qsm_average_points quiz_id=1 decimal=2]',
		),
		'qsm_taken'              => array(
			'heading'     => __( 'Total Attempts Shortcode' , 'qsm-extra-shortcodes' ),
			'description' => __( 'Show the total attempts in the quizzes' , 'qsm-extra-shortcodes' ),
			'shortcode'   => 'quiz_id',
			'settings'    => [ 'quiz_id' ],
			'demo'        => '[qsm_taken quiz_id=1]',
		),
		'qsm_recent'             => array(
			'heading'     => __( 'Show list of recently added quizzes' , 'qsm-extra-shortcodes' ),
			'description' => __( 'Set a number of recent quiz list to be displayed' , 'qsm-extra-shortcodes' ),
			'shortcode'   => 'amount',
			'settings'    => [ 'amount' ],
			'demo'        => '[qsm_recent amount=1]',
		),
		'qsm_all_quizzes'        => array(
			'heading'     => __( 'Show list of all quizzes' , 'qsm-extra-shortcodes' ),
			'description' => __( 'Set a number of all quizzes list to be displayed' , 'qsm-extra-shortcodes' ),
			'shortcode'   => 'button_text, limit, date_range',
			'settings'    => [ 'button_text', 'limit', 'date_range' ],
			'demo'        => '[qsm_all_quizzes button_text="Preview" limit=90 date_range=""]',
		),
		'qsm_popular'            => array(
			'heading'     => __( 'Show list of popular quizzes' , 'qsm-extra-shortcodes' ),
			'description' => __( 'Set a number of popular quiz list to be displayed' , 'qsm-extra-shortcodes' ),
			'shortcode'   => 'amount',
			'settings'    => [ 'amount' ],
			'demo'        => '[qsm_popular amount=1]',
		),
		'qsm_assessment_compare' => array(
			'heading'     => __( 'Display user assessment percentage in chart' , 'qsm-extra-shortcodes' ),
			'description' => __( 'Generates a comparison chart (bar or pie) for specified assessment data' , 'qsm-extra-shortcodes' ),
			'shortcode'   => 'value1, value2, label1, label2, color',
			'settings'    => [ 'value1', 'value2', 'label1', 'label2', 'color' ],
			'demo'        => '[qsm_assessment_compare value1=10 value2=20 label1=Label1 lebel2=Label2 color=#2880B9]',
		),
		'qsm_display_score'      => array(
			'heading'     => __( 'Quiz Score Shortcode' , 'qsm-extra-shortcodes' ),
			'description' => __( 'Show the score earned in all quizzes' , 'qsm-extra-shortcodes' ),
			'shortcode'   => 'scoreby, mlw_quiz',
			'settings'    => [ 'scoreby', 'quiz_id' ],
			'demo'        => '[qsm_display_score scoreby="average" mlw_quiz=0]',
		),
		'qsm_calc' => array(
			'heading'     => __( 'Quiz Calc', 'qsm-extra-shortcodes' ),
			'description' => sprintf( __( 'Calculate dynamic results with QSM Calc — see %s.', 'qsm-extra-shortcodes' ), $doc_link ),
			'shortcode'   => '',
			'settings'    => '',
			'demo'        => '[qsm_calc] %CORRECT_SCORE% / %MAXIMUM_POINTS% * 100 [/qsm_calc]',
		),
	);

	$decimal_text = 'Set decimal';
	$amount_text = 'Set limit';
	$score_text = 'Set high score';
	$saved_shortcode = get_option( 'qsm_extra_shortcode_saved_shortcodes', array() );

	if ( '' !== $license && 'valid' === $license_status ) {
	?>
	<div class="qsm_tab_content">
	<table class="form-table qsm-extra-shortcode-table" style="width: 100%;" role="presentation">
		<tr valign="top">
			<th class="section-heading" scope="row" colspan="2">
				<h3><?php esc_html_e('Manage QSM Shortcodes', 'qsm-extra-shortcodes'); ?></h3>
				<p class="section-hint"><?php esc_html_e('Customize shortcodes and display information as per your needs. You can embed the shortcodes in any quiz results, website’s page or post.', 'qsm-extra-shortcodes'); ?> </p>
			</th>
		</tr>
		<?php
		foreach ( $extra_shortcodes as $key => $value ) :
			$demo_shortcode = isset($saved_shortcode[ $key ]) ? $saved_shortcode[ $key ] : $value['demo'];
		?>
		<tr valign="top" class="extra-shortcode-manage-shortcode-rows">
			<th class="section-heading" scope="row">
				<label><?php echo esc_html( $value['heading'] ); ?></label>
			</th>
			<td>
				<div class="extra-shortcode-options-notloop">
					<div class="extra-shortcode-options-field">
						<div class="extra-shortcode-options-group extra-shortcode-options-demo">
							<input class="extra-shortcode-demo" disabled value="<?php echo esc_attr( $demo_shortcode ); ?>" >
						</div>
						<div class="extra-shortcode-options-group extra-shortcode-options-switch">
							<button
								class="button extra-shortcode-generate-shortcode-button"
								data-name="<?php echo esc_attr( $key ); ?>"
								data-params="<?php echo esc_attr( $value['shortcode'] ); ?>"
								onclick="qsm_copy_shortcode(this, 1);"
								title="Copy">
								<img src="<?php echo esc_url(QSM_PLUGIN_URL . 'assets/copy.svg'); ?>" alt="copy.svg"/>
							</button>
						</div>
						<?php if ( ! empty( $value['settings'] ) ) : ?>
						<div class="extra-shortcode-options-group extra-shortcode-options-actions">
							<div class="extra-shortcode-options-actions-box">
								<button class="settings-field" title="Settings">
								<img src="<?php echo esc_url(QSM_PLUGIN_URL . 'assets/edit-pencil.svg'); ?>" alt="edit-pencil.svg"/>
								</button>
							</div>
						</div>
						<?php endif; ?>
						<div class="extra-shortcode-options-field-settings arrow-left" style="display: none;">
							<b><?php esc_html_e( 'Shortcode Settings', "qsm-extra-shortcodes" ); ?></b>
							<hr>
							<?php foreach ( $value['settings'] as $setting_name ) : ?>
								<?php if ( 'quiz_id' == $setting_name ) : ?>
								<div class="extra-shortcode-options-group">
									<label class="extra-shortcode-options-label"><?php esc_html_e( 'Select Quiz', "qsm-extra-shortcodes" ); ?></label>
									<div class="extra-shortcode-field">
										<?php echo $quiz_html; ?>
									</div>
								</div>
								<?php endif; ?>
								<?php if ( in_array( $setting_name, [ 'value1', 'value2', 'label1', 'label2' ] ) ) : ?>
								<div class="extra-shortcode-options-group">
									<label class="extra-shortcode-options-label"><?php echo esc_html( 'Select ' . $setting_name ); ?></label>
									<div class="extra-shortcode-field">
										<input id="<?php echo esc_attr( $setting_name ); ?>" type="text" >
									</div>
								</div>
								<?php endif; ?>
								<?php if ( 'button_text' == $setting_name ) : ?>
								<div class="extra-shortcode-options-group">
									<label class="extra-shortcode-options-label"><?php esc_html_e( 'Write button text', "qsm-extra-shortcodes" ); ?></label>
									<div class="extra-shortcode-field">
										<input id="<?php echo esc_attr( $setting_name ); ?>" type="text" value="<?php esc_html_e( 'Preview', "qsm-extra-shortcodes" ); ?>" >
									</div>
								</div>
								<?php endif; ?>
								<?php if ( 'color' == $setting_name ) : ?>
								<div class="extra-shortcode-options-group">
									<label class="extra-shortcode-options-label"><?php esc_html_e( 'Select Chart', "qsm-extra-shortcodes" ); ?></label>
									<div class="extra-shortcode-field">
										<input id="shortcode_color" class="qsm-shortcode-color-field"
										type="text" data-alpha-enabled="true"
										value="#ffffff"
										data-default-color="#ffffff" data-label="<?php esc_html_e( 'Select Color', 'qsm-extra-shortcodes' ); ?>" >
									</div>
								</div>
								<?php endif; ?>
								<?php if ( 'scoreby' == $setting_name ) : ?>
								<div class="extra-shortcode-options-group">
									<label class="extra-shortcode-options-label"><?php esc_html_e( 'Score By', "qsm-extra-shortcodes" ); ?></label>
									<div class="extra-shortcode-field">
										<select name="quiz_score_by" id="quiz_score_by" class="quiz-score-by">
											<option value="average">
												<?php echo esc_html__("Average", "qsm-extra-shortcodes"); ?>
											</option>
											<option value="top">
												<?php echo esc_html__("Top Score", "qsm-extra-shortcodes"); ?>
											</option>
											<option value="lowest">
												<?php echo esc_html__("Lowest Score", "qsm-extra-shortcodes"); ?>
											</option>
										</select>
									</div>
								</div>
								<?php endif; ?>
								<?php if ( 'decimal' == $setting_name || 'amount' == $setting_name || 'score' == $setting_name || 'limit' == $setting_name ) : ?>
								<div class="extra-shortcode-options-group">
									<label class="extra-shortcode-options-label">
										<?php
										switch ( $setting_name ) {
											case 'decimal':
												esc_html_e( $decimal_text, "qsm-extra-shortcodes" );
												break;
											case 'amount':
												esc_html_e( $amount_text, "qsm-extra-shortcodes" );
												break;
											case 'score':
												esc_html_e( $score_text, "qsm-extra-shortcodes" );
												break;
											case 'limit':
												esc_html_e( 'Set Limit', "qsm-extra-shortcodes" );
												break;
											default:
												break;
										}
										?>
									</label>
									<div class="extra-shortcode-field">
										<input type="number" value="90">
									</div>
								</div>
								<?php endif; ?>
								<?php if ( 'date_range' == $setting_name ) : ?>
								<div class="extra-shortcode-options-group">
									<label class="extra-shortcode-options-label"><?php esc_html_e( 'Set date range', "qsm-extra-shortcodes" ); ?></label>
									<div class="extra-shortcode-field">
										<div class="extra-shortcode-sub-field">
											<p><?php esc_html_e( 'From', "qsm-extra-shortcodes" ); ?></p><input id="start_date" type="date" value="">
										</div>
										<div class="extra-shortcode-sub-field">
											<p><?php esc_html_e( 'To', "qsm-extra-shortcodes" ); ?></p><input id="end_date" type="date" value="">
										</div>
									</div>
								</div>
								<?php endif; ?>
							<?php endforeach; ?>
						</div>
					</div>
					<p class="section-hint"><?php echo wp_kses_post( $value['description'] ); ?></p>
				</div>
			</td>
		</tr>
		<?php endforeach; ?>
	</table>
	</div>
	<?php
	} else {
		$params      = array(
			'please_wait' => __('Please Wait! We are validating your license', 'qsm-extra-shortcodes'),
			'license_msg' => __('License Key Required.', 'qsm-extra-shortcodes'),
			'invalid'     => __('<span class="dashicons dashicons-warning"></span><b>Incorrect License!</b> Please enter a valid license key.', 'qsm-extra-shortcodes'),
		);
		wp_localize_script( 'qsm_extra_shortcodes_admin_script', 'qsm_extra_shortcodes_obj', $params );?>
		<div class="qsm-license-form-parent">
			<div class="qsm-license-header">
				<p class="qsm-heading">
					<?php esc_html_e( 'Manage License', 'qsm-extra-shortcodes' ); ?>
				</p>
			</div>
			<div class="qsm_extra_shortcodes_validate_parent">
				<form class="rq_validata-license" method="POST">
					<input type="text" placeholder="<?php echo esc_html("Enter your license key"); ?>" class="qsm_extra_shortcodes_validate_input" name="qsm_extra_shortcodes_validate_input" />
					<input type="submit" name="qsm_extra_shortcodes_validate_button" class="qsm_extra_shortcodes_validate_button button button-primary" value="Validate" />
				</form>
			</div>
			<div id="qsm-license_message" style="display: none; padding: 0 0 0 22px;"><strong class="qsm_extra_shortcodes_validate_message"></strong></div>
		</div>
	<?php
	}
}

function qsm_extra_shortcode_save_shortcode() {
	global $mlwQuizMasterNext;
	$name   = isset( $_POST['name'] ) ? sanitize_text_field( wp_unslash( $_POST['name'] ) ) : '';
	$shortcode  = isset( $_POST['shortcode'] ) ? sanitize_text_field( wp_unslash( $_POST['shortcode'] ) ) : '';

	$shortcode_default = array(
		'qsm_passed'             => '[qsm_passed quiz_id=1 score=90]',
		'qsm_passed_points'      => '[qsm_passed_points quiz_id=1 score=90]',
		'qsm_failed'             => '[qsm_failed quiz_id=1 score=90]',
		'qsm_failed_points'      => '[qsm_failed_points quiz_id=1 score=90]',
		'qsm_average'            => '[qsm_average quiz_id=1 decimal=2]',
		'qsm_average_points'     => '[qsm_average_points quiz_id=1 decimal=2]',
		'qsm_taken'              => '[qsm_taken quiz_id=1]',
		'qsm_recent'             => '[qsm_recent amount=1]',
		'qsm_popular'            => '[qsm_popular amount=1]',
		'qsm_assessment_compare' => '[qsm_assessment_compare value1=10 value2=20 label1=Label1 lebel2=Label2 color=#2880B9]',
		'qsm_display_score'      => '[qsm_display_score scoreby="average" mlw_quiz=0]',
		'qsm_all_quizzes'        => '[qsm_all_quizzes button_text="Preview" limit=90 date_range=""]',
		'qsm_calc'		         => '[qsm_calc] %CORRECT_SCORE% / %MAXIMUM_POINTS% * 100 [/qsm_calc]',
	);

	$saved_shortcode = get_option( 'qsm_extra_shortcode_saved_shortcodes', array() );
	$saved_shortcode = wp_parse_args( $saved_shortcode, $shortcode_default );

	$current_shortcode = [
		$name => $shortcode,
	];
	update_option( 'qsm_extra_shortcode_saved_shortcodes', wp_parse_args( $current_shortcode, $saved_shortcode ) );
	echo wp_json_encode(array(
		'updated' => 1,
	));
	wp_die();
}