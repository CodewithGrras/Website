<?php
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Creates function for the qsm_passed shortcode
 *
 * @since 2.0.0
 * @return int The amount of results with score greater than the supplied score in shortcode parameters
 */
function qsm_addon_extra_shortcodes_passed_score_shortcode( $atts ) {
  extract(shortcode_atts(array(
	  'score'   => 90,
	  'quiz_id' => 1,
  ), $atts));

  $score = intval( $score );
  $quiz_ids = array_map('intval', explode(',', $quiz_id)); // Convert quiz IDs to an array of integers
  $quiz_ids_placeholder = implode(',', array_fill(0, count($quiz_ids), '%d')); // Create placeholders for the quiz IDs

  global $wpdb;
  $query = $wpdb->prepare(
    "SELECT COUNT(quiz_name) FROM {$wpdb->prefix}mlw_results WHERE deleted=0 AND quiz_id IN ($quiz_ids_placeholder) AND correct_score>=%d",
    array_merge($quiz_ids, array( $score ))
  );

  return $wpdb->get_var( $query );
}

/**
 * Creates function for the qsm_passed_points shortcode
 *
 * @since 2.0.0
 * @return int The amount of results with score greater than the supplied score in shortcode parameters
 */
function qsm_addon_extra_shortcodes_passed_point_shortcode( $atts ) {
  extract(shortcode_atts(array(
	  'score'   => 90,
	  'quiz_id' => 1,
  ), $atts));

  $score = intval( $score );
  $quiz_ids = array_map('intval', explode(',', $quiz_id)); // Convert quiz IDs to an array of integers
  $quiz_ids_placeholder = implode(',', array_fill(0, count($quiz_ids), '%d')); // Create placeholders for the quiz IDs

  global $wpdb;
  $query = $wpdb->prepare(
    "SELECT COUNT(quiz_name) FROM {$wpdb->prefix}mlw_results WHERE deleted=0 AND quiz_id IN ($quiz_ids_placeholder) AND point_score>=%d",
    array_merge($quiz_ids, array( $score ))
  );

  return $wpdb->get_var( $query );
}

/**
 * Creates function for the qsm_failed_points shortcode
 *
 * @since 2.0.0
 * @return int The amount of results with a point score less than the supplied score shortcode parameter
 */
function qsm_addon_extra_shortcodes_failed_point_shortcode( $atts ) {
  extract(shortcode_atts(array(
	  'score'   => 90,
	  'quiz_id' => 1,
  ), $atts));

  $score = intval( $score );
  $quiz_ids = array_map('intval', explode(',', $quiz_id)); // Convert quiz IDs to an array of integers
  $quiz_ids_placeholder = implode(',', array_fill(0, count($quiz_ids), '%d')); // Create placeholders for the quiz IDs

  global $wpdb;
  $query = $wpdb->prepare(
    "SELECT COUNT(quiz_name) FROM {$wpdb->prefix}mlw_results WHERE deleted=0 AND quiz_id IN ($quiz_ids_placeholder) AND point_score<%d",
    array_merge($quiz_ids, array( $score ))
  );

  return $wpdb->get_var( $query );
}

/**
 * Creates function for the qsm_failed shortcode
 *
 * @since 2.0.0
 * @return int The amount of results with a score less than the supplied score shortcode parameter
 */
function qsm_addon_extra_shortcodes_failed_score_shortcode( $atts ) {
  extract(shortcode_atts(array(
	  'score'   => 90,
	  'quiz_id' => 1,
  ), $atts));

  $score = intval( $score );
  $quiz_ids = array_map('intval', explode(',', $quiz_id)); // Convert quiz IDs to an array of integers
  $quiz_ids_placeholder = implode(',', array_fill(0, count($quiz_ids), '%d')); // Create placeholders for the quiz IDs

  global $wpdb;
  $query = $wpdb->prepare(
    "SELECT COUNT(quiz_name) FROM {$wpdb->prefix}mlw_results WHERE deleted=0 AND quiz_id IN ($quiz_ids_placeholder) AND correct_score<%d",
    array_merge($quiz_ids, array( $score ))
  );

  return $wpdb->get_var( $query );
}

/**
 * Creates function for the qsm_taken shortcode
 *
 * @since 2.0.0
 * @return int The amount of times the quiz has been taken
 */
function qsm_addon_extra_shortcodes_taken_shortcode( $atts ) {
  extract(shortcode_atts(array(
	  'quiz_id' => '1',
  ), $atts));

  $quiz_ids = array_map('intval', explode(',', $quiz_id)); // Convert quiz IDs to an array of integers
  $quiz_ids_placeholder = implode(',', array_fill(0, count($quiz_ids), '%d')); // Create placeholders for the quiz IDs

  global $wpdb;
  $query = $wpdb->prepare(
    "SELECT COUNT(quiz_name) FROM {$wpdb->prefix}mlw_results WHERE deleted=0 AND quiz_id IN ($quiz_ids_placeholder)",
    $quiz_ids
  );

  return $wpdb->get_var( $query );
}

/**
 * Creates function for the qsm_average shortcode
 *
 * @since 2.0.0
 * @return int The average score of the results for the quiz
 */
function qsm_addon_extra_shortcodes_average_score_shortcode( $atts ) {
  extract(shortcode_atts(array(
	  'quiz_id' => '1',
	  'decimal' => 2,
  ), $atts));
  $decimal = intval( $decimal );
  $quiz_ids = array_map('intval', explode(',', $quiz_id)); // Convert quiz IDs to an array of integers
  $quiz_ids_placeholder = implode(',', array_fill(0, count($quiz_ids), '%d')); // Create placeholders for the quiz IDs

  global $wpdb;
  $query = $wpdb->prepare(
    "SELECT ROUND(AVG(correct_score), $decimal) FROM {$wpdb->prefix}mlw_results WHERE deleted=0 AND quiz_id IN ($quiz_ids_placeholder)",
    $quiz_ids
  );

  return $wpdb->get_var( $query );
}

/**
 * Creates function for the qsm_average_points shortcode
 *
 * @since 2.0.0
 * @return int The average point score of the results for the quiz
 */
function qsm_addon_extra_shortcodes_average_point_shortcode( $atts ) {
  extract(shortcode_atts(array(
	  'quiz_id' => '1',
	  'decimal' => 2,
  ), $atts));
  $decimal = intval( $decimal );
  $quiz_ids = array_map('intval', explode(',', $quiz_id)); // Convert quiz IDs to an array of integers
  $quiz_ids_placeholder = implode(',', array_fill(0, count($quiz_ids), '%d')); // Create placeholders for the quiz IDs

  global $wpdb;
  $query = $wpdb->prepare(
    "SELECT ROUND(AVG(point_score), $decimal) FROM {$wpdb->prefix}mlw_results WHERE deleted=0 AND quiz_id IN ($quiz_ids_placeholder)",
    $quiz_ids
  );

  return $wpdb->get_var( $query );
}

/**
 * Creates function for the qsm_recent shortcode
 *
 * @since 2.0.0
 * @return string An HTML list of the most recent quizzes
 */
function qsm_addon_extra_shortcodes_recent_shortcode( $atts ) {
  extract(shortcode_atts(array(
	  'amount' => 5,
  ), $atts));
  $amount = intval( $amount );

  $return = '';
  global $wpdb;
  $recent_quizzes = $wpdb->get_results( "SELECT quiz_id, quiz_name FROM {$wpdb->prefix}mlw_quizzes ORDER BY quiz_id DESC LIMIT $amount" );
  $quizzes = array();
  foreach ( $recent_quizzes as $quiz ) {
    $quizzes[ $quiz->quiz_id ] = $quiz->quiz_name;
  }

  $args = array(
	  'post_type'  => 'qsm_quiz',
	  'meta_query' => array(
		  array(
			  'key'     => 'quiz_id',
			  'value'   => array_keys( $quizzes ),
			  'compare' => 'IN',
		  ),
	  ),
  );
  $my_query = new WP_Query( $args );

  if ( $my_query->have_posts() ) {
    $return .= '<ul class="qsm-popular-list">';
    while ( $my_query->have_posts() ) {
      $my_query->the_post();
      $return .= "<li><a href='" . get_the_permalink() . "'>" . $quizzes[ get_post_meta( get_the_ID(), 'quiz_id', true ) ] . "</a>";
    }
    $return .= '</ul>';
  }
  return $return;
}

/**
 * Creates function for the qsm_popular shortcode
 *
 * @since 2.0.0
 * @return string An HTML list of the most popular quizzes
 */
function qsm_addon_extra_shortcodes_popular_shortcode( $atts ) {
  extract(shortcode_atts(array(
	  'amount' => 5,
  ), $atts));
  $amount = intval( $amount );

  $return = '';
  global $wpdb;
  $recent_quizzes = $wpdb->get_results( "SELECT quiz_id, quiz_name FROM {$wpdb->prefix}mlw_quizzes ORDER BY quiz_taken DESC LIMIT $amount" );
  $quizzes = array();
  foreach ( $recent_quizzes as $quiz ) {
    $quizzes[ $quiz->quiz_id ] = $quiz->quiz_name;
  }

  $args = array(
	  'post_type'  => 'qsm_quiz',
	  'meta_query' => array(
		  array(
			  'key'     => 'quiz_id',
			  'value'   => array_keys( $quizzes ),
			  'compare' => 'IN',
		  ),
	  ),
  );
  $my_query = new WP_Query( $args );

  if ( $my_query->have_posts() ) {
    $return .= '<ul class="qsm-popular-list">';
    while ( $my_query->have_posts() ) {
      $my_query->the_post();
      $return .= "<li><a href='" . get_the_permalink() . "'>" . $quizzes[ get_post_meta( get_the_ID(), 'quiz_id', true ) ] . "</a></li>";
    }
    $return .= '</ul>';
  }
  return $return;
}

/**
 * Creates function for the qsm_all_quizzes shortcode
 * [qsm_all_quizzes button_text="Preview" limit="" order_by="quiz_id" date_range="" ]
 * @since 3.0.1
 * @return string An HTML list of all quizzes in the database
 */
function qsm_addon_extra_shortcodes_all_quizzes_shortcode( $atts ) {
  extract( shortcode_atts( array(
    'button_text' => __( 'Preview', 'qsm-extra-shortcodes' ),
    'limit'       => '',
    'order_by'    => 'quiz_id',
    'date_range'  => '',
  ), $atts ) );

  $return = '';
  global $wpdb;
  $query = "SELECT quiz_id, quiz_name FROM {$wpdb->prefix}mlw_quizzes";
  if ( ! empty( $date_range ) ) {
    $dates = explode( ',', $date_range );
    $start_date = ! empty( $dates[0] ) ? $dates[0] : '0000-00-00';
    $end_date   = ! empty( $dates[1] ) ? $dates[1] : '9999-12-31';
    $query      .= " WHERE last_activity BETWEEN '$start_date 00:00:00' AND '$end_date 23:59:59'";
  }
  if ( ! empty( $order_by ) ) {
    $query .= " ORDER BY $order_by";
    $query .= " DESC";
  }
  if ( ! empty( $limit ) ) {
    $query .= " LIMIT $limit";
  }
  $recent_quizzes = $wpdb->get_results( $query );
  $quizzes = array();
  foreach ( $recent_quizzes as $quiz ) {
    $quizzes[ $quiz->quiz_id ] = $quiz->quiz_name;
  }

  $args = array(
    'post_type'  => 'qsm_quiz',
    'meta_query' => array(
      array(
        'key'     => 'quiz_id',
        'value'   => array_keys( $quizzes ),
        'compare' => 'IN',
      ),
    ),
  );
  $qsm_query_fetch_all_posts = new WP_Query( $args );
  $css = "table.qsm-all-quizzes-list tbody tr td .qsm-quiz-preview-button {
    background: #2271b1;
    border-color: #2271b1;
    color: #fff;
    text-decoration: none;
    text-shadow: none;
    display: inline-block;
    font-size: 13px;
    line-height: 2.15384615;
    min-height: 30px;
    margin: 0;
    padding: 0 10px;
    cursor: pointer;
    border-width: 1px;
    border-style: solid;
    -webkit-appearance: none;
    border-radius: 3px;
    white-space: nowrap;
    box-sizing: border-box;
  }
  table.qsm-all-quizzes-list tr td {
    border-bottom: 1px solid #e5e5e5;
    padding: 10px 0;
  }";
  wp_register_style( 'qsm-extra-shortcodes', false );
  wp_add_inline_style( 'qsm-extra-shortcodes', $css );
  wp_enqueue_style( 'qsm-extra-shortcodes' );
  if ( $qsm_query_fetch_all_posts->have_posts() ) {
    $return .= '<table class="qsm-all-quizzes-list"><thead><tr><th>' . __( 'Quiz Name', 'qsm-extra-shortcode' ) . '</th><th>' . __( 'Action', 'qsm-extra-shortcode' ) . '</th></tr></thead><tbody>';
    foreach ( $quizzes as $quiz_id => $quiz_name ) {
      $post = $qsm_query_fetch_all_posts->posts[ array_search( $quiz_id, array_column( $qsm_query_fetch_all_posts->posts, 'ID' ) ) ];
      if ( $post ) {
        $return .= "<tr><td>" . $quiz_name . "</td><td><a href='" . get_the_permalink( $post->ID ) . "' target='_blank' class='qsm-quiz-preview-button'>" . $button_text . "</a></td></tr>";
      }
    }
    $return .= '</table>';
  }
  return $return;
}

/**
 * Creates a function for the qsm_assessment_compare shortcode.
 *
 * @since 2.1.0
 * @param array $atts Shortcode attributes.
 * @return string HTML chart of assessment levels.
 */
function qsm_addon_extra_shortcodes_assessment_compare( $atts ) {
	static $qsm_extrashortcode_css_added = false;

	// Extract shortcode attributes.
	$args = shortcode_atts(
		array(
			'value1' => 1,
			'value2' => 2,
			'label1' => __( 'Label 1', 'qsm-extra-shortcode' ),
			'label2' => __( 'Label 2', 'qsm-extra-shortcode' ),
			'color'  => '#2880B9',
		),
		$atts
	);

	$value1 = intval( $args['value1'] );
	$value2 = intval( $args['value2'] );
	$total_points = $value1 + $value2;

	if ( 0 === $total_points ) {
		return ''; // Prevent division by zero.
	}

	$point1_percentage = ( $value1 * 100 ) / $total_points;
	$point2_percentage = ( $value2 * 100 ) / $total_points;

	$percentage_label = ( $point2_percentage > $point1_percentage ) ? $args['label2'] : $args['label1'];
	$percentage = round( max( $point1_percentage, $point2_percentage ) );

	ob_start();
  $css = "";
	if ( ! $qsm_extrashortcode_css_added ) {
		$qsm_extrashortcode_css_added = true;
		$css = "<style>
		.qsm-comparison-graph-container {
			width: 100%;
			padding: 5px;
			display: flex;
			justify-content: space-between;
			align-items: center;
			box-sizing: border-box;
		}
		span.qsm-comparison-graph {
			height: 12px;
			width: 100%;
			margin: 0 10px;
			border-radius: 10px;
			position: relative;
			background-color: #2880B9; /* Fallback color */
		}
		span.qsm-comparison-graph-label {
			min-width: -webkit-max-content;
			min-width: -moz-max-content;
			min-width: max-content;
			box-sizing: border-box;
		}
		span.qsm-comparison-graph-active-label {
			position: absolute;
			top: -25px;
			left: calc(100% - 93px);
			width: -webkit-max-content;
			width: -moz-max-content;
			width: max-content;
			box-sizing: border-box;
      font-weight: 600;
		}
		.qsm-comparison-graph-dot {
			content: '';
			width: 12px;
			height: 12px;
			top: 0;
			display: block;
			border: 2px solid #fff;
			border-radius: 50%;
			position: absolute;
			left: 97%;
			box-sizing: border-box;
		}
		</style>";
	}

	$html = '<div class="qsm-comparison-graph-container">
		<span class="qsm-comparison-graph-label">' . esc_html( $args['label1'] ) . '</span>
		<span class="qsm-comparison-graph" style="background: ' . esc_attr( $args['color'] ) . ';">
			<span class="qsm-comparison-graph-dot" style="left: calc(' . esc_attr( $percentage ) . '% - 10px);"></span>
			<span class="qsm-comparison-graph-active-label" style="left: calc(' . esc_attr( $percentage ) . '% - 50px);">
				<span class="qsm-comparison-graph-score" style="color: ' . esc_attr( $args['color'] ) . ';">' . esc_html( $percentage ) . '%</span>
				' . esc_html( $percentage_label ) . '
			</span>
		</span>
		<span class="qsm-comparison-graph-label">' . esc_html( $args['label2'] ) . '</span>
	</div>';

	$html = apply_filters( 'qsm_extra_shortcodes_assessment_compare', $html, $args );
  return $css . $html;
}

function qsm_addon_extra_shortcodes_display_score( $atts ) {

	$scoreby = "";
	if ( isset($atts['scoreby']) ) {

		extract(shortcode_atts(array(
			'order'    => 'score',
			'mlw_quiz' => "",
		), $atts));

		$quiz_sql = $mlw_order_sql = $mlw_limit_sql = '';

		if ( 'top' == $atts['scoreby'] ) {
			$order = 'point_score';
		} elseif ( 'lowest' == $atts['scoreby'] ) {
			$order = 'point_score_asc';
		}
		switch ( $order ) {
			case 'point_score':
				$mlw_order_sql .= " ORDER BY point_score DESC";
				break;
			case 'point_score_asc':
				$mlw_order_sql .= " ORDER BY point_score ASC";
				break;
			default:
				$mlw_order_sql = " ORDER BY correct_score DESC";
				break;
		}

		if ( "" != $mlw_quiz ) {
      $quiz_sql .= " AND `quiz_id` IN ({$mlw_quiz})";
		}

		global $wpdb;
		$mlw_result_data = $wpdb->get_results("SELECT * FROM " . $wpdb->prefix . "mlw_results WHERE `deleted`='0' {$quiz_sql} {$mlw_order_sql} {$mlw_limit_sql}");
		if ( ! empty($mlw_result_data) ) {
			foreach ( $mlw_result_data as $key => $mlw_eaches ) {
				$time_taken = $time_taken_ms = 0;
				$mlw_qmn_results_array = maybe_unserialize($mlw_eaches->quiz_results);
				$mlw_complete_time = $mlw_complete_time_ms = '';
				if ( is_array($mlw_qmn_results_array) ) {
					$time_taken = $mlw_qmn_results_array[0];
					$hrs = $mins = $secs = $ms = "";
					$mlw_complete_hours = floor($time_taken / 3600);
					if ( $mlw_complete_hours > 0 ) {
						$hrs = "{$mlw_complete_hours} hr";
					}
					$mlw_complete_minutes = floor(($time_taken % 3600) / 60);
					if ( $mlw_complete_minutes > 0 ) {
						$mins = "{$mlw_complete_minutes} min";
					}
					$mlw_complete_seconds = $time_taken % 60;
					$secs = "{$mlw_complete_seconds} sec";

					$time_taken_ms = ($time_taken * 1000);
					if ( isset($mlw_qmn_results_array['timer_ms']) && $mlw_qmn_results_array['timer_ms'] > 0 ) {
						$time_taken_ms = $mlw_qmn_results_array['timer_ms'];
						$mlw_complete_ms = floor($time_taken_ms % 1000);
						if ( $mlw_complete_ms > 0 ) {
							$mlw_complete_ms = str_pad($mlw_complete_ms, 3, "0", STR_PAD_LEFT);
							$ms = "$mlw_complete_ms ms";
						}
					}
				}
				$mlw_result_data[ $key ]->total_time_taken = $time_taken;
				$mlw_result_data[ $key ]->total_time_taken_ms = $time_taken_ms;
				$mlw_result_data[ $key ]->total_time_taken_text = "{$hrs} {$mins} {$secs}";
				$mlw_result_data[ $key ]->total_time_taken_ms_text = "{$hrs} {$mins} {$secs} {$ms}";
			}

			switch ( $order ) {
				case 'point_score':
					array_multisort(array_column($mlw_result_data, 'point_score'), SORT_DESC, array_column($mlw_result_data, 'total_time_taken_ms'), SORT_ASC, $mlw_result_data);
					break;
				case 'point_score_asc':
					array_multisort(array_column($mlw_result_data, 'point_score'), SORT_ASC, array_column($mlw_result_data, 'total_time_taken_ms'), SORT_DESC, $mlw_result_data);
					break;
				default:
					array_multisort(array_column($mlw_result_data, 'correct_score'), SORT_DESC, array_column($mlw_result_data, 'total_time_taken_ms'), SORT_ASC, $mlw_result_data);
					break;
			}
			if ( 'average' == $atts['scoreby'] ) {
				$point_scores = array_column($mlw_result_data, 'point_score');
				$sum_point_score = array_sum($point_scores);
				$total_values = count($point_scores);
				$score_value = $total_values > 0 ? $sum_point_score / $total_values : 0;
				$score_value = number_format($score_value, 2);
			}
			elseif ( 'top' == $atts['scoreby'] || 'lowest' == $atts['scoreby'] ) {
				$mlw_result_data = array_slice($mlw_result_data, 0, 1);
				if ( $mlw_result_data ) {
					$score_value = $mlw_result_data[0]->point_score;
				}
			}
			$scoreby .= "<p>". $score_value ."</p>";
		} else {
			return '<p>'.__('No results available.', 'qsm-advanced-leaderboard').'</p>';
		}
	}

	return $scoreby;
}

function qsm_category_score_shortcode( $content, $mlw_quiz_array ) {
  $pattern = get_shortcode_regex([ 'qsm_category_score' ]);

  // Check for matches
  if ( preg_match_all('/' . $pattern . '/s', $content, $matches, PREG_SET_ORDER) ) {
      // Loop through each match
      foreach ( $matches as $shortcode ) {
          // Extract the attributes from the shortcode
          $attributes = shortcode_parse_atts($shortcode[3]);

          // Set default category value if not provided
          $attributes = shortcode_atts(array(
              'category' => '',
          ), $attributes);

          // Retrieve the category name from the attributes
          $category_filter = $attributes['category'];

          $categories = QSM_Questions::get_quiz_categories($mlw_quiz_array['quiz_id']);
          $categories_tree = isset($categories['tree']) ? $categories['tree'] : array();
          $questions = QSM_Questions::load_questions_by_pages( $mlw_quiz_array['quiz_id']);
          $cat_array = array();

          $cat_name = array();
          if ( $questions ) {
              $multiple_category_system = false;
              $enabled = get_option('qsm_multiple_category_enabled');
              if ( $enabled && 'cancelled' !== $enabled ) {
                  $multiple_category_system = true;
              }
              foreach ( $questions as $single_question ) {
                  if ( ! $multiple_category_system ) {
                      $cat_array[] = $single_question['category'];
                  }
              }
              $cat_array = array_unique($cat_array);
              if ( $cat_array || $categories_tree ) {
                  if ( $multiple_category_system ) {
                      foreach ( $categories_tree as $c_value ) {
                          $cat_name[] = $c_value->name;
                      }
                  } else {
                      foreach ( $cat_array as $single_cat ) {
                          $cat_name[] = $single_cat;
                      }
                  }
              }
          }

          $total_questions = 0;
          $return_points = 0;
          $correctness = [];
          $uniqueIds = array();
          $single_category_points = 0;
          foreach ( $cat_name as $category_name ) {
              foreach ( $mlw_quiz_array['question_answers_array'] as $answer ) {
                  if ( is_array($answer['multicategories']) ) {
                      foreach ( $answer['multicategories'] as $category_single ) {
                          $category_name_object = get_term_by('id', $category_single, 'qsm_category');
                          if ( $category_name_object->name == $category_name && '11' !== $answer['question_type'] ) {
                              if ( "" == $category_filter ) {
                                  if ( ! in_array($category_single, $uniqueIds) ) {
                                      $uniqueIds[] = $category_single;
                                      $correctness[ $category_name_object->name ] = $answer['points'];
                                  } else {
                                      $correctness[ $category_name_object->name ] += $answer['points'];
                                  }
                              } else {
                                  if ( $category_name_object->name == $category_filter ) {
                                      $single_category_points += $answer['points'];
                                  }
                              }
                          }
                      }
                  }
              }
          }

          // Display scores in an unordered list
          $return = '';
          if ( ! empty($correctness) && "" == $category_filter ) {
              $return .= '<ul>';
              foreach ( $correctness as $key => $score ) {
                  // Ensure output is properly escaped
                  $return .= '<li>' . esc_html($key) . ': ' . esc_html($score) . '</li>';
              }
              $return .= '</ul>';
          } elseif ( "" != $category_filter ) {
              $return .= esc_html($single_category_points);
          }

          // Replace the current shortcode instance with the generated output
          $content = str_replace($shortcode[0], $return, $content);
      }
  }

  return $content;
}
function qsm_conditions_shortcode( $content, $mlw_quiz_array ) {
  // Define a pattern to find all instances of [qsm_conditions ...] shortcodes in the content
  $pattern = get_shortcode_regex([ 'qsm_conditions' ]);

  // Check for matches
  if ( preg_match_all('/' . $pattern . '/s', $content, $matches, PREG_SET_ORDER) ) {
      // Loop through each match
      foreach ( $matches as $shortcode ) {
          // Extract the attributes from the shortcode
          $attributes = shortcode_parse_atts($shortcode[3]);

          // Set default values for attributes if not provided
          $attributes = shortcode_atts(array(
              'type'               => 'points',
              'condition'          => 'equal',
              'value'              => '',
              'category_condition' => 'AND',
              'category'           => '',
              'ismultiple'         => 'true',
          ), $attributes);

          // Retrieve the attribute values
          $type      = $attributes['type'];
          $condition  = $attributes['condition'];
          $value     = $attributes['value'];
          $category_condition = $attributes['category_condition'];
          $category  = $attributes['category'];
          $ismultiple  = $attributes['ismultiple'];

          // Initialize total points variable
          $total_points_or_score = 0;
          $condition_met = false;
          if ( empty($category) ) {
            // Calculate total quiz points or score
            if ( 'points' == $type || 1 == $mlw_quiz_array['quiz_system'] ) {
                $total_points_or_score += $mlw_quiz_array['total_points'];
            } elseif ( 'score' == $type ) {
                $total_points_or_score += $mlw_quiz_array['total_score'];
            }
          } else {
            if ( "true" == $ismultiple ) {
              $total_points_or_score = calculate_category_points_or_score($mlw_quiz_array, $category, $category_condition, $type, $ismultiple);
            }else {
              // Calculate total category points or score based on the category and condition
              $shortcode_categories = explode(',', $category);
              $category_string = "";
              $loop_count = 0;
              $category_count = 0;
              if ( ! empty($shortcode_categories) ) {
                $category_conditions = [];
                foreach ( $shortcode_categories as $category_value ) {
                    list($cat_name, $range) = explode(':', trim($category_value));
                    $category_conditions[] = [
						'category' => $cat_name,
						'range'    => "" != $range ? $range : 0,
                    ];
                    $category_string .= $cat_name.',';
                }
                $category_points = calculate_category_points_or_score($mlw_quiz_array, $category_string, $category_condition, $type, $ismultiple);
                $category_count = count($category_conditions);

                foreach ( $category_conditions as $single_category ) {
                  $total_points_or_score = 0;
                  if ( isset($category_points[ $single_category['category'] ]['points']) ) {
                    $total_points_or_score = $category_points[ $single_category['category'] ]['points'];
                  }
                  if ( 'score' == $type ) {
                    if ( isset($category_points[ $single_category['category'] ]['amount_correct']) ) {
                      $amount_correct = $category_points[ $single_category['category'] ]['amount_correct'];
                      $total_questions = $category_points[ $single_category['category'] ]['total_questions'];
                      if ( qsm_is_allow_score_roundoff() ) {
                        $total_points_or_score = round( ( ( $amount_correct / $total_questions ) * 100 ) );
                      } else {
                        $total_points_or_score = round( ( ( $amount_correct / $total_questions ) * 100 ), 2 );
                      }
                    }
                  }
                  switch ( $condition ) {
                    case 'equal':
                      if ( $total_points_or_score == (int)$single_category['range'] ) {
                        $loop_count++;
                      }
                        break;
                    case 'greater':
                      if ( $total_points_or_score > (int)$single_category['range'] ) {
                        $loop_count++;
                      }
                        break;
                    case 'lessthan':
                      if ( $total_points_or_score < (int)$single_category['range'] ) {
                        $loop_count++;
                      }
                        break;
                    case 'between':
                      list($min, $max) = explode('-', $single_category['range']);
                      if ( $total_points_or_score >= (int)$min && $total_points_or_score <= (int)$max ) {
                        $loop_count++;
                      }
                        break;
                  }
                }
              }

              if ( $category_condition == 'AND' && $category_count == $loop_count ) {// AND Case
                $condition_met = true;
              } else { // OR Case
                if ( 0 < $loop_count && $category_condition == 'OR' ) {
                  $condition_met = true;
                }
              }
            }
          }

          if ( empty($category) || ( ! empty($category) && "true" == $ismultiple) ) {
            // Evaluate conditions
            switch ( $condition ) {
              case 'equal':
                if ( $total_points_or_score == (int)$value ) {
                    $condition_met = true;
                }
                  break;
              case 'greater':
                if ( $total_points_or_score > (int)$value ) {
                    $condition_met = true;
                }
                  break;
              case 'lessthan':
                if ( $total_points_or_score < (int)$value ) {
                    $condition_met = true;
                }
                  break;
              case 'between':
                list($min, $max) = explode('-', $value);
                if ( $total_points_or_score >= (int)$min && $total_points_or_score <= (int)$max ) {
                    $condition_met = true;
                }
                  break;
            }
          }

          // Get the content between the shortcode tags
          $inner_content = $shortcode[5];
          // Return the content if the condition is met, otherwise return an empty string
          $return = '';
          if ( $condition_met ) {
              $return = do_shortcode($inner_content); // Ensure nested shortcodes are processed
          }
          // Replace the current shortcode instance with the generated output
          $content = str_replace($shortcode[0], $return, $content);
      }
  }

  return $content;
}
// Function to calculate category points or score based on the quiz array and categories
function calculate_category_points_or_score( $mlw_quiz_array, $category, $category_condition, $type, $ismultiple ) {
  $quiz_categories = QSM_Questions::get_quiz_categories($mlw_quiz_array['quiz_id']);
  $categories_tree = isset($quiz_categories['tree']) ? $quiz_categories['tree'] : array();
  $questions = QSM_Questions::load_questions_by_pages($mlw_quiz_array['quiz_id']);
  $cat_array = array();

  $cat_name = array();
  if ( $questions ) {
      $multiple_category_system = false;
      $enabled = get_option('qsm_multiple_category_enabled');
      if ( $enabled && 'cancelled' !== $enabled ) {
          $multiple_category_system = true;
      }
      foreach ( $questions as $single_question ) {
          if ( ! $multiple_category_system ) {
              $cat_array[] = $single_question['category'];
          }
      }
      $cat_array = array_unique($cat_array);
      if ( $cat_array || $categories_tree ) {
          if ( $multiple_category_system ) {
              foreach ( $categories_tree as $c_value ) {
                  $cat_name[] = $c_value->name;
              }
          } else {
              foreach ( $cat_array as $single_cat ) {
                  $cat_name[] = $single_cat;
              }
          }
      }
  }

  $shortcode_categories = explode(',', $category);
  $category_points = array();
  if ( ! empty($cat_name) ) {
    foreach ( $cat_name as $key => $value ) {
      if ( ! empty($shortcode_categories) && in_array($value, $shortcode_categories) ) {
        $category_points[ $value ]['points'] = 0;
      }
    }
  }
  $cat_counts_array = [];
  if ( ! empty($mlw_quiz_array['question_answers_array']) ) {
      foreach ( $mlw_quiz_array['question_answers_array'] as $answer ) {
          if ( ! empty($answer['multicategories']) ) {
              foreach ( $answer['multicategories'] as $cat_id ) {
                  $category_name_object = get_term_by('id', $cat_id, 'qsm_category');
                  if ( ! isset($category_points[ $category_name_object->name ]['total_questions']) ) {
                    $category_points[ $category_name_object->name ]['total_questions'] = 0;
                  }
                  if ( ! isset($category_points[ $category_name_object->name ]['amount_correct']) ) {
                    $category_points[ $category_name_object->name ]['amount_correct'] = 0;
                  }
                  if ( ! isset($category_points[ $category_name_object->name ]['points']) ) {
                    $category_points[ $category_name_object->name ]['points'] = 0;
                  }
                  if ( in_array($category_name_object->name, $shortcode_categories) && '11' !== $answer['question_type'] ) {
                      $category_points[ $category_name_object->name ]['points'] += $answer['points'];
                      if ( 'correct' == $answer['correct'] ) {
                        $category_points[ $category_name_object->name ]['amount_correct'] += 1;
                      }
                  }
                  $category_points[ $category_name_object->name ]['total_questions'] += 1;
              }
          }
      }
  }
	$total_points_or_score     = 0;
  $previous_value = 0;
  $category_scores  = array();
  if ( "true" == $ismultiple ) {
    if ( ! empty($category_points) ) {
      if ( 'points' == $type || 1 == $mlw_quiz_array['quiz_system'] ) {
        if ( $category_condition == 'AND' ) {// AND Case
          foreach ( $category_points as $key => $value ) {
            $total_points_or_score     += $value['points'];
          }
        } else { // OR Case
          foreach ( $category_points as $key => $value ) {
            if ( 0 == $previous_value || $previous_value <= $value['points'] ) {
              $total_points_or_score = $value['points'];
            }
            $previous_value = $value['points'];
          }
        }
      }elseif ( 'score' == $type ) {
        if ( $category_condition == 'AND' ) {// AND Case
          $total_questions = 0;
          $amount_correct = 0;
          foreach ( $category_points as $key => $value ) {
            $total_questions += $value['total_questions'];
            $amount_correct += $value['amount_correct'];
          }
          if ( 0 != $total_questions ) {
            if ( qsm_is_allow_score_roundoff() ) {
              $total_points_or_score = round( ( ( $amount_correct / $total_questions ) * 100 ) );
            } else {
              $total_points_or_score = round( ( ( $amount_correct / $total_questions ) * 100 ), 2 );
            }
          } else {
            $total_points_or_score = 0;
          }
        } else { // OR Case
          $total_questions = 0;
          $amount_correct = 0;
          $calculated = 0;
          foreach ( $category_points as $key => $value ) {
            if ( qsm_is_allow_score_roundoff() ) {
              $calculated = round( ( ( $value['amount_correct'] / $value['total_questions'] ) * 100 ) );
            } else {
              $calculated = round( ( ( $value['amount_correct'] / $value['total_questions'] ) * 100 ), 2 );
            }
            if ( 0 == $previous_value || $previous_value <= $calculated ) {
              $total_points_or_score = $calculated;
            }
            $previous_value = $calculated;
          }
        }
      }
    }
    return $total_points_or_score;
  } else {
    return $category_points;
  }
}

function qsm_calc_filter($content, $mlw_quiz_array) {
  global $mlwQuizMasterNext, $wpdb;

  // Define a pattern to find all instances of [qsm_calc]...[/qsm_calc] shortcodes
  $pattern = get_shortcode_regex(['qsm_calc']);

  // Check for matches
  if (preg_match_all('/' . $pattern . '/s', $content, $matches, PREG_SET_ORDER)) {
      foreach ($matches as $shortcode) {
          // The expression is the content between the tags (index 5 in matches)
          $expression = !empty($shortcode[5]) ? trim($shortcode[5]) : '';

          // Skip if no expression
          if (empty($expression)) {
              $content = str_replace($shortcode[0], '', $content);
              continue;
          }

          // Get quiz data from the filter parameter
          $question_answers = isset($mlw_quiz_array['question_answers_array']) ? $mlw_quiz_array['question_answers_array'] : array();

          // Pattern to find answer_XXXX placeholders in the expression (where XXXX is question ID)
          $pattern = '/answer_(\d+)/i';
          preg_match_all($pattern, $expression, $answer_matches);

          // Replace answer_XXXX with actual values
          if (!empty($answer_matches[1])) {
              foreach ($answer_matches[1] as $question_id) {
                  $key = array_search($question_id, array_column($question_answers, 'id'), true);
                  $value = 0; // Default value if no answer found

                  if ($key !== false && isset($question_answers[$key]['user_answer'])) {
                    $answer = $question_answers[$key]['user_answer'];
                    $value = 0; // Default value

                    // Handle different answer types
                    if (is_array($answer) && !empty($answer)) {
                        // Sum numeric values in the array
                        $numeric_values = array_filter($answer, 'is_numeric');
                        if (!empty($numeric_values)) {
                            $value = floatval(array_sum($numeric_values));
                        }
                    } elseif (is_numeric($answer)) {
                        // Single numeric answer
                        $value = floatval($answer);
                    } elseif (is_string($answer) && !empty($answer)) {
                        // Attempt to extract a number from a string (e.g., "5 points" -> 5)
                        preg_match('/-?\d*\.?\d+/', $answer, $matches);
                        if (!empty($matches)) {
                            $value = floatval($matches[0]);
                        }
                    }
                }

                  // Replace answer_XXXX with its numeric value
                  $expression = str_replace("answer_$question_id", $value, $expression);
              }
          }

          // Sanitize the expression to allow only basic math operations
          $allowed_chars = '/[^0-9+\-*\/(). ]/';
          $expression = preg_replace($allowed_chars, '', $expression);

          // Evaluate the expression safely
          $result = 'Error: Invalid calculation';
          try {
              $eval_result = null;
              $eval_string = "\$eval_result = $expression;";

              // Check for division by zero
              if (strpos($expression, '/0') !== false) {
                  $result = 'Error: Division by zero';
              } else {
                  @eval($eval_string); // @ to suppress warnings
                  if ($eval_result !== null && $eval_result !== false) {
                      $result = is_float($eval_result) ? number_format($eval_result, 2) : strval($eval_result);
                  }
              }
          } catch (Exception $e) {
              $result = 'Error: Calculation failed';
          }

          // Replace the entire shortcode with the result
          $content = str_replace($shortcode[0], $result, $content);
      }
  }

  return $content;
}

// Add the filter hook