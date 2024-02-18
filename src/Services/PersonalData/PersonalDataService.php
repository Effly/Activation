<?php

namespace App\Services\PersonalData;

use App\Repository\ContractRepository;
use App\Services\Helper\JSONService;
use DateTime;

class PersonalDataService
{
    public function __construct(
        private readonly JSONService $JSONService,
        private readonly ContractRepository $contractRepository
    )
    {
    }

    public function save(string $number,array $formData): void
    {
        $contract = $this->contractRepository->findOneBy(['number'=>$number]);
        $formData['lifeTimeDay'] = (new DateTime('now'))->diff($contract->getLimitDate())->days;
        $formData['lifeTimeDate'] = $contract->getLimitDate()->format("Y-m-d");
        $formJson = json_encode($formData);
        $this->JSONService->createJsonFile($number,$formJson);
    }
}