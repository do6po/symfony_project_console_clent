<?php

namespace AppBundle\Command;

use AppBundle\Entity\Group;
use AppBundle\Entity\User;
use AppBundle\Exceptions\NotFoundEntityException;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GroupRemUserCommand extends BasicAbstractCommand
{
    protected function configure()
    {
        $this
            ->setName('group:rem-user')
            ->setDescription('Remove user from group.')
            ->addArgument('group_id', InputArgument::REQUIRED, 'Group id')
            ->addArgument('user_id', InputArgument::REQUIRED, 'User id');
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $group = new Group();
        $group->id = $input->getArgument('group_id');

        $user = new User();
        $user->id = $input->getArgument('user_id');

        try {
            $this->userServices->delUserFromGroup($group, $user);

            $output->writeln(sprintf('User %s deleted from group %s;', $user->id, $group->id));
        } catch (NotFoundEntityException $exception) {
            $output->writeln($exception->getMessage());
        } catch (\Exception $exception) {
            $output->writeln(sprintf('Deleting user from group error: %s.', $exception->getMessage()));
        }
    }

}
