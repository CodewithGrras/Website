<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Registers your tab in the addon  settings page
 *
 * @since 0.1.0
 * @return void
 */
function qsm_addon_export_import_register_addon_settings_tabs() {
	global $mlwQuizMasterNext;
	if ( ! is_null( $mlwQuizMasterNext ) && ! is_null( $mlwQuizMasterNext->pluginHelper ) && method_exists( $mlwQuizMasterNext->pluginHelper, 'register_quiz_settings_tabs' ) ) {
		$mlwQuizMasterNext->pluginHelper->register_addon_settings_tab( 'Export And Import', 'qsm_addon_export_import_addon_settings_tabs_content' );
	}
	$export_folder = QSM_IMPORT_EXPORT_THEME_PATH . "/exports/";
	if ( ! is_dir($export_folder) ) {
		mkdir($export_folder, 0755);
	}
}

/**
 * Generates the content for your addon settings tab
 *
 * @since 0.1.0
 * @return void
 */
function qsm_addon_export_import_addon_settings_tabs_content() {

	// Enqueue your scripts and styles.
	wp_enqueue_script( 'qsm_export_import_admin_script', QSM_IMPORT_EXPORT_JS_URL . '/qsm-export-import-admin.js', array( 'jquery' ), QSM_IMPORT_EXPORT_VER, true );
	wp_enqueue_style( 'qsm_export_import_admin_style', QSM_IMPORT_EXPORT_CSS_URL . '/qsm-export-import-admin.css', array(), QSM_IMPORT_EXPORT_VER );
	$params = array(
		'qsm_exporting_txt'       => esc_html__( 'Exporting...', 'qsm-export-import' ),
		'qsm_select_quiz_txt'     => esc_html__( 'please select a quiz or survey', 'qsm-export-import' ),
		'qsm_export_quiz_btn_txt' => esc_html__( 'Export', 'qsm-export-import' ),
		'please_wait'             => __('Please Wait! We are validating your license', 'qsm-export-import'),
		'license_msg'             => __('License Key Required.', 'qsm-export-import'),
		'save_license'            => __('Save', 'qsm-export-import'),
		'invalid'                 => __('<span class="dashicons dashicons-warning"></span><b>Incorrect License!</b> Please enter a valid license key.', 'qsm-export-import'),
		'already_present'         => __( 'already present in database.', 'qsm-export-import' ),
		'qsm_importing_txt'       => __( 'Importing...', 'qsm-export-import' ),
		'quiz_survey'             => __( 'quiz/survey', 'qsm-export-import' ),
		'response'                => __( 'response', 'qsm-export-import' ),
		'missing_file'            => __( 'Missing or empty file.', 'qsm-export-import' ),
		'import_failed'           => __( 'import failed!', 'qsm-export-import' ),
		'import_success'          => __( 'imported successfully!', 'qsm-export-import' ),
		'check_qsm_log'           => __( 'Please check QSM Logs for details.', 'qsm-export-import' ),
		'unable_to_import_result' => __( 'Unable to import some responses due to following issues:', 'qsm-export-import' ),
		'no_question_quiz'        => __( 'Associated quiz has no question.', 'qsm-export-import' ),
		'no_result_data'          => __( 'Response has no result data.', 'qsm-export-import' ),
		'quiz_not_found'          => __( 'Quiz not found.', 'qsm-export-import' ),
		'site_url'                => site_url(),
	);
	wp_localize_script( 'qsm_export_import_admin_script', 'qsm_export_import_obj', $params );

	global $mlwQuizMasterNext, $wp_filesystem;
	global $wpdb;
	WP_Filesystem();

	$logic_table                  = $wpdb->prefix . 'mlw_logic';
	$themes_table                 = $wpdb->prefix . 'mlw_themes';
	$themes_settings_table        = $wpdb->prefix . 'mlw_quiz_theme_settings';
	$logic_table_exists           = false;
	$themes_table_exists          = false;
	$themes_settings_table_exists = false;

	if ( $wpdb->get_var( "SHOW TABLES LIKE '$logic_table'" ) == $logic_table ) {
		$logic_table_exists = true;
	}

	if ( $wpdb->get_var( "SHOW TABLES LIKE '$themes_table'" ) == $themes_table ) {
		$themes_table_exists = true;
	}

	if ( $wpdb->get_var( "SHOW TABLES LIKE '$themes_settings_table'" ) == $themes_settings_table ) {
		$themes_settings_table_exists = true;
	}

	$accepted_mime_types = array(
		'application/json',
		'text/json',
		'text/javascript',
		'text/plain',
		'text/anytext',
		'text/*',
		'text/csv',
		'application/csv',
		'application/excel',
		'application/vnd.ms-excel',
		'application/vnd.msexcel',
		'application/octet-stream',
	);

	$json_file_type = array(
		'application/json',
		'text/json',
		'text/javascript',
		'text/plain',
		'text/anytext',
		'text/*',
		'application/octet-stream',
	);

	$qsm_export_import_content = new QSM_Export_Import_Content();
	$qsm_export_import_content->qsm_addon_import_quiz_tabs_function( $json_file_type, $logic_table, $themes_table, $themes_settings_table, $themes_table_exists, $themes_settings_table_exists, $logic_table_exists );
	$qsm_export_import_content->qsm_addon_import_settings_tabs_function( $json_file_type, $logic_table, $themes_table, $themes_settings_table, $themes_table_exists, $themes_settings_table_exists, $logic_table_exists );
	$qsm_export_import_content->qsm_addon_import_question_tabs_function( $accepted_mime_types, $json_file_type, $logic_table, $themes_table, $themes_settings_table, $themes_table_exists, $themes_settings_table_exists, $logic_table_exists );
	$qsm_export_import_content->qsm_addon_import_flashcards_tabs_function( $accepted_mime_types, $json_file_type );
	$qsm_export_import_content->qsm_addon_export_import_license_tabs_function();
	// Show any alerts from saving.
	// load all quizzes.
	$quiz_data = $wpdb->get_results( "SELECT quiz_id, quiz_name	FROM {$wpdb->prefix}mlw_quizzes WHERE deleted=0 ORDER BY quiz_id DESC" );
	?>
	<?php $mlwQuizMasterNext->alertManager->showAlerts(); ?>
	<nav class="nav-tab-wrapper">
		<a class="nav-tab <?php echo ! isset( $_GET['innertab'] ) ? esc_attr( 'nav-tab-active' ) : ''; ?>" href="
			<?php
			echo esc_url(
				add_query_arg(
					array(
						'page' => 'qmn_addons',
						'tab'  => 'export-and-import',
					),
					admin_url( 'admin.php' )
				)
			);
			?>
		"><?php esc_html_e( 'Export/Import', 'qsm-export-import' ); ?></a>
		<?php if ( class_exists( 'QSM_Flashcards' ) ) { ?>
			<a class="nav-tab <?php echo isset( $_GET['flashcards'] ) ? esc_attr( 'nav-tab-active' ) : ''; ?>" href="
				<?php
				echo esc_url(
					add_query_arg(
						array(
							'page'       => 'qmn_addons',
							'tab'        => 'export-and-import',
							'innertab'   => true,
							'flashcards' => true,
						),
						admin_url( 'admin.php' )
					)
				);
				?>
			"><?php esc_html_e( 'Flashcards', 'qsm-export-import' ); ?></a>
		<?php } ?>
		<a class="nav-tab <?php echo  isset( $_GET['license'] ) ? esc_attr( 'nav-tab-active' ) : ''; ?>" href="
			<?php
			echo esc_url(
				add_query_arg(
					array(
						'page'     => 'qmn_addons',
						'tab'      => 'export-and-import',
						'innertab' => true,
						'license'  => true,
					),
					admin_url( 'admin.php' )
				)
			);
			?>
		"><?php esc_html_e( 'License', 'qsm-export-import' ); ?></a>
	</nav>
	<div id="dashboard-widgets-wrap" class="qsm-export-import-dashboard">
		<div id="dashboard-widgets" class="metabox-holder">
			<?php
			if ( isset( $_GET['flashcards'] ) && class_exists( 'QSM_Flashcards' ) ) {
				$qsm_export_import_content->qsm_addon_export_import_flashcards_tabs_content();
			} elseif ( isset( $_GET['license'] ) ) {
				$qsm_export_import_content->qsm_addon_export_import_license_tabs_content();
			} else {
				$date_now = date("d-m-Y");
				$settings_data   = get_option('qsm_addon_export_import_settings', '');
				$license         = isset( $settings_data['license_key'] ) ? trim( $settings_data['license_key'] ) : '';
				$license_status  = isset( $settings_data['license_status'] ) ? $settings_data['license_status'] : '';
				if ( '' != $license && 'valid' == $license_status ) {
					if ( version_compare( $mlwQuizMasterNext->version, '8.1.6', '>' ) && (isset($settings_data['expiry_date']) && "" != $settings_data['expiry_date']) && (isset($settings_data['last_validate']) && "" != $settings_data['last_validate']) && strtotime($date_now) > strtotime($settings_data['expiry_date']) && strtotime($date_now) >= strtotime($settings_data['last_validate']) ) {
						$item_url = 'https://quizandsurveymaster.com/checkout/?edd_license_key='.$license.'&download_id='.QSM_IMPORT_EXPORT_ITEM;
						$target_text = __('License Key Expired. ', 'qsm-export-import');
						$target_link = sprintf( $target_text.'<a style="font-weight: 500;" href="%s" target="_blank">%s</a>', esc_url( $item_url ), __( 'Click here to renew', 'qsm-export-import' ) );
						$mlwQuizMasterNext->alertManager->newAlert( $target_link, 'error' );
					}
					$mlwQuizMasterNext->alertManager->showAlerts();
					$qsm_export_import_content->qsm_addon_export_import_quiz_tabs_content( $quiz_data );
					$qsm_export_import_content->qsm_addon_export_import_questions_tabs_content( $quiz_data );
					$qsm_export_import_content->qsm_addon_export_import_options_tabs_content( $quiz_data );
				}else {
					?>
					<div class="qsm-license-form-parent">
						<div class="qsm-license-header">
							<p class="qsm-heading">
								<?php esc_html_e( 'Manage License', 'qsm-export-import' ); ?>
							</p>
						</div>
						<div class="qsm_export_i_validate_parent">
							<form class="rq_validata-license" method="POST">
								<input type="text" placeholder="<?php echo esc_html("Enter your license key"); ?>" class="qsm_export_i_validate_input" name="qsm_export_i_validate_input" />
								<input value="Validate" type="submit" name="qsm_export_i_validate_button" class="qsm_export_i_validate_button button button-primary" />
							</form>
						</div>
						<div id="qsm-license_message" style="display: none; padding: 0 0 0 22px;"><p><strong class="qsm_export_i_validate_message"></strong></div>
					</div>
					<?php
				}
			}
			?>
		</div>
	</div>
	<?php
}

/**
 * This class is the main class of tab content
 *
 * @since 2.0
 */
class QSM_Export_Import_Content {

	/**
	 * Generates the content for export/import quiz
	 *
	 * @since 2.0
	 * @return void
	 */
	public function qsm_addon_export_import_quiz_tabs_content( $quiz_data ) {
		?>
		<div class="postbox">
			<div class="qsm-import-export-header">
				<h2><?php esc_html_e( 'Export/Import Quizzes & Surveys', 'qsm-export-import' ); ?></h2>
				<p><?php esc_html_e( 'Use this section to export or import all of your quizzes and surveys, including their questions and settings.', 'qsm-export-import' ); ?></p>
				<?php wp_nonce_field( 'qsm_export_import_quiz', 'qsm_export_import_quiz_nonce' ); ?>
			</div>
			<div class="inside">
				<div id="postbox-container-1" class="postbox-container">
					<div id="normal-sortables" class="meta-box-sortables ui-sortable">
						<div class="settings-row">
							<h3 class="qsm-option-heading"><?php esc_html_e( 'Export Quizzes & Surveys', 'qsm-export-import' ); ?></h3>
							<p><?php esc_html_e( 'Click the button below to download a file containing all of your quizzes and surveys, including their questions and settings. If you want to export a single quiz, you can select the quiz from dropdown and then click export button.', 'qsm-export-import' ); ?></p>
							<?php wp_nonce_field( 'qsm_export_quiz', 'qsm_export_quiz_nonce' ); ?>
							<label class="qsm-label-heading"><?php esc_html_e( 'Select Quiz/Survey:', 'qsm-export-import' ); ?></label>
							<select name="qsm-export-select" class="qsm-export-select" multiple id="qsm-multi-select-quiz" >
								<!-- <option value="all"><?php //esc_html_e( 'All Quizzes & Surveys', 'qsm-export-import' ); ?></option> -->
								<?php
								foreach ( $quiz_data as $quiz ) {
									?>
									<option value="<?php echo esc_attr( $quiz->quiz_id ); ?>"><?php echo esc_html( $quiz->quiz_name ); ?></option>
									<?php
								}
								?>
							</select>
							<label class="qsm-label-heading include-responses">
								<input type="checkbox" name="export_results" id="export_results_checkbox" />
								<?php esc_html_e( 'Include Responses', 'qsm-export-import' ); ?>
							</label>
							<div id="qsm-export-quiz-result-message" class="qsm-error-message qsm-ie-message"></div>
						</div>
						<button class="button-primary qsm-export-quiz"><?php esc_html_e( 'Export', 'qsm-export-import' ); ?></button>
					</div>
				</div>
				<div id="postbox-container-2" class="postbox-container">
					<div id="side-sortables" class="meta-box-sortables ui-sortable">
						<form action="" method="post" id="qsm-import-quiz-result-form" >
							<div class="settings-row">
								<h3 class="qsm-option-heading"><?php esc_html_e( 'Import Quizzes & Surveys', 'qsm-export-import' ); ?></h3>
								<p><?php esc_html_e( 'Choose a file from your computer to import all of your quizzes and surveys, including their questions and settings.', 'qsm-export-import' ); ?></p>
								<div class="qsm-drag-drop-area">
									<label class="qsm-drag-drop-info" for="import-quizzes"><span class="dashicons dashicons-upload"></span></label>
									<p class="drag-drop-info"><?php esc_html_e( 'Drop files to upload' , 'qsm-export-import'); ?></p>
									<p><?php esc_html_e( 'or' , 'qsm-export-import'); ?></p>
									<label for="import-options-file" class="button qsm-drag-drop-info"><?php esc_html_e( 'Select Files' , 'qsm-export-import'); ?></label>
									<input type="file" name="import-quizzes" class="import-quizzes qsm-import-files" id="qsm-import-quiz-result-file" >
								</div>
							</div>
							<label class="qsm-label-heading qsm-import-media">
								<input type="checkbox" name="qsm_import_media" id="qsm-import-media" />
								<?php esc_html_e( 'Import Media', 'qsm-export-import' ); ?>
							</label>
							<p><span class="dashicons dashicons-info-outline qsm-text-primary" style="color:#0065D3"></span> <?php esc_html_e( 'JSON file format supported.', 'qsm-export-import' );?></p>
							<div id="qsm-import-quiz-result-message" class="qsm-error-message qsm-ie-message"></div>
							<input type="submit" id="qsm-import-quiz-result-submit-btn" class="button-primary" value="<?php esc_html_e( 'Import', 'qsm-export-import' ); ?>" name="submit">
							<?php wp_nonce_field( 'qsm_import_quiz', 'qsm_import_quiz_nonce' ); ?>
						</form>
					</div>
				</div>
			</div>
		</div>
		<?php
	}

	/**
	 * Generates the content for export/import question
	 *
	 * @since 2.0
	 * @return void
	 */
	public function qsm_addon_export_import_questions_tabs_content( $quiz_data ) {
		?>
		<div class="postbox">
			<div class="qsm-import-export-header">
				<h2><?php esc_html_e( 'Export/Import Questions', 'qsm-export-import' ); ?></h2>
				<p><?php esc_html_e( 'Use this section to export or import only the questions from your quizzes and surveys.', 'qsm-export-import' ); ?></p>
			</div>
			<div class="inside">
				<div id="postbox-container-1" class="postbox-container">
					<div id="normal-sortables" class="meta-box-sortables ui-sortable">
						<div class="settings-row">
							<h3 class="qsm-option-heading"><?php esc_html_e( 'Export Questions', 'qsm-export-import' ); ?></h3>
							<p><?php esc_html_e( 'Click the button below to download a file containing all of the questions from your quizzes and surveys.', 'qsm-export-import' ); ?></p>
							<?php wp_nonce_field( 'qsm_export_questions', 'qsm_export_questions_nonce' ); ?>
							<label class="qsm-label-heading"><?php esc_html_e( 'Select Quiz/Survey', 'qsm-export-import' ); ?></label>
							<select name="qsm-export-question-select" class="qsm-export-question-select">
								<option value="all"><?php esc_html_e( 'All Quizzes & Surveys', 'qsm-export-import' ); ?></option>
								<?php
								foreach ( $quiz_data as $quiz ) {
									?>
									<option value="<?php echo esc_attr( $quiz->quiz_id ); ?>"><?php echo esc_html( $quiz->quiz_name ); ?></option>
									<?php
								}
								?>
							</select>
						</div>
						<div class="settings-row">
							<label><input type="radio" value="json" name="export-type" class="qsm-export-type" checked="checked" /><?php esc_html_e( 'JSON', 'qsm-export-import' ); ?></label>
							<label><input type="radio" value="csv" name="export-type" class="qsm-export-type" /><?php esc_html_e( 'CSV Export', 'qsm-export-import' ); ?></label>
						</div>
						<button class="button-primary qsm-export-questions"><?php esc_html_e( 'Export', 'qsm-export-import' ); ?></button>
					</div>
				</div>
				<div id="postbox-container-2" class="postbox-container">
					<div id="side-sortables" class="meta-box-sortables ui-sortable">
						<form action="" method="post" enctype="multipart/form-data">
							<div class="settings-row">
								<h3 class="qsm-option-heading"><?php esc_html_e( 'Import Questions', 'qsm-export-import' ); ?></h3>
								<p>
									<?php
									printf(
										__( 'Choose a file from your computer to import questions into quizzes and surveys. You can download this %1$s sample CSV %2$s file and upload new questions in bulk.', 'easy-digital-downloads' ),
										'<a download href="' . QSM_IMPORT_EXPORT_URL . '/import_question_file_demo.csv">',
										'</a>'
									);
									?>
								</p>
								<label class="qsm-label-heading"><?php esc_html_e( 'Select Quiz/Survey', 'qsm-export-import' ); ?></label>
								<select name="qsm-import-select-quiz" class="import_select" required>
									<option value=""><?php esc_html_e( 'Select Quiz', 'qsm-export-import' ); ?></option>
									<?php
									if ( $quiz_data ) {
										foreach ( $quiz_data as $quiz ) {
											?>
											<option value="<?php echo esc_attr( $quiz->quiz_id ); ?>"><?php echo esc_html( $quiz->quiz_name ); ?></option>
											<?php
										}
									}
									?>
								</select>
							</div>
							<div class="settings-row">
								<div class="qsm-drag-drop-area">
									<label class="qsm-drag-drop-info" for="import-questions"><span class="dashicons dashicons-upload"></span></label>
									<p class="drag-drop-info"><?php esc_html_e( 'Drop files to upload' , 'qsm-export-import'); ?></p>
									<p><?php esc_html_e( 'or' , 'qsm-export-import'); ?></p>
									<label for="import-questions" class="button qsm-drag-drop-info"><?php esc_html_e( 'Select Files' , 'qsm-export-import'); ?></label>
									<input type="file" name="import-questions" class="import-quizzes qsm-import-files">
								</div>
								<p><span class="dashicons dashicons-info-outline qsm-text-primary" style="color:#0065D3"></span> <?php esc_html_e( 'CSV & JSON file format supported.', 'qsm-export-import' );?>
							</div>
							<input type="submit" class="button-primary" value="<?php esc_html_e( 'Import', 'qsm-export-import' ); ?>" name="submit">
							<?php wp_nonce_field( 'qsm_import_questions', 'qsm_import_questions_nonce' ); ?>
						</form>
					</div>
				</div>
			</div>
		</div>
	<?php
	}

	/**
	 * Generates the content for export/import options
	 *
	 * @since 2.0
	 * @return void
	 */
	public function qsm_addon_export_import_options_tabs_content( $quiz_data ) {
		?>
		<div class="postbox">
			<div class="qsm-import-export-header">
				<h2><?php esc_html_e( 'Export/Import Quiz Settings', 'qsm-export-import' ); ?></h2>
				<p><?php esc_html_e( 'Use this section to export or import the settings for your quizzes and surveys.', 'qsm-export-import' ); ?></p>
			</div>
			<div class="inside">
				<div id="postbox-container-1" class="postbox-container">
					<div id="normal-sortables" class="meta-box-sortables ui-sortable">
						<div class="settings-row">
							<h3 class="qsm-option-heading"><?php esc_html_e( 'Export Quiz Settings', 'qsm-export-import' ); ?></h3>
							<p><?php esc_html_e( 'Select the settings you want to export, and click the button below to download a file for safekeeping or sharing with others.', 'qsm-export-import' ); ?></p>
							<label class="qsm-input-label">
								<input type="checkbox" value="option" name="qsm-export-options[]">
								<?php esc_html_e( 'Options', 'qsm-export-import' ); ?>
							</label>
							<label class="qsm-input-label">
								<input type="checkbox" value="text" name="qsm-export-options[]">
								<?php esc_html_e( 'Text', 'qsm-export-import' ); ?>
							</label>
							<label class="qsm-input-label">
								<input type="checkbox" value="contact" name="qsm-export-options[]">
								<?php esc_html_e( 'Contact fields', 'qsm-export-import' ); ?>
							</label>
							<label class="qsm-input-label">
								<input type="checkbox" value="style" name="qsm-export-options[]">
								<?php esc_html_e( 'Style', 'qsm-export-import' ); ?>
							</label>
						</div>
						<div class="settings-row">
							<span>
								<?php wp_nonce_field( 'qsm_export_settings', 'qsm_export_settings_nonce' ); ?>
								<label class="qsm-label-heading"><?php esc_html_e( 'Select Quiz/Survey', 'qsm-export-import' ); ?></label>
								<select name="qsm-export-option-select" class="qsm-export-option-select" required>
									<option value=""><?php esc_html_e( 'Select Quiz', 'qsm-export-import' ); ?></option>
									<?php
									foreach ( $quiz_data as $quiz ) {
										?>
										<option value="<?php echo esc_attr( $quiz->quiz_id ); ?>"><?php echo esc_html( $quiz->quiz_name ); ?></option>
										<?php
									}
									?>
								</select>
							</span>
						</div>
						<button class="button-primary qsm-export-settings"><?php esc_html_e( 'Export', 'qsm-export-import' ); ?></button>
					</div>
				</div>
				<div id="postbox-container-2" class="postbox-container">
					<div id="side-sortables" class="meta-box-sortables ui-sortable">
						<form action="" method="post" enctype="multipart/form-data">
							<div class="settings-row">
								<h3 class="qsm-option-heading"><?php esc_html_e( 'Import Quiz Settings', 'qsm-export-import' ); ?></h3>
								<p><?php esc_html_e( 'Choose a file from your computer to import only the settings for your quizzes and surveys.', 'qsm-export-import' ); ?></p>
								<?php wp_nonce_field( 'option_import_settings', 'option_import_settings_nonce' ); ?>
								<label class="qsm-label-heading"><?php esc_html_e( 'Select Quiz/Survey', 'qsm-export-import' ); ?></label>
								<select name="qsm-import-options-select-quiz" class="import_select" required>
									<option value=""><?php esc_html_e( 'Select Quiz', 'qsm-export-import' ); ?></option>
									<?php
									if ( $quiz_data ) {
										foreach ( $quiz_data as $quiz ) {
											?>
											<option value="<?php echo esc_attr( $quiz->quiz_id ); ?>"><?php echo esc_html( $quiz->quiz_name ); ?></option>
											<?php
										}
									}
									?>
								</select>
							</div>
							<div class="settings-row">
								<div class="qsm-drag-drop-area">
									<label class="qsm-drag-drop-info" for="import-options-file"><span class="dashicons dashicons-upload"></span></label>
									<p class="drag-drop-info"><?php esc_html_e( 'Drop files to upload' , 'qsm-export-import'); ?></p>
									<p><?php esc_html_e( 'or' , 'qsm-export-import'); ?></p>
									<label for="import-options-file" class="button qsm-drag-drop-info"><?php esc_html_e( 'Select Files' , 'qsm-export-import'); ?></label>
									<input type="file" name="import-options-file" class="import-quizzes qsm-import-files">
								</div>
								<p><span class="dashicons dashicons-info-outline qsm-text-primary" style="color:#0065D3"></span> <?php esc_html_e( 'JSON file format supported.', 'qsm-export-import' );?></p>
							</div>
							<input type="submit" class="button-primary" value="<?php esc_html_e( 'Import', 'qsm-export-import' ); ?>" name="submit">
						</form>
					</div>
				</div>
			</div>
		</div>
		<?php
	}

	/**
	 * Generates the content for export/import addon license
	 *
	 * @since 2.0
	 * @return void
	 */
	public function qsm_addon_export_import_license_tabs_content(){
		// Load settings.
		global $mlwQuizMasterNext;
		$settings_data = wp_parse_args( get_option( 'qsm_addon_export_import_settings', array() ), array(
			'license_key' => '',
		)
		);
		$date_now = date("d-m-Y");
		$settings_data   = get_option('qsm_addon_export_import_settings', '');
		$license         = isset( $settings_data['license_key'] ) ? trim( $settings_data['license_key'] ) : '';
		$license_status  = isset( $settings_data['license_status'] ) ? $settings_data['license_status'] : '';
		if ( '' != $license && 'valid' == $license_status ) {
		?>
		<div class="qsm-license-container">
			<div class="qsm-license-header">
				<p class="qsm-heading">
					<?php esc_html_e( 'Manage License', 'qsm-export-import' ); ?>
				</p>
			</div>
			<div class='qsm-license-content'>
			<?php
				if ( (isset($settings_data['expiry_date']) && "" !== $settings_data['expiry_date']) && (isset($settings_data['last_validate']) && "" !== $settings_data['last_validate']) && strtotime($date_now) > strtotime($settings_data['expiry_date']) && strtotime($date_now) >= strtotime($settings_data['last_validate']) ) {
					$item_url = 'https://quizandsurveymaster.com/checkout/?edd_license_key='.$license.'&download_id='.QSM_IMPORT_EXPORT_ITEM;
				?>
				<div class="qsm-license-info">
					<p class='qsm-valid-msg'>
						<img class="qsm-warning" src="<?php echo esc_attr( QSM_IMPORT_EXPORT_URL . 'warning.png' ); ?>" alt="">
						<span class='qsm-msg qsm-addon-title'><b><?php esc_html_e( 'Export & Import License', 'qsm-export-import' ); ?></b></span>
						<span class='qsm-msg qsm-addon-status'>
							<?php esc_html_e( 'Your license is expired.', 'qsm-export-import' ); ?>
							<a target="_blank" href="<?php echo esc_url( $item_url ); ?>"><?php esc_html_e( 'Renew', 'qsm-export-import' ); ?></a>
						</span>
					</p>
					<a data-toggle='0' class="qsm-toggleButton" href=""><?php esc_attr_e( 'Change License', 'qsm-export-import' ); ?></a>
				</div>
			<?php } else { ?>
				<div class="qsm-license-info">
					<p class='qsm-valid-msg'>
						<span class="dashicons dashicons-yes-alt"></span>
						<span class='qsm-msg qsm-addon-title'><b><?php esc_html_e( 'Export & Import License', 'qsm-export-import' ); ?></b></span>
						<span class='qsm-msg qsm-addon-status'><?php esc_html_e( 'Valid till ', 'qsm-export-import' ); ?><?php esc_html_e( date( 'd M, Y', strtotime($settings_data['expiry_date'])), 'qsm-export-import' ); ?></span>
					</p>
					<a data-toggle='0' class="qsm-toggleButton" href=""><?php esc_attr_e( 'Change License', 'qsm-export-import' ); ?></a>
				</div>
			<?php } ?>
				<form id="qsm-license_entry" action="" method="post" style="display: none;">
					<input type="text" name="license_key" placeholder="<?php esc_html_e( 'Enter License key', 'qsm-export-import' ); ?>"/>
					<button id="qsm-validate_btn" class="button button-primary"><?php esc_html_e( 'Validate', 'qsm-export-import' ); ?></button>
					<a data-toggle='1' class="qsm-toggleButton" href=""><?php esc_html_e( 'Cancel', 'qsm-export-import' ); ?></a>
					<p class="qsm-validate-msg"></p>
				</form>
			</div>
		</div>
		<?php
		}else { ?>
			<div class="qsm-license-form-parent">
				<div class="qsm-license-header">
					<p class="qsm-heading">
						<?php esc_html_e( 'Manage License', 'qsm-export-import' ); ?>
					</p>
				</div>
				<div class="qsm_export_i_validate_parent">
					<form class="rq_validata-license" method="POST">
						<input type="text" placeholder="<?php echo esc_html("Enter your license key"); ?>" class="qsm_export_i_validate_input" name="qsm_export_i_validate_input" />
						<input value="Validate" type="submit" name="qsm_export_i_validate_button" class="qsm_export_i_validate_button button button-primary" />
					</form>
				</div>
				<div id="qsm-license_message" style="display: none; padding: 0 0 0 22px;"><p><strong class="qsm_export_i_validate_message"></strong></div>
			</div>
			<?php
		}
	}

	/**
	 * Generates the content for export/import flashcards
	 *
	 * @since 2.0
	 * @return void
	 */
	public function qsm_addon_export_import_flashcards_tabs_content(){
		?>
		<div class="postbox">
			<h2 class="hndle ui-sortable-handle"><?php esc_html_e( 'Quizzes/Surveys', 'qsm-export-import' ); ?></h2>
			<div class="inside">
				<div id="postbox-container-1" class="postbox-container">
					<div id="normal-sortables" class="meta-box-sortables ui-sortable">
						<div class="settings-row">
							<h3 class="qsm-option-heading"><?php esc_html_e( 'Export Flashcards', 'qsm-export-import' ); ?></h3>
							<?php wp_nonce_field( 'export_flashcard', 'export_flashcard_nonce' ); ?>
							<label><input type="radio" value="json" name="flashcard-export-type" class="flashcard-export-type" checked="checked" /><?php esc_html_e( 'JSON Export', 'qsm-export-import' ); ?></label>
							<label><input type="radio" value="csv" name="flashcard-export-type" class="flashcard-export-type" /><?php esc_html_e( 'CSV Export', 'qsm-export-import' ); ?></label>
						</div>
						<button class="button-primary flashcard-export-submit"><?php esc_html_e( 'Export', 'qsm-export-import' ); ?></button>
					</div>
				</div>
				<div id="postbox-container-2" class="postbox-container">
					<div id="side-sortables" class="meta-box-sortables ui-sortable">
						<form action="" method="post" enctype="multipart/form-data">
							<div class="settings-row">
								<h3 class="qsm-option-heading"><?php esc_html_e( 'Import Flashcards', 'qsm-export-import' ); ?></h3>
								<div class="qsm-drag-drop-area">
									<?php wp_nonce_field( 'import_flashcards', 'import_flashcards_nonce' ); ?>
									<label class="qsm-drag-drop-info" for="import-flashcards"><span class="dashicons dashicons-upload"></span></label>
									<input type="file" name="file-import-flashcards" class="import-quizzes qsm-import-files">
									<p class="drag-drop-info"><?php esc_html_e( 'Drop files to upload' , 'qsm-export-import'); ?></p>
									<p><?php esc_html_e( 'or' , 'qsm-export-import'); ?></p>
									<label for="import-flashcards" class="button qsm-drag-drop-info"><?php esc_html_e( 'Select Files' , 'qsm-export-import'); ?></label>
								</div>
								<p><span class="dashicons dashicons-info-outline qsm-text-primary" style="color:#0065D3"></span> <?php esc_html_e( 'CSV & JSON file format supported.', 'qsm-export-import' );?></p>
							</div>
							<input type="submit" class="button-primary" value="<?php esc_html_e( 'Import', 'qsm-export-import' ); ?>" name="submit">
						</form>
					</div>
				</div>
			</div>
		</div>
	<?php
	}

	/**
	 * import quiz function
	 *
	 * @since 2.0
	 * @return void
	 */
	public function qsm_addon_import_quiz_tabs_function( $json_file_type, $logic_table, $themes_table, $themes_settings_table, $themes_table_exists, $themes_settings_table_exists, $logic_table_exists ) {
		// If import form has been submitted.
		if ( isset( $_POST['qsm_import_quiz_nonce'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['qsm_import_quiz_nonce'] ) ), 'qsm_import_quiz' ) ) {
			// Check if import file is missing and, if so, through error.
			global $mlwQuizMasterNext, $wp_filesystem, $wpdb;
			if ( empty( $_FILES['import-quizzes'] ) ) {
				$mlwQuizMasterNext->log_manager->add( 'Error uploading QSM - Export & Import file', 'Error: File was missing!', 0, 'error' );
				$mlwQuizMasterNext->alertManager->newAlert( __( 'Error uploading file: Missing File. Please try again.', 'qsm-export-import' ), 'error' );
			} else {
				// Checks to ensure the file is of a supported mime type.
				if ( empty( $_FILES['import-quizzes']['type'] ) || ! in_array( strtolower( $_FILES['import-quizzes']['type'] ), $json_file_type ) ) {
					$mlwQuizMasterNext->log_manager->add( 'Error uploading QSM - Export & Import file', "Error: Incorrect type. Supplied type: {$_FILES['import-quizzes']['type']}", 0, 'error' );
					$mlwQuizMasterNext->alertManager->newAlert( __( 'Error uploading file: Incorrect file format. Please try again.', 'qsm-export-import' ), 'error' );
				} else {
					// Checks to make sure file does not already exist.
					if ( ! file_exists( $_FILES['import-quizzes']['tmp_name'] ) ) {
						$mlwQuizMasterNext->log_manager->add( 'Error uploading QSM - Export & Import file', 'File may possibly already exist!', 0, 'error' );
						$mlwQuizMasterNext->alertManager->newAlert( __( 'Error uploading file. Please try again.', 'qsm-export-import' ), 'error' );
					} else {

						$datafile       = $_FILES['import-quizzes']['tmp_name'];
						$upload_dir     = wp_upload_dir();
						$file           = $upload_dir['path'] . '/' . $_FILES['import-quizzes']['name'];
						$uploaded_files = move_uploaded_file( $datafile, $file );
						$actual_path    = $upload_dir['url'] . '/' . $_FILES['import-quizzes']['name'];
						// Checks if the file has been uploaded correctly.
						if ( $uploaded_files ) {
							$quiz_json_string = $wp_filesystem->get_contents( $file );
							$quiz_data        = json_decode( $quiz_json_string, true );
							$current_version = $mlwQuizMasterNext->version;
							$quiz_system     = 'system';
							if ( version_compare( $current_version, '7.0.0', '>=' ) ) {
								$quiz_system = 'quiz_system';
							}
							$quiz_imported_count = $quiz_imported_failed = 0;
							// Cycle through the quizzes and insert the quiz.
							foreach ( $quiz_data as $quiz ) {
								$new_quiz_system = 0;
								if ( isset( $quiz['system'] ) ) {
									$new_quiz_system = $quiz['system'];
								} elseif ( isset( $quiz['quiz_system'] ) ) {
									$new_quiz_system = $quiz['quiz_system'];
								}
								$results = $wpdb->insert(
									$wpdb->prefix . 'mlw_quizzes',
									array(
										'quiz_name'        => $quiz['quiz_name'],
										'message_before'   => $quiz['message_before'],
										'message_after'    => $quiz['message_after'],
										'message_comment'  => $quiz['message_comment'],
										'message_end_template' => $quiz['message_end_template'],
										'user_email_template' => $quiz['user_email_template'],
										'admin_email_template' => $quiz['admin_email_template'],
										'submit_button_text' => $quiz['submit_button_text'],
										'name_field_text'  => $quiz['name_field_text'],
										'business_field_text' => $quiz['business_field_text'],
										'email_field_text' => $quiz['email_field_text'],
										'phone_field_text' => $quiz['phone_field_text'],
										'comment_field_text' => $quiz['comment_field_text'],
										'email_from_text'  => $quiz['email_from_text'],
										'question_answer_template' => $quiz['question_answer_template'],
										'leaderboard_template' => $quiz['leaderboard_template'],
										$quiz_system       => $new_quiz_system,
										'randomness_order' => $quiz['randomness_order'],
										'loggedin_user_contact' => $quiz['loggedin_user_contact'],
										'show_score'       => $quiz['show_score'],
										'send_user_email'  => $quiz['send_user_email'],
										'send_admin_email' => $quiz['send_admin_email'],
										'contact_info_location' => $quiz['contact_info_location'],
										'user_name'        => $quiz['user_name'],
										'user_comp'        => $quiz['user_comp'],
										'user_email'       => $quiz['user_email'],
										'user_phone'       => $quiz['user_phone'],
										'admin_email'      => $quiz['admin_email'],
										'comment_section'  => $quiz['comment_section'],
										'question_from_total' => $quiz['question_from_total'],
										'total_user_tries' => $quiz['total_user_tries'],
										'total_user_tries_text' => $quiz['total_user_tries_text'],
										'certificate_template' => $quiz['certificate_template'],
										'social_media'     => $quiz['social_media'],
										'social_media_text' => $quiz['social_media_text'],
										'pagination'       => $quiz['pagination'],
										'pagination_text'  => $quiz['pagination_text'],
										'timer_limit'      => $quiz['timer_limit'],
										'quiz_stye'        => $quiz['quiz_stye'],
										'question_numbering' => $quiz['question_numbering'],
										'quiz_settings'    => $quiz['quiz_settings'],
										'theme_selected'   => $quiz['theme_selected'],
										'last_activity'    => date( 'Y-m-d H:i:s' ),
										'require_log_in'   => $quiz['require_log_in'],
										'require_log_in_text' => $quiz['require_log_in_text'],
										'limit_total_entries' => $quiz['limit_total_entries'],
										'limit_total_entries_text' => $quiz['limit_total_entries_text'],
										'scheduled_timeframe' => $quiz['scheduled_timeframe'],
										'scheduled_timeframe_text' => $quiz['scheduled_timeframe_text'],
										'quiz_views'       => $quiz['quiz_views'],
										'quiz_taken'       => $quiz['quiz_taken'],
										'deleted'          => 0,
									),
									array(
										'%s',
										'%s',
										'%s',
										'%s',
										'%s',
										'%s',
										'%s',
										'%s',
										'%s',
										'%s',
										'%s',
										'%s',
										'%s',
										'%s',
										'%s',
										'%s',
										'%d',
										'%d',
										'%d',
										'%d',
										'%d',
										'%d',
										'%d',
										'%d',
										'%d',
										'%d',
										'%d',
										'%s',
										'%d',
										'%d',
										'%d',
										'%s',
										'%s',
										'%d',
										'%s',
										'%d',
										'%s',
										'%d',
										'%s',
										'%d',
										'%s',
										'%s',
										'%s',
										'%d',
										'%s',
										'%d',
										'%s',
										'%s',
										'%s',
										'%d',
										'%d',
										'%d',
									)
								);
								if ( false === $results ) {
									$quiz_imported_failed++;
									$mlwQuizMasterNext->log_manager->add( 'Error uploading QSM - Export & Import file', $wpdb->last_error . ' from ' . $wpdb->last_query . ' quiz name:' . $quiz['quiz_name'], 0, 'error' );
								} else {

									// Create quiz post for inserted quiz.
									$new_quiz     = $wpdb->insert_id;
									$current_user = wp_get_current_user();
									$quiz_post    = array(
										'post_title'   => $quiz['quiz_name'],
										'post_content' => "[mlw_quizmaster quiz=$new_quiz]",
										'post_status'  => 'publish',
										'post_author'  => $current_user->ID,
										'post_type'    => 'qsm_quiz',
									);
									$quiz_post_id = wp_insert_post( $quiz_post );
									add_post_meta( $quiz_post_id, 'quiz_id', $new_quiz );
									$quiz_imported_count++;
									$mlwQuizMasterNext->audit_manager->new_audit( "New Quiz Has Been Imported: {$quiz["quiz_name"]}", intval( $quiz['quiz_id'] ), '' );
									// do_action('qmn_quiz_created', $new_quiz);

									// add qsm_featured_image if exists.
									if ( isset( $quiz['featured_image'] ) ) {
										update_option( 'quiz_featured_image_' . $new_quiz, $quiz['featured_image'] );
									}

									// if theme table exists add theme data is found in export.
									if ( isset( $quiz['themes'] ) && $themes_table_exists && $themes_settings_table_exists ) {
										$exported_themes = maybe_unserialize( $quiz['themes'] );
										$query           = "SELECT id, theme from $themes_table";
										$themes          = $wpdb->get_results( $query, ARRAY_A );
										if ( ! empty( $themes ) ) {
											foreach ( $themes as $theme ) {
												$key = array_search( $theme['theme'], array_column( $exported_themes, 0 ) );
												if ( false !== $key ) {
													$wpdb->insert(
														$themes_settings_table,
														array(
															'theme_id'              => $theme['id'],
															'quiz_id'               => $new_quiz,
															'quiz_theme_settings'   => $exported_themes[ $key ][1],
															'active_theme'          => $exported_themes[ $key ][2],
														),
														array( '%d', '%d', '%s', '%d' )
													);
												}
											}
										}
									}

									// Update quiz settings.
									$update_quiz_settings = maybe_unserialize( $quiz['quiz_settings'] );
									$update_pages         = maybe_unserialize( $update_quiz_settings['pages'] );
									$update_q_pages       = maybe_unserialize( $update_quiz_settings['qpages'] );
									if ( isset( $quiz['logic'] ) ) {
										$logic_rules = maybe_unserialize( $quiz['logic'] );
									} else {
										$logic_rules = isset( $update_quiz_settings['logic_rules'] ) ? maybe_unserialize( maybe_unserialize( $update_quiz_settings['logic_rules'] ) ) : array();
									}
									$no_pages_included = false;

									// Cycle through each question for the quiz and insert question.
									$quiz['questions'] = isset( $quiz['questions'] ) && is_array( $quiz['questions'] ) ? $quiz['questions'] : json_decode( $quiz['questions'], true );
									foreach ( $quiz['questions'] as $question ) {
										if ( version_compare( $current_version, '6.4.12', '>=' ) ) {
											if ( 'fill-in-the-blank' == $question['question_type_new'] ) {
												$question['question_type_new'] = '14';
											}
										}
										$results            = $wpdb->insert(
											$wpdb->prefix . 'mlw_questions',
											array(
												'quiz_id'  => $new_quiz,
												'question_name' => $question['question_name'],
												'answer_array' => $question['answer_array'],
												'answer_one' => $question['answer_one'],
												'answer_one_points' => $question['answer_one_points'],
												'answer_two' => $question['answer_two'],
												'answer_two_points' => $question['answer_two_points'],
												'answer_three' => $question['answer_three'],
												'answer_three_points' => $question['answer_three_points'],
												'answer_four' => $question['answer_four'],
												'answer_four_points' => $question['answer_four_points'],
												'answer_five' => $question['answer_five'],
												'answer_five_points' => $question['answer_five_points'],
												'answer_six' => $question['answer_six'],
												'answer_six_points' => $question['answer_six_points'],
												'correct_answer' => $question['correct_answer'],
												'question_answer_info' => $question['question_answer_info'],
												'comments' => $question['comments'],
												'hints'    => $question['hints'],
												'question_order' => $question['question_order'],
												'question_type_new' => $question['question_type_new'],
												'question_settings' => $question['question_settings'],
												'category' => $question['category'],
												'deleted'  => $question['deleted'],
											),
											array(
												'%d',
												'%s',
												'%s',
												'%s',
												'%d',
												'%s',
												'%d',
												'%s',
												'%d',
												'%s',
												'%d',
												'%s',
												'%d',
												'%s',
												'%d',
												'%d',
												'%s',
												'%d',
												'%s',
												'%d',
												'%s',
												'%s',
												'%s',
												'%d',
											)
										);
										$questionID = $wpdb->insert_id;
										foreach ( $update_pages as $pages_key => $pages_value ) {
											foreach ( $pages_value as $pages_k_q => $page_q_id ) {
												if ( $page_q_id == $question['question_id'] ) {
													$update_pages[ $pages_key ][ $pages_k_q ] = $questionID;
													$update_q_pages[ $pages_key ]['questions'][ $pages_k_q ] = $questionID;
												}
											}
										}
										if ( empty( $update_pages ) || true == $no_pages_included ) {
											$no_pages_included = true;
											$update_pages[0][] = $questionID;
										}
										// Fixed Rules Questions with new question ids
										if ( $logic_rules ) {
											foreach ( $logic_rules as $logic_key => $logic_value ) {
												foreach ( $logic_value as $logic_cond_k => $logic_cond ) {
													foreach ( $logic_cond as $l_cond_k => $logic_val ) {
														if ( $logic_val['question'] == $question['question_id'] ) {
															$logic_rules[ $logic_key ][ $logic_cond_k ][ $l_cond_k ]['question'] = $questionID;
														}
													}
												}
											}
										}

										if ( isset( $question['multicategoriesobject'] ) && ! empty( $question['multicategoriesobject'] ) ) {
											foreach ( $question['multicategoriesobject'] as $category ) {
												$term_data = get_term_by( 'name', sanitize_text_field( $category['name'] ), 'qsm_category' );
												if ( $term_data ) {
													$patent_term_id = $term_data->term_id;
												} else {
													$term_array     = wp_insert_term( sanitize_text_field( $category['name'] ), 'qsm_category' );
													$patent_term_id = $term_array['term_id'];
												}
												$values_array[] = "($questionID, $new_quiz, $patent_term_id, 'qsm_category')";
												if ( ! empty( $category['children'] ) ) {
													foreach ( $category['children'] as $subcategory ) {
														$sub_term_data = get_term_by( 'name', sanitize_text_field( $subcategory['name'] ), 'qsm_category' );
														if ( $sub_term_data ) {
															$term_id = $sub_term_data->term_id;
														} else {
															$term_array = wp_insert_term( sanitize_text_field( $subcategory['name'] ), 'qsm_category', array( 'parent' => $patent_term_id ) );
															$term_id    = $term_array['term_id'];
														}
														$values_array[] = "($questionID, $new_quiz, $term_id, 'qsm_category')";
													}
												}
											}
											if ( ! empty( $values_array ) ) {
												$values       = join( ',', array_unique( $values_array ) );
												$insert_query = stripslashes( $wpdb->prepare( "INSERT INTO {$wpdb->prefix}mlw_question_terms (question_id, quiz_id, term_id, taxonomy) VALUES %1s", $values ) );
												$termresult   = $wpdb->query( $insert_query );
											}
										}
										if ( false === $results ) {
											$mlwQuizMasterNext->log_manager->add( 'Error uploading QSM - Export & Import file', $wpdb->last_error . ' from ' . $wpdb->last_query, 0, 'error' );
										}
									}
									$update_quiz_settings['pages'] = maybe_serialize( $update_pages );
									$update_quiz_settings['qpages'] = maybe_serialize( $update_q_pages );

									// insert logic data in logic table if exists.
									if ( $logic_table_exists ) {
										$value_array = array();
										foreach ( $logic_rules as $logic_data ) {
											$data          = array(
												$new_quiz,
												maybe_serialize( $logic_data ),
											);
											$value_array[] = stripslashes( $wpdb->prepare( '(%d, %s)', $data ) );
										}
										$values = implode( ',', $value_array );
										if ( ! empty($values) ) {
											$query  = "INSERT INTO $logic_table (quiz_id, logic) VALUES $values";
											$saved  = $wpdb->query( $query );
											if ( $saved ) {
												update_option( "logic_rules_quiz_$new_quiz", date( time() ) );
											}
										}
									} else {
										$update_quiz_settings['logic_rules'] = maybe_serialize( maybe_serialize( $logic_rules ) );
									}

									$wpdb->update(
										$wpdb->prefix . 'mlw_quizzes',
										array(
											'quiz_settings' => maybe_serialize( $update_quiz_settings ),
										),
										array(
											'quiz_id' => $new_quiz,
										)
									);
									unlink( $file );
								}
							}
							if ( $quiz_imported_failed ) {
								$mlwQuizMasterNext->alertManager->newAlert( __(  'Error! ' . $quiz_imported_count . 'quiz/survey importing failed!', 'qsm-export-import' ), 'error' );
							}
							if ( $quiz_imported_count ) {
								$mlwQuizMasterNext->alertManager->newAlert( __( $quiz_imported_count . ' quiz/survey has been imported successfully!', 'qsm-export-import' ), 'success' );
							}
						} else {
							$mlwQuizMasterNext->log_manager->add( 'Error uploading QSM - Export & Import file', "Error from wp_handle_upload: {$import_file['error']}", 0, 'error' );
							$mlwQuizMasterNext->alertManager->newAlert( __( 'Error uploading file. Please try again.', 'qsm-export-import' ), 'error' );
						}
					}
				}
			}
		}
	}

	/**
	 * import quiz settings function
	 *
	 * @since 2.0
	 * @return void
	 */
	public function qsm_addon_import_settings_tabs_function( $json_file_type, $logic_table, $themes_table, $themes_settings_table, $themes_table_exists, $themes_settings_table_exists, $logic_table_exists ) {
		// If import form has been submitted.
		if ( isset( $_POST['option_import_settings_nonce'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['option_import_settings_nonce'] ) ), 'option_import_settings' ) ) {
			// Check if import file is missing and, if so, through error.
			global $mlwQuizMasterNext, $wp_filesystem, $wpdb;
			if ( empty( $_FILES['import-options-file'] ) ) {
				$mlwQuizMasterNext->log_manager->add( 'Error uploading QSM - Export & Import file', 'Error: File was missing!', 0, 'error' );
				$mlwQuizMasterNext->alertManager->newAlert( __( 'Error uploading file: Missing File. Please try again.', 'qsm-export-import' ), 'error' );
			} else {
				// Checks to ensure the file is of a supported mime type.
				if ( empty( $_FILES['import-options-file']['type'] ) || ! in_array( strtolower( $_FILES['import-options-file']['type'] ), $json_file_type ) ) {
					$mlwQuizMasterNext->log_manager->add( 'Error uploading QSM - Export & Import file', "Error: Incorrect type. Supplied type: {$_FILES['import-options-file']['type']}", 0, 'error' );
					$mlwQuizMasterNext->alertManager->newAlert( __( 'Error uploading file: Incorrect file format. Please try again.', 'qsm-export-import' ), 'error' );
				} else {
					// Checks to make sure file does not already exist.
					if ( ! file_exists( $_FILES['import-options-file']['tmp_name'] ) ) {
						$mlwQuizMasterNext->log_manager->add( 'Error uploading QSM - Export & Import file', 'File may possibly already exist!', 0, 'error' );
						$mlwQuizMasterNext->alertManager->newAlert( __( 'Error uploading file. Please try again.', 'qsm-export-import' ), 'error' );
					} else {
						$datafile       = $_FILES['import-options-file']['tmp_name'];
						$upload_dir     = wp_upload_dir();
						$file           = $upload_dir['path'] . '/' . $_FILES['import-options-file']['name'];
						$uploaded_files = move_uploaded_file( $datafile, $file );
						$actual_path    = $upload_dir['url'] . '/' . $_FILES['import-options-file']['name'];
						// Checks if the file has been uploaded correctly.
						if ( $uploaded_files ) {
							$quiz_json_string = $wp_filesystem->get_contents( $file );
							$quiz_json_data        = json_decode( $quiz_json_string, true );
							$quiz_id = ! empty( $_POST['qsm-import-options-select-quiz'] ) ? sanitize_text_field( wp_unslash( $_POST['qsm-import-options-select-quiz'] ) ) : "";
							$quiz_data = $wpdb->get_row( $wpdb->prepare( "SELECT quiz_settings FROM {$wpdb->prefix}mlw_quizzes WHERE deleted = 0 AND quiz_id = %d", $quiz_id ), ARRAY_A );
							// Cycle through the quizzes and insert the quiz.
							if ( ! empty( $quiz_data['quiz_settings'] ) ) {
								$quiz_settings = maybe_unserialize( $quiz_data['quiz_settings'] );
								if ( ! empty( $quiz_json_data['quiz_options'] ) ) {
									$quiz_settings['quiz_options'] = $quiz_json_data['quiz_options'];
								}
								if ( ! empty( $quiz_json_data['contact_form'] ) ) {
									$quiz_settings['contact_form'] = $quiz_json_data['contact_form'];
								}
								if ( ! empty( $quiz_json_data['quiz_text'] ) ) {
									$quiz_settings['quiz_text'] = $quiz_json_data['quiz_text'];
								}
								// Saves the new css.
								$results = $wpdb->query( $wpdb->prepare( "UPDATE {$wpdb->prefix}mlw_quizzes SET quiz_settings=%s, last_activity=%s WHERE quiz_id=%d", maybe_serialize( $quiz_settings ), gmdate( 'Y-m-d H:i:s' ), $quiz_id ) );
								if ( false !== $results ) {
									if ( ! empty( $quiz_json_data['quiz_theme_settings'] ) ) {
										$theme_exists = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM {$wpdb->prefix}mlw_themes WHERE theme_active = 1  AND   id = %d", $quiz_json_data['theme_id'] ), ARRAY_A );
										if ( empty( $theme_exists ) ) {
											$mlwQuizMasterNext->alertManager->newAlert( __( 'Please activate the theme before importing.', 'qsm-export-import' ), 'error' );
										} else {
											$quiz_theme_settings['quiz_theme_settings'] = $quiz_json_data['quiz_theme_settings'];
											$themeID = $quiz_json_data['theme_id'];
											if(isset( $quiz_json_data['theme'] ) && '' != $quiz_json_data['theme']){
												$theme_settings = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM {$wpdb->prefix}mlw_themes WHERE theme = %s", $quiz_json_data['theme']), ARRAY_A );
												$themeID = $theme_settings['id'] ? $theme_settings['id'] : $quiz_json_data['theme_id'];
											}
											$theme = $wpdb->query( $wpdb->prepare( "UPDATE {$wpdb->prefix}mlw_quiz_theme_settings SET quiz_theme_settings=%s, theme_id=%d WHERE quiz_id=%d  AND active_theme=%d", $quiz_theme_settings['quiz_theme_settings'], $themeID, $quiz_id,1 ) );
											if ( false !== $theme ) {
												$mlwQuizMasterNext->alertManager->newAlert( __( 'The file has been imported successfully.', 'qsm-export-import' ), 'success' );
												$mlwQuizMasterNext->theme_settings->activate_selected_theme( $quiz_id, $themeID );
												if(isset( $quiz_json_data['quiz_css'] ) && '' != $quiz_json_data['quiz_css'] ) {
													$quiz_style = isset( $quiz_json_data['quiz_css'] ) ? htmlspecialchars( preg_replace( '#<script(.*?)>(.*?)</script>#is', '', sanitize_textarea_field( wp_unslash( $quiz_json_data['quiz_css'] ) ) ), ENT_QUOTES, 'UTF-8', false ) : '';
													$wpdb->query( $wpdb->prepare( "UPDATE {$wpdb->prefix}mlw_quizzes SET quiz_stye=%s WHERE quiz_id=%d", $quiz_style, $quiz_id ) );
												}
											}
										}
									} else {
										$mlwQuizMasterNext->alertManager->newAlert( __( 'The file has been imported successfully.', 'qsm-export-import' ), 'success' );
										$theme_id    = isset( $quiz_json_data['quiz_theme_id'] ) ? intval( $quiz_json_data['quiz_theme_id'] ) : 0;
										if(isset( $quiz_json_data['quiz_css']) && '' != $quiz_json_data['quiz_css'] ) {
											$quiz_style = isset( $quiz_json_data['quiz_css'] ) ? htmlspecialchars( preg_replace( '#<script(.*?)>(.*?)</script>#is', '', sanitize_textarea_field( wp_unslash( $quiz_json_data['quiz_css'] ) ) ), ENT_QUOTES, 'UTF-8', false ) : '';
											$wpdb->query( $wpdb->prepare( "UPDATE {$wpdb->prefix}mlw_quizzes SET quiz_stye=%s WHERE quiz_id=%d", $quiz_style, $quiz_id ) );
										}
									}
								} else {
									$mlwQuizMasterNext->alertManager->newAlert( __( 'Error occured when trying to save the files. Please try again.', 'qsm-export-import' ), 'error' );
									$mlwQuizMasterNext->log_manager->add( 'Error saving styles', $wpdb->last_error . ' from ' . $wpdb->last_query, 0, 'error' );
								}
							}else {
								$mlwQuizMasterNext->alertManager->newAlert( __( 'Quiz data not found!. Please try again.', 'qsm-export-import' ), 'error' );
							}
						} else {
							$mlwQuizMasterNext->log_manager->add( 'Error uploading QSM - Export & Import file', "Error from wp_handle_upload: {$import_file['error']}", 0, 'error' );
							$mlwQuizMasterNext->alertManager->newAlert( __( 'Error uploading file. Please try again.', 'qsm-export-import' ), 'error' );
						}
					}
				}
			}
		}
	}

	/**
	 * import questions function
	 *
	 * @since 2.0
	 * @return void
	 */
	public function qsm_addon_import_question_tabs_function( $accepted_mime_types, $json_file_type, $logic_table, $themes_table, $themes_settings_table, $themes_table_exists, $themes_settings_table_exists, $logic_table_exists ) {
		// If import form has been submitted.
		if ( isset( $_POST['qsm_import_questions_nonce'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['qsm_import_questions_nonce'] ) ), 'qsm_import_questions' ) ) {
			// Check if import file is missing and, if so, through error.
			global $mlwQuizMasterNext, $wp_filesystem, $wpdb;
			if ( empty( $_FILES['import-questions'] ) ) {
				$mlwQuizMasterNext->log_manager->add( 'Error uploading QSM - Export & Import file', 'Error: File was missing!', 0, 'error' );
				$mlwQuizMasterNext->alertManager->newAlert( __( 'Error uploading file: Missing File. Please try again.', 'qsm-export-import' ), 'error' );
			} else {
				// Checks to ensure the file is of a supported mime type.
				if ( empty( $_FILES['import-questions']['type'] ) || ! in_array( strtolower( $_FILES['import-questions']['type'] ), $accepted_mime_types ) ) {
					$mlwQuizMasterNext->log_manager->add( 'Error uploading QSM - Export & Import file', "Error: Incorrect type. Supplied type: {$_FILES['import-questions']['type']}", 0, 'error' );
					$mlwQuizMasterNext->alertManager->newAlert( __( 'Error uploading file: Incorrect file format. Please try again.', 'qsm-export-import' ), 'error' );
				} else {
					// Checks to make sure file does not already exist.
					if ( ! file_exists( $_FILES['import-questions']['tmp_name'] ) ) {
						$mlwQuizMasterNext->log_manager->add( 'Error uploading QSM - Export & Import file', 'File may possibly already exist!', 0, 'error' );
						$mlwQuizMasterNext->alertManager->newAlert( __( 'Error uploading file. Please try again.', 'qsm-export-import' ), 'error' );
					} else {
						// Let WordPress import the file. We will remove it after import is complete
						$datafile       = $_FILES['import-questions']['tmp_name'];
						$upload_dir     = wp_upload_dir();
						$file           = $upload_dir['path'] . '/' . $_FILES['import-questions']['name'];
						$uploaded_files = move_uploaded_file( $datafile, $file );
						$actual_path    = $upload_dir['url'] . '/' . $_FILES['import-questions']['name'];
						$quiz_question_ids = $question_data = $fields = array();
						$quiz_id = ! empty( $_POST['qsm-import-select-quiz'] ) ? sanitize_text_field( wp_unslash( $_POST['qsm-import-select-quiz'] ) ) : "";
						// Checks if the file has been uploaded correctly.
						if ( $uploaded_files ) {
							if ( in_array( $_FILES['import-questions']['type'], $json_file_type ) ) {
								$quiz_json_string = $wp_filesystem->get_contents( $file );
								$question_data        = json_decode( $quiz_json_string, true );
							} else {
								$handle    = @fopen( $file, 'rb' );
								if ( $handle ) {
									// Skip BOM if present
									$bom = fread($handle, 3);
									if ($bom !== "\xEF\xBB\xBF") {
										rewind($handle);
									}
									$old_question_id = $question_index = $answer_index = 0;
									while ( ( $row = fgetcsv( $handle, 4096 ) ) !== false ) {
										foreach ( $row as $k => $value ) {
											if (!mb_detect_encoding($value, 'UTF-8', true)) {
												$row[$k] = mb_convert_encoding($value, 'UTF-8');
											}
										}
										if ( empty( $fields ) ) {
											$fields = $row;
											continue;
										}
										if ( 'Question' === $row[0] ) {
											$question_index++;
											foreach ( $row as $k => $value ) {
												if ( isset( $fields[ $k ] ) ) {
													$k_eky                     = strtolower( str_replace( ' ', '_', $fields[ $k ] ) );
													if ( 'question_id' === $k_eky ) {
														$question_data[0][ $question_index ]['question_id'] = $value;
													}elseif ( 'question_description' === $k_eky ) {
														$question_data[0][ $question_index ]['question_name'] = str_replace('\\n', "\n", esc_sql( $value ) );
													}elseif ( 'required' === $k_eky || 'case_sensitive' === $k_eky || 'question_title' === $k_eky || 'answer_columns' === $k_eky || 'autofill' === $k_eky || 'limit_text' === $k_eky || 'limit_multiple_response' === $k_eky || 'file_upload_limit' === $k_eky || 'file_upload_type' === $k_eky || 'image_size-width' === $k_eky || 'image_size-height' === $k_eky ) {
														if( 'required' === $k_eky ){
															$value = 1 === intval( $value ) ? 0 : 1;
														}
														if( 'question_title' === $k_eky ){
															$question_data[0][ $question_index ]['question_settings'][ $k_eky ] = stripslashes( esc_sql( $value ) );
														}else{
															$question_data[0][ $question_index ]['question_settings'][ $k_eky ] = $value;
														}
													}elseif ( 'answer_editor' === $k_eky ) {
														$question_data[0][ $question_index ]['question_settings']['answerEditor'] = $value;
													}elseif ( 'feature_image_src' === $k_eky ) {
														$question_data[0][ $question_index ]['question_settings']['featureImageSrc'] = $value;
														if ( ! empty( $value ) ) {
															if ( attachment_url_to_postid( $value ) ) {
																$question_data[0][ $question_index ]['question_settings']['featureImageID'] = attachment_url_to_postid( $value );
															}else {
																$upload_dir = wp_upload_dir();
																global $wp_filesystem;
																require_once ( ABSPATH . '/wp-admin/includes/file.php' );
																WP_Filesystem();
																$image_data = $wp_filesystem->get_contents( $value );

																$filename = basename( $value );

																if ( wp_mkdir_p( $upload_dir['path'] ) ) {
																	$file = $upload_dir['path'] . '/' . $filename;
																}else {
																	$file = $upload_dir['basedir'] . '/' . $filename;
																}
																global $wp_filesystem;
																if ( empty( $wp_filesystem ) ) {
																	require_once ABSPATH . 'wp-admin/includes/file.php';
																}
																WP_Filesystem();
																$wp_filesystem->put_contents( $file, $image_data, 0644);

																$wp_filetype = wp_check_filetype( $filename, null );

																$attachment = array(
																	'post_mime_type' => $wp_filetype['type'],
																	'post_title' => sanitize_file_name( $filename ),
																	'post_content' => '',
																	'post_status' => 'inherit',
																);

																$attach_id = wp_insert_attachment( $attachment, $file );
																if ( $attach_id ) {
																	require_once( ABSPATH . 'wp-admin/includes/image.php' );
																	$attach_data = wp_generate_attachment_metadata( $attach_id, $file );
																	wp_update_attachment_metadata( $attach_id, $attach_data );
																	$question_data[0][ $question_index ]['question_settings']['featureImageID'] = $attach_id;
																}
															}
														}
													}elseif ( 'match_answer' === $k_eky ) {
														$question_data[0][ $question_index ]['question_settings']['matchAnswer'] = $value;
													}elseif ( 'categories' === $k_eky && ! empty( $value ) ) {
														$categories = explode(",", $value);
														foreach ( $categories as $category ) {
															$term_data = get_term_by( 'name', sanitize_text_field( $category ), 'qsm_category' );
															if ( $term_data ) {
																$question_data[0][ $question_index ]['multicategoriesobject'][] = (array) $term_data;
															} else {
																$term_array     = wp_insert_term( sanitize_text_field( $category ), 'qsm_category' );
																$term_array['name'] = $category;
																$question_data[0][ $question_index ]['multicategoriesobject'][] = $term_array;
															}
														}
													}else {
														$question_data[0][ $question_index ][ $k_eky ] = $value;
													}
												}
											}
											$question_data[0][ $question_index ]['question_settings'] = maybe_serialize( $question_data[0][ $question_index ]['question_settings'] );
										}elseif ( 'Answer' === $row[0] ) {
											if ( ! empty( $old_question_id ) && $old_question_id != $question_index ) {
												$answer_index = 0;
												$question_data[0][ $old_question_id ]['answer_array'] = maybe_serialize( $question_data[0][ $old_question_id ]['answer_array'] );
											}
											foreach ( $row as $k => $value ) {
												if ( isset( $fields[ $k ] ) ) {
													$k_eky                     = strtolower( str_replace( ' ', '_', $fields[ $k ] ) );
													if ( 'answer_text' === $k_eky ) {
														$question_data[0][ $question_index ]['answer_array'][ $answer_index ][0] = $value;
													}elseif ( 'answer_point' === $k_eky ) {
														$question_data[0][ $question_index ]['answer_array'][ $answer_index ][1] = $value;
													}elseif ( 'answer_correct/incorrect' === $k_eky ) {
														$question_data[0][ $question_index ]['answer_array'][ $answer_index ][2] = $value;
													}elseif ( 'answer_caption' === $k_eky ) {
														$question_data[0][ $question_index ]['answer_array'][ $answer_index ][3] = $value;
													}elseif ( 'answer_label' === $k_eky ) {
														$question_data[0][ $question_index ]['answer_array'][ $answer_index ]['label'] = $value;
													}
												}
											}
											$answer_index++;
											$old_question_id = $question_index;
										}
									}
								}
								$question_data[0][ $old_question_id ]['answer_array'] = maybe_serialize( $question_data[0][ $old_question_id ]['answer_array'] );
								fclose($handle);
							}
							$question_imported = 0;
							if (!is_array($question_data)) {
								$question_data = array();
							}
							foreach ( $question_data as $questions ) {
								if (!is_array($questions)) {
									continue;
								}
								foreach ( $questions as $id => $question ) {
									$existing_question = array();
									if ( ! empty( $question['question_id'] ) ) {
										$existing_question = $wpdb->get_row(
											$wpdb->prepare(
												"SELECT * FROM {$wpdb->prefix}mlw_questions WHERE question_id = %d AND quiz_id = %d",
												$question['question_id'],
												$quiz_id
											),
											ARRAY_A
										);
									}

									// Prepare data for insertion or update
									$data = array(
										'quiz_id'      			=> $quiz_id,
										'question_name' 		=> ! empty( $question['question_name'] ) ? $question['question_name'] : "",
										'answer_array' 			=> ! empty( $question['answer_array'] ) ? $question['answer_array'] : "",
										'answer_one'   			=> ! empty( $question['answer_one'] ) ? $question['answer_one'] : "",
										'answer_one_points' 	=> ! empty( $question['answer_one_points'] ) ? $question['answer_one_points'] : "",
										'answer_two'   			=> ! empty( $question['answer_two'] ) ? $question['answer_two'] : "",
										'answer_two_points' 	=> ! empty( $question['answer_two_points'] ) ? $question['answer_two_points'] : "",
										'answer_three' 			=> ! empty( $question['answer_three'] ) ? $question['answer_three'] : "",
										'answer_three_points' 	=> ! empty( $question['answer_three_points'] ) ? $question['answer_three_points'] : "",
										'answer_four'  			=> ! empty( $question['answer_four'] ) ? $question['answer_four'] : "",
										'answer_four_points' 	=> ! empty( $question['answer_four_points'] ) ? $question['answer_four_points'] : "",
										'answer_five'  			=> ! empty( $question['answer_five'] ) ? $question['answer_five'] : "",
										'answer_five_points' 	=> ! empty( $question['answer_five_points'] ) ? $question['answer_five_points'] : "",
										'answer_six'   			=> ! empty( $question['answer_six'] ) ? $question['answer_six'] : "",
										'answer_six_points' 	=> ! empty( $question['answer_six_points'] ) ? $question['answer_six_points'] : "",
										'correct_answer' 		=> ! empty( $question['correct_answer'] ) ? $question['correct_answer'] : "",
										'question_answer_info' 	=> ! empty( $question['question_answer_info'] ) ? $question['question_answer_info'] : "",
										'comments'     			=> ! empty( $question['comments'] ) ? $question['comments'] : 1,
										'hints'        			=> ! empty( $question['hints'] ) ? $question['hints'] : "",
										'question_order' 		=> ! empty( $question['question_order'] ) ? $question['question_order'] : "",
										'question_type_new' 	=> ! empty( $question['question_type_new'] ) ? qsm_addon_import_export_question_type_int_str( $question['question_type_new'], 'int' ) : 0,
										'question_settings' 	=> ! empty( $question['question_settings'] ) ? $question['question_settings'] : "",
										'category'     			=> ! empty( $question['category'] ) ? $question['category'] : "",
									);
									if ( $existing_question ) {
										$update_results  = $wpdb->update(
											$wpdb->prefix . 'mlw_questions',
											$data,
											array( 'question_id' => $question['question_id'], 'quiz_id' => $quiz_id ),
											// Define data format for %d and %s placeholders
											array(
												'%d',
												'%s',
												'%s',
												'%s',
												'%d',
												'%s',
												'%d',
												'%s',
												'%d',
												'%s',
												'%d',
												'%s',
												'%d',
												'%s',
												'%d',
												'%d',
												'%s',
												'%d',
												'%s',
												'%d',
												'%s',
												'%s',
												'%s',
											),
											// Define data format for WHERE clause placeholders
											array(
												'%d',
												'%d',
											)
										);
										$questionID = $question['question_id'];
										$quiz_question_ids[] = $questionID;
										if ( false === $update_results ) {
											$mlwQuizMasterNext->log_manager->add( 'Error uploading QSM - Export & Import file', $wpdb->last_error . ' from ' . $wpdb->last_query, 0, 'error' );
										}else {
											$question_imported++;
										}
									} else {
										$results  = $wpdb->insert(
											$wpdb->prefix . 'mlw_questions',
											$data,
											array(
												'%d',
												'%s',
												'%s',
												'%s',
												'%d',
												'%s',
												'%d',
												'%s',
												'%d',
												'%s',
												'%d',
												'%s',
												'%d',
												'%s',
												'%d',
												'%d',
												'%s',
												'%d',
												'%s',
												'%d',
												'%s',
												'%s',
												'%s',
											)
										);
										$questionID = $wpdb->insert_id;
										$quiz_question_ids[] = $questionID;
										if ( false === $results ) {
											$mlwQuizMasterNext->log_manager->add( 'Error uploading QSM - Export & Import file', $wpdb->last_error . ' from ' . $wpdb->last_query, 0, 'error' );
										}else {
											$question_imported++;
										}
									}
									if ( isset( $question['multicategoriesobject'] ) && ! empty( $question['multicategoriesobject'] ) ) {
										foreach ( $question['multicategoriesobject'] as $category ) {
											$term_data = get_term_by( 'name', sanitize_text_field( $category['name'] ), 'qsm_category' );
											if ( $term_data ) {
												$patent_term_id = $term_data->term_id;
											} else {
												$term_array     = wp_insert_term( sanitize_text_field( $category['name'] ), 'qsm_category' );
												$patent_term_id = $term_array['term_id'];
											}
											$values_array[] = "($questionID, $quiz_id, $patent_term_id, 'qsm_category')";
											if ( ! empty( $category['children'] ) ) {
												foreach ( $category['children'] as $subcategory ) {
													$sub_term_data = get_term_by( 'name', sanitize_text_field( $subcategory['name'] ), 'qsm_category' );
													if ( $sub_term_data ) {
														$term_id = $sub_term_data->term_id;
													} else {
														$term_array = wp_insert_term( sanitize_text_field( $subcategory['name'] ), 'qsm_category', array( 'parent' => $patent_term_id ) );
														$term_id    = $term_array['term_id'];
													}
													$values_array[] = "($questionID, $quiz_id, $term_id, 'qsm_category')";
												}
											}
										}
										if ( isset( $update_results ) && $update_results ) {
											$delete_term = $wpdb->delete(
												$wpdb->prefix . 'term_relationships',
												array(
													'object_id' => intval($questionID),
												),
												array(
													'%d',
												)
											);
											$delete_question_terms = $wpdb->delete(
												$wpdb->prefix . 'mlw_question_terms',
												array(
													'question_id' => intval($questionID),
												),
												array(
													'%d',
												)
											);
											// Check if deletion was successful
											if ( false === $delete_term || false === $delete_question_terms ) {
												error_log( 'Error deleting term relationships: ' . $wpdb->last_error );
											}
										}
										if ( ! empty( $values_array ) ) {
											$values       = join( ',', array_unique( $values_array ) );
											$insert_query = stripslashes( $wpdb->prepare( "INSERT INTO {$wpdb->prefix}mlw_question_terms (question_id, quiz_id, term_id, taxonomy) VALUES %1s", $values ) );
											$termresult   = $wpdb->query( $insert_query );
										}
									}
								}
							}
							$quiz_page_settings = $wpdb->get_row( 'SELECT quiz_settings FROM ' . $wpdb->prefix . 'mlw_quizzes WHERE quiz_id = ' . $quiz_id . ' AND deleted = 0', ARRAY_A );
							$quiz_settings      = isset( $quiz_page_settings['quiz_settings'] ) ? maybe_unserialize( $quiz_page_settings['quiz_settings'] ) : array();
							$quiz_pages         = isset( $quiz_settings['pages'] ) ? maybe_unserialize( $quiz_settings['pages'] ) : array();
							foreach ( $quiz_question_ids as $id ) {
								if ( isset( $quiz_pages[0] ) && ! in_array( $id, $quiz_pages[0] ) ) {
									$quiz_pages[0][] = $id;
								}
							}
							$quiz_settings['pages']  = maybe_serialize( $quiz_pages  );
							$results_update = $wpdb->update(
								$wpdb->prefix . 'mlw_quizzes',
								array(
									'quiz_settings' => maybe_serialize( $quiz_settings ),
								),
								array(
									'quiz_id' => $quiz_id,
								)
							);
							if ( false === $results_update ) {
								$mlwQuizMasterNext->log_manager->add( 'Error uploading QSM - Export & Import file', $wpdb->last_error . ' from ' . $wpdb->last_query, 0, 'error' );
								$mlwQuizMasterNext->alertManager->newAlert( __( 'Error updating questions pages. Please try again.', 'qsm-export-import' ), 'error' );
							}else {
								$mlwQuizMasterNext->alertManager->newAlert( __( $question_imported . ' questions has been imported successfully!', 'qsm-export-import' ), 'success' );
							}
						} else {
							$mlwQuizMasterNext->log_manager->add( 'Error uploading QSM - Export & Import file', "Error from wp_handle_upload: {$import_file['error']}", 0, 'error' );
							$mlwQuizMasterNext->alertManager->newAlert( __( 'Error uploading file. Please try again.', 'qsm-export-import' ), 'error' );
						}
					}
				}
			}
		}
	}

	/**
	 * import flashcards function
	 *
	 * @since 2.0
	 * @return void
	 */
	public function qsm_addon_import_flashcards_tabs_function( $accepted_mime_types, $json_file_type ) {
		global $mlwQuizMasterNext;
		// If import flashcards form has been submitted.
		if ( isset( $_POST['import_flashcards_nonce'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['import_flashcards_nonce'] ) ), 'import_flashcards' ) ) {
			// Check if import file is missing and, if so, through error.
			if ( empty( $_FILES['file-import-flashcards']['tmp_name'] ) || empty( $_FILES['file-import-flashcards']['type'] ) ) {
				$mlwQuizMasterNext->log_manager->add( 'Error uploading QSM - Export & Import file', 'Error: File was missing!', 0, 'error' );
				$mlwQuizMasterNext->alertManager->newAlert( __( 'Error uploading file: Missing File. Please try again.', 'qsm-export-import' ), 'error' );
			} elseif ( ! in_array( $_FILES['file-import-flashcards']['type'], $accepted_mime_types, true ) ) {
				// Checks to ensure the file is of a supported mime type.
				$mlwQuizMasterNext->log_manager->add( 'Error uploading QSM - Export & Import file', "Error: Incorrect type. Supplied type: {$file_type}", 0, 'error' );
				$mlwQuizMasterNext->alertManager->newAlert( __( 'Error uploading file: Incorrect file format. Please try again.', 'qsm-export-import' ), 'error' );
			} else {
				// Let WordPress import the file. We will remove it after import is complete.
				$flashcards_data = array();
				$flashcard_data  = array();
				if ( in_array( $_FILES['file-import-flashcards']['type'], $json_file_type, true ) ) {
					$file_contents   = file_get_contents( wp_unslash( $_FILES['file-import-flashcards']['tmp_name'] ) ); // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized
					$flashcards_data = json_decode( $file_contents, true );
					foreach ( $flashcards_data as $flashcard_data ) {
						$args          = array(
							'post_type'    => 'qsm_flashcards',
							'post_status'  => 'publish',
							'post_parent'  => 0,
							'post_title'   => $flashcard_data['title'],
							'post_content' => '',
						);
						$flashcards_id = wp_insert_post( $args );
						update_post_meta( $flashcards_id, 'flashcards', $flashcard_data['flashcards_back_front'][0] );
					}
					$mlwQuizMasterNext->alertManager->newAlert( __( 'Your flashcards has been imported successfully!', 'qsm-export-import' ), 'success' );

				} else {
					$file_name      = isset( $_FILES['file-import-flashcards']['name'] ) ? sanitize_file_name( wp_unslash( $_FILES['file-import-flashcards']['name'] ) ) : '';
					$datafile       = wp_unslash( $_FILES['file-import-flashcards']['tmp_name'] ); // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized
					$upload_dir     = wp_upload_dir();
					$file           = $upload_dir['path'] . '/' . $file_name;
					$uploaded_files = move_uploaded_file( $datafile, $file );
					$actual_path    = $upload_dir['url'] . '/' . $file_name;
					// Checks if the file has been uploaded correctly.
					if ( $uploaded_files ) {
						$flashcard_data = $fields = array();
						$i              = 0;
						$handle         = @fopen( $file, 'r' );
						if ( $handle ) {
							while ( ( $flashcard_data = fgetcsv( $handle, 4096 ) ) !== false ) {
								if ( empty( $fields ) ) {
									$fields = $flashcard_data;
									continue;
								}
								$total_cards          = count( $flashcard_data );
								$args                 = array(
									'post_type'    => 'qsm_flashcards',
									'post_status'  => 'publish',
									'post_parent'  => 0,
									'post_title'   => $flashcard_data[0],
									'post_content' => '',
								);
								$sanitized_flashcards = array();
								for ( $i = 1;  $i < $total_cards; $i += 2 ) {
									$j                      = $i + 1;
									$sanitized_flashcards[] = array(
										'front' => wp_kses_post( stripslashes( $flashcard_data[ $i ] ) ),
										'back'  => wp_kses_post( stripslashes( $flashcard_data[ $j ] ) ),
									);
								}
								$flashcards_id = wp_insert_post( $args );
								update_post_meta( $flashcards_id, 'flashcards', $sanitized_flashcards );
							}
							if ( ! feof( $handle ) ) {
								$mlwQuizMasterNext->log_manager->add( 'Error in reading CSV file', 'File may possibly already exist!', 0, 'error' );
								$mlwQuizMasterNext->alertManager->newAlert( __( 'Error in reading CSV file. Please try again.', 'qsm-export-import' ), 'error' );
							} else {
								$mlwQuizMasterNext->alertManager->newAlert( __( 'Your flashcards has been imported successfully!', 'qsm-export-import' ), 'success' );
							}
							fclose( $handle );
						}
					}else {
						$mlwQuizMasterNext->alertManager->newAlert( __( 'Error in uploading CSV file, Please try again.', 'qsm-export-import' ), 'error' );
					}
				}
			}
		}
	}

	/**
	 * save license settings function
	 *
	 * @since 2.0
	 * @return void
	 */
	public function qsm_addon_export_import_license_tabs_function(){
		global $mlwQuizMasterNext;
		$settings    = get_option( 'qsm_addon_export_import_settings', '' );
		$license     = isset( $settings['license_key'] ) ? trim( $settings['license_key'] ) : '';
		$default_notice = 1;
		// If nonce is correct, update settings from passed input.
		if ( isset( $_POST['license_export_import_nonce'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['license_export_import_nonce'] ) ), 'export_import_license' ) ) {
			// Load previous license key
			$saved_license   = isset( $_POST['license_key'] ) ? sanitize_text_field( wp_unslash( $_POST['license_key'] ) ) : '';
			if ( isset( $_POST['new_license_key'] ) ) {
				$saved_license = sanitize_text_field( wp_unslash( $_POST['new_license_key'] ) );
			}
			if ( class_exists ( 'QSM_Check_License' ) ) {
				$activation = $mlwQuizMasterNext->check_license->activate( $saved_license, 'Export & Import' );
			}else {
				$activation = QSM_license::activate( $saved_license, 'Export & Import' );
			}
			$new_settings    = array( 'license_key' => $saved_license );

			if ( ! empty($activation) && ( ( __( 'Attempting to activate a bundle\'s parent license', 'qsm-export-import' ) == $activation['message'] || __( 'License key revoked', 'qsm-export-import' ) == $activation['message'] || __( 'No activations left', 'qsm-export-import' ) == $activation['message'] || __( 'License has expired', 'qsm-export-import' ) == $activation['message'] ) || 'success' == $activation['status'] ) ) {
				$item_url = 'https://quizandsurveymaster.com/checkout/?edd_license_key='.$license.'&download_id='.QSM_IMPORT_EXPORT_ITEM;
				$new_settings['license_key'] = $saved_license;
				$new_settings['license_status'] = 'valid';
				$new_settings['last_validate'] = date("d-m-Y", time());
				$new_settings['expiry_date'] = isset($activation['expiry_date']) ? $activation['expiry_date'] : "";
				if ( 'success' == $activation['status'] ) {
					$mlwQuizMasterNext->alertManager->newAlert( __( 'License validated Successfully', 'qsm-export-import' ), 'success' );
				}elseif ( __( 'License has expired', 'qsm-export-import' ) == $activation['message'] ) {
					$target_text = __('License Key Expired. ', 'qsm-export-import');
					$target_link = sprintf( $target_text.'<a href="%s" target="_blank">%s</a>', esc_url( $item_url ), __( 'Click here to renew', 'qsm-export-import' ) );
					$default_notice = 0;
					$mlwQuizMasterNext->alertManager->newAlert( $target_link, 'error' );
				}else {
					$mlwQuizMasterNext->alertManager->newAlert( $activation['message'], 'error' );
				}
				$mlwQuizMasterNext->alertManager->newAlert( __( 'Your settings has been saved successfully!', 'qsm-export-import' ), 'success' );
			} else {
				$new_settings['license_key'] = '';
				$new_settings['license_status'] = '';
				$new_settings['last_validate'] = 'invalid';
				$new_settings['expiry_date'] = '';
				if ( "" == $saved_license ) {
					$default_notice = 0;
					$mlwQuizMasterNext->alertManager->newAlert( __('License Key Required ', 'qsm-export-import'), 'error' );
				}else {
					$mlwQuizMasterNext->alertManager->newAlert( $activation['message'], 'error' );
				}
			}
			// If same license key was entered.
			if ( $license != $saved_license ) {
				$deactivation = QSM_license::deactivate( $license, 'Export & Import' );
			}
			update_option( 'qsm_addon_export_import_settings', $new_settings );
		}
	}
}