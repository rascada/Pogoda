<?php

namespace SyntaxError\SocketBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use SyntaxError\SocketBundle\Server\Config;

class ClientsCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('ws:clients')
            ->setDescription('List connected hosts to webSocket server.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $pid = Config::getPid();
        if( is_numeric($pid) ) {

            $now = new \DateTime('now');
            $clients = json_decode( file_get_contents(Config::hostsPath) );
            $nobody = true;
            foreach(get_object_vars($clients) as $i => $client) {
                $nobody = false;
                $logged = new \DateTime($client->connected);
                $diff = $logged->diff($now);
                $host = "<fg=blue>".$client->ip."</>";
                $time = "<fg=blue>".$diff->format("%H hrs %I min. %S sec. ago")."</>";
                $output->writeln("<info>Host: </info>$host<info> connected</info> $time");
            }
            if($nobody) {
                $output->writeln("<info>Nobody connected.</info>");
            }

        } else {
            $output->writeln("<error>Server not started.</error>");
        }
    }
}
