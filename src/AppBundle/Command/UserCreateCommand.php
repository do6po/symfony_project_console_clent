<?php

namespace AppBundle\Command;

use AppBundle\Entity\User;
use AppBundle\Exceptions\ValidationErrorException;
use Helpers\ValidationErrorConverter;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class UserCreateCommand extends BasicAbstractCommand
{
    protected function configure()
    {
        $this
            ->setName('user:create')
            ->setDescription('Add user')
            ->addArgument('name', InputArgument::REQUIRED, 'User name')
            ->addArgument('email', InputArgument::REQUIRED, 'Email name');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|null|void
     * @throws \AppBundle\Exceptions\ResponseErrorException
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $user = new User();
        $user->name = $input->getArgument('name');
        $user->email = $input->getArgument('email');

        try {
            $createdUser = $this->userServices->add($user);

            $table = new Table($output);

            $table
                ->setHeaders(array_keys($createdUser))
                ->setRows([$createdUser])
                ->render();

            $output->writeln('Create successfully');
        } catch (ValidationErrorException $exception) {
            $errors = $exception->getErrors();

            $output->writeln('Validation error:');

            $errorsView = new Table($output);

            $convertedErrors = (new ValidationErrorConverter())->convert($errors);

            $errorsView
                ->setHeaders(array_keys($errors))
                ->setRows($convertedErrors)
                ->render();
        }
    }

}
