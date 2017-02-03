<?php

namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SendSubscribeMailCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('app:subscribe:send_mail')
            ->setDescription('Sends out the subscribe mails');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->getContainer()->get('app_bundle.subscribe')->dispatchMassEmails();
    }
}
