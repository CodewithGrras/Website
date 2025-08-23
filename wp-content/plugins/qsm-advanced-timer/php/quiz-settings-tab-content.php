<?php
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Registers your tab in the quiz settings page
 *
 * @since 1.0.0
 * @return void
 */
function qsm_addon_advanced_timer_register_quiz_settings_tabs() {
    global $mlwQuizMasterNext;
    if ( ! is_null( $mlwQuizMasterNext ) && ! is_null( $mlwQuizMasterNext->pluginHelper ) && method_exists( $mlwQuizMasterNext->pluginHelper, 'register_quiz_settings_tabs' ) ) {
        $mlwQuizMasterNext->pluginHelper->register_quiz_settings_tabs('Advanced Timer', 'qsm_addon_advanced_timer_quiz_settings_tabs_content' );
    }
}

/**
 * Generates the content for your quiz settings tab
 *
 * @since 1.0.0
 * @return void
 */
function qsm_addon_advanced_timer_quiz_settings_tabs_content() {

    global $mlwQuizMasterNext;
    $date_now = gmdate("d-m-Y");
    $settings_data     = get_option('qsm_addon_advanced_timer_settings', '');
    $license       = isset( $settings_data['license_key'] ) ? trim( $settings_data['license_key'] ) : '';
    $license_status    = isset( $settings_data['license_status'] ) ? $settings_data['license_status'] : '';
    //Enqueue admin script
    wp_enqueue_script('wp-color-picker');
    wp_enqueue_style('wp-color-picker');
    $custom_styles = "
        .et-preview-main-wrapper {
            display: inline-block;
            vertical-align: top;
            margin-left: 0px;
            margin-top: 20px;
        }
        .et-preview-main-wrapper .show_preview_timer img,
        .orher_timer_options img {
            padding: 10px;
            text-align: center;
            position: relative;
            max-width: 80px;
        }
        .et-preview-main-wrapper .show_preview_timer img {
            padding: 10px;
        }
        .at-preview-text {
            margin: 0;
            font-size: 14px;
            color: #bcbbc9fa;
            margin-bottom: 5px;
        }
        .qsm-upgrade-read-icon-timer{
            display: flex !important;
            flex-direction: row;
            margin: -35px 0px 10px !important;
            flex-wrap: nowrap;
            align-items: center;
            float: right;
        }
        .qsm-upgrade-read-icon-timer a{
            text-decoration: none;
            display: inherit !important;
            flex-direction: row;
            flex-wrap: nowrap;
            align-content: center;
            align-items: center;
            margin: 2px 6px 0;
        }
        .qsm-upgrade-read-icon-timer a img {
            margin-right: 7px;
        }
    ";
    wp_add_inline_style('advance_timer_admin_style', $custom_styles);
    wp_enqueue_script( 'qsm_advanced_timer_admin', plugins_url( '../js/admin.js' , __FILE__ ), array( 'jquery' ), QSM_ADVANCED_TIMER_VERSION );
    if ( '' != $license && 'valid' == $license_status ) {
    if ( version_compare( $mlwQuizMasterNext->version, '8.1.6', '>' ) && (isset($settings_data['expiry_date']) && "" != $settings_data['expiry_date']) && (isset($settings_data['last_validate']) && "" != $settings_data['last_validate']) && strtotime($date_now) > strtotime($settings_data['expiry_date']) && strtotime($date_now) >= strtotime($settings_data['last_validate']) ) {
        $item_url = 'https://quizandsurveymaster.com/checkout/?edd_license_key='.$license.'&download_id='.QSM_ADVANCED_TIMER_ITEM;
        $target_text = __('License Key Expired. ', 'qsm-advanced-timer');
        $target_link = sprintf( $target_text.'<a style="font-weight: 500;" href="%s" target="_blank">%s</a>', esc_url( $item_url ), __( 'Click here to renew', 'qsm-advanced-timer' ) );
        $mlwQuizMasterNext->alertManager->newAlert( $target_link, 'error' );
    }
    //If nonce is set and correct, save the form
    if ( isset( $_POST["advanced_timer_integration_nonce"] ) && wp_verify_nonce( sanitize_text_field(wp_unslash( $_POST['advanced_timer_integration_nonce'] )), 'advanced_timer_integration') ) {

    if ( ! isset($_POST['reset']) ) {
        if ( isset($_POST['qsm_show_both_timers']) && "yes" == sanitize_text_field(wp_unslash( $_POST['qsm_show_both_timers'])) ) {
        $show_both_timers = "yes";
        }
        if ( isset($_POST['qsm_show_stop_timer']) && "yes" == sanitize_text_field(wp_unslash( $_POST['qsm_show_stop_timer'])) ) {
        $show_stop_timer = "yes";
        }
        if ( isset($_POST['qsm_show_warning']) && "yes" == sanitize_text_field(wp_unslash( $_POST['qsm_show_warning'])) ) {
        $show_warning = "yes";
        }
        if ( isset($_POST['qsm_refresh_timer_on_reload']) && 1 == sanitize_text_field(wp_unslash( $_POST['qsm_refresh_timer_on_reload'])) ) {
        $qsm_refresh_timer_on_reload = 1;
        }
        if ( isset($_POST['qsm_timer_count_upwards']) && 1 == sanitize_text_field(wp_unslash( $_POST['qsm_timer_count_upwards'])) ) {
        $qsm_timer_count_upwards = 1;
        }
        if ( isset($_POST['qsm_timer_continues_after_closing']) && "yes" == sanitize_text_field(wp_unslash( $_POST['qsm_timer_continues_after_closing'])) ) {
        $timer_continues_after_closing = "yes";
        }
        $at_data = array(
            'start_timer_page'              => isset( $_POST["qsm_start_timer_page"] ) ? sanitize_text_field( wp_unslash( $_POST["qsm_start_timer_page"] ) ) : '1',
            'show_stop_timer'               => isset($show_stop_timer) ? $show_stop_timer : "no",
            'timer_design'                  => isset( $_POST["qsm_timer_design"] ) ? sanitize_text_field( wp_unslash( $_POST["qsm_timer_design"] ) ) : 'oval_timer',
            'time_text_color'               => isset( $_POST["qsm_time_text_color"] ) ? sanitize_text_field( wp_unslash( $_POST["qsm_time_text_color"] ) ) : '#000000',
            'time_progress_color'           => isset( $_POST["qsm_time_progress_color"] ) ? sanitize_text_field( wp_unslash( $_POST["qsm_time_progress_color"] ) ) : '#1dd969',
            'time_background_color'         => isset( $_POST["qsm_time_background_color"] ) ? sanitize_text_field( wp_unslash( $_POST["qsm_time_background_color"] ) ) : '#ffffff',
            'show_warning'                  => isset($show_warning) ? $show_warning : "no",
            'custome_timer_warning'         => isset( $_POST["qsm_custome_timer_warning"] ) ? sanitize_text_field( wp_unslash( $_POST["qsm_custome_timer_warning"] ) ) : __('Your quiz time is about to finish. Few seconds left.', 'qsm-advanced-timer'),
            'show_both_timers'              => isset($show_both_timers) ? $show_both_timers : "no",
            'timer_continues_after_closing' => isset($timer_continues_after_closing) ? $timer_continues_after_closing : "no",
            'qsm_refresh_timer_on_reload'   => isset($qsm_refresh_timer_on_reload) ? $qsm_refresh_timer_on_reload : 0,
            'qsm_timer_count_upwards'       => isset($qsm_timer_count_upwards) ? $qsm_timer_count_upwards : 0,
            'qsm_continue_after_timer_ends' => isset( $_POST["qsm_continue_after_timer_ends"] ) ? 1 : 0,
        );
    }else {
        $at_data = array(
            'start_timer_page'              => '1',
            'custome_timer_warning'         => __('Your quiz time is about to finish. Few seconds left.', 'qsm-advanced-timer'),
            'show_stop_timer'               => 'no',
            'timer_design'                  => 'oval_timer',
            'time_text_color'               => '#000000',
            'time_progress_color'           => '#1dd969',
            'time_background_color'         => '#ffffff',
            'show_warning'                  => 'no',
            'timer_continues_after_closing' => 'no',
            'show_both_timers'              => 'no',
            'qsm_refresh_timer_on_reload'   => 0,
            'qsm_timer_count_upwards'       => 0,
        );
    }

    $mlwQuizMasterNext->pluginHelper->update_quiz_setting( "advanced_timer_integration_settings", $at_data );
    $mlwQuizMasterNext->alertManager->newAlert(__( 'Your settings has been saved successfully!', 'qsm-advanced-timer' ), 'success' );
    }

    // Load the settings
    $at_data = $mlwQuizMasterNext->pluginHelper->get_quiz_setting( "advanced_timer_integration_settings" );

    $default_both_timer = 'no';
    $default_timer_face = 'oval_timer';
    if(!isset($at_data['show_both_timers'])) {
        $qmn_quiz_options = $mlwQuizMasterNext->quiz_settings->get_quiz_options();
        if ( (! empty( $qmn_quiz_options->timer_limit ) && 0 < $qmn_quiz_options->timer_limit) && (! empty($qmn_quiz_options->advance_per_page_timer) && 0 < $qmn_quiz_options->advance_per_page_timer )) {
            $default_both_timer = 'yes';
        }
    }
    if(!isset($at_data['timer_design'])) {
        $default_timer_face = 'right_bottom_timer';
    }
    $at_defaults = array(
        'start_timer_page'              => '1',
        'custome_timer_warning'         => __('Your quiz time is about to finish. Few seconds left.', 'qsm-advanced-timer'),
        'show_stop_timer'               => 'no',
        'timer_design'                  => $default_timer_face,
        'time_text_color'               => '#000000',
        'time_progress_color'           => '#1dd969',
        'time_background_color'         => '#ffffff',
        'show_warning'                  => 'no',
        'timer_continues_after_closing' => 'no',
        'show_both_timers'              => $default_both_timer,
        'qsm_refresh_timer_on_reload'   => 0,
        'qsm_timer_count_upwards'       => 0,
        'qsm_continue_after_timer_ends' => 0,
    );
    $at_data = wp_parse_args( $at_data, $at_defaults );
    ?>
    <div class="qsm-alerts">
		<?php $mlwQuizMasterNext->alertManager->showAlerts(); ?>
	</div>
    <div id="tabs-mailchimp-integration" class="mlw_tab_content">
        <h2><?php esc_html_e('Advanced Timer Settings', 'qsm-advanced-timer'); ?></h2>
        <span class="qsm-upgrade-read-icon-timer">
        <a target="_blank" class="button qsm-doc-icon" href="<?php echo esc_url( qsm_get_plugin_link( 'docs/add-ons/advanced-timer', 'advanced_timer', 'advancedtimer_settings_page', 'read_documentation' ) )?>"><img src="<?php echo esc_attr(plugin_dir_url( __DIR__ ).'/img/documentation.png'); ?>"><span><?php echo esc_html_e( 'Documentation', 'qsm-analysis' ); ?></span></a>
        </span>
        <form action="" method="post">
            <table class="form-table advance-timer-settings" style="width: 100%;">
                <tr valign="top">
                    <th scope="row" class="qsm-opt-tr">
                        <label for="qsm-start-timer-page"><?php esc_html_e( 'Start timer from page', 'qsm-advanced-timer' ); ?>
                        <span class="dashicons dashicons-editor-help qsm-tooltips-icon">
                        <span class="qsm-tooltips"><?php esc_html_e( 'You can set the timer to operate from a specific page. This feature works only on quizzes with auto-paging.', 'qsm-advanced-timer' ); ?></span>
                        </span>
                        </label>
                    </th>
                    <td>
                        <input type="number" min="1" id="qsm-start-timer-page" name="qsm_start_timer_page" value='<?php echo esc_attr($at_data["start_timer_page"]); ?>' /><br />
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row" class="qsm-opt-tr">
                        <label><?php esc_html_e( 'Timer controls', 'qsm-advanced-timer' ); ?></label>
                    </th>
                    <td style="position: relative;" class="qsm-opt-tr">
                        <input name="qsm_show_stop_timer" id="qsm-show-stop-timer" type="checkbox" value="yes" <?php checked($at_data['show_stop_timer'], 'yes') ?> />
                        <label for="qsm-show-stop-timer" class="qsm-advance-input-span"><?php esc_html_e( 'Show button to stop timer', 'qsm-advanced-timer' ); ?></label><br />
                        <input name="qsm_show_warning"  id="qsm-show-warning" class="advance-show-warning" type="checkbox" value="yes" <?php checked($at_data['show_warning'], 'yes') ?> />
                        <label  for="qsm-show-warning"  class="qsm-advance-input-span"><?php esc_html_e( 'Show warning when quiz timer is 90% completed', 'qsm-advanced-timer' ); ?>
                        <span class="qsm-custom-tooltiop dashicons dashicons-editor-help qsm-tooltips-icon">
                        <span class="qsm-tooltips"><?php esc_html_e( 'A warning popup will appear only when the timer reaches 90% completion. This option will not show a popup in the per-page timer of manual-paging quiz.', 'qsm-advanced-timer' ); ?></span>
                        </span>
                        </label>
                        <div class="qsm-custome-timer-warning"><input type="text" id="qsm-custome-timer-warning" placeholder="<?php echo esc_html("Add your custom message in warning"); ?>" name="qsm_custome_timer_warning" value='<?php echo esc_attr($at_data["custome_timer_warning"]); ?>' /><br /></div>
                        <div class="qsm-refresh-timer-on-reload-section">
                            <input name="qsm_refresh_timer_on_reload" id="qsm-refresh-timer-on-reload" type="checkbox" value="1" <?php checked($at_data['qsm_refresh_timer_on_reload'], '1') ?> />
                            <label for="qsm-refresh-timer-on-reload" class="qsm-advance-input-span"><?php esc_html_e( 'Refresh timers on reload page', 'qsm-advanced-timer' ); ?></label>
                        </div>
                        <div class="qsm-timer-continue-after-close"><input name="qsm_timer_continues_after_closing" id="qsm-timer-continues-after-closing" type="checkbox" value="yes" <?php checked($at_data['timer_continues_after_closing'], 'yes') ?> /><label  for="qsm-timer-continues-after-closing" class="qsm_advance_input_span"><?php esc_html_e( 'Timer continues after closing browser window/tab', 'qsm-advanced-timer' ); ?>
                            <span class="qsm-custom-tooltiop dashicons dashicons-editor-help qsm-tooltips-icon">
                            <span class="qsm-tooltips"><?php esc_html_e( 'This option is not suitable for single page quizzes.', 'qsm-advanced-timer' ); ?></span>
                            </span>
                            </label>
                        </div>
                        <input name="qsm_show_both_timers" id="qsm-show-both-timers" type="checkbox" value="yes" <?php checked($at_data['show_both_timers'], 'yes') ?> /><label for="qsm-show-both-timers" class="qsm_advance_input_span"><?php esc_html_e( 'Show dual timer on the page (when per page timer is enabled)', 'qsm-advanced-timer' ); ?></label><br />
                        <input name="qsm_continue_after_timer_ends" id="qsm-continue-after-timer-ends" type="checkbox" value="1" <?php checked($at_data['qsm_continue_after_timer_ends'], '1') ?> /><label for="qsm-continue-after-timer-ends" class="qsm_advance_input_span"><?php esc_html_e( 'Allow users to continue quiz after timer ends', 'qsm-advanced-timer' ); ?></label><br />
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row" class="qsm-opt-tr">
                        <label><?php esc_html_e( 'Timer Behaviour', 'qsm-advanced-timer' ); ?></label>
                    </th>
                    <td style="position: relative;" class="qsm-opt-tr">
                    <div class="qsm-timer-count-upwards">
                            <select name="qsm_timer_count_upwards" id="qsm_timer_count_upwards">
                                <option value="0" <?php selected($at_data['qsm_timer_count_upwards'], '0') ?>><?php esc_html_e('Count Down Timer', 'qsm-advanced-timer'); ?></option>
                                <option value="1" <?php selected($at_data['qsm_timer_count_upwards'], '1') ?>><?php esc_html_e('Count Up Timer', 'qsm-advanced-timer'); ?></option>
                            </select>
                        </div>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row"><label for="timer_faces"><?php esc_html_e( 'Select Timer Face', 'qsm-advanced-timer' ); ?></label></th>
                    <td id="other_timer_design">
                        <div class="orher_timer_options">
                            <div data-class="oval_timer" class="other_timers oval_timer <?php echo esc_attr('oval_timer' == $at_data['timer_design'] ? "active" : ""); ?>"><img src="<?php echo esc_url(QSM_ADVANCED_TIMER_PLUGIN_URL . '/img/ovalTimer.png'); ?>"/></div>
                            <div data-class="linear_timer" class="other_timers linear_timer <?php echo esc_attr('linear_timer' == $at_data['timer_design'] ? "active" : ""); ?>"><img src="<?php echo esc_url(QSM_ADVANCED_TIMER_PLUGIN_URL . '/img/linearTimer.png'); ?>"/></div>
                            <div data-class="box_timer" class="other_timers box_timer <?php echo esc_attr('box_timer' == $at_data['timer_design'] ? "active" : ""); ?>"><img src="<?php echo esc_url(QSM_ADVANCED_TIMER_PLUGIN_URL . '/img/BoxTimer.png'); ?>"/></div>
                            <div data-class="v_line_timer" class="other_timers v_line_timer <?php echo esc_attr('v_line_timer' == $at_data['timer_design'] ? "active" : ""); ?>"><img src="<?php echo esc_url(QSM_ADVANCED_TIMER_PLUGIN_URL . '/img/v_lineTimer.png'); ?>"/></div>
                            <div data-class="half_timer" class="other_timers half_timer <?php echo esc_attr('half_timer' == $at_data['timer_design'] ? "active" : ""); ?>"><img src="<?php echo esc_url(QSM_ADVANCED_TIMER_PLUGIN_URL . '/img/halfTimer.png'); ?>"/></div>
                            <div data-class="shade_timer" class="other_timers shade_timer <?php echo esc_attr('shade_timer' == $at_data['timer_design'] ? "active" : ""); ?>"><img src="<?php echo esc_url(QSM_ADVANCED_TIMER_PLUGIN_URL . '/img/shadeTimer.png'); ?>"/></div>
                            <input type="radio" name="qsm_timer_design" class="linear_timer" value='linear_timer' <?php checked($at_data['timer_design'], 'linear_timer') ?> />
                            <input type="radio" name="qsm_timer_design" class="box_timer" value='box_timer' <?php checked($at_data['timer_design'], 'box_timer') ?> />
                            <input type="radio" name="qsm_timer_design" class="oval_timer" value='oval_timer' <?php checked($at_data['timer_design'], 'oval_timer') ?> />
                            <input type="radio" name="qsm_timer_design" class="v_line_timer" value='v_line_timer' <?php checked($at_data['timer_design'], 'v_line_timer') ?> />
                            <input type="radio" name="qsm_timer_design" class="half_timer" value='half_timer' <?php checked($at_data['timer_design'], 'half_timer') ?> />
                            <input type="radio" name="qsm_timer_design" class="shade_timer" value='shade_timer' <?php checked($at_data['timer_design'], 'shade_timer') ?> />
                        </div>
                        <input name="show_legacy_timers" id="show_legacy_timers" class="show_legacy_timers" type="checkbox" value="yes"  /><label for="show_legacy_timers" class="qsm_advance_input_span"><?php esc_html_e( 'Show legacy timer faces', 'qsm-advanced-timer' ); ?></label><br />
                        <div class="orher_timer_options legace_timer_options">
                            <div data-class="right_bottom_timer" class="other_timers right_bottom_timer <?php echo esc_attr('right_bottom_timer' == $at_data['timer_design'] ? "active" : ""); ?>"><img src="<?php echo esc_url(QSM_ADVANCED_TIMER_PLUGIN_URL . '/img/right_side_timer.png'); ?>"/></div>
                            <div data-class="big_timer" class="other_timers big_timer <?php echo esc_attr('big_timer' == $at_data['timer_design'] ? "active" : ""); ?>"><img src="<?php echo esc_url(QSM_ADVANCED_TIMER_PLUGIN_URL . '/img/big_timer.png'); ?>"/></div>
                            <input type="radio" name="qsm_timer_design" class="right_bottom_timer" value='right_bottom_timer' <?php checked($at_data['timer_design'], 'right_bottom_timer') ?> />
                            <input type="radio" name="qsm_timer_design" class="big_timer" value='big_timer' <?php checked($at_data['timer_design'], 'big_timer') ?>/>
                        </div>
                        <br/>
                        <h4><?php esc_html_e( 'Set Timer Colour', 'qsm-advanced-timer' ); ?></h4>
                        <span class="advance-color-span"><?php esc_html_e( 'Timer Text Color', 'qsm-advanced-timer' ); ?></span><input type="text" class="color-picker" value="<?php echo esc_attr($at_data['time_text_color']); ?>" data-default-color="#ffffff" name="qsm_time_text_color"><br/>
                        <span class="advance-color-span"><?php esc_html_e( 'Progress Bar Color', 'qsm-advanced-timer' ); ?></span><input type="text" class="color-picker" value="<?php echo esc_attr($at_data['time_progress_color']); ?>" data-default-color="#ffffff" name="qsm_time_progress_color"><br/>
                        <div class="advance-background-color"><span class="advance-color-span"><?php esc_html_e( 'Background Color', 'qsm-advanced-timer' ); ?></span><input type="text" class="color-picker" value="<?php echo esc_attr($at_data['time_background_color']); ?>" data-default-color="#ffffff" name="qsm_time_background_color"></div>
                    </td>
                </tr>
            </table>
            <?php wp_nonce_field('advanced_timer_integration','advanced_timer_integration_nonce'); ?>
            <div class="option-page-option-tab-footer advance-timer-settings-btn">
                <div class="result-tab-footer-buttons">
                    <input class="button-secondary" type="submit" name="reset" value="<?php echo esc_attr__( 'Reset to Defaults', 'qsm-advanced-timer' );  ?>" />
                    <button class="button-primary"><?php esc_html_e( 'Save Settings', 'qsm-advanced-timer' );  ?></button>
                </div>
            </div>
        </form>
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
?>
