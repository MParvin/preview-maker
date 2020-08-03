<?php
namespace Module\Application;

use function DI\create;
use Module\Application\Factory\PreviewServiceFactory;
use Module\Application\Service\PreviewService;

return [
    PreviewService::class => create(PreviewServiceFactory::class),
];