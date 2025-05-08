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
				'message' => __( 'Please try again!', 'quiz-master-next' ),
			);
			if ( ! empty( $license_key ) ) {
				$params              = array(
					'timeout'   => 15,
					'sslverify' => true,
					'body'      => array(
						'edd_action' => 'activate_license',
						'license'    => $license_key,
						'item_name'  => rawurlencode( $item_name ), /* The name of product in EDD. */
						'url'        => home_url(),
					),
				);
				$activation_response = wp_remote_post( QSM_INSTALLER_API_URL, $params );
				if ( ! empty( $activation_response ) ) {
					$body = json_decode( $activation_response['body'] );
					if ( $body->success ) {
						$response = array(
							'status'  => 'success',
							'message' => __( 'License validated Successfully', 'quiz-master-next' ),
						);
					} else {
						$error_message   = array(
							'missing'               => __( 'License doesn\'t exist', 'quiz-master-next' ),
							'missing_url'           => __( 'URL not provided', 'quiz-master-next' ),
							'license_not_activable' => __( 'Attempting to activate a bundle\'s parent license', 'quiz-master-next' ),
							'disabled'              => __( 'License key revoked', 'quiz-master-next' ),
							'no_activations_left'   => __( 'No activations left', 'quiz-master-next' ),
							'expired'               => __( 'License has expired', 'quiz-master-next' ),
							'key_mismatch'          => __( 'License is not valid for this product', 'quiz-master-next' ),
							'invalid_item_id'       => __( 'Invalid Item ID', 'quiz-master-next' ),
							'item_name_mismatch'    => __( 'License is not valid for this product', 'quiz-master-next' ),
						);
						$message         = __( 'Please try again!', 'quiz-master-next' );
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
					'sslverify' => true,
					'body'      => array(
						'edd_action' => 'deactivate_license',
						'license'    => $license_key,
						'item_name'  => rawurlencode( $item_name ), /* The name of product in EDD. */
						'url'        => home_url(),
					),
				);
				$response    = wp_remote_post( QSM_INSTALLER_API_URL, $params );
			}
			return;
		}

	}

}
