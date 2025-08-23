<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Creates export quiz file
 *
 * @since 2.0
 */
function qsm_addon_export_quiz() {

	if ( empty( $_POST['nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['nonce'] ) ), 'qsm_export_quiz' ) ) {
		wp_send_json_error( __('Nonce Validation failed', 'qsm-export-import') );
	}

	global $wpdb;
	if ( empty( $_POST['export'] ) || 'all' == $_POST['export'] ) {
		$quiz_data = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}mlw_quizzes WHERE deleted = 0 ORDER BY quiz_id DESC", ARRAY_A );
	} else {
		$export_ID = intval( $_POST['export'] );
		$quiz_data = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM {$wpdb->prefix}mlw_quizzes WHERE deleted = 0 AND quiz_id = %d ORDER BY quiz_id DESC", $export_ID ), ARRAY_A );
	}

	if ( ! empty( $quiz_data ) ) {
		// Cycle through each quiz and retrieve all of quiz's questions.
		foreach ( $quiz_data as $key => $quiz ) {
			$question_data = QSM_Questions::load_questions_by_pages( $quiz['quiz_id'] );
			$quiz_data[ $key ]['questions'] = $question_data;

			// checking if logic is updated to tables
			$logic_updated = get_option( 'logic_rules_quiz_' . $quiz['quiz_id'] );
			if ( $logic_updated ) {
				$query      = $wpdb->prepare( "SELECT logic FROM {$wpdb->prefix}mlw_logic where quiz_id = %d", $quiz['quiz_id'] );
				$logic_data = $wpdb->get_results( $query, ARRAY_N );
				$logics     = array();
				if ( ! empty( $logic_data ) ) {
					foreach ( $logic_data as $logic ) {
						$logics[] = maybe_unserialize( $logic[0] );
					}
					$serialized_logic           = maybe_serialize( $logics );
					$quiz_data[ $key ]['logic'] = $serialized_logic;
				}
			}

			// get featured image of quiz if available
			$qsm_featured_image = get_option( 'quiz_featured_image_' . $quiz['quiz_id'] );
			if ( $qsm_featured_image ) {
				$quiz_data[ $key ]['featured_image'] = $qsm_featured_image;
			}

			// get themes setting
			$query       = $wpdb->prepare( "SELECT A.theme, B.quiz_theme_settings, B.active_theme FROM {$wpdb->prefix}mlw_themes A, {$wpdb->prefix}mlw_quiz_theme_settings B where A.id = B.theme_id and B.quiz_id = %d", $quiz['quiz_id'] );
			$themes_data = $wpdb->get_results( $query, ARRAY_N );
			if ( ! empty( $themes_data ) ) {
				$themes = array();
				foreach ( $themes_data as $data ) {
					$themes[] = $data;
				}
				$serialized_themes           = maybe_serialize( $themes );
				$quiz_data[ $key ]['themes'] = $serialized_themes;
			}
		}

		// Encode data into json
		$json_quizzes = wp_json_encode( $quiz_data );

		// Put json into export file
		$time = time();
		global $wp_filesystem;
		if ( empty( $wp_filesystem ) ) {
			require_once ABSPATH . 'wp-admin/includes/file.php';
		}
		WP_Filesystem();
		$wp_filesystem->put_contents( QSM_IMPORT_EXPORT_THEME_PATH . "/exports/exported_quizzes_$time.json", $json_quizzes, 0644 );

		// Return file URL to front-end for download
		$file = QSM_IMPORT_EXPORT_URL . "/exports/exported_quizzes_$time.json";
		wp_send_json_success(
			array(
				'filename'  => $file,
				'file_name' => 'exported_quizzes_' . $time . '.json',
			)
		);
	}else {
		wp_send_json_error( __('Quiz not found!', 'qsm-export-import') );
	}
}

/**
 * Creates export questions file
 *
 * @since 2.0
 */
function qsm_addon_export_question() {
	if ( empty( $_POST['nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['nonce'] ) ), 'qsm_export_questions' ) ) {
		wp_send_json_error( __('Nonce Validation failed', 'qsm-export-import') );
	}
    global $wpdb;
	if ( empty( $_POST['export'] ) || 'all' == $_POST['export'] ) {
		$quiz_data = $wpdb->get_results( "SELECT quiz_id FROM {$wpdb->prefix}mlw_quizzes WHERE deleted = 0 ORDER BY quiz_id DESC", ARRAY_A );
	} else {
		$export_ID = intval( $_POST['export'] );
		$quiz_data = $wpdb->get_results( $wpdb->prepare( "SELECT quiz_id FROM {$wpdb->prefix}mlw_quizzes WHERE deleted = 0 AND quiz_id = %d ORDER BY quiz_id DESC", $export_ID ), ARRAY_A );
	}
	if ( ! empty( $quiz_data ) ) {
		$time = time();
		if ( empty( $_POST['export_type'] ) || 'json' == $_POST['export_type'] ) {
			$question_data = array();
			foreach ( $quiz_data as $quiz ) {
				$question_data[] = QSM_Questions::load_questions_by_pages( $quiz['quiz_id'] );
			}
			// Encode data into json
			$json_quizzes = wp_json_encode( $question_data );

			// Put json into export file
			$file_name = 'exported_quizzes_questions_answers_' . $time . '.json';
			global $wp_filesystem;
			if ( empty( $wp_filesystem ) ) {
				require_once ABSPATH . 'wp-admin/includes/file.php';
			}
			WP_Filesystem();
			$wp_filesystem->put_contents( QSM_IMPORT_EXPORT_THEME_PATH . "/exports/$file_name", $json_quizzes, 0644 );

			// Return file URL to front-end for download
			$file = QSM_IMPORT_EXPORT_URL . "/exports/$file_name";
			wp_send_json_success(
				array(
					'filename'  => $file,
					'file_name' => $file_name,
				)
			);
		}else {
			if ( ! class_exists( 'MLW_Export_CSV' ) ) {
				include 'class-mlw-export-csv.php';
			}
			$file_name = 'exported_quizzes_questions_answers_' . $time . '.csv';
			$csv_file = new MLW_Export_CSV( "../exports/$file_name" );
			$headers  = array(
				'item_type'                => 'Item Type',
				'question_title'           => 'Question Title',
				'question_description'     => 'Question Description',
				'answer_text'              => 'Answer Text',
				'answer_point'             => 'Answer Point',
				'answer_correct_incorrect' => 'Answer Correct/InCorrect',
				'answer_caption'           => 'Answer Caption',
				'answer_label'             => 'Answer label',
				'question_answer_info'     => 'Question Answer Info',
				'comments'                 => 'Comments',
				'hints'                    => 'Hints',
				'question_type_new'        => 'Question Type New',
				'required'                 => 'Required',
				'require_all_rows'         => 'Require all rows',
				'answer_editor'            => 'Answer Editor',
				'feature_image_src'        => 'Feature Image Src',
				'match_answer'             => 'Match Answer',
				'case_sensitive'           => 'Case Sensitive',
				'answer_columns'           => 'Answer Columns',
				'image_size-width'         => 'Image Size-Width',
				'image_size-height'        => 'Image Size-Height',
				'autofill'                 => 'Autofill',
				'text_limit'               => 'Text Limit',
				'limit_multiple_response'  => 'Limit Multiple Response',
				'file_upload_limit'        => 'File Upload Limit',
				'file_upload_type'         => 'File Upload Type',
				'categories'               => 'Categories',
			);
			$csv_file->add_row( apply_filters( 'qsm_addon_export_questins_answers_headers', $headers ) );
			foreach ( $quiz_data as $quiz ) {
				$quiz_id = $quiz['quiz_id'];
				$question_data = QSM_Questions::load_questions_by_pages( $quiz_id );
				if ( ! empty( $question_data ) ) {
					foreach ( $question_data as $question ) {
						$categories_str = "";
						$question_settings = maybe_unserialize( $question['question_settings'] );
						$categories = maybe_unserialize( $question['multicategoriesobject'] );
						if ( $categories ) {
							foreach ( $categories as $category ) {
								$categories_str .= $category->name . ",";
								if ( $category->children ) {
									$categories_str = qsm_categories_to_string( $categories_str, $category->children);
								}
							}
							$categories_str = rtrim($categories_str, ',');
						}
						$question_array = array(
							'item_type'                => 'Question',
							'question_title'           => ! empty( $question_settings['question_title'] ) ? $question_settings['question_title'] : "",
							'question_description'     => ! empty( $question['question_name'] ) ? $question['question_name'] : "",
							'answer_text'              => '',
							'answer_point'             => '',
							'answer_correct_incorrect' => '',
							'answer_caption'           => '',
							'answer_label'             => '',
							'question_answer_info'     => ! empty( $question['question_answer_info'] ) ? $question['question_answer_info'] : "",
							'comments'                 => ! empty( $question['comments'] ) ? $question['comments'] : 1,
							'hints'                    => ! empty( $question['hints'] ) ? $question['hints'] : "",
							'question_type_new'        => ! empty( $question['question_type_new'] ) ? qsm_addon_import_export_question_type_int_str( $question['question_type_new'], 'string' ) : "",
							'required'                 => ! empty( $question_settings['required'] ) ? 0 : 1,
							'require_all_rows'         => ! empty( $question_settings['require-all-rows'] ) ? $question_settings['require-all-rows'] : "",
							'answer_editor'            => ! empty( $question_settings['answerEditor'] ) ? $question_settings['answerEditor'] : "",
							'feature_image_src'        => ! empty( $question_settings['featureImageSrc'] ) ? $question_settings['featureImageSrc'] : "",
							'match_answer'             => ! empty( $question_settings['matchAnswer'] ) ? $question_settings['matchAnswer'] : "",
							'case_sensitive'           => ! empty( $question_settings['case_sensitive'] ) ? $question_settings['case_sensitive'] : "",
							'answer_columns'           => ! empty( $question_settings['answer_columns'] ) ? $question_settings['answer_columns'] : "",
							'image_size-width'         => ! empty( $question_settings['image_size-width'] ) ? $question_settings['image_size-width'] : "",
							'image_size-height'        => ! empty( $question_settings['image_size-height'] ) ? $question_settings['image_size-height'] : "",
							'autofill'                 => ! empty( $question_settings['autofill'] ) ? $question_settings['autofill'] : "",
							'text_limit'               => ! empty( $question_settings['limit_text'] ) ? $question_settings['limit_text'] : "",
							'limit_multiple_response'  => ! empty( $question_settings['limit_multiple_response'] ) ? $question_settings['limit_multiple_response'] : "",
							'file_upload_limit'        => ! empty( $question_settings['file_upload_limit'] ) ? $question_settings['file_upload_limit'] : "",
							'file_upload_type'         => ! empty( $question_settings['file_upload_type'] ) ? $question_settings['file_upload_type'] : "",
							'categories'               => ! empty( $categories_str ) ? $categories_str : "",
						);
						$csv_file->add_row( apply_filters( 'qsm_addon_export_questions_answers_rows', $question_array ) );
						$answers_arr = maybe_unserialize( $question['answer_array'] );
						if ( ! empty( $answers_arr['columns'] ) ) {
							$answers_arr[] = $answers_arr;
							unset($answers_arr['columns']);
							unset($answers_arr['points']);
							unset($answers_arr['rows']);
						}
						foreach ( $answers_arr as $single_answer ) {
							if ( ! empty( $single_answer['columns'] ) ) {
								$single_answer[0] = implode(", ", $single_answer['columns'] );
							}
							if ( ! empty( $single_answer['points'] ) ) {
								$single_answer[1] = implode(", ", $single_answer['points'] );
							}
							if ( ! empty( $single_answer['rows'] ) ) {
								$single_answer['label'] = implode(", ", $single_answer['rows'] );
							}
							$answer_array = array(
								'item_type'                => 'Answer',
								'question_title'           => "",
								'question_description'     => "",
								'answer_text'              => ! empty( $single_answer[0] ) ? $single_answer[0] : "",
								'answer_point'             => ! empty( $single_answer[1] ) ? $single_answer[1] : "",
								'answer_correct_incorrect' => ! empty( $single_answer[2] ) ? $single_answer[2] : "",
								'answer_caption'           => ! empty( $single_answer[3] ) ? $single_answer[3] : "",
								'answer_label'             => ! empty( $single_answer['label'] ) ? $single_answer['label'] : "",
							);
							$csv_file->add_row( apply_filters( 'qsm_addon_export_answers_rows', $answer_array ) );
						}
					}
				}
			}
		}
		// Finalize and close csv file
		$csv_file->finalize();

		$file = QSM_IMPORT_EXPORT_URL . "/exports/$file_name";

		wp_send_json_success(
			array(
				'filename'  => $file,
				'file_name' => $file_name,
			)
		);
	}else {
		wp_send_json_error( __('Quiz not found!', 'qsm-export-import') );
	}
}
/**
 * Convert question types
 * @param string||int $question_type
 * @param string $convert_type ( string, int )
 *
 * @since 2.0
 */
function qsm_addon_import_export_question_type_int_str( $question_type, $convert_type = 'string' ) {
	$default_question_types = array(
		0  => __( 'Multiple Choice', 'qsm-export-import' ),
		1  => __( 'Multiple Choice (Horizontal)', 'qsm-export-import' ),
		2  => __( 'Drop Down', 'qsm-export-import' ),
		3  => __( 'Short Answer', 'qsm-export-import' ),
		4  => __( 'Multiple Response', 'qsm-export-import' ),
		5  => __( 'Paragraph', 'qsm-export-import' ),
		6  => __( 'Text/HTML Section', 'qsm-export-import' ),
		7  => __( 'Number', 'qsm-export-import' ),
		8  => __( 'Opt-in', 'qsm-export-import' ),
		9  => __( 'Captcha', 'qsm-export-import' ),
		10 => __( 'Multiple Response (Horizontal)', 'qsm-export-import' ),
		11 => __( 'File Upload', 'qsm-export-import' ),
		12 => __( 'Date', 'qsm-export-import' ),
		13 => __( 'Polar', 'qsm-export-import' ),
		14 => __( 'Fill In The Blank', 'qsm-export-import' ),
		15 => __( 'Matching Pairs', 'qsm-export-import' ),
		16 => __( 'Radio Grid', 'qsm-export-import' ),
		17 => __( 'Checkbox Grid', 'qsm-export-import' ),
		18 => __( 'Flash card', 'qsm-export-import' ),
	);

	if ( 'string' === $convert_type ) {
		$question_type = ! empty( $default_question_types[ $question_type ] ) ? $default_question_types[ $question_type ] : $question_type;
	}elseif ( 'int' === $convert_type ) {
		$question_type = false !== array_search( $question_type, $default_question_types, true) && ! is_int($question_type) ? array_search( $question_type, $default_question_types, true) : $question_type ;
	}
	return $question_type;
}

/**
 * Creates export options file
 *
 * @since 2.0
 */
function qsm_addon_export_quiz_settings() {
	if ( empty( $_POST['nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['nonce'] ) ), 'qsm_export_settings' ) ) {
		wp_send_json_error( __('Nonce Validation failed!', 'qsm-export-import') );
	}
	if ( empty( $_POST['export'] ) ) {
		wp_send_json_error( __('Please Select Quiz!', 'qsm-export-import') );
	}
	if ( empty( $_POST['checkboxValues'] ) ) {
		wp_send_json_error( __('Please Select Settings Options!', 'qsm-export-import') );
	}
	global $wpdb;
	$time = time();
	$export_ID = intval( wp_unslash( $_POST['export'] ) );
	$options = qsm_sanitize_rec_array( wp_unslash( $_POST['checkboxValues'] ) ); // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized
	$quiz_data = $wpdb->get_row( $wpdb->prepare( "SELECT quiz_settings,quiz_stye FROM {$wpdb->prefix}mlw_quizzes WHERE deleted = 0 AND quiz_id = %d ORDER BY quiz_id DESC", $export_ID ), ARRAY_A );
	if ( ! empty( $quiz_data ) ) {
		$export_data = array();
		$quiz_settings = maybe_unserialize( $quiz_data['quiz_settings'] );
		if ( in_array( 'option', $options, true ) ) {
			$export_data['quiz_options'] = $quiz_settings['quiz_options'];
		}
		if ( in_array( 'contact', $options, true ) ) {
			$export_data['contact_form'] = $quiz_settings['contact_form'];
		}
		if ( in_array( 'text', $options, true ) ) {
			$export_data['quiz_text'] = $quiz_settings['quiz_text'];
		}
		if ( in_array( 'style', $options, true ) ) {
			$quiz_theme_settings = $wpdb->get_row( $wpdb->prepare( "SELECT theme_id,quiz_theme_settings  FROM {$wpdb->prefix}mlw_quiz_theme_settings WHERE  quiz_id = %d AND active_theme = %d", $export_ID,true), ARRAY_A );
			$export_data['quiz_theme_settings'] = $quiz_theme_settings['quiz_theme_settings'];
			$export_data['theme_id'] = $quiz_theme_settings['theme_id'];
			$export_data['quiz_css'] = isset($quiz_data['quiz_stye']) ? $quiz_data['quiz_stye'] : '';
			if(null != $quiz_theme_settings['theme_id'] && '' != $quiz_theme_settings['theme_id']) {
				$theme_settings = $wpdb->get_row( $wpdb->prepare( "SELECT *  FROM {$wpdb->prefix}mlw_themes WHERE id = %d", $quiz_theme_settings['theme_id']), ARRAY_A );
				$export_data['theme'] = $theme_settings ? $theme_settings['theme'] : '';
			}
		}
		// Encode data into json
		$json_quizzes = wp_json_encode( $export_data );

		// Put json into export file
		$file_name = 'exported_quiz_settings_' . $time . '.json';
		global $wp_filesystem;
		if ( empty( $wp_filesystem ) ) {
			require_once ABSPATH . 'wp-admin/includes/file.php';
		}
		WP_Filesystem();
		$wp_filesystem->put_contents( QSM_IMPORT_EXPORT_THEME_PATH . "/exports/$file_name", $json_quizzes, 0644 );

		// Return file URL to front-end for download
		$file = QSM_IMPORT_EXPORT_URL . "/exports/$file_name";
		wp_send_json_success(
			array(
				'filename'  => $file,
				'file_name' => $file_name,
			)
		);
	}else {
		wp_send_json_error( __('Quiz not found!', 'qsm-export-import') );
	}
}

/**
 * Creates export file
 *
 * @since 2.0
 */
function qsm_addon_export_flashcards() {

	if ( empty( $_POST['export_flashcard_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['export_flashcard_nonce'] ) ), 'export_flashcard' ) ) {
		wp_send_json_error( __('Nonce Validation failed', 'qsm-export-import') );
	}

	$flashcards      = get_posts( array( 'post_type' => 'qsm_flashcards' ) );
	$flashcards_data = array();
	$time            = time();
	$i               = 0;
	if ( isset( $_POST['export_type'] ) && 'json' === $_POST['export_type'] ) {
		foreach ( $flashcards as $flashcard ) {
			$flashcards_data[ $i ]['title']                 = $flashcard->post_title;
			$flashcards_data[ $i ]['flashcards_back_front'] = get_post_meta( $flashcard->ID, 'flashcards', false );
			$i ++;
		}
		// Encode data into json.
		$json_flashcards = wp_json_encode( $flashcards_data );
		// Put json into export file.
		global $wp_filesystem;
		WP_Filesystem();
		$file_name = 'exported_flashcards_' . $time . '.json';
		$wp_filesystem->put_contents( QSM_IMPORT_EXPORT_THEME_PATH . "/exports/$file_name", $json_flashcards, 0644 );

		// Return file URL to front-end for download.
		$file = QSM_IMPORT_EXPORT_URL . "/exports/$file_name";
		wp_send_json_success(
			array(
				'filename'  => $file,
				'file_name' => $file_name,
			)
		);
	} else {
		if ( ! class_exists( 'MLW_Export_CSV' ) ) {
			include 'class-mlw-export-csv.php';
		}
		$file_name        = 'exported_flashcards_' . $time . '.csv';
		$csv_file         = new MLW_Export_CSV( "../exports/$file_name" );
		$headers['title'] = 'Title';
		foreach ( $flashcards as $flashcard ) {
			$flashcards_back_front = get_post_meta( $flashcard->ID, 'flashcards', false );
			$j                     = 1;
			foreach ( $flashcards_back_front[0] as $flashcard_back_front ) {
				$headers[ 'front_' . $j ] = 'Front ' . $j;
				$headers[ 'back_' . $j ]  = 'Back ' . $j;
				$j++;
			}
		}

		// Add headers to csv.
		$csv_file->add_row( apply_filters( 'qsm_addon_export_flashcard_headers', $headers ) );

		// Add result row to csv.
		foreach ( $flashcards as $flashcard ) {
			$flashcards_data          = array();
			$flashcards_data['title'] = $flashcard->post_title;
			$flashcards_back_front    = get_post_meta( $flashcard->ID, 'flashcards', false );
			$j                        = 1;
			foreach ( $flashcards_back_front[0] as $flashcard_back_front ) {
				$flashcards_data[ 'front_' . $j ] = $flashcard_back_front['front'];
				$flashcards_data[ 'back_' . $j ]  = $flashcard_back_front['back'];
				$j++;
			}
			$csv_file->add_row( apply_filters( 'qsm_addon_export_flashcard_rows', $flashcards_data ) );
		}

		// Finalize and close csv file.
		$csv_file->finalize();

		$file = QSM_IMPORT_EXPORT_URL . "/exports/$file_name";

		wp_send_json_success(
			array(
				'filename'  => $file,
				'file_name' => $file_name,
			)
		);
	}
}

function qsm_categories_to_string( $categories_str, $categories ) {
	foreach ( $categories as $category ) {
		$categories_str .= $category->name . ",";
		if ( $category->children ) {
			$categories_str = qsm_categories_to_string( $categories_str, $category->children );
		}
	}
	return $categories_str;
}
