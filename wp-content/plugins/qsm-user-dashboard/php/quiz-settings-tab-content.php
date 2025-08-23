<?php
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Registers your tab in the quiz settings page
 *
 * @since 1.0.0
 * @return void
 */
function qsm_addon_user_dashboard_register_quiz_settings_tabs() {
  global $mlwQuizMasterNext;
  if ( ! is_null( $mlwQuizMasterNext ) && ! is_null( $mlwQuizMasterNext->pluginHelper ) && method_exists( $mlwQuizMasterNext->pluginHelper, 'register_quiz_settings_tabs' ) ) {
    $mlwQuizMasterNext->pluginHelper->register_quiz_settings_tabs('User Dashboard', 'qsm_addon_user_dashboard_quiz_settings_tabs_content' );
  }
}

/**
 * Generates the content for your quiz settings tab
 *
 * @since 1.0.0
 * @return void
 */
function qsm_addon_user_dashboard_quiz_settings_tabs_content() { 
	wp_enqueue_script( 'qsm_user-dashboard_js', QSM_USER_DASHBOARD_URL . '/qsm-user-dashboard.js', array( 'jquery' ), QSM_USER_DASHBOARD_VERSION, true );
	wp_enqueue_style( 'qsm_user-dashboard_css', QSM_USER_DASHBOARD_URL . '/qsm-user-dashboard-style.css', array(), QSM_USER_DASHBOARD_VERSION );
	$date_now = date("d-m-Y");
	global $mlwQuizMasterNext; 
	$settings    = get_option('mlw_qmn_dashboard_option', array());
	$license         = isset( $settings['license_key'] ) ? trim( $settings['license_key'] ) : '';
	$license_status  = isset( $settings['license_status'] ) ? $settings['license_status'] : '';
	if ( '' !== $license && 'valid' === $license_status ) {
		if ( version_compare( $mlwQuizMasterNext->version, '8.1.6', '>' ) && (isset($settings['expiry_date']) && "" !== $settings['expiry_date']) && (isset($settings['last_validate']) && "" !== $settings['last_validate']) && strtotime($date_now) > strtotime($settings['expiry_date']) && strtotime($date_now) >= strtotime($settings['last_validate']) ) { 
			$item_url = 'https://quizandsurveymaster.com/checkout/?edd_license_key='.$license.'&download_id='.USER_DASHBOARD_ITEM;
			$target_text = __('License Key Expired. ', 'qsm-user-dashboard');
			$target_link = sprintf( $target_text.'<a style="font-weight: 500;" href="%s" target="_blank">%s</a>', esc_url( $item_url ), __( 'Click here to renew', 'qsm-user-dashboard' ) );
			$mlwQuizMasterNext->alertManager->newAlert( $target_link, 'error' );
		}
		global $wpdb;
		$quiz_id = isset( $_GET['quiz_id'] ) ? sanitize_text_field( wp_unslash( $_GET['quiz_id'] ) ) : '';
		$quiz_inline_results_count = 0;
		$correct_results_count_text = __('Correct Answers', 'qsm-user-dashboard');
		$incorrect_results_count_text = __('Incorrect Answers', 'qsm-user-dashboard');
		$skipped_results_count_text = __('Skipped Answers', 'qsm-user-dashboard');
		if ( isset($_POST["user_dashboard_inline_nonce"]) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['user_dashboard_inline_nonce'] ) ), 'user_dashboard_inline') ) {
			$quiz_inline_results_count = isset($_POST['quiz_inline_results_count']) ? sanitize_text_field( wp_unslash( $_POST['quiz_inline_results_count'] ) ) : 0;
			if ( ! isset($_POST['inline_results_reset']) ) {
				$correct_results_count_text = isset( $_POST['correct_results_count_text'] ) ? sanitize_text_field( wp_unslash( $_POST['correct_results_count_text'] ) ) : 0;
				$incorrect_results_count_text = isset( $_POST['incorrect_results_count_text'] ) ? sanitize_text_field( wp_unslash( $_POST['incorrect_results_count_text'] ) ) : 0;
				$skipped_results_count_text = isset( $_POST['skipped_results_count_text'] ) ? sanitize_text_field( wp_unslash( $_POST['skipped_results_count_text'] ) ) : 0;
			}
			$single_quiz_data = $wpdb->get_row( "SELECT quiz_settings FROM " . $wpdb->prefix . "mlw_quizzes WHERE quiz_id = $quiz_id" );
			$quiz_settings = unserialize($single_quiz_data->quiz_settings);
			$new_setting = array(
				'quiz_inline_results_count'    => $quiz_inline_results_count,
				'correct_results_count_text'   => $correct_results_count_text,
				'incorrect_results_count_text' => $incorrect_results_count_text,
				'skipped_results_count_text'   => $skipped_results_count_text,
			);
			$quiz_settings['quiz_inline_results'] = $new_setting;
			$wpdb->update(
				$wpdb->prefix . 'mlw_quizzes',
				array(
					'quiz_settings' => maybe_serialize( $quiz_settings ),
				),
				array(
					'quiz_id' => $quiz_id,
				)
			);
			$mlwQuizMasterNext->alertManager->newAlert( __( 'Settings has been saved successfully!', 'qsm-user-dashboard' ), 'success' );
		}
		$single_quiz_data = $wpdb->get_row( "SELECT quiz_settings FROM " . $wpdb->prefix . "mlw_quizzes WHERE quiz_id = $quiz_id" );
		$quiz_settings = unserialize($single_quiz_data->quiz_settings);
		if ( isset($quiz_settings['quiz_inline_results']) ) {
			$quiz_inline_results_count = $quiz_settings['quiz_inline_results']['quiz_inline_results_count'];
			$correct_results_count_text = $quiz_settings['quiz_inline_results']['correct_results_count_text'];
			$incorrect_results_count_text = $quiz_settings['quiz_inline_results']['incorrect_results_count_text'];
			$skipped_results_count_text = $quiz_settings['quiz_inline_results']['skipped_results_count_text'];
		} 
		?>
		<div class="qsm-alerts">
			<?php $mlwQuizMasterNext->alertManager->showAlerts(); ?>
		</div>
		<div class="setting-info">
			<p>
				<?php esc_html_e('You can customize your user\'s dashboard from the settings.', 'qsm-user-dashboard'); ?>
				<a target="_blank" href="<?php echo esc_url( '?page=qmn_addons&tab=user-dashboard-settings' )?>"><b><?php esc_html_e(' Click here ', 'qsm-user-dashboard'); ?></b></a>
				<?php esc_html_e('to edit the dashboard.', 'qsm-user-dashboard'); ?>
			</p>
		</div>
	<div class="mlw_tab_content">
		<h2><?php esc_html_e('User Dashboard addon setting', 'qsm-user-dashboard'); ?></h2>
		<form action="" method="post">
		<table class="form-table" style="width: 100%;">
			<tr valign="top">
				<th scope="row" ><label for="quiz_inline_results_count"><?php esc_html_e( 'Live Results', 'qsm-user-dashboard' ); ?></label></th>
				<td><input type="checkbox" id="quiz_inline_results_count" name="quiz_inline_results_count" value="1" <?php checked( $quiz_inline_results_count, '1' ); ?> /><label for="quiz_inline_results_count"><strong><?php esc_html_e( 'Show Live result on top of quiz', 'qsm-user-dashboard' ); ?></strong></label></td>
			</tr>
			<tr valign="top" class="inline-result-overlay">
				<th scope="row" ><label for="correct_results_count_text"><?php esc_html_e( 'Correct Answer Text', 'qsm-user-dashboard' ); ?></label></th>
				<td><input type="text" id="correct_results_count_text" class="regular-text" placeholder="<?php echo esc_attr('e.g., \'Correct Answer\'', 'qsm-user-dashboard'); ?>" name="correct_results_count_text" value='<?php echo esc_attr($correct_results_count_text); ?>' /></td>
			</tr>
			<tr valign="top" class="inline-result-overlay">
				<th scope="row" ><label for="incorrect_results_count_text"><?php esc_html_e( 'Incorrect Answer Text', 'qsm-user-dashboard' ); ?></label></th>
				<td><input type="text" id="incorrect_results_count_text" class="regular-text" placeholder="<?php echo esc_attr('e.g., \'Incorrect Answer\'', 'qsm-user-dashboard'); ?>" name="incorrect_results_count_text" value='<?php echo esc_attr($incorrect_results_count_text); ?>' /></td>
			</tr>
			<tr valign="top" class="inline-result-overlay">
				<th scope="row" ><label for="skipped_results_count_text"><?php esc_html_e( 'Skipped Answer Text', 'qsm-user-dashboard' ); ?></label></th>
				<td><input type="text" id="skipped_results_count_text" class="regular-text" placeholder="<?php echo esc_attr('e.g., \'Skipped Answer\'', 'qsm-user-dashboard'); ?>" name="skipped_results_count_text" value='<?php echo esc_attr($skipped_results_count_text); ?>' /></td>
			</tr>
			
		</table>
		<?php wp_nonce_field('user_dashboard_inline','user_dashboard_inline_nonce'); ?>
		<button class="button-primary inline_results_submit"><?php esc_html_e( 'Save Changes', 'qsm-user-dashboard' );  ?></button>
		<input type="submit" name="inline_results_reset" class="button-secondary inline_results_reset" value="<?php echo esc_attr("Reset to Defaults"); ?>">
		</form>
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
