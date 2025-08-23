<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Registers your tab in the addon  settings page
 *
 * @since 1.0.0
 * @return void
 */
function qsm_addon_advanced_timer_register_stats_tabs() {
	global $mlwQuizMasterNext;
	if ( ! is_null( $mlwQuizMasterNext ) && ! is_null( $mlwQuizMasterNext->pluginHelper ) && method_exists( $mlwQuizMasterNext->pluginHelper, 'register_quiz_settings_tabs' ) ) {
		$mlwQuizMasterNext->pluginHelper->register_addon_settings_tab( 'Advanced Timer', 'qsm_addon_advanced_timer_addon_settings_tabs_content' );
	}
	if ( version_compare( $mlwQuizMasterNext->version, '7.3.4', '>' ) ) {
		add_filter( 'qsm_text_variable_list_result', 'qsm_advanced_timer_show_variable', 10, 1 );
	} else {
		add_filter( 'qsm_text_variable_list', 'qsm_advanced_timer_show_variable', 10, 1 );
	}

	$field_array = array(
		'label'           => __( 'Per-page time in auto-paging', 'qsm-advanced-timer' ),
		'id'              => 'advance_per_page_timer',
		'type'            => 'multiple_fields',
		'fields'          => array(
			'advance_per_page_timer'         => array(
				'type'        => 'number',
				'suffix_text' => '<i class="qsm-font-light">' . __( 'Minutes and &nbsp;', 'qsm-advanced-timer' ) . '</i>',
				'default'     => 0,
			),
			'advance_per_page_timer_seconds' => array(
				'type'        => 'number',
				'suffix_text' => '<i class="qsm-font-light">' . __( 'Seconds', 'qsm-advanced-timer' ) . '</i>',
				'default'     => 0,
			),
		),
		'container_class' => 'qsm-advance-timer-input',
		'help'            => __( 'Set a timer for answering each page. If you don\'t wish to set a common time in each page, leave it blank or zero(0).', 'qsm-advanced-timer' ),
		'option_tab'      => 'display',
		'tooltip'         => __( 'When auto-paging, a timer displays on each page with the set number of questions (in question per page).', 'qsm-advanced-timer' ),
	);
	$settings_data   = get_option('qsm_addon_advanced_timer_settings', '');
	if ( ( isset($settings_data['last_validate']) && "invalid" == $settings_data['last_validate'] ) || empty($settings_data) ) { }
	else{
		$mlwQuizMasterNext->pluginHelper->register_quiz_setting( $field_array, 'quiz_options' );
	}
}

/**
 * Add TIME_PER_PAGE template variable in list.
 *
 * @since 1.0.6
 * @param array $variable_list variable list.
 * @return array
 */
function qsm_advanced_timer_show_variable( $variable_list ) {
	global $mlwQuizMasterNext;
	$template_array = array(
		'%TIME_PER_PAGE%'   => __( 'Display time taken by user per page.', 'qsm-advanced-timer' ),
		'%TIME_PER_PAGE_X%' => __( 'X: Page name, Display time taken by user.', 'qsm-advanced-timer' ),
	);
	if ( version_compare( $mlwQuizMasterNext->version, '7.3.4', '>' ) ) {
		$advanced_timer = array(
			'Advance Timer' => $template_array,
		);
	} else {
		$advanced_timer = $template_array;
	}
	$variable_list = array_merge( $variable_list, $advanced_timer );
	return $variable_list;
}

/**
 * Generates the content for your addon settings tab
 *
 * @since 1.0.0
 * @return void
 */
function qsm_addon_advanced_timer_addon_settings_tabs_content() {
	global $mlwQuizMasterNext;
	wp_enqueue_script( 'qsm_advanced_timer_admin', plugins_url( '../js/admin.js' , __FILE__ ), array( 'jquery' ), QSM_ADVANCED_TIMER_VERSION );
	wp_enqueue_style( 'advance_timer_admin_style', plugins_url( 'css/admin.css', __FILE__ ), array(), QSM_ADVANCED_TIMER_VERSION );
	?>
	<nav class="nav-tab-wrapper">
		<a class="nav-tab" href="
			<?php
			echo esc_url(
				add_query_arg(
					array(
						'page'    => 'qmn_addons',
						'tab'     => 'advanced-timer',
					),
					admin_url( 'admin.php' )
				)
			);
			?>
		"><?php esc_html_e( 'License', 'qsm-advanced-timer' ); ?></a>
	</nav>
	<?php
	// Load settings.
	$date_now = gmdate("d-m-Y");
	$settings_data = wp_parse_args( 
		get_option( 'qsm_addon_advanced_timer_settings', array() ), 
		array(
			'license_key' => '',
		)
	);
	$license         = isset( $settings_data['license_key'] ) ? trim( $settings_data['license_key'] ) : '';
	$license_status  = isset( $settings_data['license_status'] ) ? $settings_data['license_status'] : '';
	if ( '' != $license && 'valid' == $license_status ) {
		$params      = array(
			'invalid' => __('<span class="dashicons dashicons-warning"></span><b>Incorrect License!</b> Please enter a valid license key.', 'qsm-advanced-timer'),
			'hold'    => __('Please Wait! We are validating your license', 'qsm-advanced-timer'),
			'empty'   => __('Please enter a license key.', 'qsm-advanced-timer'),
		);
		wp_localize_script( 'qsm_advanced_timer_admin', 'qsm_license_validate_obj', $params );
	?>
	<div class="qsm-license-container">
		<div class="qsm-license-header">
			<p class="qsm-heading">
				<?php esc_html_e( 'Manage License', 'qsm-advanced-timer' ); ?>
			</p>
		</div>
		<div class='qsm-license-content'>
		<?php 
			if ( (isset($settings_data['expiry_date']) && "" !== $settings_data['expiry_date']) && (isset($settings_data['last_validate']) && "" !== $settings_data['last_validate']) && strtotime($date_now) > strtotime($settings_data['expiry_date']) && strtotime($date_now) >= strtotime($settings_data['last_validate']) ) { 
				$item_url = 'https://quizandsurveymaster.com/checkout/?edd_license_key='.$license.'&download_id='.QSM_ADVANCED_TIMER_ITEM;
			?>
			<div class="qsm-license-info">
				<p class='qsm-valid-msg'>
					<img class="qsm-warning" src="<?php echo esc_attr( QSM_ADVANCED_TIMER_PLUGIN_URL . '/img/warning.png' ); ?>" alt="">
					<span class='qsm-msg qsm-addon-title'><b><?php esc_html_e( 'Advanced Timer License', 'qsm-advanced-timer' ); ?></b></span>
					<span class='qsm-msg qsm-addon-status'>
						<?php esc_html_e( 'Your license is expired.', 'qsm-advanced-timer' ); ?>
						<a target="_blank" href="<?php echo esc_url( $item_url ); ?>"><?php esc_html_e( 'Renew', 'qsm-advanced-timer' ); ?></a>
					</span>
				</p>
				<a data-toggle='0' class="qsm-toggleButton" href=""><?php esc_attr_e( 'Change License', 'qsm-advanced-timer' ); ?></a>
			</div>
		<?php } else { ?>
			<div class="qsm-license-info">
				<p class='qsm-valid-msg'>
					<span class="dashicons dashicons-yes-alt"></span>
					<span class='qsm-msg qsm-addon-title'><b><?php esc_html_e( 'Advanced Timer License', 'qsm-advanced-timer' ); ?></b></span>
					<span class='qsm-msg qsm-addon-status'><?php esc_html_e( 'Valid till ', 'qsm-advanced-timer' ); ?><?php esc_html_e( date( 'd M, Y', strtotime($settings_data['expiry_date'])), 'qsm-advanced-timer' ); ?></span>
				</p>
				<a data-toggle='0' class="qsm-toggleButton" href=""><?php esc_attr_e( 'Change License', 'qsm-advanced-timer' ); ?></a>
			</div>
		<?php } ?>
			<form id="qsm-license_entry" action="" method="post" style="display: none;">
				<input type="text" name="license_key" placeholder="<?php esc_html_e( 'Enter License key', 'qsm-advanced-timer' ); ?>"/>
				<button id="qsm-validate_btn" class="button button-primary"><?php esc_html_e( 'Validate', 'qsm-advanced-timer' ); ?></button>
				<a data-toggle='1' class="qsm-toggleButton" href=""><?php esc_html_e( 'Cancel', 'qsm-advanced-timer' ); ?></a>
				<p class="qsm-validate-msg"></p>
			</form>
		</div>
	</div>
	<?php
	}else {
		$params      = array(
			'please_wait' => __('Please Wait! We are validating your license', 'qsm-advanced-timer'),
			'license_msg' => __('License Key Required.', 'qsm-advanced-timer'),
			'invalid'     => __('<span class="dashicons dashicons-warning"></span><b>Incorrect License!</b> Please enter a valid license key.', 'qsm-advanced-timer'),
		);
		wp_localize_script( 'qsm_advanced_timer_admin', 'qsm_advanced_t_obj', $params );?>
		<div class="qsm-license-form-parent">
			<div class="qsm-license-header">
				<p class="qsm-heading">
					<?php esc_html_e( 'Manage License', 'qsm-advanced-timer' ); ?>
				</p>
			</div>
			<div class="qsm_advanced_t_validate_parent">
				<form class="rq_validata-license" method="POST">
					<input type="text" placeholder="<?php echo esc_html("Enter your license key"); ?>" class="qsm_advanced_t_validate_input" name="qsm_advanced_t_validate_input" />
					<input value="Validate" type="submit" name="qsm_advanced_t_validate_button" class="qsm_advanced_t_validate_button button button-primary" />
				</form>
			</div>
			<div id="qsm-license_message" style="display: none; padding: 0 0 0 22px;"><p><strong class="qsm_advanced_t_validate_message"></strong></div>
		</div>
		<?php
	}
}
