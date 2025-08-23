<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
if ( ! class_exists( 'AddonFunctions_advance_question' ) ) {

	class AddonFunctions_advance_question {

		public function __construct() {
			/**
			 * Add Hooks & Functions.
			 */
			add_action( 'admin_enqueue_scripts', array( &$this, 'admin_enqueue_scripts' ), 9999 );
			add_action( 'wp_enqueue_scripts', array( &$this, 'wp_enqueue_scripts' ), 9999 );
		}

		public function admin_enqueue_scripts() {
			wp_enqueue_script( 'qsm-advance-question-addon-admin-js', QSM_ADVANCE_QUESTION_ADDON_JS_URL . '/qsm-custom-addon-admin.js', array( 'jquery', 'qsm_admin_js' ), QSM_ADVANCE_QUESTION_ADDON_VERSION, true );
			wp_enqueue_style( 'qsm-advance-question-addon-admin-css', QSM_ADVANCE_QUESTION_ADDON_CSS_URL . '/qsm-custom-addon-admin.css', array(), QSM_ADVANCE_QUESTION_ADDON_VERSION );
			wp_enqueue_style( 'qsm-multi-polar-slide', QSM_ADVANCE_QUESTION_ADDON_CSS_URL . '/qsm-multi-polar-slide.css', array(), QSM_ADVANCE_QUESTION_ADDON_VERSION );
		}

		public function wp_enqueue_scripts() {
			wp_enqueue_script( 'qsm-advance-question-addon-front-js', QSM_ADVANCE_QUESTION_ADDON_JS_URL . '/qsm-custom-addon-front.js', array( 'jquery', 'jquery-touch-punch', 'jquery-ui-sortable' ), QSM_ADVANCE_QUESTION_ADDON_VERSION, true );
			wp_enqueue_style( 'qsm-advance-question-addon-front-css', QSM_ADVANCE_QUESTION_ADDON_CSS_URL . '/qsm-custom-addon-front.css', array(), QSM_ADVANCE_QUESTION_ADDON_VERSION );
			wp_enqueue_style( 'qsm-multi-polar-slide', QSM_ADVANCE_QUESTION_ADDON_CSS_URL . '/qsm-multi-polar-slide.css', array(), QSM_ADVANCE_QUESTION_ADDON_VERSION );
		}

		function qsm_get_quiz_url( $quiz_id = 0 ) {
			$permalink = '';
			if ( ! empty( $quiz_id ) && $quiz_id > 0 ) {
				$args      = array(
					'posts_per_page' => 1,
					'post_type'      => 'qsm_quiz',
					'meta_query'     => array(
						array(
							'key'     => 'quiz_id',
							'value'   => $quiz_id,
							'compare' => '=',
						),
					),
				);
				$the_query = new WP_Query( $args );
				if ( $the_query->have_posts() ) {
					while ( $the_query->have_posts() ) {
						$the_query->the_post();
						$permalink = get_the_permalink( get_the_ID() );
					}
					wp_reset_postdata();
				}
			}
			return $permalink;
		}

	}

}
global $AddonFunctions_advance_question;
$AddonFunctions_advance_question = new AddonFunctions_advance_question();
