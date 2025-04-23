<?php

namespace GFOTP\Helper;

use GFOTP\Objects\BaseMessages;
use GFOTP\Traits\Instance;

if(! defined( 'ABSPATH' )) exit;


final class MoMessages extends BaseMessages
{
	use Instance;

    function __construct()
	{
		
		define("MO_GF_MESSAGES", serialize( array(
		
			self::BLOCKED_COUNTRY       => mogf_("This country is blocked by the admin. Please enter another phone number or contact site admin." ),
			self::NEED_TO_REGISTER       => mogf_("You need to login with the miniOrange account in the plugin in order to send the OTP Code." ),
			self::GLOBALLY_INVALID_PHONE_FORMAT       => mogf_("##phone## is not a Globally valid phone number. 
			                                            Please enter a valid Phone Number." ),
						self::INVALID_SCRIPTS       => mogf_("You cannot add script tags in the pop up template." ),
			
			self::OTP_SENT_PHONE                => mogf_("A OTP (One Time Passcode) has been sent to ##phone##.
			                                            Please enter the OTP in the field below to verify your phone." ),

			self::OTP_SENT_EMAIL                => mogf_("A One Time Passcode has been sent to ##email##. 
			                                            Please enter the OTP below to verify your Email Address. 
			                                            If you cannot see the email in your inbox, make sure to check 
			                                            your SPAM folder." ),

            self::ERROR_OTP_EMAIL               => mogf_("There was an error in sending the OTP. 
			                                            Please enter a valid email id or contact site Admin." ),

            self::ERROR_OTP_PHONE               => mogf_("There was an error in sending the OTP to the given Phone.
                                                        Number. Please Try Again or contact site Admin." ),

            self::ERROR_PHONE_FORMAT            => mogf_("##phone## is not a valid phone number. 
			                                            Please enter a valid Phone Number. E.g:+1XXXXXXXXXX" ),

            self::ERROR_EMAIL_FORMAT            => mogf_("##email## is not a valid email address. 
                                                        Please enter a valid Email Address. E.g:abc@abc.abc"),

            self::CHOOSE_METHOD                 => mogf_("Please select one of the methods below to verify your account. 
                                                        A One time passcode will be sent to the selected method." ),

			self::PLEASE_VALIDATE               => mogf_("You need to verify yourself in order to submit this form" ),

			self::ERROR_PHONE_BLOCKED           => mogf_("##phone## has been blocked by the admin. 
                                                        Please Try a different number or Contact site Admin." ),

			self::ERROR_EMAIL_BLOCKED           => mogf_("##email## has been blocked by the admin. 
			                                            Please Try a different email or Contact site Admin." ),

            self::REGISTER_WITH_US              => mogf_("<a href='{{url}}'>Register or Login with miniOrange</a> 
                                                        to get the free SMS/Email Transactions and enable OTP Verification"),

            self::ACTIVATE_PLUGIN              => mogf_("<a href='{{url}}'>Complete plugin activation process</a> 
                                                        to enable OTP Verification"),

            self::CONFIG_GATEWAY              =>  mogf_("<a href='{{url}}'>Please Configure Gateway </a> 
                                                             to enable OTP Verification"),  
            
						self::FORM_NOT_AVAIL_HEAD    	    => mogf_("MY FORM IS NOT IN THE LIST" ),

			self::FORM_NOT_AVAIL_BODY    	    => mogf_("We are actively adding support for more forms. Please contact 
                                                        us using the support form on your right or email us at 
                                                        <a style='cursor:pointer;' onClick='otpSupportOnClick();'><font color='white'><u>".MoConstants::FEEDBACK_EMAIL."</u>.</font></a> While contacting us please include
                                                        enough information about your registration form and how you
                                                        intend to use this plugin. We will respond promptly." ),

			self::CHANGE_SENDER_ID_BODY         => mogf_("SenderID/Number is gateway specific. 
			                                            You will need to use your own SMS gateway for this." ),

			self::CHANGE_SENDER_ID_HEAD         => mogf_("CHANGE SENDER ID / NUMBER" ),

			self::CHANGE_EMAIL_ID_BODY          => mogf_("Sender Email is gateway specific. 
			                                            You will need to use your own Email gateway for this." ),

			self::CHANGE_EMAIL_ID_HEAD          => mogf_("CHANGE SENDER EMAIL ADDRESS" ),

			self::INFO_HEADER    			    => mogf_("WHAT DOES THIS MEAN?" ),

            self::META_KEY_HEADER   		    => mogf_("WHAT IS A META KEY?" ),

            self::META_KEY_BODY 		 	    => mogf_("WordPress stores addtional user data like phone number, age 
                                                        etc in the usermeta table in a key value pair. MetaKey is
                                                        the key against which the additional value is stored in the 
                                                        usermeta table." ),

			self::ENABLE_BOTH_BODY  		    => mogf_("New users can validate their Email or Phone Number using
                                                        either Email or Phone Verification.s They will be prompted 
                                                        during registration to choose one of the two verification methods."),

			self::COUNTRY_CODE_HEAD  	        => mogf_("DON'T WANT USERS TO ENTER THEIR COUNTRY CODE?" ),

            self::COUNTRY_CODE_BODY  	        => mogf_("Choose the default country code that will be appended to the 
                                                        phone number entered by the users. This will allow your 
                                                        users to enter their phone numbers in the phone field without 
                                                        a country code." ),

			self::WC_GUEST_CHECKOUT_HEAD        => mogf_("WHAT IS GUEST CHECKOUT?"),

			self::WC_GUEST_CHECKOUT_BODY        => mogf_("Verify customer's phone number or email address only when
                                                        he is not logged in during checkout ( is a guest user )."),

						self::SUPPORT_FORM_VALUES    	    => mogf_("Please submit your query along with email." ),

			self::SUPPORT_FORM_SENT  	        => mogf_("Thanks for getting in touch! We shall get back to you shortly." ),

			self::PREM_SUPPORT_FORM_SENT  	    => mogf_("Thanks for getting in touch! We shall get back to you shortly. You can also purchase the support plan to raise the priority of the ticket." ),

			self::SUPPORT_FORM_ERROR     	    => mogf_("Your query could not be submitted. Please try again." ),

			            self::FEEDBACK_SENT                 => mogf_("Thank you for your feedback."),

            self::FEEDBACK_ERROR                => mogf_("Your feedback couldn't be submitted. Please try again"),

						self::SETTINGS_SAVED     		    => mogf_("Settings saved successfully. 
			                                            You can go to your registration form page to test the plugin." ),

			self::REG_ERROR  			        => mogf_("Please register an account before trying to enable 
			                                            OTP verification for any form." ),

			self::MSG_TEMPLATE_SAVED     	    => mogf_("Settings saved successfully." ),

			self::SMS_TEMPLATE_SAVED     	    => mogf_("Your SMS configurations are saved successfully." ),

			self::SMS_TEMPLATE_ERROR            => mogf_("Please configure your gateway URL correctly."),

			self::EMAIL_TEMPLATE_SAVED   	    => mogf_("Your email configurations are saved successfully." ),

			self::CUSTOM_MSG_SENT    		    => mogf_("Message sent successfully" ),

			self::CUSTOM_MSG_SENT_FAIL   	    => mogf_("Error sending message." ),

			self::EXTRA_SETTINGS_SAVED          => mogf_("Settings saved successfully." ),

						self::NINJA_FORM_FIELD_ERROR        => mogf_("Please fill in the form id and field id of your Ninja Form" ),

			self::NINJA_CHOOSE   			    => mogf_("Please choose a Verification Method for Ninja Form." ),

						self::EMAIL_MISMATCH     		    => mogf_("The email OTP was sent to and the email in contact 
			                                            submission do not match." ),

			self::PHONE_MISMATCH     	 	    => mogf_("The phone number OTP was sent to and the phone number in 
                                                        contact submission do not match." ),

			self::ENTER_PHONE    			    => mogf_("You will have to provide a Phone Number before you can verify it." ),

			self::ENTER_EMAIL    			    => mogf_("You will have to provide an Email Address before you can verify it." ),

						self::CF7_PROVIDE_EMAIL_KEY         => mogf_("Please Enter the name of the email address field you created
                                                        in Contact Form 7." ),

			self::CF7_CHOOSE     			    => mogf_("Please choose a Verification Method for Contact Form 7." ),

						self::BP_PROVIDE_FIELD_KEY          => mogf_("Please Enter the Name of the phone number field you 
                                                        created in BuddyPress." ),

			self::BP_CHOOSE  			        => mogf_("Please choose a Verification Method for BuddyPress 
                                                        Registration Form." ),

						self::UM_CHOOSE  			        => mogf_("Please choose a Verification Method for 
			                                            Ultimate Member Registration Form." ),

			self::UM_PROFILE_CHOOSE             => mogf_("Please choose a Verification Method for 
			                                            Ultimate Member Profile/Account Form"),

						self::EVENT_CHOOSE   			    => mogf_("Please choose a Verification Method for Event Registration Form." ),

						self::UULTRA_PROVIDE_FIELD   	    => mogf_("Please Enter the Field Key of the phone number field you 
                                                        created in Users Ultra Registration form." ),

			self::UULTRA_CHOOSE  		        => mogf_("Please choose a Verification Method for Users Ultra Registration Form." ),

						self::CRF_PROVIDE_PHONE_KEY         => mogf_("Please Enter the label name of the phone number field you 
			                                            created in Custom User Registration form." ),
			self::CRF_PROVIDE_EMAIL_KEY         => mogf_("Please Enter the label name of the email number field you 
                                                        created in Custom User Registration form." ),

			self::CRF_CHOOSE     			    => mogf_("Please choose a Verification Method for Custom User Registration Form." ),

						self::SMPLR_PROVIDE_FIELD    	    => mogf_("Please Enter the Field Key of the phone number field you
                                                        created in Simplr User Registration form." ),

			self::SIMPLR_CHOOSE  		        => mogf_("Please choose a Verification Method for 
			                                            Simplr User Registration Form." ),

						self::UPME_PROVIDE_PHONE_KEY        => mogf_("Please Enter the Field Key of the phone number field you 
			                                            created in User Profile Made Easy Registration form." ),

			self::UPME_CHOOSE    			    => mogf_("Please choose a Verification Method for User Profile Made
                                                        Easy Registration Form." ),


						self::PB_PROVIDE_PHONE_KEY   	    => mogf_("Please Enter the Field Key of the phone number field you 
                                                        created in Profile Builder Registration form." ),

			self::PB_CHOOSE  			        => mogf_("Please choose a Verification Method for Profile 
			                                            Builder Registration Form." ),

						self::PIE_PROVIDE_PHONE_KEY         => mogf_("Please Enter the Meta Key of the phone field." ),

			self::PIE_CHOOSE     			    => mogf_("Please choose a Verification Method for Pie Registration Form." ),

						self::ENTER_PHONE_CODE   		    => mogf_("Please enter the verification code sent to your phone" ),

			self::ENTER_EMAIL_CODE              => mogf_("Please enter the verification code sent to your email address" ),

            self::ENTER_VERIFY_CODE  	        => mogf_("Please verify yourself before submitting the form." ),

            self::PHONE_VALIDATION_MSG   	    => mogf_("Enter your mobile number below for verification :" ),

            self::WC_CHOOSE_METHOD   		    => mogf_("Please choose a Verification Method for Woocommerce 
                                                        Default Registration Form." ),

            self::WC_CHECKOUT_CHOOSE   		    => mogf_("Please choose a Verification Method for Woocommerce 
                                                        Checkout Registration Form." ),

						self::TMLM_CHOOSE    			    => mogf_("Please choose a Verification Method for 
			                                            Theme My Login Registration Form." ),

						self::ENTER_PHONE_DEFAULT    	    => mogf_("ERROR: Please enter a valid phone number." ),

			self::WP_CHOOSE_METHOD   		    => mogf_("Please choose a Verification Method for 
			                                            WordPress Default Registration Form." ),

			self::AUTO_ACTIVATE_HEAD            => mogf_("WHAT DO YOU MEAN BY AUTO ACTIVATE?" ),

			self::AUTO_ACTIVATE_BODY            => mogf_("By default WordPress sends out a confirmation email to new
                                                        registrants to complete their registration process. The 
                                                        plugin would add a password and confirm password field on
                                                        the registration page and auto-activate the users after 
                                                        registration."),

						self::USERPRO_CHOOSE     		    => mogf_("Please choose a Verification Method for 
			                                            UserPro Registration Form." ),

			self::USERPRO_VERIFY     		    => mogf_("Please verify yourself before submitting the form." ),

						self::PASS_LENGTH    			    => mogf_("Choose a password with minimum length 6." ),

			self::PASS_MISMATCH  		        => mogf_("Password and Confirm Password do not match." ),

			self::OTP_SENT   				    => mogf_("A passcode has been sent to {{method}}. Please enter the otp
                                                        below to verify your account." ),

			self::ERR_OTP    				    => mogf_("There was an error in sending OTP. Please click on Resend 
                                                        OTP link to resend the OTP." ),

			self::REG_SUCCESS    			    => mogf_("Your account has been retrieved successfully." ),

			self::ACCOUNT_EXISTS     		    => mogf_("You already have an account with miniOrange. 
			                                            Please enter a valid password." ),

			self::REG_COMPLETE   			    => mogf_("Registration complete!" ),

			self::INVALID_OTP    			    => mogf_("Invalid one time passcode. Please enter a valid passcode." ),

			self::RESET_PASS     			    => mogf_("You password has been reset successfully and sent to your
                                                        registered email. Please check your mailbox." ),

			self::REQUIRED_FIELDS    		    => mogf_("Please enter all the required fields" ),

            self::REQUIRED_OTP   			    => mogf_("Please enter a value in OTP field." ),

            self::INVALID_SMS_OTP    		    => mogf_("There was an error in sending sms. Please Check your phone number." ),

            self::NEED_UPGRADE_MSG   		    => mogf_("You have not upgraded yet. 
                                                        Check licensing tab to upgrade to premium version." ),

            self::VERIFIED_LK    			    => mogf_("Your license is verified. You can now setup the plugin." ),

            self::LK_IN_USE 				    => mogf_("License key you have entered has already been used. Please 
                                                        enter a key which has not been used before on any other
                                                        instance or if you have exhausted all your keys then check 
                                                        licensing tab to buy more." ),

			self::INVALID_LK     			    => mogf_("You have entered an invalid license key. 
			                                            Please enter a valid license key." ),

			self::REG_REQUIRED   			    => mogf_("Please complete your registration to save configuration." ),

						self::UNKNOWN_ERROR  		        => mogf_("Error processing your request. Please try again." ),
			self::INVALID_OP                    => mogf_( "Invalid Operation. Please Try Again"),

			self::MO_REG_ENTER_PHONE     	    => mogf_("Phone with country code eg. +1xxxxxxxxxx" ),

						self::UPGRADE_MSG    			    => mogf_("Thank you. You have upgraded to {{plan}}." ),
			self::REMAINING_TRANSACTION_MSG    	=> mogf_("You have <b>{{sms}}</b> SMS and <b>{{email}}</b> Email remaining." ),

			self::FREE_PLAN_MSG  		        => mogf_("You are on our FREE plan. Check Licensing Tab to learn how to upgrade." ),

			self::TRANS_LEFT_MSG     		    => mogf_("You have <b><i>{{email}} Email Transactions</i></b> and
                                                        <b><i>{{phone}} Phone Transactions</i></b> remaining." ),

			self::YOUR_GATEWAY_HEADER           => mogf_("WHAT DO YOU MEAN BY CUSTOM GATEWAY? WHEN DO I OPT FOR THIS PLAN?" ),

            self::YOUR_GATEWAY_BODY     	    => mogf_("Custom Gateway means that you have your own SMS or Email 
                                                        Gateway for delivering OTP to the user's email or phone. 
                                                        The plugin will handle OTP generation and verification but 
                                                        your existing gateway would be used to deliver the message to 
                                                        the user. <br/><br/>Hence, the One Time Cost of the plugin. 
                                                        <b><i>NOTE:</i></b> You will still need to pay SMS and Email 
                                                        delivery charges to your gateway separately." ),

			self::MO_GATEWAY_HEADER     	    => mogf_("WHAT DO YOU MEAN BY miniOrange GATEWAY? WHEN DO I OPT FOR THIS PLAN?" ),

            self::MO_GATEWAY_BODY       	    => mogf_("miniOrange Gateway means that you want the complete package 
                                                        of OTP generation, delivery ( to user's phone or email ) and
                                                        verification. Opt for this plan when you don't have your own 
                                                        SMS or Email gateway for message delivery. <br/><br/>
                                                        <b><i>NOTE:</i></b> SMS Delivery charges depend on the 
                                                        country you want to send the OTP to. Click on the Upgrade
                                                        Now button below and select your country to see the full pricing." ),
			self::INSTALL_PREMIUM_PLUGIN        => mogf_("You have Upgraded to the Custom Gateway Plugin. You will need to 
			                                            install the premium plugin from the 
			                                            <a href='".MoConstants::HOSTNAME."/moas/viewpaymenthistory'>
			                                            miniOrange dashboard</a>."),
			self::MO_PAYMENT     	    => mogf_("Payment Methods which we support" ),

						self::GRAVITY_CHOOSE     		    => mogf_("Please choose a Verification Method for Gravity Form." ),

						self::PHONE_NOT_FOUND    		    => mogf_("Sorry, but you don't have a registered phone number." ),

			self::REGISTER_PHONE_LOGIN   	    => mogf_("A new security system has been enabled for you. Please 
                                                        register your phone to continue." ),

						self::WP_MEMBER_CHOOSE   		    => mogf_("Please choose a Verification Method for WP Member Form." ),

						self::UMPRO_VERIFY   			    => mogf_("Please verify yourself before submitting the form." ),

			self::UMPRO_CHOOSE   			    => mogf_("Please choose a verification method for 
			                                            Ultimate Membership Pro form." ),

						self::CLASSIFY_THEME     		    => mogf_("Please choose a Verification Method for Classify Theme." ),

						self::REALES_THEME   			    => mogf_("Please choose a Verification Method for Reales WP Theme." ),

						self::LOGIN_MISSING_KEY  	        => mogf_("Please provide a meta key value for users phone numbers." ),

			self::PHONE_EXISTS  			    => mogf_("Phone Number is already in use. Please use another number." ),

			self::EMAIL_EXISTS  			    => mogf_("Email is already in use. Please use another email." ),

			self::WP_LOGIN_CHOOSE               => mogf_("Please choose a Verification Method for WordPress Login Form"),

						self::WPCOMMNENT_CHOOSE 		    => mogf_("Please choose a Verification Method for WordPress Comments Form" ),
			self::WPCOMMNENT_PHONE_ENTER        => mogf_("Error: You did not add a phone number. Hit the Back button on 
			                                            your Web browser and resubmit your comment with a phone number."),
            self::WPCOMMNENT_VERIFY_ENTER       => mogf_("Error: You did not add a Verification Code. Hit the Back button 
                                                        on your Web browser and resubmit your comment with a verification code."),

						self::FORMCRAFT_CHOOSE  	 	    => mogf_("Please choose a Verification Method for FormCraft Form" ),

			self::FORMCRAFT_FIELD_ERROR 	    => mogf_("Please fill in the form id and field id of your FormCraft Form" ),

						self::WPEMEMBER_CHOOSE   		    => mogf_("Please choose a Verification Method for WpEmember Registration Form" ),

						self::DOC_DIRECT_VERIFY 		    => mogf_("Please verify yourself before submitting the form" ),

			self::DCD_ENTER_VERIFY_CODE 	    => mogf_("Please enter a verification code to verify yourself" ),

			self::DOC_DIRECT_CHOOSE 		    => mogf_("Please choose a Verification Method for DocDirect Theme."),

						self::WPFORM_FIELD_ERROR     	    => mogf_("Please check if you have provided all the required 
			                                            information for WP Forms."),

						self::CALDERA_FIELD_ERROR    	    => mogf_("Please check if you have provided all the required
                                                        information for Caldera Forms."),

			            self::INVALID_USERNAME              => mogf_("Please enter a valid username or email."),

			self::UM_LOGIN_CHOOSE               => mogf_("Please choose a verification method for 
			                                            Ultimate Member Login form."),

			            self::MEMBERPRESS_CHOOSE            => mogf_("Please choose a verification method for Memberpress form."),

						self::REQUIRED_TAGS  		        => mogf_("NOTE: Please make sure that the template has the {{TAG}} tag. 
                                                        It is necessary for the popup to work."),

			self::TEMPLATE_SAVED     		    => mogf_("Template Saved Successfully."),

						self::DEFAULT_SMS_TEMPLATE          => mogf_("Dear Customer, Your OTP is ##otp##. Use this Passcode to
                                                        complete your transaction. Thank you." ),

			self::EMAIL_SUBJECT  		        => mogf_("Your Requested One Time Passcode" ),

			self::DEFAULT_EMAIL_TEMPLATE        => mogf_("Dear Customer, \n\nYour One Time Passcode for completing 
                                                        your transaction is: ##otp##\nPlease use this Passcode to
                                                        complete your transaction. Do not share this Passcode with 
                                                        anyone.\n\nThank You,\nminiOrange Team." ),

                        self::ADD_ON_VERIFIED               => mogf_('Thank you for the upgrade. AddOn Settings have been verified.'),

            self::INVALID_PHONE  		        => mogf_('Please enter a valid phone number'),

            self::ERROR_SENDING_SMS  	        => mogf_('There was an error sending SMS to the user'),

            self::SMS_SENT_SUCCESS   		    => mogf_('SMS was sent successfully.'),

                        self::VISUAL_FORM_CHOOSE            => mogf_( 'Please Choose a verification method for Visual Form Builder'),

                        self::FORMIDABLE_CHOOSE             => mogf_( 'Please Choose a verification method for Formidable Forms'),

                        self::FORMMAKER_CHOOSE              => mogf_( "Please Choose a verification method for FormMaker Forms."),

                        self::WC_BILLING_CHOOSE             => mogf_( "Please Choose a verification method for Woocommerce Billing Form"),
            self::ENTERPRIZE_EMAIL				=> mogf_("Please use Enterprize Email for registration or contact us at <b><i><a style='cursor:pointer;' onClick='otpSupportOnClick();'> <u>otpsupport@xecurify.com</u></a></i></b> to know more."),
            self::REGISTRATION_ERROR            => mogf_( "There is some issue proccessing the request. Please try again or contact us at <b><i><a onClick='otpSupportOnClick();'> <u>otpsupport@xecurify.com</u></a></i></b> to know more. "),
            self::FORGOT_PASSWORD_MESSAGE             => mogf_( "Please<a href='https://login.xecurify.com/moas/idp/resetpassword ' target='_blank'> Click here </a>to reset your password"),

			self::CUSTOM_CHOOSE     			    => mogf_("Please choose a Verification Method for Your Own Form." ),

			self::CUSTOM_PACKS						=> mogf_("<a href='/wp-admin/admin.php?page=pricing&subpage=custpackage'>Checkout out our new impressive <b>Cover-Your-Site Packages</b>. All-in-one WooCommerce package, Ultimate Member Package, Login/Register with Phone number and many more.</a><input type='button' class='button button-primary button-large' value='Upgrade' id='update_custom_packages_button' style='background:orange;color:black'/>" ),
			   			self::GATEWAY_PARAM_NOTE				=> mogf_("You will need to place your SMS gateway URL in the field above in order to be 
                                            able to send OTPs to the user's phone.<br>Example:-http://alerts.sinfini.com/api/web2sms.php?username=XYZ&password=password& to=##phone##&sender=senderid& message=##message##"),
			self::CUSTOM_FORM_MESSAGE     => mogf_("<b>Your test was succesful!</b> <br> Please contact us at <a style='cursor:pointer;' href='mailto:otpsupport@xecurify.com'>otpsupport@xecurify.com</a> for full integration of your form." ),

        )));
	}



    
	public static function showMessage($messageKeys , $data=array())
	{
		$displayMessage = "";
		$messageKeys = explode(" ",$messageKeys);
		$messages = unserialize(MO_GF_MESSAGES);
		foreach ($messageKeys as $messageKey)
		{
			if(MoUtility::isBlank($messageKey)) return $displayMessage;
			$formatMessage = mogf_($messages[$messageKey]);
		    foreach($data as $key => $value)
		    {
		        $formatMessage = str_replace("{{" . $key . "}}", $value ,$formatMessage);
		    }
		    $displayMessage.=$formatMessage;
		}
	    return $displayMessage;
	}
}