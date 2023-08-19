<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;
use Attribute;

/**
 * @Annotation
 *
 * @Target({"PROPERTY"})
 */
#[Attribute(Attribute::TARGET_PROPERTY)]
class UniqueField extends Constraint
{
    public function __construct(
        public string $message = 'The value is taken. Please choose another.',
        mixed $options = null, 
        array $groups = null, 
        mixed $payload = null,
    ) {
        parent::__construct($options, $groups, $payload);
    }
}
