<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
add_action( 'init', 'qsm_advance_question_type_register' );

/**
 * This function registers the match_options open question type.
 *
 * @param string $name             The name of the Question Type which will be shown when selecting type.
 * @param string $display_function The name of the function to call when displaying the question.
 * @param bool   $graded           Tells the plugin if this question is graded or not. This will affect scoring.
 * @param string $review_function  The name of the function to call when scoring the question.
 * @param string $slug             The slug of the question type to be stored with question in database.
 * @param string $options          The options for show and hide question validation settings and answer types.
 * @since 1.0.0
 */
function qsm_advance_question_type_register() {
	global $mlwQuizMasterNext;
	$matching_pairs_options = array(
		'show_answer_option'                 => true,
		'show_correct_answer_info'           => true,
		'show_change_answer_editor'          => true,
		'show_match_answer'                  => false,
		'show_autofill'                      => false,
		'show_limit_text'                    => false,
		'show_limit_multiple_response'       => false,
		'show_file_upload_type'              => false,
		'show_file_upload_limit'             => false,
		'multiple_choise'                    => true,
		'description'                        => null,
		'use_custom_default_template'        => true,
		'use_custom_user_answer_template'    => true,
		'use_custom_correct_answer_template' => true,
	);
	$mlwQuizMasterNext->pluginHelper->register_question_type( esc_html__( 'Matching Pairs', 'qsm-advance-question' ), 'qsm_match_pairs_display', true, 'qsm_match_pairs_review', null, null, 15, $matching_pairs_options );
	$mlwQuizMasterNext->pluginHelper->set_question_type_meta( 15, 'category', 'Advanced' );

	$multiple_grid_options = array(
		'show_answer_option'                 => true,
		'show_correct_answer_info'           => true,
		'use_custom_default_template'        => true,
		'use_custom_user_answer_template'    => true,
		'use_custom_correct_answer_template' => true,
	);
	$mlwQuizMasterNext->pluginHelper->register_question_type( esc_html__( 'Radio Grid', 'qsm-advance-question' ), 'qsm_multiple_grid_display', true, 'qsm_multiple_grid_review', null, null, 16, $multiple_grid_options );
	$mlwQuizMasterNext->pluginHelper->register_question_type( esc_html__( 'Checkbox Grid', 'qsm-advance-question' ), 'qsm_multiple_grid_display', true, 'qsm_multiple_grid_review', null, null, 17, $multiple_grid_options );
	$mlwQuizMasterNext->pluginHelper->set_question_type_meta( 16, 'category', 'Advanced' );
	$mlwQuizMasterNext->pluginHelper->set_question_type_meta( 17, 'category', 'Advanced' );
}

/**
 * This function displays the content of the match_options open question.
 *
 * @params $id The ID of the multiple choice question
 * @params $question The question that is being edited.
 * @params @answers The array that contains the answers to the question.
 * @since  1.0.0
 */
function qsm_match_pairs_display( $id, $question, $answers ) {
	global $mlwQuizMasterNext;

	$answer_editor      = $mlwQuizMasterNext->pluginHelper->get_question_setting( $id, 'answerEditor' );
	$required           = $mlwQuizMasterNext->pluginHelper->get_question_setting( $id, 'required' );
	$new_question_title = $mlwQuizMasterNext->pluginHelper->get_question_setting( $id, 'question_title' );
	qsm_question_title_func( $question, 'match_pairs', $new_question_title, $id );
	?><div class="qsm-matching-pairs">
	<?php
	if ( is_array( $answers ) ) {
		$keys = array_keys( $answers );
		shuffle( $keys );
		$random = array();
		foreach ( $keys as $key ) {
			$random[ $key ] = $answers[ $key ];
		}
		$random_key = 'qsm_match_pairs_array_key_' . wp_rand();
		$qsm_inline_encrypt_js = '
			if ( transientData === undefined ) {
				var transientData = {};
			}
			if ( transientKey === undefined ) {
				var transientKey = {};
			}

			transientKey['.$id.'] = "'.hash('sha256',time().$id).'";
			transientData['.$id.'] = CryptoJS.AES.encrypt(JSON.stringify('. wp_json_encode( $keys )  .'), transientKey['.$id.']).toString();
		';
		wp_add_inline_script('qsm_encryption', $qsm_inline_encrypt_js, 'after');
		set_transient( $random_key, $keys );
		?>
		<input type="hidden" name="<?php echo esc_attr( 'random_key_' . $id ); ?>" value="<?php echo esc_attr( $random_key ); ?>" />
		<div class="qsm-left-option">
		<?php
		$mlw_answer_total = 0;
		foreach ( $random as $answer_index => $answer ) {
			$mlw_answer_total++;
			if ( '' != $answer[0] ) {
				$ans                = explode( ',,', $answer[0] );
				$answer_class_right = apply_filters( 'qsm_answer_wrapper_class', '', $ans[1], $id );
				if ( 'rich' === $answer_editor ) {
					?>
				<div class="qsm_mc_answer_wrap" id="<?php echo esc_attr( "question$id-$mlw_answer_total" ); ?>">
					<?php
				} elseif ( 'image' === $answer_editor ) {
					?>
				<div class="qsm_mc_answer_wrap qsm_image_option" id="<?php echo esc_attr( "question$id-$mlw_answer_total" ); ?>">
					<?php
				} else {
					?>
				<div class="qsm_mc_answer_wrap" id="<?php echo esc_attr( 'question' . $id . '-' . str_replace( ' ', '-', esc_attr( $ans[0] ) ) ); ?>">
					<?php
				}
				if ( 'image' === $answer_editor ) {
					$caption = explode( ',,', $answer[3] );
					?>
					<img src="<?php echo esc_url( trim( htmlspecialchars_decode( $ans[0], ENT_QUOTES ) ) ); ?>" alt="<?php echo __( 'LHS', 'qsm-advance-question' ) . wp_kses_post( trim( htmlspecialchars_decode( $caption[0], ENT_QUOTES ) ) ); ?>" />
					<span class="qsm_image_caption"><?php echo wp_kses_post( trim( htmlspecialchars_decode( $caption[0], ENT_QUOTES ) ) ); ?></span>
					<?php
				} else {
					echo do_shortcode( htmlspecialchars_decode( $ans[0], ENT_QUOTES ) );
				}
				do_action( 'qsm_match_pairs_left_display_loop', $id, $question, $answers );
				?>
				</div>
				<?php
			}
		}
		?>
		</div><div class="qsm-right-option qsm-match-sortable" data-qid="<?php echo esc_attr( $id ); ?>">
		<?php
		$mlw_answer_total = 0;
		$keys             = array_keys( $answers );
		shuffle( $keys );
		$random = array();
		foreach ( $keys as $key ) {
			$random[ $key ] = $answers[ $key ];
		}
		foreach ( $random as $answer_index => $answer ) {
			$mlw_answer_total++;
			if ( '' !== $answer[0] ) {
				$ans                = explode( ',,', $answer[0] );
				$answer_class_right = apply_filters( 'qsm_answer_wrapper_class', '', $ans[1], $id );
				if ( 'rich' === $answer_editor ) {
					?>
					<div class="qsm_mc_answer_wrap" id="<?php echo esc_attr( "question$id-$mlw_answer_total" ); ?>">
					<?php
				} elseif ( 'image' === $answer_editor ) {
					?>
					<div class="qsm_mc_answer_wrap qsm_image_option" id="<?php echo esc_attr( "question$id-$mlw_answer_total" ); ?>">
					<?php
				} else {
					?>
					<div class="qsm_mc_answer_wrap" id="<?php echo esc_attr( 'question' . $id . '-' . str_replace( ' ', '-', esc_attr( $ans[1] ) ) ); ?>">
					<?php
				}
				?>
				<span class="dashicons dashicons-move"></span>
				<?php
				if ( 'image' === $answer_editor ) {
					$caption = explode( ',,', $answer[3] );
					?>
					<img src="<?php echo esc_url( trim( htmlspecialchars_decode( $ans[1], ENT_QUOTES ) ) ); ?>" alt="<?php echo __( 'RHS', 'qsm-advance-question' ) . wp_kses_post( trim( do_shortcode( htmlspecialchars_decode( $caption[1], ENT_QUOTES ) ) ) ); ?>" />
					<span class="qsm_image_caption"><?php echo wp_kses_post( trim( do_shortcode( htmlspecialchars_decode( $caption[1], ENT_QUOTES ) ) ) ); ?></span>
					<?php
				} else {
					echo do_shortcode( htmlspecialchars_decode( $ans[1], ENT_QUOTES ) );
				}
				?>
				<input class="qsm_matching_pairs" type="hidden" value="<?php echo esc_attr( $answer_index ); ?>" name="<?php echo esc_attr( 'question' . $id . '[]' ); ?>">
				<?php
				do_action( 'qsm_match_pairs_right_display_loop', $id, $question, $answers );
				?>
			</div>
				<?php
			}
		}
		?>
		</div>
		<?php
	}
	?>
	</div>
	<?php
	do_action( 'qsm_match_pairs_display_after', $id, $question, $answers );
}

/**
 * This function determines how the match_options open question is graded
 *
 * @params $id The ID of the multiple choice question
 * @params $question The question that is being edited.
 * @params @answers The array that contains the answers to the question.
 * @return $return_array Returns the graded question to the results page
 * @since  1.0.0
 */
function qsm_match_pairs_review( $id, $question, $answers ) {
	$return_array    = array(
		'points'       => 0,
		'correct'      => 'incorrect',
		'user_text'    => '',
		'correct_text' => '',
		'user_answer'  => array(),
	);
	$user_correct    = 0;
	$total_correct   = 0;
	$total_answers   = count( $answers );
	$random_key_name = isset( $_POST[ 'random_key_' . $id ] ) ? wp_unslash( $_POST[ 'random_key_' . $id ] ) : ''; // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized
	$user_ans_array  = isset( $_POST[ 'question' . $id ] ) ? wp_unslash( $_POST[ 'question' . $id ] ) : array(); // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized
	$left_side_keys  = get_transient( $random_key_name );
	delete_transient( $random_key_name );
	$i = 0;
	foreach ( $left_side_keys as $key ) {
		$ans          = explode( ',,', $answers[ $key ][0] );
		$user_ans_key = $user_ans_array[ $i ];
		$user_answers = explode( ',,', $answers[ $user_ans_key ][0] );
		$user_ans     = htmlspecialchars_decode( $user_answers[1], ENT_QUOTES );
		$left_ans     = htmlspecialchars_decode( $ans[0], ENT_QUOTES );
		$correct_ans  = htmlspecialchars_decode( $ans[1], ENT_QUOTES );

		if ( intval( $user_ans_key ) === intval( $key ) ) {
			$return_array['points'] += $answers[ $key ][1];
			++$user_correct;
		}

		$return_array['user_answer'][ $key ] = $user_ans_key;
		$return_array['user_text']          .= $left_ans . '=' . $user_ans . '|';
		$return_array['correct_text']       .= $left_ans . '=' . $correct_ans . '|';
		$i++;
	}
	$return_array['user_text']    = rtrim( $return_array['user_text'], '| ' );
	$return_array['correct_text'] = rtrim( $return_array['correct_text'], '| ' );
	if ( $user_correct === $total_answers ) {
		$return_array['correct'] = 'correct';
	}
	/**
	 * Hook to filter answers array
	 */
	return apply_filters( 'qsm_match_pairs_review_after', $return_array, $answers );
}

/**
 * This function displays the content of the qsm_multiple_grid open question.
 *
 * @params $id The ID of the multiple choice question
 * @params $question The question that is being edited.
 * @params @answers The array that contains the answers to the question.
 * @since  1.0.0
 */
function qsm_multiple_grid_display( $id, $question, $answers ) {
	global $wpdb;
	global $mlwQuizMasterNext;
	$type               = $wpdb->get_var( $wpdb->prepare( 'SELECT question_type_new FROM ' . $wpdb->prefix . 'mlw_questions WHERE question_id=%d', intval( $id ) ) );
	$required           = $mlwQuizMasterNext->pluginHelper->get_question_setting( $id, 'required' );
	$require_all_rows   = $mlwQuizMasterNext->pluginHelper->get_question_setting( $id, 'require-all-rows' );
	$new_question_title = $mlwQuizMasterNext->pluginHelper->get_question_setting( $id, 'question_title' );
	$main_class         = 'qmn_check_answers';
	$question_class     = 'qsm_check_answer';
	$deselect_class     = 'multiple_grid';
	$tr_class = '';
	if ( 16 === intval( $type ) ) {
		$deselect_class = 'multiple_choice';
		$main_class     = 'qmn_radio_answers';
		$question_class = 'qmn_mc_answer_wrap';
	}
	if ( 0 === intval( $required ) && 1 === intval( $require_all_rows ) ) {
		$main_class .= ' mlwRequiredRadio';
	}
	if ( 0 === intval( $required ) && 0 === intval( $require_all_rows ) ) {
		$main_class .= ' mlwRequiredRadio  mlwRequiredRadioAllRows';
		$tr_class = 'qmn-grid-require-all-rows';
	}
	qsm_question_title_func( $question, $deselect_class, $new_question_title, $id );
	?>
	<div class="qsm_multiple_grid_answers <?php echo esc_attr( $main_class ); ?>">
	<?php
	if ( is_array( $answers ) ) {
		$columns = $answers['columns'];
		$rows    = $answers['rows'];
		?>
		<table class="qsm_multiple_grid_table">
			<thead>
				<tr>
					<th></th>
					<?php foreach ( $columns as $column ) { ?>
					<th><?php echo wp_kses_post( trim( htmlspecialchars_decode( $column ) ) ); ?></th>
					<?php } ?>
				</tr>
			</thead>
			<tbody>
				<?php foreach ( $rows as $key => $row ) { ?>
				<tr class="qmn_radio_answers <?php echo esc_attr( $tr_class ); ?>">
					<th><?php echo wp_kses_post( trim( htmlspecialchars_decode( $row ) ) ); ?></th>
					<?php foreach ( $columns as $col_key => $column ) { ?>
					<td class="<?php echo esc_attr( $question_class ); ?>">
						<?php if ( 16 === intval( $type ) ) { ?>
							<input class="qsm_radio_grid" id="<?php echo esc_attr( 'question' . $id . '_' . $key . '_' . $col_key ); ?>" data-qid="<?php echo esc_attr( $id ); ?>" name="<?php echo esc_attr( $id . '-' . $key ); ?>" type="radio" value="<?php echo esc_attr( $col_key ); ?>" />
						<?php } elseif ( 17 === intval( $type ) ) { ?>
							<input class="qsm_checkbox_grid" id="<?php echo esc_attr( 'question' . $id . '_' . $key . '_' . $col_key ); ?>" data-qid="<?php echo esc_attr( $id ); ?>" name="<?php echo esc_attr( $id . '-' . $key . '[]' ); ?>" type="checkbox" value="<?php echo esc_attr( $col_key ); ?>" />
						<?php } ?>
						<label for="<?php echo esc_attr( 'question' . $id . '_' . $key . '_' . $col_key ); ?>" class="qsm-input-label"></label>
					</td>
					<?php } ?>
				</tr>
				<?php } ?>
			</tbody>
		</table>
		<?php
	}
	?>
	</div>
	<?php
	do_action( 'qsm_multiple_grid_display_after', $id, $question, $answers );
}

function convertToChunkedArray( $arr, $chunkSize ) {
    $result = [];
    for ( $i = 0; $i < $chunkSize; $i++ ) {
        $result[] = array_values(array_filter($arr, function ( $key ) use ( $i, $chunkSize ) {
            return ($key - $i) % $chunkSize === 0;
        }, ARRAY_FILTER_USE_KEY));
    }
    return $result;
}

function productOfArray( $arr, $logic ) {
    $result = 1;
	foreach ( $arr as $subArray ) {
		$result *= array_product($subArray);
	}
    return $result;
}

function countOnes( $arr ) {
	$count = 0;
    foreach ( $arr as $subArray ) {
        $count += array_sum($subArray);
    }
    return $count;
}

/**
 * This function determines how the multiple_grid open question is graded.
 *
 * @since  1.0.0
 * @param $id The ID of the multiple choice question
 * @param $question The question that is being edited.
 * @param $answers The array that contains the answers to the question.
 * @return $return_array Returns the graded question to the results page
 */
function qsm_multiple_grid_review( $id, $question, $answers ) {

	global $mlwQuizMasterNext, $wpdb;
	$question_type = $wpdb->get_var( $wpdb->prepare( 'SELECT question_type_new FROM ' . $wpdb->prefix . 'mlw_questions WHERE question_id=%d', intval( $id ) ) );
	$quiz_id = $wpdb->get_var( $wpdb->prepare( 'SELECT quiz_id FROM ' . $wpdb->prefix . 'mlw_questions WHERE question_id=%d', intval( $id ) ) );
	$quiz_settings = $wpdb->get_var( $wpdb->prepare( 'SELECT quiz_settings FROM ' . $wpdb->prefix . 'mlw_quizzes WHERE quiz_id=%d', intval( $quiz_id ) ) );
	$quiz_settings = unserialize($quiz_settings);
	$quiz_options = unserialize($quiz_settings['quiz_options']);
	$correct_answer_logic = $quiz_options['correct_answer_logic'];
	$quiz_system   = $quiz_options['system'];
	$form_type     = $quiz_options['form_type'];
	$return_array  = array(
		'points'       => 0,
		'user_text'    => '',
		'correct_text' => '',
		'user_answer'  => array(),
	);
	if ( is_array( $answers ) ) {
		$columns = $answers['columns'];
		$rows    = $answers['rows'];
		$points  = $answers['points'];

		$expectedLength = count($rows) * count($columns);
		if ( count($points) < $expectedLength ) {
			$replicatedPoint = [];
			$repetitions = ceil($expectedLength / count($points));

			foreach ( $points as $element ) {
				for ( $i = 0; $i < $repetitions; $i++ ) {
					$replicatedPoint[] = $element;
				}
			}
			$points = array_slice($replicatedPoint, 0, $expectedLength);
		}
		$corrects  = isset($answers['corrects']) ? $answers['corrects'] : array();
		$points = convertToChunkedArray($points, count($rows));
		$corrects = convertToChunkedArray($corrects, count($rows));
		$isCorrect = false;
		$isCorrects = [];
		foreach ( $rows as $key => $row ) {
			$row = htmlspecialchars_decode( $row, ENT_QUOTES );
			if ( 16 === intval( $question_type ) ) {
				$user_ans = isset( $_POST[ $id . '-' . $key ] ) ? sanitize_text_field( wp_unslash( $_POST[ $id . '-' . $key ] ) ) : '-1';
			} elseif ( 17 === intval( $question_type ) ) {
				$user_ans_array = isset( $_POST[ $id . '-' . $key ] ) ? qsm_sanitize_rec_array( wp_unslash( $_POST[ $id . '-' . $key ] ) ) : array(); // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized
			}
			$user_text_column = '';
			$point = isset($points[ $key ]) ? $points[ $key ] : array();
			$correct = isset($corrects[ $key ]) ? $corrects[ $key ] : array();
			foreach ( $columns as $col_key => $column ) {
				if ( ( 16 === intval( $question_type ) && $col_key === intval( $user_ans ) ) || ( 17 === intval( $question_type ) && in_array( $col_key, $user_ans_array ) ) ) {
					$isCorrect  = isset( $correct[ $col_key ] ) ? intval($correct[ $col_key ]) : 0;
					$return_array['points'] += isset( $point[ $col_key ] ) ? intval($point[ $col_key ]) : 0;
					$user_text_column                     .= $column . '.';
					$return_array['user_answer'][ $key ][] = $col_key;
					if ( $isCorrect ) {
						$return_array['correct_answer'][ $key ][] = $col_key;
					}
					$isCorrects[ $key ][ $col_key ] = $isCorrect;
				}
			}
			$user_text_column           = rtrim( $user_text_column, '.' );
			$return_array['user_text'] .= $row . '=' . $user_text_column . '=' . $isCorrect . ' | ';
		}
		if ( 1 == $correct_answer_logic && ( 0 == $quiz_system || 3 == $quiz_system ) ) {
			$return_array['correct'] = (count($isCorrects) > 0) && productOfArray($isCorrects, 1) && (countOnes($isCorrects) == countOnes($corrects)) ? 'correct' : 'incorrect';
		} elseif ( 0 == $correct_answer_logic && ( 0 == $quiz_system || 3 == $quiz_system ) ) {
			$return_array['correct'] = (count($isCorrects) > 0) && productOfArray($isCorrects, 0) && (countOnes($isCorrects) <= countOnes($corrects)) ? 'correct' : 'incorrect';
		} else {
			$return_array['correct'] = count($return_array['user_answer']) > 0 ? 'correct' : 'incorrect';
		}
	}
	$return_array['user_text']    = rtrim( $return_array['user_text'], '| ' );
	$return_array['correct_text'] = $return_array['user_text'];

	/**
	 * Hook to filter answers array
	 */
	return apply_filters( 'qsm_multiple_grid_review_after', $return_array, $answers );
}

/**
 * This function create single answer template for advance question type
 *
 * @since 1.0.0
 */
function qsm_advance_quetion_type_template() {
	global $mlwQuizMasterNext;

	$advance_assessment_data         = $mlwQuizMasterNext->pluginHelper->get_quiz_setting( "advance_assessment_settings" );
	$advance_assessment_defaults     = array(
		'enable'       => 1,
		'label_points' => 0,
	);
	$advance_assessment_data         = wp_parse_args( $advance_assessment_data, $advance_assessment_defaults );
	$enable_advanced_assement = '';
	if(0 == $advance_assessment_data['enable']) {
		$enable_advanced_assement = 'qsm-advanced-assessment-disabled';
	}

	$settings = get_option( 'qsm_addon_advance_question_settings', array() );
	$license  = isset( $settings['license_key'] ) ? trim( $settings['license_key'] ) : '';
	$license_status  = isset( $settings['license_status'] ) ? $settings['license_status'] : '';
	$params      = array(
		'please_wait' => __('Please Wait! We are validating your license', 'qsm-advance-question'),
		'license_msg' => __('License Key Required.', 'qsm-advance-question'),
		'invalid'     => __('<span class="dashicons dashicons-warning"></span><b>Incorrect License!</b> Please enter a valid license key.', 'qsm-advance-question'),
	);
	wp_localize_script( 'qsm-advance-question-addon-admin-js', 'qsm_advance_question_obj', $params );
	?>
	<script type="text/template" id="tmpl-advance-question-matching-pairs">
	<?php if ( $license != '' && $license_status == 'valid' ) { ?>
		<div class="answers-single qsm-advance-question-match-pairs">
			<div class="remove-answer-icon">
				<a href="javascript:void(0)" class="delete-answer-button"><span class="dashicons dashicons-minus"></span></a>
				<a href="javascript:void(0)" class="qsm-add-answer-button"><span class="dashicons dashicons-plus"></span></a>
			</div>
			<div class="answer-text-div">
				<#
					let answer = data.answer;
					let answer_array = ["",""];
					if(answer != null){
						answer_array = answer.split(',,');
					}
					let caption = data.caption;
					let caption_array = ["",""];
					if(caption != null){
						caption_array = caption.split(',,');
					}
				#>
				<# if ( 'rich' == data.answerType ) { #>
					<textarea class="answer-textarea-lhs" id="answer-{{data.question_id}}-{{data.count}}-lhs"></textarea>
				<# } else if ( 'image' == data.answerType ) { #>
					<input type="text" class="answer-text answer-text-lhs" id="featured_image_textbox_lhs" value="{{answer_array[0]}}" placeholder="<?php esc_attr_e( 'Insert LHS image URL', 'qsm-advance-question' ); ?>"/>
					<a href="javascript:void(0)" class="set_featured_image" id="set_featured_image_lhs"><span class="dashicons dashicons-insert"></span></a>
					<input type="text" class="answer-caption answer-caption-lhs" id="featured_image_caption_lhs" value="{{caption_array[0]}}" placeholder="<?php esc_attr_e( 'Image Caption', 'qsm-advance-question' ); ?>"/>
				<# } else { #>
					<input type="text" class="answer-text answer-text-lhs" value="{{answer_array[0]}}" placeholder="<?php esc_attr_e( 'Left Side', 'qsm-advance-question' ); ?>"/>
				<# } #>
			</div>
			<div class="answer-text-div">
				<# if ( 'rich' == data.answerType ) { #>
					<textarea class="answer-textarea-rhs" id="answer-{{data.question_id}}-{{data.count}}-rhs"></textarea>
				<# } else if ( 'image' == data.answerType ) { #>
					<input type="text" class="answer-text answer-text-rhs" id="featured_image_textbox_rhs" value="{{answer_array[1]}}" placeholder="<?php esc_attr_e( 'Insert RHS image URL', 'qsm-advance-question' ); ?>"/>
					<a href="javascript:void(0)" class="set_featured_image" id="set_featured_image_rhs"><span class="dashicons dashicons-insert"></span></a>
					<input type="text" class="answer-caption answer-caption-rhs" id="featured_image_caption_rhs" value="{{caption_array[1]}}" placeholder="<?php esc_attr_e( 'Image Caption', 'qsm-advance-question' ); ?>"/>
				<# } else { #>
					<input type="text" class="answer-text answer-text-rhs" value="{{answer_array[1]}}" placeholder="<?php esc_attr_e( 'Right Side', 'qsm-advance-question' ); ?>"/>
				<# } #>
			</div>
			<# if ( 1 == data.quiz_system || 3 == data.quiz_system ) { #>
				<div><input type="text" class="answer-points" value="{{data.points}}" placeholder="<?php esc_attr_e( 'Points', 'qsm-advance-question' ); ?>"/></div>
			<# } #>
		</div>
		<?php
	} else {
		$mlwQuizMasterNext->alertManager->showAlerts() ?>
		<div class="license_form_parent" style="background: #fff; padding: 20px">
			<div class="qsm-popup-upgrade-warning">
				<img src="<?php echo esc_url( QSM_PLUGIN_URL . 'php/images/warning.png' ); ?>"  width="15px" height="15px" alt="warning">
				<span style="margin-left: 10px">
					<?php esc_html_e( 'Action Required - License missing', 'qsm-advance-question' ); ?>
				</span>
			</div>
			<h4><strong><?php esc_html_e( 'To use Advances Question Type Addon features, you must validate your licence key.', 'qsm-advance-question' ); ?></strong></h4>
			<div class="qsm_advance_question_validate_parent">
				<form class="rq_validata-license" method="POST">
					<input style="width: 400px" type="text" placeholder="<?php echo esc_html("Enter your license key"); ?>" class="qsm_advance_question_validate_input" name="qsm_advance_question_validate_input" />
					<input value="Validate" type="submit" name="qsm_advance_question_validate_button" class="qsm_advance_question_validate_button button button-primary" />
				</form>
			</div>
			<div id="qsm-license_message" style="display: none;  padding: 0 0 0 22px;"><p><strong class="qsm_advance_question_validate_message"></strong></div>
		</div>
	<?php } ?>
	</script>

	<script type="text/template" id="tmpl-advance-question-multiple-grid">
	<?php if ( $license != '' && $license_status == 'valid' ) { ?>
		<#
			function splitArray(arr, chunkSize) {
				const result = [];
				for (let i = 0; i < arr.length; i += chunkSize) {
					result.push(arr.slice(i, i + chunkSize));
				}
				return result;
			}
			let qsm_multiple_rows = data.answer.rows;
			let qsm_multiple_columns = data.answer.columns;
			let qsm_multiple_points = data.answer.points;
			let qsm_multiple_corrects = data.answer.corrects;
			let point_type = 'correct';
			if(qsm_multiple_rows == null){
				qsm_multiple_rows = ['', ''];
			}
			if(qsm_multiple_columns == null){
				qsm_multiple_columns = ['', ''];
				qsm_multiple_points = ['', ''];
				qsm_multiple_corrects = ['', ''];
			}
			const expectedLength = qsm_multiple_rows.length * qsm_multiple_columns.length;
			if (qsm_multiple_points.length < expectedLength) {
				const replicatedPoint = [];
				const repetitions = Math.ceil(expectedLength / qsm_multiple_points.length);

				qsm_multiple_points.forEach((element) => {
					for (let i = 0; i < repetitions; i++) {
					replicatedPoint.push(element);
					}
				});
				qsm_multiple_points = replicatedPoint.slice(0, expectedLength);
			}
			let qsm_multiple_rowLen = qsm_multiple_rows.length;
			qsm_multiple_points = splitArray(qsm_multiple_points, qsm_multiple_rowLen);
			if(qsm_multiple_corrects && Array.isArray(qsm_multiple_corrects) && qsm_multiple_corrects.length > 0) {
				qsm_multiple_corrects = splitArray(qsm_multiple_corrects, qsm_multiple_rowLen);
			} else {
				qsm_multiple_corrects = ['', ''];
			}
			data.inside_key = 0;
		#>
		<div class="answers-single qsm-advance-question-multiple-grid <?php echo esc_attr( $enable_advanced_assement ); ?>">
			<div class="question-half-div">
				<#
				_.each(qsm_multiple_columns, function (outer_column, outer_key) {
				#>
				<div class="qsm-advance-question-column-list">
					<a href="javascript:void(0)" class="delete-question-option"><span class="dashicons dashicons-remove"></span></a>
					<input type="text" class="answer-text answer-text-column" value="{{outer_column}}" placeholder="<?php esc_attr_e( 'Column value', 'qsm-advance-question' ); ?>"/>
					<# if ( 0 == data.form_type ) {
						if ( 3 == data.quiz_system ) {
							point_type = 'both';
							_.each(qsm_multiple_rows, function (inside_row, inside_rkey) {
								point = Array.isArray(qsm_multiple_points) && qsm_multiple_points.length > 0 && qsm_multiple_points[outer_key] !== undefined && qsm_multiple_points[outer_key][inside_rkey] != 'undefined' ? qsm_multiple_points[outer_key][inside_rkey] : '';
								isCorrect = Array.isArray(qsm_multiple_corrects) && qsm_multiple_corrects.length > 0 && qsm_multiple_corrects[outer_key] !== undefined && qsm_multiple_corrects[outer_key][inside_rkey] !== undefined ? qsm_multiple_corrects[outer_key][inside_rkey] : '';
							#>
							<div class="qsm-grid-points-section qsm-grid-points-both-section" index={{inside_rkey}}>
								<input type="checkbox" class="answer-correct" value="1" {{isCorrect == 1 ? 'checked' : ''}}>
								<input type="text" class="answer-points weight-points" value="{{point}}" placeholder="<?php esc_attr_e( 'Points', 'qsm-advance-question' ); ?>"/>
								<?php do_action('qsm_admin_multigrid_answer_option_fields'); ?>
							</div>
						<# data.inside_key++; }); } #>
						<#
						if ( 1 == data.quiz_system ) {
							point_type = 'point';
							_.each(qsm_multiple_rows, function (inside_row, inside_rkey) {
								point = Array.isArray(qsm_multiple_points) && qsm_multiple_points.length > 0 && qsm_multiple_points[outer_key] !== undefined && qsm_multiple_points[outer_key][inside_rkey] != 'undefined' ? qsm_multiple_points[outer_key][inside_rkey] : '';
							#>
							<div class="qsm-grid-points-section qsm-grid-points-point-section" index={{inside_rkey}}>
								<input type="text" class="answer-points" value="{{point}}" placeholder="<?php esc_attr_e( 'Points', 'qsm-advance-question' ); ?>"/>
								<?php do_action('qsm_admin_multigrid_answer_option_fields'); ?>
							</div>
						<# data.inside_key++; }); } #>
						<#
						if ( 0 == data.quiz_system ) {
							point_type = 'correct';
							_.each(qsm_multiple_rows, function (inside_row, inside_rkey) {
								isCorrect = Array.isArray(qsm_multiple_corrects) && qsm_multiple_corrects.length > 0 && qsm_multiple_corrects[outer_key] !== undefined && qsm_multiple_corrects[outer_key][inside_rkey] !== undefined ? qsm_multiple_corrects[outer_key][inside_rkey] : '';
							#>
							<div class="qsm-grid-points-section qsm-grid-correct-incorrect-section" index={{inside_rkey}}>
								<input type="checkbox" class="answer-correct" value="1" {{isCorrect == 1 ? 'checked' : ''}}>
								<?php do_action('qsm_admin_multigrid_answer_option_fields'); ?>
							</div>
						<# data.inside_key++; }); } #>
					<# } else {
						point_type = 'other';
						_.each(qsm_multiple_rows, function (inside_row, inside_rkey) {
						#>
						<div class="qsm-grid-points-section" index={{inside_rkey}}>
							<input type="checkbox" checked disabled>
						</div>
					<# data.inside_key++; }); } #>
				</div>
				<# }); #>
				<div class="new-answer-button">
					<a href="javascript:void(0)" class="qsm-dashed-btn qsm-block-btn new-question-column" point_type="{{point_type}}">+ <?php esc_html_e( 'Add column', 'qsm-advance-question' ); ?></a>
				</div>
			</div>
			<div class="question-half-div">
				<#
				_.each(qsm_multiple_rows, function (inside_row, inside_rkey) {
				#>
				<div class="qsm-advance-question-rows-list">
					<a href="javascript:void(0)" class="delete-question-option" index={{inside_rkey}}><span class="dashicons dashicons-remove"></span></a>
					<input type="text" class="answer-text answer-text-row" value="{{inside_row}}" placeholder="<?php esc_attr_e( 'Row value', 'qsm-advance-question' ); ?>"/>
				</div>
				<# data.inside_key++; }); #>
				<div class="new-answer-button">
					<a href="javascript:void(0)" class="qsm-dashed-btn qsm-block-btn new-question-row" index={{qsm_multiple_rowLen}}>+ <?php esc_html_e( 'Add row', 'qsm-advance-question' ); ?></a>
				</div>
			</div>
		</div>
		<?php
	} else {
		$mlwQuizMasterNext->alertManager->showAlerts() ?>
		<div class="license_form_parent" style="background: #fff; padding: 20px">
			<div class="qsm-popup-upgrade-warning">
				<img src="<?php echo esc_url( QSM_PLUGIN_URL . 'php/images/warning.png' ); ?>"  width="15px" height="15px" alt="warning">
				<span style="margin-left: 10px">
					<?php esc_html_e( 'Action Required - License missing', 'qsm-advance-question' ); ?>
				</span>
			</div>
			<h4><strong><?php esc_html_e( 'To use Advances Question Type Addon features, you must validate your licence key.', 'qsm-advance-question' ); ?></strong></h4>
			<div class="qsm_advance_question_validate_parent">
				<form class="rq_validata-license" method="POST">
					<input style="width: 400px" type="text" placeholder="<?php echo esc_html("Enter your license key"); ?>" class="qsm_advance_question_validate_input" name="qsm_advance_question_validate_input" />
					<input value="Validate" type="submit" name="qsm_advance_question_validate_button" class="qsm_advance_question_validate_button button button-primary" />
				</form>
			</div>
			<div id="qsm-license_message" style="display: none;  padding: 0 0 0 22px;"><p><strong class="qsm_advance_question_validate_message"></strong></div>
		</div>
	<?php } ?>
	</script>
	<?php
}
add_action( 'qsm_admin_after_single_answer_template', 'qsm_advance_quetion_type_template' );

/**
 * The qsm_result_question_types filter callback function.
 *
 * @param array
 **/
function qsm_advance_question_result_question_types( $result_question_types ) {
	array_push( $result_question_types, 15, 16, 17 );
	return $result_question_types;
}
add_filter( 'qsm_result_question_types', 'qsm_advance_question_result_question_types' );

/**
 * The qsm_email_template_variable_results filter callback function.
 *
 * @arg $content
 **/
function qsm_advance_question_email_template( $content ) {
	$content = str_replace( '<tr class="qsm-correct-match-pairs">', "<tr style='color:green;'>", $content );
	$content = str_replace( '<tr class="qsm-incorrect-match-pairs">', "<tr style='color:red;'>", $content );
	$content = str_replace( '<td class="qsm_pairs_image_option">', "<td style='border:1px solid;min-width:120px;'>", $content );
	$content = str_replace( '<td>', "<td style='border:1px solid;min-width:120px;'>", $content );
	$content = str_replace( '<img', "<img style='max-width:100%;width:160px;'", $content );
	return $content;
}
add_filter( 'qmn_email_template_variable_results', 'qsm_advance_question_email_template' );

/**
 * The qsm_result_page_custom_default_template filter callback function.
 *
 * @arg $total_answers, $questions, $answer
 * return string
 **/
function qsm_advance_question_result_page_default_template( $final_ans, $total_answers, $questions, $answer ) {
	global $mlwQuizMasterNext, $wpdb;
	$question_id   = $answer['id'];
	$quiz_id       = $wpdb->get_var( $wpdb->prepare( 'SELECT quiz_id FROM ' . $wpdb->prefix . 'mlw_questions WHERE question_id=%d', intval( $question_id ) ) );
	$quiz_settings = $wpdb->get_var( $wpdb->prepare( 'SELECT quiz_settings FROM ' . $wpdb->prefix . 'mlw_quizzes WHERE quiz_id=%d', intval( $quiz_id ) ) );
	$quiz_settings = unserialize($quiz_settings);
	$quiz_options  = unserialize($quiz_settings['quiz_options']);
	$quiz_system   = $quiz_options['system'];
	$form_type     = $quiz_options['form_type'];
	if ( in_array( intval( $answer['question_type'] ), array( 15, 16, 17 ), true ) ) {
		if ( in_array( intval( $answer['question_type'] ), array( 16, 17 ), true ) ) {
			$columns     = $total_answers['columns'];
			$rows        = $total_answers['rows'];
			$user_answer = $answer['user_answer'];
			$correct_answer = $answer['correct_answer'];
			$final_ans  .= '<div class="qsm_multiple_grid_answers"><table class="qsm_multiple_grid_table"><thead><tr><th></th>';
			foreach ( $columns as $column ) {
				$final_ans .= '<th>' . wp_kses_post( trim( htmlspecialchars_decode( $column ) ) ) . '</th>';
			}
			$final_ans .= '</tr></thead><tbody>';
			foreach ( $rows as $key => $val ) {
				$final_ans .= '<tr><th>' . wp_kses_post( trim( htmlspecialchars_decode( $val ) ) ) . '</th>';
				foreach ( $columns as $col_key => $column ) {
					$final_ans .= '<td>';

					if ( array_key_exists( $key, $user_answer ) && in_array( $col_key, $user_answer[ $key ] ) ) {
						if ( ! empty($correct_answer) && is_array($correct_answer) ) {
							if ( 0 == $form_type && ( 0 == $quiz_system || 3 == $quiz_system ) ) {
								if ( array_key_exists( $key, $correct_answer ) && in_array( $col_key, $correct_answer[ $key ] ) ) {
									$final_ans .= '<span class="qsm-text-correct-option qsm-text-user-correct-answer "></span>';
								} else {
									$final_ans .= '<span class="qsm-text-wrong-option qsm-text-user-correct-answer "></span>';
								}
							} else {
								$final_ans .= '<span class="qsm-text-correct-option qsm-text-user-correct-answer "></span>';
							}
						} else {
							$final_ans .= '<span class="qsm-text-correct-option qsm-text-user-correct-answer "></span>';
						}
					}
					$final_ans .= '</td>';
				}
				$final_ans .= '</tr>';
			}
			$final_ans .= '</tbody></table></div>';
		} else {
			if ( 'correct' === $answer['correct'] ) {
				$user_answer_class = 'qsm_user_correct_answer';
			} else {
				$user_answer_class = 'qsm_user_incorrect_answer';
			}
			$user_ans   = $answer['user_answer'];
			$final_ans .= '<div class="' . $user_answer_class . ' qsm-advance-question-matching-pairs"><table class="qsm_answer_table"><tbody>';
			foreach ( $user_ans as $key => $val ) {
				$left_answers   = explode( ',,', $total_answers[ $key ][0] );
				$user_answers   = explode( ',,', $total_answers[ $val ][0] );
				$questionid    = $questions[ $answer['id'] ]['question_id'];
				$answer_type   = $mlwQuizMasterNext->pluginHelper->get_question_setting( $questionid, 'answerEditor' );
				if ( 'image' === $answer_type ) {
					$left_caption   = explode( ',,', $total_answers[ $key ][3] );
					$left_ans = '<td class="qsm_pairs_image_option"><img src="' . trim( htmlspecialchars_decode( $left_answers[0], ENT_QUOTES ) ) . '" /><span class="qsm_image_caption">' . wp_kses_post( trim( do_shortcode( htmlspecialchars_decode( $left_caption[0], ENT_QUOTES ) ) ) ) . '</td>';
				} else {
					$left_ans = '<td>' . trim( do_shortcode( htmlspecialchars_decode( $left_answers[0], ENT_QUOTES ) ) ) . '</td>';
				}
				if ( 'image' === $answer_type ) {
					$user_caption   = explode( ',,', $total_answers[ $val ][3] );
					$user_ans = '<td class="qsm_pairs_image_option"><img src="' . trim( htmlspecialchars_decode( $user_answers[1], ENT_QUOTES ) ) . '" /><span class="qsm_image_caption">' . wp_kses_post( trim( do_shortcode( htmlspecialchars_decode( $user_caption[1], ENT_QUOTES ) ) ) ) . '</td>';
				} else {
					$user_ans = '<td>' . trim( do_shortcode( htmlspecialchars_decode( $user_answers[1], ENT_QUOTES ) ) ) . '</td>';
				}
				if ( in_array( intval( $answer['question_type'] ), array( 16, 17 ), true ) ) {
					$user_ans_class = '';
				} elseif ( intval( $key ) === intval( $val ) ) {
					$user_ans_class = 'qsm-correct-match-pairs';
				} else {
					$user_ans_class = 'qsm-incorrect-match-pairs';
				}
				$final_ans .= '<tr class="' . $user_ans_class . '">' . $left_ans . $user_ans . '</tr>';

			}

			$final_ans .= '</tbody></table></div>';
		}
	}
	return $final_ans;
}
add_filter( 'qsm_result_page_custom_default_template', 'qsm_advance_question_result_page_default_template', 10, 4 );

/**
 * The qsm_advance_question_result_page_user_answer_template filter callback function.
 *
 * @arg $question, $answer
 * return string
 **/
function qsm_advance_question_result_page_user_answer_template( $final_ans, $questions, $answer ) {
	global $mlwQuizMasterNext, $wpdb;
	$question_id   = $answer['id'];
	$quiz_id       = $wpdb->get_var( $wpdb->prepare( 'SELECT quiz_id FROM ' . $wpdb->prefix . 'mlw_questions WHERE question_id=%d', intval( $question_id ) ) );
	$quiz_settings = $wpdb->get_var( $wpdb->prepare( 'SELECT quiz_settings FROM ' . $wpdb->prefix . 'mlw_quizzes WHERE quiz_id=%d', intval( $quiz_id ) ) );
	$quiz_settings = unserialize($quiz_settings);
	$quiz_options  = unserialize($quiz_settings['quiz_options']);
	$quiz_system   = $quiz_options['system'];
	$form_type     = $quiz_options['form_type'];
	$questionid    = $questions[ $answer['id'] ]['question_id'];
	$total_answers = $questions[ $questionid ]['answers'];
	if ( in_array( intval( $answer['question_type'] ), array( 15, 16, 17 ), true ) ) {
		if ( in_array( intval( $answer['question_type'] ), array( 16, 17 ), true ) ) {
			$columns     = $total_answers['columns'];
			$rows        = $total_answers['rows'];
			$user_answer = $answer['user_answer'];
			$correct_answer = $answer['correct_answer'];
			$final_ans  .= '<div class="qsm_multiple_grid_answers"><table class="qsm_multiple_grid_table"><thead><tr><th></th>';
			foreach ( $columns as $column ) {
				$final_ans .= '<th>' . wp_kses_post( trim( htmlspecialchars_decode( $column ) ) ) . '</th>';
			}
			$final_ans .= '</tr></thead><tbody>';
			foreach ( $rows as $key => $val ) {
				$final_ans .= '<tr><th>' . wp_kses_post( trim( htmlspecialchars_decode( $val ) ) ) . '</th>';
				foreach ( $columns as $col_key => $column ) {
					$final_ans .= '<td>';

					if ( ! empty($correct_answer) && is_array($correct_answer) ) {
						if ( 0 == $form_type && ( 0 == $quiz_system || 3 == $quiz_system ) ) {
							if ( array_key_exists( $key, $correct_answer ) && in_array( $col_key, $correct_answer[ $key ] ) ) {
								$final_ans .= '<span class="qsm-text-correct-option qsm-text-user-correct-answer "></span>';
							} else {
								if ( array_key_exists( $key, $user_answer ) && in_array( $col_key, $user_answer[ $key ] ) ) {
									$final_ans .= '<span class="qsm-text-wrong-option "></span>';
								} else {
									$final_ans .= '<span class="qsm-text-simple-option "></span>';
								}
							}
						} else {
							if ( array_key_exists( $key, $correct_answer ) && in_array( $col_key, $correct_answer[ $key ] ) ) {
								$final_ans .= '<span class="qsm-text-correct-option qsm-text-user-correct-answer "></span>';
							} else {
								$final_ans .= '<span class="qsm-text-simple-option "></span>';
							}
						}
					} else {
						if ( array_key_exists( $key, $user_answer ) && in_array( $col_key, $user_answer[ $key ] ) ) {
							$final_ans .= '<span class="qsm-text-correct-option qsm-text-user-correct-answer "></span>';
						} else {
							$final_ans .= '<span class="qsm-text-simple-option "></span>';
						}
					}
					$final_ans .= '</td>';
				}
				$final_ans .= '</tr>';
			}
			$final_ans .= '</tbody></table></div>';
		} else {
			if ( 'correct' === $answer['correct'] ) {
				$user_answer_class = 'qsm_user_correct_answer';
			} else {
				$user_answer_class = 'qsm_user_incorrect_answer';
			}
			$user_ans   = $answer['user_answer'];
			$final_ans .= '<div class="' . $user_answer_class . ' qsm-advance-question-matching-pairs"><table class="qsm_answer_table"><tbody>';
			foreach ( $user_ans as $key => $val ) {
				$left_answers   = explode( ',,', $total_answers[ $key ][0] );
				$user_answers   = explode( ',,', $total_answers[ $val ][0] );
				$answer_type    = $mlwQuizMasterNext->pluginHelper->get_question_setting( $questionid, 'answerEditor' );
				if ( 'image' === $answer_type ) {
					$left_caption   = explode( ',,', $total_answers[ $key ][3] );
					$left_ans = '<td class="qsm_pairs_image_option"><img src="' . trim( htmlspecialchars_decode( $left_answers[0], ENT_QUOTES ) ) . '" /><span class="qsm_image_caption">' . wp_kses_post( trim( do_shortcode( htmlspecialchars_decode( $left_caption[0], ENT_QUOTES ) ) ) ) . '</td>';
				} else {
					$left_ans = '<td>' . trim( do_shortcode( htmlspecialchars_decode( $left_answers[0], ENT_QUOTES ) ) ) . '</td>';
				}
				if ( 'image' === $answer_type ) {
					$user_caption   = explode( ',,', $total_answers[ $val ][3] );
					$user_ans = '<td class="qsm_pairs_image_option"><img src="' . trim( htmlspecialchars_decode( $user_answers[1], ENT_QUOTES ) ) . '" /><span class="qsm_image_caption">' . wp_kses_post( trim( do_shortcode( htmlspecialchars_decode( $user_caption[1], ENT_QUOTES ) ) ) ) . '</td>';
				} else {
					$user_ans = '<td>' . trim( do_shortcode( htmlspecialchars_decode( $user_answers[1], ENT_QUOTES ) ) ) . '</td>';
				}
				if ( in_array( intval( $answer['question_type'] ), array( 16, 17 ), true ) ) {
					$user_ans_class = '';
				} elseif ( intval( $key ) === intval( $val ) ) {
					$user_ans_class = 'qsm-correct-match-pairs';
				} else {
					$user_ans_class = 'qsm-incorrect-match-pairs';
				}
				$final_ans .= '<tr class="' . $user_ans_class . '">' . $left_ans . $user_ans . '</tr>';

			}

			$final_ans .= '</tbody></table></div>';
		}
	}
	return $final_ans;
}
add_filter( 'qsm_result_page_custom_user_answer_template', 'qsm_advance_question_result_page_user_answer_template', 10, 3 );

/**
 * The qsm_advance_question_result_page_correct_answer_template filter callback function.
 *
 * @arg $question_type, $answer
 * return string
 **/
function qsm_advance_question_result_page_correct_answer_template( $final_ans, $questions, $answer ) {
	global $mlwQuizMasterNext;
	$questionid    = $questions[ $answer['id'] ]['question_id'];
	$total_answers = $questions[ $questionid ]['answers'];
	if ( 15 === intval( $answer['question_type'] ) ) {
		$user_ans  = $answer['user_answer'];
		$final_ans = '<div class="qsm-advance-question-matching-pairs"><table class="qsm_answer_table"><tbody>';
		foreach ( $user_ans as $key => $val ) {
			$answers        = explode( ',,', $total_answers[ $key ][0] );
			$answer_type    = $mlwQuizMasterNext->pluginHelper->get_question_setting( $questionid, 'answerEditor' );
			if ( 'image' === $answer_type ) {
				$caption        = explode( ',,', $total_answers[ $key ][3] );
				$left_ans = '<td class="qsm_pairs_image_option"><img src="' . trim( htmlspecialchars_decode( $answers[0], ENT_QUOTES ) ) . '" /><span class="qsm_image_caption">' . wp_kses_post( trim( do_shortcode( htmlspecialchars_decode( $caption[0], ENT_QUOTES ) ) ) ) . '</td>';
			} else {
				$left_ans = '<td>' . trim( do_shortcode( htmlspecialchars_decode( $answers[0], ENT_QUOTES ) ) ) . '</td>';
			}
			if ( 'image' === $answer_type ) {
				$correct_ans = '<td class="qsm_pairs_image_option"><img src="' . trim( htmlspecialchars_decode( $answers[1], ENT_QUOTES ) ) . '" /><span class="qsm_image_caption">' . wp_kses_post( trim( do_shortcode( htmlspecialchars_decode( $caption[1], ENT_QUOTES ) ) ) ) . '</td>';
			} else {
				$correct_ans = '<td>' . trim( do_shortcode( htmlspecialchars_decode( $answers[1], ENT_QUOTES ) ) ) . '</td>';
			}
			$final_ans .= '<tr>' . $left_ans . $correct_ans . '</tr>';
		}

		$final_ans .= '</tbody></table></div>';
	}
	return $final_ans;
}
add_filter( 'qsm_result_page_custom_correct_answer_template', 'qsm_advance_question_result_page_correct_answer_template', 10, 3 );

/**
 * qsm_advance_question_type_answers_before_save filter callback function.
 *
 * @param array $sanitize_answers Sanitized Ans.
 * @param array $answers Ans Array.
 * @param array $data Quiz Data.
 * @return array
 **/
function qsm_advance_question_type_answers_before_save( $sanitize_answers, $answers, $data ) {
	if ( in_array( intval( $data['type'] ), array( 16, 17 ), true ) ) {
		$columns = $answers['columns'];
		$points  = $answers['points'];
		$corrects  = $answers['corrects'];
		$rows    = $answers['rows'];
		$answer_label_array    = isset($answers['answer_label']) ? $answers['answer_label'] : array();
		$answer_label = array();
		foreach ( $columns as $key => $column ) {
			$column          = htmlspecialchars( sanitize_text_field( $column ), ENT_QUOTES );
			$columns[ $key ] = $column;
		}
		foreach ( $points as $key => $point ) {
			$point          = floatval( sanitize_text_field( $point ) );
			$points[ $key ] = $point;
		}
		foreach ( $corrects as $key => $correct ) {
			$correct          = floatval( sanitize_text_field( $correct ) );
			$corrects[ $key ] = $correct;
		}
		foreach ( $rows as $key => $row ) {
			$row          = htmlspecialchars( sanitize_text_field( $row ) );
			$rows[ $key ] = $row;
		}
		if ( ! empty($answer_label_array) ) {
			foreach ( $answer_label_array as $key => $label ) {
				$row          = sanitize_text_field( $label );
				$answer_label[ $key ] = $label;
			}
		}
		$sanitize_answers['columns']    = $columns;
		$sanitize_answers['points']     = $points;
		$sanitize_answers['rows']       = $rows;
		$sanitize_answers['corrects']   = $corrects;
		$sanitize_answers['answer_label']   = $answer_label;
	}
	return $sanitize_answers;
}
add_filter( 'qsm_answers_before_save', 'qsm_advance_question_type_answers_before_save', 13, 3 );
/**
 * qsm_advance_question_format_option filter callback function.
 *
 * @param array $simple_question_option  array for match answer,required.
 * @return array
 **/
function qsm_advance_question_format_option( $simple_question_option ) {
	$simple_question_option ['require-all-rows'] = array(
		'label'    => __( 'Require all rows', 'qsm-advance-question' ),
		'type'     => 'single_checkbox',
		'priority' => '5',
		'options'  => array(
			'0' => __( 'Yes', 'qsm-advance-question' ),
		),
		'default'  => '0',
		'show'     => '16,17',
	);

	$simple_question_option ['inline-drop-down'] = array(
		'label'    => __( 'Enable inline drop-down', 'qsm-advance-question' ),
		'type'     => 'single_checkbox',
		'priority' => '1',
		'options'  => array(
			'0' => __( 'Yes', 'qsm-advance-question' ),
		),
		'default'  => '0',
		'show'     => '2',
	);

	$simple_question_option ['drop-down-type'] = array(
		'label'    => __( 'Drop-down type', 'qsm-advance-question' ),
		'type'     => 'select',
		'priority' => '2',
		'options'  => array(
			'single'   => __( 'Single drop-down', 'qsm-advance-question' ),
			'multiple' => __( 'Multiple drop-down', 'qsm-advance-question' ),
		),
		'default'  => 'single',
		'show'     => '2',
	);

	$simple_question_option ['advance-polar'] = array(
		'label'    => __( 'Multi-polar type', 'qsm-advance-question' ),
		'type'     => 'select',
		'priority' => '1',
		'options'  => array(
			''  => __( 'Default', 'qsm-advance-question' ),
			'1' => __( 'Multi Slider', 'qsm-advance-question' ),
		),
		'default'  => '1',
		'show'     => '13',
	);
	return $simple_question_option;
}
add_filter( 'qsm_question_format_option', 'qsm_advance_question_format_option');

/**
 * qsm_advance_alert_required_all_rows filter callback function.
 *
 * @param array $field_array  array for alerts/messages.
 * @return array
 **/
// Registers empty_error_text setting
function qsm_advance_alert_required_all_rows() {
	global $mlwQuizMasterNext;
	// Registers empty_error_text setting
	$field_array = array(
		'id'         => 'empty_grid_radio_checkbox_text',
		'label'      => __( 'All required rows fields', 'qsm-advance-question' ),
		'type'       => 'text',
		'default'    => __( 'Please complete all  rows required fields!', 'qsm-advance-question' ),
		'option_tab' => 'text-validation-messages',
	);
	$mlwQuizMasterNext->pluginHelper->register_quiz_setting( $field_array, 'quiz_text' );
}
add_filter( 'init', 'qsm_advance_alert_required_all_rows');

function add_default_texts_advanced_question_type( $defaults ) {
	$defaults['empty_grid_radio_checkbox_text'] = __('Please complete all rows are required fields','qsm-advance-question');
	return $defaults;
}
add_filter( 'add_json_error_message_advanced_question_type','add_default_texts_advanced_question_type');

function add_json_error_message_advanced_question_type( $qmn_json_data,$options ) {
	global $mlwQuizMasterNext;
	$qmn_json_data['error_messages']['empty_grid_radio_checkbox_text'] = $mlwQuizMasterNext->pluginHelper->qsm_language_support( $options->empty_grid_radio_checkbox_text, "quiz_empty_grid_radio_checkbox_text-{$options->quiz_id}" );
	return $qmn_json_data;
}
add_filter( 'qsm_json_error_message','add_json_error_message_advanced_question_type', 10, 2 );

function qsm_advanced_question_title_func_after( $question, $answers, $question_id ) {
	global $mlwQuizMasterNext, $wpdb;
	$inline_drop_down = $mlwQuizMasterNext->pluginHelper->get_question_setting( $question_id, 'inline-drop-down' );
	$drop_down_type = $mlwQuizMasterNext->pluginHelper->get_question_setting( $question_id, 'drop-down-type' );
	$required = $mlwQuizMasterNext->pluginHelper->get_question_setting( $question_id, 'required' );
	if ( 0 == $required ) {
		$require_class = 'qsmRequiredSelect';
	} else {
		$require_class = '';
	}
	$input_text = '';

	if ( isset( $inline_drop_down ) && 0 == $inline_drop_down ) {
		$options = '';
		if ( 'multiple' === trim($drop_down_type) ) {
			$input_text .= '<select style="width:auto;" class="qsm_select qsm_dropdown ' . $require_class . '" name="question' . $question_id . '[]">';
			$options .= '<option disabled selected value></option>';
			foreach ( $answers as $answer_index => $answer ) {
				$answer_text = trim( htmlspecialchars_decode( $answer[0], ENT_QUOTES ) );
				$answer_text = $mlwQuizMasterNext->pluginHelper->qsm_language_support( $answer_text, "answer-" . $question_id . "-" . $answer_index, "QSM Answers" );
				$options .= '<option value="' . esc_html( $answer_text ) . '">' . esc_html( $answer_text ) . '</option>';
			}
		} elseif ( 'single' === trim($drop_down_type) ) {
			$input_text .= '<select style="width:auto;" class="qsm_select qsm_dropdown ' . $require_class . '" name="question' . $question_id . '">';
			$options .= '<option disabled selected value></option>';
			foreach ( $answers as $answer_index => $answer ) {
				$answer_text = trim( htmlspecialchars_decode( $answer[0], ENT_QUOTES ) );
				$answer_text = $mlwQuizMasterNext->pluginHelper->qsm_language_support( $answer_text, "answer-" . $question_id . "-" . $answer_index, "QSM Answers" );
				$options .= '<option value="'. esc_attr( $answer_index ) .'">' . esc_html( $answer_text ) . '</option>';
			}
		}

		$input_text .= $options;
		$input_text .= '</select>';
		if ( strpos( $question, '%DROPDOWN%' ) !== false ) {
			$question = str_replace( '%DROPDOWN%', $input_text, do_shortcode( htmlspecialchars_decode( $question, ENT_QUOTES ) ) );
		}
	}

	return $question;
}
add_filter( 'qsm_question_title_function_before','qsm_advanced_question_title_func_after', 10, 3 );

function qsm_advance_question_type_description( $description_arr ) {
	$description_arr[] = array(
		'question_type_id' => '2',
		'description'      => __( 'Use %DROPDOWN% variable in the description field to display drop-down.', 'qsm-advance-question' ),
	);

	return $description_arr;
}
add_filter( 'qsm_question_type_description', 'qsm_advance_question_type_description', 10, 1 );

function qsm_advanced_admin_messages_after( $qsm_admin_messages ) {
	$qsm_admin_messages = array_merge(
		$qsm_admin_messages,
		array(
			'drop_down_single_validation'   => __('Only one <strong>%DROPDOWN%</strong> variable is allowed in single drop down type.', 'qsm-advance-question'),
			'drop_down_multiple_validation' => __('Number of <strong>%DROPDOWN%</strong> variables should be equal to the number of answer options in multiple drop-down types.', 'qsm-advance-question'),
			'advance_polar_validation'      => __('Number of answers should be greater than or equal to three.', 'qsm-advance-question'),
		)
	);

	return $qsm_admin_messages;
}
add_filter( 'qsm_admin_messages_after', 'qsm_advanced_admin_messages_after', 10, 1 );

function qsm_modify_allow_html_question_title( $allow_html, $question_id ) {
	global $mlwQuizMasterNext;
	$inline_drop_down = $mlwQuizMasterNext->pluginHelper->get_question_setting( $question_id, 'inline-drop-down' );

	if ( isset( $inline_drop_down ) && 0 == $inline_drop_down ) {
		$allow_html['select']['name'] = 1;
		$allow_html['select']['style'] = 1;
		$allow_html['select']['class'] = 1;
		$allow_html['select']['id'] = 1;
		$allow_html['option']['value'] = 1;
	}

	return $allow_html;
}
add_filter( 'qsm_allow_html_question_title_after', 'qsm_modify_allow_html_question_title', 10, 2 );

function qsm_advance_check_show_answer_drop_down( $show, $question_id, $question, $answers ) {
	global $mlwQuizMasterNext;
	$inline_drop_down = $mlwQuizMasterNext->pluginHelper->get_question_setting( $question_id, 'inline-drop-down' );

	if ( isset( $inline_drop_down ) && 0 == $inline_drop_down ) {
		$show = false;
	}
	return $show;
}
add_filter( 'qsm_check_show_answer_drop_down', 'qsm_advance_check_show_answer_drop_down', 10, 4 );

function qsm_advance_is_answer_correct_choice_before( $is_answer_correct, $single_answer, $user_answer_array, $single_answer_key, $answers_from_response, $grading_system, $question_settings, $form_type ) {
	if ( isset($question_settings['inline-drop-down'], $question_settings['drop-down-type']) && 2 == $answers_from_response['question_type'] && 0 == $question_settings['inline-drop-down'] && 'multiple' == $question_settings['drop-down-type'] ) {
		$is_answer_correct = ($answers_from_response['correct_answer'][ $single_answer_key ] === $user_answer_array[ $single_answer_key ]);
	}
	return $is_answer_correct;
}
add_filter( 'qsm_is_answer_correct_choice_before', 'qsm_advance_is_answer_correct_choice_before', 10, 8 );

function qsm_advance_show_user_answer_before( $show_user_answer, $single_answer, $user_answer_array, $single_answer_key, $answers_from_response, $grading_system, $question_settings, $form_type ) {
	if ( isset($question_settings['inline-drop-down'], $question_settings['drop-down-type']) && 2 == $answers_from_response['question_type'] && 0 == $question_settings['inline-drop-down'] && 'multiple' == $question_settings['drop-down-type'] ) {
		$show_user_answer = ! empty($user_answer_array[ $single_answer_key ]) ? htmlspecialchars_decode( $user_answer_array[ $single_answer_key ], ENT_QUOTES ) : htmlspecialchars_decode( $single_answer[0], ENT_QUOTES );
	}
	return $show_user_answer;
}
add_filter( 'qsm_show_user_answer_before', 'qsm_advance_show_user_answer_before', 10, 8 );

function qmn_advance_drop_down_review_before( $current_object, $id, $question, $answers ) {
	global $mlwQuizMasterNext;
	$inline_drop_down = $mlwQuizMasterNext->pluginHelper->get_question_setting( $id, 'inline-drop-down' );
	$drop_down_type = $mlwQuizMasterNext->pluginHelper->get_question_setting( $id, 'drop-down-type' );
	if ( class_exists( 'QSM_Advance_Question_Review_Choice' ) && isset( $inline_drop_down ) && 0 == $inline_drop_down && 'multiple' == $drop_down_type ) {
		return new QSM_Advance_Question_Review_Choice( $id, $question, $answers );
	}
	return $current_object;
}
add_filter( 'qmn_drop_down_review_before', 'qmn_advance_drop_down_review_before', 10, 4 );

function qmn_advanced_variable_question_answers( $mlw_question_answer_display, $mlw_quiz_array, $question_obj ) {

	if ( $question_obj['question_type_new'] == 2 && (strpos($mlw_question_answer_display, '%DROPDOWN%') !== false || strpos($mlw_question_answer_display, '%dropdown%') !== false) ) {
		return str_replace([ '%DROPDOWN%', '%dropdown%' ], [ '__________', '__________' ], $mlw_question_answer_display);
	}
	return $mlw_question_answer_display;
}
add_filter( 'qmn_variable_question_answers', 'qmn_advanced_variable_question_answers', 10, 3 );

function qsm_check_multi_polar_slide_show_status( $show, $question_id ) {
	global $mlwQuizMasterNext;
	$advance_polar = $mlwQuizMasterNext->pluginHelper->get_question_setting( $question_id, 'advance-polar' );
	if ( ! empty( $advance_polar ) && 1 === intval( $advance_polar ) ) {
		$show = false;
	}
	return $show;
}
add_filter( 'qsm_check_advance_polar_show_status', 'qsm_check_multi_polar_slide_show_status', 10, 2 );

function qsm_advance_display_multi_polar_slide( $blank, $id, $question, $answers ) {
	global $mlwQuizMasterNext;
	$advance_polar  = $mlwQuizMasterNext->pluginHelper->get_question_setting( $id, 'advance-polar' );
	$required       = $mlwQuizMasterNext->pluginHelper->get_question_setting( $id, 'required' );
	$answerEditor   = $mlwQuizMasterNext->pluginHelper->get_question_setting( $id, 'answerEditor' );
	$image_width    = $mlwQuizMasterNext->pluginHelper->get_question_setting( $id, 'image_size-width' );
	$image_height   = $mlwQuizMasterNext->pluginHelper->get_question_setting( $id, 'image_size-height' );
	$first_point    = isset( $answers[0][1] ) ? floatval( $answers[0][1] ) : 0;
	$second_point   = isset( $answers[ count($answers) - 1 ][1] ) ? floatval( $answers[ count($answers) - 1 ][1] ) : 0;
	$is_reverse     = false;
	$check_point    = $second_point;
	if ( $first_point > $second_point ) {
		$is_reverse  = true;
		$check_point = $first_point;
	}
	$total_answer      = count( $answers );
	$id                = esc_attr( intval( $id ) );
	$answar1           = $first_point;
	$answar2           = $second_point;
	$slider_data_atts  = '';
	$slider_data_atts .= ' data-answer1=' . $answar1 . ' ';
	$slider_data_atts .= ' data-answer2=' . $answar2 . ' ';
	$slider_data_atts .= ' data-is_reverse=' . intval( $is_reverse ) . ' ';
	$slider_data_atts .= ' data-is_required=' . $required . ' ';
	if ( 0 == $required ) {
		$mlw_require_class = 'mlwRequiredText mlwRequiredPolar';
	} else {
		$mlw_require_class = '';
	}

	if ( ! empty( $advance_polar ) && 1 === intval( $advance_polar ) ) {
	?>
	<span class="mlw_qmn_question question-type-polar-s qsm-advance-polar">
		<div class="qsm-advance-polar-options">
			<?php foreach ( $answers as $index => $answer ) : ?>
				<div id="polar-<?php echo esc_attr( $answer[1] ); ?>" class="polar-title"> <?php
					if ( 'image' === $answerEditor ) {
						$size_style = '';
						if ( ! empty($image_width) ) {
							$size_style .= 'width:'.$image_width.'px !important;';
						}
						if ( ! empty($image_height) ) {
							$size_style .= ' height:'.$image_height.'px !important;';
						}
						$left_image = $answer[0];
						?>
						<img class="qsm-polar-img" alt="<?php echo esc_attr( $new_question_title ); ?>" src="<?php echo esc_url( trim( htmlspecialchars_decode( $left_image, ENT_QUOTES ) ) ); ?>"  style="<?php echo esc_attr( $size_style ); ?>"  />
						<span class="qsm_image_caption">
							<?php
							$caption_text = trim( htmlspecialchars_decode( $answer[3], ENT_QUOTES ) );
							$caption_text = $mlwQuizMasterNext->pluginHelper->qsm_language_support( $caption_text, 'caption-' . $id . '-' . $index, 'QSM Answers' );
							echo esc_html( $caption_text );
							?>
						</span>
						<?php
					} else {
						$left_title = $mlwQuizMasterNext->pluginHelper->qsm_language_support( $answer[0], 'answer-' . $id . '-' . $index, "QSM Answers" );
						echo wp_kses_post( do_shortcode( $left_title ) );
					}
					?>
				</div>
			<?php endforeach; ?>
		</div>
		<div class='slider-main-wrapper'>
			<input type='hidden' class='qmn_polar <?php echo esc_attr( $mlw_require_class ); ?>' id='question<?php echo esc_attr( $id ); ?>' name='question<?php echo esc_attr( $id ); ?>' value=''/>
			<div id="slider-<?php echo esc_attr( $id ); ?>" <?php echo esc_attr( $slider_data_atts ); ?> ></div>
		</div>
	</span>
	<?php
	}
}
add_filter( 'qmn_polar_display_front_before', 'qsm_advance_display_multi_polar_slide', 10, 4 );

function qsm_result_page_display_multi_polar_slide( $question_display, $id, $question, $answers, $answer ) {
	global $mlwQuizMasterNext;
	$required       = $mlwQuizMasterNext->pluginHelper->get_question_setting( $id, 'required' );
	$answerEditor   = $mlwQuizMasterNext->pluginHelper->get_question_setting( $id, 'answerEditor' );
	$image_width    = $mlwQuizMasterNext->pluginHelper->get_question_setting( $id, 'image_size-width' );
	$image_height   = $mlwQuizMasterNext->pluginHelper->get_question_setting( $id, 'image_size-height' );
	$advance_polar  = $mlwQuizMasterNext->pluginHelper->get_question_setting( $id, 'advance-polar' );
	$input_text     = '';
	$first_point    = isset( $answers[0][1] ) ? intval( $answers[0][1] ) : 0;
	$second_point   = isset( $answers[ count($answers) - 1 ][1] ) ? intval( $answers[ count($answers) - 1 ][1] ) : 0;
	$mid_point      = ( $second_point - $first_point ) / 2;
	$is_reverse     = false;
	if ( $first_point > $second_point ) {
		$is_reverse = true;
		$mid_point  = ( $first_point - $second_point ) / 2;
	}
	$total_answer      = count( $answers );
	$id                = esc_attr( intval( $id ) );
	$answar1           = $first_point;
	$answar2           = $second_point;
	$user_answer       = $answer[1];
	$slider_date_atts  = '';
	$slider_date_atts .= ' data-answer1="' . $answar1 . '" ';
	$slider_date_atts .= ' data-answer2="' . $answar2 . '" ';
	$slider_date_atts .= ' data-is_reverse="' . intval( $is_reverse ) . '" ';
	$slider_date_atts .= ' data-answer_value="' . $user_answer . '" ';
	$mlw_require_class = '';
	if ( 0 == $required ) {
		$mlw_require_class = 'mlwRequiredText';
	}
	$polar_title_style = 'style="font-weight:900;"';
	if ( ! empty( $advance_polar ) && 1 === intval( $advance_polar ) ) {
		$question_display = '';
		$input_text       .= '<div class="qsm-advance-polar-options">';

		foreach ( $answers as $index => $ans ) {
			if ( $ans[1] == $user_answer ) {
				$input_text .= '<div id="polar-'. esc_attr( $ans[1] ) .'" class="polar-title transparent-before" '. $polar_title_style .' >';
			} else {
				$input_text .= '<div id="polar-'. esc_attr( $ans[1] ) .'" class="polar-title">';
			}
			if ( 'image' === $answerEditor ) {
				$size_style = '';
				if ( ! empty($image_width) ) {
					$size_style .= 'width:'.$image_width.'px !important;';
				}
				if ( ! empty($image_height) ) {
					$size_style .= ' height:'.$image_height.'px !important;';
				}
				$left_image = $ans[0];
				$caption_text = trim( htmlspecialchars_decode( $ans[3], ENT_QUOTES ) );
				$caption_text = $mlwQuizMasterNext->pluginHelper->qsm_language_support( $caption_text, 'caption-' . $caption_text, 'QSM Answers' );
				$input_text .= '<img src="'.esc_url( trim( htmlspecialchars_decode( $left_image, ENT_QUOTES ) ) ).'"  style="'.esc_attr( $size_style ).'"  />';
				$input_text .= '<span class="qsm_image_caption">'.esc_html( $caption_text ).'</span>';
			} else {
				$left_title = $mlwQuizMasterNext->pluginHelper->qsm_language_support( $ans[0], "answer-" . $ans[0], "QSM Answers" );
				$input_text       .= wp_kses_post( do_shortcode( $left_title ) );
			}
			$input_text       .= "</div>";
		}

		$input_text       .= "</div>";
		$input_text       .= "<div class='slider-main-wrapper'><input type='hidden' class='qmn_polar $mlw_require_class' id='question" . esc_attr( $id ) . "' name='question" . esc_attr( $id ) . "' />";
		$input_text       .= '<div id="slider-' . esc_attr( $id ) . '"' . $slider_date_atts . '></div></div>';

		$question_display .= "<span class='mlw_qmn_question mlw-qmn-question-result-$id question-type-polar-s qsm-advance-polar'>" . do_shortcode( htmlspecialchars_decode( $input_text, ENT_QUOTES ) ) . '</span>';
	}
	return $question_display;
}
add_filter( 'qmn_polar_display_result_page', 'qsm_result_page_display_multi_polar_slide', 10, 5 );

/**
 * Calculate the maximum and minimum points for advanced questions.
 *
 * @param array $max_min_result     The current max/min results.
 * @param bool  $question_required   Whether the question is required.
 * @param array $questions           The questions data.
 *
 * @return array                     The updated max/min results.
 */
function qsm_advance_question_max_min_points( $max_min_result, $question_required, $questions ) {
    // Check if the question type is one of the specified types.
    if ( in_array( intval( $questions['question_type_new'] ), array( 15, 16, 17 ), true ) ) {
        // Initialize max and min arrays.
        $max_value_array = [];
        $min_value_array = [];
        $max_min_result = array( 'max_point' => 0, 'min_point' => 0 );

        // Handle question type 15.
        if ( 15 === intval( $questions['question_type_new'] ) ) {
            foreach ( $questions['answers'] as $answer ) {
                if ( isset( $answer[1] ) ) {
                    $point_value = floatval( $answer[1] );
                    if ( $point_value > 0 ) {
                        $max_value_array[] = $point_value;
                    } elseif ( $point_value < 0 ) {
                        $min_value_array[] = $point_value;
                    }
                }
            }
        } else {
            // Handle other question types (16, 17).
            if ( isset( $questions['answers']['points'], $questions['answers']['columns'], $questions['answers']['rows'] ) ) {
                $columns_count = count( $questions['answers']['columns'] ?? [] );
                $rows_count = count( $questions['answers']['rows'] ?? [] );
				if ( 16 === intval( $questions['question_type_new'] ) ) {
					$radio_row_points = [];
                    $i = 0;
                    for ( $c = 0; $c < $columns_count; $c++ ) {
                        for ( $r = 0; $r < $rows_count; $r++ ) {
                            $radio_row_points[$r][$c] = floatval( $questions['answers']['points'][$i++] ?? 0 );
                        }
                    }
                    foreach ( $radio_row_points as $radio_row_point ) {
                        $max_value_array[] = max( $radio_row_point );
                        $min_value_array[] = min( $radio_row_point );
                    }
				} else {
					foreach ( $questions['answers']['points'] as $single_answer_arr ) {
						$point_value = floatval( $single_answer_arr );
						if ( $point_value > 0 ) {
							$max_value_array[] = $point_value;
						} elseif ( $point_value < 0 ) {
							$min_value_array[] = $point_value;
						}
					}
                }
            }
        }

        // Return early if both arrays are empty.
        if ( empty( $max_value_array ) && empty( $min_value_array ) ) {
            return $max_min_result;
        }

        // Calculate max and min points based on available data.
        if ( empty( $max_value_array ) ) {
            $max_min_result['max_point'] = 0;
            $max_min_result['min_point'] = $question_required ? array_sum( $min_value_array ) : 0;
        } elseif ( empty( $min_value_array ) ) {
            $max_min_result['max_point'] = array_sum( $max_value_array );
            $max_min_result['min_point'] = $question_required ? min( $max_value_array ) : 0;
        } else {
            $max_min_result['max_point'] = array_sum( $max_value_array );
            $max_min_result['min_point'] = $question_required ? array_sum( $min_value_array ) : 0;
        }
    }

    return $max_min_result;
}

add_filter( 'qsm_max_min_points_conditions_result', 'qsm_advance_question_max_min_points', 10, 3 );
?>