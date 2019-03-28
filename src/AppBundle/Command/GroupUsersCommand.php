<?php

namespace AppBundle\Command;

use AppBundle\Entity\Group;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GroupUsersCommand extends BasicAbstractCommand
{
    protected function configure()
    {
        $this
            ->setName('group:users')
            ->setDescription('Show user list in group')
            ->addArgument('group_id', InputArgument::REQUIRED, 'Group id');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $group = new Group();
        $group->id = $input->getArgument('group_id');

        try {
            $users = $this->userServices->fetchUsersFromGroup($group);
            $table = new Table($output);

            $table
                ->setHeaders(['ID', 'Name', 'Email'])
                ->setRows($users)
                ->render();

            $output->writeln(sprintf('Showed rows %s', count($users)));
        } catch (\Exception $exception) {
            $output->writeln(sprintf('Fetch users error: %s.', $exception->getMessage()));
        }
    }

}
