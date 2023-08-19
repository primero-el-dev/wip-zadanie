<?php

namespace App\Form;

use App\Entity\ProjectManager;
use App\Form\UserFormType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class ProjectManagerFormType extends UserFormType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        parent::buildForm($builder, $options);

        $builder
            ->add('projectManagementMethodologies')
            ->add('reportSystems')
            ->add('knowsScrum', CheckboxType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $this->configureForClass(ProjectManager::class, $resolver);
    }
}
