<?php

namespace GFOTP\Helper;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


class MoConstants {

	// const COUNTRY_BLOCKED_ERROR = "COUNTRY_BLOCKED_ERROR";
	const HOSTNAME               = MOV_GF_HOST;
	const DEFAULT_CUSTOMER_KEY   = MOV_GF_DEFAULT_CUSTOMERKEY;
	const DEFAULT_API_KEY        = MOV_GF_DEFAULT_APIKEY;
	const FEEDBACK_EMAIL         = 'otpsupport@xecurify.com';
	const SUCCESS                = 'SUCCESS';
	const ERROR                  = 'ERROR';
	const FAILURE                = 'FAILURE';
	const AREA_OF_INTEREST       = 'WP OTP Verification Plugin';
	const ADDON_NAME             = 'WP OTP Gravity Addon';
	const PLUGIN_TYPE            = MOV_GF_TYPE;
	const PATTERN_PHONE          = '/^[\+]\d{1,4}\d{7,12}$|^[\+]\d{1,4}[\s]\d{7,12}$/';
	const PATTERN_COUNTRY_CODE   = '/^[\+]\d{1,4}.*/';
	const PATTERN_SPACES_HYPEN   = '/([\(\) \-]+)/';
	const ERROR_JSON_TYPE        = 'error';
	const SUCCESS_JSON_TYPE      = 'success';
	const EMAIL_TRANS_REMAINING  = 10;
	const PHONE_TRANS_REMAINING  = 10;
	const USERPRO_VER_FIELD_META = 'verification_form';

		const FAQ_URL       = 'https://faq.miniorange.com/kb/otp-verification/';
	const FAQ_BASE_URL      = 'https://faq.miniorange.com/knowledgebase/';
	const VIEW_TRANSACTIONS = '/moas/viewtransactions';
	const FAQ_PAY_URL       = 'https://faq.miniorange.com/knowledgebase/how-to-make-payment-for-the-otp-verification-plugin';
	const MOCOUNTRY         = 'India';
}
