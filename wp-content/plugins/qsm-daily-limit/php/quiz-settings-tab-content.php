<?php
if ( ! defined('ABSPATH'))
    exit;

/**
 * Registers your tab in the quiz settings page
 *
 * @since 1.1.0
 * @return void
 */
function qsm_addon_daily_limit_register_quiz_settings_tabs() {
    global $mlwQuizMasterNext;
    if ( ! is_null($mlwQuizMasterNext) && ! is_null($mlwQuizMasterNext->pluginHelper) && method_exists($mlwQuizMasterNext->pluginHelper, 'register_quiz_settings_tabs') ) {
        $mlwQuizMasterNext->pluginHelper->register_quiz_settings_tabs("Daily Limit", 'qsm_addon_daily_limit_quiz_settings_tabs_content');
    }
}

/**
 * Generates the content for your quiz settings tab
 *
 * @since 1.1.0
 * @return void
 */
function qsm_addon_daily_limit_quiz_settings_tabs_content() {
    global $mlwQuizMasterNext;
    wp_enqueue_script( 'qsm-daily-limit-admin_js', QSM_DAILY_LIMIT_ADDON_URL . 'js/admin.js', array(), QSM_DAILY_LIMIT_VERSION, true );
	wp_enqueue_style( 'qsm-daily-limit-admin-css', QSM_DAILY_LIMIT_ADDON_URL . 'css/qsm-daily-limit-admin.css', array(), QSM_DAILY_LIMIT_VERSION );
	
    $date_now = gmdate("d-m-Y");
	$settings = wp_parse_args( 
		get_option( 'qsm_addon_daily_limit_settings', array() ), 
		array( 'license_key' => '' ) 
	);
	$license     = isset( $settings['license_key'] ) ? trim( $settings['license_key'] ) : '';
	$license_status = isset( $settings['license_status'] ) ? trim( $settings['license_status'] ) : '';

	if ( '' !== $license && 'valid' === $license_status ) {
        if ( version_compare( $mlwQuizMasterNext->version, '8.1.6', '>' ) && (isset($settings['expiry_date']) && "" !== $settings['expiry_date']) && (isset($settings['last_validate']) && "" !== $settings['last_validate']) && strtotime($date_now) > strtotime($settings['expiry_date']) && strtotime($date_now) >= strtotime($settings['last_validate']) ) {
			$item_url = 'https://quizandsurveymaster.com/checkout/?edd_license_key='.$license.'&download_id='.QSM_DAILY_LIMIT_ITEM;
			$target_text = __('License Key Expired. ', 'qsm-daily-limit');
			$target_link = sprintf( $target_text.'<a style="font-weight: 500;" href="%s" target="_blank">%s</a>', esc_url( $item_url ), __( 'Click here to renew', 'qsm-daily-limit' ) );
			$mlwQuizMasterNext->alertManager->newAlert( $target_link, 'error' );
		}
		
        //If nonce is set and correct, save the form
        if ( isset($_POST["daily_limit_nonce"]) && wp_verify_nonce($_POST['daily_limit_nonce'], 'daily_limit') ) {
            $daily_limit_data = array(
                'enabled'          => isset( $_POST["daily_limit_enable"] ) ? 'yes' : 'no',
                'amount'           => isset( $_POST["amount"] ) ? intval( sanitize_text_field( $_POST["amount"] ) ) : 0,
                'text'             => isset( $_POST["text"] ) ? htmlspecialchars(stripslashes($_POST["text"]), ENT_QUOTES) : '',
                'email_type'       => isset( $_POST["daily_limit_email_type"] ) ? sanitize_text_field( $_POST["daily_limit_email_type"] ) : '',
                'recurring_period' => isset( $_POST["recurring_period"] ) ? intval( sanitize_text_field( $_POST["recurring_period"] ) ) : '',
                'recurring_limit'  => isset( $_POST["recurring_limit"] ) ? intval( sanitize_text_field( $_POST["recurring_limit"] ) ) : '',
                'daily_limit_type' => isset( $_POST["daily_limit_type"] ) ? sanitize_text_field( $_POST["daily_limit_type"] ) : '',
            );
            $mlwQuizMasterNext->pluginHelper->update_quiz_setting("daily_limit_settings", $daily_limit_data);
            $mlwQuizMasterNext->alertManager->newAlert( sprintf(__('Your %s settings has been saved successfully!','qsm-daily-limit'),'Daily Limit'), 'success');
        }
        // Shows any alerts from saving.
		$mlwQuizMasterNext->alertManager->showAlerts();
        
        // Load the settings
        $daily_limit_data = $mlwQuizMasterNext->pluginHelper->get_quiz_setting("daily_limit_settings");
        $daily_limit_defaults = array(
            'enabled'          => 'no',
            'amount'           => 0,
            'text'             => '',
            'email_type'       => '',
            'daily_limit_type' => 1,
            'recurring_period' => 2,
            'recurring_limit'  => 0,
        );
        $daily_limit_data = wp_parse_args($daily_limit_data, $daily_limit_defaults);
        ?>
        <h1><?php esc_html_e('Manage Limit on Responses','qsm-daily-limit'); ?></h1>
        <?php
        $options = $qmn_quiz_options = $mlwQuizMasterNext->quiz_settings->get_quiz_options();
        $contact_form = QSM_Contact_Manager::load_fields();    
        if ( $options->user_email == 2 && empty($contact_form) ) {
            ?>      
            <div class="updated below-h2" style="padding: 10px 10px;"><?php _e('To enable daily limit for non logged in user you have to enable the','qsm-daily-limit'); ?>
                <b><?php _e('"Should we ask for users email?"','qsm-daily-limit'); ?></b> <?php _e('option','qsm-daily-limit'); ?> <a href="<?php echo admin_url('admin.php') . '?page=mlw_quiz_options&quiz_id=' . $_GET['quiz_id'] . '&tab=options'; ?>"><?php _e('here','qsm-daily-limit'); ?></a>.
            </div>
            <?php
        }
        
        
        if ( ! empty($contact_form) && array_search('email', array_column($contact_form, 'type')) !== False ) {
            //Do nothing
        } else {
            ?>
            <div class="notice notice-error below-h2 " style="padding: 10px 10px;"><?php _e('To enable daily limit for non logged in user please create an Email field in Contact tab','qsm-daily-limit'); ?>
                <a href="<?php echo admin_url('admin.php') . '?page=mlw_quiz_options&quiz_id=' . $_GET['quiz_id'] . '&tab=contact'; ?>"><?php _e('here','qsm-daily-limit'); ?></a>.
            </div>
            <?php
        }    
        ?>  
        <form action="" method="post" class="qsm-daily-limit-settings">
            <table class="form-table" style="width: 100%;">
                <tr valign="top">
                    <th scope="row"><label for="daily_limit_enable"><?php esc_html_e('Set limit on responses','qsm-daily-limit'); ?></label></th>
                    <td>
                        <input type="checkbox" id="daily_limit_enable_radio" name="daily_limit_enable" <?php checked($daily_limit_data["enabled"], 'yes'); ?> value='yes' /><label for="daily_limit_enable_radio1"><?php esc_html_e('Enable a limit of responses for this form type','qsm-daily-limit'); ?></label><br>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row"></th>
                    <td>
                        <div class="qsm-daily-limit-types-container">
                            <div class="limit-type">
                                <p class="sub-heading"><?php esc_html_e( 'Accept responses based on:', 'qsm-daily-limit' ); ?></p>
                                <select id="daily_limit_type" name="daily_limit_type">
                                    <option value="1" <?php selected( $daily_limit_data['daily_limit_type'], 1 ) ?>>
                                        <?php esc_html_e( 'Daily Submission', 'qsm-daily-limit' ); ?>
                                    </option>
                                    <option value="2" <?php selected( $daily_limit_data['daily_limit_type'], 2 ) ?>>
                                        <?php esc_html_e( 'Recurring Submission', 'qsm-daily-limit' ); ?>
                                    </option>
                                </select>
                            </div>
                            <div class="recurring-section" style="display: none;">
                                <p class="sub-heading"><?php esc_html_e('Set recurring limit','qsm-daily-limit'); ?></p>
                                <label for="recurring_limit">
                                    <?php esc_html_e('Accept only ','qsm-daily-limit'); ?>
                                    <input type="number" min="0" id="recurring_limit" name="recurring_limit" value="<?php echo $daily_limit_data["recurring_limit"]; ?>">
                                    <?php esc_html_e(' responses every ','qsm-daily-limit'); ?>
                                    <input type="number" min="2" id="recurring_period" name="recurring_period" value="<?php echo $daily_limit_data["recurring_period"]; ?>">
                                    <?php esc_html_e(' days.','qsm-daily-limit'); ?>
                                </label>
                            </div>
                            <div class="daily-section">
                                <p class="sub-heading"><?php esc_html_e('Set daily limit','qsm-daily-limit'); ?></p>
                                <label for="amount">
                                    <?php esc_html_e('Accept only ','qsm-daily-limit'); ?>
                                    <input type="number" min="0" id="amount" name="amount" value="<?php echo $daily_limit_data["amount"]; ?>">
                                    <?php esc_html_e(' responses per day.','qsm-daily-limit'); ?>
                                </label>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row">
                        <label for="text"><?php esc_html_e( 'Custom message for limit', 'qsm-daily-limit' ); ?></label>
                        <p class="section-hint"><?php esc_html_e( 'Set a text message when a user exhausts the limit.', 'qsm-daily-limit' ); ?></p>
                    </th>
                    <td>
                        <?php wp_editor(htmlspecialchars_decode($daily_limit_data["text"], ENT_QUOTES), 'text'); ?>
                    </td>
                </tr>
                <?php if ( $contact_form ) { ?>
                    <tr valign="top">
                        <th scope="row">
                            <label><?php esc_html_e('Select Method','qsm-daily-limit'); ?></label>
                            <p class="section-hint"><?php esc_html_e('Select a unique method to limit submissions for non-logged in users','qsm-daily-limit'); ?></p>
                        </th>
                        <td>
                            <select name="daily_limit_email_type">
                                <option value=""><?php esc_html_e('Select email field','qsm-daily-limit'); ?></option>
                                <?php
                                foreach ( $contact_form as $key => $single_data ) {
                                    if ( $single_data['type'] == 'email' ) {
                                        ?>
                                            <option value="<?php echo 'contact_field_'. $key; ?>" <?php selected($daily_limit_data['email_type'], 'contact_field_'. $key) ?>><?php echo $single_data['label']; ?></option>
                                        <?php
                                    }
                                }
                                ?>
                            </select>
                        </td>
                    </tr>
                    <?php
                }
                ?>
            </table>
            <?php wp_nonce_field('daily_limit', 'daily_limit_nonce'); ?>
            <div class="option-page-option-tab-footer">
				<div class="footer-bar-notice"></div>
				<div class="result-tab-footer-buttons">
					<a target="_blank" class="button-secondary" href="<?php echo esc_attr(qsm_get_plugin_link( 'docs/add-ons/daily-limit/' )); ?>">
                        <img src="<?php echo esc_attr( QSM_DAILY_LIMIT_ADDON_URL . '/img/doc.png' ); ?>">
                        <?php esc_html_e( 'Read Documentation', 'qsm-daily-limit' ); ?>
                    </a>
					<button class="button-primary"><?php esc_html_e( 'Save Setting', 'qsm-daily-limit' ); ?></button>
				</div>
			</div>
        </form>
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
?>
