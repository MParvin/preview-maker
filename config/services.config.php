<?php
namespace Module\Application;

use function DI\create;
use Module\Application\Factory\ffmpegServiceFactory;
use Module\Application\Service\ffmpegService;

return [
    ffmpegService::class => create(ffmpegServiceFactory::class),
];