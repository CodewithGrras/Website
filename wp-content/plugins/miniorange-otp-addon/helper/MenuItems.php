<?php

namespace GFOTP\Helper;

if(! defined( 'ABSPATH' )) exit;

use GFOTP\MoOTPGf;
use GFOTP\Objects\PluginPageDetails;
use GFOTP\Objects\TabDetails;
use GFOTP\Traits\Instance;


final class MenuItems
{
    use Instance;

    
    private $_callback;

    
    private $_menuSlug;

    
    private $_menuLogo;

    
    private $_tabDetails;

    
    private function __construct()
    {
        $this->_callback  = [   MoOTPGf::instance(), 'mo_customer_validation_options' ];
        $this->_menuLogo  =  MOV_GF_ICON;
        
        $tabDetails = TabDetails::instance();
        $this->_tabDetails = $tabDetails->_tabDetails;
        $this->_menuSlug = $tabDetails->_parentSlug;
        //$this->addMainMenu();
        $this->addSubMenus();
    }

    private function addMainMenu()
    {
        // add_menu_page (
        //     'OTP Verification' ,
        //     'OTP Verification' ,
        //     'manage_options',
        //     $this->_menuSlug ,
        //     $this->_callback,
        //     $this->_menuLogo
        // );
    }

    private function addSubMenus()
    {
        
        foreach ($this->_tabDetails as $tabDetail) {
            
            add_submenu_page(
                $this->_menuSlug,
                $tabDetail->_pageTitle,
                $tabDetail->_menuTitle,
                'manage_options',
                $tabDetail->_menuSlug,
                $this->_callback
            );
        }
    }
}