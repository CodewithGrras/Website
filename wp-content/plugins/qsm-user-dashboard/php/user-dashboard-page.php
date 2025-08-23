<?php
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Creates the table & results for the User Dashboard on the WP dashboard page "My Results"
 *
 * @since 1.1.0
 */
function qsm_user_dashboard_admin() {
	global $mlwQuizMasterNext;
	wp_enqueue_script( 'qsm_user-dashboard_js', QSM_USER_DASHBOARD_URL . '/qsm-user-dashboard.js', array( 'jquery' ), QSM_USER_DASHBOARD_VERSION, true );
	$date_now = date("d-m-Y");
	$settings    = get_option('mlw_qmn_dashboard_option', array());
	$license         = isset( $settings['license_key'] ) ? trim( $settings['license_key'] ) : '';
	$license_status  = isset( $settings['license_status'] ) ? $settings['license_status'] : '';
	
	if ( '' !== $license && 'valid' === $license_status ) {
	?>
	<div class="wrap">
		<h2>My Results</h2> <?php 
		if ( version_compare( $mlwQuizMasterNext->version, '8.1.6', '>' ) && (isset($settings['expiry_date']) && "" !== $settings['expiry_date']) && (isset($settings['last_validate']) && "" !== $settings['last_validate']) && strtotime($date_now) > strtotime($settings['expiry_date']) && strtotime($date_now) >= strtotime($settings['last_validate']) ) { 
			$item_url = 'https://quizandsurveymaster.com/checkout/?edd_license_key='.$license.'&download_id='.USER_DASHBOARD_ITEM;
			$target_text = __('License Key Expired. ', 'qsm-user-dashboard');
			$target_link = sprintf( $target_text.'<a style="font-weight: 500;" href="%s" target="_blank">%s</a>', esc_url( $item_url ), __( 'Click here to renew', 'qsm-user-dashboard' ) );
			$mlwQuizMasterNext->alertManager->newAlert( $target_link, 'error' );
		}
		$mlwQuizMasterNext->alertManager->showAlerts();
		?>
		<?php echo do_shortcode( '[user_dashboard]' ); ?>
	</div>
	<?php
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
?>
