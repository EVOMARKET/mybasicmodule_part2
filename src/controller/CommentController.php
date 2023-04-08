<?php 
namespace Mybasicmodule\Controller;

use Mybasicmodule\Entity\CommentTest;
use Symfony\Component\HttpFoundation\Request;
use Mybasicmodule\Controller\Form\CommentType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use PrestaShopBundle\Controller\Admin\FrameworkBundleAdminController;
//use Symfony\Component\BrowserKit\Response;
use Symfony\Component\HttpFoundation\Response;


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

        $commantTest->setName($form->get('name')->getData());
        $commantTest->setDescription($form->get('description')->getData());
        $commantTest->setprice($form->get('price')->getData());

          $em->persist($commantTest);
          $em->flush();
          $this->addFlash("success", "The form has been submitted correctly");
          $this->addFlash("error", "ERROR === The form has been submitted correctly");
          $this->addFlash("success", "500 === The form has been submitted correctlyy");

       // dump($data = $form->getData());
    
      }

      return $this ->render(
        "@Modules/mybasicmodule/views/templates/admin/comment.html.twig",
      [
        "test"=> 123,
        "form"=>$form->createView()
      ]
    );    
    }

   public function listAction()
   {
    //$em =$this->getDoctrine()->getRepository(CommentTest::class)->findAll();
    //dump($em);
    $em =$this->getDoctrine()->getManager();
    $data = $em-> getRepository(CommentTest::class)->findAll();
    //$form = $this ->createForm(CommentType::class, $data) ;
    return $this ->render(
      "@Modules/mybasicmodule/views/templates/admin/listing.html.twig",
    [
      "data"=> $data,
     
    ]
  );    
   }
}