<?php

if (!defined('_PS_VERSION_'))
    exit;

class BlockNotepad extends Module
{
    /* @var boolean error */
    protected $_errors = false;
	private $_html = '';
	
    public function __construct()
    {
        $this->name = 'blocknotepad';
        $this->tab = 'front_office_features';
        $this->version = '1.0.0';
        $this->author = 'Jaideep Bhoosreddy';
        $this->need_instance = 1;

        parent::__construct();
		$this->context = Context::getContext();
        $this->displayName = $this->l('NotePad Module');
        $this->description = $this->l('This module allows customers to send their requests to Bazaarek.');
		$this->confirmUninstall = $this->l('Are you sure you want to delete this module?');
    }

    public function install() {

        if (!parent::install() && $this->registerHook('displayLeftColumn'))
	    	return false;
        return true;
    }

    public function uninstall() {

        if (!parent::uninstall())
            return false;
        return true;
    }
	
	public function hookDisplayLeftColumn($params)
	{
		if(Tools::isSubmit('submit')) {
			$_first = Tools::getValue('first');
			$_last = Tools::getValue('last');
			$_email = Tools::getValue('email');
			$_message = Tools::getValue('message');
			$this->context->smarty->assign(array(
				'first' => $_first,
				'last' => $_last,
				'email' => $_email,
				'message' => $_message,
				'toast' => 'Note delivered to Bazaarek.'
			));
			$email_vars = array('first' => $_first,
				'last' => $_last,
				'email' => $_email,
				'message' => $_message);
			Mail::Send($this->context->language->id, 'email.tpl', 'Server: Web Note', $email_vars, 'jkumar@bazaarek.com');
		}
		
		return $this->display(__FILE__, 'notepad.tpl');
	}
}




