<?php

namespace App\Controller;

use App\Form\Request\NewContractRequest;
use App\Form\Type\AuthType;
use App\Form\Type\PersonalDataType;
use App\Repository\ContractRepository;
use App\Repository\TokenRepository;
use App\Services\Contract\ContractService;
use App\Services\PersonalData\PersonalDataService;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route(path: '/contract', name: 'contract_')]
class ContractController extends AbstractController
{
    public function __construct(
        private readonly ContractService     $contractService,
        private readonly PersonalDataService $personalDataService,
        private readonly TokenRepository     $repository,
        private readonly ContractRepository  $contractRepository
    )
    {
    }

    #[Route(path: '/activate', name: 'activate')]
    public function activate(Request $request): Response
    {
        $errors = [];
        $form = $this->createForm(AuthType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $formData = $form->getData();
            $number = $formData['number'];
            $pin = $formData['pin'];

            if (!$this->contractService->findByNumberAndPin($number, $pin)) {

                $contract = $this->contractRepository->findOneBy(['number' => $number, 'pin' => $pin]);
                if (!$contract || $contract->isActive()) {
                    $errors['isActivated'] = 'Договор уже активирован';
                    return $this->render('auth.html.twig', [
                        'form' => $form->createView(),
                        'errors' => $errors,
                    ]);
                }

                if (!$contract || $contract->getLimitDate() < new DateTime('now')) {
                    $errors['isActivated'] = 'Договор невозможно активировать, потому что превышена предельная дата активации';
                    return $this->render('auth.html.twig', [
                        'form' => $form->createView(),
                        'errors' => $errors,
                    ]);
                }

                return $this->redirectToRoute('contract_activate_by_link', [
                    'number' => $number,
                    'pin' => $pin,
                ]);
            } else {
                $errors['notFound'] = "Договора с номером $number не существует";
            }
        }

        return $this->render('auth.html.twig', [
            'form' => $form->createView(),
            'errors' => $errors,
        ]);
    }


    #[Route(path: '/activate-by-link/{number}/{pin}', name: 'activate_by_link')]
    public function activateLink(string $number, string $pin, Request $request): Response
    {
        $errors = [];
        $form = $this->createForm(PersonalDataType::class);
        $form->handleRequest($request);

        $contract = $this->contractService->findByNumberAndPin($number, $pin);

        if ($contract) {
            $errors['notFound'] = "Договора с номером $number не существует";
        } elseif ($form->isSubmitted() && $form->isValid()) {
            $this->personalDataService->save($number, $form->getData());
            $this->contractService->activate($number);
            return $this->render('success.html.twig');
        }

        return $this->render('personal-data-form.html.twig', [
            'form' => $form->createView(),
            'errors' => $errors,
        ]);
    }

    #[Route(path: '/new', name: 'new', methods: ['POST'])]
    public function newAction(Request $request): JsonResponse
    {
        if (is_null($this->repository->findOneBy(['value' => $request->headers->get('authorization')]))) {
            return new JsonResponse(status: 401);
        }

        $form = $this->createForm(NewContractRequest::class);
        $form->submit(json_decode($request->getContent(), true));
        $errors = [];
        if ($form->isSubmitted() && $form->isValid()) {
            $this->contractService->create(
                $form->getData()['number'],
                $form->getData()['pin'],
                isset($form->getData()['isPay']) ? $form->getData()['isPay'] : null,
                isset($form->getData()['cost']) ? $form->getData()['cost'] : null,
                isset($form->getData()['limitDate']) ? $form->getData()['limitDate'] : null,
                isset($form->getData()['periodDay']) ? $form->getData()['periodDay'] : null,
                isset($form->getData()['amount']) ? $form->getData()['amount'] : null,
                isset($form->getData()['productCode']) ? $form->getData()['productCode'] : null,
            );
            return new JsonResponse('ok');
        }

        foreach ($form->getErrors(true) as $error) {
            $errors[] = $error->getMessage();
        }

        return new JsonResponse(['error' => $errors], 500);
    }
}