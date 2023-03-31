<?php 
namespace Mybasicmodule\Controller;


use Mybasicmodule\Controller\Form\CommentType;
use PrestaShopBundle\Controller\Admin\FrameworkBundleAdminController;


class CommentController extends FrameworkBundleAdminController
{
    public function indexAction()
    {
       $form = $this->createForm(CommentType::class);
       

      return $this ->render(
        "@Modules/mybasicmodule/views/templates/admin/comment.html.twig",
      [
        "test"=> 123,
        "form"=>$form->createView()
      ]
    );    
    }
}
