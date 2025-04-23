<?php


namespace GFOTP\Helper;

use GFOTP\Objects\FormHandler;
use GFOTP\Traits\Instance;

if(! defined( 'ABSPATH' )) exit;

final class GravityFormList
{
    use Instance;

    
    private $_forms;

    
    private $enabled_forms;


    
    private function __construct() { $this->_forms = array(); }

    
    public function add($key, $form)
    {   
        $this->_forms[$key] = $form;
        if($form->isFormEnabled()) {
            $this->enabled_forms[$key] = $form;
        }
    }

    

    
    public function getList() { return $this->_forms; }

    
    public function getEnabledForms(){ return $this->enabled_forms; }

}