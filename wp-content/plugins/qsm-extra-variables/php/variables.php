<?php
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Generates your template variable
 *
 * @since 1.1.0
 * @param string $content The string from various templates including email and results pages
 * @param array $quiz_array An array of the results from the quiz/survey that was completed
 * @return string The string to be used in email, results page, social sharing, etc..
 */
function qsm_addon_extra_variables_group_by_answer( $content, $quiz_array ) {
  global $wpdb, $mlwQuizMasterNext;
  $question_answer_template = $mlwQuizMasterNext->pluginHelper->get_section_setting('quiz_text', 'question_answer_template', '%QUESTION%<br/>%USER_ANSWERS_DEFAULT%');

  while ( preg_match("~%QUESTION_ANSWER_GROUP%(.*?)%/QUESTION_ANSWER_GROUP%~i", $content, $matches) ) {
    $display_return = qsm_get_answer_group_display_return($matches[1], $quiz_array, $question_answer_template);
    $content = str_replace($matches[0], $display_return, $content);
  }

  while ( preg_match("~%QUESTION_ANSWER_GROUP_(.*?)%~i", $content, $matches) ) {
    $answer_value = $matches[1];
    $display_return = qsm_get_answer_group_display_return($answer_value, $quiz_array, $question_answer_template);
    $content = str_replace('%QUESTION_ANSWER_GROUP_' . $answer_value . '%', $display_return, $content);
  }

  return $content;
}

function qsm_get_answer_group_display_return( $answer_value, $quiz_array, $question_answer_template ) {
  global $wpdb;
  $display_return = '';
  $questions = QSM_Questions::load_questions_by_pages( $quiz_array['quiz_id'] );
  $qmn_questions = array();
  foreach ( $questions as $question ) {
    $qmn_questions[ $question['question_id'] ] = $question['question_answer_info'];
  }
  $total_question_cnt = count($quiz_array['question_answers_array']);
  $qsm_question_cnt = 1;
  foreach ( $quiz_array['question_answers_array'] as $answer ) {
    if ( strtoupper(htmlspecialchars_decode($answer[1], ENT_QUOTES)) == strtoupper($answer_value) ) {
      $display_return .= qsm_questions_answers_shortcode_to_text($quiz_array, $question_answer_template, $questions, $qmn_questions, $answer, $qsm_question_cnt, $total_question_cnt);
      $qsm_question_cnt++;
    }
  }
  return $display_return;
}

/**
 * Generates your template variable
 *
 * @since 1.1.0
 * @param string $content The string from various templates including email and results pages
 * @param array $quiz_array An array of the results from the quiz/survey that was completed
 * @return string The string to be used in email, results page, social sharing, etc..
 */
function qsm_addon_extra_variables_incorrect_answers( $content, $quiz_array ) {
	global $mlwQuizMasterNext;
	$logic_rules      = $mlwQuizMasterNext->pluginHelper->get_quiz_setting( 'logic_rules' );
	$logic_rules      = qmn_sanitize_input_data( $logic_rules );
	$hidden_questions = isset( $quiz_array['hidden_questions'] ) ? $quiz_array['hidden_questions'] : array();

	if ( empty( $hidden_questions ) ) {
		$hidden_questions = isset( $quiz_array['results']['hidden_questions'] ) ? $quiz_array['results']['hidden_questions'] : array();
	}

	// While the variable is in content
	while ( false !== strpos( $content, '%QUESTION_ANSWER_INCORRECT%' ) ) {
		$display = '';
		global $wpdb;

		// Retieve template
		if ( isset( $quiz_array['quiz_settings'] ) && ! empty( $quiz_array['quiz_settings'] ) ) {
			$quiz_text_settings           = isset( $quiz_array['quiz_settings']['quiz_text'] ) ? @unserialize( stripslashes( $quiz_array['quiz_settings']['quiz_text'] ) ) : array();
			$qmn_question_answer_template = isset( $quiz_text_settings['question_answer_template'] ) ? apply_filters( 'qsm_section_setting_text', $quiz_text_settings['question_answer_template'] ) : $mlwQuizMasterNext->pluginHelper->get_section_setting( 'quiz_text', 'question_answer_template', '%QUESTION%<br/>%USER_ANSWERS_DEFAULT%' );
		} else {
			$qmn_question_answer_template = $mlwQuizMasterNext->pluginHelper->get_section_setting( 'quiz_text', 'question_answer_template', '%QUESTION%<br/>%USER_ANSWERS_DEFAULT%' );
		}

		// Retieve questions and create array with ID as key
		$questions     = QSM_Questions::load_questions_by_pages( $quiz_array['quiz_id'] );
		$qmn_questions = array();
		foreach ( $questions as $question ) {
			$qmn_questions[ $question['question_id'] ] = $question['question_answer_info'];
		}

		// Cycle through question responses in results
		$total_question_cnt = count( $quiz_array['question_answers_array'] );
		$qsm_question_cnt   = 1;
		foreach ( $quiz_array['question_answers_array'] as $answer ) {
			if ( in_array( $answer['id'], $hidden_questions, true ) ) {
				continue;
			}

			if ( 'incorrect' == $answer['correct'] ) {
				$display .= qsm_questions_answers_shortcode_to_text( $quiz_array, $qmn_question_answer_template, $questions, $qmn_questions, $answer, $qsm_question_cnt, $total_question_cnt );
				$qsm_question_cnt++;
			}
		}
		$display = "<div class='qsm_questions_answers_section'>{$display}</div>";

		$content = str_replace( '%QUESTION_ANSWER_INCORRECT%', $display, $content );
	}

	// Returns the content
	return $content;
}

/**
 * Generates your template variable
 *
 * @since 1.1.0
 * @param string $content The string from various templates including email and results pages
 * @param array $quiz_array An array of the results from the quiz/survey that was completed
 * @return string The string to be used in email, results page, social sharing, etc..
 */
function qsm_addon_extra_variables_correct_answers( $content, $quiz_array ) {

  // While the variable is in content
  while ( false !== strpos( $content, '%QUESTION_ANSWER_CORRECT%' ) ) {
    $display_return = '';
    global $wpdb, $mlwQuizMasterNext;

    // Retieve template
    if ( isset( $quiz_array['quiz_settings'] ) && ! empty($quiz_array['quiz_settings']) ) {
        $quiz_text_settings = isset( $quiz_array['quiz_settings']['quiz_text'] ) ? @unserialize( stripslashes( $quiz_array['quiz_settings']['quiz_text'] ) ) : array();
        $qmn_question_answer_template = isset( $quiz_text_settings['question_answer_template'] ) ? apply_filters('qsm_section_setting_text', $quiz_text_settings['question_answer_template']) : $mlwQuizMasterNext->pluginHelper->get_section_setting( 'quiz_text', 'question_answer_template', '%QUESTION%<br/>%USER_ANSWERS_DEFAULT%' );
    }else {
        $qmn_question_answer_template = $mlwQuizMasterNext->pluginHelper->get_section_setting( 'quiz_text', 'question_answer_template', '%QUESTION%<br/>%USER_ANSWERS_DEFAULT%' );
    }

    // Retieve questions and create array with ID as key
    $questions = QSM_Questions::load_questions_by_pages( $quiz_array['quiz_id'] );
    $qmn_questions = array();
    foreach ( $questions as $question ) {
            $qmn_questions[ $question['question_id'] ] = $question['question_answer_info'];
    }

    // Cycle through question responses in results
    $total_question_cnt = count( $quiz_array['question_answers_array'] );
    $qsm_question_cnt = 1;
    foreach ( $quiz_array['question_answers_array'] as $answer ) {
      if ( 'correct' == $answer["correct"] ) {
        $display_return .= qsm_questions_answers_shortcode_to_text($quiz_array, $qmn_question_answer_template, $questions, $qmn_questions, $answer, $qsm_question_cnt, $total_question_cnt);
        $qsm_question_cnt++;
      }
    }
    $content = str_replace( '%QUESTION_ANSWER_CORRECT%' , $display_return, $content );
  }

  // Returns the content
  return $content;
}

/**
 * Generates your template variable
 *
 * @since 1.1.0
 * @param string $content The string from various templates including email and results pages
 * @param array $quiz_array An array of the results from the quiz/survey that was completed
 * @return string The string to be used in email, results page, social sharing, etc..
 */
function qsm_addon_extra_variables_custom_message_points( $content, $quiz_array ) {
  // Loop for %CUSTOM_MESSAGE_POINTS%
  while ( preg_match("~%CUSTOM_MESSAGE_POINTS%(.*?)%/CUSTOM_MESSAGE_POINTS%~i", $content, $match) ) {
      $replace_text = '';
      preg_match_all("~(.*?):(.*?)-(.*?);~i", $match[1], $matches);

      // Loop through messages
      foreach ( $matches[0] as $key => $value ) {
          if ( $quiz_array["total_points"] >= $matches[2][ $key ] && $quiz_array["total_points"] <= $matches[3][ $key ] ) {
              $replace_text = $matches[1][ $key ];
              break;
          }
      }

      $content = str_replace($match[0], $replace_text, $content);
  }

  // Loop for %CUSTOM_MESSAGE_POINTS_X
  while ( preg_match("~%CUSTOM_MESSAGE_POINTS_(.*?)%~i", $content, $match) ) {
      $points_text = $match[1];
      $replace_text = '';
      preg_match_all("~(.*?):(.*?)-(.*?);~i", $points_text, $matches);

      // Loop through messages
      foreach ( $matches[0] as $key => $value ) {
          if ( $quiz_array["total_points"] >= $matches[2][ $key ] && $quiz_array["total_points"] <= $matches[3][ $key ] ) {
              $replace_text = $matches[1][ $key ];
              break;
          }
      }

      $content = str_replace('%CUSTOM_MESSAGE_POINTS_' . $points_text . '%', $replace_text, $content);
  }

  return $content;
}

/**
 * Generates your template variable
 *
 * @since 1.1.0
 * @param string $content The string from various templates including email and results pages
 * @param array $quiz_array An array of the results from the quiz/survey that was completed
 * @return string The string to be used in email, results page, social sharing, etc..
 */
function qsm_addon_extra_variables_custom_message_correct( $content, $quiz_array ) {
  // Loop for %CUSTOM_MESSAGE_CORRECT%
  while ( preg_match("~%CUSTOM_MESSAGE_CORRECT%(.*?)%/CUSTOM_MESSAGE_CORRECT%~i", $content, $match) ) {
      $replace_text = '';
      preg_match_all("~(.*?):(.*?)-(.*?);~i", $match[1], $matches);

      // Cycle through all messages
      foreach ( $matches[0] as $key => $value ) {
          // If score is between message values, use message
          if ( $quiz_array["total_score"] >= $matches[2][ $key ] && $quiz_array["total_score"] <= $matches[3][ $key ] ) {
              $replace_text = $matches[1][ $key ];
              break;
          }
      }

      $content = str_replace($match[0], $replace_text, $content);
  }

  // Loop for %CUSTOM_MESSAGE_CORRECT_X
  while ( preg_match("~%CUSTOM_MESSAGE_CORRECT_(.*?)%~i", $content, $match) ) {
      $score_text = $match[1];
      $replace_text = '';
      preg_match_all("~(.*?):(.*?)-(.*?);~i", $score_text, $matches);

      // Cycle through all messages
      foreach ( $matches[0] as $key => $value ) {
          // If score is between message values, use message
          if ( $quiz_array["total_score"] >= $matches[2][ $key ] && $quiz_array["total_score"] <= $matches[3][ $key ] ) {
              $replace_text = $matches[1][ $key ];
              break;
          }
      }

      $content = str_replace('%CUSTOM_MESSAGE_CORRECT_' . $score_text . '%', $replace_text, $content);
  }

  return $content;
}

/**
 * Generates your template variable
 *
 * @since 1.1.1
 * @param string $content The string from various templates including email and results pages
 * @param array $quiz_array An array of the results from the quiz/survey that was completed
 * @return string return the question's answer point
 *
 * Use %QUESTION_POINT% in %QUESTIONS_ANSWERS% Text option
 */

function qsm_addon_extra_variables_custom_question_point( $content, $quiz_array ) {
    $answer_arr = $quiz_array['question_answers_array'];
    while ( false !== strpos($content, '%QUESTION_POINT%') ) {
        $word_count = substr_count($content,"%QUESTION_POINT%");
        for ( $i = 0; $i <= $word_count; $i++ ) {
            $points = $answer_arr[ $i ]['points'];
            $content = preg_replace('/%QUESTION_POINT%/', $points, $content, 1);
        }
    }
    // Returns the content
    return $content;
}

function qsm_addon_extra_variable_display_result_date( $content, $mlw_quiz_array ) {
	global $mlwQuizMasterNext;

	$date                = '';
	$quiz_options        = $mlwQuizMasterNext->quiz_settings->get_quiz_options();
	$qsm_quiz_settings   = maybe_unserialize( $quiz_options->quiz_settings );
	$qsm_quiz_options    = maybe_unserialize( $qsm_quiz_settings['quiz_options'] );
	$qsm_global_settings = get_option( 'qsm-quiz-settings' );
  $preferred_date_format = get_option( 'date_format' );
	if ( isset( $qsm_quiz_options['preferred_date_format'] ) ) {
		$preferred_date_format = $qsm_quiz_options['preferred_date_format'];
	} elseif ( isset( $qsm_global_settings['preferred_date_format'] ) ) {
		$preferred_date_format = isset( $qsm_global_settings['preferred_date_format'] );
	} 
	
	if ( isset( $mlw_quiz_array['time_taken'] ) ) {
		$date = date_i18n( $preferred_date_format, strtotime( $mlw_quiz_array['time_taken'] ) );
	}
	$content = str_replace( '%SUBMISSION_DATE%', $date, $content );

	return $content;
}

/**
 * @since 1.0.0
 *
 * Converts the %QUESTION_ANSWER_ATTEMPTED% into the template
 *
 * @param string $content        The content to be checked for the template
 * @param array  $mlw_quiz_array The array for the response data
 * 
 * @return The attempted questions answers template.
 * 
 */

function qsm_addon_extra_variable_question_answers( $content, $mlw_quiz_array ) {
	global $mlwQuizMasterNext;
	$quiz_id = is_object( $mlw_quiz_array ) ? $mlw_quiz_array->quiz_id : $mlw_quiz_array['quiz_id'];
	$mlwQuizMasterNext->pluginHelper->prepare_quiz( $quiz_id );
	$logic_rules      = $mlwQuizMasterNext->pluginHelper->get_quiz_setting( 'logic_rules' );
	$logic_rules      = qmn_sanitize_input_data( $logic_rules );
	$hidden_questions = isset( $mlw_quiz_array['hidden_questions'] ) ? $mlw_quiz_array['hidden_questions'] : array();
	if ( empty( $hidden_questions ) ) {
		$hidden_questions = isset( $mlw_quiz_array['results']['hidden_questions'] ) ? $mlw_quiz_array['results']['hidden_questions'] : array();
	}
	// Checks if the variable is present in the content.
	while ( strpos( $content, '%QUESTION_ANSWER_ATTEMPTED%' ) !== false || strpos( $content, '%QUESTIONS_ANSWERS_EMAIL%' ) !== false ) {
		global $wpdb;
		$display = '';
		if ( strpos( $content, '%QUESTIONS_ANSWERS_EMAIL%' ) !== false ) {
			$qmn_question_answer_template = $mlwQuizMasterNext->pluginHelper->get_section_setting( 'quiz_text', 'question_answer_email_template', '%QUESTION%<br/>Answer Provided: %USER_ANSWER%<br/>Correct Answer: %CORRECT_ANSWER%<br/>Comments Entered: %USER_COMMENTS%' );
			if ( isset( $mlw_quiz_array['quiz_settings'] ) && ! empty( $mlw_quiz_array['quiz_settings'] ) ) {
				$quiz_text_settings           = isset( $mlw_quiz_array['quiz_settings']['quiz_text'] ) ? qmn_sanitize_input_data( $mlw_quiz_array['quiz_settings']['quiz_text'], true ) : array();
				$qmn_question_answer_template = isset( $quiz_text_settings['question_answer_email_template'] ) ? apply_filters( 'qsm_section_setting_text', $quiz_text_settings['question_answer_email_template'] ) : $qmn_question_answer_template;
			}
			$qmn_question_answer_template = $mlwQuizMasterNext->pluginHelper->qsm_language_support( $qmn_question_answer_template, "quiz_question_answer_email_template-{$quiz_id}" );
		} else {
			$qmn_question_answer_template = $mlwQuizMasterNext->pluginHelper->get_section_setting( 'quiz_text', 'question_answer_template', '%QUESTION%<br/>%USER_ANSWERS_DEFAULT%' );
			if ( isset( $mlw_quiz_array['quiz_settings'] ) && ! empty( $mlw_quiz_array['quiz_settings'] ) ) {
				$quiz_text_settings           = isset( $mlw_quiz_array['quiz_settings']['quiz_text'] ) ? qmn_sanitize_input_data( $mlw_quiz_array['quiz_settings']['quiz_text'], true ) : array();
				$qmn_question_answer_template = isset( $quiz_text_settings['question_answer_template'] ) ? apply_filters( 'qsm_section_setting_text', $quiz_text_settings['question_answer_template'] ) : $qmn_question_answer_template;
			}
			$qmn_question_answer_template = $mlwQuizMasterNext->pluginHelper->qsm_language_support( $qmn_question_answer_template, "quiz_question_answer_template-{$quiz_id}" );
		}
		$questions     = QSM_Questions::load_questions_by_pages( $mlw_quiz_array['quiz_id'] );
		
		$qmn_questions = array();
		foreach ( $questions as $question ) {
			$qmn_questions[ $question['question_id'] ] = $question['question_answer_info'];
		}

		// Cycles through each answer in the responses.
		$total_question_cnt = count( $mlw_quiz_array['question_answers_array'] );
		$qsm_question_cnt   = 1;
		foreach ( $mlw_quiz_array['question_answers_array'] as $answer ) {
			if ( ! empty( $hidden_questions ) && is_array( $hidden_questions ) && in_array( $answer['id'], $hidden_questions, true ) ) {
				continue;
			}
			if ( '' !== trim( $answer[1] ) ) {
				$display .= qsm_questions_answers_shortcode_to_text( $mlw_quiz_array, $qmn_question_answer_template, $questions, $qmn_questions, $answer, $qsm_question_cnt, $total_question_cnt );
				$qsm_question_cnt++;
			}
		}
		
		$display = "<div class='qsm_questions_answers_section'>{$display}</div>";
		$content = str_replace( '%QUESTION_ANSWER_ATTEMPTED%', $display, $content );
		$content = str_replace( '%QUESTIONS_ANSWERS_EMAIL%', $display, $content );
	}
	return $content;
}

/**
 * %QUIZ_PERCENTAGE% is use to display the overall percentage a user earned.
 */
function qsm_addon_extra_variables_quiz_percentage( $content, $quiz_array ) {
    $quiz_percentage = 0;
    if ( isset( $quiz_array['total_possible_points'] ) && isset( $quiz_array['total_points'] ) ) {
      if ( 0 != $quiz_array['total_possible_points'] ) {
        $quiz_percentage = ( $quiz_array['total_points'] / $quiz_array['total_possible_points'] ) * 100;
      }
    }
    if ( qsm_check_score_roundoff_status() ) {
      $quiz_percentage = round( $quiz_percentage, 2 );
    }
    if ( false !== strpos($content, '%QUIZ_PERCENTAGE%') ) {
      $content = preg_replace('/%QUIZ_PERCENTAGE%/', $quiz_percentage, $content, 1);
    }
    return $content;
}

/**
 * Function to replace %CATEGORY_PERCENTAGE_X% variable in content provided
 */
function qsm_addon_extra_variables_quiz_category_percentage( $content, $quiz_array ) {
  $category_percentage = 0;
	while ( false !== strpos( $content, '%CATEGORY_PERCENTAGE_' ) ) {
		$total_questions = 0;
		$category_percentage   = 0;
		$category_name   = mlw_qmn_get_string_between( $content, '%CATEGORY_PERCENTAGE_', '%' );
		foreach ( $quiz_array['question_answers_array'] as $answer ) {
			if ( is_array( $answer['multicategories'] ) ) {
				foreach ( $answer['multicategories'] as $category ) {
					$category_name_object = get_term_by( 'id', $category, 'qsm_category' );
					if ( $category_name_object->name == $category_name && '11' !== $answer['question_type'] ) {
						$total_questions += 1;
						$category_percentage   += $answer['points'];
					}
				}
			}
		}
		if ( 0 != $total_questions && isset( $quiz_array['total_possible_points'] ) && 0 != $quiz_array['total_possible_points'] ) {
			$category_percentage = strval( ($category_percentage / $quiz_array['total_possible_points']) * 100 );
		} else {
			$category_percentage = 0;
		}
    if ( qsm_check_score_roundoff_status() ) {
      $category_percentage = round( $category_percentage, 2 );
    }
		$content       = str_replace( '%CATEGORY_PERCENTAGE_' . $category_name . '%', $category_percentage, $content );
	}
	return $content;
}

/**
 * Function to get the count of not answered questions or not attempted questions
 *
 */
function qsm_addon_extra_variable_total_unattempted_questions( $content, $quiz_array ) {
	$total_attempted_questions = isset( $quiz_array['total_attempted_questions'] ) ? $quiz_array['total_attempted_questions'] : 0;
	$total_questions = isset( $quiz_array['total_questions'] ) ? $quiz_array['total_questions'] : 0;
	$total_unattempted_questions = $total_questions - $total_attempted_questions;
	$content                   = str_replace( '%COUNT_UNATTEMPTED%', $total_unattempted_questions, $content );
	return $content;
}

/**
 * This function is to add %QUIZ_TIME% to the all options available in Text tab.
 */
function qsm_addon_extra_variables_add_total_time( $field_array ) {
  if ( 'message_before' == $field_array['id'] || 'message_comment' == $field_array['id'] || 'message_end_template' == $field_array['id'] || 'total_user_tries_text' == $field_array['id'] || 'require_log_in_text' == $field_array['id'] || 'scheduled_timeframe_text' == $field_array['id'] || 'twitter_sharing_text' == $field_array['id'] || 'facebook_sharing_text' == $field_array['id'] || 'limit_total_entries_text' == $field_array['id'] ) {
    array_push( $field_array['variables'], '%QUIZ_TIME%');
  }
  return $field_array;
}

/**
 * Function to replace %QUIZ_TIME% in content provided.
 */
function qsm_addon_extra_variables_total_time( $message_before, $quiz_array ) {
  global $wpdb;
  $table_name = $wpdb->prefix . 'mlw_quizzes';
  $quiz_data = $wpdb->get_var( $wpdb->prepare( "SELECT quiz_settings FROM $table_name WHERE quiz_id=%d", $quiz_array['quiz_id'] ) );
  $quiz_settings = maybe_unserialize($quiz_data);
  $options = maybe_unserialize( $quiz_settings['quiz_options'] );
  $total_time = $options['timer_limit'];
  if ( false !== strpos($message_before, '%QUIZ_TIME%') ) {
    $message_before = preg_replace('/%QUIZ_TIME%/', $total_time, $message_before, 1);
  }
  return $message_before;
}

/**
 * @since 1.3.2
 *
 * Converts the %RETAKE_QUIZ_BUTTON% into the template
 * @param string $content is the result page that is being populated
 * @param array  $mlw_quiz_array The array for the response data 
 * @return The retake quiz button template 
 */
function qsm_addon_extra_variable_display_quiz_retake_button( $content, $mlw_quiz_array ) {
  global $mlwQuizMasterNext;
  $quiz_options = $mlwQuizMasterNext->quiz_settings->get_quiz_options();
  
  $retaka_button = '<a href="' . esc_attr( wp_get_referer() ) . '" class="qsm-btn qsm_retake_button qmn_btn">' . $mlwQuizMasterNext->pluginHelper->qsm_language_support( $quiz_options->retake_quiz_button_text, "quiz_retake_quiz_button_text-{$quiz_options->quiz_id}" ) . '</a>';

  if ( false !== strpos($content, '%RETAKE_QUIZ_BUTTON%') && 0 === $quiz_options->enable_retake_quiz_button ) {    
    $content = preg_replace( '/%RETAKE_QUIZ_BUTTON%/', $retaka_button, $content, 1 );
  } else if ( false !== strpos($content, '%RETAKE_QUIZ_BUTTON%') ) {
    $content = preg_replace( '/%RETAKE_QUIZ_BUTTON%/', '', $content, 1 );
  }
  
  return $content;
}

/**
 * Function to replace %CATEGORY_MAX_POINTS_X% variable in content provided
 * @since 1.3.4
 */
function qsm_addon_extra_variables_quiz_category_max_points( $content, $quiz_array ) {
  $category_max_points = 0;
	while ( false !== strpos( $content, '%CATEGORY_MAX_POINTS_' ) ) {
		$total_questions = 0;
		$category_max_points   = 0;
		$category_name   = mlw_qmn_get_string_between( $content, '%CATEGORY_MAX_POINTS_', '%' );
		foreach ( $quiz_array['question_answers_array'] as $answer ) {
			if ( is_array( $answer['multicategories'] ) ) {
				foreach ( $answer['multicategories'] as $category ) {
					$category_name_object = get_term_by( 'id', $category, 'qsm_category' );
					if ( $category_name_object->name == $category_name && '11' !== $answer['question_type'] ) {
						$total_questions += 1;
            $category_max_points   += qsm_get_max_points( $answer['id'] );
					}
				}
			}
		}
    if ( qsm_check_score_roundoff_status() ) {
      $category_max_points = round( $category_max_points, 2 );
    }
		$content       = str_replace( '%CATEGORY_MAX_POINTS_' . $category_name . '%', $category_max_points, $content );
	}
	return $content;
}

function qsm_get_max_points( $question_id ) {
  global $wpdb;
  $table_name = $wpdb->prefix . 'mlw_questions';
  $answer_array = $wpdb->get_var( $wpdb->prepare( "SELECT answer_array FROM $table_name WHERE question_id=%d", $question_id ) );
  $answer_array = maybe_unserialize( $answer_array );
  $max_points = max(array_column($answer_array, 1));
  return intval( $max_points );
}

/**
 * Function to replace %CATEGORY_WISE_PERCENTAGE_X% variable in content provided
 * @since 1.3.4
 */
function qsm_addon_extra_variables_quiz_category_percentage_points( $content, $quiz_array ) {
  $category_percentage_points = 0;
	while ( false !== strpos( $content, '%CATEGORY_WISE_PERCENTAGE_' ) ) {
		$total_questions = 0;
		$category_percentage_points   = 0;
		$category_name   = mlw_qmn_get_string_between( $content, '%CATEGORY_WISE_PERCENTAGE_', '%' );
		$category_points = qmn_variable_category_points( '%CATEGORY_POINTS_'. $category_name .'%', $quiz_array );
		$category_max_points = qsm_addon_extra_variables_quiz_category_max_points( '%CATEGORY_MAX_POINTS_'. $category_name .'%', $quiz_array );
    $category_percentage_points = ($category_points / $category_max_points) * 100;
    if ( qsm_check_score_roundoff_status() ) {
      $category_percentage_points = round( $category_percentage_points, 2 );
    }
		$content       = str_replace( '%CATEGORY_WISE_PERCENTAGE_' . $category_name . '%', $category_percentage_points, $content );
	}
	return $content;
}

/**
 * Displays the available variables in the variable list
 *
 * @since 1.1.0
 */
function qsm_addon_extra_variables_display_variables() {
  ?>
  <div class="template_variable">
    <span class="template_name">%QUESTION_ANSWER_CORRECT%</span> - <?php _e('This variable shows all questions and answers for questions the user got correct.', 'qsm-extra-variables'); ?>
  </div>
  <div class="template_variable">
    <span class="template_name">%QUESTION_ANSWER_INCORRECT%</span> - <?php _e('This variable shows all questions and answers for questions the user got incorrect.', 'qsm-extra-variables'); ?>
  </div>
  <div class="template_variable">
    <span class="template_name">%QUESTION_ANSWER_GROUP_X%</span> - <?php _e('X: Answer value - This variable shows all questions and answers for questions where the user selected the matching answer.', 'qsm-extra-variables'); ?>
  </div>
  <div class="template_variable">
    <span class="template_name">%CUSTOM_MESSAGE_POINTS_X%</span> - <?php _e('X: Points range and message e.g. ( CUSTOM_MESSAGE_POINTS_loser:0-49;winner:50-100; ) - Shows a custom message based on the amount of points a user has earned.', 'qsm-extra-variables'); ?>
  </div>
  <div class="template_variable">
    <span class="template_name">%CUSTOM_MESSAGE_CORRECT_X%</span> - <?php _e('X: Score range and message e.g. ( CUSTOM_MESSAGE_CORRECT_loser:0-49;winner:50-100; ) - Shows a custom message based on the score a user has earned.', 'qsm-extra-variables'); ?>
  </div>
  <div class="template_variable">
    <span class="template_name">%QUIZ_TIME%</span> - <?php _e('This variable displays the total time of quiz.', 'qsm-extra-variables'); ?>
  </div>
  <div class="template_variable">
    <span class="template_name">%QUIZ_PERCENTAGE%</span> - <?php _e('This variable displays the obtained percentage of quiz.', 'qsm-extra-variables'); ?>
  </div>
  <div class="template_variable">
    <span class="template_name">%CATEGORY_PERCENTAGE_X%</span> - <?php _e('X:Category Name - This variable displays the percentage of any selected category out of the total quiz score.', 'qsm-extra-variables'); ?>
  </div>
  <div class="template_variable">
    <span class="template_name">%COUNT_UNATTEMPTED%</span> - <?php _e('This variable displays the total number of questions not attempted or not counted by the user.', 'qsm-extra-variables'); ?>
  </div>
  <div class="template_variable">
    <span class="template_name">%SUBMISSION_DATE%</span> - <?php _e('This variable displays the quiz submission date.', 'qsm-extra-variables'); ?>
  </div>
  <div class="template_variable">
    <span class="template_name">%QUESTION_ANSWER_ATTEMPTED%</span> - <?php _e('This variable displays only attempted questions answers on the result page.', 'qsm-extra-variables'); ?>
  </div>
  <div class="template_variable">
    <span class="template_name">%RETAKE_QUIZ_BUTTON%</span> - <?php _e('This variable displays the quiz retake button.', 'qsm-extra-variables'); ?>
  </div>
  <div class="template_variable">
    <span class="template_name">%REMAINING_QUIZ_ATTEMPTS%</span> - <?php _e('This variable displays the quiz remaining attempts.', 'qsm-extra-variables'); ?>
  </div>
  <div class="template_variable">
    <span class="template_name">%CATEGORY_MAX_POINTS_X%</span> - <?php _e('This variable displays the max points of any selected category can earn in the total quiz score.', 'qsm-extra-variables'); ?>
  </div>
  <div class="template_variable">
    <span class="template_name">%CATEGORY_WISE_PERCENTAGE_X%</span> - <?php _e('This variable displays the percentage of points that earned for that category.', 'qsm-extra-variables'); ?>
  </div>
  <?php
}

/**
 * Show the template variables in popup ( According to 7.0.0 )
 *
 * @since 1.1.2
 */
function qsm_addon_extra_variables_display_variables_popup( $variable_list ) {
  global $mlwQuizMasterNext;
  $template_array = array(
	  '%QUESTION_ANSWER_CORRECT%'   => __('This variable shows all questions and answers for questions the user got correct.', 'qsm-extra-variables'),
	  '%QUESTION_ANSWER_INCORRECT%' => __('This variable shows all questions and answers for questions the user got incorrect.', 'qsm-extra-variables'),
	  '%QUESTION_ANSWER_GROUP_X%'   => __('X: Answer value - This variable shows all questions and answers for questions where the user selected the matching answer.', 'qsm-extra-variables'),
	  '%CUSTOM_MESSAGE_POINTS_X%'   => __('X: Points range and message e.g. ( CUSTOM_MESSAGE_POINTS_loser:0-49;winner:50-100; ) - Shows a custom message based on the amount of points a user has earned.', 'qsm-extra-variables'),
	  '%CUSTOM_MESSAGE_CORRECT_X%'  => __('X: Score range and message e.g. ( CUSTOM_MESSAGE_POINTS_loser:0-49;winner:50-100; ) - Shows a custom message based on the score a user has earned.', 'qsm-extra-variables'),
	  '%QUIZ_TIME%'                 => __('This variable displays the total time of quiz.', 'qsm-extra-variables'),
	  '%QUIZ_PERCENTAGE%'           => __('This variable displays the obtained percentage of quiz.', 'qsm-extra-variables'),
	  '%CATEGORY_PERCENTAGE_X%'     => __('X:Category Name - This variable displays the percentage of any selected category out of the total quiz score.', 'qsm-extra-variables'),
	  '%COUNT_UNATTEMPTED%'         => __('This variable displays the total number of questions not attempted or not counted by the user.', 'qsm-extra-variables'),
	  '%SUBMISSION_DATE%'           => __('This variable displays the quiz submission date.', 'qsm-extra-variables'),
	  '%QUESTION_ANSWER_ATTEMPTED%' => __('This variable displays only attempted questions answers on the result page.', 'qsm-extra-variables'),
	  '%RETAKE_QUIZ_BUTTON%'        => __('This variable displays the quiz retake button.', 'qsm-extra-variables'),
	  '%REMAINING_QUIZ_ATTEMPTS%'   => __('This variable displays the quiz remaining attempts.', 'qsm-extra-variables'),
    '%CATEGORY_MAX_POINTS_X%'     => __('X:Category Name - This variable displays the max points of any selected category can earn in the total quiz score.', 'qsm-extra-variables'),
    '%CATEGORY_WISE_PERCENTAGE_X%' => __('X:Category Name - This variable displays the percentage of points that earned for that category.', 'qsm-extra-variables'),
  );

  if ( version_compare( $mlwQuizMasterNext->version, '7.3.4', '>' ) ) {
    $extra_variables = array(
		'Extra Template Variables' => $template_array,
    );
  } else {
    $extra_variables = $template_array;
  }

  $variable_list = array_merge($variable_list, $extra_variables);
  return $variable_list;
}

function qsm_check_score_roundoff_status() {
	global $mlwQuizMasterNext;
	return $mlwQuizMasterNext->pluginHelper->get_section_setting( 'quiz_options', 'score_roundoff' );
}

/**
 * @since 1.3.3
 *
 * %REMAINING_QUIZ_ATTEMPTS% variable displays the remaining quiz attempts
 * @param string $content is the result page that is being populated
 * @param array  $mlw_quiz_array The array for the response data 
 * @return number of remaining quiz attempts
 */
function qsm_addon_extra_variable_display_remaining_attempts( $content, $mlw_quiz_array ) {
  global $wpdb, $mlwQuizMasterNext;

  $quiz_options = $mlwQuizMasterNext->quiz_settings->get_quiz_options();

  if ( false !== strpos( $content, '%REMAINING_QUIZ_ATTEMPTS%' ) ) {
    $mlw_qmn_user_try_count = 0;

    if ( is_user_logged_in() ) {
      $current_user = wp_get_current_user();
      $mlw_qmn_user_try_count = $wpdb->get_var(
        $wpdb->prepare(
          "SELECT COUNT(*) FROM {$wpdb->prefix}mlw_results WHERE user=%d AND deleted=0 AND quiz_id=%d",
          $current_user->ID,
          $mlw_quiz_array['quiz_id']
        )
      );
    } else {
      $mlw_qmn_user_try_count = $wpdb->get_var(
        $wpdb->prepare(
          "SELECT COUNT(*) FROM {$wpdb->prefix}mlw_results WHERE user_ip=%s AND deleted=0 AND quiz_id=%d",
          $mlw_quiz_array['user_ip'],
          $mlw_quiz_array['quiz_id']
        )
      );
    }

    $content = preg_replace(
      '/%REMAINING_QUIZ_ATTEMPTS%/',
      intval( $quiz_options->total_user_tries ) - intval( $mlw_qmn_user_try_count ),
      $content
    );
  }

  return $content;
}
?>
