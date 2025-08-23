<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * Registers your tab in the addon  settings page
 *
 * @since 1.0.0
 * @return void
 */
function quiz_navigator_register_addon_settings_tabs() {
	global $mlwQuizMasterNext;
	if ( ! is_null($mlwQuizMasterNext) && ! is_null($mlwQuizMasterNext->pluginHelper) && method_exists($mlwQuizMasterNext->pluginHelper, 'register_quiz_settings_tabs') ) {
		$mlwQuizMasterNext->pluginHelper->register_addon_settings_tab("Quiz Navigator", 'quiz_navigator_addon_settings_tabs_content');
	}
}

function quiz_navigator_addon_settings_tabs_content() {
	global $mlwQuizMasterNext;
	$settings = get_option('qsm_quiz_navigator_settings', '');
	$license     = isset( $settings['license_key'] ) ? trim( $settings['license_key'] ) : '';

	/**
	 * If nonce is correct, update api key from passed input
	 */
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
			$item_url = 'https://quizandsurveymaster.com/checkout/?edd_license_key='.$license.'&download_id='.QSM_QUIZ_NAVIGATOR_ITEM;
			$new_settings['license_key'] = $saved_license;
			$new_settings['license_status'] = 'valid';
			$new_settings['last_validate'] = gmdate("d-m-Y", time());
			$new_settings['expiry_date'] = isset($activation['expiry_date']) ? $activation['expiry_date'] : "";
			if ( 'success' == $activation['status'] ) {
				$mlwQuizMasterNext->alertManager->newAlert( __( 'License validated Successfully', 'qsm-quiz-navigator' ), 'success' );
			}elseif ( __( 'License has expired', 'qsm-quiz-navigator' ) == $activation['message'] ) {
				$target_text = __('License Key Expired. ', 'qsm-quiz-navigator');
				$target_link = sprintf( $target_text.'<a href="%s" target="_blank">%s</a>', esc_url( $item_url ), __( 'Click here to renew', 'qsm-quiz-navigator' ) );
				$default_notice = 0;
				$mlwQuizMasterNext->alertManager->newAlert( $target_link, 'error' );
			}else {
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
	/**
	 * Load settings
	 */
	$date_now = gmdate("d-m-Y");
	$settings        = get_option('qsm_quiz_navigator_settings', '');
	$license         = isset( $settings['license_key'] ) ? trim( $settings['license_key'] ) : '';
	$license_status  = isset( $settings['license_status'] ) ? $settings['license_status'] : '';
	if ( version_compare( $mlwQuizMasterNext->version, '8.1.6', '>' ) && (isset($settings['expiry_date']) && "" != $settings['expiry_date']) && (isset($settings['last_validate']) && "" != $settings['last_validate']) && strtotime($date_now) > strtotime($settings['expiry_date']) && strtotime($date_now) >= strtotime($settings['last_validate']) && 1 == $default_notice ) {
		$item_url = 'https://quizandsurveymaster.com/checkout/?edd_license_key='.$license.'&download_id='.QSM_ACTIVE_CAMPAIGN_ITEM;
		$target_text = __('License Key Expired. ', 'qsm-quiz-navigator');
		$target_link = sprintf( $target_text.'<a style="font-weight: 500;" href="%s" target="_blank">%s</a>', esc_url( $item_url ), __( 'Click here to renew', 'qsm-quiz-navigator' ) );
		$mlwQuizMasterNext->alertManager->newAlert( $target_link, 'error' );
	}
	$settings_data = wp_parse_args( get_option( 'qsm_quiz_navigator_settings', array() ), array(
		'license_key' => '',
	));
  	$mlwQuizMasterNext->alertManager->showAlerts();
  	?>
  	<h2><?php esc_html_e( 'Quiz Navigator', 'qsm-quiz-navigator' );  ?> </h2>
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

function qsm_quiz_navigator_front( $html, $options, $quiz_data ) {
	global $mlwQuizMasterNext;
    $settings_data  = get_option( 'qsm_quiz_navigator_settings', '' );
	$license        = isset( $settings_data['license_key'] ) ? trim( $settings_data['license_key'] ) : '';
	$license_status = isset( $settings_data['license_status'] ) ? $settings_data['license_status'] : '';
    if ( empty( $license ) || 'valid' != $license_status ) {
        return '<div class="qsm-result-page-warning">' . __( 'Quiz navigator configuration error. Contact the website administrator for help.', 'quiz-master-next' ) .'</div>';
    }
	$quiz_id = $options->quiz_id;
	// Load the settings
    $success = $mlwQuizMasterNext->pluginHelper->prepare_quiz( $quiz_id );
    if ( false === $success ) {
        return '<div class="qsm-result-page-warning">' .__( 'It appears that this quiz is not set up correctly', 'quiz-master-next' ) .'</div>';
    }
	$qsm_quiz_navigator_data         = load_qsm_quiz_navigator_data();
	if ( 1 != $qsm_quiz_navigator_data['qsm_quiz_navigator_enable'] || 1 == $qsm_quiz_navigator_data['qsm_quiz_navigator_shortcode'] ) {
		return;
	}
	// Generate CSS
	$css = qsm_quiz_navigator_generate_css($quiz_id, $qsm_quiz_navigator_data);

	// Enqueue styles
	qsm_quiz_navigator_enqueue_styles($quiz_id, $css);
	generate_quiz_navigator_html( $quiz_id, $qsm_quiz_navigator_data, false );

}

function qsm_quiz_navigator_shortcode( $attr ) {
	global $mlwQuizMasterNext;
    $settings_data  = get_option( 'qsm_quiz_navigator_settings', '' );
	$license        = isset( $settings_data['license_key'] ) ? trim( $settings_data['license_key'] ) : '';
	$license_status = isset( $settings_data['license_status'] ) ? $settings_data['license_status'] : '';
    if ( empty( $license ) || 'valid' != $license_status ) {
        return '<div class="qsm-result-page-warning">' . __( 'Quiz navigator configuration error. Contact the website administrator for help.', 'quiz-master-next' ) .'</div>';
    }
    $options = $mlwQuizMasterNext->quiz_settings->get_quiz_options();
	if ( ! empty( $attr['id'] ) || ! empty( $options->quiz_id ) ) {
		$quiz_id = ! empty( $attr['id'] ) ? sanitize_text_field( wp_unslash( $attr['id'] ) ) : $options->quiz_id;
        $success = $mlwQuizMasterNext->pluginHelper->prepare_quiz( $quiz_id );
        if ( false === $success ) {
        return '<div class="qsm-result-page-warning">' . __( 'It appears that this quiz is not set up correctly', 'quiz-master-next' ) .'</div>';
        }
		$qsm_quiz_navigator_data        = load_qsm_quiz_navigator_data();
        if ( 1 != $qsm_quiz_navigator_data['qsm_quiz_navigator_enable'] ) {
            return '<div class="qsm-result-page-warning">' . __('Please enable quiz navigator', 'qsm-quiz-navigator') . '</div>';
        }
        if ( 1 != $qsm_quiz_navigator_data['qsm_quiz_navigator_shortcode'] ) {
            return '<div class="qsm-result-page-warning">' . __('Please enable shortcode', 'qsm-quiz-navigator') . '</div>';
        }
		// Generate CSS
		$css = qsm_quiz_navigator_generate_css($quiz_id, $qsm_quiz_navigator_data);

		// Enqueue styles
		qsm_quiz_navigator_enqueue_styles($quiz_id, $css);
        ob_start();
		generate_quiz_navigator_html( $quiz_id, $qsm_quiz_navigator_data, true );
        return ob_get_clean();
    }
}

function qsm_quiz_navigator_generate_css( $quiz_id, $data ) {
    return sprintf(
        '.qsm-quiz-navigator-answers-wrap-%1$s .qsm-pages-number{
            border-radius: %2$s%3$s;
            background: %4$s;
            color: %5$s;
            border: %6$spx solid %7$s;
            margin-bottom: %8$s%9$s;
            min-width: %10$s%11$s;
            height: %12$s%13$s;
        }',
        $quiz_id,
        $data['qsm_quiz_navigator_radius'],
        $data['qsm_quiz_navigator_radius_unit'],
        $data['qsm_quiz_navigator_background_color'],
        $data['qsm_quiz_navigator_number_color'],
        $data['qsm_quiz_navigator_border_thickness'],
        $data['qsm_quiz_navigator_border_color'],
        $data['qsm_quiz_navigator_gap'],
        $data['qsm_quiz_navigator_gap_unit'],
        $data['qsm_quiz_navigator_width'],
        $data['qsm_quiz_navigator_width_unit'],
        $data['qsm_quiz_navigator_height'],
        $data['qsm_quiz_navigator_height_unit']
    ) .
	sprintf(
        '.qsm-quiz-navigator-answers-wrap-%1$s .qsm-pages-number:hover{
            background: %2$s;
            color: %3$s;
            border-color: %4$s;
        }',
        $quiz_id,
        $data['qsm_quiz_navigator_background_color_hover'],
        $data['qsm_quiz_navigator_number_color_hover'],
        $data['qsm_quiz_navigator_border_color_hover']
    ) .
    sprintf(
        '.qsm-quiz-navigator-answers-wrap-%1$s .qsm-pages-number.active{
            background: %2$s;
            color: %3$s;
            border-color: %4$s;
        }',
        $quiz_id,
        $data['qsm_quiz_navigator_background_color_active'],
        $data['qsm_quiz_navigator_number_color_active'],
        $data['qsm_quiz_navigator_border_color_active']
    ) .
    sprintf(
        '.qsm-quiz-navigator-answers-wrap-%1$s .qsm-pages-number.qsm-navigator-page-status-skipped:not(.active){
            background: %2$s;
            color: %3$s;
            border-color: %4$s;
        }',
        $quiz_id,
        $data['qsm_quiz_navigator_background_color_skipped'],
        $data['qsm_quiz_navigator_number_color_skipped'],
        $data['qsm_quiz_navigator_border_color_skipped']
    ) .
    sprintf(
        '.qsm-quiz-navigator-answers-wrap-%1$s .qsm-pages-number.qsm-navigator-page-status-completed:not(.active){
            background: %2$s;
            color: %3$s;
            border-color: %4$s;
        }',
        $quiz_id,
        $data['qsm_quiz_navigator_background_color_completed'],
        $data['qsm_quiz_navigator_number_color_completed'],
        $data['qsm_quiz_navigator_border_color_completed']
    ) .
    sprintf(
        '.qsm-quiz-navigator-answers-wrap-%1$s .qsm-pages-number.qsm-navigator-page-status-required:not(.active){
            background: %2$s;
            color: %3$s;
            border-color: %4$s;
        }',
        $quiz_id,
        $data['qsm_quiz_navigator_background_color_required'],
        $data['qsm_quiz_navigator_number_color_required'],
        $data['qsm_quiz_navigator_border_color_required']
    ) .
    sprintf(
        '.qsm-quiz-navigator-answers-wrap-%1$s .qsm-quiz-navigator-pages {
            column-gap: %2$s%3$s;
        }',
        $quiz_id,
        $data['qsm_quiz_navigator_gap'],
        $data['qsm_quiz_navigator_gap_unit']
    );
}

function qsm_quiz_navigator_enqueue_styles( $quiz_id, $css ) {
    wp_register_style('qsm_quiz_navigator_css' . $quiz_id, false, array(), $quiz_id );
    wp_enqueue_style('qsm_quiz_navigator_css' . $quiz_id, false, array(), $quiz_id );
    wp_add_inline_style('qsm_quiz_navigator_css' . $quiz_id, $css);
}

function load_qsm_quiz_navigator_data() {
    // Load the settings
	global $mlwQuizMasterNext;
    $qsm_quiz_navigator_data = $mlwQuizMasterNext->pluginHelper->get_quiz_setting("qsm_quiz_navigator_settings");

    $qsm_quiz_navigator_defaults = array(
        'qsm_quiz_navigator_enable'                     => 0,
        'qsm_quiz_navigator_shortcode'                  => 0,
        'qsm_quiz_navigator_skip'                       => 0,
        'qsm_quiz_navigator_layout'                     => 'horizontal',
        'qsm_quiz_navigator_alignment'                  => 'center',
        'qsm_quiz_navigator_width'                      => 40,
        'qsm_quiz_navigator_width_unit'                 => 'px',
        'qsm_quiz_navigator_height'                     => 40,
        'qsm_quiz_navigator_height_unit'                => 'px',
        'qsm_quiz_navigator_radius'                     => 2,
        'qsm_quiz_navigator_radius_unit'                => 'px',
        'qsm_quiz_navigator_gap'                        => 10,
        'qsm_quiz_navigator_gap_unit'                   => 'px',
        'qsm_quiz_navigator_background_color'           => '#eeeeee',
        'qsm_quiz_navigator_number_color'               => '#3498db',
        'qsm_quiz_navigator_border_color'               => '#3498db',
        'qsm_quiz_navigator_border_thickness'           => 1,
        'qsm_quiz_navigator_background_color_active'    => '#3498db',
        'qsm_quiz_navigator_number_color_active'        => '#ffffff',
        'qsm_quiz_navigator_border_color_active'        => '#3498db',
		'qsm_quiz_navigator_background_color_hover'     => '#3498db',
        'qsm_quiz_navigator_number_color_hover'         => '#FFFFFF',
        'qsm_quiz_navigator_border_color_hover'         => '#3498db',
        'qsm_quiz_navigator_background_color_completed' => '#81d742',
        'qsm_quiz_navigator_number_color_completed'     => '#ffffff',
        'qsm_quiz_navigator_border_color_completed'     => '#81d742',
		'qsm_quiz_navigator_background_color_skipped'   => '#d8d8d8',
        'qsm_quiz_navigator_number_color_skipped'       => '#ffffff',
        'qsm_quiz_navigator_border_color_skipped'       => '#d8d8d8',
		'qsm_quiz_navigator_background_color_required'  => '#f85758',
        'qsm_quiz_navigator_number_color_required'      => '#FFFFFF',
        'qsm_quiz_navigator_border_color_required'      => '#f85758',
    );

    return wp_parse_args($qsm_quiz_navigator_data, $qsm_quiz_navigator_defaults);
}

function generate_quiz_navigator_html( $quiz_id, $qsm_quiz_navigator_data, $shortcode = true ) {
	global $mlwQuizMasterNext, $qmn_total_questions;
    $total_pages = 0;
    $start_pages = false;
    $mlwQuizMasterNext->pluginHelper->prepare_quiz( $quiz_id );
    $pages = $mlwQuizMasterNext->pluginHelper->get_quiz_setting('pages', array());
    $options = $mlwQuizMasterNext->quiz_settings->get_quiz_options();
	$contact_fields  = QSM_Contact_Manager::load_fields();

    if ( 0 == $options->question_from_total && 0 == $options->pagination && is_countable($pages) && 0 !== count($pages) ) {
        $total_pages = $total_pages + count($pages);
    } else {
        $pagination_option = $options->pagination ? $options->pagination : $qmn_total_questions;
        if ( 0 == $qmn_total_questions && is_countable( $pages ) ) {
            $total_questions = 0 ;
            foreach ( $pages as $page ) {
                if ( is_countable( $page ) ) {
                    $total_questions = $total_questions + count($page);
                }
            }
            $autopages = $total_questions / $pagination_option;
        }else {
            $autopages = $qmn_total_questions / $pagination_option;
        }
        $total_pages = $total_pages + ceil( $autopages );
    }

    if ( 1 !== intval($options->disable_first_page) && ( ! empty($options->message_before) || (0 == $options->contact_info_location && $contact_fields)) ) {
        $start_pages = true;
    }
    ?>
    <div class="qsm-quiz-navigator-answers-wrap qsm-quiz-navigator-answers-wrap-<?php echo esc_attr($options->quiz_id); ?> qsm-quiz-navigator-answers-wrap-<?php echo esc_attr( $qsm_quiz_navigator_data['qsm_quiz_navigator_layout'] ); ?> qsm-quiz-navigator-answers-wrap-<?php echo esc_attr( $qsm_quiz_navigator_data['qsm_quiz_navigator_alignment'] ); ?> <?php echo $start_pages && ! $shortcode ? 'qsm-d-none' : ''; ?> <?php echo $shortcode ? 'qsm-quiz-navigator-answers-wrap-shortcode' : ''; ?> <?php echo 1 == $qsm_quiz_navigator_data['qsm_quiz_navigator_skip'] ? 'qsm-quiz-navigator-answers-wrap-skip' : ''; ?>" data-quiz-id="<?php echo esc_attr($options->quiz_id); ?>">
        <div class="qsm-quiz-navigator-pages">
            <?php
            for ( $i = 1; $i <= $total_pages; $i++ ) {
                ?>
                <span class="qsm-pages-number <?php echo ! $start_pages && 1 === $i ? 'active' : ''; ?> qsm-pages-number-<?php echo esc_attr($i); ?>" data-number="<?php echo esc_attr($i); ?>" data-quiz-id="<?php echo esc_attr($options->quiz_id); ?>">
                    <?php echo esc_html($i); ?>
                </span>
            <?php
            }
            ?>
        </div>
        <?php if ( 'horizontal' === $qsm_quiz_navigator_data['qsm_quiz_navigator_layout'] ) { ?>
            <div class="qsm-quiz-navigator-arrow">
                <label class="qsm-quiz-navigator-arrow-left qsm-quiz-navigator-arrow-icon">
                    <span class="dashicons dashicons-arrow-left-alt2"></span>
                </label>
                <label class="qsm-quiz-navigator-arrow-right qsm-quiz-navigator-arrow-icon">
                    <span class="dashicons dashicons-arrow-right-alt2"></span>
                </label>
            </div>
        <?php } ?>
    </div>
    <?php
}
