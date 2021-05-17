<?php

declare(strict_types=1);

namespace App\Entity;

use App\Validator as BookingAssert;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Booking
 *
 * @ORM\Table(name="booking", uniqueConstraints={@ORM\UniqueConstraint(name="mobile_date_of_arrival", columns={"mobile", "date_of_arrival"}), @ORM\UniqueConstraint(name="mobile_airflight_number", columns={"mobile", "airflight_number"})}, indexes={@ORM\Index(name="airport", columns={"airport_name"}), @ORM\Index(name="mobile", columns={"mobile"}), @ORM\Index(name="customer_name", columns={"customer_name"})})
 * @ORM\Entity
 * @BookingAssert\Airport
 * @UniqueEntity(
 *     fields={"mobile", "dateOfArrival"},
 *     errorPath="dateOfArrival",
 *     message="The date of arrival is already registered"
 * )
 * @UniqueEntity(
 *     fields={"mobile", "airflightNumber"},
 *     errorPath="airflightNumber",
 *     message="The airflight number is already registered"
 * )
 */
class Booking
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
     * @ORM\Column(name="customer_name", type="string", length=128, nullable=false, options={"comment"="Customer Name"})
     * @Assert\NotBlank
     */
    private $customerName;

    /**
     * @var string
     *
     * @ORM\Column(name="mobile", type="string", length=128, nullable=false, options={"comment"="Mobile Number"})
     * @Assert\NotBlank
     * @BookingAssert\UkMobile
     */
    private $mobile;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_of_arrival", type="datetime", nullable=false, options={"comment"="Date of Arrival"})
     * @Assert\NotBlank
     */
    private $dateOfArrival;

    /**
     * @var string
     *
     * @ORM\Column(name="airport_name", type="string", length=128, nullable=false, options={"comment"="Airport Name"})
     * @Assert\NotBlank
     */
    private $airportName;

    /**
     * @var string|null
     *
     * @ORM\Column(name="airport_terminal", type="string", length=128, nullable=true, options={"comment"="Airport Terminal"})
     */
    private $airportTerminal;

    /**
     * @var string
     *
     * @ORM\Column(name="airflight_number", type="string", length=128, nullable=false, options={"comment"="Airflight Number"})
     * @Assert\NotBlank
     * @BookingAssert\AirlineCode
     */
    private $airflightNumber;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCustomerName(): ?string
    {
        return $this->customerName;
    }

    public function setCustomerName(string $customerName): self
    {
        $this->customerName = $customerName;

        return $this;
    }

    public function getMobile(): ?string
    {
        return $this->mobile;
    }

    public function setMobile(string $mobile): self
    {
        $this->mobile = $mobile;

        return $this;
    }

    public function getDateOfArrival(): ?DateTimeInterface
    {
        return $this->dateOfArrival;
    }

    public function setDateOfArrival(?DateTimeInterface $dateOfArrival): self
    {
        $this->dateOfArrival = $dateOfArrival;

        return $this;
    }

    public function getAirportName(): ?string
    {
        return $this->airportName;
    }

    public function setAirportName(string $airportName): self
    {
        $this->airportName = $airportName;

        return $this;
    }

    public function getAirportTerminal(): ?string
    {
        return $this->airportTerminal;
    }

    public function setAirportTerminal(?string $airportTerminal): self
    {
        $this->airportTerminal = $airportTerminal;

        return $this;
    }

    public function getAirflightNumber(): ?string
    {
        return $this->airflightNumber;
    }

    public function setAirflightNumber(string $airflightNumber): self
    {
        $this->airflightNumber = $airflightNumber;

        return $this;
    }


}
