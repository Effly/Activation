<?php

namespace App\Services\Contract;

use App\Entity\Contract;
use App\Entity\Product;
use App\Repository\ContractRepository;
use App\Repository\ProductRepository;
use App\Services\Helper\JSONService;
use Doctrine\ORM\EntityManagerInterface;

class ContractService
{
    public function __construct(
        private readonly JSONService            $JSONService,
        private readonly ContractRepository     $contractRepository,
        private readonly EntityManagerInterface $em,
        private readonly ProductRepository      $productRepository
    )
    {
    }

    public function create(
        string  $number,
        string  $pin,
        ?bool    $isPay,
        ?float  $cost,
        string  $limitDate,
        int     $periodDay,
        ?float  $amount,
        ?string $productCode
    ): void
    {
        $contract = new Contract();
        $contract->setNumber($number);
        $contract->setPin($pin);
        $contract->setIsPay($isPay);
        $contract->setCost($cost);
        $contract->setLimitDate(new \DateTime($limitDate));
        $contract->setPeriodDay($periodDay);
        $contract->setAmountOfInsurance($amount);
        $this->em->persist($contract);

        $product = $this->productRepository->findOneBy(['code' => $productCode]);
        if (is_null($product)) {
            $product = new Product();
            $product->setName(null);
            $product->setCode($productCode);
            $this->em->persist($product);
        }
        $contract->setProduct($product);

        $this->em->flush();
    }

    public function saveFile(string $number, string $personalData): void
    {
        $this->JSONService->createJsonFile($number, $personalData);
    }

    public function findByNumberAndPin(string $number, string $pin): bool
    {
        return empty($this->contractRepository->findByNumberAndPin($number, $pin));
    }

    public function activate(string $number): void
    {
        $contract = $this->contractRepository->findOneBy(['number' => $number]);
        $contract->setIsActive(true);
        $this->em->flush();
    }
}