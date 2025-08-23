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
function qsm_addon_extra_variables_register_addon_settings_tabs() {
	global $mlwQuizMasterNext;
	if ( ! is_null( $mlwQuizMasterNext ) && ! is_null( $mlwQuizMasterNext->pluginHelper ) && method_exists( $mlwQuizMasterNext->pluginHelper, 'register_quiz_settings_tabs' ) ) {
		$mlwQuizMasterNext->pluginHelper->register_addon_settings_tab( "Extra Variables", 'qsm_addon_extra_variables_addon_settings_tabs_content' );
	}
}

/**
 * Generates the content for your addon settings tab
 *
 * @since 1.1.0
 * @return void
 */
function qsm_addon_extra_variables_addon_settings_tabs_content() {
	global $mlwQuizMasterNext;
	wp_enqueue_script( 'extra-variables-admin_js', QSM_EXTRA_VARIABLES_ADDON_URL . 'js/admin.js', array(), QSM_EXTRA_VARIABLES_VERSION, true );
	wp_enqueue_style( 'extra-variables-admin-css', QSM_EXTRA_VARIABLES_ADDON_URL . 'css/admin.css', array(), QSM_EXTRA_VARIABLES_VERSION );
	?>
	<nav class="nav-tab-wrapper">
		<a class="nav-tab <?php echo ('extra-variables' === $_GET['tab']) ? esc_attr( 'nav-tab-active' ) : ''; ?>" href="
			<?php
			echo esc_url(
				add_query_arg(
					array(
						'page' => 'qmn_addons',
						'tab'  => 'extra-variables',
					),
					admin_url( 'admin.php' )
				)
			);
			?>
		"><?php esc_html_e( 'License', 'qsm-extra-variables' ); ?></a>
	</nav>
	<?php
	$date_now = date("d-m-Y");
	$template_data = wp_parse_args( 
		get_option( 'qsm_addon_extra_variables_settings', array() ), 
		array( 'license_key' => '' ) 
	);
	$license        = isset( $template_data['license_key'] ) ? trim( $template_data['license_key'] ) : '';
	$license_status = isset( $template_data['license_status'] ) ? trim( $template_data['license_status'] ) : '';

	if ( '' !== $license && 'valid' === $license_status ) {
		$params      = array(
			'invalid' => __('<span class="dashicons dashicons-warning"></span><b>Incorrect License!</b> Please enter a valid license key.', 'qsm-extra-variables'),
			'hold'    => __('Please Wait! We are validating your license', 'qsm-extra-variables'),
			'empty'   => __('Please enter a license key.', 'qsm-extra-variables'),
		);
		wp_localize_script( 'extra-variables-admin_js', 'qsm_license_validate_obj', $params );
		?>
		<div class="qsm-license-container">
			<div class="qsm-license-header">
				<p class="qsm-heading">
					<?php esc_html_e( 'Manage License', 'qsm-extra-variables' ); ?>
				</p>
			</div>
			<div class='qsm-license-content'>
			<?php 
				if ( (isset($template_data['expiry_date']) && "" !== $template_data['expiry_date']) && (isset($template_data['last_validate']) && "" !== $template_data['last_validate']) && strtotime($date_now) > strtotime($template_data['expiry_date']) && strtotime($date_now) >= strtotime($template_data['last_validate']) ) { 
					$item_url = 'https://quizandsurveymaster.com/checkout/?edd_license_key='.$license.'&download_id='.QSM_EXTRA_VARIABLES_ITEM;
				?>
				<div class="qsm-license-info">
					<p class='qsm-valid-msg'>
						<img class="qsm-warning" src="<?php echo esc_attr( QSM_EXTRA_VARIABLES_ADDON_URL . '/img/warning.png' ); ?>" alt="">
						<span class='qsm-msg qsm-addon-title'><b><?php esc_html_e( 'Extra Template Variables License', 'qsm-extra-variables' ); ?></b></span>
						<span class='qsm-msg qsm-addon-status'>
							<?php esc_html_e( 'Your license is expired.', 'qsm-extra-variables' ); ?>
							<a target="_blank" href="<?php echo esc_url( $item_url ); ?>"><?php esc_html_e( 'Renew', 'qsm-extra-variables' ); ?></a>
						</span>
					</p>
					<a data-toggle='0' class="qsm-toggleButton" href=""><?php esc_attr_e( 'Change License', 'qsm-extra-variables' ); ?></a>
				</div>
			<?php } else { ?>
				<div class="qsm-license-info">
					<p class='qsm-valid-msg'>
						<span class="dashicons dashicons-yes-alt"></span>
						<span class='qsm-msg qsm-addon-title'><b><?php esc_html_e( 'Extra Template Variables License', 'qsm-extra-variables' ); ?></b></span>
						<span class='qsm-msg qsm-addon-status'><?php esc_html_e( 'Valid till ', 'qsm-extra-variables' ); ?><?php esc_html_e( date( 'd M, Y', strtotime($template_data['expiry_date'])), 'qsm-extra-variables' ); ?></span>
					</p>
					<a data-toggle='0' class="qsm-toggleButton" href=""><?php esc_attr_e( 'Change License', 'qsm-extra-variables' ); ?></a>
				</div>
			<?php } ?>
				<form id="qsm-license_entry" action="" method="post" style="display: none;">
					<input type="text" name="license_key" placeholder="<?php esc_html_e( 'Enter License key', 'qsm-extra-variables' ); ?>"/>
					<button id="qsm-validate_btn" class="button button-primary"><?php esc_html_e( 'Validate', 'qsm-extra-variables' ); ?></button>
					<a data-toggle='1' class="qsm-toggleButton" href=""><?php esc_html_e( 'Cancel', 'qsm-extra-variables' ); ?></a>
					<p class="qsm-validate-msg"></p>
				</form>
			</div>
		</div>
	<?php
	} else {
		$params      = array(
			'please_wait' => __('Please Wait! We are validating your license', 'qsm-extra-variables'),
			'license_msg' => __('License Key Required.', 'qsm-extra-variables'),
			'invalid'     => __('<span class="dashicons dashicons-warning"></span><b>Incorrect License!</b> Please enter a valid license key.', 'qsm-extra-variables'),
		);
		wp_localize_script( 'extra-variables-admin_js', 'qsm_extra_variables_obj', $params );?>
		<div class="qsm-license-form-parent">
			<div class="qsm-license-header">
				<p class="qsm-heading">
					<?php esc_html_e( 'Manage License', 'qsm-extra-variables' ); ?>
				</p>
			</div>
			<div class="qsm_extra_variables_validate_parent">
				<form class="rq_validata-license" method="POST">
					<input type="text" placeholder="<?php echo esc_html("Enter your license key"); ?>" class="qsm_extra_variables_validate_input" name="qsm_extra_variables_validate_input" />
					<input type="submit" name="qsm_extra_variables_validate_button" class="qsm_extra_variables_validate_button button button-primary" value="Validate" />
				</form>
			</div>
			<div id="qsm-license_message" style="display: none; padding: 0 0 0 22px;"><strong class="qsm_extra_variables_validate_message"></strong></div>
		</div>
	<?php
	}
}
