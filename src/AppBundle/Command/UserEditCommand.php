<?php

namespace AppBundle\Command;

use AppBundle\Entity\User;
use AppBundle\Exceptions\ValidationErrorException;
use Helpers\ValidationErrorConverter;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class UserEditCommand extends BasicAbstractCommand
{
    protected function configure()
    {
        $this
            ->setName('user:edit')
            ->setDescription('Editing user')
            ->addArgument('user_id', InputArgument::REQUIRED, 'User id')
            ->addArgument('name', InputArgument::REQUIRED, 'User name')
            ->addArgument('email', InputArgument::REQUIRED, 'User email');
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

        $user->id = $input->getArgument('user_id');
        $user->name = $input->getArgument('name');
        $user->email = $input->getArgument('email');

        try {
            $editedUser = $this->userServices->edit($user);

            $table = new Table($output);

            $table
                ->setHeaders(array_keys($editedUser))
                ->setRows([$editedUser])
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

        } catch (\Exception $exception) {
            $output->writeln(sprintf('Editing error: %s', $exception->getMessage()));
        }
    }
}
