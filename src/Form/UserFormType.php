<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class UserFormType extends AbstractType
{
    // public static function getSpecificUserForm(User $user): string
    // {
    //     return match(get_class()) {

    //         default => throw new \Exception(),
    //     };
    // }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $availableJobs = [
            'tester',
            'developer',
            'project_manager',
        ];
        
        $builder
            ->add('email')
            ->add('name')
            ->add('surname')
            ->add('description')
            ->add('job', ChoiceType::class, [
                'choices'  => array_combine($availableJobs, $availableJobs),
                'mapped' => false,
            ])
        ;
    }

    protected function configureForClass(string $dataClass, OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => $dataClass,
            'csrf_protection' => false,
        ]);
    }

    // public function configureOptions(OptionsResolver $resolver): void
    // {
    //     $resolver->setDefaults([
    //         'data_class' => User::class,
    //     ]);
    // }
}
