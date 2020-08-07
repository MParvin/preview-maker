<?php
namespace Module\Application\Command;

use Core\Command;
use Module\Application\Service\PreviewService;
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
            ->setHelp('This command is to create an image or pdf preview from an input file.')
            ->addArgument('inputFile', InputArgument::REQUIRED, 'Path to the file you want to make preview from')
            ->addOption('pdf', null, InputOption::VALUE_NONE, 'Convert given document to pdf')
            ->addOption('output', 'o', InputOption::VALUE_REQUIRED, 'Path to output file');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $inputFile = $input->getArgument('inputFile');
        $service   = $this->getPreviewService()->setFile($inputFile);

        if ($input->getOption('pdf')) {
            $file = $service->toPdf($input->getOption('output'));    
        } else {
            $file = $service->preview($input->getOption('output'));
        }

        $this->writeSummary($output, $file);
    }

    private function getPreviewService(): PreviewService
    {
        return $this->getApplication()->getService(PreviewService::class);
    }
}
