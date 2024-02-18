<?php

namespace App\Command;

use App\Entity\Token;
use App\Repository\TokenRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:create-token',
    description: 'generate or re-generate token',
)]
class CreateTokenCommand extends Command
{
    public function __construct(
        private readonly EntityManagerInterface $em,
        private readonly TokenRepository $repository
    )
    {
        parent::__construct();
    }


    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $generatedToken = '';

        for ($i = 0; $i < 32; $i++) {
            $generatedToken .= $characters[rand(0, strlen($characters) - 1)];
        }

        $token = $this->repository->find(1);

        if (is_null($token)){
            $token = new Token();
        }

        $token->setValue($generatedToken);
        $this->em->persist($token);
        $this->em->flush();

        $io->success('Token success created');

        return Command::SUCCESS;
    }
}
