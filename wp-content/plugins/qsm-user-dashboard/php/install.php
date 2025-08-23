<?php
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Creates the user dashboard settings
 *
 * @since 1.1.1
 */
function qsm_user_dashboard_activate() {
	$options = array(
		'quiz_name_check'      => 1,
		'quiz_name_text'       => "Quiz Name",
		'quiz_time_check'      => 1,
		'quiz_time_text'       => "Time Taken",
		'results_template'     => '<h1>Quiz Results</h1>
	You scored %CORRECT_SCORE%!

	Out of %TOTAL_QUESTIONS%, you got %AMOUNT_CORRECT% correct. Here are your answers:

	%QUESTIONS_ANSWERS%',
		'next_button_text'     => 'Next 10 Results',
		'previous_button_text' => 'Previous 10 Results',
		'view_text'            => 'View',
		'not_user_text'        => 'You must be logged in to see your results.',
	);
	if ( ! get_option( 'mlw_qmn_dashboard_option' ) ) {
		add_option( 'mlw_qmn_dashboard_option' , $options );
	}
}

