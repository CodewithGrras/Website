<?php

namespace GFOTP\Handler;
if(! defined( 'ABSPATH' )) exit;
use GFOTP\Helper\GatewayFunctions;
use GFOTP\Helper\MoConstants;
use GFOTP\Helper\MocURLOTP;
use GFOTP\Helper\MoMessages;
use GFOTP\Helper\MoUtility;
use GFOTP\Objects\BaseActionHandler;
use GFOTP\Traits\Instance;


class MoRegistrationHandler extends BaseActionHandler
{
    use Instance;

	function __construct()
	{
	    parent::__construct();
	    $this->_nonce = 'mo_reg_actions';
		add_action( 'admin_init',  array( $this, 'handle_customer_registration_gf' ) );
	}


	
	function handle_customer_registration_gf()
	{
		if ( !current_user_can( 'manage_options' )) return;
		if(!isset($_POST['option'])) return;
		$option = sanitize_text_field(trim($_POST['option']));
		switch($option)
		{
			case "mogf_registration_register_customer":
				$this->_register_customer($_POST);	
				case 'mogf_registration_connect_verify_customer':
					$this->_verify_customer( $_POST );											   	break;
			case "mogf_registration_go_back":
				$this->_revert_back_registration();												   		break;
			case "mogf_registration_forgot_password":
				$this->_reset_password();															   	break;
            case "mogf_go_to_login_page":
            case "remove_account_gf":
				$this->removeAccount();													                break;
			case "mogf_registration_verify_license":
				$this->_vlk($_POST);																	break;
		}
	}


	
	function _register_customer($post)
	{
	    $this->isValidRequest();
		$email 			 = sanitize_email( $_POST['email'] );
		$company 		 = sanitize_text_field($_POST['company']);
		$first_name 	 = sanitize_text_field($_POST['fname']);
		$last_name 		 = sanitize_text_field($_POST['lname']);
		$password 		 = sanitize_text_field($_POST['password'] );
		$confirmPassword = sanitize_text_field($_POST['confirmPassword'] );

		if( strlen( $password ) < 6 || strlen( $confirmPassword ) < 6)
		{
			do_action('mo_registration_show_message',MoMessages::showMessage(MoMessages::PASS_LENGTH),'ERROR');
			return;
		}

		if( $password != $confirmPassword )
		{
			delete_mo_gf_option('verify_customer');
			do_action('mo_registration_show_message',MoMessages::showMessage(MoMessages::PASS_MISMATCH),'ERROR');
			return;
		}

		if( MoUtility::isBlank( $email ) || MoUtility::isBlank( $password )
				|| MoUtility::isBlank( $confirmPassword ) )
		{
			do_action('mo_registration_show_message',MoMessages::showMessage(MoMessages::REQUIRED_FIELDS),'ERROR');
			return;
		}

		update_mo_gf_option( 'company_name'		, $company);
		update_mo_gf_option( 'first_name'		, $first_name);
		update_mo_gf_option( 'last_name'		    , $last_name);
		update_mo_gf_option( 'admin_email_gf'		, $email );
				update_mo_gf_option( 'admin_password'	, $password );

		$content  = json_decode(MocURLOTP::check_customer($email), true);
		switch ($content['status'])
		{
			case 'CUSTOMER_NOT_FOUND':
				$this->handle_without_ckey_cid_regisgtration( $email, $company, $password, '', $first_name, $last_name );
				break;
			default:
				$this->_get_current_customer($email,$password);
				break;
		}

	}

	private function handle_without_ckey_cid_regisgtration( $email, $company, $password, $phone, $first_name, $last_name ) {
		$customer_key = json_decode( MocURLOTP::create_customer( $email, $company, $password, $phone, $first_name, $last_name ), true );
		if ( strcasecmp( $customer_key['status'], 'INVALID_EMAIL_QUICK_EMAIL' ) === 0 ) {
			do_action( 'mo_registration_show_message', MoMessages::show_message( MoMessages::ENTERPRIZE_EMAIL ), 'ERROR' );
		}
		if ( strcasecmp( $customer_key['status'], 'CUSTOMER_USERNAME_ALREADY_EXISTS' ) === 0 ) {
			$this->_get_current_customer( $email, $password );
		} elseif ( strcasecmp( $customer_key['status'], 'ENDUSER_EMAIL_EXISTS' ) === 0 ) {
			do_action( 'mo_registration_show_message', MoMessages::show_message( MoMessages::ACCOUNT_EXISTS ), 'ERROR' );
		} elseif ( strcasecmp( $customer_key['status'], 'EMAIL_BLOCKED' ) === 0 && 'error.enterprise.email' === $customer_key['message'] ) {
			do_action( 'mo_registration_show_message', MoMessages::show_message( MoMessages::ENTERPRIZE_EMAIL ), 'ERROR' );
		} elseif ( strcasecmp( $customer_key['status'], 'FAILED' ) === 0 ) {
			do_action( 'mo_registration_show_message', MoMessages::show_message( MoMessages::REGISTRATION_ERROR ), 'ERROR' );
		} elseif ( strcasecmp( $customer_key['status'], 'SUCCESS' ) === 0 ) {
			$this->save_success_customer_config( $customer_key['id'], $customer_key['apiKey'], $customer_key['token'], $customer_key['appSecret'] );
			update_mo_gf_option( 'registration_status', 'MO_CUSTOMER_VALIDATION_REGISTRATION_COMPLETE' );
			do_action( 'mo_registration_show_message', MoMessages::show_message( MoMessages::REG_COMPLETE ), 'SUCCESS' );
			header( 'Location: admin.php?page=otpaccount' );
		}
	}



    
	private function _get_current_customer($email,$password)
	{	
		$content     = MocURLOTP::get_customer_key($email,$password);
		$customerKey = json_decode($content, true);
		if(json_last_error() == JSON_ERROR_NONE)
		{
			update_mo_gf_option('admin_email_gf', $email );
			update_mo_gf_option( 'admin_phone_gf', $customerKey['phone'] );
			$this->save_success_customer_config(
			    $customerKey['id'], $customerKey['apiKey'], $customerKey['token'], $customerKey['appSecret']
            );
			MoUtility::_handle_mo_check_ln(false,$customerKey['id'], $customerKey['apiKey']);
			do_action('mo_registration_show_message', MoMessages::showMessage(MoMessages::REG_SUCCESS),'SUCCESS');
		}
		else
		{
            update_mo_gf_option('admin_email_gf', $email );
			update_mo_gf_option('verify_customer', 'true');
			delete_mo_gf_option('new_registration_gf');
			do_action('mo_registration_show_message', MoMessages::showMessage(MoMessages::ACCOUNT_EXISTS),'ERROR');
		}
	}

		function save_success_customer_config($id, $apiKey, $token, $appSecret)
	{
		update_mo_gf_option( 'admin_customer_key_gf'  , $id       );
		update_mo_gf_option( 'admin_api_key_gf'       , $apiKey   );
		update_mo_gf_option( 'customer_token_gf'      , $token    );
		update_mo_gf_option( 'plugin_activation_date'      , date("Y-m-d h:i:sa"));
		delete_mo_gf_option( 'verify_customer'                 );
		delete_mo_gf_option( 'new_registration_gf'                );
		delete_mo_gf_option( 'admin_password'                  );
	}

    
	function _verify_customer($post)
	{
        $this->isValidRequest();
		$email 	  = sanitize_email( $post['email'] );
		$password = stripslashes($post['password']);

		if( MoUtility::isBlank( $email ) || MoUtility::isBlank( $password ) )
		{
			do_action('mo_registration_show_message', MoMessages::showMessage(MoMessages::REQUIRED_FIELDS),'ERROR');
			return;
		}
		$this->_get_current_customer($email,$password);
	}


    
	function _reset_password()
	{
        $this->isValidRequest();
		$email 	  = get_mo_gf_option('admin_email_gf');
		if(!$email)
			do_action('mo_registration_show_message',MoMessages::showMessage(MoMessages::FORGOT_PASSWORD_MESSAGE),"SUCCESS");
		else{
		$forgot_password_response = json_decode(MocURLOTP::forgot_password($email));
		if($forgot_password_response->status == 'SUCCESS')
			do_action('mo_registration_show_message', MoMessages::showMessage(MoMessages::RESET_PASS),'SUCCESS');
		else
			do_action('mo_registration_show_message',MoMessages::showMessage(MoMessages::UNKNOWN_ERROR),'ERROR');
		}
		
	}


    
	function _revert_back_registration()
	{	
        $this->isValidRequest();
		update_mo_gf_option('registration_status_gf','');
		delete_mo_gf_option('new_registration_gf');
		delete_mo_gf_option('verify_customer' ) ;
		delete_mo_gf_option('admin_email_gf');
		delete_mo_gf_option('sms_otp_count');
		delete_mo_gf_option('email_otp_count');
		delete_mo_gf_option('plugin_activation_date');

	}


    
    function removeAccount()
    {	
        $this->isValidRequest();
        $this->flush_cache();
        wp_clear_scheduled_hook('hourlySync');
        delete_mo_gf_option('transactionId');
        delete_mo_gf_option('admin_password');
        delete_mo_gf_option('registration_status_gf');
        delete_mo_gf_option('admin_phone_gf');
        delete_mo_gf_option('new_registration_gf');
        delete_mo_gf_option('admin_customer_key_gf');
        delete_mo_gf_option('admin_api_key_gf');
        delete_mo_gf_option('customer_token_gf');
        delete_mo_gf_option('verify_customer');
        delete_mo_gf_option('message');
        delete_mo_gf_option('check_ln');
        delete_mo_gf_option('site_email_ckl');
        delete_mo_gf_option('email_verification_lk');
        update_mo_gf_option("verify_customer",true);
        delete_mo_gf_option('plugin_activation_date');
    }

    
    function flush_cache()
    {
        
        $gateway = GatewayFunctions::instance();
        $gateway->flush_cache();
    }

    
    function _vlk($post)
    {
        
        $gateway = GatewayFunctions::instance();
        $gateway->_vlk($post);
    }
}