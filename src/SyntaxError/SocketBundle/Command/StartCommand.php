<?php

namespace SyntaxError\SocketBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use SyntaxError\SocketBundle\Server\Config;

class StartCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('ws:start')
            ->setDescription('Start the webSocket server.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if(is_numeric( Config::getPid() )) {
            $output->writeln("<error>Server has already started.</error>");
        } else {
            $pathToApp = __DIR__."/../app.php";
            `php $pathToApp > /dev/null 2>/dev/null &`;
            $timeout = 0;
            while(!is_numeric( Config::getPid() ) && $timeout++ < Config::timeout) {
                sleep(1);
            }
            if($timeout >= Config::timeout) {
                $output->writeln("<error>Error when starting. Check php error log.</error>");
            } else {
                $output->writeln("<info>Server started</info>");
            }
        }
    }
}
