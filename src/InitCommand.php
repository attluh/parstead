<?php

namespace Attluh\Parstead;

use InvalidArgumentException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class InitCommand extends Command
{
    /**
     * Configure the command options.
     *
     * @return void
     */
    protected function configure()
    {
        $this->setName('init')->setDescription('Create a stub Homestead.yaml file');
    }

    /**
     * Execute the command.
     *
     * @param  \Symfony\Component\Console\Input\InputInterface  $input
     * @param  \Symfony\Component\Console\Output\OutputInterface  $output
     * @return void
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        if (is_dir(homestead_path())) {
            throw new InvalidArgumentException('Homestead has already been initialized.');
        }

        $output->writeln('<comment>Parstead config path:</comment> <info>'. homestead_path() . '</info>');

        mkdir(homestead_path());

        copy(__DIR__.'/stubs/Homestead.yaml', homestead_path().'/Homestead.yaml');
        copy(__DIR__.'/stubs/after.sh', homestead_path().'/after.sh');
        copy(__DIR__.'/stubs/aliases', homestead_path().'/aliases');
        
        if (is_dir(homestead_path())) {
            $output->writeln('<comment>Creating Homestead.yaml file...</comment> <info>✔</info>');
            $output->writeln('<comment>Homestead.yaml file created at:</comment> '.homestead_path().'/Homestead.yaml');
        } else {
            $output->writeln('<error>X</error> <comment>Could not initialize Parstead</comment>');
        }

    }
}
