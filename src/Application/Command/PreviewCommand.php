<?php
namespace Module\Application\Command;

use Module\Application\Service\ffmpegService;
use Module\Application\Service\PreviewService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class PreviewCommand extends Command
{
    protected function configure()
    {
        $this->setName('preview')
            ->setDescription('This creates a preview image from an input file.')
            ->setHelp('Demonstration of custom commands created by Symfony Console component.')
            ->addArgument('filepath', InputArgument::REQUIRED, 'Path to the file you want to make preview from')
            ->addOption('output', 'o', InputOption::VALUE_REQUIRED, 'Path to output file');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $filePath = $input->getArgument('filepath');
        $service  = $this->getPreviewService()->setFile($filePath);

        $startTime = microtime(true);
        $file      = $service->preview($input->getOption('output'));
        $endTime   = microtime(true);

        $output->writeln('');
        $output->writeln(sprintf('<info>File name:</info> %s', $file->getName()));
        $output->writeln(sprintf('<info>Directory:</info> %s', $file->getDir()));
        $output->writeln(sprintf('<info>Preview:</info>   %s', $file->getPath()));
        $output->writeln('');
        $output->writeln(sprintf('<fg=yellow;options=bold>Execution time: %s sec</>', number_format($endTime - $startTime, 5)));
        $output->writeln('');
    }

    private function getPreviewService(): PreviewService
    {
        return $this->getApplication()->getService(PreviewService::class);
    }
}
