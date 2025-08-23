<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Registers your tab in the addon  settings page
 *
 * @since 1.1.0
 * @return void
 */
function qsm_addon_daily_limit_register_addon_settings_tabs() {
	global $mlwQuizMasterNext;
	if ( ! is_null( $mlwQuizMasterNext ) && ! is_null( $mlwQuizMasterNext->pluginHelper ) && method_exists( $mlwQuizMasterNext->pluginHelper, 'register_quiz_settings_tabs' ) ) {
		$mlwQuizMasterNext->pluginHelper->register_addon_settings_tab( "Daily Limit", 'qsm_addon_daily_limit_addon_settings_tabs_content' );
	}
}

/**
 * Generates the content for your addon settings tab
 *
 * @since 1.1.0
 * @return void
 */
function qsm_addon_daily_limit_addon_settings_tabs_content() {
	global $mlwQuizMasterNext;
	wp_enqueue_script( 'qsm-daily-limit-admin_js', QSM_DAILY_LIMIT_ADDON_URL . 'js/admin.js', array(), QSM_DAILY_LIMIT_VERSION, true );
	wp_enqueue_style( 'qsm-daily-limit-admin-css', QSM_DAILY_LIMIT_ADDON_URL . 'css/qsm-daily-limit-admin.css', array(), QSM_DAILY_LIMIT_VERSION );
	?>
	<nav class="nav-tab-wrapper">
		<a class="nav-tab <?php echo ('daily-limit' === $_GET['tab']) ? esc_attr( 'nav-tab-active' ) : ''; ?>" href="
			<?php
			echo esc_url(
				add_query_arg(
					array(
						'page' => 'qmn_addons',
						'tab'  => 'daily-limit',
					),
					admin_url( 'admin.php' )
				)
			);
			?>
		"><?php esc_html_e( 'License', 'qsm-daily-limit' ); ?></a>
	</nav>
	<?php
	$date_now = date("d-m-Y");
	$settings = wp_parse_args( 
		get_option( 'qsm_addon_daily_limit_settings', array() ), 
		array( 'license_key' => '' ) 
	);
	$license     = isset( $settings['license_key'] ) ? trim( $settings['license_key'] ) : '';
	$license_status = isset( $settings['license_status'] ) ? trim( $settings['license_status'] ) : '';

	if ( '' !== $license && 'valid' === $license_status ) {
		$params      = array(
			'invalid' => __('<span class="dashicons dashicons-warning"></span><b>Incorrect License!</b> Please enter a valid license key.', 'qsm-daily-limit'),
			'hold'    => __('Please Wait! We are validating your license', 'qsm-daily-limit'),
			'empty'   => __('Please enter a license key.', 'qsm-daily-limit'),
		);
		wp_localize_script( 'qsm-daily-limit-admin_js', 'qsm_license_validate_obj', $params );
		?>
		<div class="qsm-daily-limit-license-container">
			<div class="qsm-license-header">
				<p class="qsm-heading">
					<?php esc_html_e( 'Manage License', 'qsm-daily-limit' ); ?>
				</p>
			</div>
			<div class='qsm-license-content'>
			<?php 
				if ( (isset($settings['expiry_date']) && "" !== $settings['expiry_date']) && (isset($settings['last_validate']) && "" !== $settings['last_validate']) && strtotime($date_now) > strtotime($settings['expiry_date']) && strtotime($date_now) >= strtotime($settings['last_validate']) ) { 
					$item_url = 'https://quizandsurveymaster.com/checkout/?edd_license_key='.$license.'&download_id='.QSM_DAILY_LIMIT_ITEM;
				?>
				<div class="qsm-license-info">
					<p class='qsm-valid-msg'>
						<img class="qsm-warning" src="<?php echo esc_attr( QSM_DAILY_LIMIT_ADDON_URL . '/img/warning.png' ); ?>" alt="">
						<span class='qsm-msg qsm-addon-title'><b><?php esc_html_e( 'Daily Limit License', 'qsm-daily-limit' ); ?></b></span>
						<span class='qsm-msg qsm-addon-status'>
							<?php esc_html_e( 'Your license is expired.', 'qsm-daily-limit' ); ?>
							<a target="_blank" href="<?php echo esc_url( $item_url ); ?>"><?php esc_html_e( 'Renew', 'qsm-daily-limit' ); ?></a>
						</span>
					</p>
					<a data-toggle='0' class="qsm-toggleButton" href=""><?php esc_attr_e( 'Change License', 'qsm-daily-limit' ); ?></a>
				</div>
			<?php } else { ?>
				<div class="qsm-license-info">
					<p class='qsm-valid-msg'>
						<span class="dashicons dashicons-yes-alt"></span>
						<span class='qsm-msg qsm-addon-title'><b><?php esc_html_e( 'Daily Limit License', 'qsm-daily-limit' ); ?></b></span>
						<span class='qsm-msg qsm-addon-status'><?php esc_html_e( 'Valid till ', 'qsm-daily-limit' ); ?><?php esc_html_e( date( 'd M, Y', strtotime($settings['expiry_date'])), 'qsm-daily-limit' ); ?></span>
					</p>
					<a data-toggle='0' class="qsm-toggleButton" href=""><?php esc_attr_e( 'Change License', 'qsm-daily-limit' ); ?></a>
				</div>
			<?php } ?>
				<form id="qsm-license_entry" action="" method="post" style="display: none;">
					<input type="text" name="license_key" placeholder="<?php esc_html_e( 'Enter License key', 'qsm-daily-limit' ); ?>"/>
					<button id="qsm-validate_btn" class="button button-primary"><?php esc_html_e( 'Validate', 'qsm-daily-limit' ); ?></button>
					<a data-toggle='1' class="qsm-toggleButton" href=""><?php esc_html_e( 'Cancel', 'qsm-daily-limit' ); ?></a>
					<p class="qsm-validate-msg"></p>
				</form>
			</div>
		</div>
	<?php
	} else {
		$params      = array(
			'please_wait' => __('Please Wait! We are validating your license', 'qsm-daily-limit'),
			'license_msg' => __('License Key Required.', 'qsm-daily-limit'),
			'invalid'     => __('<span class="dashicons dashicons-warning"></span><b>Incorrect License!</b> Please enter a valid license key.', 'qsm-daily-limit'),
		);
		wp_localize_script( 'qsm-daily-limit-admin_js', 'qsm_daily_limit_obj', $params );?>
		<div class="qsm-license-form-parent">
			<div class="qsm-license-header">
				<p class="qsm-heading">
					<?php esc_html_e( 'Manage License', 'qsm-daily-limit' ); ?>
				</p>
			</div>
			<div class="qsm_daily_limit_validate_parent">
				<form class="rq_validata-license" method="POST">
					<input type="text" placeholder="<?php echo esc_html("Enter your license key"); ?>" class="qsm_daily_limit_validate_input" name="qsm_daily_limit_validate_input" />
					<input type="submit" name="qsm_daily_limit_validate_button" class="qsm_daily_limit_validate_button button button-primary" value="Validate" />
				</form>
			</div>
			<div id="qsm-license_message" style="display: none; padding: 0 0 0 22px;"><strong class="qsm_daily_limit_validate_message"></strong></div>
		</div>
	<?php
	}
}
