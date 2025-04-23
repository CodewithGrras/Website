<?php

namespace GFOTP\Handler\Forms;

use GF_Field;
use GFAPI;
use GFOTP\Helper\FormSessionVars;
use GFOTP\Helper\MoConstants;
use GFOTP\Helper\MoMessages;
use GFOTP\Helper\MoOTPDocs;
use GFOTP\Helper\MoUtility;
use GFOTP\Helper\SessionUtils;
use GFOTP\Objects\FormHandler;
use GFOTP\Objects\IFormHandler;
use GFOTP\Objects\VerificationType;
use GFOTP\Traits\Instance;
use ReflectionException;
use VARIANT;

class GravityForm extends FormHandler implements IFormHandler {

	private $sms_body;
	private $admin_sms_body;
	
	use Instance;

	protected function __construct() {
		$this->_isLoginOrSocialForm = false;
		$this->_isAjaxForm          = true;
		$this->_formSessionVar      = FormSessionVars::GF_FORMS;
		$this->_typePhoneTag        = 'mo_gf_contact_phone_enable';
		$this->_typeEmailTag        = 'mo_gf_contact_email_enable';
		$this->_formKey             = 'GRAVITY_FORM';
		$this->_formName            = mogf_( 'Gravity Form' );
		$this->_isFormEnabled       = get_mo_gf_option( 'gf_addon_contact_enable' );
		$this->_phoneFormId         = '.ginput_container_phone';
		$this->_buttonText          = get_mo_gf_option( 'gf_addon_button_text' );
		$this->_buttonText          = ! MoUtility::isBlank( $this->_buttonText ) ? $this->_buttonText : mogf_( 'Click here to send OTP' );
		$this->_formDocuments       = MoOTPDocs::GF_FORM_LINK;
		parent::__construct();
	}


	function handleForm() {
		$this->_otpType               = get_mo_gf_option( 'gf_addon_contact_type' );
		$this->_formDetails           = maybe_unserialize( get_mo_gf_option( 'gf_addon_otp_enabled' ) );
		$this->customer_notif_enabled = get_mo_gf_option( 'mogf_customer_sms_notif_enable' );
		$this->admin_notif_enabled    = get_mo_gf_option( 'mogf_admin_sms_notif_enable' );
		$this->sms_body               = get_mo_gf_option( 'mogf_sms_template' );
		$this->admin_sms_body         = get_mo_gf_option( 'mogf_admin_sms_template' );
		$this->admin_phone_numbers    = get_mo_gf_option( 'gf_admin_phone_numbers' );

		if ( empty( $this->_formDetails ) ) {
			return;
		}
		add_filter( 'gform_field_content', array( $this, '_add_scripts' ), 1, 5 );
		add_filter( 'gform_field_validation', array( $this, 'validate_form_submit' ), 1, 5 );
		// add_action( 'gform_after_submission', array( $this, 'send_mo_notif' ), 1, 2 );

		$this->routeData();
	}

	public static function send_mo_gravity_form_notif( $entry, $form ) {

		$customer_notif_enabled = get_mo_gf_option( 'mogf_customer_sms_notif_enable' );
		$admin_notif_enabled    = get_mo_gf_option( 'mogf_admin_sms_notif_enable' );
		if ( ! $customer_notif_enabled && ! $admin_notif_enabled ) {
			return;
		}

		$data                = $_POST;
		$sms_body            = get_mo_gf_option( 'mogf_sms_template' );
		$admin_sms_body      = get_mo_gf_option( 'mogf_admin_sms_template' );
		$admin_phone_numbers = get_mo_gf_option( 'gf_admin_phone_numbers' );
		$ad_phone_numbers    = is_array( $admin_phone_numbers ) ? $admin_phone_numbers : explode( ';', $admin_phone_numbers );
		$form_details        = maybe_unserialize( get_mo_gf_option( 'gf_addon_otp_enabled' ) );

		// $user_email   = $data['input_2'];
		// $firstname    = $data['input_1.3'];
		// $lastname     = $data['input_1.6'];

		$replaced_string = array(
			'site-name' => get_bloginfo(),
		);
		$sms_body        = MoUtility::replaceString( $replaced_string, $sms_body );

		if ( $customer_notif_enabled ) {
			foreach ( $form_details as $key => $formDetail ) {
				$phoneField   = sprintf( '%s_%d', 'input', $formDetail['phonekey'] );
				$phone_number = $data[ $phoneField ];

				if ( MoUtility::isBlank( $phone_number ) ) {
					return;
				}
				MoUtility::send_phone_notif( $phone_number, $sms_body );
			}
		}

		if ( $admin_notif_enabled ) {
			if ( MoUtility::isBlank( $ad_phone_numbers ) ) {
				return;
			}
			foreach ( $ad_phone_numbers as $phone_number ) {
				MoUtility::send_phone_notif( $phone_number, $admin_sms_body );
			}
		}

	}

	private function routeData() {
		if ( ! array_key_exists( 'option', $_GET ) ) {
			return;
		}

		switch ( trim( $_GET['option'] ) ) {
			case 'miniorange-gf-contact':
				$this->_handle_gf_form( $_POST );
				break;
		}
	}



	private function _handle_gf_form( $getData ) {

		MoUtility::initialize_transaction( $this->_formSessionVar );

		if ( $this->_otpType === $this->_typeEmailTag ) {
			$this->processEmailAndStartOTPVerificationProcess( $getData );
		}
		if ( $this->_otpType === $this->_typePhoneTag ) {
			$this->processPhoneAndStartOTPVerificationProcess( $getData );
		}
	}



	private function processEmailAndStartOTPVerificationProcess( $getData ) {
		if ( MoUtility::sanitizeCheck( 'user_email', $getData ) ) {
			SessionUtils::addEmailVerified( $this->_formSessionVar, $getData['user_email'] );
			$this->sendChallenge( '', $getData['user_email'], null, $getData['user_email'], VerificationType::EMAIL );
		} else {
			wp_send_json(
				MoUtility::createJson(
					MoMessages::showMessage( MoMessages::ENTER_EMAIL ),
					MoConstants::ERROR_JSON_TYPE
				)
			);
		}

	}



	private function processPhoneAndStartOTPVerificationProcess( $getData ) {
		if ( MoUtility::sanitizeCheck( 'user_phone', $getData ) ) {
			SessionUtils::addPhoneVerified( $this->_formSessionVar, trim( $getData['user_phone'] ) );
			$this->sendChallenge( '', '', null, trim( $getData['user_phone'] ), VerificationType::PHONE );
		} else {
			wp_send_json(
				MoUtility::createJson(
					MoMessages::showMessage( MoMessages::ENTER_PHONE ),
					MoConstants::ERROR_JSON_TYPE
				)
			);
		}
	}



	function _add_scripts( $field_content, $field, $value, $zero, $form_id ) {
		if ( ! isset( $this->_formDetails[ $form_id ] ) ) {
			return $field_content;
		}
		$formData = $this->_formDetails[ $form_id ];

		if ( ! MoUtility::isBlank( $formData ) ) {
			if ( strcasecmp( $this->_otpType, $this->_typeEmailTag ) === 0
				&& get_class( $field ) === 'GF_Field_Email'
				&& $field['id'] == $formData['emailkey'] ) {
				$field_content = $this->_add_shortcode_to_form( 'email', $field_content, $field, $form_id );
			}
			if ( strcasecmp( $this->_otpType, $this->_typePhoneTag ) === 0
				&& get_class( $field ) === 'GF_Field_Phone'
				&& $field['id'] == $formData['phonekey'] ) {
				$field_content = $this->_add_shortcode_to_form( 'phone', $field_content, $field, $form_id );
			}
		}
		return $field_content;
	}



	function _add_shortcode_to_form( $mo_type, $field_content, $field, $form_id ) {
		$img            = "<div style='display:table;text-align:center;'><img src='" . MOV_GF_URL . "includes/images/loader.gif'></div>";
		$field_content .= "<div style='margin-top: 2%;'><input type='button' class='gform_button button medium' ";
		$field_content .= "id='miniorange_otp_token_submit' title='Please Enter an " . $mo_type . " to enable this' ";
		$field_content .= "value= '" . mogf_( $this->_buttonText ) . "'><div style='margin-top:2%'>";
		$field_content .= "<div id='mo_message' style='background-color: #f7f6f7; width:full; padding: 1em 2em 1em 3.5em; display:none;'></div></div></div>";
		$field_content .= '<style>@media only screen and (min-width: 641px) { #mo_message { width: calc(100% - 8px);}}</style>';
		$field_content .= '<script>jQuery(document).ready(function(){$mo=jQuery;$mo("#gform_' . $form_id . ' #miniorange_otp_token_submit").click(function(o){';
		$field_content .= 'var e=$mo("#input_' . $form_id . '_' . $field->id . '").val(); $mo("#gform_' . $form_id . ' #mo_message").empty(),$mo("#gform_' . $form_id . ' #mo_message").append("' . $img . '")';
		$field_content .= ',$mo("#gform_' . $form_id . ' #mo_message").show(),$mo.ajax({url:"' . site_url() . '/?option=miniorange-gf-contact",type:"POST",data:{user_';
		$field_content .= $mo_type . ':e},crossDomain:!0,dataType:"json",success:function(o){ if(o.result==="success"){$mo("#gform_' . $form_id . ' #mo_message").empty()';
		$field_content .= ',$mo("#gform_' . $form_id . ' #mo_message").append(o.message),$mo("#gform_' . $form_id . ' #mo_message").css({"background-color":"#dbfff7","color":"#008f6e"}),$mo("';
		$field_content .= '#gform_' . $form_id . ' input[name=email_verify]").focus()}else{$mo("#gform_' . $form_id . ' #mo_message").empty(),$mo("#gform_' . $form_id . ' #mo_message").append(o.message),';
		$field_content .= '$mo("#gform_' . $form_id . ' #mo_message").css({"background-color":"#ffefef","color":"#ff5b5b"}),$mo("#gform_' . $form_id . ' input[name=phone_verify]").focus()} ;},';
		$field_content .= 'error:function(o,e,n){}})});});</script>';
		return $field_content;
	}



	function validate_form_submit( $error, $value, $form, $field ) {

		$formDetails = MoUtility::sanitizeCheck( $field->formId, $this->_formDetails );

		if ( $formDetails && $error['is_valid'] == 1 ) {
			if ( strpos( $field->label, $formDetails['verifyKey'] ) !== false
				&& SessionUtils::isOTPInitialized( $this->_formSessionVar ) ) {
				$error = $this->validate_otp( $error, $value );
			} elseif ( $this->isEmailOrPhoneField( $field, $formDetails ) ) {
				if ( SessionUtils::isOTPInitialized( $this->_formSessionVar ) ) {
					$error = $this->validate_submitted_email_or_phone( $error['is_valid'], $value, $error );
				} else {
					$error = array(
						'is_valid' => null,
						'message'  => MoMessages::showMessage( MoMessages::PLEASE_VALIDATE ),
					);
				}
			}
		}
		return $error;
	}



	function validate_otp( $error, $value ) {
		$otpType = $this->getVerificationType();
		if ( MoUtility::isBlank( $value ) ) {
			$error = array(
				'is_valid' => null,
				'message'  => MoUtility::_get_invalid_otp_method(),
			);
		} else {
			$this->validateChallenge( $otpType, null, $value );
			if ( ! SessionUtils::isStatusMatch( $this->_formSessionVar, self::VALIDATED, $otpType ) ) {
				$error = array(
					'is_valid' => null,
					'message'  => MoUtility::_get_invalid_otp_method(),
				);
			} else {
				$this->unsetOTPSessionVariables();
			}
		}
		return $error;
	}



	function validate_submitted_email_or_phone( $isValid, $value, $error ) {
		$otpType = $this->getVerificationType();
		if ( $isValid ) {
			if ( $otpType === VerificationType::EMAIL && ! SessionUtils::isEmailVerifiedMatch( $this->_formSessionVar, $value ) ) {
				return array(
					'is_valid' => null,
					'message'  => MoMessages::showMessage( MoMessages::EMAIL_MISMATCH ),
				);
			} elseif ( $otpType === VerificationType::PHONE && ! SessionUtils::isPhoneVerifiedMatch( $this->_formSessionVar, $value ) ) {
				return array(
					'is_valid' => null,
					'message'  => MoMessages::showMessage( MoMessages::PHONE_MISMATCH ),
				);
			}
		}
		return $error;
	}



	function handle_failed_verification( $user_login, $user_email, $phone_number, $otpType ) {

		SessionUtils::addStatus( $this->_formSessionVar, self::VERIFICATION_FAILED, $otpType );
	}



	function handle_post_verification( $redirect_to, $user_login, $user_email, $password, $phone_number, $extra_data, $otpType ) {

		SessionUtils::addStatus( $this->_formSessionVar, self::VALIDATED, $otpType );
	}



	public function unsetOTPSessionVariables() {
		SessionUtils::unsetSession( array( $this->_txSessionId, $this->_formSessionVar ) );
	}



	public function getPhoneNumberSelector( $selector ) {

		if ( $this->isFormEnabled() && $this->_otpType === $this->_typePhoneTag ) {
			foreach ( $this->_formDetails as $key => $formDetail ) {
				$phoneField = sprintf( '%s_%d_%d', 'input', $key, $formDetail['phonekey'] );
				array_push( $selector, sprintf( '%s #%s', $this->_phoneFormId, $phoneField ) );
			}
		}
		return $selector;
	}



	function handleFormOptions() {
		if ( ! MoUtility::areFormOptionsBeingSaved( $this->getFormOption() ) || ! MoUtility::getActivePluginVersion( 'Gravity Forms' ) ) {
			return;
		}

		$this->_isFormEnabled = $this->sanitizeFormPOST( 'gf_addon_contact_enable' );
		$this->_otpType       = $this->sanitizeFormPOST( 'gf_addon_contact_type' );
		$this->_buttonText    = $this->sanitizeFormPOST( 'gf_addon_button_text' );

		// notif:
		$this->customer_notif_enabled    = $this->sanitizeFormPOST( 'mogf_customer_sms_notif_enable' );
		$this->admin_notif_enabled       = $this->sanitizeFormPOST( 'mogf_admin_sms_notif_enable' );
		$this->mogf_notif_template       = $this->sanitizeFormPOST( 'mogf_sms_template' );
		$this->mogf_admin_notif_template = $this->sanitizeFormPOST( 'mogf_admin_sms_template' );
		$this->admin_phone_numbers       = $this->sanitizeFormPOST( 'gf_admin_phone_numbers' );

		update_mo_gf_option( 'mogf_customer_sms_notif_enable', $this->customer_notif_enabled );
		update_mo_gf_option( 'mogf_admin_sms_notif_enable', $this->admin_notif_enabled );
		update_mo_gf_option( 'mogf_sms_template', $this->mogf_notif_template );
		update_mo_gf_option( 'mogf_admin_sms_template', $this->mogf_admin_notif_template );
		update_mo_gf_option( 'gf_admin_phone_numbers', $this->admin_phone_numbers );


		$forms = $this->parseFormDetails();
		$this->_formDetails = is_array( $forms ) ? $forms : '';

		update_mo_gf_option( 'gf_addon_otp_enabled', maybe_serialize( $this->_formDetails ) );
		update_mo_gf_option( 'gf_addon_contact_enable', $this->_isFormEnabled );
		update_mo_gf_option( 'gf_addon_contact_type', $this->_otpType );
		update_mo_gf_option( 'gf_addon_button_text', $this->_buttonText );
	}


	private function parseFormDetails() {
		$forms       = array();
		$getFieldKey = function( $fieldDetails, $fieldLabel, $type ) {
			foreach ( $fieldDetails as $field ) {
				if ( get_class( $field ) === $type
					&& $field['label'] == $fieldLabel ) {
					return $field['id'];
				}
			}
			return null;
		};

		$form = null;
		if ( ! array_key_exists( 'gravity_form', $_POST ) || ! $this->_isFormEnabled ) {
			return array();
		}
		foreach ( array_filter( $_POST['gravity_form']['form'] ) as $key => $value ) {
			$formData                               = GFAPI::get_form( $value );
			$emailKey                               = sanitize_text_field( $_POST['gravity_form']['emailkey'][ $key ] );
			$phoneKey                               = sanitize_text_field( $_POST['gravity_form']['phonekey'][ $key ] );
			$forms[ sanitize_text_field( $value ) ] = array(
				'emailkey'    => $getFieldKey( $formData['fields'], $emailKey, 'GF_Field_Email' ),
				'phonekey'    => $getFieldKey( $formData['fields'], $phoneKey, 'GF_Field_Phone' ),
				'verifyKey'   => sanitize_text_field( $_POST['gravity_form']['verifyKey'][ $key ] ),
				'phone_show'  => sanitize_text_field( $_POST['gravity_form']['phonekey'][ $key ] ),
				'email_show'  => sanitize_text_field( $_POST['gravity_form']['emailkey'][ $key ] ),
				'verify_show' => sanitize_text_field( $_POST['gravity_form']['verifyKey'][ $key ] ),
			);
		}
		return $forms;
	}


	private function isEmailOrPhoneField( $field, $f ) {
		return ( $this->_otpType === $this->_typePhoneTag && $field->id === $f['phonekey'] )
			|| ( $this->_otpType === $this->_typeEmailTag && $field->id === $f['emailkey'] );
	}
	
	public function getSMStemplate() {
		return $this->sms_body; }
	public function getadminSMStemplate() {
		return $this->admin_sms_body ; }
}
