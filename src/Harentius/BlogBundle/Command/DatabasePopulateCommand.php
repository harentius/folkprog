<?php

namespace Harentius\BlogBundle\Command;

use Harentius\BlogBundle\Entity\AdminUser;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class DatabasePopulateCommand extends ContainerAwareCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setName('blog:database:populate')
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $em = $this->getContainer()->get('doctrine.orm.entity_manager');
        $encoder = $this->getContainer()->get('security.password_encoder');

        $adminUser = new AdminUser();
        $adminUser
            ->setUsername('admin')
            ->setPassword($encoder->encodePassword($adminUser, 'admin'))
        ;

        $em->persist($adminUser);
        $em->flush($adminUser);
    }
}