<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Airport;
use App\Entity\AirportTerminal;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $airports = $this->loadAirports($manager);
        $this->loadAirportOptions($manager, $airports);
    }

    private function loadAirports(ObjectManager $manager): array
    {
        $loadedAirports = [];

        foreach ($this->airportsData() as $airportName) {
            $airport = new Airport();
            $airport->setName($airportName);

            $manager->persist($airport);

            $loadedAirports[$airportName] = $airport;
        }

        $manager->flush();

        return $loadedAirports;
    }

    private function loadAirportOptions(ObjectManager $manager, array $airports): void
    {
        $airportOptions = $this->airportOptionsData();

        foreach ($airports as $airportName => $airport) {
            if (!isset($airportOptions[$airportName])) {
                continue;
            }

            foreach ($airportOptions[$airportName] as $airportOptionLabel) {
                $airportOption = new AirportTerminal();
                $airportOption->setLabel($airportOptionLabel);
                $airportOption->setAirport($airport);

                $manager->persist($airportOption);
            }
        }

        $manager->flush();
    }

    private function airportsData(): array
    {
        return ['Heathrow', 'Gatwick'];
    }

    private function airportOptionsData(): array
    {
        return [
            'Heathrow' => ['1', '2', '3', '4', 'not sure']
        ];
    }
}
