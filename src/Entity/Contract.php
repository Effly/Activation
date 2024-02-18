<?php

namespace App\Entity;

use App\Repository\ContractRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ContractRepository::class)]
class Contract
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $number = null;

    #[ORM\Column(length: 255)]
    private ?string $pin = null;

    #[ORM\OneToOne(mappedBy: 'contract', cascade: ['persist', 'remove'])]
    private ?PersonalData $personalData = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $limitDate = null;

    #[ORM\OneToOne(mappedBy: 'contract', cascade: ['persist', 'remove'])]
    private ?Product $product = null;

    #[ORM\Column]
    private ?bool $IsPay = null;

    #[ORM\Column(nullable: true)]
    private ?float $cost = null;

    #[ORM\Column(nullable: true)]
    private ?float $amountOfInsurance = null;

    #[ORM\Column]
    private ?int $periodDay = null;

    #[ORM\Column]
    private ?bool $isActive = false;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumber(): ?string
    {
        return $this->number;
    }

    public function setNumber(string $number): static
    {
        $this->number = $number;

        return $this;
    }

    public function getPin(): ?string
    {
        return $this->pin;
    }

    public function setPin(string $pin): static
    {
        $this->pin = $pin;

        return $this;
    }

    public function getPersonalData(): ?PersonalData
    {
        return $this->personalData;
    }

    public function setPersonalData(?PersonalData $personalData): static
    {
        // unset the owning side of the relation if necessary
        if ($personalData === null && $this->personalData !== null) {
            $this->personalData->setContract(null);
        }

        // set the owning side of the relation if necessary
        if ($personalData !== null && $personalData->getContract() !== $this) {
            $personalData->setContract($this);
        }

        $this->personalData = $personalData;

        return $this;
    }

    public function getLimitDate(): ?\DateTimeInterface
    {
        return $this->limitDate;
    }

    public function setLimitDate(\DateTimeInterface $limitDate): static
    {
        $this->limitDate = $limitDate;

        return $this;
    }

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(Product $product): static
    {
        // set the owning side of the relation if necessary
        if ($product->getContract() !== $this) {
            $product->setContract($this);
        }

        $this->product = $product;

        return $this;
    }

    public function isPay(): ?bool
    {
        return $this->IsPay;
    }

    public function setIsPay(bool $IsPay): static
    {
        $this->IsPay = $IsPay;

        return $this;
    }

    public function getCost(): ?float
    {
        return $this->cost;
    }

    public function setCost(?float $cost): static
    {
        $this->cost = $cost;

        return $this;
    }

    public function getAmountOfInsurance(): ?float
    {
        return $this->amountOfInsurance;
    }

    public function setAmountOfInsurance(?float $amountOfInsurance): static
    {
        $this->amountOfInsurance = $amountOfInsurance;

        return $this;
    }

    public function getPeriodDay(): ?int
    {
        return $this->periodDay;
    }

    public function setPeriodDay(int $periodDay): static
    {
        $this->periodDay = $periodDay;

        return $this;
    }

    public function isActive(): ?bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): static
    {
        $this->isActive = $isActive;

        return $this;
    }
}
