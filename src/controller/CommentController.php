<?php 
namespace Mybasicmodule\Controller;

use Mybasicmodule\Entity\CommentTest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Mybasicmodule\Controller\Form\CommentType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use PrestaShopBundle\Controller\Admin\FrameworkBundleAdminController;
//use Symfony\Component\BrowserKit\Response;


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

   public function updateAction(int $id, Request $request) 
   {
    $em =$this->getDoctrine()->getManager();
    $data = $em-> getRepository(CommentTest::class)->find($id);
    $form = $this ->createForm(CommentType::class, $data) ;

    //handle the submission (skopiowane z góry)

    $form->handleRequest($request);
      if($form->isSubmitted() && $form->isValid()){
        $em = $this->getDoctrine()->getManager();

        //buildthe object
        $commantTest = new CommentTest();

        $commantTest->setName($form->get('name')->getData());
        $commantTest->setDescription($form->get('description')->getData());
        $commantTest->setprice($form->get('price')->getData());

          //$em->persist($commantTest);
          $em->flush();
          $this->addFlash("success", "The form has been submitted correctly");    
          
       // dump($data = $form->getData());
    
      }
      
    return $this ->render(
      "@Modules/mybasicmodule/views/templates/admin/update.html.twig",
    [
      "form"=> $form->createView(),
     
    ]
  );    
   }
   //public function deleteAction(Task $id)*******************************/
   public function deleteAction(CommentTest $id) 
   {
   $em =$this->getDoctrine()->getManager();
   
    $em->remove($id);
    $em->flush();
    return $this->redirectToRoute('blog_list');
   

   }

}