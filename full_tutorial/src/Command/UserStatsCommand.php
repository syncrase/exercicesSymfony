<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class UserStatsCommand extends Command
{
    protected static $defaultName = 'user:stats';

    public function __construct($name = null)
    {
        parent::__construct($name);
    }

    protected function configure()
    {
        $this
            ->setDescription('Returns some user stats :-)')
            ->addArgument('slug', InputArgument::OPTIONAL, 'The article\'s slug')
            ->addOption('format', null, InputOption::VALUE_REQUIRED, 'text')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $slug = $input->getArgument('slug');

//        $io->success('You have a new command! Now make it your own! Pass --help to see your options.');
        $data = [
            'slug' => $slug,
            'hearts' => rand(10, 100),
        ];
        switch ($input->getOption('format')) {
            case 'text':
                $rows = [];
                foreach ($data as $key => $val) {
                    $rows[] = [$key, $val];
                }
                $io->table(['Key', 'Value'], $rows);
//                $io->listing($data);
                break;
            case 'json':
                $io->write(json_encode($data));
                break;
            default:
                throw new \Exception('What kind of crazy format is that!?');
        }
    }
}
