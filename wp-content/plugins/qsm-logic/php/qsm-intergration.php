<?php
/**
 * Adds the logic JavaScript function to the enqueue in the quiz
 *
 * @since 0.1.0
 * @return string The HTML of the quiz
 */
function qsm_addon_logic_script_integration( $display, $qmn_quiz_options, $qmn_array_for_variables ) {
	global $mlwQuizMasterNext;
	global $wpdb;
	$quiz_id      = $qmn_quiz_options->quiz_id;
	$table_exists = get_option( "logic_rules_quiz_$quiz_id" );
	if ( empty( $table_exists ) ) {
		$logic_rules = $mlwQuizMasterNext->pluginHelper->get_quiz_setting( 'logic_rules' );
	} else {
		$query             = "SELECT id, logic FROM {$wpdb->prefix}mlw_logic where quiz_id = %d";
		$logic_rules_data  = $wpdb->get_results( $wpdb->prepare( $query, $quiz_id ) );
		$logic_rules_array = array();
		foreach ( $logic_rules_data as $data ) {
			$logic_rules_array[] = maybe_unserialize( $data->logic );
		}
		$logic_rules = maybe_serialize( $logic_rules_array );
	}
	$unserialize_logic_rule    = $logic_rules ? maybe_unserialize( $logic_rules ) : array();
	$unserialize_logic_quiz_id = isset( $qmn_array_for_variables['quiz_id'] ) ? $qmn_array_for_variables['quiz_id'] : 0;
	if ( version_compare( $mlwQuizMasterNext->version, '7.3.8', '>' ) ) {
		$unserialize_logic_rule    = qsm_map_logic_rules_to_answer_keys( $unserialize_logic_rule );
	}
	wp_enqueue_script( 'qsm_logic_quiz_script', plugins_url( '../js/qsm-logic-quiz.js', __FILE__ ), array( 'jquery', 'qsm_quiz' ), QSM_LOGIC_VERSION, true );
	wp_localize_script( 'qsm_logic_quiz_script', 'qsm_logic_object', $unserialize_logic_rule );
	wp_localize_script( 'qsm_logic_quiz_script', 'qsm_logic_quiz_id', array( 'quiz_id' => $unserialize_logic_quiz_id ) );
	$display .= '
        if (window.qmn_quiz_data_new === undefined) {
                window.qmn_quiz_data_new = new Object();
        }';
	$display .= 'window.qmn_quiz_data_new["' . $unserialize_logic_quiz_id . '"] = ' . wp_json_encode( $unserialize_logic_rule );
	wp_add_inline_script( 'qsm_logic_quiz_script', $display, 'before');
}

function qsm_map_logic_rules_to_answer_keys( $logic_rules ) {

	if ( empty( $logic_rules ) ) {
		return $logic_rules;
	}
	foreach ( $logic_rules as $rule_id => $rule ) {
		if ( isset( $rule['if'] ) && ! empty( $rule['if'] ) ) {
			$if_conditions = $rule ['if'];
			foreach ( $if_conditions as $if_condition_id => $if_condition ) {
				$answer_from_rule   = $if_condition['answer'];
				$question_id        = $if_condition['question'];
				$serialized_answers = QSM_Questions::load_question_data( $question_id, 'answer_array' );
				$question_type      = QSM_Questions::load_question_data( $question_id, 'question_type_new' );
				$answers_from_db    = maybe_unserialize( $serialized_answers );
				if ( ! in_array( intval( $question_type ), array( 3, 5 ), true ) ) {
					if ( ! empty($answers_from_db) ) {
						foreach ( $answers_from_db as $answer_key_from_db => $answer_from_db ) {
							if ( 0 === strcmp(qsm_logic_string_matching($answer_from_rule), qsm_logic_string_matching($answer_from_db[0])) ) {
								$logic_rules[ $rule_id ]['if'][ $if_condition_id ]['answer'] = $answer_key_from_db;
							}
						}
					}
				}
			}
		}
	}
	return $logic_rules;
}

function qsm_logic_string_matching( $data ) {
	return trim( stripslashes( htmlspecialchars_decode( sanitize_text_field( $data ), ENT_QUOTES ) ) );
}

