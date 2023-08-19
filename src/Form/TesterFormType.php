<?php

namespace App\Form;

use App\Entity\Tester;
use App\Form\UserFormType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class TesterFormType extends UserFormType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        parent::buildForm($builder, $options);
        
        $builder
            ->add('testingSystems')
            ->add('reportSystems')
            ->add('knowsSelenium', CheckboxType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $this->configureForClass(Tester::class, $resolver);
    }
}
