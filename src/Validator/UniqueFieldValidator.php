<?php

namespace App\Validator;

use App\Traits\EntityManagerTrait;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class UniqueFieldValidator extends ConstraintValidator
{
    use EntityManagerTrait;

    public function validate($value, Constraint $constraint)
    {
        /* @var App\Validator\UniqueField $constraint */
        
        if (null === $value || '' === $value) {
            return;
        }

        $className = $this->context->getClassName();
        $property = $this->context->getPropertyName();
        $validatedObject = $this->context->getObject();
        $entityFromDb = $this->entityManager
            ->getRepository($className)
            ->findOneBy([$property => $value]);

        if ($entityFromDb && $validatedObject->getId() !== $entityFromDb->getId()) {
            $this->context
                ->buildViolation($constraint->message)
                ->setParameter('{{ value }}', $value)
                ->addViolation();
        }
    }
}
