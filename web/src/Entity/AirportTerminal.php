<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\Airport;
use Doctrine\ORM\Mapping as ORM;

/**
 * AirportTerminal
 *
 * @ORM\Table(name="airport_terminal", uniqueConstraints={@ORM\UniqueConstraint(name="airport_id_label", columns={"label", "airport_id"})}, indexes={@ORM\Index(name="airport_terminal", columns={"airport_id"})})
 * @ORM\Entity
 */
class AirportTerminal
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false, options={"comment"="ID"})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="label", type="string", length=128, nullable=false, options={"comment"="Terminal Label"})
     */
    private $label;

    /**
     * @var \Airport
     *
     * @ORM\ManyToOne(targetEntity="Airport", inversedBy="terminals")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="airport_id", referencedColumnName="id", onDelete="CASCADE")
     * })
     */
    private $airport;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(string $label): self
    {
        $this->label = $label;

        return $this;
    }

    public function getAirport(): ?Airport
    {
        return $this->airport;
    }

    public function setAirport(?Airport $airport): self
    {
        $this->airport = $airport;

        return $this;
    }
}
