<?php

declare(strict_types=1);

namespace App\Validator;

use App\Entity\Airport;
use App\Validator\Airport as AirportConstraint;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class AirportValidator extends ConstraintValidator
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param \App\Entity\Booking $object
     */
    public function validate($object, Constraint $constraint)
    {
        if (!$constraint instanceof AirportConstraint) {
            throw new UnexpectedTypeException($constraint, AirportConstraint::class);
        }

        if ($object->getAirportName() === null || $object->getAirportName() === '') {
            return;
        }

        $airport = $this->entityManager->find(Airport::class, $object->getAirportName());

        if ($airport === null) {
            $this->addViolation('airportName', 'The aiport name is invalid');
            return;
        }

        $terminals = $airport->getTerminals()->getValues();
        if (!$terminals) {
            return;
        }

        $requestTerminal = $object->getAirportTerminal();
        if ($requestTerminal === null || $requestTerminal === '') {
            $this->addViolation('airportTerminal', 'The aiport terminal is required');
            return;
        }

        foreach ($airport->getTerminals() as $terminal) {
            if ($terminal->getId() == $requestTerminal) {
                return;
            }
        }

        $this->addViolation('airportTerminal', 'The aiport terminal is invalid');
    }

    private function addViolation(string $field, string $message): void
    {
        $this->context->buildViolation($message)->atPath($field)->addViolation();
    }
}
