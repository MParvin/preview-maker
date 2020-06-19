<?php
namespace Module\Application\Command;

use Module\Application\Service\ffmpegService;
use Module\Application\Service\PreviewService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
 
class PreviewCommand extends Command
{
    protected function configure()
    {
        $this->setName('preview')
            ->setDescription('This creates a preview image from an input file.')
            ->setHelp('Demonstration of custom commands created by Symfony Console component.')
            ->addArgument('filepath', InputArgument::REQUIRED, 'Path to the file you want to make preview from');
    }
 
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $filePath = $input->getArgument('filepath');
        $service  = new PreviewService($filePath);
        $file     = $service->preview();
        
        $output->writeln('');
        $output->writeln(sprintf('File name: %s', $file->getName()));
        $output->writeln(sprintf('Directory: %s', $file->getDir()));
        $output->writeln(sprintf('Preview: %s', $file->getPreview()));
    }
}