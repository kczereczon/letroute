<?php

namespace App\Command;

use App\Repository\UserRepository;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'user:create-new',
    description: 'Command creates the new user',
)]
class UserCreateNewCommand extends Command
{
    public function __construct(private readonly UserRepository $userRepository)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('email', InputArgument::REQUIRED, 'This is the email of the user')
            ->addArgument('password', null, InputArgument::OPTIONAL, 'Optional password of the user')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $email = $input->getArgument('email');

        if (!$email) {
            $io->error("Email is required");
        }

        $io->writeln("We are going to create a new user with email: $email");

        $user = $this->userRepository->findOneBy(['email' => $email]);

        if($user) {
            $io->error("User with email $email already exists");
            return Command::FAILURE;
        }

        $password = $io->askHidden("Please enter the password for the user", function($password) {
            if (strlen($password) < 6) {
                throw new \RuntimeException('The password must be at least 6 characters long');
            }

            return $password;
        });

        $this->userRepository->createNewUser($email, $password);

        $io->success('You have created a new user with email: ' . $email . ' and password: ' . $password);

        return Command::SUCCESS;
    }
}
