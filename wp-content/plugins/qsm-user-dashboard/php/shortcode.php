<?php

/**
 * Creates the shortcode that outputs the table and results
 *
 * @since 1.1.0
 */
function qsm_user_dashboard_shortcode( $atts ) {
	ob_start();

	$quiz_id = isset($atts['quiz_id']) ? $atts['quiz_id'] : 0;

	// If the user isn't logged in
	if ( ! is_user_logged_in() ) {

		// Return the text from the settings
		$options = get_option( 'mlw_qmn_dashboard_option' );
		return $options['not_user_text'];
	}
	wp_enqueue_script( 'jquery' );
	wp_enqueue_style( 'qmn_quiz_common_style', QSM_PLUGIN_URL . '/css/common.css' );
	wp_enqueue_style( 'user_dashboard_table_style', QSM_USER_DASHBOARD_URL . '/qsm-user-dashboard-style.css', array('dashicons'), QSM_USER_DASHBOARD_VERSION );
	$customStyle = ".question-type-polar-s .ui-widget-content { position: relative;}";
	wp_add_inline_style( 'qmn_quiz_common_style', $customStyle );
	
	wp_register_script( 'qsm-user-dashboard', '', array( 'jquery-ui-slider' ), '', true );
	wp_enqueue_script( 'qsm-user-dashboard' );
	?>
	<script type="text/javascript" async src="//cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.2/MathJax.js?config=TeX-MML-AM_CHTML"></script>

	<script>
		MathJax = {
		showProcessingMessages: false,
		tex2jax: { inlineMath: [['$','$'],['\\(','\\)']] }
		};
	</script>

<?php
	global $wpdb, $qmn_total_questions;
	// Gets total results
	$current_user  = wp_get_current_user();
	$table_limit   = 10;
	// Prepare the base SQL query to count results
	$count_sql = 'SELECT COUNT(result_id) 
				FROM ' . $wpdb->prefix . "mlw_results 
				WHERE deleted='0' 
				AND (user=%d OR email='%s')";

	// Add the quiz filter if $quiz_id is provided
	if (!empty($quiz_id)) {
		$count_sql .= 'AND quiz_id IN ('.esc_sql($quiz_id).')';
	}

	$current_user = wp_get_current_user();

	$results_count = $wpdb->get_var($wpdb->prepare($count_sql, get_current_user_id(), $current_user->user_email));

	// Determine the pagination
	$result_page = isset($_GET['result_page']) ? $_GET['result_page'] + 1 : 0;
	$result_begin = $result_page * $table_limit;

	// Calculate the remaining results
	$results_remaining = $results_count - $result_begin;

	// Prepare the base SQL query to retrieve user results with quiz settings
	$result_sql = 'SELECT results.*, quiz.quiz_settings 
	FROM ' . $wpdb->prefix . 'mlw_results AS results 
	INNER JOIN ' . $wpdb->prefix . "mlw_quizzes quiz 
	ON results.quiz_id = quiz.quiz_id 
	WHERE results.deleted='0' 
	AND (results.user=%d OR results.email='%s')";

	// Add the quiz filter if $quiz_id is provided
	if (!empty($quiz_id)) {
		$result_sql .= ' AND results.quiz_id IN ('.esc_sql($quiz_id).')';
	}

	$result_sql .= ' ORDER BY results.result_id DESC LIMIT %d, %d';

	$current_user = wp_get_current_user();

	$user_results = $wpdb->get_results(
		$wpdb->prepare($result_sql, get_current_user_id(), $current_user->user_email, $result_begin, $table_limit)
	);

	$display      = '';
	$options      = get_option( 'mlw_qmn_dashboard_option' );
	$results_json = array();
	// Cycles through the results
	foreach ( $user_results as $result ) {

		// Prepares the template for the results
		$template = $options['results_template'];

		// For backwards compatibility
		$template = str_replace( '%QUESTIONS_RESULTS%', '%QUESTIONS_ANSWERS%', $template );

		if ( is_serialized( $result->quiz_results ) && is_array( @unserialize( $result->quiz_results ) ) ) {
			$results = unserialize( $result->quiz_results );
		} else {
			$template = str_replace( '%QUESTIONS_ANSWERS%', $result->quiz_results, $template );
			$template = str_replace( '%TIMER%', '', $template );
			$template = str_replace( '%COMMENT_SECTION%', '', $template );
			$results  = array(
				0,
				array(),
				'',
			);
		}
		// Creates the array for the template variables
		$qmn_array_for_variables = array(
			'result_id'                 => $result->result_id,
			'quiz_id'                   => $result->quiz_id,
			'quiz_name'                 => $result->quiz_name,
			'quiz_system'               => $result->quiz_system,
			'user_name'                 => $result->name,
			'user_business'             => $result->business,
			'user_email'                => $result->email,
			'user_phone'                => $result->phone,
			'user_id'                   => $result->user,
			'timer'                     => $results[0],
			'time_taken'                => $result->time_taken,
			'total_points'              => $result->point_score,
			'total_score'               => $result->correct_score,
			'total_correct'             => $result->correct,
			'total_questions'           => $result->total,
			'comments'                  => $results[2],
			'question_answers_array'    => $results[1],
			'form_type'                 => isset( $result->form_type ) ? $result->form_type : 0,
			'quiz_settings'             => isset( $result->quiz_settings ) ? @unserialize( $result->quiz_settings ) : array(),
			'total_possible_points'     => isset( $results['total_possible_points'] ) ? $results['total_possible_points'] : '',
			'total_attempted_questions' => isset( $results['total_attempted_questions'] ) ? $results['total_attempted_questions'] : '',
		);
		$qmn_total_questions = 0;
		$template                = apply_filters( 'mlw_qmn_template_variable_results_page', $template, $qmn_array_for_variables );
		$template                = str_replace( "\n", '<br>', $template );
		$template                = do_shortcode( $template, true );
		// Creates JS object with all the results
		$results_json[ $result->result_id ] = $template;
	}
	$quiz_back_button_text                          = isset( $options['quiz_back_button_text'] ) ? $options['quiz_back_button_text'] : __( 'Go Back', 'qsm-user-dashboard' );
	$options['quiz_time_to_complete_check']         = isset( $options['quiz_time_to_complete_check'] ) ? $options['quiz_time_to_complete_check'] : 0;
	$options['quiz_time_to_complete_text']          = isset( $options['quiz_time_to_complete_text'] ) ? $options['quiz_time_to_complete_text'] : __( 'Time to Complete', 'qsm-user-dashboard' );
	$options['quiz_certificate_link_text']          = isset( $options['quiz_certificate_link_text'] ) ? $options['quiz_certificate_link_text'] : __( 'Certificate Link', 'qsm-user-dashboard' );
	$options['quiz_certificate_link_check']         = isset( $options['quiz_certificate_link_check'] ) ? $options['quiz_certificate_link_check'] : 0;
	$options['quiz_certificate_link_header_text']   = isset( $options['quiz_certificate_link_header_text'] ) ? $options['quiz_certificate_link_header_text'] : __( 'View Certificate', 'qsm-user-dashboard' );
	$options['quiz_time_text_date_format']          = isset( $options['quiz_time_text_date_format'] ) ? $options['quiz_time_text_date_format'] : 0;
	$options['quiz_time_text_time_format']          = isset( $options['quiz_time_text_time_format'] ) ? $options['quiz_time_text_time_format'] : 0;
	$options['quiz_time_text_custom_date_format']   = isset( $options['quiz_time_text_custom_date_format'] ) ? $options['quiz_time_text_custom_date_format'] : '';
	$options['quiz_time_text_custom_time_format']   = isset( $options['quiz_time_text_custom_time_format'] ) ? $options['quiz_time_text_custom_time_format'] : '';
	$options['quiz_time_to_complete_time_format']   = isset( $options['quiz_time_to_complete_time_format'] ) ? $options['quiz_time_to_complete_time_format'] : '';
	$options['quiz_certificate_custom_css']         = isset( $options['quiz_certificate_custom_css'] ) ? $options['quiz_certificate_custom_css'] : '';
	$options['view_text_custom_css']                = isset( $options['view_text_custom_css'] ) ? $options['view_text_custom_css'] : '';
	$options['view_header_text']                    = isset( $options['view_header_text'] ) ? $options['view_header_text'] : __( 'View Results', 'qsm-user-dashboard' );
	$options['view_text_check']                     = isset( $options['view_text_check'] ) ? $options['view_text_check'] : 1;
	$options['quiz_correct_answer_text']            = isset( $options['quiz_correct_answer_text'] ) ? $options['quiz_correct_answer_text'] : __("Correct Answer", "qsm-user-dashboard");
	$options['quiz_correct_answer_check']           = isset( $options['quiz_correct_answer_check'] ) ? $options['quiz_correct_answer_check'] : 0;
	$options['quiz_correct_answer_text_format']     = isset( $options['quiz_correct_answer_text_format'] ) ? $options['quiz_correct_answer_text_format'] : '%AMOUNT_CORRECT% out of %TOTAL_QUESTIONS%';
	$options['quiz_total_points_text']              = isset( $options['quiz_total_points_text'] ) ? $options['quiz_total_points_text'] : __("Total Quiz Points", "qsm-user-dashboard");
	$options['quiz_total_points_check']             = isset( $options['quiz_total_points_check'] ) ? $options['quiz_total_points_check'] : '';
	$options['quiz_total_points_text_format']       = isset( $options['quiz_total_points_text_format'] ) ? $options['quiz_total_points_text_format'] : '%POINT_SCORE% out of %MAXIMUM_POINTS%';
	$options['quiz_score_percent_text']             = isset( $options['quiz_score_percent_text'] ) ? $options['quiz_score_percent_text'] : __("Quiz Score Percent", "qsm-user-dashboard");
	$options['quiz_score_percent_check']            = isset( $options['quiz_score_percent_check'] ) ? $options['quiz_score_percent_check'] : 0;
	$options['quiz_score_percent_text_format']      = isset( $options['quiz_score_percent_text_format'] ) ? $options['quiz_score_percent_text_format'] : '';
	$options['dashboard_options_order']             = isset( $options['dashboard_options_order'] ) ? $options['dashboard_options_order'] : [ 'view_text', 'quiz_name', 'quiz_score', 'quiz_time', 'quiz_time_to_complete', 'quiz_certificate_link', 'quiz_correct_answer', 'quiz_total_points', 'quiz_score_percent' ];
$data = "
	function show_results(id) {
		jQuery('.qsm_results_table').hide();
		jQuery('.qsm_results').empty();
		jQuery('.qsm_results').html(
			'<button class=\"button\" onclick=\"qsm_show_results_table();\">". $quiz_back_button_text ."</button>' +
			qsm_results[id]);
		jQuery('.qsm_results').show();
		jQuery(document).trigger('qsm_init_after_result_show', [id,qsm_results]);
		MathJax.Hub.Queue([\"Typeset\", MathJax.Hub, jQuery('#qsm_ud_results').html()]);
		jQuery('.question-type-polar-s').each(function(){
			let question = jQuery(this).find('.slider-main-wrapper div');
			let minVal = question.data('answer1'); 
			let maxVal = question.data('answer2'); 
			let userVal = question.data('answer_value');
			question.slider({
				min: minVal,
				max: maxVal,
				value: userVal,
				disabled: true, // Set the slider to be disabled
				create: function (event, ui){
					// jQuery(document).trigger('qsm_after_display_result',[ this, ui ]);
					jQuery(this).find('span').css({'display':'flex','align-items':'center','justify-content':'center','text-decoration':'none','color':'white','height':'20px','background':'#a5a5a5','position':'absolute','margin-top':'6px'});
					jQuery(this).find('span').html('<p style=\"margin:0;height:25px;background: #6a6a7c;padding:5px;font-weight:bold;\">'+userVal+'</p>');					
				}
			});
		});		
	}	
	function qsm_show_results_table() {
		jQuery('.qsm_results').hide();
		jQuery('.qsm_results_table').show();
	}var qsm_results =". wp_json_encode( $results_json );
wp_add_inline_script( 'qsm-user-dashboard', $data, 'after' );
?>
<div class="qsm_results" id="qsm_ud_results" style="display: none;"></div>
<div class="qsm_results_table">
	<?php
	if ( is_admin() ) {
		$admin_page = 'page=qsm_user_dashboard_admin_menu&&';
	} else {
		$admin_page = '';
	}
	if ( $theme_template = locate_template( '/qsm-templates/user-dashboard.php' ) ) {
		include $theme_template;
	} else {
		include QSM_USER_DASHBOARD_TEMPLATE_DIR . '/user-dashboard.php';
	}
	?>
</div>
<?php
	return ob_get_clean();
}

/**
 * [user_total_points]
 * Display total quiz points earned by user
 * @since 2.1.1
 */
function qsm_user_total_points_shortcode( $atts ) {
	global $wpdb;
	$current_user  = wp_get_current_user();
	$total_points = $wpdb->get_var( $wpdb->prepare( 'SELECT SUM(point_score) FROM ' . $wpdb->prefix . "mlw_results WHERE deleted='0' AND (user=%d OR email='%s')", get_current_user_id(), $current_user->user_email ) );
	return $total_points;
}


function display_quiz_score( $result, $options ) {
	?>
	<td class="post-title column-title">
		<span style='font-size:16px;'>
			<?php
			if ( isset($result->form_type) && ( 1 === intval($result->form_type) || 2 === intval($result->form_type) ) ) {
				esc_html_e('Not Graded', 'qsm-user-dashboard');
			} else {
				if ( 0 === intval($result->quiz_system) ) {
					$score_display = $result->correct . __(" out of ", 'qsm-user-dashboard') . $result->total . __(" or ", 'qsm-user-dashboard') . $result->correct_score . "%";
				} elseif ( 1 === intval($result->quiz_system) ) {
					$score_display = $result->point_score . __(" Points", 'qsm-user-dashboard');
				} elseif ( 3 === intval($result->quiz_system) ) {
					$score_display = $result->correct . __(" out of ", 'qsm-user-dashboard') . $result->total . __(" or ", 'qsm-user-dashboard') . $result->correct_score . "%<br/>" . $result->point_score . __(" Points", 'qsm-user-dashboard') . "";
				}
				echo apply_filters('quiz_score_user_dashboard', $score_display, $result);
			}
			?>
		</span>
	</td>
	<?php
}

function display_quiz_correct_answer( $result, $options ) {
	?>
	<td class="post-title column-title">
		<span style='font-size:16px;'>
			<?php
			if ( isset($result->form_type) && ( 1 === intval($result->form_type) || 2 === intval($result->form_type) ) ) {
				esc_html_e('Not Graded', 'qsm-user-dashboard');
			} else {
				if ( false !== strpos( $options['quiz_correct_answer_text_format'], '%AMOUNT_CORRECT%' ) ) {
					$options['quiz_correct_answer_text_format'] = str_replace( '%AMOUNT_CORRECT%', $result->correct, $options['quiz_correct_answer_text_format'] );
				}
				if ( false !== strpos( $options['quiz_correct_answer_text_format'], '%TOTAL_QUESTIONS%' ) ) {
					$options['quiz_correct_answer_text_format'] = str_replace( '%TOTAL_QUESTIONS%', $result->total, $options['quiz_correct_answer_text_format'] );
				}
				echo esc_html( $options['quiz_correct_answer_text_format'] );
			}
			?>
		</span>
	</td>
	<?php
}

function display_quiz_total_points( $result, $options ) {
	$quiz_results = unserialize($result->quiz_results);
	$total_points = $quiz_results['total_possible_points'];
	?>
	<td class="post-title column-title">
		<span style='font-size:16px;'>
			<?php
			if ( isset($result->form_type) && ( 1 === intval($result->form_type) || 2 === intval($result->form_type) ) ) {
				esc_html_e('Not Graded', 'qsm-user-dashboard');
			} else {
				if ( false !== strpos( $options['quiz_total_points_text_format'], '%POINT_SCORE%' ) ) {
					$options['quiz_total_points_text_format'] = str_replace( '%POINT_SCORE%', $result->point_score, $options['quiz_total_points_text_format'] );
				}
				if ( false !== strpos( $options['quiz_total_points_text_format'], '%MAXIMUM_POINTS%' ) ) {
					$options['quiz_total_points_text_format'] = str_replace( '%MAXIMUM_POINTS%', $total_points, $options['quiz_total_points_text_format'] );
				}
				echo esc_html( $options['quiz_total_points_text_format'] );
			}
			?>
		</span>
	</td>
	<?php
}

function display_quiz_score_percent( $result, $options ) {
	?>
	<td class="post-title column-title">
		<span style='font-size:16px;'>
			<?php
			if ( isset($result->form_type) && ( 1 === intval($result->form_type) || 2 === intval($result->form_type) ) ) {
				esc_html_e('Not Graded', 'qsm-user-dashboard');
			} else {
				if ( isset($options['quiz_score_percent_text_format']) ) {
					echo round($result->correct_score, intval($options['quiz_score_percent_text_format'])) . "%";
				}
			}
			?>
		</span>
	</td>
	<?php
}

function display_view_text( $result, $options ) {
	?>
	<td>
		<span style='color:green;font-size:16px;'>
			<a href="javascript:show_results(<?php echo $result->result_id; ?>);">
				<?php echo esc_html( $options['view_text'] ); ?>
			</a>
		</span>
	</td>
	<?php
}

function display_quiz_name( $result, $options ) {
	?>
	<td>
		<span style='font-size:16px;'>
			<?php echo esc_html( $result->quiz_name ) ?>
		</span>
	</td>
	<?php
}

function display_quiz_time( $result, $options ) {
	$date_time_format = [
		'date' => [ 'F j, Y', 'Y-m-d', 'm/d/Y', 'd/m/Y' ],
		'time' => [ 'h:i a', 'h:i A', 'h:i:s a', 'h:i:s A' ],
	];
	$quiz_time_format = '';
	if ( 0 <= intval($options['quiz_time_text_date_format']) && 3 >= intval($options['quiz_time_text_date_format']) ) {
		$quiz_time_format .= $date_time_format['date'][ $options['quiz_time_text_date_format'] ] . ' ';
	} elseif ( 4 === intval($options['quiz_time_text_date_format']) ) {
		$quiz_time_format .= $date_time_format['date'][ $options['quiz_time_text_custom_date_format'] ] . ' ';
	}
	if ( 0 <= intval($options['quiz_time_text_time_format']) && 3 >= intval($options['quiz_time_text_time_format']) ) {
		$quiz_time_format .= $date_time_format['time'][ $options['quiz_time_text_time_format'] ];
	} elseif ( 4 === intval($options['quiz_time_text_time_format']) ) {
		$quiz_time_format .= $date_time_format['time'][ $options['quiz_time_text_custom_time_format'] ];
	}
	?>
	<td>
		<span style='font-size:16px;'>
			<?php echo apply_filters( 'quiz_time_user_dashboard', date( ! empty( $quiz_time_format ) ? $quiz_time_format : "m-d-Y h:i:s A", strtotime($result->time_taken) ), $result );?>
		</span>
	</td>
	<?php
}

function display_quiz_time_to_complete( $mlw_qmn_results_array, $result, $options ) {
	?>
	<td>
		<?php
		if ( is_array($mlw_qmn_results_array) && isset($mlw_qmn_results_array[0]) ) {
			$mlw_complete_hours = floor($mlw_qmn_results_array[0] / 3600);
			if ( $mlw_complete_hours > 0 && ( 0 === intval($options['quiz_time_to_complete_time_format']) || 1 === intval($options['quiz_time_to_complete_time_format']) ) ) {
				echo "<span class='qsm-ud-hour-span' style='font-size:16px;'>" . str_pad($mlw_complete_hours, 2, '0', STR_PAD_LEFT) . "</span>";
			} elseif ( $mlw_complete_hours <= 0 && ( 0 === intval($options['quiz_time_to_complete_time_format']) || 1 === intval($options['quiz_time_to_complete_time_format']) ) ) {
				echo "<span class='qsm-ud-hour-span' style='font-size:16px;'>" . '00' . "</span>";
			}
			$mlw_complete_minutes = floor(($mlw_qmn_results_array[0] % 3600) / 60);
			if ( $mlw_complete_minutes > 0 ) {
				if ( 2 === intval($options['quiz_time_to_complete_time_format']) ) {
					echo "<span class='qsm-ud-min-span' style='font-size:16px;'>" . str_pad($mlw_complete_minutes, 2, '0', STR_PAD_LEFT) . "</span>";
				} else {
					echo "<span class='qsm-ud-min-span' style='font-size:16px;'>" . ':'.str_pad($mlw_complete_minutes, 2, '0', STR_PAD_LEFT) . "</span>";
				}
			} else {
				if ( 2 === intval($options['quiz_time_to_complete_time_format']) ) {
					echo "<span class='qsm-ud-min-span' style='font-size:16px;'>" . '00' . "</span>";
				} else {
					echo "<span class='qsm-ud-min-span' style='font-size:16px;'>" . ':00' . "</span>";
				}
			}
			$mlw_complete_seconds = $mlw_qmn_results_array[0] % 60;
			if ( 0 === intval($options['quiz_time_to_complete_time_format']) || 2 === intval($options['quiz_time_to_complete_time_format']) ) {
				echo "<span class='qsm-ud-second-span' style='font-size:16px;'>" . ':'.str_pad($mlw_complete_seconds, 2, '0', STR_PAD_LEFT) . "</span>";
			}
		} else {
			echo "-";
		}
		?>
	</td>
	<?php
}

function display_quiz_certificate_link( $upload_dir, $mlw_qmn_results_array, $result, $options ) {
	?>
	<td>
		<?php
		if ( class_exists( 'QSM_Certificate' ) ) {
			$encoded_time_taken = md5($result->time_taken);
			$certifacate_name = "{$result->quiz_id}-{$mlw_qmn_results_array[0]}-{$encoded_time_taken}-{$result->point_score}-{$result->correct_score}";
			$certificates = scandir($upload_dir['basedir'] . "/qsm-certificates/");
			array_shift($certificates);
			array_shift($certificates);
			foreach ( $certificates as $certificate ) {
				$certi_exists = strpos($certificate, $certifacate_name);
				if ( 0 === $certi_exists ) {
					$certifacate_name = $certificate;
					break;
				}
			}
			if ( $certifacate_name && file_exists($upload_dir['basedir'] . "/qsm-certificates/" . $certifacate_name) ) {
				$certificate_url = $upload_dir['baseurl'] . "/qsm-certificates/$certifacate_name";
				echo "<a target='_blank' href='".esc_url($certificate_url)."' class='qmn_certificate_link'>" . esc_html( $options["quiz_certificate_link_text"] ) . "</a>";
			} else {
				echo esc_html_e('Certificate Unavailable', 'qsm-user-dashboard');
			}
		} else {
			echo esc_html_e('Enable QSM Certificate Addon', 'qsm-user-dashboard');
		}       
		?>
	</td>
	<?php
}
?>