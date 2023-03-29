<?php

Tools::checkPhpVersion();
require_once(_PS_MODULE_DIR_ .'mybasicmodule/classes/comment.class.php');
class AdminTestController extends ModuleAdminController
{
    /**lekcja 36 (koniec rodziału Admin controller)********************************** */
   /* public function initContent()
   {
        parent::initContent();
        $content = "Hello tu ziemia";
        $this->context->smarty->assign(
            array(
               // 'content' => $this->content.$content
               'content' =>$content
            )
        );
    }*/

    public function initContent()
    {
        parent::initContent();
        $content = $this->context->smarty->fetch(
            _PS_MODULE_DIR_ . 'mybasicmodule/views/templates/admin/configuration2.tpl'
        );
        $this->context->smarty->assign(
            [
                'content'=>$content
            ]
        );
    }
    /***********************************koniec lekcji 35 */
    public function __construct()
    {
        $this->table = 'testcomment';
        $this->className = 'CommentTest';
        $this->identifier = CommentTest::$definition['primary'];
        $this->bootstrap = true;

        $this->fields_list = [
            'id_sample' => [
                'title' => 'The id',
                'align' => 'left'
            ],
            'user_id'=>[
                'title'=>'The user id',
                'align'=> 'left',
            ],
            'comment'=>[
                'title'=>'The comment',
            ]
            ];
            $this->addRowAction('edit');
            $this->addRowAction('delete');
            $this->addRowAction('view');
        parent::__construct();
    }
    public function renderForm()
    {
        $this->fields_form= [
            'legend'=>[
                'title'=>'Nowy komentarz',
                'icon'=>'icon-cog'
            ],
            'input'=>[
                [
                'type'=>'text',
                'label'=>'The user id',
                'name'=>'user_id',
                'class'=>'input fixed-with-sm',
                'required'=>true,
                'empty_message'=>'Please fill the input'
                ],
                [
                    'type'=>'text',
                    'label'=>'The comment',
                    'name'=>'comment',
                    'class'=>'input fixed-with-sm',
                    'required'=>true,
                    'empty_message'=>'Please fill the input' 
                
                ]
                ],
            
           
                'submit'=>[
                    'title'=>'Submit a comment'
                ]
                ];
                
        
            return parent::renderForm();
    }
    public function renderView(){
        $tplFile = dirname(__FILE__) . '/../../views/templates/admin/view.tpl';
        $tpl = $this->context->smarty->createTemplate($tplFile);
        //fetch data
        $sql = new DbQuery();
      echo  $sql->select(`*`)
            ->from($this->table)
            ->where('id_sample =  '. Tools::getValue('id_sample'));

            $data = Db::getInstance()->executeS($sql);
            print_r($data);
            //assign vars
        $tpl->assign(
            [
                'data'=> $data['0']
            ]
            );
       return $tpl->fetch();
       
    }
}

