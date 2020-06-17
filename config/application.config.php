<?php
namespace Module\Application;

return [
    'services' => require __DIR__ . "/services.config.php",

    'commands' => [
        Command\ConvertCommand::class
    ],
];