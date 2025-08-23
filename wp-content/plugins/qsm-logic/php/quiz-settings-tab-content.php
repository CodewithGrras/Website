<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Registers your tab in the quiz settings page
 *
 * @since 0.1.0
 * @return void
 */
function qsm_addon_logic_register_quiz_settings_tabs() {
	global $mlwQuizMasterNext;
	if ( ! is_null( $mlwQuizMasterNext ) && ! is_null( $mlwQuizMasterNext->pluginHelper ) && method_exists( $mlwQuizMasterNext->pluginHelper, 'register_quiz_settings_tabs' ) ) {
		$mlwQuizMasterNext->pluginHelper->register_quiz_settings_tabs( 'Logic', 'qsm_addon_logic_quiz_settings_tabs_content' );
	}
}

/**
 * Generates the content for your quiz settings tab
 *
 * @since 0.1.0
 * @return void
 */
function qsm_addon_logic_quiz_settings_tabs_content() {
	wp_enqueue_style( 'qsm_logic_admin_style', QSM_LOGIC_ADDON_URL . '/css/qsm-logic-admin.css', array(), QSM_LOGIC_VERSION );
	wp_enqueue_script( 'qsm_logic_admin', QSM_LOGIC_ADDON_URL . '/js/admin.js', array(), QSM_LOGIC_VERSION, true );
	?>
	<div class="logic-rule-message"></div>
	<div class="upgrade-logic-rules" style="display:none">
		<h2><?php esc_html_e( 'Upgrade Message', 'qsm-logic' ); ?></h2>
		<?php esc_html_e( 'From version 2.0.0 we are upgrading to better database structure.', 'qsm-logic' ); ?><br />
		<?php esc_html_e( 'All your logic rules will be migrated to new tables', 'qsm-logic' ); ?><br />
		<?php esc_html_e( 'Hence we recommend to take a ', 'qsm-logic' ); ?>
		<strong><?php esc_html_e( 'database backup', 'qsm-logic' ); ?></strong><br /><br />
		<a class="save-rules button-primary"><?php esc_html_e( 'Upgrade', 'qsm-logic' ); ?></a>
	</div>
	<?php
	global $mlwQuizMasterNext;
	$auto_pagination = $mlwQuizMasterNext->pluginHelper->get_section_setting( 'quiz_options', 'pagination' );
	$settings        = get_option( 'qsm_addon_logic_settings', '' );
	$license         = isset( $settings['license_key'] ) ? trim( $settings['license_key'] ) : '';
	$license_status  = isset( $settings['license_status'] ) ? $settings['license_status'] : '';
	if ( '' == $license && 'valid' != $license_status ) :
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
	else :
		if ( $auto_pagination ) :
	?>
		<div class="qsm-popup-upgrade-warning" style="background:#d9edf7;border-color:#31708f;color:#31708f">
			<span class="dashicons dashicons-info" style=" font-size: 35px; line-height: 20px; margin-right: 20px; "></span>
			<span><?php echo esc_html__("When using Auto-paging, please note that Logic Rules will not work as expected. This means that any logic you set using the Logic addon will not work if you have set a  number of questions to be displayed per page in the options tab. Please refer to the", "qsm-logic") . " <a href='https://quizandsurveymaster.com/docs/add-ons/logic/' target='_blank' style='text-decoration: underline;'>". esc_html__("documentation", "qsm-logic") . "</a>."; ?></span>
		</div>
	<?php endif; ?>
		<div class="no-logic-container" style="display:none"><span class="dashicons dashicons-lightbulb"></span><br />
			<h2>
				<?php esc_html_e( ' You don\'t have logic rules', 'qsm-logic' ); ?><br />
			</h2>
			<a class="add-rule button button-primary button-hero">
				<span class="dashicons dashicons-plus"></span>
				<?php _e( 'Create New Rule', 'qsm-logic' ); ?>
			</a>
		</div>
		<div class="logic-container" style="display:none">
			<a class="add-rule button-primary"><?php esc_html_e( 'Add Rule', 'qsm-logic' ); ?></a>
			<a class="delete-all-rules button"><?php esc_html_e( 'Delete Rules', 'qsm-logic' ); ?></a>
			<input type="text" class="search-logic" placeholder="<?php esc_html_e( 'Search Logic Rules', 'qsm-logic' ); ?>" />
			<table class="widefat logic-table">
				<thead>
					<tr>
						<th><input type="checkbox" name="check_all" id="check_all" value="all"></th>
						<th><strong><?php esc_html_e( 'When', 'qsm-logic' ); ?></strong></th>
						<th><strong><?php esc_html_e( 'Then', 'qsm-logic' ); ?></strong></th>
					</tr>
				</thead>
				<tbody class="logic-rules"></tbody>
			</table>
			<a class="add-rule button-primary"><?php esc_html_e( 'Add Rule', 'qsm-logic' ); ?></a>
			<a class="delete-all-rules button"><?php esc_html_e( 'Delete Rules', 'qsm-logic' ); ?></a>
		</div>
		<div class="qsm-popup qsm-popup-slide" id="modal-wizard-logic" aria-hidden="false" style="display:none;">
			<div class="qsm-popup__overlay" tabindex="-1" data-micromodal-close>
				<div class="qsm-popup__container" role="dialog" aria-modal="true" aria-labelledby="modal-wizard-logic-title">
					<header class="qsm-popup__header">
						<img src="<?php echo esc_url(QSM_PLUGIN_URL . '/assets/icon-128x128.png'); ?>" />
						<h2 class="qsm-popup__title" id="modal-wizard-logic-title">
							<?php esc_html_e( 'Logic Rules', 'qsm-logic' ); ?>
						</h2>
						<a class="qsm-popup__close" aria-label="Close modal" data-micromodal-close></a>
					</header>
					<main class="qsm-popup__content" id="modal-wizard-logic-content">
					</main>
					<footer class="qsm-popup__footer">
						<button class="qsm-popup__btn" data-micromodal-close=""
							aria-label="Close this dialog window"><?php esc_html_e( 'Cancel', 'qsm-logic' ); ?></button>
						<button id="save-logic-button"
							class="save-new-rule qsm-popup__btn qsm-popup__btn-primary"><?php esc_html_e( 'Save', 'qsm-logic' ); ?></button>
					</footer>
				</div>
			</div>
		</div>
	<?php
	endif;
}
?>