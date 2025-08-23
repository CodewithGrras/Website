<?php
/**
 * Import and export quizzes/surveys with responses
 *
 * @since 2.1.2
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Abort if the class is already exists.
 */
if ( ! class_exists( 'QSM_Import_Export_Quiz' ) ) {

	/**
	 * This class is used for import and export quizzes/surveys with responses
	 *
	 * @since 2.1.2
	 */
	class QSM_Import_Export_Quiz {

		/**
		 * Main Construct Function
		 *
		 * Call functions within class
		 *
		 * @since 2.1.2
		 * @uses QSM_Export_Import::add_hooks() Adds actions to hooks and filters
		 * @return void
		 */
		function __construct() {
			$this->add_hooks();
		}


		/**
		 * Add Hooks
		 *
		 * Adds functions to relavent hooks and filters
		 *
		 * @since 0.1.0
		 * @return void
		 */
		public function add_hooks() {
			add_action( 'wp_ajax_qsm_export_quiz', array( $this, 'export_quiz_and_results' ) );
			add_action( 'wp_ajax_qsm_prepare_import_quiz', array( $this, 'prepare_import_quiz' ) );
			add_action( 'wp_ajax_qsm_imported_quiz_data', array( $this, 'imported_quiz_data' ) );
			add_action( 'wp_ajax_qsm_import_quizzes', array( $this, 'import_quizzes' ) );
			add_action( 'wp_ajax_qsm_import_results', array( $this, 'import_results' ) );
		}

		/**
		 * Sanitize Ids
		 *
		 * @param array $ids unfiltered ids
		 * @since 2.1.2
		 *
		 * @return array $ids filtered ids
		 */
		public function sanitize_id( $ids = array() ) {
			// Sanitize and validate the IDs
			$ids = array_map( 'intval', wp_unslash( $ids ) );

			// filter ids
			$ids = array_filter(
				$ids,
				function ( $id ) {
					return 0 < $id;
				}
			);

			return $ids;
		}

		/**
		 * Log Error
		 *
		 * @param string|html $text error title
		 * @param array       $error error details
		 * @param string      $type error type quiz or result
		 * @since 2.1.2
		 *
		 * @return integer log_id log post id
		 */
		private function log_error( $text, $error = array(), $type = 'quiz' ) {
			if ( empty( $error['error'] ) ) {
				return false;
			}
			global $mlwQuizMasterNext;
			$log_id = $mlwQuizMasterNext->log_manager->add(
				$text,
				implode( '<br/>', $error['error'] ),
				0,
				'error',
				array(
					'failed_' . $type . '_ids' => maybe_serialize( $error['failed'] ),
				)
			);

			return empty( $log_id ) ? $log_id : admin_url( 'post.php?post=' . intval( $log_id ) . '&action=edit' );
		}

		/**
		 * Check if there is any error in export or import quiz
		 *
		 * @param string $input_name $_POST input name to check
		 * @since 2.1.2
		 *
		 * @return boolean|string false or error message
		 */
		private function is_error( $input_name = '' ) {
			// Global variables
			global $mlwQuizMasterNext;

			// Verify nonce
			if ( empty( $_POST['nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['nonce'] ) ), 'qsm_export_import_quiz' ) ) {
				return __( 'Nonce Validation failed', 'qsm-export-import' );
			}

			// should have delete_published_posts capabilities.
			if ( ! isset( $mlwQuizMasterNext ) || ! method_exists( $mlwQuizMasterNext, 'qsm_is_admin' ) || ! method_exists( $mlwQuizMasterNext, 'qsm_check_database_structure' ) ) {
				return __( 'Please update Quiz And Survey Master plugin.', 'qsm-export-import' );
			}

			// should have delete_private_pages capabilities. Editor and above roles only
			if ( ! $mlwQuizMasterNext->qsm_is_admin( 'delete_private_pages' ) ) {
				return __( 'You do not have permission to export data. Please contact the site administrator.', 'qsm-export-import' );
			}

			// check for required quiz ids
			if ( ! empty( $input_name ) && ( empty( $_POST[ $input_name ] ) || ! is_array( $_POST[ $input_name ] ) ) ) {
				return __( 'Missing required quiz data', 'qsm-export-import' );
			}

			return false;
		}

		/**
		 * Imported stats: merge imported quiz if provide and return merged stats
		 *
		 * @since 2.1.2
		 * @param array $imported_quiz imported quiz data
		 *
		 * @return array $imported_stats merged stats
		 */
		private function imported_quiz_stats( $imported_quiz = array(), $type = 'quizzes' ) {
			$imported_stats = get_option( 'qsm_import_quiz_stats' );
			if ( empty( $imported_stats ) ) {
				$imported_stats = array(
					'quizzes' => array(),
					'results' => array(),
				);
			}
			if ( ! empty( $imported_quiz ) ) {
				$type = 'quizzes' === $type ? 'quizzes' : 'results';
				$imported_stats[ $type ][ count( $imported_stats[ $type ] ) ] = $imported_quiz;
				update_option( 'qsm_import_quiz_stats', $imported_stats );
			}
			return $imported_stats;
		}

		/**
		 * Import Quiz Data
		 */
		public function imported_quiz_data() {
			$error = $this->is_error();
			if ( false !== $error ) {
				wp_send_json_error( $error );
			}
			wp_send_json_success( $this->imported_quiz_stats() );
		}

		/**
		 * Export quiz and results data
		 *
		 * @since 2.1.2
		 */
		public function export_quiz_and_results() {
			$error = $this->is_error( 'quiz_ids' );
			if ( false !== $error ) {
				wp_send_json_error( $error );
			}
			global $mlwQuizMasterNext, $wpdb;

			// Sanitize and validate the IDs
			$quiz_ids = $this->sanitize_id( $_POST['quiz_ids'] );

			if ( empty( $quiz_ids ) ) {
				wp_send_json_error( __( 'Invalid quiz ids', 'qsm-export-import' ) );
			}

			// Generate placeholders for each ID
			$placeholder_for_ids = array_fill( 0, count( $quiz_ids ), '%d' );

			/**
			 * Prepares results of quiz including deleted result
			 */
			if ( ! empty( $_POST['export_results'] ) ) {
				// Construct the query with placeholders.
				$query = sprintf(
					"SELECT * FROM {$wpdb->prefix}mlw_results WHERE quiz_id IN (%s)",
					implode( ', ', $placeholder_for_ids )
				);

				// Prepare the query
				$query = $wpdb->prepare( $query, $quiz_ids );

				$results = $wpdb->get_results( $query, ARRAY_A );

				if ( ! empty( $results ) ) {
					// Unserialize result will help in updating question ids
					foreach ( $results as $results_index => $result ) {
						if ( ! empty( $result['quiz_results'] ) ) {
							$results[ $results_index ]['quiz_results'] = maybe_unserialize( $result['quiz_results'] );
						}
					}
				}

				wp_send_json_success(
					array(
						'status'  => 'success',
						'results' => $results,
					)
				);
			}

			// Construct the query with placeholders.
			$query = sprintf(
				"SELECT * FROM {$wpdb->prefix}mlw_quizzes WHERE deleted = 0 AND quiz_id IN (%s) ORDER BY quiz_id DESC",
				implode( ', ', $placeholder_for_ids )
			);

			// Prepare the query
			$query = $wpdb->prepare( $query, $quiz_ids );

			// Run query
			$quiz_data = $wpdb->get_results( $query, ARRAY_A );

			if ( ! empty( $quiz_data ) ) {
				// Cycle through each quiz and retrieve all of quiz's questions.
				foreach ( $quiz_data as $key => $quiz ) {
					$question_data                  = QSM_Questions::load_questions_by_pages( $quiz['quiz_id'], 'admin' );
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

					if ( taxonomy_exists('qsm-answer-label') ) {
						$answer_labels = array(); // To store the labels where quiz_id or 'all' exists

						$qsm_labels = get_terms(
							array(
								'taxonomy'   => 'qsm-answer-label',
								'hide_empty' => false,
							)
						);

						foreach ( $qsm_labels as $labelkey => $labelvalue ) {
							$qsm_quiz = maybe_unserialize( get_term_meta( $labelvalue->term_id, 'qsm_quiz', true ) ); // Unserialize once
						
							// Check if $qsm_quiz is a valid array
							if ( is_array( $qsm_quiz ) ) {
								// Check if the label applies to the specific quiz ID or 'all'
								$is_global = in_array( 'all', $qsm_quiz ) ? true : false;
								
								if ( in_array( $quiz['quiz_id'], $qsm_quiz ) || $is_global ) {
									// Use the term ID as the array key to ensure uniqueness
									$answer_labels[ $labelvalue->term_id ] = array(
										'id'        => $labelvalue->term_id,
										'name'      => $labelvalue->name,
										'slug'      => $labelvalue->slug,
										'is_global' => $is_global,
									);
								}
							}
						}                       

						if ( ! empty($answer_labels) ) {
							$quiz_data[ $key ]['answer_labels'] = maybe_serialize( $answer_labels );
						}
					}               
				}

				wp_send_json_success(
					array(
						'status'  => 'success',
						'quizzes' => $quiz_data,
					)
				);
			} else {
				wp_send_json_error( __( 'Quiz not found!', 'qsm-export-import' ) );
			}
		}

		/**
		 * Get quiz table exists, unique id and quiz name list of result table
		 *
		 * @since 2.1.2
		 */
		public function prepare_import_quiz() {
			$error = $this->is_error();
			if ( false !== $error ) {
				wp_send_json_error( $error );
			}
			global $mlwQuizMasterNext, $wpdb;

			$site_url = trailingslashit( get_site_url() );
			if ( ! empty( $_POST['quiz_ids'] ) && is_array( $_POST['quiz_ids'] ) ) {
				// Sanitize and validate the IDs
				$quiz_ids = $this->sanitize_id( $_POST['quiz_ids'] );

				if ( empty( $quiz_ids ) ) {
					wp_send_json_error( __( 'Invalid quiz ids', 'qsm-export-import' ) );
				}

				// Generate placeholders for each ID
				$placeholder_for_ids = array_fill( 0, count( $quiz_ids ), '%d' );

				// Construct the query with placeholders for maximum number of question a quiz contain
				$query = sprintf(
					"SELECT quiz_id, COUNT(question_id) as max_questions FROM {$wpdb->prefix}mlw_questions WHERE quiz_id IN (%s) GROUP BY quiz_id ORDER BY COUNT(question_id) DESC LIMIT 1",
					implode( ',', $placeholder_for_ids )
				);

				// Prepare the query
				$query = $wpdb->prepare( $query, $quiz_ids );

				$max_questions = $wpdb->get_results( $query, ARRAY_A );

				if ( empty( $max_questions ) ) {
					$max_questions = 0;
				} else {
					$max_questions = absint( $max_questions[0]['max_questions'] );
				}

				// Chunk size: size of data to be fetch during import export
				$chunk_size = 25;
				if ( 250 < $max_questions ) {
					$chunk_size = 1;
				} elseif ( 100 < $max_questions ) {
					$chunk_size = 2;
				} elseif ( 50 < $max_questions ) {
					$chunk_size = 5;
				} elseif ( 25 <= $max_questions ) {
					$chunk_size = 10;
				} elseif ( 15 < $max_questions ) {
					$chunk_size = 15;
				}

				if ( ! empty( $_POST['get_chunk_size'] ) ) {
					wp_send_json_success(
						array(
							'site_url'      => $site_url,
							'chunk_size'    => $chunk_size,
							'max_questions' => $max_questions,
						)
					);
				}
			}

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

			// unique id with associated quiz id list. Result with matching quiz id and unique id will be considered as duplicate.
			$result_data = $wpdb->get_results( "SELECT DISTINCT unique_id, quiz_id FROM {$wpdb->prefix}mlw_results", ARRAY_A );
			$unique_ids  = array();
			if ( ! empty( $result_data ) ) {
				foreach ( $result_data as $result ) {
					$unique_ids[ $result['unique_id'] ] = $result['quiz_id'];
				}
			}

			// Quiz name with associated quiz id list. Quiz with same name will be considered as duplicate.
			$quiz_data    = $wpdb->get_results( "SELECT DISTINCT quiz_name, quiz_id FROM {$wpdb->prefix}mlw_quizzes WHERE deleted = 0", ARRAY_A );
			$quiz_id_name = array();
			if ( ! empty( $quiz_data ) ) {
				foreach ( $quiz_data as $quiz ) {
					$quiz_id_name[ $quiz['quiz_id'] ] = $quiz['quiz_name'];
				}
			}

			$database_status = '';
			// check database structure
			if ( 'error' == get_option( 'qsm_check_database_structure', '' ) ) {
				$database_status = __( 'Incorrect database structure!', 'qsm-export-import' ) . ' <a href="' . esc_url( admin_url('admin.php?page=qmn_addons&tab=export-and-import&qsm_check_database_structure=1') ) . '">' . __( 'Check details.', 'qsm-export-import' ) . '<a>';
			}

			wp_send_json_success(
				array(
					'database_status'          => $database_status,
					'site_url'                 => $site_url,
					'result_unique_id_quiz_id' => $unique_ids,
					'quiz_id_name'             => $quiz_id_name,
					'has_logic_store'          => $logic_table_exists ? 1 : 0,
					'has_theme_store'          => $themes_table_exists ? 1 : 0,
					'has_theme_settings_store' => $themes_settings_table_exists ? 1 : 0,
				)
			);
		}

		/**
	 * @since 1.0.0
	 */
	public static function qsm_get_addon_data() {
		$addon_list_path = QSM_IMPORT_EXPORT_THEME_PATH . 'data/addons-import-export.json';
		$addon_list_data = file_get_contents( $addon_list_path );
		$addon_list_data = json_decode( $addon_list_data, true );
		return $addon_list_data;
	}

		/**
		 * Import quizzes
		 *
		 * @since 2.1.2
		 */
		public function import_quizzes() {
			$error = $this->is_error( 'quizzes' );
			if ( false !== $error ) {
				wp_send_json_error( $error );
			}
			try {
				global $mlwQuizMasterNext, $wpdb;
				$logic_table                  = $wpdb->prefix . 'mlw_logic';
				$themes_table                 = $wpdb->prefix . 'mlw_themes';
				$themes_settings_table        = $wpdb->prefix . 'mlw_quiz_theme_settings';
				$logic_table_exists           = empty( $_POST['has_logic_store'] ) ? false : true;
				$themes_table_exists          = empty( $_POST['has_theme_store'] ) ? false : true;
				$themes_settings_table_exists = empty( $_POST['has_theme_settings_store'] ) ? false : true;

				// stats of failed, imported, error log
				$stats = array(
					'failed'   => array(),
					'imported' => array(),
					'error'    => array(),
					'log_link' => array(),
				);

				$current_version = $mlwQuizMasterNext->version;
				$quiz_system     = 'system';
				if ( version_compare( $current_version, '7.0.0', '>=' ) ) {
					$quiz_system = 'quiz_system';
				}

				// Cycle through the quizzes and insert the quiz.
				foreach ( $_POST['quizzes'] as $quiz ) {
					$quiz = json_decode( wp_unslash( $quiz ), true );
					if ( empty( $quiz ) || ! is_array( $quiz ) ) {
						continue;
					}
					
					if ( isset($quiz['dependencies']) && ! empty($quiz['dependencies']) ) {

						$qsm_admin_dd = wp_remote_get(QSM_PLUGIN_URL . 'data/parsing_script.json', [ 'sslverify' => false ]);
						$qsm_admin_dd = json_decode(wp_remote_retrieve_body($qsm_admin_dd), true);
						$all_themes = $qsm_admin_dd['themes'];
						$all_addons = $qsm_admin_dd['all_addons'];
						$theme_paths = array();
						// Get id and name for themes and addons
						
						$theme_data = array_map(function( $theme ) use ( &$theme_paths ) { // Use reference
							$theme_paths[] = array(
								'name' => $theme['name'],
								'path' => "qsm-theme-{$theme['name']}/qsm_theme_{$theme['name']}.php",
							);
							return [
								'id'   => $theme['id'],
								'name' => $theme['name'],
							];
						}, $all_themes);
						$addon_data = array_map(function( $addon ) {
							return [
								'id'   => $addon['id'],
								'name' => $addon['name'],
							];
						}, $all_addons);

						// Merge theme_data and addon_data
						$merged_data = array_merge($theme_data, $addon_data);

						$required_dependencies = maybe_unserialize($quiz['dependencies']);
						$dependency_name = [];

						// Prepare messages based on matching IDs
						foreach ( $required_dependencies as $id ) {
							foreach ( $merged_data as $item ) {
								if ( $item['id'] == $id ) {
									$dependency_name[] = $item['name'];
								}
							}
						}

						$addon_list_data = self::qsm_get_addon_data();
						$addon_list_data = array_merge($theme_paths, $addon_list_data);
						$dependency_messages = []; // Initialize the message array
						foreach ( $addon_list_data as $key => $value ) {
							if ( in_array($value['name'], $dependency_name) ) {
								if ( is_plugin_active($value['path']) ) { } elseif ( file_exists(WP_PLUGIN_DIR . '/' . $value['path']) ) {
									$dependency_messages[] = sprintf(
										__('%s is installed but not activated.', 'qsm-export-import'),
										$value['name']
									);
								} else {
									$dependency_messages[] = sprintf(
										__('%s is required but not installed.', 'qsm-export-import'),
										$value['name']
									);
								}
							}
						}
						$stats['dependency'] = $dependency_messages;
					}

					$quiz_settings   = $quiz['quiz_settings'];
					$quiz            = wp_kses_post_deep( $quiz );
					$new_quiz_system = 0;
					if ( isset( $quiz['system'] ) ) {
						$new_quiz_system = $quiz['system'];
					} elseif ( isset( $quiz['quiz_system'] ) ) {
						$new_quiz_system = $quiz['quiz_system'];
					}
					$results = $wpdb->insert(
						$wpdb->prefix . 'mlw_quizzes',
						array(
							'quiz_name'                => $quiz['quiz_name'],
							'message_before'           => $quiz['message_before'],
							'message_after'            => $quiz['message_after'],
							'message_comment'          => $quiz['message_comment'],
							'message_end_template'     => $quiz['message_end_template'],
							'user_email_template'      => $quiz['user_email_template'],
							'admin_email_template'     => $quiz['admin_email_template'],
							'submit_button_text'       => $quiz['submit_button_text'],
							'name_field_text'          => $quiz['name_field_text'],
							'business_field_text'      => $quiz['business_field_text'],
							'email_field_text'         => $quiz['email_field_text'],
							'phone_field_text'         => $quiz['phone_field_text'],
							'comment_field_text'       => $quiz['comment_field_text'],
							'email_from_text'          => $quiz['email_from_text'],
							'question_answer_template' => $quiz['question_answer_template'],
							'leaderboard_template'     => $quiz['leaderboard_template'],
							$quiz_system               => $new_quiz_system,
							'randomness_order'         => $quiz['randomness_order'],
							'loggedin_user_contact'    => $quiz['loggedin_user_contact'],
							'show_score'               => $quiz['show_score'],
							'send_user_email'          => $quiz['send_user_email'],
							'send_admin_email'         => $quiz['send_admin_email'],
							'contact_info_location'    => $quiz['contact_info_location'],
							'user_name'                => $quiz['user_name'],
							'user_comp'                => $quiz['user_comp'],
							'user_email'               => $quiz['user_email'],
							'user_phone'               => $quiz['user_phone'],
							'admin_email'              => $quiz['admin_email'],
							'comment_section'          => $quiz['comment_section'],
							'question_from_total'      => $quiz['question_from_total'],
							'total_user_tries'         => $quiz['total_user_tries'],
							'total_user_tries_text'    => $quiz['total_user_tries_text'],
							'certificate_template'     => $quiz['certificate_template'],
							'social_media'             => $quiz['social_media'],
							'social_media_text'        => $quiz['social_media_text'],
							'pagination'               => $quiz['pagination'],
							'pagination_text'          => $quiz['pagination_text'],
							'timer_limit'              => $quiz['timer_limit'],
							'quiz_stye'                => $quiz['quiz_stye'],
							'question_numbering'       => $quiz['question_numbering'],
							'quiz_settings'            => $quiz_settings,
							'theme_selected'           => $quiz['theme_selected'],
							'last_activity'            => date( 'Y-m-d H:i:s' ),
							'require_log_in'           => $quiz['require_log_in'],
							'require_log_in_text'      => $quiz['require_log_in_text'],
							'limit_total_entries'      => $quiz['limit_total_entries'],
							'limit_total_entries_text' => $quiz['limit_total_entries_text'],
							'scheduled_timeframe'      => $quiz['scheduled_timeframe'],
							'scheduled_timeframe_text' => $quiz['scheduled_timeframe_text'],
							'quiz_views'               => $quiz['quiz_views'],
							'quiz_taken'               => $quiz['quiz_taken'],
							'deleted'                  => 0,
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
						$stats['failed'][] = $quiz['quiz_id'];
						$stats['error'][]  = $wpdb->last_error . ' from ' . $wpdb->last_query . ' quiz name:' . $quiz['quiz_name'];
					} else {

						// Create quiz post for inserted quiz.
						$new_quiz     = $wpdb->insert_id;
						if ( isset($quiz['answer_labels']) && ! empty($quiz['answer_labels']) && taxonomy_exists('qsm-answer-label') ) {
							$exported_answer_labels = maybe_unserialize($quiz['answer_labels']);

							$merged_labels = array(); // To store the final merged labels with term_id as the key
							$term_id_map = array(); // To map old term_id to new term_id

							// Get all existing terms from the taxonomy
							$existing_labels = get_terms(
								array(
									'taxonomy'   => 'qsm-answer-label',
									'hide_empty' => false,
								)
							);

							// Prepare an array of existing label names for comparison and store their details with term_id as key
							$existing_label_names = array();
							foreach ( $existing_labels as $existing_label ) {
								$existing_label_names[ strtolower( $existing_label->name ) ] = array(
									'id'        => $existing_label->term_id,
									'name'      => $existing_label->name,
									'slug'      => $existing_label->slug,
									'is_global' => '', // Default assumption; update if needed
								);

								// Store in the merged array using term_id as key
								$merged_labels[ $existing_label->term_id ] = $existing_label_names[ strtolower( $existing_label->name ) ];
							}

							// Loop through the exported answer labels and check for duplicates by name
							foreach ( $exported_answer_labels as $exported_label ) {
								$exported_label_name = strtolower( $exported_label['name'] ); // Normalize to lowercase

								if ( ! array_key_exists( $exported_label_name, $existing_label_names ) ) {
									// If the term name doesn't exist, create it
									$new_term = wp_insert_term(
										$exported_label['name'], // The name of the term
										'qsm-answer-label',      // The taxonomy
										array(
											'slug' => $exported_label['slug'], // Optionally use the exported slug
										)
									);

									// Check if term was created successfully
									if ( ! is_wp_error( $new_term ) ) {
										// Store the new term's details into the merged array using term_id as key
										$new_term_id = $new_term['term_id'];
										$merged_labels[ $new_term_id ] = array(
											'id'        => $new_term_id,
											'name'      => $exported_label['name'],
											'slug'      => $exported_label['slug'],
											'is_global' => isset($exported_label['is_global']) && 1 == $exported_label['is_global'] ? 'all' : '',
										);

										// Map old term_id to the new term_id
										if ( isset($exported_label['id']) && $exported_label['id'] ) {
											$term_id_map[ $exported_label['id'] ] = $new_term_id;
										}
									}
								} else {
									// If the term already exists, ensure it is added to the merged array by term_id
									$existing_term_id = $existing_label_names[ $exported_label_name ]['id'];
									$merged_labels[ $existing_term_id ] = array(
										'id'        => $existing_term_id,
										'name'      => $existing_label_names[ $exported_label_name ]['name'],
										'slug'      => $existing_label_names[ $exported_label_name ]['slug'],
										'is_global' => isset($exported_label['is_global']) && 1 == $exported_label['is_global'] ? 'all' : '',
									);

									// Map old term_id to the same term_id (if no change, but still track)
									if ( isset($exported_label['id']) && $exported_label['id'] ) {
										$term_id_map[ $exported_label['id'] ] = $existing_term_id;
									}
								}
							}
						
							if ( ! empty( $term_id_map ) ) {
								foreach ( $quiz['questions'] as $question_key => $question ) {
									// Unserialize the answer array for the question
									$unserialized_answer_array = maybe_unserialize( $question['answer_array'] );

									if ( ! empty( $unserialized_answer_array ) ) {
										// Iterate through the answers in the answer array
										foreach ( $unserialized_answer_array as $ans_question_key => $ans_question_value ) {
											if ( isset( $ans_question_value['answer_label'] ) && "" != $ans_question_value['answer_label'] ) {
												// Unserialize the answer labels
												$answer_label = maybe_unserialize( $ans_question_value['answer_label'] );
												$updated_answer_label = array(); // Initialize the updated answer label array

												// Loop through the answer labels and update with the new term_id
												foreach ( $answer_label as $ans_label_key => $ans_label_value ) {
													if ( isset( $term_id_map[ $ans_label_key ] ) ) {
														// The mapped new term_id
														$updated_term_id = $term_id_map[ $ans_label_key ];

														// Update answer label with the new term_id
														$updated_answer_label[ $updated_term_id ] = $ans_label_value;

														// Check if the term is global (from the $merged_labels array)
														$is_global = $merged_labels[ $updated_term_id ]['is_global'];
														
													} else {
														// If no mapping, retain the existing label
														$updated_answer_label[ $ans_label_key ] = $ans_label_value;

														// Check if the original term is global and update accordingly
														$is_global = $merged_labels[ $ans_label_key ]['is_global'];

														// Set the term_id to the original one since no mapping exists
														$updated_term_id = $ans_label_key;
													}

													// Update term meta based on whether it's global or not
													if ( 'all' == $is_global ) {
														update_term_meta( $updated_term_id, 'qsm_quiz', array( 'all' ) );
													} else {
														update_term_meta( $updated_term_id, 'qsm_quiz', array( $new_quiz ) );
													}
												}

												// Serialize and update the answer label back into the question's answer array
												$unserialized_answer_array[ $ans_question_key ]['answer_label'] = maybe_serialize( $updated_answer_label );
											}
										}

										// Serialize the entire updated answer array and assign back to the question
										$quiz['questions'][ $question_key ]['answer_array'] = maybe_serialize( $unserialized_answer_array );
									}
								}
							}                           
						}
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
						$stats['imported'][ $quiz['quiz_id'] ] = array(
							'quiz_name' => $quiz['quiz_name'],
							'id'        => $new_quiz,
							'post_id'   => $quiz_post_id,
						);
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
												'theme_id' => $theme['id'],
												'quiz_id'  => $new_quiz,
												'quiz_theme_settings' => $exported_themes[ $key ][1],
												'active_theme' => $exported_themes[ $key ][2],
											),
											array( '%d', '%d', '%s', '%d' )
										);
									}
								}
							}
						}

						// Update quiz settings.
						$update_quiz_settings = maybe_unserialize( $quiz_settings );
						$update_pages         = maybe_unserialize( $update_quiz_settings['pages'] );
						$update_pages         = ( empty( $update_pages ) || ! is_array( $update_pages ) ) ? array() : $update_pages;
						$update_q_pages       = maybe_unserialize( $update_quiz_settings['qpages'] );
						$update_q_pages       = ( empty( $update_q_pages ) || ! is_array( $update_q_pages ) ) ? array() : $update_q_pages;
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
							$results    = $wpdb->insert(
								$wpdb->prefix . 'mlw_questions',
								array(
									'quiz_id'              => $new_quiz,
									'question_name'        => $question['question_name'],
									'answer_array'         => $question['answer_array'],
									'answer_one'           => $question['answer_one'],
									'answer_one_points'    => $question['answer_one_points'],
									'answer_two'           => $question['answer_two'],
									'answer_two_points'    => $question['answer_two_points'],
									'answer_three'         => $question['answer_three'],
									'answer_three_points'  => $question['answer_three_points'],
									'answer_four'          => $question['answer_four'],
									'answer_four_points'   => $question['answer_four_points'],
									'answer_five'          => $question['answer_five'],
									'answer_five_points'   => $question['answer_five_points'],
									'answer_six'           => $question['answer_six'],
									'answer_six_points'    => $question['answer_six_points'],
									'correct_answer'       => $question['correct_answer'],
									'question_answer_info' => $question['question_answer_info'],
									'comments'             => $question['comments'],
									'hints'                => empty( $question['hints'] ) ? '' : $question['hints'],
									'question_order'       => $question['question_order'],
									'question_type_new'    => $question['question_type_new'],
									'question_settings'    => htmlspecialchars_decode( $question['question_settings'], ENT_QUOTES | ENT_HTML5 ),
									'category'             => $question['category'],
									'deleted'              => $question['deleted'],
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
							// old and new question id
							$stats['imported'][ $quiz['quiz_id'] ]['questions'][ $question['question_id'] ] = $questionID;
							foreach ( $update_pages as $pages_key => $pages_value ) {
								foreach ( $pages_value as $pages_k_q => $page_q_id ) {
									if ( $page_q_id == $question['question_id'] ) {
										$update_pages[ $pages_key ][ $pages_k_q ]                = $questionID;
										$update_q_pages[ $pages_key ]['questions'][ $pages_k_q ] = $questionID;
										$update_q_pages[ $pages_key ]['quizID'] = $new_quiz;
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
								$stats['error'][] = $wpdb->last_error . ' from ' . $wpdb->last_query;
							}
						}
						$update_quiz_settings['pages']  = maybe_serialize( $update_pages );
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
							if ( ! empty( $values ) ) {
								$query = "INSERT INTO $logic_table (quiz_id, logic) VALUES $values";
								$saved = $wpdb->query( $query );
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
					}
				}
				if ( ! empty( $stats['error'] ) ) {
					$stats['log_link'] = array(
						$this->log_error(
							__( 'Error importing quiz QSM - Export & Import', 'qsm-export-import' ),
							$stats
						),
					);
					if ( ! empty( $stats['log_link'] ) ) {
						unset( $stats['error'] );
					}
				}

				// Update imported quiz
				if ( ! empty( $stats['imported'] ) ) {
					$this->imported_quiz_stats( $stats['imported'] );
					$stats['imported'] = array_keys( $stats['imported'] );
				}

				wp_send_json_success( $stats );
			} catch ( Throwable $e ) {
				wp_send_json_error( __( 'Failed to import quiz. ', 'qsm-export-import' ) . $e->getMessage() . __( '. Error file ', 'qsm-export-import' ) . $e->getFile() . __( ' line number ', 'qsm-export-import' ) . $e->getLine() );
			}
		}

		/**
		 * Sanitize array recursively
		 *
		 * @param array   $array array to sanitize
		 * @param boolean $textarea_sanitize either use textarea_sanitize or text sanitize
		 * @since 2.1.2
		 *
		 * @return array sanitized array
		 */
		public function sanitize_array( $array, $textarea_sanitize = false ) {
			if ( ! empty( $array ) && is_array( $array ) ) {
				foreach ( (array) $array as $key => $value ) {
					if ( is_array( $value ) ) {
						$array[ $key ] = $this->sanitize_array( $value );
					} else {
						$array[ $key ] = true === $textarea_sanitize ? sanitize_textarea_field( $value ) : sanitize_text_field( $value );
					}
				}
			}
			return $array;
		}
		/**
		 * Import results
		 *
		 * @since 2.1.2
		 */
		public function import_results() {
			$error = $this->is_error( 'results' );
			if ( false !== $error ) {
				wp_send_json_error( $error );
			}

			try {
				global $mlwQuizMasterNext, $qmnQuizManager, $wpdb;

				// stats of failed, imported, error log
				$stats = array(
					'failed'   => array(),
					'imported' => array(),
					'error'    => array(),
					'log_link' => array(),
				);

				foreach ( $_POST['results'] as $result ) {
					// decode data
					$result = json_decode( wp_unslash( $result ), true );
					// deep sanitization
					// $result = $this->sanitize_array( $result, true );

					// check for required data
					if ( empty( $result['result_id'] ) || empty( $result['quiz_id'] ) || ! is_numeric( $result['quiz_id'] ) || empty( $result['qmn_array_for_variables'] ) || empty( $result['results_array'] ) ) {
						wp_send_json_success( __( 'Invalid file', 'qsm-export-import' ) );
					}

					if ( empty( $result['unique_id'] ) ) {
						$result['unique_id'] = uniqid();
					}

					$res = $qmnQuizManager->add_quiz_results( $result );

					if ( false === $res ) {
						$stats['failed'][] = $result['result_id'];
						$stats['error'][]  = $wpdb->last_error . ' from ' . $wpdb->last_query;
					} else {
						$stats['imported'][ $result['result_id'] ] = array(
							'id'        => $wpdb->insert_id,
							'unique_id' => $result['unique_id'],
						);
					}
				}

				if ( ! empty( $stats['error'] ) ) {
					$stats['log_link'] = array(
						$this->log_error(
							__( 'Error importing responses QSM - Export & Import', 'qsm-export-import' ),
							$stats,
							'result'
						),
					);
					if ( ! empty( $stats['log_link'] ) ) {
						unset( $stats['error'] );
					}
				}

				// Update imported quiz
				if ( ! empty( $stats['imported'] ) ) {
					$this->imported_quiz_stats( $stats['imported'], 'results' );
					$stats['imported'] = array_keys( $stats['imported'] );
				}

				wp_send_json_success( $stats );
			} catch ( Throwable $th ) {
				wp_send_json_error( __( 'Failed to import response. ', 'qsm-export-import' ) . $th->getMessage() );
			}
		}
	}

	$qsm_import_export_quiz = new QSM_Import_Export_Quiz();
}
