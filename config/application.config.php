<?php
namespace Module\Application;

return [
    'settings' => require __DIR__ . "/settings.config.php",
    
    'services' => require __DIR__ . "/services.config.php",

    'commands' => [
        Command\ConvertCommand::class,
        Command\PreviewCommand::class,
    ],
];