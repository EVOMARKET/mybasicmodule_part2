<?php 
namespace Mybasicmodule\Controller;

use Mybasicmodule\Entity\CommentTest;
use Symfony\Component\HttpFoundation\Request;
use Mybasicmodule\Controller\Form\CommentType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use PrestaShopBundle\Controller\Admin\FrameworkBundleAdminController;

class CommentController extends FrameworkBundleAdminController
{
    public function indexAction(Request $request)
    {
       $form = $this->createForm(CommentType::class);
          $form->handleRequest($request);
      if($form->isSubmitted() && $form->isValid()){
        $em = $this->getDoctrine()->getManager();

        //buildthe object
        $commantTest = new CommentTest();

        $commantTest->setName("The name");
        $commantTest->setDescription("The description");
        $commantTest->setprice(99);

          $em->persist($commantTest);
          $em->flush();

       // dump($data = $form->getData());
       dump( $form->getData());
      }

      return $this ->render(
        "@Modules/mybasicmodule/views/templates/admin/comment.html.twig",
      [
        "test"=> 123,
        "form"=>$form->createView()
      ]
    );    
    }
}