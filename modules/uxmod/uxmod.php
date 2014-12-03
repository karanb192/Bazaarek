<?php

if (!defined('_PS_VERSION_'))
    exit;

class UXMod extends Module
{
    /* @var boolean error */
    protected $_errors = false;
	private $_html = '';
	
    public function __construct()
    {
        $this->name = 'uxmod';
        $this->tab = 'front_office_features';
        $this->version = '1.0.0';
        $this->author = 'Jaideep Bhoosreddy';
        $this->need_instance = 1;

        parent::__construct();
		$this->context = Context::getContext();
        $this->displayName = $this->l('UXMod');
        $this->description = $this->l('This module modifies the front end UI for Bazaarek.');
		$this->confirmUninstall = $this->l('Are you sure you want to delete this module?');
    }

    public function install() {

        if (!parent::install() && $this->registerHook('displayHeader'))
	    	return false;
        return true;
    }

    public function uninstall() {

        if (!parent::uninstall())
            return false;
        return true;
    }
	
	public function hookDisplayHeader($params)
	{
		ToolsCore::addJS($this->_path.$this->name.'.js');
		ToolsCore::addCSS($this->_path.$this->name.'.css');
		return $this->display(__FILE__, $this->name.'.tpl');
	}
}




