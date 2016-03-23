<?php

namespace TuanQuynh\UserBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use TuanQuynh\UserBundle\Entity\User;

class UserCommand extends ContainerAwareCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('tuanquynh:user:create')
            ->setDescription('Create User For TuanQuynh User Bundle')
            ->addArgument(
                'username',
                InputArgument::REQUIRED,
                "User's Username"
            )
            ->addArgument(
                'password',
                InputArgument::REQUIRED,
                "User's Password"
            )
            ->addArgument(
                'email',
                InputArgument::REQUIRED,
                "User's Email"
            );
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $username = $input->getArgument('username');
        $password = $input->getArgument('password');
        $email = $input->getArgument('email');

        $container = $this->getContainer();
        $userRepository = $container->get('tuan_quynh_user.repository.user');
        $passwordEncoder = $container->get('security.password_encoder');

        $user = new User();
        $password = $passwordEncoder->encodePassword($user, $password);
        $user->setUsername($username);
        $user->setPassword($password);
        $user->setEmail($email);

        $userRepository->persistAndFlush($user);

        $output->writeln('Create User Successful.');
    }
}
