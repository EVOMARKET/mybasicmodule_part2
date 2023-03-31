<?php
namespace Mybasicmodule\Controller\Form;

use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class CommentType extends AbstractType {
   
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        
        $builder
        ->add('task')
        ->add('dueDate', DateType::class)
        ->add('save', SubmitType::class);
    }
}
