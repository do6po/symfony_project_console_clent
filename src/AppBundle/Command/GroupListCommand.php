<?php

namespace AppBundle\Command;

use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GroupListCommand extends BasicAbstractCommand
{
    protected function configure()
    {
        $this
            ->setName('group:list')
            ->setDescription('Get group list')
        ;
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|null|void
     * @throws \AppBundle\Exceptions\ResponseErrorException
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $groups = $this->userServices->groupAll();

        $table = new Table($output);

        $table
            ->setHeaders(['ID', 'Name'])
            ->setRows($groups)
            ->render();

        $output->writeln(sprintf('Showed rows %s', count($groups)));
    }
}
