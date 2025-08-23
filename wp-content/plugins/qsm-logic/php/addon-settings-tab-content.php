<?php
if ( ! defined( 'ABSPATH' ) )
	exit;

/**
 * Registers your tab in the addon  settings page
 *
 * @since 0.1.0
 * @return void
 */
function qsm_addon_logic_register_addon_settings_tabs() {
	global $mlwQuizMasterNext;
	if ( ! is_null( $mlwQuizMasterNext ) && ! is_null( $mlwQuizMasterNext->pluginHelper ) && method_exists( $mlwQuizMasterNext->pluginHelper, 'register_quiz_settings_tabs' ) ) {
		$mlwQuizMasterNext->pluginHelper->register_addon_settings_tab( "Logic", 'qsm_addon_logic_addon_settings_tabs_content' );
	}
}

/**
 * Generates the content for your addon settings tab
 *
 * @since 0.1.0
 * @return void
 */
function qsm_addon_logic_addon_settings_tabs_content() {
	global $mlwQuizMasterNext;
	wp_enqueue_style( 'qsm_logic_admin_style', QSM_LOGIC_ADDON_URL . '/css/qsm-logic-admin.css', array(), QSM_LOGIC_VERSION );
	wp_enqueue_script( 'qsm_logic_admin', QSM_LOGIC_ADDON_URL . '/js/admin.js', array(), QSM_LOGIC_VERSION, true );
	?>
	<nav class="nav-tab-wrapper">
		<a class="nav-tab <?php echo ! isset( $_GET['logic'] ) ? esc_attr( 'nav-tab-active' ) : ''; ?>" href="
			<?php
			echo esc_url(
				add_query_arg(
					array(
						'page' => 'qmn_addons',
						'tab'  => 'logic',
					),
					admin_url( 'admin.php' )
				)
			);
			?>
		"><?php esc_html_e( 'License', 'qsm-logic' ); ?></a>
	</nav>
	<?php
	$date_now = gmdate("d-m-Y");
	$settings_data = wp_parse_args( 
		get_option( 'qsm_addon_logic_settings', array() ), 
		array(
			'license_key' => '',
		)
	);
	$license = isset($settings_data['license_key']) ? $settings_data['license_key'] : '';
	$license_status = isset($settings_data['license_status']) ? $settings_data['license_status'] : '';

	if ( '' !== $license && 'valid' === $license_status ) {
		$params      = array(
			'invalid' => __('<span class="dashicons dashicons-warning"></span><b>Incorrect License!</b> Please enter a valid license key.', 'qsm-logic'),
			'hold'    => __('Please Wait! We are validating your license', 'qsm-logic'),
			'empty'   => __('Please enter a license key.', 'qsm-logic'),
		);
		wp_localize_script( 'qsm_logic_admin', 'qsm_license_validate_obj', $params );
		?>
		<div class="qsm-license-container">
			<div class="qsm-license-header">
				<p class="qsm-heading">
					<?php esc_html_e( 'Manage License', 'qsm-logic' ); ?>
				</p>
			</div>
			<div class='qsm-license-content'>
			<?php 
				if ( (isset($settings_data['expiry_date']) && "" !== $settings_data['expiry_date']) && (isset($settings_data['last_validate']) && "" !== $settings_data['last_validate']) && strtotime($date_now) > strtotime($settings_data['expiry_date']) && strtotime($date_now) >= strtotime($settings_data['last_validate']) ) { 
					$item_url = 'https://quizandsurveymaster.com/checkout/?edd_license_key='.$license.'&download_id='.QSM_LOGIC_ID;
				?>
				<div class="qsm-license-info">
					<p class='qsm-valid-msg'>
						<img class="qsm-warning" src="<?php echo esc_attr( QSM_LOGIC_ADDON_URL . '/images/warning.png' ); ?>" alt="">
						<span class='qsm-msg qsm-addon-title'><b><?php esc_html_e( 'QSM Logic License', 'qsm-logic' ); ?></b></span>
						<span class='qsm-msg qsm-addon-status'>
							<?php esc_html_e( 'Your license is expired.', 'qsm-logic' ); ?>
							<a target="_blank" href="<?php echo esc_url( $item_url ); ?>"><?php esc_html_e( 'Renew', 'qsm-logic' ); ?></a>
						</span>
					</p>
					<a data-toggle='0' class="qsm-toggleButton" href=""><?php esc_attr_e( 'Change License', 'qsm-logic' ); ?></a>
				</div>
			<?php } else { ?>
				<div class="qsm-license-info">
					<p class='qsm-valid-msg'>
						<span class="dashicons dashicons-yes-alt"></span>
						<span class='qsm-msg qsm-addon-title'><b><?php esc_html_e( 'QSM Logic License', 'qsm-logic' ); ?></b></span>
						<span class='qsm-msg qsm-addon-status'><?php esc_html_e( 'Valid till ', 'qsm-logic' ); ?><?php esc_html_e( date( 'd M, Y', strtotime($settings_data['expiry_date'])), 'qsm-logic' ); ?></span>
					</p>
					<a data-toggle='0' class="qsm-toggleButton" href=""><?php esc_attr_e( 'Change License', 'qsm-logic' ); ?></a>
				</div>
			<?php } ?>
				<form id="qsm-license_entry" action="" method="post" style="display: none;">
					<input type="text" name="license_key" placeholder="<?php esc_html_e( 'Enter License key', 'qsm-logic' ); ?>"/>
					<button id="qsm-validate_btn" class="button button-primary"><?php esc_html_e( 'Validate', 'qsm-logic' ); ?></button>
					<a data-toggle='1' class="qsm-toggleButton" href=""><?php esc_html_e( 'Cancel', 'qsm-logic' ); ?></a>
					<p class="qsm-validate-msg"></p>
				</form>
			</div>
		</div>
	<?php
	} else {
		$params      = array(
			'please_wait' => __('Please Wait! We are validating your license', 'qsm-logic'),
			'license_msg' => __('License Key Required.', 'qsm-logic'),
			'invalid'     => __('<span class="dashicons dashicons-warning"></span><b>Incorrect License!</b> Please enter a valid license key.', 'qsm-logic'),
		);
		wp_localize_script( 'qsm_logic_admin', 'qsm_logic_obj', $params );?>
		<div class="qsm-license-form-parent">
			<div class="qsm-license-header">
				<p class="qsm-heading">
					<?php esc_html_e( 'Manage License', 'qsm-logic' ); ?>
				</p>
			</div>
			<div class="qsm_logic_validate_parent">
				<form class="rq_validata-license" method="POST">
					<input type="text" placeholder="<?php echo esc_html("Enter your license key"); ?>" class="qsm_logic_validate_input" name="qsm_logic_validate_input" />
					<input type="submit" name="qsm_logic_validate_button" class="qsm_logic_validate_button button button-primary" value="Validate" />
				</form>
			</div>
			<div id="qsm-license_message" style="display: none; padding: 0 0 0 22px;"><strong class="qsm_logic_validate_message"></strong></div>
		</div>
		<?php
	}
}
