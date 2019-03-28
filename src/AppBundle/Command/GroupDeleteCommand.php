<?php

namespace AppBundle\Command;

use AppBundle\Entity\Group;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GroupDeleteCommand extends BasicAbstractCommand
{
    protected function configure()
    {
        $this
            ->setName('group:delete')
            ->setDescription('Delete group')
            ->addArgument('group_id', InputArgument::REQUIRED, 'Group id')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $group = new Group();
        $group->id = $input->getArgument('group_id');

        try {
            $this->userServices->deleteGroup($group);

            $output->writeln('Delete successfully.');
        } catch (\Exception $exception) {
            $output->writeln(sprintf('Deleting error: %s.', $exception->getMessage()));
        }
    }

}
