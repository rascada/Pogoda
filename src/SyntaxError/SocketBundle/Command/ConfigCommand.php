<?php

namespace SyntaxError\SocketBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use SyntaxError\SocketBundle\Server\Config;

class ConfigCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('ws:config')
            ->setDescription('Configure the webSocket server.');

        foreach(Config::required as $configKey) {
            $this->addOption(
                $configKey, null, InputOption::VALUE_REQUIRED, preg_replace( '/[^a-zA-Z]+/', ' ', ucfirst($configKey) )
            );
        }
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $optionsChanged = 0;
        $config = Config::create(true);
        foreach($config as $configKey => $configVal) {
            if( $input->getOption($configKey) !== null) {
                $config[$configKey] = $input->getOption($configKey);
                $output->writeln(
                    preg_replace( '/[^a-zA-Z]+/', ' ', ucfirst($configKey))." set to: ".$config[$configKey]
                );
                $optionsChanged++;
            }
        }
        if( !$optionsChanged ) {
            $output->writeln("<error>Required option to set. Check help for this command.</error>");
            return;
        }

        try {
            Config::save($config);
        } catch(\Exception $e) {
            $output->writeln("<error>Error when creating config file.</error>");
        }

        $output->writeln("<fg=green>Created new config file.</>");
    }
}
