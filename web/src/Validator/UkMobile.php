<?php

declare(strict_types=1);

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class UkMobile extends Constraint
{
    /**
     * @inheritDoc
     */
    public $message = 'The mobile number "{{ string }}" is invalid';
}
