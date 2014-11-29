<?php

if (!defined('_PS_VERSION_'))
    exit;

class khaasDaysModuleFrontController extends ModuleFrontController
{

	public function __construct()
	{
	    parent::__construct();
	    $this->context = Context::getContext();
	    
	}
	
	public function init()
	{
		$this->page_name = 'khaasdays'; // page_name and body id
		$this->display_column_left = TRUE;
		//$this->display_column_right = TRUE;
	    parent::init();
	}
	
	public function initContent()
	{
	    parent::initContent();
		$products_count = $this->module->countAllProducts();
		$this->pagination($products_count);
		$products = $this->module->getActiveProducts();/*
	    $products_partial = Product::getProducts($this->context->language->id, ((int)$this->p - 1) * (int)$this->n, $this->n, 'name', 'asc'); 
		$products = Product::getProductsProperties($this->context->language->id, $products_partial);
		/* Retrieving product images *//*
 
		foreach ($products as $key => $product) {
    		foreach ($products as $key => $product) {
	        	$products[$key]['id_image'] = Product::getCover($product['id_product'])['id_image'];
		    }
		}*/
		$this->context->smarty->assign(array(
			'products' => $products,
			'homeSize' => ImageCore::getSize('home_default')
		));
		$this->setTemplate('days.tpl');
	}
	
	public function setMedia()
	{
	    parent::setMedia();
	    $this->addCSS(__PS_BASE_URI__.'modules/'.$this->module->name.'/css/'.$this->module->name.'.css');
		$this->context->controller->addJS(__PS_BASE_URI__.'modules/'.$this->module->name.'/js/'.$this->module->name.'.js');
	}   
}
