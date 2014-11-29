<?php

if (!defined('_PS_VERSION_'))
    exit;

class khaas extends Module
{
    /* @var boolean error */
    protected $_errors = false;
	private $_html = '';
	
    public function __construct()
    {
        $this->name = 'khaas';
        $this->tab = 'front_office_features';
        $this->version = '1.0.0';
        $this->author = 'Jaideep Bhoosreddy';
        $this->need_instance = 0;

        parent::__construct();
		$this->context = Context::getContext();
        $this->displayName = $this->l('Khaas Module');
        $this->description = $this->l('Adds a block.');
	$this->confirmUninstall = $this->l('Are you sure you want to delete this module?');
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
	  		$toast = "";
	  		if(Tools::getValue('type') == 'add') {
	  			$this->addProduct(Tools::getValue('product'));
	  			$toast = "Product added successfully.";
	  		}
			elseif(Tools::getValue('type') == 'remove') {
				$this->removeProduct(Tools::getValue('id_product'));
				$toast = "Product removed successfully.";
			}
	  		$this->_html .= '<div class="bootstrap">
		<div class="alert alert-success">
			<button type="button" class="close" data-dismiss="alert">×</button>
			'.$toast.'
		</div>
	</div>';
	  		
			
	    	//Configuration::updateValue($this->name.'_message', Tools::getValue('our_message'));
	  	}
	  	$this->_displayForm();
	  	return $this->_html;
	}
	
	public function _displayForm()
	{
		$_options = "";
		$products_count = $this->countAllProducts();
		//$this->_html .= "Product Count : ".$products_count.'<br>';
		$products = Product::getProducts($this->context->language->id, 0, $products_count, 'name', 'asc');
		$ids = $this->getProducts();
		$id_list = array();
		foreach ($ids as $id) {
			array_push($id_list, $id['id_product']);
		}
		$activeBool = "";
		foreach ($products as $product) {
			if($this->isActiveProduct($product['id_product'], $id_list)) {
				$activeBool = "disabled";
			}
			else {
				$activeBool = "";
			}
			$_options .= '<option value="'.$product['id_product'].'" '.$activeBool.'>'.$product['name'].'</option>';
		}
		//$this->_html .= serialize($products);
		$this->_html .= '<h1>Khaas Modules</h1>
						<hr><h2>Khaas Days</h2>
							<h3>Product List</h3>
						    <form action="'.$_SERVER['REQUEST_URI'].'" method="post">
	      					<label>'.$this->l('Select Product').'</label>
	      					<div class="margin-form">
	        				<select name="product">'.$_options.'</select>
	      					</div>
	      					<input type="hidden" name="type" value="add" />
	      					<input type="submit" name="submit" value="'.$this->l('Submit').'" class="button" />
	    				</form>';
		
		$active = $this->getProducts();
		//$this->_html .= serialize($active);
		$this->_html .= '<h3>Active Products</h3><ol>';
		foreach ($active as $product) {
			$this->_html .= '<li><form action="'.$_SERVER['REQUEST_URI'].'" method="post"><input type="hidden" name="type" value="remove" />
			<input type="hidden" name="id_product" value="'.$product['id_product'].'" />
			<input type="submit" name="submit" value="'.$this->l('Remove').'" class="button" /><b>&nbsp&nbsp'.ProductCore::getProductName($product['id_product']).'</b></li></form>';
		}
		$this->_html .= '</ol>';
	}
	
	public function countAllProducts()
	{
    	return Db::getInstance()->getValue('SELECT COUNT(*) from ps_product');
	}
	
	public function addProduct($id)
	{
		$data = array('id_product' => (int)$id);
		return Db::getInstance()->execute('INSERT INTO `ps_khaas_days` (`id_product`) VALUES ("'.$id.'")');
		//return Db::getInstance()->insert('ps_khaas_days', $data);
	}

	public function removeProduct($id)
	{
		$data = array('id_product' => (int)$id);
		return Db::getInstance()->execute('DELETE FROM `ps_khaas_days` WHERE `id_product` = '.$id);
	}
	
	public function getProducts()
	{
		return Db::getInstance()->executeS('SELECT * FROM `ps_khaas_days` ');
	}
	
	public function getActiveProducts()
	{
		$ids = $this->getProducts();
		$id_list = array();
		foreach ($ids as $id) {
			array_push($id_list, $id['id_product']);
		}
		
		$products_partial = Product::getProducts($this->context->language->id, ((int)$this->p - 1) * (int)$this->n, $this->n, 'name', 'asc'); 
		$products = Product::getProductsProperties($this->context->language->id, $products_partial);
		/* Retrieving product images */
 
		foreach ($products as $key => $product) {
    		foreach ($products as $key => $product) {
	        	$products[$key]['id_image'] = Product::getCover($product['id_product'])['id_image'];
		    }
		}
		$active_product = array();
		foreach ($products as $product) {
			if($this->isActiveProduct($product['id_product'], $id_list)) {
				array_push($active_product, $product);
			}
		}
		return $active_product;
	}
	
	public function isActiveProduct($id, $ids)
	{
		if(in_array($id, $ids)) {
			return TRUE;
		}
		else {
			return FALSE;
		}
	}
}




