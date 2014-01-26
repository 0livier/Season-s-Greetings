<?php

namespace Greetings\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

use Twig_Loader_String;
use Twig_Environment;

use Greetings\Parser\Csv;
use Greetings\Transport\Gmail;

class GreetingsCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('greetings')
            ->setDescription('Transmit season\'s greeting !')
            ->addArgument('template', InputArgument::REQUIRED, 'Twig mail template')
            ->addArgument('recipients', InputArgument::REQUIRED, 'Recipients CSV file')
            ->addOption('username', 'u', InputOption::VALUE_REQUIRED, 'Gmail user account (an email)')
            ->addOption('password', 'p', InputOption::VALUE_REQUIRED, 'Gmail user password')
            ->addOption('subject', 's', InputOption::VALUE_OPTIONAL, 'Subject', 'Happy new year !');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $twig = new Twig_Environment(new Twig_Loader_String());
        $mailer = new Gmail($input->getOption('username'), $input->getOption('password'));

        foreach (Csv::parse($input->getArgument('recipients')) as $recipient) {
            $template = $twig->render(file_get_contents($input->getArgument('template')), $recipient);

            $mailer->send(
                $input->getOption('username'),
                array($recipient['email'] => $recipient['fullname']),
                $input->getOption('subject'),
                $template
            );

            $output->writeln("Sent email to $recipient[email]");
        }
    }
}