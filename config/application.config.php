<?php
namespace Module\Application;

return [
    // App info
    'AppName' => 'PreviewMaker',
    'Version' => '1.1.0',

    // App settings
    'settings' => require __DIR__ . "/settings.config.php",
    
    // Services
    'services' => require __DIR__ . "/services.config.php",

    // Commands
    'commands' => [
        Command\PreviewCommand::class,
    ],
];