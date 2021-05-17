<?php

declare(strict_types=1);

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class AirlineCode extends Constraint
{
    /**
     * @inheritDoc
     */
    public $message = 'The airflight number "{{ string }}" is invalid';
}
