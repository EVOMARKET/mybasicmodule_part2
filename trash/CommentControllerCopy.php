<?php 
namespace src\controller;


use PrestaShopBundle\Controller\Admin\FrameworkBundleAdminController;



class CommentController extends FrameworkBundleAdminController
{
    public function indexAction(Request $request)
    {
       $form = $this->createForm(CommentType::class);
       
     /*  $form->handleRequest($request);
      if($form->isSubmitted() && $form->isValid()){
        $em = $this->getDoctrine()->getManager();

        //buildthe object
        $commantTest = new CommentTest();

        $commantTest->setNme("The name");
        $commantTest->setDescription("The description");
        $commantTest->setprice(99);

          $em->persist($Entity);
          $em->flush();

        dump($data = $form->getData());
      }*/
      return $this ->render(
        "@Modules/mybasicmodule/views/templates/admin/comment.html.twig",
      [
        "test"=> 123,
        "form"=>$form->createView()
      ]
    );    
    }
}
