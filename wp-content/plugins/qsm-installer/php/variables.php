<?php
/**
 * This file stores all template variables for the addon
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Generates your template variable
 *
 * @since 1.0.0
 * @param string $content The string from various templates including email and results pages.
 * @param array  $quiz_array An array of the results from the quiz/survey that was completed.
 * @return string The string to be used in email, results page, social sharing, etc..
 * @todo Replace your variable with any content
 */
function qsm_addon_installer_my_variable( $content, $quiz_array ) {
	/**
	 * Manipulate the content here
	 * Remember to remove your shortcode from the content using something like:
	 * $content = str_replace( "%My_VARIABLE%" , $my_content, $content);
	 */

	// Returns the content.
	return $content;
}


