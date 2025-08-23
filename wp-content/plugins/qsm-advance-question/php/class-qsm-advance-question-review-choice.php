<?php

class QSM_Advance_Question_Review_Choice extends QSM_Question_Review_Choice {

	function __construct( $question_id = 0, $question_title_old = '', $answer_array = array() ) {
		parent::__construct( $question_id, $question_title_old, $answer_array );
	}

	public function set_user_answer() {
		global $mlwQuizMasterNext;
		if ( isset( $_POST[ 'question' . $this->question_id ] ) ) {
			$user_response = wp_unslash( $_POST[ 'question' . $this->question_id ] ); // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized
			foreach ( $user_response as $user_answer_key => $user_answer_value ) {
                $user_answer_value                     = $this->sanitize_answer_from_post( $user_answer_value );
                $this->user_answer[ $user_answer_key ] = $user_answer_value;
            }           
		}
	}

	public function set_answer_status() {
		global $mlwQuizMasterNext;
		$user_correct_ans  = 0;

        foreach ( $this->answer_array as $answer_key => $answer_value ) {
            $this->correct_answer[ $answer_key ] = $this->sanitize_answer_from_db( $answer_value[0] );
        }

        $total_user_answers   = sizeof( $this->user_answer );
        $total_correct_answer = sizeof( $this->correct_answer );
        
		$temp_answer = [];
		foreach ( $this->correct_answer as $index => $answer ) {
			$temp_answer[] = $mlwQuizMasterNext->pluginHelper->qsm_language_support( $answer, "answer-" . $this->question_id . "-" . $index, "QSM Answers" );
		}
		$this->correct_answer = $temp_answer;
        
        if ( $total_user_answers <= $total_correct_answer ) {
            foreach ( $this->user_answer as $user_answer_key => $user_answer ) {
                if ( $user_answer === $this->correct_answer[ $user_answer_key ] ) {
                    $user_correct_ans++;
                    $this->points       += $this->answer_array[ $user_answer_key ][1];
                }
            }
        } else {
            foreach ( $this->correct_answer as $correct_answer_key => $correct_answer ) {
                if ( $correct_answer === $this->user_answer[ $correct_answer_key ] ) {
                    $user_correct_ans++;
                    $this->points       += $this->answer_array[ $correct_answer_key ][1];
                }
            }
        }
        if ( ( $this->correct_answer_logic && $total_user_answers === $user_correct_ans ) || ( ! $this->correct_answer_logic && 0 < $user_correct_ans ) ) {
            $this->answer_status = 'correct';
        }   
	}
}
