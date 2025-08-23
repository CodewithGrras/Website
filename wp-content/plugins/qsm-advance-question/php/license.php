<?php

/**
 * License Related Functions
 *
 * @author Awesome
 */
if ( ! class_exists( 'QSM_license' ) ) {

	class QSM_license {

		public function __construct() {

		}

		public static function activate( $license_key = '', $item_name = '' ) {
			$response = array(
				'status'  => 'error',
				'message' => __( 'Please try again!', 'qsm-advance-question' ),
			);
			if ( ! empty( $license_key ) ) {
				$params              = array(
					'timeout'   => 15,
					'sslverify' => true,
					'body'      => array(
						'edd_action' => 'activate_license',
						'license'    => $license_key,
						'item_name'  => urlencode( $item_name ), /* The name of product in EDD. */
						'url'        => home_url(),
					),
				);
				$activation_response = wp_remote_post( 'https://quizandsurveymaster.com', $params );
				if ( ! empty( $activation_response ) ) {
					$body = json_decode( $activation_response['body'] );
					if ( $body->success ) {
						$response = array(
							'status'  => 'success',
							'message' => __( 'License validated Successfully', 'qsm-advance-question' ),
						);
					} else {
						$error_message   = array(
							'missing'               => __( 'License doesn\'t exist', 'qsm-advance-question' ),
							'missing_url'           => __( 'URL not provided', 'qsm-advance-question' ),
							'license_not_activable' => __( 'Attempting to activate a bundle\'s parent license', 'qsm-advance-question' ),
							'disabled'              => __( 'License key revoked', 'qsm-advance-question' ),
							'no_activations_left'   => __( 'No activations left', 'qsm-advance-question' ),
							'expired'               => __( 'License has expired', 'qsm-advance-question' ),
							'key_mismatch'          => __( 'License is not valid for this product', 'qsm-advance-question' ),
							'invalid_item_id'       => __( 'Invalid Item ID', 'qsm-advance-question' ),
							'item_name_mismatch'    => __( 'License is not valid for this product', 'qsm-advance-question' ),
						);
						$message         = __( 'Please try again!', 'qsm-advance-question' );
						if ( ! empty( $body->error ) ) {
							$message = $error_message[ $body->error ];
						}
						$response = array(
							'status'  => 'error',
							'message' => $message,
						);
					}
				}
			}
			return $response;
		}

		public static function deactivate( $license_key = '', $item_name = '' ) {
			if ( ! empty( $license_key ) ) {
				$params      = array(
					'timeout'   => 15,
					'sslverify' => false,
					'body'      => array(
						'edd_action' => 'deactivate_license',
						'license'    => $license_key,
						'item_name'  => urlencode( $item_name ), /* The name of product in EDD. */
						'url'        => home_url(),
					),
				);
				$response    = wp_remote_post( 'https://quizandsurveymaster.com', $params );
			}
			return;
		}

	}

}
