<?php

namespace App\Command\User;

use App\DTO\CreateUserDTO;
use App\Service\AuthService;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[AsCommand(
    name: 'user:create',
    description: 'Creates a user',
)]
class CreateUserCommand extends Command
{
    private const EMAIL = 'email';
    private const DISPLAY_NAME = 'display-name';
    private const PASSWORD = 'password';

    public function __construct(
        private ValidatorInterface $validator,
        private AuthService $authService,
    )
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument(self::EMAIL, InputArgument::REQUIRED, 'User email')
            ->addOption(self::DISPLAY_NAME, null, InputOption::VALUE_OPTIONAL, 'User display name')
            ->addOption(self::PASSWORD, null, InputOption::VALUE_OPTIONAL, 'User password')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $email = $input->getArgument(self::EMAIL);
        $displayName = $input->getOption(self::DISPLAY_NAME);
        $password = $input->getOption(self::PASSWORD);

        while ($displayName === null) {
            $displayName = $io->ask('What is your display name?');
        }

        while ($password === null) {
            $password = $io->askHidden('What is your password?');
        }

        $userDto = new CreateUserDTO($email, $displayName, $password);

        $errors = $this->validator->validate($userDto);
        if ($errors->count() > 0) {
            for ($i = 0; $i < $errors->count(); $i++) {
                $io->error(sprintf(
                    "[%s]: %s",
                    $errors->get($i)->getPropertyPath(),
                    $errors->get($i)->getMessage(),
                ));
            }
            return Command::INVALID;
        }

        try {
            $user = $this->authService->registerUser($userDto);
            $io->success(
                sprintf("Successfully created user %s", $user->getEmail()),
            );
            return Command::SUCCESS;
        } catch(\Exception $e) {
            $io->error(
                sprintf("Failed to create user %s", $email),
            );
            $io->error($e->getMessage());

            return Command::FAILURE;
        }
    }
}