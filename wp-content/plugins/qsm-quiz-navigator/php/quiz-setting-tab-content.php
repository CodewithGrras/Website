<?php
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Registers your tab in the quiz settings page
 *
 * @since 1.0.0
 * @return void
 */
function qsm_quiz_navigator_register_quiz_settings_tabs() {
    global $mlwQuizMasterNext;
    if ( ! is_null( $mlwQuizMasterNext ) && ! is_null( $mlwQuizMasterNext->pluginHelper ) && method_exists( $mlwQuizMasterNext->pluginHelper, 'register_quiz_settings_tabs' ) ) {
        $mlwQuizMasterNext->pluginHelper->register_quiz_settings_tabs( "Quiz Navigator", 'qsm_quiz_navigator_quiz_settings_tabs_content' );
    }
}

/**
 * Generates the content for your quiz settings tab
 *
 * @since 1.0.0
 * @return void
 */
function qsm_quiz_navigator_quiz_settings_tabs_content() {
    global $mlwQuizMasterNext;
    /**
	 * If nonce is correct, update api key from passed input
	 */
    $settings = get_option('qsm_quiz_navigator_settings', '');
	$license     = isset( $settings['license_key'] ) ? trim( $settings['license_key'] ) : '';
	if ( isset($_POST["quiz_navigator_nonce"]) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['quiz_navigator_nonce'] ) ), 'quiz_navigator') ) {

		/**
		 * Save settings
		 */
		$saved_license   = isset( $_POST['license_key'] ) ? sanitize_text_field( wp_unslash( $_POST['license_key'] ) ) : '';
		if ( class_exists ( 'QSM_Check_License' ) ) {
			$activation = $mlwQuizMasterNext->check_license->activate( $saved_license, 'Quiz Navigator' );
		}else {
			$activation = QSM_license::activate( $saved_license, 'Quiz Navigator' );
		}
		$new_settings    = array(
			'license_key' => $saved_license,
		);
		// Checks to see if the license key has changed.
		if ( ! empty($activation) && ( ( __( 'Attempting to activate a bundle\'s parent license', 'qsm-quiz-navigator' ) == $activation['message'] || __( 'License key revoked', 'qsm-quiz-navigator' ) == $activation['message'] || __( 'No activations left', 'qsm-quiz-navigator' ) == $activation['message'] || __( 'License has expired', 'qsm-quiz-navigator' ) == $activation['message'] ) || 'success' == $activation['status'] ) ) {
			$item_url = 'https://quizandsurveymaster.com/checkout/?edd_license_key='.$saved_license.'&download_id='.QSM_QUIZ_NAVIGATOR_ITEM;
			$new_settings['license_key'] = $saved_license;
			$new_settings['license_status'] = 'valid';
			$new_settings['last_validate'] = gmdate("d-m-Y", time());
			$new_settings['expiry_date'] = isset($activation['expiry_date']) ? $activation['expiry_date'] : "";
			if ( 'success' == $activation['status'] ) {
				$mlwQuizMasterNext->alertManager->newAlert( __( 'License validated Successfully', 'qsm-quiz-navigator' ), 'success' );
			}elseif ( __( 'License has expired', 'qsm-quiz-navigator' ) != $activation['message'] ) {
				$mlwQuizMasterNext->alertManager->newAlert( $activation['message'], 'error' );
			}
		} else {
			$new_settings['license_key'] = '';
			$new_settings['license_status'] = '';
			$new_settings['last_validate'] = 'invalid';
			$new_settings['expiry_date'] = '';
			if ( "" == $saved_license ) {
				$default_notice = 0;
				$mlwQuizMasterNext->alertManager->newAlert( __('License Key Required ', 'qsm-quiz-navigator'), 'error' );
			}else {
				$mlwQuizMasterNext->alertManager->newAlert( $activation['message'], 'error' );
			}
		}
		// If same license key was entered.
		if ( $license != $saved_license ) {
			$deactivation = QSM_license::deactivate( $license, 'Quiz Navigator' );
		}
		update_option('qsm_quiz_navigator_settings', $new_settings);
	}
    $settings_data = wp_parse_args( get_option( 'qsm_quiz_navigator_settings', array() ), array(
		'license_key' => '',
	));
	$license        = isset( $settings_data['license_key'] ) ? trim( $settings_data['license_key'] ) : '';
	$license_status = isset( $settings_data['license_status'] ) ? $settings_data['license_status'] : '';
    $date_now = gmdate("d-m-Y");
    if ( '' != $license && 'valid' == $license_status ) {
		if ( version_compare( $mlwQuizMasterNext->version, '8.1.6', '>' ) && (isset($settings_data['expiry_date']) && "" != $settings_data['expiry_date']) && (isset($settings_data['last_validate']) && "" != $settings_data['last_validate']) && strtotime($date_now) > strtotime($settings_data['expiry_date']) && strtotime($date_now) >= strtotime($settings_data['last_validate']) ) {
			$item_url = 'https://quizandsurveymaster.com/checkout/?edd_license_key='.$license.'&download_id='.QSM_QUIZ_NAVIGATOR_ITEM;
			$target_text = __('License Key Expired. ', 'qsm-advanced-timer');
			$target_link = sprintf( $target_text.'<a style="font-weight: 500;" href="%s" target="_blank">%s</a>', esc_url( $item_url ), __( 'Click here to renew', 'qsm-advanced-timer' ) );
			$mlwQuizMasterNext->alertManager->newAlert( $target_link, 'error' );
		}
		$mlwQuizMasterNext->alertManager->showAlerts();

        $quiz_id = isset( $_GET['quiz_id'] ) ? intval( $_GET['quiz_id'] ) : 0;
        if ( isset( $_POST["qsm_quiz_navigator_nonce"] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['qsm_quiz_navigator_nonce'] ) ), 'qsm_quiz_navigator' ) ) {
            $enable     = isset( $_POST["qsm_quiz_navigator_enable"] ) ? sanitize_text_field( wp_unslash( $_POST["qsm_quiz_navigator_enable"] ) ) : 0;
            $shortcode  = isset( $_POST["qsm_quiz_navigator_shortcode"] ) ? sanitize_text_field( wp_unslash( $_POST["qsm_quiz_navigator_shortcode"] ) ) : 0;
            if ( isset( $_POST['qsm-quiz-navigator-reset'] ) ) {
                unset($_POST);
            }
            $qsm_quiz_navigator_data = array(
                'qsm_quiz_navigator_enable'                => $enable,
                'qsm_quiz_navigator_shortcode'             => $shortcode,
                'qsm_quiz_navigator_skip'                  => isset( $_POST["qsm_quiz_navigator_skip"] ) ? sanitize_text_field( wp_unslash( $_POST["qsm_quiz_navigator_skip"] ) ) : 0,
                'qsm_quiz_navigator_layout'                => isset( $_POST["qsm_quiz_navigator_layout"] ) ? sanitize_text_field( wp_unslash( $_POST["qsm_quiz_navigator_layout"] ) ) : 'horizontal',
                'qsm_quiz_navigator_alignment'             => isset( $_POST["qsm_quiz_navigator_alignment"] ) ? sanitize_text_field( wp_unslash( $_POST["qsm_quiz_navigator_alignment"] ) ) : 'center',
                'qsm_quiz_navigator_width'                 => isset( $_POST["qsm_quiz_navigator_width"] ) ? sanitize_text_field( wp_unslash( $_POST["qsm_quiz_navigator_width"] ) ) : 40,
                'qsm_quiz_navigator_width_unit'            => isset( $_POST["qsm_quiz_navigator_width_unit"] ) ? sanitize_text_field( wp_unslash( $_POST["qsm_quiz_navigator_width_unit"] ) ) : 'px',
                'qsm_quiz_navigator_height'                => isset( $_POST["qsm_quiz_navigator_height"] ) ? sanitize_text_field( wp_unslash( $_POST["qsm_quiz_navigator_height"] ) ) : 40,
                'qsm_quiz_navigator_height_unit'           => isset( $_POST["qsm_quiz_navigator_height_unit"] ) ? sanitize_text_field( wp_unslash( $_POST["qsm_quiz_navigator_height_unit"] ) ) : 'px',
                'qsm_quiz_navigator_radius'                => isset( $_POST["qsm_quiz_navigator_radius"] ) ? sanitize_text_field( wp_unslash( $_POST["qsm_quiz_navigator_radius"] ) ) : 2,
                'qsm_quiz_navigator_radius_unit'           => isset( $_POST["qsm_quiz_navigator_radius_unit"] ) ? sanitize_text_field( wp_unslash( $_POST["qsm_quiz_navigator_radius_unit"] ) ) : 'px',
                'qsm_quiz_navigator_gap'                   => isset( $_POST["qsm_quiz_navigator_gap"] ) ? sanitize_text_field( wp_unslash( $_POST["qsm_quiz_navigator_gap"] ) ) : 10,
                'qsm_quiz_navigator_gap_unit'              => isset( $_POST["qsm_quiz_navigator_gap_unit"] ) ? sanitize_text_field( wp_unslash( $_POST["qsm_quiz_navigator_gap_unit"] ) ) : 'px',
                'qsm_quiz_navigator_background_color'      => isset( $_POST["qsm_quiz_navigator_background_color"] ) ? sanitize_text_field( wp_unslash( $_POST["qsm_quiz_navigator_background_color"] ) ) : '#eeeeee',
                'qsm_quiz_navigator_number_color'          => isset( $_POST["qsm_quiz_navigator_number_color"] ) ? sanitize_text_field( wp_unslash( $_POST["qsm_quiz_navigator_number_color"] ) ) : '#3498db',
                'qsm_quiz_navigator_border_color'          => isset( $_POST["qsm_quiz_navigator_border_color"] ) ? sanitize_text_field( wp_unslash( $_POST["qsm_quiz_navigator_border_color"] ) ) : '#3498db',
                'qsm_quiz_navigator_border_thickness'      => isset( $_POST["qsm_quiz_navigator_border_thickness"] ) ? sanitize_text_field( wp_unslash( $_POST["qsm_quiz_navigator_border_thickness"] ) ) : 1,
                'qsm_quiz_navigator_background_color_active' => isset( $_POST["qsm_quiz_navigator_background_color_active"] ) ? sanitize_text_field( wp_unslash( $_POST["qsm_quiz_navigator_background_color_active"] ) ) : '#3498db',
                'qsm_quiz_navigator_number_color_active'   => isset( $_POST["qsm_quiz_navigator_number_color_active"] ) ? sanitize_text_field( wp_unslash( $_POST["qsm_quiz_navigator_number_color_active"] ) ) : '#FFFFFF',
                'qsm_quiz_navigator_border_color_active'   => isset( $_POST["qsm_quiz_navigator_border_color_active"] ) ? sanitize_text_field( wp_unslash( $_POST["qsm_quiz_navigator_border_color_active"] ) ) : '#3498db',
                'qsm_quiz_navigator_background_color_hover' => isset( $_POST["qsm_quiz_navigator_background_color_hover"] ) ? sanitize_text_field( wp_unslash( $_POST["qsm_quiz_navigator_background_color_hover"] ) ) : '#3498db',
                'qsm_quiz_navigator_number_color_hover'    => isset( $_POST["qsm_quiz_navigator_number_color_hover"] ) ? sanitize_text_field( wp_unslash( $_POST["qsm_quiz_navigator_number_color_hover"] ) ) : '#FFFFFF',
                'qsm_quiz_navigator_border_color_hover'    => isset( $_POST["qsm_quiz_navigator_border_color_hover"] ) ? sanitize_text_field( wp_unslash( $_POST["qsm_quiz_navigator_border_color_hover"] ) ) : '#3498db',
                'qsm_quiz_navigator_background_color_completed' => isset( $_POST["qsm_quiz_navigator_background_color_completed"] ) ? sanitize_text_field( wp_unslash( $_POST["qsm_quiz_navigator_background_color_completed"] ) ) : '#81d742',
                'qsm_quiz_navigator_number_color_completed' => isset( $_POST["qsm_quiz_navigator_number_color_completed"] ) ? sanitize_text_field( wp_unslash( $_POST["qsm_quiz_navigator_number_color_completed"] ) ) : '#FFFFFF',
                'qsm_quiz_navigator_border_color_completed' => isset( $_POST["qsm_quiz_navigator_border_color_completed"] ) ? sanitize_text_field( wp_unslash( $_POST["qsm_quiz_navigator_border_color_completed"] ) ) : '#81d742',
                'qsm_quiz_navigator_background_color_skipped' => isset( $_POST["qsm_quiz_navigator_background_color_skipped"] ) ? sanitize_text_field( wp_unslash( $_POST["qsm_quiz_navigator_background_color_skipped"] ) ) : '#d8d8d8',
                'qsm_quiz_navigator_number_color_skipped'  => isset( $_POST["qsm_quiz_navigator_number_color_skipped"] ) ? sanitize_text_field( wp_unslash( $_POST["qsm_quiz_navigator_number_color_skipped"] ) ) : '#FFFFFF',
                'qsm_quiz_navigator_border_color_skipped'  => isset( $_POST["qsm_quiz_navigator_border_color_skipped"] ) ? sanitize_text_field( wp_unslash( $_POST["qsm_quiz_navigator_border_color_skipped"] ) ) : '#d8d8d8',
                'qsm_quiz_navigator_background_color_required' => isset( $_POST["qsm_quiz_navigator_background_color_required"] ) ? sanitize_text_field( wp_unslash( $_POST["qsm_quiz_navigator_background_color_required"] ) ) : '#f85758',
                'qsm_quiz_navigator_number_color_required' => isset( $_POST["qsm_quiz_navigator_number_color_required"] ) ? sanitize_text_field( wp_unslash( $_POST["qsm_quiz_navigator_number_color_required"] ) ) : '#FFFFFF',
                'qsm_quiz_navigator_border_color_required' => isset( $_POST["qsm_quiz_navigator_border_color_required"] ) ? sanitize_text_field( wp_unslash( $_POST["qsm_quiz_navigator_border_color_required"] ) ) : '#f85758',
            );
            $mlwQuizMasterNext->pluginHelper->update_quiz_setting( "qsm_quiz_navigator_settings", $qsm_quiz_navigator_data );
            $mlwQuizMasterNext->alertManager->newAlert( __( 'Your quiz navigator settings has been saved successfully!', 'qsm-quiz-navigator' ), 'success' );
        }
        // Load the settings
        $qsm_quiz_navigator_data         = load_qsm_quiz_navigator_data();
        ?>
        <div id="tabs-quiz-navigator" class="mlw_tab_content <?php echo 1 != $qsm_quiz_navigator_data['qsm_quiz_navigator_enable'] ? 'qsm-navigator-disabled' : ''; ?>">
            <a target="_blank" class="button qsm-quiz-navigator-document-link" href="<?php echo esc_url( qsm_get_plugin_link( 'docs/add-ons/quiz-navigator', 'quiz_navigator', 'quiz_navigator_settings_page', 'read_documentation' ) )?>"><span class="dashicons dashicons-media-document"></span><?php echo esc_html_e( 'Read Documentation', 'qsm-quiz-navigator' ); ?></a>
            <h2><?php esc_html_e( "Quiz Navigator", "qsm-quiz-navigator" ); ?></h2>
            <p><?php esc_html_e( "Enable quiz takers to easily navigate and jump to specific pages within the quiz.", "qsm-quiz-navigator" ); ?></p>
            <form action="" method="post">
                <table class="form-table" style="width: 100%;">
                    <tr valign="top">
                        <th scope="row">
                            <label for="qsm-quiz-navigator-enable">
                                <?php esc_html_e( 'General Settings', 'qsm-quiz-navigator' ); ?>
                            </label>
                        </th>
                        <td class="qsm-navigator-general-settings">
                            <label class="qsm-opt-desc qsm-quiz-navigator-enable" for="qsm-quiz-navigator-enable">
                                <input type="checkbox" id="qsm-quiz-navigator-enable" name="qsm_quiz_navigator_enable" value="1" <?php
                                checked( $qsm_quiz_navigator_data['qsm_quiz_navigator_enable'], 1 ) ?> />
                                <?php esc_html_e( 'Enable', 'qsm-quiz-navigator' ); ?>
                            </label>
                            <div class="qsm-opt-desc" for="qsm-quiz-navigator-shortcode">
                                <label for="qsm-quiz-navigator-shortcode">
                                    <input type="checkbox" id="qsm-quiz-navigator-shortcode" name="qsm_quiz_navigator_shortcode" value="1" <?php
                                    checked( $qsm_quiz_navigator_data['qsm_quiz_navigator_shortcode'], 1 ) ?> />
                                    <?php esc_html_e( 'Use Shortcode', 'qsm-quiz-navigator' ); ?>
                                </label>
                                <div class="qsm-navigator-shortcode-main button-secondary"
                                    <?php echo 1 != $qsm_quiz_navigator_data['qsm_quiz_navigator_shortcode'] ? 'style="visibility:hidden;"' : '';
                                    echo empty( $mlwQuizMasterNext->pluginHelper->get_quiz_setting("qsm_quiz_navigator_settings") ) ? 'data-first="true"' : ''; ?>
                                    >
                                    <span class="qsm-navigator-shortcode">[qsm_navigator]</span>
                                    <span class="qsm-navigator-shortcode-info">
                                        <span class="qsm-navigator-copy-msg">
                                            <?php esc_html_e( 'Click to Copy', 'qsm-quiz-navigator' ); ?>
                                        </span>
                                        <span class="qsm-navigator-copy-success">
                                            <?php esc_html_e( 'Code Copied!', 'qsm-quiz-navigator' ); ?>
                                        </span>
                                    </span>
                                </div>
                                <br/>
                                <i><small><?php esc_html_e( 'Enabling the shortcode option automatically hides the default navigator view.', 'qsm-quiz-navigator' ); ?></small></i>
                            </div>
                            <label class="qsm-opt-desc" for="qsm-quiz-navigator-skip">
                                <input type="checkbox" id="qsm-quiz-navigator-skip" name="qsm_quiz_navigator_skip" value="1" <?php
                                    checked( $qsm_quiz_navigator_data['qsm_quiz_navigator_skip'], 1 ) ?> />
                                    <?php esc_html_e( 'Allow skipping required questions until submission', 'qsm-quiz-navigator' ); ?>
                            </label>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row">
                            <label for="qsm-quiz-navigator-size">
                                <?php esc_html_e( 'Layout', 'qsm-quiz-navigator' ); ?>
                            </label>
                        </th>
                        <td>
                            <div>
                                <b class="qsm-opt-desc">
                                    <?php esc_html_e( 'Type', 'qsm-quiz-navigator' ); ?>
                                </b>
                                <label class="qsm-quiz-navigator-select-image" for="qsm-quiz-navigator-layout-horizontal">
                                    <input type="radio" value="horizontal" name="qsm_quiz_navigator_layout" id="qsm-quiz-navigator-layout-horizontal" <?php
                                checked( $qsm_quiz_navigator_data['qsm_quiz_navigator_layout'], 'horizontal' ) ?> />
                                    <img src="<?php echo esc_url( QSM_QUIZ_NAVIGATOR_PLUGIN_URL ) ;?>/img/horizontal-selected.svg" class="active">
                                    <img src="<?php echo esc_url( QSM_QUIZ_NAVIGATOR_PLUGIN_URL ) ;?>/img/horizontal.svg">
                                    <?php esc_html_e( 'Horizontal', 'qsm-quiz-navigator' ); ?>
                                </label>
                                <label class="qsm-quiz-navigator-select-image" for="qsm-quiz-navigator-layout-grid" >
                                    <input type="radio" value="grid" name="qsm_quiz_navigator_layout" id="qsm-quiz-navigator-layout-grid" <?php
                                checked( $qsm_quiz_navigator_data['qsm_quiz_navigator_layout'], 'grid' ) ?>/>
                                    <img src="<?php echo esc_url( QSM_QUIZ_NAVIGATOR_PLUGIN_URL ) ;?>/img/grid-selected.svg" class="active">
                                    <img src="<?php echo esc_url( QSM_QUIZ_NAVIGATOR_PLUGIN_URL ) ;?>/img/grid.svg">
                                    <?php esc_html_e( 'Grid', 'qsm-quiz-navigator' ); ?>
                                </label>
                                <b class="qsm-opt-desc">
                                    <?php esc_html_e( 'Alignment', 'qsm-quiz-navigator' ); ?>
                                </b>
                                <label class="qsm-quiz-navigator-select-image" for="qsm-quiz-navigator-layout-left">
                                    <input type="radio" value="left" name="qsm_quiz_navigator_alignment" id="qsm-quiz-navigator-layout-left" <?php
                                checked( $qsm_quiz_navigator_data['qsm_quiz_navigator_alignment'], 'left' ) ?>/>
                                    <img src="<?php echo esc_url( QSM_QUIZ_NAVIGATOR_PLUGIN_URL ) ;?>/img/left-selected.svg" class="active">
                                    <img src="<?php echo esc_url( QSM_QUIZ_NAVIGATOR_PLUGIN_URL ) ;?>/img/left.svg">
                                    <?php esc_html_e( 'Left', 'qsm-quiz-navigator' ); ?>
                                </label>
                                <label class="qsm-quiz-navigator-select-image" for="qsm-quiz-navigator-layout-center" >
                                    <input type="radio" value="center" name="qsm_quiz_navigator_alignment" id="qsm-quiz-navigator-layout-center" <?php
                                checked( $qsm_quiz_navigator_data['qsm_quiz_navigator_alignment'], 'center' ) ?>/>
                                    <img src="<?php echo esc_url( QSM_QUIZ_NAVIGATOR_PLUGIN_URL ) ;?>/img/center-selected.svg" class="active">
                                    <img src="<?php echo esc_url( QSM_QUIZ_NAVIGATOR_PLUGIN_URL ) ;?>/img/center.svg">
                                    <?php esc_html_e( 'Center', 'qsm-quiz-navigator' ); ?>
                                </label>
                                <label class="qsm-quiz-navigator-select-image" for="qsm-quiz-navigator-layout-right" >
                                    <input type="radio" value="right" name="qsm_quiz_navigator_alignment" id="qsm-quiz-navigator-layout-right" <?php
                                checked( $qsm_quiz_navigator_data['qsm_quiz_navigator_alignment'], 'right' ) ?>/>
                                    <img src="<?php echo esc_url( QSM_QUIZ_NAVIGATOR_PLUGIN_URL ) ;?>/img/right-selected.svg" class="active">
                                    <img src="<?php echo esc_url( QSM_QUIZ_NAVIGATOR_PLUGIN_URL ) ;?>/img/right.svg">
                                    <?php esc_html_e( 'Right', 'qsm-quiz-navigator' ); ?>
                                </label>
                            </div>
                        </td>
                    </tr>
                </table>
                <h2 class="title"><?php esc_html_e( 'Buttons', 'qsm-quiz-navigator' ); ?></h2>
                <table class="form-table" style="width: 100%;">
                    <tr valign="top">
                        <th scope="row">
                            <label for="qsm-quiz-navigator-size">
                                <?php esc_html_e( 'Buttons Style', 'qsm-quiz-navigator' ); ?>
                            </label>
                        </th>
                        <td>
                            <table class="qsm-quiz-navigator-inner">
                                <tr>
                                    <td>
                                        <span class="qsm-opt-desc" for="qsm-quiz-navigator-width">
                                            <?php esc_html_e( 'Width', 'qsm-quiz-navigator' ); ?>
                                        </span>
                                    </td>
                                    <td>
                                        <input class="qsm-small-text qsm-quiz-navigator-device-input" name="qsm_quiz_navigator_width" type="number"
                                            placeholder="300" min="0" id="qsm-quiz-navigator-width"
                                            value="<?php echo esc_attr( $qsm_quiz_navigator_data['qsm_quiz_navigator_width'] ); ?>">
                                        <select id="qsm-quiz-navigator-width-unit" name="qsm_quiz_navigator_width_unit" class="qsm-quiz-navigator-unit">
                                            <option <?php selected( $qsm_quiz_navigator_data['qsm_quiz_navigator_width_unit'], 'px' );
                                                ?> value="px"><?php esc_html_e( 'px', 'qsm-quiz-navigator' ); ?></option>
                                            <option <?php selected( $qsm_quiz_navigator_data['qsm_quiz_navigator_width_unit'], '%' );
                                                ?> value="%"><?php esc_html_e( '%', 'qsm-quiz-navigator' ); ?></option>
                                            <option <?php selected( $qsm_quiz_navigator_data['qsm_quiz_navigator_width_unit'], 'em' );
                                                ?> value="em"><?php esc_html_e( 'em', 'qsm-quiz-navigator' ); ?></option>
                                            <option <?php selected( $qsm_quiz_navigator_data['qsm_quiz_navigator_width_unit'], 'rem' );
                                                ?> value="rem"><?php esc_html_e( 'rem', 'qsm-quiz-navigator' ); ?></option>
                                            <option <?php selected( $qsm_quiz_navigator_data['qsm_quiz_navigator_width_unit'], 'vw' );
                                                ?> value="vw"><?php esc_html_e( 'vw', 'qsm-quiz-navigator' ); ?></option>
                                            <option <?php selected( $qsm_quiz_navigator_data['qsm_quiz_navigator_width_unit'], 'vh' );
                                                ?> value="vh"><?php esc_html_e( 'vh', 'qsm-quiz-navigator' ); ?></option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <span class="qsm-opt-desc" for="qsm-quiz-navigator-width">
                                            <?php esc_html_e( 'Height', 'qsm-quiz-navigator' ); ?>
                                        </span>
                                    </td>
                                    <td>
                                        <input class="qsm-small-text qsm-quiz-navigator-device-input" name="qsm_quiz_navigator_height" type="number"
                                            placeholder="300" min="0" id="qsm-quiz-navigator-height"
                                            value="<?php echo esc_attr( $qsm_quiz_navigator_data['qsm_quiz_navigator_height'] ); ?>">
                                        <select id="qsm-quiz-navigator-width-unit" name="qsm_quiz_navigator_height_unit" class="qsm-quiz-navigator-unit">
                                            <option <?php selected( $qsm_quiz_navigator_data['qsm_quiz_navigator_height_unit'], 'px' );
                                                ?> value="px"><?php esc_html_e( 'px', 'qsm-quiz-navigator' ); ?></option>
                                            <option <?php selected( $qsm_quiz_navigator_data['qsm_quiz_navigator_height_unit'], '%' );
                                                ?> value="%"><?php esc_html_e( '%', 'qsm-quiz-navigator' ); ?></option>
                                            <option <?php selected( $qsm_quiz_navigator_data['qsm_quiz_navigator_height_unit'], 'em' );
                                                ?> value="em"><?php esc_html_e( 'em', 'qsm-quiz-navigator' ); ?></option>
                                            <option <?php selected( $qsm_quiz_navigator_data['qsm_quiz_navigator_height_unit'], 'rem' );
                                                ?> value="rem"><?php esc_html_e( 'rem', 'qsm-quiz-navigator' ); ?></option>
                                            <option <?php selected( $qsm_quiz_navigator_data['qsm_quiz_navigator_height_unit'], 'vw' );
                                                ?> value="vw"><?php esc_html_e( 'vw', 'qsm-quiz-navigator' ); ?></option>
                                            <option <?php selected( $qsm_quiz_navigator_data['qsm_quiz_navigator_height_unit'], 'vh' );
                                                ?> value="vh"><?php esc_html_e( 'vh', 'qsm-quiz-navigator' ); ?></option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <span class="qsm-opt-desc" for="qsm-quiz-navigator-gap">
                                            <?php esc_html_e( 'Gap', 'qsm-quiz-navigator' ); ?>
                                        </span>
                                    </td>
                                    <td>
                                        <input class="qsm-small-text" type="number" id="qsm-quiz-navigator-gap"
                                            name="qsm_quiz_navigator_gap" placeholder="10" step="1" min="0"
                                            value="<?php echo esc_attr( $qsm_quiz_navigator_data['qsm_quiz_navigator_gap'] ); ?>">
                                        <select id="qsm-quiz-navigator-width-unit" name="qsm_quiz_navigator_gap_unit" class="qsm-quiz-navigator-unit">
                                            <option <?php selected( $qsm_quiz_navigator_data['qsm_quiz_navigator_gap_unit'], 'px' );
                                                ?> value="px"><?php esc_html_e( 'px', 'qsm-quiz-navigator' ); ?></option>
                                            <option <?php selected( $qsm_quiz_navigator_data['qsm_quiz_navigator_gap_unit'], '%' );
                                                ?> value="%"><?php esc_html_e( '%', 'qsm-quiz-navigator' ); ?></option>
                                            <option <?php selected( $qsm_quiz_navigator_data['qsm_quiz_navigator_gap_unit'], 'em' );
                                                ?> value="em"><?php esc_html_e( 'em', 'qsm-quiz-navigator' ); ?></option>
                                            <option <?php selected( $qsm_quiz_navigator_data['qsm_quiz_navigator_gap_unit'], 'rem' );
                                                ?> value="rem"><?php esc_html_e( 'rem', 'qsm-quiz-navigator' ); ?></option>
                                            <option <?php selected( $qsm_quiz_navigator_data['qsm_quiz_navigator_gap_unit'], 'vw' );
                                                ?> value="vw"><?php esc_html_e( 'vw', 'qsm-quiz-navigator' ); ?></option>
                                            <option <?php selected( $qsm_quiz_navigator_data['qsm_quiz_navigator_gap_unit'], 'vh' );
                                                ?> value="vh"><?php esc_html_e( 'vh', 'qsm-quiz-navigator' ); ?></option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <span class="qsm-opt-desc" for="qsm-quiz-navigator-radium">
                                            <?php esc_html_e( 'Border Radius', 'qsm-quiz-navigator' ); ?>
                                        </span>
                                    </td>
                                    <td>
                                        <input class="qsm-small-text" type="number" id="qsm-quiz-navigator-radium"
                                            name="qsm_quiz_navigator_radius" placeholder="0" step="1" min="0"
                                            value="<?php echo esc_attr( $qsm_quiz_navigator_data['qsm_quiz_navigator_radius'] ); ?>">
                                        <select id="qsm-quiz-navigator-width-unit" name="qsm_quiz_navigator_radius_unit" class="qsm-quiz-navigator-unit">
                                            <option <?php selected( $qsm_quiz_navigator_data['qsm_quiz_navigator_radius_unit'], 'px' );
                                                ?> value="px"><?php esc_html_e( 'px', 'qsm-quiz-navigator' ); ?></option>
                                            <option <?php selected( $qsm_quiz_navigator_data['qsm_quiz_navigator_radius_unit'], '%' );
                                                ?> value="%"><?php esc_html_e( '%', 'qsm-quiz-navigator' ); ?></option>
                                            <option <?php selected( $qsm_quiz_navigator_data['qsm_quiz_navigator_radius_unit'], 'em' );
                                                ?> value="em"><?php esc_html_e( 'em', 'qsm-quiz-navigator' ); ?></option>
                                            <option <?php selected( $qsm_quiz_navigator_data['qsm_quiz_navigator_radius_unit'], 'rem' );
                                                ?> value="rem"><?php esc_html_e( 'rem', 'qsm-quiz-navigator' ); ?></option>
                                            <option <?php selected( $qsm_quiz_navigator_data['qsm_quiz_navigator_radius_unit'], 'vw' );
                                                ?> value="vw"><?php esc_html_e( 'vw', 'qsm-quiz-navigator' ); ?></option>
                                            <option <?php selected( $qsm_quiz_navigator_data['qsm_quiz_navigator_radius_unit'], 'vh' );
                                                ?> value="vh"><?php esc_html_e( 'vh', 'qsm-quiz-navigator' ); ?></option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <span class="qsm-opt-desc" for="qsm-quiz-navigator-gap">
                                            <?php esc_html_e( 'Border Thickness', 'qsm-quiz-navigator' ); ?>
                                        </span>
                                    </td>
                                    <td>
                                        <input name="qsm_quiz_navigator_border_thickness"
                                            id="qsm-quiz-navigator-borderd-thickness-active" type="number"
                                            value="<?php echo esc_attr( $qsm_quiz_navigator_data['qsm_quiz_navigator_border_thickness'] ); ?>"
                                            class="qsm-small-text">
                                        <span class="qsm-navigator-input-unit"><?php esc_html_e( 'px', 'qsm-quiz-navigator' ); ?></span>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row" colspan="2">
                            <label>
                                <?php esc_html_e( 'Button Colors', 'qsm-quiz-navigator' ); ?>
                            </label>
                        </th>
                    </tr>
                    <tr class="qsm-quiz-navigator-inner qsm-quiz-navigator-colors">
                        <td scope="row">
                            <label for="qsm-quiz-navigator-background-color">
                                <?php esc_html_e( 'Background', 'qsm-quiz-navigator' ); ?>
                            </label>
                        </td>
                        <td>
                            <input name="qsm_quiz_navigator_background_color" id="qsm-quiz-navigator-background-color"
                                type="text" data-alpha-enabled="true"
                                value="<?php echo esc_attr( $qsm_quiz_navigator_data['qsm_quiz_navigator_background_color'] ); ?>"
                                data-default-color="#eeeeee" data-label="<?php esc_html_e( 'Normal', 'qsm-quiz-navigator' ); ?>" class="qsm-navigator-color-field">
                            <input name="qsm_quiz_navigator_background_color_hover" id="qsm-quiz-navigator-background-color-hover"
                                type="text" data-alpha-enabled="true"
                                value="<?php echo esc_attr( $qsm_quiz_navigator_data['qsm_quiz_navigator_background_color_hover'] ); ?>"
                                data-default-color="#3498db" data-label="<?php esc_html_e( 'Hover', 'qsm-quiz-navigator' ); ?>" class="qsm-navigator-color-field">
                            <input name="qsm_quiz_navigator_background_color_active" id="qsm-quiz-navigator-background-color-active"
                                type="text" data-alpha-enabled="true"
                                value="<?php echo esc_attr( $qsm_quiz_navigator_data['qsm_quiz_navigator_background_color_active'] ); ?>"
                                data-default-color="#3498db" data-label="<?php esc_html_e( 'Active', 'qsm-quiz-navigator' ); ?>" class="qsm-navigator-color-field">
                            <input name="qsm_quiz_navigator_background_color_completed" id="qsm-quiz-navigator-background-color-completed"
                                type="text" data-alpha-enabled="true"
                                value="<?php echo esc_attr( $qsm_quiz_navigator_data['qsm_quiz_navigator_background_color_completed'] ); ?>"
                                data-default-color="#81d742" data-label="<?php esc_html_e( 'Responded', 'qsm-quiz-navigator' ); ?>" class="qsm-navigator-color-field">
                            <input name="qsm_quiz_navigator_background_color_skipped" id="qsm-quiz-navigator-background-color-skipped"
                                type="text" data-alpha-enabled="true"
                                value="<?php echo esc_attr( $qsm_quiz_navigator_data['qsm_quiz_navigator_background_color_skipped'] ); ?>"
                                data-default-color="#D8D8D8" data-label="<?php esc_html_e( 'Skipped', 'qsm-quiz-navigator' ); ?>" class="qsm-navigator-color-field">
                            <input name="qsm_quiz_navigator_background_color_required" id="qsm-quiz-navigator-background-color-required"
                                type="text" data-alpha-enabled="true"
                                value="<?php echo esc_attr( $qsm_quiz_navigator_data['qsm_quiz_navigator_background_color_required'] ); ?>"
                                data-default-color="#F85758" data-label="<?php esc_html_e( 'Required', 'qsm-quiz-navigator' ); ?>" class="qsm-navigator-color-field">
                        </td>
                    </tr>
                    <tr class="qsm-quiz-navigator-inner qsm-quiz-navigator-colors">
                        <td scope="row">
                            <label for="qsm-quiz-navigator-number-color">
                                <?php esc_html_e( 'Text', 'qsm-quiz-navigator' ); ?>
                            </label>
                        </td>
                        <td>
                            <input name="qsm_quiz_navigator_number_color" id="qsm-quiz-navigator-number-color"
                                type="text" data-alpha-enabled="true"
                                value="<?php echo esc_attr( $qsm_quiz_navigator_data['qsm_quiz_navigator_number_color'] ); ?>"
                                data-default-color="#3498db" data-label="<?php esc_html_e( 'Normal', 'qsm-quiz-navigator' ); ?>" class="qsm-navigator-color-field">
                            <input name="qsm_quiz_navigator_number_color_hover" id="qsm-quiz-navigator-number-color-hover"
                                type="text" data-alpha-enabled="true"
                                value="<?php echo esc_attr( $qsm_quiz_navigator_data['qsm_quiz_navigator_number_color_hover'] ); ?>"
                                data-default-color="#ffffff" data-label="<?php esc_html_e( 'Hover', 'qsm-quiz-navigator' ); ?>" class="qsm-navigator-color-field">
                            <input name="qsm_quiz_navigator_number_color_active" id="qsm-quiz-navigator-number-color-active"
                                type="text" data-alpha-enabled="true"
                                value="<?php echo esc_attr( $qsm_quiz_navigator_data['qsm_quiz_navigator_number_color_active'] ); ?>"
                                data-default-color="#ffffff" data-label="<?php esc_html_e( 'Active', 'qsm-quiz-navigator' ); ?>" class="qsm-navigator-color-field">
                            <input name="qsm_quiz_navigator_number_color_completed" id="qsm-quiz-navigator-number-color-completed"
                                type="text" data-alpha-enabled="true"
                                value="<?php echo esc_attr( $qsm_quiz_navigator_data['qsm_quiz_navigator_number_color_completed'] ); ?>"
                                data-default-color="#ffffff" data-label="<?php esc_html_e( 'Responded', 'qsm-quiz-navigator' ); ?>" class="qsm-navigator-color-field">
                            <input name="qsm_quiz_navigator_number_color_skipped" id="qsm-quiz-navigator-number-color-skipped"
                                type="text" data-alpha-enabled="true"
                                value="<?php echo esc_attr( $qsm_quiz_navigator_data['qsm_quiz_navigator_number_color_skipped'] ); ?>"
                                data-default-color="#ffffff" data-label="<?php esc_html_e( 'Skipped', 'qsm-quiz-navigator' ); ?>" class="qsm-navigator-color-field">
                            <input name="qsm_quiz_navigator_number_color_required" id="qsm-quiz-navigator-number-color-required"
                                type="text" data-alpha-enabled="true"
                                value="<?php echo esc_attr( $qsm_quiz_navigator_data['qsm_quiz_navigator_number_color_required'] ); ?>"
                                data-default-color="#ffffff" data-label="<?php esc_html_e( 'Required', 'qsm-quiz-navigator' ); ?>" class="qsm-navigator-color-field">
                        </td>
                    </tr>
                    <tr class="qsm-quiz-navigator-inner qsm-quiz-navigator-colors qsm-quiz-navigator-colors-last">
                        <td scope="row">
                            <label for="qsm-quiz-navigator-border-color">
                                <?php esc_html_e( 'Border', 'qsm-quiz-navigator' ); ?>
                            </label>
                        </td>
                        <td>
                            <input name="qsm_quiz_navigator_border_color" id="qsm-quiz-navigator-border-color"
                                type="text" data-alpha-enabled="true"
                                value="<?php echo esc_attr( $qsm_quiz_navigator_data['qsm_quiz_navigator_border_color'] ); ?>"
                                data-default-color="#3498db" data-label="<?php esc_html_e( 'Normal', 'qsm-quiz-navigator' ); ?>" class="qsm-navigator-color-field">
                            <input name="qsm_quiz_navigator_border_color_hover" id="qsm-quiz-navigator-border-color-hover"
                                type="text" data-alpha-enabled="true"
                                value="<?php echo esc_attr( $qsm_quiz_navigator_data['qsm_quiz_navigator_border_color_hover'] ); ?>"
                                data-default-color="#3498db" data-label="<?php esc_html_e( 'Hover', 'qsm-quiz-navigator' ); ?>" class="qsm-navigator-color-field">
                            <input name="qsm_quiz_navigator_border_color_active" id="qsm-quiz-navigator-border-color-active"
                                type="text" data-alpha-enabled="true"
                                value="<?php echo esc_attr( $qsm_quiz_navigator_data['qsm_quiz_navigator_border_color_active'] ); ?>"
                                data-default-color="#3498db" data-label="<?php esc_html_e( 'Active', 'qsm-quiz-navigator' ); ?>" class="qsm-navigator-color-field">
                            <input name="qsm_quiz_navigator_border_color_completed" id="qsm-quiz-navigator-border-color-completed"
                                type="text" data-alpha-enabled="true"
                                value="<?php echo esc_attr( $qsm_quiz_navigator_data['qsm_quiz_navigator_border_color_completed'] ); ?>"
                                data-default-color="#81d742" data-label="<?php esc_html_e( 'Responded', 'qsm-quiz-navigator' ); ?>" class="qsm-navigator-color-field">
                            <input name="qsm_quiz_navigator_border_color_skipped" id="qsm-quiz-navigator-border-color-skipped"
                                type="text" data-alpha-enabled="true"
                                value="<?php echo esc_attr( $qsm_quiz_navigator_data['qsm_quiz_navigator_border_color_skipped'] ); ?>"
                                data-default-color="#D8D8D8" data-label="<?php esc_html_e( 'Skipped', 'qsm-quiz-navigator' ); ?>" class="qsm-navigator-color-field">
                            <input name="qsm_quiz_navigator_border_color_required" id="qsm-quiz-navigator-border-color-required"
                                type="text" data-alpha-enabled="true"
                                value="<?php echo esc_attr( $qsm_quiz_navigator_data['qsm_quiz_navigator_border_color_required'] ); ?>"
                                data-default-color="#F85758" data-label="<?php esc_html_e( 'Required', 'qsm-quiz-navigator' ); ?>" class="qsm-navigator-color-field">
                        </td>
                    </tr>
                </table>
                <?php wp_nonce_field( 'qsm_quiz_navigator', 'qsm_quiz_navigator_nonce' ); ?>
                <div class="option-page-option-tab-footer">
                    <div class="footer-bar-notice">
                    </div>
                    <div class="result-tab-footer-buttons">
                        <button class="button-primary" type="submit"><?php esc_html_e( 'Save Settings', 'qsm-quiz-navigator' ); ?></button>
                        <button type="submit" name="qsm-quiz-navigator-reset" class="button-secondary qsm-quiz-navigator-reset"><?php esc_html_e( 'Reset to Defaults', 'qsm-quiz-navigator' ); ?></a>
                    </div>
                </div>
            </form>
        </div>
    <?php
    }else {
        ?>
        <form action="" method="post">
            <table class="form-table" >
            <tr valign="top">
                <th scope="row"><label for="license_key"><?php esc_html_e( 'Addon License Key', 'qsm-quiz-navigator' ); ?> </label></th>
                <td><input type="text" name="license_key" id="license_key" value="<?php echo esc_attr( $settings_data["license_key"] ); ?>"></td>
            </tr>
            </table>
            <?php wp_nonce_field('quiz_navigator', 'quiz_navigator_nonce'); ?>
            <button class="button-primary"><?php esc_html_e( 'Save Settings', 'qsm-quiz-navigator' ); ?></button>
        </form>
        <?php
    }
}
