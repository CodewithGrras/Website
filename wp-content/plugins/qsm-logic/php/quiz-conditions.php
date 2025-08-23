<?php
if ( ! defined('ABSPATH') ) {
	exit;
}
if ( ! class_exists('QSMQuizConditions') ) {

	class QSMQuizConditions {

		public function __construct() {
			add_action('admin_enqueue_scripts', array( &$this, 'admin_enqueue_scripts' ), 9999);

			add_action( 'qsm_results_page_condition_category', array( $this, 'qsm_add_page_condition' ) );
			add_action( 'qsm_email_page_condition_category', array( $this, 'qsm_add_page_condition' ) );
			add_action('qsm_email_condition_operator', array( &$this, 'qsm_add_condition_operator' ));
			add_action('qsm_email_condition_value', array( &$this, 'qsm_add_condition_value' ));

			add_action('qsm_results_page_condition_operator', array( &$this, 'qsm_add_condition_operator' ));
			add_action('qsm_results_page_condition_value', array( &$this, 'qsm_add_condition_value' ));

			add_filter('qsm_email_condition_check', array( &$this, 'qsm_condition_check' ), 999, 3);
			add_filter('qsm_results_page_condition_check', array( &$this, 'qsm_condition_check' ), 999, 3);
		}

		public function admin_enqueue_scripts( $hook_suffix ) {
			global $mlwQuizMasterNext;
			if ( 'admin_page_mlw_quiz_options' == $hook_suffix ) {
				if ( 'emails' == isset($_REQUEST['tab']) && $_REQUEST['tab'] ) {
					wp_enqueue_script('qsm_logic_email_conditions_admin', plugins_url('../js/qsm-email-conditions-admin.js', __FILE__), array( 'qsm_admin_js' ), $mlwQuizMasterNext->version, true);
				}
				if ( 'results-pages' == isset($_REQUEST['tab']) && $_REQUEST['tab'] ) {
					wp_enqueue_script('qsm_logic_result_conditions_admin', plugins_url('../js/qsm-result-conditions-admin.js', __FILE__), array( 'qsm_admin_js' ), $mlwQuizMasterNext->version, true);
				}
			}
		}

		/**
		* add field in result addon
		*
		* @return void
		* @since 2.1.3
		*/
		public function qsm_add_page_condition() {
			?>
			<option value="question" class="qsm-logic-condition" <# if (data.category == 'question' || data.criteria == 'question' ) { #>selected<# } #>><?php esc_attr_e('Questions', 'quiz-logic'); ?></option>
			<?php
		}

		public function qsm_add_condition_operator() {
			if ( is_admin() && isset($_REQUEST['quiz_id']) ) {
				global $wpdb;
				global $mlwQuizMasterNext;
				$quiz_id = intval( $_REQUEST['quiz_id'] );
				$questions = QSM_Questions::load_questions_by_pages( $quiz_id );
				if ( ! empty($questions) ) {
					foreach ( $questions as $q ) {
						$q_id = $q['question_id'];
						$question_type = $q['question_type_new'];
						$q_title = $q['settings']['question_title'];
						if ( empty( $q_title ) && ! empty( $q['question_name'] ) ) {
							$q_title = substr( wp_strip_all_tags( htmlspecialchars_decode($q['question_name'], ENT_QUOTES ) ) , 0, 100);
						}
						?>
						<option class="question_operator" value="<?php echo esc_attr( $q_id ); ?>" data-type="<?php echo esc_attr( $question_type ); ?>" style="display:none;" <# if (data.operator == '<?php echo esc_attr( $q_id ); ?>') { #>selected<# } #>><?php echo esc_html( $q_title ); ?></option>
						<?php
					}
				}
			}
		}

		public function qsm_add_condition_value() {
			if ( is_admin() && isset($_REQUEST['quiz_id']) ) {
				global $wpdb;
				global $mlwQuizMasterNext;
				$quiz_id = intval( $_REQUEST['quiz_id'] );
				$questions = QSM_Questions::load_questions_by_pages( $quiz_id );
				$condition_value_field = '';
				if ( ! empty($questions) ) {
					?>
					<div class="condition-question-value-container qsm-result-condition-container-inner" style="display: none;">
						<label class="qsm-result-condition-title"><?php esc_html_e( 'Answers', 'quiz-master-next' ); ?></label>
						<select class="email-condition-value results-page-condition-value condition-question-value">
						<?php
						foreach ( $questions as $question ) {
							$q_id = $question['question_id'];
							$answers = maybe_unserialize( $question['answer_array'] );
							if ( ! empty($answers) ) {
								foreach ( $answers as $key => $value ) {
									?>
									<option class="criteria_question_value" value="<?php echo esc_attr( $q_id . '-' . $key ); ?>" data-qid="<?php echo esc_attr( $q_id ); ?>" <# if (data.value == "<?php echo esc_attr( $q_id . '-' . $key ); ?>" && data.operator == "<?php echo esc_attr( $q_id ); ?>") { #>selected<# } #> ><?php echo esc_attr( $value[0] ); ?></option>
									<?php
								}
							}
						}
						?>
						</select>
					</div>
					<?php
				}
			}
		}

		public function qsm_condition_check( $show, $condition, $response_data ) {
			if ( 'question' == $condition['criteria'] || 'question' == $condition['category'] ) {
				$show = false;
				$question_id = $condition['operator'];
				$answer = $condition['value'];
				$question_answers_array = isset($response_data['question_answers_array']) ? $response_data['question_answers_array'] : array();
				foreach ( $question_answers_array as $answers ) {
					if ( isset($answers['user_answer']) ) {
						$user_answer = $answers['user_answer'];
						$answer = str_replace( $question_id.'-', '', $answer );
						if ( $question_id === $answers['id'] && array_key_exists( intval( $answer ), $user_answer ) ) {
							$show = true;
						}
					}
				}
			}
			return $show;
		}

	}

}
global $QSMQuizConditions;
$QSMQuizConditions = new QSMQuizConditions();
