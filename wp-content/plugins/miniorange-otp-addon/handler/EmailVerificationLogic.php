<?php

namespace GFOTP\Handler;
if(! defined( 'ABSPATH' )) exit;
use GFOTP\Helper\FormSessionVars;
use GFOTP\Helper\GatewayFunctions;
use GFOTP\Helper\MoConstants;
use GFOTP\Helper\MoMessages;
use GFOTP\Helper\MoUtility;
use GFOTP\Helper\SessionUtils;
use GFOTP\Objects\VerificationLogic;
use GFOTP\Traits\Instance;


final class EmailVerificationLogic extends VerificationLogic
{
    use Instance;

	
	public function _handle_logic($user_login,$user_email,$phone_number,$otp_type,$from_both)
	{
		$this->checkIfUserRegistered($otp_type,$from_both);
	    if(is_email($user_email)) {
            $this->_handle_matched($user_login,$user_email,$phone_number,$otp_type,$from_both);
        } else {
	        $this->_handle_not_matched($user_email,$otp_type,$from_both);
        }
	}

	

 function checkIfUserRegistered($otp_type,$from_both){
		if (!MoUtility::micr()) {
			$message = MoMessages::showMessage(MoMessages::NEED_TO_REGISTER);
			if($this->_is_ajax_form()){
				
				wp_send_json(MoUtility::createJson($message,MoConstants::ERROR_JSON_TYPE));
			}
			else{
				miniorange_site_otp_validation_form_gf(null,null,null,$message,$otp_type,$from_both);
			}
		}
	}


    
    public function _handle_matched($user_login,$user_email,$phone_number,$otp_type,$from_both)
    {
        $message = str_replace("##email##", $user_email, $this->_get_is_blocked_message());
        if ($this->_is_blocked($user_email, $phone_number))
            if ($this->_is_ajax_form())
                wp_send_json(MoUtility::createJson($message, MoConstants::ERROR_JSON_TYPE));
            else
                miniorange_site_otp_validation_form_gf(null, null, null, $message, $otp_type, $from_both);
        else
            $this->_start_otp_verification($user_login, $user_email, $phone_number, $otp_type, $from_both);
    }


    
    public function _handle_not_matched($user_email,$otp_type,$from_both)
    {

        $message = str_replace("##email##",$user_email,$this->_get_otp_invalid_format_message());
        if($this->_is_ajax_form())
            wp_send_json(MoUtility::createJson($message,MoConstants::ERROR_JSON_TYPE));
        else
            miniorange_site_otp_validation_form_gf(null,null,null,$message,$otp_type,$from_both);
    }


	
	public function _start_otp_verification($user_login,$user_email,$phone_number,$otp_type,$from_both)
	{
	    
        $gateway = GatewayFunctions::instance();
        $content = $gateway->mo_send_otp_token('EMAIL',$user_email,'');
		switch ($content['status'])
		{
			case 'SUCCESS':
				$this->_handle_otp_sent($user_login,$user_email,$phone_number,$otp_type,$from_both,$content);
				break;
			default:
				$this->_handle_otp_sent_failed($user_login,$user_email,$phone_number,$otp_type,$from_both,$content);
				break;
		}
	}


	
	public function _handle_otp_sent($user_login,$user_email,$phone_number,$otp_type,$from_both,$content)
	{
		SessionUtils::setEmailTransactionID($content['txId']);
	 
		if(MoUtility::micr() && MoUtility::isMG()) {
			$availEmail = get_mo_gf_option('email_transactions_remaining');
            if(($availEmail > 0) && (MO_GF_TEST_MODE==false))
            update_mo_gf_option('email_transactions_remaining',$availEmail - 1);
        }

        $message = str_replace("##email##",$user_email,$this->_get_otp_sent_message());
        
        apply_filters( 'mo_start_reporting', $content['txId'],$user_email,$user_email,$otp_type,$message,'OTP_SENT');

		if($this->_is_ajax_form())
			wp_send_json(MoUtility::createJson($message,MoConstants::SUCCESS_JSON_TYPE));
		else
			miniorange_site_otp_validation_form_gf($user_login, $user_email,$phone_number,$message,$otp_type,$from_both);
	}


	
	public function _handle_otp_sent_failed($user_login,$user_email,$phone_number,$otp_type,$from_both,$content)
	{
		$message = str_replace("##email##",$user_email,$this->_get_otp_sent_failed_message());

		if($this->_is_ajax_form())
			wp_send_json(MoUtility::createJson($message,MoConstants::ERROR_JSON_TYPE));
		else
			miniorange_site_otp_validation_form_gf(null,null,null,$message,$otp_type,$from_both);
	}


	
	public function _get_otp_sent_message()
	{
		$sentMsg = get_mo_gf_option("success_email_message","mo_otp_");
		return $sentMsg ? mogf_($sentMsg) : MoMessages::showMessage(MoMessages::OTP_SENT_EMAIL);
	}


	
	public function _get_otp_sent_failed_message()
	{
		$failedMsg = get_mo_gf_option("error_email_message","mo_otp_");
		return $failedMsg ? mogf_($failedMsg) : MoMessages::showMessage(MoMessages::ERROR_OTP_EMAIL);
	}


    
	public function _is_blocked($user_email,$phone_number)
	{
		$blocked_email_domains = explode(";",get_mo_gf_option('blocked_domains'));
		$blocked_email_domains = apply_filters("mo_blocked_email_domains",$blocked_email_domains);
		return in_array(MoUtility::getDomain($user_email),$blocked_email_domains);
	}


	
	public function _get_is_blocked_message()
	{
		$blocked_emails = get_mo_gf_option("blocked_email_message","mo_otp_");
		return $blocked_emails ? mogf_($blocked_emails) : MoMessages::showMessage(MoMessages::ERROR_EMAIL_BLOCKED);
	}


	
	public function _get_otp_invalid_format_message() {
        $message = get_mo_gf_option("invalid_email_message","mo_otp_");
        return $message ? mogf_($message) : MoMessages::showMessage(MoMessages::ERROR_EMAIL_FORMAT);
    }
}