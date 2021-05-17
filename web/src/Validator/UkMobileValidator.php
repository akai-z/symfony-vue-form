<?php

declare(strict_types=1);

namespace App\Validator;

use App\Validator\UkMobile;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;

class UkMobileValidator extends ConstraintValidator
{
    /**
     * @inheritDoc
     */
    public function validate($value, Constraint $constraint)
    {
        if (!$constraint instanceof UkMobile) {
            throw new UnexpectedTypeException($constraint, UkMobile::class);
        }

        if ($value === null || $value === '') {
            return;
        }

        if (!is_string($value)) {
            throw new UnexpectedValueException($value, 'string');
        }

        // https://regexlib.com/(X(1)A(4gXc20GThkvez8o3QlDYbmkwLNb87fdJUFS1r4_O3taz2ET5Fz6SmJVYVrVpPfloGGV33E3dzaO6cYVI_5VBP_w1WaKEkWRT7U7GRqyRoz86BliySp6bzCGNPRYKdTLNdnm5hcynoualneipivnm0g_xCNTvedyt23ne2jd2BZrFGDcOIqMem87Cud9Qn2o70))/REDetails.aspx?regexp_id=592
        // (This validation RegExp might be outdated for some of the mobile numbers currently used in the UK.)
        if (!preg_match('/^(\+44\s?7\d{3}|\(?07\d{3}\)?)\s?\d{3}\s?\d{3}$/i', $value, $matches)) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ string }}', $value)
                ->addViolation();
        }
    }
}
