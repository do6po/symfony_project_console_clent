<?php

namespace AppBundle\Command;

use AppBundle\Entity\Group;
use AppBundle\Exceptions\ValidationErrorException;
use Helpers\ValidationErrorConverter;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GroupAddCommand extends BasicAbstractCommand
{
    protected function configure()
    {
        $this
            ->setName('group:add')
            ->setDescription('Add new group')
            ->addArgument('name', InputArgument::REQUIRED, 'Group name')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $group = new Group();
        $group->name = $input->getArgument('name');

        try {
            $createdUser = $this->userServices->addGroup($group);

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
