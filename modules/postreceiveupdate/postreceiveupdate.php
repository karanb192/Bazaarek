<?php

if (!defined('_PS_VERSION_'))
    exit;

class PostReceiveUpdate extends Module
{
    /* @var boolean error */
    protected $_errors = false;
	private $_html = '';
	
    public function __construct()
    {
        $this->name = 'postreceiveupdate';
        $this->tab = 'administration';
        $this->version = '1.0.0';
        $this->author = 'Jaideep Bhoosreddy';
        $this->need_instance = 0;

        parent::__construct();
		$this->context = Context::getContext();
        $this->displayName = $this->l('Post Receive Update Module');
        $this->description = $this->l('This module updates the Bazaarek with the latest updates from Github repository.');
		$this->confirmUninstall = $this->l('Uninstalling this module will prevent Bazaarek from receiving updates from Github. Are you sure you want to delete this module?');
    }

    public function install() {

        if (!parent::install())
	    	return false;
        return true;
    }

    public function uninstall() {

        if (!parent::uninstall())
            return false;
        return true;
    }
	
	public function getContent()
	{
		
		if (Tools::isSubmit('submit'))
	  	{
	  		$toast = "Starting update process.";
	  		$this->_html .= '<div class="bootstrap">
			<div class="alert alert-success">
				<button type="button" class="close" data-dismiss="alert">×</button>
				'.$toast.'
				</div>
			</div>';
			$this->_html .= exec('sudo git pull --rebase origin master');
	  		
	  	}
	  	$this->_displayForm();
	  	return $this->_html;
	}
	
	public function _displayForm()
	{
		$this->_html .= '<h1>Post Receive Update Module</h1>
						    <form action="'.$_SERVER['REQUEST_URI'].'" method="post">
	      					<label>'.$this->l('Update from Github').'</label>
	      					<div class="margin-form">
	        				<input type="submit" name="submit" value="'.$this->l('Submit').'" class="button" />
	      					</div>
	    				</form>';
	}
}




