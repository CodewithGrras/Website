<?php
/**
 * Loads deactivation feedback form.
 *
 * @package miniorange-otp-verification
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
use GFOTP\Handler\MoOTPActionHandlerHandlerGF;

$message = mogf_(
	'We are sad to see you go :( Have you found a bug? Did you feel something was missing? 
                Whatever it is, we\'d love to hear from you and get better.'
);

$submit_message  = mogf_( 'Submit & Deactivate' );
$submit_message2 = mogf_( 'Submit' );

$admin_handler       = MoOTPActionHandlerHandlerGF::instance();
$nonce               = $admin_handler->getNonceValue();
$deactivationreasons = $admin_handler->mo_feedback_reasons();
require_once MOV_GF_DIR . 'views/feedback.php';



