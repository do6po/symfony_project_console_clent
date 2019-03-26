<?php

namespace AppBundle\Command;

use AppBundle\Services\UserService;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class UsersListCommand extends ContainerAwareCommand
{
    /**
     * @var UserService
     */
    protected $userServices;

    public function __construct(UserService $userServices, ?string $name = null)
    {
        parent::__construct($name);

        $this->userServices = $userServices;
    }

    protected function configure()
    {
        $this
            ->setName('users:list')
            ->setDescription('Get the users list')
            ->addArgument('argument', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option', null, InputOption::VALUE_NONE, 'Option description')
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
        $users = $this->userServices->all();

        $table = new Table($output);

        $table->setHeaders(['ID', 'Name', 'Email'])
            ->setRows($users);
        $table->render();

        $output->writeln(sprintf('Showed rows %s', count($users)));
    }

}
