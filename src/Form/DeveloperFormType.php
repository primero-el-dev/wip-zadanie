<?php

namespace App\Form;

use App\Entity\Developer;
use App\Form\UserFormType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class DeveloperFormType extends UserFormType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        parent::buildForm($builder, $options);
        
        $builder
            ->add('ideEnvironments')
            ->add('programmingLanguages')
            ->add('knowsMySQL', CheckboxType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $this->configureForClass(Developer::class, $resolver);
    }
}
