<?php

namespace SyntaxError\SocketBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use SyntaxError\SocketBundle\Server\Config;

class StatusCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('ws:status')
            ->addOption('logfile', 'l', InputOption::VALUE_NONE, 'Display absolute log file path.')
            ->setDescription('Status of the webSocket server.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $config = Config::create();
        if( $input->hasOption('logfile') && $input->getOption('logfile') ) {
            $output->writeln( preg_match('/\.\./', $config['log']) ? __DIR__.$config['log'] : $config['log'] );
        } else {
            $output->writeln("<fg=blue>** Status **</>");

            $output->writeln("<info>Bind on address: </info><comment>".$config['bind']."</comment>");
            $output->writeln("<info>Listen on port: </info><comment>".$config['port']."</comment>");
            $output->writeln("<info>Logged to file: </info><comment>".$config['log']."</comment>");
            $output->writeln("<info>Task class is: </info><comment>".$config['task']."</comment>");

            $clientsCount = 0;
            if( is_readable(Config::hostsPath) ){
                $decoded = json_decode(file_get_contents(Config::hostsPath));
                $decoded = !is_array($decoded) ? get_object_vars($decoded) : $decoded;
                $clientsCount = count($decoded);
            }


            $pid = Config::getPid();
            $started = is_numeric($pid);
            $starStop = $started ? "<fg=blue>STARTED ($pid)</>" : "<fg=red>STOPPED</>";
            if($started) {
                $output->writeln("<info>Connected clients: </info><comment>$clientsCount</comment>");
            }
            $output->writeln("<info>Server: </info>$starStop");
        }
    }
}
