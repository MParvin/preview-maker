#!/usr/bin/env php
<?php
require_once __DIR__ . '/../vendor/autoload.php';

use Core\ConsoleApplication as Application;
use DI\ContainerBuilder;
use function DI\create;
use Module\Application\Command\ConvertCommand;

// Get application config
$config = require __DIR__ . '/../config/application.config.php';
$config = isset($config) && is_array($config) ? $config : [];

// Create Application
$app = new Application();

// Run the application
$app->init($config)->run();