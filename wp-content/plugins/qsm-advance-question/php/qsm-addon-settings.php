<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Registers your tab in the addon settings page
 *
 * @since 1.0.0
 * @return void
 */
function qsm_addon_advance_question_register_addon_settings_tabs() {
	global $mlwQuizMasterNext;
	if ( ! is_null( $mlwQuizMasterNext ) && ! is_null( $mlwQuizMasterNext->pluginHelper ) && method_exists( $mlwQuizMasterNext->pluginHelper, 'register_quiz_settings_tabs' ) ) {
		$mlwQuizMasterNext->pluginHelper->register_addon_settings_tab( 'Advance Question Type', 'qsm_addon_advance_question_addon_settings_tabs_content' );
	}
}

/**
 * Generates the content for your addon settings tab
 *
 * @since 1.1.0
 * @return void
 */
function qsm_addon_advance_question_addon_settings_tabs_content() {
	global $mlwQuizMasterNext;
	wp_enqueue_style( 'qsm-advance-question-addon-admin-css', QSM_ADVANCE_QUESTION_ADDON_CSS_URL . '/qsm-custom-addon-admin.css', array(), QSM_ADVANCE_QUESTION_ADDON_VERSION );
	wp_enqueue_script( 'qsm-advance-question-addon-admin-js', QSM_ADVANCE_QUESTION_ADDON_JS_URL . '/qsm-custom-addon-admin.js', array( 'jquery', 'qsm_admin_js' ), QSM_ADVANCE_QUESTION_ADDON_VERSION, true );
	?>
	<nav class="nav-tab-wrapper">
		<a class="nav-tab" href="
			<?php
			echo esc_url(
				add_query_arg(
					array(
						'page' => 'qmn_addons',
						'tab'  => 'advance-question-type',
					),
					admin_url( 'admin.php' )
				)
			);
			?>
		"><?php esc_html_e( 'License', 'qsm-advance-question' ); ?></a>
	</nav>
	<?php
	// Load settings.
	$date_now   = gmdate("d-m-Y");
	$settings   = wp_parse_args( 
		get_option( 'qsm_addon_advance_question_settings', array() ), 
		array(
			'license_key' => '',
		)
	);
	$license         = isset( $settings['license_key'] ) ? trim( $settings['license_key'] ) : '';
	$license_status  = isset( $settings['license_status'] ) ? $settings['license_status'] : '';
	if ( '' != $license && 'valid' == $license_status ) {
		$params      = array(
			'invalid' => __('<span class="dashicons dashicons-warning"></span><b>Incorrect License!</b> Please enter a valid license key.', 'qsm-advance-question'),
			'hold'    => __('Please Wait! We are validating your license', 'qsm-advance-question'),
			'empty'   => __('Please enter a license key.', 'qsm-advance-question'),
		);
		wp_localize_script( 'qsm-advance-question-addon-admin-js', 'qsm_license_validate_obj', $params );
		?>
		<div class="qsm-license-container">
			<div class="qsm-license-header">
				<p class="qsm-heading">
					<?php esc_html_e( 'Manage License', 'qsm-advance-question' ); ?>
				</p>
			</div>
			<div class='qsm-license-content'>
			<?php 
				if ( (isset($settings['expiry_date']) && "" !== $settings['expiry_date']) && (isset($settings['last_validate']) && "" !== $settings['last_validate']) && strtotime($date_now) > strtotime($settings['expiry_date']) && strtotime($date_now) >= strtotime($settings['last_validate']) ) { 
					$item_url = 'https://quizandsurveymaster.com/checkout/?edd_license_key='.$license.'&download_id='.QSM_ADVANCE_QUESTION_ITEM;
				?>
				<div class="qsm-license-info">
					<p class='qsm-valid-msg'>
						<img class="qsm-warning" src="<?php echo esc_attr( QSM_ADVANCE_QUESTION_ADDON_URL . '/img/warning.png' ); ?>" alt="">
						<span class='qsm-msg qsm-addon-title'><b><?php esc_html_e( 'Advanced Question Types License', 'qsm-advance-question' ); ?></b></span>
						<span class='qsm-msg qsm-addon-status'><?php esc_html_e( 'Your license is expired.', 'qsm-advance-question' ); ?></span>
					</p>
					<a target="_blank" href="<?php echo esc_url( $item_url ); ?>"><?php esc_html_e( 'Renew License', 'qsm-advance-question' ); ?></a>
					<a data-toggle='0' class="qsm-toggleButton" href=""><?php esc_attr_e( 'Change License', 'qsm-advance-question' ); ?></a>
				</div>
			<?php } else { ?>
				<div class="qsm-license-info">
					<p class='qsm-valid-msg'>
						<span class="dashicons dashicons-yes-alt"></span>
						<span class='qsm-msg qsm-addon-title'><b><?php esc_html_e( 'Advanced Question Types License', 'qsm-advance-question' ); ?></b></span>
						<span class='qsm-msg qsm-addon-status'><?php esc_html_e( 'Valid till ', 'qsm-advance-question' ); ?><?php esc_html_e( gmdate( 'd M, Y', strtotime($settings['expiry_date'])), 'qsm-advance-question' ); ?></span>
					</p>
					<a data-toggle='0' class="qsm-toggleButton" href=""><?php esc_attr_e( 'Change License', 'qsm-advance-question' ); ?></a>
				</div>
			<?php } ?>
				<form id="qsm-license_entry" action="" method="post" style="display: none;">
					<input type="text" name="license_key" placeholder="<?php esc_html_e( 'Enter License key', 'qsm-advance-question' ); ?>"/>
					<button id="qsm-validate_btn" class="button button-primary"><?php esc_html_e( 'Validate', 'qsm-advance-question' ); ?></button>
					<a data-toggle='1' class="qsm-toggleButton" href=""><?php esc_html_e( 'Cancel', 'qsm-advance-question' ); ?></a>
					<p class="qsm-validate-msg"></p>
				</form>
			</div>
		</div>
		<?php
	} else {
		$params      = array(
			'please_wait' => __('Please Wait! We are validating your license', 'qsm-advance-question'),
			'license_msg' => __('License Key Required.', 'qsm-advance-question'),
			'invalid'     => __('<span class="dashicons dashicons-warning"></span><b>Incorrect License!</b> Please enter a valid license key.', 'qsm-advance-question'),
		);
		wp_localize_script( 'qsm-advance-question-addon-admin-js', 'qsm_advance_question_obj', $params );?>
		<div class="qsm-license-form-parent">
			<div class="qsm-license-header">
				<p class="qsm-heading">
					<?php esc_html_e( 'Manage License', 'qsm-advance-question' ); ?>
				</p>
			</div>
			<div class="qsm_advance_question_validate_parent">
				<form class="rq_validata-license" method="POST">
					<input type="text" placeholder="<?php echo esc_html("Enter your license key"); ?>" class="qsm_advance_question_validate_input" name="qsm_advance_question_validate_input" />
					<input value="Validate" type="submit" name="qsm_advance_question_validate_button" class="qsm_advance_question_validate_button button button-primary" />
				</form>
			</div>
			<div id="qsm-license_message" style="display: none; padding: 0 0 0 22px;"><p><strong class="qsm_advance_question_validate_message"></strong></div>
		</div>
		<?php
	}
}
