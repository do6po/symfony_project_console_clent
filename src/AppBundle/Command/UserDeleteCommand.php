<?php

namespace AppBundle\Command;

use AppBundle\Entity\User;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class UserDeleteCommand extends BasicAbstractCommand
{
    protected function configure()
    {
        $this
            ->setName('user:delete')
            ->setDescription('Deleting user')
            ->addArgument('user_id', InputArgument::REQUIRED, 'User ID');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $user = new User();
        $user->id = $input->getArgument('user_id');
        try {
            $this->userServices->delete($user);

            $output->writeln('Delete successfully.');
        } catch (\Exception $exception) {
            $output->writeln(sprintf('Deleting error: %s.', $exception->getMessage()));
        }
    }
}
