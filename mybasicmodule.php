<?php
/**
* 2007-2022 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author    PrestaShop SA <contact@prestashop.com>
*  @copyright 2007-2022 PrestaShop SA
*  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/



if (!defined('_PS_VERSION_')) {
    exit;
}
//use Language;
use PrestaShop\PrestaShop\Core\Module\WidgetInterface;

class MyBasicModule extends Module implements WidgetInterface
{
    public $name;
    public $templateFile;
    public $version;
    public $autor;
    public $need_instance;
    public $ps_version_compilancy;
    public $bootstrap;
    public $displayName;
    public $description;
    public $confirmrUninstall;
    public $parent;
  
    
    public function __construct()
    {
        $this->name = "mybasicmodule";
        $this->tab = "front_office_features";
        $this->version = "1.0";
        $this->autor = "Grzegorz Hys";
        $this->need_instance = 0;
        $this->ps_version_compilancy = [
            "min" => "1.6",
            "max" => _PS_VERSION_
        ];
        $this->bootstrap = true;

        parent::__construct();

        $this->displayName = $this->l("My very first module");
        $this->description = $this->l("This is a great testing module");
        $this->confirmrUninstall = $this->l("Aru you crayzy, you are going to unistall a grat module ?");
        $this->templateFile = "module:mybasicmodule/views/templates/hook/footer.tpl";
        $this->templateFile = "module:mybasicmodule/views/templates/hook/firstFooter.tpl";
    }
   
    public function install()
    {
        if (Shop::isFeatureActive()) {
            Shop::setContext(Shop::CONTEXT_ALL);
        }
        return(
        parent::install()&&
        $this->sqlInstall()&&
        $this->installTab()&&
    
        $this->registerHook('registerGDPRConsent')&&
        $this->registerHook('displayCheckoutSubtotalDetails')&&
        $this->registerHook('moduleRoutes')
        );
    }
    //uninstall method 
    public function uninstall(): Bool
    {
        if(
            !$this->sqlUninstall()  ||  !$this->uninstalltab()
        )
        {
            return false;
        } 
        if(
            !parent::uninstall()
        )
        {
            return false;
        }  
        return true; 
        
    }
 
    protected function sqlInstall() {
    //sql query to create database table
       
        $sqlCreate = "CREATE TABLE IF NOT EXISTS `" . _DB_PREFIX_ . "testcomment` (
            `id_sample` int(11) unsigned NOT NULL AUTO_INCREMENT,
            `user_id` varchar(255) DEFAULT NULL,
            `comment` varchar(255) DEFAULT NULL,
            PRIMARY KEY (`id_sample`)     
      )  ENGINE=InnoDb DEFAULT CHARSET=UTF8;";
          
        return Db::getInstance()->execute($sqlCreate);  
    }
    

    protected function sqlUninstall()
    {
        $sqldrop = "DROP TABLE IF EXISTS  `" . _DB_PREFIX_ . "testcomment`";
        return Db::getInstance()->execute($sqldrop);
    }

    public function installtab() {
        $tab = new Tab();
        $tab->active = 1;
        $tab->class_name= 'AdminTest';
        $tab->position = 3;
        $tab->name = array();
        foreach (Language::getLanguages(true) as $lang) {
        $tab->name[$lang['id_lang']] = 'Mój pierwszy moduł';
        }
        $tab->id_parent = (int) Tab::getIdFromClassName('DEFAULT');
        $tab->module = $this->name;
        $tab->add();
        $tab->save();

        try {
            $tab->save();
        } catch(Exception $e) {
            echo $e->getMessage();
            return false;
        }
    }
    private function uninstalltab(){
        $idTab = (int)Tab::getIdFromClassName('AdminTest');

        if($idTab){
            $tab = new Tab($idTab);
            try {
                $tab->delete();
            } catch(Exeption $e){
                echo $e->getMessage();
                return false;
            }
        }
        return true;
    }
  
    public function renderWidget($hookName , array $configuration)
    {    
        echo $this->context->link->getModuleLink($this->name, "test");

        if($hookName === 'displayNavFullWidth'){
            return "Hello this is an exception form the displayNavFullWidth !";
        }
        if(!$this->isCached($this->templateFile, $this->getCacheId($this->name))){
        $this->context->smarty->assign($this->getWidgetVariables($hookName, $configuration));
        }
        return $this->fetch("module:mybasicmodule/views/templates/hook/footer.tpl");
    }

    public function getWidgetVariables($hookName, array $configuration)
    {   
        return [
            'idcart'=> $this->context->cart->id,
            'myparamtest' => "Prestashop developer",
        ];
    }
    public function getContent()
    {
        $output = "";
        if(Tools::isSubmit('submit' . $this->name)) {
            $courserating = Tools::getValue('courserating');

            if($courserating && !empty($courserating) && Validate::isGenericName($courserating))
            {
            Configuration::updateValue('COURSE_RATING', Tools::getValue("courserting"));
            $output .= $this->displayConfirmation($this->trans('Form submitted succesfully!'));
            }
            else {
                $output .= $this->displayError($this->trans('Form has not been submitted succesfully!'));
            }
        }
        return $output . $this->displayForm() ;
    }
    
        public function displayForm()
        {
           $defaultLang =(int) Configuration::get('PS_LANG_DEFAULT');
                //form inputs
            $fields[0]['form'] = [
                'legend' => [
                    'title' => $this->trans('Rating setting')
                ],
                'input' => [
                    [
                        'type' => 'text',
                        'label' => $this->l('Course rating'),
                        'name' => 'courserating',
                        'size' => 20,
                        'required' => true
                    ]
                ],
                'submit' => [
                    'title' => $this->trans('Save the rating'),
                    'class' => 'btn btn-primary pull-right'
    
                ]
            ];
    
            //instance of the FH
            $helper = new HelperForm();
            $helper->module = $this;
            $helper->name_controller = $this->name;
            $helper->token = Tools::getAdminTokenLite("AdminModules");
            $helper->currentIndex = AdminController::$currentIndex . '&configure=' . $this->name;
    
            //Lanuage
            $helper->default_form_language = $defaultLang;
            $helper->allow_employee_form_lang = $defaultLang;
    
            //Title an toolbar 
            $helper->title = $this->displayName;
            $helper->show_toolbar = true;   //false -> remove toolbar
            $helper->toolbar_croll = true;  //yes ->toolbar is always visible on the top of the screen.
            $helper->submit_action = 'submit' . $this->name;
            $helper->toolbar_btn = [
                'save' => [
                    'desc' => $this->l('Save'),
                    'href' => AdminController::$currentIndex . '&configure=' . $this->name . '&save' . $this->name,
                    '&token=' . Tools::getAdminTokenLite('AdminModules'),
                ],
                'back' => [
                    'href' => AdminController::$currentIndex . '&token=' . Tools::getAdminTokenLite('AdminModules'),
                    'desc' => $this->l('Back to list'),
                ]
            ];
            $helper->fields_value['courserating'] = Configuration::get('COURSE_RATING');
                    return $helper->generateForm($fields);
    
        }
    //hookModuleRoutes
    public function hookModuleRoutes($params)
      {
        return [
            'test' =>[
                'controller'=> 'test',
                'rule'=> "fc-test",
                'keywords'=> [],
                'params'=> [
                    'module'=> $this->name,
                    'fc'=> 'module',
                    'controller'=> 'test'
                ]
                ]
                ];              
            }

}