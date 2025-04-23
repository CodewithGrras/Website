<?php

namespace GFOTP\Objects;

use GFOTP\Helper\MoUtility;
use GFOTP\Traits\Instance;

final class TabDetails
{
    use Instance;

    
    public $_tabDetails;

    
    public $_parentSlug;

    
    private function __construct()
    {   
        $registered = MoUtility::micr();
        $this->_parentSlug = 'gfsettings';
        $request_uri = remove_query_arg('addon',$_SERVER['REQUEST_URI']);

        $this->_tabDetails = [
            Tabs::ACCOUNT => new PluginPageDetails(
                "OTP Verification - Accounts",
                "gfotpaccount",
                !$registered ? 'Account Setup' : 'User Profile',
                !$registered ? "Account Setup" : "Profile",
                $request_uri,
                'account.php',
                'account',
                '',
                false
            ),
            Tabs::FORMS => new PluginPageDetails(
                'OTP Verification - Forms',
                $this->_parentSlug,
                mogf_('Forms'),
                mogf_('OTP Verification Settings'),
                $request_uri,
                'settingsgf.php',
                'tabID',
                "background:#D8D8D8"
            ),
        ];
    }
}