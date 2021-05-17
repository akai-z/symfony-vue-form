<?php

declare(strict_types=1);

namespace App\Form\Data;

use App\Entity\Airport as AirportEntity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;

class Airport extends ServiceEntityRepository
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
        $airports = $this->entityManager->getRepository(AirportEntity::class)->findAll();

        if (!$airports) {
            return [];
        }

        $options = [['value' => '', 'label' => '-Please Select-', 'disabled' => 'true']];

        foreach ($airports as $airport) {
            $options[] = ['value' => $airport->getId(), 'label' => $airport->getName()];
        }

        return $options;
    }
}
