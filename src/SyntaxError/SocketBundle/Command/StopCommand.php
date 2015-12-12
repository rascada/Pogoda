<?php

namespace SyntaxError\SocketBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use SyntaxError\SocketBundle\Server\Config;

class StopCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('ws:stop')
            ->setDescription('Stop the webSocket server.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $pid = Config::getPid();
        if( is_numeric($pid) ) {
            `kill $pid`;
            $output->writeln("<info>Server stopped</info>");
            file_put_contents(Config::pidPath, 'stopped');
        } else {
            $output->writeln("<error>Server not started.</error>");
        }
    }
}
