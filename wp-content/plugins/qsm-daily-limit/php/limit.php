<?php
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Limit checking function to be called from beginning of quiz shortcode
 *
 * @uses qsm_addon_daily_limit_core_function
 * @since 1.1.0
 * @return string The HTML to be displayed in the quiz shortcode
 */
function qsm_addon_daily_limit_begin_shortcode(  $display, $options, $quiz_data ) {
  // Returns HTML from the core function
  return qsm_addon_daily_limit_core_function( $display, $options, $quiz_data );
}

/**
 * Limit checking function to be called from results page
 *
 * @uses qsm_addon_daily_limit_core_function
 * @since 1.1.0
 * @return array The array to be sent back via AJAX
 */
function qsm_addon_daily_limit_begin_results( $display, $options, $quiz_data ) {

  // Checks limit and retrieves modified HTML
  $display = qsm_addon_daily_limit_core_function( $display, $options, $quiz_data );

  // Checks if the limit function changed the visit variable. If still true, return original HTML. If is false, return array to be sent back via AJAX
  global $qmn_allowed_visit;
  if ( $qmn_allowed_visit ) {
    return $display;
  }
  return array(
	  'display'       => $display,
	  'redirect'      => false,
	  'redirect_url'  => '',
	  'result_status' => array(
		  'save_response' => 0,
		  'id'            => 0,
	  ),
  );
}

/**
 * Checks if the limit has been reached
 * @since 1.1.0
 * @return string The modified HTML
 */
function qsm_addon_daily_limit_core_function( $display, $options, $quiz_data ) {

  global $mlwQuizMasterNext;

  // Load the settings
  $daily_limit_data = $mlwQuizMasterNext->pluginHelper->get_quiz_setting( "daily_limit_settings" );
  $daily_limit_defaults = array(
	  'enabled'          => 'no',
	  'amount'           => 0,
	  'text'             => '',
	  'email_type'       => '',
	  'daily_limit_type' => 1,
	  'recurring_period' => 2,
	  'recurring_limit'  => 0,
  );
  $daily_limit_data = wp_parse_args( $daily_limit_data, $daily_limit_defaults );
  
  // Checks if daily limit is enabled for this quiz/survey
  if ( 'yes' == $daily_limit_data["enabled"] ) {

    global $qmn_allowed_visit;
    global $wpdb;
    $email = isset( $_POST["mlwUserEmail"] ) ? $_POST["mlwUserEmail"] : '';
    if ( $email == '' && isset($daily_limit_data['email_type']) && $daily_limit_data['email_type'] != '' ) {
        $email = isset( $_POST[ $daily_limit_data['email_type'] ] ) ? $_POST[ $daily_limit_data['email_type'] ] : '';
    }
    $user_id = 0;

    // Checks if user is logged in and, if so, sets user_id and email
    if ( is_user_logged_in() ) {
      $user = wp_get_current_user();
      if ( isset( $user->ID) && 0 !== $user->ID ) {
        $user_id = intval( $user->ID );
        $email = $user->user_email;
      }
    }

    // If no email or user ID is available, return original text
    if ( empty( $email ) && 0 === $user_id ) {
      return $display;
    }

    // Counts amount of results by the user based on user ID or email
    $count = 0;
    if ( 0 !== $user_id ) {
      $count = $wpdb->get_var( $wpdb->prepare( "SELECT COUNT(*) FROM {$wpdb->prefix}mlw_results WHERE (user=%d OR email='%s') AND deleted='0' AND quiz_id=%d AND (time_taken_real BETWEEN '" . date("Y-m-d") . " 00:00:00' AND '" . date("Y-m-d") . " 23:59:59')", $user_id, $email, $quiz_data["quiz_id"] ) );
    } else {
      $count = $wpdb->get_var( $wpdb->prepare( "SELECT COUNT(*) FROM {$wpdb->prefix}mlw_results WHERE email='%s' AND deleted='0' AND quiz_id=%d AND (time_taken_real BETWEEN '". date("Y-m-d") ." 00:00:00' AND '". date("Y-m-d") ." 23:59:59')", $email, $quiz_data["quiz_id"] ) );
    }

    $recurring_count = 0;
    if ( 2 == intval( $daily_limit_data['daily_limit_type'] ) ) {
      $currentDate = new DateTime();

      // Number of days before the current date
      $period = intval($daily_limit_data['recurring_period']) - 1;

      // Subtract the number of days from the current date
      $interval = new DateInterval("P{$period}D");
      $currentDate->sub($interval);

      // Format the date as "Y-m-d"
      $prev_date = $currentDate->format('Y-m-d');

      if ( 0 !== $user_id ) {
        $recurring_count = $wpdb->get_var( $wpdb->prepare( "SELECT COUNT(*) FROM {$wpdb->prefix}mlw_results WHERE (user=%d OR email='%s') AND deleted='0' AND quiz_id=%d AND (time_taken_real BETWEEN '" . $prev_date . " 00:00:00' AND '" . date("Y-m-d") . " 23:59:59')", $user_id, $email, $quiz_data["quiz_id"] ) );
      } else {
        $recurring_count = $wpdb->get_var( $wpdb->prepare( "SELECT COUNT(*) FROM {$wpdb->prefix}mlw_results WHERE email='%s' AND deleted='0' AND quiz_id=%d AND (time_taken_real BETWEEN '". $prev_date ." 00:00:00' AND '". date("Y-m-d") ." 23:59:59')", $email, $quiz_data["quiz_id"] ) );
      }
    }

    $isDailyLimitAvailable = $count >= $daily_limit_data["amount"];
    $isRecurringLimitAvailable = $recurring_count >= $daily_limit_data["recurring_limit"];
    $limit_type = intval( $daily_limit_data['daily_limit_type'] );

    if ( 2 == $limit_type && 0 < $daily_limit_data["amount"]) {
      $isRecurringLimitAvailable = $isDailyLimitAvailable || $isRecurringLimitAvailable;
    }

    // If amount of results is more than the daily limit, return daily limit text
    if ( ( 1 == $limit_type && $isDailyLimitAvailable ) || ( 2 == $limit_type && $isRecurringLimitAvailable ) ) {
      $qmn_allowed_visit = false;
      return htmlspecialchars_decode( $daily_limit_data["text"], ENT_QUOTES );
    }
  }

  // If everything else is fine, return the original text
  return $display;
}

