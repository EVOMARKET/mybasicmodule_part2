<?php
namespace Mybasicmodule\controller\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class CommentType extends AbstractType {
   
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /********************** */
        $builder
        ->add('name', TextType::class, array(
            "attr" =>array(
               "placeholder" =>"The name"
            )
        ))
        ->add('description', TextType::class, array(
            "attr" =>array(
                "placeholder" =>"The name"
                )
        ))
        ->add('price', NumberType::class, array(
           "attr" =>array(
                "placeholder" =>"[0-9]", "size=>10", "mapped"=>false 
                )
        ))
        ->add('save', SubmitType::class);
    }
}
