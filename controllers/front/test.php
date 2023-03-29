<?php

//use GuzzleHttp\Event\AbstractEvent;

class MyBasicModuleTestModuleFrontController extends ModuleFrontController
{
    //GET
//POST

    public function initContent()
    {
        parent::initContent();
        $this->context->smarty->assign([
                'data' => "Hello mr Prestatshop",
            ]);
        
        $this->setTemplate("module:mybasicmodule/views/templates/front/test.tpl");
        
    }
    public function postProcess()
    {
        if (Tools::isSubmit('form')) {
            return Tools::redirect("URL");
        }
    }

}