<?php

namespace AppBundle\Command;

use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class UserListCommand extends BasicAbstractCommand
{
    protected function configure()
    {
        $this
            ->setName('user:list')
            ->setDescription('Get the users list');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|null|void
     * @throws \AppBundle\Exceptions\ResponseErrorException
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $users = $this->userServices->all();

        $table = new Table($output);

        $table
            ->setHeaders(['ID', 'Name', 'Email'])
            ->setRows($users)
            ->render();

        $output->writeln(sprintf('Showed rows %s', count($users)));
    }
}
