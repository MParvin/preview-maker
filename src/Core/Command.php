<?php

namespace Core;

use Module\Application\FileSystem\FileInterface;
use Symfony\Component\Console\Command\Command as ConsoleCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Command extends ConsoleCommand
{
    /**
     * @var string|float
     */
    protected $startTime;
    
    /**
     * @var string|float
     */
    protected $endTime;

    /**
     * @inheritDoc
     */
    public function __construct($name = null)
    {
        parent::__construct($name = null);
    }

    /**
     * @inheritDoc
     */
    public function run(InputInterface $input, OutputInterface $output)
    {
        $this->startTime = microtime(true);
        $result          = parent::run($input, $output);

        return $result;
    }
    
    /**
     * Calculate commmand execution time in seconds
     *
     * @return float
     */
    protected function getExecutionTime()
    {
        $this->endTime = microtime(true);
        return number_format($this->endTime - $this->startTime, 5);
    }
    
    /**
     * Write a file summary to the output
     *
     * @param  mixed $output
     * @param  mixed $file
     * @return void
     */
    public function writeSummary(OutputInterface $output, FileInterface $file)
    {
        $output->writeln('');
        $output->writeln(sprintf('<info>File name:</info> %s', $file->getName()));
        $output->writeln(sprintf('<info>Directory:</info> %s', $file->getDir()));
        $output->writeln(sprintf('<info>Preview:</info>   %s', $file->getPath()));
        $output->writeln('');
        $output->writeln(sprintf('<fg=yellow;options=bold>Execution time: %s sec</>', $this->getExecutionTime()));
        $output->writeln('');
    }
}
