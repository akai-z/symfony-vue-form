<?php

declare(strict_types=1);

namespace App\Form\Data;

use App\Entity\AirportTerminal as AirportTerminalEntity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;

class AirportTerminal extends ServiceEntityRepository
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function getOptions(): array
    {
        $terminals = $this->entityManager->getRepository(AirportTerminalEntity::class)->findAll();
        $options = [];

        foreach ($terminals as $terminal) {
            $options[$terminal->getAirport()->getId()][] = [
                'value' => $terminal->getId(),
                'label' => $terminal->getLabel()
            ];
        }

        foreach ($options as &$option) {
            array_unshift($option, ['value' => '', 'label' => '-Please Select-', 'disabled' => 'true']);
        }

        return $options;
    }
}
