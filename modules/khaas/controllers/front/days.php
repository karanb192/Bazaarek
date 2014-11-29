<?php
class khaasDaysModuleFrontController extends ModuleFrontController
{

public function __construct()
{
    parent::__construct();
    $this->context = Context::getContext();
    
}

}
